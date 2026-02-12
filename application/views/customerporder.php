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
                            <div class="page-header-icon"><i class="fas fa-shopping-cart"></i></div>
                            <span>Sales Order</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus mr-2"></i>Create Sales Order</button>
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
                                                <th>Date</th>
                                                <th>Sales Order No.</th>
                                                <th>Customer</th>
                                                <th>Currency Type</th>
                                                <th>Total</th>
                                                <th>Confirm Status</th>
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
<div class="modal fade" id="productionorder" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered ">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Packing Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    	<form action="<?php echo base_url() ?>Customerporder/Porderinsertupdate" method="post"
                    		autocomplete="off">
                    		<div class="form-row mb-1 p-1">
                    			<input type="hidden" class="form-control form-control-sm" name="orderid" id="orderid">
                    			<label class="small font-weight-bold text-dark">Product*</label><br>
                    			<select class="form-control form-control-sm" name="productlist"
                    				id="productlist" required>
                    			</select>
                    		</div>
                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold">Order Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="orderqty" id="orderqty"
                    					readonly>
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Production Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="proqty" id="proqty"
                    					required>
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Balance Qty*</label>
                    				<input type="text" class="form-control form-control-sm" name="balanceqty"
                    					id="balanceqty" readonly>
                    			</div>
                    		</div>
                            

                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold d-none">Material Unit Cost*</label>
                    				<input type="text" class="form-control form-control-sm d-none" name="uprice" id="uprice"
                    					required>
                    			</div>
                    		</div>
                    		<div class="form-row mb-1">
                    			<div class="col">
                    				<label class="small font-weight-bold">Production Start Date</label>
                    				<input type="date" class="form-control form-control-sm" name="startdate" id="startdate">
                    			</div>
                    			<div class="col">
                    				<label class="small font-weight-bold">Production End Date</label>
                    				<input type="date" class="form-control form-control-sm" name="enddate" id="enddate">
                    			</div>
                    		</div>
                    		<div class="form-group mt-3 text-right">
                    			<button type="submit" id="submitBtn" class="btn btn-outline-primary btn-sm fa-pull-right"
                    				<?php if($addcheck==0){echo 'disabled';} ?>><i class="far fa-save"></i>&nbsp;Create
                    				Packing Order</button>
                    		</div>
                    	</form>
                    </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Create Sales Order</h5>
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
                                        <?php foreach($currencylist as $rowcurrencylist){ ?>
                                        <option value="<?php echo $rowcurrencylist['id'] ?>" data-currencycode="<?php echo $rowcurrencylist['code'] ?>"><?php echo $rowcurrencylist['text'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Sales Order Type*</label>
                                    <select class="form-control form-control-sm" name="ordertype" id="ordertype" required>
                                        <option value="">Select</option>
                                        <?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
                                        <option value="<?php echo $rowordertypelist->idtbl_order_type ?>"><?php echo $rowordertypelist->type ?></option>
                                        <?php } ?>
                                    </select>
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
                                    <label class="small font-weight-bold text-dark">Sale Type*</label>
                                    <select class="form-control form-control-sm" name="saletype" id="saletype" required>
                                        <option value="">Select</option>
                                        <option value="1">Local</option>
                                        <option value="2">Export</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Customer*</label>
                                    <select class="form-control form-control-sm" name="customer" id="customer" required>
                                        <option value="">Select</option>
                                        <?php foreach($customerlist->result() as $rowcustomerlist){ ?>
                                        <option value="<?php echo $rowcustomerlist->idtbl_customer ?>"><?php echo $rowcustomerlist->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
                                <div class="col">
                                    <label class="small font-weight-bold text-dark">Product*</label><br>
                                    <select class="form-control form-control-sm" style="width: 100%;" name="product" id="product" required>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Profit Margin*</label>
									<div class="input-group input-group-sm">
										<input type="number" class="form-control form-control-sm " name="profitmargin" id="profitmargin" value="20">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
									</div>
								</div>
                                <div class="col">
									<label class="small font-weight-bold text-dark">Conversion Rate</label>
									<input type="text" id="convertrate" name="convertrate" class="form-control form-control-sm">
								</div>
							</div>
                            <div class="form-row mb-1">
                                <div class="col">
									<label class="small font-weight-bold text-dark">Qty*</label>
									<input type="text" id="newqty" name="newqty" class="form-control form-control-sm" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Unit Price</label>
									<input type="text" id="unitprice" name="unitprice" class="form-control form-control-sm">
								</div>
							</div>
                            <!-- <div class="form-row mb-1">
                            	<div class="col">
                            		<label class="small font-weight-bold text-dark">Suggest Price</label>
                            		<input type="text" id="suggestprice" name="suggestprice"
                            			class="form-control form-control-sm">
                            	</div>
                            </div> -->
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold text-dark">Comment</label>
                                <textarea name="comment" id="comment" class="form-control form-control-sm"></textarea>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <button type="button" id="formsubmitcreate" class="btn btn-primary btn-sm px-4" <?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to list</button>
                                <input name="submitBtncreate" type="submit" value="Save" id="submitBtncreate" class="d-none">
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
                                    <th class="">ProductID</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="row">
                            <div class="col text-right">
                                <h1 class="font-weight-600" id="divtotal">0.00</h1>
                            </div>
                            <input type="hidden" id="hidetotalorder" value="0">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="small font-weight-bold text-dark">Remark</label>
                            <textarea name="remark" id="remark" class="form-control form-control-sm"></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <button type="button" id="btncreateorder" class="btn btn-outline-primary btn-sm fa-pull-right"><i class="fas fa-save"></i>&nbsp;Create Sales Order</button>
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
                <h5 class="modal-title" id="staticBackdropLabel">View Sales Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="salesorderprint">
                <!-- Dynamic Sales Order Code -->
                <h4 class="text-right"><span id="salesordercode"></span></h4>
                <div id="viewhtml"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="pordereditmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Edit Sales Order</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
						<form id="createorderform2" autocomplete="off">
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Sales Order Type*</label>
								<input type="hidden" class="form-control form-control-sm" name="hiddenporderid"
									id="hiddenporderid" required>
								<select class="form-control form-control-sm" name="ordertype2" id="ordertype2" required>
									<option value="">Select</option>
									<?php foreach($ordertypelist->result() as $rowordertypelist){ ?>
									<option value="<?php echo $rowordertypelist->idtbl_order_type ?>">
										<?php echo $rowordertypelist->type ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Order Date*</label>
									<input type="date" class="form-control form-control-sm" placeholder=""
										name="orderdate2" id="orderdate2" value="<?php echo date('Y-m-d') ?>" required>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Due Date*</label>
									<input type="date" class="form-control form-control-sm" placeholder=""
										name="duedate2" id="duedate2" value="<?php echo date('Y-m-d') ?>" required>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Sale Type*</label>
									<select class="form-control form-control-sm" name="saletype2" id="saletype2">
										<option value="">Select</option>
										<option value="1">Local</option>
										<option value="2">Export</option>
									</select>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Customer*</label>
									<select class="form-control form-control-sm" name="customer2" id="customer2"
										required>
										<option value="">Select</option>
										<?php foreach($customerlist->result() as $rowcustomerlist){ ?>
										<option value="<?php echo $rowcustomerlist->idtbl_customer ?>">
											<?php echo $rowcustomerlist->name ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Product*</label><br>
									<select class="form-control form-control-sm" style="width: 100%;" name="product2"
										id="product2" required>
										<option value="">Select</option>
									</select>
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Profit Margin*</label>
									<div class="input-group mb-3">
										<input type="number" class="form-control form-control-sm col-8"
											name="profitmargin2" id="profitmargin2" value="20">
										<input type="text" value="%" class="form-control form-control-sm col-4"
											readonly>
									</div>
								</div>
								<div class="col">
									<label class="small font-weight-bold text-dark">Qty*</label>
									<input type="text" id="newqty2" name="newqty2" class="form-control form-control-sm"
										required>
								</div>
							</div>
                            <div class="form-row mb-1">
								<div class="col">
									<label class="small font-weight-bold text-dark">Suggest Price</label>
									<input type="text" id="suggestprice2" name="suggestprice2"
										class="form-control form-control-sm">
								</div>
                                <div class="col">
									<label class="small font-weight-bold text-dark">USD Rate</label>
									<input type="text" id="usdrate2" name="usdrate2"
										class="form-control form-control-sm">
								</div>
							</div>
							<div class="form-row mb-1">
								<div class="col">
									<!-- <label class="small font-weight-bold text-dark">Suggest Price</label>
                            		<input type="text" id="suggestprice" name="suggestprice"
                            			class="form-control form-control-sm"> -->
								</div>
							</div>
							<div class="form-group mb-1">
								<label class="small font-weight-bold text-dark">Comment</label>
								<textarea name="comment2" id="comment2" class="form-control form-control-sm"></textarea>
							</div>
							<div class="form-group mt-3 text-right">
								<button type="button" id="formsubmit2" class="btn btn-primary btn-sm px-4"
									<?php if($addcheck==0){echo 'disabled';} ?>><i class="fas fa-plus"></i>&nbsp;Add to
									list</button>
								<input name="submitBtn1" type="submit2" value="Save" id="submitBtn1" class="d-none">
							</div>
							<input type="hidden" name="refillprice" id="refillprice" value="">
						</form>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
						<table class="table table-striped table-bordered table-sm small" id="tableorder2">
							<thead>
								<tr>
									<th>Product</th>
									<th>Comment</th>
									<th class="d-none">ProductID</th>
									<th class="d-none">Unitprice</th>
									<th class="text-right d-none">Material Unit Cost</th>
									<th class="text-center">Qty</th>
									<th class="d-none">HideTotal</th>
									<th class="text-right">Suggest Price</th>
									<th class="text-right">Total</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<div class="row">
							<div class="col text-right">
								<h1 class="font-weight-600" id="divtotal2">Rs. 0.00</h1>
							</div>
							<input type="hidden" id="hidetotalorder2" value="0">
						</div>
						<hr>
						<div class="form-group">
							<label class="small font-weight-bold text-dark">Remark</label>
							<textarea name="remark2" id="remark2" class="form-control form-control-sm"></textarea>
						</div>
						<div class="form-group mt-2">
							<button type="button" id="btncreateorder2"
								class="btn btn-outline-primary btn-sm fa-pull-right"><i
									class="fas fa-save"></i>&nbsp;Update Sales
								Order</button>
						</div>
                        <br><br>
                        <div id='gcw_mainFsmgGEMWY' class='gcw_mainFsmgGEMWY'></div>
					</div>
				</div>
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

    function reloadFsmgGEMWY(){ 
        var sc = document.getElementById('scFsmgGEMWY');
        if (sc) sc.parentNode.removeChild(sc);
        sc = document.createElement('script');
        sc.type = 'text/javascript';
        sc.charset = 'UTF-8';
        sc.async = true;
        sc.id='scFsmgGEMWY';
        sc.src = 'https://freecurrencyrates.com/en/widget-horizontal?iso=USD-LKR&df=2&p=FsmgGEMWY&v=fits&source=fcr&width=900&width_title=225&firstrowvalue=1&thm=A6C9E2,FCFDFD,4297D7,5C9CCC,FFFFFF,C5DBEC,FCFDFD,2E6E9E,000000&title=Currency%20Converter&tzo=-330';
        var div = document.getElementById('gcw_mainFsmgGEMWY');
        div.parentNode.insertBefore(sc, div);
    } 
    reloadFsmgGEMWY();

    $(document).ready(function() {

        $("#product").select2({
            dropdownParent: $('#staticBackdrop'),

        	ajax: {
        		url: "<?php echo base_url() ?>Customerporder/Getproductlist",
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

        $("#product2").select2({
            dropdownParent: $('#pordereditmodal'),

        	ajax: {
        		url: "<?php echo base_url() ?>Customerporder/Getproductlist",
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

        var addcheck='<?php echo $addcheck; ?>';
        var editcheck='<?php echo $editcheck; ?>';
        var statuscheck='<?php echo $statuscheck; ?>';
        var deletecheck='<?php echo $deletecheck; ?>';

        sessionStorage.setItem('companyid', '<?php echo $this->session->userdata('companyid'); ?>');


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
                url: "<?php echo base_url() ?>scripts/customerpurchaseorderlist.php",
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
                    "data": "orderdate"
                },
                {
                    "data": "idtbl_customer_porder",
                    "render": function(data, type, full) {
                        var orderDate = new Date(full['orderdate']);
                        var cutoffDate = new Date("2024-12-10");
                        
                        var companyId = sessionStorage.getItem("companyid");
                        
                        var prefix = "UNKNOWN/SOD";
                        if (companyId == 1) {
                            prefix = "UN/SOD";
                        } else if (companyId == 2) {
                            prefix = "UF/SOD";
                        }
                        
                        if (orderDate >= cutoffDate) {
                                return prefix + "-0000" + full['sod_no']; 
                        
                        } else {
                                return prefix + "-0000" + data;
                        }
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "currency_display"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        return addCommas(parseFloat(full['nettotal']).toFixed(2));
                    }
                },
                {
                    "targets": -1,
                    "className": '',
                    "data": null,
                    "render": function(data, type, full) {
                        if(full['confirmstatus']==1){return '<i class="fas fa-check text-success mr-2"></i>Confirm Order';}
                        else{return 'Not Confirm Order';}
                    }
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button='';
                        //button+='<button class="btn btn-warning btn-sm btnAddCosting mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-list"></i></button>';     
                        button+='<button class="btn btn-dark btn-sm btnview mr-1" id="'+full['idtbl_customer_porder']+'" sod_no="' + full['sod_no'] + '"><i class="fas fa-eye"></i></button>'; 
                        if(full['confirmstatus']!=2){
                            button += '<a href="<?php echo base_url() ?>Customerporder/printreport/' + full['idtbl_customer_porder'] + '/' + full['tbl_product_idtbl_product'] + '" target="_blank" name="'+ full['tbl_product_idtbl_product'] +'" class="btn btn-secondary btn-sm mr-1"><i class="fas fa-print"></i></a>';       
                        }                 
                        
                        if(full['confirmstatus']==1){
                            if(addcheck==1){
                                button+='<button class="btn btn-primary btn-sm btnAdd mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-plus"></i></button>';
                            }
                            if(statuscheck==1){
                                button+='<button class="btn btn-success btn-sm mr-1"><i class="fas fa-check"></i></button>';
                            }
                        }else{
                            if(editcheck==1 && full['confirmstatus']==0){
                                button+='<button class="btn btn-info btn-sm btnEdit mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-pen"></i></button>';
                            }
                            if(statuscheck==1 && full['confirmstatus']==0){
                                button+='<button class="btn btn-warning btn-sm btnconfirm mr-1" id="'+full['idtbl_customer_porder']+'"><i class="fas fa-times"></i></button>';
                            }
                            if(deletecheck==1 && full['confirmstatus']==0){
								button+='<button type="button" data-url="Customerporder/Customerporderstatus/'+full['idtbl_customer_porder']+'/3" data-actiontype="3" class="btn btn-danger btn-sm text-light btntableaction"><i class="fas fa-trash-alt"></i></button>';
							}	
                        }
                        // if(full['transproductionstatus']==0){
                        //     button+='<a href="<?php echo base_url() ?>Customerporder/Customerporderstatus/'+full['idtbl_customer_porder']+'/2" onclick="return active_confirm()" target="_self" class="btn btn-danger btn-sm mr-1 ';if(statuscheck!=1){button+='d-none';}button+='"><i class="fas fa-random"></i></a>';
                        // }
                        
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
        $('#dataTable tbody').on('click', '.btnEdit', async function () {
        	var r = await Otherconfirmation("You want to Edit this ? ");
        	if (r == true) {
        		var id = $(this).attr('id');
        		$.ajax({
        			type: "POST",
        			data: {
        				recordID: id
        			},
        			url: '<?php echo base_url() ?>Customerporder/Customerporderedit',
        			success: function (result) {
        				try {
        					var obj = JSON.parse(result);
        					console.log(obj); // Debugging statement

        					// Populate the input fields
        					$('#recordID').val(obj.id);
                            $('#recordOption').val('2');
                            $('#btncreateorder').html('<i class="far fa-save"></i>&nbsp;Update Sales Order');

        					$('#orderdate').val(obj.orderdate);
        					$('#duedate').val(obj.duedate);
        					$('#customer').val(obj.name);
        					$('#ordertype').val(obj.type);
        					$('#convertrate').val(obj.conversion_rate);
        					$('#currencytype').val(obj.currencytype);

        					// Clear the existing table rows
        					$('#tableorder > tbody').empty();

        					// Check if obj.items exists and is an array
        					if (obj.items && Array.isArray(obj.items)) {
        						// Iterate through each item and add a row to the table
        						obj.items.forEach(function (item) {
        							var productID = item.productID;
        							var comment = item.comment;
        							var product = item.productcode;
        							var suggestprice = parseFloat(item.suggestprice).toFixed(2);
        							var newqty = item.qty;
        							var netsaleprice = parseFloat(item.netsaleprice).toFixed(2);

                                    $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td class="">' + productID + '</td><td class="text-center">' + newqty + '</td><td class="text-right ">' + addCommas(suggestprice) + '</td><td class="text-right total ">' + addCommas(netsaleprice) + '</td></tr>');
        						});

                                $('#staticBackdrop').modal('show');

                                $('#divtotal').html(obj.currencycode + ' ' + addCommas(parseFloat(obj.nettotal).toFixed(2)));
                                $('#hidetotalorder').val(obj.nettotal);
                                $('#product').focus();
        					} else {
        						console.error('Error: obj.items is undefined or not an array.');
        						// Handle the error here
        					}
        				} catch (e) {
        					console.error('Error parsing JSON:', e);
        				}
        			},
        			error: function (xhr, status, error) {
        				console.error('AJAX request error:', error);
        			}
        		});
        	}
        });
        $('#dataTable tbody').on('click', '.btnview', function () {
        	var id = $(this).attr('id');
            var sodno = $(this).attr('sod_no');
        	var companyId = sessionStorage.getItem("companyid");

        	var prefix = "UNKNOWN/SOD";
        	if (companyId == 1) {
        		prefix = "UN/SOD";
        	} else if (companyId == 2) {
        		prefix = "UF/SOD";
        	}

        	var salesOrderCode = prefix + "-0000" + sodno;

        	$('#salesordercode').html(salesOrderCode);

        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Customerporder/Customerporderview',
        		success: function (result) {
        			$('#porderviewmodal').modal('show');
        			$('#viewhtml').html(result);
        		}
        	});
        });
        $('#dataTable tbody').on('click', '.btnAdd', function () {
        	var id = $(this).attr('id');
        	$.ajax({
        		type: "POST",
        		data: {
        			recordID: id
        		},
        		url: '<?php echo base_url() ?>Customerporder/Getcustomerporderdetails',
        		success: function (result) { //alert(result);
        			var obj = JSON.parse(result);
        			var html1 = '';
        			html1 += '<option value="">Select</option>';
        			$.each(obj, function (i) {
        				html1 += '<option value="' + obj[i].idtbl_product + '">';
        				html1 += obj[i].prodcutname + ' - ' + obj[i].productcode;
        				html1 += '</option>';
        			});
        			$('#productlist').empty().append(html1);
        			$('#orderid').val(obj[0].idtbl_customer_porder);
        			$('#productionorder').modal('show');
        		}
        	});
        });
        $("#productlist").change(function (event) {
            event.preventDefault();
            var productid = $('#productlist').val();
            var orderid = $('#orderid').val();
            $.ajax({
                type: "POST",
                data: {
                product:productid,
                orderid:orderid,
                  },
                url: '<?php echo base_url() ?>Customerporder/Getorderqty',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#orderqty').val(obj[0].qty);
                    $('#uprice').val(obj[0].unitprice);

                }
            });
        });
        $("#productlist").change(function (event) {
            event.preventDefault();
            var productid = $('#productlist').val();
            var orderid = $('#orderid').val();
            $.ajax({
                type: "POST",
                data: {
                product:productid,
                orderid:orderid,
                  },
                url: '<?php echo base_url() ?>Customerporder/Getbalanceqty',
                success: function (result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#balanceqty').val(obj[0].qtydiff);

                    

                }
            });
        });
        $('#product').change(function () {
            let productID = $(this).val();
            let saletype = $('#saletype').val();
            let customer = $('#customer').val();

            if(productID!=''){
                $.ajax({
                    type: "POST",
                    data: {
                        recordID: productID,
                        saletype: saletype,
                        customer: customer
                    },
                    url: 'Customerporder/Getproductpriceaccoproduct',
                    success: function (result) { //alert(result);
                        var obj = JSON.parse(result);
                        $('#suggestprice').val(obj.saleprice);
                        $('#usdrate').val(obj.salepriceusd);
                        // $('#unitprice').val(result);
                        // $('#newqty').focus();
                    }
                });
            }
        });
        $('#newqty').keypress(function (e){
            var key = e.which;
            if(key == 13){
                $('#comment').focus();
                return false;  
            }            
        });
        $('#comment').keypress(function (e){
            var key = e.which;
            if(key == 13){
                $('#formsubmit').click();
                return false;  
            }    
        });
        $("#formsubmitcreate").click(function () {
            if (!$("#createorderform")[0].checkValidity()) {
                // If the form is invalid, submit it. The form won't actually submit;
                // this will just cause the browser to display the native HTML5 error messages.
                $("#submitBtncreate").click();
            } else {
                var productID = $('#product').val();
                var comment = $('#comment').val();
                var product = $("#product option:selected").text();
                var unitprice = parseFloat($('#unitprice').val());
                var convertrate = parseFloat($('#convertrate').val());
                var newqty = parseFloat($('#newqty').val());
                var currencycode = $('#currencytype option:selected').data('currencycode');

                var total = addCommas(parseFloat(unitprice * newqty).toFixed(2));

                $('#tableorder > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td class="">' + productID + '</td><td class="text-center">' + newqty + '</td><td class="text-right">' + addCommas(unitprice) + '</td><td class="text-right total">' + total + '</td></tr>');

                $('#unitprice').val('');
                $('#saleprice').val('');
                $('#product').val('').trigger('change');
                $('#comment').val('');
                $('#profitmargin').val('20');
                $('#unitprice').val('');
                $('#newqty').val('0');

                var sum = 0;
                $(".total").each(function () {
                    var value = $(this).text();
                    var num = parseFloat(value.replace(/,/g, ''));
                    if (!isNaN(num)) {
                        sum += num;
                    }
                });

                var showsum = addCommas(parseFloat(sum).toFixed(2));

                $('#divtotal').html(currencycode + showsum);
                $('#hidetotalorder').val(sum);
                $('#product').focus();
            }
        });
        // $("#formsubmit2").click(function () {
        //     if (!$("#createorderform2")[0].checkValidity()) {
        //         // If the form is invalid, submit it. The form won't actually submit;
        //         // this will just cause the browser to display the native HTML5 error messages.
        //         $("#submitBtn2").click();
        //     } else {
        //         var productID = $('#product2').val();
        //         var comment = $('#comment2').val();
        //         var product = $("#product2 option:selected").text();
        //         var unitprice = parseFloat($('#unitprice2').val());
        //         var suggestprice = $('#suggestprice2').val();
        //         var newqty = parseFloat($('#newqty2').val());

        //         var newtotal = parseFloat(suggestprice * newqty);


        //         var total = parseFloat(newtotal);
        //         var showtotal = addCommas(parseFloat(total).toFixed(2));

        //         $('#tableorder2 > tbody:last').append('<tr class="pointer"><td>' + product + '</td><td>' + comment + '</td><td class="d-none">' + productID + '</td><td class="d-none">' + unitprice + '</td><td class="text-right d-none">' + addCommas(parseFloat(unitprice).toFixed(2)) + '</td><td class="text-center">' + newqty + '</td><td class="total2 d-none">' + total + '</td><td class="text-right">' + suggestprice + '</td><td class="text-right">' + showtotal + '</td></tr>');

        //         $('#unitprice2').val('');
        //         $('#saleprice2').val('');
        //         $('#product2').val('').trigger('change');
        //         $('#comment2').val('');
        //         $('#profitmargin2').val('20');
        //         $('#suggestprice2').val('');
        //         $('#newqty2').val('0');


        //         var sum = 0;
        //         $(".total2").each(function () {
        //             sum += parseFloat($(this).text());
        //         });

        //         var showsum = addCommas(parseFloat(sum).toFixed(2));

        //         $('#divtotal2').html('Rs. ' + showsum);
        //         $('#hidetotalorder2').val(sum);
        //         $('#product2').focus();
        //     }
        // });
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
        // $('#tableorder2').on('click', 'tr', function () {
        //     var r = confirm("Are you sure, You want to remove this product ? ");
        //     if (r == true) {
        //         $(this).closest('tr').remove();

        //         var sum = 0;
        //         $(".total2").each(function () {
        //             sum += parseFloat($(this).text());
        //         });

        //         var showsum = addCommas(parseFloat(sum).toFixed(2));

        //         $('#divtotal2').html('Rs. ' + showsum);
        //         $('#hidetotalorder2').val(sum);
        //         $('#product2').focus();
        //     }
        // });
        $('#btncreateorder').click(function () { //alert('IN');
            $('#btncreateorder').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Sales Order')
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

                var currencytype = $('#currencytype').val();
                var ordertype = $('#ordertype').val();
                var orderdate = $('#orderdate').val();
                var duedate = $('#duedate').val();
                var remark = $('#remark').val();
                var total = $('#hidetotalorder').val();
                var customer = $('#customer').val();
                var profitmargin = $('#profitmargin').val();

                var recordID = $('#recordID').val();
                var recordOption = $('#recordOption').val();
                var convertrate = $('#convertrate').val();
                // alert(usdrate);
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
                                tableData: jsonObj,
                                currencytype: currencytype,
                                ordertype: ordertype,
                                orderdate: orderdate,
                                duedate: duedate,
                                remark: remark,
                                total: total,
                                customer: customer,
                                profitmargin: profitmargin,
                                convertrate: convertrate,
                                recordID: recordID,
                                recordOption: recordOption
                            },
                            url: 'Customerporder/Customerporderinsertupdate',
                            success: function (result) { //alert(result);
                                // console.log(result);
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

        });
        // $('#btncreateorder2').click(function () { //alert('IN');
        //     $('#btncreateorder2').prop('disabled', true).html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Create Order')
        //     var tbody = $("#tableorder2 tbody");

        //     if (tbody.children().length > 0) {
        //         jsonObj = [];
        //         $("#tableorder2 tbody tr").each(function () {
        //             item = {}
        //             $(this).find('td').each(function (col_idx) {
        //                 item["col_" + (col_idx + 1)] = $(this).text();
        //             });
        //             jsonObj.push(item);
        //         });
        //          console.log(jsonObj);

        //         var orderdate = $('#orderdate2').val();
        //         var duedate = $('#duedate2').val();
        //         var remark = $('#remark2').val();
        //         var total = $('#hidetotalorder2').val();
        //         var customer = $('#customer2').val();
        //         var profitmargin = $('#profitmargin2').val();
        //         var ordertype = $('#ordertype2').val();
        //         var wastage = $('#wastage').val();
        //         var othercost = $('#othercost2').val();
        //         var hiddenporderid = $('#hiddenporderid').val();
        //         var usdrate2 = $('#usdrate2').val();
        //         // alert(orderdate);
        //         $.ajax({
        //             type: "POST",
        //             data: {
        //                 tableData: jsonObj,
        //                 orderdate: orderdate,
        //                 duedate: duedate,
        //                 total: total,
        //                 remark: remark,
        //                 customer: customer,
        //                 profitmargin: profitmargin,
        //                 ordertype: ordertype,
        //                 wastage: wastage,
        //                 othercost: othercost,
        //                 hiddenporderid: hiddenporderid,
        //                 usdrate2: usdrate2,
        //             },
        //             url: 'Customerporder/Customerpordertupdate',
        //             success: function (result) { //alert(result);
        //                 // console.log(result);
        //                 var obj = JSON.parse(result);
        //                 if(obj.status==1){
        //                     $('#modalgrnadd').modal('hide');
        //                     setTimeout(window.location.reload(), 3000);
        //                 }
        //                 action(obj.action);
        //             }
        //         });
        //     }

        // });
        $('#dataTable tbody').on('click', '.btnconfirm', function() {
            var id = $(this).attr('id'); 
            Swal.fire({
                title: "Do you want to approve this sales order?",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Approve",
                denyButtonText: `Reject`
            }).then((result) => {
                if (result.isConfirmed) {
                    var confirmnot = 1;
                    confirmsalesorder(confirmnot, id);
                } else if (result.isDenied) {
                    var confirmnot = 2;
                    confirmsalesorder(confirmnot, id);
                } 
            });
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

    function confirmsalesorder(confirmnot, id){
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
                    url: '<?php echo base_url() ?>Customerporder/Customerporderconfirm/' + id + '/' + confirmnot,
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
