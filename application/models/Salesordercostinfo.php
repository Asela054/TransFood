<?php
class Salesordercostinfo extends CI_Model{
    public function Getcostlist(){
        $this->db->select('`idtbl_expence_type`, `expencetype`');
        $this->db->from('tbl_expence_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getsalesoredrproduct(){

        $recordID=$this->input->post('recordID');
        $html='';

        $sql="SELECT `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_material_code`.`materialname`, `tbl_customer_porder`.`idtbl_customer_porder`,
        `tbl_customer_porder_detail`.`idtbl_customer_porder_detail`,`tbl_customer_porder_detail`.`suggestprice`, `tbl_customer_porder_detail`.`unitprice`, `tbl_customer_porder_detail`.`othercost`, `tbl_customer_porder_detail`.`netsaleprice`,    `tbl_customer_porder_detail`.`qty` FROM `tbl_product`
        LEFT JOIN `tbl_customer_porder_detail` ON `tbl_product`.`idtbl_product` = `tbl_customer_porder_detail`.`tbl_product_idtbl_product` 
        LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` 
        LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code` = `tbl_product`.`materialid`
        WHERE `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder`= $recordID AND `tbl_customer_porder_detail`.`status`= 1";

        $respond=$this->db->query($sql, array(1, $recordID));

        $unitprice=$respond->row(0)->unitprice;
        $othercost=$respond->row(0)->othercost;

        $nonprofitprice = $unitprice+$othercost;



        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
                <td>'.$rowlist->idtbl_customer_porder_detail.'</td>
                <td>'.$rowlist->productcode.'</td>
                <td>'.$rowlist->qty.'</td>
                <td>'.$rowlist->suggestprice.'</td>
                <td>'.$rowlist->unitprice.'</td>
                <td>'.$rowlist->othercost.'</td>
                <td>'.$rowlist->netsaleprice.'</td>
                <td>'.$nonprofitprice.'</td>
                <td>
                	<div class="row ml-3">
                		<button type="button" value="'.$rowlist->idtbl_product.'"
                			id="'.$rowlist->idtbl_customer_porder_detail.'" name="'.$rowlist->idtbl_customer_porder.'"
                			class="btnAddcost btn btn-primary btn-sm" data-toggle="modal"
                			data-target="#exampleModal"><i class="fas fa-plus"></i></button>
                	</div>
                </td>
                
             </tr>
            
            ';
        }

        echo $html;
    }

    public function Getexpencetype(){

        $orderid=$this->input->post('orderid');
        $productid=$this->input->post('productid');


        $sql="SELECT `tbl_expence_type`.`idtbl_expence_type`,`tbl_expence_type`.`expencetype` FROM `tbl_expence_type`
        WHERE `tbl_expence_type`.`status`=? AND `tbl_expence_type`.`idtbl_expence_type` NOT IN (SELECT `tbl_expence_type_idtbl_expence_type`
        FROM `tbl_customer_porder_cost` WHERE `status`=? AND `tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_product_idtbl_product`=?)";

        $respond=$this->db->query($sql, array(1, 1, $orderid, $productid));

        echo json_encode($respond->result());

    }

    public function Getorderdetails(){

        $recordID=$this->input->post('recordID');

        $sql="SELECT `tbl_product`.`idtbl_product`,`tbl_product`.`productcode`, `tbl_customer_porder`.`idtbl_customer_porder`,`tbl_customer_porder_detail`.`idtbl_customer_porder_detail`,`tbl_customer_porder_detail`.`qty`,`tbl_customer_porder_detail`.`unitprice`,`tbl_customer_porder_detail`.`othercost` FROM `tbl_product`
         LEFT JOIN `tbl_customer_porder_detail` ON `tbl_product`.`idtbl_product` = `tbl_customer_porder_detail`.`tbl_product_idtbl_product` 
         LEFT JOIN `tbl_customer_porder` ON `tbl_customer_porder`.`idtbl_customer_porder` = `tbl_customer_porder_detail`.`tbl_customer_porder_idtbl_customer_porder` 
         WHERE `tbl_customer_porder_detail`.`idtbl_customer_porder_detail`= $recordID AND `tbl_customer_porder_detail`.`status`= 1";
        $respond=$this->db->query($sql, array(1, $recordID));

        echo json_encode($respond->result());

    }

    public function Getmaterialcost(){

        $productid=$this->input->post('productid');

        $sql="SELECT `tbl_grndetail`.`tbl_material_info_idtbl_material_info`, AVG(`tbl_grndetail`.`unitprice`) AS `avgunitprice` FROM `tbl_grndetail` LEFT JOIN `tbl_stock` ON `tbl_stock`.`tbl_material_info_idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` LEFT JOIN `tbl_product_bom` ON `tbl_product_bom`.`tbl_material_info_idtbl_material_info`=`tbl_grndetail`.`tbl_material_info_idtbl_material_info` WHERE `tbl_material_info`.`tbl_material_category_idtbl_material_category`=? AND `tbl_product_bom`.`tbl_product_idtbl_product`=? AND `tbl_product_bom`.`qty`>? AND `tbl_product_bom`.`status`=?";
        $respond=$this->db->query($sql, array(1, $productid, 0, 1));    

        echo json_encode($respond->result());


    }

