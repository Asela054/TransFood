<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Materialdetail extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Materialdetailinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['materialcategory']=$this->Materialdetailinfo->Getmaterialcategory();
        $result['unitlist']=$this->Materialdetailinfo->Getunit();
		$this->load->view('materialdetail', $result);
	}
    public function Materialdetailinsertupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailinsertupdate();
	}
    public function Supplierupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Supplierupdate();
	}
        public function Supplierupdate(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Supplierupdate();
	}
    public function Materialdetailstatus($x, $y){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailstatus($x, $y);
	}
    public function Materialdetailedit(){
		$this->load->model('Materialdetailinfo');
        $result=$this->Materialdetailinfo->Materialdetailedit();
	}
    public function Getsupplierlist(){
		$searchTerm=$this->input->post('searchTerm');
        $result=SearchSupplierList($searchTerm);
	}

    public function getMaterialSuppliers(){
        $material_id = $this->input->post('material_id');
        $this->load->model('Materialdetailinfo');
        $result = $this->Materialdetailinfo->getSuppliersByMaterial($material_id);
        echo json_encode($result);
    }

}