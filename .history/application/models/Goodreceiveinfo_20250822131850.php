<?php
class Goodreceiveinfo extends CI_Model{
    public function Getcostlist(){
        $this->db->select('`idtbl_expence_type`, `expencetype`');
        $this->db->from('tbl_expence_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsupplier(){
        $this->db->select('`idtbl_supplier`, `suppliername`');
        $this->db->from('tbl_supplier');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getporder(){
        $this->db->select('`idtbl_porder`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('confirmstatus', 1);
        $this->db->where('grnconfirm', 0);

        return $respond=$this->db->get();
    }
    public function Getproductaccosupplier(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname` FROM `tbl_material_info` WHERE `tbl_material_info`.`status`=? AND `tbl_supplier_idtbl_supplier`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getgoodreceiveid(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `idtbl_grn` FROM `tbl_grn` WHERE `idtbl_grn`=? AND `status`=1";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->result());
    }
    public function Goodreceiveinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $grndate=$this->input->post('grndate');
        $total=$this->input->post('total');
        $remark=$this->input->post('remark');
        $supplier=$this->input->post('supplier');
        $location=$this->input->post('location');
        if(!empty($this->input->post('porder'))){$porder=$this->input->post('porder');$grntype=1;}
        else{$porder=1;$grntype=2;}
        $batchno=$this->input->post('batchno');
        $invoice=$this->input->post('invoice');
        $dispatch=$this->input->post('dispatch');
        $grntype=$this->input->post('grntype');

        $updatedatetime=date('Y-m-d H:i:s');

        $sql = "SELECT MAX(`grn_no`) AS `count` FROM `tbl_grn` WHERE `grntype`= 1 AND `grn_no`> 0 AND `tbl_company_idtbl_company`='$companyid' AND `tbl_company_branch_idtbl_company_branch`='$branchid'";
            $respond = $this->db->query($sql);

            if ($respond->row(0)->count == 0) {
                $i = 1;
            } else {
                $i = $respond->row(0)->count + 1;
            }

        $data = array(
            'grn_no'=> $i,
            'batchno'=> $batchno, 
            'grntype'=> '1', 
            'grndate'=> $grndate, 
            'total'=> $total, 
            'invoicenum'=> $invoice, 
            'dispatchnum'=> $dispatch, 
            'approvestatus'=> '0', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_supplier_idtbl_supplier'=> $supplier, 
            'tbl_location_idtbl_location'=> $location,
            'tbl_porder_idtbl_porder'=> $porder,
            'tbl_order_type_idtbl_order_type'=> $grntype,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_grn', $data);

        $grnID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $materialname=$rowtabledata['col_1'];
            $comment=$rowtabledata['col_2'];
            $mfdate=$rowtabledata['col_3'];
            $expdate=$rowtabledata['col_4'];
            $quater=$rowtabledata['col_5'];
            $materialID=$rowtabledata['col_6'];
            $unit=$rowtabledata['col_7'];
            $unitperctn=$rowtabledata['col_8'];
            $ctn=$rowtabledata['col_9'];
            $qty=$rowtabledata['col_10'];
            $nettotal=$rowtabledata['col_11'];

            $dataone = array(
                'date'=> $grndate, 
                'unitperctn'=> $unitperctn, 
                'ctn'=> $ctn, 
                'qty'=> $qty, 
                'unitprice'=> $unit, 
                'costunitprice'=> $unit, 
                'total'=> $nettotal, 
                'comment'=> $comment, 
                'mfdate'=> $mfdate, 
                'expdate'=> $expdate, 
                'quater'=> $quater, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_grn_idtbl_grn'=> $grnID, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );

            $this->db->insert('tbl_grndetail', $dataone);

            $sqlcheck = "SELECT `qty` FROM `tbl_stock` WHERE `tbl_material_info_idtbl_material_info` = ? AND `batchno` = ? AND `tbl_location_idtbl_location` = ? AND `status` = ?";
            $respondcheck = $this->db->query($sqlcheck, array($materialID, $batchno, $location, 1));
        
            if($respondcheck->num_rows() == 0) {
                $data = array(
                    'batchno' => $batchno,
                    'qty' => $qty,
                    'unitprice' => $unit,
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
                    'unitprice' => $unit,
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
    public function Goodreceiveview(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `u`.*, `ua`.`suppliername`, `ua`.`primarycontactno`, `ua`.`secondarycontactno`, `ua`.`address`, `ua`.`email`, `ub`.`location`, `ub`.`phone`, `ub`.`address`, `ub`.`phone2`, `ub`.`email` AS `locemail` FROM `tbl_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) WHERE `u`.`status`=? AND `u`.`idtbl_grn`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_grndetail.*, tbl_material_info.materialinfocode, tbl_material_info.materialname, tbl_unit.unitname');
        $this->db->from('tbl_grndetail');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_unit', 'tbl_unit.idtbl_unit = tbl_material_info.tbl_unit_idtbl_unit', 'left');
        $this->db->where('tbl_grndetail.tbl_grn_idtbl_grn', $recordID);
        $this->db->where('tbl_grndetail.status', 1);

        $responddetail=$this->db->get();
        // print_r($this->db->last_query());

        $html='';
        $html.='
        <div class="row">
            <div class="col-12">'.$respond->row(0)->location.'<br>'.$respond->row(0)->phone.' / '.$respond->row(0)->phone2.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->locemail.'</div>
            <div class="col-12 text-right">'.$respond->row(0)->suppliername.'<br>'.$respond->row(0)->primarycontactno.' / '.$respond->row(0)->secondarycontactno.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->email.'</div>
            <div class="col-12">
                <hr>
                <h6>Invoice No : '.$respond->row(0)->invoicenum.'</h6>
                <h6>Dispatch No : '.$respond->row(0)->dispatchnum.'</h6>
                <h6>Batch No : '.$respond->row(0)->batchno.'</h6>
            </div>
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
                        $total=number_format(($roworderinfo->qty*$roworderinfo->unitprice), 2);
                        $html.='<tr>
                            <td>'.$roworderinfo->materialname.' / '.$roworderinfo->materialinfocode.'</td>
                            <td>'.$roworderinfo->unitname.'</td>
                            <td>'.$roworderinfo->unitperctn.'</td>
                            <td>'.$roworderinfo->ctn.'</td>
                            <td>'.$roworderinfo->qty.'</td>
                            <td>'.number_format(($roworderinfo->unitprice), 2).'</td>
                            <td class="text-right">'.$total.'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-bold">Rs. '.number_format(($respond->row(0)->total), 2).'</h3></div>
        </div>
        ';

        echo $html;
    }
    public function Goodreceivestatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'approvestatus' => '1',
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

            			$this->db->select('tbl_print_grn.batchno, tbl_print_grn.tbl_company_idtbl_company, tbl_print_grn.tbl_company_branch_idtbl_company_branch, tbl_print_grn.grntype, tbl_print_grn.tbl_location_idtbl_location, tbl_print_grn.tbl_supplier_idtbl_supplier, tbl_print_grn.grndate, tbl_print_grndetail.qty, tbl_print_grndetail.pieces, tbl_print_grndetail.total, tbl_print_grndetail.tbl_measurements_idtbl_mesurements, tbl_print_grndetail.unitprice, tbl_print_grndetail.tbl_print_material_info_idtbl_print_material_info, tbl_print_grndetail.tbl_machine_id, tbl_print_grndetail.tbl_sparepart_id, tbl_print_grn.tbl_print_porder_idtbl_print_porder');
			$this->db->from('tbl_print_grn');
			$this->db->join('tbl_print_grndetail', 'tbl_print_grn.idtbl_print_grn = tbl_print_grndetail.tbl_print_grn_idtbl_print_grn', 'left');
			$this->db->where('tbl_print_grn.status', 1);
			$this->db->where('tbl_print_grn.idtbl_print_grn', $approveID);
			$respond = $this->db->get();

			if ($respond->num_rows() > 0) {
				foreach ($respond->result() as $row) {
					$batchno = $row->batchno;
					$location = $row->tbl_location_idtbl_location;
					$supplier = $row->tbl_supplier_idtbl_supplier;
					$grndate = $row->grndate;
					$qty = $row->qty;
					$pieces = $row->pieces;
					$measure_type = $row->tbl_measurements_idtbl_mesurements;
					$unitprice = $row->unitprice;
					$total = $row->total;
					$materialID = $row->tbl_print_material_info_idtbl_print_material_info;
					$orderType = $row->grntype;
					$machineID = $row->tbl_machine_id;
					$sparepartID = $row->tbl_sparepart_id;
					$companyid = $row->tbl_company_idtbl_company;
					$branchid = $row->tbl_company_branch_idtbl_company_branch;

					$finalQty = ($pieces != 0) ? $pieces : $qty;

					$stockData = array(
						'batchno' => $batchno,
						'location' => $location,
						'grndate' => $grndate,
						'supplier_id' => $supplier,
						'qty' => $finalQty,
						'measure_type_id' => $measure_type,
						'unitprice' => $unitprice,
						'total' => $total,
						'status' => '1',
						'insertdatetime' => $updatedatetime,
						'tbl_user_idtbl_user' => $userID,
						'tbl_company_idtbl_company' => $companyid,
						'tbl_company_branch_idtbl_company_branch' => $branchid
					);

					if ($orderType == 3) {
						$stockData['tbl_print_material_info_idtbl_print_material_info'] = $materialID;
					} elseif ($orderType == 4) {
						$stockData['tbl_machine_id'] = $machineID;
					} elseif ($orderType == 1) {
						$stockData['tbl_sparepart_id'] = $sparepartID;
					}

					$this->db->insert('tbl_print_stock', $stockData);
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
                redirect('Goodreceive');                
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
                redirect('Goodreceive');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_grn', $recordID);
            $this->db->update('tbl_grn', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Reject Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Goodreceive');                
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
                redirect('Goodreceive');
            }
        }
    }
    public function Getsupplieraccoporder(){
        $recordID=$this->input->post('recordID');

        $this->db->select('`tbl_supplier_idtbl_supplier`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('idtbl_porder', $recordID);

        $respond=$this->db->get();

        echo $respond->row(0)->tbl_supplier_idtbl_supplier;
    }
    public function Getproductaccoporder(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname` FROM `tbl_porder_detail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_porder_detail`.`tbl_material_info_idtbl_material_info` WHERE `tbl_material_info`.`status`=? AND `tbl_porder_detail`.`tbl_porder_idtbl_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getproductinfoaccoproduct(){
        $recordID = $this->input->post('recordID');
        $porderID = $this->input->post('porderID');
    
        if ($porderID != "") {
            $this->db->select('qty, unitperctn, ctn, unitprice, comment');
            $this->db->from('tbl_porder_detail');
            $this->db->where('status', 1);
            $this->db->where('tbl_material_info_idtbl_material_info', $recordID);
            $this->db->where('tbl_porder_idtbl_porder', $porderID);
            $respond = $this->db->get();
    
            if ($respond->num_rows() > 0) {
                $obj = new stdClass();
                $row = $respond->row();
                $obj->qty = $row->qty;
                $obj->unitprice = $row->unitprice;
                $obj->unitperctn = $row->unitperctn;
                $obj->ctn = $row->ctn;
                $obj->comment = $row->comment;
            } else {
                $obj = new stdClass();
                $obj->qty = 0;
                $obj->unitprice = 0;
                $obj->unitperctn = 0;
                $obj->ctn = 0;
                $obj->comment = '';
            }
        } else {
            $obj = new stdClass();
            $obj->qty = 0;
            $obj->unitprice = 0;
            $obj->unitperctn = 0;
            $obj->ctn = 0;
            $obj->comment = '';
        }
        echo json_encode($obj);
    }
    
    public function Getexpdateaccoquater(){
        $recordID=$this->input->post('recordID');
        $mfdate=$this->input->post('mfdate');

        if($recordID==1){$addmonth=3;}
        else if($recordID==2){$addmonth=6;}
        else if($recordID==3){$addmonth=9;}
        else if($recordID==4){$addmonth=12;}
        else if($recordID==5){$addmonth=18;}
        else if($recordID==6){$addmonth=24;}

        echo date('Y-m-d', strtotime("+$addmonth months", strtotime($mfdate)));
    }
    public function Getbatchnoaccosupplier(){
        $recordID=$this->input->post('recordID');

        if(!empty( $recordID)){
            $this->db->select('tbl_supplier.`suppliercode`, tbl_material_category.categorycode');
            $this->db->from('tbl_supplier');
            $this->db->join('tbl_supplier_has_tbl_material_category', 'tbl_supplier_has_tbl_material_category.tbl_supplier_idtbl_supplier = tbl_supplier.idtbl_supplier', 'left');
            $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_supplier_has_tbl_material_category.tbl_material_category_idtbl_material_category', 'left');
            $this->db->where('tbl_supplier.idtbl_supplier', $recordID);
            $this->db->where('tbl_supplier.status', 1);

            $responddetail=$this->db->get();

            // print_r($this->db->last_query());    
            $materialcode=$responddetail->row(0)->categorycode;
            $suppliercode=$responddetail->row(0)->suppliercode;

            $sql="SELECT COUNT(*) AS `count` FROM `tbl_grn`";
            $respond=$this->db->query($sql);
        
            if($respond->row(0)->count==0){$batchno=date('dmY').'001';}
            else{
                $count='000'.($respond->row(0)->count+1);
                $count=substr($count, -3);
                $batchno=date('dmY').$count;
            }
        
            echo $suppliercode.$materialcode.$batchno;
        }
        else{
            echo '';
        }
    }
    public function Getordertype(){
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getpordertpeaccoporder(){
        $recordID=$this->input->post('recordID');
        
        $this->db->select('`tbl_order_type_idtbl_order_type`');
        $this->db->from('tbl_porder');
        $this->db->where('status', 1);
        $this->db->where('idtbl_porder', $recordID);

        $respond=$this->db->get();

        echo $respond->row(0)->tbl_order_type_idtbl_order_type;
    }
    public function Costinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $grnID=$this->input->post('grnID');

        $insertdatetime=date('Y-m-d H:i:s');
        $adddate=date('Y-m-d');

        $totalcost=0;

        foreach($tableData as $rowtabledata){
            $totalcost=$totalcost+$rowtabledata['col_3'];

            $data = array( 
                'adddate'=> $adddate,
                'costamount'=> $rowtabledata['col_3'],
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_expence_type_idtbl_expence_type'=> $rowtabledata['col_2'],
                'tbl_grn_idtbl_grn'=> $grnID
                
            );

            $this->db->insert('tbl_grn_other_cost', $data);
        }

        $sql='SELECT SUM(`qty`) AS `totalsumqty` FROM `tbl_grndetail` WHERE `status`=? AND `tbl_grn_idtbl_grn`=?';
        $respond=$this->db->query($sql, array(1, $grnID));

        $unitothercostprice=$totalcost/$respond->row(0)->totalsumqty;

        $sqlgrndetail="SELECT `unitprice`, `idtbl_grndetail` FROM `tbl_grndetail` WHERE `status`=? AND `tbl_grn_idtbl_grn`=?";
        $respondgrndetail=$this->db->query($sqlgrndetail, array(1, $grnID));

        foreach($respondgrndetail->result() AS $rowgrninfo){
            $unitcostprice=$rowgrninfo->unitprice+$unitothercostprice;
            $idtbl_grndetail=$rowgrninfo->idtbl_grndetail;

            $dataupdate = array( 
                'costunitprice'=> $unitcostprice,
                'updateuser'=> $userID,
                'updatedatetime'=> $insertdatetime,
            );

            $this->db->where('idtbl_grndetail', $idtbl_grndetail);
            $this->db->update('tbl_grndetail', $dataupdate);
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
            redirect('Goodreceive');                
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
            redirect('Goodreceive');
        }  
    }
    public function Getallocatecostlist(){

        $recordID=$this->input->post('recordID');

        $html='';

        $sql="SELECT `tbl_grn_other_cost`.`idtbl_grn_other_cost`, `tbl_expence_type`.`expencetype`, `tbl_grn_other_cost`.`costamount` FROM `tbl_grn_other_cost`
        LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`=`tbl_grn_other_cost`.`tbl_expence_type_idtbl_expence_type`
         WHERE `tbl_grn_other_cost`.`tbl_grn_idtbl_grn`=? AND `tbl_grn_other_cost`.`status`= 1";
        $respond=$this->db->query($sql, array($recordID));

        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
                <td>'.$rowlist->idtbl_grn_other_cost.'</td>
                <td>'.$rowlist->expencetype.'</td>
                <td class="totalcost">'.$rowlist->costamount.'</td>                
             </tr>
            
            ';
        }

        echo $html;

    }

    public function Getexpencetype(){
        $grnid=$this->input->post('grnid');

        $sql="SELECT `tbl_expence_type`.`idtbl_expence_type`,`tbl_expence_type`.`expencetype` FROM `tbl_expence_type`
        WHERE `tbl_expence_type`.`status`=? AND `tbl_expence_type`.`idtbl_expence_type` NOT IN (SELECT `tbl_expence_type_idtbl_expence_type`
        FROM `tbl_grn_other_cost` WHERE `status`=1 AND `tbl_grn_idtbl_grn`=?)";

        $respond=$this->db->query($sql, array(1, $grnid));

        echo json_encode($respond->result());

    }

    public function Getmateriallistaccogrn(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname` FROM `tbl_grndetail` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` WHERE `tbl_material_info`.`status`=? AND `tbl_grndetail`.`tbl_grn_idtbl_grn`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getgrninfoaccogrnid(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `idtbl_grn`,`tbl_porder_idtbl_porder`, `batchno` FROM `tbl_grn` WHERE `idtbl_grn`=?";
        $respond=$this->db->query($sql, array($recordID));

        echo json_encode($respond->row(0));
    }
    public function Getmaterialinfoaccogrnlable(){
        $recordID=$this->input->post('recordID');
        $materialID=$this->input->post('materialID');

        $sql="SELECT `mfdate`, `expdate` FROM `tbl_grndetail` WHERE `tbl_grn_idtbl_grn`=? AND `tbl_material_info_idtbl_material_info`=? AND `status`=?";
        $respond=$this->db->query($sql, array($recordID, $materialID, 1));

        echo json_encode($respond->row(0));
    }
}