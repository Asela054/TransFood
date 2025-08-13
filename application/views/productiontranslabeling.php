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
							<span>Production Transfer To Labelling</span>
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
												<th>Product</th>
												<th>Material Name | Code</th>
												<th>Production Qty</th>
												<th>Production Date</th>
												<th>Start Date</th>
												<th>End Date</th>
												<th>Status</th>
												<!-- <th>Unit Price</th>
												<th>Total</th> -->
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
<!-- Modal Production Material -->
<div class="modal fade" id="modaltraspacking" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <form action="<?php echo base_url() ?>Productiontranslabeling/Transfertofgstock" method="post">
							<div class="form-row mb-2">
								<div class="col">
									<label class="small font-weight-bold text-dark">Complete Qty</label>
                                    <input type="text" id="completeqty" name="completeqty" class="form-control form-control-sm" value="" readonly>
								</div>
							</div>
							<div class="form-row mb-2">
								<div class="col">
									<label class="small font-weight-bold text-dark">Labelling Qty</label>
                                    <input type="text" id="labelqty" name="labelqty" class="form-control form-control-sm" value="0">
								</div>
							</div>
							<div class="form-row mt-3">
								<div class="col text-right">
									<button	type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Transfer to FG Stock</button>
								</div>
							</div>
							<input type="hidden" name="hidepromaterialid" id="hidepromaterialid">
						</form>
                    </div>
                </div>
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
				<h5 class="modal-title" id="staticBackdropLabel">Labelling Quality Information</h5>
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
                                    <button type="button" class="btn btn-primary btn-sm" id="btnapplyquality">Apply Quality</button>
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
<?php include "include/footerscripts.php"; ?>
<script>
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';

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
				url: "<?php echo base_url() ?>scripts/productiontranslabelinglist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [{
					"data": "idtbl_production_material"
				},
				{
					"data": "productcode"
				},
				{
					"targets": -1,
					"className": '',
					"data": null,
					"render": function (data, type, full) {
						return full['materialname']+' - '+full['materialinfocode'];
					}
				},
				{
					"data": "qty"
				},
				{
					"data": "prodate"
				},
				{
					"data": "prostartdate"
				},
				{
					"data": "proenddate"
				},
				// {
				// 	"data": "unitprice"
				// },
				// {
				// 	"data": "total"
				// },
				{
					"targets": -1,
					"className": 'text-center',
					"data": null,
					"render": function (data, type, full) {
						if(full['passfail']==0){return '<span class="text-primary">Processing</span>';}
						else if(full['passfail']==1){return '<span class="text-success">Pass</span>';}
						else if(full['passfail']==2){return '<span class="text-danger">Fail</span>';}
					}
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						if(full['passfail']<2){
							if(full['qualitycheck']==null){
								button += '<button class="btn btn-dark btn-sm btnqualitycheck mr-1" data-toggle="tooltip" data-placement="top" title="Quality Checking" id="' + full[ 'idtbl_production_material'] + '"><i class="fas fa-tasks"></i></button>';
							}
							if(full['passfail']<2){
								button += '<button class="btn btn-primary btn-sm btntranslabeling mr-1" data-toggle="tooltip" data-placement="top" title="Transfer to labeling" id="' + full[ 'idtbl_production_material'] + '"><i class="fas fa-luggage-cart"></i></button>';
							}
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});
		$('#productionorderTable tbody').on('click', '.btnqualitycheck', function(){
            var id = $(this).attr('id');
            $('#hideproductionmaterial').val(id);

            $.ajax({
                type: "POST",
                data: {},
                url: '<?php echo base_url() ?>Productiontranslabeling/Productionpackqualityform',
                success: function(result) { //alert(result);
                    $('#formlayer').html(result);
                    $('#modalquality').modal('show');
                }
            });            
        });
		$('#btnapplyquality').click(function(){
            var formData = new FormData($('#qualityform')[0]);

            $.ajax({
                url: '<?php echo base_url() ?>Productiontranslabeling/Productionpackqualityinsertupdate',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function(response) {//alert(response);
                    var obj = JSON.parse(response);
                    if(obj.status==1){
                        $('#modalquality').modal('hide');
                        setTimeout(window.location.reload(), 3000);
                    }
                    action(obj.action);
                }
            });
        });

		$('#productionorderTable tbody').on('click', '.btntranslabeling', function () {
			var id = $(this).attr('id');
            $('#hidepromaterialid').val(id);
			$('#modaltraspacking').modal('show');
			var row = $(this);
            rowinfo = row;
            var totalqty = row.closest("tr").find('td:eq(3)').text();
			$('#completeqty').val(totalqty);
		});
		$("#packqty").keyup(function(){
			var parseqty = parseFloat($(this).val());
			var semiqty = parseFloat($('#semiqty').val());
			var completeqty = parseFloat($('#completeqty').val());

			var totqty = parseFloat(parseqty+semiqty);

			if(completeqty<totqty){
				$("#packqty").addClass('text-white bg-danger');
				$("#semiqty").addClass('text-white bg-danger');
			}
			else{
				$("#packqty").removeClass('text-white bg-danger');
				$("#semiqty").removeClass('text-white bg-danger');
			}
		});
	});

    function action(data) { //alert(data);
        var obj = JSON.parse(data);
        $.notify({
            // options
            icon: obj.icon,
            title: obj.title,
            message: obj.message,
            url: obj.url,
            target: obj.target
        }, {
            // settings
            element: 'body',
            position: null,
            type: obj.type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "center"
            },
            offset: 100,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            timer: 1000,
            url_target: '_blank',
            mouse_over: null,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    }
</script>
<?php include "include/footer.php"; ?>
