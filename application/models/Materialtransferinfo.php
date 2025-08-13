<?php
class Materialtransferinfo extends CI_Model{
    public function locationlist() {
        $userID = $_SESSION['userid'];
    
        $this->db->select('tbl_location.idtbl_location, tbl_location.location');
        $this->db->from('tbl_location');
        $this->db->where('tbl_location.status', 1);
    
        if ($userID == 1) {
            return $respond=$this->db->get();
        } else {
            $this->db->join('tbl_user', 'tbl_user.location_id = tbl_location.idtbl_location');
            $this->db->where('tbl_user.idtbl_user', $userID);
            return $respond=$this->db->get();
        }
    }    
    
    public function tolocationlist(){
        $userID = $_SESSION['userid'];

        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getproductlist(){
        $locationId = $this->input->post('locationId');

        $sql="SELECT `tbl_product`.`productcode`, `tbl_product`.`idtbl_product` FROM `tbl_product_stock` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_stock`.`tbl_product_idtbl_product`  WHERE `tbl_product_stock`.`tbl_location_idtbl_location`=? AND `tbl_product_stock`.`status`=?";
        $respond=$this->db->query($sql, array($locationId, 1));

        echo json_encode($respond->result());
    }

    public function Getproductlisttoselectpicker(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_material_info`, `materialinfocode`, `materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_material_info`, `materialinfocode`, `materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `materialinfocode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_material_info`, `materialinfocode`, `materialname` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_material_info, "text"=>$row->materialname.'-'.$row->materialinfocode);
        }
        
        echo json_encode($data);
    }

    public function Getbatchlist(){
        $productId = $this->input->post('productId');
        $fromlocation = $this->input->post('fromlocation');
    
        $sql="SELECT `tbl_stock`.`idtbl_stock`,`tbl_stock`.`batchno`, SUM(`qty`) AS totalqty FROM `tbl_stock`  WHERE `tbl_stock`.`tbl_material_info_idtbl_material_info`=? AND `tbl_stock`.`status`=? AND `tbl_stock`.`tbl_location_idtbl_location`=? AND `qty`!= 0 GROUP BY `tbl_stock`.`batchno`";
        $respond=$this->db->query($sql, array($productId, 1, $fromlocation));
    
        echo json_encode($respond->result());
    }

   
    public function Stocktransferprocess() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $tableData = $this->input->post('tableData');
        $fromlocation = $this->input->post('fromlocation');
        $tolocation = $this->input->post('tolocation');
        $hiddenbatchid = $this->input->post('hiddenbatchid');
        $insertdatetime = date('Y-m-d H:i:s');
        $updatedatetime = date('Y-m-d H:i:s');
        $transdate = date('Y-m-d');

        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];
    
        foreach ($tableData as $rowtabledata) {
            $batchnos = explode(',', $rowtabledata['col_7']);
        
            $totalQty = $rowtabledata['col_8'];
        
        
            $this->db->select('`batchno`, `qty`');
            $this->db->from('tbl_stock');
            $this->db->where('tbl_material_info_idtbl_material_info', $rowtabledata['col_6']);
            $this->db->where('tbl_location_idtbl_location', $rowtabledata['col_2']);
            $this->db->where_in('batchno', $batchnos);
            $this->db->where('status', 1);
        
            $respondstock = $this->db->get();
 
           
            $orderqty = $totalQty;

        foreach ($respondstock->result() as $rowstocklist) {
            if ($orderqty > 0) {
                $batchno2 = $rowstocklist->batchno;
                $availableqty = $rowstocklist->qty;

                if ($availableqty >= $orderqty) {

                    $dedqty = $orderqty;
                    $availableqty -= $dedqty;
                    $orderqty = 0;
                } else {
                    $dedqty = $availableqty;
                    $orderqty -= $dedqty;
                    $availableqty = 0;
                }


            $datastockupdate = array(
                'qty' => $availableqty,
                'updateuser' => $userID,
                'updatedatetime' => $updatedatetime
            );

            $this->db->where('batchno', $batchno2);
            $this->db->where('tbl_material_info_idtbl_material_info', $rowtabledata['col_6']);
            $this->db->where('tbl_location_idtbl_location', $rowtabledata['col_2']);
            $this->db->update('tbl_stock', $datastockupdate);


            $datastockupdatetolocation = array(
                'batchno' => $batchno2,
                'qty' => $dedqty,
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_user_idtbl_user' => $userID,
                'tbl_material_info_idtbl_material_info' => $rowtabledata['col_6'],
                'tbl_location_idtbl_location' => $rowtabledata['col_4'],
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->insert('tbl_stock', $datastockupdatetolocation);

            $data = array(
                'date' => $transdate,
                'approvestatus' => '0',
                'approveuser' => '0',
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'fromlocation' => $rowtabledata['col_2'],
                'tolocation' => $rowtabledata['col_4'],
                'tbl_user_idtbl_user' => $userID,
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );
        
            $this->db->insert('tbl_material_transfer', $data);
            $transID = $this->db->insert_id();

            foreach ($batchnos as $batchno) {
                $dataone = array(
                    'batchno' => trim($batchno),
                    'qty' => $dedqty,
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_material_transfer_idtbl_material_transfer' => $transID,
                    'tbl_material_info_idtbl_material_info' => $rowtabledata['col_6']
                );
                $this->db->insert('tbl_material_transfer_detail', $dataone);
            }
        
                    if ($orderqty == 0) {
                        break; 
                    }
                } else {
                    break;
                }
            }
                }
        
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Record Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            } else {
                $this->db->trans_rollback();
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-exclamation-triangle';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            }
        }
}