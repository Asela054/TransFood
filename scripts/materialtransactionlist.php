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
$table = 'tbl_transfer_fg';

// Table's primary key
$primaryKey = 'idtbl_transfer_fg';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => '`u`.`idtbl_transfer_fg`', 'dt' => 'idtbl_transfer_fg', 'field' => 'idtbl_transfer_fg' ),
    array( 'db' => '`ub`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`ua`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
    array( 'db' => '`ua`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
    array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`fl`.`location`', 'dt' => 'fromlocation', 'field' => 'fromlocation', 'as' => 'fromlocation'  ),
    array( 'db' => '`tl`.`location`', 'dt' => 'tolocation', 'field' => 'tolocation', 'as' => 'tolocation'  ),
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

require('ssp.customized.class.php');

$companyid=$_SESSION['companyid'];
$branchid=$_SESSION['branchid'];

$joinQuery = "FROM `tbl_transfer_fg` AS `u`
JOIN `tbl_transfer_fg_detail` AS `ua` ON (`u`.`idtbl_transfer_fg` = `ua`.`tbl_transfer_fg_idtbl_transfer_fg`)
JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product`)
JOIN `tbl_location` AS `fl` ON (`fl`.`idtbl_location` = `u`.`fromlocation`)
JOIN `tbl_location` AS `tl` ON (`tl`.`idtbl_location` = `u`.`tolocation`)";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);