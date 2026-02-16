<?php
class Invoicecostsheetinfo extends CI_Model{
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
    // public function Getcostcountinfo(){
    //     $companyid=$_SESSION['companyid'];
    //     $branchid=$_SESSION['branchid'];         
    //     $customerid=$this->input->post('customerud');
    //     $salesorderid=$this->input->post('salesorderid');
    //     $mainarray = array();

    //     $saleorder = "SELECT 
    //         p.productcode AS ITEM_CODE,
    //         p.prodcutname AS Item,
    //         p.weight AS Unit,
    //         p.nopckperctn AS Pks_Per_Carton,
    //         (d.qty / p.nopckperctn) AS No_of_MC,
    //         d.qty AS Qty,
    //         d.unitprice AS Unit_Price_FOB,
    //         (d.unitprice * p.nopckperctn) AS Price_Per_MCT,
    //         (d.qty * d.unitprice) AS Total_Value_FOB,
    //         d.tbl_product_idtbl_product AS ItemID
    //     FROM tbl_customer_porder_detail d
    //     JOIN tbl_product p ON d.tbl_product_idtbl_product = p.idtbl_product
    //     WHERE d.tbl_customer_porder_idtbl_customer_porder = ?";
    //     $respondsalesorder=$this->db->query($saleorder, array($salesorderid));

    //     foreach($respondsalesorder->result() as $rowsalesorder){
    //         $ItemID = $rowsalesorder->ItemID;

    //         $object = new stdClass();
    //         $object->ITEM_CODE = $rowsalesorder->ITEM_CODE;
    //         $object->Item = $rowsalesorder->Item;
    //         $object->Unit = $rowsalesorder->Unit;
    //         $object->Pks_Per_Carton = $rowsalesorder->Pks_Per_Carton;
    //         $object->No_of_MC = $rowsalesorder->No_of_MC;
    //         $object->Qty = $rowsalesorder->Qty;
    //         $object->Unit_Price_FOB = $rowsalesorder->Unit_Price_FOB;
    //         $object->Price_Per_MCT = $rowsalesorder->Price_Per_MCT;

    //         $this->db->select('`batchno`, `qty`, `tbl_material_info_idtbl_material_info`');
    //         $this->db->from('tbl_production_material_issue');
    //         $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_material_issue.tbl_production_order_idtbl_production_order', 'left');
    //         $this->db->where('tbl_production_order.tbl_customer_porder_idtbl_customer_porder', $salesorderid);
    //         $this->db->where('tbl_production_material_issue.tbl_product_idtbl_product', $ItemID);
    //         $this->db->where('tbl_production_material_issue.status', 1);

    //         $respondissue=$this->db->get();

    //         foreach($respondissue->result() as $rowissuedata){
    //             $materialID = $rowissuedata->tbl_material_info_idtbl_material_info;
    //             $this->db->select('
    //                 AVG(CASE 
    //                     WHEN tbl_stock.currencytype = 2 THEN (tbl_stock.unitprice * tbl_stock.conversion_rate)
    //                     ELSE tbl_stock.unitprice 
    //                 END) AS unitcost 
    //             ');
    //             $this->db->from('tbl_stock');
    //             $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_stock.tbl_material_info_idtbl_material_info', 'left');
    //             $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
    //             $this->db->where('tbl_stock.tbl_material_info_idtbl_material_info', $materialID);
    //             $this->db->where('tbl_stock.tbl_company_idtbl_company', $companyid);
    //             $this->db->where('tbl_stock.tbl_company_branch_idtbl_company_branch', $branchid);
    //             $this->db->where('tbl_stock.status', 1);

    //             $respondmaterialinfo=$this->db->get();
    //         }            
    //     }

    //     // $sqlsalesorderqty="SELECT tbl_customer_porder_detail.qty FROM tbl_customer_porder_detail WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=? AND tbl_customer_porder_detail.tbl_product_idtbl_product=?";
    //     // $respondsalesorderqty=$this->db->query($sqlsalesorderqty, array($salesorderid, $finishgoodid));
    //     // if($respondsalesorderqty->num_rows()>0){
    //     //     $salesorderqty=$respondsalesorderqty->row(0)->qty;
    //     // }
    //     // else{
    //     //     $salesorderqty=0;
    //     // }

