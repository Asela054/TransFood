<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class ProductCategory extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('ProductCategoryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productcategory', $result);
	}
    public function ProductCategoryinsertupdate(){
		$this->load->model('ProductCategoryinfo');
        $result=$this->ProductCategoryinfo->ProductCategoryinsertupdate();
	}
    public function ProductCategorystatus($x, $y){
		$this->load->model('ProductCategoryinfo');
        $result=$this->ProductCategoryinfo->ProductCategorystatus($x, $y);
	}
    public function ProductCategoryedit(){
		$this->load->model('ProductCategoryinfo');
        $result=$this->ProductCategoryinfo->ProductCategoryedit();
	}
}