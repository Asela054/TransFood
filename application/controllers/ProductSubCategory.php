<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class ProductSubCategory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('ProductSubCategoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['category']=$this->ProductSubCategoryinfo->Getcategory();
		$this->load->view('productsubcategory', $result);
	}
    public function ProductSubCategoryinsertupdate(){
		$this->load->model('ProductSubCategoryinfo');
        $result=$this->ProductSubCategoryinfo->ProductSubCategoryinsertupdate();
	}
    public function ProductSubCategorystatus($x, $y){
		$this->load->model('ProductSubCategoryinfo');
        $result=$this->ProductSubCategoryinfo->ProductSubCategorystatus($x, $y);
	}
    public function ProductSubCategoryedit(){
		$this->load->model('ProductSubCategoryinfo');
        $result=$this->ProductSubCategoryinfo->ProductSubCategoryedit();
	}
}