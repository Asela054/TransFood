<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Factory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Factoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('factory', $result);
	}
    public function Factoryinsertupdate(){
		$this->load->model('Factoryinfo');
        $result=$this->Factoryinfo->Factoryinsertupdate();
	}
    public function Factorystatus($x, $y){
		$this->load->model('Factoryinfo');
        $result=$this->Factoryinfo->Factorystatus($x, $y);
	}
    public function Factoryedit(){
		$this->load->model('Factoryinfo');
        $result=$this->Factoryinfo->Factoryedit();
	}
}