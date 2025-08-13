<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoice extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Invoiceinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();  
        $result['location']=$this->Invoiceinfo->locationlist();      
		$this->load->view('invoice', $result);
	}
    public function Invoiceinsertupdate(){
        $this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Invoiceinsertupdate();
    }
    public function Getporderviewtable(){
        $this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getporderviewtable();
    }
    public function Getorderdetails(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getorderdetails();
	}
    public function Getproductdetails(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getproductdetails();
	}
    public function Getproductavalaibleqty(){
		$this->load->model('Invoiceinfo');
        $result=$this->Invoiceinfo->Getproductavalaibleqty();
	}
}