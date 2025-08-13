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
$table = 'tbl_grn';

// Table's primary key
$primaryKey = 'idtbl_grn';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_grn`', 'dt' => 'idtbl_grn', 'field' => 'idtbl_grn' ),
	array( 'db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
    array( 'db' => '`drv`.`ds`', 'dt' => 'ds', 'field' => 'ds' ),
    array( 'db' => '`u`.`grndate`', 'dt' => 'grndate', 'field' => 'grndate' ),
    array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`u`.`invoicenum`', 'dt' => 'invoicenum', 'field' => 'invoicenum' ),
    array( 'db' => '`u`.`dispatchnum`', 'dt' => 'dispatchnum', 'field' => 'dispatchnum' ),
	array( 'db' => '`ua`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
    array( 'db' => '`ub`.`location`', 'dt' => 'location', 'field' => 'location' ),
    array( 'db' => '`uc`.`type`', 'dt' => 'type', 'field' => 'type' )
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

$joinQuery = "FROM `tbl_grn` AS `u` JOIN (SELECT 1 AS type, 'Normal GRN' AS ds UNION ALL SELECT 2 AS type, 'Direct GRN' AS ds) AS drv ON `u`.`grntype`= drv.type
JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`)
 JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`)
 JOIN `tbl_order_type` AS `uc` ON (`uc`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)";
 
if(!empty($_POST['search_date'])){ 
$date = $_POST['search_date'];
$extraWhere = "`u`.`status` IN (1,2) AND `u`.grndate = '$date' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
}elseif (!empty($_POST['search_week'])){
$week = $_POST['search_week'];

$weeksep=explode('-W', $week);

$year=$weeksep[0];
$week1=$weeksep[1];

$dto = new DateTime();
$dto->setISODate($year, $week1);
$startDate = $dto->format('Y-m-d');
$dto->modify('+6 days');
$endDate = $dto->format('Y-m-d');

$extraWhere = "`u`.`status` IN (0,1) AND `u`.grndate BETWEEN '$startDate' AND '$endDate' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

}elseif(!empty($_POST['search_month'])){
$month = $_POST['search_month'];
$month_arr = explode('-',$month);
$extraWhere = "`u`.`status` IN (0,1) AND YEAR(`u`.grndate) = '$month_arr[0]' AND Month(`u`.grndate) = '$month_arr[1]' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    

}elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date'])){

$from_date = $_POST['search_from_date'];
$to_date = $_POST['search_to_date'];

$extraWhere = "`u`.`status` IN (1,2) AND `u`.grndate BETWEEN '$from_date' AND '$to_date' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
}elseif(!empty($_POST['report_type'])){
        
	$extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
	}

$i = 1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
);