    //     // $sql="SELECT `tbl_product_bom`.`idtbl_product_bom`, `tbl_product_bom`.`tbl_material_info_idtbl_material_info`, `tbl_product_bom`.`qty` , `tbl_product_bom`.`wastage`, `tbl_material_info`.`materialname`, `tbl_material_category`.`categoryname`, `tbl_product`.`productcode`, `tbl_unit`.`unitcode`, `tbl_material_info`.`materialinfocode`
    //     // FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_bom`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_bom_info_idtbl_product_bom_info`= ? AND `tbl_product_bom`.`status`=?";
    //     // $respond=$this->db->query($sql, array($bomid, 1));

    //     // // Array to store supplier totals
    //     // $supplierTotals = array();
    //     // $totalcostall=0;

    //     // foreach($respond->result() as $row){
    //     //     $object = new stdClass();
    //     //     $object->idtbl_product_bom = $row->idtbl_product_bom;
    //     //     $object->tbl_material_info_idtbl_material_info = $row->tbl_material_info_idtbl_material_info;
    //     //     $object->qty = $row->qty;
    //     //     $object->wastage = $row->wastage;
    //     //     $object->materialname = $row->materialname;
    //     //     $object->categoryname = $row->categoryname;
    //     //     $object->productcode = $row->productcode;
    //     //     $object->unitcode = $row->unitcode;
    //     //     $object->materialinfocode = $row->materialinfocode;

    //     //     $sqlmaterialavg="SELECT 
    //     //         ms.`tbl_material_info_idtbl_material_info`,
    //     //         sup.`suppliername`,
    //     //         sup.`idtbl_supplier`,
    //     //         AVG(gd.`costunitprice`) AS average_costunitprice,
    //     //         COUNT(*) AS record_count
    //     //     FROM `tbl_material_suppliers` ms
    //     //     LEFT JOIN `tbl_grn` grn ON ms.`tbl_supplier_idtbl_supplier` = grn.`tbl_supplier_idtbl_supplier`
    //     //     LEFT JOIN `tbl_grndetail` gd ON grn.`idtbl_grn` = gd.`tbl_grn_idtbl_grn` AND ms.`tbl_material_info_idtbl_material_info` = gd.`tbl_material_info_idtbl_material_info`
    //     //     LEFT JOIN `tbl_supplier` sup ON ms.`tbl_supplier_idtbl_supplier` = sup.`idtbl_supplier`
    //     //     WHERE gd.`costunitprice` IS NOT NULL
    //     //     AND ms.`tbl_material_info_idtbl_material_info`=?
    //     //     GROUP BY ms.`tbl_supplier_idtbl_supplier`
    //     //     ORDER BY ms.`tbl_material_info_idtbl_material_info`";
    //     //     $respondmaterialavg=$this->db->query($sqlmaterialavg, array($row->tbl_material_info_idtbl_material_info));

    //     //     $i=0;
    //     //     foreach($respondmaterialavg->result() as $rowmaterialavg){
    //     //         $adjustedSalesQty = $salesorderqty + ($salesorderqty*($row->wastage/100));
    //     //         $totalcost = $rowmaterialavg->average_costunitprice * $adjustedSalesQty;
                
    //     //         // Initialize supplier in totals array if not exists
    //     //         $supplierId = $rowmaterialavg->idtbl_supplier;
    //     //         $supplierName = $rowmaterialavg->suppliername;
                
    //     //         if(!isset($supplierTotals[$supplierId])) {
    //     //             $supplierTotals[$supplierId] = array(
    //     //                 'suppliername' => $supplierName,
    //     //                 'total' => 0
    //     //             );
    //     //         }
                
    //     //         // Add to supplier total
    //     //         $supplierTotals[$supplierId]['total'] += $totalcost;

    //     //         if($i==0){
    //     //             $object->suppliername = $supplierName;
    //     //             $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //     //             $object->totalcost = $totalcost;
    //     //         }
    //     //         else{
    //     //             $object = new stdClass();
    //     //             $object->idtbl_product_bom = '';
    //     //             $object->tbl_material_info_idtbl_material_info = '';
    //     //             $object->qty = '';
    //     //             $object->wastage = '';
    //     //             $object->materialname = '';
    //     //             $object->categoryname = '';
    //     //             $object->productcode = '';
    //     //             $object->unitcode = '';
    //     //             $object->materialinfocode = '';
    //     //             $object->suppliername = $supplierName;
    //     //             $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
    //     //             $object->totalcost = $totalcost;
    //     //         }

    //     //         array_push($mainarray, $object);
    //     //         $totalcostall += $totalcost;
    //     //         $i++;
    //     //     }
    //     // }

