<?php
class PurchaseorderPrintinfo extends CI_Model{

    public function Printpurchaseorder($x){
        $recordID=$x;

        $html ='
        
        ';
      
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream( "MULTI OFFSET PRINTERS-PURCHASE ORDER- ".$recordID.".pdf", array("Attachment"=>0));
    }

}
