<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Semiproduction extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Semibominfo');
		$this->load->model('Semiproductioninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Semibominfo->Getmaterialcategory();
		$result['machine']=$this->Semiproductioninfo->Getmachinelist();
		$result['materialname']=$this->Semibominfo->Getmaterialname();
		$this->load->view('semiproduction', $result);
	}
	public function GetSemimateriallist(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->GetSemimateriallist();
	}
	public function printreport($x){
		$this->load->model('Semiproductionreportinfo');
        $result=$this->Semiproductionreportinfo->printreport($x);
	}
	public function Getprodcutioninfo(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getprodcutioninfo();
	}
	public function Machineinsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Machineinsertupdate();
	}
	public function Semiproductioninsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductioninsertupdate();
	}
	public function Semiproductioncreate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductioncreate();
	}
	public function Getothercosttype(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getothercosttype();
	}
	public function Othercostinsertupdate(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Othercostinsertupdate();
	}
	public function Viewalreadyothercost(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Viewalreadyothercost();
	}
	public function Semiproductiondetails(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductiondetails();
	}
	public function Semiproductiontransfer(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductiontransfer();
	}
	public function Getbatchnolistaccomaterial(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getbatchnolistaccomaterial();
	}
	public function Checkproductorderqty(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Checkproductorderqty();
	}
	public function Semiproductiondailycomplete(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductiondailycomplete();
	}
	public function Viewdailycompleteinfo(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Viewdailycompleteinfo();
	}
	public function Createlabel($dailycomID){
		$this->load->library('Fpdf_gen');

        $this->db->select('tbl_semi_production_daily_complete.mfdate, tbl_semi_production_daily_complete.expdate, tbl_semi_production_daily_complete.batchno,tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production , tbl_material_info.materialinfocode');
        $this->db->from('tbl_semi_production_daily_complete');
        $this->db->join('tbl_semi_production_detail', 'tbl_semi_production_detail.tbl_semi_production_idtbl_semi_production = tbl_semi_production_daily_complete.tbl_semi_production_idtbl_semi_production', 'left');
        $this->db->join('tbl_material_info', 'tbl_material_info.idtbl_material_info = tbl_semi_production_detail.semimaterial', 'left');
        $this->db->where('tbl_semi_production_daily_complete.idtbl_semi_production_daily_complete', $dailycomID);

        $respond=$this->db->get();
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		// $pdf->TextWithRotation(50,65,'Hello',45,-45);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(6,28,'SEMI LABEL','U');
		$pdf->SetFont('Arial','',5);
		$pdf->TextWithDirection(8,7,'SEMI Code : '.$respond->row(0)->materialinfocode,'R');
		$pdf->TextWithDirection(8,11,'SO No     : UN/POD-0000'.$respond->row(0)->tbl_semi_production_idtbl_semi_production,'R');
		$pdf->TextWithDirection(8,15,'MF Date  : '.$respond->row(0)->mfdate,'R');
		$pdf->TextWithDirection(8,19.5,'EXP Date: '.$respond->row(0)->expdate,'R');
		$pdf->TextWithDirection(8,24,'Batch No : '.$respond->row(0)->batchno,'R');
		// $pdf->TextWithDirection(110,50,'world!','D');
		$pdf->Output();
	}
	public function Semiproductionapprove($x){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductionapprove($x);
	}
	public function Semiproductionprocess(){
        $this->load->model('Commeninfo');
        $this->load->model('Semibominfo');
		$this->load->model('Semiproductioninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['materialcategory']=$this->Semibominfo->Getmaterialcategory();
		$result['machine']=$this->Semiproductioninfo->Getmachinelist();
		$result['materialname']=$this->Semibominfo->Getmaterialname();
		$this->load->view('semiproductionprocess', $result);
	}
	public function Getsemiprodcutioninfo(){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Getsemiprodcutioninfo();
	}
	public function Semiproductionstatus($x, $y){
		$this->load->model('Semiproductioninfo');
        $result=$this->Semiproductioninfo->Semiproductionstatus($x, $y);
	}
}