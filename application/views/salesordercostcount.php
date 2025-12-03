<?php 
include "include/header.php"; 

include "include/topnavbar.php"; 
?>

<style>
    content-display {
        display: none;
    }
</style>


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
                                    <span>Sales Order Cost Count</span>
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
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">Finish Good*</label>
                                            <select class="form-control form-control-sm" name="costfinishgood" id="costfinishgood" required>
                                                <option value="">Select</option>
                                            </select>
            							</div>
            							<div class="col-2">
            								<label class="small font-weight-bold text-dark">BOM*</label>
                                            <select class="form-control form-control-sm" name="costbom" id="costbom" required>
                                                <option value="">Select</option>
                                            </select>
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
                                <button type="button" id="btnpdfconvert" class="btn btn-danger btn-sm px-4 mb-3" disabled><i class="fas fa-file-pdf mr-2"></i>PDF</button>  
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
                url: '<?php echo base_url()."Salesordercostcount/Getcustomerelist" ?>',
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
            $('#costfinishgood').val(null).trigger('change');
            $('#costbom').val(null).trigger('change');
        });
        $('#costsalesorder').select2({
            // placeholder: 'Select Customer',
            width: 'resolve',
            ajax: {
                url: '<?php echo base_url()."Salesordercostcount/Getsalesorder" ?>',
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
        $('#costsalesorder').change(function(){
            $('#costfinishgood').val(null).trigger('change');
            $('#costbom').val(null).trigger('change');
        });
        $('#costfinishgood').select2({
            // placeholder: 'Select Customer',
            width: 'resolve',
            ajax: {
                url: '<?php echo base_url()."Salesordercostcount/Getfglistaccosalesorder" ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                        salesorderid: $('#costsalesorder').val()
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
        $('#costfinishgood').change(function(){
            $('#costbom').val(null).trigger('change');
        });
        $('#costbom').select2({
            // placeholder: 'Select Customer',
            width: 'resolve',
            ajax: {
                url: '<?php echo base_url()."Salesordercostcount/Getbomlist" ?>',
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term, // search term
                        finishgoodid: $('#costfinishgood').val()
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
                var finishgoodid =  $('#costfinishgood').val();
                var bomid =  $('#costbom').val();

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
                                finishgoodid: finishgoodid,
                                bomid: bomid
                            },
                            url: 'Salesordercostcount/Getcostcountinfo',
                            success: function (result) { //alert(result);
                                // console.log(result);
                                Swal.close();
                                $('#viewinfo').html(result);	
                                $('#btnpdfconvert').prop('disabled', false);
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

        $('#btnpdfconvert').click(function(){
            var { jsPDF } = window.jspdf;
            var doc = new jsPDF('l', 'pt', 'legal');
            var title = 'Trans Food Lanka Sales Order Cost Sheet';
            doc.setFontSize(12);
            doc.text(title, 40, 30);

            // Define table content
            var table = document.getElementById("table_content");
            var rows = [];

            for (var i = 0, row; row = table.rows[i]; i++) {
                var rowData = [];
                for (var j = 0, col; col = row.cells[j]; j++) {
                    if(j<10){
                        rowData.push(col.innerText);
                        if(col.innerText=='Total Cost'){
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                            rowData.push('');
                        }
                    }
                }
                rows.push(rowData);
            }

            var head = [rows[0]];
            var data = rows.slice(1);

            doc.autoTable({
                head: head,
                body: data,
                startY: 40,
                theme: 'grid',
                headStyles: { fillColor: [41, 128, 185], fontSize: 8, halign: 'left' }, 
                styles: { cellPadding: 5, halign: 'left', fontSize: 8 }, 
                columnStyles: {
                    8: { halign: 'right' }, 
                    9: { halign: 'right' }, 
                }
            });

            doc.save("salesordercostcount.pdf");
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
</script>

<?php include "include/footer.php"; ?>