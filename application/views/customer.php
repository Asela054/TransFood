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
                            <span>Customers</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-5">
                                <form action="<?php echo base_url() ?>Customer/Customerinsertupdate" method="post"
                                	autocomplete="off">
                                	<div class="form-row mb-1">
                                		<div class="col">
                                			<label class="small font-weight-bold">Customer Name*</label>
                                			<input type="text" class="form-control form-control-sm" name="name"
                                				id="name" required>
                                		</div>
                                		<div class="col">
                                			<label class="small font-weight-bold">Customer Code*</label>
                                			<input type="text" class="form-control form-control-sm" name="code"
                                				id="code" required>
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                			<label class="small font-weight-bold">Customer Type*</label>
                                			<select class="form-control form-control-sm" name="type" id="type" required>
                                				<option value="">Select</option>
                                				<option value="1">Local</option>
                                				<option value="2">Export</option>
                                			</select>
                                            </div>
                                			<div class="col">
                                            <label class="small font-weight-bold">Address</label>
                                			<textarea type="text" class="form-control form-control-sm" name="address"
                                				id="address"></textarea>
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                        <label class="small font-weight-bold">Mobile</label>
                                				<input type="tel" class="form-control form-control-sm" name="contact"
                                					id="contact" pattern="[0-9]{12}">
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
                                		<div class="col" style="display: none" id="gstin">
                                			<label class="small font-weight-bold">GSTIN No.</label>
                                			<input type="text" class="form-control form-control-sm" name="gstinno"
                                				id="gstinno">
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col" style="display: none" id="pan">
                                			<label class="small font-weight-bold">PAN No.</label>
                                			<input type="text" class="form-control form-control-sm" name="panno"
                                				id="panno">
                                		</div>
                                		<div class="col" style="display: none" id="iec">
                                			<label class="small font-weight-bold">IEC Code</label>
                                			<input type="text" class="form-control form-control-sm" name="ieccode"
                                				id="ieccode">
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col-6" style="display: none" id="fssai">
                                			<label class="small font-weight-bold">FSSAI No.</label>
                                			<input type="text" class="form-control form-control-sm" name="fssaino"
                                				id="fssaino">
                                		</div>
                                	</div><br>
                                	<h6 class="large title-style"><span>Bank Details</span></h6><br>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                			<label class="small font-weight-bold">Bank Name</label>
                                			<input type="text" class="form-control form-control-sm" name="bank"
                                				id="bank">
                                		</div>
                                		<div class="col">
                                			<label class="small font-weight-bold">Branch</label>
                                			<input type="text" class="form-control form-control-sm" name="branch"
                                				id="branch">
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col">
                                			<label class="small font-weight-bold">Account Number</label>
                                			<input type="text" class="form-control form-control-sm" name="accountnum"
                                				id="accountnum">
                                		</div>
                                		<div class="col">
                                			<label class="small font-weight-bold">Account Name</label>
                                			<input type="text" class="form-control form-control-sm" name="account"
                                				id="account">
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col-6">
                                			<label class="small font-weight-bold">Bank Address</label>
                                			<input type="text" class="form-control form-control-sm" name="bankaddress"
                                				id="bankaddress">
                                		</div>
                                		<div class="col" style="display: none" id="swift">
                                			<label class="small font-weight-bold">Swift Code</label>
                                			<input type="text" class="form-control form-control-sm" name="swiftcode"
                                				id="swiftcode">
                                		</div>
                                	</div>
                                	<div class="form-row mb-1">
                                		<div class="col-6" style="display: none" id="ifsc">
                                			<label class="small font-weight-bold">IFSC No</label>
                                			<input type="text" class="form-control form-control-sm" name="ifscno"
                                				id="ifscno">
                                		</div>
                                        <div class="col" style="display: none" id="intemediary">
                                			<label class="small font-weight-bold">Intemediary Bank</label>
                                			<input type="text" class="form-control form-control-sm" name="intemediarybank"
                                				id="intemediarybank">
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col-6" style="display: none" id="inteswift">
                                			<label class="small font-weight-bold">Intemediary Swift Code</label>
                                			<input type="text" class="form-control form-control-sm" name="inteswiftcode"
                                				id="inteswiftcode">
                                		</div>
                                        <div class="col" style="display: none" id="accountinst">
                                			<label class="small font-weight-bold">Account with Institution</label>
                                			<input type="text" class="form-control form-control-sm" name="accountinstitution"
                                				id="accountinstitution">
                                		</div>
                                	</div>
                                    <div class="form-row mb-1">
                                		<div class="col-6" style="display: none" id="insswift">
                                			<label class="small font-weight-bold">Institution Swift Code</label>
                                			<input type="text" class="form-control form-control-sm" name="insswiftcode"
                                				id="insswiftcode">
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
                            		id="customerdataTable">
                            		<thead>
                            			<tr>
                            				<th>#</th>
                            				<th>Customer</th>
                                            <th>Customer Code</th>
                            				<th>Customer Type</th>
                            				<th>Mobile</th>
                            				<th>Phone</th>
                            				<th>Email</th>
                            				<th>Address</th>
                                            <th>GSTIN No.</th>
                            				<th>PAN No.</th>
                            				<th>IEC Code</th>
                            				<th>FSSAI No.</th>
                                            <th>Bank Name</th>
                                            <th>Branch</th>
                                            <th>Account No.</th>
                                            <th>Account Name</th>
                                            <th>Bank Address</th>
                                            <th>Swift Code</th>
                                            <th>IFSC No.</th>
                                            <th>Intemediary Bank</th>
                                            <th>Intemediary Swift Code</th>
                                            <th>Account with Institution</th>
                                            <th>Institution Swift Code</th>
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

    function field_display(){
 if ($("#type").val() == 1) {
                $("#gstin").hide();
                $("#pan").hide();
                $("#iec").hide();
                $("#fssai").hide();
                $("#swift").hide();
                $("#ifsc").hide();
                $("#intemediary").hide();
                $("#inteswift").hide();
                $("#accountinst").hide();
                $("#insswift").hide();
            } else if ($("#type").val() == 2) {
                $("#gstin").show();
                $("#pan").show();
                $("#iec").show();
                $("#fssai").show();
                $("#swift").show();
                $("#ifsc").show();
                $("#intemediary").show();
                $("#inteswift").show();
                $("#accountinst").show();
                $("#insswift").show();
            }
    }
        $("#type").change(function () {
            field_display();
        });

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#customerdataTable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Customer Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Customer Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Customer Information',
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
                url: "<?php echo base_url() ?>scripts/customerlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": "idtbl_customer"
                },
                {
                    "data": "name"
                },
                {
                    "data": "customercode"
                },
                {
                    "data": "ds"
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
                    "data": "gstinno"
                },
                {
                    "data": "panno"
                },
                {
                    "data": "ieccode"
                },
                {
                    "data": "fssaino"
                },
                {
                    "data": "bankname"
                },
                {
                    "data": "bankbranch"
                },
                {
                    "data": "accountno"
                },
                {
                    "data": "accountname"
                },
                {
                    "data": "bankaddress"
                },
                {
                    "data": "swiftcode"
                },
                {
                    "data": "ifscno"
                },
                {
                    "data": "intemediarybank"
                },
                {
                    "data": "inteswiftcode"
                },
                {
                    "data": "accountinstitution"
                },
                {
                    "data": "insswiftcode"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        button+='<button class="btn btn-primary btn-sm btnEdit mr-1 ';if(editcheck!=1){button+='d-none';}button+='" id="'+full['idtbl_customer']+'"><i class="fas fa-pen"></i></button>';
                        if(full['status']==1){
                            button+='<a href="<?php echo base_url() ?>Customer/Customerstatus/'+full['idtbl_customer']+'/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-check"></i></a>';
                        }else{
                            button+='<a href="<?php echo base_url() ?>Customer/Customerstatus/'+full['idtbl_customer']+'/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-times"></i></a>';
                        }
                        button+='<a href="<?php echo base_url() ?>Customer/Customerstatus/'+full['idtbl_customer']+'/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';if(deletecheck!=1){button+='d-none';}button+='"><i class="fas fa-trash-alt"></i></a>';
                        
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#customerdataTable tbody').on('click', '.btnEdit', function() {
            var r = confirm("Are you sure, You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Customer/Customeredit',
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#recordID').val(obj.id);
                        $('#name').val(obj.name);   
                        $('#code').val(obj.code);   
                        $('#type').val(obj.type);                       
                        $('#contact').val(obj.contact);                       
                        $('#contact2').val(obj.contact2);      
                        $('#email').val(obj.email);   
                        $('#address').val(obj.address);   
                        $('#gstinno').val(obj.gstinno);                     
                        $('#panno').val(obj.panno);      
                        $('#ieccode').val(obj.ieccode);   
                        $('#fssaino').val(obj.fssaino);  
                        $('#bank').val(obj.bank);                       
                        $('#branch').val(obj.branch);      
                        $('#accountnum').val(obj.accountnum);   
                        $('#account').val(obj.account);  
                        $('#bankaddress').val(obj.bankaddress);      
                        $('#swiftcode').val(obj.swiftcode);   
                        $('#ifscno').val(obj.ifscno); 
                        $('#intemediarybank').val(obj.intemediarybank);  
                        $('#inteswiftcode').val(obj.inteswiftcode);      
                        $('#accountinstitution').val(obj.accountinstitution);   
                        $('#insswiftcode').val(obj.insswiftcode);  
                        field_display();

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
