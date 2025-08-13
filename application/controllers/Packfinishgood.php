<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Packfinishgood extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Packfinishgoodinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('packfinishgood', $result);
	}
    public function Packfinishgoodinsertupdate(){
		$this->load->model('Packfinishgoodinfo');
        $result=$this->Packfinishgoodinfo->Packfinishgoodinsertupdate();
	}
    public function Packfinishgoodmaterial(){
		$this->load->model('Packfinishgoodinfo');
        $result=$this->Packfinishgoodinfo->Packfinishgoodmaterial();
	}
}