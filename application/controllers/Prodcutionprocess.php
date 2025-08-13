<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Prodcutionprocess extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Prodcutionprocessinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['factorylist']=$this->Prodcutionprocessinfo->Getfactorylist();
		$this->load->view('prodcutionprocess', $result);
	}
    public function Prodcutionprocessinsertupdate(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Prodcutionprocessinsertupdate();
	}
    public function Prodcutionprocessmaterial(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Prodcutionprocessmaterial();
	}
    public function Getmachineaccofactory(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Getmachineaccofactory();
	}
    public function Checkavabilitystock(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Checkavabilitystock();
	}
    public function Productionsteptwo(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Productionsteptwo();
	}
    public function Getbatchnoaccoproductiondetail(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Getbatchnoaccoproductiondetail();
	}
    public function Getqtyinfoaccoproductiondetail(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Getqtyinfoaccoproductiondetail();
	}
    public function Productiondetailaccoproduction(){
		$this->load->model('Prodcutionprocessinfo');
        $result=$this->Prodcutionprocessinfo->Productiondetailaccoproduction();
	}
}