<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Semiproductionquality extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Semiproductionqualityinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('semiproductionquality', $result);
	}

    public function Semiproductiondetails(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Semiproductiondetails();
	}

    public function Productionpackqualityform(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Productionpackqualityform();
	}
    public function Productionpackqualityinsertupdate(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Productionpackqualityinsertupdate();
	}
    public function Getqualityviewdescription(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Getqualityviewdescription();
	}
    public function Editproductionqualityinfo(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Editproductionqualityinfo();
	}
	public function Newproductioninqualitysertupdate(){
		$this->load->model('Semiproductionqualityinfo');
        $result=$this->Semiproductionqualityinfo->Newproductioninqualitysertupdate();
	}
	public function Semiproductionqualitycheckreport($x,$y){
		$this->load->model('Semiproductionqualityreportinfo');
        $result=$this->Semiproductionqualityreportinfo->Semiproductionqualitycheckreport($x,$y);
	}
}