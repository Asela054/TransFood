<?php
// --- Database connection ---
$servername = "localhost";
$username = "root"; // change if needed
$password = ""; // change if needed
$dbname = "your_database_name"; // change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- Get Sri Lanka country ID ---
$countrySql = "SELECT idtbl_country FROM tbl_country WHERE countryname = 'Sri Lanka'";
$countryResult = $conn->query($countrySql);
if ($countryResult->num_rows == 0) {
    die("Country 'Sri Lanka' not found in tbl_country table.");
}
$countryRow = $countryResult->fetch_assoc();
$sriLankaID = $countryRow['idtbl_country'];

// --- CSV file path ---
$csvFile = 'your_file.csv'; // <-- change to your CSV filename

if (!file_exists($csvFile)) {
    die("CSV file not found.");
}

// --- Open CSV file ---
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, "\t"); // assuming tab-separated
    // If comma-separated use: fgetcsv($handle, 1000, ",");

    echo "<h3>Supplier Import Results</h3>";
    echo "<table border='1' cellpadding='5'>
            <tr><th>Supplier Name</th><th>Status</th></tr>";

    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
        // Column index 3 = Pref Vendor
        $prefVendor = trim($data[3]);

        if ($prefVendor != "") {
            // --- Check if supplier exists ---
            $checkStmt = $conn->prepare("SELECT suppliername FROM tbl_supplier WHERE suppliername = ? AND tbl_country_idtbl_country = ?");
            $checkStmt->bind_param("si", $prefVendor, $sriLankaID);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                echo "<tr><td>{$prefVendor}</td><td style='color:green;'>Already Exists</td></tr>";
            } else {
                // --- Insert new supplier ---
                $insertStmt = $conn->prepare("
                    INSERT INTO tbl_supplier (suppliername, status, insertdatetime, tbl_country_idtbl_country)
                    VALUES (?, '1', NOW(), ?)
                ");
                $insertStmt->bind_param("si", $prefVendor, $sriLankaID);
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
