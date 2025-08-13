<?php
class Productinfo extends CI_Model{
    public function Getmaterial(){
        $this->db->select('`idtbl_material_code`, `materialname`, `materialcode`');
        $this->db->from('tbl_material_code');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getform(){
        $this->db->select('`idtbl_form`, `formname`, `formcode`');
        $this->db->from('tbl_form');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getgrade(){
        $this->db->select('`idtbl_grade`, `gradename`, `gradecode`');
        $this->db->from('tbl_grade');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getbrand(){
        $this->db->select('`idtbl_brand`, `brandname`, `brandcode`');
        $this->db->from('tbl_brand');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsize(){
        $this->db->select('`idtbl_size`, `sizename`, `sizecode`');
        $this->db->from('tbl_size');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Gettype(){
        $this->db->select('`idtbl_unit_type`, `unittypename`, `unittypecode`');
        $this->db->from('tbl_unit_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Productinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $materialcode='';

        $materialname=$this->input->post('materialcode');
        $materialmaincode = $this->Productinfo->Getmaterialcode($materialname);
        $materialcode.=$materialmaincode;


        if(!empty($this->input->post('form'))){
            $form=$this->input->post('form');
            $formcode = $this->Productinfo->Getformcode($form);
            $materialcode.='_'.$formcode;
        }else{$form=0;}
        if(!empty($this->input->post('grade'))){
            $grade=$this->input->post('grade');
            $gradecode = $this->Productinfo->Getgradecode($grade);
            $materialcode.='_'.$gradecode;
        }else{$grade=0;}
        if(!empty($this->input->post('brand'))){
            $brand=$this->input->post('brand');
            $brandcode = $this->Productinfo->Getbrandcode($brand);
            $materialcode.='_'.$brandcode;
        }else{$brand=0;}
        if(!empty($this->input->post('size'))){
            $size=$this->input->post('size');
            $sizecode = $this->Productinfo->Getsizecode($size);
            $materialcode.='_'.$sizecode;
        }else{$size=0;}
        if(!empty($this->input->post('type'))){
            $unittype=$this->input->post('type');
            $unittypecode = $this->Productinfo->Getunittypecode($unittype);
            $materialcode.='_'.$unittypecode;
        }else{$unittype=0;}
        if(!empty($this->input->post('weight'))){
            $weight=$this->input->post('weight');
            $materialcode.='_'.$weight;
        }else{$weight=0;}

        $desc=$this->input->post('desc');  
        $retailprice=$this->input->post('retailprice'); 
        // $wholesaleprice=$this->input->post('wholesaleprice'); 
        $barcode=$this->input->post('barcode'); 

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'barcode'=> $barcode, 
                'productcode'=> 'FG'.'_'.$materialcode, 
                'desc'=> $desc, 
                'weight'=> $weight, 
                'materialid'=> $materialname, 
                'formid'=> $form, 
                'gradeid'=> $grade, 
                'brandid'=> $brand, 
                'sizeid'=> $size, 
                'typeid'=> $unittype, 
                'retailprice'=> $retailprice, 
                'wholesaleprice'=> '0', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_product', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Insert Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else{
            $data = array(
                'barcode'=> $barcode, 
                'productcode'=> 'FG'.'_'.$materialcode, 
                'desc'=> $desc, 
                'weight'=> $weight, 
                'materialid'=> $materialname, 
                'formid'=> $form, 
                'gradeid'=> $grade, 
                'brandid'=> $brand, 
                'sizeid'=> $size, 
                'typeid'=> $unittype, 
                'retailprice'=> $retailprice, 
                'wholesaleprice'=> '0', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);
 
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
                redirect('Product');                
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
                redirect('Product');
            }
        }
    }
    public function Productstatus($x, $y){
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

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

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
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

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
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

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
                redirect('Product');                
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
                redirect('Product');
            }
        }
    }
    public function Productedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_product');
        $this->db->where('idtbl_product', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_product;
        $obj->barcode=$respond->row(0)->barcode;
        $obj->desc=$respond->row(0)->desc;
        $obj->weight=$respond->row(0)->weight;
        $obj->materialcode=$respond->row(0)->materialid;
        $obj->form=$respond->row(0)->formid;
        $obj->grade=$respond->row(0)->gradeid;
        $obj->brand=$respond->row(0)->brandid;
        $obj->size=$respond->row(0)->sizeid;
        $obj->type=$respond->row(0)->typeid;
        $obj->retailprice=$respond->row(0)->retailprice;
        // $obj->wholesaleprice=$respond->row(0)->wholesaleprice;

        echo json_encode($obj);
    }
    public function Getbrandcode($brand){
        $this->db->select('brandcode');
        $this->db->from('tbl_brand');
        $this->db->where('idtbl_brand', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->brandcode;
    }
    public function Getformcode($form){
        $this->db->select('formcode');
        $this->db->from('tbl_form');
        $this->db->where('idtbl_form', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->formcode;
    }
    public function Getgradecode($grade){
        $this->db->select('gradecode');
        $this->db->from('tbl_grade');
        $this->db->where('idtbl_grade', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->gradecode;
    }
    public function Getsizecode($size){
        $this->db->select('sizecode');
        $this->db->from('tbl_size');
        $this->db->where('idtbl_size', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->sizecode;
    }
    public function Getunittypecode($unittype){
        $this->db->select('unittypecode');
        $this->db->from('tbl_unit_type');
        $this->db->where('idtbl_unit_type', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->unittypecode;
    }
    public function Getmaterialcode($materialname){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('idtbl_material_code', $materialname);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getweight($weight){
        $this->db->select('weight');
        $this->db->from('tbl_product');
        $this->db->where('idtbl_product', $weight);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->weight;
    }
    public function Finishgoodlupload(){
        $this->db->trans_begin();
        $i=0;

        $userID=$_SESSION['userid'];

		$filename=$_FILES['csvfile']['tmp_name'];
        $updatedatetime=date('Y-m-d h:i:s');

        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {

            if($i>0 && $line[0]!=''){
                $materialcode='';
                $material=$line[0];
                $materialmaincode = $this->Productinfo->Getmaterialcodename($material);
                $materialcode.=$materialmaincode;

                $materialid=$line[4];
                if(!empty($materialid)){
                    $materialcodeid = $this->Productinfo->Getmaterialid($materialid);
                }else{$materialcodeid=0;}

                $formcodeid=$line[5];
                if(!empty($formcodeid)){
                    $formcode = $this->Productinfo->Getformid($formcodeid);
                    $materialcode.='_'.$formcodeid;
                }else{$formcode=0;}
                
                $gradeid=$line[6];
                if(!empty($gradeid)){
                    $grade = $this->Productinfo->Getgradeid($gradeid);
                    $materialcode.='_'.$gradeid;
                }else{$grade=0;}

                $brandid=$line[7];
                if(!empty($brandid)){
                    $brand = $this->Productinfo->Getbrandid($brandid);
                    $materialcode.='_'.$brandid;
                }else{$brand=0;}
                
                $sizeid=$line[8];
                if(!empty($sizeid)){
                    $size = $this->Productinfo->Getsizeid($sizeid);
                    $materialcode.='_'.$sizeid;
                }else{$size=0;}

                $unittypecode=$line[9];
                if(!empty($unittypecode)){
                    $unittype = $this->Productinfo->Getunittypeid($unittypecode);
                    $materialcode.='_'.$unittypecode;
                }else{$unittype=0;}   
                
                $barcode=$line[1];
                $desc=$line[2];
                $weight=$line[3];
                $retailprice=$line[10];
                // $wholesaleprice=$line[11];


                $data = array(
                    'barcode'=> $barcode, 
                    'productcode'=> "FG"."_".$materialcode."_".$weight, 
                    'desc'=> $desc, 
                    'weight'=> $weight, 
                    'materialid'=> $materialcodeid, 
                    'formid'=> $formcode, 
                    'gradeid'=> $grade, 
                    'brandid'=> $brand, 
                    'sizeid'=> $size, 
                    'typeid'=> $unittype, 
                    'retailprice'=> $retailprice,
                    'wholesaleprice'=> '0',
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
    
                $this->db->insert('tbl_product', $data);
            }
            $i++;
        }
        fclose($file);

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
            redirect('Product');                
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
            redirect('Product');
        }
    }
    public function Getmaterialcodename($material){
        $this->db->select('materialcode');
        $this->db->from('tbl_material_code');
        $this->db->where('materialname', $material);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->materialcode;
    }
    public function Getmaterialid($materialcodeid){
        $this->db->select('idtbl_material_code');
        $this->db->from('tbl_material_code');
        $this->db->where('materialcode', $materialcodeid);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_material_code;
    }
    public function Getbrandid($brand){
        $this->db->select('idtbl_brand');
        $this->db->from('tbl_brand');
        $this->db->where('brandcode', $brand);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_brand;
    }
    public function Getformid($form){
        $this->db->select('idtbl_form');
        $this->db->from('tbl_form');
        $this->db->where('formcode', $form);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_form;
    }
    public function Getgradeid($grade){
        $this->db->select('idtbl_grade');
        $this->db->from('tbl_grade');
        $this->db->where('gradecode', $grade);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_grade;
    }
    public function Getsizeid($size){
        $this->db->select('idtbl_size');
        $this->db->from('tbl_size');
        $this->db->where('sizecode', $size);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_size;
    }
    public function Getunittypeid($unittype){
        $this->db->select('idtbl_unit_type');
        $this->db->from('tbl_unit_type');
        $this->db->where('unittypecode', $unittype);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        return $respond->row(0)->idtbl_unit_type;
    }
    public function checkBarcode() {
        $barcode = $this->input->post('barcode');

        $this->db->select('barcode');
        $this->db->from('tbl_product');
        $this->db->where('barcode', $barcode);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
          $response = array('success' => true, 'message' => 'The barcode you entered exists in the database.!');
        } else {
          $response = array('success' => false);
        }
        echo json_encode($response);
    }

    public function Getproductinfo() {
        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT 
        `u`.`idtbl_product`,
        `ub`.`materialname`,
        `u`.`barcode`,
        `u`.`productcode`,
        `u`.`weight`,
        `u`.`retailprice`,
        `u`.`wholesaleprice`,
        `ub`.`materialcode`,
        `uc`.`formname`,
        `ud`.`gradename`,
        `ue`.`brandname`,
        `uf`.`sizename`,
        `ug`.`unittypecode`,
        `u`.`status`
    FROM 
        `tbl_product` AS `u`
        LEFT JOIN `tbl_material_code` AS `ub` ON `u`.`materialid` = `ub`.`idtbl_material_code` 
        LEFT JOIN `tbl_form` AS `uc` ON `u`.`formid` = `uc`.`idtbl_form`
        LEFT JOIN `tbl_grade` AS `ud` ON `u`.`gradeid` = `ud`.`idtbl_grade`
        LEFT JOIN `tbl_brand` AS `ue` ON `u`.`brandid` = `ue`.`idtbl_brand`
        LEFT JOIN `tbl_size` AS `uf` ON `u`.`sizeid` = `uf`.`idtbl_size`
        LEFT JOIN `tbl_unit_type` AS `ug` ON `u`.`typeid` = `ug`.`idtbl_unit_type` WHERE `u`.`idtbl_product`=?";

        $respond=$this->db->query($sql, array($recordID));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>
            		<label for="">Material Name : <span>&nbsp;'.$rowlist->materialname.'</span></label>
            	</li>
            	<li>
            		<label for="">Barcode : <span>&nbsp;'.$rowlist->barcode.'</span></label>
            	</li>
            	<li>
            		<label for="">FG Code : <span>&nbsp;'.$rowlist->productcode.'</span></label>
            	</li>
            	<li>
            		<label for="">Weight : <span>&nbsp;'.$rowlist->weight.'</span></label>
            	</li>
            	<li>
            		<label for="">Retail Price : <span>&nbsp;'.$rowlist->retailprice.'</span></label>
            	</li>
            	<li>
            		<label for="">Material Code : <span>&nbsp;'.$rowlist->materialcode.'</span></label>
            	</li>
            	<li>
            		<label for="">Form Code : <span>&nbsp;'.$rowlist->formname.'</span></label>
            	</li>
            	<li>
            		<label for="">Grade Code : <span>&nbsp;'.$rowlist->gradename.'</span></label>
            	</li>
            	<li>
            		<label for="">Brand Code : <span>&nbsp;'.$rowlist->brandname.'</span></label>
            	</li>
            	<li>
            		<label for="">Size Code : <span>&nbsp;'.$rowlist->sizename.'</span></label>
            	</li>
            	<li>
            		<label for="">Unit Type Code : <span>&nbsp;'.$rowlist->unittypecode.'</span></label>
            	</li>
            </ul>
            ';
        }

        echo $html;
    }
}