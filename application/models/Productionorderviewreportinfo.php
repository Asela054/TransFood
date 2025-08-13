<?php
class Productionorderviewreportinfo extends CI_Model{
    public function printreport($x){

        $recordID=$x;


        $tblproduction='';

        $sql = "SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_production_orderdetail`.`qty`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_production_order`.`prodate`, `tbl_production_order`.`procode`, `tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`
        FROM `tbl_production_orderdetail`
        LEFT JOIN `tbl_production_order`  ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product` WHERE `tbl_production_order`.`idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=? GROUP BY `tbl_production_orderdetail`.`idtbl_production_orderdetail`";
        $respond = $this->db->query($sql, array($recordID, 1)); 


        $sqlcus = "SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_production_orderdetail`.`qty`,`tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_production_order`.`prodate`, `tbl_production_order`.`procode`, `tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`
        FROM `tbl_production_orderdetail`
        LEFT JOIN `tbl_production_order`  ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
         LEFT JOIN `tbl_customer_porder`  ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`
         LEFT JOIN `tbl_customer_porder_detail`  ON `tbl_customer_porder_detail`.`idtbl_customer_porder_detail` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product` WHERE `tbl_production_order`.`idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=? GROUP BY `tbl_production_orderdetail`.`idtbl_production_orderdetail`";
        $respondsus = $this->db->query($sqlcus, array($recordID, 1));

        $sqltotal="SELECT SUM(`qty`) AS qty FROM `tbl_production_orderdetail` WHERE `tbl_production_order_idtbl_production_order`=?";
        $respondtotal = $this->db->query($sqltotal, array($recordID));
    
        $row2 = $respondtotal->row();
        $qty = $row2->qty;
    
    if ($respondsus->num_rows() > 0) {
        $row = $respondsus->row();
        $prodate = $row->prodate;
    }

        foreach($respond->result() as $rowlist){
            $tblproduction.='
            <tr>
                    <td style="text-align: center;">'.$rowlist->idtbl_production_orderdetail.'</td>
                    <td>'.$rowlist->desc.'</td>
                    <td style="text-align: center;">'.$rowlist->qty.'</td>
                    <td style="text-align: center;">'.$rowlist->procode.'</td>
                    <td style="text-align: right;">'.$rowlist->prodate.'</td>
                    <td style="text-align: right;">'.$rowlist->prostartdate.'</td>
                    <td style="text-align: right;">'.$rowlist->proenddate.'</td>
                </tr>
            
            ';
        } 

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
                <img src="'.base_url().'images/Ch.jpg" alt="">
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
		<h1><b>Packing Order Details</b></h1>
		<div class="">
			<b>Date -</b> '.$prodate.' <br>
		</div>
		<table class="invoice-table">
			<thead>
				<tr>
					<th style="text-align: center;" scope="col">#</th>
                    <th style="text-align: center;" scope="col">Item</th>
                    <th style="text-align: center;" scope="col">Quantity</th>
					<th style="text-align: center;" scope="col">Packing Order Code</th>
					<th style="text-align: center;" scope="col">Packing Order Date</th>
                    <th style="text-align: center;" scope="col">Packing Start Date</th>
                    <th style="text-align: center;" scope="col">Packing End Date</th>
				</tr>
			</thead>
			<tbody>
				'.$tblproduction.'
			</tbody>
			<tfoot>
				<tr>
					<th colspan="1"></th>
					<th style="text-align: left;">TOTAL:</th>
                    <th style="text-align: center;"><label>'.$qty.'</label></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    				</tr>
			</tfoot>
		</table>
    <div class="logo2">
    <img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt="">
</div>
	</div>
</body>
</html>
';

// echo $html;

    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL PRODUCTION ORDER DETAIL SHEET.pdf", array("Attachment"=>0));

    }

}