    //     // $html='';
    //     // $html.='<table class="table table-bordered table-striped table-sm small" id="table_content">
    //     //     <thead>
    //     //         <tr>
    //     //             <th>Material Info Code</th>
    //     //             <th>Material Name</th>
    //     //             <th>Category</th>
    //     //             <th>Product Code</th>
    //     //             <th>Quantity per FG</th>
    //     //             <th>Wastage (%)</th>
    //     //             <th>Unit</th>
    //     //             <th>Supplier Name</th>
    //     //             <th class="text-right">Avg. Cost Unit Price</th>
    //     //             <th class="text-right">Total Cost for SO Qty ('.$adjustedSalesQty.')</th>
    //     //         </tr>
    //     //     </thead>
    //     //     <tbody>';  

    //     // foreach($mainarray as $data){
    //     //     $html.='<tr>
    //     //         <td>'.$data->materialinfocode.'</td>
    //     //         <td>'.$data->materialname.'</td>
    //     //         <td>'.$data->categoryname.'</td>
    //     //         <td>'.$data->productcode.'</td>
    //     //         <td>'.$data->qty.'</td>
    //     //         <td>'.$data->wastage.'</td>
    //     //         <td>'.$data->unitcode.'</td>
    //     //         <td>'.$data->suppliername.'</td>
    //     //         <td class="text-right">'.number_format((float)$data->average_costunitprice, 2, '.', ',').'</td>
    //     //         <td class="text-right">'.number_format((float)$data->totalcost, 2, '.', ',').'</td>
    //     //     </tr>';
    //     // }  
        
    //     // // Add supplier-wise totals in footer
    //     // $html.='</tbody>
    //     //     <tfoot>';
        
    //     // // Add supplier-wise totals
    //     // foreach($supplierTotals as $supplierId => $supplierData) {
    //     //     $html.='<tr>
    //     //         <th colspan="9" class="text-right">'.$supplierData['suppliername'].' Total</th>
    //     //         <th class="text-right">'.number_format((float)$supplierData['total'], 2, '.', ',').'</th>
    //     //     </tr>';
    //     // }
        
    //     // // Add grand total
    //     // $html.='<tr>
    //     //         <th colspan="9" class="text-right">Grand Total</th>
    //     //         <th class="text-right">'.number_format((float)$totalcostall, 2, '.', ',').'</th>
    //     //     </tr>
    //     // </tfoot>
    //     // </table>
    //     // ';
    //     // echo $html;
    // }
    // public function Getcostcountinfo(){
    //     $companyid = $_SESSION['companyid'];
    //     $branchid = $_SESSION['branchid'];         
    //     $customerid = $this->input->post('customerud');
    //     $salesorderid = $this->input->post('salesorderid');
    //     $costmarkup = $this->input->post('costmarkup');
    //     $costconversionrate = $this->input->post('costconversionrate');
    //     $mainarray = array();

    //     $saleorder = "SELECT 
    //         p.productcode AS ITEM_CODE,
    //         p.prodcutname AS Item,
    //         p.weight AS Unit,
    //         p.nopckperctn AS Pks_Per_Carton,
    //         (d.qty / p.nopckperctn) AS No_of_MC,
    //         d.qty AS Qty,
    //         d.unitprice AS Unit_Price_FOB,
    //         (d.unitprice * p.nopckperctn) AS Price_Per_MCT,
    //         (d.qty * d.unitprice) AS Total_Value_FOB,
    //         d.tbl_product_idtbl_product AS ItemID
    //     FROM tbl_customer_porder_detail d
    //     JOIN tbl_product p ON d.tbl_product_idtbl_product = p.idtbl_product
    //     WHERE d.tbl_customer_porder_idtbl_customer_porder = ?";
    //     $respondsalesorder = $this->db->query($saleorder, array($salesorderid));
        
    //     // Initialize totals
    //     $total_no_of_mc = 0;
    //     $total_value_fob = 0;
    //     $grand_total = 0;
        
