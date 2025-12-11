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
    public function getItemCostReport() {
        $product_id = $this->input->post('product_id');
        $companyid = $_SESSION['companyid'];
        $branchid = $_SESSION['branchid'];
        
        $html = '';
        
        // 01. Get Product Information
        $sql_product = "SELECT `idtbl_product`, `prodcutname`, `productcode`, `productimg`, `desc`, `weight`, `retailprice`, `wholesaleprice`, `retailpriceusd`, `wholesalepriceusd`, `semistatus`, `nopckperctn`, `mastercartoon`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user` 
                        FROM `tbl_product` 
                        WHERE `idtbl_product` = ?";
        $product = $this->db->query($sql_product, array($product_id))->row();
        
        $html .= '<div class="card shadow-none mb-4">';
        $html .= '<div class="card-header bg-primary">';
        $html .= '<h4 class="mb-0 text-light"><strong>ITEM NAME: ' . $product->prodcutname . '</strong></h4>';
        $html .= '</div>';
        
        // Section 1: Raw Materials Chart
        $html .= '<div class="card-body">';
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<h5 class="border-bottom pb-2"><u>Raw Materials Chart</u></h5>';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered table-sm small">';
        $html .= '<thead class="thead-light">';
        $html .= '<tr>';
        $html .= '<th width="5%">No</th>';
        $html .= '<th width="25%">NAME</th>';
        $html .= '<th width="25%">Supplier Name</th>';
        $html .= '<th width="15%">Sizes</th>';
        $html .= '<th width="15%">Previous Cost</th>';
        $html .= '<th width="15%">Current Cost</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        // Get BOM information for this product
        $sql_bom = "SELECT pb.`idtbl_product_bom`, pb.`qty`, pb.`wastage`, 
                        mi.`materialname`, mi.`materialinfocode`, mi.`unitperctn`,
                        cat.`categoryname`, u.`unitcode`, pb.`tbl_material_info_idtbl_material_info`
                    FROM `tbl_product_bom` pb
                    LEFT JOIN `tbl_material_info` mi ON mi.`idtbl_material_info` = pb.`tbl_material_info_idtbl_material_info`
                    LEFT JOIN `tbl_material_category` cat ON cat.`idtbl_material_category` = mi.`tbl_material_category_idtbl_material_category`
                    LEFT JOIN `tbl_unit` u ON u.`idtbl_unit` = mi.`tbl_unit_idtbl_unit`
                    WHERE pb.`tbl_product_idtbl_product` = ? 
                    AND pb.`status` = 1";
        $bom_items = $this->db->query($sql_bom, array($product_id))->result();
        // print_r($this->db->last_query());
        $counter = 1;
        foreach($bom_items as $bom) {
            // Get suppliers for this material
            $sql_suppliers = "SELECT s.`suppliername`, ms.`unitprice`,
                                    gd.`costunitprice`, g.`grn_no`, g.`grndate`
                            FROM `tbl_material_suppliers` ms
                            LEFT JOIN `tbl_supplier` s ON s.`idtbl_supplier` = ms.`tbl_supplier_idtbl_supplier`
                            LEFT JOIN `tbl_grn` g ON g.`tbl_supplier_idtbl_supplier` = ms.`tbl_supplier_idtbl_supplier`
                            LEFT JOIN `tbl_grndetail` gd ON gd.`tbl_grn_idtbl_grn` = g.`idtbl_grn` 
                            AND gd.`tbl_material_info_idtbl_material_info` = ms.`tbl_material_info_idtbl_material_info`
                            WHERE ms.`tbl_material_info_idtbl_material_info` = ?
                            AND gd.`costunitprice` IS NOT NULL
                            ORDER BY g.`grndate` DESC
                            LIMIT 3";
            $suppliers = $this->db->query($sql_suppliers, array($bom->tbl_material_info_idtbl_material_info))->result();
             
            $html .= '<tr>';
            $html .= '<td rowspan="' . (count($suppliers) > 0 ? count($suppliers) : 1) . '">' . $counter . '.</td>';
            $html .= '<td rowspan="' . (count($suppliers) > 0 ? count($suppliers) : 1) . '">' . $bom->materialname . '</td>';
            
            if(count($suppliers) > 0) {
                $first = true;
                foreach($suppliers as $supplier) {
                    if(!$first) {
                        $html .= '<tr>';
                    }
                    $html .= '<td>' . $supplier->suppliername . '</td>';
                    $html .= '<td>' . $bom->unitperctn . ' ' . $bom->unitcode . '</td>';
                    $html .= '<td class="text-right">' . ($supplier->unitprice ? number_format($supplier->unitprice, 2) : '-') . '</td>';
                    $html .= '<td class="text-right">' . ($supplier->costunitprice ? number_format($supplier->costunitprice, 2) : '-') . '</td>';
                    if(!$first) {
                        $html .= '</tr>';
                    }
                    $first = false;
                }
            } else {
                $html .= '<td>-</td>';
                $html .= '<td>' . $bom->unitperctn . ' ' . $bom->unitcode . '</td>';
                $html .= '<td class="text-right">-</td>';
                $html .= '<td class="text-right">-</td>';
                $html .= '</tr>';
            }
            $counter++;
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Section 2: Finished Good Item Description
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<h5 class="border-bottom pb-2"><u>Finished Good Item Description</u></h5>';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered table-sm small">';
        $html .= '<thead class="thead-light">';
        $html .= '<tr>';
        $html .= '<th>Item Description</th>';
        $html .= '<th>No of Pkts Per Ctn</th>';
        $html .= '<th>Master Carton</th>';
        $html .= '<th>Weight</th>';
        $html .= '<th>Retail Price</th>';
        $html .= '<th>Wholesale Price</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>' . $product->prodcutname . '</td>';
        $html .= '<td>' . ($product->nopckperctn ?: '1X20') . '</td>';
        $html .= '<td>' . ($product->mastercartoon ?: '1MC') . '</td>';
        $html .= '<td>' . $product->weight . '</td>';
        $html .= '<td class="text-right">' . number_format($product->retailprice, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($product->wholesaleprice, 2) . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Section 3: Assemble 01 (BOM Cost for one unit)
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<h5 class="border-bottom pb-2"><u>Assemble 01</u></h5>';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered table-sm small">';
        $html .= '<thead class="thead-light">';
        $html .= '<tr>';
        $html .= '<th width="30%">Item Name</th>';
        $html .= '<th width="15%">Quantity</th>';
        $html .= '<th width="15%">Unit</th>';
        $html .= '<th width="20%">Cost</th>';
        $html .= '<th width="20%">Total Value</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        $total_assembly_cost = 0;
        foreach($bom_items as $bom) {
            // Get latest cost for this material
            $sql_latest_cost = "SELECT gd.`costunitprice`
                                FROM `tbl_grndetail` gd
                                LEFT JOIN `tbl_grn` g ON g.`idtbl_grn` = gd.`tbl_grn_idtbl_grn`
                                WHERE gd.`tbl_material_info_idtbl_material_info` = ?
                                AND gd.`costunitprice` IS NOT NULL
                                ORDER BY g.`grndate` DESC
                                LIMIT 1";
            $latest_cost = $this->db->query($sql_latest_cost, array($bom->tbl_material_info_idtbl_material_info))->row();
            
            $cost = $latest_cost ? $latest_cost->costunitprice : 0;
            $total_value = $cost * $bom->qty;
            $total_assembly_cost += $total_value;
            
            $html .= '<tr>';
            $html .= '<td>' . $bom->materialname . '</td>';
            $html .= '<td class="text-right">' . number_format($bom->qty, 2) . '</td>';
            $html .= '<td>' . $bom->unitcode . '</td>';
            $html .= '<td class="text-right">' . number_format($cost, 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($total_value, 2) . '</td>';
            $html .= '</tr>';
        }
        
        // Total row
        $html .= '<tr class="table-primary font-weight-bold">';
        $html .= '<td colspan="4" class="text-right">Total Assembly Cost</td>';
        $html .= '<td class="text-right">' . number_format($total_assembly_cost, 2) . '</td>';
        $html .= '</tr>';
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        
        // Section 4: Previous Shipment Details
        $html .= '<div class="row mb-4">';
        $html .= '<div class="col-12">';
        $html .= '<h5 class="border-bottom pb-2"><u>Previous Shipment Details</u></h5>';
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-bordered table-sm small">';
        $html .= '<thead class="thead-light">';
        $html .= '<tr>';
        $html .= '<th width="20%">Inv No</th>';
        $html .= '<th width="15%">Date</th>';
        $html .= '<th width="25%">Product</th>';
        $html .= '<th width="15%">Quantity</th>';
        $html .= '<th width="15%">Sale Price</th>';
        $html .= '<th width="15%">Total</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        // Get previous shipment/invoice details
        $sql_invoices = "SELECT i.`invno`, i.`invdate`, 
                                p.`prodcutname`,
                                id.`qty`, id.`saleprice`, id.`total`
                        FROM `tbl_invoice_detail` id
                        LEFT JOIN `tbl_invoice` i ON i.`idtbl_invoice` = id.`tbl_invoice_idtbl_invoice`
                        LEFT JOIN `tbl_product` p ON p.`idtbl_product` = id.`tbl_product_idtbl_product`
                        WHERE id.`tbl_product_idtbl_product` = ?
                        AND i.`status` = 1
                        ORDER BY i.`invdate` DESC
                        LIMIT 10";
        $invoices = $this->db->query($sql_invoices, array($product_id))->result();
        
        if(count($invoices) > 0) {
            foreach($invoices as $inv) {
                $html .= '<tr>';
                $html .= '<td>' . $inv->invno . '</td>';
                $html .= '<td>' . date('Y-m-d', strtotime($inv->invdate)) . '</td>';
                $html .= '<td>' . $inv->prodcutname . '</td>';
                $html .= '<td class="text-right">' . number_format($inv->qty, 2) . '</td>';
                $html .= '<td class="text-right">' . number_format($inv->saleprice, 2) . '</td>';
                $html .= '<td class="text-right">' . number_format($inv->total, 2) . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="6" class="text-center">No previous shipment records found</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        
        // Close all divs
        $html .= '</div>'; // card-body
        $html .= '</div>'; // card
        
        echo $html;
    }
}