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
                        <h1 class="page-header-title ">
                            <div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
                            <span>Material Details</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body p-0 p-2">
            			<div class="row">
            				<div class="col-4">
            					<form action="<?php echo base_url() ?>Materialdetail/Materialdetailinsertupdate"
            						method="post" autocomplete="off">
            						<div class="form-row mb-1">
            							<div class="col">
            								<label class="small font-weight-bold">Material Category*</label>
            								<select class="form-control form-control-sm" name="materialcategory"
            									id="materialcategory" required>
            									<option value="">Select</option>
            									<?php foreach($materialcategory->result() as $rowmaterialcategory){ ?>
            									<option
            										value="<?php echo $rowmaterialcategory->idtbl_material_category ?>">
            										<?php echo $rowmaterialcategory->categoryname . ' - ' . $rowmaterialcategory->categorycode?>
            									</option>
            									<?php } ?>
            								</select>
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Material Name*</label>
            								<input type="text" class="form-control form-control-sm" name="materialname"
            									id="materialname">
            							</div>
            						</div>
            						<div class="form-row mb-1">
										<div class="col">
            								<label class="small font-weight-bold">Material Code*</label>
            								<input type="text" class="form-control form-control-sm" name="materialcode"
            									id="materialcode">
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Unit*</label>
            								<select class="form-control form-control-sm" name="unit" id="unit"
            									required>
            									<option value="">Select</option>
            									<?php foreach($unitlist->result() as $rowunitlist){ ?>
            									<option value="<?php echo $rowunitlist->idtbl_unit ?>">
            										<?php echo $rowunitlist->unitname ?></option>
            									<?php } ?>
            								</select>
            							</div>
            						</div>
									<div class="form-row mb-1">
                                        <div class="col">
            								<label class="small font-weight-bold">Unit per Ctn*</label>
            								<input type="text" class="form-control form-control-sm" name="unitperctn"
            									id="unitperctn">
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Re-order Level*</label>
            								<input type="text" class="form-control form-control-sm" name="reorder"
            									id="reorder">
            							</div>
            						</div>
            						<div class="form-group">
            							<label class="small font-weight-bold">Comment</label>
            							<textarea class="form-control form-control-sm" name="comment"
            								id="comment"></textarea>
            						</div>
            						<div class="form-group mt-2 text-right">
            							<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
            								<?php if($addcheck==0){echo 'disabled';} ?>><i
            									class="far fa-save"></i>&nbsp;Add</button>
            						</div>
            						<input type="hidden" name="recordOption" id="recordOption" value="1">
            						<input type="hidden" name="recordID" id="recordID" value="">
            					</form>
            				</div>
            				<div class="col-8">
            					<div class="scrollbar pb-3" id="style-2">
            						<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
            							<thead>
            								<tr>
            									<th>#</th>
            									<th>Material Name</th>
												<th>Unit</th>
												<th>Unit per Ctn</th>
                                                <th>Category</th>
            									<th>Material Code</th>
            									<th>Re Order</th>
                                                <th>Comment</th>
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
<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
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
                title: 'Material Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Material Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Material Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'csv', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/materialdetaillist.php",
            type: "POST", // you can use GET
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
        		"data": null,
        		"render": function (data, type, full, meta) {
        			return meta.settings._iRecordsDisplay - meta.row;
        		}
        	},
        	{
        		"data": "materialname"
        	},
			{
        		"data": "unitname"
        	},
			{
        		"data": "unitperctn"
        	},
        	{
        		"data": "categoryname"
        	},
        	{
        		"data": "materialinfocode"
        	},
        	{
        		"data": "reorderlevel"
        	},
            {
        		"data": "comment"
        	},
        	{
        		"targets": -1,
        		"className": 'text-right',
        		"data": null,
        		"render": function (data, type, full) {
        			var button = '';
					button+='<button class="btn btn-secondary btn-sm btnSuppliers mr-1" id="'+full['idtbl_material_info']+'"><i class="fas fa-user"></i></button>';
        			button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
        			if (editcheck == 1) {
        				button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Edit" class="btn btn-primary btn-sm btnEdit mr-1" id="' + full['idtbl_material_info'] + '"><i class="fas fa-pen"></i></button>';
        			}
        			if (full['status'] == 1 && statuscheck == 1) {
        				button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Active" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_material_info'] + '/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
        			} else if (full['status'] != 1 && statuscheck == 1) {
        				button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Deactive" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_material_info'] + '/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 btntableaction"><i class="fas fa-times"></i></button>';
        			}

        			if (deletecheck == 1) {
        				button += '<button type="button" data-toggle="tooltip" data-placement="bottom" title="Delete" data-url="Materialdetail/Materialdetailstatus/' + full['idtbl_material_info'] + '/3" data-actiontype="3" class="btn btn-danger btn-sm btntableaction"><i class="fas fa-trash-alt"></i></button>';
        			}

        			return button;
        		}
        	}
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#dataTable tbody').on('click', '.btnEdit', async function () {
        var r = await Otherconfirmation("You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Materialdetail/Materialdetailedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#materialname').val(obj.materialname);
                    $('#materialcategory').val(obj.materialcategory);
                    $('#unitprice').val(obj.unitprice);
					$('#unitperctn').val(obj.unitperctn);
                    $('#materialcode').val(obj.materialcode);
                    $('#reorder').val(obj.reorderlevel);
                    $('#comment').val(obj.comment);
                    $('#supplier').val(obj.supplier);
					$('#unit').val(obj.unit);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });

	$('#dataTable tbody').on('click', '.btnSuppliers', function () {
		var id = $(this).attr('id');
		$('#hidematerialid').val(id);
		$('#lablemodal').modal('show');

		$.ajax({
			type: "POST",
			data: {
				recordID: id
			},
			url: '<?php echo base_url() ?>Goodreceive/Getmateriallistaccogrn',
			success: function (result) { //alert(result);

			}
		});
	});

});

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

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>
<?php include "include/footer.php"; ?>