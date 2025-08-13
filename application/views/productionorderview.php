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
							<span>Packing Order</span>
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
<!-- Modal Prodcution Material Issue -->
<div class="modal fade" id="materialissuemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="materialissuemodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="materialissuemodalLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <form id="formissuematerial">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Finish Good*</label>
                                    <select class="form-control form-control-sm" name="orderfinishgood" id="orderfinishgood" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-1">
								<label class="small font-weight-bold">FG Production BOM</label><br>
								<select class="form-control form-control-sm" name="productbomlist" id="productbomlist" required>
									<option value="">Select</option>
								</select>
							</div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Qty*</label>
                                    <input type="text" name="orderqty" id="orderqty" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Issue Qty*</label>
                                    <input type="text" name="issueqty" id="issueqty" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Balance Qty*</label>
                                    <input type="text" name="balanceqty" id="balanceqty" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col text-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnissuematerial">Check Production</button>
                                    <input type="submit" id="hideisuematerialsubmit" class="d-none">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                        <table class="table table-striped table-bordered table-sm small" id="tablebomqtyinfo">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="d-none">MaterialID</th>
                                    <th>Material</th>
                                    <th>Qty</th>
                                    <th>Batch No</th>
                                </tr>
                            </thead>
                            <tbody id="tablebody"></tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" id="btnstartproduction"><i class="far fa-play-circle mr-2"></i>Issue Materials</button>
                            </div>
                            <div class="col-12">
                                <hr>
                                <div id="alertdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="hideprodcutionorder" id="hideprodcutionorder">
			</div>
		</div>
	</div>
</div>
<!-- Modal Production Material -->
<div class="modal fade" id="modalproductionmaterial" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
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
                        <table class="table table-striped table-bordered table-sm small" id="tablestockinfo">
                            <thead>
                                <tr>
                                    <th>Batch No</th>
                                    <th>Available Qty</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <hr>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary btn-sm" id="btnaddmaterialinfo">Issue Qty</button>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Batch No List -->
