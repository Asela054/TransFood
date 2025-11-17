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
                            <div class="page-header-icon"><i class="fas fa-briefcase"></i></div>
                            <span>Production Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#productioncreatemodal" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Production</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
											<th>#</th>
                                            <th>Date</th>
											<th>Production Order No.</th>
                                            <th>Material Name</th>
											<th>Production Start Date</th>
											<th>Production End Date</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal Create -->
<div class="modal fade" id="productioncreatemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="productioncreatemodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title" id="productioncreatemodalLabel">Create Production</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12">
						<form action="Semiproduction/Semiproductioncreate" method="post">
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Date</label>
								<input type="date" class="form-control form-control-sm" name="prodatenew" id="prodatenew" required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Semi Material</label><br>
								<select class="form-control form-control-sm" name="semimaterialnew" id="semimaterialnew" style="width: 100%;" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Qty</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control form-control-sm col-10" name="qtynew" id="qtynew" required>
									<input type="text" id="unitnew" name="unitnew" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="submit" class="btn btn-primary btn-sm small" <?php if($addcheck==0){echo 'disabled';} ?>>Create Production</button>
							</div>
						</form>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal Issue Material -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title" id="staticBackdropLabel">Issue Material Production</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-3">
						<form id="formproduction">
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Production BOM</label><br>
								<select class="form-control form-control-sm" name="semibomlist" id="semibomlist" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Date</label>
								<input type="date" class="form-control form-control-sm" name="prodate" id="prodate" required readonly>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Semi Material</label><br>
								<select class="form-control form-control-sm" name="semimaterial" id="semimaterial" style="width: 100%;" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Qty</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm col-10" name="qty" id="qty" required readonly>
									<input type="text" id="unit" name="unit" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Issue Qty</label>
								<div class="input-group">
									<input type="text" class="form-control form-control-sm col-10" name="issueqty" id="issueqty" required readonly>
									<input type="text" id="issueunit" name="issueunit" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1">
								<hr>
								<label class="small font-weight-bold mb-0">Balance qty option</label><br>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="balqtychoose1" name="balqtychoose" class="custom-control-input" value="0" checked>
									<label class="custom-control-label small font-weight-bold" for="balqtychoose1">Balance Qty</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="balqtychoose2" name="balqtychoose" class="custom-control-input" value="1">
									<label class="custom-control-label small font-weight-bold" for="balqtychoose2">Material Qty</label>
								</div>
							</div>
							<div class="collapse" id="materialoptionchangecollapse">
								<div class="card card-body border-0 p-0 shadow-none">
									<div class="form-group mb-1">
										<label class="small font-weight-bold">BOM Material</label><br>
										<select class="form-control form-control-sm" name="bommateriallist" id="bommateriallist">
											<option value="">Select</option>
										</select>
									</div>
									<div class="form-group mb-1">
										<label class="small font-weight-bold">Issue batch qty</label><br>
										<select class="form-control form-control-sm" name="bomissuemateqty" id="bomissuemateqty">
											<option value="">Select</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group mb-1">
								<hr>
								<label class="small font-weight-bold">Balance Qty</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control form-control-sm col-10" name="balanceqty" id="balanceqty" required>
									<input type="text" id="balanceunit" name="balanceunit" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitcheck" <?php if($addcheck==0){echo 'disabled';} ?>>Check Production</button>
								<input type="submit" id="hidesubmit" class="d-none">
							</div>
							<input type="hidden" name="hideproductionid" id="hideproductionid">
						</form>
                    </div>
					<div class="col-9 border border-right-0 border-top-0 border-bottom-0">
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
						<hr>
						<div class="row">
							<div class="col-12 text-right">
								<button type="button" class="btn btn-danger btn-sm small" id="btnstartproduction" <?php if($addcheck==0){echo 'disabled';} ?> disabled>Create Production</button>
							</div>
							<div class="col-12">
								<hr>
								<div id="alertdiv"></div>
								<div class="alert alert-primary mt-2" role="alert">
									If you need to issue a partial quantity. Please change the balance quantity input field and then press the "Enter" button.
								</div>
							</div>
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal View Detail -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="printporder">
				<div class="row">
					<div class="col-6">
					<h5 class="modal-title text-left" id="exampleModalCenterTitle">Production information of <label id="procode"></label></h5>
					</div>
					<div class="col-2"></div>
					<div class="col">
						<img src="images/unistarimg.jpeg" alt="" class="ml-5" width="80%">
					</div>
				</div>
				<div id="viewproduction"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-sm small" onclick="printContent()"><i class="fas fa-print mr-2"></i>Print Porder</button>
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
							<input type="hidden" name="issuemateqty" id="issuemateqty">
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

	var rowID, bommateoptionlist, wastagepre;

	$('#batchnolist').select2();
	$("#batchnolist").on("select2:select", function (evt) {
		var element = evt.params.data.element;
		var $element = $(element);
		
		$element.detach();
		$(this).append($element);
		$(this).trigger("change");
	});
	$("#semimaterial").select2({
		dropdownParent: $('#staticBackdrop'),
		// placeholder: 'Select supplier',
		ajax: {
			url: "<?php echo base_url() ?>Semiproduction/GetSemimateriallist",
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
	$("#semimaterialnew").select2({
		dropdownParent: $('#productioncreatemodal'),
		// placeholder: 'Select supplier',
		ajax: {
			url: "<?php echo base_url() ?>Semiproduction/GetSemimateriallist",
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

	$("#semimaterial").on('change', function () {
		var unit = $(this).find("option:selected").text().split('/');
		$("#unit").val(unit[1]);
		$("#issueunit").val(unit[1]);
		$("#balanceunit").val(unit[1]);
	});
	$("#semimaterialnew").on('change', function () {
		var unit = $(this).find("option:selected").text().split('/');
		$("#unitnew").val(unit[1]);
	});

	$('input[type=radio][name=balqtychoose]').change(function() {
		if (this.value == '0') {$('#materialoptionchangecollapse').collapse('hide');}
		else if (this.value == '1') {$('#materialoptionchangecollapse').collapse('show');}
	});
	$('#materialoptionchangecollapse').on('shown.bs.collapse', function () {
		$('#bommateriallist').empty().append(bommateoptionlist).prop('required', true);
	});
	$('#materialoptionchangecollapse').on('hidden.bs.collapse', function () {
		$('#bommateriallist').empty().prop('required', false);
		var qty = parseFloat($('#qty').val());
		var issueqty = parseFloat($('#issueqty').val());

		var balanceqty = qty-issueqty;
		$('#balanceqty').val(balanceqty);
		$('#btnsubmitcheck').prop('disabled', false);
		$('#btnsubmitcheck').click();
	});
	$('#bommateriallist').change(function(){
		wastagepre = $(this).find(':selected').data('wastage');
		
		$.ajax({
			type: "POST",
			data: {
				materialID: $(this).val()
			},
			url: '<?php echo base_url() ?>Semiproduction/Getbatchnolistaccomaterial',
			success: function(result) { //alert(result);
				var objfirst = JSON.parse(result);

                var html = '';
				html += '<option value="">Select</option>';
                $.each(objfirst, function(i, item) {
                    //alert(objfirst[i].id);
                    html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
                    html += objfirst[i].batchno+' - '+objfirst[i].qty+objfirst[i].unitcode;
                    html += '</option>';
                });

				$('#bomissuemateqty').empty().append(html);
			}
		}); 
	});
	$('#bomissuemateqty').change(function(){
		var setqty = parseFloat($(this).find(':selected').data('qty')).toFixed(2);
		
		setqty = setqty - (setqty*wastagepre)/100;

		$('#balanceqty').val(parseFloat(setqty).toFixed(2));
		$('#btnsubmitcheck').prop('disabled', false);
		$('#btnsubmitcheck').click();
	});

	$('#semibomlist').change(function(){
		$('#btnsubmitcheck').click();
	});
	$('#btnsubmitcheck').click(function(){
		if (!$("#formproduction")[0].checkValidity()) {
			// If the form is invalid, submit it. The form won't actually submit;
			// this will just cause the browser to display the native HTML5 error messages.
			$("#hidesubmit").click();
		} else {
			var prodate = $('#prodate').val();
			var semibomlist = $('#semibomlist').val();
			var semimaterial = $('#semimaterial').val();
			// var qty = $('#qty').val();
			var qty = $('#balanceqty').val();
			var prodcutionID = $('#hideproductionid').val();
			$('#btnsubmitcheck').prop('disabled', true);

			var balanceqty = $('#balanceqty').val();
			
			$.ajax({
				type: "POST",
				data: {
					prodate: prodate,
					semibomlist: semibomlist,
					semimaterial: semimaterial,
					qty: qty,
					prodcutionID: prodcutionID
				},
				url: '<?php echo base_url() ?>Semiproduction/Getprodcutioninfo',
				success: function(result) { //alert(result);
					// console.log(result);
					var obj = JSON.parse(result);
					$('#tablebody').html(obj.htmlview);
					
					var html = '';
					html += '<option value="">Select</option>';
					var objfirst = obj.materiallist;
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].materialID + '" data-wastage="' + objfirst[i].wastage + '">';
						html += objfirst[i].code;
						html += '</option>';
					});		
					
					bommateoptionlist = html;					

					if(obj.stockstatus==1){
						$('#btnstartproduction').prop('disabled', true);
						$('#alertdiv').html('<div class="alert alert-danger" role="alert">Some Product quantity not enough for you production or your are already issue material for this prodcution. Please check stock and production start again.</div>');
					}
					else{
						if(balanceqty==0){$('#btnstartproduction').prop('disabled', true);}
						else{$('#btnstartproduction').prop('disabled', false);}
					}
				}
			}); 
		}
	});
	$('#tablebomqtyinfo tbody').on('click', 'tr', function () {
		var row = $(this);
		// console.log(row);
        var materialID = row.closest("tr").find('td:eq(1)').text();
        var qty = row.closest("tr").find('td:eq(3)').text();
		$('#issuemateqty').val(qty);
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
                    html += '<option value="' + objfirst[i].batchno + '" data-qty="'+objfirst[i].qty+'">';
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
			var selectedmatetotalqty = 0;
			$('#batchnolist option:selected').each(function () {
				selectedmatetotalqty += parseFloat($(this).data('qty'));
			});

			var issuemateqty = parseFloat($('#issuemateqty').val());
			if(issuemateqty<=selectedmatetotalqty){
				$('#tablebomqtyinfo').find('tr').eq(rowID).find('td:eq(4)').text($('#batchnolist').val());
				$('#batchnolist').empty().trigger('change');
				$('#modalbatchno').modal('hide');
			}
			else{
				Swal.fire({text: "You can't issue this quantity. because you selected material quantity is not enough to start production. Thank you."});
			}
		}
	});
	$('#btnstartproduction').click(function(){
		$('#btnstartproduction').prop('disabled', true);
		var prodate = $('#prodate').val();
		var semibomlist = $('#semibomlist').val();
		var semimaterial = $('#semimaterial').val();
		var qty = $('#qty').val();
		var balanceqty = $('#balanceqty').val();
		var hideproductionid = $('#hideproductionid').val();

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
					prodate: prodate,
					semibomlist: semibomlist,
					semimaterial: semimaterial,
					qty: qty,
					balanceqty: balanceqty,
					productionid: hideproductionid,
					tableData: jsonObj
				},
				url: '<?php echo base_url() ?>Semiproduction/Semiproductioninsertupdate',
				success: function(result) { //alert(result);
					// console.log(result);
					// window.location.reload();
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
	$('#staticBackdrop').on('hidden.bs.modal', function () {
		window.location.reload();
	});

	$('#dataTable').DataTable({
		"destroy": true,
		"processing": true,
		"serverSide": true,
		dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
		responsive: true,
		lengthMenu: [
			[10, 25, 50, -1],
			[10, 25, 50, 'All'],
		],
		"buttons": [{
				extend: 'csv',
				className: 'btn btn-success btn-sm',
				title: 'Brand Information',
				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
			},
			{
				extend: 'pdf',
				className: 'btn btn-danger btn-sm',
				title: 'Brand Information',
				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
			},
			{
				extend: 'print',
				title: 'Brand Information',
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
			url: "<?php echo base_url() ?>scripts/semiprodcutionlist.php",
			type: "POST", // you can use GET
			// data: function(d) {}
		},
		"order": [
			[0, "desc"]
		],
		"columns": [			
			{
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
                    if(companyID==1){return 'UN/POD-'+full['procode'];}
                    else if(companyID==2){return 'UF/POD-'+full['procode'];}
                }
            },
			{
				"data": "materialinfocode"
			},
			{
				"data": "startdatetime"
			},
			{
				"data": "enddatetime"
			},
			{
				"targets": -1,
				"className": 'text-right',
				"data": null,
				"render": function (data, type, full) {
					var button = '';
					button += '<button type="button" class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-eye"></i></button>';

					if(full['approvestatus']==0){
						button+='<button type="button" class="btn btn-primary btn-sm mr-1 issuematerial" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-dolly"></i></button>';
					}

                    if(full['approvestatus']==1 && statuscheck==1){
                        button+='<button type="button" class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
                    }else if(statuscheck==1 && full['partialissue']==1){
						button+='<button type="button" data-url="Semiproduction/Semiproductionapprove/'+full['idtbl_semi_production']+'/1" data-actiontype="4" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                    }

					if(full['approvestatus']==0 && deletecheck==1){
						button+='<button type="button" data-url="Semiproduction/Semiproductionstatus/'+full['idtbl_semi_production']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
					}


					return button;
				}
			}
		],
		drawCallback: function (settings) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});
	
	$('#dataTable tbody').on('click', '.btnview', function () {
		var id = $(this).attr('id');
		var p = $(this).parent().parent();
		var td = p.children("td:nth-child(3)").html();
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Semiproduction/Semiproductiondetails',
			success: function (result) {
				$('#viewproduction').html(result);
				$('#exampleModalCenter').modal('show');
			}
		});
	});

	$('#dataTable tbody').on('click', '.issuematerial', async function() {
		var r = await Otherconfirmation("You want to issue material this production ? ");
        if (r == true) {
			var id = $(this).attr('id');
			$('#hideproductionid').val(id);
			$.ajax({
				type: "POST",
				data: {
					recordID: id
				},
				url: '<?php echo base_url() ?>Semiproduction/Getsemiprodcutioninfo',
				success: function (result) { //alert(result);
					var objmain = JSON.parse(result);
					var obj = JSON.parse(objmain.production);
					$('#prodate').val(obj.prodate);
					$("#semimaterial").empty().append('<option value="'+obj.tbl_material_info_idtbl_material_info+'" selected>'+obj.materialname+' - '+obj.materialinfocode+'/'+obj.unitcode+'</option>').val(obj.tbl_material_info_idtbl_material_info).trigger('change');
					$('#qty').val(obj.qty);
					$('#issueqty').val(obj.issueqty);

					let balanceqty = parseFloat(obj.qty)-parseFloat(obj.issueqty);
					$('#balanceqty').val(balanceqty);
					
					var objfirst = JSON.parse(objmain.productionbominfo);
					var html = '';
					$.each(objfirst, function(i, item) {
						//alert(objfirst[i].id);
						html += '<option value="' + objfirst[i].idtbl_semi_bom_info + '">';
						html += objfirst[i].title;
						html += '</option>';
					});
					
					$('#semibomlist').empty().append(html);

					$('#btnsubmitcheck').click();
					$('#staticBackdrop').modal('show');
				}
			});
		}
	});

	$("#balanceqty").keydown(function(event) {
		if (event.keyCode === 13) {
			$('#btnsubmitcheck').prop('disabled', false);

			let qty = parseFloat($('#qty').val());
			let issueqty = parseFloat($('#issueqty').val());
			let balanceqty = parseFloat($('#balanceqty').val());

			let balqty = qty-issueqty;

			if(balanceqty<=balqty){
				$('#btnsubmitcheck').click();
			}
			else{
				Swal.fire({text: "You can't issue this quantity. because you are already issue some quantity. Please check and enter again. Thank you."});
			}

			return false;  
		}
	});
});

function printContent() {
	printJS({
		printable: 'printporder',
		type: 'html',
		targetStyles: ['*'],
	});
}
</script>
<?php include "include/footer.php"; ?>
