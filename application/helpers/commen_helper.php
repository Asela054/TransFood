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