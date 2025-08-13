<?php
class Rptstocksummeryinfo extends CI_Model{
    public function Getfinishgoodlist(){
        $searchTerm=$this->input->post('searchTerm');
        $companyID=$_SESSION['companyid'];
        $branchID=$_SESSION['branchid'];

        if(!isset($searchTerm)){
            $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` LEFT JOIN `tbl_product_stock` ON `tbl_product_stock`.`tbl_product_idtbl_product`=`tbl_product`.`idtbl_product` WHERE `tbl_product`.`status`=? AND `tbl_product_stock`.`qty`>? AND `tbl_product_stock`.`tbl_company_idtbl_company`=? AND `tbl_product_stock`.`tbl_company_branch_idtbl_company_branch`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1, 0, $companyID, $branchID));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` LEFT JOIN `tbl_product_stock` ON `tbl_product_stock`.`tbl_product_idtbl_product`=`tbl_product`.`idtbl_product` WHERE `tbl_product`.`status`=? AND `tbl_product_stock`.`qty`>? AND `tbl_product_stock`.`tbl_company_idtbl_company`=? AND `tbl_product_stock`.`tbl_company_branch_idtbl_company_branch`=? AND `tbl_product`.`productcode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1, 0, $companyID, $branchID));    
            }
            else{
                $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` `tbl_product_stock` ON `tbl_product_stock`.`tbl_product_idtbl_product`=`tbl_product`.`idtbl_product` WHERE `tbl_product`.`status`=? AND `tbl_product_stock`.`qty`>? AND `tbl_product_stock`.`tbl_company_idtbl_company`=? AND `tbl_product_stock`.`tbl_company_branch_idtbl_company_branch`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1, 0, $companyID, $branchID));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->materialname.' - '.$row->productcode);
        }
        
        echo json_encode($data);
    }
    public function Getbatchnolist(){
        $recordID=$this->input->post('recordID');

        $this->db->select('DISTINCT(`fgbatchno`) AS `fgbatchno`');
        $this->db->from('tbl_product_stock');
        $this->db->where('tbl_product_idtbl_product', $recordID);
        $this->db->where('status', 1);
        $this->db->where('qty >', 0);

        $respond=$this->db->get(); 
        
        echo json_encode($respond->result());
    }
    public function Getsummeryreport(){
        $fgid=$this->input->post('fgid');
        $batchno=$this->input->post('batchno');

        $mainarray=array();
        $html='';

        $this->db->select('`tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_product`.`desc`, `tbl_product_stock`.`fgbatchno`, `tbl_product_stock`.`qty`');
        $this->db->from('tbl_product');
        $this->db->join('tbl_product_stock', 'tbl_product_stock.tbl_product_idtbl_product = tbl_product.idtbl_product', 'left');
        $this->db->where('tbl_product.idtbl_product', $fgid);
        $this->db->where('tbl_product_stock.fgbatchno', $batchno);
        $this->db->group_by("`tbl_product_stock`.`fgbatchno`");
        $respond = $this->db->get();

        foreach($respond->result() AS $rowfginfo){
            $obj=new stdClass();
            $obj->productcode=$rowfginfo->productcode;
            $obj->desc=$rowfginfo->desc;
            $obj->idtbl_product=$rowfginfo->idtbl_product;
            $obj->qty=$rowfginfo->qty;
            $obj->fgbatchno=$rowfginfo->fgbatchno;
            $obj->saleprice=0;
            $obj->total=0;

            $productID=$rowfginfo->idtbl_product;
            $fgbatchno=$rowfginfo->fgbatchno;

            $this->db->select('`tbl_production_material_issue`.`batchno`, `tbl_production_material_issue`.`qty, `tbl_production_material_issue`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`, `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`,`tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`, `tbl_material_info`.`semistatus`');
            $this->db->from('tbl_production_material_issue');
            $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_material_issue.tbl_production_order_idtbl_production_order', 'left');
            $this->db->join('tbl_production_daily_complete', 'tbl_production_daily_complete.tbl_production_order_idtbl_production_order = tbl_production_order.idtbl_production_order', 'left');
            $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_production_material_issue.tbl_material_info_idtbl_material_info', 'left');
            $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
            // $this->db->join('tbl_invoice', 'tbl_invoice.tbl_customer_porder_idtbl_customer_porder = tbl_production_order.tbl_customer_porder_idtbl_customer_porder', 'left');
            // $this->db->join('tbl_invoice_detail', 'tbl_invoice_detail.tbl_invoice_idtbl_invoice = tbl_invoice.idtbl_invoice', 'left');
            $this->db->where('tbl_production_material_issue.tbl_product_idtbl_product', $productID);
            $this->db->where('tbl_production_daily_complete.batchno', $fgbatchno);
            // $this->db->where('tbl_invoice_detail.tbl_product_idtbl_product', $productID);
            $this->db->where('tbl_production_material_issue.status', 1);
            // $this->db->where('tbl_material_info.tbl_material_category_idtbl_material_category', 1);
            // $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
            $respondissuematerial = $this->db->get();

            $obj->issuematerial=$respondissuematerial->result();

            $grnarraydata=array();

            foreach($respondissuematerial->result() AS $rowissuematerial){
                $objgrndata=new stdClass();
                // if($rowissuematerial->tbl_customer_porder_idtbl_customer_porder==$respond->row(0)->idtbl_customer_porder){
                    $semistatus=$rowissuematerial->semistatus;
                    $materialID=$rowissuematerial->idtbl_material_info;
                    $arraygrninfo=array();
                    
                    if(strpos($rowissuematerial->batchno, ',') !== false ) {
                        $materialbatchno=explode(',', $rowissuematerial->batchno);
                        
                        foreach($materialbatchno as $explodebatch){
                            $this->db->select('`tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_grn`.`batchno`, `tbl_grndetail`.`unitprice`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_supplier`.`suppliername`');
                            $this->db->from('tbl_grn');
                            $this->db->join('tbl_grndetail', 'tbl_grndetail.tbl_grn_idtbl_grn = tbl_grn.idtbl_grn', 'left');
                            $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
                            $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                            $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_grn.tbl_supplier_idtbl_supplier', 'left');
                            $this->db->where('tbl_grn.batchno', $explodebatch);
                            $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $materialID);
                            $this->db->where('tbl_grndetail.status', 1);
                            $respondgrninfo = $this->db->get();
                            // print_r($this->db->last_query());

                            $objgrn=new stdClass();
                            $objgrn->grninfo=$respondgrninfo->result();

                            array_push($arraygrninfo, $objgrn);
                        }
                    }
                    else{
                        $this->db->select('`tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_grn`.`batchno`, `tbl_grndetail`.`unitprice`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_supplier`.`suppliername`');
                        $this->db->from('tbl_grn');
                        $this->db->join('tbl_grndetail', 'tbl_grndetail.tbl_grn_idtbl_grn = tbl_grn.idtbl_grn', 'left');
                        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
                        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                        $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_grn.tbl_supplier_idtbl_supplier', 'left');
                        $this->db->where('tbl_grn.batchno', $rowissuematerial->batchno);
                        $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $materialID);
                        $this->db->where('tbl_grndetail.status', 1);
                        $respondgrninfo = $this->db->get();
                        // print_r($this->db->last_query());

                        $objgrn=new stdClass();
                        $objgrn->grninfo=$respondgrninfo->result();

                        array_push($arraygrninfo, $objgrn);
                    }
                    
                    $objgrndata->grninfo=$arraygrninfo;

                    if($semistatus==1){
                        $semibatcharray=array();

                        if(strpos($rowissuematerial->batchno, ',') !== false ) {
                            $materialbatchnosemi=explode(',', $rowissuematerial->batchno);
                            
                            foreach($materialbatchnosemi as $expsemilodebatch){
                                $this->db->select('`tbl_semi_production_detail`.`batchnolist`, `tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info`');
                                $this->db->from('tbl_semi_production_detail');
                                $this->db->join('tbl_semi_production_daily_complete', 'tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production = tbl_semi_production_detail.tbl_semi_production_idtbl_semi_production', 'left');
                                $this->db->where('tbl_semi_production_daily_complete.batchno', $expsemilodebatch);
                                $this->db->where('tbl_semi_production_daily_complete.status', 1);
                                $respondsemiinfo = $this->db->get();

                                if($respondsemiinfo->num_rows()>0){
                                    $objsemibatch=new stdClass();
                                    $objsemibatch->batchnolist=$respondsemiinfo->row(0)->batchnolist;
                                    $objsemibatch->materialinfoid=$respondsemiinfo->row(0)->tbl_material_info_idtbl_material_info;

                                    array_push($semibatcharray, $objsemibatch);
                                }
                            }
                        }
                        else{
                            $this->db->select('`tbl_semi_production_detail`.`batchnolist`, `tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info`');
                            $this->db->from('tbl_semi_production_detail');
                            $this->db->join('tbl_semi_production_daily_complete', 'tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production = tbl_semi_production_detail.tbl_semi_production_idtbl_semi_production', 'left');
                            $this->db->where('tbl_semi_production_daily_complete.batchno', $rowissuematerial->batchno);
                            $this->db->where('tbl_semi_production_daily_complete.status', 1);
                            $respondsemiinfo = $this->db->get();

                            if($respondsemiinfo->num_rows()>0){
                                $objsemibatch=new stdClass();
                                $objsemibatch->batchnolist=$respondsemiinfo->row(0)->batchnolist;
                                $objsemibatch->materialinfoid=$respondsemiinfo->row(0)->tbl_material_info_idtbl_material_info;

                                array_push($semibatcharray, $objsemibatch);
                            }
                        }

                        $arraysemigrninfo=array();
                    
                        foreach($semibatcharray as $semiarraylist){
                            if(strpos($semiarraylist->batchnolist, ',') !== false ) {
                                $semiissuebatch=explode(',', $semiarraylist->batchnolist);
                                
                                foreach($semiissuebatch as $expsemiissuebatch){
                                    $this->db->select('`tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_grn`.`batchno`, `tbl_grndetail`.`unitprice`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_supplier`.`suppliername`');
                                    $this->db->from('tbl_grn');
                                    $this->db->join('tbl_grndetail', 'tbl_grndetail.tbl_grn_idtbl_grn = tbl_grn.idtbl_grn', 'left');
                                    $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
                                    $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                                    $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_grn.tbl_supplier_idtbl_supplier', 'left');
                                    $this->db->where('tbl_grn.batchno', $expsemiissuebatch);
                                    $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $semiarraylist->materialinfoid);
                                    $this->db->where('tbl_grndetail.status', 1);
                                    $respondsemigrninfo = $this->db->get();

                                    if($respondsemigrninfo->num_rows()>0){
                                        $objsemigrn=new stdClass();
                                        $objsemigrn->semigrninfo=$respondsemigrninfo->result();

                                        array_push($arraysemigrninfo, $objsemigrn);
                                    }
                                }
                            }
                            else{
                                $this->db->select('`tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_grn`.`batchno`, `tbl_grndetail`.`unitprice`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_supplier`.`suppliername`');
                                $this->db->from('tbl_grn');
                                $this->db->join('tbl_grndetail', 'tbl_grndetail.tbl_grn_idtbl_grn = tbl_grn.idtbl_grn', 'left');
                                $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_grndetail.tbl_material_info_idtbl_material_info', 'left');
                                $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                                $this->db->join('tbl_supplier', 'tbl_supplier.idtbl_supplier = tbl_grn.tbl_supplier_idtbl_supplier', 'left');
                                $this->db->where('tbl_grn.batchno', $semiarraylist->batchnolist);
                                $this->db->where('tbl_grndetail.tbl_material_info_idtbl_material_info', $semiarraylist->materialinfoid);
                                $this->db->where('tbl_grndetail.status', 1);
                                $respondsemigrninfo = $this->db->get();

                                if($respondsemigrninfo->num_rows()>0){
                                    $objsemigrn=new stdClass();
                                    $objsemigrn->semigrninfo=$respondsemigrninfo->result();

                                    array_push($arraysemigrninfo, $objsemigrn);
                                }
                            }

                            $objgrndata->semigrninfo=$arraysemigrninfo;
                        }
                    }
                    else{
                        $objgrndata->semigrninfo='';
                    }
                // }
                // else{
                //     $objgrndata->semigrninfo='';
                //     $objgrndata->grninfo='';
                // }

                array_push($grnarraydata, $objgrndata);
            }

            $obj->grninfo=$grnarraydata;

            array_push($mainarray, $obj);
        }

        $html.='
        <table class="table table-striped table-bordered table-sm small w-100">';
            foreach($mainarray as $rowmaininfo){
                $html.='
                <tr>
                    <th colspan="7" class="text-uppercase table-pink">Product Information</th>
                </tr>
                <tr>
                    <th nowrap>&nbsp;</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Prodcut Code:</label> ' . $rowmaininfo->productcode . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Product Name:</label> ' . $rowmaininfo->desc . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $rowmaininfo->fgbatchno . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Available Qty:</label> ' . $rowmaininfo->qty . '</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-uppercase table-orange">Issue Material Information</th>
                </tr>';
                foreach($rowmaininfo->issuematerial as $rowissuemate){
                    $html.='
                    <tr>
                        <th nowrap>&nbsp;</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Name:</label> ' . $rowissuemate->materialname . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $rowissuemate->materialinfocode . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $rowissuemate->batchno . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $rowissuemate->qty . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Start:</label> ' . $rowissuemate->prostartdate . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">End:</label> ' . $rowissuemate->proenddate . '</th>
                    </tr>
                    ';
                }
                // print_r($rowmaininfo->grninfo);
                if(!empty($rowmaininfo->grninfo)){
                    foreach($rowmaininfo->grninfo as $rowgrninfo){
                        if(!empty($rowgrninfo->grninfo)){
                            $i=1;
                            foreach($rowgrninfo->grninfo as $rowmaingrninfo){
                                if($i==1){
                                    $html.='
                                    <tr>
                                        <th colspan="7" class="text-uppercase table-success">GRN Material Information</th>
                                    </tr>';
                                }

                                foreach($rowmaingrninfo->grninfo as $listgrninfo){
                                    // print_r($listgrninfo);
                                    $html.='
                                    <tr>
                                        <th nowrap>&nbsp;</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">GRN Date:</label> ' . $listgrninfo->grndate . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $listgrninfo->materialinfocode . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $listgrninfo->batchno . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $listgrninfo->qty . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Supplier:</label> ' . $listgrninfo->suppliername . '</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    ';
                                }
                                $i++;
                            }
                        }

                        if(!empty($rowgrninfo->semigrninfo)){
                            $i=1;
                            foreach($rowgrninfo->semigrninfo as $rowsemimaingrninfo){
                                if($i==1){
                                    $html.='
                                    <tr>
                                        <th colspan="7" class="text-uppercase table-warning">Supporting GRN Material Information</th>
                                    </tr>';
                                }

                                foreach($rowsemimaingrninfo->semigrninfo as $semilistgrninfo){
                                    // print_r($semilistgrninfo);
                                    $html.='
                                    <tr>
                                        <th nowrap>&nbsp;</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">GRN Date:</label> ' . $semilistgrninfo->grndate . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $semilistgrninfo->materialinfocode . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $semilistgrninfo->batchno . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $semilistgrninfo->qty . '</th>
                                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Supplier:</label> ' . $semilistgrninfo->suppliername . '</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    ';
                                }
                                $i++;
                            }
                        }
                    }
                }
            }
        $html.='  
        </table>
        ';

        echo $html;
        // print_r($mainarray);
    }
}