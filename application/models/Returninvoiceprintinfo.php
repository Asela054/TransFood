<?php
class Returninvoiceprintinfo extends CI_Model{
    public function Getinvoiceprint(){

        $recordID = $this->input->post('recordID');

        $this->db->select('tbl_invoice_return_detail.*, tbl_invoice_return.idtbl_invoice_return , tbl_invoice_return.total, tbl_invoice.invdate, tbl_invoice.idtbl_invoice, tbl_invoice.invtype, tbl_invoice.nettotal, tbl_product.productcode, tbl_product.desc, tbl_customer.name');
        $this->db->from('tbl_invoice_return_detail');
        $this->db->join('tbl_invoice_return', 'tbl_invoice_return.idtbl_invoice_return = tbl_invoice_return_detail.tbl_invoice_return_idtbl_invoice_return', 'left');
        $this->db->join('tbl_invoice', 'tbl_invoice.idtbl_invoice = tbl_invoice_return.tbl_invoice_idtbl_invoice', 'left');
        $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_invoice.tbl_customer_porder_idtbl_customer_porder', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customer_porder.tbl_customer_idtbl_customer', 'left');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_invoice_return_detail.tbl_product_idtbl_product', 'left');
        $this->db->where('tbl_invoice_return.idtbl_invoice_return', $recordID);
        $this->db->where('tbl_invoice_return_detail.status', 1);

        $responddetail = $this->db->get();

        $html = '';

        if ($responddetail->num_rows() > 0) {
            $row = $responddetail->row();
            $html .= '<div class="row">
                <div class="col">
                    <img src="'.base_url().'images/unistarimg.jpeg" class="img-fluid" alt="" style="width: 180px; height: 120px; margin-left:20px;">
                </div>
                <div class="col">
                    <h4 class="text-right">UN/RET-0000'.$row->idtbl_invoice_return.'</h4>
                </div>
            </div>
            <div class="row">
            	<div class="col">
            		<table style="width:25%;">
            			<tr>
            				<td>
            					<h6>Invoice No.</h6>
            				</td>
                            <td>-</td>
            				<td>
            					<h6>'.$row->idtbl_invoice.'</h6>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<h6>Date</h6>
            				</td>
                            <td>-</td>
            				<td>
            					<h6>'.$row->invdate.'</h6>
            				</td>
            			</tr>
            			<tr>
            				<td>
            					<h6>Customer Name</h6>
            				</td>
                            <td>-</td>
            				<td>
            					<h6>'.$row->name.'</h6>
            				</td>
            			</tr>
            		</table>

            	</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Return Product</th>
                                <th>Unit Price</th>
                                <th>Return Qty</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach($responddetail->result() as $roworderinfo) {
                $html .= '<tr>
                    <td>'.$roworderinfo->desc.' / '.$roworderinfo->productcode.'</td>
                    <td>'.$roworderinfo->unitprice.'</td>
                    <td>'.$roworderinfo->qty.'</td>
                    <td class="text-right">'.number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2).'</td>
                </tr>';
            }
            $html .= '</tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right"><h3 class="font-weight-normal"><span class="font-weight-bold">Invoice Total :</span>Rs. '.number_format(($row->nettotal),2).'</h3></div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-right"><h3 class="font-weight-normal"><span class="font-weight-bold">Return Total :</span>Rs. '.number_format(($row->total),2).'</h3></div>
            </div>

            <div class="row" style="margin-top: 100px;">
                <div class="ml-3">
                    <p class="text-right">Approved by: </p>
                </div>
                <div class="col-md-3">
                    <p style="border-bottom: 1px dotted; margin-bottom: 0;">&nbsp;</p>
                </div>
            </div>


            ';
        } else {
            $html .= '<p>No data found</p>';
        }

        echo $html;
    }

}
?>