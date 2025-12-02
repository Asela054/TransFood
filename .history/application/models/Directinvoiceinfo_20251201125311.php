<?php
class Directinvoiceinfo extends CI_Model{
    public function locationlist(){
        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function banklist(){
        $this->db->select('`idtbl_invoice_bank, `bank_name`, `bank_branch`, `account_no`');
        $this->db->from('tbl_invoice_bank');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Invoiceinsertupdate(){
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];
    
        $tableData = $this->input->post('tableData');
        $total = $this->input->post('total');
        $distotal = $this->input->post('distotal');
        $nettotal = $this->input->post('nettotal');
        $location = $this->input->post('location');
        $bank = $this->input->post('bank');
        $batchlist = $this->input->post('batchlist');
        $orderid = $this->input->post('orderid');
        $hiddenbatchid = $this->input->post('hiddenbatchid');
    
        $insertdatetime = date('Y-m-d H:i:s');
        $invdate = date('Y-m-d H:i:s');

        $sql = "SELECT MAX(`invno`) AS `count` FROM `tbl_invoice` WHERE `invno`> 0 AND `tbl_company_idtbl_company`='$companyid' AND `tbl_company_branch_idtbl_company_branch`='$branchid'";
        $respond = $this->db->query($sql);

        if ($respond->row(0)->count == 0) {
            $i = 1;
        } else {
            $i = $respond->row(0)->count + 1;
        }
    
        $data = array(
            'invno'=> $i,
            'invdate' => $invdate,
            'grosstotal' => $total,
            'discount' => $distotal,
            'nettotal' => $nettotal,
            'invtype' => '1',
            'paycomplete' => '0',
            'status' => '1',
            'insertdatetime' => $insertdatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_location_idtbl_location' => $location,
            'tbl_customer_porder_idtbl_customer_porder' => $orderid,
            'tbl_invoice_bank_idtbl_invoice_bank' => $bank,
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid

        );
    
        $this->db->insert('tbl_invoice', $data);
    
        $invoiceID = $this->db->insert_id();
    
        foreach ($tableData as $rowtabledata) {
            $batchnos = explode(',', $rowtabledata['col_2']);

            $totalQty = $rowtabledata['col_3'];
    
            $dataone = array(
                'batchno' => $rowtabledata['col_2'],
                'qty' => $rowtabledata['col_3'],
                'saleprice' => $rowtabledata['col_4'],
                'total' => $rowtabledata['col_6'],
                'status' => '1',
                'insertdatetime' => $insertdatetime,
                'tbl_invoice_idtbl_invoice' => $invoiceID,
                'tbl_product_idtbl_product' => $rowtabledata['col_9']
            );
    
            $this->db->insert('tbl_invoice_detail', $dataone);
    
            $this->db->select('qty, fgbatchno');
            $this->db->from('tbl_product_stock');
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_9']);
            $this->db->where('tbl_location_idtbl_location', $location);
            $this->db->where_in('fgbatchno', $batchnos);
    
            $query = $this->db->get();

            $orderqty = $totalQty;
    
            foreach ($query->result() as $rowstocklist) {
                if ($orderqty > 0) {
                    $batchno = $rowstocklist->fgbatchno;
                    $availableqty = $rowstocklist->qty;
    
                    if ($availableqty >= $orderqty) {
    
                        $dedqty = $orderqty;
                        $availableqty -= $dedqty;
                        $orderqty = 0;
                    } else {
                        $dedqty = $availableqty;
                        $orderqty -= $dedqty;
                        $availableqty = 0;
                    }
    
                $data2 = array(
                    'qty' => $availableqty,
                    'updateuser' => $userID,
                    'updatedatetime' => $insertdatetime,
                );
    
                $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_9']);
                $this->db->where('tbl_location_idtbl_location', $location);
                $this->db->where('fgbatchno', $batchno);
                $this->db->set($data2);
                $this->db->update('tbl_product_stock');
                if ($orderqty == 0) {
                    break; 
                }
            } else {
                break;
            }
        }
        
                $data = array(
                    'paydate' => $invdate,
                    'nettotal' => $nettotal,
                    'balance' => '0',
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_location_idtbl_location' => $location,
                    'tbl_company_idtbl_company'=> $companyid,
                    'tbl_company_branch_idtbl_company_branch'=> $branchid
                );
        
                $this->db->insert('tbl_invoice_payment', $data);
        
                $invoicepayID = $this->db->insert_id();
        
                $dataone = array(
                    'method' => '1',
                    'amount' => '0',
                    'bank' => '0',
                    'branch' => '0',
                    'chequeno' => '0',
                    'chequedate' => '0',
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_invoice_payment_idtbl_invoice_payment' => $invoicepayID,
                );
        
                $this->db->insert('tbl_invoice_payment_detail', $dataone);
        
                $datatwo = array(
                    'tbl_invoice_payment_idtbl_invoice_payment' => $invoicepayID,
                    'tbl_invoice_idtbl_invoice' => $invoiceID,
                );
        
                $this->db->insert('tbl_invoice_payment_has_tbl_invoice', $datatwo);
            }
        
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
        
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-exclamation-triangle';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            } else {
                $this->db->trans_commit();
        
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Record Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';
        
                $actionJSON = json_encode($actionObj);
        
                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;
        
                echo json_encode($obj);
            }
    }

