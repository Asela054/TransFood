<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Goodreceive extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Goodreceiveinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['locationlist']=$this->Goodreceiveinfo->Getlocation();
		$result['supplierlist']=$this->Goodreceiveinfo->Getsupplier();
		$result['porderlist']=$this->Goodreceiveinfo->Getporder();
		$result['costlist']=$this->Goodreceiveinfo->Getcostlist();
		$result['ordertypelist']=$this->Goodreceiveinfo->Getordertype();
		$this->load->view('goodreceive', $result);
	}
    public function Goodreceiveinsertupdate(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveinsertupdate();
	}
    public function Goodreceivestatus($x, $y){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceivestatus($x, $y);
	}
    public function Goodreceiveedit(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveedit();
	}
    public function Getproductaccosupplier(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductaccosupplier();
	}
    public function Goodreceiveview(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Goodreceiveview();
	}
    public function Getsupplieraccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getsupplieraccoporder();
	}
    public function Getproductaccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductaccoporder();
	}
    public function Getproductinfoaccoproduct(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getproductinfoaccoproduct();
	}
    public function Getexpdateaccoquater(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getexpdateaccoquater();
	}
    public function Getbatchnoaccosupplier(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getbatchnoaccosupplier();
	}
    public function Getpordertpeaccoporder(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getpordertpeaccoporder();
	}
	public function Getgoodreceiveid(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getgoodreceiveid();
	}
	public function Costinsertupdate(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Costinsertupdate();
	}

	public function Getallocatecostlist(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getallocatecostlist();
	}
	public function Getexpencetype(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getexpencetype();
	}
	public function Getmateriallistaccogrn(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getmateriallistaccogrn();
	}
	public function Getgrninfoaccogrnid(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getgrninfoaccogrnid();
	}
	public function Createlabel($mname, $mcode, $grnno, $pono, $mfdate, $expdate, $batchno){
		$this->load->library('Fpdf_gen');
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		// $pdf->TextWithRotation(50,65,'Hello',45,-45);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(3,5,'MATERIAL LABEL','R');
		$pdf->SetFont('Arial','',6);
		$pdf->TextWithDirection(3,8,'Name       : '.str_replace('%20', ' ', $mname),'R');
		$pdf->TextWithDirection(3,11,'Code        : '.str_replace('%20', '', $mcode),'R');
		$pdf->TextWithDirection(3,14,'GRN No   : '.str_replace('%7C', '/', $grnno),'R');
		$pdf->TextWithDirection(3,17,'PO No      : '.str_replace('%7C', '/', $pono),'R');
        $pdf->TextWithDirection(3,20,'MF Date   : '.$mfdate,'R');
		$pdf->TextWithDirection(3,23,'EXP Date : '.$expdate,'R');
		$pdf->TextWithDirection(3,26,'Batch No  : '.$batchno,'R');
		// $pdf->TextWithDirection(110,50,'world!','D');
		$pdf->Output();
	}
	public function Getmaterialinfoaccogrnlable(){
		$this->load->model('Goodreceiveinfo');
        $result=$this->Goodreceiveinfo->Getmaterialinfoaccogrnlable();
	}
}