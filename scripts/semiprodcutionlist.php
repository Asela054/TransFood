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
$table = 'tbl_semi_production';

// Table's primary key
$primaryKey = 'idtbl_semi_production';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`main`.`idtbl_semi_production`', 'dt' => 'idtbl_semi_production', 'field' => 'idtbl_semi_production' ),
	array( 'db' => '`main`.`procode`', 'dt' => 'procode', 'field' => 'procode' ),
	array( 'db' => '`main`.`prodate`', 'dt' => 'prodate', 'field' => 'prodate' ),
	array( 'db' => '`main`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode' ),
	array( 'db' => '`main`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname' ),
	// array( 'db' => '`main`.`materialcode`', 'dt' => 'materialcode', 'field' => 'materialcode' ),
	array( 'db' => '`main`.`qty_semi_production`', 'dt' => 'qty_semi_production', 'field' => 'qty_semi_production' ),
	array( 'db' => '`main`.`issueqty_semi_production`', 'dt' => 'issueqty_semi_production', 'field' => 'issueqty_semi_production' ),
	array( 'db' => '`main`.`qty_daily_complete`', 'dt' => 'qty_daily_complete', 'field' => 'qty_daily_complete' ),
	array( 'db' => '`main`.`damageqty`', 'dt' => 'damageqty', 'field' => 'damageqty' ),
	array( 'db' => '`main`.`startdatetime`', 'dt' => 'startdatetime', 'field' => 'startdatetime' ),
	array( 'db' => '`main`.`enddatetime`', 'dt' => 'enddatetime', 'field' => 'enddatetime' ),
	array( 'db' => '`main`.`grnstatus`', 'dt' => 'grnstatus', 'field' => 'grnstatus' ),
	array( 'db' => '`main`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`main`.`partialissue`', 'dt' => 'partialissue', 'field' => 'partialissue' ),
	array( 'db' => '`main`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "FROM (SELECT
`u`.`idtbl_semi_production` AS `idtbl_semi_production`,
LPAD(`u`.`procode`, 6, '0') AS `procode`,
`u`.`prodate` AS `prodate`,
`ua`.`materialinfocode` AS `materialinfocode`,
`ua`.`materialname` AS `materialname`,
`uc`.`qty` AS `qty_daily_complete`,
`ud`.`startdatetime` AS `startdatetime`,
`ud`.`enddatetime` AS `enddatetime`,
`u`.`qty` AS `qty_semi_production`,
`u`.`issueqty` AS `issueqty_semi_production`,
`uc`.`damageqty` AS `damageqty`,
`u`.`grnstatus` AS `grnstatus`,
`u`.`approvestatus` AS `approvestatus`,
`u`.`partialissue` AS `partialissue`,
`u`.`status` AS `status`
FROM `tbl_semi_production` AS `u`
LEFT JOIN `tbl_material_info` AS `ua` ON (`ua`.`idtbl_material_info` = `u`.`tbl_material_info_idtbl_material_info`)
LEFT JOIN `tbl_semi_production_daily_complete` AS `uc` ON (`u`.`idtbl_semi_production` = `uc`.`tbl_semi_production_idtbl_semi_production`)
LEFT JOIN `tbl_machine_allocation` AS `ud` ON (`u`.`idtbl_semi_production` = `ud`.`tbl_semi_production_idtbl_semi_production`)
WHERE `u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid' GROUP BY `u`.`idtbl_semi_production`
) AS main";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
