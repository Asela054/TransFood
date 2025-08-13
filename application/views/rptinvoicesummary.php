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
                            <div class="page-header-icon"><i class="fas fa-file-invoice"></i></div>
                            <span>Invoice Summary</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold">Invoice No.*</label>
                                    <select type="text" class="form-control form-control-sm" name="invoicelist" id="invoicelist" required>
                                    <option value="" selected>Select</option>
                                    <?php foreach ($invoicelist->result() as $rowinvoicelist) { ?>
                                        <option value="<?php echo $rowinvoicelist->idtbl_invoice ?>">
                                        <?php echo 'INV/DT-0000'.$rowinvoicelist->idtbl_invoice ?>
                                        </option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <br>
                                <button onclick="print()" type="button" id="formsubmit" class="btn btn-primary btn-sm ml-3 mt-2 px-4 text-right">
                                    <i class="fas fa-save"></i>&nbsp;Print
                                </button>
                            </div>
                        </div>
                        <hr>
                        <div class="scrollbar pb-3" id="style-2">
                            <div id="viewhtml"></div>
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
$(document).ready(function () {

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        // $('#invoicelist').select2();

        $('#invoicelist').change(function () {
        	var invoiceid = $('#invoicelist').val();
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: invoiceid
        		},
        		url: '<?php echo base_url() ?>Rptinvoicesummary/Getinvoicedetail',
        		success: function (result) { //alert(result);
        			$('#viewhtml').html(result);
        		}
        	});
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

    function print() {
        printJS({
            printable: 'viewhtml',
            type: 'html',
            style: '@page { size: A4 landscape; margin:0.25cm;}',
            targetStyles: ['*']
        })
    }
</script>
<?php include "include/footer.php"; ?>
