<?php
class Qualitycheckinfo extends CI_Model{
    public function GRNqualityform(){
        $recordID=$this->input->post('recordID');

        $sqlgrn="SELECT `idtbl_grn`, `grndate` FROM `tbl_grn` WHERE `status`=? AND `idtbl_grn`=?";
        $respondgrn=$this->db->query($sqlgrn, array(1, $recordID));

        $sqlmaterial="SELECT `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`
        FROM `tbl_material_info`
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code`
        LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=`tbl_material_info`.`idtbl_material_info`
        WHERE `tbl_grndetail`.`status`=? AND `tbl_grndetail`.`tbl_grn_idtbl_grn`=? 
        AND `tbl_material_info`.`idtbl_material_info` NOT IN (SELECT `tbl_material_info_idtbl_material_info` FROM `tbl_grn_quality` WHERE `status`=? AND `tbl_grn_idtbl_grn`=?)";
        $respondmaterial=$this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));

        $r=1;
        $html='';

        $html.='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN#</label>
                <input type="text" name="grn" id="grn" class="form-control form-control-sm" value="'.$respondgrn->row(0)->idtbl_grn.'" readonly>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN DATE</label>
                <input type="text" name="grndate" id="grndate" class="form-control form-control-sm" value="'.$respondgrn->row(0)->grndate.'" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">Material</label>
                <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                    <option value="">Select</option>';
                    foreach($respondmaterial->result() AS $rowmateriallist){
                        $html.='<option value="'.$rowmateriallist->idtbl_material_info.'">'.$rowmateriallist->materialname.' - '.$rowmateriallist->materialinfocode.'</option>';
                    }
                $html.='</select>
            </div>
        </div>
        <div class="form-row">
        	<div class="col">
        		<label class="small font-weight-bold text-dark">GRN QUANTITY</label>
        		<input type="text" name="grnqty" id="grnqty" class="form-control form-control-sm" value="" readonly>
        	</div>
        </div>
        <div class="form-row">
        	<div class="col">
        		<label class="small font-weight-bold text-dark">ITEM DESCRIPTION</label>
        		<textarea name="itemdesc" id="itemdesc" class="form-control form-control-sm"></textarea>
        	</div>
        </div>
        ';
        $html.='
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                		<input type="text" name="exqty" id="exqty" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">MOISTURE LEVEL%</label>
                		<input type="text" name="moisture" id="moisture" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">ADULTERING</label>
                		<input type="text" name="adultering" id="adultering" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">FUNGI & PEST</label>
                		<input type="text" name="funginfest" id="funginfest" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">COLOR CONFIRMITY</label>
                		<input type="text" name="color" id="color" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">GRADE</label>
                		<input type="text" name="grade" id="grade" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">SIZE</label>
                		<input type="text" name="size" id="size" class="form-control form-control-sm">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">PASS/FAIL</label><br>
                		<div class="custom-control custom-radio custom-control-inline">
                			<input type="radio" id="passfail1" name="qualityform" class="custom-control-input"
                				value="1">
                			<label class="custom-control-label" for="passfail1">PASS</label>
                		</div>
                		<div class="custom-control custom-radio custom-control-inline">
                			<input type="radio" id="passfail2" name="qualityform" class="custom-control-input"
                				value="0" checked>
                			<label class="custom-control-label" for="passfail2">FAIL</label>
                		</div>
                	</div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">COMMENTS</label>
                        <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
             
                ';

        echo $html;
    }
    public function GRNqualityinsertupdate(){
        $this->db->trans_begin();

        $grnid=$this->input->post('hidegrnid');
        $examinedqty=$this->input->post('exqty');
        $moisturelevel=$this->input->post('moisture');
        $adultering=$this->input->post('adultering');
        $fungipest=$this->input->post('funginfest');
        $colorconfirmity=$this->input->post('color');
        $grade=$this->input->post('grade');
        $size=$this->input->post('size');
        $statuspassfail=$this->input->post('qualityform');
        $comments=$this->input->post('comment');
        $itemdesc=$this->input->post('itemdesc');
        $materialinfo=$this->input->post('materialinfo');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

            $data = array(
                'examined_qty'=> $examinedqty, 
                'moisture_level'=> $moisturelevel, 
                'adultering'=> $adultering, 
                'fungi_pest'=> $fungipest, 
                'color_confirmity'=> $colorconfirmity, 
                'grade'=> $grade, 
                'size'=> $size, 
                'statuspassfail'=> $statuspassfail, 
                'comments'=> $comments, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_grn_idtbl_grn'=> $grnid,
                'tbl_material_info_idtbl_material_info'=> $materialinfo,
            );

            $this->db->insert('tbl_grn_quality', $data);

        $data = array(
            'itemdesc'=> $itemdesc,
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime, 
        );

        $this->db->where('tbl_grn_idtbl_grn', $grnid);
        $this->db->where('tbl_material_info_idtbl_material_info', $materialinfo);
        $this->db->update('tbl_grndetail', $data);


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

    public function Qualitycheckstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        if($type==1){
            $data = array(
                'qualitycheck' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_grn', $recordID);
            $this->db->update('tbl_grn', $data);

            $this->db->select('`batchno`, `tbl_porder_idtbl_porder`, `tbl_location_idtbl_location`');
            $this->db->from('tbl_grn');
            $this->db->where('status', 1);
            $this->db->where('idtbl_grn', $recordID);

            $respondgrn=$this->db->get();

            $porderID=$respondgrn->row(0)->tbl_porder_idtbl_porder;

            $dataporder = array(
                'grnconfirm' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_porder', $porderID);
            $this->db->update('tbl_porder', $dataporder);

            $this->db->select('`qty`, `unitprice`, `costunitprice`, `tbl_material_info_idtbl_material_info`');
            $this->db->from('tbl_grndetail');
            $this->db->join('tbl_grn', 'tbl_grn.idtbl_grn = tbl_grndetail.tbl_grn_idtbl_grn', 'left');
            $this->db->where('tbl_grndetail.status', 1);
            $this->db->where('tbl_grn_idtbl_grn', $recordID);

            $respond=$this->db->get();

            foreach($respond->result() as $grnproductlist){
                $batchno = $respondgrn->row(0)->batchno;
                $location = $respondgrn->row(0)->tbl_location_idtbl_location;
                $qty = $grnproductlist->qty;
                $unitprice = $grnproductlist->unitprice;
                $costunitprice = $grnproductlist->costunitprice;
                $materialID = $grnproductlist->tbl_material_info_idtbl_material_info;
            
                $sqlcheck = "SELECT `qty` FROM `tbl_stock` WHERE `tbl_material_info_idtbl_material_info` = ? AND `batchno` = ? AND `tbl_location_idtbl_location` = ? AND `status` = ?";
                $respondcheck = $this->db->query($sqlcheck, array($materialID, $batchno, $location, 1));
            
                if($respondcheck->num_rows() == 0) {
                    $data = array(
                        'batchno' => $batchno,
                        'qty' => $qty,
                        'unitprice' => $costunitprice,
                        'status' => '1',
                        'insertdatetime' => $updatedatetime,
                        'tbl_user_idtbl_user' => $userID,
                        'tbl_material_info_idtbl_material_info' => $materialID,
                        'tbl_location_idtbl_location' => $location,
                        'tbl_company_idtbl_company'=> $companyid,
                        'tbl_company_branch_idtbl_company_branch'=> $branchid
                    );
                    $this->db->insert('tbl_stock', $data);
                } else {
                    $existingQty = $respondcheck->row(0)->qty;
                    $newQty = $existingQty + $qty;
            
                    $data = array(
                        'qty' => $newQty,
                        'unitprice' => $costunitprice,
                        'updateuser' => $userID,
                        'updatedatetime' => $updatedatetime,
                        'tbl_company_idtbl_company'=> $companyid,
                        'tbl_company_branch_idtbl_company_branch'=> $branchid
                    );
                    $this->db->where('batchno', $batchno);
                    $this->db->where('tbl_location_idtbl_location', $location);
                    $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                    $this->db->update('tbl_stock', $data);
                }
            }
            

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Order Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Qualitycheck');                
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
                redirect('Qualitycheck');
            }
        }
    }

    public function Getqualityviewdescription(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_grn_quality`.`statuspassfail`) As descstatus, `idtbl_grn_quality`, `examined_qty`, `moisture_level`, `adultering`, `fungi_pest`, `color_confirmity`, `grade`, `size`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_grn_idtbl_grn`, `tbl_material_info_idtbl_material_info` FROM `tbl_grn_quality` LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_grn_quality`.`statuspassfail`=`tblel`.`type`)  WHERE `tbl_grn_idtbl_grn`=? AND `tbl_grn_quality`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>

            		<label for="">EXAMINED QTY : <span>&nbsp;'.$rowlist->examined_qty.'</span></label>
            	</li>
            	<li>
            		<label for="">MOISTURE LEVEL : <span>&nbsp;'.$rowlist->moisture_level.'</span></label>
            	</li>
            	<li>
            		<label for="">ADULTERING : <span>&nbsp;'.$rowlist->adultering.'</span></label>
            	</li>
            	<li>
            		<label for="">FUNGI : <span>&nbsp;'.$rowlist->fungi_pest.'</span></label>
            	</li>
            	<li>
            		<label for="">COLOR CONFIRMITY : <span>&nbsp;'.$rowlist->color_confirmity.'</span></label>
            	</li>
            	<li>
            		<label for="">GRADE : <span>&nbsp;'.$rowlist->grade.'</span></label>
            	</li>
            	<li>
            		<label for="">SIZE : <span>&nbsp;'.$rowlist->size.'</span></label>
            	</li>
            	<li>
            		<label for="">PASS/FAIL : <span>&nbsp;'.$rowlist->descstatus.'</span></label>
            	</li>
            	<li>
            		<label for="">COMMENT : <span>&nbsp;'.$rowlist->comments.'</span></label>
            	</li>
            </ul>

            
            ';
        }

        echo $html;
    }

    public function Editqualityinfo(){
        $recordID=$this->input->post('recordID');

        $updatesql="SELECT `idtbl_grn_quality`, `examined_qty`, `moisture_level`, `adultering`, `fungi_pest`, `color_confirmity`, `grade`, `size`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_grn_idtbl_grn`, `tbl_material_info_idtbl_material_info` FROM `tbl_grn_quality` WHERE `tbl_grn_idtbl_grn`=? AND `tbl_grn_quality`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array($recordID, 1));

        $editsqlgrn="SELECT `idtbl_grn`, `grndate` FROM `tbl_grn` WHERE `status`=? AND `idtbl_grn`=?";
        $editrespondgrn=$this->db->query($editsqlgrn, array(1, $recordID));

        $html='';

        $html.='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN#</label>
                <input type="text" name="grn" id="grn" class="form-control form-control-sm" value="'.$editrespondgrn->row(0)->idtbl_grn.'" readonly>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">GRN DATE</label>
                <input type="text" name="grndate" id="grndate" class="form-control form-control-sm" value="'.$editrespondgrn->row(0)->grndate.'" readonly>
            </div>
        </div>
        ';
        foreach($updaterespond->result() as $rowupdatequalitylist){
        $html.='
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                		<input type="text" name="exqty" id="exqty" class="form-control form-control-sm" value="'.$rowupdatequalitylist->examined_qty.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">MOISTURE LEVEL%</label>
                		<input type="text" name="moisture" id="moisture" class="form-control form-control-sm" value="'.$rowupdatequalitylist->moisture_level.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">ADULTERING</label>
                		<input type="text" name="adultering" id="adultering" class="form-control form-control-sm" value="'.$rowupdatequalitylist->adultering.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">FUNGI & PEST</label>
                		<input type="text" name="funginfest" id="funginfest" class="form-control form-control-sm" value="'.$rowupdatequalitylist->fungi_pest.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">COLOR CONFIRMITY</label>
                		<input type="text" name="color" id="color" class="form-control form-control-sm" value="'.$rowupdatequalitylist->color_confirmity.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">GRADE</label>
                		<input type="text" name="grade" id="grade" class="form-control form-control-sm" value="'.$rowupdatequalitylist->grade.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">SIZE</label>
                		<input type="text" name="size" id="size" class="form-control form-control-sm" value="'.$rowupdatequalitylist->size.'">
                	</div>
                </div>
                <div class="form-row">
                	<div class="col">
                		<label class="small font-weight-bold text-dark">PASS/FAIL</label><br>
                		<div class="custom-control custom-radio custom-control-inline">
                			<input type="radio" id="passfail1" name="qualityform" class="custom-control-input"
                				value="'.$rowupdatequalitylist->statuspassfail.'">
                			<label class="custom-control-label" for="passfail1">Pass</label>
                		</div>
                		<div class="custom-control custom-radio custom-control-inline">
                			<input type="radio" id="passfail2" name="qualityform" class="custom-control-input"
                				value="'.$rowupdatequalitylist->statuspassfail.'" checked>
                			<label class="custom-control-label" for="passfail2">Fail</label>
                		</div>
                	</div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">COMMENTS</label>
                        <textarea name="comment" id="comment" class="form-control form-control-sm" value="'.$rowupdatequalitylist->comments.'"></textarea>
                    </div>
                </div>
             
                ';
        }
        echo $html;
    }

    public function NewGRNinsertupdate(){
        $this->db->trans_begin();

        $examinedqty=$this->input->post('exqty');
        $moisturelevel=$this->input->post('moisture');
        $adultering=$this->input->post('adultering');
        $fungipest=$this->input->post('funginfest');
        $colorconfirmity=$this->input->post('color');
        $grade=$this->input->post('grade');
        $size=$this->input->post('size');
        $statuspassfail=$this->input->post('qualityform');
        $comments=$this->input->post('comment');
        $itemdesc=$this->input->post('itemdesc');
        $editedgrnid=$this->input->post('editedgrnid');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');


        $data = array( 
            'examined_qty'=> $examinedqty, 
            'moisture_level'=> $moisturelevel, 
            'adultering'=> $adultering, 
            'fungi_pest'=> $fungipest, 
            'color_confirmity'=> $colorconfirmity, 
            'grade'=> $grade, 
            'size'=> $size, 
            'statuspassfail'=> $statuspassfail, 
            'comments'=> $comments, 
            'updatedatetime'=> $updatedatetime,
            'updateuser'=> $userID

        );
        $this->db->where('tbl_grn_idtbl_grn', $editedgrnid);
        $respond = $this->db->update('tbl_grn_quality', $data);


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
    public function Getmaterialqtyaccomaterialid(){
        $recordID=$this->input->post('recordID');
        $grnID=$this->input->post('grnID');

        $sql="SELECT `qty` FROM `tbl_grndetail` WHERE `tbl_grn_idtbl_grn`=? AND `tbl_material_info_idtbl_material_info`=?";
        $respond=$this->db->query($sql, array($grnID, $recordID));

        echo $respond->row(0)->qty;
    }

    public function Getmaterialinfo(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_grn`.`idtbl_grn`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode` FROM `tbl_grn_quality`
        LEFT JOIN `tbl_grn` ON `tbl_grn`.`idtbl_grn`=`tbl_grn_quality`.`tbl_grn_idtbl_grn`
       LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_grn_quality`.`tbl_material_info_idtbl_material_info` WHERE `tbl_grn_quality`.`tbl_grn_idtbl_grn`=? AND `tbl_grn_quality`.`status`=? GROUP BY `tbl_grn_quality`.`tbl_material_info_idtbl_material_info`";

        $respond=$this->db->query($sql, array($recordID, 1));


        foreach($respond->result() as $rowlist){
            $html .= '
              <tr>
              	<td>' . $rowlist->materialinfocode . '</td>
              	<td>
                  <a href="' . base_url() . 'Qualitycheck/Qualitycheckreport/' . $rowlist->idtbl_grn . '/' . $rowlist->idtbl_material_info .'"
                  class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>
              		<button type="button" id="' . $rowlist->idtbl_grn . '"
              			class="btnViewqualityinfo btn btn-primary btn-sm float-right" data-toggle="modal"
              			data-target="#exampleModal">
              			<i class="fas fa-eye"></i>
              		</button>
              	</td>
              </tr>
            ';
        }
        

        echo $html;
    }

}