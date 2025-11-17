<?php
class Productionorderviewinfo extends CI_Model{
    public function Productionorderstatus($x, $y){
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

            $this->db->where('idtbl_production_orderdetail', $recordID);
            $this->db->update('tbl_production_orderdetail', $data);

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
    }
    public function Checkmachineavailability(){
        $machineid = $_POST['machineid'];
        $startdate = $_POST['startdate'];
        $enddate = $_POST['enddate'];

        $sql="SELECT `tbl_machine_idtbl_machine`, `startdatetime`, `enddatetime` FROM `tbl_machine_allocation`
        WHERE '$startdate' < DATE(`enddatetime`) AND '$enddate' > DATE(`startdatetime`) AND `tbl_machine_idtbl_machine`= ?  AND `status`= 1";
        $respond=$this->db->query($sql, array($machineid));
        //echo $sql;die;//var_dump($respond);
        //     WHERE new_start < existing_end
        //   AND new_end   > existing_start;

        $obj=new stdClass();
        if($respond->num_rows() > 0){    
            $obj->actiontype = 1; 
        }
        else{
            $obj->actiontype = 2;
        }
        echo json_encode($obj);

    }
    public function Productiondetailaccoproduction(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_orderdetail`.`idtbl_production_orderdetail`, `tbl_product`.`prodcutname`, `tbl_product`.`idtbl_product`, `tbl_product`.`productcode` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` WHERE `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`=? AND `tbl_production_orderdetail`.`status`=? AND `tbl_production_orderdetail`.`materialissue`=?";
        $respond=$this->db->query($sql, array($recordID, 1, 0));

        echo json_encode($respond->result());
    }
    public function Getqtyinfoaccoproductiondetail(){
        $recordID=$this->input->post('recordID');
        $productionid=$this->input->post('productionid');

        $sql="SELECT `qty`, `issueqty` FROM `tbl_production_orderdetail` WHERE `tbl_production_order_idtbl_production_order`=? AND `tbl_product_idtbl_product`=?";
        $respond=$this->db->query($sql, array($productionid, $recordID));

        echo json_encode($respond->result());
    }
    public function Getrowmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getpackmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 2, $recordID));

        echo json_encode($respond->result());
    }
    public function Getlablemateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_orderdetail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_orderdetail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_orderdetail`.`idtbl_production_orderdetail`=?";
        $respond=$this->db->query($sql, array(1, 3, $recordID));

        echo json_encode($respond->result());
    }
    public function Getmaterialenterlayout(){
        echo '<table class="table table-striped table-bordered table-sm small">
            <tr>
                <th>Raw Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="rowmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Raw Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Raw Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm rowmaterial">
                                        <option value="">Raw Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Packing Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="packingmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm packingmaterial">
                                        <option value="">Packing Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <th>Lable Material</th>
                <td class="p-0 border-0">
                    <table class="table-striped table-bordered table-sm w-100" id="lablingmaterialtable">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Batch No</th>
                                <th>Qty</th>
                                <th class="d-none">materialID</th>
                                <th class="d-none">qtylist</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labelling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labelling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                    <select class="form-control form-control-sm lablematerial">
                                        <option value="">Labelling Material</option>
                                    </select>
                                </td>
                                <td></td>
                                <td></td>
                                <td class="d-none"></td>
                                <td class="d-none"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>';
    }
    public function Getmaterialstockinfoaccomaterial(){
        $materialID=$this->input->post('materialID');

        $sql="SELECT `batchno`, `qty` FROM `tbl_stock` WHERE `tbl_material_info_idtbl_material_info`=? AND `status`=?";
        $respond=$this->db->query($sql, array($materialID, 1));

        $html='';
        foreach($respond->result() as $rowstocklist){
            $html.='
            <tr>
                <td>'.$rowstocklist->batchno.'</td>
                <td>'.$rowstocklist->qty.'</td>
                <td class="enterqty"></td>
                <td class="d-none">'.$rowstocklist->batchno.'</td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Checkissueqty(){
        $recordID=$this->input->post('recordID');
        $productionmaterialinfoID=$this->input->post('productionmaterialinfoID');

        $sql="SELECT SUM(`qty`) AS `issueqty` FROM `tbl_production_material` WHERE `tbl_production_orderdetail_idtbl_production_orderdetail`=? AND `tbl_material_info_idtbl_material_info`=?";
        $respond=$this->db->query($sql, array($productionmaterialinfoID, $recordID));

        echo $respond->row(0)->issueqty;
    }
    public function Issuematerialforproduction(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $productionorderID=$this->input->post('productionorderid');
        $orderfinishgood=$this->input->post('orderfinishgood');
        $orderqty=$this->input->post('orderqty');
        $balanceqty=$this->input->post('balanceqty');
        $tableData=$this->input->post('tableData');

        $updatedatetime=date('Y-m-d H:i:s');
        $today=date('Y-m-d');

        $this->db->select('`tbl_product_idtbl_product`, `tbl_production_order_idtbl_production_order`, `qty`, `issueqty`');
        $this->db->from('tbl_production_orderdetail');
        $this->db->where('idtbl_production_orderdetail', $productionorderID);

        $respondproductiondetail=$this->db->get();

        $totalissueqty=$respondproductiondetail->row(0)->issueqty+$balanceqty;

        if($respondproductiondetail->row(0)->qty==$totalissueqty){
            $dataupdate = array( 
                'materialissue'=> '1', 
                'partialissued'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('tbl_production_order_idtbl_production_order', $productionorderID);
            $this->db->where('tbl_product_idtbl_product', $orderfinishgood);
            $this->db->update('tbl_production_orderdetail', $dataupdate);
        }
        else{
            $dataupdate = array( 
                'partialissued'=> '1', 
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );
            $this->db->set('issueqty', 'issueqty + ' . $balanceqty, false);
            $this->db->where('tbl_production_order_idtbl_production_order', $productionorderID);
            $this->db->where('tbl_product_idtbl_product', $orderfinishgood);
            $this->db->update('tbl_production_orderdetail', $dataupdate);
        }

        foreach($tableData as $rowmaterial){
            $materialID=$rowmaterial['col_2'];
            $materialcode=$rowmaterial['col_3'];
            $qty=$rowmaterial['col_4'];
            $batchnumlist=$rowmaterial['col_5'];

            $checkbatchlist=explode(',', $batchnumlist);

            $data = array(
                'qty'=> $qty, 
                'batchno'=> $batchnumlist, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_production_order_idtbl_production_order'=> $productionorderID, 
                'tbl_product_idtbl_product'=> $orderfinishgood, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );
            $this->db->insert('tbl_production_material_issue', $data);

            $balqty=$qty;
            foreach($checkbatchlist as $rowcheckbatchlist){
                $this->db->select('`batchno`, `qty`');
                $this->db->from('tbl_stock');
                $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                $this->db->where_in('batchno', $rowcheckbatchlist);
                $this->db->where('status', 1);

                $respondstock=$this->db->get();

                // print_r($this->db->last_query()); 

                if($balqty>0){
                    if($respondstock->row(0)->qty>=$balqty){
                        $dedqty=$respondstock->row(0)->qty-$balqty;
                        $balqty=0;
                    }
                    else{
                        $dedqty=0;
                        $balqty=$balqty-$respondstock->row(0)->qty;
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
                }
                else{
                    break;
                }
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
    public function Getprodcutioninfo(){
        $productionid=$this->input->post('productionid');
        $orderfinishgood=$this->input->post('orderfinishgood');
        $productbomlist=$this->input->post('productbomlist');
        $orderqty=$this->input->post('orderqty');

        $this->db->select('tbl_product_bom.qty, tbl_product_bom.wastage, tbl_product_bom.tbl_material_info_idtbl_material_info, tbl_product_bom.idtbl_product_bom, tbl_material_info.materialinfocode');
        $this->db->from('tbl_product_bom');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_product_bom.tbl_material_info_idtbl_material_info', 'left');
        $this->db->join('tbl_production_orderdetail', 'tbl_production_orderdetail.tbl_product_idtbl_product = tbl_product_bom.tbl_product_idtbl_product', 'left');
        $this->db->where('tbl_production_orderdetail.idtbl_production_orderdetail', $productionid);
        $this->db->where('tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info', $productbomlist);
        $this->db->where('tbl_product_bom.status', 1);

        $respond=$this->db->get();
        // print_r($this->db->last_query()); 

        $statusstock=0;
        $html='';
        foreach($respond->result() as $rowmaterialbomlist){
            $materialID=$rowmaterialbomlist->tbl_material_info_idtbl_material_info;
            $checkqty=(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$orderqty);

            $this->db->select('SUM(qty) AS sumqty');
            $this->db->from('tbl_stock');
            $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
            $this->db->where('status', 1);

            $respondcheck=$this->db->get();

            // print_r($this->db->last_query()); 

            // if($respondcheck->row(0)->sumqty<$checkqty){
            if (round($respondcheck->row(0)->sumqty, 2) < round($checkqty, 2)) {
                $statusstock=1;
            }
            
            $html.='
                <tr class="pointer">
                    <td>'.$rowmaterialbomlist->idtbl_product_bom.'</td>
                    <td class="d-none">'.$rowmaterialbomlist->tbl_material_info_idtbl_material_info.'</td>
                    <td>'.$rowmaterialbomlist->materialinfocode.'</td>
                    <td>'.(($rowmaterialbomlist->qty+(($rowmaterialbomlist->qty*$rowmaterialbomlist->wastage)/100))*$orderqty).'</td>
                    <td></td>
                </tr>
            ';
        }

        $obj=new stdClass();
        $obj->stockstatus=$statusstock;
        $obj->htmlview=$html;

        echo json_encode($obj);
    }
    public function Productionbomlistaccofg(){
        $recordID=$this->input->post('recordID');
        $productionID=$this->input->post('productionID');

        $this->db->select('`tbl_product_bom_info`.`idtbl_product_bom_info`, `tbl_product_bom_info`.`title`');
        $this->db->from('tbl_product_bom_info');
        $this->db->join('tbl_product_bom', 'tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info = tbl_product_bom_info.idtbl_product_bom_info', 'left');
        $this->db->join('tbl_customer_porder_detail', 'tbl_customer_porder_detail.tbl_product_idtbl_product = tbl_product_bom.tbl_product_idtbl_product', 'left');
        $this->db->join('tbl_production_order', 'tbl_production_order.tbl_customer_porder_idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', 'left');
        $this->db->where('tbl_product_bom_info.status', 1);
        $this->db->where('tbl_customer_porder_detail.tbl_product_idtbl_product', $recordID);
        $this->db->where('tbl_production_order.idtbl_production_order', $productionID);
        $this->db->where('tbl_customer_porder_detail.status', 1);
        $this->db->group_by('tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info');

        $respond=$this->db->get();

        // print_r($this->db->last_query());
        echo json_encode($respond->result());
    }
}