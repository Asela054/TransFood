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
$table = 'tbl_production_packing';

// Table's primary key
$primaryKey = 'idtbl_production_packing';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_production_packing`', 'dt' => 'idtbl_production_packing', 'field' => 'idtbl_production_packing' ),
	array( 'db' => '`ug`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`ue`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
    array( 'db' => '`uf`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	array( 'db' => '`ua`.`procode`', 'dt' => 'procode', 'field' => 'procode' ),
    array( 'db' => '`ub`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
    array( 'db' => '`ua`.`prodate`', 'dt' => 'prodate', 'field' => 'prodate' ),
    array( 'db' => '`ua`.`prostartdate`', 'dt' => 'prostartdate', 'field' => 'prostartdate' ),
    array( 'db' => '`ua`.`proenddate`', 'dt' => 'proenddate', 'field' => 'proenddate' ),
    array( 'db' => '`ub`.`unitprice`', 'dt' => 'unitprice', 'field' => 'unitprice' ),
    array( 'db' => '`ub`.`total`', 'dt' => 'total', 'field' => 'total' ),
    array( 'db' => '`uc`.`idtbl_production_material`', 'dt' => 'idtbl_production_material', 'field' => 'idtbl_production_material' ),
    array( 'db' => '`uc`.`passfail`', 'dt' => 'passfail', 'field' => 'passfail' ),
    array( 'db' => '`uh`.`qualitycheck`', 'dt' => 'qualitycheck', 'field' => 'qualitycheck' ),
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

$joinQuery = "FROM `tbl_production_packing` AS `u`
LEFT JOIN `tbl_production_order` AS `ua` ON `ua`.`idtbl_production_order` = `u`.`tbl_production_order_idtbl_production_order`
LEFT JOIN `tbl_production_orderdetail` AS `ub` ON `ub`.`tbl_production_order_idtbl_production_order`=`ua`.`idtbl_production_order`
LEFT JOIN `tbl_production_material` AS `uc` ON `uc`.`tbl_production_order_idtbl_production_order`=`u`.`tbl_production_order_idtbl_production_order`
LEFT JOIN `tbl_production_material_issue` AS `ud` ON `ud`.`tbl_production_material_idtbl_production_material`=`uc`.`idtbl_production_material`
LEFT JOIN `tbl_material_info` AS `ue` ON `ue`.`idtbl_material_info` = `uc`.`tbl_material_info_idtbl_material_info`
LEFT JOIN `tbl_material_code` AS `uf` ON `uf`.`idtbl_material_code`=`ue`.`tbl_material_code_idtbl_material_code`
LEFT JOIN `tbl_product` AS `ug` ON `ug`.`idtbl_product` = `u`.`tbl_product_idtbl_product`
LEFT JOIN `tbl_production_lable` AS `uh` ON `uh`.`tbl_production_material_issue_idtbl_production_material_issue`=`ud`.`idtbl_production_material_issue`";

$extraWhere = "`u`.`status` IN (1, 2) AND `uc`.`approvestatus`=1 AND `uc`.`productiontype`=2";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
