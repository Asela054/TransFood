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
$table = 'tbl_miscellaneous';

// Table's primary key
$primaryKey = 'idtbl_miscellaneous';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_miscellaneous`', 'dt' => 'idtbl_miscellaneous', 'field' => 'idtbl_miscellaneous' ),
    array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
	array( 'db' => '`u`.`type`', 'dt' => 'type', 'field' => 'type' ),
    array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`ua`.`company`', 'dt' => 'company', 'field' => 'company' ),
    array( 'db' => '`ub`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
    array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
    array(
    'db' => "CONCAT(
        CASE 
            WHEN `u`.`approvestatus` = 1 THEN '<i class=\"fas fa-check text-success mr-2\"></i>Approved Ammendment'
            WHEN `u`.`approvestatus` = 2 THEN '<i class=\"fa fa-times text-danger mr-2\"></i>Reject Ammendment'
            ELSE '<i class=\"fa fa-spinner text-warning mr-2\"></i>Pending Ammendment for Approval'
        END
    )",
    'dt' => 'approvestatus_display',
    'field' => 'approvestatus_display',
    'as' => 'approvestatus_display'
    ),
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

$joinQuery = "FROM `tbl_miscellaneous` AS `u`
LEFT JOIN `tbl_company` AS `ua` ON (`ua`.`idtbl_company` = `u`.`tbl_company_idtbl_company`)
LEFT JOIN `tbl_company_branch` AS `ub` ON (`u`.`tbl_company_branch_idtbl_company_branch` = `ub`.`idtbl_company_branch`)";


$extraWhere = "`u`.`status`=1 AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

$i = 1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
