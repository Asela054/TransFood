<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productiontranslabeling extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productiontranslabelinginfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('productiontranslabeling', $result);
	}
    public function Productionpackqualityform(){
		$this->load->model('Productiontranslabelinginfo');
        $result=$this->Productiontranslabelinginfo->Productionpackqualityform();
	}
    public function Productionpackqualityinsertupdate(){
		$this->load->model('Productiontranslabelinginfo');
        $result=$this->Productiontranslabelinginfo->Productionpackqualityinsertupdate();
	}
    public function Transfertofgstock(){
		$this->load->model('Productiontranslabelinginfo');
        $result=$this->Productiontranslabelinginfo->Transfertofgstock();
	}
}