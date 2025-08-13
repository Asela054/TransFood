<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialcode extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialcodeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialcode', $result);
	}
    public function Materialcodeinsertupdate(){
		$this->load->model('Materialcodeinfo');
        $result=$this->Materialcodeinfo->Materialcodeinsertupdate();
	}
    public function Materialcodestatus($x, $y){
		$this->load->model('Materialcodeinfo');
        $result=$this->Materialcodeinfo->Materialcodestatus($x, $y);
	}
    public function Materialcodeedit(){
		$this->load->model('Materialcodeinfo');
        $result=$this->Materialcodeinfo->Materialcodeedit();
	}
    public function Materialcodeupload(){
		$this->load->model('Materialcodeinfo');
        $result=$this->Materialcodeinfo->Materialcodeupload();
	}
}