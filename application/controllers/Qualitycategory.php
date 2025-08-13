<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Qualitycategory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Qualitycategoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('qualitycategory', $result);
	}
    public function Qualitycategoryinsertupdate(){
		$this->load->model('Qualitycategoryinfo');
        $result=$this->Qualitycategoryinfo->Qualitycategoryinsertupdate();
	}
    public function Qualitycategorystatus($x, $y){
		$this->load->model('Qualitycategoryinfo');
        $result=$this->Qualitycategoryinfo->Qualitycategorystatus($x, $y);
	}
    public function Qualitycategoryedit(){
		$this->load->model('Qualitycategoryinfo');
        $result=$this->Qualitycategoryinfo->Qualitycategoryedit();
	}
}