<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoiceview extends CI_Controller {
    public function index(){
        $this->load->model('Commeninfo');
		$this->load->model('Invoiceviewinfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['location']=$this->Invoiceviewinfo->locationlist();      
		$this->load->view('invoiceview', $result);
	}

	public function Getinvoicedetails(){
        $this->load->model('Invoiceviewinfo');
        $result=$this->Invoiceviewinfo->Getinvoicedetails();
    }

    public function printreport($x){
		$this->load->model('Invoiceviewreportinfo');
        $result=$this->Invoiceviewreportinfo->printreport($x);
	}
    public function printreportpos($x){
		$this->load->model('Invoiceviewreportposinfo');
        $result=$this->Invoiceviewreportposinfo->printreportpos($x);
	}

    public function Getproductlisttoselectpicker(){
		$this->load->model('Invoiceviewinfo');
        $result=$this->Invoiceviewinfo->Getproductlisttoselectpicker();
	}

    public function GetProductsByInvoiceID() {
        $invoice_id = $this->input->post('invoice_id');
        $this->load->model('Invoiceviewinfo');
        $products = $this->Invoiceviewinfo->GetProductsByInvoiceID($invoice_id);

        $response = [];
        foreach ($products as $product) {
            $response[] = [
                'id' => $product->idtbl_product,
                'text' => $product->productcode
            ];
        }

        echo json_encode($response);
    }

    public function UpdateBatchNumbers() {
        $invoice_id = $this->input->post('invoice_id');
        $product_id = $this->input->post('product_id');
        $batchnos = $this->input->post('batchnos');

        $this->load->model('Invoiceviewinfo');
        $result = $this->Invoiceviewinfo->UpdateBatchNumbers($invoice_id, $product_id, $batchnos);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Batch numbers updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update batch numbers']);
        }
    }

    public function GetBatchesByProductAndLocation() {
        $product_id = $this->input->post('product_id');
        $location_id = $this->input->post('location_id');
        $this->load->model('Invoiceviewinfo');
        $batches = $this->Invoiceviewinfo->GetBatchesByProductAndLocation($product_id, $location_id);

        $response = [];
        foreach ($batches as $batch) {
            $response[] = [
                'id' => $batch->idtbl_product_stock,
                'text' => $batch->fgbatchno . ' (Inserted on: ' . $batch->insertdatetime . ')',
                'fgbatchno' => $batch->fgbatchno
            ];
        }

        echo json_encode($response);
    }
}