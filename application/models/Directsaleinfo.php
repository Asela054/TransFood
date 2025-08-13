<?php
class Directsaleinfo extends CI_Model{
    public function Getmaterial(){
        $this->db->select('`idtbl_material_info`, `idtbl_material_code`, `materialname`');
        $this->db->from('tbl_material_info');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_material_info.tbl_material_code_idtbl_material_code', 'left');
        $this->db->join('tbl_material_category', 'tbl_material_category.idtbl_material_category = tbl_material_info.tbl_material_category_idtbl_material_category', 'left');
        $this->db->where('tbl_material_info.status', 1);
        $this->db->where('tbl_material_info.tbl_material_category_idtbl_material_category', 1);
        $this->db->group_by('tbl_material_code.idtbl_material_code');

        return $respond=$this->db->get();
    }

    public function Getlocation(){
        $this->db->select('`idtbl_location`, `location`');
        $this->db->from('tbl_location');
        $this->db->where('tbl_location.status', 1);

        return $respond=$this->db->get();
    }


    public function Getproductlist() {
        $html = '';
    
        $hiddenmaterialID = $this->input->post('categoryID');
        $locationType = $this->input->post('locationType');
    
        $sql = "SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`,  `tbl_product`.`barcode`, `tbl_product`.`retailprice`, `tbl_product`.`wholesaleprice` FROM `tbl_product` LEFT JOIN tbl_material_code ON tbl_material_code.idtbl_material_code = tbl_product.materialid WHERE `tbl_product`.`materialid` = $hiddenmaterialID AND `tbl_product`.`status` = 1";
        $respond = $this->db->query($sql);
    
        if ($respond->num_rows() > 0) {
            foreach ($respond->result() as $rowlist) {
                $productID = $rowlist->idtbl_product;
                $sqlstockcheck = "SELECT SUM(`qty`) AS sumqty FROM `tbl_product_stock` WHERE `tbl_product_idtbl_product`='$productID' AND `tbl_location_idtbl_location`='$locationType'  AND `qty` != '0'"; 
        
                $respondstockcheck = $this->db->query($sqlstockcheck);
        
                if (!empty($respondstockcheck->row(0)->sumqty)) {
                    $stockcount = $respondstockcheck->row(0)->sumqty;

                    $html .= '
                        <tr tabindex="0" class=' . ($stockcount == 0 ? 'table-danger' : 'pointer') . ' id="' . $rowlist->idtbl_product . '">
                            <td>' . $rowlist->idtbl_product . '</td>
                            <td>' . $rowlist->productcode . '</td>
                            <td>' . $rowlist->barcode . '</td>
                            <td>' . $stockcount . '</td>
                            <td class="text-right">' . $rowlist->retailprice . '</td>
                        </tr>';
                }
            }
        } else {
            $html .= '
                <tr>
                    <td colspan="3">No Product To Show</td>
                </tr>
            ';
        }
        echo $html;
    }
    

