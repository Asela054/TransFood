<?php
class Semiproductionreportinfo extends CI_Model{
    public function printreport($x){

        $recordID = $x;

        $htmlcusdetail = '';
        
        $sql = "SELECT
		`u`.`idtbl_semi_production` AS `idtbl_semi_production`,
		`u`.`prodate` AS `prodate`,
		`u`.`qty` AS `orderqty`,
		`ua`.`materialinfocode` AS `materialinfocode`,
		`ub`.`materialname` AS `materialname`,
		`uc`.`qty` AS `qty`,
		`uc`.`damageqty` AS `damageqty`,
		`ud`.`startdatetime` AS `startdatetime`,
		`ud`.`enddatetime` AS `enddatetime`,
		`u`.`grnstatus` AS `grnstatus`,
		`u`.`approvestatus` AS `approvestatus`,
		`u`.`status` AS `status`
	FROM
		`tbl_semi_production` AS `u`
	LEFT JOIN
		`tbl_material_info` AS `ua` ON (`ua`.`idtbl_material_info` = `u`.`tbl_material_info_idtbl_material_info`)
	LEFT JOIN
		`tbl_material_code` AS `ub` ON (`ub`.`idtbl_material_code` = `ua`.`tbl_material_code_idtbl_material_code`)
	LEFT JOIN
		`tbl_semi_production_daily_complete` AS `uc` ON (`u`.`idtbl_semi_production` = `uc`.`tbl_semi_production_idtbl_semi_production`)
	LEFT JOIN
		`tbl_machine_allocation` AS `ud` ON (`u`.`idtbl_semi_production` = `ud`.`tbl_semi_production_idtbl_semi_production`)
	WHERE
		`u`.`status`=? AND `u`.`idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

                if ($respond->num_rows() > 0) {
            $materialname = $respond->row(0)->materialname;
            $qty = $respond->row(0)->orderqty;
        } else {
            $materialname = "N/A";

        }

        $sql2 = "SELECT `tbl_machine`.`machine`,`tbl_machine_allocation`.`startdatetime`, `tbl_machine_allocation`.`enddatetime` FROM `tbl_machine_allocation` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine`=`tbl_machine_allocation`.`tbl_machine_idtbl_machine` WHERE `tbl_machine_allocation`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond2 = $this->db->query($sql2, array($recordID));
        
        if ($respond2->num_rows() > 0) {
            $machine = $respond2->row(0)->machine;
            $startdatetime = $respond2->row(0)->startdatetime;
            $enddatetime = $respond2->row(0)->enddatetime;
        } else {
            $machine = "N/A";
            $startdatetime = "N/A";
            $enddatetime = "N/A";
        }
        
        $sqlcus = "SELECT `u`.*, `ua`.`name`, `ua`.`contact`, `ua`.`customercode`,`ua`.`contact2`, `ua`.`address`, `ua`.`email` FROM `tbl_customer_porder` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status`=? AND `u`.`idtbl_customer_porder`=?";
        $respondcus = $this->db->query($sqlcus, array(1, $recordID));
        
        $htmlcusdetail .= '
		<table>
			<tr>
				<th>Production Order No</th>
				<td>:</td>
				<td>UN/PO-0000' . ($respond ? $respond->row(0)->idtbl_semi_production : '') . '</td>
			</tr>
		</table>
		<br>
		<table>
			<tr>
				<th>Customer Name</th>
				<td>:</td>
				<td</td> 
			</tr> 
		</table>
		<table>
			<tr>
				<th>Customer Code</th>
				<td>:</td>
				<td</td> 
			</tr> 
		</table>
		<br>
		<table>
			<tr>
				<th>Sales Order No</th>
				<td>:</td>
				<td</td> 
			</tr> 
		</table>
		<table>
			<tr>
				<th>Sales Order Due Date</th>
				<td>:</td>
				<td</td> 
			</tr> 
		</table>
		';

        $tblporder='';

        $sqltable = "SELECT `tbl_semi_production_detail`.`qty`, `tbl_semi_production_detail`.`unitprice`, `tbl_semi_production_detail`.`total`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_semi_production_detail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_semi_production_detail`.`status`=? AND `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production`=?";
        $respondtable = $this->db->query($sqltable, array(1,$recordID));

		$i="1";
        foreach($respondtable->result() as $rowlist){
            $tblporder.='
            <tr style="text-align:right; border: 1px solid black;">
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="text-left">
                '.$i.'
            </td>
            <td colspan="2" style="font-size:10px; text-align:left; border: 1px solid black;" class="text-left"> 
            '.$rowlist->materialinfocode.'
        </td>
            <td style="font-size:10px; text-align:center; border: 1px solid black;" class="totalrawcost text-left">
                '.number_format($rowlist->qty, 2).'
            </td>
        </tr>
            
            ';
			$i++;
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

    	<table>
    		<tr>
    			<td><img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px;">
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
    	<table style="width:100%;">
    		<tr>
    			<td width=100%">
    				<h2 style="font-size:20px; text-align:center;">PRODUCTION ORDER
    				</h2>
    			</td>
    		</tr>
    	</table>
    	<div class="container">

		<div class="row">
		'.$htmlcusdetail.'
        </div>
    		<div class="row">
    			<div class="col-12" style="padding:0;">
    				<table class="tg" style="table-layout: fixed; width: 100%; border-collapse: collapse;">
    					<tr style="text-align: center; font-weight: bold; font-size: 25px;">
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">#
    						</th>
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: left;">Semi
    							Item Name: '.$materialname.'</th>
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: left;">
    							Quantity: '.$qty.'</th>
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: left;">
    							Machine: '.$machine.'</th>
    					</tr>
    					<tr style="text-align: center; font-weight: bold; font-size: 25px;">
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">
    							Production Start Date :</th>
    						<th style="font-size: 15px; border: 1px solid black; text-align: center;">'.$startdatetime.'</th>
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">
    							Production End Date : </th>
    						<th style="font-size: 15px; border: 1px solid black; text-align: center;">'.$startdatetime.'</th>
    					</tr>
    					<tr style="text-align: center; font-weight: bold; font-size: 25px;">
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">#
    						</th>
    						<th colspan="2"
    							style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: left;">Semi
    							BOM</th>
    						<th style="font-size: 15px; font-weight: bold; border: 1px solid black; text-align: center;">
    							Quantity</th>

    					</tr>
                <tbody>
                    '.$tblporder.'
                </tbody>
            </table>

    			</div>
    		</div>

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