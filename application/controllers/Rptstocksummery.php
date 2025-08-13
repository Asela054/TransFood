<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptstocksummery extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rptstocksummeryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('rptstocksummery', $result);
	}
    public function Getfinishgoodlist(){
		$this->load->model('Rptstocksummeryinfo');
        $result=$this->Rptstocksummeryinfo->Getfinishgoodlist();
	}
    public function Getbatchnolist(){
		$this->load->model('Rptstocksummeryinfo');
        $result=$this->Rptstocksummeryinfo->Getbatchnolist();
	}
    public function Getsummeryreport(){
		$this->load->model('Rptstocksummeryinfo');
        $result=$this->Rptstocksummeryinfo->Getsummeryreport();
	}
}