    public function Getproductlistaccobarcode(){

        $barcode=$this->input->post('barcode');

        $this->db->select('`tbl_product`.`idtbl_product`, `tbl_product`.`productcode`,  `tbl_product`.`barcode`, `tbl_product`.`retailprice`, `tbl_product`.`wholesaleprice`');
        $this->db->from('tbl_product');
        $this->db->join('tbl_material_code', 'tbl_material_code.idtbl_material_code = tbl_product.materialid', 'left');
        $this->db->where('tbl_product.barcode', $barcode);
        $this->db->where('tbl_product.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_product;
        $obj->productcode=$respond->row(0)->productcode;
        $obj->price=$respond->row(0)->retailprice ;
        $obj->barcode=$respond->row(0)->barcode;
        // $obj->wastage=$respond->row(0)->wastage;


        echo json_encode($obj);


    }


    public function Directsaleinsertupdate(){

        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $companyid=$_SESSION['companyid'];
        $branchid=$_SESSION['branchid'];

        $tableData=$this->input->post('tableData');
        $tableDataPay=$this->input->post('tableDataPay');
        $total=$this->input->post('total');
        $distotal=$this->input->post('distotal');
        $nettotal=$this->input->post('nettotal');
        $billtype=$this->input->post('billtype');
        $paytotal=$this->input->post('paytotal');
        $location=$this->input->post('locationID');
        $orderid=$this->input->post('orderid');

        $balance=$nettotal-$paytotal;

        $insertdatetime=date('Y-m-d H:i:s');
        $invdate=date('Y-m-d H:i:s');

        $sql = "SELECT MAX(`invno`) AS `count` FROM `tbl_invoice` WHERE `invno`> 0 AND `tbl_company_idtbl_company`='$companyid' AND `tbl_company_branch_idtbl_company_branch`='$branchid'";
        $respond = $this->db->query($sql);

        if ($respond->row(0)->count == 0) {
            $i = 1;
        } else {
            $i = $respond->row(0)->count + 1;
        }

        $data = array(
            'invno'=> $i,
            'invdate'=> $invdate, 
            'grosstotal'=> $total, 
            'discount'=> $distotal, 
            'nettotal'=> $nettotal, 
            'invtype'=> '2', 
            'paycomplete'=> '0', 
            'status'=> '1', 
            'insertdatetime'=> $insertdatetime, 
            'tbl_user_idtbl_user'=> $userID,
            'tbl_location_idtbl_location'=> $location,
            'tbl_customer_porder_idtbl_customer_porder'=> '637',
            'tbl_invoice_bank_idtbl_invoice_bank'=> '1',
            'tbl_company_idtbl_company'=> $companyid,
            'tbl_company_branch_idtbl_company_branch'=> $branchid
        );

        $this->db->insert('tbl_invoice', $data);

        $invoiceID=$this->db->insert_id();

        foreach($tableData as $rowtabledata){
            $data = array(
                'qty'=> $rowtabledata['col_2'], 
                'saleprice'=> $rowtabledata['col_3'], 
                'total'=> $rowtabledata['col_5'],  
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime,
                'tbl_invoice_idtbl_invoice'=> $invoiceID, 
                'tbl_product_idtbl_product'=> $rowtabledata['col_6']
            );

                $this->db->insert('tbl_invoice_detail', $data);

                $qtyToReduce = $rowtabledata['col_2'];

                $this->db->select('idtbl_product_stock, qty');
                $this->db->from('tbl_product_stock');
                $this->db->where('tbl_product_idtbl_product', $rowtabledata['col_6']);
                $this->db->where('tbl_location_idtbl_location', $location);
                $this->db->order_by('idtbl_product_stock', 'ASC');
                $respond2 = $this->db->get();
                $rows = $respond2->result_array();

                foreach ($rows as $row) {
                    $currentQty = $row['qty'];

                    if ($currentQty >= $qtyToReduce) {
                        $finalqty = $currentQty - $qtyToReduce;

                        $data2 = array(
                            'qty' => $finalqty,
                        );
                        $this->db->where('idtbl_product_stock', $row['idtbl_product_stock']);
                        $this->db->set($data2);
                        $this->db->update('tbl_product_stock');
                        
                        break;
                    } else {
                        $qtyToReduce -= $currentQty;

                        $data2 = array(
                            'qty' => 0,
                        );
                        $this->db->where('idtbl_product_stock', $row['idtbl_product_stock']);
                        $this->db->set($data2);
                        $this->db->update('tbl_product_stock');
                    }
                }
        }

        if($billtype==1){
            $data = array(
                'paydate'=> $invdate, 
                'nettotal'=> $paytotal, 
                'balance'=> $balance, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'tbl_location_idtbl_location'=> '1',
                'tbl_company_idtbl_company'=> $companyid,
                'tbl_company_branch_idtbl_company_branch'=> $branchid
            );
    
            $this->db->insert('tbl_invoice_payment', $data);

            $invoicepayID=$this->db->insert_id();

            foreach($tableDataPay as $rowtableDataPay){
                $dataone = array(
                    'method'=> $rowtableDataPay['col_1'], 
                    'amount'=> $rowtableDataPay['col_7'], 
                    'bank'=> $rowtableDataPay['col_3'],  
                    'branch'=> $rowtableDataPay['col_4'], 
                    'chequeno'=> $rowtableDataPay['col_5'], 
                    'chequedate'=> $rowtableDataPay['col_6'],  
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime,
                    'tbl_user_idtbl_user'=> $userID,
                    'tbl_invoice_payment_idtbl_invoice_payment'=> $invoicepayID, 
                );
    
                $this->db->insert('tbl_invoice_payment_detail', $dataone);

                $datatwo = array(
                    'tbl_invoice_payment_idtbl_invoice_payment'=> $invoicepayID, 
                    'tbl_invoice_idtbl_invoice'=> $invoiceID, 
                );
        
                $this->db->insert('tbl_invoice_payment_has_tbl_invoice', $datatwo);
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
            $obj->action=json_encode($actionObj);
            $obj->actiontype='1';
            $obj->invoiceid=$invoiceID;
            $obj->billtype=$billtype;
            // $obj->saletype=$salestype;  
            
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
            $obj->action=json_encode($actionObj);
            $obj->actiontype='0';
            $obj->invoiceid='0';
            $obj->billtype=$billtype;
            // $obj->saletype=$salestype; 
            
            echo json_encode($obj);
        }

    }

    public function Getproductavalaibleqty(){

        $product=$this->input->post('product');
        $inserted_qty=$this->input->post('qty');
        $location = $this->input->post('location');

        $this->db->select_sum('qty');
        $this->db->from('tbl_product_stock');
        $this->db->where('tbl_product_idtbl_product', $product);
        $this->db->where('tbl_location_idtbl_location', $location);
        $this->db->where('status', 1);
        $respond=$this->db->get();
        
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
}
