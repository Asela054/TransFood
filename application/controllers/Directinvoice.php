<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Directinvoice extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Directinvoiceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();  
        $result['location']=$this->Directinvoiceinfo->locationlist();      
        $result['bank']=$this->Directinvoiceinfo->banklist();      
		$this->load->view('directinvoice', $result);
	}
    public function Invoiceinsertupdate(){
        $this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Invoiceinsertupdate();
    }

    public function Getorderdetails(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getorderdetails();
	}
    public function Getbatchlist(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getbatchlist();
	}
    public function Getorderdetailsnoninvoice(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getorderdetailsnoninvoice();
	}
    public function Getproductdetails(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getproductdetails();
	}
    public function Getproductdetailsnoninvoice(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getproductdetailsnoninvoice();
	}
    public function Getproductavalaibleqty(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getproductavalaibleqty();
	}
    public function Getorderqty(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getorderqty();
	}
    public function Getorderqtynoninvoice(){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Getorderqtynoninvoice();
	}
    public function Completestatusupdate($x, $y){
		$this->load->model('Directinvoiceinfo');
        $result=$this->Directinvoiceinfo->Completestatusupdate($x, $y);
	}
}