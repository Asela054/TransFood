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
									<div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
									<span>&nbsp; Invoice </span>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row ">
							<div class="col-10 col-md-4">
								<label class="small font-weight-bold text-dark"> Date*</label>
								<input type="date" class="form-control form-control-sm" name="loadingdate"
									id="loadingdate">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-12 col-md-12">
								<table class=" mt-4 table-sm table table-bordered table-striped  nowrap display"
									id="porderdetailview">
									<thead>
										<th>#</th>
										<th>Order Date</th>
										<th>Customer</th>
										<th>Order Type</th>
										<th>Order Qty.</th>
										<th>Actions</th>
									</thead>
									<tbody id="viewhtml">
									</tbody>
								</table>
							</div>
						</div>
						<br>
						<hr>
						<div id="billingsection" style="display: none">

							<div class="row">
								<div class="col-12 col-md-4">
									<div class="row">
										<div class="col-12 col-md-12">
											<div class="form-group mb-1">
												<input id="saletype" name="saletype" type="hidden">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-md-12">
											<div class="form-group mb-1">
												<input type="hidden" name="orderid" class="form-control form-control-sm"
													id="orderid" required>
												<label class="small font-weight-bold text-dark">Customer :</label>
												<input type="text" name="customer" class="form-control form-control-sm"
													id="customer" readonly>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-12 col-md-12">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">Location :</label>
												<select class="form-control form-control-sm" name="location"
													id="location">
													<option value="">Select</option>
													<?php foreach($location->result() as $rowlocationlist){ ?>
													<option value="<?php echo $rowlocationlist->idtbl_location ?>">
														<?php echo $rowlocationlist->location ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<form>
										<div class="row">
											<div class="col-12 col-md-6">
												<label class="small font-weight-bold text-dark">Product*</label><br>
												<select class="form-control form-control-sm" style="width: 100%;"
													name="productlist" id="productlist" required>
												</select>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Sale Price :</label>
													<input type="text" name="saleprice"
														class="form-control form-control-sm" id="saleprice" readonly>
													<input type="hidden" name="productname"
														class="form-control form-control-sm" id="productname">
													<input type="hidden" name="productid"
														class="form-control form-control-sm" id="productid">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">QTY :</label>
													<input type="number" name="qty" class="form-control form-control-sm"
														id="qty">
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="form-group mb-1">
													<label class="small font-weight-bold text-dark">Sale Discount
														:</label>
													<input type="number" name="salediscount"
														class="form-control form-control-sm" id="salediscount">
												</div>
											</div>
										</div>
										<div class="form-group mt-2">
											<button type="button" name="BtnAdd" id="BtnAdd"
												class="btn btn-primary btn-m  fa-pull-right"><i
													class="fas fa-plus"></i>&nbsp;Add</button>
										</div>
										<button type="reset" name="hiddenreset" id="hiddenreset"
											style="display:none;"></button>
									</form>
									<br><br><br>
								</div>

								<div class="col-12 col-md-8">
									<div class="row">
										<div class="col-12 col-md-12">
											<div class="table scrollbar" id="style-2">
												<table class="table table-bordered table-striped  nowrap display"
													id="tblinvoice">
													<thead>
														<th>Product Name</th>
														<th>Qty</th>
														<th>Sale Price</th>
														<th>Discount</th>
														<th>Net Amount</th>
													</thead>
													<tbody>

													</tbody>
													<tfoot>
														<tr>
															<th class="text-right" colspan="5"><label
																	id="labeltotal"></label><br>
																<input type="hidden" id="hiddenfulltotal"
																	name="hiddenfulltotal">
																<input type="hidden" id="hiddenfulldistotal"
																	name="hiddenfulldistotal">
																<input type="hidden" id="hiddenfullnettotal"
																	name="hiddenfullnettotal">
																<label id="labeldistotal"></label><br>
																<label id="labelnettotal"></label><br>
																<label id="htmlbillamount"></label></th>

														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
									<br><br>
									<div class="form-group mt-2">
										<button type="button" name="Btnsubmit" id="Btnsubmit"
											class="btn btn-primary btn-m  fa-pull-right"><i
												class="far fa-save"></i>&nbsp;Save</button>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
		</main>

		<div class="modal fade bd-example-modal-sm" id="saletypemodel" tabindex="-1" role="dialog"
			aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<button type="button" id="retailbutton"
							class="btn btn-primary btn-lg btn-block fa-pull-center"><i
								class="fas fa-cash-register fa-2x"></i>&nbsp; RETAIL SALE</button><br><br>
						<button type="button" id="wholesalebutton"
							class="btn btn-danger btn-lg btn-block  fa-pull-center"><i
								class="fas fa-cash-register fa-2x"></i>&nbsp; WHOLE SALE</button>
					</div>
				</div>
			</div>
		</div>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<?php include "include/footer.php"; ?>


<script>

    
    $(document).ready(function () {

    	$('#porderdetailview').dataTable();

    	// get bill view deatils table according to date
    	$('#loadingdate').on("change", function () {
    		event.preventDefault();
    		var selectdate = $("#loadingdate").val();
    		$.ajax({
    			type: "POST",
    			data: {
    				save: '1',
    				date: selectdate
    			},
    			url: "<?php echo base_url() ?>Invoice/Getporderviewtable",
    			success: function (result) {
    				$('#viewhtml').html(result);
    			}
    		});
    	});
    	// new bill function
    	$(document).on('click', '.btnInvoice', function () {
    		var id = $(this).attr('id');
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: "<?php echo base_url() ?>Invoice/Getorderdetails",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i) {
    					html1 += '<option value="' + obj[i].idtbl_product + '">';
    					html1 += obj[i].materialname + ' - ' + obj[i].productcode;
    					html1 += '</option>';
    				});
    				$('#productlist').empty().append(html1);
    				$('#customer').val(obj[0].name);
    				$('#orderid').val(obj[0].idtbl_customer_porder);
    				// $('#saletypemodel').modal('show');
    				$("#billingsection").show();
    			}
    		});
    	});


    	// get product details according to product select
    	$(document).on("change", "#productlist", function () {
    		var productid = $("#productlist").val();
    		var typesale = $("#saletype").val();
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productid,
    				saletypes: typesale
    			},
    			url: "<?php echo base_url() ?>Invoice/Getproductdetails",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#saleprice').val(obj.saleprice);
    				$('#productname').val(obj.code);
    				$('#productid').val(obj.id);
    			}
    		});
    	});

    	// set sale type 
    	// $(document).on("click", "#retailbutton", function () {
    	// 	var saletype = 1;
    	// 	$('#saletype').val(saletype);
    	// 	$('#saletypemodel').modal('hide');
    	// });

    	// $(document).on("click", "#wholesalebutton", function () {
    	// 	var saletype = 2;
    	// 	$('#saletype').val(saletype);
    	// 	$('#saletypemodel').modal('hide');
    	// });


    	// stock quntity check with user enterd quntity      
    	var count
    	$(document).on("keyup", "#qty", function (event) {
    		event.preventDefault();
    		var productid = $('#productlist').val();
    		var enterqty = $('#qty').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				product: productid,
    				qty: enterqty,

    			},
    			url: "<?php echo base_url() ?>Invoice/Getproductavalaibleqty",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				count = obj.checkqty;

    				if (count == '1') {
    					/*if the quantity is greater than the stock*/
    					alert('Warning !! The Quantity you Entered is not Available in stock !!');
    					$('#BtnAdd').prop('disabled', true);
    				} else {
    					$('#BtnAdd').prop('disabled', false);
    				}

    			}
    		});
    	});

    	// add products and other details to the bill
    	$(document).on("click", "#BtnAdd", function () {
    		var productID = $('#productlist').val();
    		var product = $('#productname').val();
    		var productcode = $('#productcode').val();
    		var sale = parseFloat($('#saleprice').val());
    		var unitprice = parseFloat($('#unitprice').val());
    		var discountpresentage = parseFloat($('#salediscount').val());
    		var qty = parseFloat($('#qty').val());
    		var total = sale * qty;
    		var total = parseFloat(total);

    		var discountamount = parseFloat((total * discountpresentage) / 100);
    		var totalwithdis = parseFloat(total - discountamount);
    		var showtotal = parseFloat(totalwithdis).toFixed(2);

    		$('#tblinvoice> tbody:last').append('<tr><td class="text-center">' + product + '</td><td class="text-center">' + qty + '</td><td class="text-right">' +
    			sale + '</td><td class=" distotal text-center">' + discountamount + '</td><td class=" total text-right">' + total + '</td><td class="nettotal d-none">' +
    			totalwithdis + '</td><td class=" d-none">' + unitprice + '</td><td class="d-none ">' + productID + '</td></tr>');


    		var sum = 0;
    		$(".total").each(function () {
    			sum += parseFloat($(this).text());
    		});

    		var showsum = parseFloat(sum).toFixed(2);

    		var dissum = 0;
    		$(".distotal").each(function () {
    			dissum += parseFloat($(this).text());
    		});

    		var showdissum = parseFloat(dissum).toFixed(2);

    		var netsum = 0;
    		$(".nettotal").each(function () {
    			netsum += parseFloat($(this).text());
    		});

    		var shownetsum = parseFloat(netsum).toFixed(2);

    		$('#labeltotal').html('Gross Amount: ' + showsum);
    		$('#labeldistotal').html('Discount: ' + showdissum);
    		$('#labelnettotal').html('Net Total:' + shownetsum);
    		$('#htmlbillamount').html('Rs. ' + shownetsum);
    		$('#hiddenfulltotal').val(sum);
    		$('#hiddenfulldistotal').val(dissum);
    		$('#hiddenfullnettotal').val(netsum);
    		$('#hiddenreset').click();


    	});

    	// bill data submit for process data
    	$(document).on("click", "#Btnsubmit", function () {

    		// get table data into array
    		var tbody = $('#tblinvoice tbody');
    		if (tbody.children().length > 0) {
    			jsonObj = []
    			$("#tblinvoice tbody tr").each(function () {
    				item = {}
    				$(this).find('td').each(function (col_idx) {
    					item["col_" + (col_idx + 1)] = $(this).text();
    				});
    				jsonObj.push(item);
    			});
    		}
    		// console.log(jsonObj);
    		var total = $('#hiddenfulltotal').val();
    		var distotal = $('#hiddenfulldistotal').val();
    		var nettotal = $('#hiddenfullnettotal').val();
    		// var salestype = $("#saletype").val();
    		var location = $('#location').val();
    		var orderid = $('#orderid').val();


    		$.ajax({
    			type: "POST",
    			data: {
    				tableData: jsonObj,
    				total: total,
    				distotal: distotal,
    				nettotal: nettotal,
    				location: location,
    				// salestype: salestype,
    				orderid: orderid,
    			},
    			url: "<?php echo base_url() ?>Invoice/Invoiceinsertupdate",
    			success: function (result) {
    				// console.log(result);
    				var objfirst = JSON.parse(result);
    					alert("Record Added Successfully");
    					window.location.reload(true);

    			}
    		});


    	});

    });


</script>