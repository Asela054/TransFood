<?php
class GoodreceivePrintinfo extends CI_Model{

	public function Printgoodreceive($x) {
		$recordID = $x;

		$grn_sql = "SELECT g.*, s.suppliername, p.idtbl_porder, p.po_no 
					FROM tbl_grn g
					LEFT JOIN tbl_supplier s ON s.idtbl_supplier = g.tbl_supplier_idtbl_supplier
					LEFT JOIN tbl_porder p ON p.idtbl_porder = g.tbl_porder_idtbl_porder
					WHERE g.idtbl_grn = ?";
		$grn_data = $this->db->query($grn_sql, [$recordID])->row();

		$po_number = "TRFL/PO-" . $grn_data->po_no;
		$remark = $grn_data->remark;

		$details_sql = "SELECT d.*, m.materialname, m.materialinfocode, u.unitname
					FROM tbl_grndetail d
					LEFT JOIN tbl_material_info m ON m.idtbl_material_info = d.tbl_material_info_idtbl_material_info
					LEFT JOIN tbl_unit u ON u.idtbl_unit = m.tbl_unit_idtbl_unit
					WHERE d.tbl_grn_idtbl_grn = ? AND d.status = 1";
		$details_data = $this->db->query($details_sql, [$recordID])->result();

		$total_ctn = 0;
		$total_qty = 0;
		$items_html = '';
		$sn = 1;

		foreach ($details_data as $row) {
			$total_ctn += $row->ctn;
			$total_qty += $row->qty;
			
			$items_html .= '<tr>
				<td style="border: 1px solid black; padding: 8px;">'.$sn.'</td>
				<td style="border: 1px solid black; padding: 8px;">'.$row->materialname.' ('.$row->materialinfocode.')</td>
				<td style="border: 1px solid black; padding: 8px;">'.$row->comment.'</td>
				<td style="border: 1px solid black; padding: 8px;">'.$row->unitname.'</td>
				<td style="border: 1px solid black; padding: 8px;">'.$row->ctn.'</td>
				<td style="border: 1px solid black; padding: 8px;">'.$row->qty.'</td>
			</tr>';
			$sn++;
		}

		$grn_date = $grn_data->grndate ? date('d/m/Y', strtotime($grn_data->grndate)) : '';
		$po_date = $grn_data->podate ? date('d/m/Y', strtotime($grn_data->podate)) : '';

		$html = '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Goods Receiving Notes - Transfood Lanka</title>
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
					<td colspan="3" style="border:1px solid #000;font-size:16px;font-weight:bold;letter-spacing:2px;text-align:center;">GOODS RECEIVING NOTES</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td style="vertical-align:top;">
						<table style="width:100%;border-collapse:collapse;">
							<tr>
								<th style="border:1px solid #000;background-color:#97d197;text-align:center;">SUPPLIER</th>
							</tr>
							<tr>
								<td style="border:1px solid #000;text-align:center;padding:4px;">'.htmlspecialchars($grn_data->suppliername).'</td>
							</tr>
						</table>
					</td>
					<td width="20%"></td>
					<td style="text-align:right;">
						<table style="border-collapse:collapse;width:100%;text-align:center;">
							<tr>
								<td style="width:25%;background-color:#97d197;border:1px solid #000;font-weight:bold;">GRN NUMBER</td>
								<td style="width:25%;background-color:#97d197;border:1px solid #000;font-weight:bold;">DATE</td>
								<td style="width:25%;background-color:#97d197;border:1px solid #000;font-weight:bold;">PO NUMBER</td>
								<td style="width:25%;background-color:#97d197;border:1px solid #000;font-weight:bold;">DO NUMBER</td>
							</tr>
							<tr>
								<td style="border:1px solid #000;padding:4px;">TRFL/GRN-'.$grn_data->grn_no.'</td>
								<td style="border:1px solid #000;padding:4px;">'.$grn_date.'</td>
								<td style="border:1px solid #000;padding:4px;">'.$po_number.'</td>
								<td style="border:1px solid #000;padding:4px;">'.($grn_data->dispatchnum ? $grn_data->dispatchnum : '&nbsp;').'</td>
							</tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr>
								<td colspan="2" style="background-color:#97d197;border:1px solid #000;font-weight:bold;">INVOICE NO</td>
								<td colspan="2" style="background-color:#97d197;border:1px solid #000;font-weight:bold;">CHARGING DETAILS</td>
							</tr>
							<tr>
								<td colspan="2" style="border:1px solid #000;padding:4px;">'.($grn_data->invoicenum !== null && $grn_data->invoicenum !== '' ? $grn_data->invoicenum : '&nbsp;').'</td>
								<td colspan="2" style="border:1px solid #000;padding:4px;text-align:left;">
									Full Order <input type="checkbox" '.($grn_data->grntype == 'full' ? 'checked' : '').'>&nbsp;&nbsp;
									Partial <input type="checkbox" '.($grn_data->grntype == 'partial' ? 'checked' : '').'>&nbsp;&nbsp;
									DO Attached <input type="checkbox" '.($grn_data->dispatchnum ? 'checked' : '').'>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr>
					<td colspan="3">
						<table style="border-collapse:collapse;width:100%;">
							<thead>
								<tr>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;">SL#</th>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;">ITEM DESCRIPTION</th>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;">COMMENT</th>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;">UNIT</th>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;"># CTN.</th>
									<th style="background-color:#97d197;border:1px solid #000;text-align:center;padding:6px;">QTY</th>
								</tr>
							</thead>
							<tbody>
								'.$items_html.'
							</tbody>
							<tfoot>
								<tr>
									<td colspan="3" style="border:1px solid #000;background-color:#97d197;text-align:right;padding:6px;font-weight:bold;">TOTAL</td>
									<td style="border:1px solid #000;background-color:#97d197;padding:6px;"></td>
									<td style="border:1px solid #000;background-color:#97d197;text-align:center;padding:6px;font-weight:bold;">'.$total_ctn.'</td>
									<td style="border:1px solid #000;background-color:#97d197;text-align:center;padding:6px;font-weight:bold;">'.$total_qty.'</td>
								</tr>
							</tfoot>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding-top:20px;">
						<table style="width:100%;border-collapse:collapse;">
							<tr>
								<td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;width:20%;">Remark</td>
								<td style="border:1px solid #000;padding:4px;">'.$remark.'</td>
							</tr>
							<tr>
								<td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">Received By</td>
								<td style="border:1px solid #000;padding:4px;height:30px;"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding-top:30px;text-align:center;">
						<div style="width:100%;margin:auto;border-top:1px dotted #000;"></div>
						<div style="margin-top:5px;font-size:10px;">
							For questions concerning this GRN, Please Contact Transfood Lanka (Pvt) Ltd. | info@tflanka.com
						</div>
					</td>
				</tr>
			</table>
		</body>
		</html>';
		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream("GOODS RECEIVING NOTE-".$grn_data->grn_no.".pdf", array("Attachment"=>0));
	}

}