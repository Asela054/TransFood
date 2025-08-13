<?php
class Userinfo extends CI_Model{
    public function locationlist(){
        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function LoginUser(){
        $username=$this->input->post('username');
        $password=md5($this->input->post('password'));
        
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->join('tbl_user_type', 'tbl_user_type.idtbl_user_type = tbl_user.tbl_user_type_idtbl_user_type');
        $this->db->where('tbl_user.username', $username);
        $this->db->where('tbl_user.password', $password);
        $this->db->where('tbl_user.status', 1);
        
        $respond=$this->db->get();
        if($respond->num_rows()==1){            
            return $respond->row(0);
        }
        else{
            return false; 
        }
    }
    public function Usertype(){
        $this->db->select('idtbl_user_type, type');
        $this->db->from('tbl_user_type');

        return $respond=$this->db->get();
    }
    public function Useraccountedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('idtbl_user', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_user;
        $obj->name=$respond->row(0)->name;
        $obj->username=$respond->row(0)->username;
        $obj->type=$respond->row(0)->tbl_user_type_idtbl_user_type;
        $obj->location=$respond->row(0)->location_id;

        echo json_encode($obj);
    }
    public function Useraccountinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $accountname=$this->input->post('accountname');
        $username=$this->input->post('username');
        if(!empty($this->input->post('password'))){$password=md5($this->input->post('password'));}
        $usertype=$this->input->post('usertype');
        $location=$this->input->post('location');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'name'=>$accountname, 
                'username'=>$username, 
                'password'=>$password, 
                'status'=>'1', 
                'insertdatetime'=>$updatedatetime, 
                'tbl_user_type_idtbl_user_type'=>$usertype,
                'location_id'=>$location
            );

            $this->db->insert('tbl_user', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else{
            if(!empty($this->input->post('password'))){
                $data = array(
                    'name'=>$accountname, 
                    'username'=>$username, 
                    'password'=>$password,
                    'updateuser'=>$userID, 
                    'updatedatetime'=>$updatedatetime, 
                    'tbl_user_type_idtbl_user_type'=>$usertype,
                    'location_id'=>$location
                );
    
                $this->db->where('idtbl_user', $recordID);
                $this->db->update('tbl_user', $data);
            }
            else{
                $data = array(
                    'name'=>$accountname, 
                    'username'=>$username, 
                    'updateuser'=>$userID, 
                    'updatedatetime'=>$updatedatetime, 
                    'tbl_user_type_idtbl_user_type'=>$usertype,
                    'location_id'=>$location
                );
    
                $this->db->where('idtbl_user', $recordID);
                $this->db->update('tbl_user', $data);
            }

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
    }
    public function Useraccountstatus($x, $y){
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

            $this->db->where('idtbl_user', $recordID);
            $this->db->update('tbl_user', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user', $recordID);
            $this->db->update('tbl_user', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user', $recordID);
            $this->db->update('tbl_user', $data);

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
                redirect('User/Useraccount');                
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
                redirect('User/Useraccount');
            }
        }
    }
    public function Usertypeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_user_type');
        $this->db->where('idtbl_user_type', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_user_type;
        $obj->type=$respond->row(0)->type;

        echo json_encode($obj);
    }
    public function Usertypeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $usertype=$this->input->post('usertype');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'type'=> $usertype,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime
            );

