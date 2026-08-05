<?php
class Qualitycheckreportinfo extends CI_Model {
    public function Qualitycheckreport($x, $y) {
        $recordID = $x;
        $materialid = $y;

        $html = '';

        $sqlgrn = "SELECT `tbl_grn`.`idtbl_grn`, `tbl_grn`.`grndate`, `tbl_grndetail`.`qty`, `tbl_material_info`.`materialinfocode`, `tbl_material_info`.`comment`, `tbl_supplier`.`suppliername`, `tbl_supplier`.`suppliercode` FROM `tbl_grn` LEFT JOIN `tbl_grndetail` ON `tbl_grn`.`idtbl_grn`=`tbl_grndetail`.`tbl_grn_idtbl_grn` LEFT JOIN `tbl_supplier` ON `tbl_supplier`.`idtbl_supplier`=`tbl_grn`.`tbl_supplier_idtbl_supplier` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` WHERE `tbl_grn`.`status`=? AND `tbl_grn`.`idtbl_grn`=? AND `tbl_grndetail`.`tbl_material_info_idtbl_material_info`=?";
        $respondgrn = $this->db->query($sqlgrn, array(1, $recordID, $materialid)); 

        $qualitysql="SELECT IFNULL(`tblel`.`ds`, `tbl_grn_quality`.`statuspassfail`) As descstatus, `idtbl_grn_quality`, `examined_qty`, `moisture_level`, `adultering`, `fungi_pest`, `color_confirmity`, `grade`, `size`, `statuspassfail`, `comments`, `status`, `insertdatetime`, `updateuser`, `updatedatetime`, `tbl_user_idtbl_user`, `tbl_grn_idtbl_grn`, `tbl_material_info_idtbl_material_info` FROM `tbl_grn_quality` LEFT JOIN(SELECT 1 AS type, 'PASS' AS ds, 2 As el UNION ALL SELECT 0 AS type, 'FAIL' AS ds, 2 As el) As tblel ON (`tbl_grn_quality`.`statuspassfail`=`tblel`.`type`)  WHERE `tbl_grn_idtbl_grn`=? AND `tbl_grn_quality`.`tbl_material_info_idtbl_material_info`=? AND `tbl_grn_quality`.`status`=?";
        $qualityrespond=$this->db->query($qualitysql, array($recordID, $materialid, 1));
		


$html = '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Incoming Quality Inspection - Transfood Lanka</title>
        <style>
            @page { size: 210mm 297mm; margin: 5mm 5mm 5mm 5mm; font-family: Arial, sans-serif; }
            body { font-family: Arial, sans-serif; line-height: 1.5; text-align: left; margin-top: 110px; font-size: 11px; }
            header { position: fixed; top: 0px; left: 0px; right: 0px; height: 110px; }
            footer { position: fixed; bottom: 12px; left: 0px; right: 0px; height: 20px; border-top: 1px dotted #000; text-align: center; font-size: 9px; }
        </style>
    </head>
    <body>
        <header>
            <table style="width:100%;border-collapse:collapse;">
                <tr>
                    <td style="text-align:right;"><img src="'.base_url().'images/logo.png" style="width:140px;height:80px;margin-right:20px;"></td>
                    <td style="font-size:12px;">
                        <h3 style="color:#FF0000;font-size:25px;font-weight:bold;margin:0;">Transfood Lanka (Pvt) Ltd.</h3>
                        17A/1, 2 Vihara Mawatha, Kolonnawa<br>
                        Tel/Fax: +94 11-2254441 Email: info@tflanka.com<br>
                        www.transfoodlanka.com or www.tflanka.com
                    </td>
                </tr>
            </table>
        </header>

        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="border:1px solid #000;font-size:16px;font-weight:bold;letter-spacing:2px;text-align:center;background-color:#97d197;">INCOMING QUALITY INSPECTION &nbsp;|&nbsp; MATERIAL TYPE: Raw Material</td>
            </tr>
        </table>
        <table style="width:100%;border-collapse:collapse;margin-top:6px;">
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;width:18%;">SUPPLIER NAME</td>
                <td style="border:1px solid #000;padding:4px;width:32%;">'.$respondgrn->row(0)->suppliername.'</td>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;width:18%;">GRN NO</td>
                <td style="border:1px solid #000;padding:4px;width:32%;">'.$respondgrn->row(0)->idtbl_grn.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">SUPPLIER CODE</td>
                <td style="border:1px solid #000;padding:4px;">'.$respondgrn->row(0)->suppliercode.'</td>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">GRN DATE</td>
                <td style="border:1px solid #000;padding:4px;">'.$respondgrn->row(0)->grndate.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">ITEM CODE</td>
                <td colspan="3" style="border:1px solid #000;padding:4px;">'.$respondgrn->row(0)->materialinfocode.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;">ITEM DESCRIPTION</td>
                <td colspan="3" style="border:1px solid #000;padding:4px;">'.$respondgrn->row(0)->comment.'</td>
            </tr>
        </table>
        <br>
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td colspan="2" style="background-color:#97d197;border:1px solid #000;font-weight:bold;font-size:13px;text-align:center;padding:4px;">QUALITY PARAMETERS</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;width:50%;text-align:right;">RECEIVED QUANTITY:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$respondgrn->row(0)->qty.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">EXAMINED QTY:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->examined_qty.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">MOISTURE LEVEL %:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->moisture_level.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">ADULTERING:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->adultering.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">FUNGI &amp; PEST:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->fungi_pest.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">COLOR CONFIRMITY:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->color_confirmity.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">GRADE:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->grade.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">SIZE:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;">'.$qualityrespond->row(0)->size.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">STATUS:</td>
                <td style="border:1px solid #000;padding:4px;text-align:center;font-weight:bold;">'.$qualityrespond->row(0)->descstatus.'</td>
            </tr>
            <tr>
                <td style="background-color:#97d197;border:1px solid #000;font-weight:bold;padding:4px;text-align:right;">COMMENTS:</td>
                <td style="border:1px solid #000;padding:4px;">'.$qualityrespond->row(0)->comments.'</td>
            </tr>
        </table>
        <br>
        <table style="width:100%;border-collapse:collapse;margin-top:30px;">
            <tr>
                <td style="padding-top:10px;text-align:center;">
                    <div style="width:100%;margin:auto;border-top:1px dotted #000;"></div>
                    <div style="margin-top:5px;font-size:10px;">
                        For queries, contact Transfood Lanka (Pvt) Ltd. | info@tflanka.com
                    </div>
                </td>
            </tr>
        </table>
    </body>
    </html>';

        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->render();
        $this->pdf->stream( "UNISTAR-INTERNATIONAL QUALITY LIST SHEET.pdf", array("Attachment"=>0));
    }
}