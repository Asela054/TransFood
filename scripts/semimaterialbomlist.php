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
$table = 'tbl_semi_bom_info';

// Table's primary key
$primaryKey = 'idtbl_semi_bom_info';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_semi_bom_info`', 'dt' => 'idtbl_semi_bom_info', 'field' => 'idtbl_semi_bom_info' ),
	array( 'db' => '`u`.`semimaterial`', 'dt' => 'semimaterial', 'field' => 'semimaterial' ),
	array( 'db' => '`u`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`u`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`u`.`title`', 'dt' => 'title', 'field' => 'title' ),
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

$joinQuery = "FROM (SELECT * FROM (SELECT `idtbl_semi_bom_info`, `title`, `status` FROM `tbl_semi_bom_info` WHERE `status` IN (1, 2)) AS `dmain` LEFT JOIN (SELECT `tbl_semi_bom`.`tbl_semi_bom_info_idtbl_semi_bom_info`, `tbl_semi_bom`.`semimaterial`, `tbl_material_info`.`materialinfocode`, `tbl_material_code`.`materialname` FROM `tbl_semi_bom` LEFT JOIN `tbl_material_info` ON `tbl_material_info`.`idtbl_material_info`=`tbl_semi_bom`.`semimaterial` LEFT JOIN `tbl_material_code` ON `tbl_material_code`.`idtbl_material_code`=`tbl_material_info`.`tbl_material_code_idtbl_material_code` WHERE `tbl_semi_bom`.`status` IN (1, 2) GROUP BY `tbl_semi_bom`.`tbl_semi_bom_info_idtbl_semi_bom_info`) AS `dsub` ON `dsub`.`tbl_semi_bom_info_idtbl_semi_bom_info`=`dmain`.`idtbl_semi_bom_info`) AS `u`";

$extraWhere = "";

$groupBy ="";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
