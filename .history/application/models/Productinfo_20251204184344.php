<?php
class Productinfo extends CI_Model{
    public function Productinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $materialcode='';

        $productname=$this->input->post('productname');
        $productcode=$this->input->post('productcode'); 
        $desc=$this->input->post('desc');  
        $weight=$this->input->post('weight');  
        $retailprice=$this->input->post('retailprice'); 
        $retailpriceusd=$this->input->post('retailpriceusd'); 
        $pktperctn=$this->input->post('pktperctn'); 
        $masterctn=$this->input->post('masterctn'); 

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        $imagePath = '';
        if (!empty($_FILES['productimage']['name'])) {

            $config['upload_path']   = FCPATH . 'images/ProductImg/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('productimage')) {
                $uploadData = $this->upload->data();
                $imagePath = 'images/ProductImg/' . $uploadData['file_name'];
            } else {
                echo $this->upload->display_errors();
                exit;
            }
        }

        if($recordOption==1){
            $data = array(
                'prodcutname'=> $productname, 
                'productcode'=> $productcode, 
                'productimg'=> $imagePath,
                'desc'=> $desc, 
                'weight'=> $weight, 
                'retailprice'=> $retailprice, 
                'retailpriceusd'=> $retailpriceusd, 
                'wholesaleprice'=> '0', 
                'nopckperctn'=> $pktperctn, 
                'mastercartoon'=> $masterctn, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_product', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Insert Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else{
            $data = array(
                'prodcutname'=> $productname, 
                'productcode'=> $productcode, 
                'desc'=> $desc, 
                'weight'=> $weight, 
                'retailprice'=> $retailprice, 
                'retailpriceusd'=> $retailpriceusd, 
                'wholesaleprice'=> '0', 
                'nopckperctn'=> $pktperctn, 
                'mastercartoon'=> $masterctn, 
                'updatedatetime'=> $updatedatetime, 
                'updateuser'=> $userID,
            );

            if($imagePath != ''){
                $data['productimg'] = $imagePath;
            }


            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);
 
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
        }
    }
    public function Stockupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $qty=$this->input->post('qty');
        $unitprice=$this->input->post('unitprice');
        $hideproductid=$this->input->post('hidestockproductid');
        $updatedatetime=date('Y-m-d H:i:s');  

        $batchno = date('dmY') . $hideproductid;

            $data = array(
                'fgbatchno'=> $batchno, 
                'qty'=> $qty, 
                'unitprice'=> $unitprice, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_product_idtbl_product'=> $hideproductid, 
                'tbl_location_idtbl_location'=> '1', 
                'tbl_company_idtbl_company'=> '1', 
                'tbl_company_branch_idtbl_company_branch'=> '1'
            );

            $this->db->insert('tbl_product_stock', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
    } 
    public function Productstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Product');                
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
                redirect('Product');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_product', $recordID);
            $this->db->update('tbl_product', $data);

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
                redirect('Product');                
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
                redirect('Product');
            }
        }
    }
    public function Productedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_product');
        $this->db->where('idtbl_product', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_product;
        $obj->prodcutname=$respond->row(0)->prodcutname;
        $obj->productcode=$respond->row(0)->productcode;
        $obj->desc=$respond->row(0)->desc;
        $obj->weight=$respond->row(0)->weight;
        $obj->retailprice=$respond->row(0)->retailprice;
        $obj->retailpriceusd=$respond->row(0)->retailpriceusd;
        $obj->nopckperctn=$respond->row(0)->nopckperctn;
        $obj->mastercartoon=$respond->row(0)->mastercartoon;

        echo json_encode($obj);
    }
    public function Finishgoodlupload(){
        $this->db->trans_begin();
        $i=0;

        $userID=$_SESSION['userid'];

		$filename=$_FILES['csvfile']['tmp_name'];
        $updatedatetime=date('Y-m-d h:i:s');

        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            if($i>0 && $line[0]!=''){
                $productname=$line[0];
                $productcode=$line[1]; 
                $desc=$line[2];  
                $weight=$line[3];  
                $retailprice=$line[04]; 
                $pktperctn=$line[5]; 
                $masterctn=$line[6];

                $data = array(
                    'prodcutname'=> $productname, 
                    'productcode'=> $productcode, 
                    'desc'=> $desc, 
                    'weight'=> $weight, 
                    'retailprice'=> $retailprice, 
                    'wholesaleprice'=> '0', 
                    'nopckperctn'=> $pktperctn, 
                    'mastercartoon'=> $masterctn, 
                    'status'=> '1', 
                    'insertdatetime'=> $updatedatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
    
                $this->db->insert('tbl_product', $data);
            }
            $i++;
        }
        fclose($file);

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
            
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Product');                
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
            redirect('Product');
        }
    }
    public function checkBarcode() {
        $barcode = $this->input->post('barcode');

        $this->db->select('barcode');
        $this->db->from('tbl_product');
        $this->db->where('barcode', $barcode);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
          $response = array('success' => true, 'message' => 'The barcode you entered exists in the database.!');
        } else {
          $response = array('success' => false);
        }
        echo json_encode($response);
    }
    public function Getproductinfo() {
        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT 
            `u`.`idtbl_product`,
            `ub`.`materialname`,
            `u`.`barcode`,
            `u`.`productcode`,
            `u`.`weight`,
            `u`.`retailprice`,
            `u`.`wholesaleprice`,
            `ub`.`materialcode`,
            `uc`.`formname`,
            `ud`.`gradename`,
            `ue`.`brandname`,
            `uf`.`sizename`,
            `ug`.`unittypecode`,
            `u`.`status`
        FROM 
            `tbl_product` AS `u`
            LEFT JOIN `tbl_material_code` AS `ub` ON `u`.`materialid` = `ub`.`idtbl_material_code` 
            LEFT JOIN `tbl_form` AS `uc` ON `u`.`formid` = `uc`.`idtbl_form`
            LEFT JOIN `tbl_grade` AS `ud` ON `u`.`gradeid` = `ud`.`idtbl_grade`
            LEFT JOIN `tbl_brand` AS `ue` ON `u`.`brandid` = `ue`.`idtbl_brand`
            LEFT JOIN `tbl_size` AS `uf` ON `u`.`sizeid` = `uf`.`idtbl_size`
            LEFT JOIN `tbl_unit_type` AS `ug` ON `u`.`typeid` = `ug`.`idtbl_unit_type` WHERE `u`.`idtbl_product`=?";

        $respond=$this->db->query($sql, array($recordID));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>
            		<label for="">Material Name : <span>&nbsp;'.$rowlist->materialname.'</span></label>
            	</li>
            	<li>
            		<label for="">Barcode : <span>&nbsp;'.$rowlist->barcode.'</span></label>
            	</li>
            	<li>
            		<label for="">FG Code : <span>&nbsp;'.$rowlist->productcode.'</span></label>
            	</li>
            	<li>
            		<label for="">Weight : <span>&nbsp;'.$rowlist->weight.'</span></label>
            	</li>
            	<li>
            		<label for="">Retail Price : <span>&nbsp;'.$rowlist->retailprice.'</span></label>
            	</li>
            	<li>
            		<label for="">Material Code : <span>&nbsp;'.$rowlist->materialcode.'</span></label>
            	</li>
            	<li>
            		<label for="">Form Code : <span>&nbsp;'.$rowlist->formname.'</span></label>
            	</li>
            	<li>
            		<label for="">Grade Code : <span>&nbsp;'.$rowlist->gradename.'</span></label>
            	</li>
            	<li>
            		<label for="">Brand Code : <span>&nbsp;'.$rowlist->brandname.'</span></label>
            	</li>
            	<li>
            		<label for="">Size Code : <span>&nbsp;'.$rowlist->sizename.'</span></label>
            	</li>
            	<li>
            		<label for="">Unit Type Code : <span>&nbsp;'.$rowlist->unittypecode.'</span></label>
            	</li>
            </ul>
            ';
        }

        echo $html;
    }

    public function ProductProfileModal()
    {
        $productid = $this->input->post('productid');

        // ✅ PRODUCT DATA
        $sqlproduct = "SELECT `idtbl_product`, `prodcutname`, `productcode`, `productimg`, 
                        `nopckperctn`, `mastercartoon`
                        FROM `tbl_product` 
                        WHERE `status` = ? AND `idtbl_product` = ?";
        $respondproduct = $this->db->query($sqlproduct, array(1, $productid))->row();

        // ✅ BOM DATA → ONLY LAST 3 ITEMS ✅✅✅
        $sqlbom = "SELECT 
                    `tbl_material_info`.`idtbl_material_info`,
                    `tbl_material_info`.`materialname`,
                    `tbl_product_bom`.`qty`,
                    `tbl_product_bom`.`wastage`
                FROM `tbl_product_bom`
                LEFT JOIN `tbl_material_info` 
                    ON `tbl_material_info`.`idtbl_material_info` = 
                    `tbl_product_bom`.`tbl_material_info_idtbl_material_info`
                WHERE `tbl_product_bom`.`status` = ? 
                AND `tbl_product_bom`.`tbl_product_idtbl_product` = ?
                ORDER BY `tbl_product_bom`.`idtbl_product_bom` DESC
                LIMIT 3";   // ✅✅✅ ONLY LAST 3 BOM ITEMS

        $respondbom = $this->db->query($sqlbom, array(1, $productid));

        $html = '';

        // ✅ HEADER
        $html .= '
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-4 border text-center p-2">
                    <img src="'.base_url().'uploads/'.$respondproduct->productimg.'" class="img-fluid mb-1">
                </div>
                <div class="col-md-8">
                    <h5 class="font-weight-bold">ITEM NAME : '.$respondproduct->prodcutname.'</h5>
                    <div>CODE : '.$respondproduct->productcode.'</div>
                </div>
            </div>
            <hr>
        ';

        // ✅ RAW MATERIALS CHART
        $html .= '
        <label class="badge badge-success mb-1">Raw Materials Chart (Last 3)</label>
        <table class="table table-bordered table-sm">
            <thead class="bg-warning">
                <tr>
                    <th>NAME</th>
                    <th>Supplier</th>
                    <th>Qty</th>
                    <th>Previous Cost</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($respondbom->result() as $rowbom) {

            // ✅ LAST 3 SUPPLIER PRICES
            $sqlsup = "SELECT `tbl_supplier`.`supname`, `tbl_material_suppliers`.`unitprice`
                    FROM `tbl_material_suppliers`
                    LEFT JOIN `tbl_supplier` 
                            ON `tbl_supplier`.`idtbl_supplier` = 
                            `tbl_material_suppliers`.`tbl_supplier_idtbl_supplier`
                    WHERE `tbl_material_suppliers`.`status` = ?
                    AND `tbl_material_suppliers`.`tbl_material_info_idtbl_material_info` = ?
                    ORDER BY `tbl_material_suppliers`.`idtbl_material_suppliers` DESC
                    LIMIT 3";

            $respondsup = $this->db->query($sqlsup, array(1, $rowbom->idtbl_material_info));

            $suppliers = '';
            $prices = '';

            foreach ($respondsup->result() as $rowsup) {
                $suppliers .= $rowsup->supname . '<br>';
                $prices .= number_format($rowsup->unitprice, 2) . '<br>';
            }

            $html .= '
                <tr>
                    <td>'.$rowbom->materialname.'</td>
                    <td>'.$suppliers.'</td>
                    <td>'.$rowbom->qty.'</td>
                    <td>'.$prices.'</td>
                </tr>
            ';
        }

        $html .= '
            </tbody>
        </table>
        ';

        // ✅ FINISHED GOOD ITEM DESCRIPTION
        $html .= '
        <label class="badge badge-success mb-1">Finished Good Item Description</label>
        <table class="table table-bordered table-sm">
            <tr>
                <th>Item Description</th>
                <th>No of Pkts Per Ctn</th>
                <th>Master Carton</th>
            </tr>
            <tr>
                <td>'.$respondproduct->prodcutname.'</td>
                <td>'.$respondproduct->nopckperctn.'</td>
                <td>'.$respondproduct->mastercartoon.'</td>
            </tr>
        </table>
        ';

        // ✅ ASSEMBLE (LAST 3)
        $html .= '
        <label class="badge badge-success mb-1">Assemble (Last 3)</label>
        <table class="table table-bordered table-sm">
            <thead class="bg-warning">
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Wastage</th>
                </tr>
            </thead>
            <tbody>
        ';

        foreach ($respondbom->result() as $rowbom) {
            $html .= '
                <tr>
                    <td>'.$rowbom->materialname.'</td>
                    <td>'.$rowbom->qty.'</td>
                    <td>'.$rowbom->wastage.'</td>
                </tr>
            ';
        }

        $html .= '
            </tbody>
        </table>
        ';

        // ✅ PREVIOUS SHIPMENT
        $html .= '
        <label class="badge badge-success mb-1">Previous Shipment Details</label>
        <table class="table table-bordered table-sm">
            <tr>
                <th>Item</th>
                <th>Inv No</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>'.$respondproduct->prodcutname.'</td>
                <td>-</td>
                <td>-</td>
            </tr>
        </table>
        </div>
        ';

        echo $html;
    }


}