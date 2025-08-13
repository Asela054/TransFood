<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionmaterialissue extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionmaterialissueinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productionmaterialissue', $result);
	}
    public function Getproductionordermaterialinfo(){
		$this->load->model('Productionmaterialissueinfo');
        $result=$this->Productionmaterialissueinfo->Getproductionordermaterialinfo();
	}
    public function Issuematerialforproduction(){
		$this->load->model('Productionmaterialissueinfo');
        $result=$this->Productionmaterialissueinfo->Issuematerialforproduction();
	}
}