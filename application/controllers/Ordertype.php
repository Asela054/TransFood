<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Ordertype extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Ordertypeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('ordertype', $result);
	}
    public function Ordertypeinsertupdate(){
		$this->load->model('Ordertypeinfo');
        $result=$this->Ordertypeinfo->Ordertypeinsertupdate();
	}
    public function Ordertypestatus($x, $y){
		$this->load->model('Ordertypeinfo');
        $result=$this->Ordertypeinfo->Ordertypestatus($x, $y);
	}
    public function Ordertypeedit(){
		$this->load->model('Ordertypeinfo');
        $result=$this->Ordertypeinfo->Ordertypeedit();
	}
}