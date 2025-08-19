<?php
function CompanyList(){
    $CI = get_instance();
    $CI->db->select('`idtbl_company`, `company`, `code`');
    $CI->db->from('tbl_company');
    $CI->db->where('status', 1);

    return $CI->db->get()->result();
}
function CompanyBranchList($companyid){
    $CI = get_instance();
    $CI->db->where('status', 1);
    $CI->db->where('tbl_company_idtbl_company', $companyid);
    $CI->db->select('idtbl_company_branch, branch, code, tbl_company_idtbl_company');
    $CI->db->from('tbl_company_branch');
    echo json_encode($CI->db->get()->result());
}

function SearchSupplierList($searchTerm){
    $companyid=$_SESSION['company_id'];
    $branchid=$_SESSION['branch_id'];

    if(!isset($searchTerm)){
        $CI = get_instance();
        $CI->db->where('status', 1);
        $CI->db->select('idtbl_supplier, suppliername');
        $CI->db->from('tbl_supplier');
        $CI->db->limit(5);
        $respond=$CI->db->get();
    }
    else{            
        if(!empty($searchTerm)){
            $CI = get_instance();
            $CI->db->where('status', 1);
            $CI->db->select('idtbl_supplier, suppliername');
            $CI->db->from('tbl_supplier');
            $CI->db->like('suppliername', $searchTerm, 'both'); 
            $respond=$CI->db->get();
        }
        else{
            $CI = get_instance();
            $CI->db->where('status', 1);
            $CI->db->select('idtbl_supplier, suppliername');
            $CI->db->from('tbl_supplier');
            $CI->db->limit(5);
            $respond=$CI->db->get();             
        }
    }
    
    $data=array();
    
    foreach ($respond->result() as $row) {
        $data[]=array("id"=>$row->idtbl_supplier, "text"=>$row->suppliername);
    }   
    echo json_encode($data);
}