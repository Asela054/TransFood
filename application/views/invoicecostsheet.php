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
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                                    <span>Invoice Cost Sheet</span>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body">

            			<div class="row">
            				<div class="col-12">
            					<form id="searchReport">
            						<div class="form-row">
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">Customer*</label>
                                            <select class="form-control form-control-sm" name="costcustomer" id="costcustomer" required>
                                                <option value="">Select</option>
                                            </select>
            							</div>
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">Sales Order*</label>
                                            <select class="form-control form-control-sm" name="costsalesorder" id="costsalesorder" required>
                                                <option value="">Select</option>
                                            </select>
            							</div>
            							<div class="col-1">
            								<label class="small font-weight-bold text-dark">Markup*</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control form-control-sm" name="costmarkup" id="costmarkup" min="0" max="100" step="0.01" placeholder="0.00" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">%</span>
                                                </div>
                                            </div>
            							</div>
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">Conversion Rate*</label>
                                            <input type="text" class="form-control form-control-sm" name="costconversionrate" id="costconversionrate" required>
            							</div>
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">&nbsp;</label><br>
            								<button type="button" class="btn btn-primary btn-sm px-3" id="costsearch"><i class="fas fa-search mr-2"></i>Check Cost</button>
            							</div>
            						</div>
                                    <input type="submit" class="d-none" id="hidesubmit">
            					</form>
            				</div>
                            <div class="col-12 text-right"> 
                                <button type="button" id="btnconvert" class="btn btn-success btn-sm px-4 mb-3" disabled><i class="fas fa-file-excel mr-2"></i>EXCEL</button>  
                            </div>
            				<div class="col-12">
            					<hr class="border-dark">
            					<div class="scrollbar pb-3" id="style-2">
            						<div id="viewinfo"></div>
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


<script type="text/javascript">
    $(document).ready(function () {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        $('#costcustomer').select2({
            // placeholder: 'Select Customer',
            width: 'resolve',
            ajax: {
                url: '<?php echo base_url()."Invoicecostsheet/Getcustomerelist" ?>',
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
        $('#costcustomer').change(function(){
            $('#costsalesorder').val(null).trigger('change');
        });
        $('#costsalesorder').select2({
            // placeholder: 'Select Customer',
            width: 'resolve',
            ajax: {
                url: '<?php echo base_url()."Invoicecostsheet/Getsalesorder" ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                        customerid: $('#costcustomer').val()
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
        $('#costsearch').click(function(){
            $('#seperateamount').attr('type', 'number');
            if (!$("#searchReport")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#hidesubmit").click();
            } else {
                var customerud = $('#costcustomer').val();
                var salesorderid =  $('#costsalesorder').val();
                var costmarkup =  $('#costmarkup').val();
                var costconversionrate =  $('#costconversionrate').val();

                Swal.fire({
                    title: '',
                    html: '<div class="div-spinner"><div class="custom-loader"></div></div>',
                    allowOutsideClick: false,
                    showConfirmButton: false, // Hide the OK button
                    backdrop: `
                        rgba(255, 255, 255, 0.5) 
                    `,
                    customClass: {
                        popup: 'fullscreen-swal'
                    },
                    didOpen: () => {
                        document.body.style.overflow = 'hidden';

                        $.ajax({
                            type: "POST",
                            data: {
                                customerud: customerud,
                                salesorderid: salesorderid,
                                costmarkup: costmarkup,
                                costconversionrate: costconversionrate
                            },
                            url: 'Invoicecostsheet/Getcostcountinfo',
                            success: function (result) { //alert(result);
                                // console.log(result);
                                Swal.close();
                                $('#viewinfo').html(result);	
                                $('#btnconvert').prop('disabled', false);
                            },
                            error: function(error) {
                                // Close the SweetAlert on error
                                Swal.close();
                                
                                // Show an error alert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again later.'
                                });
                            }
                        });

                        document.body.style.overflow = 'visible';
                    }
                });
            }
        });
        $('#btnconvert').click(function() {
            var table_html = $('#table_content').html();
            
            // Create a temporary form to post the data
            var form = $('<form action="Invoicecostsheet/Exporttoexcel" method="post"></form>');
            form.append($('<input type="hidden" name="table_data">').val(table_html));
            $('body').append(form);
            form.submit();
            form.remove();
        });
    });
</script>