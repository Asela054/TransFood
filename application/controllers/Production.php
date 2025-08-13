<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Production extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productioninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['factorylist']=$this->Productioninfo->Getfactorylist();
		$this->load->view('production', $result);
	}
    public function Productionapprovel(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionapprovel();
	}
    public function Productiondetailaccoproduction(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productiondetailaccoproduction();
	}
    public function Getqtyinfoaccoproductiondetail(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getqtyinfoaccoproductiondetail();
	}
    public function Getrowmateriallist(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getrowmateriallist();
	}
    public function Getpackmateriallist(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getpackmateriallist();
	}
    public function Getlablemateriallist(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getlablemateriallist();
	}
    public function Getmaterialstockinfoaccomaterial(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getmaterialstockinfoaccomaterial();
	}
    public function Productioninsertupdate(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productioninsertupdate();
	}
    public function Getmaterialenterlayout(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getmaterialenterlayout();
	}
    public function Checkissueqty(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Checkissueqty();
	}
    public function Productionmaterialdetailaccoproductionmaterial(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionmaterialdetailaccoproductionmaterial();
	}
    public function Getmachineaccofactory(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getmachineaccofactory();
	}
    public function Productionmachineinsertupdate(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionmachineinsertupdate();
	}
    public function Getmachineavailableqty(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Getmachineavailableqty();
	}
    public function Productionmateriallistaccoproductionordermachine(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionmateriallistaccoproductionordermachine();
	}
    public function Productionmachinecompleteinsertupdate(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionmachinecompleteinsertupdate();
	}
    public function Packmateriallistaccoproduction(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Packmateriallistaccoproduction();
	}
    public function Productionpackqualityform(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionpackqualityform();
	}
    public function Productionpackqualityinsertupdate(){
		$this->load->model('Productioninfo');
        $result=$this->Productioninfo->Productionpackqualityinsertupdate();
	}
}