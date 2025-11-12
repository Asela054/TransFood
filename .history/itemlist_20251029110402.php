<?php
// ---------- DATABASE CONNECTION ----------
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "erav_transfood";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ---------- CONFIGURATION ----------
$csvFile = 'productlist.csv';  // your CSV file path
$defaultSupplierId = 1732;     // default supplier ID
$userId = 1;                   // static user id

if (!file_exists($csvFile)) {
    die("CSV file not found!");
}

// ---------- OPEN CSV ----------
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, "\t"); // tab-separated CSV
    // If comma-separated, use: fgetcsv($handle, 1000, ",");

    echo "<h3>Material Import Results</h3>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>
            <tr style='background:#eee;'>
                <th>Item</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Unit</th>
                <th>Status</th>
            </tr>";

    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
        $materialCategory = isset($data[0]) ? trim($data[0]) : '';
        $itemName         = isset($data[1]) ? trim($data[1]) : '';
        $itemDescription  = isset($data[2]) ? trim($data[2]) : '';
        $prefVendor       = isset($data[3]) ? trim($data[3]) : '';
        $unitName         = isset($data[4]) ? trim($data[4]) : '';

        if ($itemName == '') continue; // skip empty lines

        // ---------- SUPPLIER ----------
        $supplierId = $defaultSupplierId;
        if (!empty($prefVendor)) {
            $checkSupplier = $conn->prepare("SELECT idtbl_supplier FROM tbl_supplier WHERE suppliername = ?");
            $checkSupplier->bind_param("s", $prefVendor);
            $checkSupplier->execute();
            $result = $checkSupplier->get_result();
            if ($row = $result->fetch_assoc()) {
                $supplierId = $row['idtbl_supplier'];
            }
            $checkSupplier->close();
        }

        // ---------- CATEGORY ----------
        $categoryId = null;
        if (!empty($materialCategory)) {
            $checkCategory = $conn->prepare("SELECT idtbl_material_category FROM tbl_material_category WHERE categoryname = ?");
            $checkCategory->bind_param("s", $materialCategory);
            $checkCategory->execute();
            $result = $checkCategory->get_result();
            if ($row = $result->fetch_assoc()) {
                $categoryId = $row['idtbl_material_category'];
            }
            $checkCategory->close();
        }

        if (!$categoryId) {
            echo "<tr><td>$itemName</td><td>$materialCategory</td><td>$prefVendor</td><td>$unitName</td><td style='color:red;'>❌ Category not found</td></tr>";
            continue;
        }

        // ---------- UNIT ----------
        $unitId = null;
        if (!empty($unitName)) {
            $checkUnit = $conn->prepare("SELECT idtbl_unit FROM tbl_unit WHERE unitname = ?");
            $checkUnit->bind_param("s", $unitName);
            $checkUnit->execute();
            $result = $checkUnit->get_result();
            if ($row = $result->fetch_assoc()) {
                $unitId = $row['idtbl_unit'];
            }
            $checkUnit->close();
        }

        if (!$unitId) {
            echo "<tr><td>$itemName</td><td>$materialCategory</td><td>$prefVendor</td><td>$unitName</td><td style='color:red;'>❌ Unit not found</td></tr>";
            continue;
        }

        // ---------- INSERT MATERIAL ----------
        $insertMaterial = $conn->prepare("
            INSERT INTO tbl_material_info 
            (materialname, materialinfocode, unitperctn, reorderlevel, comment, status, insertdatetime, tbl_user_idtbl_user, tbl_material_category_idtbl_material_category, tbl_unit_idtbl_unit)
            VALUES (?, '', 0, 0, ?, 1, NOW(), ?, ?, ?)
        ");
        $insertMaterial->bind_param("ssiii", $itemName, $itemDescription, $userId, $categoryId, $unitId);

        if ($insertMaterial->execute()) {
            $materialId = $insertMaterial->insert_id;

            // ---------- LINK SUPPLIER ----------
            $insertSupplier = $conn->prepare("
                INSERT INTO tbl_material_suppliers 
                (unitprice, status, updatedatetime, updateuser, tbl_material_info_idtbl_material_info, tbl_supplier_idtbl_supplier)
                VALUES (0, 1, NOW(), ?, ?, ?)
            ");
            $insertSupplier->bind_param("iii", $userId, $materialId, $supplierId);
            $insertSupplier->execute();
            $insertSupplier->close();

            echo "<tr><td>$itemName</td><td>$materialCategory</td><td>$prefVendor</td><td>$unitName</td><td style='color:blue;'>✅ Inserted (Supplier ID: $supplierId)</td></tr>";
        } else {
            echo "<tr><td>$itemName</td><td>$materialCategory</td><td>$prefVendor</td><td>$unitName</td><td style='color:red;'>❌ Insert Failed</td></tr>";
        }

        $insertMaterial->close();
    }

    echo "</table>";
    fclose($handle);
} else {
    echo "Error opening CSV file!";
}

$conn->close();
?>
