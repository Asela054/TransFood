<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Finishgoodbom extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Finishgoodbominfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Finishgoodbominfo->Getmaterialcategory();
		$result['materialcategoryedit']=$this->Finishgoodbominfo->Getmaterialcategoryedit();
		$result['materialname']=$this->Finishgoodbominfo->Getmaterialname();
		$this->load->view('finishgoodbom', $result);
	}
    public function Finishgoodbominsertupdate(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbominsertupdate();
	}
    public function Finishgoodbomstatus($x, $y){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomstatus($x, $y);
	}
    public function Finishgoodbomedit(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomedit();
	}
    public function Getfinishgoodlist(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Getfinishgoodlist();
	}
    public function Getmaterialinfolist(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Getmaterialinfolist();
	}
    public function Getmaterialinfo(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Getmaterialinfo();
	}
	public function Getmaterialinfoedit(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Getmaterialinfoedit();
	}
	public function Finishgoodbomdetails(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomdetails();
	}
	public function Finishgoodbomlist(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomlist();
	}

	public function Finishgoodbomlistedit(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomlistedit();
	}
	public function Finishgoodbomdelete(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->Finishgoodbomdelete();
	}
	public function ViewallBOMdetails(){
		$this->load->model('Finishgoodbominfo');
        $result=$this->Finishgoodbominfo->ViewallBOMdetails();
	}
}