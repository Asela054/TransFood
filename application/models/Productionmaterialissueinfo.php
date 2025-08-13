<?php
class Productionmaterialissueinfo extends CI_Model{
    public function Getproductionordermaterialinfo(){
        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname`, `tbl_production_material_issue`.`issuedate`, `tbl_production_material_issue`.`batchno`, `tbl_production_material_issue`.`issueqty` FROM `tbl_production_material_issue` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_issue`.`tbl_production_material_idtbl_production_material` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_material`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_production_material`.`idtbl_production_material`=?";
        $respond=$this->db->query($sql, array($recordID));

        $html='';
        foreach($respond->result() as $rowlistload){
            $html.='
            <tr>
                <td>'.$rowlistload->materialname.'</td>
                <td>'.$rowlistload->materialinfocode.'</td>
                <td>'.$rowlistload->batchno.'</td>
                <td>'.$rowlistload->issuedate.'</td>
                <td>'.$rowlistload->issueqty.'</td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Issuematerialforproduction(){
        $this->db->trans_begin();
        $userID=$_SESSION['userid'];

        $recordID=$this->input->post('recordID');

        $updatedatetime=date('Y-m-d H:i:s');

        $sql="SELECT `tbl_production_material_issue`.`batchno`, `tbl_production_material_issue`.`issueqty`, `tbl_production_material`.`tbl_material_info_idtbl_material_info`, `tbl_production_material`.`idtbl_production_material` FROM `tbl_production_material_issue` LEFT JOIN `tbl_production_material` ON `tbl_production_material`.`idtbl_production_material`=`tbl_production_material_issue`.`tbl_production_material_idtbl_production_material` WHERE `tbl_production_material_issue`.`tbl_production_material_idtbl_production_material`=? AND `tbl_production_material_issue`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, 1));

        foreach($respond->result() as $rowlistload){
            $idtbl_production_material=$rowlistload->idtbl_production_material;
            $batchno=$rowlistload->batchno;
            $issueqty=$rowlistload->issueqty;
            $materialinfoID=$rowlistload->tbl_material_info_idtbl_material_info;

            $sqlcheckstock="SELECT `qty` FROM `tbl_stock` WHERE `batchno`=? AND `tbl_material_info_idtbl_material_info`=? AND `status`=?";
            $respondcheckstock=$this->db->query($sqlcheckstock, array($batchno, $materialinfoID, 1));

            if($respondcheckstock->row(0)->qty>0){
                $updateqty=$respondcheckstock->row(0)->qty-$issueqty;

                $datastock = array(
                    'qty'=> $updateqty, 
                    'updateuser'=> $userID, 
                    'updatedatetime' => $updatedatetime
                );
    
                $this->db->where('batchno', $batchno);
                $this->db->where('tbl_material_info_idtbl_material_info', $materialinfoID);
                $this->db->update('tbl_stock', $datastock);

                $datamaterial = array(
                    'approvestatus'=> '1',
                );
    
                $this->db->where('idtbl_production_material', $idtbl_production_material);
                $this->db->update('tbl_production_material', $datamaterial);
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