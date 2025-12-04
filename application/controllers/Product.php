<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Product extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('product', $result);
	}
    public function Productinsertupdate(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productinsertupdate();
	}
    public function Productstatus($x, $y){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productstatus($x, $y);
	}
    public function Productedit(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Productedit();
	}
	public function Stockupdate(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Stockupdate();
	}
	public function Finishgoodlupload(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Finishgoodlupload();
	}
	public function Checkbarcode(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->Checkbarcode();
	}
	public function getItemCostReport(){
		$this->load->model('Productinfo');
        $result=$this->Productinfo->getItemCostReport();
	}
	public function Barcode($barcode){
		$this->load->library('Fpdf_gen');

		$pdf=new PDF_Code39('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->Code39(3,4,$barcode,0.549,18);
		$pdf->Output();
	}
	public function Createlabel($fgcode, $socode, $mfdate, $expdate, $batchno){
		$this->load->library('Fpdf_gen');
		
		$pdf=new PDF_EAN13('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->EAN13(3,4, $barcode);
		$pdf->Output();
	}
}