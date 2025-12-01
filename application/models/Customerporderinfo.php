<?php
class Customerporderinfo extends CI_Model{
    public function Getcustomerlist(){
        $this->db->select('`idtbl_customer`, `name`');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getproductlist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_product`, `productcode`, `prodcutname` FROM `tbl_product` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_product`, `productcode`, `prodcutname` FROM `tbl_product` WHERE `status`=? AND `productcode` LIKE '%$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_product`, `productcode`, `prodcutname` FROM `tbl_product` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->prodcutname.' - '.$row->productcode);
        }
        
        echo json_encode($data);
    }
    public function Getproductpriceaccoproduct(){
        $recordID=$this->input->post('recordID');
        $saletype=$this->input->post('saletype');
        $customer=$this->input->post('customer');

        $this->db->select('tbl_customer_porder_detail.suggestprice, tbl_customer_porder_detail.unitpriceusd');
        $this->db->from('tbl_customer_porder_detail');
        $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', 'left');
        $this->db->where('tbl_customer_porder_detail.status', 1);
        $this->db->where('tbl_customer_porder.tbl_customer_idtbl_customer', $customer);
        $this->db->where('tbl_customer_porder_detail.tbl_product_idtbl_product', $recordID);
        $this->db->order_by('tbl_customer_porder_detail.idtbl_customer_porder_detail', 'DESC');
        $this->db->limit(1);
        $respond=$this->db->get();
           
        if ($respond->num_rows() > 0) {
            $obj=new stdClass();
            $obj->saleprice=$respond->row(0)->suggestprice;
            $obj->salepriceusd=$respond->row(0)->unitpriceusd;
        }
        else{
            $this->db->select('`retailprice`, `retailpriceusd`');
            $this->db->from('tbl_product');
            $this->db->where('status', 1);
            $this->db->where('idtbl_product', $recordID);
            $respond=$this->db->get();

            $obj=new stdClass();
            $obj->saleprice=$respond->row(0)->retailprice;
            $obj->salepriceusd=$respond->row(0)->retailpriceusd;
        }
        
        echo json_encode($obj);

        // $sql="SELECT * FROM (SELECT `tbl_product_bom`.`qty` AS `rowqty`, AVG(`tbl_grndetail`.`costunitprice`) AS `avgrowmate`, `tbl_product_bom`.`tbl_product_idtbl_product`, `tbl_material_info`.`tbl_unit_idtbl_unit` AS `rowunit` FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` WHERE `tbl_product_bom`.`status`=1 AND `tbl_product_bom`.`tbl_product_idtbl_product`='$recordID' AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=1 AND `tbl_stock`.`qty`>0 AND `tbl_stock`.`status`=1 AND `tbl_grndetail`.`status`=1) AS `drow` LEFT JOIN (SELECT `tbl_product_bom`.`qty` AS `packqty`, AVG(`tbl_grndetail`.`costunitprice`) AS `avgpackmate`, `tbl_product_bom`.`tbl_product_idtbl_product`, `tbl_material_info`.`tbl_unit_idtbl_unit` AS `packunit` FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` WHERE `tbl_product_bom`.`status`=1 AND `tbl_product_bom`.`tbl_product_idtbl_product`='$recordID' AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=2 AND `tbl_stock`.`qty`>0 AND `tbl_stock`.`status`=1 AND `tbl_grndetail`.`status`=1) AS `dpack` ON `dpack`.`tbl_product_idtbl_product`=`drow`.`tbl_product_idtbl_product` LEFT JOIN (SELECT `tbl_product_bom`.`qty` AS `labelqty`, AVG(`tbl_grndetail`.`costunitprice`) AS `avglabelmate`, `tbl_product_bom`.`tbl_product_idtbl_product`, `tbl_material_info`.`tbl_unit_idtbl_unit` AS `labelunit` FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` WHERE `tbl_product_bom`.`status`=1 AND `tbl_product_bom`.`tbl_product_idtbl_product`='$recordID' AND `tbl_material_info`.`tbl_material_category_idtbl_material_category`=3 AND `tbl_stock`.`qty`>0 AND `tbl_stock`.`status`=1 AND `tbl_grndetail`.`status`=1) AS `dlabel` ON `dlabel`.`tbl_product_idtbl_product`=`drow`.`tbl_product_idtbl_product`";
        // $sql="SELECT
        //     `tbl_product_bom`.`qty` AS `rowqty`,
        //     AVG(`tbl_grndetail`.`costunitprice`) AS `avgrowmate`,
        //     `tbl_product_bom`.`tbl_product_idtbl_product`,
        //     `tbl_material_info`.`tbl_unit_idtbl_unit` AS `rowunit`,
        //     (AVG(`tbl_grndetail`.`costunitprice`)*`tbl_product_bom`.`qty`) AS `totalunitcost`
        // FROM
        //     `tbl_product_bom`
        // LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info` = `tbl_product_bom`.`tbl_material_info_idtbl_material_info`
        // LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info` = `tbl_product_bom`.`tbl_material_info_idtbl_material_info`
        // LEFT JOIN `tbl_grndetail` ON `tbl_grndetail`.`tbl_material_info_idtbl_material_info` = `tbl_product_bom`.`tbl_material_info_idtbl_material_info`
        // WHERE
        //     `tbl_product_bom`.`status` = 1 AND `tbl_product_bom`.`tbl_product_idtbl_product` = '$recordID' AND `tbl_stock`.`qty` > 0 AND `tbl_stock`.`status` = 1 AND `tbl_grndetail`.`status` = 1
        // GROUP BY
        //     `tbl_product_bom`.`tbl_material_info_idtbl_material_info`";
        // $respond=$this->db->query($sql);    

        // if(!empty($respond->row(0)->avgrowmate)){$rowmaterialcost=$respond->row(0)->avgrowmate*$respond->row(0)->rowqty;}
        // else{$rowmaterialcost=0;}

        // if(!empty($respond->row(0)->avgpackmate)){$packmaterialcost=$respond->row(0)->avgpackmate*$respond->row(0)->packqty;}
        // else{$packmaterialcost=0;}

        // if(!empty($respond->row(0)->avglabelmate)){$labelmaterialcost=$respond->row(0)->avglabelmate*$respond->row(0)->labelqty;}
        // else{$labelmaterialcost=0;}

        // $totalunitprice=$rowmaterialcost+$packmaterialcost+$labelmaterialcost;

        // echo $totalunitprice;

        // $totalunitprice=0;
        // foreach($respond->result() as $rowlist){
        //     $totalunitprice=$totalunitprice+$rowlist->totalunitcost;
        // }

        // echo $totalunitprice;
    }
    public function Productlist(){
        $sql="SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`, `tbl_material_code`.`materialname` FROM `tbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` WHERE `tbl_product`.`status`=?";
        $respond=$this->db->query($sql, array(1));    

        return $respond;
    }
    public function Customerporderinsertupdate(){
        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $orderdate=$this->input->post('orderdate');
        $duedate=$this->input->post('duedate');
        $total=$this->input->post('total');
        $remark=$this->input->post('remark');
        $customer=$this->input->post('customer');
        $ordertype=$this->input->post('ordertype');
        $profitmargin=$this->input->post('profitmargin');
        $totalusd=$this->input->post('totalusd');
        $usdrate=$this->input->post('usdrate');

        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}
        $recordOption=$this->input->post('recordOption');

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1):
            $this->db->trans_begin();

            $sqlnextno = "SELECT IFNULL(MAX(`sod_no`), 0) + 1 AS next_sod_no FROM `tbl_customer_porder` WHERE `tbl_company_idtbl_company`=?";
            $respondnextno=$this->db->query($sqlnextno, array($companyid));

            $data = array(
                'sod_no'=> $respondnextno->row(0)->next_sod_no, 
                'orderdate'=> $orderdate, 
                'duedate'=> $duedate, 
                'subtotal'=> $total, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'nettotal'=> $total, 
                'subtotalusd'=> $totalusd, 
                'discountamountusd'=> '0', 
                'nettotalusd'=> $totalusd, 
                'usd_rate'=> $usdrate, 
                'confirmstatus'=> '0', 
                'transproductionstatus'=> '0', 
                'remark'=> $remark, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customer_idtbl_customer'=> $customer,
                'tbl_order_type_idtbl_order_type'=> $ordertype,
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );

            $this->db->insert('tbl_customer_porder', $data);

            $porderID=$this->db->insert_id();

            foreach($tableData as $rowtabledata){
                $productname=$rowtabledata['col_1'];
                $comment=$rowtabledata['col_2'];
                $productID=$rowtabledata['col_3'];
                $qty=$rowtabledata['col_4'];
                $salepriceusd=str_replace(',', '', $rowtabledata['col_5']);
                $saleprice = str_replace(',', '', $rowtabledata['col_6']);
                $totalusd=str_replace(',', '', $rowtabledata['col_7']);
                $total=str_replace(',', '', $rowtabledata['col_8']);

                $dataone = array(
                    'qty'=> $qty,
                    'suggestprice'=> $saleprice,  
                    'discount'=> '0', 
                    'discountamount'=> '0', 
                    'netsaleprice'=> $total,  
                    'unitpriceusd'=> $salepriceusd,  
                    'discountamountusd'=> '0',  
                    'netsalepriceusd'=> $totalusd,  
                    'comment'=> $comment, 
                    'profitmargin'=> $profitmargin, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime,
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_product_idtbl_product'=> $productID, 
                    'tbl_customer_porder_idtbl_customer_porder'=> $porderID
                );

                $this->db->insert('tbl_customer_porder_detail', $dataone);
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
        else:
            $this->db->select('`confirmstatus`');
            $this->db->from('tbl_customer_porder');
            $this->db->where('idtbl_customer_porder', $recordID);
            $this->db->where('status', 1);
            $respond=$this->db->get();

            if($respond->row(0)->confirmstatus>0):
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-exclamation-triangle';
                $actionObj->title='';
                $actionObj->message='Cannot Edit Confirmed Or Reject Sales Order';
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
                    'orderdate'=> $orderdate, 
                    'duedate'=> $duedate, 
                    'subtotal'=> $total, 
                    'discount'=> '0', 
                    'discountamount'=> '0', 
                    'nettotal'=> $total, 
                    'subtotalusd'=> $totalusd, 
                    'discountamountusd'=> '0', 
                    'nettotalusd'=> $totalusd, 
                    'confirmstatus'=> '0', 
                    'transproductionstatus'=> '0', 
                    'remark'=> $remark, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_order_type_idtbl_order_type'=> $ordertype,
                    'tbl_company_idtbl_company'=> $companyid,
                    'tbl_company_branch_idtbl_company_branch'=> $branchid
                );
                $this->db->where('idtbl_customer_porder', $recordID);
                $this->db->update('tbl_customer_porder', $data);

                $this->db->where('tbl_customer_porder_idtbl_customer_porder', $recordID);
                $this->db->delete('tbl_customer_porder_detail');

                foreach($tableData as $rowtabledata){
                    $productname=$rowtabledata['col_1'];
                    $comment=$rowtabledata['col_2'];
                    $productID=$rowtabledata['col_3'];
                    $qty=$rowtabledata['col_4'];
                    $salepriceusd=str_replace(',', '', $rowtabledata['col_5']);
                    $saleprice = str_replace(',', '', $rowtabledata['col_6']);
                    $totalusd=str_replace(',', '', $rowtabledata['col_7']);
                    $total=str_replace(',', '', $rowtabledata['col_8']);

                    $dataone = array(
                        'qty'=> $qty,
                        'suggestprice'=> $saleprice,  
                        'discount'=> '0', 
                        'discountamount'=> '0', 
                        'netsaleprice'=> $total,  
                        'unitpriceusd'=> $salepriceusd,  
                        'discountamountusd'=> '0',  
                        'netsalepriceusd'=> $totalusd,  
                        'comment'=> $comment, 
                        'profitmargin'=> $profitmargin, 
                        'status'=> '1', 
                        'insertdatetime'=> $updatedatetime,
                        'tbl_user_idtbl_user'=> $userID, 
                        'tbl_product_idtbl_product'=> $productID, 
                        'tbl_customer_porder_idtbl_customer_porder'=> $recordID
                    );

                    $this->db->insert('tbl_customer_porder_detail', $dataone);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    
                    $actionObj=new stdClass();
                    $actionObj->icon='fas fa-save';
                    $actionObj->title='';
                    $actionObj->message='Record Update Successfully';
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
            endif;
        endif;
    }
    // public function Customerpordertupdate(){
    //     $this->db->trans_begin();
    
    //     $userID=$_SESSION['userid'];
    //     $companyid=$_SESSION['companyid'];
    //     $branchid=$_SESSION['branchid'];
    
    //     $tableData=$this->input->post('tableData');
    
    //     // Check if $tableData is an array and not empty
    //     if(is_array($tableData) && !empty($tableData)){
    //         $orderdate=$this->input->post('orderdate');
    //         $duedate=$this->input->post('duedate');
    //         $total=$this->input->post('total');
    //         $remark=$this->input->post('remark');
    //         $customer=$this->input->post('customer');
    //         $ordertype=$this->input->post('ordertype');
    //         $profitmargin=$this->input->post('profitmargin');
    //         $hiddenporderid=$this->input->post('hiddenporderid');
    //         $usdrate=$this->input->post('usdrate2');
    //         $updatedatetime=date('Y-m-d H:i:s');
    
    //         $data = array(
    //             'orderdate'=> $orderdate, 
    //             'duedate'=> $duedate, 
    //             'subtotal'=> $total, 
    //             'usd_rate'=> $usdrate, 
    //             'discount'=> '0', 
    //             'discountamount'=> '0', 
    //             'nettotal'=> $total, 
    //             'confirmstatus'=> '0', 
    //             'transproductionstatus'=> '0', 
    //             'remark'=> $remark, 
    //             'status'=> '1', 
    //             'insertdatetime'=> $updatedatetime, 
    //             'tbl_user_idtbl_user'=> $userID,
    //             'tbl_customer_idtbl_customer'=> $customer,
    //             'tbl_order_type_idtbl_order_type'=> $ordertype,
    //             'tbl_company_idtbl_company'=> $companyid,
    //             'tbl_company_branch_idtbl_company_branch'=> $branchid
    //         );
    
    //         $this->db->where('idtbl_customer_porder', $hiddenporderid);
    //         $this->db->update('tbl_customer_porder', $data);
    
    
    //         $this->db->where('tbl_customer_porder_idtbl_customer_porder', $hiddenporderid);
    //         $this->db->delete('tbl_customer_porder_detail');
    
    //         foreach($tableData as $rowtabledata){
    //             $productname=$rowtabledata['col_1'];
    //             $comment=$rowtabledata['col_2'];
    //             $productID=$rowtabledata['col_3'];
    //             $unit=$rowtabledata['col_4'];
    //             $nettotal=$rowtabledata['col_5'];
    //             $qty=$rowtabledata['col_6'];
    //             $suggestprice=$rowtabledata['col_8'];
    
    //             $dataone = array(
    //                 'qty'=> $qty, 
    //                 'unitprice'=> $unit, 
    //                 'suggestprice'=> $suggestprice,  
    //                 'discount'=> '0', 
    //                 'discountamount'=> '0', 
    //                 'comment'=> $comment, 
    //                 'profitmargin'=> $profitmargin, 
    //                 'status'=> '1', 
    //                 'insertdatetime'=> $updatedatetime,
    //                 'tbl_user_idtbl_user'=> $userID, 
    //                 'tbl_product_idtbl_product'=> $productID, 
    //                 'tbl_customer_porder_idtbl_customer_porder'=> $hiddenporderid
    //             );
    
    //             $this->db->insert('tbl_customer_porder_detail', $dataone);
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Added Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);

    //             $obj=new stdClass();
    //             $obj->status=1;          
    //             $obj->action=$actionJSON;  
                
    //             echo json_encode($obj);
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-exclamation-triangle';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);

    //             $obj=new stdClass();
    //             $obj->status=0;          
    //             $obj->action=$actionJSON;  
                
    //             echo json_encode($obj);
    //         }
    //     }
    // }
    public function Customerporderview(){
        $recordID=$this->input->post('recordID');
        $companyid=$_SESSION['companyid'];

        $sql="SELECT `u`.*, `ua`.`name`, `ua`.`contact`, `ua`.`contact2`, `ua`.`address`, `ua`.`email` FROM `tbl_customer_porder` AS `u` LEFT JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`) WHERE `u`.`status`=? AND `u`.`idtbl_customer_porder`=?";
        $respond=$this->db->query($sql, array(1, $recordID));

        $this->db->select('tbl_customer_porder_detail.*, tbl_product.productcode, tbl_product.prodcutname');
        $this->db->from('tbl_customer_porder_detail');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product', 'left');
        $this->db->where('tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', $recordID);
        $this->db->where('tbl_customer_porder_detail.status', 1);

        $responddetail=$this->db->get();

        $html='';
        $html.='
        <div class="row">
            <div class="col-12">'.$respond->row(0)->name.'<br>'.$respond->row(0)->contact.' / '.$respond->row(0)->contact2.'<br>'.$respond->row(0)->address.'<br>'.$respond->row(0)->email.'</div>
        </div>
        <div class="row">
            <div class="col-12">
                <hr>
                <table class="table table-striped table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($responddetail->result() as $roworderinfo){
                        $html.='<tr>
                            <td>'.$roworderinfo->prodcutname.'-'.$roworderinfo->productcode.'</td>
                            <td>'.$roworderinfo->suggestprice.'</td>
                            <td>'.$roworderinfo->qty.'</td>
                            <td class="text-right">'.number_format(($roworderinfo->qty*$roworderinfo->suggestprice), 2).'</td>
                        </tr>';
                    }
                    $html.='</tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12 text-right"><h3 class="font-weight-normal">Rs. '.number_format(($respond->row(0)->nettotal), 2).'</h3></div>
        </div>
        ';

        echo $html;
    }
    public function Customerporderstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            
        }
        else if($type==2){
            $data = array(
                'transproductionstatus' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer_porder', $recordID);
            $this->db->update('tbl_customer_porder', $data);

            $this->db->select('*');
            $this->db->from('tbl_customer_porder');
            $this->db->where('status', 1);
            $this->db->where('idtbl_customer_porder', $recordID);

            $respond=$this->db->get();

            $data = array(
                'orderdate'=> $respond->row(0)->orderdate, 
                'duedate'=> $respond->row(0)->duedate, 
                'subtotal'=> $respond->row(0)->subtotal, 
                'discount'=> '0', 
                'discountamount'=> '0', 
                'nettotal'=> $respond->row(0)->nettotal, 
                'approvestatus'=> '0', 
                'completestatus'=> '0', 
                'remark'=> $respond->row(0)->remark, 
                'productionstep'=> '0', 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_customer_porder_idtbl_customer_porder '=> $recordID
            );
    
            $this->db->insert('tbl_production_order', $data);
    
            $prodcutionID=$this->db->insert_id();

            $this->db->select('*');
            $this->db->from('tbl_customer_porder_detail');
            $this->db->where('status', 1);
            $this->db->where('tbl_customer_porder_idtbl_customer_porder', $recordID);

            $responddetail=$this->db->get();
            
            foreach ($responddetail->result() as $rowporderdetail) {
                $comment=$rowporderdetail->comment;
                $productID=$rowporderdetail->tbl_product_idtbl_product;
                $unit=$rowporderdetail->unitprice;
                $qty=$rowporderdetail->qty;
                $today=date('Y-m-d');

                $dataone = array(
                    'startdate'=> $today, 
                    'qty'=> $qty, 
                    'unitprice'=> $unit, 
                    'discount'=> '0', 
                    'discountamount'=> '0', 
                    'comment'=> $comment, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime,
                    'tbl_user_idtbl_user'=> $userID, 
                    'tbl_production_order_idtbl_production_order'=> $prodcutionID,
                    'tbl_product_idtbl_product'=> $productID
                );

                $this->db->insert('tbl_production_order_detail', $dataone);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Purchase Order Transfer Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customerporder');                
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
                redirect('Customerporder');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer_porder', $recordID);
            $this->db->update('tbl_customer_porder', $data);

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
                redirect('Customerporder');                
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
                redirect('Customerporder');
            }
        }
    }
    public function Customerporderconfirm($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $confirmstatus=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        $data = array(
            'confirmstatus' => $confirmstatus,
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_customer_porder', $recordID);
        $this->db->update('tbl_customer_porder', $data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            if($confirmstatus==1){
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Sales Order Confirm Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';
            }
            else{
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Sales Order rejected Successfully';
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
    }
    public function Getordertype(){
        $this->db->select('`idtbl_order_type`, `type`');
        $this->db->from('tbl_order_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getcustomerporderdetails(){

        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_product`.`prodcutname`, `tbl_customer_porder`.`idtbl_customer_porder` FROM `tbl_product`
         LEFT JOIN `tbl_customer_porder_detail` ON `tbl_product`.`idtbl_product` = `tbl_customer_porder_detail`.`tbl_product_idtbl_product` 
         LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` 
         WHERE `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`= $recordID AND `tbl_customer_porder_detail`.`status`= 1";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());

    }
    public function Getorderqty(){
        $product = $_POST['product'];
        $orderid = $_POST['orderid'];

        $sql = "SELECT `qty`, `unitprice` FROM `tbl_customer_porder_detail` WHERE tbl_product_idtbl_product =? AND tbl_customer_porder_idtbl_customer_porder =?";
        $respond=$this->db->query($sql, array($product, $orderid));

        echo json_encode($respond->result());

    }

    public function Getbalanceqty(){

        $product = $_POST['product'];
        $orderid = $_POST['orderid'];

        $sql="SELECT tbl_customer_porder_detail.qty - SUM(tbl_production_orderdetail.qty) AS qtydiff FROM tbl_customer_porder_detail 
        INNER JOIN tbl_production_order ON tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=tbl_production_order.tbl_customer_porder_idtbl_customer_porder 
        INNER JOIN tbl_production_orderdetail ON tbl_production_order.idtbl_production_order=tbl_production_orderdetail.tbl_production_order_idtbl_production_order WHERE tbl_customer_porder_detail.tbl_product_idtbl_product=? and tbl_production_orderdetail.tbl_product_idtbl_product=? AND tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder=?";

        $respond=$this->db->query($sql, array($product, $product, $orderid));

        // print_r($this->db->last_query()); 

        echo json_encode($respond->result());

    }
    public function Porderinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyID=$_SESSION['companyid'];
        $companybranchID=$_SESSION['branchid'];

        $productlist=$this->input->post('productlist');
        $proqty=$this->input->post('proqty');
        $unitprice=$this->input->post('uprice');
        $procode=$this->input->post('procode');
        // $prodate=$this->input->post('prodate');
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $orderid=$this->input->post('orderid');
        $productcode = "00000";
        $newstring = substr($productcode, -4);

        $insertdatetime=date('Y-m-d H:i:s');
        $productiondate=date('Y-m-d H:i:s');

        $sqlnextno = "SELECT IFNULL(MAX(`procode`), 0) + 1 AS next_procode FROM `tbl_production_order` WHERE `tbl_company_idtbl_company`=?";
        $respondnextno=$this->db->query($sqlnextno, array($companyID));

        $data = array( 
            'procode'=> $respondnextno->row(0)->next_procode,
            'prodate'=> $productiondate,
            'prostartdate'=> $startdate, 
            'proenddate'=> $enddate, 
            'status'=> '1', 
            'insertdatetime'=> $insertdatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_customer_porder_idtbl_customer_porder'=> $orderid,
            'tbl_company_idtbl_company'=>$companyID,
            'tbl_company_branch_idtbl_company_branch'=>$companybranchID
        );

        $this->db->insert('tbl_production_order', $data);
        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        $data = array(
            'tbl_product_idtbl_product'=> $productlist, 
            'qty'=> $proqty, 
            'unitprice'=> $unitprice, 
            'total'=> $proqty * $unitprice, 
            'status'=> '1', 
            'insertdatetime'=> $insertdatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_production_order_idtbl_production_order'=> $insert_id,
        );

        $this->db->insert('tbl_production_orderdetail', $data);

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
            redirect('Customerporder');                
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
            redirect('Customerporder');
        }  

    }

    public function Customerporderedit(){
        $recordID = $this->input->post('recordID');
    
        $this->db->select('tbl_customer_porder.*, tbl_customer_porder_detail.*, tbl_order_type.*, tbl_customer.*, tbl_product.*');
        $this->db->from('tbl_customer_porder');
        $this->db->join('tbl_customer_porder_detail', 'tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', 'left');
        $this->db->join('tbl_order_type', 'tbl_order_type.idtbl_order_type = tbl_customer_porder.tbl_order_type_idtbl_order_type', 'left');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_customer_porder.tbl_customer_idtbl_customer', 'left');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product', 'left');
        $this->db->where('idtbl_customer_porder', $recordID);
        $this->db->where('tbl_customer_porder.status', 1);
    
        $respond = $this->db->get();
    
        $obj = new stdClass();
        $obj->id = $respond->row(0)->idtbl_customer_porder;
        $obj->orderdate = $respond->row(0)->orderdate;
        $obj->usd_rate = $respond->row(0)->usd_rate;
        $obj->duedate = $respond->row(0)->duedate;
        $obj->name = $respond->row(0)->idtbl_customer;
        $obj->type = $respond->row(0)->idtbl_order_type;
    
        $items = array();
        foreach ($respond->result() as $row) {
            $item = new stdClass();
            $item->productcode = $row->prodcutname.' - '.$row->productcode;
            $item->comment = $row->comment;
            $item->productID = $row->idtbl_product;
            $item->suggestprice = $row->suggestprice;
            $item->unitpriceusd = $row->unitpriceusd;
            $item->qty = $row->qty;
            $items[] = $item;
        }
        $obj->items = $items;
    
        echo json_encode($obj);
    }
}
