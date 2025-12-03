<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Salesordercostcount extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Semibominfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		// $result['materialcategory']=$this->Salesordercostcountinfo->Getmaterialcategory();
		// $result['materialname']=$this->Salesordercostcountinfo->Getmaterialname();
		$this->load->view('salesordercostcount', $result);
	}
    public function Getcustomerelist(){
        $searchTerm=$this->input->post('searchTerm');
        $result=SearchCustomerList($searchTerm);
    }
    public function Getsalesorder(){
        $searchTerm=$this->input->post('searchTerm');
        $customerid=$this->input->post('customerid');
        $this->load->model('Salesordercostcountinfo');
        $result=$this->Salesordercostcountinfo->SearchSalesorderList($searchTerm, $customerid);
    }
    public function Getfglistaccosalesorder(){
        $searchTerm=$this->input->post('searchTerm');
        $salesorderid=$this->input->post('salesorderid');
        $this->load->model('Salesordercostcountinfo');
        $result=$this->Salesordercostcountinfo->SearchFgList($searchTerm, $salesorderid);
    }
    public function Getbomlist(){
        $searchTerm=$this->input->post('searchTerm');
        $finishgoodid=$this->input->post('finishgoodid');
        $this->load->model('Salesordercostcountinfo');
        $result=$this->Salesordercostcountinfo->Getbomlist($searchTerm, $finishgoodid);
    }
    public function Getcostcountinfo(){
        $this->load->model('Salesordercostcountinfo');
        $result=$this->Salesordercostcountinfo->Getcostcountinfo();
    }
}