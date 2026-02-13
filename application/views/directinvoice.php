<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<style>
	.highlighted-row {
    background-color: yellow;
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
							<div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
							<span>Direct Invoice</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
					<div class="row">
                        </div>
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="pordertable">
										<thead>
										<th>#</th>
										<th>Order Date</th>
										<th>Sales Order No.</th>
										<th>Customer</th>
										<th>Amount</th>
										<th>Actions</th>
									</thead>
									</table>
								</div>
							</div>
						</div>
						<br>
						<hr>
						<div id="billingsection" style="display: none">

							<div class="row">
								<div class="col-12 col-md-4">
									<div class="row">
										<div class="col">
											<div class="form-group mb-1">
												<input id="saletype" name="saletype" type="hidden">
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<input type="hidden" name="orderid" class="form-control form-control-sm" id="orderid" required>
											<label class="small font-weight-bold text-dark">Customer</label>
											<input type="text" name="customer" class="form-control form-control-sm" id="customer" readonly>
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Currency Type*</label>
											<select class="form-control form-control-sm" name="currencytype" id="currencytype" required>
												<option value="">Select</option>
												<?php foreach($currencylist as $rowcurrencylist){ ?>
												<option value="<?php echo $rowcurrencylist['id'] ?>" data-currencycode="<?php echo $rowcurrencylist['code'] ?>"><?php echo $rowcurrencylist['text'] ?></option>
												<?php } ?>
											</select>
											<input type="hidden" name="hidecurrencytype" id="hidecurrencytype">
										</div>
									</div>
									<div class="row d-none">
										<div class="col">
											<div class="form-group mb-1">
												<label class="small font-weight-bold text-dark">Bank* :</label>
												<select class="form-control form-control-sm" name="bank"
													id="bank" required>
													<option value="">Select</option>
													<?php foreach($bank->result() as $rowbank){ ?>
													<option value="<?php echo $rowbank->idtbl_invoice_bank ?>">
														<?php echo $rowbank->bank_name.'/'.$rowbank->bank_branch.'-'.$rowbank->account_no ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<label class="small font-weight-bold text-dark">Conversion Rate*</label>
											<input type="text" id="convertrate" name="convertrate" class="form-control form-control-sm">
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Location*</label>
											<select class="form-control form-control-sm" name="location" id="location" required>
												<option value="">Select</option>
												<?php foreach($location->result() as $rowlocationlist){ ?>
												<option value="<?php echo $rowlocationlist->idtbl_location ?>">
													<?php echo $rowlocationlist->location ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<label class="small font-weight-bold text-dark">Product*</label><br>
											<select class="form-control form-control-sm" style="width: 100%;"
												name="productlist" id="productlist" required>
											</select>
											<small id="" class="form-text text-danger">Issuing an invoice removes listed products from this order</small>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Batch No.*</label><br>
											<select class="form-control form-control-sm" style="width: 100%;" name="batchlist[]" id="batchlist" required multiple>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<label class="small font-weight-bold text-dark">Sale Price</label>
											<input type="text" name="saleprice" class="form-control form-control-sm" id="saleprice">
											<input type="hidden" name="productname" class="form-control form-control-sm" id="productname">
											<input type="hidden" name="productid" class="form-control form-control-sm" id="productid">
											<input type="hidden" class="form-control form-control-sm" name="hiddenbatchid" id="hiddenbatchid" required>
										</div>
										<div class="col">
											<div class="form-group mb-1">
											<label class="small font-weight-bold text-dark">Order QTY</label>
											<input type="number" name="orderqty" class="form-control form-control-sm" id="orderqty" readonly>
											</div>
										</div>
									</div>
									<div class="form-row">
										<div class="col">
											<label class="small font-weight-bold text-dark">QTY</label>
											<input type="number" name="qty"  id="qty" class="form-control form-control-sm">
										</div>
										<div class="col">
											<label class="small font-weight-bold text-dark">Sale Discount</label>
											<input type="number" name="salediscount" class="form-control form-control-sm" id="salediscount" value="0">
										</div>
									</div>
									<div class="form-group mt-2">
										<button type="button" name="BtnAdd" id="BtnAdd" class="btn btn-primary btn-sm fa-pull-right px-4"><i class="fas fa-plus"></i>&nbsp;Add</button>
									</div>
									<button type="reset" name="hiddenreset" id="hiddenreset" style="display:none;"></button>
								</div>

								<div class="col-12 col-md-8">
									<div class="table scrollbar" id="style-2">
										<table class="table table-bordered table-striped table-sm small nowrap display"
											id="tblinvoice">
											<thead>
												<th>Product Name</th>
												<th>Batch Number</th>
												<th class="text-center">Qty</th>
												<th class="text-right">Sale Price</th>
												<th class="text-right">Discount</th>
												<th class="text-right">Net Amount</th>
											</thead>
											<tbody></tbody>
											<!-- <tfoot>
												<tr>
													<th class="text-right" colspan="6">
														<label id="labeltotal"></label><br>
														
														<label id="labeldistotal"></label><br>
														<label id="labelnettotal"></label><br>
														<label id="htmlbillamount"></label>
													</th>
												</tr>
											</tfoot> -->
										</table>
										<div class="row">
											<div class="col-9 text-right"><h6 class="font-weight-normal">Gross total</h6></div>
											<div class="col-3 text-right"><h6 class="font-weight-normal" id="labeltotal"></h6></div>
										</div>
										<div class="row">
											<div class="col-9 text-right"><h6 class="font-weight-normal">Discount total</h6></div>
											<div class="col-3 text-right"><h6 class="font-weight-normal" id="labeldistotal"></h6></div>
										</div>
										<div class="row">
											<div class="col-9 text-right"><h3 class="font-weight-normal">Net total</h3></div>
											<div class="col-3 text-right"><h3 class="font-weight-normal" id="labelnettotal"></h3></div>
										</div>
										<input type="hidden" id="hiddenfulltotal" name="hiddenfulltotal">
										<input type="hidden" id="hiddenfulldistotal" name="hiddenfulldistotal">
										<input type="hidden" id="hiddenfullnettotal" name="hiddenfullnettotal">
									</div>
									<div class="form-group mt-2">
										<button type="button" name="Btnsubmit" id="Btnsubmit" class="btn btn-primary btn-sm fa-pull-right px-4"><i class="far fa-save"></i>&nbsp;Save</button>
									</div>
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
<?php include "include/footerscripts.php"; ?>
<?php include "include/footer.php"; ?>


<script>

    
    $(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';
		var companyID = '<?php echo $_SESSION['companyid'] ?>';
		var currencycode = '';

		$("#batchlist").select2();
		$("#batchlist").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });

		$('#pordertable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/porderlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
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
					"data": "orderdate"
				},
				{
					"targets": -1,
					"className": '',
					"data": null,
					"render": function (data, type, full) {
						if(companyID==1){return 'UN/SOD-'+full['sod_no'];}
						else if(companyID==2){return 'UF/SOD-'+full['sod_no'];}
					}
				},
				{
					"data": "name"
				},
				{
					"data": "nettotal",
					"render": function (data, type, row) {
						return parseFloat(data).toLocaleString('en-US', {
							minimumFractionDigits: 2,
							maximumFractionDigits: 2
						});
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function(data, type, full) {
						var button = '';
						
						if(full['completestatus']==0){
                            button+='<a href="<?php echo base_url() ?>Directinvoice/Completestatusupdate/'+full['idtbl_customer_porder']+'/1" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-unlock"></i></a>';
                        }else{
                            button+='<button class="btn btn-danger btn-sm mr-1" id=""><i class="fas fa-lock"></i>';
                        }
						button += '<button class="btn btn-primary btn-sm btnInvoice mr-1" id="' + full['idtbl_customer_porder'] + '"><i class="fas fa-file-invoice-dollar"></i>';
						return button;
					}
				}
			],
			rowCallback: function(row, data) {
				// Check if completestatus is 1 and apply a Bootstrap "danger" color
				if (data.completestatus == 1) {
					$(row).addClass('bg-danger-soft');
				}
			},
			drawCallback: function(settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});


		// new bill function
		$(document).on('click', '.btnInvoice', function () {
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: "<?php echo base_url() ?>Directinvoice/Getorderdetails",
				success: function (result) {
					// Parse the JSON result
					var obj = JSON.parse(result);

					if (obj.length > 0) {
						var html1 = '';
						html1 += '<option value="">Select</option>';
						$.each(obj, function (i) {
							html1 += '<option value="' + obj[i].idtbl_product + '">';
							html1 += obj[i].prodcutname + ' - ' + obj[i].productcode;
							html1 += '</option>';
						});
						$('#productlist').empty().append(html1);
						$('#customer').val(obj[0].name);
						$('#orderid').val(obj[0].idtbl_customer_porder);
						$('#currencytype').val(obj[0].currencytype);
						currencycode = $('#currencytype option:selected').data('currencycode');
						$('#currencytype').prop('disabled', true);
						$('#hidecurrencytype').val(obj[0].currencytype);
						$('#convertrate').val(obj[0].conversion_rate);
						// $('#saletypemodel').modal('show');
						$("#billingsection").show();
					} else {
						// Handle the case when there are no records in tbl_invoice
						// Display an error message or handle this situation as needed
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'The products in this order have already been invoiced..'
						});
						$("#billingsection").hide(); // Hide the billing section
					}
				},
				error: function (xhr, status, error) {
					// Handle any errors that occur during the AJAX request
					console.error(error);
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: 'Error occurred while fetching data.'
					});
				}
			});
		});


		$('#productlist').on('change', function () {
			var productId = $(this).val();
			var fromlocation = $('#location').val();

			$.ajax({
				type: "POST",
				data: {
					productId: productId,
					fromlocation: fromlocation
				},
				url: '<?php echo base_url("Directinvoice/Getbatchlist"); ?>',
				success: function (result) { //alert(result);
					var obj = JSON.parse(result);
					var options = '';

					obj.forEach(function (product) {
						options += '<option value="' + product.fgbatchno + '">' + product.fgbatchno + '/' + product.qty + '</option>';
					});

					$('#batchlist').html(options);

					$('#batchlist').on('change', function () {
						var selectedBatch = obj.filter(product => $(this).val().indexOf(product.idtbl_product_stock.toString()) !== -1);
						$('#hiddenbatchid').val($(this).val());
						var batchCodes = selectedBatch.map(product => product.fgbatchno).join(', ');
						$('input[name="hiddenbatchcode[]"]').val(batchCodes);
					});
				},
				error: function (xhr, status, error) {
					console.log(xhr.responseText);
				}
			});
		});

		$(document).on('click', '.btnInvoice2', function () {
    		var id = $(this).attr('id');
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: id
    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getorderdetailsnoninvoice",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				var html1 = '';
    				html1 += '<option value="">Select</option>';
    				$.each(obj, function (i) {
    					html1 += '<option value="' + obj[i].idtbl_product + '">';
    					html1 += obj[i].materialname + ' - ' + obj[i].productcode;
    					html1 += '</option>';
    				});
    				$('#productlist2').empty().append(html1);
    				$('#customer2').val(obj[0].name);
    				$('#orderid2').val(obj[0].idtbl_customer_porder);
    				// $('#saletypemodel').modal('show');
    				$("#billingsection2").show();
    			}
    		});
    	});


    	// get product details according to product select
    	$(document).on("change", "#productlist", function () {
    		var productid = $("#productlist").val();
    		// var typesale = $("#saletype").val();
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productid,
    				// saletypes: typesale
    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getproductdetails",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#productname').val(obj.code);
    				$('#productid').val(obj.id);
    			}
    		});
    	});

		$(document).on("change", "#productlist2", function () {
    		var productid = $("#productlist2").val();
    		// var typesale = $("#saletype").val();
    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productid,
    				// saletypes: typesale
    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getproductdetailsnoninvoice",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#saleprice2').val(obj.saleprice);
    				$('#productname2').val(obj.code);
    				$('#productid2').val(obj.id);
    			}
    		});
    	});

		$(document).on("change", "#productlist", function () {
    		var productid = $("#productlist").val();
			var orderid = $('#orderid').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productid,
					orderid: orderid,
    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getorderqty",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#orderqty').val(obj.orderqty);
					$('#saleprice').val(obj.saleprice);


    			}
    		});
    	});

		$(document).on("change", "#productlist2", function () {
    		var productid = $("#productlist2").val();
			var orderid = $('#orderid2').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				recordID: productid,
					orderid: orderid,
    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getorderqtynoninvoice",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				$('#orderqty2').val(obj.orderqty);

    			}
    		});
    	});

    	// stock quntity check with user enterd quntity      
    	var count
    	$(document).on("keyup", "#qty", function (event) {
    		event.preventDefault();
    		var productid = $('#productlist').val();
    		var enterqty = $('#qty').val();
			var location = $('#location').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				product: productid,
    				qty: enterqty,
					location: location

    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getproductavalaibleqty",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				count = obj.checkqty;

    				if (count == '1') {
    					/*if the quantity is greater than the stock*/
						Swal.fire({
							icon: 'warning',
							title: 'Warning',
							text: 'Warning !! The Quantity you Entered is not Available in stock !!'
						});
    					$('#BtnAdd').prop('disabled', true);
    				} else {
    					$('#BtnAdd').prop('disabled', false);
    				}

    			}
    		});
    	});

		// stock quntity check with user enterd quntity      
		var count
    	$(document).on("keyup", "#qty2", function (event) {
    		event.preventDefault();
    		var productid = $('#productlist2').val();
    		var enterqty = $('#qty2').val();

    		$.ajax({
    			type: "POST",
    			data: {
    				product: productid,
    				qty: enterqty,

    			},
    			url: "<?php echo base_url() ?>Directinvoice/Getproductavalaibleqty",
    			success: function (result) { //alert(result);
    				var obj = JSON.parse(result);
    				count = obj.checkqty;

    				if (count == '1') {
    					/*if the quantity is greater than the stock*/
						Swal.fire({
							icon: 'warning',
							title: 'Warning',
							text: 'Warning !! The Quantity you Entered is not Available in stock !!'
						});
    					$('#BtnAdd2').prop('disabled', true);
    				} else {
    					$('#BtnAdd2').prop('disabled', false);
    				}

    			}
    		});
    	});

    	// add products and other details to the bill
    	$(document).on("click", "#BtnAdd", function () {
    		var productID = $('#productlist').val();
			var batchlist = $('#batchlist').val();
    		var product = $('#productname').val();
    		var productcode = $('#productcode').val();
    		var sale = parseFloat($('#saleprice').val());
    		var unitprice = parseFloat($('#unitprice').val());
    		var discountpresentage = parseFloat($('#salediscount').val());
    		var qty = parseFloat($('#qty').val());
    		var total = sale * qty;
    		var total = parseFloat(total).toFixed(2);

    		var discountamount = parseFloat((total * discountpresentage) / 100);
    		var totalwithdis = parseFloat(total - discountamount);
    		var showtotal = parseFloat(totalwithdis).toFixed(2);

    		$('#tblinvoice> tbody:last').append('<tr><td>' + product + '</td><td>' + batchlist + '</td><td class="text-center">' + qty + '</td><td class="text-right">' + addCommas(sale) + '</td><td class=" distotal text-right">' + addCommas(discountamount) + '</td><td class=" total text-right">' + addCommas(total) + '</td><td class="nettotal d-none">' + totalwithdis + '</td><td class="d-none">' + unitprice + '</td><td class="d-none ">' + productID + '</td></tr>');

    		var sum = 0;
			$(".total").each(function () {
				var value = $(this).text();
				var num = parseFloat(value.replace(/,/g, ''));
				if (!isNaN(num)) {
					sum += num;
				}
			});

    		var showsum = parseFloat(sum).toFixed(2);

    		var dissum = 0;
			$(".distotal").each(function () {
				var value = $(this).text();
				var num = parseFloat(value.replace(/,/g, ''));
				if (!isNaN(num)) {
					dissum += num;
				}
			});

    		var showdissum = parseFloat(dissum).toFixed(2);

    		var netsum = 0;
			$(".nettotal").each(function () {
				var value = $(this).text();
				var num = parseFloat(value.replace(/,/g, ''));
				if (!isNaN(num)) {
					netsum += num;
				}
			});

    		var shownetsum = parseFloat(netsum).toFixed(2);

    		$('#labeltotal').html(currencycode + addCommas(showsum));
    		$('#labeldistotal').html(currencycode + addCommas(showdissum));
    		$('#labelnettotal').html(currencycode + addCommas(shownetsum));
    		// $('#htmlbillamount').html('Rs. ' + shownetsum);
    		$('#hiddenfulltotal').val(sum);
    		$('#hiddenfulldistotal').val(dissum);
    		$('#hiddenfullnettotal').val(netsum);
    		$('#hiddenreset').click();
    	});

		// add products and other details to the bill
		$(document).on("click", "#BtnAdd2", function () {
    		var productID = $('#productlist2').val();
    		var product = $('#productname2').val();
    		var productcode = $('#productcode').val();
    		var sale = parseFloat($('#saleprice2').val());
    		var unitprice = parseFloat($('#unitprice').val());
    		var discountpresentage = parseFloat($('#salediscount2').val());
    		var qty = parseFloat($('#qty2').val());
    		var total = sale * qty;
    		var total = parseFloat(total);

    		var discountamount = parseFloat((total * discountpresentage) / 100);
    		var totalwithdis = parseFloat(total - discountamount);
    		var showtotal = parseFloat(totalwithdis).toFixed(2);

    		$('#tblinvoice2> tbody:last').append('<tr><td class="text-center">' + product + '</td><td class="text-center">' + qty + '</td><td class="text-right">' +
    			sale + '</td><td class=" distotal2 text-center">' + discountamount + '</td><td class=" total2 text-right">' + total + '</td><td class="nettotal2 d-none">' +
    			totalwithdis + '</td><td class=" d-none">' + unitprice + '</td><td class="d-none ">' + productID + '</td></tr>');


    		var sum = 0;
    		$(".total2").each(function () {
    			sum += parseFloat($(this).text());
    		});

    		var showsum = parseFloat(sum).toFixed(2);

    		var dissum = 0;
    		$(".distotal2").each(function () {
    			dissum += parseFloat($(this).text());
    		});

    		var showdissum = parseFloat(dissum).toFixed(2);

    		var netsum = 0;
    		$(".nettotal2").each(function () {
    			netsum += parseFloat($(this).text());
    		});

    		var shownetsum = parseFloat(netsum).toFixed(2);

    		$('#labeltotal2').html('Gross Amount: ' + showsum);
    		$('#labeldistotal2').html('Discount: ' + showdissum);
    		$('#labelnettotal2').html('Net Total:' + shownetsum);
    		$('#htmlbillamount2').html('Rs. ' + shownetsum);
    		$('#hiddenfulltotal2').val(sum);
    		$('#hiddenfulldistotal2').val(dissum);
    		$('#hiddenfullnettotal2').val(netsum);
    		$('#hiddenreset2').click();

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
			var bank = $('#bank').val();
    		var orderid = $('#orderid').val();
    		var currencytype = $('#hidecurrencytype').val();
    		var convertrate = $('#convertrate').val();

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
							tableData: jsonObj,
							total: total,
							distotal: distotal,
							nettotal: nettotal,
							location: location,
							bank: bank,
							orderid: orderid,
							currencytype: currencytype,
							convertrate: convertrate
						},
						url: '<?php echo base_url() ?>Directinvoice/Invoiceinsertupdate',
						success: function (result) { //alert(result);
							// console.log(result);
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
    	});

		// bill data submit for process data
		$(document).on("click", "#Btnsubmit2", function () {

			// get table data into array
			var tbody = $('#tblinvoice2 tbody');
			if (tbody.children().length > 0) {
				jsonObj = []
				$("#tblinvoice2 tbody tr").each(function () {
					item = {}
					$(this).find('td').each(function (col_idx) {
						item["col_" + (col_idx + 1)] = $(this).text();
					});
					jsonObj.push(item);
				});
			}
			// console.log(jsonObj);
			var total = $('#hiddenfulltotal2').val();
			var distotal = $('#hiddenfulldistotal2').val();
			var nettotal = $('#hiddenfullnettotal2').val();
			// var salestype = $("#saletype").val();
			var location = $('#location2').val();
			var orderid = $('#orderid2').val();


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
				url: "<?php echo base_url() ?>Directinvoice/Invoiceinsertupdate",
				success: function (result) {
					// console.log(result);
					var objfirst = JSON.parse(result);
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: 'Record Added Successfully'
						});
						window.location.reload(true);

				}
			});


		});

    });

	function deactive_confirm() {
        return confirm("Are you sure you want to lock this?");
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