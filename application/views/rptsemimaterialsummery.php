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
                            <span>Semi Summery Report</span>
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
                                    <label class="small font-weight-bold">Finish Good*</label>
                                    <select type="text" class="form-control form-control-sm" name="semimaterial" id="semimaterial" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group mb-1">
                                    <label class="small font-weight-bold">Batch no*</label>
                                    <select type="text" class="form-control form-control-sm" name="batchno" id="batchno" required>
                                        <option value="">Select</option>
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
                        <div id="viewhtml"></div>
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

        $("#semimaterial").select2({
            // dropdownParent: $('#staticBackdrop'),
            // placeholder: 'Select supplier',
            ajax: {
                url: "<?php echo base_url() ?>Rptsemimaterialsummery/Getsemimateriallist",
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

        $('#semimaterial').change(function () {
        	var fgid = $(this).val();
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: fgid
        		},
        		url: '<?php echo base_url() ?>Rptsemimaterialsummery/Getbatchnolist',
        		success: function (result) { //alert(result);
        			var obj = JSON.parse(result);
                    var html = '';
                    html += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html += '<option value="' + obj[i].batchno + '">';
                        html += obj[i].batchno;
                        html += '</option>';
                    });
                    $('#batchno').empty().append(html);
        		}
        	});
        });

        $('#batchno').change(function () {
            var fgid = $('#semimaterial').val();
            var batchno = $(this).val();

        	$.ajax({
        		type: "POST",
        		data: {
        			fgid: fgid,
        			batchno: batchno
        		},
        		url: '<?php echo base_url() ?>Rptsemimaterialsummery/Getsummeryreport',
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
