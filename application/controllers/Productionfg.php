<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionfg extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionfginfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['location']=$this->Productionfginfo->locationlist();      
		$this->load->view('productionfg', $result);
	}

    public function Getproductlist(){
		$this->load->model('Productionfginfo');
        $result=$this->Productionfginfo->Getproductlist();
	}

    public function Getbatchlist(){
		$this->load->model('Productionfginfo');
        $result=$this->Productionfginfo->Getbatchlist();
	}

    public function Stocktransferprocess(){
		$this->load->model('Productionfginfo');
        $result=$this->Productionfginfo->Stocktransferprocess();
	}

    public function Getproductlisttoselectpicker(){
		$this->load->model('Productionfginfo');
        $result=$this->Productionfginfo->Getproductlisttoselectpicker();
	}

}