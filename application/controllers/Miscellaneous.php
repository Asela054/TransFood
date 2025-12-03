<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Miscellaneous extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Miscellaneousinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['material']=$this->Miscellaneousinfo->Getmaterial();
        $result['product']=$this->Miscellaneousinfo->Getproduct();
        $result['location']=$this->Miscellaneousinfo->Getlocation();
		$this->load->view('miscellaneous', $result);
	}
    public function Getbatchnolist(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Getbatchnolist();
	}
    public function Getbatchnolistaccoproduct(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Getbatchnolistaccoproduct();
	}
    public function Miscellaneousinsertupdate(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Miscellaneousinsertupdate();
	}
    public function Miscellaneousinsertupdate2(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Miscellaneousinsertupdate2();
	}
    public function Brandstatus($x, $y){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Brandstatus($x, $y);
	}
    public function Brandedit(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Brandedit();
	}
    public function Getproductlist(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Getproductlist();
	}
    public function Getmateriallist(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Getmateriallist();
	}
    public function Miscellaneousview(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Miscellaneousview();
	}
    public function Approvestatus(){
		$this->load->model('Miscellaneousinfo');
        $result=$this->Miscellaneousinfo->Approvestatus();
	}
}