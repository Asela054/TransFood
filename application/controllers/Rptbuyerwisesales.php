<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptbuyerwisesales extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rptbuyerwisesalesinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['customer']=$this->Rptbuyerwisesalesinfo->Getcustomer();
		$this->load->view('rptbuyerwisesales', $result);
	}

    public function Getcustomerlist(){
		$this->load->model('Rptbuyerwisesalesinfo');
        $result=$this->Rptbuyerwisesalesinfo->Getcustomerlist();
	}
}