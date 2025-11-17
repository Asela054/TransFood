<?php
class Productionpackingqualityinfo extends CI_Model{
    public function Productionpackqualityform(){

        $recordID=$this->input->post('recordID');

        $sqlmaterial = "SELECT `tbl_product`.`idtbl_product`, `tbl_product`.`productcode`
        FROM `tbl_product`
        LEFT JOIN `tbl_production_orderdetail` ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product`
        LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order`
        WHERE `tbl_product`.`status` = ? AND `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` = ? AND `tbl_product`.`idtbl_product` NOT IN (SELECT `tbl_product_idtbl_product` FROM `tbl_packing_quality` WHERE `status` = ? AND `tbl_production_order_idtbl_production_order` = ?)";
        $stmt = $this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));

        if ($stmt->num_rows() > 0) {
            $respondmaterial = $stmt->row();
            $productid = $respondmaterial->idtbl_product;
        } else {
            $productid = null;
        }


        $sqlbommaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondbommaterial=$this->db->query($sqlbommaterial, array($productid, 1, 1));

        $sqlpackmaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondpackmaterial=$this->db->query($sqlpackmaterial, array($productid, 1, 2));

        $sqllabelmaterial="SELECT `tbl_product_bom`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`materialname`, `tbl_unit`.`unitcode`, `tbl_product_bom`.`wastage`  FROM `tbl_product_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_product_bom`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_category` ON `tbl_material_category`.`idtbl_material_category`=`tbl_material_info`.`tbl_material_category_idtbl_material_category` LEFT JOIN `tbl_unit` ON `tbl_unit`.`idtbl_unit`=`tbl_material_info`.`tbl_unit_idtbl_unit` WHERE `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`status`=? AND `tbl_material_category`.`idtbl_material_category`=?";
        $respondlabelmaterial=$this->db->query($sqllabelmaterial, array($productid, 1, 3));

        $html='';

        $html='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">Product</label>
                <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                    <option value="">Select</option>';
                    foreach($stmt->result() AS $rowmateriallist){
                        $html.='<option value="'.$rowmateriallist->idtbl_product.'">'.$rowmateriallist->productcode.'</option>';
                    }
                $html.='</select>
            </div>
        </div>
        ';
        $html.='
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                <input type="text" name="exqty" id="exqty" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">NET WEIGHT</label>
                <input type="text" name="netweight" id="netweight" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GROSS WEIGHT</label>
                <input type="text" name="grossweight" id="grossweight" class="form-control form-control-sm">
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">RAW MATERIAL</label>
                ';
                foreach($respondbommaterial->result() as $rowrawmateriallist){
                $html.='
                <input type="text" name="adultering" id="adultering" class="form-control form-control-sm"
                    value="'.$rowrawmateriallist->materialinfocode.'" readonly>
                ';
                }
                $html.='
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">PACKING MATERIAL</label>
                ';
                foreach($respondpackmaterial->result() as $rowpackmateriallist){
                $html.='
                <input type="text" name="adultering" id="adultering" class="form-control form-control-sm"
                    value="'.$rowpackmateriallist->materialinfocode.'" readonly>
                ';
                }
                $html.='
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">Labelling MATERIAL</label>
                ';
                foreach($respondlabelmaterial->result() as $rowlabelmateriallist){
                $html.='
                <input type="text" name="adultering" id="adultering" class="form-control form-control-sm"
                    value="'.$rowlabelmateriallist->materialinfocode.'" readonly>
                ';
                }
                $html.='
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">MOISTURE%</label>
                <input type="text" name="moisture" id="moisture" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">COLOR</label>
                <input type="text" name="color" id="color" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">TASTE</label>
                <input type="text" name="taste" id="taste" class="form-control form-control-sm">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">SEAL</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="seal1" name="seal" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="seal1">YES</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="seal2" name="seal" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="seal2">NO</label>
                </div>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">WATER LEAKAGES</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="leak1" name="leakages" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="leak1">YES</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="leak22" name="leakages" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="leak22">NO</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">PASS/FAIL</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail1" name="qualityform" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail1">PASS</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail2" name="qualityform" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfail2">FAIL</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">COMMENTS</label>
                <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
            </div>
        </div>

        ';

        echo $html;
    }

    public function Productionpackqualityinsertupdate(){

        $hideproductionmaterial=$this->input->post('hideproductionmaterial');
        $examinedqty=$this->input->post('exqty');
        $netweight=$this->input->post('netweight');
        $grossweight=$this->input->post('grossweight');
        $moisture=$this->input->post('moisture');
        $color=$this->input->post('color');
        $taste=$this->input->post('taste');
        $size=$this->input->post('size');
        $seal=$this->input->post('seal');
        $leakages=$this->input->post('leakages');
        $statuspassfail=$this->input->post('qualityform');
        $comments=$this->input->post('comment');
        $materialinfo=$this->input->post('materialinfo');


        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

            $data = array(
                'examined_quantity'=> $examinedqty, 
                'net_weight'=> $netweight, 
                'gross_weight'=> $grossweight, 
                'moisture'=> $moisture, 
                'color'=> $color, 
                'taste'=> $taste, 
                'seal'=> $seal, 
                'water_leakages'=> $leakages, 
                'statuspassfail'=> $statuspassfail, 
                'comments'=> $comments, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime,
                'tbl_user_idtbl_user'=> $userID,
                'tbl_production_order_idtbl_production_order'=> $hideproductionmaterial,
                'tbl_product_idtbl_product'=> $materialinfo,
            );

            $this->db->insert('tbl_packing_quality', $data);

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

    public function Semiproductiondetails(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_production_order`.`idtbl_production_order`,`tbl_product`.`idtbl_product`, `tbl_product`.`productcode` FROM `tbl_product` LEFT JOIN `tbl_production_orderdetail` ON `tbl_product`.`idtbl_product` = `tbl_production_orderdetail`.`tbl_product_idtbl_product`LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order` = `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` WHERE `tbl_product`.`status`=? AND `tbl_production_orderdetail`.`tbl_production_order_idtbl_production_order` = ?";
        $respond=$this->db->query($sql, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->productcode.'</td>
                    
                    <td class="text-right">
                    <a href="' . base_url() . 'Productionpackingquality/Productionpackingqualityreport/' . $rowcotlist->idtbl_production_order .'"
                    class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>
                        <button type="button" id="' . $rowcotlist->idtbl_production_order . '"
                            class="btnViewqualityinfo btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#exampleModal">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            ';
        }
        $html.='</tbody></table>';

        echo $html;
    }

    public function Getqualityviewdescription(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_packing_quality`.`statuspassfail`) As descstatus, IFNULL(`tblel1`.`cs`, `tbl_packing_quality`.`seal`) As descstatus1, IFNULL(`tblel2`.`es`, `tbl_packing_quality`.`water_leakages`) As descstatus2, `idtbl_packing_quality`, `examined_quantity`, `net_weight`, `gross_weight`, `moisture`, `color`, `taste`, `seal`, `water_leakages`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_production_order_idtbl_production_order`, `tbl_product_idtbl_product` FROM `tbl_packing_quality` LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_packing_quality`.`statuspassfail`=`tblel`.`type`) LEFT JOIN(SELECT 1 AS type, 'YES' AS cs, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS cs, 2 As el) As tblel1 ON (`tbl_packing_quality`.`seal`=`tblel1`.`type`) LEFT JOIN(SELECT 1 AS type, 'YES' AS es, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS es, 2 As el) As tblel2 ON (`tbl_packing_quality`.`water_leakages`=`tblel2`.`type`) WHERE `tbl_production_order_idtbl_production_order`=? AND `status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>

            		<label for="">EXAMINED QTY : <span>&nbsp;'.$rowlist->examined_quantity.'</span></label>
            	</li>
            	<li>
            		<label for="">NET WEIGHT : <span>&nbsp;'.$rowlist->net_weight.'</span></label>
            	</li>
            	<li>
            		<label for="">GROSS WEIGHT : <span>&nbsp;'.$rowlist->gross_weight.'</span></label>
            	</li>
            	<li>
            		<label for="">MOISTURE% : <span>&nbsp;'.$rowlist->moisture.'</span></label>
            	</li>
            	<li>
            		<label for="">COLOR : <span>&nbsp;'.$rowlist->color.'</span></label>
            	</li>
            	<li>
            		<label for="">TASTE : <span>&nbsp;'.$rowlist->taste.'</span></label>
            	</li>
                <li>
                	<label for="">SEAL : <span>&nbsp;'.$rowlist->descstatus1.'</span></label>
                </li>
                <li>
                	<label for="">WATER LEAKAGES : <span>&nbsp;'.$rowlist->descstatus2.'</span></label>
                </li>
            	<li>
            		<label for="">PASS/FAIL : <span>&nbsp;'.$rowlist->descstatus.'</span></label>
            	</li>
            	<li>
            		<label for="">COMMENT : <span>&nbsp;'.$rowlist->comments.'</span></label>
            	</li>
            </ul>

            
            ';
        }

        echo $html;
    }

    public function Editproductionqualityinfo(){
        $recordID=$this->input->post('recordID');

        $updatesql="SELECT `idtbl_packing_quality`, `examined_quantity`, `net_weight`, `gross_weight`, `moisture`, `color`, `taste`, `seal`, `water_leakages`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_production_order_idtbl_production_order`, `tbl_product_idtbl_product` FROM `tbl_packing_quality` WHERE `tbl_production_order_idtbl_production_order`=? AND `tbl_packing_quality`.`status`=?";
        $updaterespond=$this->db->query($updatesql, array($recordID, 1));

        $html = '';

        foreach($updaterespond->result() as $rowupdatequalitylist){
            $html.='
            <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                <input type="text" name="exqty" id="exqty" class="form-control form-control-sm" value="'.$rowupdatequalitylist->examined_quantity.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">NET WEIGHT</label>
                <input type="text" name="netweight" id="netweight" class="form-control form-control-sm" value="'.$rowupdatequalitylist->net_weight.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">GROSS WEIGHT</label>
                <input type="text" name="grossweight" id="grossweight" class="form-control form-control-sm" value="'.$rowupdatequalitylist->gross_weight.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">MOISTURE%</label>
                <input type="text" name="moisture" id="moisture" class="form-control form-control-sm" value="'.$rowupdatequalitylist->moisture.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">COLOR</label>
                <input type="text" name="color" id="color" class="form-control form-control-sm" value="'.$rowupdatequalitylist->color.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">TASTE</label>
                <input type="text" name="taste" id="taste" class="form-control form-control-sm" value="'.$rowupdatequalitylist->taste.'">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">SEAL</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="seal1" name="seal" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="seal1">YES</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="seal2" name="seal" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="seal2">NO</label>
                </div>
            </div>
            <div class="col">
                <label class="small font-weight-bold text-dark">WATER LEAKAGES</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="leak1" name="leakages" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="leak1">YES</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="leak22" name="leakages" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="leak22">NO</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">PASS/FAIL</label><br>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail1" name="qualityform" class="custom-control-input" value="1">
                    <label class="custom-control-label" for="passfail1">PASS</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="passfail2" name="qualityform" class="custom-control-input" value="0" checked>
                    <label class="custom-control-label" for="passfail2">FAIL</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label class="small font-weight-bold text-dark">COMMENTS</label>
                <textarea name="comment" id="comment" class="form-control form-control-sm" value="'.$rowupdatequalitylist->comments.'"></textarea>
            </div>
        </div>
    
                 
                    ';
            }
            echo $html;
    }

    public function Newproductioninqualitysertupdate(){
        $this->db->trans_begin();

        $editedproductionid=$this->input->post('editedproductionid');
        $examinedqty=$this->input->post('exqty');
        $netweight=$this->input->post('netweight');
        $grossweight=$this->input->post('grossweight');
        $moisture=$this->input->post('moisture');
        $color=$this->input->post('color');
        $taste=$this->input->post('taste');
        $size=$this->input->post('size');
        $seal=$this->input->post('seal');
        $leakages=$this->input->post('leakages');
        $statuspassfail=$this->input->post('qualityform');
        $comments=$this->input->post('comment');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');


        $data = array( 
            'examined_quantity'=> $examinedqty, 
            'net_weight'=> $netweight, 
            'gross_weight'=> $grossweight, 
            'moisture'=> $moisture, 
            'color'=> $color, 
            'taste'=> $taste, 
            'seal'=> $seal, 
            'water_leakages'=> $leakages, 
            'statuspassfail'=> $statuspassfail, 
            'comments'=> $comments, 
            'updatedatetime'=> $updatedatetime,
            'updateuser'=> $userID

        );
        $this->db->where('tbl_production_order_idtbl_production_order', $editedproductionid);
        $respond = $this->db->update('tbl_packing_quality', $data);


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
}