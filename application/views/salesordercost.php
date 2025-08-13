<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<style>
    html {
    	scroll-behavior: smooth;
    }
    .table-cost{
        margin-top:75px;
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
                        <h1 class="page-header-title font-weight-light">
                            <div class="page-header-icon"><i class="fas fa-list-alt"></i></div>
                            <span>Sales Order Cost List</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">

                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3 px-2" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Sales Order Type</th>
                                                <th>Date</th>
                                                <th>Customer</th>
                                                <th>Total</th>
                                                <th>Confirm Status</th>
                                                <!-- <th>Transfer Status</th> -->
                                                <th>Remark</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="table-cost row">
                            <div class="col-12">
                                <div class="pb-3 px-2" id="addcostsection">
                                    <table id="orderlist" class="table table-bordered table-striped table-sm nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Order Qty</th>
                                                <th>Suggested Price</th>
                                                <th>Material Cost/Unit</th>
                                                <th>Other Cost/Unit</th>
                                                <th>Unit Price</th>
                                                <th>Total Cost/Unit</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productlist"></tbody>
                                    </table>
                                    <input type="hidden" class="form-control form-control-sm" name="salesid"
											id="salesid" required>
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
<div class="modal fade" id="addCostModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">SOD000<label id="orderno"></label></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-4">
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<form id="addcostform" action="" autocomplete="off">
									<div class="form-row mb-1">
										<input type="hidden" class="form-control form-control-sm" name="unitprice" id="unitprice" required>
										<input type="hidden" class="form-control form-control-sm" name="orderid" id="orderid" required>
										<input type="hidden" class="form-control form-control-sm" name="productid" id="productid" required>
										<input type="hidden" class="form-control form-control-sm" name="costamount" id="costamount" required>
										<input type="hidden" class="form-control form-control-sm" name="matcost" id="matcost" required>
										<input type="hidden" class="form-control form-control-sm" name="qty" id="qty" required>
										<label class="small font-weight-bold">Product*</label>
										<input type="text" class="form-control form-control-sm" name="orderproduct" id="orderproduct" required>
									</div>
									<div class="form-row mb-1">
										<label class="small font-weight-bold text-dark">Add Date</label>
										<input type="date" class="form-control form-control-sm" placeholder="" name="adddate" id="adddate"
											value="<?php echo date('Y-m-d') ?>">
									</div>
									<div class="form-row mb-1">
										<label class="small font-weight-bold text-dark">Costing Type*</label><br>
										<select class="form-control form-control-sm" name="costlist" id="costlist" required>
										</select>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Amount*</label>
											<input type="text" class="form-control form-control-sm" name="amount" id="amount">
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Percentage</label>
											<div class="input-group mb-3">
												<input type="number" class="form-control form-control-sm col-10" name="percentage"
													id="percentage">
												<input type="text" value="%" class="form-control form-control-sm col-2" readonly>
											</div>
										</div>
									</div>
									<div class="form-row mb-1 mt-2">
										<div class="col-3">
											<input class="unit" type="radio" id="perunit" name="perunit" value="1" required checked>
											<label for="perunit" class="mt-1 px-1 small font-weight-bold text-dark">Per Unit</label>
										</div>
										<div class="col">
											<input class="unit" type="radio" id="perunit2" name="perunit" value="0" required>
											<label for="perunit2" class="mt-1 px-1 small font-weight-bold text-dark">All Qty</label>
										</div>
									</div>
									<div class="form-group  text-right">
                                                <button type="button" id="BtnAdd" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>>
                                                <i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn2" type="submit" value="Save" id="submitBtn2" class="d-none">
									</div>
									<input type="reset" class="d-none" id="hideResetModal">
								</form>
							</div>
						</div>
                        <hr>
                        <h2 class="modal-title" id="staticBackdropLabel">Cost List</h2>
                        <table class=" mt-4 table table-bordered table-striped  nowrap display" id="tblcostadd">
										<thead>
                                            <th>#</th>
											<th>Costing Type</th>
											<th>Amount</th>
										</thead>
										<tbody id="viewhtml">
										</tbody>
									</table>
					</div>

					<div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table-sm" id="style-2">
									<table class="table table-bordered table-striped  nowrap display" id="tblcost">
										<thead>
                                            <th class="d-none">Product ID</th>
											<th>Product</th>
											<th>Date</th>
											<th>Costing Type</th>
											<th class="d-none">Costing ID</th>
											<th class="d-none">Per Unit Amount</th>
											<th class="text-right">Amount</th>
                                            <th class="d-none">Percentage</th>
                                            <th class="d-none">Unit Status</th>
                                            <th class="d-none">Order ID</th>
										</thead>
										<tbody id="tblcostbody">
										</tbody>
										<tfoot>
											<tr>
											<th class="text-right" colspan="3">
													<label class="d-none" id="hiddenlabelcosttotal"></label><br>
													<input type="hidden" class="form-control form-control-sm" name="hiddentotalcost"
														id="hiddentotalcost">
												</th>
												<th class="text-right" colspan="4">
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
							<button type="button" id="submitBtn" class="btn btn-outline-primary btn-sm fa-pull-right"
								<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add
								Costing</button>
						</div>
					</div>
				</div>
			</div>
			</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>

$(document).ready(function() {
  // Add change event handler to the dropdown element
  $('#costlist').change(function() {
    // Get the selected value from the dropdown
    var selectedValue = $(this).val();

    // Set the readonly property of the input fields based on the selected value
    if (selectedValue === '14') {
      $('#amount').prop('readonly', true);
      $('#percentage').prop('readonly', false);
    } else {
      $('#amount').prop('readonly', false);
      $('#percentage').prop('readonly', true);
    }
  });
});


	$(document).on("click", ".btnViewreport", function () {

		var id = $(this).attr('id');
		var productid = $(this).attr('value');
		// alert(productid);
		$.ajax({
			type: "POST",
			data: {
				recordID: id,
				productid: productid
			},
			url: '<?php echo base_url() ?>Salesordercost/printitemreport',
			success: function (result) {

				// alert(result);
				// window.load.library('pdf');
				// window.pdf.loadHtml(result);
				// window.pdf.render();
				// window.pdf.stream("UNISTAR-INTERNATIONAL COSTLIST SHEET.pdf", {
				// 	"Attachment": 0
				// });

			}
		});
	});


    $(document).on("click", ".btnAddcost", function () {
    	var id = $(this).attr('name');
		var productid = $(this).attr('value');
		// var id = $('#orderid').val();

    	$('#addCostModal').modal('show');
    	$.ajax({
    		type: "POST",
    		data: {
    			recordID: id,
				productid: productid
    		},
    		url: '<?php echo base_url() ?>Salesordercost/Getallocatecostlist',
    		success: function (result) { //alert(result);
    			$('#viewhtml').html(result);
    		}
    	});
    });

    function preparelist (orderid) {
        var productid = $('#productid').val();
		// alert (productid);

        $.ajax({
                type: "POST",
                data: {
                    orderid: orderid,
					productid: productid
                },
                url: '<?php echo base_url() ?>Salesordercost/Getexpencetype',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i) {
                        html1 += '<option value="' + obj[i].idtbl_expence_type + '">';
                        html1 +=  obj[i].expencetype;
                        html1 += '</option>';
                    });
                    $('#costlist').empty().append(html1);
                }
            });
    };


    $(document).on("click", "#submitBtn", function () {

    	var orderid = $('#orderid').val();
    	var productid = $('#productid').val();
    	var totalcost = $('#totalcost').val();
		var hiddentotalcost = $('#hiddentotalcost').val();
    	var unitprice = $('#unitprice').val();
    	var qty = $('#qty').val();
    	var unit = $("input[name='perunit']:checked").val();

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
    	//console.log(jsonObj);

    	$.ajax({
    		type: "POST",
    		data: {
    			tableData: jsonObj,
    			totalcost: totalcost,
				hiddentotalcost: hiddentotalcost,
    			unitprice: unitprice,
    			productid: productid,
    			orderid: orderid,
    			unit: unit,
    			qty: qty
    		},
    		url: '<?php echo base_url() ?>Salesordercost/Costinsertupdate',
    		success: function (result) { //alert(result);
    			//console.log(result);
    			$('#hideResetModal').click();
    			$('#tblcost > tbody').empty();
    			$('#labelcosttotal').val('');
    			$('#totalcost').val('');
    			$('#labelcosttotal').html('');
    			$('#addCostModal').modal('toggle');
    			dataload();
    		}
    	});


    });

    $(document).ready(function() {

        $("#BtnAdd").click(function () {
            if (!$("#addcostform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn2").click();
            } else {

        var amount;
        var productid = $('#productid').val();
    	var orderProduct = $('#orderproduct').val();
    	var addDate = $('#adddate').val();
    	var costList = $("#costlist option:selected").text();
    	var costListid = $('#costlist').val();
    	var Amount = $('#amount').val();
		var hiddencostamount = $('#amount').val();
        var percentage = $('#percentage').val();
        var unitprice = $('#unitprice').val();
        var unit = $("input[name='perunit']:checked").val();
        var orderid = $('#orderid').val();
        var matcost = $('#matcost').val();
		var qty = $('#qty').val();
        
        var percent = (matcost*percentage/100);

		if(unit==1){
            hiddencostamount=Amount;
        }else{
            hiddencostamount=Amount/qty;
        }

        if(Amount!==""){
            amount=Amount;
            percentage=0;

        }else{
            amount=percent;            
        }

    	$('#tblcost> tbody:last').append('<tr><td class="text-center d-none">' + productid + '</td><td class="text-center">' + orderProduct + '</td><td class="text-center">' + addDate + '</td><td class="text-center">' + costList +
    		'</td><td class="text-center d-none">' + costListid + '</td><td class="text-center hiddentotal d-none">' + hiddencostamount + '</td><td class="total text-right">' + amount + '</td><td class="text-center d-none">' + percentage + '</td><td class="text-center d-none">' + unit + '</td><td class="text-center d-none">' + orderid + '</td></tr>');

            $('#costlist').val('');
            $('#amount').val('');
            $('#percentage').val('');

    	var sum = 0;
    	$(".total").each(function () {
    		sum += parseFloat($(this).text());
    	});

    	var showsum = parseFloat(sum).toFixed(2);

    	$('#labelcosttotal').html('Total:' + showsum);
    	$('#totalcost').val(sum);

		var sum = 0;
    	$(".hiddentotal").each(function () {
    		sum += parseFloat($(this).text());
    	});

    	var showsum = parseFloat(sum).toFixed(2);

    	$('#hiddenlabelcosttotal').html('Total:' + showsum);
    	$('#hiddentotalcost').val(sum);
    }
    });

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';
        $('#product').select2({dropdownParent: $('#staticBackdrop')});

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Purchase Order Information',
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
                url: "<?php echo base_url() ?>scripts/salesordercostlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_customer_porder"
                },
                {
                    "data": "type"
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "name"
                },
                {
                    "data": "nettotal"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';}
                        else{return 'Not Confirm Order';}
                    }
                },
                // {
                //     "targets": -1,
                //     "className": '',
                //     "data": null,
                //     "render": function(data, type, full) {
                //         if(full['transproductionstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Transfer to production';}
                //         else{return 'Not Transfer to production';}
                //     }
                // },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-center',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<a href="#addcostsection"><button class="btn btn-warning btn-sm btnAddCosting mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-list"></i></button></a>';
                        button+='<a href="<?php echo base_url() ?>Salesordercost/printreport/'+full['idtbl_customer_porder']+'" target="_blank" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>';
       
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });


        $('#dataTable tbody').on('click', '.btnAddCosting', function () {
        	var id = $(this).attr('id');
            $('#salesid').val(id);
            dataload();
        });

        $('#orderlist tbody').on('click', '.btnAddcost', function () {
        var id = $(this).attr('id');
        $.ajax({
        	type: "POST",
        	data: {
        		recordID: id
        	},
        	url: '<?php echo base_url() ?>Salesordercost/Getorderdetails',
        	success: function (result) { //alert(result);
        		var obj = JSON.parse(result);
        		$('#orderproduct').val(obj[0].productcode);
        		$('#orderid').val(obj[0].idtbl_customer_porder);
        		$('#orderdetailid').val(obj[0].idtbl_customer_porder_detail);
        		$('#orderno').html(obj[0].idtbl_customer_porder);
        		$('#unitprice').val(obj[0].unitprice);
        		$('#productid').val(obj[0].idtbl_product);
        		$('#costamount').val(obj[0].othercost);
        		$('#qty').val(obj[0].qty);

                preparelist(obj[0].idtbl_customer_porder);
        	}
            });
        });

        $('#dataTable tbody').on('click', '.btnview', function () {
        var id = $(this).attr('id');
        $.ajax({
        	type: "POST",
        	data: {
                recordID: id
        	},
        	url: '<?php echo base_url() ?>Salesordercost/printreport',
                    success: function(result) { //alert(result);
                        // location.reload();
            }
            });
        });


    $('#orderlist tbody').on('click', '.btnAddcost', function () {
        var productid = $(this).attr('value');
        $.ajax({
        	type: "POST",
        	data: {
                productid: productid
        	},
        	url: '<?php echo base_url() ?>Salesordercost/Getmaterialcost',
        	success: function (result) { //alert(result);
                var obj = JSON.parse(result);
        		$('#matcost').val(obj[0].avgunitprice);
        	}
            });
        });

    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to confirm this purchase order?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }

    function dataload(){
        // alert('in');
        var id = $('#salesid').val();
        $.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Salesordercost/Getsalesoredrproduct',
        		success: function (result) { //alert(result);
        			$('#productlist').html(result);
        		}
        	});
    }
</script>
<?php include "include/footer.php"; ?>
