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
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-building"></i></div>
                            <span>Company Branch</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-5">
                                <form action="<?php echo base_url() ?>Companybranch/Companybranchinsertupdate" method="post"
                                	autocomplete="off">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Company*</label>
                                        <select class="form-control form-control-sm" name="company" id="company" required>
                                            <option value="">Select</option>
                                            <?php foreach($company->result() as $rowcompany){ ?>
                                            <option value="<?php echo $rowcompany->idtbl_company ?>"><?php echo $rowcompany->company.'-'.$rowcompany->code ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                			<label class="small font-weight-bold">Branch Name*</label>
                                			<input type="text" class="form-control form-control-sm" name="name"
                                				id="name" required>
                                		</div>
                                		<div class="col">
                                			<label class="small font-weight-bold">Branch Code*</label>
                                			<input type="text" class="form-control form-control-sm" name="code"
                                				id="code" required>
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                			<div class="col">
                                            <label class="small font-weight-bold">Address 1*</label>
                                			<textarea type="text" class="form-control form-control-sm" name="address1"
                                				id="address1" required></textarea>
                                		</div>
                                        <div class="col">
                                            <label class="small font-weight-bold">Address 2</label>
                                			<textarea type="text" class="form-control form-control-sm" name="address2"
                                				id="address2"></textarea>
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Mobile*</label>
                                				<input type="tel" class="form-control form-control-sm" name="contact"
                                					id="contact" pattern="[0-9]{12}" required>
                                                    <small class="text-danger font-weight-bold">Please Match the Format (094 771 234 567)</small>
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">Phone</label>
                                			<input type="tel" class="form-control form-control-sm" name="contact2"
                                				id="contact2" pattern="[0-9]{12}">
                                                <small class="text-danger font-weight-bold">Please Match the Format (094 771 234 567)</small>
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col-6">
                                        <label class="small font-weight-bold">Email</label>
                                			<input type="text" class="form-control form-control-sm" name="email"
                                				id="email">
                                		</div>
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
                            <div class="col-7">
                            <div class="scrollbar pb-3" id="style-2">
                            	<table class="table table-bordered table-striped table-sm nowrap"
                            		id="branchdataTable">
                            		<thead>
                            			<tr>
                            				<th>#</th>
                                            <th>Company</th>
                            				<th>Branch</th>
                                            <th>Branch Code</th>
                            				<th>Mobile</th>
                            				<th>Phone</th>
                            				<th>Email</th>
                            				<th>Address 1</th>
                                            <th>Address 2</th>
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

$(function () {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#branchdataTable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Branch Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Branch Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Branch Information',
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
                url: "<?php echo base_url() ?>scripts/companybranchlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_company_branch"
                },
                {
                    "data": "company"
                },
                {
                    "data": "branch"
                },
                {
                    "data": "code"
                },
                {
                    "data": "address1"
                },
                {
                    "data": "address2"
                },
                {
                    "data": "mobile"
                },
                {
                    "data": "phone"
                },
                {
                    "data": "email"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_company_branch']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Companybranch/Companybranchstatus/'+full['idtbl_company_branch']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Companybranch/Companybranchstatus/'+full['idtbl_company_branch']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Companybranch/Companybranchstatus/'+full['idtbl_company_branch']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#branchdataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Companybranch/Companybranchedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#name').val(obj.name);   
                        $('#company').val(obj.company);   
                        $('#code').val(obj.code);   
                        $('#contact').val(obj.contact);                       
                        $('#contact2').val(obj.contact2);      
                        $('#email').val(obj.email);   
                        $('#address1').val(obj.address1);   
                        $('#address2').val(obj.address2);   

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
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
</script>
<?php include "include/footer.php"; ?>
