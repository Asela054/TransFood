<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Directsale extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Directsaleinfo');
        $result['material']=$this->Directsaleinfo->Getmaterial();
        $result['location']=$this->Directsaleinfo->Getlocation();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('directsale', $result);
	}
    public function Directsaleinsertupdate(){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Directsaleinsertupdate();
	}
    public function Directsalestatus($x, $y){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Directsalestatus($x, $y);
	}
    public function Directsaleedit(){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Directsaleedit();
	}

    public function Getproductlist(){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Getproductlist();
	}

    public function Getproductlistaccobarcode(){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Getproductlistaccobarcode();
	}

    public function Getproductavalaibleqty(){
		$this->load->model('Directsaleinfo');
        $result=$this->Directsaleinfo->Getproductavalaibleqty();
	}

    public function Getposprintbill($x){
		$this->load->model('Directsalereceiptinfo');
        $result=$this->Directsalereceiptinfo->Getposprintbill($x);
	}
    public function Getcreditprintbill($x){
		$this->load->model('Directsalecreditreceiptinfo');
        $result=$this->Directsalecreditreceiptinfo->Getcreditprintbill($x);
	}

}