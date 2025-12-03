<?php
class Productinfo extends CI_Model{
    public function Productinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $materialcode='';

        $productname=$this->input->post('productname');
        $productcode=$this->input->post('productcode'); 
        $desc=$this->input->post('desc');  
        $weight=$this->input->post('weight');  
        $retailprice=$this->input->post('retailprice'); 
        $retailpriceusd=$this->input->post('retailpriceusd'); 
        $pktperctn=$this->input->post('pktperctn'); 
        $masterctn=$this->input->post('masterctn'); 

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        $imagePath = '';

        if (!empty($_FILES['productimage']['name'])) {

            $config['upload_path']   = FCPATH . 'images/ProductImg/'; // ✅ Correct full path
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 2048;
            $config['encrypt_name'] = TRUE; // ✅ safer file name

            $this->load->library('upload');
            $this->upload->initialize($config); // ✅ VERY IMPORTANT

            if ($this->upload->do_upload('productimage')) {
                $uploadData = $this->upload->data();
                $imagePath = 'images/ProductImg/' . $uploadData['file_name']; // ✅ DB Path
            } else {
                // ✅ SHOW UPLOAD ERROR (THIS WILL TELL US EXACT ISSUE)
                echo $this->upload->display_errors();
                exit;
            }
        }

        if($recordOption==1){
            $data = array(
                'prodcutname'=> $productname, 
                'productcode'=> $productcode, 
                'productimg'=> $imagePath,
                'desc'=> $desc, 
                'weight'=> $weight, 
                'retailprice'=> $retailprice, 
                'retailpriceusd'=> $retailpriceusd, 
                'wholesaleprice'=> '0', 
                'nopckperctn'=> $pktperctn, 
                'mastercartoon'=> $masterctn, 
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
                'prodcutname'=> $productname, 
                'productcode'=> $productcode, 
                'desc'=> $desc, 
                'weight'=> $weight, 
                'retailprice'=> $retailprice, 
                'retailpriceusd'=> $retailpriceusd, 
                'wholesaleprice'=> '0', 
                'nopckperctn'=> $pktperctn, 
                'mastercartoon'=> $masterctn, 
                'updatedatetime'=> $updatedatetime, 
                'updateuser'=> $userID,
            );

            if($imagePath != ''){
                $data['productimg'] = $imagePath;
            }


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
    public function Stockupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $qty=$this->input->post('qty');
        $unitprice=$this->input->post('unitprice');
        $hideproductid=$this->input->post('hidestockproductid');
        $updatedatetime=date('Y-m-d H:i:s');  

        $batchno = date('dmY') . $hideproductid;

            $data = array(
                'fgbatchno'=> $batchno, 
                'qty'=> $qty, 
                'unitprice'=> $unitprice, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_product_idtbl_product'=> $hideproductid, 
                'tbl_location_idtbl_location'=> '1', 
                'tbl_company_idtbl_company'=> '1', 
                'tbl_company_branch_idtbl_company_branch'=> '1'
            );

            $this->db->insert('tbl_product_stock', $data);

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
        $obj->prodcutname=$respond->row(0)->prodcutname;
        $obj->productcode=$respond->row(0)->productcode;
        $obj->desc=$respond->row(0)->desc;
        $obj->weight=$respond->row(0)->weight;
        $obj->retailprice=$respond->row(0)->retailprice;
        $obj->retailpriceusd=$respond->row(0)->retailpriceusd;
        $obj->nopckperctn=$respond->row(0)->nopckperctn;
        $obj->mastercartoon=$respond->row(0)->mastercartoon;

        echo json_encode($obj);
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
                $productname=$line[0];
                $productcode=$line[1]; 
                $desc=$line[2];  
                $weight=$line[3];  
                $retailprice=$line[04]; 
                $pktperctn=$line[5]; 
                $masterctn=$line[6];

                $data = array(
                    'prodcutname'=> $productname, 
                    'productcode'=> $productcode, 
                    'desc'=> $desc, 
                    'weight'=> $weight, 
                    'retailprice'=> $retailprice, 
                    'wholesaleprice'=> '0', 
                    'nopckperctn'=> $pktperctn, 
                    'mastercartoon'=> $masterctn, 
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