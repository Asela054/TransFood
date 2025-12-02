<?php
class Invoiceviewreportinfo extends CI_Model{
    public function printreport($x){

		$companyid=$_SESSION['companyid'];

		function numberToWords($number) {
			$dictionary = array(
				0                   => 'zero',
				1                   => 'one',
				2                   => 'two',
				3                   => 'three',
				4                   => 'four',
				5                   => 'five',
				6                   => 'six',
				7                   => 'seven',
				8                   => 'eight',
				9                   => 'nine',
				10                  => 'ten',
				11                  => 'eleven',
				12                  => 'twelve',
				13                  => 'thirteen',
				14                  => 'fourteen',
				15                  => 'fifteen',
				16                  => 'sixteen',
				17                  => 'seventeen',
				18                  => 'eighteen',
				19                  => 'nineteen',
				20                  => 'twenty',
				30                  => 'thirty',
				40                  => 'forty',
				50                  => 'fifty',
				60                  => 'sixty',
				70                  => 'seventy',
				80                  => 'eighty',
				90                  => 'ninety',
				100                 => 'hundred',
				1000                => 'thousand',
				1000000             => 'million',
				1000000000          => 'billion'
			);
		
			if (!is_numeric($number)) {
				return false;
			}
		
			if ($number < 0) {
				return 'negative ' . numberToWords(abs($number));
			}
		
			$string = '';
			$number = number_format($number, 2, '.', '');
			$parts = explode('.', $number);
			$integerPart = intval($parts[0]);
			$decimalPart = isset($parts[1]) ? intval($parts[1]) : 0;
		
			if ($integerPart > 0) {
				$string .= convertNumberToWords($integerPart, $dictionary);
			} else {
				$string .= 'zero';
			}
		
			if ($decimalPart > 0) {
				$string .= ' point ' . convertNumberToWords($decimalPart, $dictionary);
			}
		
			return $string;
		}
		
		function convertNumberToWords($number, $dictionary) {
			$string = '';
		
			if ($number < 20) {
				$string .= $dictionary[$number];
			} elseif ($number < 100) {
				$string .= $dictionary[intval($number / 10) * 10];
				$string .= $number % 10 ? '-' . $dictionary[$number % 10] : '';
			} elseif ($number < 1000) {
				$string .= $dictionary[intval($number / 100)] . ' hundred';
				$string .= $number % 100 ? ' and ' . convertNumberToWords($number % 100, $dictionary) : '';
			} elseif ($number < 1000000) {
				$string .= convertNumberToWords(intval($number / 1000), $dictionary) . ' thousand';
				$string .= $number % 1000 ? ' ' . convertNumberToWords($number % 1000, $dictionary) : '';
			} elseif ($number < 1000000000) {
				$string .= convertNumberToWords(intval($number / 1000000), $dictionary) . ' million';
				$string .= $number % 1000000 ? ' ' . convertNumberToWords($number % 1000000, $dictionary) : '';
			} else {
				$string .= convertNumberToWords(intval($number / 1000000000), $dictionary) . ' billion';
				$string .= $number % 1000000000 ? ' ' . convertNumberToWords($number % 1000000000, $dictionary) : '';
			}
		
			return $string;
		}
		
		

        $recordID=$x;


        $tblinvoice='';

        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`, `tbl_product`.`prodcutname`, `tbl_product`.`weight`,`tbl_customer_porder_detail`.`unitprice`
        FROM `tbl_invoice_detail`
        LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice`.`idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=? GROUP BY `tbl_invoice_detail`.`idtbl_invoice_detail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $sqlcus = "SELECT `u`.`idtbl_invoice`, `u`.`invno`, `u`.`invdate`, `ud`.`name`, `ud`.`customercode` AS customercode, `ud`.`address` AS cusaddress, `ud`.`contact`, `ud`.`email` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_detail` AS `ua` ON `ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice` LEFT JOIN `tbl_product` AS `ub` ON `ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product` LEFT JOIN `tbl_customer_porder` AS `uc` ON `uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` AS `ud` ON `ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer` LEFT JOIN `tbl_location` AS `ue` ON `ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
    	$respondsus = $this->db->query($sqlcus, array($recordID));

        $sqlbank = "SELECT `ua`.`account_name`, `ua`.`account_no`, `ua`.`bank_name`, `ua`.`bank_branch`, `ua`.`swift_code`, `ua`.`branch_code`, `ua`.`bank_code` FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_bank` AS `ua` ON `ua`.`idtbl_invoice_bank` = `u`.`tbl_invoice_bank_idtbl_invoice_bank` WHERE `u`.`idtbl_invoice`=? GROUP BY  `u`.`idtbl_invoice`";
    	$respondbank = $this->db->query($sqlbank, array($recordID));

		$sqltotal="SELECT `grosstotal` AS total, SUM(`qty`) AS qty, `discount` AS discount, `nettotal` AS nettotal FROM `tbl_invoice_detail` LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice` WHERE `tbl_invoice_idtbl_invoice`=?";
		$respondtotal = $this->db->query($sqltotal, array($recordID));
		
		$row2 = $respondtotal->row();
		$qty = $row2->qty;

		$total = floatval(number_format($row2->total, 2, '.', ''));
		$discount = floatval(number_format($row2->discount, 2, '.', ''));
		$nettotal = floatval(number_format($row2->nettotal, 2, '.', ''));
		$amountInWords = numberToWords($total);
    
    if ($respondsus->num_rows() > 0) {
        $row = $respondsus->row();
        $cusname = $row->name;
        $cusaddress = $row->cusaddress;
		$customercode = $row->customercode;
        $contact = $row->contact;
        $email = $row->email;
        $invdate = $row->invdate;
        $invid = $row->idtbl_invoice;
		$invno = $row->invno;
    }
	if ($respondbank->num_rows() > 0) {
        $row = $respondbank->row();
        $accname = $row->account_name;
        $accnum = $row->account_no;
        $bank = $row->bank_name;
        $branch = $row->bank_branch;
        $swiftcode = $row->swift_code;
        $branchcode = $row->branch_code;
		$bankcode = $row->bank_code;
    }
    $i=1;
	$rowCount = 0;
	$pageLimit = 14;

	foreach($respond->result() as $rowlist){
		if ($rowCount % $pageLimit == 0 && $rowCount > 0) {
			$tblinvoice .= '</tbody></table><div style="page-break-after: always;"></div><table width="100%" style="border-collapse: collapse; margin: 0 auto;">
				<thead>
					
			<tr>
				<th style="text-align: center; width:8%; border: thin 1px solid;" scope="col">SN</th>
				<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Item Code</th>
				<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Item</th>
				<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Unit</th>
				<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">No. of Pks Per carton</th>
				<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">No of MC</th>
				<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">Qty</th>
				<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">Unit Price $ FOB</th>
				<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">Price Per MCT FOB $</th>
				<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">TOTAL VALUE FOB $</th>
			</tr>
				</thead>
				<tbody>';
		}

		$tblinvoice .= '
			<tr>			
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$i++.'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$rowlist->productcode.'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$rowlist->prodcutname.'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.number_format($rowlist->saleprice, 2).'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;"></td>
				<td style="text-align: right; border: thin 1px solid;padding:5px;"></td>
				<td style="text-align: right; border: thin 1px solid;padding:5px;">'.$rowlist->qty.'</td>
				<td style="text-align: right; border: thin 1px solid;padding:5px;">'.number_format($rowlist->total, 2).'</td>
				<td style="text-align: right; border: thin 1px solid;padding:5px;">'.number_format($rowlist->total, 2).'</td>
				<td style="text-align: right; border: thin 1px solid;padding:5px;">'.number_format($rowlist->total, 2).'</td>
			</tr>';
		
		$rowCount++;
	} 
		$html='
		<html>
			<head>
				<style>
					/** Define the margins of your page **/
					@page {
						margin: 100px 50px 50px 50px;
						font-family: Arial, sans-serif;
					}

					body {
						margin: 0;
						padding: 0;
					}

					header {
						position: fixed;
						top: -80px;
						left: 50px;
						right: 50px;
						height: 80px;
					}

					main {
						margin: 0 auto;
						width: 100%;
					}

					.invoice-container {
						width: 100%;
						margin: 0 auto;
					}

					.center-table {
						margin: 0 auto;
						width: 100%;
					}
				</style>
			</head>
			<body>
				<!-- Define header and footer blocks before your content -->
				<header>
					<table style="width:100%;border-collapse: collapse;">
						<tr>
							<td style="text-align: right;"><img src="'.base_url().'images/logo.png" style="width: 140px; height: 80px; margin-right: 20px;"></td>
							<td style="font-size: 12px;">
								<h3 style="color: #FF0000;font-size: 25px;font-weight: bold;margin: 0;">Transfood Lanka (Pvt) Ltd.</h3>
								17/A, Vihara Mawatha, Katunayake, Sri Lanka<br>
								Tel/Fax: +94 11-2254441 Email: info@tflanka.com<br>
								www.transfoodlanka.com or www.tflanka.com
							</td>
						</tr>
					</table>
				</header>
				<hr>
				<main>
					<div class="invoice-container">
						<table width="100%" style="margin-bottom: 10px;">
							<tr>
								<td colspan="2" style="text-align: center;"><h3 style="margin: 0;padding: 10px 0; text-decoration: underline;">COMMERCIAL INVOICE</h3></td>
							</tr>
						</table>
						
						<table width="100%" style="margin-bottom: 20px;">
							<tr>
								<td width="50%" style="vertical-align: top;">
									<table style="width: 100%; font-size: 14px;">
										<tr>
											<th style="text-align: left;vertical-align: top;">INVOICE DATE</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;">'.$invdate.'</td>
										</tr>
										<tr>
											<th style="text-align: left;vertical-align: top;">B/L NO.</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;"></td>
										</tr>
										<tr>
											<th style="text-align: left;vertical-align: top;">CUSTOMER</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;">'.$cusname.'</td>
										</tr>
									</table>
								</td>
								<td width="50%" style="vertical-align: top;">
									<table style="width: 100%; font-size: 14px;">
										<tr>
											<th style="text-align: left;vertical-align: top;">YOUR REF</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;"></td>
										</tr>
										<tr>
											<th style="text-align: left;vertical-align: top;">CON NO</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;"></td>
										</tr>
										<tr>
											<th style="text-align: left;vertical-align: top;">INV REF</th>
											<td style="text-align: left;vertical-align: top;">:</td>
											<td style="vertical-align: top;"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
						<table class="center-table" style="border-collapse: collapse; margin: 20px auto; width: 100%; font-size: 12px;">
							<thead>						
								<tr>
									<th style="text-align: center; width:8%; border: thin 1px solid;" scope="col">SN</th>
									<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Item Code</th>
									<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Item</th>
									<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">Unit</th>
									<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">No. of Pks Per carton</th>
									<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">No of MC</th>
									<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">Qty</th>
									<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">Unit Price $ FOB</th>
									<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">Price Per MCT FOB $</th>
									<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">TOTAL VALUE FOB $</th>
								</tr>
							</thead>
							<tbody>'.$tblinvoice.'</tbody>
							<tfoot>
								<tr>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;">TOTAL</td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;"></td>
								<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;">'.number_format($total, 2).'</td>
								</tr>
								<tr>
									<td colspan="9" style="text-align: left; border: thin 1px solid; padding: 8px; font-weight: bold;">FREIGHT</td>
									<td style="text-align: right; border: thin 1px solid; padding: 8px;">0.00</td>
								</tr>
								<tr>
									<td colspan="9" style="text-align: left; border: thin 1px solid; padding: 8px; font-weight: bold;">GRAND TOTAL</td>
									<td style="text-align: right; border: thin 1px solid; padding: 8px; font-weight: bold;">'.number_format($nettotal, 2).'</td>
								</tr>
							</tfoot>
						</table>
						
						<table width="100%" style="margin-top: 20px;">
							<tr>
								<td colspan="2"><h4 style="margin-top:5px;font-weight: normal;font-size: 10px;">REX - GSP NOTE:</h4></td>
							</tr>
							<tr>
								<td colspan="2"><h4 style="margin-top:5px;font-weight: normal;font-size: 10px;"><span>The Exporter LKREX174928061DC0556, of the products covered by this document declare that, except
								where otherwise clearly indicated, these products are of SRI LANKA preferential origin according
								to rules of origin of the Generalized System of Preferences of the Europen Union and that the origin
								criterion met is "P".</span></td>
							</tr>
						</table>
					</div>
				</main>
			</body>
		</html>
		';
	
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));

    }

}