<?php
// ---------- DATABASE CONNECTION ----------
$servername = "localhost";
$username = "root";
$password = "asela123";
$dbname = "erav_transfood";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ---------- CONFIGURATION ----------
$csvFile = 'materialstock.csv';
$userId = 1;

if (!file_exists($csvFile)) {
    die("CSV file not found!");
}

// ---------- Detect CSV delimiter ----------
$firstLine = fgets(fopen($csvFile, 'r'));
$delimiter = (substr_count($firstLine, "\t") > substr_count($firstLine, ",")) ? "\t" : ",";
rewind(fopen($csvFile, 'r'));

// Array to store materials grouped by supplier with totals
$supplierMaterials = [];

// ---------- OPEN CSV ----------
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, $delimiter);
    
    // Process CSV data
    while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
        if (empty($data[0]) || $data[3] == 0) {
            continue;
        }
        
        $materialID = $data[0];
        
        // Get supplier for this material
        $sql = "SELECT `tbl_supplier_idtbl_supplier` 
                FROM `tbl_material_suppliers` 
                WHERE `tbl_material_info_idtbl_material_info` = '$materialID' 
                AND `status` = 1 
                ORDER BY `idtbl_material_suppliers` DESC 
                LIMIT 1";
        
        $result = $conn->query($sql);
        
        // Get total value from column 5
        $totalValue = 0;
        if (isset($data[5]) && !empty($data[5])) {
            // Clean the value (remove commas, quotes, etc.)
            $totalValueStr = str_replace(',', '', trim($data[5], '"\' '));
            $totalValue = is_numeric($totalValueStr) ? floatval($totalValueStr) : 0;
        }
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $supplierId = $row['tbl_supplier_idtbl_supplier'];
            
            // Prepare material data
            $materialData = [
                'material_id' => $materialID,
                'material_name' => isset($data[1]) ? $data[1] : '',
                'unit' => isset($data[2]) ? $data[2] : '',
                'quantity' => isset($data[3]) ? $data[3] : 0,
                'price_per_unit' => isset($data[4]) ? $data[4] : 0,
                'total_value' => $totalValue,
                'category' => isset($data[7]) ? $data[7] : '',
                'material_code' => isset($data[8]) ? $data[8] : ''
            ];
            
            // Group by supplier ID
            if (!isset($supplierMaterials[$supplierId])) {
                $supplierMaterials[$supplierId] = [
                    'supplier_id' => $supplierId,
                    'total_supplier_value' => 0,
                    'materials' => []
                ];
            }
            
            $supplierMaterials[$supplierId]['materials'][] = $materialData;
            $supplierMaterials[$supplierId]['total_supplier_value'] += $totalValue;
            
        } else {
            // Materials without supplier
            if (!isset($supplierMaterials[0])) {
                $supplierMaterials[0] = [
                    'supplier_id' => 0,
                    'supplier_name' => 'No Supplier',
                    'total_supplier_value' => 0,
                    'materials' => []
                ];
            }
            
            $materialData = [
                'material_id' => $materialID,
                'material_name' => isset($data[1]) ? $data[1] : '',
                'unit' => isset($data[2]) ? $data[2] : '',
                'quantity' => isset($data[3]) ? $data[3] : 0,
                'price_per_unit' => isset($data[4]) ? $data[4] : 0,
                'total_value' => $totalValue,
                'category' => isset($data[7]) ? $data[7] : '',
                'material_code' => isset($data[8]) ? $data[8] : ''
            ];
            
            $supplierMaterials[0]['materials'][] = $materialData;
            $supplierMaterials[0]['total_supplier_value'] += $totalValue;
        }
    }
    
    fclose($handle);
}

// Close database connection (will reopen for transactions)
$conn->close();

// ---------- TRANSACTION PROCESSING ----------
$today = date('Y-m-d');
$updatedatetime = date('Y-m-d H:i:s');
$userID = 1;
$companyID = 1;
$branchID = 1;

// Arrays to track processing results
$processingResults = [
    'success' => [],
    'failed' => [],
    'skipped' => []
];

// Reconnect for transaction processing
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

