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
$table = 'tbl_grn';

// Table's primary key
$primaryKey = 'idtbl_grn';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_grn`', 'dt' => 'idtbl_grn', 'field' => 'idtbl_grn' ),
	array( 'db' => '`u`.`grn_no`', 'dt' => 'grn_no', 'field' => 'grn_no' ),
	array( 'db' => '`u`.`currencytype`', 'dt' => 'currencytype', 'field' => 'currencytype' ),
	array( 'db' => '`u`.`batchno`', 'dt' => 'batchno', 'field' => 'batchno' ),
	array( 'db' => '`u`.`grndate`', 'dt' => 'grndate', 'field' => 'grndate' ),
	array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
	array( 'db' => '`u`.`invoicenum`', 'dt' => 'invoicenum', 'field' => 'invoicenum' ),
	array( 'db' => '`u`.`dispatchnum`', 'dt' => 'dispatchnum', 'field' => 'dispatchnum' ),
	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
	array( 'db' => '`u`.`qualitycheck`', 'dt' => 'qualitycheck', 'field' => 'qualitycheck' ),
	array( 'db' => '`ua`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`ub`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`uc`.`type`', 'dt' => 'type', 'field' => 'type' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => 'IFNULL(`ud`.`po_no`, \'\')', 'dt' => 'po_no', 'field' => 'po_no', 'as' => 'po_no' ),
	array( 'db' => 'IFNULL(`ud`.`class`, \'\')', 'dt' => 'class', 'field' => 'class', 'as' => 'class' ),
	array( 'db' => '`u`.`receivetype`', 'dt' => 'receivetype', 'field' => 'receivetype' )
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

$joinQuery = "FROM `tbl_grn` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) LEFT JOIN `tbl_order_type` AS `uc` ON (`uc`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`) LEFT JOIN `tbl_porder` AS `ud` ON (`ud`.`idtbl_porder` = `u`.`tbl_porder_idtbl_porder`)"; 

$baseWhere = "`u`.`status` IN (1,2) AND `u`.`grntype`='1' AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Item-wise search support
 *
 * Materials are stored per GRN line (tbl_grndetail -> tbl_material_info)
 * and are not shown as a DataTable column. To let the global search box
 * also match GRNs by material name/code:
 *
 *   1. Grab the search term DataTables sent ($_POST['search']['value']).
 *   2. Look up which idtbl_grn values have at least one detail line
 *      whose material matches that term.
 *   3. Build an "OR" group covering (a) the normal visible columns
 *      and (b) those matched GRN ids, pass it via $extraWhere.
 *   4. Clear $_POST['search']['value'] before calling SSP::simple() so
 *      SSP does not ALSO apply its own global search on top of ours.
 */

$extraWhere = $baseWhere;

$searchTerm = '';
if ( isset( $_POST['search']['value'] ) ) {
	$searchTerm = trim( $_POST['search']['value'] );
}

if ( $searchTerm !== '' ) {

	$mysqli = @new mysqli( $db_host, $db_username, $db_password, $db_name );

	if ( ! $mysqli->connect_errno ) {

		$escapedTerm = $mysqli->real_escape_string( $searchTerm );

		// GRN ids that have a detail line matching this material name/code.
		$materialIdSql = "
			SELECT DISTINCT `gd`.`tbl_grn_idtbl_grn` AS grnid
			FROM `tbl_grndetail` AS `gd`
			INNER JOIN `tbl_material_info` AS `mi`
				ON `mi`.`idtbl_material_info` = `gd`.`tbl_material_info_idtbl_material_info`
			WHERE `gd`.`status` = 1
			  AND (
			        `mi`.`materialname` LIKE '%{$escapedTerm}%'
			     OR `mi`.`materialinfocode` LIKE '%{$escapedTerm}%'
			      )
		";

		$matchedIds = array();
		if ( $result = $mysqli->query( $materialIdSql ) ) {
			while ( $row = $result->fetch_assoc() ) {
				$matchedIds[] = (int) $row['grnid'];
			}
			$result->free();
		}

		// Build the same LIKE conditions SSP would normally apply across
		// the visible columns, so we can OR them together with the
		// material-id match ourselves.
		$columnSearchParts = array();
		foreach ( $columns as $col ) {
			$columnSearchParts[] = "{$col['db']} LIKE '%{$escapedTerm}%'";
		}

		$searchGroupParts = $columnSearchParts;
		if ( ! empty( $matchedIds ) ) {
			$searchGroupParts[] = "`u`.`idtbl_grn` IN (" . implode( ',', $matchedIds ) . ")";
		}

		$extraWhere = "({$baseWhere}) AND (" . implode( ' OR ', $searchGroupParts ) . ")";

		// Prevent SSP from additionally applying its own global search.
		$_POST['search']['value'] = '';

		$mysqli->close();
	}
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
