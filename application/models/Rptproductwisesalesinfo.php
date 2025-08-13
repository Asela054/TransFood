<?php
class Rptproductwisesalesinfo extends CI_Model{
    public function Getproduct(){
        $this->db->select('`idtbl_product`, `productcode`');
        $this->db->from('tbl_product');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getproductlist(){
        $searchTerm=$this->input->post('searchTerm');

        if(!isset($searchTerm)){
            $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? LIMIT 5";
            $respond=$this->db->query($sql, array(1));                       
        }
        else{            
            if(!empty($searchTerm)){
                $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? AND `productcode` LIKE '$searchTerm%'";
                $respond=$this->db->query($sql, array(1));    
            }
            else{
                $sql="SELECT `idtbl_product`, `productcode` FROM `tbl_product` WHERE `status`=? LIMIT 5";
                $respond=$this->db->query($sql, array(1));                
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_product, "text"=>$row->productcode);
        }
        
        echo json_encode($data);
    }
}