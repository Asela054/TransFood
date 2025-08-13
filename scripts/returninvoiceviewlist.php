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
$table = 'tbl_invoice';

// Table's primary key
$primaryKey = 'idtbl_invoice';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_invoice`', 'dt' => 'idtbl_invoice', 'field' => 'idtbl_invoice' ),
	array( 'db' => '`u`.`invdate`', 'dt' => 'invdate', 'field' => 'invdate' ),
    array( 'db' => '`u`.`invtype`', 'dt' => 'invtype', 'field' => 'invtype' ),
	array( 'db' => '`ue`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ub`.`productcode`', 'dt' => 'productcode', 'field' => 'productcode' ),
	array( 'db' => '`ua`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`returnstatus`', 'dt' => 'returnstatus', 'field' => 'returnstatus' ),
	array( 'db' => '`u`.`grosstotal`', 'dt' => 'grosstotal', 'field' => 'grosstotal' ),
    array( 'db' => '`u`.`discount`', 'dt' => 'discount', 'field' => 'discount' ),
    array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
    array( 'db' => '`ua`.`total`', 'dt' => 'total', 'field' => 'total' ),
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

$joinQuery = "FROM `tbl_invoice` AS `u` LEFT JOIN `tbl_invoice_detail` AS `ua` ON (`ua`.`idtbl_invoice_detail` = `ua`.`tbl_invoice_idtbl_invoice`)
LEFT JOIN `tbl_product` AS `ub` ON (`ub`.`idtbl_product` = `ua`.`tbl_product_idtbl_product`) 
LEFT JOIN `tbl_customer_porder` AS `uc` ON (`uc`.`idtbl_customer_porder` = `u`.`tbl_customer_porder_idtbl_customer_porder`)
LEFT JOIN `tbl_customer` AS `ud` ON (`ud`.`idtbl_customer` = `uc`.`tbl_customer_idtbl_customer`)
LEFT JOIN `tbl_location` AS `ue` ON (`ue`.`idtbl_location` = `u`.`tbl_location_idtbl_location`)";

if(!empty($_POST['customer'])){ 
$customer = $_POST['customer'];

$extraWhere = "`u`.`status` IN (1,2) AND `uc`.`tbl_customer_idtbl_customer`= '$customer'";
}
$groupBy = "`u`.`idtbl_invoice`";

$i=1;
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy)
);
