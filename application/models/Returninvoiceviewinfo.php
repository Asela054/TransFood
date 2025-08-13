<?php
class Returninvoiceviewinfo extends CI_Model{
    public function Getinvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_invoice_return_detail`.`idtbl_invoice_return_detail`, `tbl_invoice_return_detail`.`qty`, `tbl_invoice_return_detail`.`nettotal`,`tbl_product`.`productcode`
        FROM `tbl_invoice_return_detail`
        LEFT JOIN `tbl_invoice_return`  ON `tbl_invoice_return`.`idtbl_invoice_return` = `tbl_invoice_return_detail`.`tbl_invoice_return_idtbl_invoice_return`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_return_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice_return`.`idtbl_invoice_return`=? AND `tbl_invoice_return_detail`.`status`=?";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $html.='
        <table class="table table-bordered table-striped table-sm nowrap" id="tblInvoicelist">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Finish Good</th>
                <th scope="col">Qty.</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach ($respond->result() as $invoicelist) {
            $html .= '
                <tr>
                    <td>'.$invoicelist->idtbl_invoice_return_detail.'</td>
                    <td>'.$invoicelist->productcode.'</td>
                    <td>'.$invoicelist->qty.'</td>
                    <td>'.$invoicelist->nettotal.'</td>
                </tr>';
        }
        $html.='</tbody>
        <tfoot>
                <tr>
                    <th colspan="2" class="text-right"></th>
                    <th class="text-left">Total:</th>
                    <th class="text-left"></th>
                </tr>
            </tfoot></table>';

        echo $html;
    }

}