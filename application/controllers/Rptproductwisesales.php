<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptproductwisesales extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rptproductwisesalesinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['product']=$this->Rptproductwisesalesinfo->Getproduct();
		$this->load->view('rptproductwisesales', $result);
	}
    public function Getproductlist(){
		$this->load->model('Rptproductwisesalesinfo');
        $result=$this->Rptproductwisesalesinfo->Getproductlist();
	}
}