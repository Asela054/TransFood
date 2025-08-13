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
$table = 'tbl_semi_bom_other_cost';

// Table's primary key
$primaryKey = 'idtbl_semi_bom_other_cost';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`main`.`idtbl_semi_bom_other_cost`', 'dt' => 'idtbl_semi_bom_other_cost', 'field' => 'idtbl_semi_bom_other_cost' ),
	array( 'db' => '`main`.`perunit`', 'dt' => 'perunit', 'field' => 'perunit' ),
	array( 'db' => '`main`.`expencetype`', 'dt' => 'expencetype', 'field' => 'expencetype' ),
	array( 'db' => '`main`.`selection_status`', 'dt' => 'selection_status', 'field' => 'selection_status' ),
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

$bomID=$_POST['recordID'];

$joinQuery = "FROM (SELECT 
    u.idtbl_semi_bom_other_cost,
    u.perunit,
    u.status,
    ua.expencetype,
    CASE 
        WHEN ub.tbl_semi_bom_other_cost_idtbl_semi_bom_other_cost IS NOT NULL THEN '1'
        ELSE '0'
    END AS selection_status
FROM `tbl_semi_bom_other_cost` AS u
LEFT JOIN `tbl_expence_type` AS ua 
    ON ua.`idtbl_expence_type` = u.`tbl_expence_type_idtbl_expence_type`
LEFT JOIN `tbl_semi_bom_info_has_tbl_semi_bom_other_cost` AS ub 
    ON ub.`tbl_semi_bom_other_cost_idtbl_semi_bom_other_cost` = u.`idtbl_semi_bom_other_cost`
    AND ub.tbl_semi_bom_info_idtbl_semi_bom_info = '$bomID'
WHERE u.`status` IN (1, 2)) AS `main`";

$extraWhere = "";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
