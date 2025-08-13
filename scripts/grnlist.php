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
$table = 'ops_grn';

// Table's primary key
$primaryKey = 'idops_grn';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idops_grn`', 'dt' => 'idops_grn', 'field' => 'idops_grn' ),
	array( 'db' => '`u`.`supplier_name`', 'dt' => 'supplier_name', 'field' => 'supplier_name' ),
	array( 'db' => '`u`.`supplier_invoice_no`', 'dt' => 'supplier_invoice_no', 'field' => 'supplier_invoice_no' ),
	array( 'db' => '`u`.`supplier_invoice_date`', 'dt' => 'supplier_invoice_date', 'field' => 'supplier_invoice_date' ),
	array( 'db' => '`u`.`other_chargers`', 'dt' => 'other_chargers', 'field' => 'other_chargers' ),
	array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
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

$joinQuery = "FROM `ops_grn` AS `u`";

$extraWhere = "`u`.`status`='1'";

$i=1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
