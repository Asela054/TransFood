<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionorderview extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionorderviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productionorderview', $result);
	}
    public function Productionorderstatus($x, $y){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Productionorderstatus($x, $y);
	}
    public function printreport($x){
		$this->load->model('Productionorderviewreportinfo');
        $result=$this->Productionorderviewreportinfo->printreport($x);
	}
    public function Checkmachineavailability(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Checkmachineavailability();
	}
    public function Productiondetailaccoproduction(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Productiondetailaccoproduction();
	}
    public function Getqtyinfoaccoproductiondetail(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getqtyinfoaccoproductiondetail();
	}
    public function Getrowmateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getrowmateriallist();
	}
    public function Getpackmateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getpackmateriallist();
	}
    public function Getlablemateriallist(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getlablemateriallist();
	}
    public function Getmaterialenterlayout(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getmaterialenterlayout();
	}
    public function Getmaterialstockinfoaccomaterial(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getmaterialstockinfoaccomaterial();
	}
    public function Checkissueqty(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Checkissueqty();
	}
    public function Issuematerialforproduction(){
		$this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Issuematerialforproduction();
	}
    public function Getprodcutioninfo(){
        $this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Getprodcutioninfo();
    }
    public function Productionbomlistaccofg(){
        $this->load->model('Productionorderviewinfo');
        $result=$this->Productionorderviewinfo->Productionbomlistaccofg();
    }
}