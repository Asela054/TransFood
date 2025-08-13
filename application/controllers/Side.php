<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Side extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Sideinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Sideinfo->Getmaterialcategory();
		$this->load->view('side', $result);
	}
    public function Sideinsertupdate(){
		$this->load->model('Sideinfo');
        $result=$this->Sideinfo->Sideinsertupdate();
	}
    public function Sidestatus($x, $y){
		$this->load->model('Sideinfo');
        $result=$this->Sideinfo->Sidestatus($x, $y);
	}
    public function Sideedit(){
		$this->load->model('Sideinfo');
        $result=$this->Sideinfo->Sideedit();
	}
}