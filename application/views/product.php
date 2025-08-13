<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<style>
	.toggle {
		cursor: pointer;
		display: inline-block;
	}

	.toggle-switch {
		display: inline-block;
		background: #ccc;
		border-radius: 0px;
		width: 58px;
		height: 30px;
		position: relative;
		vertical-align: middle;
		transition: background 0.25s;
	}

	.toggle-switch:before,
	.toggle-switch:after {
		content: "";
	}

	.toggle-switch:before {
		display: block;
		background: linear-gradient(to bottom, #fff 0%, #eee 100%);
		border-radius: 0%;
		width: 22px;
		height: 22px;
		position: absolute;
		top: 4px;
		left: 4px;
		transition: left 0.25s;
	}

	.toggle:hover .toggle-switch:before {
		background: linear-gradient(to bottom, #fff 0%, #fff 100%);
	}

	.toggle-checkbox:checked+.toggle-switch {
		background: #56c080;
	}

	.toggle-checkbox:checked+.toggle-switch:before {
		left: 30px;
	}

	.toggle-checkbox {
		position: absolute;
		visibility: hidden;
	}

	.toggle-label {
		margin-left: 5px;
		position: relative;
		top: 2px;
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
							<div class="page-header-icon"><i class="fas fa-briefcase"></i></div>
							<span>Finish Good</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12 text-right">
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
									data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i
										class="fas fa-file-upload mr-2"></i>Upload File</button>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<form action="<?php echo base_url() ?>Product/Productinsertupdate" method="post"
									autocomplete="off">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Material Name*</label>
										<input type="hidden" class="form-control form-control-sm" name="materialcodeid"
											id="materialcodeid" required>
										<select class="form-control form-control-sm" name="materialcode"
											id="materialcode">
											<option value="">Select</option>
											<?php foreach($material->result() as $rowmaterial){ ?>
											<option value="<?php echo $rowmaterial->idtbl_material_code ?>"
												data-materialid="<?php echo $rowmaterial->materialcode?>">
												<?php echo $rowmaterial->materialname.'-'.$rowmaterial->materialcode?>
											</option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Barcode</label>
										<input type="text" class="form-control form-control-sm" name="barcode"
											id="barcode">
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Description</label>
										<textarea type="text" class="form-control form-control-sm" name="desc"
											id="desc"></textarea>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Weight</label>
											<input type="text" class="form-control form-control-sm" name="weight"
												id="weight">
										</div>
										<div class="col">
											<label class="small font-weight-bold">Form</label>
											<input type="hidden" class="form-control form-control-sm" name="formid"
												id="formid">
											<select class="form-control form-control-sm" name="form" id="form">
												<option value="">Select</option>
												<?php foreach($form->result() as $rowformcode){ ?>
												<option value="<?php echo $rowformcode->idtbl_form ?>"
													data-formcodeid="<?php echo $rowformcode->formcode?>">
													<?php echo $rowformcode->formname.'-'.$rowformcode->formcode?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Grade</label>
											<input type="hidden" class="form-control form-control-sm" name="gradeid"
												id="gradeid">
											<select class="form-control form-control-sm" name="grade" id="grade">
												<option value="">Select</option>
												<?php foreach($grade->result() as $rowgradecode){ ?>
												<option value="<?php echo $rowgradecode->idtbl_grade ?>"
													data-gradeid="<?php echo $rowgradecode->gradecode?>">
													<?php echo $rowgradecode->gradename.'-'.$rowgradecode->gradecode?>
												</option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Brand</label>
											<input type="hidden" class="form-control form-control-sm" name="brandid"
												id="brandid">
											<select class="form-control form-control-sm" name="brand" id="brand">
												<option value="">Select</option>
												<?php foreach($brand->result() as $rowbrandcode){ ?>
												<option value="<?php echo $rowbrandcode->idtbl_brand ?>"
													data-brandid="<?php echo $rowbrandcode->brandcode?>">
													<?php echo $rowbrandcode->brandname.'-'.$rowbrandcode->brandcode?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Size</label>
											<input type="hidden" class="form-control form-control-sm" name="sizeid"
												id="sizeid">
											<select class="form-control form-control-sm" name="size" id="size">
												<option value="">Select</option>
												<?php foreach($size->result() as $rowsizecode){ ?>
												<option value="<?php echo $rowsizecode->idtbl_size ?>"
													data-sizeid="<?php echo $rowsizecode->sizecode?>">
													<?php echo $rowsizecode->sizename.'-'.$rowsizecode->sizecode?>
												</option>
												<?php } ?>
											</select>
										</div>
										<div class="col">
											<label class="small font-weight-bold">Type</label>
											<input type="hidden" class="form-control form-control-sm" name="typeid"
												id="typeid">
											<select class="form-control form-control-sm" name="type" id="type">
												<option value="">Select</option>
												<?php foreach($type->result() as $rowtypecode){ ?>
												<option value="<?php echo $rowtypecode->idtbl_unit_type ?>"
													data-typeid="<?php echo $rowtypecode->unittypecode?>">
													<?php echo $rowtypecode->unittypename.'-'.$rowtypecode->unittypecode?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col-6">
											<label class="small font-weight-bold">Retail Price</label>
											<input type="text" class="form-control form-control-sm" name="retailprice"
												id="retailprice">
										</div>
										<div class="col-6">
											<label class="small font-weight-bold d-none">Wholesale Price</label>
											<input type="text" class="form-control form-control-sm d-none"
												name="wholesaleprice" id="wholesaleprice">
										</div>
									</div>
									<div class="form-group mt-2 text-right">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
											<?php if($addcheck==0){echo 'disabled';} ?>><i
												class="far fa-save"></i>&nbsp;Add</button>
									</div>
									<input type="hidden" name="recordOption" id="recordOption" value="1">
									<input type="hidden" name="recordID" id="recordID" value="">
								</form>
							</div>
							<div class="col-8">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="productdataTable">
										<thead>
											<tr>
												<th>#</th>
												<th>Material Name</th>
												<th>Barcode</th>
												<th>FG Code</th>
												<th>Weight</th>
												<th>Retail Price</th>
												<th class="d-none">Wholesale Price</th>
												<th>Material Code</th>
												<th>Form</th>
												<th>Grade</th>
												<th>Brand</th>
												<th>Size</th>
												<th>Type</th>
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
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Upload file</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12 mb-3">
						<a href="<?php echo site_url('csv/samplefinishgoodinfo.csv') ?>" download>Click here</a> to
						download a Sample Csv
					</div>
				</div>
				<form action="<?php echo base_url() ?>Product/Finishgoodlupload" method="post"
					enctype="multipart/form-data">
					<div class="input-group input-group-sm">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="csvfile" name="csvfile"
								aria-describedby="csvfile" required>
							<label class="custom-file-label" for="csvfile">Choose file</label>
						</div>
						<div class="input-group-append">
							<button class="btn btn-secondary" type="submit" id="csvfile">Upload File</button>
						</div>
					</div>
				</form>
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
						<label class="small font-weight-bold">FG Code</label>
						<input type="text" class="form-control form-control-sm" name="fgcode" id="fgcode" readonly>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">SO No</label>
						<input type="text" class="form-control form-control-sm" name="socode" id="socode" required>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">MF Date</label>
						<input type="date" class="form-control form-control-sm" name="mfdate" id="mfdate" required>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">EXP Date</label>
						<input type="date" class="form-control form-control-sm" name="expdate" id="expdate" required>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Batch No</label>
						<input type="text" class="form-control form-control-sm" name="batchno" id="batchno" required>
					</div>
					<div class="form-group mt-3 text-right">
						<button type="button" class="btn btn-primary btn-sm" id="btncreatelable"><i class="fas fa-print mr-2"></i>Print Lable</button>
						<input type="submit" class="d-none" id="hidesubmitbtn">
						<input type="reset" class="d-none" id="hideresetbtn">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="finishgoodinfomodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Finish Good Info</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewdescription"></div>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {

		$("#materialcode").select2({
	    });

		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

		$('#productdataTable').DataTable({
			"destroy": true,
			"processing": true,
			"serverSide": true,
			dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			responsive: true,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			"buttons": [{
					extend: 'csv',
					className: 'btn btn-success btn-sm',
					title: 'Product Information',
					text: '<i class="fas fa-file-csv mr-2"></i> CSV',
				},
				{
					extend: 'pdf',
					className: 'btn btn-danger btn-sm',
					title: 'Product Information',
					text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
				},
				{
					extend: 'print',
					title: 'Product Information',
					className: 'btn btn-primary btn-sm',
					text: '<i class="fas fa-print mr-2"></i> Print',
					customize: function (win) {
						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
				},
				// 'copy', 'csv', 'excel', 'pdf', 'print'
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/productlist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_product"
				},
				{
					"data": "materialname"
				},
				{
					"data": "barcode"
				},
				{
					"data": "productcode"
				},
				{
					"data": "weight"
				},
				{
					"data": "retailprice"
				},
				// {
				//     "data": "wholesaleprice"
				// },
				{
					"data": "materialcode"
				},
				{
					"data": "formname"
				},
				{
					"data": "gradename"
				},
				{
					"data": "brandname"
				},
				{
					"data": "sizename"
				},
				{
					"data": "unittypecode"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						// button += '';
                        button += '<a href="<?php echo base_url() ?>Product/Barcode/'+full['barcode']+'" class="btn btn-dark btn-sm mr-1" target="_blank"><i class="fas fa-barcode"></i></a>';
                        button += '<button class="btn btn-warning btn-sm mr-1 btnlable" id="'+full['productcode']+'"><i class="fas fa-tag"></i></button>';
						button+='<button class="btn btn-secondary btn-sm btnview mr-1" id="'+full['idtbl_product']+'"><i class="fas fa-eye"></i></button>';
						button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
						if (editcheck != 1) {
							button += 'd-none';
						}
						button += '" id="' + full['idtbl_product'] +
							'"><i class="fas fa-pen"></i></button>';
						if (full['status'] == 1) {
							button += '<a href="<?php echo base_url() ?>Product/Productstatus/' +
								full['idtbl_product'] +
								'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></a>';
						} else {
							button += '<a href="<?php echo base_url() ?>Product/Productstatus/' +
								full['idtbl_product'] +
								'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-times"></i></a>';
						}
						button += '<a href="<?php echo base_url() ?>Product/Productstatus/' + full[
								'idtbl_product'] +
							'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
						if (deletecheck != 1) {
							button += 'd-none';
						}
						button += '"><i class="fas fa-trash-alt"></i></a>';

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#productdataTable tbody').on('click', '.btnview', function(){
            var id = $(this).attr('id');
			// alert(id);

            $.ajax({
                type: "POST",
                data: {

                    recordID: id
                },
                url: '<?php echo base_url() ?>Product/Getproductinfo',
                success: function(result) { //alert(result);
                    $('#viewdescription').html(result);
                    $('#finishgoodinfomodal').modal('show');
                }
            });            
        });
		$('#productdataTable tbody').on('click', '.btnEdit', function () {
			var r = confirm("Are you sure, You want to Edit this ? ");
			if (r == true) {
				var id = $(this).attr('id');
				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Product/Productedit',
					success: function (result) { //alert(result);
						var obj = JSON.parse(result);
						$('#recordID').val(obj.id);
						$('#barcode').val(obj.barcode);
						$('#desc').val(obj.desc);
						$('#weight').val(obj.weight);
						$('#unit').val(obj.unit);
						$('#materialcode').val(obj.materialcode);
						$('#form').val(obj.form);
						$('#grade').val(obj.grade);
						$('#brand').val(obj.brand);
						$('#size').val(obj.size);
						$('#type').val(obj.type);
						$('#retailprice').val(obj.retailprice);
						// $('#wholesaleprice').val(obj.wholesaleprice);                                   

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});
		$('#productdataTable tbody').on('change', '.btntoggle', function () {
			var id = $(this).attr('id');

			$(this).prop('checked', true);

			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Product/Semiproductupdatestatus',
				success: function (result) {
					if (obj.statuschange == 1) {
						$('#statuscheck').prop('checked', true);
					}

				},
			});
		});
		$('#productdataTable tbody').on('click', '.btnlable', function () {
			var id = $(this).attr('id');
			$('#fgcode').val(id);
			$('#lablemodal').modal('show');
		});
		$('#btncreatelable').click(function(){
			if (!$("#formlable")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hidesubmitbtn").click();
            } else {
				let fgcode = $('#fgcode').val();
				let socode = $('#socode').val();
				let mfdate = $('#mfdate').val();
				let expdate = $('#expdate').val();
				let batchno = $('#batchno').val();

				var link ='<?php echo base_url() ?>Product/Createlabel/'+fgcode+'/'+socode+'/'+mfdate+'/'+expdate+'/'+batchno;
				window.open(link, '_blank');
				$('#hideresetbtn').click();
				$('#lablemodal').modal('hide');
			}
		});

		$(function () {
			var typingTimer;
			var doneTypingInterval = 10;
			var $barcode = $('#barcode');
			var barcodeValue = "";

			$barcode.on('input', function () {
				barcodeValue = $barcode.val();
				clearTimeout(typingTimer);
				if (barcodeValue) {
					typingTimer = setTimeout(checkBarcode, doneTypingInterval);
				}
			});

			function checkBarcode() {
				$.ajax({
					url: '<?php echo base_url() ?>Product/Checkbarcode',
					method: 'post',
					data: {
						barcode: barcodeValue
					},
					dataType: 'json',
					success: function (response) {
						if (response.success) {
							alert(response.message);
						}
					},
					error: function (xhr, status, error) {
						alert('An error occurred while checking the barcode: ' + error);
					}
				});
			}
		});

		$('#materialcode').change(function () {

			$("#materialcodeid").val($("#materialcode").find(":selected").data('materialid'));

		});
		$('#form').change(function () {

			$("#formid").val($("#form").find(":selected").data('formcodeid'));

		});
		$('#grade').change(function () {

			$("#gradeid").val($("#grade").find(":selected").data('gradeid'));

		});
		$('#brand').change(function () {

			$("#brandid").val($("#brand").find(":selected").data('brandid'));

		});
		$('#size').change(function () {

			$("#sizeid").val($("#size").find(":selected").data('sizeid'));
		});
		$('#type').change(function () {

			$("#typeid").val($("#type").find(":selected").data('typeid'));
		});
		$('#unit').change(function () {

			$("#unitid").val($("#unit").find(":selected").data('unitid'));
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
