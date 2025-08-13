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
                            <span>Packing & Finish Good</span>
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
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
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
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<!-- Modal Prduction Process Materials -->
<div class="modal fade" id="modalproduction" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Finishing & Labling Materials</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <table class="table table-striped table-bordered table-sm" id="viewprocesstable">
                            <thead>
                                <tr>
                                    <th>Finish Good</th>
                                    <th>Issue Batch No</th>
                                    <th>Qty</th>
                                    <th>Factory</th>
                                    <th>Machine</th>
                                    <th>Material Code</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyprocessinfo"></tbody>
                        </table>
                    </div>
                </div>
                <input type="hidden" name="hideproductionID" id="hideproductionID">
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Quality check and transfer to approve</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <form id="productionsteptwoform" autocomplete="off">
                            <div id="msgdiv"></div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">BRAND</label>
                                    <input type="text" name="brand" id="brand" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">STICKERS</label>
                                    <div class="custom-control custom-checkbox">
                                    	<input type="checkbox" class="custom-control-input" name="stickerfront" id="stickerfront" value="1">
                                    	<label class="custom-control-label small" for="stickerfront">FRONT</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                    	<input type="checkbox" class="custom-control-input" name="stickeback" id="stickeback" value="1">
                                    	<label class="custom-control-label small" for="stickeback">BACK</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                    	<input type="checkbox" class="custom-control-input" name="stickequality" id="stickequality" value="1">
                                    	<label class="custom-control-label small" for="stickequality">QUALITY</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">UNIT WEIGHT</label>
                                    <input type="text" name="unitweight" id="unitweight" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">REQ. UNIT WEIGHT</label>
                                    <input type="text" name="reunitweight" id="reunitweight" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">PACKING MATERIAL</label>
                                    <input type="text" name="packmaerial" id="packmaerial" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">REQUIRED MATERIAL</label>
                                    <input type="text" name="rematerial" id="rematerial" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">PACKING METHOD</label>
                                    <input type="text" name="packmethod" id="packmethod" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">SEALING METHOD</label>
                                    <input type="text" name="sealmethod" id="sealmethod" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">NO of UNITS/CARTON</label>
                                    <input type="text" name="nounitcar" id="nounitcar" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">SEALING CHECK</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="sealcheck1" name="sealcheck"
                                    		class="custom-control-input" value="1">
                                    	<label class="custom-control-label" for="sealcheck1">Pass</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="sealcheck2" name="sealcheck"
                                    		class="custom-control-input" value="0" checked>
                                    	<label class="custom-control-label" for="sealcheck2">Fail</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">CARTON GRS WEIGHT</label>
                                    <input type="text" name="cargrsweight" id="cargrsweight" class="form-control form-control-sm">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">REQ. CARTON GRS. WGT.</label>
                                    <input type="text" name="reqcargrsweight" id="reqcargrsweight" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">METAL DETECTION</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="metaldet1" name="metaldet"
                                    		class="custom-control-input" value="1">
                                    	<label class="custom-control-label" for="metaldet1">Pass</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="metaldet2" name="metaldet"
                                    		class="custom-control-input" value="0" checked>
                                    	<label class="custom-control-label" for="metaldet2">Fail</label>
                                    </div>
                                </div>
                                <div class="col">&nbsp;</div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">PASS OR FAIL</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="passfail1" name="passfail"
                                    		class="custom-control-input" value="1">
                                    	<label class="custom-control-label" for="passfail1">Pass</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" id="passfail2" name="passfail"
                                    		class="custom-control-input" value="0" checked>
                                    	<label class="custom-control-label" for="passfail2">Fail</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">COMMENTS</label>
                                    <textarea type="text" class="form-control form-control-sm" name="comment" id="comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-check"></i>&nbsp;Complete & Tra. Approve</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="productionmachineID" id="productionmachineID" value="">
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

        $('#dataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
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
                url: "<?php echo base_url() ?>scripts/steptwoproduction.php",
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
                        button+='<button type="button" class="btn btn-dark btn-sm mr-1 btncomquality ';if(statuscheck!=1){button+='d-none';}button+='" id="'+full['idtbl_production_order']+'"><i class="fas fa-list"></i></button>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btncomquality', function() {
            var id = $(this).attr('id');
            $('#hideproductionID').val(id);
            filtordata();
        });
        $('#viewprocesstable tbody').on('click', '.btnqualitycheck', function() {
            var id = $(this).attr('id');
            $('#productionmachineID').val(id);
            $('#staticBackdrop').modal('show');
        });

        $('#formsubmit').click(function(){
            var formData = new FormData($('#productionsteptwoform')[0]);
            var emptyTextBoxes = $('#productionsteptwoform input:text').filter(function(){
                return !$(this).val();
            }).length;
            
            if(emptyTextBoxes==12){
                $('#msgdiv').html("<div class='alert alert-danger role='alert'>Can't process this request, because all field are empty</div>");
            }
            else{
                $('#formsubmit').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Complete & Tra. Approve');
                $.ajax({
                    url: '<?php echo base_url() ?>Packfinishgood/Packfinishgoodinsertupdate',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function(response) {//alert(response);
                        console.log(response);
                        if(response==1){
                            filtordata();
                            $('#formsubmit').prop('disabled', true).html('<i class="fas fa-check"></i>&nbsp;Complete & Tra. Approve');
                            $('#staticBackdrop').modal('hide');
                        }
                        else{
                            $('#msgdiv').html("<div class='alert alert-danger role='alert'>Record error</div>");
                        }
                    }
                });
            }
        });
    });

    function filtordata(){
        var id = $('#hideproductionID').val();
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Packfinishgood/Packfinishgoodmaterial',
            success: function(result) { //alert(result);
                $('#modalproduction').modal('show');
                $('#tbodyprocessinfo').html(result);
            }
        });
    }

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
</script>
<?php include "include/footer.php"; ?>
