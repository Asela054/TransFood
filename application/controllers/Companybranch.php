<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Companybranch extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Companybranchinfo');
        $result['company']=$this->Companybranchinfo->Getcompanylist();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('companybranch', $result);
	}
    public function Companybranchinsertupdate(){
		$this->load->model('Companybranchinfo');
        $result=$this->Companybranchinfo->Companybranchinsertupdate();
	}
    public function Companybranchstatus($x, $y){
		$this->load->model('Companybranchinfo');
        $result=$this->Companybranchinfo->Companybranchstatus($x, $y);
	}
    public function Companybranchedit(){
		$this->load->model('Companybranchinfo');
        $result=$this->Companybranchinfo->Companybranchedit();
	}
}