    public function Getorderdetails(){
 
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer`.`name`, `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_product`.`prodcutname`
        FROM `tbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_porder`.`tbl_customer_idtbl_customer`
        LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` 
        LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_customer_porder_detail`.`tbl_product_idtbl_product`
        WHERE `tbl_customer_porder`.`idtbl_customer_porder`=? AND `tbl_customer_porder`.`status` =? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_invoice_detail` LEFT JOIN `tbl_invoice` ON `tbl_invoice`.`idtbl_invoice`=`tbl_invoice_detail`.`tbl_invoice_idtbl_invoice` WHERE `tbl_invoice_detail`.`status`=? AND `tbl_invoice`.`tbl_customer_porder_idtbl_customer_porder`=?)";
        $respond=$this->db->query($sql, array($recordID, 1, 1, $recordID));

        echo json_encode($respond->result());

    }

    public function Getorderdetailsnoninvoice(){
 
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer`.`name`, `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_material_code`.`materialname`
        FROM `tbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_porder`.`tbl_customer_idtbl_customer`
        LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` 
        LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_customer_porder_detail`.`tbl_product_idtbl_product`
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid`
        WHERE `tbl_customer_porder`.`idtbl_customer_porder`=? AND `tbl_customer_porder`.`status` =?";
        $respond=$this->db->query($sql, array($recordID, 1));

        echo json_encode($respond->result());

    }

    public function Getproductdetails(){

    $recordID=$this->input->post('recordID');

     $this->db->select('tbl_product.*');
     $this->db->from('tbl_product');
     $this->db->where('tbl_product.idtbl_product', $recordID);
     $this->db->where('tbl_product.status', 1);
     $this->db->where('tbl_product.status', 1);
     $this->db->where('tbl_product.status', 1);
     $respond=$this->db->get();

     $zero=000;
     
     $obj=new stdClass();
     $obj->id=$respond->row(0)->idtbl_product;
     $obj->code=$respond->row(0)->productname.'-'.$respond->row(0)->productcode;
     $obj->saleprice=$respond->row(0)->retailprice;

     echo json_encode($obj); 
    }

    public function Getproductdetailsnoninvoice(){

        $recordID=$this->input->post('recordID');

    
         $this->db->select('tbl_product.*, tbl_material_code.materialname');
         $this->db->from('tbl_product');
         $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_product.materialid', 'left');
         $this->db->where('tbl_product.idtbl_product', $recordID);
         $this->db->where('tbl_product.status', 1);
         $respond=$this->db->get();

        //  echo $this->db->last_query();
    
         $zero=000;
         
         $obj=new stdClass();
         $obj->id=$respond->row(0)->idtbl_product;
         $obj->code=$respond->row(0)->materialname.'-'.$respond->row(0)->productcode;
         $obj->saleprice=$respond->row(0)->retailprice;
    
         echo json_encode($obj); 
        }

    public function Getorderqty(){

        $recordID=$this->input->post('recordID');
        $orderid=$this->input->post('orderid');
    
         $this->db->select('tbl_customer_porder_detail.qty,tbl_customer_porder_detail.suggestprice,tbl_customer_porder_detail.unitpriceusd');
         $this->db->from('tbl_customer_porder_detail');
         $this->db->join('tbl_customer_porder', 'tbl_customer_porder.idtbl_customer_porder = tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', 'left');
         $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_customer_porder_detail.tbl_product_idtbl_product', 'left');
         $this->db->where('tbl_product.idtbl_product', $recordID);
         $this->db->where('tbl_customer_porder.idtbl_customer_porder', $orderid);
         $this->db->where('tbl_product.status', 1);
         $respond=$this->db->get();
    
         $zero=000;
         
         $obj=new stdClass();
         $obj->orderqty=$respond->row(0)->qty;
         $obj->saleprice=$respond->row(0)->suggestprice;
         $obj->unitpriceusd=$respond->row(0)->unitpriceusd;
    
         echo json_encode($obj); 
        }

        public function Getbatchlist(){
            $productId = $this->input->post('productId');
            $fromlocation = $this->input->post('fromlocation');
            $companyid=$_SESSION['companyid'];
            $branchid=$_SESSION['branchid'];
        
            $sql="SELECT `idtbl_product_stock`, `fgbatchno`, `qty` FROM `tbl_product_stock`  WHERE `tbl_product_stock`.`tbl_product_idtbl_product`=? AND `tbl_product_stock`.`status`=? AND `tbl_product_stock`.`tbl_location_idtbl_location`=? AND `tbl_product_stock`.`tbl_company_idtbl_company`= ? AND `tbl_product_stock`.`tbl_company_branch_idtbl_company_branch`=? AND `tbl_product_stock`.`qty` > 0";
            $respond=$this->db->query($sql, array($productId, 1, $fromlocation, $companyid, $branchid));
        
            echo json_encode($respond->result());
        }


        public function Getorderqtynoninvoice(){

            $recordID=$this->input->post('recordID');
            $orderid=$this->input->post('orderid');
        
             $this->db->select('tbl_customer_porder_detail.qty');
             $this->db->from('tbl_customer_porder_detail');
             $this->db->where('tbl_customer_porder_detail.tbl_product_idtbl_product', $recordID);
             $this->db->where('tbl_customer_porder_detail.tbl_customer_porder_idtbl_customer_porder', $orderid);
             $this->db->where('tbl_customer_porder_detail.status', 1);
             $respond=$this->db->get();
        
             $zero=000;
             
             $obj=new stdClass();
             $obj->orderqty=$respond->row(0)->qty;
        
             echo json_encode($obj); 
            }

            public function Getproductavalaibleqty() {
                $product = $this->input->post('product');
                $inserted_qty = $this->input->post('qty');
                $location = $this->input->post('location');
            
                $this->db->select_sum('qty');
                $this->db->from('tbl_product_stock');
                $this->db->where('tbl_product_idtbl_product', $product);
                $this->db->where('tbl_location_idtbl_location', $location);
                $this->db->where('status', 1);
                $respond = $this->db->get();
            
                $availableqty = 0; // Set default available quantity to 0
            
                if ($respond->num_rows() > 0) {
                    $result = $respond->row();
                    $availableqty = $result->qty;
                }
            
                $obj = new stdClass();
                if ($inserted_qty > $availableqty) {
                    $qtyresult = 1;
                } else {
                    $qtyresult = 0;
                }
                $obj->checkqty = $qtyresult;
                echo json_encode($obj);
            }

            public function Completestatusupdate($x, $y){
                $this->db->trans_begin();

                $userID=$_SESSION['userid'];
                $recordID=$x;
                $type=$y;
                $updatedatetime=date('Y-m-d H:i:s');

                if($type==1){
                    $data = array(
                        'completestatus' => '1',
                        'updateuser'=> $userID, 
                        'updatedatetime'=> $updatedatetime
                    );

                    $this->db->where('idtbl_customer_porder', $recordID);
                    $this->db->set($data);
                    $this->db->update('tbl_customer_porder');

                    $this->db->trans_complete();

                    if ($this->db->trans_status() === TRUE) {
                        $this->db->trans_commit();
                        
                        $actionObj=new stdClass();
                        $actionObj->icon='fas fa-check';
                        $actionObj->title='';
                        $actionObj->message='Record Lock Successfully';
                        $actionObj->url='';
                        $actionObj->target='_blank';
                        $actionObj->type='success';

                        $actionJSON=json_encode($actionObj);
                        
                        $this->session->set_flashdata('msg', $actionJSON);
                        redirect('Directinvoice');                
                    } 
                }

            }
}



