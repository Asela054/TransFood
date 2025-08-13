<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productiontranspacking extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productiontranspackinginfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productiontranspacking', $result);
	}
    public function Productionpackqualityform(){
		$this->load->model('Productiontranspackinginfo');
        $result=$this->Productiontranspackinginfo->Productionpackqualityform();
	}
    public function Productionpackqualityinsertupdate(){
		$this->load->model('Productiontranspackinginfo');
        $result=$this->Productiontranspackinginfo->Productionpackqualityinsertupdate();
	}
    public function Getmaterialinfolist(){
		$this->load->model('Productiontranspackinginfo');
        $result=$this->Productiontranspackinginfo->Getmaterialinfolist();
	}
    public function Transfertopacking(){
		$this->load->model('Productiontranspackinginfo');
        $result=$this->Productiontranspackinginfo->Transfertopacking();
	}
    public function Checkissueqtyforpacking(){
		$this->load->model('Productiontranspackinginfo');
        $result=$this->Productiontranspackinginfo->Checkissueqtyforpacking();
	}
}