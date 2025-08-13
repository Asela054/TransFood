<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Unittype extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Unittypeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Unittypeinfo->Getmaterialcategory();
		$this->load->view('unittype', $result);
	}
    public function Unittypeinsertupdate(){
		$this->load->model('Unittypeinfo');
        $result=$this->Unittypeinfo->Unittypeinsertupdate();
	}
    public function Unittypestatus($x, $y){
		$this->load->model('Unittypeinfo');
        $result=$this->Unittypeinfo->Unittypestatus($x, $y);
	}
    public function Unittypeedit(){
		$this->load->model('Unittypeinfo');
        $result=$this->Unittypeinfo->Unittypeedit();
	}
}