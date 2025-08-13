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
$table = 'ops_product';

// Table's primary key
$primaryKey = 'idops_product';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idops_product`', 'dt' => 'idops_product', 'field' => 'idops_product' ),
	array( 'db' => '`u`.`code`', 'dt' => 'code', 'field' => 'code' ),
	array( 'db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'category', 'field' => 'category', 'as' => 'category' ),
	array( 'db' => '`ud`.`idops_product_category`', 'dt' => 'idops_product_category', 'field' => 'idops_product_category' ),
	array( 'db' => '`ue`.`pack_count`', 'dt' => 'pack_count', 'field' => 'pack_count' ),
	array( 'db' => '`ue`.`count`', 'dt' => 'count', 'field' => 'count' ),
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

$joinQuery = "FROM `ops_product` AS `u` JOIN `ops_product_category` AS `ud` ON (`ud`.`idops_product_category` = `u`.`idops_product_category`) JOIN `ops_stock` AS `ue` ON (`ue`.`idops_product` = `u`.`idops_product`)";

$extraWhere = "`u`.`status`='1'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