    //     // Start HTML table
    //     echo '<table class="table table-striped table-bordered table-sm nowrap small w-100">';
    //     echo '<thead>';
    //     echo '<tr>';
    //     echo '<th nowrap>SL</th>';
    //     echo '<th nowrap>ITEM CODE</th>';
    //     echo '<th nowrap>Item</th>';
    //     echo '<th nowrap>Unit</th>';
    //     echo '<th nowrap>No of Pks per carton</th>';
    //     echo '<th nowrap>No. of MC</th>';
    //     echo '<th nowrap>Qty</th>';
    //     echo '<th nowrap>Unit Price ($) FOB</th>';
    //     echo '<th nowrap>Price Per MCT FOB ($)</th>';
    //     echo '<th nowrap>TOTAL VALUE FOB ($)</th>';
    //     echo '<th nowrap>Mat cost</th>';
    //     echo '<th nowrap>Handling</th>';
    //     echo '<th nowrap>Bags</th>';
    //     echo '<th nowrap>Cartons</th>';
    //     echo '<th nowrap>Packing</th>';
    //     echo '<th nowrap>Sticker</th>';
    //     echo '<th nowrap>Labor</th>';
    //     echo '<th nowrap>Waste</th>';
    //     echo '<th nowrap>Total Cost</th>';
    //     echo '<th nowrap>Markup</th>';
    //     echo '<th nowrap>Rs</th>';
    //     echo '<th nowrap>Rafi Price</th>';
    //     echo '<th nowrap>US ($)</th>';
    //     echo '<th nowrap>Selling Price</th>';
    //     echo '<th nowrap>Total Sales</th>';
    //     echo '<th nowrap>Total Cost</th>';
    //     echo '<th nowrap>Profit</th>';
    //     echo '<th nowrap>Margin</th>';
    //     echo '<th nowrap>Markup</th>';
    //     echo '</tr>';
    //     echo '</thead>';
    //     echo '<tbody>';
        
    //     $sl = 1;
    //     $all_objects = array();
        
    //     foreach($respondsalesorder->result() as $rowsalesorder){
    //         $ItemID = $rowsalesorder->ItemID;
            
    //         $object = new stdClass();
    //         $object->ITEM_CODE = $rowsalesorder->ITEM_CODE;
    //         $object->Item = $rowsalesorder->Item;
    //         $object->Unit = $rowsalesorder->Unit;
    //         $object->Pks_Per_Carton = $rowsalesorder->Pks_Per_Carton;
    //         $object->No_of_MC = $rowsalesorder->No_of_MC;
    //         $object->Qty = $rowsalesorder->Qty;
    //         $object->Unit_Price_FOB = $rowsalesorder->Unit_Price_FOB;
    //         $object->Price_Per_MCT = $rowsalesorder->Price_Per_MCT;
    //         $object->Total_Value_FOB = $rowsalesorder->Total_Value_FOB;
            
    //         // Initialize cost variables
    //         $object->Mat_cost = 0;
    //         $object->Handling = 0;
    //         $object->Bags = 0;
    //         $object->Cartons = 0;
    //         $object->Packing = 0;
    //         $object->Sticker = 0;
    //         $object->Labor = 0;
    //         $object->Waste = 0;

    //         $totalrscost = 0;
    //         $markuprscost = 0;
    //         $nettotalrscost = 0;
    //         $nettotalusdcost = 0;
    //         $totalsale = 0;
    //         $totalsale = 0;
    //         $totalprofit = 0;
    //         $totalmargin = 0;
    //         $totalmarkup = 0;
            
    //         // Get material issues for this product and sales order
    //         $this->db->select('
    //             tbl_production_material_issue.batchno, 
    //             tbl_production_material_issue.qty, 
    //             tbl_production_material_issue.tbl_material_info_idtbl_material_info,
    //             tbl_material_info.tbl_material_category_idtbl_material_category,
    //             tbl_material_category.categoryname,
    //             tbl_product_bom.qty AS `bomqty`,
    //             tbl_product_bom.wastage,
    //         ');
    //         $this->db->from('tbl_production_material_issue');
    //         $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_material_issue.tbl_production_order_idtbl_production_order', 'left');
    //         $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_production_material_issue.tbl_material_info_idtbl_material_info', 'left');
    //         $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
    //         $this->db->join('tbl_product_bom', 'tbl_product_bom.tbl_product_bom_info_idtbl_product_bom_info = tbl_production_material_issue.tbl_product_bom_info_idtbl_product_bom_info AND tbl_product_bom.tbl_product_idtbl_product = tbl_production_material_issue.tbl_product_idtbl_product AND tbl_product_bom.tbl_material_info_idtbl_material_info = tbl_production_material_issue.tbl_material_info_idtbl_material_info', 'left');
    //         $this->db->where('tbl_production_order.tbl_customer_porder_idtbl_customer_porder', $salesorderid);
    //         $this->db->where('tbl_production_material_issue.tbl_product_idtbl_product', $ItemID);
    //         $this->db->where('tbl_production_material_issue.status', 1);
    //         $this->db->group_by('tbl_production_material_issue.idtbl_production_material_issue');
            
    //         $respondissue = $this->db->get();
            
