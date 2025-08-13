<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Size extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Sizeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Sizeinfo->Getmaterialcategory();
		$this->load->view('size', $result);
	}
    public function Sizeinsertupdate(){
		$this->load->model('Sizeinfo');
        $result=$this->Sizeinfo->Sizeinsertupdate();
	}
    public function Sizestatus($x, $y){
		$this->load->model('Sizeinfo');
        $result=$this->Sizeinfo->Sizestatus($x, $y);
	}
    public function Sizeedit(){
		$this->load->model('Sizeinfo');
        $result=$this->Sizeinfo->Sizeedit();
	}
}