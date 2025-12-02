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

	if($recordID>=600){
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
				<!-- Define header and footer blocks before your content -->
				<header>
					<table width="100%" style="border-collapse: collapse;">
						<tr>
							<td width="33.33%" style="vertical-align: top;border-bottom: thin 1px solid; padding-bottom: 5px;"><img src="images/Ch.jpg" style="width: 150px;height: 100px;margin-top: 15px;"></td>
							<td width="33.33%" style="vertical-align: top;border-bottom: thin 1px solid; padding-bottom: 5px;">
								<h4 style="margin-bottom: 0px;"><u>HEAD OFFICE</u></h4>
    							<h6 style="margin-top: 0px;margin-bottom: 0px;">Unistar International Pvt Ltd</h6>
								<table style="font-size: 11px;">
									<tr>
										<th>Address</th>
										<td>-</td>
										<td>53, 3rd Lane, Ratmalana, Sri Lanka</td>
									</tr>
									<tr>
										<th>Tel.</th>
										<td>-</td>
										<td>+94 112635 185</td>
									</tr>
									<tr>
										<th>Mobile</th>
										<td>-</td>
										<td>+94 77 966 2165 / +94 77 888 1631</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>-</td>
										<td>admin@unistar-international.com</td>
									</tr>
								</table>
							</td>
							<td width="33.33%" style="vertical-align: top;border-bottom: thin 1px solid; padding-bottom: 5px;">
								<h4 style="margin-bottom: 0px;"><u>SHOWROOM</u></h4>
    							<h6 style="margin-top: 0px;margin-bottom: 0px;">CEYLONZ HARVEST</h6>
								<table style="font-size: 11px;">
									<tr>
										<th>Address</th>
										<td>-</td>
										<td>63, Jaya Mawatha, Ratmalana</td>
									</tr>
									<tr>
										<th>Tel.</th>
										<td>-</td>
										<td>077 966 2165 / +94 77 888 1631</td>
									</tr>
									<tr>
										<th>Web</th>
										<td>-</td>
										<td>www.admin@unistar-international.com</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</header>

				<footer>
					<table width="100%" style="border-collapse: collapse;">
						<tr>
							<td style="vertical-align: bottom; padding-bottom: 15px; border-top: thin 1px solid; border-bottom: thin 1px solid;">
								<table width="100%" style="font-size: 12px;">
									<tr>
										<td colspan="3"><h3 style="margin-top: 0px;"><u>BANK DETAILS FOR PAYMENT</u></h3></td>
									</tr>
									<tr>
										<td>Name</td>
										<td width="5%">:</td>
										<td width="70%">'.$accname.'</td>
									</tr>
									<tr>
										<td>Account No</td>
										<td width="5%">:</td>
										<td width="70%">'.$accnum.'</td>
									</tr>
									<tr>
										<td>Bank Name</td>
										<td width="5%">:</td>
										<td width="70%">'.$bank.' <b style="margin-left: 15px;">Branch Name - </b> '.$branch.'</td>
									</tr>
									<tr>
										<td>Swift Code</td>
										<td width="5%">:</td>
										<td width="70%">'.$swiftcode.' <b style="margin-left: 15px;">Branch Cd</b> '.$branchcode.' <b style="margin-left: 15px;">Bank Cd</b> '.$bankcode.'</td>
									</tr>
								</table>
							</td>
							<td width="20%" style="vertical-align: top; border-top: thin 1px solid; border-bottom: thin 1px solid;">
								<img src="images/invoicelogo.png" alt="Unistar Image" width="250px">
							</td>
						</tr>
					</table>
				</footer>

				<!-- Wrap the content of your PDF inside a main tag -->
				<main>
					<table width="100%">
						<tr>
							<td colspan="2" style="text-align: center;"><h1 style="margin: 0;padding: 10px 0;">INVOICE</h1></td>
						</tr>
						<tr>
							<td width="50%" style="vertical-align: top;">
								<table style="width: 100%; font-size: 14px;">
									<tr>
										<th style="text-align: left;vertical-align: top;">Invoice Date</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;">'.$invdate.'</td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Invoice No.</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;">';
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
										<th style="text-align: left;vertical-align: top;">Vendor Code</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Purchase Order</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Dispatch Note</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Payment Terms</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Delivery</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
								</table>
							</td>
							<td width="50%" style="vertical-align: top;">
								<table style="width: 100%; font-size: 14px;">
									<tr>
										<th style="text-align: left;vertical-align: top;">Customer</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;">'.$cusname.'</td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Customer Code</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;">'.$customercode.'</td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Address</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;">'.$cusaddress.'</td>
									</tr>
									<tr>
										<th style="text-align: left;vertical-align: top;">Cus. Vat No</th>
										<td style="text-align: left;vertical-align: top;">:</td>
										<td style="vertical-align: top;"></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<table width="100%" style="border-collapse: collapse;margin-top:10px;font-size:14px;">
									<thead>
										<tr>
											<th style="text-align: center; width:8%; border: thin 1px solid;" scope="col">#</th>
											<th style="text-align: center; width:42%; border: thin 1px solid;" scope="col">ITEM DESCRIPTION</th>
											<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">PACK WEIGHT</th>
											<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">UNIT PRICE(LKR)</th>
											<th style="text-align: center; width:10%; border: thin 1px solid;" scope="col">ORDER QUANTITY</th>
											<th style="text-align: center; width:15%; border: thin 1px solid;" scope="col">AMOUNT(LKR)</th>
										</tr>
									</thead>
									<tbody>'.$tblinvoice.'</tbody>
									<tfoot>
										<tr>
											<th colspan="2" style="text-align: left; color: #000;padding:5px; border-left: 1px solid #000; border-bottom: 1px solid #000;">TOTAL</th>
											<th style="padding:5px;border-bottom: 1px solid #000;"></th>
											<th style="padding:5px;border-bottom: 1px solid #000;"></th>
											<th style="text-align: center; color: #000;border: thin 1px solid;padding:5px;"><label>'.$qty.'</label></th>
											<th style="text-align: right; color: #000;border: thin 1px solid;padding:5px;"><label>'.number_format($total, 2).'</label></th>
										</tr>
										<tr>
											<th style="text-align: left; color: #000;padding:5px; border-left: 1px solid #000;">VAT</th>
											<th style="padding:5px;"></th>
											<th style="padding:5px;"></th>
											<th style="padding:5px;"></th>
											<th style="text-align: center; color: #000;padding:5px;"><label></label></th>
											<th style="text-align: right; color: #000;border: thin 1px solid;padding:5px;"><label>0.00</label></th>
										</tr>
										<tr>
											<td colspan="2" style="text-align: left; color: #000; padding: 5px; border-left: 1px solid #000; border-top: 1px solid #000; border-bottom: 1px solid #000;"><b>DISCOUNT</b></td>
											<th style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="text-align: center; color: #000;padding:5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="text-align: right; color: #000;border: thin 1px solid;padding:5px;"><label>'.number_format($discount, 2).'</label></th>
										</tr>
										<tr>
											<td colspan="2" style="text-align: left; color: #000; padding: 5px; border-left: 1px solid #000; border-top: 1px solid #000; border-bottom: 1px solid #000;"><b>TOTAL FOR THE INVOICE</b></td>
											<th style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="padding: 5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="text-align: center; color: #000;padding:5px; border-top: 1px solid #000; border-bottom: 1px solid #000;"></th>
											<th style="text-align: right; color: #000;border: thin 1px solid;padding:5px;"><label>'.number_format($nettotal, 2).'</label></th>
										</tr>
									</tfoot>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2"><h4 style="margin-top:5px;font-weight: normal;font-size: 14px;">Amount in words: <span style="text-transform: capitalize;">'.$amountInWords.' only</span></h4></td>
						</tr>
					</table>
					<table style="width:100%; font-size: 14px;position: fixed; bottom: 60px; ">
						<tr>
							<th>Prepared :</th>
							<td>......................................</td>
							<th>Approved :</th>
							<td>......................................</td>
							<th>Customer :</th>
							<td>......................................</td>
						</tr>
					</table>
				</main>
			</body>
		</html>
		';
	} else {
		$html = '
    <!DOCTYPE html>
    <html>

    <head>
    	<title>Unistar - By Erav Technology</title>
    	<link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    	<style>
    		body {
    			margin: 0;
    			padding: 0;
    			font-family: Arial, sans-serif;
    			font-size: 12px;
    			box-sizing: border-box;
    		}

    		.container {
    			max-width: 794px;
    			margin: 20px auto;
    			padding: 0 30px;
    		}

    		.logo {
    			display: inline-block;
    			float: left;
    			margin-top: 10px;
    		}

    		.logo img {
    			width: 160px;
    			height: 110px;
    		}

    		.logo2 {
    			display: inline-block;
    			float: right;
    			margin-top: 20px;
    		}

    		.logo2 img {
    			width: 170px;
    			height: 100px;
    		}

    		.address {
    			display: inline-block;
    			margin-top: 10px;
    			margin-left: 380px;
    		}

    		.address h3 {
    			margin: 0;
    			padding: 0;
    			text-decoration: underline;
    			font-size: 14px;
    		}

    		.address2 {
    			display: inline-block;
    			margin-top: 10px;
    			margin-left: 350px;
    		}

    		.address2 h3 {
    			margin: 0;
    			padding: 0;
    			text-decoration: underline;
    			font-size: 14px;
    		}

    		h1 {
    			margin-top: 30px;
    			font-size: 18px;
    			text-align: center;
    		}

    		.invoice-table {
    			margin-top: 10px;
    			table-layout: fixed;
    			width: 100%;
    			border-collapse: collapse;
    		}

    		.invoice-table th,
    		.invoice-table td {
    			padding: 3px;
    			border: 1px solid #000;
    			text-align: left;
    			font-size: 12px;
    		}

    		.invoice-table th {
    			background-color: #70ad47;
    			color: #fff;
    			font-weight: bold;
    			font-size: 12px;
    		}

    		.invoice-table tbody {
    			background-color: #c5e0b3;
    		}

    		.invoice-table tfoot th {
    			text-align: right;
    			font-weight: bold;
    			font-size: 12px;
    		}

    		.customer-details {
    			margin-top: 30px;
    			font-size: 12px;
    		}

    		.payment-terms {
    			margin-top: 20px;
    			font-size: 12px;
    			text-align: right;
    		}
    	</style>
    </head>

    <body>
    	<div class="container">
    		<div class="logo">
    			<img src="images/Ch.jpg" alt="">
    		</div>
    		<div class="address">
    			<h3>HEAD OFFICE</h3>
    			<b>Unistar International Pvt Ltd</b><br>
    			<b>No -</b> 53, 3rd Lane, Ratmalana, Sri Lanka <br>
    			<b>TEL -</b> +94 112635 185<br>
    			<b>MOBILE -</b> +94 77 966 2165 / +94 77 888 1631<br>
    			<b>Email -</b> admin@unistar-international.com<br>
    			<br>
    			<br>
    			<h3 style="margin-bottom:5px;">SHOWROOM</h3>
    			<b>CEYLONZ HARVEST</b><br>
    			<b>No -</b> 63, Jaya Mawatha, Ratmalana <br>
    			<b>TEL -</b> 077 966 2165 / +94 77 888 1631<br>
    			<b>Web -</b> www.admin@unistar-international.com
    		</div>
    		<h1><b>INVOICE</b></h1>
    		<div class="">
    			<b>Date -</b> '.$invdate.' <br>
    			<b>Invoice No. -</b> INV/DT-000'.$invid.'<br>
    		</div>
    		<table class="invoice-table">
    			<thead>
    				<tr>
    					<th style="text-align: center; width:8%" scope="col">#</th>
    					<th style="text-align: center; width:42%" scope="col">Item</th>
    					<th style="text-align: center; width:10%" scope="col">Pack Weight</th>
    					<th style="text-align: center; width:15%" scope="col">Unit Price(LKR)</th>
    					<th style="text-align: center; width:10%" scope="col">Order Quantity</th>
    					<th style="text-align: center; width:15%" scope="col">Amount(LKR)</th>
    				</tr>
    			</thead>
    			<tbody>
    				'.$tblinvoice.'
    			</tbody>
    			<tfoot>
    				<tr>
    					<th colspan="1"></th>
    					<th style="text-align: left; color: #000;">TOTAL:</th>
    					<th></th>
    					<th></th>
    					<th style="text-align: center; color: #000;"><label>'.$qty.'</label></th>
    					<th style="text-align: right; color: #000;"><label>'.$total.'</label></th>
    				</tr>
    			</tfoot>
    		</table>
    		<div class="">
    			<h3 style="margin-bottom:5px; margin-top:20px;"><u>CUSTOMER DETIALS</u></h3>
    			<b>CONGSIGNEE -</b> '.$cusname.'<br>
    			<b>Address -</b> '.$cusaddress.'<br>
    			<b>Contact No. -</b> '.$contact.'<br>
    			<b>Email -</b> '.$email.'<br>
    		</div>
    		<div class="" style="margin-bottom:5px; margin-top:50px;">
    			<b>PAYMENT TERMS -</b> <br>
    			<b>DELIVERY -</b> <br>
    		</div>
    		<div class="">
    			<h3 style="margin-bottom:5px; margin-top:50px;"><u>BANK DETAILS FOR PAYMENT</u></h3>
    			<b>Name -</b> Unistar International Pvt. Ltd<br>
    			<b>Account No. -</b> 100270005115<br>
    			<b>Bank Name -</b> Nations Trust PLC, Wellawaththa<br>
    			<b>Swift Code -</b> NTBCLKLX<br>
    			<b>Branch Code -</b> 027<br>
    			<b>Bank Code -</b> 7162<br>
    			<div class="logo2">
    				<img src="images/unistarimg.jpeg" class="img-fluid" alt="">
    			</div>
    		</div>
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




Here's the modified code with the layout changed to match the provided image (Transfood Lanka invoice format):

```php
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

	if($recordID>=600){
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