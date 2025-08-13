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
                            <div class="page-header-icon"><i class="fas fa-truck-loading"></i></div>
                            <span>Approve & Start</span>
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
                                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home"
                                            type="button" role="tab" aria-controls="home" aria-selected="true">Production & Planning</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="machine-tab" data-toggle="tab" data-target="#machine"
                                            type="button" role="tab" aria-controls="machine"
                                            aria-selected="false">Machine Process</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile"
                                            type="button" role="tab" aria-controls="profile"
                                            aria-selected="false">Production Packing</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-toggle="tab" data-target="#contact"
                                            type="button" role="tab" aria-controls="contact"
                                            aria-selected="false">Prodcution Complete & FG</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active py-3" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="scrollbar pb-3" id="style-2">
                                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer</th>
                                                        <th>Type</th>
                                                        <th>Order Date</th>
                                                        <th>Due Date</th>
                                                        <th>Net Total</th>
                                                        <th>Remark</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade py-3" id="machine" role="tabpanel" aria-labelledby="machine-tab">
                                        <div class="scrollbar pb-3" id="style-2">
                                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTableMachine">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer</th>
                                                        <th>Type</th>
                                                        <th>Order Date</th>
                                                        <th>Due Date</th>
                                                        <th>Net Total</th>
                                                        <th>Remark</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="scrollbar pb-3" id="style-2">
                                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTablePacking">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Customer</th>
                                                        <th>Type</th>
                                                        <th>Order Date</th>
                                                        <th>Due Date</th>
                                                        <th>Net Total</th>
                                                        <th>Remark</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"></div>
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
<!-- Modal Prodcution Set -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row mb-3">
                    <div class="col-sm-12 col-md-12 col-lg-7 col-xl-7">
                        <label class="small font-weight-bold text-dark">Order Finish Good*</label>
                        <select class="form-control form-control-sm" name="orderfinishgood" id="orderfinishgood" required>
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2">
                        <label class="small font-weight-bold text-dark">Order Qty*</label>
                        <input type="text" name="orderqty" id="orderqty" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <label class="small font-weight-bold text-dark">Issued Qty*</label>
                        <input type="text" name="issueqty" id="issueqty" class="form-control form-control-sm" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div id="datalayout"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                        <button type="button" class="btn btn-primary btn-sm" id="btnstartproduction"><i class="far fa-play-circle mr-2"></i>Start Production</button>
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
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
<!-- Modal Production Machine -->
<div class="modal fade" id="modalproductionmachine" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Production Material Allocation To Machine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3">
                        <form id="formmachinallocation">
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Row Material*</label>
                                    <select class="form-control form-control-sm" name="rowmaterial" id="rowmaterial" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Allocate Qty*</label>
                                    <input type="text" class="form-control form-control-sm" name="materialqty" id="materialqty" required>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Factory*</label>
                                    <select class="form-control form-control-sm" name="factory" id="factory" required>
                                        <option value="">Select</option>
                                        <?php foreach($factorylist->result() as $rowfactorylist){ ?>
                                        <option value="<?php echo $rowfactorylist->idtbl_factory ?>"><?php echo $rowfactorylist->factoryname.' - '.$rowfactorylist->factorycode ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Machine*</label>
                                    <select class="form-control form-control-sm" name="machine" id="machine" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Start Date Time*</label>
                                    <input type="datetime-local" name="machinestart" id="machinestart" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">End Date Time*</label>
                                    <input type="datetime-local" name="machineend" id="machineend" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Direct Transfer to Packing*</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="directtopack1" name="directtopack" class="custom-control-input" value="1">
                                    	<label class="custom-control-label" for="directtopack1">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="directtopack2" name="directtopack" class="custom-control-input" value="0" checked>
                                    	<label class="custom-control-label" for="directtopack2">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col text-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="addtolistbtnmachine"><i class="fas fa-clipboard-list mr-2"></i>Add To List</button>
                                    <input type="submit" class="d-none" id="submitBtnmachine">
                                    <input type="reset" class="d-none" id="resetBtnmachine">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9">
                        <table class="table table-striped table-bordered table-sm small" id="tablemachineallocation">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Qty</th>
                                    <th>Factory</th>
                                    <th>Machine</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Direct Transfer</th>
                                    <th class="d-none">MaterialID</th>
                                    <th class="d-none">FactoryID</th>
                                    <th class="d-none">MachineID</th>
                                    <th class="d-none">DirectValue</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-danger btn-sm" id="savealldatabtn"><i class="fas fa-save mr-2"></i>Save all data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="hideprodcutionordermachine" id="hideprodcutionordermachine">
			</div>
		</div>
	</div>
</div>
<!-- Modal Production Machine Complete Qty -->
<div class="modal fade" id="modalproductionmachinecomplete" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Production Material Complete Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="formmachincomplete">
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Row Material*</label>
                                    <select class="form-control form-control-sm" name="rowmaterialcomplete" id="rowmaterialcomplete" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Complete Qty*</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="materialqtycomplete" id="materialqtycomplete" required>
                                    	<input type="text" class="form-control" id="allocateqty" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Complete Date Time*</label>
                                    <input type="datetime-local" name="machinedatecomplete" id="machinedatecomplete" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-2">
                                <div class="col text-right">
                                    <button type="button" class="btn btn-primary btn-sm" id="addtolistbtnmachinecomplete"><i class="fas fa-clipboard-list mr-2"></i>Add To List</button>
                                    <input type="submit" class="d-none" id="submitBtnmachinecomplete">
                                    <input type="reset" class="d-none" id="resetBtnmachinecomplete">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <table class="table table-striped table-bordered table-sm small" id="tablemachinecomplete">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Complete Qty</th>
                                    <th>Complete Date Time</th>
                                    <th class="d-none">MaterialID</th>
                                    <th class="d-none">Allcateqty</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-danger btn-sm" id="savealldatacompletebtn"><i class="fas fa-save mr-2"></i>Save all data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="hideprodcutionordermachinecomplete" id="hideprodcutionordermachinecomplete">
			</div>
		</div>
	</div>
</div>
<!-- Modal Production Machine Complete Qty -->
<div class="modal fade" id="modalpackingmaterialinfo" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Production Packing Material Information</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-striped table-bordered table-sm small" id="tablepackmaterial">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Material Code</th>
                                    <th>Batch No</th>
                                    <th>Qty</th>
                                    <th>Pack Qty</th>
                                    <th class="d-none">MaterialinfoID</th>
                                    <td class="text-center">&nbsp;</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" name="hidepackproductionorder" id="hidepackproductionorder">
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
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        var rowinfo;
        var materialcategory;
        var materialselectID;

        setdatalayout();

        $('[data-toggle="tooltip"]').tooltip();

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
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Brand Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/pendingproduction.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_production_order"
                },
                {
                    "data": "name"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['customertype']){
                            return 'Local Customer';
                        }
                        else{
                            return 'International Customer';
                        }
                    }
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "duedate"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        if(full['approvestatus']==0){
                            button+='<button type="button" class="btn btn-danger btn-sm mr-1 btnApprove ';if(statuscheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-times"></i></button>';
                        }
                        else{
                            button+='<button type="button" data-toggle="tooltip" data-placement="top" title="Material Allocation" class="btn btn-dark btn-sm mr-1 btnproduction ';if(addcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-list"></i></button>';
                        }
                        button+='<button type="button" data-toggle="tooltip" data-placement="top" title="Machine Allocation" class="btn btn-primary btn-sm mr-1 btnmachine ';if(addcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-dolly-flatbed"></i></button>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnApprove', function() {
            var r = confirm("Are you sure, You want to Approve this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $('#productionorder').val(id);
                
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Production/Productionapprovel',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            $('#dataTable').DataTable().ajax.reload( null, false );
                        }
                        action(obj.action);
                    }
                });
            }
        });
        $('#dataTable tbody').on('click', '.btnproduction', function() {
            var id = $(this).attr('id');
            $('#hideprodcutionorder').val(id);
            $('#staticBackdrop').modal('show');
            
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Productiondetailaccoproduction',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_production_order_detail + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].productcode;
                        html1 += '</option>';
                    });
                    $('#orderfinishgood').empty().append(html1);                    
                }
            });
        });
        $('#dataTable tbody').on('click', '.btnmachine', function() {
            var id = $(this).attr('id');
            $('#hideprodcutionordermachine').val(id);
            $('#modalproductionmachine').modal('show');
            
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Productionmaterialdetailaccoproductionmaterial',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_production_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode + ' (' + obj[i].batchno + ')';
                        html1 += '</option>';
                    });
                    $('#rowmaterial').empty().append(html1);                    
                }
            });
        });
        
        $('#orderfinishgood').change(function(){
            var id = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Getqtyinfoaccoproductiondetail',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    
                    $.each(obj, function (i, item) {
                        $('#orderqty').val(obj[i].qty);
                        $('#issueqty').val(obj[i].issueqty);
                    });
                }
            });

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Getrowmateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Row Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.rowmaterial').empty().append(html1);
                }
            });
            
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Getpackmateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Packing Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.packingmaterial').empty().append(html1);
                }
            });

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Getlablemateriallist',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Labling Material</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('.lablematerial').empty().append(html1);
                }
            });
        });
        $('#btnstartproduction').click(function(){
            $('#btnstartproduction').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Start Production');
            var tbodymaterial = $("#rowmaterialtable tbody");
            jsonObjmaterial = [];

            if (tbodymaterial.children().length > 0) {
                $("#rowmaterialtable tbody tr").each(function () {
                    var statusmaterial=0;
                    itemmaterial = {}
                    $(this).find('td').each(function (col_idx) {
                        itemmaterial["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statusmaterial=1;
                        }
                    });

                    if(statusmaterial==0){
                        jsonObjmaterial.push(itemmaterial);
                    }
                });
            }
            // console.log(jsonObjmaterial);

            var tbodypacking = $("#packingmaterialtable tbody");
            jsonObjpacking = [];

            if (tbodypacking.children().length > 0) {
                $("#rowpackingtable tbody tr").each(function () {
                    var statuspacking=0;
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statuspacking=1;
                        }
                    });
                    
                    if(statusmaterial==0){
                        jsonObjpacking.push(item);
                    }
                });
            }
            // console.log(jsonObjpacking);

            var tbodylabling = $("#lablingmaterialtable tbody");
            jsonObjlabling = [];

            if (tbodylabling.children().length > 0) {
                $("#lablingmaterialtable tbody tr").each(function () {
                    var statuslabeling=0;
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                        if(col_idx==1 && $(this).text()==''){
                            statuslabeling=1;
                        }
                    });

                    if(statuslabeling==0){
                        jsonObjlabling.push(item);
                    }
                });
            }
            // console.log(jsonObjlabling);

            var productionorder = $('#hideprodcutionorder').val();
            var orderqty = $('#orderqty').val();
            var orderfinishgood = $('#orderfinishgood').val();
            
            $.ajax({
                type: "POST",
                data: {
                    tableDataMaterial: jsonObjmaterial,
                    tableDataPacking: jsonObjpacking,
                    tableDataLabeling: jsonObjlabling,
                    orderqty: orderqty,
                    orderfinishgood: orderfinishgood,
                    productionorder: productionorder
                },
                url: 'Production/Productioninsertupdate',
                success: function (result) { //alert(result);
                    // console.log(result);
                    var obj = JSON.parse(result);
                    if(obj.status==1){
                        setdatalayout();
                        $('#orderfinishgood').val('');
                        $('#orderqty').val('');
                        $('#issueqty').val('');
                        $('#btnstartproduction').prop('disabled', false).html('<i class="far fa-play-circle mr-2"></i> Start Production');
                    }
                    action(obj.action);
                }
            });
        });  
        
        $('#rowmaterial').change(function(){
            let rowmaterialID=$(this).val();

            $.ajax({
                type: "POST",
                data: {
                    recordID: rowmaterialID
                },
                url: '<?php echo base_url() ?>Production/Getmachineavailableqty',
                success: function(result) { //alert(result);
                    $('#materialqty').val(result);
                }
            });
        });
        $('#factory').change(function(){
            var id = $(this).val();

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Getmachineaccofactory',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html2 = '';
                    html2 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html2 += '<option value="' + obj[i].idtbl_machine + '">';
                        html2 += obj[i].machine + ' - ' + obj[i].machinecode;
                        html2 += '</option>';
                    });
                    $('#machine').empty().append(html2);
                }
            });
        });
        $('#addtolistbtnmachine').click(function(){
            if (!$("#formmachinallocation")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtnmachine").click();
            } else {
                var rowmaterialID = $('#rowmaterial').val();
                var rowmaterial = $("#rowmaterial option:selected").text();
                var materialqty = $('#materialqty').val();
                var factoryID = $('#factory').val();
                var factory = $("#factory option:selected").text();
                var machineID = $('#machine').val();
                var machine = $("#machine option:selected").text();
                var machinestart = $('#machinestart').val();
                var machineend = $('#machineend').val();
                var directtopackVal = $('input[name="directtopack"]:checked').val();
                if(directtopackVal==1){var directstatus='Yes';}else{var directstatus='No';}

                if(factoryID==''){var factory = '';}
                if(machineID==''){var machine = '';}

                $('#tablemachineallocation > tbody:last').append('<tr class="pointer"><td>' + rowmaterial + '</td><td>' + materialqty + '</td><td>' + factory + '</td><td>' + machine + '</td><td>' + machinestart + '</td><td>' + machineend + '</td><td>' + directstatus + '</td><td class="d-none">' + rowmaterialID + '</td><td class="d-none">' + factoryID + '</td><td class="d-none">' + machineID + '</td><td class="d-none">' + directtopackVal + '</td></tr>');

                $('#resetBtnmachine').click();
            }
        });
        $('input[name="directtopack"]').change(function(){
            var status = $(this).val();
            if(status==1){
                $('#factory').prop('required', false);
                $('#machine').prop('required', false);
                $('#machinestart').prop('required', false);
                $('#machineend').prop('required', false);
            }
            else{
                $('#factory').prop('required', true);
                $('#machine').prop('required', true);
                $('#machinestart').prop('required', true);
                $('#machineend').prop('required', true);
            }
        });
        $('#savealldatabtn').click(function(){
            $('#savealldatabtn').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Save all data')
            var tbody = $("#tablemachineallocation tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tablemachineallocation tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                // console.log(jsonObj);

                var hideprodcutionordermachine = $('#hideprodcutionordermachine').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        hideprodcutionordermachine: hideprodcutionordermachine
                    },
                    url: 'Production/Productionmachineinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            $('#modalproductionmachine').modal('hide');
                            setTimeout(window.location.reload(), 3000);
                        }
                        action(obj.action);
                    }
                });
            }
        });

        //Machine Process Start
        $('#dataTableMachine').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Brand Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/machineproduction.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_production_order"
                },
                {
                    "data": "name"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['customertype']){
                            return 'Local Customer';
                        }
                        else{
                            return 'International Customer';
                        }
                    }
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "duedate"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button type="button" data-toggle="tooltip" data-placement="top" title="Complete Quantity Add" class="btn btn-primary btn-sm mr-1 btncomqty ';if(addcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-tasks"></i></button>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTableMachine tbody').on('click', '.btncomqty', function() {
            var id = $(this).attr('id');
            $('#hideprodcutionordermachinecomplete').val(id);
            $('#modalproductionmachinecomplete').modal('show');

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Productionmateriallistaccoproductionordermachine',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '" data-promateinfo="'  + obj[i].idtbl_production_material_info + '">';
                        html1 += obj[i].materialname + ' - ' + obj[i].materialinfocode + '/' + obj[i].allocateqty;
                        html1 += '</option>';
                    });
                    $('#rowmaterialcomplete').empty().append(html1);                    
                }
            });
        });
        $('#rowmaterialcomplete').change(function(){
            let rowmaterialcomplete = $("#rowmaterialcomplete option:selected").text();
            const myArray = rowmaterialcomplete.split("/");
            $('#allocateqty').val(myArray[1]);
        });
        $('#addtolistbtnmachinecomplete').click(function(){
            if (!$("#formmachincomplete")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtnmachinecomplete").click();
            } else {
                var rowmaterialcompleteID = $('#rowmaterialcomplete').val();
                var rowmaterialcomplete = $("#rowmaterialcomplete option:selected").text();
                var materialqtycomplete = $('#materialqtycomplete').val();
                var allocateqty = $('#allocateqty').val();
                var machinedatecomplete = $('#machinedatecomplete').val();

                var selected = $('#rowmaterialcomplete').find('option:selected');
                var extradata = selected.data('promateinfo'); 

                $('#tablemachinecomplete > tbody:last').append('<tr class="pointer"><td>' + rowmaterialcomplete + '</td><td>' + materialqtycomplete + '</td><td>' + machinedatecomplete + '</td><td class="d-none">' + rowmaterialcompleteID + '</td><td class="d-none">' + allocateqty + '</td><td class="d-none">' + extradata + '</td></tr>');

                $('#resetBtnmachinecomplete').click();
            }
        });
        $('#savealldatacompletebtn').click(function(){
            $('#savealldatacompletebtn').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Save all data')
            var tbody = $("#tablemachinecomplete tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tablemachinecomplete tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                // console.log(jsonObj);

                var hideprodcutionordermachinecomplete = $('#hideprodcutionordermachinecomplete').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        hideprodcutionordermachinecomplete: hideprodcutionordermachinecomplete
                    },
                    url: 'Production/Productionmachinecompleteinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            $('#modalproductionmachinecomplete').modal('hide');
                            setTimeout(window.location.reload(), 3000);
                        }
                        action(obj.action);
                    }
                });
            }
        });
        //Machine Process End

        //Packing Process Start
        $('#dataTablePacking').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            "buttons": [
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Brand Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Brand Information',
                    className: 'btn btn-primary btn-sm', 
                    text: '<i class="fas fa-print mr-2"></i> Print',
                    customize: function ( win ) {
                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }, 
                },
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/packingproduction.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_production_order"
                },
                {
                    "data": "name"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['customertype']){
                            return 'Local Customer';
                        }
                        else{
                            return 'International Customer';
                        }
                    }
                },
                {
                    "data": "orderdate"
                },
                {
                    "data": "duedate"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button type="button" data-toggle="tooltip" data-placement="top" title="View Packing Materials" class="btn btn-dark btn-sm mr-1 btnpackmaterial ';if(addcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-eye"></i></button>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTablePacking tbody').on('click', '.btnpackmaterial', function() {
            var id = $(this).attr('id');
            $('#hidepackproductionorder').val(id);
            $('#modalpackingmaterialinfo').modal('show');

            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Production/Packmateriallistaccoproduction',
                success: function(result) { //alert(result);
                    $('#tablepackmaterial > tbody').html(result);
                }
            });
        });
        $('#tablepackmaterial tbody').on('click', '.btnmaterialinfo', function(){
            var id = $(this).attr('id');
            $('#hideproductionmaterial').val(id);

            $.ajax({
                type: "POST",
                data: {},
                url: '<?php echo base_url() ?>Production/Productionpackqualityform',
                success: function(result) { //alert(result);
                    $('#formlayer').html(result);
                    $('#modalquality').modal('show');
                }
            });            
        });
        $('#btnapplyquality').click(function(){lione
            var formData = new FormData($('#qualityform')[0]);

            $.ajax({
                url: '<?php echo base_url() ?>Production/Productionpackqualityinsertupdate',
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
        //Packing Process End
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

    function textremove(classname) {
        $('#tablestockinfo tbody').on('keyup', classname, function(e) {
            if (e.keyCode === 13) { 
                $this = $(this);
                let rowclick = $(this);
                var val = parseFloat($this.val());
                let rowclickID = rowclick.closest("td").parent()[0].rowIndex;
                
                var stockqty = parseFloat($('#tablestockinfo').find('tr').eq(rowclickID).find('td:eq(1)').text());
                
                if(stockqty<val){
                    $(classname).addClass('bg-danger text-white');
                }
                else{
                    $(classname).removeClass('bg-danger text-white');
                    var td = $this.closest('td');
                    td.empty().html(val).data('editing', false);
                }
            }
        });
    }

    function setdatalayout(){
        $.ajax({
            type: "POST",
            data: {},
            url: '<?php echo base_url() ?>Production/Getmaterialenterlayout',
            success: function(result) { //alert(result);
                $('#datalayout').empty().html(result);
                dataenteroption();
            }
        });
    }

    function dataenteroption(){
        // Material change start
        $('#rowmaterialtable').on('change', '.rowmaterial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 1;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Production/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });

                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Production/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#packingmaterialtable').on('change', '.packingmaterial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 2;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Production/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Production/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#lablingmaterialtable').on('change', '.lablematerial', function() {
            let materialID=$(this).val();
            materialselectID=$(this).val();
            rowinfo = $(this);
            materialcategory = 3;
            var productionmaterialinfoID=$('#orderfinishgood').val();
            
            if(materialID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        materialID: materialID
                    },
                    url: '<?php echo base_url() ?>Production/Getmaterialstockinfoaccomaterial',
                    success: function(result) { //alert(result);
                        $('#tablestockinfo > tbody').html(result);
                        $('#modalproductionmaterial').modal('show');
                    }
                });
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: materialID,
                        productionmaterialinfoID: productionmaterialinfoID
                    },
                    url: '<?php echo base_url() ?>Production/Checkissueqty',
                    success: function(result) { //alert(result);
                        let orderqty = $('#orderqty').val();
                        if(parseFloat(result)==orderqty){
                            $('#btnaddmaterialinfo').prop('disabled', true);
                        }
                        else{
                            $('#btnaddmaterialinfo').prop('disabled', false);
                        }
                    }
                });
            }
        });

        $('#tablestockinfo tbody').on('click', '.enterqty', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            $this = $(this);
            if ($this.data('editing')) return;

            var val = $this.text();

            $this.empty();
            $this.data('editing', true);

            $('<input type="Text" class="form-control form-control-sm issueqty" style="width: 100%">').val(val).appendTo($this);
            textremove('.issueqty');
        });

        $('#btnaddmaterialinfo').click(function(){
            var tbody = $("#tablestockinfo tbody");

            if (tbody.children().length > 0) {
                var batchnolist='';
                var qtylist='';
                var issueqtytotal=parseFloat(0);
                var issueqtyenter=0;
                $("#tablestockinfo tbody tr").each(function () {
                    var issueqtyenter=parseFloat(0);
                    $(this).find('td').each(function (col_idx) {
                        // if(col_idx==0){batchnolist+=$(this).text()+',';}
                        if(col_idx==2){
                            if($(this).text()!=''){
                                issueqtyenter=$(this).text();
                                issueqtytotal=issueqtytotal+parseFloat($(this).text());
                                qtylist+=$(this).text()+',';
                            }
                        }
                        if(col_idx==3){
                            if(issueqtyenter>0){
                                batchnolist+=$(this).text()+',';
                            }
                        }
                    });
                });
                
                var rowID = rowinfo.closest("td").parent()[0].rowIndex;
                if(materialcategory==1){
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#rowmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }
                if(materialcategory==2){
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#packingmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }
                if(materialcategory==3){
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(1)').text(batchnolist);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(2)').text(issueqtytotal);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(3)').text(materialselectID);
                    $('#lablingmaterialtable').find('tr').eq(rowID).find('td:eq(4)').text(qtylist);
                }

                $('#modalproductionmaterial').modal('hide');
            }
        });
        // Material change end
    }
</script>
<?php include "include/footer.php"; ?>
