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
										<label class="small font-weight-bold">Product Name*</label>
										<input type="text" class="form-control form-control-sm" name="productname" id="productname">
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Product Code*</label>
										<input type="text" class="form-control form-control-sm" name="productcode" id="productcode">
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Description</label>
										<textarea type="text" class="form-control form-control-sm" name="desc" id="desc"></textarea>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">Weight</label>
											<input type="text" class="form-control form-control-sm" name="weight" id="weight">
										</div>
										<div class="col">
											<label class="small font-weight-bold">Retail Price</label>
											<input type="text" class="form-control form-control-sm" name="retailprice" id="retailprice">
										</div>
										<div class="col">
											<label class="small font-weight-bold">Retail Price ($)</label>
											<input type="text" class="form-control form-control-sm" name="retailpriceusd" id="retailpriceusd">
										</div>
									</div>
									<div class="form-row mb-1">
										<div class="col">
											<label class="small font-weight-bold">No of Pkts Per Ctn</label>
											<input type="text" class="form-control form-control-sm" name="pktperctn" id="pktperctn">
										</div>
										<div class="col-6">
											<label class="small font-weight-bold">Master carton</label>
											<input type="text" class="form-control form-control-sm" name="masterctn" id="masterctn">
										</div>
									</div>
									<?php if($addcheck==1){ ?>
									<div class="form-group mt-3 text-right">
										<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"><i class="far fa-save"></i>&nbsp;Add</button>
									</div>
									<?php } ?>
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
												<th>Product Name</th>
												<th>Prodcut Code</th>
												<th>Weight</th>
												<th>Retail Price</th>
												<th>Retail Price ($)</th>
												<th>Pkts Per Ctn</th>
												<th>Master carton</th>
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
					"data": "prodcutname"
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
				{
					"data": "retailpriceusd"
				},
				{
					"data": "nopckperctn"
				},
				{
					"data": "mastercartoon"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button+='<button class="btn btn-warning btn-sm btnStockAdd mr-1" data-toggle="tooltip" data-placement="bottom" title="Stock Add" id="'+full['idtbl_product']+'"><i class="fas fa-plus"></i></button>';
                        button += '<a href="<?php echo base_url() ?>Product/Barcode/'+full['productcode']+'" class="btn btn-dark btn-sm mr-1" target="_blank"><i class="fas fa-barcode"></i></a>';
						if (editcheck == 1) {
							button += '<button class="btn btn-primary btn-sm btnEdit mr-1" id="' + full['idtbl_product'] + '"><i class="fas fa-pen"></i></button>';
						}
						if (full['status'] == 1 && statuscheck == 1) {
							button += '<button type="button" data-url="Product/Productstatus/' + full['idtbl_product'] + '/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
						} else if (full['status'] == 2 && statuscheck == 1) {
							button += '<button type="button" data-url="Product/Productstatus/' + full['idtbl_product'] + '/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 btntableaction"><i class="fas fa-times"></i></button>';
						}
						if (deletecheck == 1) {
							button += '<button type="button" data-url="Product/Productstatus/' + full['idtbl_product'] + '/3" data-actiontype="3" class="btn btn-danger btn-sm btntableaction"><i class="fas fa-trash-alt"></i></button>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#productdataTable tbody').on('click', '.btnEdit', async function() {
            var r = await Otherconfirmation("You want to Edit this ? ");
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
						$('#productname').val(obj.prodcutname);
						$('#productcode').val(obj.productcode);
						$('#desc').val(obj.desc);
						$('#weight').val(obj.weight);
						$('#retailprice').val(obj.retailprice);
						$('#retailpriceusd').val(obj.retailpriceusd);
						$('#pktperctn').val(obj.nopckperctn);                                   
						$('#masterctn').val(obj.mastercartoon);                                   

						$('#recordOption').val('2');
						$('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
					}
				});
			}
		});
	});
</script>
<?php include "include/footer.php"; ?>
