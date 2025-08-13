<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialtransfer extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialtransferinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['location']=$this->Materialtransferinfo->locationlist();      
        $result['tolocation']=$this->Materialtransferinfo->tolocationlist();      
		$this->load->view('materialtransfer', $result);
	}

    public function Getproductlist(){
		$this->load->model('Materialtransferinfo');
        $result=$this->Materialtransferinfo->Getproductlist();
	}

    public function Getbatchlist(){
		$this->load->model('Materialtransferinfo');
        $result=$this->Materialtransferinfo->Getbatchlist();
	}

    public function Stocktransferprocess(){
		$this->load->model('Materialtransferinfo');
        $result=$this->Materialtransferinfo->Stocktransferprocess();
	}

    public function Getproductlisttoselectpicker(){
		$this->load->model('Materialtransferinfo');
        $result=$this->Materialtransferinfo->Getproductlisttoselectpicker();
	}

}