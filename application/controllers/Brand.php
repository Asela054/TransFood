<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Brand extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Brandinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Brandinfo->Getmaterialcategory();
		$this->load->view('brand', $result);
	}
    public function Brandinsertupdate(){
		$this->load->model('Brandinfo');
        $result=$this->Brandinfo->Brandinsertupdate();
	}
    public function Brandstatus($x, $y){
		$this->load->model('Brandinfo');
        $result=$this->Brandinfo->Brandstatus($x, $y);
	}
    public function Brandedit(){
		$this->load->model('Brandinfo');
        $result=$this->Brandinfo->Brandedit();
	}
}