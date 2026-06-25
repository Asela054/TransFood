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
$table = 'tbl_porder';

// Table's primary key
$primaryKey = 'idtbl_porder';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
	array( 'db' => '`u`.`idtbl_porder`', 'dt' => 'idtbl_porder', 'field' => 'idtbl_porder' ),
	array( 'db' => '`u`.`currencytype`', 'dt' => 'currencytype', 'field' => 'currencytype' ),
	array( 'db' => '`u`.`po_no`', 'dt' => 'po_no', 'field' => 'po_no' ),
	array( 'db' => '`u`.`class`', 'dt' => 'class', 'field' => 'class' ),
	array( 'db' => '`u`.`orderdate`', 'dt' => 'orderdate', 'field' => 'orderdate' ),
	array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
	array( 'db' => '`u`.`confirmstatus`', 'dt' => 'confirmstatus', 'field' => 'confirmstatus' ),
	array( 'db' => '`u`.`grnconfirm`', 'dt' => 'grnconfirm', 'field' => 'grnconfirm' ),
	array( 'db' => '`u`.`remark`', 'dt' => 'remark', 'field' => 'remark' ),
	array( 'db' => '`ua`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`ub`.`location`', 'dt' => 'location', 'field' => 'location' ),
	array( 'db' => '`uc`.`type`', 'dt' => 'type', 'field' => 'type' ),
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

require('ssp.customized.class.php' );

$companyid=$_SESSION['companyid'];
$branchid=$_SESSION['branchid'];

$joinQuery = "FROM `tbl_porder` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`ua`.`idtbl_supplier` = `u`.`tbl_supplier_idtbl_supplier`) LEFT JOIN `tbl_location` AS `ub` ON (`ub`.`idtbl_location` = `u`.`tbl_location_idtbl_location`) LEFT JOIN `tbl_order_type` AS `uc` ON (`uc`.`idtbl_order_type` = `u`.`tbl_order_type_idtbl_order_type`)";

$baseWhere = "`u`.`status` IN (1,2) AND `u`.`tbl_company_idtbl_company`='$companyid' AND `u`.`tbl_company_branch_idtbl_company_branch`='$branchid'";

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Material search support
 *
 * Materials are stored per PO line (tbl_porder_detail -> tbl_material_info)
 * and are never shown as a DataTable column. To let the existing global
 * search box also match POs by material name/code:
 *
 *   1. Grab the search term DataTables sent ($_POST['search']['value']).
 *   2. Look up which idtbl_porder values have at least one detail line
 *      whose material matches that term.
 *   3. Build our own "OR" group covering (a) the normal visible columns
 *      and (b) those matched PO ids, and pass it in via $extraWhere.
 *   4. Clear $_POST['search']['value'] before calling SSP::simple() so
 *      SSP does not ALSO try to apply its own global search on top of
 *      ours (which would otherwise AND the two together and break things).
 *
 * Column sorting, paging, and per-column filters are untouched — only the
 * global search box behavior is being taken over manually.
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

		// PO ids that have a detail line matching this material name/code.
		$materialIdSql = "
			SELECT DISTINCT `pd`.`tbl_porder_idtbl_porder` AS poid
			FROM `tbl_porder_detail` AS `pd`
			INNER JOIN `tbl_material_info` AS `mi`
				ON `mi`.`idtbl_material_info` = `pd`.`tbl_material_info_idtbl_material_info`
			WHERE `pd`.`status` = 1
			  AND (
			        `mi`.`materialname` LIKE '%{$escapedTerm}%'
			     OR `mi`.`materialinfocode` LIKE '%{$escapedTerm}%'
			      )
		";

		$matchedIds = array();
		if ( $result = $mysqli->query( $materialIdSql ) ) {
			while ( $row = $result->fetch_assoc() ) {
				$matchedIds[] = (int) $row['poid'];
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
			$searchGroupParts[] = "`u`.`idtbl_porder` IN (" . implode( ',', $matchedIds ) . ")";
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