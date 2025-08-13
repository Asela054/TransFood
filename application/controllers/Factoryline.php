<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Factoryline extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Factorylineinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['factory']=$this->Factorylineinfo->Getfactory();
		$this->load->view('factoryline', $result);
	}
    public function Factorylineinsertupdate(){
		$this->load->model('Factorylineinfo');
        $result=$this->Factorylineinfo->Factorylineinsertupdate();
	}
    public function Factorylinestatus($x, $y){
		$this->load->model('Factorylineinfo');
        $result=$this->Factorylineinfo->Factorylinestatus($x, $y);
	}
    public function Factorylineedit(){
		$this->load->model('Factorylineinfo');
        $result=$this->Factorylineinfo->Factorylineedit();
	}
}