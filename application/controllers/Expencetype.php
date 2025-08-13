<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Expencetype extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Expencetypeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('expencetype', $result);
	}
    public function Expencetypeinsertupdate(){
		$this->load->model('Expencetypeinfo');
        $result=$this->Expencetypeinfo->Expencetypeinsertupdate();
	}
    public function Expencetypestatus($x, $y){
		$this->load->model('Expencetypeinfo');
        $result=$this->Expencetypeinfo->Expencetypestatus($x, $y);
	}
    public function Expencetypeedit(){
		$this->load->model('Expencetypeinfo');
        $result=$this->Expencetypeinfo->Expencetypeedit();
	}
}