<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Import namespaces at the TOP of the file
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Html;

date_default_timezone_set('Asia/Colombo');

class Invoicecostsheet extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("Commeninfo");
        $this->load->model("Invoicecostsheetinfo");
    }
    public function index(){
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();  
		$this->load->view('invoicecostsheet', $result);
	}
    public function Getcustomerelist(){
        $searchTerm=$this->input->post('searchTerm');
        $result=SearchCustomerList($searchTerm);
    }
    public function Getsalesorder(){
        $searchTerm=$this->input->post('searchTerm');
        $customerid=$this->input->post('customerid');
        $result=$this->Invoicecostsheetinfo->SearchSalesorderList($searchTerm, $customerid);
    }
    public function Getcostcountinfo(){
        $result=$this->Invoicecostsheetinfo->Getcostcountinfo();
    }
    public function Exporttoexcel(){
        $htmlString = $this->input->post('table_data');

        if(empty($htmlString)) {
            die("No data to export");
        }

        // Create a temporary file to load the HTML string
        $tmpfile = tmpfile();
        fwrite($tmpfile, '<table>' . $htmlString . '</table>');
        $metaDatas = stream_get_meta_data($tmpfile);
        $tmpFilename = $metaDatas['uri'];

        // Read the HTML into PhpSpreadsheet
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->load($tmpFilename);
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Find the range of the data (e.g., A1:AC50)
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $fullRange = 'A1:' . $highestColumn . $highestRow;

        // 2. Define the Border Style
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // 3. Apply Borders to all cells
        $sheet->getStyle($fullRange)->applyFromArray($styleArray);

        // 4. Force specific rows to be Bold (Header and Total Row)
        // Assuming Row 1 is header
        $sheet->getStyle('A1:' . $highestColumn . '1')->getFont()->setBold(true);
        
        // Assuming the last row is the "Grand Total" row
        $sheet->getStyle('A' . $highestRow . ':' . $highestColumn . $highestRow)->getFont()->setBold(true);

        // 5. Auto-size columns so they aren't squashed
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Cost_Analysis_Report_'.date('Ymd').'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        
        fclose($tmpfile);
        exit;
    }
}