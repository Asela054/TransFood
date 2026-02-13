<?php
require_once '../external.php';

$CI =& get_instance();
$CI->load->library('session');
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented and probably shouldn't be used as
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
$table = 'tbl_stock';

// Table's primary key
$primaryKey = 'idtbl_stock';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => '`main`.`idtbl_stock`', 'dt' => 'idtbl_stock', 'field' => 'idtbl_stock'),
    array('db' => '`main`.`total_qty`', 'dt' => 'total_qty', 'field' => 'total_qty'),
    array('db' => '`main`.`materialname`', 'dt' => 'materialname', 'field' => 'materialname'),
    array('db' => '`main`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode'),
    array('db' => '`main`.`materialinfocode`', 'dt' => 'materialinfocode', 'field' => 'materialinfocode'),
    array('db' => '`main`.`avgunitprice`', 'dt' => 'avgunitprice', 'field' => 'avgunitprice')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

require('ssp.customized.class.php' );

$companyid=$_SESSION['companyid'];
$branchid=$_SESSION['branchid'];

$joinQuery = "FROM (SELECT u.idtbl_stock AS idtbl_stock, u.currencytype AS currencytype, SUM(u.qty) AS total_qty,ua.materialinfocode AS materialinfocode,ua.materialname AS materialname,u.status AS status, AVG(u.unitprice) AS avgunitprice FROM tbl_stock AS u JOIN tbl_material_info AS ua ON (ua.idtbl_material_info = u.tbl_material_info_idtbl_material_info) WHERE u.status IN (1, 2) AND u.qty > 0  AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid' GROUP BY ua.materialinfocode) AS main";

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);