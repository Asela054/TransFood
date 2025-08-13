<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Supplier extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Supplierinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['countrylist']=$this->Supplierinfo->Getcountrylist();
		$result['materialcategory']=$this->Supplierinfo->Getmaterialcategory();
		// $result['materialinfo']=$this->Supplierinfo->Getmaterialinfo();
		$this->load->view('supplier', $result);
	}
    public function Supplierinsertupdate(){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplierinsertupdate();
	}
    public function Supplierstatus($x, $y){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplierstatus($x, $y);
	}
    public function Supplieredit(){
		$this->load->model('Supplierinfo');
        $result=$this->Supplierinfo->Supplieredit();
	}
}