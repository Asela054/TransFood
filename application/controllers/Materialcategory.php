<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialcategory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialcategoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('materialcategory', $result);
	}
    public function Materialcategoryinsertupdate(){
		$this->load->model('Materialcategoryinfo');
        $result=$this->Materialcategoryinfo->Materialcategoryinsertupdate();
	}
    public function Materialcategorystatus($x, $y){
		$this->load->model('Materialcategoryinfo');
        $result=$this->Materialcategoryinfo->Materialcategorystatus($x, $y);
	}
    public function Materialcategoryedit(){
		$this->load->model('Materialcategoryinfo');
        $result=$this->Materialcategoryinfo->Materialcategoryedit();
	}
}