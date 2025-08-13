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
                                    <div class="page-header-icon"><i class="fas fa-credit-card"></i></div>
                                    <span>Sales Order Info</span>
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
                                            <label class="small font-weight-bold text-dark">Report Type*</label>
                                            <div class="input-group input-group-sm">
                                                <select class="form-control form-control-sm" name="report_type"
                                                    id="report_type">
                                                    <option value="0">Select</option>
                                                    <option value="1">Daily</option>
                                                    <option value="2">Weekly</option>
                                                    <option value="3">Monthly</option>
                                                    <option value="4">Date Range</option>
                                                    <option value="5">All Sales Orders</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-2" style="display: none" id="select_date">
                                            <label class="small font-weight-bold text-dark"> Date*</label>
                                            <input type="date" class="form-control form-control-sm " placeholder=""
                                                name="date" id="date">
                                        </div>

                                        <div class="col-2" style="display: none" id="select_week">
                                            <label class="small font-weight-bold text-dark"> Week*</label>
                                            <input type="week" class="form-control form-control-sm" placeholder=""
                                                name="week" id="week">
                                        </div>
                                        <div class="col-2" style="display: none" id="select_month">
                                            <label class="small font-weight-bold text-dark"> Month*</label>
                                            <input type="month" class="form-control form-control-sm" placeholder=""
                                                name="month" id="month">
                                        </div>
                                        &nbsp;
                                        <div class="col-2" style="display: none" id="select_from">
                                            <label class="small font-weight-bold text-dark"> From*</label>
                                            <input type="date" class="form-control form-control-sm" placeholder=""
                                                name="date_from" id="date_from">
                                        </div>
                                        &nbsp;
                                        <div class="col-2" style="display: none" id="select_to">
                                            <label class="small font-weight-bold text-dark"> To*</label>
                                            <input type="date" class="form-control form-control-sm" placeholder=""
                                                name="date_to" id="date_to">
                                        </div>
                                        <div class="col-2" style="display: none;" id="hidesumbit">&nbsp;<br>
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm ml-auto w-25 mt-2 px-5">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12">
                                <hr class="border-dark">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-striped table-bordered table-sm nowrap" id="POTable"
                                        style="width:100%">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>CUSTOMER</th>
                                                <th>ORDER TYPE</th>
                                                <th>Product</th>
                                                <th>ORDER DATE</th>
                                                <th>STATUS</th>
                                                <th>DUE DATE</th>
                                                <th>SUB TOTAL</th>
                                                <th>DISCOUNT</th>
                                                <th>DISCOUNT AMOUNT</th>
                                                <th>NET TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="text-right"></th>
                                                <th class="text-center">Total:</th>
                                                <th class="text-left"></th>
                                                <th class="text-left"></th>
                                                <th class="text-left"></th>
                                                <th class="text-left"></th>
                                            </tr>
                                        </tfoot>
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

    $(function () {
        $("#report_type").change(function () {
            if ($(this).val() == 1) {
                $("#select_date").show();
                $("#hidesumbit").show();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 2) {
                $("#select_week").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 3) {
                $("#select_month").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_from").hide();
                $("#select_to").hide();
            } else if ($(this).val() == 4) {
                $("#select_from").show();
                $("#select_to").show();
                $("#hidesumbit").show();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
            } else if ($(this).val() == 5) {
                $("#hidesumbit").show();
            } else {
                $("#inv_type").hide();
                $("#select_date").hide();
                $("#select_week").hide();
                $("#select_month").hide();
                $("#select_from").hide();
                $("#select_to").hide();
                $("#hidesumbit").hide();
            }
        });
    });


    $(document).ready(function () {


        $("#searchReport").submit(function (event) {
            event.preventDefault();

            $('#POTable').DataTable({
                "destroy": true,
                "processing": true,
                "serverSide": true,
                ajax: {
                    url: "scripts/rptsalesorderlist.php",
                    type: "POST", // you can use GET
                    "data": function (d) {
                        return $.extend({}, d, {
                            "search_date": $("#date").val(),
                            "search_week": $("#week").val(),
                            "search_month": $("#month").val(),
                            "search_from_date": $("#date_from").val(),
                            "search_to_date": $("#date_to").val(),
                            "report_type": "5"
                        });
                    }
                },
                "order": [
                    [0, "desc"]
                ],
                "columns": [{
                        "data": "idtbl_customer_porder"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "productcode"
                    },
                    {
                        "data": "orderdate"
                    },
                    {
                        "data": "ds"
                    },
                    {
                        "data": "duedate"
                    },
                    {
                        "targets": -1,
                        "className": 'text-right',
                        "data": 'subtotal',
                        "render": function(data, type, full) {
                            return addCommas(parseFloat(data).toFixed(2));
                        }
                    },
                    {
                        "data": "discount"
                    },
                    {
                        "data": "discountamount"
                    },
                    {
                        "targets": -1,
                        "className": 'text-right',
                        "data": 'nettotal',
                        "render": function(data, type, full) {
                            return addCommas(parseFloat(data).toFixed(2));
                        }
                    },

                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'All'],
                ],
                dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                responsive: true,
                buttons: [
                    {
                        extend: 'csv',
                        className: 'btn btn-success btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-info btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report'
                    },
                    {
                        extend: 'pdf',
                        pageSize: 'A3',
                        className: 'btn btn-danger btn-sm',
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: {
                            text: 'Sales Order Report',
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
                        filename: 'Sales Order Report' + today,
                        text: '<i class="fas fa-print mr-2"></i> PRINT',
                        footer: true,
                        title: 'Unistar International',
                        messageTop: 'Sales Order Report',
                        customize: function (doc) {
                            doc.styles.title = {
                                color: 'black',
                                fontSize: '30',
                                alignment: 'center',
                            }
                        }
                    }
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(7)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(7, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function (a, b) {
                            return parseFloat(intVal(a) + intVal(b)).toFixed(2);
                        }, 0);

                    // Update footer
                    $(api.column(7).footer()).html(
                        // pageTotal=parseFloat(pageTotal).toFixed(2);
                        'Rs. ' + addCommas(parseFloat(pageTotal).toFixed(2))
                    );

                    total = api
                        .column(10)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Total over this page
                    pageTotal = api
                        .column(10, {
                            page: 'current'
                        })
                        .data()
                        .reduce(function (a, b) {
                            return parseFloat(intVal(a) + intVal(b)).toFixed(2);
                        }, 0);

                    // Update footer
                    $(api.column(10).footer()).html(
                        // pageTotal=parseFloat(pageTotal).toFixed(2);
                        'Rs. ' + addCommas(parseFloat(pageTotal).toFixed(2))
                    );
                }
            });



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