<?php
class Semiproductionqualityinfo extends CI_Model{
    public function Productionpackqualityform()
    {
        $recordID = $this->input->post('recordID');
    
        $sqlmaterial = "SELECT `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname`
        FROM `tbl_semi_production`
        LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_production`.`tbl_material_info_idtbl_material_info`
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code`
        WHERE `tbl_semi_production`.`status` = ? AND `tbl_semi_production`.`idtbl_semi_production` = ? 
        AND `tbl_material_info`.`idtbl_material_info` NOT IN (SELECT `tbl_material_info_idtbl_material_info` FROM `tbl_production_quality` WHERE `status` = ? AND `tbl_semi_production_idtbl_semi_production` = ?)";
        $respondmaterial = $this->db->query($sqlmaterial, array(1, $recordID, 1, $recordID));
    
        $sqlmachine = "SELECT `tbl_machine`.`idtbl_machine`, `tbl_machine`.`machine` FROM `tbl_machine_allocation` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_machine_allocation`.`tbl_machine_idtbl_machine` WHERE `tbl_machine_allocation`.`tbl_semi_production_idtbl_semi_production` = ?";
        $respondmachine = $this->db->query($sqlmachine, array($recordID));
    
        $html = '';
    
        $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">Material</label>
                    <select name="materialinfo" id="materialinfo" class="form-control form-control-sm">
                        <option value="">Select</option>';
                        foreach ($respondmaterial->result() as $rowmateriallist) {
                            $html .= '<option value="'.$rowmateriallist->idtbl_material_info.'">'.$rowmateriallist->materialname.' - '.$rowmateriallist->materialinfocode.'</option>';
                        }
                    $html .= '</select>
                </div>
            </div>
        ';
    
        $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                    <input type="text" name="exqty" id="exqty" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">WASHING TEMPERATURE</label>
                    <input type="text" name="washtemp" id="washtemp" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">WASHING TIME</label>
                    <input type="text" name="washtime" id="washtime" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING TEMPERATURE</label>
                    <input type="text" name="drytemp" id="drytemp" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING TIME</label>
                    <input type="text" name="drytime" id="drytime" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">AFTRER DRYING MOISTURE %</label>
                    <input type="text" name="afterdrymoisture" id="afterdrymoisture" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING - COOLING TIME</label>
                    <input type="text" name="drycoolingtime" id="drycoolingtime" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
            	<div class="col">
            		<label class="small font-weight-bold text-dark">CUT SIZE</label>
            		<input type="text" name="cutsize" id="cutsize" class="form-control form-control-sm">
            	</div>
            </div>
            <div class="form-row">
            	<div class="col">
            		<label class="small font-weight-bold text-dark">CUTTING WASTAGE %</label>
            		<input type="text" name="cutwastage" id="cutwastage" class="form-control form-control-sm">
            	</div>
            </div>
        ';
    
        foreach ($respondmachine->result() as $rowmachinelist) {
            $html .= '
            <div class="form-row">
            	<div class="col">
            		<label class="small font-weight-bold text-dark">MACHINES</label>
            		<input type="text" name="machine_id[]" id="machine_' . $rowmachinelist->idtbl_machine . '"
            			class="form-control form-control-sm" value="' . $rowmachinelist->idtbl_machine .'-'. $rowmachinelist->machine. '" readonly>
            	</div>
            	<div class="col">
            		<label class="small font-weight-bold text-dark">MESH SIZE</label>
            		<input type="text" name="mesh_size[]" id="mesh_size_' . $rowmachinelist->idtbl_machine . '"
            			class="form-control form-control-sm">
            	</div>
            	<div class="col">
            		<label class="small font-weight-bold text-dark">WASTAGE</label>
            		<input type="text" name="wastage[]" id="wastage_' . $rowmachinelist->idtbl_machine . '"
            			class="form-control form-control-sm">
            	</div>
            </div>
            ';
        }
    
        $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">MOISTURE % (AFTER GRINDING)</label>
                    <input type="text" name="moisture_after_grinding" id="moisture_after_grinding" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING TEMPERATURE</label>
                    <input type="text" name="roasting_temperature" id="roasting_temperature" class="form-control form-control-sm">
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING COLOR</label>
                    <input type="text" name="roasting_color" id="roasting_color" class="form-control form-control-sm">
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING TIME</label>
                    <input type="text" name="roasting_time" id="roasting_time" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COOLING MOISTURE %</label>
                    <input type="text" name="cooling_moisture" id="cooling_moisture" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COOLING TIME</label>
                    <input type="text" name="cooling_time" id="cooling_time" class="form-control form-control-sm">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">MAGNET VERIFICATION</label><br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="passfail1" name="magnet_verification" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="passfail1">YES</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="passfail2" name="magnet_verification" class="custom-control-input" value="0" checked>
                        <label class="custom-control-label" for="passfail2">NO</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COMMENTS</label>
                    <textarea name="comments" id="comments" class="form-control form-control-sm"></textarea>
                </div>
            </div>
        ';
    
        echo $html;
    }
    


