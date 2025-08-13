<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customer extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Customerinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('customer', $result);
	}
    public function Customerinsertupdate(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customerinsertupdate();
	}
    public function Customerstatus($x, $y){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customerstatus($x, $y);
	}
    public function Customeredit(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customeredit();
	}
}