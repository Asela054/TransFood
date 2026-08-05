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
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Production Order - Transfood Lanka</title>
        <style>
            @page { size: 210mm 297mm; margin: 5mm 5mm 5mm 5mm; font-family: Arial, sans-serif; }
            body { font-family: Arial, sans-serif; line-height: 1.5; text-align: left; margin-top: 110px; font-size: 11px; }
            header { position: fixed; top: 0px; left: 0px; right: 0px; height: 110px; }
            footer { position: fixed; bottom: 12px; left: 0px; right: 0px; height: 20px; border-top: 1px dotted #000; text-align: center; font-size: 9px; }
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
                <td colspan="4" style="border:1px solid #000;font-size:16px;font-weight:bold;letter-spacing:2px;text-align:center;">PRODUCTION ORDER</td>
            </tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">#</th>
                <th style="background-color:#97d197;border:1px solid #000;text-align:left;">Semi Item Name: '.$materialname.'</th>
                <th style="background-color:#97d197;border:1px solid #000;text-align:left;">Quantity: '.$qty.'</th>
                <th style="background-color:#97d197;border:1px solid #000;text-align:left;">Machine: '.$machine.'</th>
            </tr>
            <tr>
                <th style="border:1px solid #000;text-align:center;">Production Start Date:</th>
                <td style="border:1px solid #000;text-align:center;">'.$startdatetime.'</td>
                <th style="border:1px solid #000;text-align:center;">Production End Date:</th>
                <td style="border:1px solid #000;text-align:center;">'.$startdatetime.'</td>
            </tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">#</th>
                <th colspan="2" style="background-color:#97d197;border:1px solid #000;text-align:left;">Semi BOM</th>
                <th style="background-color:#97d197;border:1px solid #000;text-align:center;">Quantity</th>
            </tr>
            '.$tblporder.'
            <tr>
                <td colspan="4" style="padding-top:30px;text-align:center;">
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