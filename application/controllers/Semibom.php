<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Semibom extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Semibominfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Semibominfo->Getmaterialcategory();
		$result['materialname']=$this->Semibominfo->Getmaterialname();
		$this->load->view('semibom', $result);
	}
    public function Semibominsertupdate(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibominsertupdate();
	}
    public function Semibomstatus($x, $y){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomstatus($x, $y);
	}
    public function Semibomedit(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomedit();
	}
    public function GetSemimateriallist(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->GetSemimateriallist();
	}
    public function Getmaterialinfolist(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Getmaterialinfolist();
	}
    public function Getmaterialinfo(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Getmaterialinfo();
	}
	public function Semibomdetails(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomdetails();
	}
	public function Semibomlist(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomlist();
	}

	public function Semibomlistedit(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomlistedit();
	}
	public function Semibomdelete(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomdelete();
	}
	public function Semibomalllist(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Semibomalllist();
	}
	public function Getothercosttype(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->Getothercosttype();
	}
	public function SemiBomOtherCostInsertUpdate(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->SemiBomOtherCostInsertUpdate();
	}
	public function SemiBomCostEdit(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->SemiBomCostEdit();
	}
	public function SemiBomCostStatus(){
		$this->load->model('Semibominfo');
        $result=$this->Semibominfo->SemiBomCostStatus();
	}
}