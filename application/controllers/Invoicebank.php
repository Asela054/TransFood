<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoicebank extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Invoicebankinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('invoicebank', $result);
	}
    public function Invoicebankinsertupdate(){
		$this->load->model('Invoicebankinfo');
        $result=$this->Invoicebankinfo->Invoicebankinsertupdate();
	}
    public function Invoicebankstatus($x, $y){
		$this->load->model('Invoicebankinfo');
        $result=$this->Invoicebankinfo->Invoicebankstatus($x, $y);
	}
    public function Invoicebankedit(){
		$this->load->model('Invoicebankinfo');
        $result=$this->Invoicebankinfo->Invoicebankedit();
	}
}