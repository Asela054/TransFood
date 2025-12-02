<!DOCTYPE html>
<html>
<head>
    <title>Commercial Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .invoice-container {
            width: 900px;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }

        .header-table, .info-table, .items-table, .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            text-align: center;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .info-table td {
            padding: 4px;
            font-size: 13px;
        }

        .items-table th, .items-table td {
            border: 1px solid #000;
            font-size: 12px;
            padding: 5px;
            text-align: center;
        }

        .items-table th {
            background: #f2f2f2;
        }

        .footer-table td {
            padding: 5px;
        }

        .sign-area {
            margin-top: 20px;
            text-align: center;
        }

        .note {
            font-size: 12px;
            margin-top: 10px;
            line-height: 18px;
        }
    </style>
</head>
<body>

<div class="invoice-container">

    <!-- Header Section -->
    <table class="header-table">
        <tr>
            <td>
                <img src="logo.png" height="70"><br>
                <strong>Transfood Lanka (Pvt) Ltd.</strong><br>
                No: 57/F, Maligathenna Estate, Galthawa, Sri Lanka<br>
                Tel/Fax: +94 11 2345341 | Email: tflanka@gmail.com
            </td>
        </tr>

        <tr><td class="title">COMMERCIAL INVOICE</td></tr>
    </table>

    <br>

    <!-- Invoice Info Section -->
    <table class="info-table">
        <tr>
            <td><strong>INVOICE DATE:</strong> __________________</td>
            <td><strong>YOUR REF:</strong> __________________</td>
        </tr>
        <tr>
            <td><strong>B/L NO:</strong> __________________</td>
            <td><strong>CONT NO:</strong> __________________</td>
        </tr>
        <tr>
            <td><strong>CUSTOMER:</strong> __________________</td>
            <td><strong>INV REF:</strong> __________________</td>
        </tr>
    </table>

    <br>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th>SN</th>
                <th>Item Code</th>
                <th>Item</th>
                <th>Unit</th>
                <th>No of Pcs per carton</th>
                <th>No of MC</th>
                <th>Qty</th>
                <th>Unit Price $ FOB</th>
                <th>Price per MC FOB $</th>
                <th>Total Value FOB $</th>
            </tr>
        </thead>

        <tbody>
            <!-- 26 rows -->
            <?php for($i=1;$i<=26;$i++): ?>
            <tr>
                <td><?= $i ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endfor; ?>
        </tbody>

        <tr>
            <th colspan="9">TOTAL</th>
            <td></td>
        </tr>
    </table>

    <br>

    <!-- Freight / Grand Total -->
    <table class="items-table">
        <tr>
            <th width="80%">FREIGHT</th>
            <td></td>
        </tr>
        <tr>
            <th>GRAND TOTAL</th>
            <td></td>
        </tr>
    </table>

    <br>

    <!-- Note -->
    <div class="note">
        <strong>REX – GSP NOTE:</strong><br>
        The Exporter LKRREG174928061D0055E, declares that, except where otherwise clearly indicated, 
        these products are of SRI LANKA Preferential origin according to rules of origin of the 
        Generalized System of Preferences of the European Union and that the origin criterion met is "P".
    </div>

    <!-- Signature -->
    <div class="sign-area">
        <br><br><br>
        ___________________________<br>
        Authorized Signature
        <br><br>
        <img src="stamp.png" height="120">
    </div>

</div>

</body>
</html>
