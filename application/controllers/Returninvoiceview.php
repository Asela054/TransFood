<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Returninvoiceview extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Returninvoiceviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('returninvoiceview', $result);
	}

	public function Getinvoicedetails(){
        $this->load->model('Returninvoiceviewinfo');
        $result=$this->Returninvoiceviewinfo->Getinvoicedetails();
    }

}