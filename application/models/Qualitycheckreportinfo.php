<?php
class Qualitycheckreportinfo extends CI_Model {
    public function Qualitycheckreport($x, $y) {
        $recordID = $x;
        $materialid = $y;

        $html = '';

        $sqlgrn = "SELECT `tbl_grn`.`idtbl_grn`, `tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`comment`, `tbl_supplier`.`suppliername`, `tbl_supplier`.`suppliercode` FROM `tbl_grn` LEFT JOIN `tbl_grndetail` ON `tbl_grn`.`idtbl_grn`=`tbl_grndetail`.`tbl_grn_idtbl_grn` LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier`=`tbl_grn`.`tbl_supplier_idtbl_supplier` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` WHERE `tbl_grn`.`status`=? AND `tbl_grn`.`idtbl_grn`=? AND `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=?";
        $respondgrn = $this->db->query($sqlgrn, array(1, $recordID, $materialid)); 

        $qualitysql="SELECT IFNULL(`tblel`.`ds`, `tbl_grn_quality`.`statuspassfail`) As descstatus, `idtbl_grn_quality`, `examined_qty`, `moisture_level`, `adultering`, `fungi_pest`, `color_confirmity`, `grade`, `size`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_grn_idtbl_grn`, `tbl_material_info_idtbl_material_info` FROM `tbl_grn_quality` LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_grn_quality`.`statuspassfail`=`tblel`.`type`)  WHERE `tbl_grn_idtbl_grn`=? AND `tbl_grn_quality`.`tbl_material_info_idtbl_material_info`=? AND `tbl_grn_quality`.`status`=?";
        $qualityrespond=$this->db->query($qualitysql, array($recordID, $materialid, 1));
		


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
            			vertical-align: top;
            		}

            		.tg .tg-0lax {
            			text-align: left;
            			vertical-align: top;
            		}
            	</style>
            </head>

