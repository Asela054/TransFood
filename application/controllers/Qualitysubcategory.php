<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class QualitysubCategory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Qualitysubcategoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['category']=$this->Qualitysubcategoryinfo->Getcategory();
		$this->load->view('qualitysubcategory', $result);
	}
    public function Qualitysubcategoryinsertupdate(){
		$this->load->model('Qualitysubcategoryinfo');
        $result=$this->Qualitysubcategoryinfo->Qualitysubcategoryinsertupdate();
	}
    public function Qualitysubcategorystatus($x, $y){
		$this->load->model('Qualitysubcategoryinfo');
        $result=$this->Qualitysubcategoryinfo->Qualitysubcategorystatus($x, $y);
	}
    public function Qualitysubcategoryedit(){
		$this->load->model('Qualitysubcategoryinfo');
        $result=$this->Qualitysubcategoryinfo->Qualitysubcategoryedit();
	}
}