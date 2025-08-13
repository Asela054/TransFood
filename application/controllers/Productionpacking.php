<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Productionpacking extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
        $this->load->model('Productionorderviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        // $result['machine']=$this->Productionorderviewinfo->Getmachinelist();
		$this->load->view('productionpacking', $result);
	}
    public function Productionpackingcomplete(){
        $this->load->model('Productionpackinginfo');
        $result=$this->Productionpackinginfo->Productionpackingcomplete();
    }
    public function Checkproductorderqty(){
        $this->load->model('Productionpackinginfo');
        $result=$this->Productionpackinginfo->Checkproductorderqty();
    }
    public function Viewdailycompleteinfo(){
        $this->load->model('Productionpackinginfo');
        $result=$this->Productionpackinginfo->Viewdailycompleteinfo();
    }
    public function Approvedailycomplete(){
        $this->load->model('Productionpackinginfo');
        $result=$this->Productionpackinginfo->Approvedailycomplete();
    }
    public function Createlabel($dailycomID){
		$this->load->library('Fpdf_gen');

        $this->db->select('tbl_production_daily_complete.mfdate, tbl_production_daily_complete.expdate, tbl_production_daily_complete.batchno, tbl_product.productcode, tbl_production_order.tbl_customer_porder_idtbl_customer_porder');
        $this->db->from('tbl_production_daily_complete');
        $this->db->join('tbl_product', 'tbl_product.idtbl_product = tbl_production_daily_complete.tbl_product_idtbl_product', 'left');
        $this->db->join('tbl_production_order', 'tbl_production_order.idtbl_production_order = tbl_production_daily_complete.tbl_production_order_idtbl_production_order', 'left');
        $this->db->where('tbl_production_daily_complete.idtbl_production_daily_complete', $dailycomID);

        $respond=$this->db->get();
		
		$pdf=new RPDF('L','mm',array(50,30));
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);
		// $pdf->TextWithRotation(50,65,'Hello',45,-45);
		$pdf->SetFontSize(12);
		$pdf->TextWithDirection(5,25,'FG LABEL','U');
		$pdf->SetFont('Arial','B',6.2);
		$pdf->TextWithDirection(7,7, $respond->row(0)->productcode,'R');
        $pdf->SetFont('Arial','',6.5);
		$pdf->TextWithDirection(7,11,'SO No     : UN/SOD-0000'.$respond->row(0)->tbl_customer_porder_idtbl_customer_porder,'R');
		$pdf->TextWithDirection(7,14,'MF Date  : '.$respond->row(0)->mfdate,'R');
		$pdf->TextWithDirection(7,17,'EXP Date: '.$respond->row(0)->expdate,'R');
		$pdf->TextWithDirection(7,20,'Batch No : '.$respond->row(0)->batchno,'R');
		// $pdf->TextWithDirection(110,50,'world!','D');
		$pdf->Output();
	}
}

