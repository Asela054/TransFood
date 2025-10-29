<?php
require_once('connection/db.php');
session_start();

$userID = $_SESSION['userid']; // Current logged user ID

if(isset($_FILES['csvfile']) && $_FILES['csvfile']['error'] == 0){
    $filename = $_FILES['csvfile']['tmp_name'];
    $file = fopen($filename, "r");

    // Skip the header row
    fgetcsv($file);

    while(($row = fgetcsv($file)) !== FALSE){
        // CSV columns
        $materialCategory = trim($row[0]); // Material Category
        $itemName         = trim($row[1]); // Item
        $itemDescription  = trim($row[2]); // Item Description
        $prefVendor       = trim($row[3]); // Pref Vendor
        $unitName         = trim($row[4]); // Unit

        if(empty($itemName)) continue; // Skip empty rows

        // Default Supplier ID
        $supplierId = 1732;

        // --- 1️⃣ Check supplier ---
        if(!empty($prefVendor)){
            $sqlSupp = $conn->prepare("SELECT idtbl_supplier FROM tbl_supplier WHERE suppliername = ?");
            $sqlSupp->bind_param("s", $prefVendor);
            $sqlSupp->execute();
            $sqlSupp->bind_result($sid);
            if($sqlSupp->fetch()){
                $supplierId = $sid;
            }
            $sqlSupp->close();
        }

        // --- 2️⃣ Get Category ID ---
        $categoryId = null;
        $sqlCat = $conn->prepare("SELECT idtbl_material_category FROM tbl_material_category WHERE categoryname = ?");
        $sqlCat->bind_param("s", $materialCategory);
        $sqlCat->execute();
        $sqlCat->bind_result($catId);
        if($sqlCat->fetch()){
            $categoryId = $catId;
        }
        $sqlCat->close();

        if(!$categoryId){
            echo "⚠️ Category not found for: $materialCategory<br>";
            continue;
        }

        // --- 3️⃣ Get Unit ID ---
        $unitId = null;
        $sqlUnit = $conn->prepare("SELECT idtbl_unit FROM tbl_unit WHERE unitname = ?");
        $sqlUnit->bind_param("s", $unitName);
        $sqlUnit->execute();
        $sqlUnit->bind_result($uid);
        if($sqlUnit->fetch()){
            $unitId = $uid;
        }
        $sqlUnit->close();

        if(!$unitId){
            echo "⚠️ Unit not found for: $unitName<br>";
            continue;
        }

        // --- 4️⃣ Insert into tbl_material_info ---
        $insertMaterial = $conn->prepare("
            INSERT INTO tbl_material_info 
            (materialname, materialinfocode, unitperctn, reorderlevel, comment, status, insertdatetime, tbl_user_idtbl_user, tbl_material_category_idtbl_material_category, tbl_unit_idtbl_unit)
            VALUES (?, '', 0, 0, ?, 1, NOW(), ?, ?, ?)
        ");
        $insertMaterial->bind_param("ssiii", $itemName, $itemDescription, $userID, $categoryId, $unitId);

        if($insertMaterial->execute()){
            $materialId = $insertMaterial->insert_id;

            // --- 5️⃣ Insert into tbl_material_suppliers ---
            $insertSupplier = $conn->prepare("
                INSERT INTO tbl_material_suppliers 
                (unitprice, status, updatedatetime, updateuser, tbl_material_info_idtbl_material_info, tbl_supplier_idtbl_supplier)
                VALUES (0, 1, NOW(), ?, ?, ?)
            ");
            $insertSupplier->bind_param("iii", $userID, $materialId, $supplierId);
            $insertSupplier->execute();
            $insertSupplier->close();

            echo "✅ Inserted: $itemName (Supplier ID: $supplierId)<br>";
        } else {
            echo "❌ Failed to insert: $itemName<br>";
        }

        $insertMaterial->close();
    }

    fclose($file);
} else {
    echo "⚠️ Please upload a valid CSV file.";
}
?>
