<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Expences extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Expencesinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['expence']=$this->Expencesinfo->Getexpencetype();
        $result['product']=$this->Expencesinfo->Getproduct();
		$this->load->view('expences', $result);
	}
    public function Expencesinsertupdate(){
		$this->load->model('Expencesinfo');
        $result=$this->Expencesinfo->Expencesinsertupdate();
	}
    public function Expencesstatus($x, $y){
		$this->load->model('Expencesinfo');
        $result=$this->Expencesinfo->Expencesstatus($x, $y);
	}
    public function Expencesedit(){
		$this->load->model('Expencesinfo');
        $result=$this->Expencesinfo->Expencesedit();
	}
}