<div class="modal fade" id="modalbatchno" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Material Issue Batch No</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="formbatchno">
							<div class="form-group">
								<label class="small font-weight-bold">Stock Batch No</label><br>
								<select class="form-control form-control-sm" name="batchnolist[]" id="batchnolist" style="width: 100%;" multiple required>
								</select>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitbatch" <?php if($addcheck==0){echo 'disabled';} ?>>Done</button>
								<input type="submit" id="hidesubmitbatch" class="d-none">
							</div>
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
    var companyID = '<?php echo $_SESSION['companyid'] ?>';

	// setdatalayout();
    $('#batchnolist').select2();
    $("#batchnolist").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

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
			url: "<?php echo base_url() ?>scripts/productionorderlist.php",
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
					button += '<button class="btn btn-primary btn-sm btnIssueMaterial mr-1" id="' + full['idtbl_production_orderdetail'] + '"><i class="fas fa-pallet"></i></button>';
					button += '<a href="<?php echo base_url() ?>Productionorderview/printreport/' + full['idtbl_production_order'] + '" target="_blank" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-print"></i></a>';
                    if(deletecheck==1){
                        button+='<button type="button" data-url="Productionorderview/Productionorderstatus/'+full['idtbl_production_orderdetail']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
                    }
					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$("#startdate").change(function (event) {
		event.preventDefault();
		var machineid = $('#machine').val();
		var startdate = $('#startdate').val();
		var enddate = $('#enddate').val();
		$.ajax({
			type: "POST",
			data: {
				machineid: machineid,
				startdate: startdate,
				enddate: enddate,
			},
			url: '<?php echo base_url() ?>Productionorderview/Checkmachineavailability',
			success: function (result) { //alert(result);
				var obj = JSON.parse(result);
				var html = '';

				if (obj.actiontype == 1) {
					html += '<div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Sorry!</strong> Machine is Not Available.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
					$('#alert').html(html);
				}

			}
		});
	});

	//Material issue start
    $('#productionorderTable tbody').on('click', '.btnIssueMaterial', function () {
        var id = $(this).attr('id');
        $('#hideprodcutionorder').val(id);
        $('#materialissuemodal').modal('show');
        loadfglist();
    });
    $('#orderfinishgood').change(function () {
        var id = $(this).val();
        var productionid = $('#hideprodcutionorder').val();

        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                productionid: productionid
            },
            url: '<?php echo base_url() ?>Productionorderview/Getqtyinfoaccoproductiondetail',
            success: function (result) { //alert(result);
                var obj = JSON.parse(result);

                $.each(obj, function (i, item) {
                    $('#orderqty').val(obj[i].qty);
                    $('#issueqty').val(obj[i].issueqty);
                    
                    let balanceqty = parseFloat(obj[i].qty)-parseFloat(obj[i].issueqty);
                    $('#balanceqty').val(balanceqty);                    
                });
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID: id,
                productionID: productionid
            },
            url: '<?php echo base_url() ?>Productionorderview/Productionbomlistaccofg',
            success: function (result) { //alert(result);
                var obj = JSON.parse(result);
                var html = '';
                html += '<option value="">Select</option>';
                $.each(obj, function (i, item) {
                    html += '<option value="' + obj[i].idtbl_product_bom_info + '">';
                    html += obj[i].title;
                    html += '</option>';
                });
                $('#productbomlist').empty().append(html);
            }
        });
    });
    $('#btnissuematerial').click(function(){
        if (!$("#formissuematerial")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hideisuematerialsubmit").click();
        } else {
            var orderfinishgood = $('#orderfinishgood').val();
            var productbomlist = $('#productbomlist').val();
            // var orderqty = $('#orderqty').val();
            var orderqty = $('#balanceqty').val();
            var productionid = $('#hideprodcutionorder').val();
            $('#btnissuematerial').prop('disabled', true);

            $.ajax({
                type: "POST",
                data: {
                    productionid: productionid,
                    orderfinishgood: orderfinishgood,
                    productbomlist: productbomlist,
                    orderqty: orderqty
                },
                url: '<?php echo base_url() ?>Productionorderview/Getprodcutioninfo',
                success: function(result) { //alert(result);
					// console.log(result);
                    var obj = JSON.parse(result);
                    $('#tablebody').html(obj.htmlview);
                    if(obj.stockstatus==1){
                        $('#btnstartproduction').prop('disabled', true);
                        $('#alertdiv').html('<div class="alert alert-danger" role="alert">Some Product quantity not enough for you production. Please check stock and production start again.</div>');
                        $('#btnissuematerial').prop('disabled', false);
                    }
                    else{
                        $('#btnstartproduction').prop('disabled', false);
                    }
                }
            }); 
        }
    });
    $('#tablebomqtyinfo tbody').on('click', 'tr', function () {
        var row = $(this);
        console.log(row);
        var materialID = row.closest("tr").find('td:eq(1)').text();
        rowID = row.closest("tr")[0].rowIndex;
        
        $.ajax({
            type: "POST",
            data: {
                materialID: materialID
            },
            url: '<?php echo base_url() ?>Semiproduction/Getbatchnolistaccomaterial',
            success: function(result) { //alert(result);
                var objfirst = JSON.parse(result);

                var html = '';
                $.each(objfirst, function(i, item) {
                    //alert(objfirst[i].id);
                    html += '<option value="' + objfirst[i].batchno + '">';
                    html += objfirst[i].batchno+' - '+objfirst[i].qty+objfirst[i].unitcode;
                    html += '</option>';
                });

                $('#batchnolist').empty().append(html);
                $('#batchnolist').trigger('change');
                $('#modalbatchno').modal('show');
            }
        }); 
    });
    $('#btnsubmitbatch').click(function(){
        if (!$("#formbatchno")[0].checkValidity()) {
            // If the form is invalid, submit it. The form won't actually submit;
            // this will just cause the browser to display the native HTML5 error messages.
            $("#hidesubmitbatch").click();
        } else {
            $('#tablebomqtyinfo').find('tr').eq(rowID).find('td:eq(4)').text($('#batchnolist').val());
            $('#batchnolist').empty().trigger('change');
            $('#modalbatchno').modal('hide');
        }
    });
    $('#btnstartproduction').click(function(){
        $('#btnstartproduction').prop('disabled', true);
        var productionorderid = $('#hideprodcutionorder').val();
        var orderfinishgood = $('#orderfinishgood').val();
        var orderqty = $('#orderqty').val();
        var balanceqty = $('#balanceqty').val();

        var emptybatch = 0;
        var tbody = $('#tablebomqtyinfo tbody');
        if (tbody.children().length > 0) {
            var jsonObj = []
            $("#tablebomqtyinfo tbody tr").each(function () {
                item = {}
                $(this).find('td').each(function (col_idx) {
                    if($(this).text()==''){
                        emptybatch=1;
                    }
                    item["col_" + (col_idx + 1)] = $(this).text();
                });
                jsonObj.push(item);
            });
        }
        // console.log(jsonObj);
        if(emptybatch==1){
            $('#alertdiv').html('<div class="alert alert-danger" role="alert">Please select material stock batch no for issue materials.</div>');
        }
        else{
            $.ajax({
                type: "POST",
                data: {
                    productionorderid: productionorderid,
                    orderfinishgood: orderfinishgood,
                    orderqty: orderqty,
                    balanceqty: balanceqty,
                    tableData: jsonObj
                },
                url: '<?php echo base_url() ?>Productionorderview/Issuematerialforproduction',
                success: function(result) { //alert(result);
                    // console.log(result);
                    var objfirst = JSON.parse(result);
                    if(objfirst.status==1){
                        actionreload(objfirst.action);  
                    }
                    else{
                        action(objfirst.action);
                    }
                }
            }); 
        }
    });
	$('#materialissuemodal').on('hidden.bs.modal', function () {
		window.location.reload();
	});

    $("#balanceqty").keydown(function(event) {
		if (event.keyCode === 13) {
			$('#btnissuematerial').prop('disabled', false);

			let qty = parseFloat($('#orderqty').val());
			let issueqty = parseFloat($('#issueqty').val());
			let balanceqty = parseFloat($('#balanceqty').val());

			let balqty = qty-issueqty;

			if(balanceqty<=balqty){
				$('#btnissuematerial').click();
			}
			else{
				Swal.fire({text: "You can't issue this quantity. because you are already issue some quantity. Please check and enter again. Thank you."});
			}

			return false;  
		}
	});
    //Material issue end
});
function loadfglist(){
    let id = $('#hideprodcutionorder').val();
    $.ajax({
        type: "POST",
        data: {
            recordID: id
        },
        url: '<?php echo base_url() ?>Productionorderview/Productiondetailaccoproduction',
        success: function (result) { //alert(result);
            var obj = JSON.parse(result);
            var html1 = '';
            html1 += '<option value="">Select</option>';
            $.each(obj, function (i, item) {
                html1 += '<option value="' + obj[i].idtbl_product + '">';
                html1 += obj[i].materialname + ' - ' + obj[i].productcode;
                html1 += '</option>';
            });
            $('#orderfinishgood').empty().append(html1);
        }
    });
}
</script>
<?php include "include/footer.php"; ?>