            <body>
            	<table style="width:100%; border: 2px solid;">
            		<tr>
            			<td>
            				<img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt=""
            					style="width: 180px; height: 120px; color:#000;">
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
            	<table style="width:100%; border: 1px solid;">
            		<tr>
            			<td style="background-color:#000; color:#fff; text-align: center; width:40%;">
            				<h2 style="font-size:15px;">INCOMING QUALITY INSPECTION</h2>
            			</td>
            			<td style="background-color:#fff; color:#000; text-align: center; width:60%;">
            				<h2 style="font-size:15px; padding-right:150px">MATERIAL TYPE:
            					<span>Raw Material</span></h2>
            			</td>
            		</tr>
            	</table>
            	<div class="container">
            		<table style="width:100%; padding-top:0px; border-collapse: collapse;">
            			<tr>
            				<td
            					style="border-left: 1px solid black; font-size:15px; padding-left:20px; padding-top:10px;">
            					SUPPLIER NAME :</td>
            				<td style="border-bottom: 1px solid; padding-right:10px; width: 200px; padding-top:10px;">
            					'.$respondgrn->row(0)->suppliername.'</td>
            				<td></td>
            				<td style="font-size:15px; padding-left:20px; padding-top:10px;">GRN NO :</td>
            				<td style="border-bottom: 1px solid; padding-right:40px; width: 100px; padding-top:10px;">
            					'.$respondgrn->row(0)->idtbl_grn.'
            				</td>
            				<td style="border-right: 1px solid black;"></td>
            			</tr>
            		</table>
            		<table style="width:100%; border-collapse: collapse;">
            			<tr>
            				<td
            					style="border-left: 1px solid black; font-size:15px; padding-left: 20px; padding-top:15px;">
            					SUPPLIER CODE :</td>
            				<td style="border-bottom: 1px solid; padding-right:-20px; width: 200px;  padding-top:15px;">
            					'.$respondgrn->row(0)->suppliercode.'</td>
            				<td></td>
            				<td style="font-size:15px; padding-left:30px;  padding-top:15px;">GRN DATE :</td>
            				<td
            					style="border-bottom: 1px solid; border-bottom-width: 1px; width: 150px;  padding-top:15px;">
            					'.$respondgrn->row(0)->grndate.'
            				</td>
            				<td style="border-right: 1px solid black;"></td>
            			</tr>
            		</table>
            		<table style="width:100%; border-collapse: collapse;">
            			<tr>
            				<td
            					style="border-left: 1px solid black; font-size:15px; padding-left: 20px;  padding-top:15px;">
            					ITEM CODE :</td>
            				<td style="border-bottom: 1px solid; width: 76%;  padding-top:15px;">
            					'.$respondgrn->row(0)->materialinfocode.'</td>
            				<td style="border-right: 1px solid black;"></td>
            			</tr>
            		</table>
            		<table style="width:100%; border-collapse: collapse;">
            			<tr>
            				<td
            					style="border-left: 1px solid black; font-size:15px; padding-left: 20px;  padding-top:15px; padding-bottom:15px;">
            					ITEM DESCRIPTION :</td>
            				<td style="width: 62%;  padding-top:15px; padding-bottom:15px;">
            					'.$respondgrn->row(0)->comment.'</td>
            				<td style="border-right: 1px solid black;"></td>
            			</tr>
            		</table>
            		<div class="form-row">
            			<table style="width:100%; border: 1px solid">
            				<tr>
            					<td style="background-color:#A2A2A0; color:#000; text-align: center;">
            						<h2 style="font-size:15px;">QUALITY PARAMETERS
            						</h2>
            					</td>
            				</tr>
            			</table>
            			<table style="width: 100%; border-collapse: collapse;">
            				<tr>
            					<td style="font-size:15px; border: 1px solid black; width: 40%; text-align: right;">
            						RECEIVED QUANTITY:
            					</td>
            					<td style="border: 1px solid black; width: 10%; text-align: center;">
            						'.$respondgrn->row(0)->qty.'</td>
            					<td style="font-size:15px; border: 1px solid black; width: 40%; text-align: right;">
            						EXAMINED QTY:</td>
            					<td style="border: 1px solid black; width: 10%; text-align: center;">
            						'.$qualityrespond->row(0)->examined_qty.'</td>
            				</tr>
            			</table>
            			<table style="width: 100%; border-collapse: collapse;">
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
            						MOISTURE LEVEL% :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->moisture_level.'
            					</td>
            				</tr>
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
            						ADULTERING :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->adultering.'
            					</td>
            				</tr>
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
            						FUNGI & PEST :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->fungi_pest.'
            					</td>
            				</tr>
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
            						COLOR CONFIRMITY :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->color_confirmity.'
            					</td>
            				</tr>
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
            						GRADE :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->grade.'
            					</td>
            				</tr>
            				<tr>
            					<td
            						style="font-size:15px; border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; width: 40%; text-align: right;">
            						SIZE :</td>
            					<td
            						style="text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
            						'.$qualityrespond->row(0)->size.'
            					</td>
            				</tr>
            			</table>
						<table style="width: 100%; border-collapse: collapse;">
							<tr>
								<td style="border-left: 1px solid black; border-bottom: 1px solid black; width:38%"></td>
								<td
									style="font-size:10px; border-bottom: 1px solid black; width: 12.7%; text-align: center; padding-top:5px; padding-bottom:5px;">
									<table style="border-collapse: collapse; border: 1px solid black;">
										<tr>
											<td style="font-size:15px; border: 1px solid black;  background-color:#A2A2A0; color:#000;">
												STATUS
											</td>
										</tr>
										<tr>
											<td style="font-size:15px; border: 1px solid black; text-align:center;">
												'.$qualityrespond->row(0)->descstatus.'
											</td>
										</tr>
									</table>

								</td>
								<td style="border-bottom: 1px solid black; width:25%"></td>
								<td
									style="font-size:15px; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 50%;">
									COMMENTS :'.$qualityrespond->row(0)->comments.'
								</td>
							</tr>
						</table>
            		</div>
            	</div>
            </body>

            </html>';

        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));
    }
}