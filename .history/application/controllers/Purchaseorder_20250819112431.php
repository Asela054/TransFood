<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Purchaseorder extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Purchaseorderinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Purchaseorderinfo->Getlocation();
		$result['ordertypelist']=$this->Purchaseorderinfo->Getordertype();
		$this->load->view('purchaseorder', $result);
	}
    public function Purchaseorderinsertupdate(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Purchaseorderinsertupdate();
	}
    public function Purchaseorderstatus($x, $y){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Purchaseorderstatus($x, $y);
	}
    public function Purchaseorderedit(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Purchaseorderedit();
	}
    public function Getproductaccosupplier(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Getproductaccosupplier();
	}
	public function Getunitpriceaccomaterial(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Getunitpriceaccomaterial();
	}
    public function Purchaseorderview(){
		$this->load->model('Purchaseorderinfo');
        $result=$this->Purchaseorderinfo->Purchaseorderview();
	}
	public function Printpurchaseorder($x){
		$this->load->model('PurchaseorderPrintinfo');
        $result=$this->PurchaseorderPrintinfo->Printpurchaseorder($x);
	}
	public function Getsupplierlist(){
		$searchTerm=$this->input->post('searchTerm');
        $result=SearchSupplierList($searchTerm);
	}
}