<?php
class Productiontranspackinginfo extends CI_Model{
    public function Productionpackqualityform(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 2));

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
            else if($rowqualitylist->inputtype==5){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <input type="datetime-local" name="qualityform'.$rowqualitylist->idtbl_quality_subcategory.'" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
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
        $qualitycategoryID=2;

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
    public function Transfertopacking(){
        $this->db->trans_begin();
        $completeqty=$this->input->post('completeqty');
        $packqty=$this->input->post('packqty');
        $semiproduct=$this->input->post('semiproduct');
        $semiqty=$this->input->post('semiqty');
        $semicostprice=$this->input->post('semicostprice');
        $hidepromaterialid=$this->input->post('hidepromaterialid');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');

        $sql="SELECT `tbl_production_material_issue`.`idtbl_production_material_issue`, `tbl_production_material_issue`.`tbl_product_idtbl_product`, `tbl_production_material`.`tbl_production_order_idtbl_production_order` FROM `tbl_production_material_issue` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_issue`.`tbl_production_material_idtbl_production_material` WHERE `tbl_production_material_issue`.`tbl_production_material_idtbl_production_material`=? AND `tbl_production_material_issue`.`status`=?";
        $respond=$this->db->query($sql, array($hidepromaterialid, 1));

        $data = array(
            'transdate'=> $today, 
            'qty'=> $packqty, 
            'qualitycheck'=> '1', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_production_order_idtbl_production_order'=> $respond->row(0)->tbl_production_order_idtbl_production_order, 
            'tbl_production_material_issue_idtbl_production_material_issue'=> $respond->row(0)->idtbl_production_material_issue, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );

        $this->db->insert('tbl_production_packing', $data);

        $datacomplete = array(
            'comqty'=> $packqty, 
            'transpack'=> '1', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_production_material_issue_idtbl_production_material_issue'=> $respond->row(0)->idtbl_production_material_issue, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );

        $this->db->insert('tbl_production_daily_complete', $datacomplete);

        if($semiqty>0){
            $semitotal=$semiqty*$semicostprice;  
            $materialcode='RM';
            $suppliercode='DIR';

            $sqlgrncount="SELECT COUNT(*) AS `count` FROM `tbl_grn`";
            $respondgrncount=$this->db->query($sqlgrncount);
        
            if($respondgrncount->row(0)->count==0){$batchno=date('dmY').'001';}
            else{
                $count='000'.($respondgrncount->row(0)->count+1);
                $count=substr($count, -3);
                $batchno=date('dmY').$count;
            }
        
            $batchnofinal = $suppliercode.$materialcode.$batchno;

            // Purchase Order Insert Start
            $dataporder = array(
                'orderdate'=> $today, 
                'duedate'=> NULL, 
                'subtotal'=> $semitotal, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'nettotal'=> $semitotal, 
                'confirmstatus'=> '1', 
                'grnconfirm'=> '1', 
                'remark'=> '', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_location_idtbl_location'=> '1', 
                'tbl_supplier_idtbl_supplier'=> '1', 
                'tbl_order_type_idtbl_order_type'=> '1'
            );

            $this->db->insert('tbl_porder', $dataporder);

            $porderID=$this->db->insert_id();

            $dataporderdetail = array(
                'qty'=> $semiqty, 
                'unitprice'=> $semicostprice, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'comment'=> '', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_porder_idtbl_porder'=> $porderID, 
                'tbl_material_info_idtbl_material_info'=> $semiproduct
            );
    
            $this->db->insert('tbl_porder_detail', $dataporderdetail);
            // Purchase Order Insert End

            // GRN Insert Start
            $datagrn = array(
                'batchno'=> $batchnofinal, 
                'grntype'=> '2', 
                'grndate'=> $today, 
                'total'=> $semitotal, 
                'invoicenum'=> '', 
                'dispatchnum'=> '', 
                'approvestatus'=> '1', 
                'qualitycheck'=> '1', 
                'transportcost'=> '0', 
                'unloadingcost'=> 0, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_supplier_idtbl_supplier'=> '1', 
                'tbl_location_idtbl_location'=> '1', 
                'tbl_porder_idtbl_porder'=> $porderID, 
                'tbl_order_type_idtbl_order_type'=> '1'
            );

            $this->db->insert('tbl_grn', $datagrn);

            $grnID=$this->db->insert_id();

            $datagrndetail = array(
                'date'=> $today, 
                'qty'=> $semiqty, 
                'unitprice'=> $semicostprice, 
                'costunitprice'=> $semicostprice, 
                'total'=> $semitotal, 
                'comment'=> '', 
                'mfdate'=> $today, 
                'expdate'=> '', 
                'quater'=> '', 
                'actualqty'=> '', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_grn_idtbl_grn'=> $grnID, 
                'tbl_material_info_idtbl_material_info'=> $semiproduct
            );
    
            $this->db->insert('tbl_grndetail', $datagrndetail);
            // GRN Insert End

            $datastock = array(
                'batchno'=> $batchnofinal, 
                'qty'=> $semiqty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_material_info_idtbl_material_info'=> $semiproduct
            );
    
            $this->db->insert('tbl_stock', $datastock);

            $datacomplete = array(
                'comqty'=> $semiqty, 
                'transpack'=> '2', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_production_material_issue_idtbl_production_material_issue'=> $respond->row(0)->idtbl_production_material_issue, 
                'tbl_product_idtbl_product'=> $semiproduct
            );
    
            $this->db->insert('tbl_production_daily_complete', $datacomplete);
        }

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
            redirect('Productiontranspacking');                
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
            redirect('Productiontranspacking');
        }
    }
    public function Checkissueqtyforpacking(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT SUM(`tbl_production_packing`.`qty`) AS `issueqty` FROM `tbl_production_packing` LEFT JOIN `tbl_production_material_issue` ON `tbl_production_material_issue`.`idtbl_production_material_issue`=`tbl_production_packing`.`tbl_production_material_issue_idtbl_production_material_issue` WHERE `tbl_production_material_issue`.`tbl_production_material_idtbl_production_material`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo $respond->row(0)->issueqty;
    }
}