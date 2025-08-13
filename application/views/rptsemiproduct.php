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
                                    <div class="page-header-icon"><i class="fas fa-briefcase"></i></div>
                                    <span>Semi Product Info</span>
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
                                <hr class="border-dark">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-striped table-bordered table-sm nowrap" id="semiproducttable"
                                        style="width:100%">
                                        <thead class="table-warning">
                                        <tr>
                                        <th>#</th>
                                                <th>Material Name</th>
                                                <th>Code</th>
                                                <th>Material Code</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Form</th>
                                                <th>Grade</th>
                                                <th>Size</th>
                                                <th>Side</th>
                                                <th>Unit Type</th>
                                                <th>Unit</th>
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
        $('#semiproducttable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            ajax: {
                url: "scripts/rptsemiproductlist.php",
                type: "POST", // you can use GET
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [ {
                    "data": "idtbl_material_info"
                },
                {
                    "data": "materialname"
                },
                {
                    "data": "materialinfocode"
                },
                {
                    "data": "materialcode"
                },
                {
                    "data": "categoryname"
                },
                {
                    "data": "brandcode"
                },
                {
                    "data": "formcode"
                },
                {
                    "data": "gradecode"
                },
                {
                    "data": "sizecode"
                },
                {
                    "data": "sidecode"
                },
                {
                    "data": "unittypecode"
                },
                {
                    "data": "unitcode"
                }

            ],

            dom: "<'row'<'col-sm-4'B><'col-sm-3'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            buttons: [
                {
                    extend: 'csv',
                    className: 'btn btn-success btn-sm',
                    filename: 'Finish Good Stock Report' + today,
                    text: '<i class="fas fa-file-csv mr-2"></i> CSV',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Stock Report'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-info btn-sm',
                    filename: 'Finish Good Stock Report' + today,
                    text: '<i class="fas fa-file-excel mr-2"></i> EXCEL',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Finish Good Stock Report'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-danger btn-sm',
                    filename: 'Finish Good Stock Report' + today,
                    text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: {
                        text: 'Finish Good Stock Report',
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
                    filename: 'Finish Good Stock Report' + today,
                    text: '<i class="fas fa-print mr-2"></i> PRINT',
                    footer: true,
                    title: 'Unistar International',
                    messageTop: 'Finish Good Stock Report',
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
    });
</script>

<?php include "include/footer.php"; ?>