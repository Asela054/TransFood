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
						<h1 class="page-header-title font-weight-light">
							<div class="page-header-icon"><i class="fas fa-exchange-alt"></i></div>
							<span>Material Transaction</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12 col-md-4">
								<form action="<?php echo base_url() ?>Customer/Customerinsertupdate" method="post"
									autocomplete="off">
									<div class="form-row mb-1">
										<div class="col-5">
											<label class="small font-weight-bold">From Location*</label>
											<select class="form-control form-control-sm" name="fromlocation"
												id="fromlocation">
												<option value="">Select</option>
												<?php foreach($location->result() as $rowlocationlist){ ?>
												<option value="<?php echo $rowlocationlist->idtbl_location ?>">
													<?php echo $rowlocationlist->location ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col mt-4 ml-4">
											<h1 class="page-header-title font-weight-light">
												<div class="page-header-icon"><i class="fas fa-long-arrow-alt-right"
														style="color: red; width:40px;"></i></div>
											</h1>
										</div>
										<div class="col-5">
											<label class="small font-weight-bold">To Location*</label>
											<select class="form-control form-control-sm" name="tolocation"
												id="tolocation">
												<option value="">Select</option>
												<?php foreach($tolocation->result() as $rowlocationlist){ ?>
												<option value="<?php echo $rowlocationlist->idtbl_location ?>">
													<?php echo $rowlocationlist->location ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col-6">
											<label class="small font-weight-bold">Material*</label>
											<div class="form-group mb-1">
												<input type="hidden" class="form-control form-control-sm"
													name="hiddenproductid" id="hiddenproductid" required>
                                                    <input type="hidden" class="form-control form-control-sm"
													name="hiddenproductcode" id="hiddenproductcode" required>
                                                    <input type="hidden" class="form-control form-control-sm"
													name="hiddenbatchcode[]" id="hiddenbatchcode" required>
                                                    <input type="hidden" class="form-control form-control-sm"
													name="hiddenbatchid" id="hiddenbatchid" required>
												<select class="form-control form-control-sm" name="productlist[]"
													id="productlist" required>

												</select>
											</div>
										</div>
										<div class="col-6">
											<label class="small font-weight-bold">Batch No.*</label>
											<select class="form-control form-control-sm" name="batchlist[]"
												id="batchlist" required multiple>

											</select>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col-6">
											<label class="small font-weight-bold">Qty*</label>
											<input type="text" class="form-control form-control-sm" name="qty" id="qty"
												required>
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
									<div class="col-12 col-md-12 mt-4">
										<div class="table scrollbar" id="style-2">
											<table class="table table-bordered table-striped  nowrap display"
												id="tblstocktrans">
												<thead>
													<th>From Location</th>
                                                    <th class="d-none">From Location ID</th>
													<th>To Location</th>
                                                    <th class="d-none">To Location ID</th>
													<th>Product</th>
                                                    <th class="d-none">Product ID</th>
													<th>Batch No.</th>
													<th>Qty.</th>
												</thead>
												<tbody>

												</tbody>
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
		</main>
		<?php include "include/footerbar.php"; ?>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>

function checkLocations() {
    var fromLocation = document.getElementById("fromlocation").value;
    var toLocation = document.getElementById("tolocation").value;
    
    if (fromLocation === toLocation && fromLocation !== "" && toLocation !== "") {
      alert("Please select different locations for 'From Location' and 'To Location'");
    }
  }

  document.getElementById("fromlocation").addEventListener("change", checkLocations);
  document.getElementById("tolocation").addEventListener("change", checkLocations);

    $(document).ready(function() {

		
		$("#productlist").select2({
		ajax: {
			url: "<?php echo base_url() ?>Materialtransfer/Getproductlisttoselectpicker",
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

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $("#batchlist").select2();
        $("#batchlist").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);
            
            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });


        $('#fromlocation').on('change', function () {
        	var locationId = $(this).val();

        	$.ajax({
        		type: "POST",
        		data: {
        			locationId: locationId
        		},
        		url: '<?php echo base_url("Materialtransfer/Getproductlist"); ?>',
        		success: function (result) {
        			var obj = JSON.parse(result);
        			var options = '';

        			options += '<option value="">Select</option>';
        			obj.forEach(function (product) {
        				options += '<option value="' + product.idtbl_product + '">' + product.productcode + '</option>';
        			});
        			$('#productlist').html(options);

        			$('#productlist').on('change', function () {
        				var selectedProduct = obj.find(product => product.idtbl_product == $(this).val());
        				$('#hiddenproductid').val($(this).val());
        				$('#hiddenproductcode').val(selectedProduct.productcode);
        			});
        		},
        		error: function (xhr, status, error) {
        			console.log(xhr.responseText);
        		}
        	});
        });

$('#productlist').on('change', function () {
    var productId = $(this).val();
	var fromlocation = $('#fromlocation').val();

    $.ajax({
        type: "POST",
        data: {
            productId: productId,
			fromlocation: fromlocation
        },
        url: '<?php echo base_url("Materialtransfer/Getbatchlist"); ?>',
        success: function (result) {
            var obj = JSON.parse(result);
            var options = '';

			obj.forEach(function (product) {
				options += '<option value="' + product.batchno + '">' + product.batchno + '/' + product.totalqty + '</option>';
			});

            $('#batchlist').html(options);

            $('#batchlist').on('change', function () {
                var selectedBatch = obj.filter(product => $(this).val().indexOf(product.idtbl_stock.toString()) !== -1);
                $('#hiddenbatchid').val($(this).val());
                var batchCodes = selectedBatch.map(product => product.batchno).join(', ');
                $('input[name="hiddenbatchcode[]"]').val(batchCodes);
            });
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});

$(document).on("click", "#BtnAdd", function () {
    var fromlocation = $('#fromlocation').val();
    var fromlocationtext = $('#fromlocation option:selected').text();
    var tolocation = $('#tolocation').val();
    var tolocationtext = $('#tolocation option:selected').text();
    var productID = $('#hiddenproductid').val();
    var productcode = $('#hiddenproductcode').val();
    var batchlist = $('#batchlist').val();
    var qty = $('#qty').val();

    $('#tblstocktrans> tbody:last').append('<tr><td class="text-left">' + fromlocationtext + '</td><td class="text-left d-none">' + fromlocation + '</td><td class="text-left">' + tolocationtext + '</td><td class="text-left d-none">' + tolocation + '</td><td class="text-left">' +
        productcode + '</td><td class=" distotal text-left d-none">' + productID + '</td><td class=" total text-left">' + batchlist + '</td><td class="nettotal">' +
        qty + '</td></tr>');

	$('#fromlocation').val('');
    $('#tolocation').val('');
    $('#hiddenproductid').val('');
    $('#hiddenproductcode').val('');
	$('#productlist').val('');
    $('#batchlist').val([]).trigger('change');
    $('#qty').val('');
});

        // bill data submit for process data
        $(document).on("click", "#Btnsubmit", function () {

        	// get table data into array
        	var tbody = $('#tblstocktrans tbody');
        	if (tbody.children().length > 0) {
        		jsonObj = []
        		$("#tblstocktrans tbody tr").each(function () {
        			item = {}
        			$(this).find('td').each(function (col_idx) {
        				item["col_" + (col_idx + 1)] = $(this).text();
        			});
        			jsonObj.push(item);
        		});
        	}
        	console.log(jsonObj);

            var fromlocation = $('#fromlocation').val();
    		var tolocation = $('#tolocation').val();
            var hiddenbatchid = $('#hiddenbatchid').val();


        	$.ajax({
        		type: "POST",
        		data: {
        			tableData: jsonObj,
                    fromlocation: fromlocation,
    				tolocation: tolocation,
                    hiddenbatchid: hiddenbatchid,
        		},
        		url: "<?php echo base_url() ?>Materialtransfer/Stocktransferprocess",
        		success: function (result) {
        			// console.log(result);
        			var objfirst = JSON.parse(result);
        			alert("Transaction Successful!");
        			window.location.reload(true);

        		}
        	});


        });



    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to active this?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }
</script>
<?php include "include/footer.php"; ?>
