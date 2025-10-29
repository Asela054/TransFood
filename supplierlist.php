<?php
// --- Database connection ---
$servername = "localhost";
$username = "root"; // change if needed
$password = ""; // change if needed
$dbname = "erav_transfood"; // change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- CSV file path ---
$csvFile = 'productlist.csv'; // <-- change to your CSV filename

if (!file_exists($csvFile)) {
    die("CSV file not found.");
}

// --- Open CSV file ---
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    // detect delimiter automatically
    $header = fgetcsv($handle, 1000, "\t");
    if (count($header) < 2) {
        rewind($handle);
        $header = fgetcsv($handle, 1000, ",");
        $delimiter = ",";
    } else {
        $delimiter = "\t";
    }

    echo "<h3>Supplier Import Results</h3>";
    echo "<table border='1' cellpadding='5'>
            <tr><th>Supplier Name</th><th>Status</th></tr>";

    while (($data = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
        if (!isset($data[3])) continue; // skip invalid rows
        $prefVendor = trim($data[3]);

        if ($prefVendor != "") {
            // --- Check if supplier already exists ---
            $checkStmt = $conn->prepare("SELECT suppliername FROM tbl_supplier WHERE suppliername = ?");
            $checkStmt->bind_param("s", $prefVendor);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                echo "<tr><td>{$prefVendor}</td><td style='color:green;'>Already Exists</td></tr>";
            } else {
                // --- Insert new supplier ---
                $insertStmt = $conn->prepare("
                    INSERT INTO tbl_supplier 
                    (suppliername, status, insertdatetime, remark, tbl_user_idtbl_user, tbl_country_idtbl_country)
                    VALUES (?, '1', NOW(), 'Sri Lanka', 1, 210)
                ");
                $insertStmt->bind_param("s", $prefVendor);

                if ($insertStmt->execute()) {
                    echo "<tr><td>{$prefVendor}</td><td style='color:blue;'>Inserted</td></tr>";
                } else {
                    echo "<tr><td>{$prefVendor}</td><td style='color:red;'>Insert Failed: {$conn->error}</td></tr>";
                }

                $insertStmt->close();
            }

            $checkStmt->close();
        }
    }

    echo "</table>";
    fclose($handle);
}

$conn->close();
?>
