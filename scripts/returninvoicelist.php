<?php

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
$table = 'tbl_invoice_return';

// Table's primary key
$primaryKey = 'idtbl_invoice_return';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_invoice_return`', 'dt' => 'idtbl_invoice_return', 'field' => 'idtbl_invoice_return' ),
	array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`u`.`tbl_invoice_idtbl_invoice`', 'dt' => 'tbl_invoice_idtbl_invoice', 'field' => 'tbl_invoice_idtbl_invoice' ),
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

$joinQuery = "FROM `tbl_invoice_return` AS `u`";

$extraWhere = "`u`.`status` IN (1,2)";

if(!empty($_POST['search_date'])){ 
    $date = $_POST['search_date'];
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.date = '$date'";
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
    
    $extraWhere = "`u`.`status` IN (0,1) AND `u`.date BETWEEN '$startDate' AND '$endDate'";
    
    }elseif(!empty($_POST['search_month'])){
    $month = $_POST['search_month'];
    $month_arr = explode('-',$month);
    $extraWhere = "`u`.`status` IN (0,1) AND YEAR(`u`.date) = '$month_arr[0]' AND Month(`u`.date) = '$month_arr[1]'";
        
    
    }elseif(!empty($_POST['search_from_date'] && $_POST['search_to_date'])){
    
    $from_date = $_POST['search_from_date'];
    $to_date = $_POST['search_to_date'];
    
    $extraWhere = "`u`.`status` IN (1,2) AND `u`.date BETWEEN '$from_date' AND '$to_date'";
    
    }elseif(!empty($_POST['report_type'])){
        
        $extraWhere = "`u`.`status` IN (1,2)";
        }

    $groupBy = "`u`.`idtbl_invoice_return`";

$i=1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
