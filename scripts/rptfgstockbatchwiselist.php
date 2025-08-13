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
$table = 'tbl_product_stock';

// Table's primary key
$primaryKey = 'idtbl_product_stock';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`main`.`idtbl_product_stock`', 'dt' => 'idtbl_product_stock', 'field' => 'idtbl_product_stock' ),
    array( 'db' => '`main`.`tbl_location_idtbl_location`', 'dt' => 'tbl_location_idtbl_location', 'field' => 'tbl_location_idtbl_location' ),
    array( 'db' => '`main`.`total_qty`', 'dt' => 'total_qty', 'field' => 'total_qty' ),
    array( 'db' => '`main`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
    array( 'db' => '`main`.`location`', 'dt' => 'location', 'field' => 'location' ),
    array( 'db' => '`main`.`status`', 'dt' => 'status', 'field' => 'status' ),
    array( 'db' => '`main`.`avgunitprice`', 'dt' => 'avgunitprice', 'field' => 'avgunitprice' ),
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

$location = $_POST['location'];

$companyid=$_SESSION['companyid'];
$branchid=$_SESSION['branchid'];

$joinQuery = "FROM (SELECT
u.idtbl_product_stock AS 'idtbl_product_stock',
u.tbl_location_idtbl_location AS 'tbl_location_idtbl_location',
u.fgbatchno AS 'fgbatchno',
SUM(u.qty) AS 'total_qty',
ua.productcode AS 'productcode',
ub.location AS 'location',
AVG(u.unitprice) AS avgunitprice,
u.status AS 'status'
FROM
tbl_product_stock AS u
JOIN
tbl_product AS ua ON (ua.idtbl_product = u.tbl_product_idtbl_product)
JOIN
tbl_location AS ub ON (ub.idtbl_location = u.tbl_location_idtbl_location)
WHERE
u.status IN (1, 2)
AND u.tbl_location_idtbl_location = $location AND `u`.`qty` != 0 AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'
GROUP BY ua.productcode) AS main";
 
if(!empty($_POST['location'])){ 
	$location = $_POST['location'];
 $extraWhere = "`main`.`tbl_location_idtbl_location`=$location";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery,$extraWhere)
);