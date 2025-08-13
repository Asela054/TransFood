<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Grade extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Gradeinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Gradeinfo->Getmaterialcategory();
		$this->load->view('grade', $result);
	}
    public function Gradeinsertupdate(){
		$this->load->model('Gradeinfo');
        $result=$this->Gradeinfo->Gradeinsertupdate();
	}
    public function Gradestatus($x, $y){
		$this->load->model('Gradeinfo');
        $result=$this->Gradeinfo->Gradestatus($x, $y);
	}
    public function Gradeedit(){
		$this->load->model('Gradeinfo');
        $result=$this->Gradeinfo->Gradeedit();
	}
}