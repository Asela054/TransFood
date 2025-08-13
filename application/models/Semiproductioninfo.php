<?php
class Semiproductioninfo extends CI_Model{
    public function Getmachinelist(){
        $this->db->select('`idtbl_machine`, `machine`, `machinecode`');
        $this->db->from('tbl_machine');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function GetSemimateriallist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1, 1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? AND `tbl_material_code`.`materialname` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 1));    
            }
            else{
                $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`semistatus`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1, 1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.' - '.$row->materialinfocode.'/'.$row->unitcode);
        }
        
        echo json_encode($data);
    }
    public function Getprodcutioninfo(){
        $prodate=$this->input->post('prodate');
        $semibomlist=$this->input->post('semibomlist');
        $semimaterial=$this->input->post('semimaterial');
        $qty=$this->input->post('qty');
        $prodcutionID=$this->input->post('prodcutionID');

        // $this->db->select('SUM(qty) AS `issueqty`');
        // $this->db->from('tbl_semi_production_detail');
        // $this->db->where('tbl_semi_production_idtbl_semi_production', $prodcutionID);
        // $this->db->where('semimaterial', $semimaterial);
        // $this->db->where('status', 1);

        // $respondcheckissue=$this->db->get();

        $this->db->select('tbl_semi_bom.qty, tbl_semi_bom.wastage, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.idtbl_semi_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_semi_bom.semimaterial', $semimaterial);
        $this->db->where('tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info', $semibomlist);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get();

        $statusstock=0;
        $materiallist=array();
        $html='';
        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            // echo $rowmaterialbomlist->qty.'-'.$rowmaterialbomlist->qty.'-'.$rowmaterialbomlist->wastage.'-'.$qty;
            $checkqty=(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$qty);

            $this->db->select('SUM(qty) AS sumqty');
            $this->db->from('tbl_stock');
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->where('status', 1);

            $respondcheck=$this->db->get();
            
            if($respondcheck->row(0)->sumqty<$checkqty){
                $statusstock=1;
            }
            // else if($respondcheckissue->row(0)->issueqty>=$checkqty){
            //     $statusstock=1;
            // }
            
            $html.='
                <tr class="pointer">
                    <td>'.$rowmaterialbomlist->idtbl_semi_bom.'</td>
                    <td class="d-none">'.$rowmaterialbomlist->tbl_material_info_idtbl_material_info.'</td>
                    <td>'.$rowmaterialbomlist->materialinfocode.'</td>
                    <td>'.(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$qty).'</td>
                    <td></td>
                </tr>
            ';

            $obj=new stdClass();
            $obj->materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            $obj->code=$rowmaterialbomlist->materialinfocode;
            $obj->wastage=$rowmaterialbomlist->wastage;

            array_push($materiallist, $obj);
        }

        $obj=new stdClass();
        $obj->stockstatus=$statusstock;
        $obj->materiallist=$materiallist;
        $obj->htmlview=$html;

        echo json_encode($obj);
    }
    public function Machineinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $productionorderId=$this->input->post('productionorderId');

        $insertdatetime=date('Y-m-d H:i:s');
        $allocatedatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowtabledata){
            $data = array( 
                'tbl_machine_idtbl_machine'=> $rowtabledata['col_2'],
                'allocatedate'=> $allocatedatetime,
                'startdatetime'=> $rowtabledata['col_3'], 
				'starttime'=> $rowtabledata['col_4'], 	
                'enddatetime'=> $rowtabledata['col_5'], 
				'endtime'=> $rowtabledata['col_6'], 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_semi_production_idtbl_semi_production'=> $productionorderId,
            );

            $this->db->insert('tbl_machine_allocation', $data);

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
                redirect('Productionorderview');                
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
                redirect('Productionorderview');
            }        

    }
    public function Semiproductioninsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $prodate=$this->input->post('prodate');
        $semibomlist=$this->input->post('semibomlist');
        $semimaterial=$this->input->post('semimaterial');
        $qty=$this->input->post('qty');
        $balanceqty=$this->input->post('balanceqty');
        $productionid=$this->input->post('productionid');
        $tableData=$this->input->post('tableData');
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('`tbl_material_info_idtbl_material_info`');
        $this->db->from('tbl_semi_production');
        $this->db->where('idtbl_semi_production', $productionid);
        $this->db->where('status', 1);

        $respondmaterial=$this->db->get();
        $semimaterial=$respondmaterial->row(0)->tbl_material_info_idtbl_material_info;

        $this->db->select('tbl_semi_bom.qty, tbl_semi_bom.wastage, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.idtbl_semi_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_semi_bom.semimaterial', $semimaterial);
        $this->db->where('tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info', $semibomlist);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get(); 

        $this->db->select('COUNT(DISTINCT(`partialissuecount`)) AS `issuecount`');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $productionid);
        $this->db->where('status', 1);
        // $this->db->group_by("partialissuecount");

        $respondpartialcount=$this->db->get();

        $semiproID=$productionid;
        if(!empty($respondpartialcount->row(0)->issuecount)){
            $partialcount=$respondpartialcount->row(0)->issuecount+1;
        }
        else{
            $partialcount=1;
        }

        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            $qtybom=$rowmaterialbomlist->qty;
            $wastage=$rowmaterialbomlist->wastage;
            $checkqty=(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$balanceqty);

            // $sqlcheckunit="SELECT
            //     `tbl_semi_bom`.`qty` AS `rowqty`,
            //     AVG(`tbl_grndetail`.`costunitprice`) AS `avgrowmate`,
            //     `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`,
            //     `tbl_material_info`.`tbl_unit_idtbl_unit` AS `rowunit`,
            //     (
            //         AVG(`tbl_grndetail`.`costunitprice`) * `tbl_semi_bom`.`qty`
            //     ) AS `totalunitcost`
            // FROM
            //     `tbl_semi_bom`
            // LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            // LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            // LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info` = `tbl_semi_bom`.`tbl_material_info_idtbl_material_info`
            // WHERE
            //     `tbl_semi_bom`.`status` = ? AND `tbl_semi_bom`.`tbl_material_info_idtbl_material_info` = ? AND `tbl_stock`.`qty` > ? AND `tbl_stock`.`status` = ? AND `tbl_grndetail`.`status` = ?";
            // $respondcheckunit=$this->db->query($sqlcheckunit, array(1, $materialID, 0, 1, 1));

            // $totalprice=$respondcheckunit->row(0)->totalunitcost*$balanceqty;

            $data = array(
                'qty'=> $checkqty, 
                'unitprice'=> '', 
                'total'=> '', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_semi_production_idtbl_semi_production'=> $semiproID, 
                'semimaterial'=> $semimaterial, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );
            $this->db->insert('tbl_semi_production_detail', $data);

            $semiprodetailID=$this->db->insert_id();

            foreach($tableData as $batchdata){
                $batchmaterialID=$batchdata['col_2'];
                $batchlist=$batchdata['col_5'];

                if($batchmaterialID==$materialID){
                    $dataupdatedetail = array(
                        'batchnolist'=>$batchlist,
                        'partialissuecount'=>$partialcount,
                        'updateuser'=>$userID,
                        'updatedatetime'=>$updatedatetime
                    );
                    $this->db->where('idtbl_semi_production_detail', $semiprodetailID);
                    $this->db->update('tbl_semi_production_detail', $dataupdatedetail);
                    break;
                }
            }
        }

        $dataupdate = array(
            'partialissue'=>'1',
            'tbl_semi_bom_info_idtbl_semi_bom_info'=>$semibomlist,
            'updateuser'=>$userID,
            'updatedatetime'=>$updatedatetime
        );
        $this->db->set('issueqty', 'issueqty + ' . $balanceqty, false);
        $this->db->where('idtbl_semi_production', $productionid);
        $this->db->update('tbl_semi_production', $dataupdate);

        // Insert Other Cost Start 29-10-2024
        $this->db->select('`perunit`, `tbl_expence_type_idtbl_expence_type`');
        $this->db->from('tbl_semi_bom_other_cost');
        $this->db->join('tbl_semi_bom_info_has_tbl_semi_bom_other_cost', 'tbl_semi_bom_info_has_tbl_semi_bom_other_cost.tbl_semi_bom_other_cost_idtbl_semi_bom_other_cost = tbl_semi_bom_other_cost.idtbl_semi_bom_other_cost', 'left');
        $this->db->where('tbl_semi_bom_info_has_tbl_semi_bom_other_cost.tbl_semi_bom_info_idtbl_semi_bom_info', $semibomlist);
        $this->db->where('tbl_semi_bom_other_cost.status', 1);

        $respondOtherCost=$this->db->get();

        if($respondOtherCost->num_rows()>0){
            $this->db->select('COUNT(*) AS `count`');
            $this->db->from('tbl_semi_other_cost');
            $this->db->where('tbl_semi_production_idtbl_semi_production', $productionid);
            $this->db->where('status', 1);

            $respondcheckothercost=$this->db->get();
            if($respondcheckothercost->row(0)->count==0){
                foreach($respondOtherCost->result() as $rowOtherCost){
                    $dataOtherCost = array(
                        'costunit'=> $rowOtherCost->perunit, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_semi_production_idtbl_semi_production'=> $semiproID, 
                        'tbl_expence_type_idtbl_expence_type'=> $rowOtherCost->tbl_expence_type_idtbl_expence_type
                    );
                    $this->db->insert('tbl_semi_other_cost', $dataOtherCost);
                }
            }
        }
        // Insert Other Cost End 29-10-2024

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
    public function Semiproductioncreate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyID=$_SESSION['companyid'];
        $companybranchID=$_SESSION['branchid'];
        $prodate=$this->input->post('prodatenew');
        $semimaterial=$this->input->post('semimaterialnew');
        $qty=$this->input->post('qtynew');
        $updatedatetime=date('Y-m-d H:i:s');  

        $sqlnextno = "SELECT IFNULL(MAX(`procode`), 0) + 1 AS next_procode FROM `tbl_semi_production` WHERE `tbl_company_idtbl_company`=?";
        $respondnextno=$this->db->query($sqlnextno, array($companyID));

        $data = array(
            'prodate'=>$prodate, 
            'procode' => $respondnextno->row(0)->next_procode,
            'qty'=>$qty, 
            'status'=>'1', 
            'insertdatetime'=>$updatedatetime, 
            'tbl_user_idtbl_user'=>$userID,
            'tbl_material_info_idtbl_material_info'=>$semimaterial,
            'tbl_company_idtbl_company'=>$companyID,
            'tbl_company_branch_idtbl_company_branch'=>$companybranchID
        );
        $this->db->insert('tbl_semi_production', $data);
        // print_r($this->db->last_query());   

        $semiproID=$this->db->insert_id();

        // $semiprocode='000000'.$semiproID;
        // $semiprocode=substr($semiprocode, -6);

        // $dataupdate = array(
        //     'procode'=>LPAD(IFNULL(MAX(procode) + 1, 1), 6, '0'),
        //     'updateuser'=>$userID,
        //     'updatedatetime'=>$updatedatetime,
        //     'tbl_company_idtbl_company'=>$companyID,
        //     'tbl_company_branch_idtbl_company_branch'=>$companybranchID
        // );
        // $this->db->where('idtbl_semi_production', $semiproID);
        // $this->db->update('tbl_semi_production', $dataupdate);

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
            redirect('Semiproduction');                
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
            redirect('Semiproduction');
        }
    }
    public function Getothercosttype(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `idtbl_expence_type`, `expencetype` FROM `tbl_expence_type` WHERE `status`=? AND `idtbl_expence_type` NOT IN (SELECT `tbl_expence_type_idtbl_expence_type` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?)";
        $respond=$this->db->query($sql, array(1, 1, $recordID));  

        echo json_encode($respond->result());
    }
    public function Othercostinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $semiproductionID=$this->input->post('semiproductionID');
        $tableData=$this->input->post('tableData');
        $updatedatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowdatalist){
            $costtype=$rowdatalist['col_1'];
            $costtypeID=$rowdatalist['col_2'];
            $perunit=$rowdatalist['col_3'];
            $amount=$rowdatalist['col_4'];

            $this->db->select('SUM(qty) AS `sumqty`');
            $this->db->from('tbl_semi_production_detail');
            $this->db->where('tbl_semi_production_idtbl_semi_production', $semiproductionID);
            $this->db->where('status', 1);

            $respond=$this->db->get();

            if($perunit==0){
                $perunitcost=$amount/$respond->row(0)->sumqty;
            }
            else{
                $perunitcost=$amount;
            }

            $data = array(
                'costunit'=> $perunitcost, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_semi_production_idtbl_semi_production'=> $semiproductionID, 
                'tbl_expence_type_idtbl_expence_type'=> $costtypeID
            );
            $this->db->insert('tbl_semi_other_cost', $data);
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
    public function Viewalreadyothercost(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_semi_other_cost`.`costunit`, `tbl_expence_type`.`expencetype` FROM `tbl_semi_other_cost` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`=`tbl_semi_other_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_semi_other_cost`.`status`=? AND `tbl_semi_other_cost`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Cost Type</th>
                    <th class="text-right">Per Unit</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->expencetype.'</td>
                    <td class="text-right">'.$rowcotlist->costunit.'</td>
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }
    public function Semiproductiondetails(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_semi_production_detail`.`qty`, `tbl_semi_production_detail`.`unitprice`, `tbl_semi_production_detail`.`total`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode`, `tbl_semi_production_detail`.`insertdatetime` FROM `tbl_semi_production_detail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_semi_production_detail`.`status`=? AND `tbl_semi_production_detail`.`tbl_semi_production_idtbl_semi_production`=?";
        $respond=$this->db->query($sql, array(1, $recordID)); 
        // print_r($this->db->last_query());

        $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        $respondother=$this->db->query($sqlother, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Material code</th>
                    <th>Material name</th>
                    <th>Issue date</th>
                    <th>Qty with wastage</th>
                    <!--<th class="text-right">Unit Price</th>
                    <th class="text-right">Other Cost Per Unit</th>
                    <th class="text-right">Total</th>-->
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->materialinfocode.'</td>
                    <td>'.$rowcotlist->materialname.'</td>
                    <td>'.date("Y-m-d", strtotime($rowcotlist->insertdatetime)).'</td>
                    <td>'.$rowcotlist->qty.$rowcotlist->unitcode.'</td>
                    <!--<td class="text-right">'.$rowcotlist->unitprice.'</td>
                    <td class="text-right">'.number_format($respondother->row(0)->sumcost, 2).'</td>
                    <td class="text-right">'.number_format((($respondother->row(0)->sumcost)*$rowcotlist->qty), 2).'</td>-->
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }
    public function Semiproductiontransfer(){
        $this->db->trans_begin();

        $recordID=$this->input->post('recordID');
        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');
		
		$companyID=$_SESSION['companyid'];
        $companybranchID=$_SESSION['branchid'];

        $this->db->select('tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production, tbl_semi_production.procode');
        $this->db->from('tbl_semi_production_daily_complete');
        $this->db->join('tbl_semi_production', 'tbl_semi_production.idtbl_semi_production = tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production', 'left');
        $this->db->where('tbl_semi_production_daily_complete.idtbl_semi_production_daily_complete', $recordID);

        $responddailyinfo=$this->db->get();

        $semiproductionID=$responddailyinfo->row(0)->tbl_semi_production_idtbl_semi_production;
        $procode=$responddailyinfo->row(0)->procode;

        $this->db->select('SUM(qty) AS `issuedaily`');
        $this->db->from('tbl_semi_production_daily_complete');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $semiproductionID);

        $respondissuedaily=$this->db->get();

        $this->db->select('`qty`');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $semiproductionID);

        $respondsemiqty=$this->db->get();

        if($respondissuedaily->row(0)->issuedaily==$respondsemiqty->row(0)->qty){
            $datasemiproduction = array(
                'grnstatus'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_production', $semiproductionID);
            $this->db->update('tbl_semi_production', $datasemiproduction);
        }

        $this->db->select('tbl_semi_production_daily_complete.qty, tbl_semi_production_detail.semimaterial');
        $this->db->from('tbl_semi_production_detail');
        $this->db->join('tbl_semi_production_daily_complete', 'tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production = tbl_semi_production_detail.tbl_semi_production_idtbl_semi_production', 'left');
        $this->db->where('tbl_semi_production_daily_complete.idtbl_semi_production_daily_complete', $recordID);
        $this->db->where('tbl_semi_production_detail.status', 1);
        $this->db->limit(1); 

        $respond=$this->db->get();

        // $this->db->select('SUM(`unitprice`) AS `sumunitprice`');
        // $this->db->from('tbl_semi_production_detail');
        // $this->db->where('tbl_semi_production_idtbl_semi_production', $semiproductionID);
        // $this->db->where('status', 1);

        // $respondunit=$this->db->get();

        // $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        // $respondother=$this->db->query($sqlother, array(1, $semiproductionID)); 

        // $sqlunitavg="SELECT 
        //     AVG(grouped_total.total_sum) AS average_of_sums
        // FROM (
        //     SELECT 
        //         `partialissuecount`, 
        //         SUM(`total`) AS total_sum
        //     FROM 
        //         `tbl_semi_production_detail`
        //     WHERE 
        //         `status` = ? 
        //         AND `tbl_semi_production_idtbl_semi_production` = ?
        //     GROUP BY 
        //         `partialissuecount`
        // ) AS grouped_total";
        // $respondunitavg=$this->db->query($sqlunitavg, array(1, $semiproductionID)); 

        $sqlunitprice="SELECT ROUND(SUM(spd.`qty` * (1 - COALESCE(sb.`wastage`, 0) / 100)), 2) AS `net_qty`, SUM(`total`) AS `totalamount` FROM `tbl_semi_production_detail` spd JOIN `tbl_semi_production` sp ON spd.`tbl_semi_production_idtbl_semi_production` = sp.`idtbl_semi_production` LEFT JOIN `tbl_semi_bom` sb ON sp.`tbl_semi_bom_info_idtbl_semi_bom_info` = sb.`tbl_semi_bom_info_idtbl_semi_bom_info` AND spd.`tbl_material_info_idtbl_material_info` = sb.`tbl_material_info_idtbl_material_info` WHERE spd.`tbl_semi_production_idtbl_semi_production` = ? AND spd.`status` = ?";
        $respondunitprice=$this->db->query($sqlunitprice, array($semiproductionID, 1)); 

        $semiproduct=$respond->row(0)->semimaterial;
        $semiqty=$respond->row(0)->qty;
        $semicostprice=$respondunitprice->row(0)->totalamount/$respondunitprice->row(0)->net_qty;

        $semitotal=$respondunitprice->row(0)->totalamount;  
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
            'tbl_order_type_idtbl_order_type'=> '1',
			'tbl_company_idtbl_company'=>$companyID,
			'tbl_company_branch_idtbl_company_branch'=>$companybranchID
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
            'tbl_order_type_idtbl_order_type'=> '2',
			'tbl_company_idtbl_company'=>$companyID,
			'tbl_company_branch_idtbl_company_branch'=>$companybranchID
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
            'unitprice'=> $semicostprice, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_material_info_idtbl_material_info'=> $semiproduct,
            'tbl_location_idtbl_location'=> '1',
			'tbl_company_idtbl_company'=>$companyID,
			'tbl_company_branch_idtbl_company_branch'=>$companybranchID
        );

        $this->db->insert('tbl_stock', $datastock);

        $dataupdate = array(
            'checkstatus'=> '1', 
            'checkperson'=> $userID, 
            'batchno'=> $batchnofinal, 
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_semi_production_daily_complete', $recordID);
        $this->db->update('tbl_semi_production_daily_complete', $dataupdate);

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
    public function Getbatchnolistaccomaterial(){
        $materialID=$this->input->post('materialID');
        $companyID=$_SESSION['companyid'];
        $branchID=$_SESSION['branchid'];

        $sql="SELECT `tbl_stock`.`batchno`, `tbl_stock`.`qty`, `tbl_unit`.`unitcode` FROM `tbl_stock` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_stock`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_stock`.`status`=? AND `tbl_stock`.`qty`>? AND `tbl_stock`.`tbl_material_info_idtbl_material_info`=? AND `tbl_stock`.`tbl_company_idtbl_company`=? AND `tbl_stock`.`tbl_company_branch_idtbl_company_branch`=?";
        $respond=$this->db->query($sql, array(1, 0, $materialID, $companyID, $branchID));    

        echo json_encode($respond->result());
    }
    public function Checkproductorderqty(){
        $recordID=$this->input->post('recordID');
        $comqty=$this->input->post('comqty');
        $damageqty=$this->input->post('damageqty');

        // $this->db->select('SUM(`qty`) AS `qty`');
        // $this->db->from('tbl_semi_production_detail');
        // $this->db->where('tbl_semi_production_idtbl_semi_production', $recordID);
        // $this->db->where('status', 1);

        // $respond=$this->db->get();

        $this->db->select('SUM(`qty`) AS `qty`');
        $this->db->from('tbl_semi_production');
        $this->db->where('idtbl_semi_production', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        // print_r($this->db->last_query());

        $this->db->select('SUM(`qty`+`damageqty`) AS `issueqty`');
        $this->db->from('tbl_semi_production_daily_complete');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $recordID);
        $this->db->where('status', 1);

        $responddaily=$this->db->get();

        if(!empty($responddaily->row(0)->issueqty)){
            $comissueqty=$responddaily->row(0)->issueqty+$comqty+$damageqty;
        }
        else{
            $comissueqty=$comqty+$damageqty;
        }
        
        if($comissueqty<=$respond->row(0)->qty){
            echo '1';
        }
        else{
            echo '0';
        }
    }
    public function Semiproductiondailycomplete(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $comdate=$this->input->post('comdate');
        $commfdate=$this->input->post('commfdate');
        $comexpdate=$this->input->post('comexpdate');
        $comqty=$this->input->post('comqty');
        $damageqty=$this->input->post('damageqty');
        $hidesemiproductionid=$this->input->post('hidesemiproductionid');
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('`tbl_semi_production_idtbl_semi_production`, `tbl_material_info_idtbl_material_info`');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $hidesemiproductionid);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data = array(
            'comdate'=> $comdate, 
            'qty'=> $comqty, 
            'damageqty'=> $damageqty, 
            'mfdate'=> $commfdate, 
            'expdate'=> $comexpdate, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_semi_production_idtbl_semi_production'=> $respond->row(0)->tbl_semi_production_idtbl_semi_production, 
            'tbl_material_info_idtbl_material_info'=> $respond->row(0)->tbl_material_info_idtbl_material_info
        );

        $this->db->insert('tbl_semi_production_daily_complete', $data);

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
            redirect('Semiproduction/Semiproductionprocess');                
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
            redirect('Semiproduction/Semiproductionprocess');
        }
    }
    public function Viewdailycompleteinfo(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`tbl_semi_production_idtbl_semi_production`, `tbl_material_info_idtbl_material_info`');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $semiproductionID=$respond->row(0)->tbl_semi_production_idtbl_semi_production;
        $materialID=$respond->row(0)->tbl_material_info_idtbl_material_info;

        $this->db->select('*');
        $this->db->from('tbl_semi_production_daily_complete');
        $this->db->join('tbl_user', 'tbl_user.idtbl_user = tbl_semi_production_daily_complete.checkperson', 'left');
        $this->db->where('tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production', $semiproductionID);
        $this->db->where('tbl_semi_production_daily_complete.tbl_material_info_idtbl_material_info ', $materialID);
        $this->db->where('tbl_semi_production_daily_complete.status', 1);

        $responddaily=$this->db->get();

        $html='';
        foreach($responddaily->result() as $rowdailyinfo){
            $html.='
            <tr>
                <td>'.$rowdailyinfo->idtbl_semi_production_daily_complete.'</td>
                <td>'.$rowdailyinfo->batchno.'</td>
                <td>'.$rowdailyinfo->comdate.'</td>
                <td>'.$rowdailyinfo->mfdate.'</td>
                <td>'.$rowdailyinfo->expdate.'</td>
                <td class="text-center">'.$rowdailyinfo->qty.'</td>
                <td class="text-center">'.$rowdailyinfo->damageqty.'</td>
                <td>';
                if($rowdailyinfo->checkstatus==1){$html.='Approved';}
                $html.='</td>
                <td>'.$rowdailyinfo->name.'</td>
                <td class="text-right">';
                    if($rowdailyinfo->checkstatus==0){
                        $html.='<button class="btn btn-warning btn-sm btndailycompleteapprove mr-1" id="'.$rowdailyinfo->idtbl_semi_production_daily_complete.'"><i class="fas fa-times"></i></button>';
                    }
                    else{
                        $html.='<button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button><a href="'.base_url().'Semiproduction/Createlabel/'.$rowdailyinfo->idtbl_semi_production_daily_complete.'" target="_blank" class="btn btn-warning btn-sm mr-1 btnlable"><i class="fas fa-tag"></i></a>';
                    }
                    if($rowdailyinfo->checkstatus==0){
                        $html.='<button class="btn btn-danger btn-sm btndailycompletereject mr-1" id="'.$rowdailyinfo->idtbl_semi_production_daily_complete.'"><i class="fas fa-trash-alt"></i></button>'; 
                    }
                $html.='</td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Semiproductionapprove($x){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('tbl_material_info_idtbl_material_info, tbl_semi_bom_info_idtbl_semi_bom_info, partialissue, issueqty, qty');
        $this->db->from('tbl_semi_production');
        $this->db->where('idtbl_semi_production', $x);
        $this->db->where('status', 1);

        $respondsemi=$this->db->get();

        $semimaterial=$respondsemi->row(0)->tbl_material_info_idtbl_material_info;
        $semibomid=$respondsemi->row(0)->tbl_semi_bom_info_idtbl_semi_bom_info;

        $this->db->select('tbl_semi_bom.qty, tbl_semi_bom.wastage, tbl_semi_bom.tbl_material_info_idtbl_material_info, tbl_semi_bom.idtbl_semi_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_semi_bom.semimaterial', $semimaterial);
        $this->db->where('tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info', $semibomid);
        $this->db->where('tbl_semi_bom.status', 1);

        $respond=$this->db->get();

        $this->db->select('idtbl_semi_production_detail, batchnolist, tbl_material_info_idtbl_material_info, qty, partialissuecount');
        $this->db->from('tbl_semi_production_detail');
        $this->db->where('issueapproved', '0');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $x);
        $this->db->where('status', 1);

        $respondsemidetail=$this->db->get();
        // print_r($this->db->last_query());

        $issueqtybatchnoarray=array();
        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            $qtybom=$rowmaterialbomlist->qty;
            $wastage=$rowmaterialbomlist->wastage;
            $semiproductiondetailID='';

            $checkbatchlist=array();
            foreach($respondsemidetail->result() as $batchdata){
                $batchmaterialID=$batchdata->tbl_material_info_idtbl_material_info;
                $batchlist=$batchdata->batchnolist;
                $qty=$batchdata->qty;
                $semiproductiondetailID=$batchdata->idtbl_semi_production_detail;

                if($batchmaterialID==$materialID){
                    $checkbatchlist=explode(',', $batchlist);
                    break;
                }
            }

            // $balqty=(($qtybom+(($qtybom*$wastage)/100))*$qty);
            $balqty=$batchdata->qty;

            foreach($checkbatchlist as $rowcheckbatchlist){
                $this->db->select('`batchno`, `qty`');
                $this->db->from('tbl_stock');
                $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                $this->db->where('batchno', $rowcheckbatchlist);
                $this->db->where('status', 1);

                $respondstock=$this->db->get();

                // print_r($this->db->last_query());

                if($balqty>0){
                    if($respondstock->row(0)->qty>=$balqty){
                        $dedqty=$respondstock->row(0)->qty-$balqty;
                        $issueqty=$balqty;
                        $balqty=0;
                    }
                    else{
                        $dedqty=0;
                        $balqty=$balqty-$respondstock->row(0)->qty;
                        $issueqty=$respondstock->row(0)->qty;
                    }

                    $batchno=$respondstock->row(0)->batchno;

                    $datastockupdate = array(
                        'qty'=> $dedqty, 
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );

                    $this->db->where('batchno', $batchno);
                    $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                    $this->db->update('tbl_stock', $datastockupdate);
                    // print_r($this->db->last_query());

                    $data = array(
                        'qty'=> $issueqty, 
                        'batchno'=> $batchno, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime, 
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_semi_production_idtbl_semi_production'=> $x, 
                        'tbl_material_info_idtbl_material_info'=> $materialID
                    );

                    $this->db->insert('tbl_semi_production_issue_info', $data);

                    //Update issue material
                    $dataupdate = array(
                        'issueapproved'=>'1',
                        'updateuser'=>$userID,
                        'updatedatetime'=>$updatedatetime
                    );
                    $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                    $this->db->where('tbl_semi_production_idtbl_semi_production', $x);
                    $this->db->update('tbl_semi_production_detail', $dataupdate);

                    $obj=new stdClass();
                    $obj->batchno=$batchno;
                    $obj->qty=$issueqty;
                    $obj->productiondetailid=$semiproductiondetailID;
                    $obj->materialid=$materialID;

                    array_push($issueqtybatchnoarray, $obj);
                }
                else{
                    break;
                }
            }
        }

        // print_r($issueqtybatchnoarray);
        //Unit price calcuation 2024-11-27 start
        $this->db->select('IFNULL(SUM(costunit), 0) AS othercostunit');
        $this->db->from('tbl_semi_other_cost');
        $this->db->where('tbl_semi_production_idtbl_semi_production', $x);
        $this->db->where('status', 1);
        $this->db->group_by(array("tbl_semi_production_idtbl_semi_production", "tbl_expence_type_idtbl_expence_type"));

        $respondothercost=$this->db->get();
        // print_r($this->db->last_query());

        $materialData = array();
        $materialunit=0;
        foreach ($issueqtybatchnoarray as $rowissuedetail) {
            $this->db->select('tbl_grndetail.costunitprice');
            $this->db->from('tbl_grndetail');
            $this->db->join('tbl_grn', 'tbl_grn.idtbl_grn = tbl_grndetail.tbl_grn_idtbl_grn', 'left');
            $this->db->where('tbl_grn.batchno', $rowissuedetail->batchno);
            $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $rowissuedetail->materialid);
            $this->db->where('tbl_grndetail.status', 1);

            $respondgrndetail=$this->db->get();

            if ($respondgrndetail->num_rows() > 0) {
                $costunitprice = $respondgrndetail->row(0)->costunitprice;
                
                $batchunitprice = ($costunitprice + $respondothercost->row(0)->othercostunit) * $rowissuedetail->qty;
                
                if (!isset($materialData[$rowissuedetail->materialid])) {
                    $materialData[$rowissuedetail->materialid] = [
                        'totalBatchUnitPrice' => 0,
                        'costUnitPrices' => []
                    ];
                }
                
                $materialData[$rowissuedetail->materialid]['totalBatchUnitPrice'] += $batchunitprice;
                
                $materialData[$rowissuedetail->materialid]['costUnitPrices'][] = $costunitprice;

                $materialData[$rowissuedetail->materialid]['productionDetailId'] = $rowissuedetail->productiondetailid;
            }
        }

        // print_r($materialData);

        foreach ($materialData as $materialId => $data) {
            $totalBatchUnitPrice = $data['totalBatchUnitPrice'];
            $productionDetailId = $data['productionDetailId'];
            $costUnitPrices = implode(',', $data['costUnitPrices']);
            
            // Prepare the update data
            $dataupdateproductiondetail = array(
                'unitprice' => $costUnitPrices,       
                'total' => $totalBatchUnitPrice,     
                'updateuser' => $userID,             
                'updatedatetime' => $updatedatetime  
            );
        
            $this->db->where('idtbl_semi_production_detail', $productionDetailId); 
            $this->db->update('tbl_semi_production_detail', $dataupdateproductiondetail);
        }
        //Unit price calcuation 2024-11-27 end

        if($respondsemi->row(0)->qty==$respondsemi->row(0)->issueqty){
            $dataupdate = array(
                'approvestatus'=>'1',
                'partialissue'=>'0',
                'updateuser'=>$userID,
                'updatedatetime'=>$updatedatetime
            );
        }
        else{
            $dataupdate = array(
                'partialissue'=>'0',
                'updateuser'=>$userID,
                'updatedatetime'=>$updatedatetime
            );
        }
        $this->db->where('idtbl_semi_production', $x);
        $this->db->update('tbl_semi_production', $dataupdate);

        $this->db->trans_complete();
        
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-save';
            $actionObj->title='';
            $actionObj->message='Record Approve Successfully';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='success';

            $actionJSON=json_encode($actionObj);
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Semiproduction');                
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
            redirect('Semiproduction');
        }
    }
    public function Getsemiprodcutioninfo(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`tbl_semi_production`.`idtbl_semi_production`, `tbl_semi_production`.`prodate`, `tbl_semi_production`.`qty`, `tbl_semi_production`.`issueqty`, `tbl_semi_production`.`tbl_material_info_idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_unit`.`unitcode`');
        $this->db->from('tbl_semi_production');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_production.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->join('tbl_unit', 'tbl_unit.idtbl_unit = tbl_material_info.tbl_unit_idtbl_unit', 'left');
        $this->db->where('tbl_semi_production.idtbl_semi_production', $recordID);
        $this->db->where('tbl_semi_production.status', 1);

        $respond=$this->db->get();

        $this->db->select('`idtbl_semi_bom_info`, `title`');
        $this->db->from('tbl_semi_bom_info');
        $this->db->join('tbl_semi_bom', 'tbl_semi_bom.tbl_semi_bom_info_idtbl_semi_bom_info = tbl_semi_bom_info.idtbl_semi_bom_info', 'left');
        $this->db->join('tbl_semi_production', 'tbl_semi_production.tbl_material_info_idtbl_material_info = tbl_semi_bom.semimaterial', 'left');
        $this->db->where('tbl_semi_production.idtbl_semi_production', $recordID);
        $this->db->where('tbl_semi_bom_info.status', 1);
        $this->db->where('tbl_semi_bom.status', 1);
        $this->db->group_by('`tbl_semi_bom`.`tbl_semi_bom_info_idtbl_semi_bom_info`');

        $respondinfo=$this->db->get();

        $obj=new stdClass();
        $obj->production=json_encode($respond->row(0));
        $obj->productionbominfo=json_encode($respondinfo->result());

        echo json_encode($obj);
    }
    public function Semiproductionstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_semi_production', $recordID);
            $this->db->update('tbl_semi_production', $data);

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
                redirect('Semiproduction');                
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
                redirect('Semiproduction');
            }
        }
    }
}
