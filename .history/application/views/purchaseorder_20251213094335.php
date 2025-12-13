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
                            <div class="page-header-icon"><i class="fas fa-truck"></i></div>
                            <span>Purchase Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Purchase Order</button>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PO No.</th>
                                                <th>Class</th>
                                                <th>PO Date</th>
                                                <th>Total</th>
                                                <th>Confirm Status</th>
                                                <th>GRN Issue Status</th>
                                                <th>Notes and Instructions</th>
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
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                        <form id="createorderform" autocomplete="off">
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Currency Type*</label>
                                    <select class="form-control form-control-sm" name="currencytype" id="currencytype" required>
                                        <option value="">Select</option>
                                        <option value="1">LKR</option>
                                        <option value="2">USD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Purchase Order Type*</label>
                                    <select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
                                        <option value="">Select</option>
                                        <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                        <option value="<?php echo $rowordertypelist->idtbl_order_type ?>"><?php echo $rowordertypelist->type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Class</label>
                                    <input type="text" id="poclass" name="poclass" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Order Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="orderdate" id="orderdate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Due Date*</label>
                                    <input type="date" class="form-control form-control-sm" placeholder="" name="duedate" id="duedate" value="<?php echo date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Location*</label>
                                    <select class="form-control form-control-sm" name="location" id="location" required>
                                        <option value="">Select</option>
                                        <?php foreach($locationlist->result() as $rowlocationlist){ ?>
                                        <option value="<?php echo $rowlocationlist->idtbl_location ?>"><?php echo $rowlocationlist->location ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Supplier*</label>
									<select class="form-control form-control-sm" name="supplier" id="supplier" required>
										<option value="">Select</option>
									</select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col-12">
                                    <label class="small font-weight-bold text-dark">Material*</label>
                                    <select class="form-control form-control-sm" name="product" id="product" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit*</label>
                                    <select class="form-control form-control-sm" name="unit" id="unit" required readonly>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Per Ctn*</label>
                                    <input type="text" id="unitperctn" name="unitperctn" class="form-control form-control-sm" value="0" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Ctn*</label>
                                    <input type="text" id="ctn" name="ctn" class="form-control form-control-sm" required>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Total Qty*</label>
                                    <input type="text" id="newqty" name="newqty" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Unit Price</label>
                                    <input type="text" id="unitprice" name="unitprice" class="form-control form-control-sm" value="0">
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Discount Amount</label>
                                    <input type="text" id="discount" name="discount" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                            </div>
                            <input type="hidden" name="refillprice" id="refillprice" value="">
                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                        <table class="table table-striped table-bordered table-sm small" id="tableorder">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Comment</th>
                                    <th class="d-none">Product ID</th>
                                    <th class="d-none">Unit Price (LKR)</th>
                                    <th class="d-none">Unit Price (USD)</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Unit Per Ctn</th>
                                    <th class="text-center">Ctn</th>
                                    <th class="text-center">Total Qty</th>
                                    <th class="d-none">Total (LKR)</th>
                                    <th class="d-none">Total (USD)</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="divtotal">Rs. 0.00</h1>
                            </div>
                            <input type="text" id="hidetotalorder" value="0">
                            <input type="text" id="hidetotalorderusd" value="0">
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Total Discount</label>
                                <input name="totaldiscount" id="totaldiscount" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Notes and Instructions</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder"
                                class="btn btn-outline-primary btn-sm fa-pull-right"><i
                                    class="fas fa-save"></i>&nbsp;Create
                                Order</button>
                        </div>
                        <br><br>
                        <div id='gcw_mainFL0GridDR' class='gcw_mainFL0GridDR'></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">View Purchase Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="print">
                <h4 class="text-right"><label id="procode"></label></h4>
                <div id="viewhtml"></div>
			</div>
		</div>
	</div>
</div>
<?php include "include/footerscripts.php"; ?>
<script>
    function reloadFL0GridDR() {
    	var sc = document.getElementById('scFL0GridDR');
    	if (sc) sc.parentNode.removeChild(sc);
    	sc = document.createElement('script');
    	sc.type = 'text/javascript';
    	sc.charset = 'UTF-8';
    	sc.async = true;
    	sc.id = 'scFL0GridDR';
    	sc.src = 'https://freecurrencyrates.com/en/widget-horizontal?iso=USD-LKR&df=2&p=FL0GridDR&v=fts&source=fcr&width=900&width_title=225&firstrowvalue=1&thm=dddddd,eeeeee,E78F08,F6A828,FFFFFF,cccccc,ffffff,1C94C4,000000&title=Currency%20Converter&tzo=-330';
    	var div = document.getElementById('gcw_mainFL0GridDR');
    	div.parentNode.insertBefore(sc, div);
    }
    reloadFL0GridDR();

    $(document).ready(function() {
        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        sessionStorage.setItem('companyid', '<?php echo $this->session->userdata('companyid'); ?>');

        $('#ctn').on('input', function () {
            var unitPerCtn = parseFloat($('#unitperctn').val()) || 0;
            var ctn = parseFloat($(this).val()) || 0;
            var totalQty = unitPerCtn * ctn;

            $('#newqty').val(totalQty);
        });

        $("#supplier").select2({
            dropdownParent: $('#staticBackdrop'),
            width: '100%',
            ajax: {
                url: "<?php echo base_url() ?>Purchaseorder/Getsupplierlist",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        searchTerm: params.term
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

        let originalUnitPrice = 0;

        $("#unitprice").on("focus input", function () {
        	originalUnitPrice = parseFloat($(this).val()) || 0;
        });

        $("#discount").on("input", function () {

        	let discount = parseFloat($(this).val()) || 0;

        	let finalPrice = originalUnitPrice - discount;

        	if (finalPrice < 0) {
        		finalPrice = 0;
        	}

        	$("#unitprice").val(finalPrice.toFixed(2));
        });

        let baseTotal = 0;

        $("#totaldiscount").on("focus", function () {
            baseTotal = parseFloat($("#hidetotalorder").val()) || 0;
        });

        $("#totaldiscount").on("input", function () {

            let discount = parseFloat($(this).val()) || 0;

            let newTotal = baseTotal - discount;

            if (newTotal < 0) {
                newTotal = 0;
            }

            $("#divtotal").text("Rs. " + newTotal.toFixed(2));

            $("#hidetotalorder").val(newTotal.toFixed(2));

            let usdRate = parseFloat($("#gcw_valFL0GridDR1").val()) || 1;
            $("#hidetotalorderusd").val((newTotal / usdRate).toFixed(2));
        });


        $('#dataTable').DataTable({
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Purchase Order Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Purchase Order Information',
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
                url: "<?php echo base_url() ?>scripts/purchaseorderlist.php",
                type: "POST", // you can use GET
                // data: function(d) {}
            },
            "order": [[ 0, "desc" ]],
            "columns": [
                {
                    "data": null,
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "idtbl_porder",
                    "render": function(data, type, full) {
                        var orderDate = new Date(full['orderdate']);
                        var cutoffDate = new Date("2024-12-10");
                        
                        var companyId = sessionStorage.getItem("companyid");
                        
                        var prefix = "UNKNOWN/PO";
                        if (companyId == 1) {
                            prefix = "TRFL/PO";
                        } else if (companyId == 2) {
                            prefix = "TRFL/PO";
                        }
                        
                        if (orderDate >= cutoffDate) {
                                return prefix + "-" + full['po_no']; 
                        
                        } else {
                                return prefix + "-" + data;
                        }
                    }
                },
                {
                    "data": "class"
                },
                {
                    "data": "orderdate"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {

                        let curr = full['currencytype'];
                        let symbol = curr == 1 ? "Rs. " : "$ ";

                        let total = curr == 1 
                            ? full['nettotal'] 
                            : full['nettotalusd'];

                        return symbol + addCommas(parseFloat(total).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';}
                        else if(full['confirmstatus']==2){return '<i class="fas fa-times text-danger mr-2"></i>Rejected';}
                        else{return 'Not Confirm Order';}
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==2){return '<i class="fas fa-times text-danger mr-2"></i>Rejected';}
                        else{
                            if(full['grnconfirm']==1){return '<i class="fas fa-check text-success mr-2"></i>Issue GRN';}
                            else{return 'Not Issue GRN';}
                        }
                    }
                },
                {
                    "data": "remark"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        if(full['confirmstatus']<2){
                            button += '<a href="<?php echo base_url() ?>Purchaseorder/Printpurchaseorder/' + full['idtbl_porder'] + '" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Print PO" class="btn btn-danger btn-sm mr-1"><i class="fas fa-file-pdf"></i></a>';
                        }
                        button+='<button class="btn btn-dark btn-sm btnview mr-1" id="'+full['idtbl_porder']+'" po_no="' + full['po_no'] + '"><i class="fas fa-eye"></i></button>';
                        if(full['confirmstatus']==1 && statuscheck==1){
                            button+='<button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
                        }else if(full['confirmstatus']==0){
                            if(statuscheck==1){
                                button+='<button class="btn btn-warning btn-sm btnconfirm mr-1" id="'+full['idtbl_porder']+'"><i class="fas fa-times"></i></button>';
                            }
                            if(editcheck==1){
                                button+='<button class="btn btn-primary btn-sm btnEdit mr-1" id="'+full['idtbl_porder']+'"><i class="fas fa-pen"></i></button>';
                            }
                        }
                        
                        return button;
                    }
                }
            ],
            createdRow: function( row, data, dataIndex){
                if(data['confirmstatus']  ==  2){
                    $(row).addClass('bg-danger-soft');
                }
            },
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#dataTable tbody').on('click', '.btnview', function() {
            var id = $(this).attr('id');
            var pono = $(this).attr('po_no');
        	var companyId = sessionStorage.getItem("companyid");

        	var prefix = "UNKNOWN/PO";
        	if (companyId == 1) {
        		prefix = "TRFL/PO";
        	} else if (companyId == 2) {
        		prefix = "TRFL/PO";
        	}

        	var porderCode = prefix + "-" + pono;
        	$('#procode').html(porderCode);
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderview',
                success: function(result) { //alert(result);

                    $('#porderviewmodal').modal('show');
                    $('#viewhtml').html(result);
                }
            });
        }); 
        $('#dataTable tbody').on('click', '.btnconfirm', function() {
            var id = $(this).attr('id'); 
            Swal.fire({
                title: "Do you want to approve this purchase order?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Approve",
                denyButtonText: `Reject`
            }).then((result) => {
                if (result.isConfirmed) {
                    var confirmnot = 1;
                    confirmporder(confirmnot, id);
                } else if (result.isDenied) {
                    var confirmnot = 2;
                    confirmporder(confirmnot, id);
                } 
            });
        });
        $('#dataTable tbody').on('click', '.btnEdit', async function() {
            var r = await Otherconfirmation("You want to Edit this ? ");
            if (r == true) {
                var id = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: id
                    },
                    url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderedit',
                    success: function(result) { //alert(result);
                        // console.log(result);
                        
                        var obj = JSON.parse(result);
                        
                        $('#recordID').val(obj.recorddata['idtbl_porder']);
                        $('#ordertype').val(obj.recorddata['tbl_order_type_idtbl_order_type']);    
                        $('#currencytype').val(obj.recorddata['currencytype']);                     
                        $('#poclass').val(obj.recorddata['class']);                       
                        $('#orderdate').val(obj.recorddata['orderdate']);                       
                        $('#duedate').val(obj.recorddata['duedate']);                       
                        $('#location').val(obj.recorddata['tbl_location_idtbl_location']);     
                        var newOptionSupp = new Option(obj.recorddata['suppliername'], obj.recorddata['idtbl_supplier'], true, true);
                        $('#supplier').append(newOptionSupp).trigger('change');            

                        $('#recordOption').val('2');
                        $('#btncreateorder').html('<i class="far fa-save"></i>&nbsp;Update Order');
                        $.each(obj.recorddetaildata, function(i, item) {
                            var product = item['materialname'] + ' / ' + item['materialinfocode'];
                            var unit_price = parseFloat(item['unitprice']);
                            var unitprice = addCommas(parseFloat(unit_price).toFixed(2));
                            var unit_priceusd = parseFloat(item['unitpriceusd']);
                            var unitpriceusd = addCommas(parseFloat(unit_priceusd).toFixed(2));
                            var unitperctn = parseFloat(item['unitperctn']);
                            var ctn = parseFloat(item['ctn']);
                            var newqty = parseFloat(item['qty']);

                            var newtotal = parseFloat(unitprice * newqty);
                            var newtotalusd = parseFloat(unitpriceusd * newqty);

                            var total = parseFloat(newtotal);
                            var showtotal = addCommas(parseFloat(total).toFixed(2));

                            var totalusd = parseFloat(newtotalusd);
                            var showtotalusd = addCommas(parseFloat(totalusd).toFixed(2));

                            $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + item['comment'] + '</td><td class="d-none">' + item['tbl_material_info_idtbl_material_info'] + '</td><td class="d-none">' + unitprice + '</td><td class="text-center">' + unitpriceusd + '</td><td class="text-center">' + unitperctn + '</td><td class="text-center">' + ctn + '</td><td class="text-center">' + newqty + '</td><td class="total d-none">' + total + '</td><td class="text-right totalusd">' + showtotalusd + '</td></tr>');
                        });
                        var sum = 0;
                        $(".total").each(function () {
                            sum += parseFloat($(this).text());
                        });

                        var sumusd = 0;
                        $(".totalusd").each(function () {
                            var valueusd = $(this).text();
                            var numusd = parseFloat(valueusd.replace(/,/g, ''));
                            if (!isNaN(numusd)) {
                                sumusd += numusd;
                            }
                        });

                        var showsum = addCommas(parseFloat(sum).toFixed(2));

                        $('#divtotal').html('$ ' + sumusd);
                        $('#hidetotalorder').val(sum);
                        $('#hidetotalorderusd').val(sumusd);
                        $('#product').focus();
                        
                        $('#staticBackdrop').modal('show');
                    }
                });
            }
        });
        $('#supplier').change(function () {
            let supplierID = $(this).val()

            $.ajax({
                type: "POST",
                data: {
                    recordID: supplierID
                },
                url: 'Purchaseorder/Getproductaccosupplier',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    var html1 = '';
                    html1 += '<option value="">Select</option>';
                    $.each(obj, function (i, item) {
                        html1 += '<option value="' + obj[i].idtbl_material_info + '">';
                        html1 += obj[i].materialname + ' / ' + obj[i].materialinfocode;
                        html1 += '</option>';
                    });
                    $('#product').empty().append(html1);
                }
            });
        });
        $('#product').change(function () {
            let productID = $(this).val();
            if (!productID) return;

            $.ajax({
                type: "POST",
                data: {
                    recordID: productID
                },
                url: 'Purchaseorder/Getunitpriceaccomaterial',
                dataType: 'json',
                success: function (response) {
                    $('#unitprice').val(response.unitprice);
                    $('#unitperctn').val(response.unitperctn);
                    
                    let unitDropdown = $('#unit');
                    unitDropdown.empty();
                    unitDropdown.append($('<option>').val('').text('Select'));
                    
                    if (response.unit_id && response.unitname) {
                        unitDropdown.append($('<option>').val(response.unit_id).text(response.unitname));
                        unitDropdown.val(response.unit_id); 
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching unit price:", error);
                    $('#unitprice').val('0');
                    $('#unit').empty().append($('<option>').val('').text('Select'));
                }
            });
        });
        $("#formsubmit").click(function () {

        	if (!$("#createorderform")[0].checkValidity()) {
        		$("#submitBtn").click();
        		return;
        	}

        	let currencyType = $("#currencytype").val(); 
        	let usdRate = parseFloat($("#gcw_valFL0GridDR1").val());

        	let productID = $("#product").val();
        	let comment = $("#comment").val();
        	let product = $("#product option:selected").text();
        	let unitprice = parseFloat($("#unitprice").val()); 
        	let unitperctn = parseFloat($("#unitperctn").val());
        	let ctn = parseFloat($("#ctn").val());
        	let newqty = parseFloat($("#newqty").val());

        	let unitprice_lkr = 0;
        	let unitprice_usd = 0;
        	let total_lkr = 0;
        	let total_usd = 0;

        	if (currencyType == 1) {
        		unitprice_lkr = unitprice;
        		unitprice_usd = unitprice / usdRate;

        		total_lkr = unitprice_lkr * newqty;
        		total_usd = total_lkr / usdRate;

        	} else if (currencyType == 2) {
        		unitprice_usd = unitprice;
        		unitprice_lkr = unitprice * usdRate;

        		total_usd = unitprice_usd * newqty;
        		total_lkr = total_usd * usdRate;
        	}

        	$("#tableorder > tbody:last").append(`
            <tr class="pointer">
                <td>${product}</td>
                <td>${comment}</td>
                <td class="d-none">${productID}</td>

                <!-- STORE BOTH LKR + USD HIDDEN -->
                <td class="d-none unitprice_lkr">${unitprice_lkr.toFixed(2)}</td>
                <td class="d-none unitprice_usd">${unitprice_usd.toFixed(2)}</td>

                <!-- SHOW DISPLAY PRICE -->
                <td class="text-center">${currencyType == "1" ? unitprice_lkr.toFixed(2) : unitprice_usd.toFixed(2)}</td>

                <td class="text-center">${unitperctn}</td>
                <td class="text-center">${ctn}</td>
                <td class="text-center">${newqty}</td>

                <!-- HIDDEN TOTALS -->
                <td class="d-none total_lkr">${total_lkr.toFixed(2)}</td>
                <td class="d-none total_usd">${total_usd.toFixed(2)}</td>

                <!-- DISPLAY TOTAL -->
                <td class="text-right">${currencyType == "1" ? total_lkr.toFixed(2) : total_usd.toFixed(2)}</td>
            </tr>
            `);

        	$("#product").val('');
        	$("#unitprice").val('');
        	$("#ctn").val('0');
        	$("#unitperctn").val('0');
        	$("#comment").val('');
        	$("#newqty").val('0');
            $("#newqty").val('0');

        	let grand_lkr = 0;
        	let grand_usd = 0;

        	$(".total_lkr").each(function () {
        		grand_lkr += parseFloat($(this).text());
        	});

        	$(".total_usd").each(function () {
        		grand_usd += parseFloat($(this).text());
        	});

        	$("#hidetotalorder").val(grand_lkr.toFixed(2));
        	$("#hidetotalorderusd").val(grand_usd.toFixed(2));

        	$("#divtotal").html(currencyType == "1" ? "Rs. " + grand_lkr.toFixed(2) : "$ " + grand_usd.toFixed(2));

        });

        $('#tableorder').on('click', 'tr', function () {
            var r = confirm("Are you sure, You want to remove this product ? ");
            if (r == true) {
                $(this).closest('tr').remove();

                var sum = 0;
                $(".total").each(function () {
                    sum += parseFloat($(this).text());
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html('Rs. ' + showsum);
                $('#hidetotalorder').val(sum);
                $('#product').focus();
            }
        });
        $('#btncreateorder').click(function () { //alert('IN');
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
            var tbody = $("#tableorder tbody");

            if (tbody.children().length > 0) {
                jsonObj = [];
                $("#tableorder tbody tr").each(function () {
                    item = {}
                    $(this).find('td').each(function (col_idx) {
                        item["col_" + (col_idx + 1)] = $(this).text();
                    });
                    jsonObj.push(item);
                });
                // console.log(jsonObj);

                var orderdate = $('#orderdate').val();
                var poclass = $('#poclass').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var totalusd = $('#hidetotalorderusd').val();
                var supplier = $('#supplier').val();
                var location = $('#location').val();
                var ordertype = $('#ordertype').val();
                var currencytype = $('#currencytype').val();
                var recordID = $('#recordID').val();
                var recordOption = $('#recordOption').val();
                var usdrate = $('#gcw_valFL0GridDR1').val();
                // alert(orderdate);
                $.ajax({
                    type: "POST",
                    data: {
                        tableData: jsonObj,
                        orderdate: orderdate,
                        poclass: poclass,
                        duedate: duedate,
                        total: total,
                        remark: remark,
                        supplier: supplier,
                        location: location,
                        ordertype: ordertype,
                        currencytype: currencytype,
                        totalusd: totalusd,
                        usdrate: usdrate,
                        recordID: recordID,
                        recordOption: recordOption
                    },
                    url: 'Purchaseorder/Purchaseorderinsertupdate',
                    success: function (result) { //alert(result);
                        // console.log(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            actionreload(obj.action);
                        }
                        else{
                            action(obj.action);
                        }
                    }
                });
            }
        });
        $('#staticBackdrop').on('hidden.bs.modal', function (e) {
            window.location.reload();
        })
    });

    function deactive_confirm() {
        return confirm("Are you sure you want to deactive this?");
    }

    function active_confirm() {
        return confirm("Are you sure you want to confirm this purchase order?");
    }

    function delete_confirm() {
        return confirm("Are you sure you want to remove this?");
    }

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

    // function action(data) { //alert(data);
    //     var obj = JSON.parse(data);
    //     $.notify({
    //         // options
    //         icon: obj.icon,
    //         title: obj.title,
    //         message: obj.message,
    //         url: obj.url,
    //         target: obj.target
    //     }, {
    //         // settings
    //         element: 'body',
    //         position: null,
    //         type: obj.type,
    //         allow_dismiss: true,
    //         newest_on_top: false,
    //         showProgressbar: false,
    //         placement: {
    //             from: "top",
    //             align: "center"
    //         },
    //         offset: 100,
    //         spacing: 10,
    //         z_index: 1031,
    //         delay: 5000,
    //         timer: 1000,
    //         url_target: '_blank',
    //         mouse_over: null,
    //         animate: {
    //             enter: 'animated fadeInDown',
    //             exit: 'animated fadeOutUp'
    //         },
    //         onShow: null,
    //         onShown: null,
    //         onClose: null,
    //         onClosed: null,
    //         icon_type: 'class',
    //         template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
    //             '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
    //             '<span data-notify="icon"></span> ' +
    //             '<span data-notify="title">{1}</span> ' +
    //             '<span data-notify="message">{2}</span>' +
    //             '<div class="progress" data-notify="progressbar">' +
    //             '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
    //             '</div>' +
    //             '<a href="{3}" target="{4}" data-notify="url"></a>' +
    //             '</div>'
    //     });
    // }
    function confirmporder(confirmnot, id){
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
                        recordID: id,
                        confirmstatus: confirmnot
                    },
                    url: '<?php echo base_url() ?>Purchaseorder/Purchaseorderstatus/' + id + '/' + confirmnot,
                    success: function(result) { //alert(result);
                        var obj = JSON.parse(result);
                        if(obj.status==1){
                            actionreload(obj.action);
                        }
                        else{
                            action(obj.action);
                        }
                    },
                    error: function(error) {
                        // Close the SweetAlert on error
                        Swal.close();
                        document.body.style.overflow = 'auto';
                        
                        // Show an error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again later.'
                        });
                    }
                });
            }
        });
    }

</script>
<?php include "include/footer.php"; ?>
