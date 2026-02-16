<?php
class Salesordercostcountinfo extends CI_Model{
    public function SearchSalesorderList($searchTerm, $customerid){
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];         
            
        $this->db->where('completestatus', 0);
        $this->db->where('confirmstatus', 1);
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $companyid);
        $this->db->where('tbl_company_branch_idtbl_company_branch', $branchid);
        if(!empty($customerid)){
            $this->db->where('tbl_customer_idtbl_customer', $customerid);
        }
        $this->db->select('idtbl_customer_porder, sod_no');
        $this->db->from('tbl_customer_porder');
        if(!empty($searchTerm)){
            $this->db->like('sod_no', $searchTerm, 'both'); 
        }
        if(!isset($searchTerm)){
            $this->db->limit(5);
        }
        $respond=$this->db->get();

        $data=array();
    
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_customer_porder, "text"=>$row->sod_no);
        }   
        echo json_encode($data);
    }
    public function SearchFgList($searchTerm, $salesorderid){
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];         
            
        $this->db->where('tbl_customer_porder_detail.status', 1);
        $this->db->where('tbl_product.status', 1);
        if(!empty($salesorderid)){
            $this->db->where('tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', $salesorderid);
        }
        $this->db->select('tbl_product.idtbl_product, tbl_product.prodcutname');
        $this->db->from('tbl_product');
        $this->db->join('tbl_customer_porder_detail', 'tbl_customer_porder_detail.tbl_product_idtbl_product = tbl_product.idtbl_product', 'left');
        if(!empty($searchTerm)){
            $this->db->like('tbl_product.prodcutname', $searchTerm, 'both'); 
        }
        if(!isset($searchTerm)){
            $this->db->limit(5);
        }
        $respond=$this->db->get();

        $data=array();
    
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->prodcutname);
        }   
        echo json_encode($data);
    }
    public function Getbomlist($searchTerm, $finishgoodid){
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];         
            
        $this->db->where('tbl_product_bom.status', 1);
        $this->db->where('tbl_product_bom_info.status', 1);
        if(!empty($finishgoodid)){
            $this->db->where('tbl_product_bom.tbl_product_idtbl_product', $finishgoodid);
        }
        $this->db->select('idtbl_product_bom_info, title');
        $this->db->from('tbl_product_bom_info');
        $this->db->join('tbl_product_bom', 'tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info = tbl_product_bom_info.idtbl_product_bom_info', 'left');
        if(!empty($searchTerm)){
            $this->db->like('title', $searchTerm, 'both'); 
        }
        $this->db->group_by('tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info');
        if(!isset($searchTerm)){
            $this->db->limit(5);
        }
        $respond=$this->db->get();

        $data=array();
    
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product_bom_info, "text"=>$row->title);
        }   
        echo json_encode($data);
    }
    // public function Getcostcountinfo(){
    //     $companyid=$_SESSION['companyid'];
    //     $branchid=$_SESSION['branchid'];         
    //     $customerid=$this->input->post('customerud');
    //     $salesorderid=$this->input->post('salesorderid');
    //     $finishgoodid=$this->input->post('finishgoodid');
    //     $bomid=$this->input->post('bomid');
    //     $mainarray = array();

    //     $sqlsalesorderqty="SELECT tbl_customer_porder_detail.qty FROM tbl_customer_porder_detail WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=? AND tbl_customer_porder_detail.tbl_product_idtbl_product=?";
    //     $respondsalesorderqty=$this->db->query($sqlsalesorderqty, array($salesorderid, $finishgoodid));
    //     if($respondsalesorderqty->num_rows()>0){
    //         $salesorderqty=$respondsalesorderqty->row(0)->qty;
    //     }
    //     else{
    //         $salesorderqty=0;
    //     }

    //     $sql="SELECT `tbl_product_bom`.`idtbl_product_bom`, `tbl_product_bom`.`tbl_material_info_idtbl_material_info`, `tbl_product_bom`.`qty` , `tbl_product_bom`.`wastage`, `tbl_material_info`.`materialname`, `tbl_material_category`.`categoryname`, `tbl_product`.`productcode`, `tbl_unit`.`unitcode`, `tbl_material_info`.`materialinfocode`
    //     FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_bom`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_bom_info_idtbl_product_bom_info`= ? AND `tbl_product_bom`.`status`=?";
    //     $respond=$this->db->query($sql, array($bomid, 1));

    //     foreach($respond->result() as $row){
    //         $object = new stdClass();
    //         $object->idtbl_product_bom = $row->idtbl_product_bom;
    //         $object->tbl_material_info_idtbl_material_info = $row->tbl_material_info_idtbl_material_info;
    //         $object->qty = $row->qty;
    //         $object->wastage = $row->wastage;
    //         $object->materialname = $row->materialname;
    //         $object->categoryname = $row->categoryname;
    //         $object->productcode = $row->productcode;
    //         $object->unitcode = $row->unitcode;
    //         $object->materialinfocode = $row->materialinfocode;

    //         $sqlmaterialavg="SELECT 
    //             ms.`tbl_material_info_idtbl_material_info`,
    //             sup.`suppliername`,
    //             AVG(gd.`costunitprice`) AS average_costunitprice,
    //             COUNT(*) AS record_count
    //         FROM `tbl_material_suppliers` ms
    //         LEFT JOIN `tbl_grn` grn ON ms.`tbl_supplier_idtbl_supplier` = grn.`tbl_supplier_idtbl_supplier`
    //         LEFT JOIN `tbl_grndetail` gd ON grn.`idtbl_grn` = gd.`tbl_grn_idtbl_grn` AND ms.`tbl_material_info_idtbl_material_info` = gd.`tbl_material_info_idtbl_material_info`
    //         LEFT JOIN `tbl_supplier` sup ON ms.`tbl_supplier_idtbl_supplier` = sup.`idtbl_supplier`
    //         WHERE gd.`costunitprice` IS NOT NULL
    //         AND ms.`tbl_material_info_idtbl_material_info`=?
    //         GROUP BY ms.`tbl_supplier_idtbl_supplier`
    //         ORDER BY ms.`tbl_material_info_idtbl_material_info`";
    //         $respondmaterialavg=$this->db->query($sqlmaterialavg, array($row->tbl_material_info_idtbl_material_info));

    //         $i=0;
    //         foreach($respondmaterialavg->result() as $rowmaterialavg){
    //             $salesorderqty = $salesorderqty + ($salesorderqty*($row->wastage/100));

    //             if($i==0){
    //                 $object->suppliername = $rowmaterialavg->suppliername;
    //                 $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //                 $object->totalcost = $rowmaterialavg->average_costunitprice*$salesorderqty;
    //             }
    //             else{
    //                 $object = new stdClass();
    //                 $object->idtbl_product_bom = '';
    //                 $object->tbl_material_info_idtbl_material_info = '';
    //                 $object->qty = '';
    //                 $object->wastage = '';
    //                 $object->materialname = '';
    //                 $object->categoryname = '';
    //                 $object->productcode = '';
    //                 $object->unitcode = '';
    //                 $object->materialinfocode = '';
    //                 $object->suppliername = $rowmaterialavg->suppliername;
    //                 $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //                 $object->totalcost = $rowmaterialavg->average_costunitprice*$salesorderqty;
    //             }

    //             array_push($mainarray, $object);
    //             $i++;
    //         }
    //     }

    //     // print_r($mainarray);
        
    //     $html='';
    //     $html.='<table class="table table-bordered table-striped table-sm small" id="table_content">
    //         <thead>
    //             <tr>
    //                 <th>Material Info Code</th>
    //                 <th>Material Name</th>
    //                 <th>Category</th>
    //                 <th>Product Code</th>
    //                 <th>Quantity per FG</th>
    //                 <th>Wastage (%)</th>
    //                 <th>Unit</th>
    //                 <th>Supplier Name</th>
    //                 <th class="text-right">Avg. Cost Unit Price</th>
    //                 <th class="text-right">Total Cost for SO Qty ('.$salesorderqty.')</th>
    //             </tr>
    //         </thead>
    //         <tbody>';  
    //     $totalcostall=0;
    //     foreach($mainarray as $data){
    //         $html.='<tr>
    //             <td>'.$data->materialinfocode.'</td>
    //             <td>'.$data->materialname.'</td>
    //             <td>'.$data->categoryname.'</td>
    //             <td>'.$data->productcode.'</td>
    //             <td>'.$data->qty.'</td>
    //             <td>'.$data->wastage.'</td>
    //             <td>'.$data->unitcode.'</td>
    //             <td>'.$data->suppliername.'</td>
    //             <td class="text-right">'.number_format((float)$data->average_costunitprice, 2, '.', ',').'</td>
    //             <td class="text-right">'.number_format((float)$data->totalcost, 2, '.', ',').'</td>
    //         </tr>';
    //         $totalcostall +=$data->totalcost;
    //     }  
    //     $html.='</tbody>
    //         <tfoot>
    //             <tr>
    //                 <th colspan="9" class="text-right">Total Cost</th>
    //                 <th class="text-right">'.number_format((float)$totalcostall, 2, '.', ',').'</th>
    //             </tr>
    //         </tfoot>
    //     </table>
    //     ';
    //     echo $html;
    // }
    // public function Getcostcountinfo(){
    //     $companyid=$_SESSION['companyid'];
    //     $branchid=$_SESSION['branchid'];         
    //     $customerid=$this->input->post('customerud');
    //     $salesorderid=$this->input->post('salesorderid');
    //     $finishgoodid=$this->input->post('finishgoodid');
    //     $bomid=$this->input->post('bomid');
    //     $mainarray = array();

    //     $sqlsalesorderqty="SELECT tbl_customer_porder_detail.qty FROM tbl_customer_porder_detail WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=? AND tbl_customer_porder_detail.tbl_product_idtbl_product=?";
    //     $respondsalesorderqty=$this->db->query($sqlsalesorderqty, array($salesorderid, $finishgoodid));
    //     if($respondsalesorderqty->num_rows()>0){
    //         $salesorderqty=$respondsalesorderqty->row(0)->qty;
    //     }
    //     else{
    //         $salesorderqty=0;
    //     }

    //     $sql="SELECT `tbl_product_bom`.`idtbl_product_bom`, `tbl_product_bom`.`tbl_material_info_idtbl_material_info`, `tbl_product_bom`.`qty` , `tbl_product_bom`.`wastage`, `tbl_material_info`.`materialname`, `tbl_material_category`.`categoryname`, `tbl_product`.`productcode`, `tbl_unit`.`unitcode`, `tbl_material_info`.`materialinfocode`
    //     FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_bom`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_bom_info_idtbl_product_bom_info`= ? AND `tbl_product_bom`.`status`=?";
    //     $respond=$this->db->query($sql, array($bomid, 1));

    //     // Array to store supplier totals
    //     $supplierTotals = array();
    //     $totalcostall=0;

    //     foreach($respond->result() as $row){
    //         $object = new stdClass();
    //         $object->idtbl_product_bom = $row->idtbl_product_bom;
    //         $object->tbl_material_info_idtbl_material_info = $row->tbl_material_info_idtbl_material_info;
    //         $object->qty = $row->qty;
    //         $object->wastage = $row->wastage;
    //         $object->materialname = $row->materialname;
    //         $object->categoryname = $row->categoryname;
    //         $object->productcode = $row->productcode;
    //         $object->unitcode = $row->unitcode;
    //         $object->materialinfocode = $row->materialinfocode;

    //         $sqlmaterialavg="SELECT 
    //             ms.`tbl_material_info_idtbl_material_info`,
    //             sup.`suppliername`,
    //             sup.`idtbl_supplier`,
    //             AVG(gd.`costunitprice`) AS average_costunitprice,
    //             COUNT(*) AS record_count
    //         FROM `tbl_material_suppliers` ms
    //         LEFT JOIN `tbl_grn` grn ON ms.`tbl_supplier_idtbl_supplier` = grn.`tbl_supplier_idtbl_supplier`
    //         LEFT JOIN `tbl_grndetail` gd ON grn.`idtbl_grn` = gd.`tbl_grn_idtbl_grn` AND ms.`tbl_material_info_idtbl_material_info` = gd.`tbl_material_info_idtbl_material_info`
    //         LEFT JOIN `tbl_supplier` sup ON ms.`tbl_supplier_idtbl_supplier` = sup.`idtbl_supplier`
    //         WHERE gd.`costunitprice` IS NOT NULL
    //         AND ms.`tbl_material_info_idtbl_material_info`=?
    //         GROUP BY ms.`tbl_supplier_idtbl_supplier`
    //         ORDER BY ms.`tbl_material_info_idtbl_material_info`";
    //         $respondmaterialavg=$this->db->query($sqlmaterialavg, array($row->tbl_material_info_idtbl_material_info));

    //         $i=0;
    //         foreach($respondmaterialavg->result() as $rowmaterialavg){
    //             $adjustedSalesQty = $salesorderqty + ($salesorderqty*($row->wastage/100));
    //             $totalcost = $rowmaterialavg->average_costunitprice * $adjustedSalesQty;
                
    //             // Initialize supplier in totals array if not exists
    //             $supplierId = $rowmaterialavg->idtbl_supplier;
    //             $supplierName = $rowmaterialavg->suppliername;
                
    //             if(!isset($supplierTotals[$supplierId])) {
    //                 $supplierTotals[$supplierId] = array(
    //                     'suppliername' => $supplierName,
    //                     'total' => 0
    //                 );
    //             }
                
    //             // Add to supplier total
    //             $supplierTotals[$supplierId]['total'] += $totalcost;

    //             if($i==0){
    //                 $object->suppliername = $supplierName;
    //                 $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //                 $object->totalcost = $totalcost;
    //             }
    //             else{
    //                 $object = new stdClass();
    //                 $object->idtbl_product_bom = '';
    //                 $object->tbl_material_info_idtbl_material_info = '';
    //                 $object->qty = '';
    //                 $object->wastage = '';
    //                 $object->materialname = '';
    //                 $object->categoryname = '';
    //                 $object->productcode = '';
    //                 $object->unitcode = '';
    //                 $object->materialinfocode = '';
    //                 $object->suppliername = $supplierName;
    //                 $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //                 $object->totalcost = $totalcost;
    //             }

    //             array_push($mainarray, $object);
    //             $totalcostall += $totalcost;
    //             $i++;
    //         }
    //     }

    //     $html='';
    //     $html.='<table class="table table-bordered table-striped table-sm small" id="table_content">
    //         <thead>
    //             <tr>
    //                 <th>Material Info Code</th>
    //                 <th>Material Name</th>
    //                 <th>Category</th>
    //                 <th>Product Code</th>
    //                 <th>Quantity per FG</th>
    //                 <th>Wastage (%)</th>
    //                 <th>Unit</th>
    //                 <th>Supplier Name</th>
    //                 <th class="text-right">Avg. Cost Unit Price</th>
    //                 <th class="text-right">Total Cost for SO Qty ('.$adjustedSalesQty.')</th>
    //             </tr>
    //         </thead>
    //         <tbody>';  

    //     foreach($mainarray as $data){
    //         $html.='<tr>
    //             <td>'.$data->materialinfocode.'</td>
    //             <td>'.$data->materialname.'</td>
    //             <td>'.$data->categoryname.'</td>
    //             <td>'.$data->productcode.'</td>
    //             <td>'.$data->qty.'</td>
    //             <td>'.$data->wastage.'</td>
    //             <td>'.$data->unitcode.'</td>
    //             <td>'.$data->suppliername.'</td>
    //             <td class="text-right">'.number_format((float)$data->average_costunitprice, 2, '.', ',').'</td>
    //             <td class="text-right">'.number_format((float)$data->totalcost, 2, '.', ',').'</td>
    //         </tr>';
    //     }  
        
    //     // Add supplier-wise totals in footer
    //     $html.='</tbody>
    //         <tfoot>';
        
    //     // Add supplier-wise totals
    //     foreach($supplierTotals as $supplierId => $supplierData) {
    //         $html.='<tr>
    //             <th colspan="9" class="text-right">'.$supplierData['suppliername'].' Total</th>
    //             <th class="text-right">'.number_format((float)$supplierData['total'], 2, '.', ',').'</th>
    //         </tr>';
    //     }
        
    //     // Add grand total
    //     $html.='<tr>
    //             <th colspan="9" class="text-right">Grand Total</th>
    //             <th class="text-right">'.number_format((float)$totalcostall, 2, '.', ',').'</th>
    //         </tr>
    //     </tfoot>
    //     </table>
    //     ';
    //     echo $html;
    // }

    // public function Getcostcountinfo() {
    //     $companyid = $_SESSION['companyid'];
    //     $branchid = $_SESSION['branchid'];
    //     $customerid = $this->input->post('customerud');
    //     $salesorderid = $this->input->post('salesorderid');

    //     $mainarray = array();
    //     $supplierTotals = array();
    //     $totalcostall = 0;

    //     // 1. Get all products and their quantities for the given Sales Order
    //     $sqlSalesOrder = "SELECT tbl_product_idtbl_product, qty 
    //                     FROM tbl_customer_porder_detail 
    //                     WHERE tbl_customer_porder_idtbl_customer_porder = ?";
    //     $resSalesOrder = $this->db->query($sqlSalesOrder, array($salesorderid));

    //     foreach ($resSalesOrder->result() as $soRow) {
    //         $finishgoodid = $soRow->tbl_product_idtbl_product;
    //         $salesorderqty = $soRow->qty;

    //         // 2. Find the active BOM Info ID for this specific product
    //         // Note: Assuming status 1 is active
    //         $sqlBomInfo = "SELECT tbl_product_bom_info_idtbl_product_bom_info FROM tbl_product_bom 
    //                     WHERE tbl_product_idtbl_product = ? AND status = ? GROUP BY tbl_product_bom_info_idtbl_product_bom_info";
    //         $resBomInfo = $this->db->query($sqlBomInfo, array($finishgoodid, 1));

    //         if ($resBomInfo->num_rows() > 0) {
    //             $bomid = $resBomInfo->row(0)->tbl_product_bom_info_idtbl_product_bom_info;

    //             // 3. Get material breakdown from the BOM
    //             $sqlBom = "SELECT b.idtbl_product_bom, b.tbl_material_info_idtbl_material_info, b.qty, b.wastage, 
    //                             m.materialname, mc.categoryname, p.productcode, u.unitcode, m.materialinfocode
    //                     FROM tbl_product_bom b
    //                     LEFT JOIN tbl_material_info m ON m.idtbl_material_info = b.tbl_material_info_idtbl_material_info
    //                     LEFT JOIN tbl_product p ON p.idtbl_product = b.tbl_product_idtbl_product
    //                     LEFT JOIN tbl_material_category mc ON mc.idtbl_material_category = m.tbl_material_category_idtbl_material_category
    //                     LEFT JOIN tbl_unit u ON u.idtbl_unit = m.tbl_unit_idtbl_unit
    //                     WHERE b.tbl_product_bom_info_idtbl_product_bom_info = ? AND b.status = ?";
                
    //             $resBom = $this->db->query($sqlBom, array($bomid, 1));

    //             foreach ($resBom->result() as $row) {
    //                 // Calculate average cost per supplier for this material
    //                 $sqlMatAvg = "SELECT ms.tbl_material_info_idtbl_material_info, sup.suppliername, sup.idtbl_supplier,
    //                                     AVG(gd.costunitprice) AS average_costunitprice
    //                             FROM tbl_material_suppliers ms
    //                             LEFT JOIN tbl_grn grn ON ms.tbl_supplier_idtbl_supplier = grn.tbl_supplier_idtbl_supplier
    //                             LEFT JOIN tbl_grndetail gd ON grn.idtbl_grn = gd.tbl_grn_idtbl_grn 
    //                                         AND ms.tbl_material_info_idtbl_material_info = gd.tbl_material_info_idtbl_material_info
    //                             LEFT JOIN tbl_supplier sup ON ms.tbl_supplier_idtbl_supplier = sup.idtbl_supplier
    //                             WHERE gd.costunitprice IS NOT NULL AND ms.tbl_material_info_idtbl_material_info = ?
    //                             GROUP BY ms.tbl_supplier_idtbl_supplier";
                    
    //                 $resMatAvg = $this->db->query($sqlMatAvg, array($row->tbl_material_info_idtbl_material_info));

    //                 $i = 0;
    //                 foreach ($resMatAvg->result() as $rowMatAvg) {
    //                     // Logic: (SO Qty * Qty Per FG) + Wastage
    //                     $totalRequiredQty = $salesorderqty * $row->qty;
    //                     $adjustedQty = $totalRequiredQty + ($totalRequiredQty * ($row->wastage / 100));
    //                     $totalcost = $rowMatAvg->average_costunitprice * $adjustedQty;

    //                     // Update Supplier Totals
    //                     $supId = $rowMatAvg->idtbl_supplier;
    //                     if (!isset($supplierTotals[$supId])) {
    //                         $supplierTotals[$supId] = ['suppliername' => $rowMatAvg->suppliername, 'total' => 0];
    //                     }
    //                     $supplierTotals[$supId]['total'] += $totalcost;

    //                     // Prepare Object for Table
    //                     $object = new stdClass();
    //                     $object->materialinfocode = ($i == 0) ? $row->materialinfocode : '';
    //                     $object->materialname = ($i == 0) ? $row->materialname : '';
    //                     $object->categoryname = ($i == 0) ? $row->categoryname : '';
    //                     $object->productcode = ($i == 0) ? $row->productcode : '';
    //                     $object->qty = ($i == 0) ? $row->qty : '';
    //                     $object->wastage = ($i == 0) ? $row->wastage : '';
    //                     $object->unitcode = ($i == 0) ? $row->unitcode : '';
    //                     $object->suppliername = $rowMatAvg->suppliername;
    //                     $object->average_costunitprice = $rowMatAvg->average_costunitprice;
    //                     $object->totalcost = $totalcost;
    //                     $object->calc_qty = $adjustedQty; // Keep track of qty for the header label

    //                     array_push($mainarray, $object);
    //                     $totalcostall += $totalcost;
    //                     $i++;
    //                 }
    //             }
    //         }
    //     }

    //     // --- HTML Generation ---
    //     $html = '<table class="table table-bordered table-striped table-sm small" id="table_content">
    //                 <thead>
    //                     <tr>
    //                         <th>Material Info Code</th>
    //                         <th>Material Name</th>
    //                         <th>Category</th>
    //                         <th>Finished Good</th>
    //                         <th>Qty/FG</th>
    //                         <th>Wastage (%)</th>
    //                         <th>Unit</th>
    //                         <th>Supplier Name</th>
    //                         <th class="text-right">Avg. Cost Unit Price</th>
    //                         <th class="text-right">Total Cost</th>
    //                     </tr>
    //                 </thead>
    //                 <tbody>';

    //     foreach ($mainarray as $data) {
    //         $html .= '<tr>
    //                     <td>' . $data->materialinfocode . '</td>
    //                     <td>' . $data->materialname . '</td>
    //                     <td>' . $data->categoryname . '</td>
    //                     <td>' . $data->productcode . '</td>
    //                     <td>' . $data->qty . '</td>
    //                     <td>' . $data->wastage . '</td>
    //                     <td>' . $data->unitcode . '</td>
    //                     <td>' . $data->suppliername . '</td>
    //                     <td class="text-right">' . number_format((float)$data->average_costunitprice, 2) . '</td>
    //                     <td class="text-right">' . number_format((float)$data->totalcost, 2) . '</td>
    //                 </tr>';
    //     }

    //     $html .= '</tbody><tfoot>';

    //     foreach ($supplierTotals as $sup) {
    //         $html .= '<tr>
    //                     <th colspan="9" class="text-right">' . $sup['suppliername'] . ' Total</th>
    //                     <th class="text-right">' . number_format((float)$sup['total'], 2) . '</th>
    //                 </tr>';
    //     }

    //     $html .= '<tr class="">
    //                 <th colspan="9" class="text-right">Grand Total</th>
    //                 <th class="text-right">' . number_format((float)$totalcostall, 2) . '</th>
    //             </tr>
    //             </tfoot></table>';

    //     echo $html;
    // }
    public function Getcostcountinfo() {
        $companyid = $_SESSION['companyid'];
        $branchid = $_SESSION['branchid'];
        $customerid = $this->input->post('customerud');
        $salesorderid = $this->input->post('salesorderid');

        $supplierTotals = array();
        $totalcostall = 0;
        $groupedData = array(); // New array to group by Product

        // 1. Get all products in the Sales Order
        $sqlSalesOrder = "SELECT t1.tbl_product_idtbl_product, t1.qty, t2.prodcutname, t2.productcode 
                        FROM tbl_customer_porder_detail t1
                        LEFT JOIN tbl_product t2 ON t1.tbl_product_idtbl_product = t2.idtbl_product
                        WHERE t1.tbl_customer_porder_idtbl_customer_porder = ?";
        $resSalesOrder = $this->db->query($sqlSalesOrder, array($salesorderid));

        foreach ($resSalesOrder->result() as $soRow) {
            $finishgoodid = $soRow->tbl_product_idtbl_product;
            $salesorderqty = $soRow->qty;
            $productDisplayName = $soRow->productcode . " (" . $soRow->productcode . ")";
            
            // Initialize the group for this specific FG
            $groupedData[$finishgoodid] = [
                'productname' => $productDisplayName,
                'so_qty' => $salesorderqty,
                'fg_total_cost' => 0,
                'materials' => []
            ];

            // 2. Find Active BOM
            $sqlBomInfo = "SELECT tbl_product_bom_info_idtbl_product_bom_info FROM tbl_product_bom 
                WHERE tbl_product_idtbl_product = ? AND status = ? GROUP BY tbl_product_bom_info_idtbl_product_bom_info";
            $resBomInfo = $this->db->query($sqlBomInfo, array($finishgoodid, 1));

            if ($resBomInfo->num_rows() > 0) {
                $bomid = $resBomInfo->row(0)->tbl_product_bom_info_idtbl_product_bom_info;

                // 3. Get BOM Details
                $sqlBom = "SELECT b.idtbl_product_bom, b.tbl_material_info_idtbl_material_info, b.qty, b.wastage, 
                                m.materialname, mc.categoryname, u.unitcode, m.materialinfocode
                        FROM tbl_product_bom b
                        LEFT JOIN tbl_material_info m ON m.idtbl_material_info = b.tbl_material_info_idtbl_material_info
                        LEFT JOIN tbl_material_category mc ON mc.idtbl_material_category = m.tbl_material_category_idtbl_material_category
                        LEFT JOIN tbl_unit u ON u.idtbl_unit = m.tbl_unit_idtbl_unit
                        WHERE b.tbl_product_bom_info_idtbl_product_bom_info = ? AND b.status = ?";
                
                $resBom = $this->db->query($sqlBom, array($bomid, 1));

                foreach ($resBom->result() as $row) {
                    // Get Supplier Averages
                    $sqlMatAvg = "SELECT ms.tbl_material_info_idtbl_material_info, sup.suppliername, sup.idtbl_supplier,
                                        AVG(gd.costunitprice) AS average_costunitprice
                                FROM tbl_material_suppliers ms
                                LEFT JOIN tbl_grn grn ON ms.tbl_supplier_idtbl_supplier = grn.tbl_supplier_idtbl_supplier
                                LEFT JOIN tbl_grndetail gd ON grn.idtbl_grn = gd.tbl_grn_idtbl_grn 
                                            AND ms.tbl_material_info_idtbl_material_info = gd.tbl_material_info_idtbl_material_info
                                LEFT JOIN tbl_supplier sup ON ms.tbl_supplier_idtbl_supplier = sup.idtbl_supplier
                                WHERE gd.costunitprice IS NOT NULL AND ms.tbl_material_info_idtbl_material_info = ?
                                GROUP BY ms.tbl_supplier_idtbl_supplier";
                    
                    $resMatAvg = $this->db->query($sqlMatAvg, array($row->tbl_material_info_idtbl_material_info));

                    foreach ($resMatAvg->result() as $rowMatAvg) {
                        $totalRequiredQty = $salesorderqty * $row->qty;
                        $adjustedQty = $totalRequiredQty + ($totalRequiredQty * ($row->wastage / 100));
                        $itemTotalCost = $rowMatAvg->average_costunitprice * $adjustedQty;

                        // Add to FG Total and Grand Total
                        $groupedData[$finishgoodid]['fg_total_cost'] += $itemTotalCost;
                        $totalcostall += $itemTotalCost;

                        // Supplier Totals logic
                        $supId = $rowMatAvg->idtbl_supplier;
                        if (!isset($supplierTotals[$supId])) {
                            $supplierTotals[$supId] = ['suppliername' => $rowMatAvg->suppliername, 'total' => 0];
                        }
                        $supplierTotals[$supId]['total'] += $itemTotalCost;

                        // Store Material Detail
                        $groupedData[$finishgoodid]['materials'][] = [
                            'code' => $row->materialinfocode,
                            'name' => $row->materialname,
                            'cat' => $row->categoryname,
                            'qty_fg' => $row->qty,
                            'wastage' => $row->wastage,
                            'unit' => $row->unitcode,
                            'supplier' => $rowMatAvg->suppliername,
                            'avg_price' => $rowMatAvg->average_costunitprice,
                            'total' => $itemTotalCost
                        ];
                    }
                }
            }
        }

        // --- HTML Generation with Accordion ---
        $html = '<table class="table table-striped table-bordered table-sm small" id="table_content">
                    <thead class="">
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Product / Material Info</th>
                            <th>Category</th>
                            <th>Qty/FG</th>
                            <th>Wastage (%)</th>
                            <th>Unit</th>
                            <th>Supplier</th>
                            <th class="text-right">Avg. Price</th>
                            <th class="text-right">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($groupedData as $fgId => $group) {
            // Parent Row (The Finished Good)
            $html .= '<tr class="font-weight-bold">
                        <td class="text-center">
                            <button class="btn btn-sm btn-light p-0" type="button" data-toggle="collapse" data-target=".fg-details-'.$fgId.'">
                            <i class="fas fa-chevron-down"></i>
                            </button>
                        </td>
                        <td colspan="7">'.$group['productname'].' (SO Qty: '.$group['so_qty'].')</td>
                        <td class="text-right">'.number_format($group['fg_total_cost'], 2).'</td>
                    </tr>';

            // Child Rows (The Materials) - hidden by default
            foreach ($group['materials'] as $mat) {
                $html .= '<tr class="collapse fg-details-'.$fgId.'">
                            <td></td>
                            <td>'.$mat['code'].' - '.$mat['name'].'</td>
                            <td>'.$mat['cat'].'</td>
                            <td>'.$mat['qty_fg'].'</td>
                            <td>'.$mat['wastage'].'</td>
                            <td>'.$mat['unit'].'</td>
                            <td>'.$mat['supplier'].'</td>
                            <td class="text-right">'.number_format($mat['avg_price'], 2).'</td>
                            <td class="text-right">'.number_format($mat['total'], 2).'</td>
                        </tr>';
            }
        }

        $html .= '</tbody><tfoot class="">';
        
        // Supplier totals (unchanged)
        foreach ($supplierTotals as $sup) {
            $html .= '<tr>
                        <th colspan="8" class="text-right">'.$sup['suppliername'].' Total</th>
                        <th class="text-right">'.number_format($sup['total'], 2).'</th>
                    </tr>';
        }

        $html .= '<tr class="">
                    <th colspan="8" class="text-right">GRAND TOTAL</th>
                    <th class="text-right">'.number_format($totalcostall, 2).'</th>
                </tr>
                </tfoot></table>';

        echo $html;
    }
}