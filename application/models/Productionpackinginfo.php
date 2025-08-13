<?php
class Productionpackinginfo extends CI_Model{
    public function Productionpackingcomplete(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $comdate=$this->input->post('comdate');
        $commfdate=$this->input->post('commfdate');
        $comexpdate=$this->input->post('comexpdate');
        $comqty=$this->input->post('comqty');
        $damageqty=$this->input->post('damageqty');
        $hideproorderdetailid=$this->input->post('hideproorderdetailid');
        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('`tbl_production_order_idtbl_production_order`, `tbl_product_idtbl_product`');
        $this->db->from('tbl_production_orderdetail');
        $this->db->where('idtbl_production_orderdetail', $hideproorderdetailid);
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
            'tbl_production_order_idtbl_production_order'=> $respond->row(0)->tbl_production_order_idtbl_production_order, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );

        $this->db->insert('tbl_production_daily_complete', $data);

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
            redirect('Productionpacking');                
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
            redirect('Productionpacking');
        }
    }
    public function Checkproductorderqty(){
        $recordID=$this->input->post('recordID');
        $comqty=$this->input->post('comqty');
        $damageqty=$this->input->post('damageqty');

        $this->db->select('`qty`, `tbl_production_order_idtbl_production_order`, `tbl_product_idtbl_product`');
        $this->db->from('tbl_production_orderdetail');
        $this->db->where('idtbl_production_orderdetail', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $productionorderID=$respond->row(0)->tbl_production_order_idtbl_production_order;
        $productID=$respond->row(0)->tbl_product_idtbl_product;

        $this->db->select('SUM(`qty`+`damageqty`) AS `issueqty`');
        $this->db->from('tbl_production_daily_complete');
        $this->db->where('tbl_production_order_idtbl_production_order', $productionorderID);
        $this->db->where('tbl_product_idtbl_product', $productID);
        $this->db->where('status', 1);

        $responddaily=$this->db->get();

        $comissueqty=$responddaily->row(0)->issueqty+$comqty+$damageqty;

        if($comissueqty<=$respond->row(0)->qty){
            echo '1';
        }
        else{
            echo '0';
        }
    }
    public function Viewdailycompleteinfo(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`tbl_production_order_idtbl_production_order`, `tbl_product_idtbl_product`');
        $this->db->from('tbl_production_orderdetail');
        $this->db->where('idtbl_production_orderdetail', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $productionorderID=$respond->row(0)->tbl_production_order_idtbl_production_order;
        $productID=$respond->row(0)->tbl_product_idtbl_product;

        $this->db->select('*');
        $this->db->from('tbl_production_daily_complete');
        $this->db->join('tbl_user', 'tbl_user.idtbl_user = tbl_production_daily_complete.checkperson', 'left');
        $this->db->where('tbl_production_daily_complete.tbl_production_order_idtbl_production_order', $productionorderID);
        $this->db->where('tbl_production_daily_complete.tbl_product_idtbl_product ', $productID);
        $this->db->where('tbl_production_daily_complete.status', 1);

        $responddaily=$this->db->get();

        $html='';
        foreach($responddaily->result() as $rowdailyinfo){
            $html.='
            <tr>
                <td>'.$rowdailyinfo->idtbl_production_daily_complete.'</td>
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
                        $html.='<button class="btn btn-warning btn-sm btndailycompleteapprove mr-1" id="'.$rowdailyinfo->idtbl_production_daily_complete.'"><i class="fas fa-times"></i></button>';
                    }
                    else{
                        $html.='<button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button><a href="'.base_url().'Productionpacking/Createlabel/'.$rowdailyinfo->idtbl_production_daily_complete.'" target="_blank" class="btn btn-warning btn-sm mr-1 btnlable"><i class="fas fa-tag"></i></a>';
                    }
                    if($rowdailyinfo->checkstatus==0){
                        $html.='<button class="btn btn-danger btn-sm btndailycompletereject mr-1" id="'.$rowdailyinfo->idtbl_production_daily_complete.'"><i class="fas fa-trash-alt"></i></button>'; 
                    }
                $html.='</td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Approvedailycomplete(){
        $this->db->trans_begin();

        $recordID=$this->input->post('recordID');
        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');
		
		$companyID=$_SESSION['companyid'];
        $companybranchID=$_SESSION['branchid'];

        $this->db->select('tbl_production_daily_complete.qty, tbl_production_daily_complete.comdate, tbl_production_daily_complete.tbl_product_idtbl_product, tbl_production_order.procode');
        $this->db->from('tbl_production_daily_complete');
        $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_daily_complete.tbl_production_order_idtbl_production_order', 'left');
        $this->db->where('tbl_production_daily_complete.idtbl_production_daily_complete', $recordID);

        $respond=$this->db->get();

        $completeqty=$respond->row(0)->qty;
        $comdate=$respond->row(0)->comdate;
        $productID=$respond->row(0)->tbl_product_idtbl_product;
        $procode=$respond->row(0)->procode;

        $batchno=$procode.str_replace('-', '', $comdate);

        $dataupdate = array(
            'checkstatus'=> '1', 
            'checkperson'=> $userID, 
            'batchno'=> $batchno, 
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_production_daily_complete', $recordID);
        $this->db->update('tbl_production_daily_complete', $dataupdate);

        $this->db->select('qty');
        $this->db->from('tbl_product_stock');
        $this->db->where('fgbatchno', $batchno);
        $this->db->where('tbl_product_idtbl_product', $productID);
        $this->db->where('tbl_location_idtbl_location', 1);
        $this->db->where('status', 1);

        $respondcheckstock=$this->db->get();

        if(empty($respondcheckstock->row(0)->qty)){
            $data = array(
                'fgbatchno'=> $batchno, 
                'qty'=> $completeqty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_product_idtbl_product'=> $productID, 
                'tbl_location_idtbl_location'=> '1',
				'tbl_company_idtbl_company'=>$companyID,
				'tbl_company_branch_idtbl_company_branch'=>$companybranchID
            );
            $respond= $this->db->insert('tbl_product_stock', $data);
        }
        else{
            $newqty=$respondcheckstock->row(0)->qty+$completeqty;

            $data = array( 
                'qty'=> $newqty, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime,
            );
            $this->db->where('fgbatchno', $batchno);
            $this->db->where('tbl_product_idtbl_product', $productID);
            $this->db->where('tbl_location_idtbl_location', 1);
            $respond = $this->db->update('tbl_product_stock', $data);
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
}