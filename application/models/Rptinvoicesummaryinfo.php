<?php
class Rptinvoicesummaryinfo extends CI_Model{
    public function Getinvoicelist(){
        $companyID=$_SESSION['companyid'];
        $branchID=$_SESSION['branchid'];

        $this->db->select('`idtbl_invoice`');
        $this->db->from('tbl_invoice');
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $companyID);
        $this->db->where('tbl_company_branch_idtbl_company_branch', $branchID);

        return $respond=$this->db->get();
    }

    public function Getinvoicedetail(){
        $recordID = $this->input->post('recordID');
        $html='';

        if(!empty($recordID)){
            $mainarray=array();

            $this->db->select('`tbl_invoice`.`idtbl_invoice`, `tbl_invoice`.`invdate`, `tbl_invoice`.`nettotal`, `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`, `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer`.`name`');
            $this->db->from('tbl_invoice');
            $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_invoice.tbl_customer_porder_idtbl_customer_porder', 'left');
            $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customer_porder.tbl_customer_idtbl_customer', 'left');
            $this->db->where('tbl_invoice.idtbl_invoice', $recordID);
            $this->db->where('tbl_invoice.status', 1);
            $respond = $this->db->get();

            // print_r($this->db->last_query());    
            $this->db->select('`tbl_invoice_detail`.`qty`, `tbl_invoice_detail`.`saleprice`, `tbl_invoice_detail`.`total`, `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_product`.`desc`');
            $this->db->from('tbl_invoice_detail');
            $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_invoice_detail.tbl_product_idtbl_product', 'left');
            $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
            $this->db->where('tbl_invoice_detail.status', 1);
            $respondinvdetail = $this->db->get();
            
            foreach($respondinvdetail->result() AS $rowinvetail){
                $obj=new stdClass();
                $obj->productcode=$rowinvetail->productcode;
                $obj->desc=$rowinvetail->desc;
                $obj->idtbl_product=$rowinvetail->idtbl_product;
                $obj->qty=$rowinvetail->qty;
                $obj->saleprice=$rowinvetail->saleprice;
                $obj->total=$rowinvetail->total;

                $productID=$rowinvetail->idtbl_product;

                $this->db->select('`tbl_production_material_issue`.`batchno`, `tbl_production_material_issue`.`qty, `tbl_production_material_issue`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`, `tbl_production_order`.`tbl_customer_porder_idtbl_customer_porder`,`tbl_production_order`.`prostartdate`, `tbl_production_order`.`proenddate`, `tbl_material_info`.`semistatus`');
                $this->db->from('tbl_production_material_issue');
                $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_material_issue.tbl_production_order_idtbl_production_order', 'left');
                $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_production_material_issue.tbl_material_info_idtbl_material_info', 'left');
                $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
                $this->db->join('tbl_invoice', 'tbl_invoice.tbl_customer_porder_idtbl_customer_porder = tbl_production_order.tbl_customer_porder_idtbl_customer_porder', 'left');
                $this->db->join('tbl_invoice_detail', 'tbl_invoice_detail.tbl_invoice_idtbl_invoice = tbl_invoice.idtbl_invoice', 'left');
                $this->db->where('tbl_production_material_issue.tbl_product_idtbl_product', $productID);
                $this->db->where('tbl_invoice_detail.tbl_product_idtbl_product', $productID);
                $this->db->where('tbl_production_material_issue.status', 1);
                // $this->db->where('tbl_material_info.tbl_material_category_idtbl_material_category', 1);
                $this->db->where('tbl_invoice_detail.tbl_invoice_idtbl_invoice', $recordID);
                $respondissuematerial = $this->db->get();

                $obj->issuematerial=$respondissuematerial->result();

                $grnarraydata=array();
                foreach($respondissuematerial->result() AS $rowissuematerial){
                    $objgrndata=new stdClass();
                    if($rowissuematerial->tbl_customer_porder_idtbl_customer_porder==$respond->row(0)->idtbl_customer_porder){
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

                                    $objsemibatch=new stdClass();
                                    $objsemibatch->batchnolist=$respondsemiinfo->row(0)->batchnolist;
                                    $objsemibatch->materialinfoid=$respondsemiinfo->row(0)->tbl_material_info_idtbl_material_info;

                                    array_push($semibatcharray, $objsemibatch);
                                }
                            }
                            else{
                                $this->db->select('`tbl_semi_production_detail`.`batchnolist`, `tbl_semi_production_detail`.`tbl_material_info_idtbl_material_info`');
                                $this->db->from('tbl_semi_production_detail');
                                $this->db->join('tbl_semi_production_daily_complete', 'tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production = tbl_semi_production_detail.tbl_semi_production_idtbl_semi_production', 'left');
                                $this->db->where('tbl_semi_production_daily_complete.batchno', $rowissuematerial->batchno);
                                $this->db->where('tbl_semi_production_daily_complete.status', 1);
                                $respondsemiinfo = $this->db->get();

                                $objsemibatch=new stdClass();
                                $objsemibatch->batchnolist=$respondsemiinfo->row(0)->batchnolist;
                                $objsemibatch->materialinfoid=$respondsemiinfo->row(0)->tbl_material_info_idtbl_material_info;

                                array_push($semibatcharray, $objsemibatch);
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

                                        $objsemigrn=new stdClass();
                                        $objsemigrn->semigrninfo=$respondsemigrninfo->result();

                                        array_push($arraysemigrninfo, $objsemigrn);
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

                                    $objsemigrn=new stdClass();
                                    $objsemigrn->semigrninfo=$respondsemigrninfo->result();

                                    array_push($arraysemigrninfo, $objsemigrn);
                                }

                                $objgrndata->semigrninfo=$arraysemigrninfo;
                            }
                        }
                        else{
                            $objgrndata->semigrninfo='';
                        }
                    }
                    else{
                        $objgrndata->semigrninfo='';
                        $objgrndata->grninfo='';
                    }

                    array_push($grnarraydata, $objgrndata);
                }

                $obj->grninfo=$grnarraydata;

                array_push($mainarray, $obj);
            }

            // print_r($mainarray);
            // print_r($mainarray->grninfo);
            $html.='
            <table class="table table-striped table-bordered table-sm small w-100">
                <tr>
                    <th colspan="7" class="text-uppercase table-primary">Invoice Information</th>
                </tr>
                <tr>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Invoice No:</label> INV/DT-0000' . $respond->row(0)->idtbl_invoice . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Invoice Date:</label> ' . $respond->row(0)->invdate . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Customer:</label> ' . $respond->row(0)->name . '</th>
                    <th nowrap><label class="text-dark font-weight-bold text-uppercase">Sales OR/ NO:</label> UN/SOD-0000' . $respond->row(0)->idtbl_customer_porder . '</th>
                    <th nowrap class="text-right"><label class="text-dark font-weight-bold text-uppercase">Net Total:</label> ' . number_format($respond->row(0)->nettotal, 2) . '</th>
                </tr>';
                foreach($mainarray as $rowmaininfo){
                    $html.='
                    <tr>
                        <th colspan="7" class="text-uppercase table-pink">Invoice Product Information</th>
                    </tr>
                    <tr>
                        <th nowrap>&nbsp;</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Prodcut Code:</label> ' . $rowmaininfo->productcode . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Product Name:</label> ' . $rowmaininfo->desc . '</th>
                        <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $rowmaininfo->qty . '</th>
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
                    //         // print_r($rowgrninfo->grninfo);
                    //         foreach($rowgrninfo->grninfo as $rowsubgrninfo){
                    //             print_r($rowsubgrninfo);
                                // $html.='
                                // <tr>
                                //     <th nowrap>&nbsp;</th>
                                //     <th nowrap><label class="text-dark font-weight-bold text-uppercase">GRN Date:</label> ' . $rowsubgrninfo->grndate . '</th>
                                //     <th nowrap><label class="text-dark font-weight-bold text-uppercase">Material Code:</label> ' . $rowsubgrninfo->materialinfocode . '</th>
                                //     <th nowrap><label class="text-dark font-weight-bold text-uppercase">Batch No:</label> ' . $rowsubgrninfo->batchno . '</th>
                                //     <th nowrap><label class="text-dark font-weight-bold text-uppercase">Qty:</label> ' . $rowsubgrninfo->qty . '</th>
                                //     <th nowrap><label class="text-dark font-weight-bold text-uppercase">Supplier:</label> ' . $rowsubgrninfo->suppliername . '</th>
                                // </tr>
                                // ';
                    //         }
                        }
                    }
                }
            $html.='  
            </table>
            ';
        }    
        echo $html;
    
    }
}