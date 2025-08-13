<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SemiBomOtherCostCharge extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('SemiBomOtherCostChargeInfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['othercosttype']=$this->SemiBomOtherCostChargeInfo->GetOtherCostType();
		$this->load->view('semibomothercostcharge', $result);
	}
    public function SemiBomOtherCostinsertupdate(){
		$this->load->model('SemiBomOtherCostChargeInfo');
        $result=$this->SemiBomOtherCostChargeInfo->SemiBomOtherCostinsertupdate();
	}
    public function SemiBomOtherCoststatus($x, $y){
		$this->load->model('SemiBomOtherCostChargeInfo');
        $result=$this->SemiBomOtherCostChargeInfo->SemiBomOtherCoststatus($x, $y);
	}
    public function SemiBomOtherCostedit(){
		$this->load->model('SemiBomOtherCostChargeInfo');
        $result=$this->SemiBomOtherCostChargeInfo->SemiBomOtherCostedit();
	}
}