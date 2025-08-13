<?php 
include "include/header.php"; 

include "include/topnavbar.php"; 
?>

<style>
    content-display {
        display: none;
    }
</style>


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
                                    <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                                    <span>Invoice View</span>
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
            								<label class="small font-weight-bold text-dark">Report Type*</label>
            								<div class="input-group input-group-sm">
            									<select class="form-control form-control-sm" name="report_type"
            										id="report_type">
            										<option value="0">Select</option>
            										<option value="1">Daily</option>
            										<option value="2">Weekly</option>
            										<option value="3">Monthly</option>
            										<option value="4">Date Range</option>
            										<option value="5">All Invoice</option>

            									</select>
            								</div>
            							</div>
            							<div class="col-2" style="display: none" id="inv_type">
            								<label class="small font-weight-bold text-dark">Invoice Type*</label>
            								<div class="input-group input-group-sm">
            									<select class="form-control form-control-sm" name="invoice_type"
            										id="invoice_type">
            										<option value="0">Select</option>
            										<option value="1">Direct Invoice</option>
            										<option value="2">Outlet Invoice</option>
            									</select>
            								</div>
            							</div>
            							<div class="col-2" style="display: none" id="select_date">
            								<label class="small font-weight-bold text-dark"> Date*</label>
            								<input type="date" class="form-control form-control-sm " placeholder=""
            									name="date" id="date">
            							</div>

            							<div class="col-2" style="display: none" id="select_week">
            								<label class="small font-weight-bold text-dark"> Week*</label>
            								<input type="week" class="form-control form-control-sm" placeholder=""
            									name="week" id="week">
            							</div>
            							<div class="col-2" style="display: none" id="select_month">
            								<label class="small font-weight-bold text-dark"> Month*</label>
            								<input type="month" class="form-control form-control-sm" placeholder=""
            									name="month" id="month">
            							</div>
            							&nbsp;
            							<div class="col-2" style="display: none" id="select_from">
            								<label class="small font-weight-bold text-dark"> From*</label>
            								<input type="date" class="form-control form-control-sm" placeholder=""
            									name="date_from" id="date_from">
            							</div>
            							&nbsp;
            							<div class="col-2" style="display: none" id="select_to">
            								<label class="small font-weight-bold text-dark"> To*</label>
            								<input type="date" class="form-control form-control-sm" placeholder=""
            									name="date_to" id="date_to">
            							</div>
            							<div class="col-2" style="display: none;" id="hidesumbit">&nbsp;<br>
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
            				<div class="col-12">
            					<span class="badge bg-primary px-2 mt-4">&nbsp;</span> Direct Invoice
            					View
            					&nbsp;
            					<span class="badge bg-success px-2 mt-4">&nbsp;</span> Outlet Invoice
            					View
            				</div>
            			</div>
            		</div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewinvoicedetails" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Update Batch Number</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="col-12">
					<form id="createorderform2" autocomplete="off">
						<div class="form-row mb-1">
							<label class="small font-weight-bold">Product*</label><br>
							<select class="form-control form-control-sm" name="productlist[]" id="productlist" required style="width: 100%;">
							</select>
						</div>
                        <div class="form-row mb-1">
                        	<label class="small font-weight-bold">Location*</label>
                        	<select class="form-control form-control-sm" name="location" id="location">
                        		<option value="">Select</option>
                        		<?php foreach($location->result() as $rowlocationlist){ ?>
                        		<option value="<?php echo $rowlocationlist->idtbl_location ?>">
                        			<?php echo $rowlocationlist->location ?></option>
                        		<?php } ?>
                        	</select>
                        </div>
						<div class="form-row mb-1">
							<label class="small font-weight-bold">Batch No.*</label><br>
							<select class="form-control form-control-sm" name="batchlist[]" id="batchlist" required
								multiple style="width: 100%;">
							</select>
						</div>
                        <input type="hidden" id="invoice_id" name="invoice_id">
						<div class="form-group mt-3 text-right">
							<button type="button" id="formsubmit2" class="btn btn-primary btn-sm px-4"
								<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-edit"></i>&nbsp;Update Invoice</button>
							<input name="submitBtn" type="submit2" value="Save" id="submitBtn" class="d-none">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="viewInvoicelist" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
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

