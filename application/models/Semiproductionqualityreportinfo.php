<?php
class Semiproductionqualityreportinfo extends CI_Model{
    public function Semiproductionqualitycheckreport($x, $y){

        $recordID=$x;
        $materialid=$y;

		$html = '';

		$sqlmachineallocation = "SELECT `tbl_machine`.`machine`, `tbl_machine_allocation`.`startdatetime`, `tbl_machine_allocation`.`enddatetime`  FROM `tbl_machine_allocation` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_machine_allocation`.`tbl_machine_idtbl_machine` WHERE `tbl_machine_allocation`.`tbl_semi_production_idtbl_semi_production` = ?";
		$respondmachineallocation=$this->db->query($sqlmachineallocation, array($recordID));

		$sql="SELECT IFNULL(`tblel`.`ds`, `tbl_production_quality`.`magnet_verification`) As descstatus, `tbl_production_quality`.`idtbl_production_quality`, `tbl_production_quality`.`examined_quantity`, `tbl_production_quality`.`washing_temperature`, `tbl_production_quality`.`washing_time`, `tbl_production_quality`.`drying_temperature`, `tbl_production_quality`.`drying_time`, `tbl_production_quality`.`aftrer_drying_moisture`, `tbl_production_quality`.`drying_cooling_time`, `tbl_production_quality`.`cut_size`, `tbl_production_quality`.`cutting_wastage`, `tbl_production_quality`.`moisture_after_grinding`, `tbl_production_quality`.`roasting_temperature`, `tbl_production_quality`.`roasting_color`, `tbl_production_quality`.`roasting_time`, `tbl_production_quality`.`cooling_moisture`, `tbl_production_quality`.`cooling_time`, `tbl_production_quality`.`magnet_verification`, `tbl_production_quality`.`comments`, `tbl_production_quality`.`status`, `tbl_material_info`.`materialinfocode` FROM `tbl_production_quality` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_quality`.`tbl_material_info_idtbl_material_info` LEFT JOIN(SELECT 1 AS type, 'YES' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS ds, 2 As el) As tblel ON (`tbl_production_quality`.`magnet_verification`=`tblel`.`type`) WHERE `tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_production_quality`.`status`=?";
		$respond=$this->db->query($sql, array($recordID, 1));

		$sqlbom="SELECT `tbl_semi_bom`.`idtbl_semi_bom`, `tbl_semi_bom`.`qty`, `tbl_semi_bom`.`wastage`, `tbl_material_category`.`categoryname`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_semi_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_semi_bom`.`status`=? AND `tbl_semi_bom`.`semimaterial`=?";
		$respondbom=$this->db->query($sqlbom, array(1, $materialid));

		$sqlqty="SELECT `qty` FROM `tbl_semi_production` WHERE `tbl_semi_production`.`idtbl_semi_production`=? AND `tbl_semi_production`.`tbl_material_info_idtbl_material_info`=?";
		$respondqty=$this->db->query($sqlqty, array($recordID, $materialid));

		$sqlmachine="SELECT `mesh_size`, `wastage`, `machine` FROM `tbl_production_quality_machinelist` LEFT JOIN `tbl_production_quality` ON `tbl_production_quality`.`idtbl_production_quality`=`tbl_production_quality_machinelist`.`tbl_production_quality_idtbl_production_quality` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine`=`tbl_production_quality_machinelist`.`tbl_machine_idtbl_machine` WHERE `tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`=?";

        $respondmachine=$this->db->query($sqlmachine, array($recordID));


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

    	<table style="width:100%; border: 2px solid;">
    		<tr>
    			<td><img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt=""
    					style="width: 180px; height: 120px;">
    			</td>
    			<td>
    				<address style="font-size:9px; font-weight:bold; margin-left:145px;">
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
    	<table style="width:100%; border: 1px solid">
    		<tr>
    			<td style=" background-color:#000; color:#fff; width=100%">
    				<h2 style="font-size:15px; text-align:center;">PRODUCTION & PROCESSING QUALITY INSPECTION
    				</h2>
    			</td>
    		</tr>
    	</table>
    	<div class="container">
    		<table style="width:100%; padding-top:0px; border-collapse: collapse;">
    			<tr>
    				<td
    					style="border-left: 1px solid black; font-size:11.5px; padding-left:20px; padding-top:10px; width: 32%;">
    					PRODUCTION ORDER NO :
    				</td>
    				<td style="font-size:11.5px; border-bottom: 1px solid; padding-right:10px; width: 30%; padding-top:10px;">'.$recordID.'</td>
    				<td style="font-size:11.5px; padding-left:20px; padding-top:10px; width: 25%;">SALES ORDER NO :</td>
    				<td style="border-bottom: 1px solid; padding-right:20px; width: 40%; padding-top:10px;"></td>
    				<td style="border-right: 1px solid black; width: 9%"></td>
    			</tr>
    		</table>
    		<table style="width:100%; border-collapse: collapse;">
    			<tr>
    				<td
    					style="border-left: 1px solid black; font-size:11.5px; padding-left: 20px; padding-top:15px; width: 40%;">
    					PRODUCTION START DATE :
    				</td>
    				<td style="font-size:11.5px; border-bottom: 1px solid; padding-right:-20px; width: 30%; padding-top:15px;">'.$respondmachineallocation->row(0)->startdatetime.'</td>
    				<td style="font-size:11.5px; padding-left:30px;  padding-top:15px; width: 40%;">PRODUCTION END DATE :
    				</td>
    				<td style="font-size:11.5px; border-bottom: 1px solid; width: 40%; padding-top:15px;">'.$respondmachineallocation->row(0)->enddatetime.'</td>
    				<td style="border-right: 1px solid black; width: 9%"></td>
    			</tr>
    		</table>
    		<table style="width:100%; border-collapse: collapse;">
    			<tr>
    				<td
    					style="border-left: 1px solid black; font-size:11.5px; padding-left: 20px;  padding-top:15px; width: 15%;">
    					ITEM CODE :
    				</td>
    				<td style="font-size:11.5px; border-bottom: 1px solid; width: 80%;">'.$respond->row(0)->materialinfocode.'</td>
    				<td style=" border-right: 1px solid black;"></td>
    			</tr>
    		</table>
			';
				foreach ($respondbom->result() as $rowbomlist) {
					$html .= '
				<table style="width:100%; border-collapse: collapse;">
					<tr>
						<td style="border-left: 1px solid black; font-size:11.5px; padding-left: 20px; padding-top:15px; padding-bottom:15px; width: 40%;">
							BOM - BILL OF MATERIALS :
						</td>
						<td style="font-size:11.5px; width: 75%; padding-top:15px; padding-bottom:15px;">' . $rowbomlist->materialinfocode . '</td>
						<td style="border-right: 1px solid black; width: 25%;"></td>
					</tr>
				</table>
				';
				}
    		$html.='
    		<div class="form-row">
    			<table style="width:100%; border: 1px solid">
    				<tr>
    					<td style=" background-color:#A2A2A0; color:#000;">
    						<h2 style="font-size:15px; text-align:center;">QUALITY PARAMETERS</h2>
    					</td>
    				</tr>
    			</table>
    			<table style="width: 100%; border-collapse: collapse;">
    				<tr>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 47%; text-align: right;">
    						ORDER QUANTITY :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; width: 59.6%;">
							' . $respondqty->row(0)->qty . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 41%; text-align: right;">
    						EXAMINED QUANTITY :</td>
    					<td style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; width: 60%;">
						' . $respond->row(0)->examined_quantity . '
    					</td>
    					<td
    						style="text-align:center; border-bottom: 1px solid black; border-right: 1px solid black; width: 20%;">

    					</td>
    				</tr>
    			</table>
    			<table style="width: 100%; border-collapse: collapse;">
    				<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 46.5%; text-align: right;">
    						WASHING TEMPERATURE :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 61%;">
							' . $respond->row(0)->washing_temperature . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 42%; text-align: right;">
    						WASHING TIME :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->washing_time . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
    				<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						DRYING TEMPERATURE :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->drying_temperature . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						DRYING TIME :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->drying_time . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
    				<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						AFTRER DRYING MOISTURE % :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->aftrer_drying_moisture . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						DRYING - COOLING TIME :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->drying_cooling_time . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
    				<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						CUT SIZE :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->cut_size . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						CUTTING WASTAGE :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->cutting_wastage . '
    					</td>
    					<td
    						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">
    						%

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-left: 1px solid black; width: 40%; text-align: right;">MACHINES :
    						</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							MACHINE
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						MESH SIZE</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							WASTAGE
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>

					';
					foreach($respondmachine->result() as $rowmachinelist){
						$html.='
					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:8.5px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $rowmachinelist->machine . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						' . $rowmachinelist->mesh_size . '</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $rowmachinelist->wastage . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>

					';
                }
                $html.='


					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">MOISTURE % (AFTER GRINDING) :
    						</td>
    					<td
    						style="font-size:10px; font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">' . $respond->row(0)->moisture_after_grinding . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; width: 40%; text-align: right;"></td>
    					<td
    						style="font-size:11px; text-align:center; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">
							
    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
						ROASTING TEMPERATURE :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">
							' . $respond->row(0)->roasting_temperature . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						ROASTING COLOR :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->roasting_color . '
    					</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">
    						ROASTING TIME :
							' . $respond->row(0)->roasting_time . '
    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						COOLING MOISTURE % :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->cooling_moisture . '
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
    						COOLING TIME :</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->cooling_time . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
					<tr>
    					<td style="border-left: 1px solid black; width: 2%;"></td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
    						MAGNET VERIFICATION :</td>
    					<td
    						style="font-size:11px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							YES
    					</td>
    					<td
    						style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: center;">
    						NO</td>
    					<td
    						style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							' . $respond->row(0)->descstatus . '
    					</td>
    					<td
    						style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

    					</td>
    					<td style="border-right: 1px solid black; width: 2%;"></td>
    				</tr>
    			</table>
    			<table style="width: 100%; border-collapse: collapse;">
    				<tr>
    					<td
    						style="font-size:11px; border-top: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black; width: 25%; padding-left:73px">
    						COMMENTS :
    					</td>
						<td
						style="font-size:12px; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 75%;">
						' . $respond->row(0)->comments . '
					</td>
    				</tr>
    			</table>
    		</div>

    	</div>

    </body>

    </html>
';

    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));

    }
}