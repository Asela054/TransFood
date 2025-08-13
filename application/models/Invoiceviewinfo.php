<?php
class Invoiceviewinfo extends CI_Model{
    public function locationlist(){
        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getinvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`total`,`tbl_product`.`productcode`
        FROM `tbl_invoice_detail`
        LEFT JOIN `tbl_invoice`  ON `tbl_invoice`.`idtbl_invoice` = `tbl_invoice_detail`.`tbl_invoice_idtbl_invoice`
        LEFT JOIN `tbl_product`  ON `tbl_product`.`idtbl_product` = `tbl_invoice_detail`.`tbl_product_idtbl_product` WHERE `tbl_invoice`.`idtbl_invoice`=? AND `tbl_invoice_detail`.`status`=?";
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
                    <td>'.$invoicelist->idtbl_invoice_detail.'</td>
                    <td>'.$invoicelist->productcode.'</td>
                    <td>'.$invoicelist->qty.'</td>
                    <td>'.$invoicelist->total.'</td>
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

    public function Getproductlisttoselectpicker(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? AND `productcode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->productcode);
        }
        
        echo json_encode($data);
    }

    public function GetProductsByInvoiceID($invoice_id) {
        $this->db->select('p.idtbl_product, p.productcode');
        $this->db->from('tbl_invoice_detail as id');
        $this->db->join('tbl_product as p', 'id.tbl_product_idtbl_product = p.idtbl_product');
        $this->db->where('id.tbl_invoice_idtbl_invoice', $invoice_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function GetBatchesByProductAndLocation($product_id, $location_id) {
        $this->db->select('idtbl_product_stock, fgbatchno, insertdatetime');
        $this->db->from('tbl_product_stock');
        $this->db->where('tbl_product_idtbl_product', $product_id);
        $this->db->where('tbl_location_idtbl_location', $location_id);
        $query = $this->db->get();
        return $query->result();
    }

    public function UpdateBatchNumbers($invoice_id, $product_id, $batchnos) {
        $data = array(
            'batchno' => implode(',', $batchnos),
            'updatedatetime' => date('Y-m-d H:i:s'),
            'updateuser' => $this->session->userdata('user_id')
        );

        $this->db->where('tbl_invoice_idtbl_invoice', $invoice_id);
        $this->db->where('tbl_product_idtbl_product', $product_id);
        return $this->db->update('tbl_invoice_detail', $data);
    }

}