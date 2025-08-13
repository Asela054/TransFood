<?php
class Returninvoiceinfo extends CI_Model{
    public function Getreturntype(){
        $this->db->select('`idtbl_return_type`, `type`');
        $this->db->from('tbl_return_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcustomer(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcustomerlist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=? AND `name` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_customer`, `name` FROM `tbl_customer` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_customer, "text"=>$row->name);
        }
        
        echo json_encode($data);
    }

    public function Getinvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_invoice_detail`.`idtbl_invoice_detail`, `tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`total`, `tbl_invoice_detail`.`returnstatus`,`tbl_product`.`productcode`
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
            $html .= '<tr';
            if ($invoicelist->returnstatus == 1) {
                $html .= ' class="table-danger"';
            }
            $html .= '>
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

    public function Getretruninvoicedetails(){
        $html = '';

        $recordID=$this->input->post('recordID');


        $sql = "SELECT `tbl_invoice_return`.`idtbl_invoice_return`, `tbl_invoice_return`.`date`, `tbl_invoice_return`.`total`
        FROM `tbl_invoice_return` WHERE `tbl_invoice_return`.`tbl_invoice_idtbl_invoice`=? AND `tbl_invoice_return`.`status`=?";
        $respond = $this->db->query($sql, array($recordID, 1)); 

        $html.='
        <table class="table table-bordered table-striped table-sm nowrap" id="tblReturnInvoicelist">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Total</th>
                <th scope="col">Actions</th>

                </tr>
            </thead>
            <tbody>
        ';
        foreach ($respond->result() as $invoicelist) {
            $buttonClass = 'btn btn-danger btn-sm btnprintReturn mr-1';
                $html .= '<tr>
                            <td>' . $invoicelist->idtbl_invoice_return . '</td>
                            <td>' . $invoicelist->date . '</td>
                            <td>' . $invoicelist->total . '</td>
                            <td>
                            <button class="' . $buttonClass . '" id="' . $invoicelist->idtbl_invoice_return . '"><i class="fas fa-file-alt"></i></button>
                            </td>
                        </tr>';
        }        
        $html.='</tbody></table>';

        echo $html;
    }

    public function Getorderdetails(){
 
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_invoice_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_invoice_detail`.`tbl_product_idtbl_product`
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_invoice_idtbl_invoice`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());

    }

    public function Getordereqty() {
        $recordID = $this->input->post('recordID');
        $invoiceID = $this->input->post('invoiceID');
    
            
        $this->db->select('`qty`, `saleprice`, `invdate`');
        $this->db->from('tbl_invoice_detail');
        $this->db->join('tbl_invoice', 'tbl_invoice.idtbl_invoice = tbl_invoice_detail.tbl_invoice_idtbl_invoice', 'left');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_invoice_detail.tbl_product_idtbl_product', 'left');
        $this->db->where('tbl_product_idtbl_product', $recordID);
        $this->db->where('tbl_invoice_idtbl_invoice', $invoiceID);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->qty=$respond->row(0)->qty;
        $obj->price=$respond->row(0)->saleprice;
        $obj->invdate=$respond->row(0)->invdate;



        echo json_encode($obj);
    }   

    public function Returninvoiceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $hideinvoiceID=$this->input->post('hideinvoiceID');
        $total=$this->input->post('total');
        $remark=$this->input->post('remark');


        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');
        $batchnodate=date('Ymd');

        $data = array(
            'date'=> $today,
            'total'=> $total, 
            'remarks'=> $remark, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_invoice_idtbl_invoice'=> $hideinvoiceID,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_invoice_return', $data);

        $returninvoiceID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $comment=$rowtabledata['col_3'];
            $productID=$rowtabledata['col_4'];
            $returnType=$rowtabledata['col_5'];
            $unitprice=$rowtabledata['col_6'];
            $qty=$rowtabledata['col_7'];
            $nettotal=$rowtabledata['col_8'];

            $dataone = array(
                'unitprice'=> $unitprice, 
                'qty'=> $qty, 
                'nettotal'=> $nettotal, 
                'comment'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_return_type_idtbl_return_type'=> $returnType, 
                'tbl_product_idtbl_product'=> $productID, 
                'tbl_invoice_return_idtbl_invoice_return'=> $returninvoiceID
            );

            $this->db->insert('tbl_invoice_return_detail', $dataone);

            $fgbatchno = 'RET0000' . $batchnodate;

            if($returnType!=1){
                $dataone = array(
                    'fgbatchno'=> $fgbatchno, 
                    'qty'=> $qty, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_product_idtbl_product'=> $productID, 
                    'tbl_location_idtbl_location'=> '1',
                    'tbl_company_idtbl_company'=> $companyid,
                    'tbl_company_branch_idtbl_company_branch'=> $branchid
                );

                $this->db->insert('tbl_product_stock', $dataone);
            }

            $data = array(
                'returnstatus' => '1',
            );

            $this->db->where('tbl_invoice_idtbl_invoice', $hideinvoiceID);
            $this->db->where('tbl_product_idtbl_product', $productID);
            $this->db->update('tbl_invoice_detail', $data);

            $data = array(
                'returnstatus' => '1',
            );

            $this->db->where('idtbl_invoice', $hideinvoiceID);
            $this->db->update('tbl_invoice', $data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Added Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    }

}