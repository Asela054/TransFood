<?php
class Customerinfo extends CI_Model{
    public function Customerinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];


        $name=$this->input->post('name');
        $code=$this->input->post('code');
        $type=$this->input->post('type');
        $contact=$this->input->post('contact');
        $contact2=$this->input->post('contact2');
        $email=$this->input->post('email');
        $address=$this->input->post('address');
        $gstinno=$this->input->post('gstinno');
        $panno=$this->input->post('panno');
        $ieccode=$this->input->post('ieccode');
        $fssaino=$this->input->post('fssaino');
        $bank=$this->input->post('bank');
        $branch=$this->input->post('branch');
        $accountnum=$this->input->post('accountnum');
        $account=$this->input->post('account');
        $bankaddress=$this->input->post('bankaddress');
        $swiftcode=$this->input->post('swiftcode');
        $ifscno=$this->input->post('ifscno');
        $intemediarybank=$this->input->post('intemediarybank');
        $inteswiftcode=$this->input->post('inteswiftcode');
        $accountinstitution=$this->input->post('accountinstitution');
        $insswiftcode=$this->input->post('insswiftcode');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'name'=> $name, 
                'customercode'=> $code, 
                'customertype'=> $type, 
                'contact'=> $contact, 
                'contact2'=> $contact2, 
                'email'=> $email, 
                'address'=> $address, 
                'gstinno'=> $gstinno, 
                'panno'=> $panno, 
                'ieccode'=> $ieccode, 
                'fssaino'=> $fssaino, 
                'bankname'=> $bank, 
                'bankbranch'=> $branch, 
                'accountno'=> $accountnum, 
                'accountname'=> $account, 
                'bankaddress'=> $bankaddress, 
                'swiftcode'=> $swiftcode, 
                'ifscno'=> $ifscno, 
                'intemediarybank'=> $intemediarybank, 
                'inteswiftcode'=> $inteswiftcode, 
                'accountinstitution'=> $accountinstitution, 
                'insswiftcode'=> $insswiftcode,
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->insert('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
        else{
            $data = array(
                'name'=> $name, 
                'customercode'=> $code, 
                'customertype'=> $type, 
                'contact'=> $contact, 
                'contact2'=> $contact2, 
                'email'=> $email, 
                'address'=> $address, 
                'gstinno'=> $gstinno, 
                'panno'=> $panno, 
                'ieccode'=> $ieccode, 
                'fssaino'=> $fssaino, 
                'bankname'=> $bank, 
                'bankbranch'=> $branch, 
                'accountno'=> $accountnum, 
                'accountname'=> $account, 
                'bankaddress'=> $bankaddress, 
                'swiftcode'=> $swiftcode, 
                'ifscno'=> $ifscno, 
                'intemediarybank'=> $intemediarybank, 
                'inteswiftcode'=> $inteswiftcode, 
                'accountinstitution'=> $accountinstitution, 
                'insswiftcode'=> $insswiftcode,
                'updateuser'=> $userID, 
                'updatedatetime' => $updatedatetime,
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
    }
    public function Customerstatus($x, $y){
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

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
    }
    public function Customeredit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customer');
        $this->db->where('idtbl_customer', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customer;
        $obj->name=$respond->row(0)->name;
        $obj->code=$respond->row(0)->customercode;
        $obj->type=$respond->row(0)->customertype;
        $obj->contact=$respond->row(0)->contact;
        $obj->contact2=$respond->row(0)->contact2;
        $obj->email=$respond->row(0)->email;
        $obj->address=$respond->row(0)->address;
        $obj->gstinno=$respond->row(0)->gstinno;
        $obj->panno=$respond->row(0)->panno;
        $obj->ieccode=$respond->row(0)->ieccode;
        $obj->fssaino=$respond->row(0)->fssaino;
        $obj->bank=$respond->row(0)->bankname;
        $obj->branch=$respond->row(0)->bankbranch;
        $obj->accountnum=$respond->row(0)->accountno;
        $obj->account=$respond->row(0)->accountname;
        $obj->bankaddress=$respond->row(0)->bankaddress;
        $obj->swiftcode=$respond->row(0)->swiftcode;
        $obj->ifscno=$respond->row(0)->ifscno;
        $obj->intemediarybank=$respond->row(0)->intemediarybank;
        $obj->inteswiftcode=$respond->row(0)->inteswiftcode;
        $obj->accountinstitution=$respond->row(0)->accountinstitution;
        $obj->insswiftcode=$respond->row(0)->insswiftcode;


        echo json_encode($obj);
    }
}