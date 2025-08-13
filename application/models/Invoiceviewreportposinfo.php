<?php
class Invoiceviewreportposinfo extends CI_Model{
    public function printreportpos($x){

    $recordID=$x;
    $cashier=$_SESSION['name'];
	$companyid=$_SESSION['companyid'];


    $sqlinvoiceinfo="SELECT `tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`invno`, `tbl_invoice`.`invdate`, `tbl_invoice`.`grosstotal`, `tbl_invoice`.`discount`, `tbl_invoice`.`nettotal`, `tbl_invoice`.`paycomplete`, `tbl_customer`.`name`, `tbl_customer`.`address` FROM `tbl_invoice` LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`  LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_porder`.`tbl_customer_idtbl_customer` WHERE `tbl_invoice`.`status`=1 AND `tbl_invoice`.`idtbl_invoice`=?";
    $invoiceinforespond=$this->db->query($sqlinvoiceinfo, array($recordID));
    $invdate=$invoiceinforespond->row(0)->invdate;
    $invid=$invoiceinforespond->row(0)->idtbl_invoice;
	$invno=$invoiceinforespond->row(0)->invno;
    $name=$invoiceinforespond->row(0)->name;
    $address=$invoiceinforespond->row(0)->address;
    $grosstotal=$invoiceinforespond->row(0)->grosstotal;
    $discount=$invoiceinforespond->row(0)->discount;
    $nettotal=$invoiceinforespond->row(0)->nettotal;

    $sqlproduct="SELECT `tbl_product`.`productcode`, `tbl_product`.`barcode`, `tbl_product`.`desc`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=1";
    $productrespond=$this->db->query($sqlproduct, array($recordID));

    $qty=$productrespond->row(0)->qty;
    $saleprice=$productrespond->row(0)->saleprice;

    $sqlproductcount="SELECT COUNT(`tbl_product`.`productcode`) AS itemcount, `tbl_product`.`barcode`, `tbl_product`.`desc`, SUM(`tbl_invoice_detail`.`qty`) AS sumqty, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=1";
    $productcountrespond=$this->db->query($sqlproductcount, array($recordID));

    $itemcount=$productcountrespond->row(0)->itemcount;
    $sumqty=$productcountrespond->row(0)->sumqty;

    $sqlpayment="SELECT SUM(`nettotal`) AS `sumpayment` FROM `tbl_invoice_payment` LEFT JOIN `tbl_invoice_payment_has_tbl_invoice` ON `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_payment_idtbl_invoice_payment`=`tbl_invoice_payment`.`idtbl_invoice_payment` WHERE `tbl_invoice_payment_has_tbl_invoice`.`tbl_invoice_idtbl_invoice`=?";
    $paymentrespond=$this->db->query($sqlpayment, array($recordID));

    if(empty($paymentrespond)){$totalpay=0;}
    else{$totalpay=$paymentrespond->row(0)->sumpayment;}


	$tblinvoice = '';

	foreach ($productrespond->result() as $rowlist) {
		$tblinvoice .= '
			<tr>
			<td style="text-align: left; font-size:14px;" colspan="4">' .
					$rowlist->productcode . ' - ' . $rowlist->barcode . '</td>
			</tr>
			<tr>
			<td style="text-align: left; font-size:14px;">&nbsp;</td>
			<td style="text-align: center; font-size:14px;">' . number_format(($rowlist->saleprice), 2) . '</td>
			<td style="text-align: center; font-size:14px;">' . $rowlist->qty . '</td>
			<td style="text-align: right; font-size:14px;">' . number_format(($rowlist->qty * $rowlist->saleprice), 2) . '</td>
		</tr>
		';
	}

    $sqlinvoicedetail="SELECT `tbl_product`.`productcode`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`='$recordID' AND `tbl_invoice_detail`.`status`=1";
    $respond2=$this->db->query($sqlinvoicedetail, array());

$html='';

$html = '
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css2?family=Fira+Mono&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
	<title>Invoice</title>
	<style media="print">
	* {
		font-family: "Cutive Mono", monospace;
		font-weight: 600;
	}
	table,tr,th,td{
		font-family: "Cutive Mono", monospace;
		font-weight: 600;
	}
	img{
		width:200px;
		height:100px;
	}
</style>
<style>
	* {
		font-family: "Cutive Mono", monospace;
		font-weight: 600;
	}
	table,tr,th,td{
		font-family: "Cutive Mono", monospace;
		font-weight: 600;
	}
	img{
		width:100px;
		height:100px;
	}
</style>
</head>

<body>
	<div id="DivIdToPrint">
		<img src="'.base_url().'images/CH-removebg-preview.png" alt=""
			style="width:120%; height:120px; margin-left: -25px;">
		<table style="width:100%;">
			<tr>
				<td style="text-align: left; font-size:14px;">Date</td>
				<td style="text-align: right; font-size:14px;">'.$invdate.'</td>
			</tr>
			<tr>
                <td style="text-align: left; font-size:14px;">Invoice No.</td>
                <td style="text-align: right; font-size:14px;">';
                    $prefix = "UNKNOWN";
                    if ($companyid == 1) {
                        $prefix = "UN/INV";
                    } else if ($companyid == 2) {
                        $prefix = "UF/INV";
                    }
                    $html .= $prefix . "/OT-000" . $invno;
                $html .= '</td>
            </tr>
			<tr>
				<td style="text-align: left; font-size:14px;border-bottom:1px dotted black;">Cashier</td>
				<td style="text-align: right; font-size:14px;border-bottom:1px dotted black;">'.$cashier.'</td>
			</tr>
			<tr>
				<td style="text-align: center;" colspan="2">
					<table style="width:100%;">
						<tr style="text-align:right; font-weight:bold; font-size:5px;">
							<td style="text-align: left; font-size:14px;border-bottom:1px dotted black;">Name</td>
							<td style="text-align: center; font-size:14px;border-bottom:1px dotted black;">Price</td>
							<td style="text-align: center; font-size:14px;border-bottom:1px dotted black;">Qty</td>
							<td style="text-align: right; font-size:14px;border-bottom:1px dotted black;">Total</td>
						</tr>
						<tbody>
							'.$tblinvoice.'
						</tbody>

					</table>
				</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:14px;font-weight: bold;border-top:1px dotted black;">Total</td>
				<td style="text-align: right; font-size:14px;font-weight: bold;border-top:1px dotted black;">'.number_format(($grosstotal), 2).'
				</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:14px;font-weight: bold;">Total Discount</td>
				<td style="text-align: right; font-size:14px;font-weight: bold;">'.number_format(($discount), 2).'</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:14px;font-weight: bold;">Net Total</td>
				<td style="text-align: right; font-size:14px;font-weight: bold;">'.number_format(($nettotal), 2).'</td>
			</tr>
			<tr>
				<td style="text-align: left; font-size:14px;font-weight: bold;border-bottom:1px dotted black;">No. of Items</td>
				<td style="text-align: right; font-size:14px;font-weight: bold;border-bottom:1px dotted black;">'.$itemcount.'</td>
			</tr>
			<tr>
				<td style="text-align: center; font-size:10px;" colspan="2"><span
						style="text-align: center; font-size:16px;font-weight: bold;">Thank You. Come again!</span><br>Unistar
					International(PVT)Ltd <br> 53, 3rd LANE, RATMALANA, 011-2635185</td>
			</tr>
			<tr>
				<td style="text-align: center; font-size:5px;" colspan="2"><span
						style="text-align: center; font-size:8px;font-weight: bold;">Copyright © ERav Technology</td>
			</tr>
		</table>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
	window.print();
	setTimeout(() => {
		window.close();
	}, 5000);
</script>
</body>

</html>';

echo $html;

// $this->load->library('pdf');
// $this->pdf->loadHtml($html);
// $this->pdf->render();
// $this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));
    }
}