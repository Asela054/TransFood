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
							<div class="page-header-icon"><i class="fas fa-truck"></i></div>
							<span>Quality Check</span>
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
                                                <th>GRN Date</th>
                                                <th>GRN No</th>
                                                <th>Batch No</th>
                                                <th>Supplier</th>
                                                <th>Approved Status</th>
                                                <th>Quality Status</th>
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
                    <input type="hidden" name="editedgrnid" id="editedgrnid">
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Quality Check</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="qualityform">
							<div id="formlayer"></div>
							<div class="form-row text-right">
								<div class="col mt-3">
									<button type="button" class="btn btn-primary btn-sm" id="btnapplyquality">APPLY
										QUALITY</button>
								</div>
							</div>
                            <input type="hidden" name="hidegrnid" id="hidegrnid">
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
						<button type="button" class="btn btn-primary btn-sm mb-3 px-3" id="btnEditinfo" <?php if($editcheck!=1){ echo 'disabled';} ?>><i
								class="fas fa-edit"></i>&nbsp;EDIT INFO</button>
						<input type="hidden" name="hideproductionmaterial2" id="hideproductionmaterial2">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="materialinfomodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="modal-title" id="staticBackdropLabel">Material Info</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Material</th>
							<th class="text-right">Actions</th>
						</tr>
					</thead>
					<tbody id="materialrecords">
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
     $(document).on("click", ".btnViewqualityinfo", function () {
            var id = $(this).attr('id');
            // alert(id);
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Qualitycheck/Getqualityviewdescription',
                success: function (result) { //alert(result);
                    $('#viewdescription').html(result);
                    $('#materialinfomodal').modal('hide');
                    $('#qualityviewmodal').modal('show');
                    

                }
            });
            });

            $(document).on("click", ".btnViewpdf", function () {
            	var id = $(this).attr('id');
            	var materialid = $(this).attr('value');
            	// alert(materialid);
            	// alert(id);
            	$.ajax({
            		type: "POST",
            		data: {
            			recordID: id,
            			materialid: materialid
            		},
            		url: '<?php echo base_url() ?>Qualitycheck/Qualitycheckreport',
            		success: function (result) { //alert(result);
            			// $('#viewdescription').html(result);
            			// $('#materialinfomodal').modal('hide');
            			// $('#qualityviewmodal').modal('show');


            		}
            	});
            });
    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Good Receive Note Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Good Receive Note Information',
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
                url: "<?php echo base_url() ?>scripts/qualitychecklist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "grndate"
                },
                {
                    "data": "grn_no",
                    "render": function(data, type, full) {
                            return "UN/GRN-0000" + data;
                    }
                },
                {
                    "data": "batchno"
                },
                {
                    "data": "suppliername"
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['approvestatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Approved GRN';}
                        else{return 'Not Approved GRN';}
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['qualitycheck']==1){return '<i class="fas fa-check text-success mr-2"></i>Quality Checked';}
                        else if(full['qualitycheck']==0){return '<i class="fas fa-times text-danger mr-2"></i>Pending';}
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        if(full['qualitycheck']==0){
                        button+='<button class="btn btn-primary btn-sm btncheck mr-1" id="'+full['idtbl_grn']+'"><i class="fas fa-tasks"></i></button>';
                        }else{
                        button+='';
                        }
                        button+='<button class="btn btn-dark btn-sm btnview mr-1" id="'+full['idtbl_grn']+'"><i class="fas fa-eye"></i></button>';
                        // button+='<a href="<?php echo base_url() ?>Qualitycheck/Qualitycheckreport/'+full['idtbl_grn']+'" target="_self" class="btn btn-warning btn-sm mr-1"><i class="fas fa-file"></i></a>';

                        if(full['qualitycheck']==1){
                            button+='<button class="btn btn-success btn-sm mr-1 disabled';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></button>';
                        }else{
                        button+='<a href="<?php echo base_url() ?>Qualitycheck/Qualitycheckstatus/'+full['idtbl_grn']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $(document).on('click', '#btnEditinfo', function () {
        	var grnid = $('#hideproductionmaterial2').val();
            //alert(grnid);

        	$.ajax({
        		type: "POST",
        		data: {
                    recordID: grnid
                },
        		url: '<?php echo base_url() ?>Qualitycheck/Editqualityinfo',
        		success: function (result) { //alert(result);
                    $('#editformlayer').html(result);
        			$('#qualityinfoeditmodal').modal('show');
        			$('#qualityviewmodal').modal('hide');
        		}
        	});
        });

        $('#dataTable tbody').on('click', '.btncheck', function () {
        	var id = $(this).attr('id');
        	$('#hidegrnid').val(id);

        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Qualitycheck/GRNqualityform',
        		success: function (result) {

        			$('#formlayer').html(result);
        			$('#porderviewmodal').modal('show');
        		}
        	});
        });
        $('#dataTable tbody').on('click', '.btnview', function(){
            var id = $(this).attr('id');
            $('#hideproductionmaterial2').val(id);
            $('#editedgrnid').val(id);

            $.ajax({
                type: "POST",
                data: {

                    recordID: id
                },
                url: '<?php echo base_url() ?>Qualitycheck/Getmaterialinfo',
                success: function(result) { //alert(result);
                    $('#materialrecords').html(result);
                    $('#materialinfomodal').modal('show');
                }
            });            
        });
        $('#btnapplyquality').click(function(){
            var formData = new FormData($('#qualityform')[0]);
            // var grnid = $('#hideproductionmaterial').val();

            $.ajax({
                url: '<?php echo base_url() ?>Qualitycheck/GRNqualityinsertupdate',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {//alert(response);
                    // console.log(response);
                    var obj = JSON.parse(response);
                    if(obj.status==1){
                        $('#porderviewmodal').modal('hide');
                        setTimeout(window.location.reload(), 3000);
                    }
                    action(obj.action);
                }
            });
        });
        $('#btnsavequality').click(function(){
            var formData = new FormData($('#editqualityform')[0]);
            // var grnid = $('#hideproductionmaterial').val();

            $.ajax({
                url: '<?php echo base_url() ?>Qualitycheck/NewGRNinsertupdate',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {//alert(response);
                    // console.log(response);
                    var obj = JSON.parse(response);
                    if(obj.status==1){
                        $('#qualityinfoeditmodal').modal('hide');
                        setTimeout(window.location.reload(), 3000);
                    }
                    action(obj.action);
                }
            });
        });

        $(document).on('change', '#materialinfo', function () {
        	var materialID = $(this).val();
        	var grnID = $('#hidegrnid').val();
            //alert(materialID);

        	$.ajax({
        		type: "POST",
        		data: {
                    recordID: materialID,
                    grnID: grnID
                },
        		url: '<?php echo base_url() ?>Qualitycheck/Getmaterialqtyaccomaterialid',
        		success: function (result) { //alert(result);
                    $('#grnqty').val(result);
        		}
        	});
        });
    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to approve this Quality Check?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to reject this Quality Check?");
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

    function amendoption(){
        $('#tableamend tbody').on('click', '.editqty', function(e) {
            var row = $(this);
            
            var unitprice = row.closest("tr").find('td:eq(1)').text();
            var qty = row.closest("tr").find('td:eq(2)').text();
            
            e.preventDefault();
            e.stopImmediatePropagation();

            $this = $(this);
            if ($this.data('editing')) return;

            var val = $this.text();

            $this.empty();
            $this.data('editing', true);

            $('<input type="Text" class="form-control form-control-sm optionamendqty">').val(val).appendTo($this);
            textremove('.optionamendqty', row);
        });
    }

    function textremove(classname, row) {
        $('#tableamend tbody').on('keyup', classname, function(e) {
            if (e.keyCode === 13) { 
                $this = $(this);
                var val = $this.val();
                var td = $this.closest('td');
                td.empty().html(val).data('editing', false);

                var rowID = row.closest("td").parent()[0].rowIndex;
                var unitprice = parseFloat(row.closest("tr").find('td:eq(1)').text());
                var qty = parseFloat(row.closest("tr").find('td:eq(2)').text());
                var amendqty = parseFloat(row.closest("tr").find('td:eq(3)').text());

                var changetotal=parseFloat((unitprice*amendqty)).toFixed(2);
                $('#tableamend').find('tr').eq(rowID).find('td:eq(4)').text(addCommas(changetotal));
                $('#tableamend').find('tr').eq(rowID).find('td:eq(5)').text(changetotal);

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));
                $('#netshow').html('Rs. '+showsum);
                $('#hidenettotal').val(parseFloat(sum).toFixed(2));
            }
        });
    }//Text Editable Remove Commission
</script>
<?php include "include/footer.php"; ?>
