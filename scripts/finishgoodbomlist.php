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
$table = 'tbl_product';

// Table's primary key
$primaryKey = 'idtbl_product';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_product`', 'dt' => 'idtbl_product', 'field' => 'idtbl_product' ),
	array( 'db' => '`u`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
	array( 'db' => '`u`.`prodcutname`', 'dt' => 'prodcutname', 'field' => 'prodcutname' ),
	array( 'db' => '`ud`.`idtbl_product_bom`', 'dt' => 'idtbl_product_bom', 'field' => 'idtbl_product_bom' ),
	array( 'db' => '`ue`.`title`', 'dt' => 'title', 'field' => 'title' ),
	array( 'db' => '`ue`.`idtbl_product_bom_info`', 'dt' => 'idtbl_product_bom_info', 'field' => 'idtbl_product_bom_info' ),
	array( 'db' => '`ue`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM `tbl_product` AS `u` 
LEFT JOIN `tbl_product_bom` AS `ud` ON (`ud`.`tbl_product_idtbl_product` = `u`.`idtbl_product`)
LEFT JOIN `tbl_product_bom_info` AS `ue` ON (`ue`.`idtbl_product_bom_info` = `ud`.`tbl_product_bom_info_idtbl_product_bom_info`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`idtbl_product`=`ud`.`tbl_product_idtbl_product`";

$groupBy ="`ud`.`tbl_product_bom_info_idtbl_product_bom_info`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