    public function Getallocatecostlist(){

        $recordID=$this->input->post('recordID');
        $productid=$this->input->post('productid');


        $html='';

        $sql="SELECT `tbl_customer_porder_cost`.`idtbl_customer_porder_cost`, `tbl_customer_porder_cost`.`costamount`, `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type`, `tbl_expence_type`.`expencetype` FROM  `tbl_customer_porder_cost` LEFT JOIN `tbl_expence_type` ON `tbl_expence_type`.`idtbl_expence_type`= `tbl_customer_porder_cost`.`tbl_expence_type_idtbl_expence_type` WHERE `tbl_customer_porder_cost`.`tbl_customer_porder_idtbl_customer_porder`=? AND `tbl_customer_porder_cost`.`tbl_product_idtbl_product`=? AND `tbl_customer_porder_cost`.`status`=?";
        $respond=$this->db->query($sql, array($recordID, $productid, 1));

        foreach($respond->result() as $rowlist){
            $html.='
            <tr>
                <td class="text-right">'.$rowlist->idtbl_customer_porder_cost.'</td>
                <td class="text-right">'.$rowlist->expencetype.'</td>
                <td class="totalrawcost text-right">'.$rowlist->costamount.'</td>                
             </tr>
            
            ';
        }

        echo $html;

    }

    public function Costinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $tableData = $this->input->post('tableData');
        $totalcost=$this->input->post('totalcost');
        $hiddentotalcost=$this->input->post('hiddentotalcost');
        $unitprice=$this->input->post('unitprice');
        $qty=$this->input->post('qty');
        $productid=$this->input->post('productid');
        $orderid=$this->input->post('orderid');
        $unit=$this->input->post('unit');
        $netsaleprice=$hiddentotalcost + $unitprice;

        $insertdatetime=date('Y-m-d H:i:s');

        foreach($tableData as $rowtabledata){
            $data = array( 

                'adddate'=> $rowtabledata['col_3'], 
                'costamount'=> $rowtabledata['col_6'], 
                'costpercentage'=> $rowtabledata['col_8'], 
                'perunitstatus'=> $rowtabledata['col_9'], 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime,  
                'tbl_user_idtbl_user'=> $userID, 
                'tbl_expence_type_idtbl_expence_type'=> $rowtabledata['col_5'], 
                'tbl_customer_porder_idtbl_customer_porder'=> $rowtabledata['col_10'], 
                'tbl_product_idtbl_product'=> $rowtabledata['col_1']

                
            );

            $this->db->insert('tbl_customer_porder_cost', $data);  

        }

            $this->db->select('SUM(costamount) AS sumcost');
            $this->db->from('tbl_customer_porder_cost');
            $this->db->where('tbl_customer_porder_idtbl_customer_porder', $orderid);
            $this->db->where('tbl_product_idtbl_product', $productid);

            $respond=$this->db->get();

            $totalcostamount=$respond->row(0)->sumcost;

            $data = array(
                'othercost' => $totalcostamount,
            );
            $this->db->where('tbl_customer_porder_idtbl_customer_porder', $orderid);
            $this->db->where('tbl_product_idtbl_product', $productid);
            $this->db->update('tbl_customer_porder_detail', $data);
            
            
            $this->db->select('netsaleprice AS netprice, profitmargin');
            $this->db->from('tbl_customer_porder_detail');
            $this->db->where('tbl_customer_porder_idtbl_customer_porder', $orderid);
            $this->db->where('tbl_product_idtbl_product', $productid);
            
            $respond2 = $this->db->get();

            $previousnetprice = $respond2->row(0)->netprice;


            $finalnetsaleprice;

            if($previousnetprice == 0){
                $finalnetsaleprice = $previousnetprice + $netsaleprice;
            }else{
                $finalnetsaleprice=$previousnetprice+$hiddentotalcost;
            }

            $finalnetsaleprice=($finalnetsaleprice*(100+$respond2->row(0)->profitmargin))/100;

            // $data2 = array(
            //     'netsaleprice' => $netsaleprice,
            // );
            
            $this->db->where('tbl_customer_porder_idtbl_customer_porder', $orderid);
            $this->db->where('tbl_product_idtbl_product', $productid);
            $this->db->update('tbl_customer_porder_detail', array('netsaleprice' => $finalnetsaleprice));

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Added Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                // redirect('Salesordercost');                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                // redirect('Salesordercost');
            }  
    }
}