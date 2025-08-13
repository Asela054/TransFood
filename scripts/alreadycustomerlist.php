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
$table = 'tbl_customer';

// Table's primary key
$primaryKey = 'idtbl_customer';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
	array( 'db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`u`.`customercode`', 'dt' => 'customercode', 'field' => 'customercode' ),
	array( 'db' => '`u`.`customertype`', 'dt' => 'customertype', 'field' => 'customertype' ),
	array( 'db' => '`u`.`contact`', 'dt' => 'contact', 'field' => 'contact' ),
    array( 'db' => '`u`.`nicno`', 'dt' => 'nicno', 'field' => 'nicno' ),
	array( 'db' => '`u`.`status`',   'dt' => 'status', 'field' => 'status' ),
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

$joinQuery = "FROM `tbl_customer` AS `u`";

// if(!empty($_POST['searchtype'])){$searchtype=$_POST['searchtype'];}else{$searchtype='';}
// if(!empty($_POST['externalsearch'])){$externalsearch=$_POST['externalsearch'];}else{$externalsearch='';}
$searchtype=$_POST['searchtype'];
$searchbox=$_POST['searchbox'];


$extraWhere = "`u`.`status` IN (1,2)";
if($searchtype==1){$extraWhere .= " AND `u`.`name` LIKE '$searchbox%'";}
else if($searchtype==2){$extraWhere .= " AND `u`.`customercode` LIKE '$searchbox%'";}
else if($searchtype==3){$extraWhere .= " AND `u`.`contact` AND `u`.`contact2` LIKE '$searchbox%'";}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);