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

		$po_number = "TRFL/PO-" . $grn_data->idtbl_porder;
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
		<html>
		<head>
			<meta charset="UTF-8">
			<title>Goods Receiving Notes - Transfood Lanka</title>
			<style>
				body {
					font-family: Arial, sans-serif;
					font-size: 12px;
					margin: 20px;
				}
				.header {
					display: flex;
					justify-content: space-between;
					align-items: flex-start;
					border-bottom: 2px solid #000;
					padding-bottom: 10px;
				}
				.logo {
					width: 120px;
					filter: grayscale(100%);
				}
				.company-section {
					display: flex;
					align-items: flex-start;
				}
				.company-info {
					margin-left: 140px;
				}
				.company-info h2 {
					margin: 0;
					font-size: 18px;
				}
				.company-info p {
					margin: 2px 0;
					font-size: 12px;
				}
				.title {
					font-weight: bold;
					font-size: 18px;
					text-align: right;
				}
				.checkbox-group {
					display: flex;
					gap: 20px;
					margin-top: 5px;
				}
				.checkbox-group span {
					display: flex;
					align-items: center;
				}
				.checkbox {
					width: 10px;
					height: 10px;
					border: 1px solid #000;
					margin-left: 5px;
				}
				table.item-table {
					width: 100%;
					border-collapse: collapse;
					margin-top: 10px;
					font-size: 12px;
				}
				table.item-table th,
				table.item-table td {
					border: 1px solid #000;
					padding: 4px;
					text-align: center;
				}
				table.item-table th {
					background: #000;
					color: #fff;
				}
				.total-row td {
					font-weight: bold;
				}
				.footer {
					margin-top: 20px;
				}
			</style>
		</head>
		<body>
			<div class="header">
				<div class="company-section">
					<div class="logo">
						<img src="'.base_url().'images/logobw.png" width="130">
					</div>
					<div class="company-info">
						<h2>TRANSFOOD LANKA (PVT) LTD.</h2>
						<p>No. 58/E, Majeediya Estate, Gothatuwa, Sri Lanka.</p>
						<p>T/F: +94 11 2534411 E: tflankasp@gmail.com</p>
					</div>
				</div>
				<div class="title">
					GOODS RECEIVING NOTES
				</div>
			</div>
			<table style="width:100%; border-collapse:collapse; margin-top:-80px; font-family:Arial, sans-serif; font-size:12px;">
				<tr>
					<td style="width:12%; padding:4px; font-weight:bold; vertical-align:top; white-space:nowrap;">Supplier</td>
					<td style="width:2%; white-space:nowrap;">:</td>
					<td style="width:40%; border-bottom:1px solid #000;">'.htmlspecialchars($grn_data->suppliername).'</td>
					<td style="width:12%; padding:4px; font-weight:bold; vertical-align:top; white-space:nowrap;">&nbsp;Date</td>
					<td style="width:2%; white-space:nowrap;">:</td>
					<td style="width:30%; border-bottom:1px solid #000;">'.$grn_date.'</td>
				</tr>
				<tr>
					<td style="padding:4px; font-weight:bold; vertical-align:top; white-space:nowrap;">PO Number</td>
					<td style="white-space:nowrap;">:</td>
					<td style="border-bottom:1px solid #000;">'.$po_number.'</td>
					<td style="padding:4px; font-weight:bold; vertical-align:top; white-space:nowrap;">&nbsp;DO Number</td>
					<td style="white-space:nowrap;">:</td>
					<td style="border-bottom:1px solid #000;">'.$grn_data->dispatchnum.'</td>
				</tr>
				<tr>
					<td style="padding: 20px 4px; font-weight:bold; vertical-align:top; white-space:nowrap;">Charging Details</td>
					<td style="white-space:nowrap;">:</td>
					<td style="padding:4px 0; white-space:nowrap;">
						<label style="margin-right:15px;">Full Order <input type="checkbox" name="option1" style="margin-top:5px;" '.($grn_data->grntype == 'full' ? 'checked' : '').'></label>
						<label style="margin-right:15px;">Partial Order <input type="checkbox" name="option1" style="margin-top:5px;" '.($grn_data->grntype == 'partial' ? 'checked' : '').'></label>
						<label>DO Attached <input type="checkbox" name="option1" style="margin-top:5px;" '.($grn_data->dispatchnum ? 'checked' : '').'></label>
					</td>
					<td style="padding: 20px 4px; font-weight:bold; vertical-align:top; white-space:nowrap;">&nbsp;Invoice No</td>
					<td style="white-space:nowrap;">:</td>
					<td style="border-bottom:1px solid #000; white-space:nowrap; padding-left:4px; padding-right:4px;">'.$grn_data->invoicenum.'</td>
				</tr>
			</table>
			<table class="item-table" style="border-collapse: collapse; width: 100%;">
				<thead>
					<tr>
						<th style="border: 1px solid black; padding: 8px;">SL#</th>
						<th style="border: 1px solid black; padding: 8px;">ITEM DESCRIPTION</th>
						<th style="border: 1px solid black; padding: 8px;">COMMENT</th>
						<th style="border: 1px solid black; padding: 8px;">UNIT</th>
						<th style="border: 1px solid black; padding: 8px;"># CTN.</th>
						<th style="border: 1px solid black; padding: 8px;">QTY</th>
					</tr>
				</thead>
				<tbody>
					'.$items_html.'
					<tr class="total-row">
						<td colspan="3" style="border: 1px solid black; border-left: none; border-bottom: none; padding: 8px; text-align:right;">TOTAL</td>
						<td style="border: 1px solid black; padding: 8px;"></td>
						<td style="border: 1px solid black; padding: 8px;">'.$total_ctn.'</td>
						<td style="border: 1px solid black; padding: 8px;">'.$total_qty.'</td>
					</tr>
				</tbody>
			</table>

			<div class="footer">
				Received By : __________________________ <br><br>
				Remark      : '.$total_qty.'
			</div>
		</body>
		</html>';

		$this->load->library('pdf');
		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream("GOODS RECEIVING NOTE-".$grn_data->grn_no.".pdf", array("Attachment"=>0));
	}

}