            $this->db->insert('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else{
            $data = array(
                'type'=> $usertype,
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
    }
    public function Usertypestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;

        if($type==1){
            $data = array(
                'status' => '1',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_user_type', $recordID);
            $this->db->update('tbl_user_type', $data);

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
                redirect('User/Usertype');                
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
                redirect('User/Usertype');
            }
        }
    }
    public function Menulist(){
        $this->db->select('idtbl_menu_list, menu');
        $this->db->from('tbl_menu_list');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Useraccountmenu(){
        if($_SESSION['userid']==1){
            $this->db->select('idtbl_user, name');
            $this->db->from('tbl_user');
            $this->db->where('status', 1);
        }
        else{
            $this->db->select('idtbl_user, name');
            $this->db->from('tbl_user');
            $this->db->where('idtbl_user >', '1');
            $this->db->where('status', 1);
        }        

        return $respond=$this->db->get();
    }
    public function Userprivilegeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $userlist=$this->input->post('userlist');
        $menulist=$this->input->post('menulist');
        if(!empty($this->input->post('addcheck'))){$addcheck=$this->input->post('addcheck');}else{$addcheck=0;}
        if(!empty($this->input->post('editcheck'))){$editcheck=$this->input->post('editcheck');}else{$editcheck=0;}
        if(!empty($this->input->post('statuscheck'))){$statuscheck=$this->input->post('statuscheck');}else{$statuscheck=0;}
        if(!empty($this->input->post('removecheck'))){$removecheck=$this->input->post('removecheck');}else{$removecheck=0;}

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d h:i:s');

        if($recordOption==1){
            foreach($menulist as $rowmenulist){
                $data = array(
                    'add'=>$addcheck,
                    'edit'=>$editcheck,
                    'statuschange'=>$statuscheck,
                    'remove'=>$removecheck,
                    'access_status'=>'1',
                    'status'=>'1',
                    'insertdatetime'=>$updatedatetime,
                    'tbl_user_idtbl_user'=>$userlist,
                    'tbl_menu_list_idtbl_menu_list'=>$rowmenulist
                );

                $this->db->insert('tbl_user_privilege', $data);
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
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else{
            foreach($menulist as $rowmenulist){
                $data = array(
                    'add'=>$addcheck,
                    'edit'=>$editcheck,
                    'statuschange'=>$statuscheck,
                    'remove'=>$removecheck,
                    'access_status'=>'1',
                    'updateuser'=>$userID,
                    'updatedatetime'=>$updatedatetime,
                    'tbl_user_idtbl_user'=>$userlist,
                    'tbl_menu_list_idtbl_menu_list'=>$rowmenulist
                );

                $this->db->where('idtbl_user_privilege', $recordID);
                $this->db->update('tbl_user_privilege', $data);
            }

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
    }
    public function Userprivilegeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_user_privilege');
        $this->db->where('idtbl_user_privilege', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $menulistArray=array();
        $objmenulist=new stdClass();
        $objmenulist->menulistID=$respond->row(0)->tbl_menu_list_idtbl_menu_list;
        array_push($menulistArray, $objmenulist);

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_user_privilege;
        $obj->add=$respond->row(0)->add;
        $obj->edit=$respond->row(0)->edit;
        $obj->statuschange=$respond->row(0)->statuschange;
        $obj->remove=$respond->row(0)->remove;
        $obj->user=$respond->row(0)->tbl_user_idtbl_user;
        $obj->menu=$menulistArray;

        echo json_encode($obj);
    }
    public function Userprivilegestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d h:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=>$userID,
                'updatedatetime'=>$updatedatetime,
            );

            $this->db->where('idtbl_user_privilege', $recordID);
            $this->db->update('tbl_user_privilege', $data);

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=>$userID,
                'updatedatetime'=>$updatedatetime,
            );

            $this->db->where('idtbl_user_privilege', $recordID);
            $this->db->update('tbl_user_privilege', $data);

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=>$userID,
                'updatedatetime'=>$updatedatetime,
            );

            $this->db->where('idtbl_user_privilege', $recordID);
            $this->db->update('tbl_user_privilege', $data);

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
                redirect('User/Userprivilege');                
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
                redirect('User/Userprivilege');
            }
        }
    }
    public function Companybranchinfo(){
        $company=$this->input->post('company');
		$branch=$this->input->post('branch');
        
        $this->db->select('tbl_company.company, tbl_company_branch.branch');
        $this->db->from('tbl_company');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.tbl_company_idtbl_company = tbl_company.idtbl_company');
        $this->db->where('tbl_company.idtbl_company', $company);
        $this->db->where('tbl_company_branch.idtbl_company_branch', $branch);
        $this->db->where('tbl_company.status', 1);
        $this->db->where('tbl_company_branch.status', 1);
        
        $respond=$this->db->get();
        if($respond->num_rows()==1){            
            return $respond->row(0);
        }
        else{
            return false; 
        }
    }
}