<?php
class Purchaseorderinfo extends CI_Model{
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getordertype(){
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getproductaccosupplier(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname` FROM `tbl_material_suppliers` LEFT JOIN `tbl_material_info`.`idtbl_material_info`=`tbl_material_suppliers`.`tbl_material_infoidtbl_material_info` WHERE `tbl_material_suppliers`.`status`=? AND  `tbl_supplier_idtbl_supplier`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getunitpriceaccomaterial() {
        $recordID = $this->input->post('recordID');
        
        $sql = "SELECT `tbl_material_info`.`unitprice`, `tbl_material_info`.`unitperctn`, `tbl_unit`.`idtbl_unit`, `tbl_unit`.`unitname` FROM `tbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_info`.`status` = ? AND `idtbl_material_info` = ?";
        $query = $this->db->query($sql, array(1, $recordID));
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            echo json_encode(array(
                'unitprice' => $row->unitprice,
                'unitperctn' => $row->unitperctn,
                'unit_id' => $row->idtbl_unit,
                'unitname' => $row->unitname
            ));
        } else {
            echo json_encode(array(
                'unitprice' => 0,
                'unitperctn' => 0,
                'unit_id' => 0,
                'unitname' => ''
            ));
        }
    }
    public function Purchaseorderinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $orderdate=$this->input->post('orderdate');
        $poclass=$this->input->post('poclass');
        $duedate=$this->input->post('duedate');
        $total=$this->input->post('total');
        $remark=$this->input->post('remark');
        $supplier=$this->input->post('supplier');
        $location=$this->input->post('location');
        $ordertype=$this->input->post('ordertype');

        $updatedatetime=date('Y-m-d H:i:s');

        $sql = "SELECT MAX(`po_no`) AS `count` FROM `tbl_porder` WHERE `tbl_supplier_idtbl_supplier` != 1 AND `po_no`> 0 AND `tbl_company_idtbl_company`='$companyid' AND `tbl_company_branch_idtbl_company_branch`='$branchid'";
            $respond = $this->db->query($sql);

            if ($respond->row(0)->count == 0) {
                $i = 1;
            } else {
                $i = $respond->row(0)->count + 1;
            }

        $data = array(
            'po_no'=> $i, 
            'class'=> $poclass, 
            'orderdate'=> $orderdate, 
            'duedate'=> $duedate, 
            'subtotal'=> $total, 
            'discount'=> '0', 
            'discountamount'=> '0', 
            'nettotal'=> $total, 
            'confirmstatus'=> '0', 
            'grnconfirm'=> '0', 
            'remark'=> $remark, 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_location_idtbl_location'=> $location,
            'tbl_supplier_idtbl_supplier'=> $supplier,
            'tbl_order_type_idtbl_order_type'=> $ordertype,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_porder', $data);

        $porderID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $materialname=$rowtabledata['col_1'];
            $comment=$rowtabledata['col_2'];
            $materialID=$rowtabledata['col_3'];
            $unit=$rowtabledata['col_4'];
            $unitperctn=$rowtabledata['col_6'];
            $ctn=$rowtabledata['col_7'];
            $qty=$rowtabledata['col_8'];
            $nettotal=$rowtabledata['col_9'];

            $dataone = array(
                'unitperctn'=> $unitperctn, 
                'ctn'=> $ctn, 
                'qty'=> $qty, 
                'unitprice'=> $unit, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'total'=> $nettotal, 
                'comment'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_porder_idtbl_porder'=> $porderID, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );

            $this->db->insert('tbl_porder_detail', $dataone);
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
    public function Purchaseorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address` AS supplieraddress, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_porder_detail.*, tbl_material_info.materialinfocode, tbl_material_info.materialname, tbl_unit.unitname');
        $this->db->from('tbl_porder_detail');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_porder_detail.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_unit', 'tbl_unit.idtbl_unit = tbl_material_info.tbl_unit_idtbl_unit', 'left');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $recordID);
        $this->db->where('tbl_porder_detail.status', 1);

        $responddetail=$this->db->get();
        // print_r($this->db->last_query());

        $html='';
        $html.='
        <div class="row">
            <div class="col-12">'.$respond->row(0)->suppliername.'<br>'.$respond->row(0)->primarycontactno.' / '.$respond->row(0)->secondarycontactno.'<br>'.$respond->row(0)->supplieraddress.'<br>'.$respond->row(0)->email.'</div>
            <div class="col-12 text-right">'.$respond->row(0)->location.'<br>'.$respond->row(0)->phone.' / '.$respond->row(0)->phone2.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->locemail.'</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Material Info</th>
                            <th>Unit</th>
                            <th>Unit Per Ctn</th>
                            <th>Ctns</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $roworderinfo){
                        $html.='<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td>'.$roworderinfo->unitname.'</td>
                            <td>'.$roworderinfo->unitperctn.'</td>
                            <td>'.$roworderinfo->ctn.'</td>
                            <td>'.$roworderinfo->qty.'</td>
                            <td>'.number_format(($roworderinfo->unitprice), 2).'</td>
                            <td class="text-right">'.number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2).'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-bold">Rs. '.number_format(($respond->row(0)->nettotal), 2).'</h3></div>
        </div>
        ';

        echo $html;
    }
    public function Purchaseorderstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'confirmstatus' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_porder', $recordID);
            $this->db->update('tbl_porder', $data);

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
                redirect('Purchaseorder');                
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
                redirect('Purchaseorder');
            }
        }
    }
}