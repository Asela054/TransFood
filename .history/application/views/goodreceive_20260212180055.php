<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Good Receive Note</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Good Receive Note</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
									<thead>
                                            <tr>
                                                <th>#</th>
                                                <th>GRN Date</th>
                                                <th>GRN No</th>
                                                <th>Batch No</th>
                                                <th>Supplier</th>
                                                <th>Total</th>
                                                <th>Approved Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Good Receive Note</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="grndate" id="grndate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Location*</label>
                                    <select class="form-control form-control-sm" name="location" id="location" required>
                                        <option value="">Select</option>
                                        <?php foreach($locationlist->result() as $rowlocationlist){ ?>
                                        <option value="<?php echo $rowlocationlist->idtbl_location ?>"><?php echo $rowlocationlist->location ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Purchase Order</label>
                                    <select class="form-control form-control-sm" name="porder" id="porder">
                                        <option value="">Select</option>
                                        <?php foreach($porderlist->result() as $rowporderlist){ ?>
                                        <option value="<?php echo $rowporderlist->idtbl_porder ?>"><?php echo 'TRFL/PO-'.$rowporderlist->po_no ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
                                    <select class="form-control form-control-sm" name="supplier" id="supplier" required>
                                        <option value="">Select</option>
                                        <?php foreach($supplierlist->result() as $rowsupplierlist){ ?>
                                        <option value="<?php echo $rowsupplierlist->idtbl_supplier ?>"><?php echo $rowsupplierlist->suppliername ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">GRN Type*</label>
									<select class="form-control form-control-sm" name="grntype" id="grntype" required>
										<option value="">Select</option>
										<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
										<option value="<?php echo $rowordertypelist->idtbl_order_type ?>"><?php echo $rowordertypelist->type ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Currency Type*</label>
                                    <select class="form-control form-control-sm" name="currencytype" id="currencytype" required>
                                        <option value="">Select</option>
                                        <option value="1">LKR</option>
                                        <option value="2">USD</option>
                                    </select>
								</div>
								<input type="hidden" class="form-control form-control-sm" name="rate" id="rate">
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label>
                                    <select class="form-control form-control-sm selecter2" name="product" id="product" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">MF Date*</label>
                                    <input type="date" id="mfdate" name="mfdate" class="form-control form-control-sm" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Shelf Life*</label>
                                    <select class="form-control form-control-sm" name="quater" id="quater" required>
                                        <option value="">Select</option>
                                        <option value="1">3 Month</option>
                                        <option value="2">6 Month</option>
                                        <option value="3">9 Month</option>
                                        <option value="4">12 Month</option>
                                        <option value="5">18 Month</option>
                                        <option value="6">24 Month</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">EXP Date*</label>
                                    <input type="date" id="expdate" name="expdate" class="form-control form-control-sm" required>
                                </div>
                            </div>
							<div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Per Ctn*</label>
                                    <input type="text" id="unitperctn" name="unitperctn" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">ctn</label>
                                    <input type="text" id="ctn" name="ctn" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?>>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Qty*</label>
                                    <input type="text" id="newqty" name="newqty" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="unitprice" name="unitprice" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?> value="0">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm" <?php if($editcheck==0){echo 'readonly';} ?>></textarea>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Batch No</label>
                                <input type="text" id="batchno" name="batchno" class="form-control form-control-sm" readonly>
                            </div>
                            <div class="form-row mb-1 d-none">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Invoice No*</label>
                                    <input type="text" id="invoice" name="invoice" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Dispatch No</label>
                                    <input type="text" id="dispatch" name="dispatch" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <div class="scrollbar pb-3" id="style-3">
                            <table class="table table-striped table-bordered table-sm small" id="tableorder">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Comment</th>
                                        <th>MF Date</th>
                                        <th>EXP Date</th>
                                        <th class="d-none">Quater</th>
                                        <th class="d-none">ProductID</th>
                                        <th class="d-none">Unitprice</th>
                                        <th class="d-none">Saleprice</th>
										<th class="text-center">Unit Per Ctn</th>
										<th class="text-center">Ctn</th>
                                        <th class="text-center">Qty</th>
                                        <th class="d-none">HideTotal</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="divtotal">0.00</h1>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create
                                Good Receive Note</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="addCostModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel"><label id="grnno"></label></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-4">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<form action="" autocomplete="off">
									<div class="form-row mb-1">
										<input type="hidden" class="form-control form-control-sm" name="grnid" id="grnid" required>
										<label class="small font-weight-bold text-dark">Costing Type*</label><br>
										<select class="form-control form-control-sm" name="costlist" id="costlist"
											required>
										</select>
									</div>
									<div class="form-row mb-1">
										<label class="small font-weight-bold">Amount*</label>
										<input type="text" class="form-control form-control-sm" name="amount" id="amount" required>
									</div>
									<div class="form-group mt-3 text-right">
										<button type="button" name="BtnAdd" id="BtnAdd" class="btn btn-primary btn-sm  fa-pull-right"><i
												class="fas fa-plus"></i>&nbsp;Add</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table-sm" id="style-2">
									<table class="table table-bordered table-striped  nowrap display" id="tblcost">
										<thead>
											<th class="text-center">Costing Type</th>
											<th class="d-none">Costing ID</th>
											<th class="text-right">Amount</th>
										</thead>
										<tbody id="tblcostbody">

										</tbody>
                                        <tfoot>
											<tr>
												<th class="text-right mr-5" colspan="2">
													<label id="labelcosttotal"></label><br>
													<input type="hidden" class="form-control form-control-sm" name="totalcost"
														id="totalcost">
												</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group mt-2">
							<input type="hidden" name="recordOption" id="recordOption" value="1">
							<input type="hidden" name="recordID" id="recordID" value="">
							<button type="button" id="submitBtn2" class="btn btn-outline-primary btn-sm fa-pull-right"
								<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add
								Costing</button>
						</div>
					</div>
				</div>
			</div>
			</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">View Good Recieve Note</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="GRNView">
				<h4 class="text-right"><label id="grncode"></label></h4>
                <div id="viewhtml"></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="costlistView" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Cost List</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="table" id="style-2">
					<table class="table table-bordered table-striped  nowrap display" id="tblcost">
						<thead>
							<th>#</th>
							<th>Costing Type</th>
							<th>Amount</th>
						</thead>
						<tbody id="viewhtml2"></tbody>
                    </table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="lablemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="lablemodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="lablemodalLabel">&nbsp;</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="formlable">
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Material</label>
						<select name="materiallist" id="materiallist" class="form-control form-control-sm">
                            <option value="">Select</option>
                        </select>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Name</label>
						<input type="text" class="form-control form-control-sm" name="mname" id="mname" readonly>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Code</label>
						<input type="text" class="form-control form-control-sm" name="mcode" id="mcode" readonly>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">GRN No</label>
                        <input type="text" class="form-control form-control-sm" name="grnno" id="grnno" readonly>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">PO No</label>
						<input type="text" class="form-control form-control-sm" name="pono" id="pono" readonly>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">MF Date</label>
						<input type="date" class="form-control form-control-sm" name="lmfdate" id="lmfdate" required>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">EXP Date</label>
						<input type="date" class="form-control form-control-sm" name="lexpdate" id="lexpdate" required>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Batch No</label>
						<input type="text" class="form-control form-control-sm" name="lbatchno" id="lbatchno" required>
					</div>
					<div class="form-group mt-3 text-right">
						<button type="button" class="btn btn-primary btn-sm" id="btncreatelable"><i class="fas fa-print mr-2"></i>Print Lable</button>
						<input type="submit" class="d-none" id="hidesubmitbtn">
						<input type="reset" class="d-none" id="hideresetbtn">
						<input type="hidden" id="hidegrnidlable" value="">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    $(document).on("click", "#BtnAdd", function () {
    	var costList = $("#costlist option:selected").text();
    	var costListid = $('#costlist').val();
    	var Amount = $('#amount').val();

    	$('#tblcost> tbody:last').append('<tr><td class="text-center">' + costList +
    		'</td><td class="text-center d-none">' + costListid + '</td><td class="totalamount text-right">' + Amount + '</td></tr>');

    	$('#costlist').val('');
    	$('#amount').val('');

    	var sum = 0;
    	$(".totalamount").each(function () {
    		sum += parseFloat($(this).text());
    	});

    	var showsum = parseFloat(sum).toFixed(2);

    	$('#labelcosttotal').html('Total:' + showsum);
    	$('#totalcost').val(sum);

    });
    $(document).on("click", "#submitBtn2", function () {

    	var grnID = $('#grnid').val();

    	// get table data into array
    	var tbody = $('#tblcost tbody');
    	if (tbody.children().length > 0) {
    		var jsonObj = []
    		$("#tblcost tbody tr").each(function () {
    			item = {}
    			$(this).find('td').each(function (col_idx) {
    				item["col_" + (col_idx + 1)] = $(this).text();
    			});
    			jsonObj.push(item);
    		});
    	}
    	// console.log(jsonObj);

    	$.ajax({
    		type: "POST",
    		data: {
    			tableData: jsonObj,
    			grnID: grnID,
    		},
    		url: '<?php echo base_url() ?>Goodreceive/Costinsertupdate',
    		success: function (result) {
    			// console.log(result);
    			window.location.reload();
    		}
    	});
    });
    $(document).ready(function () {
    	var addcheck = '<?php echo $addcheck; ?>';
    	var editcheck = '<?php echo $editcheck; ?>';
    	var statuscheck = '<?php echo $statuscheck; ?>';
    	var deletecheck = '<?php echo $deletecheck; ?>';

		sessionStorage.setItem('companyid', '<?php echo $this->session->userdata('companyid'); ?>');

		$('#staticBackdrop').on('shown.bs.modal', function () {
			$('.selecter2').select2({
				width: '100%',
				dropdownParent: $('#staticBackdrop')
			});
        });

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Good Receive Note Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/goodreceivelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "grndate"
                },
				{
                    "data": "idtbl_grn",
                    "render": function(data, type, full) {
                        var grnDate = new Date(full['grndate']);
                        var cutoffDate = new Date("2024-12-10");
                        
                        var companyId = sessionStorage.getItem("companyid");
                        
                        var prefix = "UNKNOWN/GRN";
                        if (companyId == 1) {
                            prefix = "TRFL/GRN";
                        } else if (companyId == 2) {
                            prefix = "TRFL/GRN";
                        }
                        
                        if (grnDate >= cutoffDate) {
                                return prefix + "-" + full['grn_no']; 
                        
                        } else {
                                return prefix + "-" + data;
                        }
                    }
                },
                {
                    "data": "batchno"
                },
                {
                    "data": "suppliername"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['total']).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approvestatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Approved GRN';}
                        else{return 'Not Approved GRN';}
                    }
                },
                {
    				"targets": -1,
    				"className": 'text-right',
    				"data": null,
    				"render": function (data, type, full) {
    					var button = '';
						if (full['approvestatus'] < 2) {
							button += '<a href="<?php echo base_url() ?>Goodreceive/Printgoodreceive/' +full['idtbl_grn'] + '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print PO" class="btn btn-danger btn-sm mr-1"><i class="fas fa-file-pdf"></i></a>';
						}
                        button+='<button class="btn btn-secondary btn-sm btnLabel mr-1" id="'+full['idtbl_grn']+'"><i class="fas fa-tag"></i></button>';
						button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_grn'] + '" value="'+ full['grn_no'] +'"><i class="fas fa-eye"></i></button>';
    					if (full['approvestatus'] == 1 && statuscheck == 1) {
    						button += '<button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
    					} else if(full['approvestatus']==0) {
    						// button += '<a href="<?php echo base_url() ?>Goodreceive/Goodreceivestatus/' + full['idtbl_grn'] + '/1" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';
    						// if (statuscheck != 1) {
    						// 	button += 'd-none';
    						// }
    						// button += '"><i class="fas fa-times"></i></a>';
							if(statuscheck==1){
                                button+='<button class="btn btn-warning btn-sm btnconfirm mr-1" id="'+full['idtbl_grn']+'"><i class="fas fa-times"></i></button>';
                            }
							if(deletecheck==1){
								button+='<button type="button" data-url="Goodreceive/Goodreceivestatus/'+full['idtbl_grn']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
							}	
    					}

    					return button;
    				}
    			}
            ],
			createdRow: function( row, data, dataIndex){
                if(data['approvestatus']  ==  2){
                    $(row).addClass('bg-danger-soft');
                }
            },
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

    	function preparelist(grnid) {
    		// var orderid = $('#orderid').val();
    		//alert(grnid);

    		$.ajax({
    			type: "POST",
    			data: {
    				grnid: grnid
    			},
    			url: '<?php echo base_url() ?>Goodreceive/Getexpencetype',
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i) {
    					html1 += '<option value="' + obj[i].idtbl_expence_type + '">';
    					html1 += obj[i].expencetype;
    					html1 += '</option>';
    				});
    				$('#costlist').empty().append(html1);
    			}
    		});
    	};

    	$('#dataTable tbody').on('click', '.btnAddCosting', function () {
    		var id = $(this).attr('id');

			var grnno = $(this).attr('value');
        	var companyId = sessionStorage.getItem("companyid");

        	var prefix = "UNKNOWN/GRN";
        	if (companyId == 1) {
        		prefix = "TRFL/GRN";
        	} else if (companyId == 2) {
        		prefix = "TRFL/GRN";
        	}

        	var grnNo = prefix + "-" + grnno;
			$('#grnno').html(grnNo);  
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: '<?php echo base_url() ?>Goodreceive/Getgoodreceiveid',
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#addCostModal').modal('show');
    				$('#grnid').val(obj[0].idtbl_grn);

    				preparelist(obj[0].idtbl_grn);

    			}
    		});
    	});
    	$('#dataTable tbody').on('click', '.btnviewcost', function () {
    		var id = $(this).attr('id');
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: '<?php echo base_url() ?>Goodreceive/Getallocatecostlist',
    			success: function (result) { //alert(result);
    				$('#costlistView').modal('show');
    				$('#viewhtml2').html(result);
    			}
    		});
    	});
    	$('#dataTable tbody').on('click', '.btnview', function () {
    		var id = $(this).attr('id');
            var grnno = $(this).attr('value');
        	var companyId = sessionStorage.getItem("companyid");

        	var prefix = "UNKNOWN/GRN";
        	if (companyId == 1) {
        		prefix = "TRFL/GRN";
        	} else if (companyId == 2) {
        		prefix = "TRFL/GRN";
        	}

        	var grnNo = prefix + "-" + grnno;
			$('#grncode').html(grnNo);    		
			$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: '<?php echo base_url() ?>Goodreceive/Goodreceiveview',
    			success: function (result) { //alert(result);
    				$('#viewmodal').modal('show');
					$('.selecter2').select2();
    				$('#viewhtml').html(result);
    			}
    		});
    	});
		$('#dataTable tbody').on('click', '.btnconfirm', function() {
            var id = $(this).attr('id'); 
            Swal.fire({
                title: "Do you want to approve this good receive note?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Approve",
                denyButtonText: `Reject`
            }).then((result) => {
                if (result.isConfirmed) {
                    var confirmnot = 1;
                    confirmgoodreceive(confirmnot, id);
                } else if (result.isDenied) {
                    var confirmnot = 2;
                    confirmgoodreceive(confirmnot, id);
                } 
            });
        });
    	$('#supplier').change(function () {
    		let supplierID = $(this).val();
    		getbatchno();

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: supplierID
    			},
    			url: 'Goodreceive/Getproductaccosupplier',
    			success: function (result) { alert(result);
    				var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i, item) {
    					html1 += '<option value="' + obj[i].idtbl_material_info + '">';
    					html1 += obj[i].materialname + ' / ' + obj[i].materialinfocode;
    					html1 += '</option>';
    				});
    				$('#product').empty().append(html1);
    			}
    		});
    	});
    	$("#formsubmit").click(function () {
    		if (!$("#createorderform")[0].checkValidity()) {
    			// If the form is invalid, submit it. The form won't actually submit;
    			// this will just cause the browser to display the native HTML5 error messages.
    			$("#submitBtn").click();
    		} else {
    			var productID = $('#product').val();
    			var comment = $('#comment').val();
    			var product = $("#product option:selected").text();
    			var unitprice = parseFloat($('#unitprice').val());
    			var newqty = parseFloat($('#newqty').val());
				var unitperctn = parseFloat($('#unitperctn').val());
				var ctn = parseFloat($('#ctn').val());
    			var mfdate = $('#mfdate').val();
    			var quater = $('#quater').val();
    			var expdate = $('#expdate').val();
				// $('.selecter2').select2();

    			var newtotal = parseFloat(unitprice * newqty);

    			var total = parseFloat(newtotal);
    			var showtotal = addCommas(parseFloat(total).toFixed(2));

    			$('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td>' + mfdate + '</td><td>' + expdate + '</td><td class="d-none">' + quater + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + unitperctn + '</td><td class="text-center">' + ctn + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

				$('#product').val('').trigger('change');
    			$('#unitprice').val('');
    			$('#saleprice').val('');
    			$('#comment').val('');
    			$('#newqty').val('');
    			$('#quater').val('');
    			$('#expdate').val('');

    			var sum = 0;
    			$(".total").each(function () {
    				sum += parseFloat($(this).text());
    			});

    			var showsum = addCommas(parseFloat(sum).toFixed(2));

    			$('#divtotal').html('Rs. ' + showsum);
    			$('#hidetotalorder').val(sum);
    			$('#product').focus();
    		}
    	});
    	$('#tableorder').on('click', 'tr', function () {
    		var r = confirm("Are you sure, You want to remove this product ? ");
    		if (r == true) {
    			$(this).closest('tr').remove();

    			var sum = 0;
    			$(".total").each(function () {
    				sum += parseFloat($(this).text());
    			});

    			var showsum = addCommas(parseFloat(sum).toFixed(2));

    			$('#divtotal').html('Rs. ' + showsum);
    			$('#hidetotalorder').val(sum);
    			$('#product').focus();
    		}
    	});
    	$('#tblcost').on('click', 'tr', function () {
    		var r = confirm("Are you sure, You want to remove this cost? ");
    		if (r == true) {
    			$(this).closest('tr').remove();

    			var sum = 0;
    			$(".totalamount").each(function () {
    				sum += parseFloat($(this).text());
    			});

    			var showsum = addCommas(parseFloat(sum).toFixed(2));

    			$('#labelcosttotal').html('Rs. ' + showsum);
    			$('#totalcost').val(sum);
    		}
    	});
    	$('#btncreateorder').click(function () { //alert('IN');
    		$('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Good Receive Note')
    		var tbody = $("#tableorder tbody");

    		if (tbody.children().length > 0) {
    			jsonObj = [];
    			$("#tableorder tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});
    				jsonObj.push(item);
    			});
    			// console.log(jsonObj);

    			var grndate = $('#grndate').val();
    			var remark = $('#remark').val();
    			var total = $('#hidetotalorder').val();
    			var supplier = $('#supplier').val();
    			var location = $('#location').val();
    			var porder = $('#porder').val();
    			var batchno = $('#batchno').val();
    			var invoice = $('#invoice').val();
    			var dispatch = $('#dispatch').val();
    			var grntype = $('#grntype').val();
    			var transportcost = $('#transportcost').val();
    			var unloadcost = $('#unloadcost').val();
    			// alert(orderdate);
    			$.ajax({
    				type: "POST",
    				data: {
    					tableData: jsonObj,
    					grndate: grndate,
    					total: total,
    					remark: remark,
    					supplier: supplier,
    					location: location,
    					porder: porder,
    					invoice: invoice,
    					dispatch: dispatch,
    					batchno: batchno,
    					grntype: grntype,
    					transportcost: transportcost,
    					unloadcost: unloadcost
    				},
    				url: 'Goodreceive/Goodreceiveinsertupdate',
    				success: function (result) { //alert(result);
    					// console.log(result);
    					var obj = JSON.parse(result);
    					if (obj.status == 1) {
    						$('#modalgrnadd').modal('hide');
    						setTimeout(window.location.reload(), 3000);
    					}
    					action(obj.action);
    				}
    			});
    		}

    	});
    	$('#porder').change(function () {
    		var porderID = $(this).val();

			$.ajax({
				type: "POST",
				dataType: "json",
				data: {
					recordID: porderID
				},
				url: 'Goodreceive/Getsupplieraccoporder',
				success: function (result) {
					if(result.error){
						alert(result.error);
						return;
					}
					$('#supplier').val(result.supplier);
					$('#supplier option').each(function () {
						if (!this.selected) {
							$(this).attr('disabled', true);
						}
					});
					$('#currencytype').val(result.currencytype);
					$('#currencytype option').each(function () {
						if (!this.selected) {
							$(this).attr('disabled', true);
						}
					});
					$('#rate').val(result.rate);
					getbatchno();
				}
			});

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: porderID
    			},
    			url: 'Goodreceive/Getproductaccoporder',
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i, item) {
    					html1 += '<option value="' + obj[i].idtbl_material_info + '">';
    					html1 += obj[i].materialname + ' / ' + obj[i].materialinfocode;
    					html1 += '</option>';
    				});
    				$('#product').empty().append(html1);
    			}
    		});

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: porderID
    			},
    			url: 'Goodreceive/Getpordertpeaccoporder',
    			success: function (result) { //alert(result);
    				$('#grntype').val(result);
    			}
    		});
    	});
    	$('#product').change(function () {
    		var productID = $(this).val();
			var porderID = $('#porder').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productID,
					porderID: porderID,
    			},
    			url: 'Goodreceive/Getproductinfoaccoproduct',
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#newqty').val(obj.qty);
    				$('#unitprice').val(obj.unitprice);
					$('#unitperctn').val(obj.unitperctn);
					$('#ctn').val(obj.ctn);
    				$('#comment').val(obj.comment);
    			}
    		});
    	});
    	$('#quater').change(function () {
    		var quaterID = $(this).val();
    		var mfdate = $('#mfdate').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: quaterID,
    				mfdate: mfdate
    			},
    			url: 'Goodreceive/Getexpdateaccoquater',
    			success: function (result) { //alert(result);
    				$('#expdate').val(result);
    			}
    		});
    	});

        $('#dataTable tbody').on('click', '.btnLabel', function () {
    		var id = $(this).attr('id');
			$('#hidegrnidlable').val(id);
            $('#lablemodal').modal('show');

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: '<?php echo base_url() ?>Goodreceive/Getmateriallistaccogrn',
    			success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i, item) {
    					html1 += '<option value="' + obj[i].idtbl_material_info + '">';
    					html1 += obj[i].materialname + ' / ' + obj[i].materialinfocode;
    					html1 += '</option>';
    				});
    				$('#materiallist').empty().append(html1);
    			}
    		});

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Goodreceive/Getgrninfoaccogrnid',
                success: function(result) { //alert(result);
                    // console.log(result);
                    var obj = JSON.parse(result);
                    $('#grnno').val('TRFL|GRN-0000'+id);
                    $('#pono').val('TRFL|POD-0000'+obj.tbl_porder_idtbl_porder);
					$('#lbatchno').val(obj.batchno);
                }
            });
    	});
        $('#materiallist').change(function(){
            let optiontitle = $("#materiallist option:selected").text();
			let materialID = $("#materiallist").val();
            var result = optiontitle.split('/');
            $('#mname').val(result[0]);
            $('#mcode').val(result[1]);

			var grnID=$('#hidegrnidlable').val();

			$.ajax({
                type: "POST",
                data: {
                    recordID: grnID,
					materialID: materialID
                },
                url: '<?php echo base_url() ?>Goodreceive/Getmaterialinfoaccogrnlable',
                success: function(result) { // alert(result);
                    // console.log(result);
                    var obj = JSON.parse(result);
					$('#lmfdate').val(obj.mfdate);
					$('#lexpdate').val(obj.expdate);
                }
            });
        });
        $('#btncreatelable').click(function(){
			if (!$("#formlable")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hidesubmitbtn").click();
            } else {
				let mname = $('#mname').val();
				let mcode = $('#mcode').val();
				let grnno = $('#grnno').val();
				let pono = $('#pono').val();
				let mfdate = $('#lmfdate').val();
				let expdate = $('#lexpdate').val();
				let batchno = $('#lbatchno').val();

				var link ='<?php echo base_url() ?>Goodreceive/Createlabel/'+mname+'/'+mcode+'/'+grnno+'/'+pono+'/'+mfdate+'/'+expdate+'/'+batchno;
				window.open(link, '_blank');
				$('#hideresetbtn').click();
				$('#lablemodal').modal('hide');
			}
		});
    });

    function deactive_confirm() {
    	return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
    	return confirm("Are you sure you want to approve this good receive note?");
    }

    function delete_confirm() {
    	return confirm("Are you sure you want to reject this good receive note?");
    }

    function addCommas(nStr) {
    	nStr += '';
    	x = nStr.split('.');
    	x1 = x[0];
    	x2 = x.length > 1 ? '.' + x[1] : '';
    	var rgx = /(\d+)(\d{3})/;
    	while (rgx.test(x1)) {
    		x1 = x1.replace(rgx, '$1' + ',' + '$2');
    	}
    	return x1 + x2;
    }

    function action(data) { //alert(data);
    	var obj = JSON.parse(data);
    	$.notify({
    		// options
    		icon: obj.icon,
    		title: obj.title,
    		message: obj.message,
    		url: obj.url,
    		target: obj.target
    	}, {
    		// settings
    		element: 'body',
    		position: null,
    		type: obj.type,
    		allow_dismiss: true,
    		newest_on_top: false,
    		showProgressbar: false,
    		placement: {
    			from: "top",
    			align: "center"
    		},
    		offset: 100,
    		spacing: 10,
    		z_index: 1031,
    		delay: 5000,
    		timer: 1000,
    		url_target: '_blank',
    		mouse_over: null,
    		animate: {
    			enter: 'animated fadeInDown',
    			exit: 'animated fadeOutUp'
    		},
    		onShow: null,
    		onShown: null,
    		onClose: null,
    		onClosed: null,
    		icon_type: 'class',
    		template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    			'<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    			'<span data-notify="icon"></span> ' +
    			'<span data-notify="title">{1}</span> ' +
    			'<span data-notify="message">{2}</span>' +
    			'<div class="progress" data-notify="progressbar">' +
    			'<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    			'</div>' +
    			'<a href="{3}" target="{4}" data-notify="url"></a>' +
    			'</div>'
    	});
    }

    function getbatchno() {
    	var supplierID = $('#supplier').val();

    	$.ajax({
    		type: "POST",
    		data: {
    			recordID: supplierID
    		},
    		url: 'Goodreceive/Getbatchnoaccosupplier',
    		success: function (result) { //alert(result);
    			// console.log(result);
    			$('#batchno').val(result);
    		}
    	});
    }

	function confirmgoodreceive(confirmnot, id){
        Swal.fire({
            title: '',
            html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
            allowOutsideClick: false,
            showConfirmButton: false, // Hide the OK button
            backdrop: `
                rgba(255, 255, 255, 0.5) 
            `,
            customClass: {
                popup: 'fullscreen-swal'
            },
            didOpen: () => {
                document.body.style.overflow = 'hidden';
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id,
                        confirmstatus: confirmnot
                    },
                    url: '<?php echo base_url() ?>Goodreceive/Goodreceiveconfirm/' + id + '/' + confirmnot,
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            actionreload(obj.action);
                        }
                        else{
                            action(obj.action);
                        }
                    },
                    error: function(error) {
                        // Close the SweetAlert on error
                        Swal.close();
                        document.body.style.overflow = 'auto';
                        
                        // Show an error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                });
            }
        });
    }
	
</script>
<?php include "include/footer.php"; ?>
