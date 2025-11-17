<?php
class Productionpackingqualityreportinfo extends CI_Model{
    public function Productionpackingqualityreport($x){

        $recordID=$x;

		$html = '';

        $updatesql="SELECT IFNULL(`tblel`.`ds`, `tbl_packing_quality`.`statuspassfail`) As descstatus, IFNULL(`tblel1`.`cs`, `tbl_packing_quality`.`seal`) As descstatus1, IFNULL(`tblel2`.`es`, `tbl_packing_quality`.`water_leakages`) As descstatus2, `idtbl_packing_quality`, `examined_quantity`, `net_weight`, `gross_weight`, `moisture`, `color`, `taste`, `seal`, `water_leakages`, `statuspassfail`, `comments`, `productcode` FROM `tbl_packing_quality` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_packing_quality`.`tbl_product_idtbl_product` LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_packing_quality`.`statuspassfail`=`tblel`.`type`) LEFT JOIN(SELECT 1 AS type, 'YES' AS cs, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS cs, 2 As el) As tblel1 ON (`tbl_packing_quality`.`seal`=`tblel1`.`type`) LEFT JOIN(SELECT 1 AS type, 'YES' AS es, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS es, 2 As el) As tblel2 ON (`tbl_packing_quality`.`water_leakages`=`tblel2`.`type`) WHERE `tbl_packing_quality`.`tbl_production_order_idtbl_production_order`=? AND `tbl_packing_quality`.`status`=?";

        $updaterespond=$this->db->query($updatesql, array($recordID, 1));

		$sqlqty="SELECT `qty` FROM `tbl_packing_quality` LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order`=`tbl_packing_quality`.`tbl_production_order_idtbl_production_order` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` WHERE `tbl_production_order`.`idtbl_production_order`=?";
        $respondqty=$this->db->query($sqlqty, array($recordID));

		$sqlmaterial = "SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`
        FROM `tbl_product`
        LEFT JOIN `tbl_production_orderdetail` ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product`
        LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
        WHERE `tbl_product`.`status` = ? AND `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` = ?";

            $stmt = $this->db->query($sqlmaterial, array(1, $recordID));

            if ($stmt->num_rows() > 0) {
            $respondmaterial = $stmt->row();
            $productid = $respondmaterial->idtbl_product;
            } else {
            $productid = null;
            }

		$sqlbommaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondbommaterial=$this->db->query($sqlbommaterial, array($productid, 1, 1));

        $sqlpackmaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondpackmaterial=$this->db->query($sqlpackmaterial, array($productid, 1, 2));

        $sqllabelmaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondlabelmaterial=$this->db->query($sqllabelmaterial, array($productid, 1, 3));
		


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
						<td style=" background-color:#000; color:#fff; width=50%">
							<h2 style="font-size:15px; text-align:center;">FINISH GOODS QUALITY INSPECTION</h2>
						</td>
					</tr>
				</table>
				<div class="container">
					<table style="width:100%; padding-top:0px; border-collapse: collapse;">
						<tr>
							<td
								style="border-left: 1px solid black; font-size:11px; padding-left:20px; padding-top:10px; width: 32%;">
								PACKING ORDER NO :
							</td>
							<td style="font-size:11px; border-bottom: 1px solid; padding-right:10px; width: 37%; padding-top:10px;"></td>
							<td style="font-size:11px; padding-left:20px; padding-top:10px; width: 30%;">SALES ORDER NO :</td>
							<td style="border-bottom: 1px solid; padding-right:20px; width: 40%; padding-top:10px;"></td>
							<td style="border-right: 1px solid black; width: 9%"></td>
						</tr>
					</table>
					<table style="width:100%; border-collapse: collapse;">
						<tr>
							<td
								style="border-left: 1px solid black; font-size:11px; padding-left: 20px; padding-top:15px; width: 50%;">
								PACKING START DATE :
							</td>
							<td style="font-size:11px; border-bottom: 1px solid; padding-right:-20px; width: 50%; padding-top:15px;"></td>
							<td style="font-size:11px; padding-left:30px;  padding-top:15px; width: 65%;">PACKING END DATE :
							</td>
							<td style="font-size:11px; border-bottom: 1px solid; width: 60%; padding-top:15px;"></td>
							<td style="border-right: 1px solid black; width: 15%"></td>
						</tr>
					</table>
					<table style="width:100%; border-collapse: collapse;">
						<tr>
							<td
								style="border-left: 1px solid black; font-size:11px; padding-left: 20px;  padding-top:15px; width: 15%;">
								ITEM CODE :
							</td>
							<td style="font-size:11px; border-bottom: 1px solid; width: 80%;">'.$updaterespond->row(0)->productcode.'</td>
							<td style=" border-right: 1px solid black;"></td>
						</tr>
					</table>

    	';

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
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 41%; text-align: right;">
								ORDER QUANTITY :</td>
							<td
								style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; width: 58.5%;">
								'.$respondqty->row(0)->qty.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 39%; text-align: right;">
								EXAMINED QUANTITY :</td>
							<td style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; width: 60%;">
							'.$updaterespond->row(0)->examined_quantity.'
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
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								NET WEIGHT :</td>
							<td
								style="font-size:10px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$updaterespond->row(0)->net_weight.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
								GROSS WEIGHT :</td>
							<td
								style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$updaterespond->row(0)->gross_weight.'
							</td>
							<td
								style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

							</td>
							<td style="border-right: 1px solid black; width: 2%;"></td>
						</tr>
						';
						foreach ($respondbommaterial->result() as $rowrawmateriallist) {
						$html .= '
						<tr>
							<td style="border-left: 1px solid black; width: 2%;"></td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								RAW MATERIAL :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$rowrawmateriallist->materialinfocode.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 0%; text-align: right;">
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 2%;">
								<img src="'.base_url().'images/check.png" class="img-fluid" alt="" style="width: 15px; height: 10px;">
							</td>
							<td
								style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

							</td>
							<td style="border-right: 1px solid black; width: 2%;"></td>
						</tr>
						';
					}
					foreach ($respondpackmaterial->result() as $rowpackmateriallist) {
					$html.='
						<tr>
							<td style="border-left: 1px solid black; width: 2%;"></td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								PACKING MATERIAL :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$rowpackmateriallist->materialinfocode.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 0%; text-align: right;">
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 10%;"><img src="'.base_url().'images/check.png" class="img-fluid" alt=""
								style="width: 15px; height: 10px;">
							</td>
							<td
								style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

							</td>
							<td style="border-right: 1px solid black; width: 2%;"></td>
						</tr>
						';
					}
					foreach ($respondlabelmaterial->result() as $rowlabelmateriallist) {
					$html.='
						<tr>
							<td style="border-left: 1px solid black; width: 2%;"></td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								LABELLING MATERIAL :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$rowlabelmateriallist->materialinfocode.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 0%; text-align: right;">
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 10%;"><img src="'.base_url().'images/check.png" class="img-fluid" alt=""
								style="width: 15px; height: 10px;">
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
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								MOISTURE % :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">'.$updaterespond->row(0)->moisture.'
							</td>
							<td style="font-size:11px; border-bottom: 1px solid black; width: 40%; text-align: right;"></td>
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
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								COLOR :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">'.$updaterespond->row(0)->color.'
							</td>
							<td style="font-size:11px; border-bottom: 1px solid black; width: 40%; text-align: right;"></td>
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
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								TASTE :
							</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">'.$updaterespond->row(0)->taste.'
							</td>
							<td style="font-size:11px; border-bottom: 1px solid black; width: 40%; text-align: right;"></td>
							<td
								style="font-size:11px; text-align:center; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
							</td>
							<td
								style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

							</td>
							<td style="border-right: 1px solid black; width: 2%;"></td>
						</tr>
						<tr>
							<td style="border-bottom: 1px solid black; border-left: 1px solid black; width: 2%;"></td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-left: 1px solid black; width: 40%; text-align: right;">
								SEAL :</td>
							<td
								style="font-size:11px; text-align:center; border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$updaterespond->row(0)->descstatus1.'
							</td>
							<td
								style="font-size:11px; border-bottom: 1px solid black; border-right: 1px solid black; width: 40%; text-align: right;">
								WATER LEAKAGES :</td>
							<td
								style="font-size:10px; text-align:center; border-left: 1px solid black; solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 60%;">
								'.$updaterespond->row(0)->descstatus2.'
							</td>
							<td
								style="text-align:center; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 20%;">

							</td>
							<td style="border-right: 1px solid black; border-bottom: 1px solid black; width: 2%;"></td>
						</tr>
					</table>
					<table style="width: 100%; border-collapse: collapse;">
					<tr>
						<td style="border-left: 1px solid black; border-bottom: 1px solid black; width:6%"></td>
						<td
							style="font-size:10px; border-bottom: 1px solid black; width: 8%; text-align: center; padding-top:5px; padding-bottom:5px;">
							<table style="border-collapse: collapse; border: 1px solid black;">
								<tr>
									<td style="font-size:15px; border: 1px solid black;  background-color:#A2A2A0; color:#000;">
										STATUS
									</td>
								</tr>
								<tr>
									<td style="font-size:15px; border: 1px solid black; text-align:center;">
										'.$updaterespond->row(0)->descstatus.'
									</td>
								</tr>
							</table>

						</td>
						<td style="border-bottom: 1px solid black; width:2%"></td>
						<td
							style="font-size:15px; border-right: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black; width: 50%;">
							COMMENTS :'.$updaterespond->row(0)->comments.'
						</td>
					</tr>
				</table>
					</div>

				</div>

			</body>

			</html>
		';

		// echo $html;
		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));

    }
}