<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptinvoicesummary extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Rptinvoicesummaryinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['invoicelist']=$this->Rptinvoicesummaryinfo->Getinvoicelist();
		$this->load->view('rptinvoicesummary', $result);
	}
    public function Getinvoicedetail(){
        $this->load->model('Rptinvoicesummaryinfo');
        $result=$this->Rptinvoicesummaryinfo->Getinvoicedetail();
    }
}