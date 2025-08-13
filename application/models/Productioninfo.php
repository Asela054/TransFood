<?php
class Productioninfo extends CI_Model{
    public function Productionapprovel(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$this->input->post('recordID');
        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'approvestatus'=> '1', 
            'updateuser'=> $userID, 
            'updatedatetime' => $updatedatetime
        );

        $this->db->where('idtbl_production_order', $recordID);
        $this->db->update('tbl_production_order', $data);

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
    public function Getrowmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_order_detail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_order_detail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_order_detail`.`idtbl_production_order_detail`=?";
        $respond=$this->db->query($sql, array(1, 1, $recordID));

        echo json_encode($respond->result());
    }
    public function Getpackmateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_order_detail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_order_detail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_order_detail`.`idtbl_production_order_detail`=?";
        $respond=$this->db->query($sql, array(1, 2, $recordID));

        echo json_encode($respond->result());
    }
    public function Getlablemateriallist(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_production_order_detail` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_product_idtbl_product`=`tbl_production_order_detail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_material_info`.`status`=? AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_production_order_detail`.`idtbl_production_order_detail`=?";
        $respond=$this->db->query($sql, array(1, 3, $recordID));

        echo json_encode($respond->result());
    }
    public function Productiondetailaccoproduction(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_order_detail`.`idtbl_production_order_detail`, `tbl_material_code`.`materialname`, `tbl_product`.`productcode` FROM `tbl_production_order_detail` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_order_detail`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_production_order_detail`.`tbl_production_order_idtbl_production_order`=? AND `tbl_production_order_detail`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    }
    public function Getqtyinfoaccoproductiondetail(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_order_detail`.`qty`, `tbl_production_material`.`issueqty` FROM `tbl_production_order_detail` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`tbl_production_order_detail_idtbl_production_order_detail`=`tbl_production_order_detail`.`idtbl_production_order_detail` WHERE `tbl_production_order_detail`.`idtbl_production_order_detail`=? AND `tbl_production_order_detail`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
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
    public function Productioninsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableDataMaterial=$this->input->post('tableDataMaterial');
        $tableDataPacking=$this->input->post('tableDataPacking');
        $tableDataLabeling=$this->input->post('tableDataLabeling');
        $orderqty=$this->input->post('orderqty');
        $orderfinishgood=$this->input->post('orderfinishgood');
        $productionorder=$this->input->post('productionorder');

        $updatedatetime=date('Y-m-d H:i:s');

        if(!empty($tableDataMaterial)){
            foreach($tableDataMaterial as $rowmaterial){
                $batchnumlist=$rowmaterial['col_2'];
                $totalqty=$rowmaterial['col_3'];
                $materialID=$rowmaterial['col_4'];
                $qtylist=$rowmaterial['col_5'];

                $this->db->select('`issueqty`');
                $this->db->from('tbl_production_material');
                $this->db->where('tbl_production_order_idtbl_production_order', $productionorder);
                $this->db->where('tbl_production_order_detail_idtbl_production_order_detail', $orderfinishgood);

                $respond=$this->db->get();

                if($respond->num_rows()>0){$totalissue=$respond->row(0)->issueqty+$totalqty;}
                else{$totalissue=$totalqty;}

                $this->db->select('`tbl_material_category_idtbl_material_category`');
                $this->db->from('tbl_material_info');
                $this->db->where('idtbl_material_info', $materialID);

                $respondmaterial=$this->db->get();

                $materialcategory=$respondmaterial->row(0)->tbl_material_category_idtbl_material_category;

                $dataone = array(
                    'reqqty'=> $orderqty, 
                    'issueqty'=> $totalissue, 
                    'lastqty'=> $totalqty, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                    'tbl_material_info_idtbl_material_info'=> $materialID, 
                    'tbl_production_order_idtbl_production_order'=> $productionorder, 
                    'tbl_production_order_detail_idtbl_production_order_detail'=> $orderfinishgood
                );

                $this->db->insert('tbl_production_material', $dataone); 

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataone = array(
                        'batchno'=>$batchno, 
                        'qty'=>$qtycount, 
                        'tbl_production_material_idtbl_production_material'=>$productionmaterialID, 
                        'tbl_material_info_idtbl_material_info'=>$materialID
                    );

                    $this->db->insert('tbl_production_material_info', $dataone);

                    $sqlcheck="SELECT `qty` FROM `tbl_stock` WHERE `tbl_material_info_idtbl_material_info`=? AND `batchno`=? AND `status`=?";
                    $respondcheck=$this->db->query($sqlcheck, array($materialID, $batchno, 1));

                    $newqty=$respondcheck->row(0)->qty-$qtycount;

                    $datastock = array( 
                        'qty'=>$newqty,
                        'updateuser'=>$userID,
                        'updatedatetime'=>$updatedatetime
                    );
                    $this->db->where('batchno', $batchno);
                    $this->db->where('tbl_material_info_idtbl_material_info', $materialID);
                    $this->db->update('tbl_stock', $datastock);

                    $i++;
                }
            }
        }

        if(!empty($tableDataPacking)){
            foreach($tableDataPacking as $rowpacking){
                $batchnumlist=$rowpacking['col_2'];
                $totalqty=$rowpacking['col_3'];
                $materialID=$rowpacking['col_4'];
                $qtylist=$rowpacking['col_5'];

                $this->db->select('`issueqty`');
                $this->db->from('tbl_production_material');
                $this->db->where('tbl_production_order_idtbl_production_order', $productionorder);
                $this->db->where('tbl_production_order_detail_idtbl_production_order_detail', $orderfinishgood);

                $respond=$this->db->get();

                if($respond->num_rows()>0){$totalissue=$respond->row(0)->issueqty+$totalqty;}
                else{$totalissue=$totalqty;}

                $this->db->select('`tbl_material_category_idtbl_material_category`');
                $this->db->from('tbl_material_info');
                $this->db->where('idtbl_material_info', $materialID);

                $respondmaterial=$this->db->get();

                $materialcategory=$respondmaterial->row(0)->tbl_material_category_idtbl_material_category;

                $dataone = array(
                    'reqqty'=> $orderqty, 
                    'issueqty'=> $totalissue, 
                    'lastqty'=> $totalqty, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                    'tbl_material_info_idtbl_material_info'=> $materialID, 
                    'tbl_production_order_idtbl_production_order'=> $productionorder, 
                    'tbl_production_order_detail_idtbl_production_order_detail'=> $orderfinishgood
                );

                $this->db->insert('tbl_production_material', $dataone);

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataone = array(
                        'batchno'=>$batchno, 
                        'qty'=>$qtycount, 
                        'tbl_production_material_idtbl_production_material'=>$productionmaterialID, 
                        'tbl_material_info_idtbl_material_info'=>$materialID
                    );

                    $this->db->insert('tbl_production_material_info', $dataone);

                    $i++;
                }
            }
        }

        if(!empty($tableDataLabeling)){
            foreach($tableDataLabeling as $rowlabeling){
                $batchnumlist=$rowlabeling['col_2'];
                $totalqty=$rowlabeling['col_3'];
                $materialID=$rowlabeling['col_4'];
                $qtylist=$rowlabeling['col_5'];

                $this->db->select('`issueqty`');
                $this->db->from('tbl_production_material');
                $this->db->where('tbl_production_order_idtbl_production_order', $productionorder);
                $this->db->where('tbl_production_order_detail_idtbl_production_order_detail', $orderfinishgood);

                $respond=$this->db->get();

                if($respond->num_rows()>0){$totalissue=$respond->row(0)->issueqty+$totalqty;}
                else{$totalissue=$totalqty;}

                $this->db->select('`tbl_material_category_idtbl_material_category`');
                $this->db->from('tbl_material_info');
                $this->db->where('idtbl_material_info', $materialID);

                $respondmaterial=$this->db->get();

                $materialcategory=$respondmaterial->row(0)->tbl_material_category_idtbl_material_category;

                $dataone = array(
                    'reqqty'=> $orderqty, 
                    'issueqty'=> $totalissue, 
                    'lastqty'=> $totalqty, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_material_category_idtbl_material_category'=> $materialcategory, 
                    'tbl_material_info_idtbl_material_info'=> $materialID, 
                    'tbl_production_order_idtbl_production_order'=> $productionorder, 
                    'tbl_production_order_detail_idtbl_production_order_detail'=> $orderfinishgood
                );

                $this->db->insert('tbl_production_material', $dataone);

                $productionmaterialID=$this->db->insert_id();

                $explodebatchno=explode(',', $batchnumlist);
                $explodebatchno=array_filter($explodebatchno);
                $explodeqtylist=explode(',', $qtylist);
                $explodeqtylist=array_filter($explodeqtylist);

                $i=0;
                foreach($explodebatchno as $batchno){
                    $qtycount=$explodeqtylist[$i];

                    $dataone = array(
                        'batchno'=>$batchno, 
                        'qty'=>$qtycount, 
                        'tbl_production_material_idtbl_production_material'=>$productionmaterialID, 
                        'tbl_material_info_idtbl_material_info'=>$materialID
                    );

                    $this->db->insert('tbl_production_material_info', $dataone);

                    $i++;
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
    public function Getmaterialenterlayout(){
        echo '<table class="table table-striped table-bordered table-sm small">
            <tr>
                <th>Row Material</th>
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
                                        <option value="">Row Material</option>
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
                                        <option value="">Row Material</option>
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
                                        <option value="">Row Material</option>
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
                                        <option value="">Labling Material</option>
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
                                        <option value="">Labling Material</option>
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
                                        <option value="">Labling Material</option>
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
    public function Checkissueqty(){
        $recordID=$this->input->post('recordID');
        $productionmaterialinfoID=$this->input->post('productionmaterialinfoID');

        $sql="SELECT SUM(`qty`) AS `issueqty` FROM `tbl_production_material_info` WHERE `tbl_material_info_idtbl_material_info`=? AND `tbl_production_material_idtbl_production_material`=?";
        $respond=$this->db->query($sql, array($recordID, $productionmaterialinfoID));

        echo $respond->row(0)->issueqty;
    }
    public function Productionmaterialdetailaccoproductionmaterial(){
        $listarray=array();
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_material_info`.`idtbl_production_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_production_material_info`.`batchno`, `tbl_production_material_info`.`qty` FROM `tbl_production_material_info` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_info`.`tbl_production_material_idtbl_production_material` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_material`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_production_material`.`idtbl_production_material`=? AND `tbl_production_material`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlistproduction){
            $idtbl_production_material_info=$rowlistproduction->idtbl_production_material_info;

            $sqlissue="SELECT SUM(`allocateqty`) AS `issueqty` FROM `tbl_machine_allocation` WHERE `tbl_production_material_info_idtbl_production_material_info`=? AND `status`=?";
            $respondissue=$this->db->query($sqlissue, array($idtbl_production_material_info, 1));
   
            if($respondissue->row(0)->issueqty>0){
                $balanceqty=$rowlistproduction->qty-$respondissue->row(0)->issueqty;
            }
            else{
                $balanceqty=$rowlistproduction->qty;
            }
            
            if($balanceqty>0){
                $obj=new stdClass();
                $obj->idtbl_production_material_info=$rowlistproduction->idtbl_production_material_info;
                $obj->materialinfocode=$rowlistproduction->materialinfocode;
                $obj->materialname=$rowlistproduction->materialname;
                $obj->batchno=$rowlistproduction->batchno;
                $obj->qty=$rowlistproduction->qty;

                array_push($listarray, $obj);
            }
        }

        echo json_encode($listarray);
    }
    public function Getfactorylist(){
        $this->db->select('`idtbl_factory`, `factoryname`, `factorycode`');
        $this->db->from('tbl_factory');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getmachineaccofactory(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine`, `tbl_machine`.`machinecode` FROM `tbl_machine` LEFT JOIN `tbl_factory_has_tbl_machine` ON `tbl_factory_has_tbl_machine`.`tbl_machine_idtbl_machine`=`tbl_machine`.`idtbl_machine` WHERE `tbl_factory_has_tbl_machine`.`tbl_factory_idtbl_factory`=? AND `tbl_machine`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());
    }
    public function Productionmachineinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $hideprodcutionordermachine=$this->input->post('hideprodcutionordermachine');

        $updatedatetime=date('Y-m-d H:i:s');

        foreach($tableData AS $rowlistmaterial){
            $productionmaterialinfoID=$rowlistmaterial['col_8'];
            if(!empty($rowlistmaterial['col_9'])){$factoryID=$rowlistmaterial['col_9'];}
            else{$factoryID=1;}
            if(!empty($rowlistmaterial['col_10'])){$machineID=$rowlistmaterial['col_10'];}
            else{$machineID=1;}   
            $directtrans=$rowlistmaterial['col_11'];
            $startdatetime=$rowlistmaterial['col_5'];
            $enddatetime=$rowlistmaterial['col_6'];
            $allocateqty=$rowlistmaterial['col_2'];

            $startdate = date("Y-m-d", strtotime($startdatetime));

            if($directtrans==1){
                $packtrans=1;
                $machinetrans=0;
            }
            else{
                $packtrans=0;
                $machinetrans=1;
            }

            $this->db->select('`tbl_production_material_idtbl_production_material`');
            $this->db->from('tbl_production_material_info');
            $this->db->where('idtbl_production_material_info', $productionmaterialinfoID);

            $respond=$this->db->get();

            $productionmaterialID=$respond->row(0)->tbl_production_material_idtbl_production_material;

            $data = array(
                'date'=> $startdate, 
                'startdatetime'=> $startdatetime, 
                'enddatetime'=> $enddatetime, 
                'allocateqty'=> $allocateqty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_production_material_idtbl_production_material'=> $productionmaterialID, 
                'tbl_factory_idtbl_factory'=> $factoryID, 
                'tbl_machine_idtbl_machine'=> $machineID, 
                'tbl_production_material_info_idtbl_production_material_info'=> $productionmaterialinfoID
            );

            $this->db->insert('tbl_machine_allocation', $data); 

            $dataone = array(
                'machineallocatestatus'=> $machinetrans, 
                'tanspackstatus'=> $packtrans
            );

            $this->db->where('idtbl_production_material_info', $productionmaterialinfoID);
            $this->db->update('tbl_production_material_info', $dataone);
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
    public function Getmachineavailableqty(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `qty` FROM `tbl_production_material_info` WHERE `idtbl_production_material_info`=?";
        $respond=$this->db->query($sql, array($recordID));

        $sqlissue="SELECT SUM(`allocateqty`) AS `issueqty` FROM `tbl_machine_allocation` WHERE `tbl_production_material_info_idtbl_production_material_info`=? AND `status`=?";
        $respondissue=$this->db->query($sqlissue, array($recordID, 1));

        if($respondissue->num_rows()>0){
            echo $respond->row(0)->qty-$respondissue->row(0)->issueqty;
        }
        else{
            echo $respond->row(0)->qty;
        }
        
    }
    public function Productionmateriallistaccoproductionordermachine(){
        $listarray=array();
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_machine_allocation`.`allocateqty`, `tbl_production_material`.`idtbl_production_material`, `tbl_machine_allocation`.`tbl_production_material_info_idtbl_production_material_info` FROM `tbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`tbl_material_info_idtbl_material_info`=`tbl_material_info`.`idtbl_material_info` LEFT JOIN `tbl_machine_allocation` ON `tbl_machine_allocation`.`tbl_production_material_idtbl_production_material`=`tbl_production_material`.`idtbl_production_material` LEFT JOIN `tbl_production_material_info` ON `tbl_production_material_info`.`tbl_production_material_idtbl_production_material`=`tbl_production_material`.`idtbl_production_material` WHERE `tbl_production_material`.`tbl_production_order_idtbl_production_order`=? AND `tbl_machine_allocation`.`status`=? AND `tbl_machine_allocation`.`tbl_factory_idtbl_factory`>? AND `tbl_machine_allocation`.`tbl_machine_idtbl_machine`>? AND `tbl_production_material_info`.`machineallocatestatus`=? AND `tbl_production_material_info`.`tanspackstatus`=?";
        $respond=$this->db->query($sql, array($recordID, 1, 1, 1, 1, 0));

        foreach($respond->result() as $rowlistproduction){
            $idtbl_material_info=$rowlistproduction->idtbl_material_info;
            $idtbl_production_material=$rowlistproduction->idtbl_production_material;

            $sqlcom="SELECT SUM(`comqty`) AS `comqty` FROM `tbl_production_daily` WHERE `tbl_production_material_idtbl_production_material`=? AND `tbl_material_info_idtbl_material_info`=? AND `status`=?";
            $respondcom=$this->db->query($sqlcom, array($idtbl_production_material, $idtbl_material_info, 1));
   
            if($respondcom->row(0)->comqty>0){
                $balanceqty=$rowlistproduction->allocateqty-$respondcom->row(0)->comqty;
            }
            else{
                $balanceqty=$rowlistproduction->allocateqty;
            }
            
            if($balanceqty>0){
                $obj=new stdClass();
                $obj->idtbl_material_info=$rowlistproduction->idtbl_material_info;
                $obj->materialinfocode=$rowlistproduction->materialinfocode;
                $obj->materialname=$rowlistproduction->materialname;
                $obj->allocateqty=$rowlistproduction->allocateqty;
                $obj->idtbl_production_material_info=$rowlistproduction->tbl_production_material_info_idtbl_production_material_info;

                array_push($listarray, $obj);
            }
        }

        echo json_encode($listarray);
    }
    public function Productionmachinecompleteinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $hideprodcutionordermachinecomplete=$this->input->post('hideprodcutionordermachinecomplete');

        $updatedatetime=date('Y-m-d H:i:s');

        foreach($tableData AS $rowlistmaterial){  
            $completeqty=$rowlistmaterial['col_2'];
            $completedate=$rowlistmaterial['col_3'];
            $materialID=$rowlistmaterial['col_4'];
            $allocateqty=$rowlistmaterial['col_5'];
            $productionmaterialinfoID=$rowlistmaterial['col_6'];

            $completeday = date("Y-m-d", strtotime($completedate));

            $this->db->select('`idtbl_production_material`');
            $this->db->from('tbl_production_material');
            $this->db->where('tbl_production_order_idtbl_production_order', $hideprodcutionordermachinecomplete);

            $respond=$this->db->get();

            $idtbl_production_material=$respond->row(0)->idtbl_production_material;

            $data = array(
                'date'=> $completeday, 
                'comqty'=> $completeqty, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_production_material_idtbl_production_material'=> $idtbl_production_material, 
                'tbl_material_info_idtbl_material_info'=> $materialID
            );

            $this->db->insert('tbl_production_daily', $data); 

            $sqlcom="SELECT SUM(`comqty`) AS `comqty` FROM `tbl_production_daily` WHERE `tbl_production_material_idtbl_production_material`=? AND `tbl_material_info_idtbl_material_info`=? AND `status`=?";
            $respondcom=$this->db->query($sqlcom, array($idtbl_production_material, $materialID, 1));

            if($respondcom->row(0)->comqty==$allocateqty){
                $dataone = array(
                    'tanspackstatus'=> '1'
                );
    
                $this->db->where('idtbl_production_material_info', $productionmaterialinfoID);
                $this->db->update('tbl_production_material_info', $dataone);
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
    public function Packmateriallistaccoproduction(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_material_info`.`idtbl_production_material_info`, `tbl_production_material_info`.`batchno`, `tbl_production_material_info`.`qty`, `tbl_production_material_info`.`machineallocatestatus`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_material_code`.`materialcode`, `tbl_production_material`.`idtbl_production_material` FROM `tbl_production_material_info` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_info`.`tbl_production_material_idtbl_production_material` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_material`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_production_material`.`tbl_production_order_idtbl_production_order`=? AND `tbl_production_material_info`.`tanspackstatus`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        $html='';
        foreach($respond->result() as $packmateriallist){
            $idtbl_production_material=$packmateriallist->idtbl_production_material;
            $idtbl_production_material_info=$packmateriallist->idtbl_production_material_info;
            $idtbl_material_info=$packmateriallist->idtbl_material_info;

            $sqlcheck="SELECT SUM(`comqty`) AS `completeqty` FROM `tbl_production_daily` WHERE `tbl_production_material_idtbl_production_material`=? AND `tbl_material_info_idtbl_material_info`=? AND `status`=?";
            $respondcheck=$this->db->query($sqlcheck, array($idtbl_production_material, $idtbl_material_info, 1));

            if($packmateriallist->machineallocatestatus==1){
                $completeqty=$respondcheck->row(0)->completeqty;
            }
            else{
                $completeqty=$packmateriallist->qty;
            }

            $html.='
            <tr>
                <td>'.$packmateriallist->materialname.'</td>
                <td>'.$packmateriallist->materialinfocode.'</td>
                <td>'.$packmateriallist->batchno.'</td>
                <td>'.$packmateriallist->qty.'</td>
                <td>'.$completeqty.'</td>
                <td class="d-none">'.$packmateriallist->idtbl_production_material_info.'</td>
                <td class="text-center"><button class="btn btn-primary btn-sm btnmaterialinfo" id="'.$idtbl_production_material.'"><i class="fab fa-searchengin"></i></button></td>
            </tr>
            ';
        }
        echo $html;
    }
    public function Productionpackqualityform(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_quality_subcategory`.`idtbl_quality_subcategory`, `tbl_quality_subcategory`.`qualitysubcategory`, `tbl_quality_subcategory`.`inputtype` FROM `tbl_quality_subcategory` LEFT JOIN `tbl_quality_category` ON `tbl_quality_category`.`idtbl_quality_category`=`tbl_quality_subcategory`.`tbl_quality_category_idtbl_quality_category` WHERE `tbl_quality_subcategory`.`status`=? AND `tbl_quality_category`.`idtbl_quality_category`=?";
        $respond=$this->db->query($sql, array(1, 2));

        $html='';
        foreach($respond->result() as $rowqualitylist){
            if($rowqualitylist->inputtype==1){
                $html.='
                <div class="form-row">
                    <div class="col">
                        <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label>
                        <input type="text" name="qualityform[]" class="form-control form-control-sm">
                        <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                    </div>
                </div>
                ';
            }
            else if($rowqualitylist->inputtype==2){
                $html.='
                <label class="small font-weight-bold text-dark">'.$rowqualitylist->qualitysubcategory.'</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail1" name="qualityform[]" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail1">Pass</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail2" name="qualityform[]" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfail2">Fail</label>
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
                        <textarea name="qualityform[]" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <input type="hidden" name="qualityformhide[]" value="'.$rowqualitylist->idtbl_quality_subcategory.'">
                ';
            }
        }
        echo $html;
    }
    public function Productionpackqualityinsertupdate(){
        $fieldlist=$this->input->post('qualityform');
        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $qualityformhide=$this->input->post('qualityformhide');
        $qualitycategoryID=2;

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $i=0;
        foreach($qualityformhide as $subcategorylist){
            $descorstatus=$fieldlist[$i];
            $subcategoryID=$subcategorylist;

            $data = array(
                'descstatus'=> $descorstatus, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_production_material_idtbl_production_material'=> $hideproductionmaterial, 
                'tbl_material_info_idtbl_material_info'=> '', 
                'tbl_quality_category_idtbl_quality_category'=> $qualitycategoryID, 
                'tbl_quality_subcategory_idtbl_quality_subcategory'=> $subcategoryID,
                'tbl_user_idtbl_user'=> $userID
            );

            $this->db->insert('tbl_quality_info', $data);

            $i++;
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