    public function Productionpackqualityinsertupdate()
    {
        $hideproductionmaterial = $this->input->post('hideproductionmaterial');
        $examinedqty = $this->input->post('exqty');
        $washtemp = $this->input->post('washtemp');
        $washtime = $this->input->post('washtime');
        $drytemp = $this->input->post('drytemp');
        $drytime = $this->input->post('drytime');
        $afterdrymoisture = $this->input->post('afterdrymoisture');
        $drycoolingtime = $this->input->post('drycoolingtime');
        $cutsize = $this->input->post('cutsize');
        $cutwastage = $this->input->post('cutwastage');
        $moisture_after_grinding = $this->input->post('moisture_after_grinding');
        $roasting_temperature = $this->input->post('roasting_temperature');
        $roasting_color = $this->input->post('roasting_color');
        $roasting_time = $this->input->post('roasting_time');
        $cooling_moisture = $this->input->post('cooling_moisture');
        $cooling_time = $this->input->post('cooling_time');
        $magnet_verification = $this->input->post('magnet_verification');
        $comments = $this->input->post('comments');
        $materialinfo = $this->input->post('materialinfo');
    
        $userID = $_SESSION['userid'];
        $updatedatetime = date('Y-m-d H:i:s');
    
        $data = array(
            'examined_quantity' => $examinedqty,
            'washing_temperature' => $washtemp,
            'washing_time' => $washtime,
            'drying_temperature' => $drytemp,
            'drying_time' => $drytime,
            'aftrer_drying_moisture' => $afterdrymoisture,
            'drying_cooling_time' => $drycoolingtime,
            'cut_size' => $cutsize,
            'cutting_wastage' => $cutwastage,
            'moisture_after_grinding' => $moisture_after_grinding,
            'roasting_temperature' => $roasting_temperature,
            'roasting_color' => $roasting_color,
            'roasting_time' => $roasting_time,
            'cooling_moisture' => $cooling_moisture,
            'cooling_time' => $cooling_time,
            'magnet_verification' => $magnet_verification,
            'comments' => $comments,
            'status' => '1',
            'insertdatetime' => $updatedatetime,
            'tbl_user_idtbl_user' => $userID,
            'tbl_semi_production_idtbl_semi_production' => $hideproductionmaterial,
            'tbl_material_info_idtbl_material_info' => $materialinfo
        );
    
        $this->db->insert('tbl_production_quality', $data);
    
        $qualityID = $this->db->insert_id();
    
        if ($this->input->post('machine_id')) {
            $machineIDArray = $this->input->post('machine_id');
            $meshSizeArray = $this->input->post('mesh_size');
            $wastageArray = $this->input->post('wastage');
    
            foreach ($machineIDArray as $index => $machineID) {
                $currentMeshSize = $meshSizeArray[$index];
                $currentWastage = $wastageArray[$index];
    
                $datatwo = array(
                    'mesh_size' => $currentMeshSize,
                    'wastage' => $currentWastage,
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'tbl_production_quality_idtbl_production_quality' => $qualityID,
                    'tbl_user_idtbl_user' => $userID,
                    'tbl_machine_idtbl_machine' => $machineID
                );
    
                $this->db->insert('tbl_production_quality_machinelist', $datatwo);
            }
        }
    
        if ($this->db->trans_status() === TRUE) {
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
        } else {
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
        }
    }
    

