<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customerporder extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Customerporderinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['customerlist']=$this->Customerporderinfo->Getcustomerlist();
		$result['prodcutlist']=$this->Customerporderinfo->Productlist();
		$result['ordertypelist']=$this->Customerporderinfo->Getordertype();
		$this->load->view('customerporder', $result);
	}
    public function Customerporderinsertupdate(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerporderinsertupdate();
	}
	public function Customerpordertupdate(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerpordertupdate();
	}
    public function Customerporderstatus($x, $y){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerporderstatus($x, $y);
	}
	public function printreport($x, $y) {
		$this->load->model('Customerporderreportinfo');
		$result = $this->Customerporderreportinfo->printreport($x, $y);
	}
    public function Getproductaccoproductcategory(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getproductaccoproductcategory();
	}
    public function Getproductpriceaccoproduct(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getproductpriceaccoproduct();
	}
    public function Customerporderview(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerporderview();
	}
	public function Getcustomerporderdetails(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getcustomerporderdetails();
	}
	public function Getorderqty(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getorderqty();
	}
	public function Getbalanceqty(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getbalanceqty();
	}
	public function Porderinsertupdate(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Porderinsertupdate();
	}
	public function Customerporderedit(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerporderedit();
	}
	public function Getproductlist(){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Getproductlist();
	}
	public function Customerporderconfirm($x, $y){
		$this->load->model('Customerporderinfo');
        $result=$this->Customerporderinfo->Customerporderconfirm($x, $y);
	}
}