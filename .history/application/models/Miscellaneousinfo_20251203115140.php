<?php
class Miscellaneousinfo extends CI_Model{
    public function Getmaterial(){
        $this->db->select('`idtbl_material_info`, `materialinfocode`');
        $this->db->from('tbl_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getproduct(){
        $this->db->select('`idtbl_product`, `productcode`');
        $this->db->from('tbl_product');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getbatchnolist(){
        $materialId = $this->input->post('materialId');

        $sql="SELECT `batchno` FROM `tbl_stock` WHERE `tbl_material_info_idtbl_material_info`=? AND `tbl_stock`.`status`=?";
        $respond=$this->db->query($sql, array($materialId,1));

        echo json_encode($respond->result());
    }
    public function Getbatchnolistaccoproduct(){
        $productId = $this->input->post('productId');

        $sql="SELECT `fgbatchno` FROM `tbl_product_stock` WHERE `tbl_product_idtbl_product`=? AND `tbl_product_stock`.`status`=?";
        $respond=$this->db->query($sql, array($productId,1));

        echo json_encode($respond->result());
    }
    public function Getproductlist(){
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
    public function Getmateriallist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_material_info`, `materialinfocode` FROM `tbl_material_info` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_material_info`, `materialinfocode` FROM `tbl_material_info` WHERE `status`=? AND `materialinfocode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_material_info`, `materialinfocode` FROM `tbl_material_info` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialinfocode);
        }
        
        echo json_encode($data);
    }
    public function Miscellaneousinsertupdate(){
        $this->db->trans_begin();

        $userID = $_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData = $this->input->post('tableData');
        $type = $this->input->post('type');
        $date = $this->input->post('date');
        $selectedRadio = $this->input->post('selectedRadio');
        $total = $this->input->post('total');

        $updatedatetime = date('Y-m-d H:i:s');

        $data = array(
            'date' => $date,
            'type' => $type,
            'total' => $total,
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_miscellaneous', $data);

        $miscellaneousID = $this->db->insert_id();

        foreach ($tableData as $rowtabledata) {
            $batchno = $rowtabledata['col_2'];
            $materialID = $rowtabledata['col_3'];
            $qty = $rowtabledata['col_4'];
            $price = $rowtabledata['col_5'];
            $total = $rowtabledata['col_6'];

            $dataone = array(
                'plusmine' => $selectedRadio,
                'batchno' => $batchno,
                'qty' => $qty,
                'price' => $price,
                'total' => $total,
                'status' => '1',
                'insertdatetime' => $updatedatetime,
                'tbl_miscellaneous_idtbl_miscellaneous' => $miscellaneousID,
                'tbl_material_info_idtbl_material_info' => $materialID
            );

            $this->db->insert('tbl_miscellaneous_detail', $dataone);
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
    public function Miscellaneousinsertupdate2(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $type=$this->input->post('type');
        $date=$this->input->post('date');
        $selectedRadio=$this->input->post('selectedRadio');
        $total=$this->input->post('total');
        $batchno=$this->input->post('batchno');
        $location = $this->input->post('location');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'date'=> $date, 
            'type'=> $type, 
            'total'=> $total, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_miscellaneous', $data);

        $miscellaneousID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $batchno=$rowtabledata['col_2'];
            $materialID=$rowtabledata['col_3'];
            $qty=$rowtabledata['col_4'];
            $price=$rowtabledata['col_5'];
            $total=$rowtabledata['col_6'];

            $dataone = array(
                'plusmine'=> $selectedRadio, 
                'batchno' => $batchno,
                'qty'=> $qty, 
                'price'=> $price, 
                'total'=> $total,  
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_miscellaneous_idtbl_miscellaneous'=> $miscellaneousID, 
                'tbl_product_idtbl_product'=> $materialID,
                'tbl_location_idtbl_location'=> $location,

            );

            $this->db->insert('tbl_miscellaneous_detail', $dataone);

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
    public function Brandstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_brand', $recordID);
            $this->db->update('tbl_brand', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_brand', $recordID);
            $this->db->update('tbl_brand', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_brand', $recordID);
            $this->db->update('tbl_brand', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Brand');
            }
        }
    }
    public function Brandedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_brand');
        $this->db->where('idtbl_brand', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_brand;
        $obj->brandname=$respond->row(0)->brandname;
        $obj->brandcode=$respond->row(0)->brandcode;
        $obj->materialcategory=$respond->row(0)->tbl_material_category_idtbl_material_category ;

        echo json_encode($obj);
    }

    public function Miscellaneousview() {
		$recordID=$this->input->post('recordID');

		$this->db->select('tbl_miscellaneous_detail.*, tbl_material_info.materialinfocode, tbl_product.productcode,tbl_location.location');
		$this->db->from('tbl_miscellaneous_detail');
		$this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_miscellaneous_detail.tbl_material_info_idtbl_material_info', 'left');
		$this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_miscellaneous_detail.tbl_product_idtbl_product', 'left');
		$this->db->join('tbl_location', 'tbl_location.idtbl_location = tbl_miscellaneous_detail.tbl_location_idtbl_location', 'left');
		$this->db->where('tbl_miscellaneous_detail.tbl_miscellaneous_idtbl_miscellaneous', $recordID);
		$this->db->where('tbl_miscellaneous_detail.status', 1);

		$responddetail = $this->db->get();

        $hasMaterial = false;
        $hasProduct  = false;

        foreach ($responddetail->result() as $row) {
            if (!empty($row->tbl_material_info_idtbl_material_info)) {
                $hasMaterial = true;
            }
            if (!empty($row->tbl_product_idtbl_product)) {
                $hasProduct = true;
            }
        }

        $html = '<table class="table table-striped table-bordered table-sm"> 
            <thead> 
                <tr>';

        if ($hasProduct) {
            $html .= '<th>Location</th>';
        }
        if ($hasMaterial) {
            $html .= '<th>Material Info</th>';
        }
        if ($hasProduct) {
            $html .= '<th>Product Info</th>';
        }

        $html .= ' 
                    <th>Unit Price</th> 
                    <th class="text-center">Qty</th>
                    <th class="text-right">Total</th>
                </tr> 
            </thead> 
            <tbody>';

        // rows
        foreach ($responddetail->result() as $row) {
            $material = $row->materialinfocode;
            $product  = $row->productcode;
            $location = $row->location;

            $html .= '<tr>';

            if ($hasProduct) {
                if (!empty($product)) {
                    $html .= '<td>' . $location . '</td>';
                } else {
                    $html .= '<td></td>';
                }
            }

            if ($hasMaterial) {
                if (!empty($material)) {
                    $html .= '<td>' . $material . '</td>';
                } else {
                    $html .= '<td></td>';
                }
            }

            if ($hasProduct) {
                if (!empty($product)) {
                    $html .= '<td>' . $product . '</td>';
                } else {
                    $html .= '<td></td>';
                }
            }

            $html .= '<td>' . number_format($row->price, 2, '.', ',') . '</td>';
            $html .= '<td class="text-center">' . $row->qty . '</td>';
            $html .= '<td class="text-right">' . number_format($row->total, 2, '.', ',') . '</td>';

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

		
		$response = [
            'html' => $html
        ];
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

    public function Approvestatus() {
        $this->db->trans_begin();
        $userID = $_SESSION['userid'];
        $updatedatetime = date('Y-m-d H:i:s');
        $approveID = $this->input->post('miscellaneousid');
        $confirmnot = $this->input->post('confirmnot');

        $data = array(
            'approvestatus' => $confirmnot,
            'updateuser' => $userID,
            'updatedatetime' => $updatedatetime
        );
        $this->db->where('idtbl_miscellaneous', $approveID);
        $this->db->update('tbl_miscellaneous', $data);

        if ($confirmnot == 1) {
            $this->db->select('type');
            $this->db->from('tbl_miscellaneous');
            $this->db->where('idtbl_miscellaneous', $approveID);
            $miscRecord = $this->db->get()->row();
            
            if ($miscRecord) {
                $type = $miscRecord->type;
                
                $this->db->select('*');
                $this->db->from('tbl_miscellaneous_detail');
                $this->db->where('tbl_miscellaneous_idtbl_miscellaneous', $approveID);
                $this->db->where('status', 1);
                $details = $this->db->get()->result();
                
                foreach ($details as $detail) {
                    $plusmine = $detail->plusmine;
                    $batchno = $detail->batchno;
                    $qty = $detail->qty;
                    $location = $detail->tbl_location_idtbl_location;
                    
                    if ($type == 1) { // Material
                        $materialID = $detail->tbl_material_info_idtbl_material_info;
                        $this->updateMaterialStock($materialID, $batchno, $qty, $plusmine);
                    } 
                    else if ($type == 2) { // Product
                        $productID = $detail->tbl_product_idtbl_product;
                        $this->updateProductStock($productID, $batchno, $location, $qty, $plusmine);
                    }
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()===TRUE) {
            $this->db->trans_commit();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-check';
            $actionObj->title='';
            if($confirmnot==1){$actionObj->message='Record Approved Successfully';}
            else{$actionObj->message='Record Rejected Successfully';}
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=1;
            $obj->action=$actionJSON;

            echo json_encode($obj);
        }
        else {
            $this->db->trans_rollback();

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-warning';
            $actionObj->title='';
            $actionObj->message='Record Error';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=2;
            $obj->action=$actionJSON;

            echo json_encode($obj);
        }
    }

    private function updateMaterialStock($materialID, $batchno, $qty, $operation) {
        $this->db->select('qty AS dbqty');
        $this->db->from('tbl_stock');
        $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
        $this->db->where('batchno', $batchno);
        $this->db->where('status', 1);
        
        $respond = $this->db->get();
        
        if ($respond->num_rows() > 0) {
            $prevqty = $respond->row(0)->dbqty;
        
            $stockqty;
        
            if ($operation == 1) {
                $stockqty = $prevqty + $qty;
            } else {
                $stockqty = $prevqty - $qty;
            }
        
            $this->db->where('batchno', $batchno);
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->where('status', 1);
            $this->db->update('tbl_stock', array('qty' => $stockqty));
        } else {
            if ($operation == 1) {
                $stockData = array(
                    'tbl_material_info_idtbl_material_info' => $materialID,
                    'batchno' => $batchno,
                    'qty' => $qty,
                    'status' => 1,
                    'insertdatetime' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_stock', $stockData);
            }
        }
    }

    private function updateProductStock($productID, $batchno, $location, $qty, $operation) {
        $this->db->select('qty AS dbqty');
        $this->db->from('tbl_product_stock');
        $this->db->where('tbl_product_idtbl_product', $productID);
        $this->db->where('tbl_location_idtbl_location', $location);
        $this->db->where('fgbatchno', $batchno);
        $this->db->where('status', 1);
        
        $respond = $this->db->get();
        
        if ($respond->num_rows() > 0) {
            $prevqty = $respond->row(0)->dbqty;
        
            $stockqty;
        
            if ($operation == 1) {
                $stockqty = $prevqty + $qty;
            } else {
                $stockqty = $prevqty - $qty;
            }
        
            $this->db->where('fgbatchno', $batchno);
            $this->db->where('tbl_product_idtbl_product', $productID);
            $this->db->where('tbl_location_idtbl_location', $location);
            $this->db->where('status', 1);
            $this->db->update('tbl_product_stock', array('qty' => $stockqty));
        } else {
            if ($operation == 1) {
                $stockData = array(
                    'tbl_product_idtbl_product' => $productID,
                    'tbl_location_idtbl_location' => $location,
                    'fgbatchno' => $batchno,
                    'qty' => $qty,
                    'status' => 1,
                    'insertdatetime' => date('Y-m-d H:i:s')
                );
                $this->db->insert('tbl_product_stock', $stockData);
            }
        }
    }
}