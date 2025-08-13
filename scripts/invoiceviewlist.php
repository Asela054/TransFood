<?php
require_once '../external.php';

$CI =& get_instance();
$CI->load->library('session');
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tbl_invoice';

// Table's primary key
$primaryKey = 'idtbl_invoice';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_invoice`', 'dt' => 'idtbl_invoice', 'field' => 'idtbl_invoice' ),
	array( 'db' => '`u`.`invno`', 'dt' => 'invno', 'field' => 'invno' ),
    array( 'db' => '`u`.`invdate`', 'dt' => 'invdate', 'field' => 'invdate' ),
    array( 'db' => '`u`.`invtype`', 'dt' => 'invtype', 'field' => 'invtype' ),
	array( 'db' => '`ue`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ub`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
	array( 'db' => '`ua`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`grosstotal`', 'dt' => 'grosstotal', 'field' => 'grosstotal' ),
    array( 'db' => '`u`.`discount`', 'dt' => 'discount', 'field' => 'discount' ),
    array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
    array( 'db' => '`ua`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$companyid=$_SESSION['companyid'];
$branchid=$_SESSION['branchid'];

$joinQuery = "FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_detail` AS `ua` ON (`ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice`)
LEFT JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product`) 
LEFT JOIN `tbl_customer_porder` AS `uc` ON (`uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder`)
LEFT JOIN `tbl_customer` AS `ud` ON (`ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer`)
LEFT JOIN `tbl_location` AS `ue` ON (`ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location`)";

$extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

if(!empty($_POST['search_date']) && !empty($_POST['search_invoice'])){ 
    $date = $_POST['search_date'];
    $invoice = $_POST['search_invoice'];
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.invdate = '$date' AND `u`.invtype = '$invoice' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    }elseif (!empty($_POST['search_week']) && !empty($_POST['search_invoice'])){
    $week = $_POST['search_week'];
    $invoice = $_POST['search_invoice'];
    
    $weeksep=explode('-W', $week);
    
    $year=$weeksep[0];
    $week1=$weeksep[1];
    
    $dto = new DateTime();
    $dto->setISODate($year, $week1);
    $startDate = $dto->format('Y-m-d');
    $dto->modify('+6 days');
    $endDate = $dto->format('Y-m-d');
    $invoice = $_POST['search_invoice'];
    
    $extraWhere = "`u`.`status` IN (0,1) AND `u`.invtype = '$invoice' AND `u`.invdate BETWEEN '$startDate' AND '$endDate' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    
    }elseif(!empty($_POST['search_month']) && !empty($_POST['search_invoice'])){
    $month = $_POST['search_month'];
    $month_arr = explode('-',$month);
    $invoice = $_POST['search_invoice'];
    $extraWhere = "`u`.`status` IN (0,1) AND `u`.invtype = '$invoice' AND YEAR(`u`.invdate) = '$month_arr[0]' AND Month(`u`.invdate) = '$month_arr[1]' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
        
    
    }elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date']) && !empty($_POST['search_invoice'])){
    
    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    $invoice = $_POST['search_invoice'];
    
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.invtype = '$invoice' AND `u`.invdate BETWEEN '$from_date' AND '$to_date' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    
    }elseif(!empty($_POST['report_type'])){
        
        $extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
        }

    $groupBy = "`u`.`idtbl_invoice`";

$i=1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
