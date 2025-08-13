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
                            <span>Production Process</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
											<th>Production Order No.</th>
                                            <th>Material</th>
											<th>Order Qty</th>
											<th>Complete Qty</th>
											<th>Damaged Qty</th>
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
<!-- Modal -->
<div class="modal fade" id="machineallocatemodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Machine Allocation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alert"></div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <form action="" autocomplete="off">
                            <div class="form-row mb-1">
                            <input type="hidden" class="form-control form-control-sm" name="productionorderid" id="productionorderid" required>
                                <label class="small font-weight-bold text-dark">Machine*</label><br>
                                <select class="form-control form-control-sm" style="width: 100%;"
                                    name="machine" id="machine" required>
                                    <option value="">Select</option>
                                    <?php foreach($machine->result() as $rowmachine){ ?>
                                    <option value="<?php echo $rowmachine->idtbl_machine ?>">
                                        <?php echo $rowmachine->machine.' - '.$rowmachine->machinecode ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-row mb-1">
							     <div class="col">
                                     <label class="small font-weight-bold">Start Date*</label>
                                        <input type="date" class="form-control form-control-sm" placeholder=""
                                         name="startdate" id="startdate" required>
							     </div>
								 <div class="col">
                                     <label class="small font-weight-bold">Start Time*</label>
                                        <input type="time" class="form-control form-control-sm" placeholder=""
                                         name="starttime" id="starttime" required>
							     </div>
                            </div>
                            <div class="form-row mb-1">
							     <div class="col">
                                     <label class="small font-weight-bold">End Date*</label>
                                        <input type="date" class="form-control form-control-sm" placeholder=""
                                         name="enddate" id="enddate" required>
								 </div>
								 <div class="col">
                                     <label class="small font-weight-bold">End Time*</label>
                                        <input type="time" class="form-control form-control-sm" placeholder=""
                                         name="endtime" id="endtime" required>
							     </div>
                            </div>
                            <div class="form-group mt-3 px-2 text-right">
										<button type="button" name="BtnAddmachine" id="BtnAddmachine"
											class="btn btn-primary btn-m  fa-pull-right"><i
												class="fas fa-plus"></i>&nbsp;Add</button>
									</div>
                        </form>
                    </div>
                    <div class="col-8">
						<div class="row mt-4">
							<div class="col-12 col-md-12">
								<div class="table" id="style-2">
									<table class="table table-bordered table-striped  nowrap display" id="tblmachinelist">
										<thead>
                                            <th class="d-none">Costing ID</th>
											<th>Machine</th>
											<th>Start Date</th>
											<th>Start Time</th>
											<th>End Date</th>
											<th>End Time</th>
										</thead>
										<tbody id="tblmachinebody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group mt-3 text-right">
                                <button type="submit" id="submitBtn2"
                                    class="btn btn-outline-primary btn-sm fa-pull-right"
                                    <?php if($addcheck==0){echo 'disabled';} ?>><i
                                        class="far fa-save"></i>&nbsp;Allocate Machine</button>
                            </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title" id="staticBackdropLabel">Create Production</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-3">
						<form id="formproduction">
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Date</label>
								<input type="date" class="form-control form-control-sm" name="prodate" id="prodate" required>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Semi Material</label><br>
								<select class="form-control form-control-sm" name="semimaterial" id="semimaterial" style="width: 100%;" required>
									<option value="">Select</option>
								</select>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold">Qty</label>
								<div class="input-group mb-3">
									<input type="text" class="form-control form-control-sm col-10" name="qty" id="qty" required>
									<input type="text" id="unit" name="unit" class="form-control form-control-sm col-2" readonly>
								</div>
							</div>
							<div class="form-group mb-1 text-right">
								<button type="button" class="btn btn-primary btn-sm small" id="btnsubmitcheck" <?php if($addcheck==0){echo 'disabled';} ?>>Check Production</button>
								<input type="submit" id="hidesubmit" class="d-none">
							</div>
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
								<button type="button" class="btn btn-danger btn-sm small" id="btnstartproduction" <?php if($addcheck==0){echo 'disabled';} ?> disabled>Start Production</button>
							</div>
							<div class="col-12">
								<hr>
								<div id="alertdiv"></div>
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
				<h5 class="modal-title" id="exampleModalCenterTitle">Production information of <label id="procode"></label> </h5>
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
<!-- Modal View Detail -->
<div class="modal fade" id="modalotherexpences" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Prodcution Other Cost Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<!-- <div class="col-7">
						<form id="formothercost">
							<div class="form-row">
								<div class="col">
									<label class="small font-weight-bold">Cost Type</label>
									<select class="form-control form-control-sm" name="costtype" id="costtype" style="width: 100%;" required>
										<option value="">Select</option>
									</select>
								</div>
								<div class="col">
									<label class="small font-weight-bold">Amount</label>
									<input type="text" class="form-control form-control-sm" name="amount" id="amount" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold">Cost Per Unit Or All Qty</label>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="perunithall1" name="perunithall" class="custom-control-input" value="1" required>
										<label class="custom-control-label small" for="perunithall1">Per Unit</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="perunithall2" name="perunithall" class="custom-control-input" value="0">
										<label class="custom-control-label small" for="perunithall2">All Qty</label>
									</div>
								</div>
							</div>
							<div class="form-group text-right">
								<hr>
								<button type="button" class="btn btn-primary btn-sm small px-3" id="btnsubmitohter" <?php if($addcheck==0){echo 'disabled';} ?>>Add to list</button>
								<input type="submit" id="hidesubmitother" class="d-none">
								<input type="reset" id="hideresetother" class="d-none">
							</div>
						</form>
						<table class="table table-striped table-bordered table-sm small" id="tablecostlist">
							<thead>
								<tr>
									<th>Cost Type</th>
									<th>CostID</th>
									<th>Perunit</th>
									<th class="text-right">Amount</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<hr>
						<div class="text-right">
							<button type="button" class="btn btn-danger btn-sm small px-3" id="btnsaveallohter" <?php if($addcheck==0){echo 'disabled';} ?>>Save All</button>
						</div>
						<input type="hidden" id="hidesemiproductionorder">
					</div> -->
					<div class="col">
						<div id="viewcostlist"></div>
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
                        <form action="<?php echo base_url() ?>Semiproduction/Semiproductiondailycomplete" id="formdailycomlete" method="post">
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
                            <input type="hidden" name="hidesemiproductionid" id="hidesemiproductionid" value="">
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
	$("#tblmachinelist").on('click', '.btnDeleterow', async function() {
		var r = await Otherconfirmation("You want to remove this ? ");
		if(r==true){
			$(this).closest('tr').remove();
		}
	});

	$(document).on("click", "#BtnAddmachine", function () {
		var machine = $('#machine').val();
		var machinelist = $("#machine option:selected").text();
		var startdate = $('#startdate').val();
		var starttime = $('#starttime').val();
		var enddate = $('#enddate').val();
		var endtime = $('#endtime').val();

		$('#tblmachinelist> tbody:last').append('<tr><td class="text-center">' +
			machinelist + '</td><td class="d-none text-center">' + machine +
			'</td><td class="text-center">' + startdate + '</td><td class="text-center">' + starttime + '</td><td class="text-center">' + enddate + '</td><td class="text-center">' + endtime +
			'</td><td> <button type="button" class="btnDeleterow btn btn-danger btn-sm float-right"><i class="fas fa-trash-alt"></i></button></td></tr>');

		$('#machine').val('');
		$('#startdate').val('');
		$('#starttime').val('');
		$('#enddate').val('');
		$('#endtime').val('');
	});

	$(document).on("click", "#submitBtn2", function () {

		var productionorderId = $('#productionorderid').val();

		// get table data into array
		var tbody = $('#tblmachinelist tbody');
		if (tbody.children().length > 0) {
			var jsonObj = []
			$("#tblmachinelist tbody tr").each(function () {
				item = {}
				$(this).find('td').each(function (col_idx) {
					item["col_" + (col_idx + 1)] = $(this).text();
				});
				jsonObj.push(item);
			});
		}
		//console.log(jsonObj);

		$.ajax({
			type: "POST",
			data: {
				tableData: jsonObj,
				productionorderId: productionorderId
			},
			url: '<?php echo base_url() ?>Semiproduction/Machineinsertupdate',
			success: function (result) {
				//console.log(result);
				location.reload();
			}
		});


	});
	$(document).ready(function () {
		var addcheck = '<?php echo $addcheck; ?>';
		var editcheck = '<?php echo $editcheck; ?>';
		var statuscheck = '<?php echo $statuscheck; ?>';
		var deletecheck = '<?php echo $deletecheck; ?>';
		var companyID = '<?php echo $_SESSION['companyid'] ?>';

		var rowID;

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

		$("#semimaterial").on('change', function () {
			var unit = $(this).find("option:selected").text().split('/');
			$("#unit").val(unit[1]);
		});

		$('#btnsubmitcheck').click(function(){
			if (!$("#formproduction")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidesubmit").click();
			} else {
				var prodate = $('#prodate').val();
				var semimaterial = $('#semimaterial').val();
				var qty = $('#qty').val();
				$('#btnsubmitcheck').prop('disabled', true);

				$.ajax({
					type: "POST",
					data: {
						prodate: prodate,
						semimaterial: semimaterial,
						qty: qty
					},
					url: '<?php echo base_url() ?>Semiproduction/Getprodcutioninfo',
					success: function(result) { //alert(result);
						var obj = JSON.parse(result);
						$('#tablebody').html(obj.htmlview);
						if(obj.stockstatus==1){
							$('#btnstartproduction').prop('disabled', true);
							$('#alertdiv').html('<div class="alert alert-danger" role="alert">Some Product quantity not enough for you production. Please check stock and production start again.</div>');
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
			// console.log(row);
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
			var prodate = $('#prodate').val();
			var semimaterial = $('#semimaterial').val();
			var qty = $('#qty').val();

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
						semimaterial: semimaterial,
						qty: qty,
						tableData: jsonObj
					},
					url: '<?php echo base_url() ?>Semiproduction/Semiproductioninsertupdate',
					success: function(result) { //alert(result);
						// console.log(result);
						window.location.reload();
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
			],
			ajax: {
				url: "<?php echo base_url() ?>scripts/semiprodcutionprocesslist.php",
				type: "POST", // you can use GET
				// data: function(d) {}
			},
			"order": [
				[0, "desc"]
			],
			"columns": [
				{
					"data": null,
					"render": function (data, type, full, meta) {
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
					"data": "qty_semi_production", // Use the alias qty_daily_complete
				},
				{
					"data": "qty_daily_complete", // Use the alias qty_daily_complete
				},
				{
					"data": "damageqty"
				},
				{
					"targets": -1,
					"className": 'text-right',
					"data": null,
					"render": function (data, type, full) {
						var button = '';
						button += '<button class="btn btn-secondary btn-sm btnAdd mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-tools"></i></button>';
						button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-eye"></i></button>';
						button += '<a href="<?php echo base_url() ?>Semiproduction/printreport/' + full['idtbl_semi_production'] + '" target="_blank" class="btn btn-info btn-sm mr-1"><i class="fas fa-print"></i></a>';
						if (full['grnstatus'] == 0) {
							button += '<button class="btn btn-warning btn-sm btnothercost mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-list"></i></button>';
							button += '<button class="btn btn-primary btn-sm btndailycomplete mr-1" id="' + full['idtbl_semi_production'] + '"><i class="far fa-calendar-check"></i></button>';
						}
						button += '<button class="btn btn-orange btn-sm btndailycompleteview mr-1" id="' + full['idtbl_semi_production'] + '"><i class="fas fa-list"></i></button>';

						if (full['grnstatus'] == 1) {
							button += '<button type="button" class="btn btn-success btn-sm mr-1 ';
							if (statuscheck != 1) {
								button += 'd-none';
							}
							button += '"><i class="fas fa-check"></i></button>';
						}

						return button;
					}
				}
			],
			drawCallback: function (settings) {
				$('[data-toggle="tooltip"]').tooltip();
			}
		});

		$('#dataTable tbody').on('click', '.btnAdd', function () {
			var id = $(this).attr('id');
			$('#productionorderid').val(id);
			$('#machineallocatemodal').modal('show');

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
				success: function (result) { //alert(result);
					$('#viewproduction').html(result);
					$('#exampleModalCenter').modal('show');
				}
			});
		});
		$('#dataTable tbody').on('click', '.btnothercost', function () {
			var id = $(this).attr('id');
			loadothercosttype(id);
			$('#hidesemiproductionorder').val(id);

			$.ajax({
				type: "POST",
				data: {
					recordID: id,
				},
				url: '<?php echo base_url() ?>Semiproduction/Viewalreadyothercost',
				success: function(result) { //alert(result);
					$('#viewcostlist').html(result);
				}
			}); 

			$('#modalotherexpences').modal('show');
		});	
		$('#btnsubmitohter').click(function(){
			if (!$("#formothercost")[0].checkValidity()) {
				// If the form is invalid, submit it. The form won't actually submit;
				// this will just cause the browser to display the native HTML5 error messages.
				$("#hidesubmitother").click();
			} else {
				var costtype = $('#costtype').val();
				var costtypetext = $("#costtype option:selected").text();
				var amount = $('#amount').val();
				var perunit = $("input[name='perunithall']:checked").val();			

				$('#tablecostlist> tbody:last').append('<tr><td class="">' + costtypetext + '</td><td class="">' + costtype + '</td><td class="">' + perunit + '</td><td class="text-right">' + amount + '</td></tr>');

				$('#hideresetother').click();
				$("#costtype option[value='"+costtype+"']").remove();
			}
		});
		$('#tablecostlist').on('click', 'tr', async function() {
			var r = await Otherconfirmation("You want to remove this ? ");
			if (r == true) {
				$(this).closest('tr').remove();
				loadothercosttype($('#hidesemiproductionorder').val());
			}
		});
		$('#btnsaveallohter').click(function(){
			if ($('#tablecostlist tbody').children().length > 0) {
				var semiproductionID = $('#hidesemiproductionorder').val();

				// get table data into array
				var tbody = $('#tablecostlist tbody');
				if (tbody.children().length > 0) {
					var jsonObj = []
					$("#tablecostlist tbody tr").each(function () {
						item = {}
						$(this).find('td').each(function (col_idx) {
							item["col_" + (col_idx + 1)] = $(this).text();
						});
						jsonObj.push(item);
					});
				}
				// console.log(jsonObj);

				$.ajax({
					type: "POST",
					data: {
						tableData: jsonObj,
						semiproductionID: semiproductionID,
					},
					url: '<?php echo base_url() ?>Semiproduction/Othercostinsertupdate',
					success: function (result) {
						// console.log(result);
						window.location.reload();
					}
				});
			}
		});

		//Daily Prodcution Complete Start
		$('#dataTable tbody').on('click', '.btndailycomplete', function () {
			var id = $(this).attr('id');
			$('#hidesemiproductionid').val(id);
			$('#dailycompletemodal').modal('show');
		});
		$('#btncomsubmit').click(function(){
			let id = $('#hidesemiproductionid').val();
			let comqty = $('#comqty').val();
			let damageqty = $('#damageqty').val();
			$.ajax({
				type: "POST",
				data: {
					recordID: id,
					comqty: comqty,
					damageqty: damageqty
				},
				url: '<?php echo base_url() ?>Semiproduction/Checkproductorderqty',
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
		$('#dataTable tbody').on('click', '.btndailycompleteview', function () {
			var id = $(this).attr('id');
			$('#hideviewproorderdetailid').val(id);
			dailycompleteapprovelist(id);
		});
		$('#tabledailyapprove tbody').on('click', '.btndailycompleteapprove',  async function() {
			var r = await Otherconfirmation("You want to approve this record ? ");
			if (r == true) {
				var id = $(this).attr('id');

				$.ajax({
					type: "POST",
					data: {
						recordID: id
					},
					url: '<?php echo base_url() ?>Semiproduction/Semiproductiontransfer',
					success: function (result) { //alert(result);
						// console.log(result);
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
		//Daily Prodcution Complete End
	});

	function dailycompleteapprovelist(id){
		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Semiproduction/Viewdailycompleteinfo',
			success: function (result) { //alert(result);
				// console.log(result);
				$('#tabledailyapprove > tbody').empty().html(result);
				$('#dailycompleteviewmodal').modal('show');
			}
		});
	}

	function loadothercosttype(id){
		$.ajax({
			type: "POST",
			data: {
				recordID: id,
			},
			url: '<?php echo base_url() ?>Semiproduction/Getothercosttype',
			success: function(result) { //alert(result);
				var objfirst = JSON.parse(result);

				var html = '';
				html += '<option value="">Select</option>';
				$.each(objfirst, function(i, item) {
					//alert(objfirst[i].id);
					html += '<option value="' + objfirst[i].idtbl_expence_type + '">';
					html += objfirst[i].expencetype;
					html += '</option>';
				});

				$('#costtype').empty().append(html);
			}
		}); 
	}
</script>
<?php include "include/footer.php"; ?>