    //         // Process each material issue to get costs
    //         foreach($respondissue->result() as $rowissuedata){ //print_r($rowissuedata);
    //             $materialID = $rowissuedata->tbl_material_info_idtbl_material_info;
    //             $issued_qty = $rowissuedata->qty;
    //             $bomqty = $rowissuedata->bomqty;
    //             $wastage = $rowissuedata->wastage;
    //             $categoryname = strtolower($rowissuedata->categoryname);
                
    //             // Get unit cost from stock for this batch/material
    //             $this->db->select("
    //                 AVG(CASE 
    //                     WHEN tbl_stock.currencytype = 2 THEN (tbl_stock.unitprice * tbl_stock.conversion_rate * $bomqty)
    //                     ELSE (tbl_stock.unitprice * $bomqty)
    //                 END) AS unitcost,
    //                 AVG(CASE 
    //                     WHEN tbl_stock.currencytype = 2 THEN (tbl_stock.unitprice * tbl_stock.conversion_rate * $wastage)
    //                     ELSE (tbl_stock.unitprice * $wastage)
    //                 END) AS wastage,
    //                 tbl_material_category.tbl_material_main_category_idtbl_material_main_category
    //             ", FALSE);
    //             $this->db->from('tbl_stock');
    //             $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_stock.tbl_material_info_idtbl_material_info', 'left');
    //             $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
    //             $this->db->where('tbl_stock.tbl_material_info_idtbl_material_info', $materialID);
    //             $this->db->where('tbl_stock.tbl_company_idtbl_company', $companyid);
    //             $this->db->where('tbl_stock.tbl_company_branch_idtbl_company_branch', $branchid);
    //             $this->db->where('tbl_stock.status', 1);
                
    //             // Add batch number filter if available
    //             if(!empty($rowissuedata->batchno)){
    //                 $this->db->where('tbl_stock.batchno', $rowissuedata->batchno);
    //             }
                
    //             $respondmaterialinfo = $this->db->get();
    //             // print_r($this->db->last_query());
                
    //             $total_cost = 0;
    //             if($respondmaterialinfo->num_rows() > 0){
    //                 $materialcost = $respondmaterialinfo->row()->unitcost;
    //                 $materialwastagecost = $respondmaterialinfo->row()->wastage;
    //                 $materialmaincategory = $respondmaterialinfo->row()->tbl_material_main_category_idtbl_material_main_category;
    //                 $total_cost += $issued_qty * $materialcost;
    //                 $totalrscost += $materialcost;
                    
    //                 // Assign cost based on category
    //                 if($materialmaincategory == 1) {
    //                     $object->Mat_cost += $materialcost;
    //                 } elseif($materialmaincategory == 2) {
    //                     $object->Handling += $materialcost;
    //                 } elseif($materialmaincategory == 3) {
    //                     $object->Bags += $materialcost; // Count bags by quantity
    //                 } elseif($materialmaincategory == 4) {
    //                     $object->Cartons += $materialcost; // Count cartons by quantity
    //                 } elseif($materialmaincategory == 5) {
    //                     $object->Packing += $materialcost;
    //                 } elseif($materialmaincategory == 6) {
    //                     $object->Sticker += $materialcost;
    //                 } elseif($materialmaincategory == 7) {
    //                     $object->Labor += $materialcost;
    //                 }

    //                 if($materialwastagecost > 0) {
    //                     $object->Waste += $materialwastagecost;
    //                     $total_cost += $materialwastagecost;
    //                     $totalrscost += $materialwastagecost;
    //                 }
    //                 // $markupcost = ($total_cost * $costmarkup) / 100;
    //                 // $usdcost = ($total_cost / $costconversionrate);
    
    //                 // $object->totalrscost = $total_cost;
    //                 // $object->markupcost = $markupcost;
    //                 // $object->nettotalrscost = $total_cost+$markupcost;
    //             }                
    //         }
            
    //         $markuprscost = ($totalrscost * $costmarkup) / 100;
    //         $nettotalrscost = $totalrscost + $markuprscost;
    //         $nettotalusdcost = $nettotalrscost / $costconversionrate;
    //         $totalsale = $object->Total_Value_FOB * $costconversionrate;
    //         $totalcost = $object->Qty * $totalrscost;

    //         // Accumulate totals
    //         $total_no_of_mc += $object->No_of_MC;
    //         $total_value_fob += $object->Total_Value_FOB;
            
    //         // Add to array for later use if needed
    //         $all_objects[] = $object;
            
