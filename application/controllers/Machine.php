<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Machine extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Machineinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['factorylist']=$this->Machineinfo->Factorylist();
		$this->load->view('machine', $result);
	}
    public function Machineinsertupdate(){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machineinsertupdate();
	}
    public function Machinestatus($x, $y){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machinestatus($x, $y);
	}
    public function Machineedit(){
		$this->load->model('Machineinfo');
        $result=$this->Machineinfo->Machineedit();
	}
}