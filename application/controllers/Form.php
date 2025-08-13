<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Form extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Forminfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Forminfo->Getmaterialcategory();
		$this->load->view('form', $result);
	}
    public function Forminsertupdate(){
		$this->load->model('Forminfo');
        $result=$this->Forminfo->Forminsertupdate();
	}
    public function Formstatus($x, $y){
		$this->load->model('Forminfo');
        $result=$this->Forminfo->Formstatus($x, $y);
	}
    public function Formedit(){
		$this->load->model('Forminfo');
        $result=$this->Forminfo->Formedit();
	}
}