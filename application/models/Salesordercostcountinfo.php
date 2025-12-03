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
    public function Getcostcountinfo(){
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];         
        $customerid=$this->input->post('customerud');
        $salesorderid=$this->input->post('salesorderid');
        $finishgoodid=$this->input->post('finishgoodid');
        $bomid=$this->input->post('bomid');
        $mainarray = array();

        $sqlsalesorderqty="SELECT tbl_customer_porder_detail.qty FROM tbl_customer_porder_detail WHERE tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=? AND tbl_customer_porder_detail.tbl_product_idtbl_product=?";
        $respondsalesorderqty=$this->db->query($sqlsalesorderqty, array($salesorderid, $finishgoodid));
        if($respondsalesorderqty->num_rows()>0){
            $salesorderqty=$respondsalesorderqty->row(0)->qty;
        }
        else{
            $salesorderqty=0;
        }

        $sql="SELECT `tbl_product_bom`.`idtbl_product_bom`, `tbl_product_bom`.`tbl_material_info_idtbl_material_info`, `tbl_product_bom`.`qty` , `tbl_product_bom`.`wastage`, `tbl_material_info`.`materialname`, `tbl_material_category`.`categoryname`, `tbl_product`.`productcode`, `tbl_unit`.`unitcode`, `tbl_material_info`.`materialinfocode`
        FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_product_bom`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_bom_info_idtbl_product_bom_info`= ? AND `tbl_product_bom`.`status`=?";
        $respond=$this->db->query($sql, array($bomid, 1));

        foreach($respond->result() as $row){
            $object = new stdClass();
            $object->idtbl_product_bom = $row->idtbl_product_bom;
            $object->tbl_material_info_idtbl_material_info = $row->tbl_material_info_idtbl_material_info;
            $object->qty = $row->qty;
            $object->wastage = $row->wastage;
            $object->materialname = $row->materialname;
            $object->categoryname = $row->categoryname;
            $object->productcode = $row->productcode;
            $object->unitcode = $row->unitcode;
            $object->materialinfocode = $row->materialinfocode;

            $sqlmaterialavg="SELECT 
                ms.`tbl_material_info_idtbl_material_info`,
                sup.`suppliername`,
                AVG(gd.`costunitprice`) AS average_costunitprice,
                COUNT(*) AS record_count
            FROM `tbl_material_suppliers` ms
            LEFT JOIN `tbl_grn` grn ON ms.`tbl_supplier_idtbl_supplier` = grn.`tbl_supplier_idtbl_supplier`
            LEFT JOIN `tbl_grndetail` gd ON grn.`idtbl_grn` = gd.`tbl_grn_idtbl_grn` AND ms.`tbl_material_info_idtbl_material_info` = gd.`tbl_material_info_idtbl_material_info`
            LEFT JOIN `tbl_supplier` sup ON ms.`tbl_supplier_idtbl_supplier` = sup.`idtbl_supplier`
            WHERE gd.`costunitprice` IS NOT NULL
            AND ms.`tbl_material_info_idtbl_material_info`=?
            GROUP BY ms.`tbl_supplier_idtbl_supplier`
            ORDER BY ms.`tbl_material_info_idtbl_material_info`";
            $respondmaterialavg=$this->db->query($sqlmaterialavg, array($row->tbl_material_info_idtbl_material_info));

            $i=0;
            foreach($respondmaterialavg->result() as $rowmaterialavg){
                $salesorderqty = $salesorderqty + ($salesorderqty*($row->wastage/100));

                if($i==0){
                    $object->suppliername = $rowmaterialavg->suppliername;
                    $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
                    $object->totalcost = $rowmaterialavg->average_costunitprice*$salesorderqty;
                }
                else{
                    $object = new stdClass();
                    $object->idtbl_product_bom = '';
                    $object->tbl_material_info_idtbl_material_info = '';
                    $object->qty = '';
                    $object->wastage = '';
                    $object->materialname = '';
                    $object->categoryname = '';
                    $object->productcode = '';
                    $object->unitcode = '';
                    $object->materialinfocode = '';
                    $object->suppliername = $rowmaterialavg->suppliername;
                    $object->average_costunitprice = $rowmaterialavg->average_costunitprice;
                    $object->totalcost = $rowmaterialavg->average_costunitprice*$salesorderqty;
                }

                array_push($mainarray, $object);
                $i++;
            }
        }

        // print_r($mainarray);
        
        $html='';
        $html.='<table class="table table-bordered table-striped table-sm small" id="table_content">
            <thead>
                <tr>
                    <th>Material Info Code</th>
                    <th>Material Name</th>
                    <th>Category</th>
                    <th>Product Code</th>
                    <th>Quantity per FG</th>
                    <th>Wastage (%)</th>
                    <th>Unit</th>
                    <th>Supplier Name</th>
                    <th class="text-right">Avg. Cost Unit Price</th>
                    <th class="text-right">Total Cost for SO Qty ('.$salesorderqty.')</th>
                </tr>
            </thead>
            <tbody>';  
        $totalcostall=0;
        foreach($mainarray as $data){
            $html.='<tr>
                <td>'.$data->materialinfocode.'</td>
                <td>'.$data->materialname.'</td>
                <td>'.$data->categoryname.'</td>
                <td>'.$data->productcode.'</td>
                <td>'.$data->qty.'</td>
                <td>'.$data->wastage.'</td>
                <td>'.$data->unitcode.'</td>
                <td>'.$data->suppliername.'</td>
                <td class="text-right">'.number_format((float)$data->average_costunitprice, 2, '.', ',').'</td>
                <td class="text-right">'.number_format((float)$data->totalcost, 2, '.', ',').'</td>
            </tr>';
            $totalcostall +=$data->totalcost;
        }  
        $html.='</tbody>
            <tfoot>
                <tr>
                    <th colspan="9" class="text-right">Total Cost</th>
                    <th class="text-right">'.number_format((float)$totalcostall, 2, '.', ',').'</th>
                </tr>
            </tfoot>
        </table>
        ';
        echo $html;
    }
}