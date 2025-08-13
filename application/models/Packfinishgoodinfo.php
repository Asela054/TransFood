<?php
class Packfinishgoodinfo extends CI_Model{
    public function Packfinishgoodmaterial(){
        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_production_machine`.`idtbl_production_machine`, `tbl_production_machine`.`date`, `tbl_production_machine`.`qty`, `tbl_production_machine`.`batchno`, `tbl_machine`.`machine`, `tbl_factory`.`factoryname`, `tbl_material_code`.`materialname`, `tbl_material_info`.`materialinfocode`, `tbl_product`.`productcode` FROM `tbl_production_machine` LEFT JOIN `tbl_machine` ON `tbl_machine`.`idtbl_machine`=`tbl_production_machine`.`tbl_machine_idtbl_machine` LEFT JOIN `tbl_factory` ON `tbl_factory`.`idtbl_factory`=`tbl_production_machine`.`tbl_factory_idtbl_factory` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_machine`.`tbl_product_idtbl_product` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_product`.`materialid` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_production_machine`.`tbl_material_info_idtbl_material_info` WHERE `tbl_production_machine`.`status`=? AND `tbl_production_machine`.`tbl_production_order_idtbl_production_order`=? AND `tbl_production_machine`.`type`=? AND `tbl_production_machine`.`donestatus`=?";
        $respond=$this->db->query($sql, array(1, $recordID, 2, 0));

        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
                <td>'.$rowlist->materialname.'-'.$rowlist->productcode.'</td>
                <td>'.$rowlist->batchno.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->factoryname.'</td>
                <td>'.$rowlist->machine.'</td>
                <td>'.$rowlist->materialinfocode.'</td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-primary btnqualitycheck" id="'.$rowlist->idtbl_production_machine.'"><i class="fas fa-exchange-alt"></i></button></td>
            </tr>
            ';
        }

        echo $html;
    }
    public function Packfinishgoodinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $brand=$this->input->post('brand');
        if(!empty($this->input->post('stickerfront'))){$stickerfront=$this->input->post('stickerfront');}else{$stickerfront=0;}
        if(!empty($this->input->post('stickeback'))){$stickeback=$this->input->post('stickeback');}else{$stickeback=0;}
        if(!empty($this->input->post('stickequality'))){$stickequality=$this->input->post('stickequality');}else{$stickequality=0;}
        $unitweight=$this->input->post('unitweight');
        $reunitweight=$this->input->post('reunitweight');
        $packmaerial=$this->input->post('packmaerial');
        $rematerial=$this->input->post('rematerial');
        $packmethod=$this->input->post('packmethod');
        $sealmethod=$this->input->post('sealmethod');
        $nounitcar=$this->input->post('nounitcar');
        $sealcheck=$this->input->post('sealcheck');
        $cargrsweight=$this->input->post('cargrsweight');
        $reqcargrsweight=$this->input->post('reqcargrsweight');
        $metaldet=$this->input->post('metaldet');
        $passfail=$this->input->post('passfail');
        $comment=$this->input->post('comment');

        $recordID=$this->input->post('productionmachineID');

        $updatedatetime=date('Y-m-d H:i:s');

        $this->db->select('`tbl_production_order_idtbl_production_order`, `tbl_production_order_detail_idtbl_production_order_detail`, `tbl_product_idtbl_product`, `tbl_material_info_idtbl_material_info`');
        $this->db->from('tbl_production_machine');
        $this->db->where('idtbl_production_machine', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $data = array(
            'brand'=> $brand, 
            'unitweight'=> $unitweight, 
            'packmaterial'=> $packmaerial, 
            'packmethod'=> $packmethod, 
            'nounitcarton'=> $nounitcar, 
            'cartongrsweight'=> $cargrsweight, 
            'metaldetection'=> $metaldet, 
            'stickerfront'=> $stickerfront, 
            'stickerback'=> $stickeback, 
            'stickerquality'=> $stickeback, 
            'requnitweight'=> $reunitweight, 
            'reqmaterial'=> $rematerial, 
            'sealingmethod'=> $sealmethod, 
            'sealingcheck'=> $sealcheck, 
            'reqcartongrsweight'=> $reqcargrsweight, 
            'passfail'=> $passfail, 
            'comment'=> $comment, 
            'approvestatus'=> '0', 
            'status'=> '1', 
            'insertdatetime'=> $updatedatetime, 
            'tbl_user_idtbl_user'=> $userID, 
            'tbl_production_order_idtbl_production_order'=> $respond->row(0)->tbl_production_order_idtbl_production_order, 
            'tbl_production_order_detail_idtbl_production_order_detail'=> $respond->row(0)->tbl_production_order_detail_idtbl_production_order_detail, 
            'tbl_material_info_idtbl_material_info'=> $respond->row(0)->tbl_material_info_idtbl_material_info, 
            'tbl_product_idtbl_product'=> $respond->row(0)->tbl_product_idtbl_product
        );
        $this->db->insert('tbl_production_packfg', $data);

        $dataone = array(
            'donestatus'=> '1', 
            'updateuser'=> $userID, 
            'updatedatetime'=> $updatedatetime
        );

        $this->db->where('idtbl_production_machine', $recordID);
        $this->db->update('tbl_production_machine', $dataone);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            echo '1';                
        } else {
            $this->db->trans_rollback();

            echo '0';
        }
    }
}