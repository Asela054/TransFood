<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Qualitycheck extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Qualitycheckinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		// $result['materialcategory']=$this->Qualitycheckinfo->Getmaterialcategory();
		$this->load->view('qualitycheck', $result);
	}
	public function GRNqualityform(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->GRNqualityform();
	}
	public function GRNqualityinsertupdate(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->GRNqualityinsertupdate();
	}
    public function Qualitycheckinsertupdate(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Qualitycheckinsertupdate();
	}
    public function Qualitycheckview(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Qualitycheckview();
	}
    public function Qualityprodcutlist(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Qualityprodcutlist();
	}
    public function Qualityprodcutqty(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Qualityprodcutqty();
	}
	public function Getqualityviewdescription(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Getqualityviewdescription();
	}
	public function Editqualityinfo(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Editqualityinfo();
	}
	public function NewGRNinsertupdate(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->NewGRNinsertupdate();
	}
    public function Qualitycheckstatus($x, $y){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Qualitycheckstatus($x, $y);
	}
	public function Qualitycheckreport($x, $y){
		$this->load->model('Qualitycheckreportinfo');
        $result=$this->Qualitycheckreportinfo->Qualitycheckreport($x, $y);
	}
    public function Getmaterialqtyaccomaterialid(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Getmaterialqtyaccomaterialid();
	}
	public function Getmaterialinfo(){
		$this->load->model('Qualitycheckinfo');
        $result=$this->Qualitycheckinfo->Getmaterialinfo();
	}
}