<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Returntype extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Returntypeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('returntype', $result);
	}
    public function Returntypeinsertupdate(){
		$this->load->model('Returntypeinfo');
        $result=$this->Returntypeinfo->Returntypeinsertupdate();
	}
    public function Returntypestatus($x, $y){
		$this->load->model('Returntypeinfo');
        $result=$this->Returntypeinfo->Returntypestatus($x, $y);
	}
    public function Returntypeedit(){
		$this->load->model('Returntypeinfo');
        $result=$this->Returntypeinfo->Returntypeedit();
	}
}