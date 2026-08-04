<?php
class Customerporderreportinfo extends CI_Model{
    public function printreport($x, $y){

        $recordID = $x;
        $productID = $y;
        $companyid=$_SESSION['companyid'];
        
        $prefix = 'UN';
        if ($companyid == 2) {
            $prefix = 'UF';
        }

        $htmlcusdetail = '';
        
        $sql = "SELECT tbl_customer_porder_detail.*, tbl_customer_porder.*, tbl_product.productcode, tbl_product.prodcutname
                FROM tbl_customer_porder_detail
                LEFT JOIN tbl_customer_porder ON tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder
                LEFT JOIN tbl_product ON tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product
                WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder = ?
                AND tbl_customer_porder_detail.status = ?";
        $respond = $this->db->query($sql, array($recordID, 1));

        $sql2 = "SELECT `prostartdate`,`proenddate` FROM `tbl_production_order` WHERE `tbl_customer_porder_idtbl_customer_porder`=?";
        $respond2 = $this->db->query($sql2, array($recordID));
        
        if ($respond2->num_rows() > 0) {
            $prostartdate = $respond2->row(0)->prostartdate;
            $proenddate = $respond2->row(0)->proenddate;
        } else {
            // Handle the case when no rows are returned
            // You can assign default values or display an error message
            $prostartdate = "N/A";
            $proenddate = "N/A";
        }
        
        $sqlcus = "SELECT `u`.*, `ua`.`name`, `ua`.`contact`, `ua`.`customercode`,`ua`.`contact2`, `ua`.`address`, `ua`.`email` FROM `tbl_customer_porder` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status`=? AND `u`.`idtbl_customer_porder`=?";
        $respondcus = $this->db->query($sqlcus, array(1, $recordID));
        
        $htmlcusdetail .= '
        <div class="col-7" style="font-size:12px; margin-top:5px;">
            <label style="font-weight:bold;">Sales Order: &nbsp;</label>
            <label>' . $prefix . '/SOD-0000' . ($respond ? $respond->row(0)->sod_no : '') . '</label><br><br>
            
            <label style="font-weight:bold;">Customer Name: &nbsp;</label>' . ($respondcus ? $respondcus->row(0)->name : '') . '<br>
            <label style="font-weight:bold;">Customer Code: &nbsp;</label>' . ($respondcus ? $respondcus->row(0)->customercode : '') . '<br><br>
            
            <label style="font-weight:bold;">Due Date: &nbsp;</label>' . ($respond ? $respond->row(0)->duedate : '') . '<br><br>
            
            <label style="font-weight:bold;">Production Start Date: &nbsp;</label>' . $prostartdate . '<br>
            <label style="font-weight:bold;">Production End Date: &nbsp;</label>' . $proenddate . '<br><br><br>
        </div>';

        $tblporder='';

        $sqltable = "SELECT tbl_customer_porder_detail.*, tbl_customer_porder.*, tbl_product.productcode, tbl_product.idtbl_product, tbl_product.weight, tbl_product.prodcutname
        FROM tbl_customer_porder_detail
        LEFT JOIN tbl_customer_porder ON tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder
        LEFT JOIN tbl_product ON tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product
        WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder = ?
        AND tbl_customer_porder_detail.status = ?";
        $respondtable = $this->db->query($sqltable, array($recordID, 1));

        $products = $respondtable->result(); // Get all products
        
        $i=1;
        foreach ($products as $rowlist) {
            $productid = $rowlist->idtbl_product;
            $qty = $rowlist->qty;
        
            $stocktable = "SELECT SUM(`qty`) AS excessqty FROM `tbl_product_stock` WHERE `tbl_product_idtbl_product` = ? AND `status` = ? GROUP BY `tbl_product_idtbl_product`";
            $respondstock = $this->db->query($stocktable, array($productid, 1));
        
            if ($respondstock->num_rows() > 0) {
                $excessqty = $respondstock->row(0)->excessqty;
            } else {
                // Handle the case when no rows are returned
                // You can assign default values or display an error message
                $excessqty = "0";
            }

            $balanceqty = $qty-$excessqty;
        
            // Rest of your code
            $tblporder .= '
                <tr style="text-align:right; border: 1px solid black;">
                    <td style="font-size:10px; text-align:center; border: 1px solid black;" class="text-left">
                        '.$i++.'
                    </td>
                    <td style="font-size:10px; text-align:left; border: 1px solid black;" class="text-left">
                        '.$rowlist->productcode.'
                    </td>
                    <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                        '.$rowlist->weight.'
                    </td>
                    <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                        '.$rowlist->qty.'
                    </td>
                    <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                        '.$excessqty.'
                    </td>
                    <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                        '.$balanceqty.'
                    </td>
                </tr>';
        }


    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sales Order - Transfood Lanka</title>
        <style>
            @page {
                size: 210mm 297mm;
                margin: 5mm 5mm 5mm 5mm;
                font-family: Arial, sans-serif;
            }
            body {
                font-family: Arial, sans-serif;
                line-height: 1.5;
                text-align: left;
                margin-top: 110px;
                font-size: 11px;
            }
            header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px;
                height: 110px;
            }
            footer {
                position: fixed;
                bottom: 12px;
                left: 0px;
                right: 0px;
                height: 20px;
                border-top: 1px dotted #000;
                text-align: center;
                font-size: 9px;
            }
        </style>
    </head>
    <body>
        <header>
            <table style="width:100%;border-collapse:collapse;">
                <tr>
                    <td style="text-align:right;"><img src="'.base_url().'images/logo.png" style="width:140px;height:80px;margin-right:20px;"></td>
                    <td style="font-size:12px;">
                        <h3 style="color:#FF0000;font-size:25px;font-weight:bold;margin:0;">Transfood Lanka (Pvt) Ltd.</h3>
                        17A/1, 2 Vihara Mawatha, Kolonnawa<br>
                        Tel/Fax: +94 11-2254441 Email: info@tflanka.com<br>
                        www.transfoodlanka.com or www.tflanka.com
                    </td>
                </tr>
            </table>
        </header>

        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td colspan="3" style="border:1px solid #000;font-size:16px;font-weight:bold;letter-spacing:2px;text-align:center;">SALES ORDER</td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td style="vertical-align:top;">
                    <table style="width:100%;border-collapse:collapse;">
                        <tr>
                            <th style="border:1px solid #000;background-color:#97d197;text-align:center;">CUSTOMER</th>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;text-align:center;padding:4px;">' . ($respondcus ? $respondcus->row(0)->name : '') . '</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;text-align:center;padding:4px;">Code: ' . ($respondcus ? $respondcus->row(0)->customercode : '') . '</td>
                        </tr>
                    </table>
                </td>
                <td width="20%"></td>
                <td style="text-align:right;">
                    <table style="border-collapse:collapse;width:100%;text-align:center;">
                        <tr>
                            <td style="width:33%;background-color:#97d197;border:1px solid #000;">SALES ORDER NO</td>
                            <td style="width:33%;background-color:#97d197;border:1px solid #000;">DUE DATE</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">' . $prefix . '/SOD-0000' . ($respond ? $respond->row(0)->sod_no : '') . '</td>
                            <td style="border:1px solid #000;">' . ($respond ? $respond->row(0)->duedate : '') . '</td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr>
                            <td style="background-color:#97d197;border:1px solid #000;">PROD. START DATE</td>
                            <td style="background-color:#97d197;border:1px solid #000;">PROD. END DATE</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000;">' . $prostartdate . '</td>
                            <td style="border:1px solid #000;">' . $proenddate . '</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
                <td colspan="3">
                    <table style="border-collapse:collapse;width:100%;">
                        <tr>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;">#</th>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;width:30%;">Item Code</th>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Unit Weight</th>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Order Quantity</th>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Excess Onhand Qty</th>
                            <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Qty to be Produced</th>
                        </tr>
                        ' . $tblporder . '
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top:30px;text-align:center;">
                    <div style="width:100%;margin:auto;border-top:1px dotted #000;"></div>
                    <div style="margin-top:5px;font-size:10px;">
                        For queries, contact Transfood Lanka (Pvt) Ltd. | info@tflanka.com
                    </div>
                </td>
            </tr>
        </table>
    </body>
    </html>
';

// echo $html; 
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL COSTLIST SHEET.pdf", array("Attachment"=>0));

    }

}