    public function Semiproductiondetails(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_semi_production`.`idtbl_semi_production`, `tbl_production_quality`.`idtbl_production_quality`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`idtbl_material_info`, `tbl_material_code`.`materialname` FROM `tbl_production_quality`
        LEFT JOIN `tbl_semi_production` ON `tbl_semi_production`.`idtbl_semi_production`=`tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`
       LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_quality`.`tbl_material_info_idtbl_material_info`    
       LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_production_quality`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1)); 

        // $sqlother="SELECT SUM(`costunit`) AS `sumcost` FROM `tbl_semi_other_cost` WHERE `status`=? AND `tbl_semi_production_idtbl_semi_production`=?";
        // $respondother=$this->db->query($sqlother, array(1, $recordID)); 
        
        $html='
        <table class="table table-striped table-bordered table-sm small">
            <thead>
                <tr>
                    <th>Material Code</th>
                    <th>Material Name</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
        ';
        foreach($respond->result() AS $rowcotlist){
            $html.='
                <tr>
                    <td>'.$rowcotlist->materialinfocode.'</td>
                    <td>'.$rowcotlist->materialname.'</td>
                    
                    <td class="text-right">
                    <a href="' . base_url() . 'Semiproductionquality/Semiproductionqualitycheckreport/' . $rowcotlist->idtbl_semi_production . '/' . $rowcotlist->idtbl_material_info .'"
                    class="btn btn-warning btn-sm float-right ml-1" target="_blank"><i class="fas fa-file"></i></a>                
                        <button type="button" id="' . $rowcotlist->idtbl_semi_production . '"
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

        $sql="SELECT IFNULL(`tblel`.`ds`, `tbl_production_quality`.`magnet_verification`) As descstatus, `tbl_production_quality`.`idtbl_production_quality`, `tbl_production_quality`.`examined_quantity`, `tbl_production_quality`.`washing_temperature`, `tbl_production_quality`.`washing_time`, `tbl_production_quality`.`drying_temperature`, `tbl_production_quality`.`drying_time`, `tbl_production_quality`.`aftrer_drying_moisture`, `tbl_production_quality`.`drying_cooling_time`, `tbl_production_quality`.`cut_size`, `tbl_production_quality`.`cutting_wastage`, `tbl_production_quality`.`moisture_after_grinding`, `tbl_production_quality`.`roasting_temperature`, `tbl_production_quality`.`roasting_color`, `tbl_production_quality`.`roasting_time`, `tbl_production_quality`.`cooling_moisture`, `tbl_production_quality`.`cooling_time`, `tbl_production_quality`.`magnet_verification`, `tbl_production_quality`.`comments`, `tbl_production_quality`.`status` FROM `tbl_production_quality` LEFT JOIN(SELECT 1 AS type, 'YES' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'NO' AS ds, 2 As el) As tblel ON (`tbl_production_quality`.`magnet_verification`=`tblel`.`type`) WHERE `tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`=? AND `tbl_production_quality`.`status`=?";

        $respond=$this->db->query($sql, array($recordID, 1));

        $sqlmachine="SELECT `mesh_size`, `wastage`, `machine` FROM `tbl_production_quality_machinelist` LEFT JOIN `tbl_production_quality` ON `tbl_production_quality`.`idtbl_production_quality`=`tbl_production_quality_machinelist`.`tbl_production_quality_idtbl_production_quality` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine`=`tbl_production_quality_machinelist`.`tbl_machine_idtbl_machine` WHERE `tbl_production_quality`.`tbl_semi_production_idtbl_semi_production`=?";

        $respondmachine=$this->db->query($sqlmachine, array($recordID));

        foreach($respond->result() as $rowlist){
            $html.='

            <ul>
            	<li>

            		<label for="">EXAMINED QTY : <span>&nbsp;'.$rowlist->examined_quantity.'</span></label>
            	</li>
            	<li>
            		<label for="">WASHING TEMPERATURE : <span>&nbsp;'.$rowlist->washing_temperature.'</span></label>
            	</li>
            	<li>
            		<label for="">WASHING TIME : <span>&nbsp;'.$rowlist->washing_time.'</span></label>
            	</li>
            	<li>
            		<label for="">DRYING TEMPERATURE : <span>&nbsp;'.$rowlist->drying_temperature.'</span></label>
            	</li>
            	<li>
            		<label for="">DRYING TIME : <span>&nbsp;'.$rowlist->drying_time.'</span></label>
            	</li>
            	<li>
            		<label for="">AFTRER DRYING MOISTURE % : <span>&nbsp;'.$rowlist->aftrer_drying_moisture.'</span></label>
            	</li>
            	<li>
            		<label for="">DRYING - COOLING TIME : <span>&nbsp;'.$rowlist->drying_cooling_time.'</span></label>
            	</li>
            	<li>
            		<label for="">CUT SIZE : <span>&nbsp;'.$rowlist->cut_size.'</span></label>
            	</li>
            	<li>
            		<label for="">CUTTING WASTAGE : <span>&nbsp;'.$rowlist->cutting_wastage.'</span></label>
            	</li>
                ';
                foreach($respondmachine->result() as $rowmachinelist){
                    $html.='
                    <li>
                    	<label for="">Machine : <span>&nbsp;'.$rowmachinelist->machine.'</span></label>
                    	<ul>
                    		<li>
                    			<label for="">MESH SIZE : <span>&nbsp;'.$rowmachinelist->mesh_size.'</span></label>
                    		</li>
                    		<li>
                    			<label for="">WASTAGE : <span>&nbsp;'.$rowmachinelist->wastage.'</span></label>
                    		</li>
                    	</ul>
                    </li>
                    ';
                }
                $html.='

                <li>
                <label for="">MOISTURE % (AFTER GRINDING : <span>&nbsp;'.$rowlist->moisture_after_grinding.'</span></label>
                </li>
                <li>
                    <label for="">ROASTING TEMPERATURE : <span>&nbsp;'.$rowlist->roasting_temperature.'</span></label>
                </li>
                <li>
                    <label for="">ROASTING COLOR : <span>&nbsp;'.$rowlist->roasting_color.'</span></label>
                </li>
                <li>
                    <label for="">ROASTING TIME : <span>&nbsp;'.$rowlist->roasting_time.'</span></label>
                </li>
                <li>
                    <label for="">COOLING MOISTURE % : <span>&nbsp;'.$rowlist->cooling_moisture.'</span></label>
                </li>
                <li>
                    <label for="">COOLING TIME : <span>&nbsp;'.$rowlist->cooling_time.'</span></label>
                </li>
                <li>
                    <label for="">MAGNET VERIFICATION : <span>&nbsp;'.$rowlist->descstatus.'</span></label>
                </li>
                <li>
                	<label for="">COMMENTS : <span>&nbsp;'.$rowlist->comments.'</span></label>
                </li>
            </ul>

            
            ';
        }

        echo $html;
    }

    public function Editproductionqualityinfo(){
        $recordID=$this->input->post('recordID');

        $updatesql="SELECT `idtbl_production_quality`, `examined_quantity`, `washing_temperature`, `washing_time`, `drying_temperature`, `drying_time`, `aftrer_drying_moisture`, `drying_cooling_time`, `cut_size`, `cutting_wastage`, `mesh_size`, `wastage`, `moisture_after_grinding`, `roasting_temperature`, `roasting_color`, `roasting_time`, `cooling_moisture`, `cooling_time`, `magnet_verification`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_machine_idtbl_machine`, `tbl_semi_production_idtbl_semi_production`, `tbl_material_info_idtbl_material_info` FROM `tbl_production_quality` WHERE `tbl_semi_production_idtbl_semi_production`=? AND `status`=?";
        $updaterespond=$this->db->query($updatesql, array($recordID, 1));

        $sqlmachine = "SELECT `tbl_machine`.`machine` FROM `tbl_machine_allocation` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine` = `tbl_machine_allocation`.`tbl_machine_idtbl_machine` WHERE `tbl_machine_allocation`.`tbl_semi_production_idtbl_semi_production` = ?";
        $respondmachine = $this->db->query($sqlmachine, array($recordID));

        $html = '';

        foreach($updaterespond->result() as $rowupdatequalitylist){
        $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">EXAMINED QTY</label>
                    <input type="text" name="exqty" id="exqty" class="form-control form-control-sm" value="'.$rowupdatequalitylist->examined_quantity.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">WASHING TEMPERATURE</label>
                    <input type="text" name="washtemp" id="washtemp" class="form-control form-control-sm" value="'.$rowupdatequalitylist->washing_temperature.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">WASHING TIME</label>
                    <input type="text" name="washtime" id="washtime" class="form-control form-control-sm" value="'.$rowupdatequalitylist->washing_time.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING TEMPERATURE</label>
                    <input type="text" name="drytemp" id="drytemp" class="form-control form-control-sm" value="'.$rowupdatequalitylist->drying_temperature.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING TIME</label>
                    <input type="text" name="drytime" id="drytime" class="form-control form-control-sm" value="'.$rowupdatequalitylist->drying_time.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">AFTRER DRYING MOISTURE %</label>
                    <input type="text" name="afterdrymoisture" id="afterdrymoisture" class="form-control form-control-sm" value="'.$rowupdatequalitylist->aftrer_drying_moisture.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">DRYING - COOLING TIME</label>
                    <input type="text" name="drycoolingtime" id="drycoolingtime" class="form-control form-control-sm" value="'.$rowupdatequalitylist->drying_cooling_time.'">
                </div>
            </div>
            <div class="form-row">
            	<div class="col">
            		<label class="small font-weight-bold text-dark">CUT SIZE</label>
            		<input type="text" name="cutsize" id="cutsize" class="form-control form-control-sm" value="'.$rowupdatequalitylist->cut_size.'">
            	</div>
            </div>
            <div class="form-row">
            	<div class="col">
            		<label class="small font-weight-bold text-dark">CUTTING WASTAGE %</label>
            		<input type="text" name="cutwastage" id="cutwastage" class="form-control form-control-sm" value="'.$rowupdatequalitylist->cutting_wastage.'">
            	</div>
            </div>
        ';
    
        foreach ($respondmachine->result() as $rowmachinelist) {
            $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">MACHINES</label>
                    <input type="text" name="machine[]" id="machine" class="form-control form-control-sm" value="'.$rowmachinelist->machine.'" readonly>
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">MESH SIZE</label>
                    <input type="text" name="mesh_size[]" id="mesh_size" class="form-control form-control-sm" value="'.$rowupdatequalitylist->mesh_size.'">
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">WASTAGE</label>
                    <input type="text" name="wastage[]" id="wastage" class="form-control form-control-sm" value="'.$rowupdatequalitylist->wastage.'">
                </div>
            </div>
            ';
        }
    
        $html .= '
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">MOISTURE % (AFTER GRINDING)</label>
                    <input type="text" name="moisture_after_grinding" id="moisture_after_grinding" class="form-control form-control-sm" value="'.$rowupdatequalitylist->moisture_after_grinding.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING TEMPERATURE</label>
                    <input type="text" name="roasting_temperature" id="roasting_temperature" class="form-control form-control-sm" value="'.$rowupdatequalitylist->roasting_temperature.'">
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING COLOR</label>
                    <input type="text" name="roasting_color" id="roasting_color" class="form-control form-control-sm" value="'.$rowupdatequalitylist->roasting_color.'">
                </div>
                <div class="col">
                    <label class="small font-weight-bold text-dark">ROASTING TIME</label>
                    <input type="text" name="roasting_time" id="roasting_time" class="form-control form-control-sm" value="'.$rowupdatequalitylist->roasting_time.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COOLING MOISTURE %</label>
                    <input type="text" name="cooling_moisture" id="cooling_moisture" class="form-control form-control-sm" value="'.$rowupdatequalitylist->cooling_moisture.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COOLING TIME</label>
                    <input type="text" name="cooling_time" id="cooling_time" class="form-control form-control-sm" value="'.$rowupdatequalitylist->cooling_time.'">
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">MAGNET VERIFICATION</label><br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="passfail1" name="magnet_verification" class="custom-control-input" value="1">
                        <label class="custom-control-label" for="passfail1">YES</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="passfail2" name="magnet_verification" class="custom-control-input" value="0" checked>
                        <label class="custom-control-label" for="passfail2">NO</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col">
                    <label class="small font-weight-bold text-dark">COMMENTS</label>
                    <textarea name="comments" id="comments" class="form-control form-control-sm" value="'.$rowupdatequalitylist->comments.'"></textarea>
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
        $washtemp=$this->input->post('washtemp');
        $washtime=$this->input->post('washtime');
        $drytemp=$this->input->post('drytemp');
        $drytime=$this->input->post('drytime');
        $afterdrymoisture=$this->input->post('afterdrymoisture');
        $drycoolingtime=$this->input->post('drycoolingtime');
        $cutsize=$this->input->post('cutsize');
        $cutwastage=$this->input->post('cutwastage');
        $machine=$this->input->post('machine');
        $mesh_size=$this->input->post('mesh_size');
        $wastage=$this->input->post('wastage');
        $moisture_after_grinding=$this->input->post('moisture_after_grinding');
        $roasting_temperature=$this->input->post('roasting_temperature');
        $roasting_color=$this->input->post('roasting_color');
        $roasting_time=$this->input->post('roasting_time');
        $cooling_moisture=$this->input->post('cooling_moisture');
        $cooling_time=$this->input->post('cooling_time');
        $magnet_verification=$this->input->post('magnet_verification');
        $comments=$this->input->post('comments');
        $materialinfo=$this->input->post('materialinfo');

        $userID=$_SESSION['userid'];
        $updatedatetime=date('Y-m-d H:i:s');

        $data = array( 
            'examined_quantity'=> $examinedqty, 
            'washing_temperature'=> $washtemp, 
            'washing_time'=> $washtime, 
            'drying_temperature'=> $drytemp, 
            'drying_time'=> $drytime, 
            'aftrer_drying_moisture'=> $afterdrymoisture, 
            'drying_cooling_time'=> $drycoolingtime, 
            'cut_size'=> $cutsize, 
            'cutting_wastage'=> $cutwastage, 
            'mesh_size'=> '0', 
            'wastage'=> '0', 
            'moisture_after_grinding'=> $moisture_after_grinding, 
            'roasting_temperature'=> $roasting_temperature, 
            'roasting_color'=> $roasting_color, 
            'roasting_time'=> $roasting_time, 
            'cooling_moisture'=> $cooling_moisture, 
            'cooling_time'=> $cooling_time, 
            'magnet_verification'=> $magnet_verification,
            'comments'=> $comments, 
            'updatedatetime'=> $updatedatetime,
            'updateuser'=> $userID

        );
        $this->db->where('tbl_semi_production_idtbl_semi_production', $editedproductionid);
        $respond = $this->db->update('tbl_production_quality', $data);


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