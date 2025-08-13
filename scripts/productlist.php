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
	array( 'db' => '`ub`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`barcode`', 'dt' => 'barcode', 'field' => 'barcode' ),
	array( 'db' => '`u`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`u`.`weight`', 'dt' => 'weight', 'field' => 'weight' ),
	array( 'db' => '`u`.`retailprice`', 'dt' => 'retailprice', 'field' => 'retailprice' ),
	array( 'db' => '`u`.`wholesaleprice`', 'dt' => 'wholesaleprice', 'field' => 'wholesaleprice' ),
	array( 'db' => '`ub`.`materialcode`', 'dt' => 'materialcode', 'field' => 'materialcode' ),
    array( 'db' => '`uc`.`formname`', 'dt' => 'formname', 'field' => 'formname' ),
	array( 'db' => '`ud`.`gradename`', 'dt' => 'gradename', 'field' => 'gradename' ),
    array( 'db' => '`ue`.`brandname`', 'dt' => 'brandname', 'field' => 'brandname' ),
	array( 'db' => '`uf`.`sizename`', 'dt' => 'sizename', 'field' => 'sizename' ),
	array( 'db' => '`ug`.`unittypecode`', 'dt' => 'unittypecode', 'field' => 'unittypecode' ),
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

$joinQuery = "FROM `tbl_product` AS `u` LEFT JOIN `tbl_material_code` AS `ub` ON `u`.`materialid` = `ub`.`idtbl_material_code` 
LEFT JOIN `tbl_form` AS `uc` ON `u`.`formid` = `uc`.`idtbl_form` LEFT JOIN `tbl_grade` AS `ud` ON `u`.`gradeid` = `ud`.`idtbl_grade`
LEFT JOIN `tbl_brand` AS `ue` ON `u`.`brandid` = `ue`.`idtbl_brand` LEFT JOIN `tbl_size` AS `uf` ON `u`.`sizeid` = `uf`.`idtbl_size` LEFT JOIN `tbl_unit_type` AS `ug` ON `u`.`typeid` = `ug`.`idtbl_unit_type`";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
