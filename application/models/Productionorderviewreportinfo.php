<?php
class Productionorderviewreportinfo extends CI_Model{
    public function printreport($x){

        $recordID=$x;


        $tblproduction='';

        $sql = "SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_production_orderdetail`.`qty`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_production_order`.`prodate`, `tbl_production_order`.`procode`, `tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`
        FROM `tbl_production_orderdetail`
        LEFT JOIN `tbl_production_order`  ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product` WHERE `tbl_production_order`.`idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=? GROUP BY `tbl_production_orderdetail`.`idtbl_production_orderdetail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 


        $sqlcus = "SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_production_orderdetail`.`qty`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_production_order`.`prodate`, `tbl_production_order`.`procode`, `tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`
        FROM `tbl_production_orderdetail`
        LEFT JOIN `tbl_production_order`  ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product` WHERE `tbl_production_order`.`idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=? GROUP BY `tbl_production_orderdetail`.`idtbl_production_orderdetail`";
        $respondsus = $this->db->query($sqlcus, array($recordID, 1));

        $sqltotal="SELECT SUM(`qty`) AS qty FROM `tbl_production_orderdetail` WHERE `tbl_production_order_idtbl_production_order`=?";
        $respondtotal = $this->db->query($sqltotal, array($recordID));
    
        $row2 = $respondtotal->row();
        $qty = $row2->qty;
    
    if ($respondsus->num_rows() > 0) {
        $row = $respondsus->row();
        $prodate = $row->prodate;
    }

        foreach($respond->result() as $rowlist){
            $tblproduction.='
            <tr>
                    <td style="text-align: center;">'.$rowlist->idtbl_production_orderdetail.'</td>
                    <td>'.$rowlist->desc.'</td>
                    <td style="text-align: center;">'.$rowlist->qty.'</td>
                    <td style="text-align: center;">'.$rowlist->procode.'</td>
                    <td style="text-align: right;">'.$rowlist->prodate.'</td>
                    <td style="text-align: right;">'.$rowlist->prostartdate.'</td>
                    <td style="text-align: right;">'.$rowlist->proenddate.'</td>
                </tr>
            
            ';
        } 

    $html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Packing Order - Transfood Lanka</title>
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
                top: 0px; left: 0px; right: 0px;
                height: 110px;
            }
            footer {
                position: fixed;
                bottom: 12px; left: 0px; right: 0px;
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
                <td style="border:1px solid #000;font-size:16px;font-weight:bold;letter-spacing:2px;text-align:center;">PACKING ORDER DETAILS</td>
            </tr>
            <tr>
                <td>
                    <table style="width:100%;border-collapse:collapse;margin-top:8px;">
                        <tr>
                            <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">Date</td>
                            <td style="border:1px solid #000;padding:4px;">'.$prodate.'</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table style="border-collapse:collapse;width:100%;">
                        <thead>
                            <tr>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">#</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Item</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Quantity</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Packing Order Code</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Packing Order Date</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Packing Start Date</th>
                                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Packing End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$tblproduction.'
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="border:1px solid #000;background-color:#97d197;"></th>
                                <th style="border:1px solid #000;background-color:#97d197;text-align:left;">TOTAL:</th>
                                <th style="border:1px solid #000;background-color:#97d197;text-align:center;">'.$qty.'</th>
                                <th style="border:1px solid #000;background-color:#97d197;"></th>
                                <th style="border:1px solid #000;background-color:#97d197;"></th>
                                <th style="border:1px solid #000;background-color:#97d197;"></th>
                                <th style="border:1px solid #000;background-color:#97d197;"></th>
                            </tr>
                        </tfoot>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top:30px;text-align:center;">
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
	$this->pdf->stream( "UNISTAR-INTERNATIONAL PRODUCTION ORDER DETAIL SHEET.pdf", array("Attachment"=>0));

    }

}
