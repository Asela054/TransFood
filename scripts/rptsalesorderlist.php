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
$table = 'tbl_customer_porder';

// Table's primary key
$primaryKey = 'idtbl_customer_porder';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer_porder`', 'dt' => 'idtbl_customer_porder', 'field' => 'idtbl_customer_porder' ),
	array( 'db' => '`ua`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`ub`.`type`', 'dt' => 'type', 'field' => 'type' ),
    array( 'db' => '`ud`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`u`.`orderdate`', 'dt' => 'orderdate', 'field' => 'orderdate' ),
    array( 'db' => '`u`.`duedate`', 'dt' => 'duedate', 'field' => 'duedate' ),
    array( 'db' => '`u`.`subtotal`', 'dt' => 'subtotal', 'field' => 'subtotal' ),
    array( 'db' => '`u`.`discount`', 'dt' => 'discount', 'field' => 'discount' ),
	array( 'db' => '`u`.`discountamount`', 'dt' => 'discountamount', 'field' => 'discountamount' ),
    array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
	array( 'db' => '`drv`.`ds`', 'dt' => 'ds', 'field' => 'ds' )


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

$joinQuery = "FROM `tbl_customer_porder` AS `u` JOIN (SELECT 0 AS type, 'Not Confirmed' AS ds UNION ALL SELECT 1 AS type, 'Confirmed' AS ds) AS drv ON `u`.`confirmstatus`= drv.type
JOIN `tbl_customer` AS `ua` ON (`ua`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)
  JOIN `tbl_customer_porder_detail` AS `uc` ON (`uc`.`tbl_customer_porder_idtbl_customer_porder` = `u`.`idtbl_customer_porder`)
 JOIN `tbl_order_type` AS `ub` ON (`ub`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)
   JOIN `tbl_product` AS `ud` ON (`ud`.`idtbl_product` = `uc`.`tbl_product_idtbl_product`)";
 
if(!empty($_POST['search_date'])){ 
    $date = $_POST['search_date'];
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.orderdate = '$date' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    $groupBy ="`u`.`idtbl_customer_porder`";

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
    
    $extraWhere = "`u`.`status` IN (0,1) AND `u`.orderdate BETWEEN '$startDate' AND '$endDate' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    $groupBy ="`u`.`idtbl_customer_porder`";

}elseif(!empty($_POST['search_month'])){
    $month = $_POST['search_month'];
    $month_arr = explode('-',$month);
    $extraWhere = "`u`.`status` IN (0,1) AND YEAR(`u`.orderdate) = '$month_arr[0]' AND Month(`u`.orderdate) = '$month_arr[1]' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    $groupBy ="`u`.`idtbl_customer_porder`";

}elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date'])){

    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];

    $extraWhere = "`u`.`status` IN (1,2) AND `u`.orderdate BETWEEN '$from_date' AND '$to_date' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    $groupBy ="`u`.`idtbl_customer_porder`";
}elseif(!empty($_POST['report_type'])){
        
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";
    $groupBy ="`u`.`idtbl_customer_porder`";
    }
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere,$groupBy)
);