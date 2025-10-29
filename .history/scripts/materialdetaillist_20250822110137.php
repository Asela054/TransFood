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
$table = 'tbl_material_info';

// Table's primary key
$primaryKey = 'idtbl_material_info';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_material_info`', 'dt' => 'idtbl_material_info', 'field' => 'idtbl_material_info' ),
	array( 'db' => '`u`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`u`.`reorderlevel`', 'dt' => 'reorderlevel', 'field' => 'reorderlevel' ),
	array( 'db' => '`u`.`comment`', 'dt' => 'comment', 'field' => 'comment' ),
	array( 'db' => '`ua`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
	array( 'db' => '`u`.`unitperctn`', 'dt' => 'unitperctn', 'field' => 'unitperctn' ),
	array( 'db' => '`ub`.`categoryname`', 'dt' => 'categoryname', 'field' => 'categoryname' ),
	array( 'db' => '`uc`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`ud`.`unitname`', 'dt' => 'unitname', 'field' => 'unitname' ),
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

$joinQuery = "FROM `tbl_material_info` AS `u` 
LEFT JOIN `tbl_material_suppliers` AS `ua` ON (`ua`.`tbl_material_info_idtbl_material_info` = `u`.`idtbl_material_info`) 
LEFT JOIN `tbl_supplier` AS `uc` ON (`uc`.`idtbl_supplier` = `ua`.`tbl_supplier_idtbl_supplier`) 
LEFT JOIN `tbl_material_category` AS `ub` ON (`ub`.`idtbl_material_category` = `u`.`tbl_material_category_idtbl_material_category`) 
LEFT JOIN `tbl_unit` AS `ud` ON (`ud`.`idtbl_unit` = `u`.`tbl_unit_idtbl_unit`)";

$extraWhere = "`u`.`status` IN (1, 2)";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