    //         // Display row
    //         echo '<tr>';
    //         echo '<td nowrap>' . $sl++ . '</td>';
    //         echo '<td nowrap>' . $object->ITEM_CODE . '</td>';
    //         echo '<td nowrap>' . $object->Item . '</td>';
    //         echo '<td nowrap>' . $object->Unit . '</td>';
    //         echo '<td nowrap>' . $object->Pks_Per_Carton . '</td>';
    //         echo '<td nowrap>' . number_format($object->No_of_MC, 0) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Qty, 0) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Price_Per_MCT, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Total_Value_FOB, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Mat_cost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Handling, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Bags, 0) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Cartons, 0) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Packing, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Sticker, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Labor, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Waste, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($totalrscost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($markuprscost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($nettotalrscost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($nettotalusdcost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($totalsale, 2) . '</td>';
    //         echo '<td nowrap>' . number_format($totalcost, 2) . '</td>';
    //         echo '<td nowrap>' . number_format(($totalsale - $totalcost), 2) . '</td>';
    //         echo '<td nowrap>' . round(((($totalsale - $totalcost) / $totalsale)*100), 0) . '%</td>';
    //         echo '<td nowrap>' . round(((($totalsale - $totalcost) / $totalcost)*100), 0) . '%</td>';
    //         echo '</tr>';
    //     }
        
    //     // Display total row
    //     echo '<tr style="font-weight: bold; background-color: #f0f0f0;">';
    //     echo '<td colspan="5" style="text-align: right;">TOTAL:</td>';
    //     echo '<td>' . number_format($total_no_of_mc, 0) . '</td>';
    //     echo '<td></td>'; // Empty Qty column
    //     echo '<td></td>'; // Empty Unit Price column
    //     echo '<td></td>'; // Empty Price Per MCT column
    //     echo '<td>' . number_format($total_value_fob, 2) . '</td>';
    //     echo '<td colspan="8"></td>'; // Empty remaining columns
    //     echo '</tr>';
        
    //     echo '</tbody>';
    //     echo '</table>';
        