$(function () {
    $("#report_type").change(function () {
        if ($(this).val() == 1) {
            $("#inv_type").show();
            $("#select_date").show();
            $("#hidesumbit").show();
            $("#select_week").hide();
            $("#select_month").hide();
            $("#select_from").hide();
            $("#select_to").hide();
        } else if ($(this).val() == 2) {
            $("#inv_type").show();
            $("#select_week").show();
            $("#hidesumbit").show();
            $("#select_date").hide();
            $("#select_month").hide();
            $("#select_from").hide();
            $("#select_to").hide();
        } else if ($(this).val() == 3) {
            $("#inv_type").show();
            $("#select_month").show();
            $("#hidesumbit").show();
            $("#select_date").hide();
            $("#select_week").hide();
            $("#select_from").hide();
            $("#select_to").hide();
        } else if ($(this).val() == 4) {
            $("#inv_type").show();
            $("#select_from").show();
            $("#select_to").show();
            $("#hidesumbit").show();
            $("#select_date").hide();
            $("#select_week").hide();
            $("#select_month").hide();
        } else if ($(this).val() == 5) {
            $("#hidesumbit").show();
            $("#select_from").hide();
            $("#inv_type").hide();
            $("#select_to").hide();
            $("#select_date").hide();
            $("#select_week").hide();
            $("#select_month").hide();
        } else {
            $("#inv_type").hide();
            $("#select_date").hide();
            $("#select_week").hide();
            $("#select_month").hide();
            $("#select_from").hide();
            $("#select_to").hide();
            $("#hidesumbit").hide();
        }
    });
});


    $(document).ready(function () {

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        sessionStorage.setItem('companyid', '<?php echo $this->session->userdata('companyid'); ?>');

        $("#batchlist").select2();
        $("#productlist").select2();

        $("#searchReport").submit(function (event) {
            event.preventDefault();

        $('#invoicetable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/invoiceviewlist.php",
                type: "POST", // you can use GET
                "data": function (d) {
                        return $.extend({}, d, {
                            "search_invoice": $("#invoice_type").val(),
                            "search_date": $("#date").val(),
                            "search_week": $("#week").val(),
                            "search_month": $("#month").val(),
                            "search_from_date": $("#date_from").val(),
                            "search_to_date": $("#date_to").val(),
                            "report_type": "5"
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
                            var invDate = new Date(full['invdate']);
                            var cutoffDate = new Date("2024-12-10");
                            
                            var companyId = sessionStorage.getItem("companyid");
                            
                            var prefix = "UNKNOWN/INV";
                            if (companyId == 1) {
                                prefix = "UN/INV";
                            } else if (companyId == 2) {
                                prefix = "UF/INV";
                            }
                            
                            if (invDate >= cutoffDate) {
                                if (full['invtype'] == 1) {
                                    return prefix + "/DT-000" + full['invno']; 
                                } else {
                                    return prefix + "/OT-000" + full['invno'];
                                }
                            } else {
                                if (full['invtype'] == 1) {
                                    return prefix + "/DT-000" + data;
                                } else {
                                    return prefix + "/OT-000" + data;
                                }
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
                                button+='<button class="btn btn-dark btn-sm btnUpdatebatch mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_invoice']+'"><i class="fas fa-edit"></i></button>';

                                button+='<button class="btn btn-secondary btn-sm btnviewList mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_invoice']+'"><i class="fas fa-list"></i></button>';

                            if (full['invtype'] == 1) {
                                button += '<a href="<?php echo base_url() ?>Invoiceview/printreport/' + full['idtbl_invoice'] + '" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                            } else if (full['invtype'] == 2) {
                                button += '<a href="<?php echo base_url() ?>Invoiceview/printreportpos/' + full['idtbl_invoice'] + '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                            }

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
		url: '<?php echo base_url() ?>Invoiceview/Getinvoicedetails',
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

$('#invoicetable tbody').on('click', '.btnUpdatebatch', function() {
        var r = confirm("Are you sure, You want to Edit this?");
        if (r == true) {
            var id = $(this).attr('id');
            $('#invoice_id').val(id); // Set the invoice ID
            $('#viewinvoicedetails').modal('show');
            $.ajax({
                type: "POST",
                data: { invoice_id: id },
                url: '<?php echo base_url() ?>Invoiceview/GetProductsByInvoiceID',
                success: function(result) {
                    var products = JSON.parse(result);
                    $('#productlist').empty(); // Clear the dropdown
                    $.each(products, function(index, product) {
                        $('#productlist').append(new Option(product.text, product.id));
                    });
                    $('#productlist').trigger('change'); // Refresh the Select2 picker
                }
            });
        }
    });

    $('#productlist').on('change', function() {
        var product_id = $(this).val();
        var location_id = $('#location').val();
        if (product_id && location_id) {
            $.ajax({
                type: "POST",
                data: {
                    product_id: product_id,
                    location_id: location_id
                },
                url: '<?php echo base_url() ?>Invoiceview/GetBatchesByProductAndLocation',
                success: function(result) {
                    var batches = JSON.parse(result);
                    $('#batchlist').empty();
                    $.each(batches, function(index, batch) {
                        $('#batchlist').append(new Option(batch.text, batch.fgbatchno));
                    });
                    $('#batchlist').trigger('change');
                }
            });
        }
    });

    $('#formsubmit2').on('click', function() {
        var invoice_id = $('#invoice_id').val();
        var product_id = $('#productlist').val();
        var batchnos = $('#batchlist').val();

        $.ajax({
            type: "POST",
            data: {
                invoice_id: invoice_id,
                product_id: product_id,
                batchnos: batchnos
            },
            url: '<?php echo base_url() ?>Invoiceview/UpdateBatchNumbers',
            success: function(result) {
                var obj = JSON.parse(result);
                if (obj.status === 'success') {
                    alert('Batch numbers updated successfully');
                    $('#viewinvoicedetails').modal('hide');
                } else {
                    alert('Failed to update batch numbers');
                }
            }
        });
    });

    $('#location').on('change', function () {
    	$('#productlist').trigger('change');
    });

    $('#productlist').select2();
    $('#batchlist').select2();

});

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