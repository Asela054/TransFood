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
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i class="fas fa-undo-alt"></i></div>
                                    <span>Return Invoice</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body">

            			<div class="row">
            				<div class="col-12">
            					<form id="searchReport">
            						<div class="form-row">
            							<div class="col-2">
            								<div class="form-group">
            									<label class="small font-weight-bold">Customer*</label>
            									<select class="form-control form-control-sm" name="customer"
            										id="customer" required>
            										<option value="">Select</option>
            										<?php foreach($customer->result() as $rowcustomer){ ?>
            										<option value="<?php echo $rowcustomer->idtbl_customer?>">
            											<?php echo $rowcustomer->name ?></option>
            										<?php } ?>
            									</select>
            								</div>
            							</div>
            							<div class="col-2" id="hidesumbit">&nbsp;<br>
            								<button type="submit"
            									class="btn btn-outline-primary btn-sm ml-auto w-25 mt-2 px-5">Search</button>
            							</div>
            						</div>
            					</form>
            				</div>
            				<div class="col-12">
            					<hr class="border-dark">
            					<div class="scrollbar pb-3" id="style-2">
            						<table class="table table-striped table-bordered table-sm nowrap" id="invoicetable"
            							style="width:100%">
            							<thead class="table-warning">
            								<tr>
            									<th>#</th>
            									<th>Invoice Date</th>
            									<th>Invoice No.</th>
            									<th>Customer</th>
            									<th>Net Total</th>
            									<th>Action</th>
            								</tr>
            							</thead>
            							<tbody>
            							</tbody>
            						</table>
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal Return Invoice -->
<div class="modal fade" id="modalReturninvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompletemodaldropLabel">Return Invoice</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
							<input type="hidden" name="hideinvoiceid" id="hideinvoiceid" value="">
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Product*</label><br>
									<select class="form-control form-control-sm" style="width: 100%;" name="productlist"
										id="productlist" required>
									</select>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Inv Date</label>
									<input type="text" name="invdate" id="invdate" class="form-control form-control-sm"
										readonly>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Order Qty</label>
									<input type="number" name="orderqty" id="orderqty" class="form-control form-control-sm" readonly>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Sale Price</label><br>
									<input type="text" name="saleprice" id="saleprice"
										class="form-control form-control-sm" readonly>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Return Qty*</label>
									<input type="text" name="returnqty" id="returnqty" class="form-control form-control-sm" required>
									<span id="error-message" style="color: red; display: none;">Do not exceed the order quantity!</span>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Return Type*</label>
                                    <select class="form-control form-control-sm" name="returntype" id="returntype" required>
                                    <option value="">Select</option>
                                    <?php foreach($returntypelist->result() as $rowreturntypelist){ ?>
                                    <option value="<?php echo $rowreturntypelist->idtbl_return_type ?>"><?php echo $rowreturntypelist->type ?></option>
                                    <?php } ?>
                                </select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Comment</label>
									<textarea type="text" name="comment" id="comment"
										class="form-control form-control-sm"></textarea>
								</div>
							</div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
						<div class="scrollbar pb-3" id="style-3">
							<table class="table table-striped table-bordered table-sm small" id="tableorder">
								<thead>
									<tr>
										<th>Product</th>
                                        <th>Return Type</th>
                                        <th>Comment</th>
										<th class="d-none">ProductID</th>
                                        <th class="d-none">ReturntypeID</th>
										<th class="d-none">Saleprice</th>
										<th class="text-center">Return Qty</th>
										<th class="d-none">HideTotal</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="row">
							<div class="col text-right">
								<h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
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
								Return Invoice</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewReturnInvoicelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">View Return Invoice List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewreturninvoicedata"></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Return Invoice -->
<div class="modal fade" id="modalprintinvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompletemodaldropLabel">Print Credit Note</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div id="viewreceiptprint"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger btn-sm fa-pull-right" id="btnreceiptprint"><i class="fas fa-print"></i>&nbsp;Print Receipt</button>
            </div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewInvoicelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">View Invoice List</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewdata"></div>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>


