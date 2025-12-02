<?php
class Invoiceviewreportinfo extends CI_Model{
    public function printreport($x){
        $companyid=$_SESSION['companyid'];

        function numberToWords($number) {
            $dictionary = array(
                0                   => 'zero',
                1                   => 'one',
                2                   => 'two',
                3                   => 'three',
                4                   => 'four',
                5                   => 'five',
                6                   => 'six',
                7                   => 'seven',
                8                   => 'eight',
                9                   => 'nine',
                10                  => 'ten',
                11                  => 'eleven',
                12                  => 'twelve',
                13                  => 'thirteen',
                14                  => 'fourteen',
                15                  => 'fifteen',
                16                  => 'sixteen',
                17                  => 'seventeen',
                18                  => 'eighteen',
                19                  => 'nineteen',
                20                  => 'twenty',
                30                  => 'thirty',
                40                  => 'forty',
                50                  => 'fifty',
                60                  => 'sixty',
                70                  => 'seventy',
                80                  => 'eighty',
                90                  => 'ninety',
                100                 => 'hundred',
                1000                => 'thousand',
                1000000             => 'million',
                1000000000          => 'billion'
            );
        
            if (!is_numeric($number)) {
                return false;
            }
        
            if ($number < 0) {
                return 'negative ' . numberToWords(abs($number));
            }
        
            $string = '';
            $number = number_format($number, 2, '.', '');
            $parts = explode('.', $number);
            $integerPart = intval($parts[0]);
            $decimalPart = isset($parts[1]) ? intval($parts[1]) : 0;
        
            if ($integerPart > 0) {
                $string .= convertNumberToWords($integerPart, $dictionary);
            } else {
                $string .= 'zero';
            }
        
            if ($decimalPart > 0) {
                $string .= ' point ' . convertNumberToWords($decimalPart, $dictionary);
            }
        
            return $string;
        }
        
        function convertNumberToWords($number, $dictionary) {
            $string = '';
        
            if ($number < 20) {
                $string .= $dictionary[$number];
            } elseif ($number < 100) {
                $string .= $dictionary[intval($number / 10) * 10];
                $string .= $number % 10 ? '-' . $dictionary[$number % 10] : '';
            } elseif ($number < 1000) {
                $string .= $dictionary[intval($number / 100)] . ' hundred';
                $string .= $number % 100 ? ' and ' . convertNumberToWords($number % 100, $dictionary) : '';
            } elseif ($number < 1000000) {
                $string .= convertNumberToWords(intval($number / 1000), $dictionary) . ' thousand';
                $string .= $number % 1000 ? ' ' . convertNumberToWords($number % 1000, $dictionary) : '';
            } elseif ($number < 1000000000) {
                $string .= convertNumberToWords(intval($number / 1000000), $dictionary) . ' million';
                $string .= $number % 1000000 ? ' ' . convertNumberToWords($number % 1000000, $dictionary) : '';
            } else {
                $string .= convertNumberToWords(intval($number / 1000000000), $dictionary) . ' billion';
                $string .= $number % 1000000000 ? ' ' . convertNumberToWords($number % 1000000000, $dictionary) : '';
            }
        
            return $string;
        }

        $recordID=$x;
        $tblinvoice='';

        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_product`.`weight`,`tbl_customer_porder_detail`.`unitprice`
        FROM `tbl_invoice_detail`
        LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice`.`idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=? GROUP BY `tbl_invoice_detail`.`idtbl_invoice_detail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $sqlcus = "SELECT `u`.`idtbl_invoice`, `u`.`invno`, `u`.`invdate`, `ud`.`name`, `ud`.`customercode` AS customercode, `ud`.`address` AS cusaddress, `ud`.`contact`, `ud`.`email` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_detail` AS `ua` ON `ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice` LEFT JOIN `tbl_product` AS `ub` ON `ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product` LEFT JOIN `tbl_customer_porder` AS `uc` ON `uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` AS `ud` ON `ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer` LEFT JOIN `tbl_location` AS `ue` ON `ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
        $respondsus = $this->db->query($sqlcus, array($recordID));

        $sqlbank = "SELECT `ua`.`account_name`, `ua`.`account_no`, `ua`.`bank_name`, `ua`.`bank_branch`, `ua`.`swift_code`, `ua`.`branch_code`, `ua`.`bank_code` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_bank` AS `ua` ON `ua`.`idtbl_invoice_bank` = `u`.`tbl_invoice_bank_idtbl_invoice_bank` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
        $respondbank = $this->db->query($sqlbank, array($recordID));

        $sqltotal="SELECT `grosstotal` AS total, SUM(`qty`) AS qty, `discount` AS discount, `nettotal` AS nettotal FROM `tbl_invoice_detail` LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice` WHERE `tbl_invoice_idtbl_invoice`=?";
        $respondtotal = $this->db->query($sqltotal, array($recordID));
        
        $row2 = $respondtotal->row();
        $qty = $row2->qty;
        $total = floatval(number_format($row2->total, 2, '.', ''));
        $discount = floatval(number_format($row2->discount, 2, '.', ''));
        $nettotal = floatval(number_format($row2->nettotal, 2, '.', ''));
        $amountInWords = numberToWords($total);
    
        if ($respondsus->num_rows() > 0) {
            $row = $respondsus->row();
            $cusname = $row->name;
            $cusaddress = $row->cusaddress;
            $customercode = $row->customercode;
            $contact = $row->contact;
            $email = $row->email;
            $invdate = $row->invdate;
            $invid = $row->idtbl_invoice;
            $invno = $row->invno;
        }
        
        if ($respondbank->num_rows() > 0) {
            $row = $respondbank->row();
            $accname = $row->account_name;
            $accnum = $row->account_no;
            $bank = $row->bank_name;
            $branch = $row->bank_branch;
            $swiftcode = $row->swift_code;
            $branchcode = $row->branch_code;
            $bankcode = $row->bank_code;
        }
        
        $i=1;
        $rowCount = 0;
        $pageLimit = 14;

        foreach($respond->result() as $rowlist){
            if ($rowCount % $pageLimit == 0 && $rowCount > 0) {
                $tblinvoice .= '</tbody></table><div style="page-break-after: always;"></div><table width="100%" style="border-collapse: collapse; margin: 0 auto;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:5%; border: thin 1px solid; padding: 8px;" scope="col">SN</th>
                            <th style="text-align: center; width:25%; border: thin 1px solid; padding: 8px;" scope="col">Item Code</th>
                            <th style="text-align: center; width:25%; border: thin 1px solid; padding: 8px;" scope="col">Item</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">Unit</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">Pks/Carton</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">No of MC</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">Qty</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">Unit Price</th>
                            <th style="text-align: center; width:10%; border: thin 1px solid; padding: 8px;" scope="col">Price/MCT</th>
                            <th style="text-align: center; width:15%; border: thin 1px solid; padding: 8px;" scope="col">TOTAL VALUE</th>
                        </tr>
                    </thead>
                    <tbody>';
            }

            $tblinvoice .= '
                <tr>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;">'.$i++.'</td>
                    <td style="border: thin 1px solid; padding: 8px;">'.$rowlist->productcode.'</td>
                    <td style="border: thin 1px solid; padding: 8px;">'.$rowlist->desc.'</td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;">'.$rowlist->weight.'</td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;"></td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;"></td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;">'.$rowlist->qty.'</td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;">'.number_format($rowlist->saleprice, 2).'</td>
                    <td style="text-align: center; border: thin 1px solid; padding: 8px;">'.number_format($rowlist->saleprice, 2).'</td>
                    <td style="text-align: right; border: thin 1px solid; padding: 8px;">'.number_format($rowlist->total, 2).'</td>
                </tr>';
            
            $rowCount++;
        } 
        
        $html='
        <html>
            <head>
                <style>
                    /** Define margins **/
                    @page {
                        margin: 100px 30px 50px 30px;
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                    }

                    body {
                        margin: 0;
                        padding: 0;
                        font-family: Arial, sans-serif;
                        font-size: 12px;
                        color: #000;
                    }

                    header {
                        position: fixed;
                        top: -80px;
                        left: 0px;
                        right: 0px;
                        height: 80px;
                        margin: 0 30px;
                    }

                    footer {
                        position: fixed; 
                        bottom: -30px; 
                        left: 0px; 
                        right: 0px;
                        height: 30px; 
                        text-align: center;
                        font-size: 10px;
                        color: #666;
                        margin: 0 30px;
                    }

                    .main-container {
                        width: 100%;
                        margin: 0 auto;
                        padding: 10px 0;
                    }

                    .invoice-title {
                        text-align: center;
                        margin: 10px 0 20px 0;
                        padding-bottom: 10px;
                        border-bottom: 1px solid #ccc;
                    }

                    .company-info {
                        margin-bottom: 15px;
                    }

                    .invoice-info {
                        margin-bottom: 20px;
                    }

                    .invoice-table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 15px auto;
                    }