foreach($supplierMaterials as $supplierId => $rowsupplierMaterials) {
    
    // Skip supplier ID 0 (No Supplier)
    if ($supplierId == 0) {
        $processingResults['skipped'][] = [
            'supplier_id' => $supplierId,
            'reason' => 'No supplier assigned',
            'material_count' => count($rowsupplierMaterials['materials'])
        ];
        continue;
    }
    
    $supID = $rowsupplierMaterials['supplier_id'];
    $nettotalvalue = $rowsupplierMaterials['total_supplier_value'];
    $materialCount = count($rowsupplierMaterials['materials']);
    
    // Start transaction for this supplier
    $conn->begin_transaction();
    
    try {
        echo "<h3>Processing Supplier ID: $supID</h3>";
        echo "<p>Materials: $materialCount, Total Value: " . number_format($nettotalvalue, 2) . "</p>";
        
        // 1. Get next PO number
        $sqlmaxpo = "SELECT MAX(`po_no`) AS `count` FROM `tbl_porder` WHERE `tbl_supplier_idtbl_supplier` != 1 AND `po_no` > 0 AND `tbl_company_idtbl_company`='$companyID' AND `tbl_company_branch_idtbl_company_branch`='$branchID'";
        $resultmaxpo = $conn->query($sqlmaxpo);
        
        if (!$resultmaxpo) {
            throw new Exception("Failed to get PO number: " . $conn->error);
        }
        
        $rowmaxpo = $resultmaxpo->fetch_assoc();
        $ponumber = ($rowmaxpo['count'] == 0) ? 1 : $rowmaxpo['count'] + 1;
        
        // 2. Insert Purchase Order
        $insertpo = "INSERT INTO `tbl_porder`(`currencytype`, `po_no`, `class`, `orderdate`, `duedate`, `subtotal`, `discount`, `discountamount`, `nettotal`, `subtotalusd`, `discountusd`, `discountamountusd`, `nettotalusd`, `usd_rate`, `confirmstatus`, `grnconfirm`, `remark`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_location_idtbl_location`, `tbl_supplier_idtbl_supplier`, `tbl_order_type_idtbl_order_type`, `tbl_company_idtbl_company`, `tbl_company_branch_idtbl_company_branch`) 
                    VALUES ('1','$ponumber','$today','','$today','$nettotalvalue','0','0','$nettotalvalue','0','0','0','0','309.28','1','1','-','1','$updatedatetime','$userID','1','$supID','1','$companyID','$branchID')";
        
        if (!$conn->query($insertpo)) {
            throw new Exception("Failed to insert PO: " . $conn->error);
        }
        
        $porderID = $conn->insert_id;
        echo "<p>✓ PO Created: ID $porderID, Number $ponumber</p>";
        
        // 3. Get batch number info
        $sqlbatchno = "SELECT 
            tbl_supplier.suppliercode, 
            tbl_material_category.categorycode
        FROM tbl_supplier
        LEFT JOIN tbl_supplier_has_tbl_material_category 
            ON tbl_supplier_has_tbl_material_category.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier
        LEFT JOIN tbl_material_category 
            ON tbl_material_category.idtbl_material_category = tbl_supplier_has_tbl_material_category.tbl_material_category_idtbl_material_category
        WHERE tbl_supplier.idtbl_supplier = '$supID' 
        AND tbl_supplier.status = 1";
        
        $resultbatchno = $conn->query($sqlbatchno);
        
        if (!$resultbatchno) {
            throw new Exception("Failed to get batch info: " . $conn->error);
        }
        
        $rowbatchno = $resultbatchno->fetch_assoc();
        $materialcode = $rowbatchno['categorycode'] ?? '';
        $suppliercode = $rowbatchno['suppliercode'] ?? '';
        
        // 4. Get next GRN number
        $sqlmaxgrn = "SELECT MAX(`grn_no`) AS `count` FROM `tbl_grn` WHERE `grntype`= 1 AND `grn_no`> 0 AND `tbl_company_idtbl_company`='$companyID' AND `tbl_company_branch_idtbl_company_branch`='$branchID'";
        $resultmaxgrn = $conn->query($sqlmaxgrn);
        
        if (!$resultmaxgrn) {
            throw new Exception("Failed to get GRN number: " . $conn->error);
        }
        
        $rowmaxgrn = $resultmaxgrn->fetch_assoc();
        
        if ($rowmaxgrn['count'] == 0) {
            $grnno = 1;
            $count = '001';
        } else {
            $grnno = $rowmaxgrn['count'] + 1;
            $count = sprintf('%03d', $rowmaxgrn['count'] + 1);
        }
        
        $batchno = date('dmY') . $count;
        
        // 5. Insert GRN
        $insertgrn = "INSERT INTO `tbl_grn`(`grn_no`, `batchno`, `grntype`, `grndate`, `total`, `invoicenum`, `dispatchnum`, `approvestatus`, `qualitycheck`, `transportcost`, `unloadingcost`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_supplier_idtbl_supplier`, `tbl_location_idtbl_location`, `tbl_porder_idtbl_porder`, `tbl_order_type_idtbl_order_type`, `tbl_company_idtbl_company`, `tbl_company_branch_idtbl_company_branch`) 
                     VALUES ('$grnno','$batchno','1','$today','$nettotalvalue','','','1','1','0','0','1','$updatedatetime','$userID','$supID','1','$porderID','1','$companyID','$branchID')";
        
        if (!$conn->query($insertgrn)) {
            throw new Exception("Failed to insert GRN: " . $conn->error);
        }
        
        $grnID = $conn->insert_id;
        echo "<p>✓ GRN Created: ID $grnID, Number $grnno, Batch $batchno</p>";
        
        // 6. Process each material
        $processedMaterials = 0;
        foreach($rowsupplierMaterials['materials'] as $rowmateriallist) {
            $unitprice = floatval(str_replace(',', '', $rowmateriallist['price_per_unit']));
            $totalamount = floatval(str_replace(',', '', $rowmateriallist['total_value']));
            $qty = floatval(str_replace(',', '', $rowmateriallist['quantity']));
            $materialID = intval($rowmateriallist['material_id']);
            
            // Skip if no quantity
            if ($qty <= 0) {
                continue;
            }
            
            // Insert PO Detail
            $insertpodetail = "INSERT INTO `tbl_porder_detail`(`qty`, `unitprice`, `discount`, `discountamount`, `total`, `comment`, `status`, `insertdatetime`, `tbl_porder_idtbl_porder`, `tbl_material_info_idtbl_material_info`) 
                              VALUES ('$qty','$unitprice','0','0','$totalamount','-','1','$updatedatetime','$porderID','$materialID')";
            
            if (!$conn->query($insertpodetail)) {
                throw new Exception("Failed to insert PO detail for material $materialID: " . $conn->error);
            }
            
            // Insert GRN Detail
            $insertgrndetail = "INSERT INTO `tbl_grndetail`(`date`, `qty`, `unitprice`, `costunitprice`, `total`, `comment`, `actualqty`, `status`, `insertdatetime`, `tbl_grn_idtbl_grn`, `tbl_material_info_idtbl_material_info`) 
                               VALUES ('$today','$qty','$unitprice','$unitprice','$totalamount','-','$qty','1','$updatedatetime','$grnID','$materialID')";
            
            if (!$conn->query($insertgrndetail)) {
                throw new Exception("Failed to insert GRN detail for material $materialID: " . $conn->error);
            }
            
            // Insert Stock
            $insertstock = "INSERT INTO `tbl_stock`(`batchno`, `qty`, `unitprice`, `status`, `insertdatetime`, `tbl_user_idtbl_user`, `tbl_material_info_idtbl_material_info`, `tbl_location_idtbl_location`, `tbl_company_idtbl_company`, `tbl_company_branch_idtbl_company_branch`) 
                           VALUES ('$batchno','$qty','$unitprice','1','$updatedatetime','$userID','$materialID','1','$companyID','$branchID')";
            
            if (!$conn->query($insertstock)) {
                throw new Exception("Failed to insert stock for material $materialID: " . $conn->error);
            }
            
            $processedMaterials++;
        }
        
        echo "<p>✓ Materials processed: $processedMaterials</p>";
        
        // Commit transaction for this supplier
        $conn->commit();
        
        $processingResults['success'][] = [
            'supplier_id' => $supID,
            'po_id' => $porderID,
            'po_number' => $ponumber,
            'grn_id' => $grnID,
            'grn_number' => $grnno,
            'batch_no' => $batchno,
            'material_count' => $processedMaterials,
            'total_value' => $nettotalvalue
        ];
        
        echo "<p style='color: green;'><strong>✓ Successfully processed supplier $supID</strong></p><hr>";
        
    } catch (Exception $e) {
        // Rollback transaction for this supplier
        $conn->rollback();
        
        $processingResults['failed'][] = [
            'supplier_id' => $supID,
            'error' => $e->getMessage(),
            'material_count' => $materialCount,
            'total_value' => $nettotalvalue
        ];
        
        echo "<p style='color: red;'><strong>✗ Failed to process supplier $supID: " . $e->getMessage() . "</strong></p><hr>";
    }
}

