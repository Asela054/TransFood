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
							<span>Production Packing</span>
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
<!-- Modal Daily Complete -->
<div class="modal fade" id="dailycompletemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="dailycompletemodaldropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompletemodaldropLabel">Daily Complete Information</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <form action="<?php echo base_url() ?>Productionpacking/Productionpackingcomplete" id="formdailycomlete" method="post">
                            <div id="alertmsg"></div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Date*</label>
                                <input type="date" class="form-control form-control-sm" name="comdate" id="comdate" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Manufature Date*</label>
                                <input type="date" class="form-control form-control-sm" name="commfdate" id="commfdate" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Expire Date*</label>
                                <input type="date" class="form-control form-control-sm" name="comexpdate" id="comexpdate" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Complete Qty*</label>
                                <input type="text" class="form-control form-control-sm" name="comqty" id="comqty" required>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Damage Qty</label>
                                <input type="text" class="form-control form-control-sm" name="damageqty" id="damageqty">
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" class="btn btn-primary btn-sm" id="btncomsubmit">Complete Qty</button>
                            </div>
                            <input type="hidden" name="hideproorderdetailid" id="hideproorderdetailid" value="">
                        </form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Daily Complete Approve -->
<div class="modal fade" id="dailycompleteviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="dailycompleteviewmodaldropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title" id="dailycompleteviewmodaldropLabel">Daily Complete Approve</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-striped table-bordered table-sm" id="tabledailyapprove">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Batch No</th>
                                    <th>Date</th>
                                    <th>MF Date</th>
                                    <th>EXP Date</th>
                                    <th>Qty</th>
                                    <th>Damage Qty</th>
                                    <th>Approve</th>
                                    <th>Approve Person</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <input type="hidden" name="hideviewproorderdetailid" id="hideviewproorderdetailid" value="">
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
					button += '<button class="btn btn-primary btn-sm btndailycomplete mr-1" id="' + full['idtbl_production_orderdetail'] + '"><i class="far fa-calendar-check"></i></button>';
					button += '<button class="btn btn-orange btn-sm btndailycompleteview mr-1" id="' + full['idtbl_production_orderdetail'] + '"><i class="fas fa-list"></i></button>';

					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
    $('#productionorderTable tbody').on('click', '.btndailycomplete', function () {
        var id = $(this).attr('id');
        $('#hideproorderdetailid').val(id);
        $('#dailycompletemodal').modal('show');
    });
    $('#btncomsubmit').click(function(){
        let id = $('#hideproorderdetailid').val();
        let comqty = $('#comqty').val();
        let damageqty = $('#damageqty').val();
        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                comqty: comqty,
                damageqty: damageqty
            },
            url: '<?php echo base_url() ?>Productionpacking/Checkproductorderqty',
            success: function (result) { //alert(result);
                // console.log(result);
                if(result==1){
                    $('#formdailycomlete').submit();
                }
                else{
                    $('#alertmsg').html('<div class="alert alert-danger" role="alert">You entered a total qty that exceeded the total production qty. Please check and enter again.</div>');
                }
            }
        });
    });
    $('#dailycompletemodal').on('hidden.bs.modal', function () {
		window.location.reload();
	});
    $('#productionorderTable tbody').on('click', '.btndailycompleteview', function () {
        var id = $(this).attr('id');
        $('#hideviewproorderdetailid').val(id);
        dailycompleteapprovelist(id);
    });
    $('#tabledailyapprove tbody').on('click', '.btndailycompleteapprove', async function() {
        var r = await Otherconfirmation("You want to approve this record ? ");
        if (r == true) {
            var id = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Productionpacking/Approvedailycomplete',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        var prodetailID = $('#hideviewproorderdetailid').val();
                        dailycompleteapprovelist(prodetailID);
                    }
                    action(obj.action);
                }
            });
        }
    });
});

function dailycompleteapprovelist(id){
    $.ajax({
        type: "POST",
        data: {
            recordID: id
        },
        url: '<?php echo base_url() ?>Productionpacking/Viewdailycompleteinfo',
        success: function (result) { //alert(result);
            // console.log(result);
            $('#tabledailyapprove > tbody').empty().html(result);
            $('#dailycompleteviewmodal').modal('show');
        }
    });
}
</script>
<?php include "include/footer.php"; ?>
