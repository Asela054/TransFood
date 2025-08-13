<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Location extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Locationinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('location', $result);
	}
    public function Locationinsertupdate(){
		$this->load->model('Locationinfo');
        $result=$this->Locationinfo->Locationinsertupdate();
	}
    public function Locationstatus($x, $y){
		$this->load->model('Locationinfo');
        $result=$this->Locationinfo->Locationstatus($x, $y);
	}
    public function Locationedit(){
		$this->load->model('Locationinfo');
        $result=$this->Locationinfo->Locationedit();
	}
}