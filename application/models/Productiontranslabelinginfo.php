<?php
class Productiontranslabelinginfo extends CI_Model{
    public function Productionpackqualityform(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 3));

        $r=1;
        $html='';
        foreach($respond->result() as $rowqualitylist){
            if($rowqualitylist->inputtype==1){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <input type="text" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowqualitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail'.$r.'">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfailsecond'.$r.'" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfailsecond'.$r.'">Fail</label>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }
            else if($rowqualitylist->inputtype==3){

            }
            else if($rowqualitylist->inputtype==4){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <textarea name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }

            $r++;
        }

        $html.='
        <label class="small font-weight-bold text-dark">&nbsp;</label><br>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="mainpassfail1" name="mainpassfail" class="custom-control-input" value="1" required>
            <label class="custom-control-label" for="mainpassfail1">Pass</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="mainpassfail2" name="mainpassfail" class="custom-control-input" value="2" checked>
            <label class="custom-control-label" for="mainpassfail2">Fail</label>
        </div>
        ';
        echo $html;
    }
    public function Productionpackqualityinsertupdate(){
        $this->db->trans_begin();
        // $fieldlist=$this->input->post('qualityform');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $mainpassfail=$this->input->post('mainpassfail');
        $qualityformhide=$this->input->post('qualityformhide');
        $qualitycategoryID=3;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($qualityformhide as $subcategorylist){
            $descorstatus=$this->input->post('qualityform'.$subcategorylist);
            $subcategoryID=$subcategorylist;

            $data = array(
                'descstatus'=> $descorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_production_material_idtbl_production_material'=> $hideproductionmaterial, 
                'tbl_material_info_idtbl_material_info'=> '', 
                'tbl_grn_idtbl_grn'=> '', 
                'tbl_quality_category_idtbl_quality_category'=> $qualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $subcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
        }

        $datamaterial = array(
            'passfail'=> $mainpassfail
        );

        $this->db->where('idtbl_production_material', $hideproductionmaterial);
        $this->db->update('tbl_production_material', $datamaterial);


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
    public function Transfertofgstock(){
        $this->db->trans_begin();
        $completeqty=$this->input->post('completeqty');
        $labelqty=$this->input->post('labelqty');
        $hidepromaterialid=$this->input->post('hidepromaterialid');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');
        $currdate=date('Ymd');

        $sql="SELECT `tbl_production_order`.`procode`,`tbl_production_material_issue`.`idtbl_production_material_issue`, `tbl_production_material_issue`.`tbl_product_idtbl_product`, `tbl_production_material`.`tbl_production_order_idtbl_production_order` FROM `tbl_production_material_issue` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_issue`.`tbl_production_material_idtbl_production_material` 
        LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order`=`tbl_production_material`.`tbl_production_order_idtbl_production_order` WHERE `tbl_production_material_issue`.`tbl_production_material_idtbl_production_material`=? AND `tbl_production_material_issue`.`status`=?";
        $respond=$this->db->query($sql, array($hidepromaterialid, 1));

        $procode = $respond->row(0)->procode;
        $fgbatchno=$procode+$currdate;

        $data = array(
            'transdate'=> $today, 
            'qty'=> $labelqty, 
            'qualitycheck'=> '1', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_production_order_idtbl_production_order'=> $respond->row(0)->tbl_production_order_idtbl_production_order, 
            'tbl_production_material_issue_idtbl_production_material_issue'=> $respond->row(0)->idtbl_production_material_issue, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );

        $this->db->insert('tbl_production_lable', $data);

        $datacomplete = array(
            'completedate'=> $today, 
            'qty'=> $labelqty,  
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_production_order_idtbl_production_order'=> $respond->row(0)->tbl_production_order_idtbl_production_order, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );

        $this->db->insert('tbl_production_fg', $datacomplete);
        $fgid = $this->db->insert_id();

        $fgstocktrans = array(
            'fgbatchno'=> $fgbatchno, 
            'qty'=> $labelqty,  
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product,
            'tbl_location_idtbl_location'=> '1',
            'tbl_production_fg_idtbl_production_fg'=> $fgid
        );

        $this->db->insert('tbl_product_stock', $fgstocktrans);

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
            redirect('Productiontranslabeling');                
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
            redirect('Productiontranslabeling');
        }
    }
    public function Checkissueqtyforpacking(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT SUM(`tbl_production_lable`.`qty`) AS `issueqty` FROM `tbl_production_lable` LEFT JOIN `tbl_production_material_issue` ON `tbl_production_material_issue`.`idtbl_production_material_issue`=`tbl_production_lable`.`tbl_production_material_issue_idtbl_production_material_issue` WHERE `tbl_production_material_issue`.`tbl_production_material_idtbl_production_material`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo $respond->row(0)->issueqty;
    }
}