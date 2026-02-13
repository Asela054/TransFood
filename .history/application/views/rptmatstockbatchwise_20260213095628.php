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
                                    <div class="page-header-icon"><i class="fas fa-cart-arrow-down"></i></div>
                                    <span>Material Stock Batch Wise Info</span>
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
                                <div class="row">
                                    <div class="col-2">
                                        <div class="custom-control custom-checkbox mt-4">
                                            <input class="custom-control-input" type="checkbox" value="1" id="hide" name="hide">
                                            <label class="custom-control-label" for="hide">Hide Values</label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-dark">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-striped table-bordered table-sm nowrap" id="matstockTable"
                                        style="width:100%">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>BATCH NO.</th>
                                                <th>MATERIAL</th>
                                                <th>QUANTITY</th>
                                                <th>UNIT PRICE</th>
                                                <th>AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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


<script type="text/javascript">
    let today = new Date().toISOString().slice(0, 10)


    $(document).ready(function () {
    	const table = $('#matstockTable').DataTable({
    		"destroy": true,
    		"processing": true,
    		"serverSide": true,
    		ajax: {
    			url: "scripts/rptmatstocklist.php",
    			type: "POST",
    		},
    		"order": [
    			[0, "desc"]
    		],
    		"columns": [{
    				"data": "idtbl_stock"
    			},
    			{
    				"data": "batchno"
    			},
    			{
    				"data": "materialname"
    			},
				{
					"data": "qty",
					"render": function (data, type, row, meta) {
						return Number(parseFloat(data).toFixed(5));
					}
				},
{
    "data": null,
    "className": 'text-right',
    "render": function (data, type, full) {

        let currency = '';
        if (full['currencytype'] == 1) {
            currency = 'Rs. ';
        } else if (full['currencytype'] == 2) {
            currency = '$ ';
        }

        let unitprice = parseFloat(full['unitprice']) || 0;

        return currency + addCommas(unitprice.toFixed(2));
    }
},
{
    "data": null,
    "className": 'text-right',
    "render": function (data, type, full) {

        let currency = '';
        if (full['currencytype'] == 1) {
            currency = 'Rs. ';
        } else if (full['currencytype'] == 2) {
            currency = '$ ';
        }

        let qty = parseFloat(full['qty']) || 0;
        let unitprice = parseFloat(full['unitprice']) || 0;
        let amount = qty * unitprice;

        return currency + addCommas(amount.toFixed(2));
    }
}
    		],
    		dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    		responsive: true,
    		lengthMenu: [
    			[10, 25, 50, -1],
    			[10, 25, 50, 'All'],
    		],
    		buttons: [{
    				extend: 'csv',
    				className: 'btn btn-success btn-sm',
    				filename: 'Material Stock Report' + today,
    				text: '<i class="fas fa-file-csv mr-2"></i> CSV',
    				footer: true,
    				title: 'Unistar International',
    				messageTop: 'Stock Report'
    			},
    			{
    				extend: 'excel',
    				className: 'btn btn-info btn-sm',
    				filename: 'Material Stock Report' + today,
    				text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
    				footer: true,
    				title: 'Unistar International',
    				messageTop: 'Material Stock Report'
    			},
    			{
    				extend: 'pdf',
    				className: 'btn btn-danger btn-sm',
    				filename: 'Material Stock Report' + today,
    				text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
    				footer: true,
    				title: 'Unistar International',
    				messageTop: {
    					text: 'Material Stock Report',
    					fontSize: 20,
    					bold: true,
    					alignment: 'center'
    				},
    				customize: function (doc) {
    					doc.styles.title = {
    						bold: 60,
    						color: '#2F5233',
    						fontSize: '30',
    						alignment: 'center',
    					}
    				}
    			},
    			{
    				extend: 'print',
    				className: 'btn btn-primary btn-sm',
    				filename: 'Material Stock Report' + today,
    				text: '<i class="fas fa-print mr-2"></i> PRINT',
    				footer: true,
    				title: 'Unistar International',
    				messageTop: 'Material Stock Report',
    				customize: function (doc) {
    					doc.styles.title = {
    						color: 'black',
    						fontSize: '30',
    						alignment: 'center',
    					}
    				}
    			}
    		],
    		drawCallback: function (settings) {
    			$('[data-toggle="tooltip"]').tooltip();
    		}
    	});

        $('#hide').on('change', function () {
            const hideColumns = $(this).is(':checked');
            table.columns([4, 5]).visible(!hideColumns);
        });
    });


    function addCommas(nStr){
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