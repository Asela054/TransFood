<?php
class Semibominfo extends CI_Model{
    public function Semibominsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $semibomtitle=$this->input->post('semibomtitle');
        $finishgood=$this->input->post('finishgood');
        $materialcategory=$this->input->post('materialcategory');
        $materialinfo=$this->input->post('materialinfo');
        $qty=$this->input->post('qty');
        $wastage=$this->input->post('wastage');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        // print_r($materialinfo);

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $datamain = array(
                'title'=> $semibomtitle,
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_semi_bom_info', $datamain);

            $bominfoID=$this->db->insert_id();

            $i=0;
            foreach($materialcategory as $materialcate){
                $matcate=$materialcate;
                $matinfo=$materialinfo[$i];
                $qtylist=$qty[$i];
                $wastagelist=$wastage[$i];

                $data = array(
                    'qty'=>$qtylist, 
                    'wastage'=>$wastagelist, 
                    'status'=>'1', 
                    'insertdatetime'=>$updatedatetime, 
                    'tbl_user_idtbl_user'=>$userID, 
                    'semimaterial'=>$finishgood, 
                    'tbl_material_info_idtbl_material_info'=>$matinfo,
                    'tbl_semi_bom_info_idtbl_semi_bom_info'=>$bominfoID
                );
                $this->db->insert('tbl_semi_bom', $data);
                $i++;
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
                redirect('Semibom');                
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
                redirect('Semibom');
            }
        }
        else{
            $datamain = array(
                'title'=> $semibomtitle,
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom_info', $datamain);

            $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $recordID);
            $this->db->delete('tbl_semi_bom');

            $i=0;
            foreach($materialcategory as $materialcate){
                $matcate=$materialcate;
                $matinfo=$materialinfo[$i];
                $qtylist=$qty[$i];
                $wastagelist=$wastage[$i];

                $data = array(
                    'qty'=>$qtylist, 
                    'wastage'=>$wastagelist, 
                    'status'=>'1', 
                    'insertdatetime'=>$updatedatetime, 
                    'tbl_user_idtbl_user'=>$userID, 
                    'semimaterial'=>$finishgood, 
                    'tbl_material_info_idtbl_material_info'=>$matinfo,
                    'tbl_semi_bom_info_idtbl_semi_bom_info'=>$recordID
                );
                $this->db->insert('tbl_semi_bom', $data);
                $i++;
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
                redirect('Semibom');                
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
                redirect('Semibom');
            }
        }
    }
    public function Semibomstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $datamain = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom_info', $datamain);

            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom', $data);

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
                redirect('Semibom');                
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
                redirect('Semibom');
            }
        }
        else if($type==2){
            $datamain = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom_info', $datamain);
            
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom', $data);

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
                redirect('Semibom');                
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
                redirect('Semibom');
            }
        }
        else if($type==3){
            $datamain = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom_info', $datamain);

            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $recordID);
            $this->db->update('tbl_semi_bom', $data);

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
                redirect('Semibom');                
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
                redirect('Semibom');
            }
        }
    }
    public function Semibomedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`idtbl_semi_bom_info`, `title`');
        $this->db->from('tbl_semi_bom_info');
        $this->db->where('idtbl_semi_bom_info', $recordID);

        $respond=$this->db->get();

        $this->db->select('`qty`, `wastage`, `semimaterial`, `tbl_material_info_idtbl_material_info`');
        $this->db->from('tbl_semi_bom');
        $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $recordID);

        $respondinfo=$this->db->get();  

        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);
        $this->db->where('idtbl_material_category', 1);

        $respondcategory=$this->db->get();

        $semimaterialID=0;
        $i=1;
        $html='';
        foreach($respondinfo->result() AS $rowlist){
            $semimaterialID=$rowlist->semimaterial;
            $materialID=$rowlist->tbl_material_info_idtbl_material_info;

            $sqlmaterialinfo="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIn `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_material_info`.`status`=?";
            $respondmaterialinfo=$this->db->query($sqlmaterialinfo, array(1, 1));

            $html.='
            <div class="dynamic-field" id="dynamic-field-'.$i.'">
                <div class="form-row mb-1">
                    <div class="col-3">
                        <label class="small font-weight-bold">Material Category*</label><br>
                        <select class="form-control form-control-sm materialcate" name="materialcategory[]" id="materialcategory" required>
                            <option value="">Select</option>';
                            foreach($respondcategory->result() as $rowmaterialcategory){
                                $html.='<option value="'.$rowmaterialcategory->idtbl_material_category.'" selected>'.$rowmaterialcategory->categoryname.'-'.$rowmaterialcategory->categorycode.'</option>';
                            }
                        $html.='</select>
                    </div>
                    <div class="col-3">
                        <label class="small font-weight-bold">Material*</label><br>
                        <select class="form-control form-control-sm materialinfo" style="width: 100%;" name="materialinfo[]" id="materialinfo" required>
                            <option value="">Select</option>';
                            foreach($respondmaterialinfo->result() as $rowmaterialinfo){
                                $html.='<option value="'.$rowmaterialinfo->idtbl_material_info.'" ';if($rowmaterialinfo->idtbl_material_info==$rowlist->tbl_material_info_idtbl_material_info){$html.='selected';}$html.='>'.$rowmaterialinfo->materialname.' - '.$rowmaterialinfo->materialinfocode.'/'.$rowmaterialinfo->unitcode.'</option>';

                                if($rowmaterialinfo->idtbl_material_info==$rowlist->tbl_material_info_idtbl_material_info){$unitcode=$rowmaterialinfo->unitcode;}
                            }
                        $html.='</select>
                    </div>
                    <div class="col-3">
                        <label class="small font-weight-bold">Quantity*</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-sm col-10" name="qty[]" id="qty" value="'.$rowlist->qty.'" required>
                            <input type="text" id="unit" name="unit" class="form-control form-control-sm col-2" value="'.$unitcode.'" readonly>
                        </div>
                    </div>
                    <div class="col-3">
                        <label class="small font-weight-bold">Wastage %*</label><br>
                        <input type="text" class="form-control form-control-sm" name="wastage[]" id="wastage" value="'.$rowlist->wastage.'" required>
                    </div>
                </div>
            </div>
            ';
            $i++;
        }
        $sqlsemimaterial="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`semistatus`=? AND `tbl_material_info`.`idtbl_material_info`=?";
        $respondsemimaterial=$this->db->query($sqlsemimaterial, array(1, $semimaterialID)); 

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_semi_bom_info;
        $obj->title=$respond->row(0)->title;
        $obj->semimaterialID=$semimaterialID;
        $obj->materialname=$respondsemimaterial->row(0)->materialname;
        $obj->materialinfocode=$respondsemimaterial->row(0)->materialinfocode;
        $obj->bominfo=$html;

        echo json_encode($obj);
    }
    public function GetSemimateriallist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 10";
            $respond=$this->db->query($sql, array(1, 1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? AND `tbl_material_info`.`materialinfocode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 1));    
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 10";
                $respond=$this->db->query($sql, array(1, 1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode);
        }
        
        echo json_encode($data);
    }
    public function Getmaterialinfolist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));           
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`materialinfocode` LIKE '%$searchTerm%'";
                $respond=$this->db->query($sql, array(1));
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode);
        }
        
        echo json_encode($data);
    }
    public function Getmaterialcategory(){
        $this->db->select('`idtbl_material_category`, `categoryname`, `categorycode`');
        $this->db->from('tbl_material_category');
        $this->db->where('status', 1);
        $this->db->where('idtbl_material_category', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialname(){
        $this->db->select('`idtbl_material_info`, `materialname`, `materialinfocode`, `unitcode`');
        $this->db->from('tbl_material_info');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->join('tbl_unit', 'tbl_unit.idtbl_unit = tbl_material_info.tbl_unit_idtbl_unit', 'left');
        $this->db->where('tbl_material_info.status', 1);

        return $respond=$this->db->get();
    }
    public function Getmaterialinfo(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIn `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_material_info`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    } 
    public function Semibomdetails(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_semi_bom`.`idtbl_semi_bom`, `tbl_semi_bom`.`qty`, `tbl_semi_bom`.`wastage`, `tbl_material_category`.`categoryname`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_semi_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_semi_bom`.`status`=? AND `tbl_semi_bom`.`tbl_semi_bom_info_idtbl_semi_bom_info`=?";
        $respond=$this->db->query($sql, array(1, $recordID));


        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
            	<td>'.$rowlist->categoryname.'</td>
            	<td>'.$rowlist->materialname.'-'.$rowlist->materialinfocode.'</td>
            	<td>'.$rowlist->qty.$rowlist->unitcode.'</td>
            	<td>'.$rowlist->wastage.'%</td>
            	<td>
            		<div class="row ml-5"><button type="button" id="'.$rowlist->idtbl_semi_bom.'"
            				class="btnEditbom btn btn-primary btn-sm float-right" data-toggle="modal"
            				data-target="#exampleModal">
            				<i class="fas fa-pen"></i>
            			</button>
            			<button type="button" id="'.$rowlist->idtbl_semi_bom.'"
            				class="btnDeletebom btn btn-danger btn-sm float-left ml-1" onclick="confirmation()">
            				<i class="fas fa-trash-alt"></i>
            			</button>
            		</div>
            	</td>

            </tr>
            
            ';
        }

        echo $html;
    }
    public function Semibomlist(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_semi_bom.idtbl_semi_bom, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.qty, tbl_semi_bom.wastage, tbl_material_category.categoryname , tbl_material_code.materialname, tbl_material_code.materialcode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->where('tbl_semi_bom.idtbl_semi_bom', $recordID);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_semi_bom;
        $obj->materialcategory=$respond->row(0)->categoryname;
        $obj->materialinfo=$respond->row(0)->tbl_material_info_idtbl_material_info ;
        $obj->qty=$respond->row(0)->qty;
        $obj->wastage=$respond->row(0)->wastage;


        echo json_encode($obj);
    }
    public function Semibomlistedit(){
        $userID=$_SESSION['userid'];

        $materialinfo=$this->input->post('name');
        $qty=$this->input->post('quantity');
        $wastage=$this->input->post('wastagepresentage');

        $recordID=$this->input->post('recordID');

        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'qty'=>$qty, 
            'wastage'=>$wastage, 
            'status'=> '1', 
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime, 
            'tbl_material_info_idtbl_material_info'=>$materialinfo
        );

        $this->db->where('idtbl_semi_bom', $recordID);
        $this->db->update('tbl_semi_bom', $data);

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
            redirect('Semibom');                
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
            redirect('Semibom');
        }
    }
    public function Semibomdelete(){
        $recordID=$this->input->post('recordID');
        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'status'=> '3', 
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_semi_bom', $recordID);
        $this->db->update('tbl_semi_bom', $data);
    }
    public function Semibomalllist(){
        $mainarray=array();

        $this->db->select('tbl_semi_bom.idtbl_semi_bom, tbl_semi_bom.semimaterial, tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info, tbl_material_info.materialinfocode, tbl_material_code.materialname');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.semimaterial', 'left');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->where('tbl_semi_bom.status', 1);
        $this->db->group_by("tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info");

        $respond=$this->db->get();

        foreach($respond->result() as $rowsemibomlist){
            $recordID=$rowsemibomlist->tbl_semi_bom_info_idtbl_semi_bom_info;

            $sqlbom="SELECT `tbl_semi_bom`.`idtbl_semi_bom`, `tbl_semi_bom`.`qty`, `tbl_semi_bom`.`wastage`, `tbl_material_category`.`categoryname`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_semi_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_semi_bom`.`status`=? AND `tbl_semi_bom`.`tbl_semi_bom_info_idtbl_semi_bom_info`=?";
            $respondbom=$this->db->query($sqlbom, array(1, $recordID));

            $obj=new stdClass();
            $obj->idtbl_semi_bom=$rowsemibomlist->idtbl_semi_bom;
            $obj->semimaterial=$rowsemibomlist->semimaterial;
            $obj->materialinfocode=$rowsemibomlist->materialinfocode;
            $obj->materialname=$rowsemibomlist->materialname;
            $obj->bomlist=$respondbom->result();

            array_push($mainarray, $obj);
        }

        $html='';
        $html.='
        <table class="table table-bordered table-striped table-sm nowrap" id="dataTableview">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Semi Material Code / Material Code</th>
                    <th>Semi Material Name / Material Name</th>
                    <th class="text-center">Qty / Unit</th>
                    <th class="text-center">Wastage</th>
                </tr>
            </thead>
            <tbody>
        ';
        $i=1;
        foreach($mainarray AS $rowdatalist){
            $html.='
                <tr class="table-info">
                    <td>'.$i.'</td>
                    <td>'.$rowdatalist->materialinfocode.'</td>
                    <td>'.$rowdatalist->materialname.'</td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                </tr>
            ';
            foreach($rowdatalist->bomlist as $rowbomlist){
                $html.='
                    <tr>
                        <td>&nbsp;</td>
                        <td>'.$rowbomlist->materialinfocode.'</td>
                        <td>'.$rowbomlist->materialname.'</td>
                        <td class="text-center">'.$rowbomlist->qty.$rowbomlist->unitcode.'</td>
                        <td class="text-center">'.$rowbomlist->wastage.'%</td>
                    </tr>
                ';
            }
            $i++;
        }
        $html.='</tbody></table>';

        echo $html;
    }
    public function Getothercosttype(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `idtbl_expence_type`, `expencetype` FROM `tbl_expence_type` WHERE `status`=?";
        $respond=$this->db->query($sql, array(1));  

        echo json_encode($respond->result());
    }
    public function SemiBomOtherCostInsertUpdate(){
        $userID=$_SESSION['userid'];

        $tabledata=json_decode($this->input->post('tabledata'));
        $hidebomid=$this->input->post('hidebomid');

        $this->db->trans_begin();

        $this->db->where('tbl_semi_bom_info_idtbl_semi_bom_info', $hidebomid);
        $this->db->delete('tbl_semi_bom_info_has_tbl_semi_bom_other_cost');

        foreach($tabledata as $rowtabledata){
            $data = array(
                'tbl_semi_bom_info_idtbl_semi_bom_info'=>$hidebomid, 
                'tbl_semi_bom_other_cost_idtbl_semi_bom_other_cost'=>$rowtabledata->othercostid, 
            );

            $this->db->insert('tbl_semi_bom_info_has_tbl_semi_bom_other_cost', $data);
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
            $actionObj->icon='fas fa-warning';
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
    public function SemiBomCostEdit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_semi_bom_other_cost');
        $this->db->where('idtbl_semi_bom_other_cost', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_semi_bom_other_cost;
        $obj->perunit=$respond->row(0)->perunit;
        $obj->expencestype=$respond->row(0)->tbl_expence_type_idtbl_expence_type ;

        echo json_encode($obj);
    }
    public function SemiBomCostStatus(){
        $userID=$_SESSION['userid'];
        $recordID=$this->input->post('recordID');
        $type=$this->input->post('type');
        
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $this->db->trans_begin();
            $datamain = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_other_cost', $recordID);
            $this->db->update('tbl_semi_bom_other_cost', $datamain);

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
                
                $obj=new stdClass();
                $obj->status=1;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);                 
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
                
                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj); 
            }
        }
        else if($type==2){
            $this->db->trans_begin();
            $datamain = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_other_cost', $recordID);
            $this->db->update('tbl_semi_bom_other_cost', $datamain);

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
                
                $obj=new stdClass();
                $obj->status=1;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);             
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
                
                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj); 
            }
        }
        else if($type==3){
            $this->db->trans_begin();
            $datamain = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_bom_other_cost', $recordID);
            $this->db->update('tbl_semi_bom_other_cost', $datamain);

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
                
                $obj=new stdClass();
                $obj->status=1;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);            
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
                
                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj); 
            }
        }
    }
}

