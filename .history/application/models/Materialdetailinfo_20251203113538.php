<?php
class Materialdetailinfo extends CI_Model{
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getunit(){

        $this->db->select('`idtbl_unit`, `unitname`');
        $this->db->from('tbl_unit');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Materialdetailinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $materialname=$this->input->post('materialname');
        $materialcode=$this->input->post('materialcode');
        $materialcategory=$this->input->post('materialcategory');
        $reorder=$this->input->post('reorder');
        $comment=$this->input->post('comment');  
        $unit=$this->input->post('unit');  
        $unitperctn=$this->input->post('unitperctn');  
        

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');  

        if($recordOption==1){
            $data = array(
                'materialname'=> $materialname, 
                'materialinfocode'=> $materialcode, 
                'unitperctn'=> $unitperctn, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                'tbl_unit_idtbl_unit'=> $unit
            );

            $this->db->insert('tbl_material_info', $data);

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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else{
            $data = array(
                'materialname'=> $materialname, 
                'materialinfocode'=> $materialcode, 
                'unitperctn'=> $unitperctn, 
                'reorderlevel'=> $reorder, 
                'comment'=> $comment, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime, 
                'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                'tbl_unit_idtbl_unit'=> $unit
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }   

    public function Supplierupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $supplier=$this->input->post('supplier');
        $unitprice=$this->input->post('unitprice');
        $hidematerialid=$this->input->post('hidematerialid');
        $updatedatetime=date('Y-m-d H:i:s');  

            $data = array(
                'unitprice'=> $unitprice, 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime, 
                'updateuser'=> $userID, 
                'tbl_material_info_idtbl_material_info'=> $hidematerialid, 
                'tbl_supplier_idtbl_supplier'=> $supplier
            );

            $this->db->insert('tbl_material_suppliers', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
    } 

    public function Supplierupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $supplier=$this->input->post('supplier');
        $unitprice=$this->input->post('unitprice');
        $hidematerialid=$this->input->post('hidematerialid');
        $updatedatetime=date('Y-m-d H:i:s');  

            $data = array(
                'unitprice'=> $unitprice, 
                'status'=> '1', 
                'updatedatetime'=> $updatedatetime, 
                'updateuser'=> $userID, 
                'tbl_material_info_idtbl_material_info'=> $hidematerialid, 
                'tbl_supplier_idtbl_supplier'=> $supplier
            );

            $this->db->insert('tbl_material_suppliers', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
    } 

    public function getSuppliersByMaterial($material_id){
        $this->db->select('ms.unitprice, s.suppliername');
        $this->db->from('tbl_material_suppliers ms');
        $this->db->join('tbl_supplier s', 's.idtbl_supplier = ms.tbl_supplier_idtbl_supplier');
        $this->db->where('ms.tbl_material_info_idtbl_material_info', $material_id);
        return $this->db->get()->result_array();
    }

    public function Materialdetailstatus($x, $y){
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

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_material_info', $recordID);
            $this->db->update('tbl_material_info', $data);

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
                redirect('Materialdetail');                
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
                redirect('Materialdetail');
            }
        }
    }
    public function Materialdetailedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_material_info');
        $this->db->where('idtbl_material_info', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_material_info;
        $obj->materialname=$respond->row(0)->materialname;
        $obj->reorderlevel=$respond->row(0)->reorderlevel;
        $obj->comment=$respond->row(0)->comment;
        $obj->unitprice=$respond->row(0)->unitprice;
        $obj->materialcode=$respond->row(0)->materialinfocode;
        $obj->unitperctn=$respond->row(0)->unitperctn;
        $obj->materialcategory=$respond->row(0)->tbl_material_category_idtbl_material_category ;
        $obj->supplier=$respond->row(0)->tbl_supplier_idtbl_supplier;
        $obj->unit=$respond->row(0)->tbl_unit_idtbl_unit;

        echo json_encode($obj);
    }
}