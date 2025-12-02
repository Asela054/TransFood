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

        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_product`.`weight`,`tbl_customer_porder_detail`.`unitprice`
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
			$tblinvoice .= '</table><div style="page-break-after: always;"></div><table width="100%" style="border-collapse: collapse;">
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>';
		}

		$tblinvoice .= '
			<tr>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$i++.'</td>
				<td style="border: thin 1px solid;padding:5px;">'.$rowlist->desc.'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$rowlist->weight.'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.number_format($rowlist->saleprice, 2).'</td>
				<td style="text-align: center; border: thin 1px solid;padding:5px;">'.$rowlist->qty.'</td>
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
						margin: 130px 25px;
						font-family: Arial, sans-serif;
					}

					header {
						position: fixed;
						top: -130px;
						left: 0px;
						right: 0px;
						height: 50px;
					}

					footer {
						position: fixed; 
						bottom: 0px; 
						left: 0px; 
						right: 0px;
						height: 20px; 
					}
				</style>
			</head>
			<body>
				<main>
					<table width="100%" style="border-collapse: collapse;">
						<tr>
							<td colspan="8" style="text-align: center; padding: 20px 0;">
								<h1 style="margin: 0;">COMMERCIAL INVOICE</h1>
							</td>
						</tr>
						
						<!-- Company Info Header -->
						<tr>
							<td colspan="8" style="padding: 10px 0; border-bottom: 1px solid #000;">
								<table width="100%">
									<tr>
										<td style="font-weight: bold; font-size: 16px;">Transfood Lanka (Pvt) Ltd.</td>
										<td style="text-align: right; font-size: 12px;">Invoice No: ';
											$prefix = "UNKNOWN";
											if ($companyid == 1) {
												$prefix = "UN/INV";
											} else if ($companyid == 2) {
												$prefix = "UF/INV";
											}
											$html .= $prefix . "/DT-000" . $invno;
										$html .= '</td>
									</tr>
									<tr>
										<td style="font-size: 12px;">The UK\'s exported farm, distribution, and new food products are available in our own market.</td>
										<td style="text-align: right; font-size: 12px;">Date: '.$invdate.'</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<!-- Customer Details -->
						<tr>
							<td colspan="8" style="padding: 15px 0;">
								<table width="100%">
									<tr>
										<td width="50%" style="vertical-align: top;">
											<table style="font-size: 12px;">
												<tr>
													<th style="text-align: left; padding: 5px 0;">Customer:</th>
													<td style="padding: 5px 10px;">'.$cusname.'</td>
												</tr>
												<tr>
													<th style="text-align: left; padding: 5px 0;">Address:</th>
													<td style="padding: 5px 10px;">'.$cusaddress.'</td>
												</tr>
												<tr>
													<th style="text-align: left; padding: 5px 0;">Customer Code:</th>
													<td style="padding: 5px 10px;">'.$customercode.'</td>
												</tr>
											</table>
										</td>
										<td width="50%" style="vertical-align: top;">
											<table style="font-size: 12px;">
												<tr>
													<th style="text-align: left; padding: 5px 0;">Contact:</th>
													<td style="padding: 5px 10px;">'.$contact.'</td>
												</tr>
												<tr>
													<th style="text-align: left; padding: 5px 0;">Email:</th>
													<td style="padding: 5px 10px;">'.$email.'</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<!-- Main Invoice Table Header -->
						<tr>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 5%;">#</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 25%;">Item Description</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 10%;">Pack Weight</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 10%;">Unit Price</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 10%;">Qty</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 10%;">Amount</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 15%;">Delivery Date</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px; font-weight: bold; width: 15%;">Remarks</td>
						</tr>
						
						<!-- Invoice Items -->
						'.$tblinvoice.'
						
						<!-- Empty rows for alignment with image -->
						<tr>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
							<td style="border: 1px solid #000; text-align: center; padding: 10px;">&nbsp;</td>
						</tr>
						
						<!-- Totals Section -->
						<tr>
							<td colspan="4" style="border: 1px solid #000; padding: 10px;">
								<strong>Amount in words:</strong><br>
								<span style="text-transform: capitalize;">'.$amountInWords.' only</span>
							</td>
							<td colspan="2" style="border: 1px solid #000; text-align: right; padding: 10px;">
								<strong>Sub Total:</strong>
							</td>
							<td colspan="2" style="border: 1px solid #000; text-align: right; padding: 10px;">
								'.number_format($total, 2).'
							</td>
						</tr>
						<tr>
							<td colspan="6" style="border: 1px solid #000; padding: 10px;">
								<strong>Special Notes:</strong>
							</td>
							<td colspan="2" style="border: 1px solid #000; text-align: right; padding: 10px;">
								'.number_format($nettotal, 2).'
							</td>
						</tr>
						<tr>
							<td colspan="6" rowspan="3" style="border: 1px solid #000; padding: 10px; vertical-align: top;">
								<strong>Bank Details:</strong><br>
								Account Name: '.$accname.'<br>
								Account No: '.$accnum.'<br>
								Bank: '.$bank.'<br>
								Branch: '.$branch.'<br>
								SWIFT: '.$swiftcode.'
							</td>
							<td colspan="2" style="border: 1px solid #000; text-align: right; padding: 10px;">
								<strong>Grand Total:</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border: 1px solid #000; text-align: right; padding: 10px; font-weight: bold; font-size: 16px;">
								'.number_format($nettotal, 2).'
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border: 1px solid #000; padding: 10px;">
								<strong>Currency:</strong> LKR
							</td>
						</tr>
						
						<!-- Signatures -->
						<tr>
							<td colspan="8" style="padding: 30px 0;">
								<table width="100%">
									<tr>
										<td width="25%" style="text-align: center;">
											<p style="border-top: 1px solid #000; padding-top: 5px;">Prepared By</p>
										</td>
										<td width="25%" style="text-align: center;">
											<p style="border-top: 1px solid #000; padding-top: 5px;">Approved By</p>
										</td>
										<td width="25%" style="text-align: center;">
											<p style="border-top: 1px solid #000; padding-top: 5px;">Checked By</p>
										</td>
										<td width="25%" style="text-align: center;">
											<p style="border-top: 1px solid #000; padding-top: 5px;">Received By</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
						<!-- Footer Note -->
						<tr>
							<td colspan="8" style="padding: 10px 0; border-top: 1px solid #000; font-size: 11px; text-align: center;">
								<p><strong>RESULTED STEEL</strong></p>
								<p style="font-style: italic;">This includes US$23,000,000 total of the product required by the standard deduction that, except for the case of any other indication, does not include any material misstatement or error.</p>
							</td>
						</tr>
					</table>
				</main>
			</body>
		</html>
';
	}
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));

    }

}
