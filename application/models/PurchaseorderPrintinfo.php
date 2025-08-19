<?php
class PurchaseorderPrintinfo extends CI_Model{

    public function Printpurchaseorder($x){
    $recordID=$x;

    $sql =" SELECT `tbl_porder`.*, `tbl_supplier`.`suppliername` FROM `tbl_porder` 
    LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier` = `tbl_porder`.`tbl_supplier_idtbl_supplier` 
    WHERE `idtbl_porder` = '$recordID'";
    $respond=$this->db->query($sql, array(1, $recordID));

    $this->db->select('tbl_company.company AS companyname,tbl_company.address1 As companyaddress,tbl_company.mobile AS companymobile,tbl_company.phone companyphone,tbl_company.email AS companyemail,tbl_company_branch.branch AS branchname');
    $this->db->from('tbl_porder');
    $this->db->join('tbl_company', 'tbl_company.idtbl_company = tbl_porder.tbl_company_idtbl_company', 'left');
    $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_porder.tbl_company_branch_idtbl_company_branch', 'left');
    $this->db->where('tbl_porder.idtbl_porder', $recordID);
    $companydetails = $this->db->get();

    $sql2="SELECT `tbl_porder_detail`.*,`tbl_porder`.*,`tbl_material_info`.`materialinfocode`,`tbl_material_info`.`materialname`,`tbl_unit`.`unitname`
    FROM `tbl_porder`
    LEFT JOIN `tbl_porder_detail` ON `tbl_porder`.`idtbl_porder` = `tbl_porder_detail`.`tbl_porder_idtbl_porder`
    LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info` = `tbl_porder_detail`.`tbl_material_info_idtbl_material_info`
	LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit` = `tbl_material_info`.`tbl_unit_idtbl_unit`
    WHERE `tbl_porder_detail`.`status` = '1' AND `tbl_porder`.`idtbl_porder` = '$recordID'";
    $respond2=$this->db->query($sql2, array(1, $recordID));

    $po_number = "TRFL/PO-" . $respond->row(0)->idtbl_porder;
    
    $items_html = '';
    $sn = 1;
    $subtotal = 0;
    
    foreach($respond2->result() as $row) {
        $description = $row->materialname . " (" . $row->materialinfocode . ")";
        $total_qty = $row->qty;
        $total_amount = $row->total;
        $subtotal += $total_amount;
        
        $items_html .= '<tr>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: center;">'.$sn.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000;">'.$description.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: center;">'.$row->unitname.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: center;">'.$row->unitperctn.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: center;">'.$row->ctn.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: center;">'.$total_qty.'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: right;">'.number_format($row->unitprice, 2).'</td>
            <td style="padding: 5px; font-size: 10px; border: 1px solid #000; text-align: right;">'.number_format($total_amount, 2).'</td>
        </tr>';
        
        $sn++;
    }

    $html ='
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchase Order - Transfood Lanka</title>

        	<style>
        		@page {
        			size: A4 portrait;
        			margin: 0;
        		}

        		* {
					margin: 0;
					padding: 0;
					box-sizing: border-box;
					font-family: Calibri, Arial, sans-serif;
				}

        		.container {
        			width: 80%;
        			max-width: 17cm;
        			margin: 0 auto;
        			margin-top: 50px;
        		}

				header {
					position: fixed;
					top: 0;
					left: 0;
					width: 100%;
					display: flex;
					align-items: center; 
					justify-content: center;
					gap: 15px;               
					padding: 10px 70px;
					background: white;
					z-index: 1000;
				}

        		.logo {
        			width: 80px;
        			height: 60px;
        			background-color: #DAA520;
        			border-radius: 10px;
        			display: flex;
        			align-items: center;
        			justify-content: center;
        			color: white;
        			font-weight: bold;
        			font-size: 8px;
        			text-align: center;
        			position: relative;
        			margin-left: 5rem;
        		}

        		.company-info {
        			flex-grow: 1;
        			margin-left: 13rem;
        		}

        		.company-name {
        			color: #FF0000;
        			font-size: 25px;
        			font-weight: bold;
        		}

        		.company-details {
        			font-size: 12px;
        			line-height: 1.3;
        		}

        		.title-section {
        			text-align: center;
        			margin-bottom: 15px;
					margin-top: 100px;
        		}

        		.title {
        			border: 2px solid #000;
        			font-size: 16px;
        			font-weight: bold;
        			letter-spacing: 2px;
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
                    border-top: 1px dotted #000;
				}
        	</style>

    </head>

    <body>

    <div class="container">

    <header>
            <div class="logo"><img src="'.base_url().'images/logo.png" class="img-fluid" alt=""
                    style="width: 140px; height: 80px;"></div>
            <div class="company-info">
                <div class="company-name">Transfood Lanka (Pvt) Ltd.</div>
                <div class="company-details">
                    17/A, Vihara Mawatha, Katunayake, Sri Lanka<br>
                    Tel/Fax: +94 11-2254441 Email: info@tflanka.com<br>
                    www.transfoodlanka.com or www.tflanka.com
                </div>
            </div>
    </header>

        <div class="title-section">
            <div class="title">PURCHASE ORDER</div>
        </div>
        <div style="width: 100%;">
            <div class="row"
                style="display: flex; justify-content: space-between; align-items: flex-start; width: 100%; font-size: 13px; margin-bottom: 10px;">
                <div style="flex: 0 0 auto;">
                    <table style="border-collapse: collapse; text-align: center; width: 230px;">
                        <tr>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 10px;">
                                SUPPLIER</th>
                        </tr>
                        <tr>
                            <td style="border: none;">'.$respond->row(0)->suppliername.'</td>
                        </tr>
                    </table>
                </div>

                <div style="flex: 0 0 auto; margin-left: 295px;">
                    <table border="1" style="border-collapse: collapse; text-align: center; width: 340px;">
                        <tr>
                            <td
                                style="width:20%; padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                ESTIMATED DELIVERY</td>
                            <td
                                style="width:20%; padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                PO NUMBER</td>
                            <td
                                style="width:20%; padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                PO DATE</td>
                        </tr>
                        <tr>
                            <td style="padding: 5px; border: 1px solid #000;">'.date('d/m/Y', strtotime($respond->row(0)->duedate)).'</td>
                            <td style="padding: 5px; border: 1px solid #000;">'.$po_number.'</td>
                            <td style="padding: 5px; border: 1px solid #000;">'.date('d/m/Y', strtotime($respond->row(0)->orderdate)).'</td>
                        </tr>
                    </table>
                </div>
                <div style="display: flex; justify-content: flex-end; width: 25%;">
                    <div style="margin-left: 520px;">
                        <table border="1"
                            style="border-collapse: collapse; text-align: center; width: 115px; margin-top: 60px;">
                            <tr>
                                <td
                                    style="padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                    CLASS</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; border: 1px solid #000;">'.$respond->row(0)->class.'</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="display: flex; justify-content: flex-end; width: 100%;">
                    <div style="margin-left: 385px;">
                        <table
                            style="border-collapse: collapse; text-align: center; width: 250px; margin-top: 120px; font-size: 10px;">
                            <tr>
                                <td
                                    style="text-align: right; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                                    BR No</td>
                                <td
                                    style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                    :
                                </td>
                                <td
                                    style="text-align: left; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;">
                                    PV 92806</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: right; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                                    S VAT Reg No</td>
                                <td
                                    style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                    :
                                </td>
                                <td
                                    style="text-align: left; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;">
                                    11748</td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: right; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000;">
                                    VAT Reg No</td>
                                <td
                                    style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                    :
                                </td>
                                <td
                                    style="text-align: left; padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000;">
                                    174928061-7000</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="width: 100%;">
                    <table border="1"
                        style="border-collapse: collapse; width: 100%; font-size: 9px; margin-top: 200px;">
                        <tr>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                SN#</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                DESCRIPTION</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                UNIT</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                UNIT PER CTN</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                CTNS</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                TOTAL QTY</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                PRICE PER UNIT</th>
                            <th
                                style="padding: 5px; background-color: #97d197; border: 1px solid #000; text-align: center;">
                                TOTAL AMOUNT</th>
                        </tr>
                        '.$items_html.'
                        <table style="width: 100%; border-collapse: collapse; font-size: 9px;">
                            <tr>
                                <td style="padding: 5px; text-align: right; width: 83%;">SUB TOTAL</td>
                                <td style="padding: 5px; text-align: right;">'.number_format($subtotal, 2).'</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px; text-align: right; width: 83%;">TOTAL</td>
                                <td style="padding: 5px; border-top: 1px solid #000; text-align: right;">'.number_format($respond->row(0)->nettotal, 2).'</td>
                            </tr>
                        </table>
                    </table>
                    <div style="flex: 0 0 auto;">
                        <table border="1" style="border-collapse: collapse; text-align: center; width: 300px;">
                            <tr>
                                <th
                                    style="padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                    Notes and instructions</th>
                            </tr>
                            <tr>
                                <td style="padding: 5px; border: 1px solid #000; height: 50px;">'.$respond->row(0)->remark.'</td>
                            </tr>
                        </table>
                    </div>
                    <div style="display: flex; justify-content: flex-end; width: 25%;">
                        <div style="margin-left: 390px;">
                            <table style="border-collapse: collapse; text-align: center; width: 250px;">
                                <tr>
                                    <td
                                        style="padding: 5px; background-color: #97d197; border: 1px solid #000; font-size: 9px;">
                                        Authorized By
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 5px; border-bottom: 1px dotted; border-left: none; border-right: none; border-top: none; height: 30px;">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        For questions concerning this Purchase Order, Please Contact<br>
        M M Mohamed | 077 25 30 961 | tf.cspme@tflanka.com
    </footer>

    </body>

    </html>         
    ';
  
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
    $this->pdf->render();
    $this->pdf->stream( "MULTI OFFSET PRINTERS-PURCHASE ORDER- ".$recordID.".pdf", array("Attachment"=>0));
}

}
