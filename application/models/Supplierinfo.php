<?php
class Supplierinfo extends CI_Model{
    public function Getcountrylist(){
        $this->db->select('`idtbl_country`, `country`');
        $this->db->from('tbl_country');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialinfo(){
        $this->db->select('`idtbl_material_info`, `materialinfocode`');
        $this->db->from('tbl_material_info');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Supplierinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $suppliername=$this->input->post('suppliername');
        $suppliercode=$this->input->post('suppliercode');
        $address=$this->input->post('address');
        $country=$this->input->post('country');
        $email=$this->input->post('email');
        $primarycontact=$this->input->post('primarycontact');
        $secondarycontact=$this->input->post('secondarycontact');
        $remark=$this->input->post('remark');

        $category=$this->input->post('category');
        // $materialinfo=$this->input->post('materialinfo');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'suppliername'=> $suppliername, 
                'suppliercode'=> $suppliercode, 
                'primarycontactno'=> $primarycontact, 
                'secondarycontactno'=> $secondarycontact, 
                'address'=> $address, 
                'email'=> $email, 
                'remark'=> $remark, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_country_idtbl_country'=> $country,
                // 'tbl_company_idtbl_company'=> $companyid,
                // 'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->insert('tbl_supplier', $data);

            $supplierID=$this->db->insert_id();

            //Supplier Category Insert
            foreach($category as $rowcategory){
                $category=$rowcategory;
                $dataone = array(
                    'tbl_supplier_idtbl_supplier'=>$supplierID,
                    'tbl_material_category_idtbl_material_category'=>$category
                );

                $this->db->insert('tbl_supplier_has_tbl_material_category', $dataone);                
            }

            // Supplier Material Insert
            // foreach($materialinfo as $rowmaterialinfo){
            //     $materialinfo=$rowmaterialinfo;
            //     $datatwo = array(
            //         'tbl_supplier_idtbl_supplier'=>$supplierID,
            //         'tbl_material_info_idtbl_material_info'=>$materialinfo
            //     );

            //     $this->db->insert('tbl_supplier_has_tbl_material_info', $datatwo);                
            // }

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
                redirect('Supplier');                
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
                redirect('Supplier');
            }
        }
        else{
            $data = array(
                'suppliername'=> $suppliername, 
                'suppliercode'=> $suppliercode, 
                'primarycontactno'=> $primarycontact, 
                'secondarycontactno'=> $secondarycontact, 
                'address'=> $address, 
                'email'=> $email,  
                'remark'=> $remark, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime,
                'tbl_country_idtbl_country'=> $country,
                // 'tbl_company_idtbl_company'=> $companyid,
                // 'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->where('idtbl_supplier', $recordID);
            $this->db->update('tbl_supplier', $data);

            $this->db->where('tbl_supplier_idtbl_supplier', $recordID);
            $this->db->delete('tbl_supplier_has_tbl_material_category');
            
            // $this->db->where('tbl_supplier_idtbl_supplier', $recordID);
            // $this->db->delete('tbl_supplier_has_tbl_material_info');

            //Supplier Category Insert
            foreach($category as $rowcategory){
                $category=$rowcategory;
                $dataone = array(
                    'tbl_supplier_idtbl_supplier'=>$recordID,
                    'tbl_material_category_idtbl_material_category'=>$category
                );

                $this->db->insert('tbl_supplier_has_tbl_material_category', $dataone);                
            }

            // Supplier Material Insert
            // foreach($materialinfo as $rowmaterialinfo){
            //     $materialinfo=$rowmaterialinfo;
            //     $datatwo = array(
            //         'tbl_supplier_idtbl_supplier'=>$recordID,
            //         'tbl_material_info_idtbl_material_info'=>$materialinfo
            //     );

            //     $this->db->insert('tbl_supplier_has_tbl_material_info', $datatwo);                
            // }

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
                redirect('Supplier');                
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
                redirect('Supplier');
            }
        }
    }
    public function Supplierstatus($x, $y){
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

            $this->db->where('idtbl_supplier', $recordID);
            $this->db->update('tbl_supplier', $data);

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
                redirect('Supplier');                
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
                redirect('Supplier');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_supplier', $recordID);
            $this->db->update('tbl_supplier', $data);

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
                redirect('Supplier');                
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
                redirect('Supplier');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_supplier', $recordID);
            $this->db->update('tbl_supplier', $data);

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
                redirect('Supplier');                
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
                redirect('Supplier');
            }
        }
    }
    public function Supplieredit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_supplier');
        $this->db->where('idtbl_supplier', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $this->db->select('tbl_material_category_idtbl_material_category');
        $this->db->from('tbl_supplier_has_tbl_material_category');
        $this->db->where('tbl_supplier_idtbl_supplier', $recordID);

        $respondcategory=$this->db->get();

        $categorylistarray=array();
        foreach($respondcategory->result() as $rowcategory){
            $objcategorylist=new stdClass();
            $objcategorylist->categorylistID=$rowcategory->tbl_material_category_idtbl_material_category;
            array_push($categorylistarray, $objcategorylist);
        }

        // $this->db->select('tbl_material_info_idtbl_material_info');
        // $this->db->from('tbl_supplier_has_tbl_material_info');
        // $this->db->where('tbl_supplier_idtbl_supplier', $recordID);

        // $respondmaterial=$this->db->get();

        // $materiallistarray=array();
        // foreach($respondmaterial->result() as $rowmaterial){
        //     $objmateriallist=new stdClass();
        //     $objmateriallist->materiallistID=$rowmaterial->tbl_material_info_idtbl_material_info;
        //     array_push($materiallistarray, $objmateriallist);
        // }

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_supplier;
        $obj->suppliername=$respond->row(0)->suppliername;
        $obj->suppliercode=$respond->row(0)->suppliercode;
        $obj->primarycontactno=$respond->row(0)->primarycontactno;
        $obj->secondarycontactno=$respond->row(0)->secondarycontactno;
        $obj->address=$respond->row(0)->address;
        $obj->email=$respond->row(0)->email;
        $obj->remark=$respond->row(0)->remark;
        $obj->country=$respond->row(0)->tbl_country_idtbl_country;
        $obj->categorylist=$categorylistarray;
        // $obj->materiallist=$materiallistarray;

        echo json_encode($obj);
    }
}