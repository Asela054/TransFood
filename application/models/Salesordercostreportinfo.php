<?php
class Salesordercostreportinfo extends CI_Model{
    public function printreport($x){

        $recordID=$x;

        $matcostsql="SELECT SUM(`tbl_customer_porder_cost`.`costamount`) AS rawmatcosttotal, `tbl_customer_porder_detail`.`qty` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $matcostrespond=$this->db->query($matcostsql, array($recordID, 1, 1));

		$matcostqty=$matcostrespond->row(0)->qty;

        if(!empty($matcostrespond->row(0)->rawmatcosttotal)){$matcost=$matcostrespond->row(0)->rawmatcosttotal;}
        else{$matcost=0;}
        $matcosttotal=$matcost;

        $processcostsql="SELECT SUM(`tbl_customer_porder_cost`.`costamount`) AS processcosttotal, `tbl_customer_porder_detail`.`qty` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $processrespond=$this->db->query($processcostsql, array($recordID, 2, 1));

		$processqty=$processrespond->row(0)->qty;

        if(!empty($processrespond->row(0)->processcosttotal)){$processcost=$processrespond->row(0)->processcosttotal;}
        else{$processcost=0;}
        $processcosttotal=$processcost;

        $shippingcostsql="SELECT SUM(`tbl_customer_porder_cost`.`costamount`) AS shippingcosttotal, `tbl_customer_porder_detail`.`qty` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $shippingrespond=$this->db->query($shippingcostsql, array($recordID, 3, 1));

		$shippingqty=$shippingrespond->row(0)->qty;

        if(!empty($shippingrespond->row(0)->shippingcosttotal)){$shippingcost=$shippingrespond->row(0)->shippingcosttotal;}
        else{$shippingcost=0;}
        $shippingtotal=$shippingcost;

        $totalcostsql="SELECT SUM(`tbl_customer_porder_cost`.`costamount`) AS totalcost, `tbl_customer_porder_detail`.`qty` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=?  AND `tbl_customer_porder_cost`.`status`=?";
        $totalcostrespond=$this->db->query($totalcostsql, array($recordID, 1));

		$totalcostqty=$totalcostrespond->row(0)->qty;

        if(!empty($totalcostrespond->row(0)->totalcost)){$totalcost=$totalcostrespond->row(0)->totalcost;}
        else{$totalcost=0;}
        $finalcosttotal=$totalcost * $totalcostqty;

		$htmlcusdetail='';

        $cussql="SELECT `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer`.`name`, `tbl_customer`.`contact`, `tbl_customer`.`contact2`, `tbl_customer`.`address`, `tbl_customer`.`email` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`= `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`= `tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=?  AND `tbl_customer_porder_cost`.`status`=?";
        $cusrespond=$this->db->query($cussql, array($recordID, 1));

            $htmlcusdetail.='
            <div class="col-7" style="font-size:12px; margin-top:5px;"><label style="font-weight:bold;">Sales Order: &nbsp;</label><label>SOD000</label>'.$cusrespond->row(0)->idtbl_customer_porder.'<br> <label style="font-weight:bold;">Customer Name: &nbsp;</label>'.$cusrespond->row(0)->name.'<br> <label style="font-weight:bold;">Contact: &nbsp;</label>'.$cusrespond->row(0)->contact.' / '.$cusrespond->row(0)->contact2.'<br> <label style="font-weight:bold;">Address: &nbsp;</label>'.$cusrespond->row(0)->address.'<br> <label style="font-weight:bold;">Email: &nbsp;</label>'.$cusrespond->row(0)->email.'</div>
           
            ';

        $tblmatcost='';

        $sql="SELECT `tbl_customer_porder_detail`.`qty`, `tbl_customer_porder_cost`.`idtbl_customer_porder_cost`, `tbl_customer_porder_cost`.`costamount`, `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type`, `tbl_expence_type`.`expencetype` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1, 1));

        foreach($respond->result() as $rowlist){
            $tblmatcost.='
            <tr style="text-align:right;">
                <td style="font-size:9px;" class="text-right">'.$rowlist->idtbl_customer_porder_cost.'</td>
                <td style="font-size:9px;" class="text-right">'.$rowlist->expencetype.'</td>
                <td style="font-size:9px;" class="totalrawcost text-right">'.number_format(($rowlist->costamount), 2).'</td>        
                <td style="font-size:9px;" class="totalrawcost text-right">'.number_format(($rowlist->costamount * $rowlist->qty), 2).'</td>             
             </tr>
            
            ';
        } 
        
        $tblprocessnpack='';

        $sql2="SELECT `tbl_customer_porder_detail`.`qty`, `tbl_customer_porder_cost`.`idtbl_customer_porder_cost`, `tbl_customer_porder_cost`.`costamount`, `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type`, `tbl_expence_type`.`expencetype` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $respond2=$this->db->query($sql2, array($recordID, 2, 1));

		// print_r($this->db->last_query());    


        foreach($respond2->result() as $rowlist){
            $tblprocessnpack.='
            <tr style="text-align:right;">
                <td style="font-size:9px;" class="text-right">'.$rowlist->idtbl_customer_porder_cost.'</td>
                <td style="font-size:9px;" class="text-right">'.$rowlist->expencetype.'</td>
                <td style="font-size:9px;" class="totalprocesscost text-right">'.number_format(($rowlist->costamount), 2).'</td>  
                <td style="font-size:9px;" class="totalprocesscost text-right">'.number_format(($rowlist->costamount * $rowlist->qty), 2).'</td>           
             </tr>
            
            ';
        }

        $tblshipping='';

        $sql3="SELECT `tbl_customer_porder_detail`.`qty`, `tbl_customer_porder_cost`.`idtbl_customer_porder_cost`, `tbl_customer_porder_cost`.`costamount`, `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type`, `tbl_expence_type`.`expencetype` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_expence_type`.`reportorder`=? AND `tbl_customer_porder_cost`.`status`=?";
        $respond3=$this->db->query($sql3, array($recordID, 3, 1));


        foreach($respond3->result() as $rowlist){
            $tblshipping.='
            <tr style="text-align:right;">
                <td style="font-size:9px;" class="text-right">'.$rowlist->idtbl_customer_porder_cost.'</td>
                <td style="font-size:9px;" class="text-right">'.$rowlist->expencetype.'</td>
                <td style="font-size:9px;" class="totalshippingcost text-right">'.number_format(($rowlist->costamount), 2).'</td>          
                <td style="font-size:9px;" class="totalprocesscost text-right">'.number_format(($rowlist->costamount * $rowlist->qty), 2).'</td>              
             </tr>
            
            ';
        }

    $html = '
    <!DOCTYPE html>
    <html>

    <head>
    	<title>Unistar - By Erav Technology</title>
    	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    	<style>
    		.tg td {
    			font-family: Arial, sans-serif;
    			font-size: 14px;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg th {
    			font-family: Arial, sans-serif;
    			font-size: 14px;
    			font-weight: normal;
    			overflow: hidden;
    			word-break: normal;
    		}

    		.tg .tg-btmp {
    			color: #000;
    			text-align: left;
    			vertical-align: top
    		}

    		.tg .tg-0lax {
    			text-align: left;
    			vertical-align: top
    		}
    	</style>
    </head>

    <body>

    	<table style="border: 2px solid;">
    		<tr>
    			<td><img src="images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px;">
    			</td>
    			<td>
    				<address style="font-size:9px; font-weight:bold; margin-left:245px;">
    					<h3><u>HEAD OFFICE</u></h3>
    					UNISTAR INTERNATIONAL PVT LTD<br>
    					53, 3rd LANE, RATMALANA<br>
    					0112635185, 0779662165<br>
    					0112635185, 0779662165<br>
    				</address>
    			</td>
    			<td>
    				<address style="font-size:9px; font-weight:bold; margin-left:20px;">
    					<h3><u>SHOWROOM</u></h3>
    					CEYLON`Z HARVEST<br>
    					63, JAYA MAWATHA,<br>
    					RATMALANA<br>
    					0112635185, 0779662165<br>
    				</address>
    			</td>
    		</tr>
    	</table>
    	<table style="border: 1px solid">
    		<tr style=" background-color:#000; color:#fff;">
    			<td>
    				<h2 style="font-size:15px; margin-left:290px; margin-right:290px;">COSTLIST SHEET</h2>
    			</td>
    		</tr>
    	</table>
    	<div class="container">

		<div class="row">
		'.$htmlcusdetail.'
        </div>
    		<div class="row">
    			<div class="col-12" style="padding:0;">
    				<h6>RAW MATERIAL</h6>
    				<table class="tg" style="table-layout: fixed; width: 100%">
    					<tr style="text-align:right; font-weight:bold; background-color: #000; color:#fff; font-size:5px;">
    						<th style="font-size:10px;">#</th>
    						<th style="font-size:10px;">Costing Type</th>
							<th style="font-size:10px;">Per Unit Amount</th>
    						<th style="font-size:10px;">All Qty Amount</th>
    					</tr>
    					<tbody>
    						'.$tblmatcost.'
    					</tbody>
    					<tfoot>
    						<tr style="text-align:right;">
    							<th colspan="1"></th>
    							<th style="font-weight:bold; font-size:12px;">Total:</th>
								<th style="font-weight:bold; font-size:12px;"><label id="labelrawmatcosttotal">'.number_format(($matcosttotal),2).'</label></th>
    							<th style="font-weight:bold; font-size:12px;"><label id="labelrawmatcosttotal">'.number_format(($matcosttotal * $matcostqty),2).'</label></th>
    						</tr>
    					</tfoot>
    				</table>

    			</div>
    		</div>

    		<div class="row">
    			<div class="col-12" style="padding:0;">
    				<h6>PROCESSING & PACKAGING</h6>
    				<table class="tg" style="table-layout: fixed; width: 100%">
    					<tr style="text-align:right; font-weight:bold; background-color: #000; color:#fff; font-size:28px;">
    						<th style="font-size:10px;">#</th>
    						<th style="font-size:10px;">Costing Type</th>
							<th style="font-size:10px;">Per Unit Amount</th>
    						<th style="font-size:10px;">All Qty Amount</th>
    					</tr>
    					<tbody>
    						'.$tblprocessnpack.'
    					</tbody>
    					<tfoot>
    						<tr style="text-align:right;">
    							<th colspan="1"></th>
    							<th style="font-weight:bold; font-size:12px; text-align:right">Total:</th>
								<th style="font-weight:bold; font-size:12px;"><label id="labelcosttotal"></label>'.number_format(($processcosttotal),2).'</th>
    							<th style="font-weight:bold; font-size:12px;"><label id="labelcosttotal"></label>'.number_format(($processcosttotal * $processqty),2).'</th>
    						</tr>
    					</tfoot>
    				</table>

    			</div>
    		</div>

    		<div class="row">
    			<div class="col-12" style="padding:0;">
    				<h6>SHIPPING</h6>
    				<table class="tg" style="table-layout: fixed; width: 100%">
    					<tr style="text-align:right; font-weight:bold; background-color: #000; color:#fff; font-size:28px;">
    						<th style="font-size:10px;">#</th>
    						<th style="font-size:10px;">Costing Type</th>
							<th style="font-size:10px;">Per Unit Amount</th>
    						<th style="font-size:10px;">All Qty Amount</th>
    					</tr>
    					<tbody>
    						'.$tblshipping.'
    					</tbody>
    					<tfoot>
    						<tr style="text-align:right;">
    							<th colspan="1"></th>
    							<th style="font-weight:bold; font-size:12px; text-align:right">Total:</th>
								<th style="font-weight:bold; font-size:12px;"><label id="labelcosttotal"></label>'.number_format(($shippingtotal),2).'</th>
    							<th style="font-weight:bold; font-size:12px;"><label id="labelcosttotal"></label>'.number_format(($shippingtotal * $shippingqty),2).'</th>
    						</tr>
    					</tfoot>
    				</table>

    			</div>
    		</div>

    		<table style="margin-top:10px; width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold text-dark"> TOTAL COST :</label>
    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right; font-weight:bold;">
    					<label class="font-weight-bold text-dark" id="lblcheque">Rs.'.number_format(($finalcosttotal),2).'</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold text-dark"> Bank and other Charges :</label>

    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> 0.0%<label>
    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>
    			<tr>
    		</table>

    		<table style="margin-top:10px; width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold text-dark"> FINAL COST :</label>

    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right; font-weight:bold;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold text-dark"> COST/KG :</label>

    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr>
    				<td width="40%" style="color: red;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold"> PROFIT MARGIN :</label>
    				</td>
    				<td style="color: red;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> 0.0%</label>
    				</td>
    				</td>
    				<td style="color: red;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; padding-left:5px; font-weight:bold;">
    					<label class="small font-weight-bold"> TOTAL PRICE :</label>

    				</td>
    				<td style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="margin-top:10px; width: 100%">
    			<tr style="border: 1px solid;">
    				<td
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; font-weight:bold; padding-left:70px; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="small font-weight-bold"> PRICE/Kg (LKR) :</label>

    				</td>
    				<td
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr style="border: 1px solid;">
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; font-weight:bold; padding-left:70px; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="small font-weight-bold"> PRICE/Kg (USD($)) :</label>
    				</td>
    				<td
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>

    		<table style="width: 100%">
    			<tr>
    				<td width="40%"
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; font-weight:bold; padding-left:70px; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="small font-weight-bold"> PRICE/MT (US $) :</label>

    				</td>
    				<td
    					style="color: black;font-family:Arial, sans-serif;font-size:10px; text-align: right; border: 1px solid; width: 50%; padding-top: 5px; padding-bottom: 5px;">
    					<label class="font-weight-bold text-dark" id="lblcredit"> #####</label>
    				</td>

    			</tr>
    		</table>
    	</div>

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