                    .invoice-table th,
                    .invoice-table td {
                        border: 1px solid #000;
                        padding: 8px;
                        font-size: 11px;
                    }

                    .invoice-table th {
                        background-color: #f5f5f5;
                        text-align: center;
                        font-weight: bold;
                    }

                    .total-section {
                        margin-top: 20px;
                        border-top: 2px solid #000;
                        padding-top: 10px;
                    }

                    .notes-section {
                        margin-top: 20px;
                        padding: 10px;
                        border: 1px solid #ccc;
                        background-color: #f9f9f9;
                        font-size: 10px;
                    }

                    .center {
                        text-align: center;
                    }

                    .right {
                        text-align: right;
                    }

                    .left {
                        text-align: left;
                    }

                    .bold {
                        font-weight: bold;
                    }

                    .underline {
                        text-decoration: underline;
                    }

                    .page-break {
                        page-break-after: always;
                    }
                </style>
            </head>
            <body>
                <!-- Header -->
                <header>
                    <table style="width:100%; border-collapse: collapse; margin-bottom: 10px;">
                        <tr>
                            <td style="width: 20%;">
                                <img src="'.base_url().'images/logo.png" style="width: 140px; height: 80px;">
                            </td>
                            <td style="width: 80%; vertical-align: top; padding-left: 20px;">
                                <h2 style="color: #FF0000; font-size: 24px; font-weight: bold; margin: 0 0 5px 0;">Transfood Lanka (Pvt) Ltd.</h2>
                                <p style="margin: 2px 0; font-size: 11px;">
                                    17/A, Vihara Mawatha, Katunayake, Sri Lanka<br>
                                    Tel/Fax: +94 11-2254441 Email: info@tflanka.com<br>
                                    www.transfoodlanka.com or www.tflanka.com
                                </p>
                            </td>
                        </tr>
                    </table>
                </header>

