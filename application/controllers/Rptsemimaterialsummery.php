<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptsemimaterialsummery extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rptsemimaterialsummeryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('rptsemimaterialsummery', $result);
	}
    public function Getsemimateriallist(){
		$this->load->model('Rptsemimaterialsummeryinfo');
        $result=$this->Rptsemimaterialsummeryinfo->Getsemimateriallist();
	}
    public function Getbatchnolist(){
		$this->load->model('Rptsemimaterialsummeryinfo');
        $result=$this->Rptsemimaterialsummeryinfo->Getbatchnolist();
	}
    public function Getsummeryreport(){
		$this->load->model('Rptsemimaterialsummeryinfo');
        $result=$this->Rptsemimaterialsummeryinfo->Getsummeryreport();
	}
}