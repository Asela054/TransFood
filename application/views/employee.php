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
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            <span>Employee</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-5">
                                <form action="<?php echo base_url() ?>Employee/Employeeinsertupdate" method="post" autocomplete="off">
                                <div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Title</label>
                                        <input type="text" class="form-control form-control-sm" name="title" id="title">
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">First Name*</label>
                                        <input type="text" class="form-control form-control-sm" name="fname" id="fname" required>
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Middle Name</label>
                                        <input type="text" class="form-control form-control-sm" name="mname" id="mname" >
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">Last Name</label>
                                        <input type="text" class="form-control form-control-sm" name="lname" id="lname" >
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Designation</label>
                                        <input type="text" class="form-control form-control-sm" name="designation" id="designation">
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">Join Date*</label>
                                        <input type="date" class="form-control form-control-sm" name="joindate" id="joindate" required>
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Mobile</label>
                                        <input type="text" class="form-control form-control-sm" name="contact" id="contact" >
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">Phone</label>
                                        <input type="text" class="form-control form-control-sm" name="contact2" id="contact2">
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Address</label>
                                        <textarea type="text" class="form-control form-control-sm" name="address" id="address"></textarea>
                                		</div>
                                		<div class="col">
                                        <label class="small font-weight-bold">Email</label>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email">
                                		</div>
                                	</div>
                                    <div class="form-group mt-2 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-7">
                            <div class="scrollbar pb-3" id="style-2">
                            	<table class="table table-bordered table-striped table-sm nowrap"
                            		id="employeedataTable">
                            		<thead>
                            			<tr>
                            				<th>#</th>
                            				<th>Title</th>
                            				<th>Name</th>
                                            <th>Join Date</th>
                            				<th>Designation</th>
                            				<th>Mobile</th>
                            				<th>Phone</th>
                            				<th>Email</th>
                            				<th>Address</th>
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
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#employeedataTable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Employee Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Employee Information',
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
                url: "<?php echo base_url() ?>scripts/employeelist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_employee"
                },
                {
                    "data": "title"
                },
                {
                    "data": "fullname"
                },
                {
                    "data": "joindate"
                },
                {
                    "data": "designation"
                },
                {
                    "data": "contact"
                },
                {
                    "data": "contact2"
                },
                {
                    "data": "email"
                },
                {
                    "data": "address"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';

                        if(editcheck==1){
                            button+='<button type="button" class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_employee']+'"><i class="fas fa-pen"></i></button>';
                        }
                        if(full['status']==1 && statuscheck==1){
                            button+='<button type="button" data-url="Employee/Employeestatus/'+full['idtbl_employee']+'/2" data-actiontype="2" class="btn btn-success btn-sm mr-1 btntableaction"><i class="fas fa-check"></i></button>';
                        }else if(full['status']==2 && statuscheck==1){
                            button+='<button type="button" data-url="Employee/Employeestatus/'+full['idtbl_employee']+'/1" data-actiontype="1" class="btn btn-warning btn-sm mr-1 text-light btntableaction"><i class="fas fa-times"></i></button>';
                        }
                        if(deletecheck==1){
                            button+='<button type="button" data-url="Employee/Employeestatus/'+full['idtbl_employee']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
                        }

                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#employeedataTable tbody').on('click', '.btnEdit', async function() {
            var r = await Otherconfirmation("You want to edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Employee/Employeeedit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#title').val(obj.title);                       
                        $('#fname').val(obj.fname);                       
                        $('#mname').val(obj.mname);      
                        $('#lname').val(obj.lname);  
                        $('#empno').val(obj.empno); 
                        $('#joindate').val(obj.joindate);  
                        $('#designation').val(obj.designation);   
                        $('#contact').val(obj.contact);                       
                        $('#contact2').val(obj.contact2);      
                        $('#email').val(obj.email);   
                        $('#address').val(obj.address);                  

                        $('#recordOption').val('2');
                        $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                    }
                });
            }
        });
    });
</script>
<?php include "include/footer.php"; ?>