                <!-- Footer -->
                <footer>
                    <div style="width: 100%; border-top: 1px solid #ccc; padding-top: 5px;">
                        Page <span class="pagenum"></span> | Transfood Lanka (Pvt) Ltd. | www.transfoodlanka.com
                    </div>
                </footer>

                <!-- Main Content -->
                <div class="main-container">
                    <!-- Invoice Title -->
                    <div class="invoice-title">
                        <h2 class="underline">COMMERCIAL INVOICE</h2>
                    </div>

                    <!-- Invoice Information -->
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                                <table style="width: 100%; font-size: 12px;">
                                    <tr>
                                        <td style="width: 30%; font-weight: bold;">INVOICE NO</td>
                                        <td style="width: 5%;">:</td>
                                        <td>'.$invno.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">INVOICE DATE</td>
                                        <td>:</td>
                                        <td>'.$invdate.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">B/L NO.</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">CUSTOMER</td>
                                        <td>:</td>
                                        <td>'.$cusname.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">ADDRESS</td>
                                        <td>:</td>
                                        <td>'.$cusaddress.'</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 50%; vertical-align: top;">
                                <table style="width: 100%; font-size: 12px;">
                                    <tr>
                                        <td style="width: 30%; font-weight: bold;">YOUR REF</td>
                                        <td style="width: 5%;">:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">CON NO</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">INV REF</td>
                                        <td>:</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">CUSTOMER CODE</td>
                                        <td>:</td>
                                        <td>'.$customercode.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">CONTACT</td>
                                        <td>:</td>
                                        <td>'.$contact.'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Invoice Items Table -->
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th style="width:5%;">SN</th>
                                <th style="width:20%;">Item Code</th>
                                <th style="width:25%;">Item Description</th>
                                <th style="width:8%;">Unit</th>
                                <th style="width:8%;">Pks/Carton</th>
                                <th style="width:8%;">No of MC</th>
                                <th style="width:8%;">Quantity</th>
                                <th style="width:10%;">Unit Price ($)</th>
                                <th style="width:10%;">Price/MCT ($)</th>
                                <th style="width:12%;">Total Value ($)</th>
                            </tr>
                        </thead>
                        <tbody>'.$tblinvoice.'</tbody>
                    </table>