<script type="text/javascript">
    let today = new Date().toISOString().slice(0, 10)


    $(document).ready(function () {

        $("#customer").select2({

        	ajax: {
        		url: "<?php echo base_url() ?>Rptbuyerwisesales/Getcustomerlist",
        		type: "post",
        		dataType: 'json',
        		delay: 250,
        		data: function (params) {
        			return {
        				searchTerm: params.term // search term
        			};
        		},
        		processResults: function (response) {
        			return {
        				results: response
        			};
        		},
        		cache: true
        	}
        });

		$('#returnqty').on('input', function () {
			var returnQty = parseFloat($(this).val());
			var orderQty = parseFloat($('#orderqty').val());
			var errorMessage = $('#error-message');
			var formSubmitButton = $('#formsubmit');

			if (returnQty > orderQty) {
				errorMessage.show();
				formSubmitButton.prop('disabled', true);
			} else {
				errorMessage.hide();
				formSubmitButton.prop('disabled', false);
			}
		});

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $("#searchReport").submit(function (event) {
            event.preventDefault();
        $('#invoicetable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/returninvoiceviewlist.php",
                type: "POST", // you can use GET
                "data": function (d) {
                        return $.extend({}, d, {
                            "customer": $("#customer").val()

                        });
                    }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "data": "invdate"
                    },
                    {
                        "data": "idtbl_invoice",
                        "render": function(data, type, full) {
                            if (full['invtype'] == 1) {
                                return "INV/DT-000" + data;
                            } else {
                                return "INV/OT-000" + data;
                            }
                        }
                    },
                    {
                        "data": "name",
                        "render": function(data, type, full) {
                            if (full['invtype'] == 2) {
                                return "Guest Customer";
                            } else {
                                return  data;
                            }
                        }
                    },
                    {
                        "targets": -1,
                        "className": 'text-left',
                        "data": null,
                        "render": function(data, type, full) {
                            return addCommas(parseFloat(full['nettotal']).toFixed(2));
                        }
                    },
                    {
                        "targets": -1,
                        "className": 'text-right',
                        "data": null,
                        "render": function(data, type, full) {
                            var button = '';
                                button+='<button class="btn btn-secondary btn-sm btnviewList mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_invoice']+'"><i class="fas fa-list"></i></button>';
                                button+='<button class="btn btn-dark btn-sm btnReturn mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_invoice']+'"><i class="fas fa-undo-alt"></i></button>';
                                button+='<button class="btn btn-danger btn-sm btnreturnviewList mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_invoice']+'"><i class="fas fa-file-alt"></i></button>';
                            return button;
                        }
                    }


            ],

            dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
            buttons: [
                {
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    filename: 'Invoice Details' + today,
                    text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Stock Report'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    filename: 'Invoice Details' + today,
                    text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Invoice Details'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    filename: 'Invoice Details' + today,
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: {
                        text: 'Invoice Details',
                        fontSize: 20,
                        bold: true,
                        alignment: 'center'
                    },
                    customize: function (doc) {
                        doc.styles.title = {
                            bold: 60,
                            color: '#2F5233',
                            fontSize: '30',
                            alignment: 'center',
                        }
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-primary btn-sm',
                    filename: 'Material Stock Report' + today,
                    text: '<i class="fas fa-print mr-2"></i> PRINT',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Invoice Details',
                    customize: function (doc) {
                        doc.styles.title = {
                            color: 'black',
                            fontSize: '30',
                            alignment: 'center',
                        }
                    }
                }
            ],
				rowCallback: function(row, data) {
					if (data.returnstatus == 1) {
						$(row).addClass('bg-danger-soft');
					}
				},
                drawCallback: function (settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
        });
    });


        $(document).on("click", ".btnviewList", function () {
        	var id = $(this).attr('id');
        	$('#viewInvoicelist').modal('show');
        	// alert(id);
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Returninvoice/Getinvoicedetails',
        		success: function (result) { //alert(result);

        			$('#viewdata').html(result);
        			$('#tblInvoicelist').DataTable({
        				"ordering": false,
        				dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        				responsive: true,
        				lengthMenu: [
        					[10, 25, 50, -1],
        					[10, 25, 50, 'All'],
        				],
        				"buttons": [{
        						extend: 'csv',
        						className: 'btn btn-success btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
        					},
        					{
        						extend: 'pdf',
        						className: 'btn btn-danger btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
        					},
        					{
        						extend: 'print',
        						title: 'Invoice List',
        						className: 'btn btn-primary btn-sm',
        						text: '<i class="fas fa-print mr-2"></i> Print',
        						customize: function (win) {
        							$(win.document.body).find('table')
        								.addClass('compact')
        								.css('font-size', 'inherit');
        						},
        					},
        				],
        				footerCallback: function (row, data, start, end, display) {
        					var api = this.api();

        					// Remove the formatting to get integer data for summation
        					var intVal = function (i) {
        						return typeof i === 'string' ?
        							i.replace(/[\$,]/g, '') * 1 :
        							typeof i === 'number' ?
        							i : 0;
        					};

        					// Total over all pages
        					total = api
        						.column(3)
        						.data()
        						.reduce(function (a, b) {
        							return intVal(a) + intVal(b);
        						}, 0);

        					// Total over this page
        					pageTotal = api
        						.column(3, {
        							page: 'current'
        						})
        						.data()
        						.reduce(function (a, b) {
        							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
        						}, 0);

        					// Update footer
        					$(api.column(3).footer()).html(
        						// pageTotal=parseFloat(pageTotal).toFixed(2);
        						'Rs. ' + pageTotal
        					);

        				},
        				drawCallback: function (settings) {
        					$('[data-toggle="tooltip"]').tooltip();
        				}
        			});;


        		}
        	});
        });

		$(document).on("click", ".btnreturnviewList", function () {
        	var id = $(this).attr('id');
        	$('#viewReturnInvoicelist').modal('show');
        	// alert(id);
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Returninvoice/Getretruninvoicedetails',
        		success: function (result) { //alert(result);

        			$('#viewreturninvoicedata').html(result);
        			$('#tblReturnInvoicelist').DataTable({
        				"ordering": false,
        				dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        				responsive: true,
        				lengthMenu: [
        					[10, 25, 50, -1],
        					[10, 25, 50, 'All'],
        				],
        				"buttons": [{
        						extend: 'csv',
        						className: 'btn btn-success btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-csv mr-2"></i> CSV',
        					},
        					{
        						extend: 'pdf',
        						className: 'btn btn-danger btn-sm',
        						title: 'Invoice List',
        						text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
        					},
        					{
        						extend: 'print',
        						title: 'Invoice List',
        						className: 'btn btn-primary btn-sm',
        						text: '<i class="fas fa-print mr-2"></i> Print',
        						customize: function (win) {
        							$(win.document.body).find('table')
        								.addClass('compact')
        								.css('font-size', 'inherit');
        						},
        					},
        				],
        				footerCallback: function (row, data, start, end, display) {
        					var api = this.api();

        					// Remove the formatting to get integer data for summation
        					var intVal = function (i) {
        						return typeof i === 'string' ?
        							i.replace(/[\$,]/g, '') * 1 :
        							typeof i === 'number' ?
        							i : 0;
        					};

        					// Total over all pages
        					total = api
        						.column(3)
        						.data()
        						.reduce(function (a, b) {
        							return intVal(a) + intVal(b);
        						}, 0);

        					// Total over this page
        					pageTotal = api
        						.column(3, {
        							page: 'current'
        						})
        						.data()
        						.reduce(function (a, b) {
        							return parseFloat(intVal(a) + intVal(b)).toFixed(2);
        						}, 0);

        					// Update footer
        					$(api.column(3).footer()).html(
        						// pageTotal=parseFloat(pageTotal).toFixed(2);
        						'Rs. ' + pageTotal
        					);

        				},
        				drawCallback: function (settings) {
        					$('[data-toggle="tooltip"]').tooltip();
        				}
        			});;


        		}
        	});
        });

    $(document).on("click", ".btnReturn", function () {
    	var id = $(this).attr('id');
    	$('#hideinvoiceid').val(id);
    	$.ajax({
    		type: "POST",
    		data: {
    			recordID: id
    		},
    		url: "<?php echo base_url() ?>Returninvoice/Getorderdetails",
    		success: function (result) {
    			var obj = JSON.parse(result);

    			var html1 = '';
    			html1 += '<option value="">Select</option>';
    			$.each(obj, function (i) {
    				html1 += '<option value="' + obj[i].idtbl_product + '">';
    				html1 += obj[i].materialname + ' - ' + obj[i].productcode;
    				html1 += '</option>';
    			});
    			$('#productlist').empty().append(html1);
    			$('#modalReturninvoice').modal('show');
    		}
    	});
    });

    $(document).on("click", ".btnprintReturn", function () {
    	var id = $(this).attr('id');

    	$('#modalprintinvoice').modal('show');
    	$('#viewreceiptprint').html('<div class="card border-0 shadow-none bg-transparent"><div class="card-body text-center"><img src="images/spinner.gif" alt="" srcset=""></div></div>');

    	$.ajax({
    		type: "POST",
    		data: {
    			recordID: id
    		},
    		url: "<?php echo base_url() ?>Returninvoice/Getinvoiceprint",
    		success: function (result) { //alert(result);
    			$('#viewreceiptprint').html(result);
    		}
    	});
    });
    document.getElementById('btnreceiptprint').addEventListener ("click", print);




        $('#modalReturninvoice').on('hidden.bs.modal', function () {
            $('#productlist').val('');
            $('#invdate').val('');
            $('#hideinvoiceid').val('');
            $('#orderqty').val('');
            $('#saleprice').val('');
            $('#divtotal').html('');
            $('#hidetotalorder').val('');
            $('#tableorder tbody').empty();
        });

        $('#productlist').change(function () {
        	let productID = $(this).val();
        	let invoiceID = $('#hideinvoiceid').val();

        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: productID,
        			invoiceID: invoiceID
        		},
        		url: '<?php echo base_url() ?>Returninvoice/Getordereqty',
        		dataType: 'json',
        		success: function (result) { //alert(result);
        			$('#orderqty').val(result.qty);
        			$('#saleprice').val(result.price);
        			$('#invdate').val(result.invdate);

        		}
        	});
        });

        $('#modalReturninvoice').on('hidden.bs.modal', function () {
        	window.location.reload();
        });

        $("#formsubmit").click(function () {
    		if (!$("#createorderform")[0].checkValidity()) {
    			// If the form is invalid, submit it. The form won't actually submit;
    			// this will just cause the browser to display the native HTML5 error messages.
    			$("#submitBtn").click();
    		} else {
    			var productID = $('#productlist').val();
                var returntypeID = $('#returntype').val();
    			var comment = $('#comment').val();
    			var product = $("#productlist option:selected").text();
                var returntype = $("#returntype option:selected").text();
    			var unitprice = parseFloat($('#saleprice').val());
    			var newqty = parseFloat($('#returnqty').val());

    			var newtotal = parseFloat(unitprice * newqty);

    			var total = parseFloat(newtotal);
    			var showtotal = addCommas(parseFloat(total).toFixed(2));

    			$('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + returntype + '</td><td>' + comment + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + returntypeID + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

    			$('#productlist').val('');
    			$('#returntype').val('');
    			$('#returnqty').val('');
    			$('#comment').val('');

    			var sum = 0;
    			$(".total").each(function () {
    				sum += parseFloat($(this).text());
    			});

    			var showsum = addCommas(parseFloat(sum).toFixed(2));

    			$('#divtotal').html('Rs. ' + showsum);
    			$('#hidetotalorder').val(sum);
    			$('#productlist').focus();
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
    	$('#btncreateorder').click(function () { //alert('IN');
    		$('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Return Invoice')
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

    			var hideinvoiceID = $('#hideinvoiceid').val();
    			var remark = $('#remark').val();
    			var total = $('#hidetotalorder').val();

    			// alert(orderdate);
    			$.ajax({
    				type: "POST",
    				data: {
    					tableData: jsonObj,
    					hideinvoiceID: hideinvoiceID,
    					total: total,
    					remark: remark
    				},
    				url: 'Returninvoice/Returninvoiceinsertupdate',
    				success: function (result) { //alert(result);
    					// console.log(result);
    					var obj = JSON.parse(result);
    					if (obj.status == 1) {
    						$('#modalReturninvoice').modal('hide');
    						setTimeout(window.location.reload(), 3000);
    					}
    					action(obj.action);
    				}
    			});
    		}

    	});

});

function print() {
        printJS({
            printable: 'viewreceiptprint',
            type: 'html',
            style: '@page { size: A4 portrait; margin:0.25cm; }',
            targetStyles: ['*']
        })
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
</script>

<?php include "include/footer.php"; ?>