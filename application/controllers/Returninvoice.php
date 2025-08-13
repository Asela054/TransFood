<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Returninvoice extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Returninvoiceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['returntypelist']=$this->Returninvoiceinfo->Getreturntype();
        $result['customer']=$this->Returninvoiceinfo->Getcustomer();
		$this->load->view('returninvoice', $result);
	}

	public function Getinvoicedetails(){
        $this->load->model('Returninvoiceinfo');
        $result=$this->Returninvoiceinfo->Getinvoicedetails();
    }

    public function Getretruninvoicedetails(){
        $this->load->model('Returninvoiceinfo');
        $result=$this->Returninvoiceinfo->Getretruninvoicedetails();
    }

    public function Getorderdetails(){
		$this->load->model('Returninvoiceinfo');
        $result=$this->Returninvoiceinfo->Getorderdetails();
	}

    public function Getordereqty(){
		$this->load->model('Returninvoiceinfo');
        $result=$this->Returninvoiceinfo->Getordereqty();
	}

    public function Returninvoiceinsertupdate(){
		$this->load->model('Returninvoiceinfo');
        $result=$this->Returninvoiceinfo->Returninvoiceinsertupdate();
	}

    public function Getinvoiceprint(){
		$this->load->model('Returninvoiceprintinfo');
        $result=$this->Returninvoiceprintinfo->Getinvoiceprint();
	}
}