                    <!-- Totals Section -->
                    <table style="width: 100%; margin-top: 20px; font-size: 12px;">
                        <tr>
                            <td style="width: 70%;"></td>
                            <td style="width: 30%;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 5px; font-weight: bold;">Sub Total:</td>
                                        <td style="padding: 5px; text-align: right; border: 1px solid #000;">'.number_format($total, 2).'</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px; font-weight: bold;">Freight:</td>
                                        <td style="padding: 5px; text-align: right; border: 1px solid #000;">0.00</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px; font-weight: bold;">Discount:</td>
                                        <td style="padding: 5px; text-align: right; border: 1px solid #000;">'.number_format($discount, 2).'</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px; font-weight: bold; border-top: 2px solid #000;">Grand Total:</td>
                                        <td style="padding: 5px; text-align: right; border: 1px solid #000; border-top: 2px solid #000;">
                                            <strong>'.number_format($nettotal, 2).'</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Amount in Words -->
                    <div style="margin-top: 20px; padding: 10px; border: 1px solid #ccc; background-color: #f9f9f9;">
                        <strong>Amount in Words:</strong> '.ucfirst($amountInWords).' US Dollars Only
                    </div>

                    <!-- Notes Section -->
                    <div class="notes-section">
                        <h4 style="margin: 0 0 5px 0; font-size: 11px;">REX - GSP NOTE:</h4>
                        <p style="margin: 0; font-size: 10px; line-height: 1.4;">
                            The Exporter LKREX174928061DC0556, of the products covered by this document declare that, 
                            except where otherwise clearly indicated, these products are of SRI LANKA preferential origin 
                            according to rules of origin of the Generalized System of Preferences of the European Union 
                            and that the origin criterion met is "P".
                        </p>
                    </div>

                    <!-- Bank Details -->
                    <div style="margin-top: 20px; padding: 10px; border: 1px solid #ccc; font-size: 11px;">
                        <h4 style="margin: 0 0 10px 0; font-size: 12px;">BANK DETAILS:</h4>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;"><strong>Account Name:</strong></td>
                                <td>'.$accname.'</td>
                                <td style="width: 20%;"><strong>Bank Name:</strong></td>
                                <td>'.$bank.'</td>
                            </tr>
                            <tr>
                                <td><strong>Account No:</strong></td>
                                <td>'.$accnum.'</td>
                                <td><strong>Branch:</strong></td>
                                <td>'.$branch.'</td>
                            </tr>
                            <tr>
                                <td><strong>Swift Code:</strong></td>
                                <td>'.$swiftcode.'</td>
                                <td><strong>Branch Code:</strong></td>
                                <td>'.$branchcode.'</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Footer Notes -->
                    <div style="margin-top: 30px; padding-top: 10px; border-top: 1px solid #ccc; font-size: 10px; text-align: center;">
                        <p style="margin: 5px 0;">
                            <strong>FOR TRANSFOOD LANKA (PVT) LTD.</strong><br>
                            Authorized Signature
                        </p>
                    </div>
                </div>

                <script type="text/php">
                    if (isset($pdf)) {
                        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
                        $size = 9;
                        $font = $fontMetrics->getFont("Arial");
                        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                        $x = ($pdf->get_width() - $width) / 2;
                        $y = $pdf->get_height() - 35;
                        $pdf->page_text($x, $y, $text, $font, $size);
                    }
                </script>
            </body>
        </html>
        ';
    
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream("INVOICE-".$invno.".pdf", array("Attachment"=>0));
    }
}