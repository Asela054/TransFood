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
    $total=$this->input->post('total');
    $remark=$this->input->post('remark');
    $totaldiscount=$this->input->post('totaldiscount');
    $supplier=$this->input->post('supplier');
    $location=$this->input->post('location');
    $ordertype=$this->input->post('ordertype');
    $currencytype=$this->input->post('currencytype');
    $totalusd=$this->input->post('totalusd');
    $usdrate=$this->input->post('usdrate');

    if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}
    $recordOption=$this->input->post('recordOption');

    $updatedatetime=date('Y-m-d H:i:s');

    $isUSD = ($currencytype == 2);
    
    $finalTotal = $isUSD ? str_replace(',', '', $totalusd) : str_replace(',', '', $total);
    $finalDiscount = $isUSD ? '0' : str_replace(',', '', $totaldiscount);

    $finalTotal = (!empty($finalTotal) && $finalTotal != '') ? $finalTotal : 0;
    $finalDiscount = (!empty($finalDiscount) && $finalDiscount != '') ? $finalDiscount : 0;
    $usdrate = (!empty($usdrate) && $usdrate != '') ? str_replace(',', '', $usdrate) : 0;

    if($recordOption==1): // insert
        $this->db->trans_begin();

        $sql = "SELECT MAX(`po_no`) AS `count` FROM `tbl_porder` WHERE `tbl_supplier_idtbl_supplier` != 1 AND `po_no`> 0 AND `tbl_company_idtbl_company`='$companyid' AND `tbl_company_branch_idtbl_company_branch`='$branchid'";
        $respond = $this->db->query($sql);

        if ($respond->row(0)->count == 0) {
            $i = 1;
        } else {
            $i = $respond->row(0)->count + 1;
        }

        $data = array(
            'currencytype'=> $currencytype, 
            'po_no'=> $i, 
            'class'=> $poclass, 
            'orderdate'=> $orderdate, 
            'duedate'=> $duedate, 
            'subtotal'=> $finalTotal, 
            'discount'=> '0', 
            'discountamount'=> $finalDiscount,
            'nettotal'=> $finalTotal, 
            'conversion_rate'=> $usdrate, 
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

        $data = array_filter($data, function($value) {
            return $value !== null && $value !== '';
        });

        if(!$this->db->insert('tbl_porder', $data)) {
            $error = $this->db->error();
            log_message('error', 'Insert failed: ' . print_r($error, true));
            $this->db->trans_rollback();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error: ' . ($error['message'] ?? 'Insert failed');
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
            return;
        }

        $porderID=$this->db->insert_id();

        if(empty($porderID)) {
            $this->db->trans_rollback();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Failed to get insert ID';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
            return;
        }

        foreach($tableData as $key => $rowtabledata){
            $materialname=$rowtabledata['col_1'] ?? '';
            $comment=$rowtabledata['col_2'] ?? '';
            $materialID=$rowtabledata['col_3'] ?? '';
            $unit=str_replace(',', '', $rowtabledata['col_4'] ?? 0);
            $discountlkr=str_replace(',', '', $rowtabledata['col_5'] ?? 0);
            $salepriceusd=str_replace(',', '', $rowtabledata['col_6'] ?? 0);
            $discountusd=str_replace(',', '', $rowtabledata['col_7'] ?? 0);
            $unitperctn=$rowtabledata['col_10'] ?? 0;
            $ctn=$rowtabledata['col_11'] ?? 0;
            $qty=str_replace(',', '', $rowtabledata['col_12'] ?? 0);
            $nettotal=str_replace(',', '', $rowtabledata['col_13'] ?? 0);
            $totalusd=str_replace(',', '', $rowtabledata['col_14'] ?? 0);
            
            $finalUnitPrice = $isUSD ? $salepriceusd : $unit;
            $finalDiscountAmount = $isUSD ? $discountusd : $discountlkr;
            $finalTotalDetail = $isUSD ? $totalusd : $nettotal;

            $finalUnitPrice = (!empty($finalUnitPrice) && $finalUnitPrice != '') ? $finalUnitPrice : 0;
            $finalDiscountAmount = (!empty($finalDiscountAmount) && $finalDiscountAmount != '') ? $finalDiscountAmount : 0;
            $finalTotalDetail = (!empty($finalTotalDetail) && $finalTotalDetail != '') ? $finalTotalDetail : 0;
            $qty = (!empty($qty) && $qty != '') ? $qty : 0;
            $unitperctn = (!empty($unitperctn) && $unitperctn != '') ? $unitperctn : 0;
            $ctn = (!empty($ctn) && $ctn != '') ? $ctn : 0;

            $dataone = array(
                'unitperctn'=> $unitperctn, 
                'ctn'=> $ctn, 
                'qty'=> $qty, 
                'unitprice'=> $finalUnitPrice, 
                'discount'=> '0', 
                'discountamount'=> $finalDiscountAmount, 
                'total'=> $finalTotalDetail,
                'comment'=> $comment, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_porder_idtbl_porder'=> $porderID, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );

            $dataone = array_filter($dataone, function($value) {
                return $value !== null && $value !== '';
            });

            if(!$this->db->insert('tbl_porder_detail', $dataone)) {
                $error = $this->db->error();
                log_message('error', 'Detail insert failed at row ' . $key . ': ' . print_r($error, true));
                $this->db->trans_rollback();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-exclamation-triangle';
                $actionObj->title='';
                $actionObj->message='Record Error: ' . ($error['message'] ?? 'Detail insert failed');
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);

                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);
                return;
            }
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

            $obj=new stdClass();
            $obj->status=1;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        } else {
            $this->db->trans_rollback();
            $db_error = $this->db->error();
            log_message('error', 'Transaction failed: ' . print_r($db_error, true));

            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record Error: ' . ($db_error['message'] ?? 'Transaction failed');
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        }
    else: // update
        $this->db->select('confirmstatus');
        $this->db->from('tbl_porder');
        $this->db->where('idtbl_porder', $recordID);
        $this->db->where('status', 1);
        $respond=$this->db->get();

        if($respond->num_rows() == 0) {
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Record not found';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
            return;
        }

        if($respond->row(0)->confirmstatus > 0):
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-exclamation-triangle';
            $actionObj->title='';
            $actionObj->message='Cannot Edit Confirmed Or Reject Order';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);

            $obj=new stdClass();
            $obj->status=0;          
            $obj->action=$actionJSON;  
            
            echo json_encode($obj);
        else:
            $this->db->trans_begin();

            $data = array(
                'class'=> $poclass, 
                'orderdate'=> $orderdate, 
                'duedate'=> $duedate, 
                'subtotal'=> $finalTotal, 
                'discountamount'=> $finalDiscount,
                'nettotal'=> $finalTotal, 
                'conversion_rate'=> $usdrate, 
                'remark'=> $remark, 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime,
                'tbl_location_idtbl_location'=> $location,
                'tbl_order_type_idtbl_order_type'=> $ordertype
            );
            
            // Don't filter out zero values
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            $this->db->where('idtbl_porder', $recordID);
            if(!$this->db->update('tbl_porder', $data)) {
                $error = $this->db->error();
                log_message('error', 'Update failed: ' . print_r($error, true));
                $this->db->trans_rollback();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-exclamation-triangle';
                $actionObj->title='';
                $actionObj->message='Record Error: ' . ($error['message'] ?? 'Update failed');
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);

                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);
                return;
            }

            $this->db->where('tbl_porder_idtbl_porder', $recordID);
            $this->db->delete('tbl_porder_detail');

            foreach($tableData as $key => $rowtabledata){
                $materialname=$rowtabledata['col_1'] ?? '';
                $comment=$rowtabledata['col_2'] ?? '';
                $materialID=$rowtabledata['col_3'] ?? '';
                $unit=str_replace(',', '', $rowtabledata['col_4'] ?? 0);
                $discountlkr=str_replace(',', '', $rowtabledata['col_5'] ?? 0);
                $salepriceusd=str_replace(',', '', $rowtabledata['col_6'] ?? 0);
                $discountusd=str_replace(',', '', $rowtabledata['col_7'] ?? 0);
                $unitperctn=$rowtabledata['col_10'] ?? 0;
                $ctn=$rowtabledata['col_11'] ?? 0;
                $qty=str_replace(',', '', $rowtabledata['col_12'] ?? 0);
                $nettotal=str_replace(',', '', $rowtabledata['col_13'] ?? 0);
                $totalusd=str_replace(',', '', $rowtabledata['col_14'] ?? 0);
                
                // Determine which values to use based on currency type (1 = LKR, 2 = USD)
                $finalUnitPrice = $isUSD ? $salepriceusd : $unit;
                $finalDiscountAmount = $isUSD ? $discountusd : $discountlkr;
                $finalTotalDetail = $isUSD ? $totalusd : $nettotal;
                
                // Ensure values are numeric
                $finalUnitPrice = (!empty($finalUnitPrice) && $finalUnitPrice != '') ? $finalUnitPrice : 0;
                $finalDiscountAmount = (!empty($finalDiscountAmount) && $finalDiscountAmount != '') ? $finalDiscountAmount : 0;
                $finalTotalDetail = (!empty($finalTotalDetail) && $finalTotalDetail != '') ? $finalTotalDetail : 0;
                $qty = (!empty($qty) && $qty != '') ? $qty : 0;
                $unitperctn = (!empty($unitperctn) && $unitperctn != '') ? $unitperctn : 0;
                $ctn = (!empty($ctn) && $ctn != '') ? $ctn : 0;

                $dataone = array(
                    'unitperctn'=> $unitperctn, 
                    'ctn'=> $ctn, 
                    'qty'=> $qty, 
                    'unitprice'=> $finalUnitPrice, 
                    'discount'=> '0', 
                    'discountamount'=> $finalDiscountAmount, 
                    'total'=> $finalTotalDetail,
                    'comment'=> $comment, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime,
                    'tbl_porder_idtbl_porder'=> $recordID, 
                    'tbl_material_info_idtbl_material_info'=> $materialID
                );

                // Don't filter out zero values
                $dataone = array_filter($dataone, function($value) {
                    return $value !== null && $value !== '';
                });

                if(!$this->db->insert('tbl_porder_detail', $dataone)) {
                    $error = $this->db->error();
                    log_message('error', 'Detail insert failed at row ' . $key . ': ' . print_r($error, true));
                    $this->db->trans_rollback();
                    
                    $actionObj=new stdClass();
                    $actionObj->icon='fas fa-exclamation-triangle';
                    $actionObj->title='';
                    $actionObj->message='Record Error: ' . ($error['message'] ?? 'Detail insert failed');
                    $actionObj->url='';
                    $actionObj->target='_blank';
                    $actionObj->type='danger';

                    $actionJSON=json_encode($actionObj);

                    $obj=new stdClass();
                    $obj->status=0;          
                    $obj->action=$actionJSON;  
                    
                    echo json_encode($obj);
                    return;
                }
            }

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

                $obj=new stdClass();
                $obj->status=1;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);
            } else {
                $this->db->trans_rollback();
                $db_error = $this->db->error();
                log_message('error', 'Transaction failed: ' . print_r($db_error, true));

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-exclamation-triangle';
                $actionObj->title='';
                $actionObj->message='Record Error: ' . ($db_error['message'] ?? 'Transaction failed');
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);

                $obj=new stdClass();
                $obj->status=0;          
                $obj->action=$actionJSON;  
                
                echo json_encode($obj);
            }
        endif;
    endif;
}
    public function Purchaseorderview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address` AS supplieraddress, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $currencyType = $respond->row(0)->currencytype;
        $currencySign = ($currencyType == 1) ? 'Rs. ' : '$ ';

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
                        
                        $unitPrice = $roworderinfo->$unitPrice;
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