$conn->close();

// ---------- PROCESSING SUMMARY ----------
echo "<h2>Processing Summary</h2>";

echo "<h3>Successful: " . count($processingResults['success']) . "</h3>";
if (!empty($processingResults['success'])) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Supplier ID</th>
            <th>PO Number</th>
            <th>GRN Number</th>
            <th>Batch No</th>
            <th>Materials</th>
            <th>Total Value</th>
          </tr>";
    
    foreach ($processingResults['success'] as $success) {
        echo "<tr>";
        echo "<td>" . $success['supplier_id'] . "</td>";
        echo "<td>" . $success['po_number'] . "</td>";
        echo "<td>" . $success['grn_number'] . "</td>";
        echo "<td>" . $success['batch_no'] . "</td>";
        echo "<td>" . $success['material_count'] . "</td>";
        echo "<td>" . number_format($success['total_value'], 2) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h3>Failed: " . count($processingResults['failed']) . "</h3>";
if (!empty($processingResults['failed'])) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Supplier ID</th>
            <th>Materials</th>
            <th>Total Value</th>
            <th>Error</th>
          </tr>";
    
    foreach ($processingResults['failed'] as $failed) {
        echo "<tr>";
        echo "<td>" . $failed['supplier_id'] . "</td>";
        echo "<td>" . $failed['material_count'] . "</td>";
        echo "<td>" . number_format($failed['total_value'], 2) . "</td>";
        echo "<td style='color: red;'>" . htmlspecialchars($failed['error']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h3>Skipped (No Supplier): " . count($processingResults['skipped']) . "</h3>";
if (!empty($processingResults['skipped'])) {
    foreach ($processingResults['skipped'] as $skipped) {
        echo "<p>Supplier ID " . $skipped['supplier_id'] . ": " . $skipped['material_count'] . " materials skipped - " . $skipped['reason'] . "</p>";
    }
}

// ---------- FINAL STATISTICS ----------
$totalSuccessValue = 0;
foreach ($processingResults['success'] as $success) {
    $totalSuccessValue += $success['total_value'];
}

$totalFailedValue = 0;
foreach ($processingResults['failed'] as $failed) {
    $totalFailedValue += $failed['total_value'];
}

$totalSkippedValue = 0;
foreach ($processingResults['skipped'] as $skipped) {
    if (isset($supplierMaterials[$skipped['supplier_id']])) {
        $totalSkippedValue += $supplierMaterials[$skipped['supplier_id']]['total_supplier_value'];
    }
}

echo "<h2>Final Statistics</h2>";
echo "<p>Total Suppliers Processed: " . count($supplierMaterials) . "</p>";
echo "<p>Successfully Processed: " . count($processingResults['success']) . " suppliers (" . number_format($totalSuccessValue, 2) . ")</p>";
echo "<p>Failed: " . count($processingResults['failed']) . " suppliers (" . number_format($totalFailedValue, 2) . ")</p>";
echo "<p>Skipped (No Supplier): " . count($processingResults['skipped']) . " suppliers (" . number_format($totalSkippedValue, 2) . ")</p>";

// Optional: Save results to log file
$logContent = "Processing completed at: " . date('Y-m-d H:i:s') . "\n";
$logContent .= "Successful: " . count($processingResults['success']) . "\n";
$logContent .= "Failed: " . count($processingResults['failed']) . "\n";
$logContent .= "Skipped: " . count($processingResults['skipped']) . "\n";

file_put_contents('processing_log_' . date('Ymd_His') . '.txt', $logContent);
?>