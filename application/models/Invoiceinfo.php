<?php
class Invoiceinfo extends CI_Model{
    public function locationlist(){
        $this->db->select('`idtbl_location, `location`');
        $this->db->from('tbl_location');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Invoiceinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData=$this->input->post('tableData');
        $total=$this->input->post('total');
        $distotal=$this->input->post('distotal');
        $nettotal=$this->input->post('nettotal');
        // $salestype=$this->input->post('salestype');
        $location=$this->input->post('location');
        $orderid=$this->input->post('orderid');

        $insertdatetime=date('Y-m-d H:i:s');
        $invdate=date('Y-m-d H:i:s');

        $data = array(
            'invdate'=> $invdate, 
            'grosstotal'=> $total, 
            'discount'=> $distotal, 
            'nettotal'=> $nettotal, 
            'invtype'=> '0', 
            'paycomplete'=> '0', 
            'status'=> '1', 
            'insertdatetime'=> $insertdatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_location_idtbl_location'=> $location,
            'tbl_customer_porder_idtbl_customer_porder'=> $orderid
        );

        $this->db->insert('tbl_invoice', $data);

        $invoiceID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $dataone = array(
                'qty'=> $rowtabledata['col_2'], 
                'saleprice'=> $rowtabledata['col_3'], 
                'total'=> $rowtabledata['col_5'],  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime,
                'tbl_invoice_idtbl_invoice'=> $invoiceID, 
                'tbl_product_idtbl_product'=> $rowtabledata['col_8']
            );

            $this->db->insert('tbl_invoice_detail', $dataone);

            $this->db->select('qty AS stockqty');
            $this->db->from('tbl_product_stock');
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_8']);
            
            $respond2 = $this->db->get();

            $previousqty = $respond2->row(0)->stockqty;


            $finalqty=$previousqty-$rowtabledata['col_2'];

            $data2 = array(
                'qty' => $finalqty,
            );
            
            $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_8']);
            $this->db->update('tbl_product_stock', array('qty' => $finalqty));
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

    public function Getporderviewtable(){
 
        $save=$this->input->post('save');
        $html='';
        
        if(isset($save)){
            $date=$this->input->post('date');

            $sql="SELECT `tbl_customer_porder`.`idtbl_customer_porder`, `tbl_customer_porder`.`orderdate`, `tbl_customer_porder_detail`.`qty`, `tbl_customer`.`name`, `tbl_order_type`.`type`
            FROM `tbl_customer_porder` LEFT JOIN `tbl_customer_porder_detail` ON `tbl_customer_porder`.`idtbl_customer_porder`=`tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` LEFT JOIN `tbl_customer` ON `tbl_customer`.`idtbl_customer`=`tbl_customer_porder`.`tbl_customer_idtbl_customer`
                    LEFT JOIN `tbl_order_type` ON `tbl_order_type`.`idtbl_order_type`=`tbl_customer_porder`.`tbl_order_type_idtbl_order_type` WHERE `tbl_customer_porder`.`duedate`=? AND `tbl_customer_porder`.`status` =? GROUP BY `tbl_customer_porder`.`idtbl_customer_porder`";
    
            $respond=$this->db->query($sql, array($date, 1));
    
    
            foreach($respond->result() as $rowlist){
                $html.='
                <tr>
                    <td>'.$rowlist->idtbl_customer_porder.'</td>
                    <td>'.$rowlist->orderdate.'</td>
                    <td>'.$rowlist->name.'</td>
                    <td>'.$rowlist->type.'</td>
                    <td>'.$rowlist->qty.'</td>
                    <td><button type="button" id="'.$rowlist->idtbl_customer_porder.'" class="btnInvoice btn btn-outline-success btn-sm float-center"><i class="fas fa-file-invoice-dollar"></i></button></td>
                 </tr>                
                ';
            }
    
            echo $html;

        }

    }

    public function Getorderdetails(){
 
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
    // $type=$this->input->post('saletypes');

     $this->db->select('tbl_product.*, tbl_material_code.materialname');
     $this->db->from('tbl_product');
     $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_product.materialid', 'left');
     $this->db->where('tbl_product.idtbl_product', $recordID);
     $this->db->where('tbl_product.status', 1);
     $respond=$this->db->get();

     $zero=000;
     
     $obj=new stdClass();
     $obj->id=$respond->row(0)->idtbl_product;
     $obj->code=$respond->row(0)->materialname.'-'.$respond->row(0)->productcode;
     $obj->saleprice=$respond->row(0)->retailprice;
    //  if($type == 1){
    //     $obj->saleprice=$respond->row(0)->retailprice;
    //  }elseif($type == 2){
    //     $obj->saleprice=$respond->row(0)->wholesaleprice;
    //  }else{
    //     $obj->saleprice=$respond->row(0)-> $zero;
    //  }
     echo json_encode($obj); 
    }

    public function Getproductavalaibleqty(){

            $product=$this->input->post('product');
            $inserted_qty=$this->input->post('qty');

            $this->db->select('qty');
            $this->db->from('tbl_product_stock');
            $this->db->where('tbl_product_idtbl_product', $product);
            $this->db->where('status', 1);
            $respond=$this->db->get();
            
            $availableqty=$respond->row(0)->qty;
        
            $obj=new stdClass();
            
            if($inserted_qty > $availableqty){
                $qtyresult = 1;
                
            }
            else{
                $qtyresult = 0;
            }
            $obj->checkqty = $qtyresult;

            echo json_encode($obj);

        }

}