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

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname` FROM `tbl_material_suppliers` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_material_suppliers`.`tbl_material_info_idtbl_material_info` WHERE `tbl_material_suppliers`.`status`=? AND  `tbl_supplier_idtbl_supplier`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getunitpriceaccomaterial() {
        $recordID = $this->input->post('recordID');
        
        $sql = "SELECT `tbl_material_suppliers`.`unitprice`, `tbl_material_info`.`unitperctn`, `tbl_unit`.`idtbl_unit`, `tbl_unit`.`unitname` FROM `tbl_material_suppliers` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_material_suppliers`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_material_suppliers`.`status` = ? AND `tbl_material_suppliers`.`tbl_material_info_idtbl_material_info` = ?";
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

    $userID=$_SESSION['userid'];
    $companyid=$_SESSION['companyid'];
    $branchid=$_SESSION['branchid'];

    $tableData=$this->input->post('tableData');
    $orderdate=$this->input->post('orderdate');
    $poclass=$this->input->post('poclass');
    $duedate=$this->input->post('duedate');
    $total=str_replace(',', '', $this->input->post('total'));
    $remark=$this->input->post('remark');
    $totaldiscount=str_replace(',', '', $this->input->post('totaldiscount'));
    $supplier=$this->input->post('supplier');
    $location=$this->input->post('location');
    $ordertype=$this->input->post('ordertype');
    $currencytype=$this->input->post('currencytype');
    $usdrate=$this->input->post('usdrate');

    $recordID=$this->input->post('recordID');
    $recordOption=$this->input->post('recordOption');

    $updatedatetime=date('Y-m-d H:i:s');

    $this->db->trans_begin(); // Start transaction once only

    /* ============================================================
       INSERT
    ============================================================ */
    if($recordOption==1){

        $sql = "SELECT MAX(po_no) AS count 
                FROM tbl_porder 
                WHERE tbl_supplier_idtbl_supplier != 1 
                AND po_no > 0 
                AND tbl_company_idtbl_company='$companyid' 
                AND tbl_company_branch_idtbl_company_branch='$branchid'";

        $respond = $this->db->query($sql);
        $row = $respond->row();
        $i = (!empty($row) && !empty($row->count)) ? $row->count + 1 : 1;

        $data = array(
            'currencytype'=> $currencytype,
            'po_no'=> $i,
            'class'=> $poclass,
            'orderdate'=> $orderdate,
            'duedate'=> $duedate,
            'subtotal'=> $total,
            'discount'=> '0',
            'discountamount'=> $totaldiscount,
            'nettotal'=> $total,
            'usd_rate'=> $usdrate,
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
        $porderID = $this->db->insert_id();

        if(empty($porderID)){
            $this->db->trans_rollback();
            echo json_encode(['status'=>0,'message'=>'Parent insert failed']);
            return;
        }

    }
    /* ============================================================
       UPDATE
    ============================================================ */
    else{

        $this->db->select('confirmstatus');
        $this->db->from('tbl_porder');
        $this->db->where('idtbl_porder', $recordID);
        $this->db->where('status', 1);
        $respond=$this->db->get();
        $row = $respond->row();

        if($row && $row->confirmstatus > 0){
            echo json_encode(['status'=>0,'message'=>'Cannot Edit Confirmed Or Reject Order']);
            return;
        }

        $data = array(
            'currencytype'=> $currencytype,
            'class'=> $poclass,
            'orderdate'=> $orderdate,
            'duedate'=> $duedate,
            'subtotal'=> $total,
            'discountamount'=> $totaldiscount,
            'nettotal'=> $total,
            'usd_rate'=> $usdrate,
            'remark'=> $remark,
            'updateuser'=> $userID,
            'updatedatetime'=> $updatedatetime,
            'tbl_location_idtbl_location'=> $location,
            'tbl_order_type_idtbl_order_type'=> $ordertype
        );

        $this->db->where('idtbl_porder', $recordID);
        $this->db->update('tbl_porder', $data);

        $this->db->where('tbl_porder_idtbl_porder', $recordID);
        $this->db->delete('tbl_porder_detail');

        $porderID = $recordID;
    }

    /* ============================================================
       INSERT DETAILS
    ============================================================ */

    if(!empty($tableData)){

        foreach($tableData as $row){

            $materialID = $row['col_3'];

            if(empty($materialID)){
                continue;
            }

            $unit_lkr   = str_replace(',', '', $row['col_4']);
            $disc_lkr   = str_replace(',', '', $row['col_5']);
            $unit_usd   = str_replace(',', '', $row['col_6']);
            $disc_usd   = str_replace(',', '', $row['col_7']);

            $unitperctn = !empty($row['col_10']) ? $row['col_10'] : 0;
            $ctn        = !empty($row['col_11']) ? $row['col_11'] : 0;
            $qty        = !empty($row['col_12']) ? $row['col_12'] : 0;

            $total_lkr  = str_replace(',', '', $row['col_13']);
            $total_usd  = str_replace(',', '', $row['col_14']);

            if($currencytype == 1){
                $finalUnit  = !empty($unit_lkr) ? $unit_lkr : 0;
                $finalDisc  = !empty($disc_lkr) ? $disc_lkr : 0;
                $finalTotal = !empty($total_lkr) ? $total_lkr : 0;
            } else {
                $finalUnit  = !empty($unit_usd) ? $unit_usd : 0;
                $finalDisc  = !empty($disc_usd) ? $disc_usd : 0;
                $finalTotal = !empty($total_usd) ? $total_usd : 0;
            }

            $detail = array(
                'unitperctn'=> $unitperctn,
                'ctn'=> $ctn,
                'qty'=> $qty,
                'unitprice'=> $finalUnit,
                'discount'=> '0',
                'discountamount'=> $finalDisc,
                'total'=> $finalTotal,
                'status'=> '1',
                'insertdatetime'=> $updatedatetime,
                'tbl_porder_idtbl_porder'=> $porderID,
                'tbl_material_info_idtbl_material_info'=> $materialID
            );

            $this->db->insert('tbl_porder_detail', $detail);
        }
    }

    /* ============================================================
       FINISH TRANSACTION
    ============================================================ */

    $this->db->trans_complete();

    if ($this->db->trans_status() === TRUE) {

        $actionObj=new stdClass();
        $actionObj->icon='fas fa-save';
        $actionObj->title='';
        $actionObj->message=($recordOption==1?'Record Added Successfully':'Record Update Successfully');
        $actionObj->url='';
        $actionObj->target='_blank';
        $actionObj->type='primary';

        echo json_encode(['status'=>1,'action'=>json_encode($actionObj)]);

    } else {

        $error = $this->db->error();

        echo json_encode([
            'status'=>0,
            'error_code'=>$error['code'],
            'error_message'=>$error['message']
        ]);
    }

}
    public function Purchaseorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address` AS supplieraddress, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $currencyType = $respond->row(0)->currencytype;
        $currencySign = ($currencyType == 1) ? 'Rs. ' : '$ ';

        $netTotal = ($currencyType == 1) 
        ? $respond->row(0)->nettotal 
        : $respond->row(0)->nettotalusd;

        if ($currencyType == 1) {
            $unitPriceField = 'unitprice';
        } else {
            $unitPriceField = 'unitpriceusd';
        }


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
                        
                        $unitPrice = $roworderinfo->$unitPriceField;
                        $total = $roworderinfo->qty * $unitPrice;

                        $html .= '<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td>'.$roworderinfo->unitname.'</td>
                            <td>'.$roworderinfo->unitperctn.'</td>
                            <td>'.$roworderinfo->ctn.'</td>
                            <td>'.$roworderinfo->qty.'</td>

                            <td>'.$currencySign.number_format($unitPrice, 2).'</td>
                            <td class="text-right">'.$currencySign.number_format($total, 2).'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-bold">'.$currencySign.number_format($netTotal, 2).'</h3></div>
        </div>
        ';

        echo $html;
    }
    public function Purchaseorderstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $confirmstatus=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        // if($type==1){
        $data = array(
            'confirmstatus' => $confirmstatus,
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_porder', $recordID);
        $this->db->update('tbl_porder', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            if($confirmstatus==1){
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Order Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';
            }
            else{
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Order rejected Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';
            }            

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
        // }
    }
    public function Purchaseorderedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`tbl_porder`.`idtbl_porder`, `tbl_porder`.`currencytype`, `tbl_porder`.`class`, `tbl_porder`.`orderdate`, `tbl_porder`.`duedate`, `tbl_porder`.`subtotal`, `tbl_porder`.`discount`, `tbl_porder`.`discountamount`, `tbl_porder`.`nettotal`, `tbl_porder`.`subtotalusd`, `tbl_porder`.`discountusd`, `tbl_porder`.`discountamountusd`, `tbl_porder`.`nettotalusd`, `tbl_porder`.`tbl_location_idtbl_location`, `tbl_porder`.`tbl_order_type_idtbl_order_type`, `tbl_supplier`.`idtbl_supplier`, `tbl_supplier`.`suppliername`');
        $this->db->from('tbl_porder');
        $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_porder.tbl_supplier_idtbl_supplier', 'left');
        $this->db->where('tbl_porder.idtbl_porder', $recordID);
        $this->db->where('tbl_porder.status', 1);

        $respond=$this->db->get();

        $this->db->select('`tbl_porder_detail`.*, `tbl_material_info`.`materialname`, `tbl_material_info`.`materialinfocode`');
        $this->db->from('tbl_porder_detail');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_porder_detail.tbl_material_info_idtbl_material_info', 'left');
        $this->db->where('tbl_porder_detail.tbl_porder_idtbl_porder', $recordID);
        $this->db->where('tbl_porder_detail.status', 1);
        $responddetail=$this->db->get();

        $obj=new stdClass();
        $obj->recorddata=$respond->row();
        $obj->recorddetaildata=$responddetail->result();
        echo json_encode($obj);
    }
}