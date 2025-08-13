<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionpackingquality extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Productionpackingqualityinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productionpackingquality', $result);
	}

    public function Semiproductiondetails(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Semiproductiondetails();
	}

    public function Productionpackqualityform(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Productionpackqualityform();
	}
    public function Productionpackqualityinsertupdate(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Productionpackqualityinsertupdate();
	}
    public function Getqualityviewdescription(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Getqualityviewdescription();
	}
    public function Editproductionqualityinfo(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Editproductionqualityinfo();
	}
	public function Newproductioninqualitysertupdate(){
		$this->load->model('Productionpackingqualityinfo');
        $result=$this->Productionpackingqualityinfo->Newproductioninqualitysertupdate();
	}
	public function Productionpackingqualityreport($x){
		$this->load->model('Productionpackingqualityreportinfo');
        $result=$this->Productionpackingqualityreportinfo->Productionpackingqualityreport($x);
	}
}