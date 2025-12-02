<?php
class Invoiceviewreportinfo extends CI_Model{
    public function printreport($x){



		$html='
	
';
    $this->load->library('pdf');
    $this->pdf->loadHtml($html);
	$this->pdf->render();
	$this->pdf->stream( "UNISTAR-INTERNATIONAL INVOICE SHEET.pdf", array("Attachment"=>0));

    }

}