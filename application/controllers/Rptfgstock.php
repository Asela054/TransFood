<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Rptfgstock extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Rptfgstockinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['location']=$this->Rptfgstockinfo->Getlocation();
		$this->load->view('rptfgstock', $result);
	}
}