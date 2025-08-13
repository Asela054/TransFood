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
$table = 'tbl_production_fg';

// Table's primary key
$primaryKey = 'idtbl_production_fg';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`main`.`id`', 'dt' => 'id', 'field' => 'id' ),
	array( 'db' => '`main`.`totalqty`', 'dt' => 'totalqty', 'field' => 'totalqty' ),
	array( 'db' => '`main`.`transfgqty`', 'dt' => 'transfgqty', 'field' => 'transfgqty' ),
	array( 'db' => '`main`.`productioncode`', 'dt' => 'productioncode', 'field' => 'productioncode' ),
	array( 'db' => '`main`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`main`.`productid`', 'dt' => 'productid', 'field' => 'productid' ),
	// array( 'db' => '`tbl_production_fg`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM (SELECT (`tbl_production_fg`.`idtbl_production_fg`) AS id, (`tbl_production_fg`.`tbl_product_idtbl_product`) AS productid, SUM(`tbl_production_fg`.`qty`) AS totalqty, SUM(`tbl_production_fg`.`transfgstock`) AS transfgqty, (`tbl_production_order`.`procode`) AS productioncode, (`tbl_product`.`productcode`) AS productcode FROM `tbl_production_fg` LEFT JOIN `tbl_production_order` ON `tbl_production_order`.`idtbl_production_order`=`tbl_production_fg`.`tbl_production_order_idtbl_production_order` LEFT JOIN `tbl_product` ON `tbl_product`.`idtbl_product`=`tbl_production_fg`.`tbl_product_idtbl_product` GROUP BY `tbl_production_fg`.`tbl_product_idtbl_product`) AS main";


// $extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
