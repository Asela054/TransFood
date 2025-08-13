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
                            <div class="page-header-icon"><i class="fas fa-random"></i></div>
                            <span>Miscellaneous</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                            	<ul class="nav nav-tabs" id="myTab" role="tablist">
                            		<li class="nav-item" role="presentation">
                            			<a class="nav-link active font-weight-bold" id="home-tab" data-toggle="tab" href="#home"
                            				role="tab" aria-controls="home" aria-selected="true">Material</a>
                            		</li>
                            		<li class="nav-item" role="presentation">
                            			<a class="nav-link font-weight-bold" id="profile-tab" data-toggle="tab" href="#profile"
                            				role="tab" aria-controls="profile" aria-selected="false">Finish Good</a>
                            		</li>
                            	</ul>
                            	<div class="tab-content" id="myTabContent">
                            		<div class="tab-pane fade show active" id="home" role="tabpanel"
                            			aria-labelledby="home-tab">
                                        <br>
                                        <br>
                                        <div class="row">
                                        	<div class="col-3">
                                        		<form
                                                id="createorderform"
                                        			method="post" autocomplete="off">
                                        			<div class="form-group mb-1">
                                        				<input type="hidden" class="form-control form-control-sm"
                                        					name="type" id="type" value="1" required>
                                        				<div class="custom-control custom-radio custom-control-inline">
                                        					<input type="radio" id="add" name="miscellaneousform"
                                        						class="custom-control-input" value="1" checked>
                                        					<label class="custom-control-label" for="add">Add to the
                                        						Quantity</label>
                                        				</div>
                                        				<div class="custom-control custom-radio custom-control-inline">
                                        					<input type="radio" id="reduce" name="miscellaneousform"
                                        						class="custom-control-input" value="2">
                                        					<label class="custom-control-label" for="reduce">Reduce the
                                        						Quantity</label>
                                        				</div>
                                        			</div>
                                        			<br>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold">Material*</label>
                                        				<select class="form-control form-control-sm" style="width: 100%;" name="material"
                                        					id="material" required>
                                        					<option value="">Select</option>
                                        					<?php foreach($material->result() as $rowmaterial){ ?>
                                        					<option
                                        						value="<?php echo $rowmaterial->idtbl_material_info ?>">
                                        						<?php echo $rowmaterial->materialinfocode?></option>
                                        					<?php } ?>
                                        				</select>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold">Batch Number*</label><br>
                                        				<select class="form-control form-control-sm"
                                        					style="width: 100%;" name="batchno[]" id="batchno" required>
                                        				</select>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold text-dark">Date*</label>
                                        				<input type="date" name="date" id="date"
                                        					value="<?php echo date('Y-m-d') ?>"
                                        					class="form-control form-control-sm">
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label
                                        					class="small font-weight-bold text-dark">Quantity*</label>
                                        				<input type="text" class="form-control form-control-sm"
                                        					name="qty" id="qty" required>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold text-dark">Price</label>
                                        				<input type="text" class="form-control form-control-sm"
                                        					name="price" id="price">
                                        			</div>
                                        			<div class="form-group mt-3 text-right">
                                        				<button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"
                                        					<?php if($addcheck==0){echo 'disabled';} ?>><i
                                        						class="fas fa-plus"></i>&nbsp;Add to list</button>
                                        				<input name="submitBtn" type="submit" value="Save" id="submitBtn"
                                        					class="d-none">
                                        			</div>
                                        		</form>
                                        	</div>
                                        	<div class="col-9">
                                        		<div class="scrollbar pb-3" id="style-3">
                                        			<table class="table table-striped table-bordered table-sm small"
                                        				id="tableorder">
                                        				<thead>
                                        					<tr>
                                        						<th>Material</th>
                                        						<th>Batch No.</th>
                                        						<th class="d-none">MaterialID</th>
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
                                        				<h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                                        			</div>
                                        			<input type="hidden" id="hidetotalorder" value="0">
                                        		</div>
                                        		<hr>
                                        		<div class="form-group mt-2">
                                        			<button type="button" id="btncreateorder"
                                        				class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                        					class="fas fa-save"></i>&nbsp;Save</button>
                                        		</div>
                                        	</div>
                                        </div>
                                    </div>
                            		<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <br>
                                        <br>
                                    <div class="row">
                                        	<div class="col-3">
                                        		<form
                                                id="createorderform2"
                                        			method="post" autocomplete="off">
                                        			<div class="form-group mb-1">
                                        				<input type="hidden" class="form-control form-control-sm"
                                        					name="type2" id="type2" value="2" required>
                                        				<div class="custom-control custom-radio custom-control-inline">
                                        					<input type="radio" id="add2" name="miscellaneousform2"
                                        						class="custom-control-input" value="1" checked>
                                        					<label class="custom-control-label" for="add2">Add to the
                                        						Quantity</label>
                                        				</div>
                                        				<div class="custom-control custom-radio custom-control-inline">
                                        					<input type="radio" id="reduce2" name="miscellaneousform2"
                                        						class="custom-control-input" value="2">
                                        					<label class="custom-control-label" for="reduce2">Reduce the
                                        						Quantity</label>
                                        				</div>
                                        			</div>
                                        			<br>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold">Product*</label>
                                        				<select class="form-control form-control-sm" style="width: 100%;" name="product2"
                                        					id="product2" required>
                                        					<option value="">Select</option>
                                        					<?php foreach($product->result() as $rowproduct){ ?>
                                        					<option
                                        						value="<?php echo $rowproduct->idtbl_product ?>">
                                        						<?php echo $rowproduct->productcode?></option>
                                        					<?php } ?>
                                        				</select>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold">Batch Number*</label><br>
                                        				<select class="form-control form-control-sm"
                                        					style="width: 100%;" name="batchno2[]" id="batchno2" required>
                                        				</select>
                                        			</div>
                                                    <div class="form-group mb-1">
                                        				<label class="small font-weight-bold">Location*</label>
                                        				<select class="form-control form-control-sm" name="location"
                                        					id="location" required>
                                        					<option value="">Select</option>
                                        					<?php foreach($location->result() as $rowlocation){ ?>
                                        					<option
                                        						value="<?php echo $rowlocation->idtbl_location ?>">
                                        						<?php echo $rowlocation->location?></option>
                                        					<?php } ?>
                                        				</select>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold text-dark">Date*</label>
                                        				<input type="date" name="date2" id="date2"
                                        					value="<?php echo date('Y-m-d') ?>"
                                        					class="form-control form-control-sm">
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label
                                        					class="small font-weight-bold text-dark">Quantity*</label>
                                        				<input type="text" class="form-control form-control-sm"
                                        					name="qty2" id="qty2" required>
                                        			</div>
                                        			<div class="form-group mb-1">
                                        				<label class="small font-weight-bold text-dark">Price</label>
                                        				<input type="text" class="form-control form-control-sm"
                                        					name="price2" id="price2">
                                        			</div>
                                        			<div class="form-group mt-3 text-right">
                                        				<button type="button" id="formsubmit2" class="btn btn-primary btn-sm px-4"
                                        					<?php if($addcheck==0){echo 'disabled';} ?>><i
                                        						class="fas fa-plus"></i>&nbsp;Add to list</button>
                                        				<input name="submitBtn" type="submit" value="Save" id="submitBtn2"
                                        					class="d-none">
                                        			</div>
                                        		</form>
                                        	</div>
                                        	<div class="col-9">
                                        		<div class="scrollbar pb-3" id="style-3">
                                        			<table class="table table-striped table-bordered table-sm small"
                                        				id="tableorder2">
                                        				<thead>
                                        					<tr>
                                                                <th>Product</th>
                                        						<th>Batch No.</th>
                                        						<th class="d-none">ProductID</th>
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
                                        				<h1 class="font-weight-600" id="divtotal2">Rs. 0.00</h1>
                                        			</div>
                                        			<input type="hidden" id="hidetotalorder2" value="0">
                                        		</div>
                                        		<hr>
                                        		<div class="form-group mt-2">
                                        			<button type="button" id="btncreateorder2"
                                        				class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                        					class="fas fa-save"></i>&nbsp;Save</button>
                                        		</div>
                                        	</div>
                                        </div>
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
<script>
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

		$("#material").select2({
			// dropdownParent: $('#productioncreatemodal'),
			// placeholder: 'Select supplier',
			ajax: {
				url: "<?php echo base_url() ?>Miscellaneous/Getmateriallist",
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

		$("#product2").select2({
			// dropdownParent: $('#productioncreatemodal'),
			// placeholder: 'Select supplier',
			ajax: {
				url: "<?php echo base_url() ?>Miscellaneous/Getproductlist",
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

        $("#formsubmit").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn").click();
            } else {
                var productID = $('#material').val();
                var batch = $('#batchno').val();
                var product = $("#material option:selected").text();
                var qty = $('#qty').val();
                var price = $('#price').val();
                var batchno = $('#batchno').val();

                var newtotal = parseFloat(price * qty);

                var total = parseFloat(newtotal);
                var showtotal = addCommas(parseFloat(total).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + batch + '</td><td class="d-none">' + productID + '</td><td class="text-center">' + qty + '</td><td class="d-none">' + price + '</td><td class="total d-none">' + total + '</td><td class="text-right">' + showtotal + '</td></tr>');

                $('#material').val('');
                $('#batchno').val('');
                $('#qty').val('');
                $('#price').val('');
                $('#date').val('<?php echo date('Y-m-d') ?>');


                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#hidetotalorder').val(sum);
                $('#material').focus();
            }
        });
        $('#tableorder').on('click', 'tr', async function() {
            var r = await Otherconfirmation("You want to remove this product ? ");
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
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> save')
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
                console.log(jsonObj);

                var type = $('#type').val();
                var date = $('#date').val();
                var selectedRadio = $('input[name="miscellaneousform"]:checked').val();
                var total = $('#hidetotalorder').val();

                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        type: type,
                        date: date,
                        selectedRadio: selectedRadio,
                        total: total
                    },
                    url: 'Miscellaneous/Miscellaneousinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        // if(obj.status==1){
                        //     setTimeout(window.location.reload(), 3000);
                        // }
                        // action(obj.action);

						if(obj.status==1){
							actionreload(obj.action);
						}
						else{
							action(obj.action);
						}
                    }
                });
            }

        });

        $("#formsubmit2").click(function () {
            if (!$("#createorderform2")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtn").click();
            } else {
                var productID2 = $('#product2').val();
                var batch2 = $('#batchno2').val();
                var product2 = $("#product2 option:selected").text();
                var qty2 = $('#qty2').val();
                var price2 = $('#price2').val();

                var newtotal2 = parseFloat(price2 * qty2);

                var total2 = parseFloat(newtotal2);
                var showtotal2 = addCommas(parseFloat(total2).toFixed(2));

                $('#tableorder2 > tbody:last').append('<tr class="pointer"><td>' + product2 + '</td><td>' + batch2 + '</td><td class="d-none">' + productID2 + '</td><td class="text-center">' + qty2 + '</td><td class="d-none">' + price2 + '</td><td class="total2 d-none">' + total2 + '</td><td class="text-right">' + showtotal2 + '</td></tr>');

                $('#product2').val('');
                $('#batchno2').val('');
                $('#qty2').val('');
                $('#price2').val('');
                $('#date2').val('<?php echo date('Y-m-d') ?>');


                var sum = 0;
                $(".total2").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal2').html('Rs. ' + showsum);
                $('#hidetotalorder2').val(sum);
                $('#material2').focus();
            }
        });
        $('#tableorder2').on('click', 'tr', async function() {
            var r = await Otherconfirmation("You want to remove this product ? ");
            if (r == true) {
                $(this).closest('tr').remove();

                var sum = 0;
                $(".total2").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal2').html('Rs. ' + showsum);
                $('#hidetotalorder2').val(sum);
                $('#product2').focus();
            }
        });
        $('#btncreateorder2').click(function () { //alert('IN');
            $('#btncreateorder2').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> save')
            var tbody = $("#tableorder2 tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tableorder2 tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                // console.log(jsonObj);

                var type = $('#type2').val();
                var date = $('#date2').val();
                var selectedRadio = $('input[name="miscellaneousform2"]:checked').val();
                var total = $('#hidetotalorder2').val();
                var location = $('#location').val();


                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        type: type,
                        date: date,
                        selectedRadio: selectedRadio,
                        total: total,
                        location: location
                    },
                    url: 'Miscellaneous/Miscellaneousinsertupdate2',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        // if(obj.status==1){
                        //     setTimeout(window.location.reload(), 3000);
                        // }
                        // action(obj.action);

						if(obj.status==1){
							actionreload(obj.action);
						}
						else{
							action(obj.action);
						}
                    }
                });
            }

        });

        $('#material').on('change', function () {
        	var materialId = $(this).val();

        	$.ajax({
        		type: "POST",
        		data: {
        			materialId: materialId
        		},
                url: '<?php echo base_url() ?>Miscellaneous/Getbatchnolist',
        		success: function (result) {
        			var obj = JSON.parse(result);
        			var options = '';

        			options += '<option value="">Select</option>';
        			obj.forEach(function (batch) {
        				options += '<option value="' + batch.batchno + '">' + batch.batchno + '</option>';
        			});
        			$('#batchno').html(options);
        		}
        	});
        });

        $('#product2').on('change', function () {
        	var productId = $(this).val();

        	$.ajax({
        		type: "POST",
        		data: {
        			productId: productId
        		},
                url: '<?php echo base_url() ?>Miscellaneous/Getbatchnolistaccoproduct',
        		success: function (result) {
        			var obj = JSON.parse(result);
        			var options = '';

        			options += '<option value="">Select</option>';
        			obj.forEach(function (product) {
        				options += '<option value="' + product.fgbatchno + '">' + product.fgbatchno + '</option>';
        			});
        			$('#batchno2').html(options);
        		}
        	});
        });
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
