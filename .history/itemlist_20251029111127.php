while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
    if (count($data) < 5) continue; // skip incomplete rows
    $rowCount++;

    $categoryId      = trim($data[0]); // ID directly from CSV
    $itemName        = trim($data[1]);
    $itemDescription = trim($data[2]);
    $prefVendor      = trim($data[3]);
    $unitId          = trim($data[4]); // ID directly from CSV

    if ($itemName == '') continue; // skip empty item names

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

    // ---------- CHECK CATEGORY & UNIT ----------
    if (!$categoryId) {
        echo "<tr><td>$itemName</td><td>$categoryId</td><td>$prefVendor</td><td>$unitId</td><td style='color:red;'>❌ Category ID missing</td></tr>";
        continue;
    }

    if (!$unitId) {
        echo "<tr><td>$itemName</td><td>$categoryId</td><td>$prefVendor</td><td>$unitId</td><td style='color:red;'>❌ Unit ID missing</td></tr>";
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

        echo "<tr><td>$itemName</td><td>$categoryId</td><td>$prefVendor</td><td>$unitId</td><td style='color:blue;'>✅ Inserted (Supplier ID: $supplierId)</td></tr>";
    } else {
        echo "<tr><td>$itemName</td><td>$categoryId</td><td>$prefVendor</td><td>$unitId</td><td style='color:red;'>❌ Insert Failed</td></tr>";
    }

    $insertMaterial->close();
}
