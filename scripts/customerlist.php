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
$table = 'tbl_customer';

// Table's primary key
$primaryKey = 'idtbl_customer';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
	array( 'db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`u`.`customercode`', 'dt' => 'customercode', 'field' => 'customercode' ),
	array( 'db' => '`drv`.`ds`', 'dt' => 'ds', 'field' => 'ds' ),
	array( 'db' => '`u`.`contact`', 'dt' => 'contact', 'field' => 'contact' ),
    array( 'db' => '`u`.`contact2`', 'dt' => 'contact2', 'field' => 'contact2' ),
    array( 'db' => '`u`.`email`', 'dt' => 'email', 'field' => 'email' ),
    array( 'db' => '`u`.`address`', 'dt' => 'address', 'field' => 'address' ),
	array( 'db' => '`u`.`gstinno`', 'dt' => 'gstinno', 'field' => 'gstinno' ),
    array( 'db' => '`u`.`panno`', 'dt' => 'panno', 'field' => 'panno' ),
    array( 'db' => '`u`.`ieccode`', 'dt' => 'ieccode', 'field' => 'ieccode' ),
    array( 'db' => '`u`.`fssaino`', 'dt' => 'fssaino', 'field' => 'fssaino' ),
	array( 'db' => '`u`.`bankname`', 'dt' => 'bankname', 'field' => 'bankname' ),
    array( 'db' => '`u`.`bankbranch`', 'dt' => 'bankbranch', 'field' => 'bankbranch' ),
    array( 'db' => '`u`.`accountno`', 'dt' => 'accountno', 'field' => 'accountno' ),
    array( 'db' => '`u`.`accountname`', 'dt' => 'accountname', 'field' => 'accountname' ),
	array( 'db' => '`u`.`bankaddress`', 'dt' => 'bankaddress', 'field' => 'bankaddress' ),
    array( 'db' => '`u`.`swiftcode`', 'dt' => 'swiftcode', 'field' => 'swiftcode' ),
    array( 'db' => '`u`.`ifscno`', 'dt' => 'ifscno', 'field' => 'ifscno' ),
	array( 'db' => '`u`.`intemediarybank`', 'dt' => 'intemediarybank', 'field' => 'intemediarybank' ),
	array( 'db' => '`u`.`inteswiftcode`', 'dt' => 'inteswiftcode', 'field' => 'inteswiftcode' ),
    array( 'db' => '`u`.`accountinstitution`', 'dt' => 'accountinstitution', 'field' => 'accountinstitution' ),
    array( 'db' => '`u`.`insswiftcode`', 'dt' => 'insswiftcode', 'field' => 'insswiftcode' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
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

$joinQuery = "FROM `tbl_customer` AS `u` JOIN (SELECT 1 AS type, 'Local' AS ds UNION ALL SELECT 2 AS type, 'Export' AS ds) AS drv ON `u`.`customertype`= drv.type";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