    //     // Return the objects array if needed
    //     return $mainarray;
    // }
    public function Getcostcountinfo() {
        $companyid = $_SESSION['companyid'];
        $branchid = $_SESSION['branchid'];         
        $customerid = $this->input->post('customerud');
        $salesorderid = $this->input->post('salesorderid');
        $costmarkup = $this->input->post('costmarkup');
        $costconversionrate = $this->input->post('costconversionrate');
        $mainarray = array();

        $saleorder = "SELECT 
                p.productcode AS ITEM_CODE,
                p.prodcutname AS Item,
                p.weight AS Unit,
                p.nopckperctn AS Pks_Per_Carton,
                (d.qty / p.nopckperctn) AS No_of_MC,
                d.qty AS Qty,
                d.unitprice AS Unit_Price_FOB,
                (d.unitprice * p.nopckperctn) AS Price_Per_MCT,
                (d.qty * d.unitprice) AS Total_Value_FOB,
                d.tbl_product_idtbl_product AS ItemID
            FROM tbl_customer_porder_detail d
            JOIN tbl_product p ON d.tbl_product_idtbl_product = p.idtbl_product
            WHERE d.tbl_customer_porder_idtbl_customer_porder = ?";
        
        $respondsalesorder = $this->db->query($saleorder, array($salesorderid));
        
        // Initialize Grand Totals
        $total_no_of_mc = 0;
        $total_value_fob = 0;
        $grand_total_sales = 0;
        $grand_total_cost = 0;
        $grand_total_profit = 0;
        
        echo '<table class="table table-striped table-bordered table-sm nowrap small w-100" id="table_content">';
        echo '<thead>
                <tr>
                    <th nowrap>SL</th>
                    <th nowrap>ITEM CODE</th>
                    <th nowrap>Item</th>
                    <th nowrap>Unit</th>
                    <th nowrap>No of Pks per carton</th>
                    <th nowrap>No. of MC</th>
                    <th nowrap>Qty</th>
                    <th nowrap>Unit Price ($) FOB</th>
                    <th nowrap>Price Per MCT FOB ($)</th>
                    <th nowrap>TOTAL VALUE FOB ($)</th>
                    <th nowrap>Mat cost</th>
                    <th nowrap>Handling</th>
                    <th nowrap>Bags</th>
                    <th nowrap>Cartons</th>
                    <th nowrap>Packing</th>
                    <th nowrap>Sticker</th>
                    <th nowrap>Labor</th>
                    <th nowrap>Waste</th>
                    <th nowrap>Total Cost</th>
                    <th nowrap>Markup</th>
                    <th nowrap>Rs</th>
                    <th nowrap>Rafi Price</th>
                    <th nowrap>US ($)</th>
                    <th nowrap>Selling Price</th>
                    <th nowrap>Total Sales</th>
                    <th nowrap>Total Cost</th>
                    <th nowrap>Profit</th>
                    <th nowrap>Margin</th>
                    <th nowrap>Markup</th>
                </tr>
            </thead>';
        echo '<tbody>';
        
        $sl = 1;
        foreach($respondsalesorder->result() as $rowsalesorder) {
            $ItemID = $rowsalesorder->ItemID;
            
            $object = new stdClass();
            $object->ITEM_CODE = $rowsalesorder->ITEM_CODE;
            $object->Item = $rowsalesorder->Item;
            $object->Unit = $rowsalesorder->Unit;
            $object->Pks_Per_Carton = $rowsalesorder->Pks_Per_Carton;
            $object->No_of_MC = $rowsalesorder->No_of_MC;
            $object->Qty = $rowsalesorder->Qty;
            $object->Unit_Price_FOB = $rowsalesorder->Unit_Price_FOB;
            $object->Price_Per_MCT = $rowsalesorder->Price_Per_MCT;
            $object->Total_Value_FOB = $rowsalesorder->Total_Value_FOB;
            
            // Initialize individual row costs
            $object->Mat_cost = 0; $object->Handling = 0; $object->Bags = 0;
            $object->Cartons = 0; $object->Packing = 0; $object->Sticker = 0;
            $object->Labor = 0; $object->Waste = 0;

            $totalrscost = 0;

            // Fetch Material Issues
            $this->db->select('mi.batchno, mi.qty, mi.tbl_material_info_idtbl_material_info, mc.categoryname, pb.qty AS bomqty, pb.wastage, mc.tbl_material_main_category_idtbl_material_main_category as maincat');
            $this->db->from('tbl_production_material_issue mi');
            $this->db->join('tbl_production_order po', 'po.idtbl_production_order = mi.tbl_production_order_idtbl_production_order', 'left');
            $this->db->join('tbl_material_info minf', 'minf.idtbl_material_info = mi.tbl_material_info_idtbl_material_info', 'left');
            $this->db->join('tbl_material_category mc', 'mc.idtbl_material_category = minf.tbl_material_category_idtbl_material_category', 'left');
            $this->db->join('tbl_product_bom pb', 'pb.tbl_product_bom_info_idtbl_product_bom_info = mi.tbl_product_bom_info_idtbl_product_bom_info AND pb.tbl_product_idtbl_product = mi.tbl_product_idtbl_product AND pb.tbl_material_info_idtbl_material_info = mi.tbl_material_info_idtbl_material_info', 'left');
            $this->db->where('po.tbl_customer_porder_idtbl_customer_porder', $salesorderid);
            $this->db->where('mi.tbl_product_idtbl_product', $ItemID);
            $this->db->where('mi.status', 1);
            $this->db->group_by('mi.idtbl_production_material_issue');
            
            $respondissue = $this->db->get();

            foreach($respondissue->result() as $rowissuedata) {
                $bomqty = $rowissuedata->bomqty;
                $wastage = $rowissuedata->wastage;

                $this->db->select("
                    AVG(CASE WHEN s.currencytype = 2 THEN (s.unitprice * s.conversion_rate * $bomqty) ELSE (s.unitprice * $bomqty) END) AS unitcost,
                    AVG(CASE WHEN s.currencytype = 2 THEN (s.unitprice * s.conversion_rate * $wastage) ELSE (s.unitprice * $wastage) END) AS wastagecost
                ", FALSE);
                $this->db->from('tbl_stock s');
                $this->db->where('s.tbl_material_info_idtbl_material_info', $rowissuedata->tbl_material_info_idtbl_material_info);
                $this->db->where('s.tbl_company_idtbl_company', $companyid);
                $this->db->where('s.status', 1);
                if(!empty($rowissuedata->batchno)) $this->db->where('s.batchno', $rowissuedata->batchno);
                
                $resStock = $this->db->get()->row();

                if($resStock) {
                    $mcost = $resStock->unitcost;
                    $wcost = $resStock->wastagecost;
                    $totalrscost += ($mcost + $wcost);

                    // Assign to object based on main category
                    switch($rowissuedata->maincat) {
                        case 1: $object->Mat_cost += $mcost; break;
                        case 2: $object->Handling += $mcost; break;
                        case 3: $object->Bags += $mcost; break;
                        case 4: $object->Cartons += $mcost; break;
                        case 5: $object->Packing += $mcost; break;
                        case 6: $object->Sticker += $mcost; break;
                        case 7: $object->Labor += $mcost; break;
                    }
                    $object->Waste += $wcost;
                }
            }

            // Row Calculations
            $markuprscost = ($totalrscost * $costmarkup) / 100;
            $nettotalrscost = $totalrscost + $markuprscost;
            $nettotalusdcost = ($costconversionrate > 0) ? ($nettotalrscost / $costconversionrate) : 0;
            
            $row_total_sales = $object->Total_Value_FOB * $costconversionrate;
            $row_total_cost = $object->Qty * $totalrscost;
            $row_profit = $row_total_sales - $row_total_cost;

            // Accumulate Grand Totals
            $total_no_of_mc += $object->No_of_MC;
            $total_value_fob += $object->Total_Value_FOB;
            $grand_total_sales += $row_total_sales;
            $grand_total_cost += $row_total_cost;
            $grand_total_profit += $row_profit;

            echo '<tr>
                    <td nowrap>' . $sl++ . '</td>
                    <td nowrap>' . $object->ITEM_CODE . '</td>
                    <td nowrap>' . $object->Item . '</td>
                    <td nowrap>' . $object->Unit . '</td>
                    <td nowrap>' . $object->Pks_Per_Carton . '</td>
                    <td nowrap>' . number_format($object->No_of_MC, 0) . '</td>
                    <td nowrap>' . number_format($object->Qty, 0) . '</td>
                    <td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>
                    <td nowrap>' . number_format($object->Price_Per_MCT, 2) . '</td>
                    <td nowrap>' . number_format($object->Total_Value_FOB, 2) . '</td>
                    <td nowrap>' . number_format($object->Mat_cost, 2) . '</td>
                    <td nowrap>' . number_format($object->Handling, 2) . '</td>
                    <td nowrap>' . number_format($object->Bags, 2) . '</td>
                    <td nowrap>' . number_format($object->Cartons, 2) . '</td>
                    <td nowrap>' . number_format($object->Packing, 2) . '</td>
                    <td nowrap>' . number_format($object->Sticker, 2) . '</td>
                    <td nowrap>' . number_format($object->Labor, 2) . '</td>
                    <td nowrap>' . number_format($object->Waste, 2) . '</td>
                    <td nowrap>' . number_format($totalrscost, 2) . '</td>
                    <td nowrap>' . number_format($markuprscost, 2) . '</td>
                    <td nowrap>' . number_format($nettotalrscost, 2) . '</td>
                    <td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>
                    <td nowrap>' . number_format($nettotalusdcost, 2) . '</td>
                    <td nowrap>' . number_format($object->Unit_Price_FOB, 2) . '</td>
                    <td nowrap>' . number_format($row_total_sales, 2) . '</td>
                    <td nowrap>' . number_format($row_total_cost, 2) . '</td>
                    <td nowrap>' . number_format($row_profit, 2) . '</td>
                    <td nowrap>' . ($row_total_sales != 0 ? round(($row_profit / $row_total_sales) * 100, 0) : 0) . '%</td>
                    <td nowrap>' . ($row_total_cost != 0 ? round(($row_profit / $row_total_cost) * 100, 0) : 0) . '%</td>
                </tr>';
        }
        
        // Calculate Final Percentages for Total Row
        $grand_margin = ($grand_total_sales != 0) ? round(($grand_total_profit / $grand_total_sales) * 100, 0) : 0;
        $grand_markup = ($grand_total_cost != 0) ? round(($grand_total_profit / $grand_total_cost) * 100, 0) : 0;

        // Display total row
        echo '<tr style="font-weight: bold; background-color: #e9ecef;">
                <td nowrap colspan="5" style="text-align: right;">GRAND TOTAL:</td>
                <td nowrap>' . number_format($total_no_of_mc, 0) . '</td>
                <td nowrap colspan="3"></td>
                <td nowrap>' . number_format($total_value_fob, 2) . '</td>
                <td nowrap colspan="14"></td>
                <td nowrap>' . number_format($grand_total_sales, 2) . '</td>
                <td nowrap>' . number_format($grand_total_cost, 2) . '</td>
                <td nowrap>' . number_format($grand_total_profit, 2) . '</td>
                <td nowrap>' . $grand_margin . '%</td>
                <td nowrap>' . $grand_markup . '%</td>
            </tr>';
        
        echo '</tbody></table>';
        return $mainarray;
    }
}