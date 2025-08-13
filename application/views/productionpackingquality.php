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
							<div class="page-header-icon"><i class="fas fa-list"></i></div>
							<span>Production Packing Quality</span>
						</h1>
					</div>
				</div>
			</div>
			<div class="container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="row">
							<div class="col-12">
								<div class="scrollbar pb-3" id="style-2">
									<table class="table table-bordered table-striped table-sm nowrap"
										id="productionorderTable">
										<thead>
											<tr>
												<th>#</th>
                                                <th>Date</th>
                                                <th>Packing Order No.</th>
												<th>Product</th>
												<th>Qty</th>
												<th>Start Date</th>
												<th>End Date</th>
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
<!-- Modal View Detail -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Production information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewproduction"></div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Production Quality -->
<div class="modal fade" id="modalquality" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Production Quality Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <form id="qualityform">
                            <div id="formlayer"></div>
                            <div class="form-row text-right">
                                <div class="col">
                                    <button type="button" class="btn btn-primary btn-sm mt-3" id="btnapplyquality">Apply Quality</button>
                                </div>
                            </div>
                            <input type="hidden" name="hideproductionmaterial" id="hideproductionmaterial">
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="qualityviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Quality Check Info</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="viewdescription"></div>
				<div class="form-row text-right">
					<div class="col mt-3">
						<button type="button" class="btn btn-primary btn-sm mb-3 px-3" id="btnEditinfo"  <?php if($editcheck!=1){ echo 'disabled';} ?>><i
								class="fas fa-edit"></i>&nbsp;EDIT INFO</button>
						<input type="hidden" name="hideproductionmaterial2" id="hideproductionmaterial2">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="qualityinfoeditmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Edit Quality Info</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="editqualityform">
					<div id="editformlayer"></div>
					<div class="form-row text-right">
						<div class="col mt-3">
							<button type="button" class="btn btn-primary btn-sm" id="btnsavequality"><i
								class="fas fa-save"></i>&nbsp; SAVE
								QUALITY</button>
						</div>
					</div>
                    <input type="hidden" name="editedproductionid" id="editedproductionid">
				</form>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>

$(document).on("click", ".btnViewqualityinfo", function () {
	var id = $(this).attr('id');
	$('#hideproductionmaterial2').val(id);
	// alert(id);
	$.ajax({
		type: "POST",
		data: {
			recordID: id
		},
		url: '<?php echo base_url() ?>Productionpackingquality/Getqualityviewdescription',
		success: function (result) { //alert(result);
			$('#viewdescription').html(result);
			$('#exampleModalCenter').modal('hide');
			$('#qualityviewmodal').modal('show');
			

		}
	});
});

$(document).ready(function () {
	var addcheck = '<?php echo $addcheck; ?>';
	var editcheck = '<?php echo $editcheck; ?>';
	var statuscheck = '<?php echo $statuscheck; ?>';
	var deletecheck = '<?php echo $deletecheck; ?>';
	var companyID = '<?php echo $_SESSION['companyid'] ?>';

	$('#productionorderTable').DataTable({
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
				title: 'Production View Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Production View Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Production View Information',
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
			url: "<?php echo base_url() ?>scripts/productionpackinglist.php",
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
				"data": "prodate"
			},
            {
				"targets": -1,
				"className": '',
				"data": null,
				"render": function (data, type, full) {
                    if(companyID==1){return 'UN/PID-'+full['procode'];}
                    else if(companyID==2){return 'UF/PID-'+full['procode'];}
                }
            },
			{
				"data": "productcode"
			},
			{
				"data": "qty"
			},
			{
				"data": "prostartdate"
			},
			{
				"data": "proenddate"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';
                    button+='<button class="btn btn-primary btn-sm btncheck mr-1" id="'+full['idtbl_production_order']+'"><i class="fas fa-tasks"></i></button>';
					button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_production_order'] + '"><i class="fas fa-eye"></i></button>';

					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

    $('#productionorderTable tbody').on('click', '.btnview', function () {
		var id = $(this).attr('id');
		var p = $(this).parent().parent();
		var td = p.children("td:nth-child(3)").html();
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Productionpackingquality/Semiproductiondetails',
			success: function (result) { //alert(result);
				$('#viewproduction').html(result);
				$('#exampleModalCenter').modal('show');
			}
		});
	});

	$('#productionorderTable tbody').on('click', '.btncheck', function () {
		var id = $(this).attr('id');
		$('#hideproductionmaterial').val(id);

		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Productionpackingquality/Productionpackqualityform',
			success: function (result) { //alert(result);
				$('#formlayer').html(result);
				$('#modalquality').modal('show');
			}
		});
	});

	$(document).on('click', '#btnEditinfo', function () {
		var productionid = $('#hideproductionmaterial2').val();
		$('#editedproductionid').val(productionid);
		//alert(grnid);

		$.ajax({
			type: "POST",
			data: {
				recordID: productionid
			},
			url: '<?php echo base_url() ?>Productionpackingquality/Editproductionqualityinfo',
			success: function (result) { //alert(result);
				$('#editformlayer').html(result);
				$('#qualityinfoeditmodal').modal('show');
				$('#qualityviewmodal').modal('hide');
			}
		});
	});

	$('#btnsavequality').click(function(){
		var formData = new FormData($('#editqualityform')[0]);
		// var grnid = $('#hideproductionmaterial').val();

		$.ajax({
			url: '<?php echo base_url() ?>Productionpackingquality/Newproductioninqualitysertupdate',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {//alert(response);
				// console.log(response);
				var obj = JSON.parse(response);
				// if(obj.status==1){
				// 	$('#qualityinfoeditmodal').modal('hide');
				// 	setTimeout(window.location.reload(), 3000);
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
	});

	$('#btnapplyquality').click(function(){
		var formData = new FormData($('#qualityform')[0]);

		$.ajax({
			url: '<?php echo base_url() ?>Productionpackingquality/Productionpackqualityinsertupdate',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,

			success: function(response) {//alert(response);
				var obj = JSON.parse(response);
				// if(obj.status==1){
				// 	$('#modalquality').modal('hide');
				// 	setTimeout(window.location.reload(), 3000);
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
	});

});
</script>
<?php include "include/footer.php"; ?>
