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
	array( 'db' => '`u`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`u`.`reorderlevel`', 'dt' => 'reorderlevel', 'field' => 'reorderlevel' ),
	array( 'db' => '`u`.`comment`', 'dt' => 'comment', 'field' => 'comment' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`ua`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`ua`.`materialcode`', 'dt' => 'materialcode', 'field' => 'materialcode' ),
	array( 'db' => '`ub`.`categoryname`', 'dt' => 'categoryname', 'field' => 'categoryname' ),
	array( 'db' => '`uc`.`brandcode`', 'dt' => 'brandcode', 'field' => 'brandcode' ),
	array( 'db' => '`ud`.`unitcode`', 'dt' => 'unitcode', 'field' => 'unitcode' ),
	array( 'db' => '`ue`.`formcode`', 'dt' => 'formcode', 'field' => 'formcode' ),
	array( 'db' => '`uf`.`gradecode`', 'dt' => 'gradecode', 'field' => 'gradecode' ),
	array( 'db' => '`ug`.`sizecode`', 'dt' => 'sizecode', 'field' => 'sizecode' ),
	array( 'db' => '`uh`.`sidecode`', 'dt' => 'sidecode', 'field' => 'sidecode' ),
	array( 'db' => '`ui`.`unittypecode`', 'dt' => 'unittypecode', 'field' => 'unittypecode' )
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

$joinQuery = "FROM `tbl_material_info` AS `u` LEFT JOIN `tbl_material_code` AS `ua` ON (`ua`.`idtbl_material_code` = `u`.`tbl_material_code_idtbl_material_code`) LEFT JOIN `tbl_material_category` AS `ub` ON (`ub`.`idtbl_material_category` = `u`.`tbl_material_category_idtbl_material_category`) LEFT JOIN `tbl_brand` AS `uc` ON (`uc`.`idtbl_brand` = `u`.`tbl_brand_idtbl_brand`) LEFT JOIN `tbl_unit` AS `ud` ON (`ud`.`idtbl_unit` = `u`.`tbl_unit_idtbl_unit`) LEFT JOIN `tbl_form` AS `ue` ON (`ue`.`idtbl_form` = `u`.`tbl_form_idtbl_form`) LEFT JOIN `tbl_grade` AS `uf` ON (`uf`.`idtbl_grade` = `u`.`tbl_grade_idtbl_grade`) LEFT JOIN `tbl_size` AS `ug` ON (`ug`.`idtbl_size` = `u`.`tbl_size_idtbl_size`) LEFT JOIN `tbl_side` AS `uh` ON (`uh`.`idtbl_side` = `u`.`tbl_side_idtbl_side`) LEFT JOIN `tbl_unit_type` AS `ui` ON (`ui`.`idtbl_unit_type` = `u`.`tbl_unit_type_idtbl_unit_type`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`semistatus`=1";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
