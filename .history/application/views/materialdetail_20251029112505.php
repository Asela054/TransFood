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
                        <h1 class="page-header-title ">
                            <div class="page-header-icon"><i class="fas fa-shopping-basket"></i></div>
                            <span>Material Details</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
            	<div class="card">
            		<div class="card-body p-0 p-2">
            			<div class="row">
            				<div class="col-4">
            					<form action="<?php echo base_url() ?>Materialdetail/Materialdetailinsertupdate"
            						method="post" autocomplete="off">
            						<div class="form-row mb-1">
            							<div class="col">
            								<label class="small font-weight-bold">Material Category*</label>
            								<select class="form-control form-control-sm" name="materialcategory"
            									id="materialcategory" required>
            									<option value="">Select</option>
            									<?php foreach($materialcategory->result() as $rowmaterialcategory){ ?>
            									<option
            										value="<?php echo $rowmaterialcategory->idtbl_material_category ?>">
            										<?php echo $rowmaterialcategory->categoryname . ' - ' . $rowmaterialcategory->categorycode?>
            									</option>
            									<?php } ?>
            								</select>
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Material Name*</label>
            								<input type="text" class="form-control form-control-sm" name="materialname"
            									id="materialname">
            							</div>
            						</div>
            						<div class="form-row mb-1">
										<div class="col">
            								<label class="small font-weight-bold">Material Code*</label>
            								<input type="text" class="form-control form-control-sm" name="materialcode"
            									id="materialcode">
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Unit*</label>
            								<select class="form-control form-control-sm" name="unit" id="unit"
            									required>
            									<option value="">Select</option>
            									<?php foreach($unitlist->result() as $rowunitlist){ ?>
            									<option value="<?php echo $rowunitlist->idtbl_unit ?>">
            										<?php echo $rowunitlist->unitname ?></option>
            									<?php } ?>
            								</select>
            							</div>
            						</div>
									<div class="form-row mb-1">
                                        <div class="col">
            								<label class="small font-weight-bold">Unit per Ctn*</label>
            								<input type="text" class="form-control form-control-sm" name="unitperctn"
            									id="unitperctn">
            							</div>
										<div class="col">
            								<label class="small font-weight-bold">Re-order Level*</label>
            								<input type="text" class="form-control form-control-sm" name="reorder"
            									id="reorder">
            							</div>
            						</div>
            						<div class="form-group">
            							<label class="small font-weight-bold">Comment</label>
            							<textarea class="form-control form-control-sm" name="comment"
            								id="comment"></textarea>
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
            				<div class="col-8">
            					<div class="scrollbar pb-3" id="style-2">
            						<table class="table table-bordered table-striped table-sm nowrap" id="dataTable">
            							<thead>
            								<tr>
            									<th>#</th>
            									<th>Material Name</th>
												<th>Unit</th>
												<th>Unit per Ctn</th>
                                                <th>Category</th>
            									<th>Material Code</th>
            									<th>Re Order</th>
                                                <th>Comment</th>
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
<div class="modal fade" id="suppliermodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	aria-labelledby="suppliermodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="suppliermodalLabel">&nbsp;</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
            	<form action="<?php echo base_url() ?>Materialdetail/Supplierupdate" method="post" autocomplete="off">
					<div class="form-group mb-1">
						<label class="small font-weight-bold text-dark">Supplier*</label>
						<select class="form-control form-control-sm" name="supplier" id="supplier" required>
							<option value="">Select</option>
						</select>
					</div>
					<div class="form-group mb-1">
						<label class="small font-weight-bold">Unit Price*</label>
						<input type="text" class="form-control form-control-sm" name="unitprice" id="unitprice">
					</div>
						<input type="hidden" name="hidematerialid" id="hidematerialid" value="">
					<div class="form-group mt-2 text-right">
						<button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
							<?php if($addcheck==0){echo 'disabled';} ?>><i
								class="far fa-save"></i>&nbsp;Add Supplier</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Material Suppliers Modal -->
<div class="modal fade" id="materialSuppliersModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suppliers & Unit Prices</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm" id="supplierTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Supplier Name</th>
              <th>Unit Price</th>
            </tr>
          </thead>
          <tbody>
            <!-- Rows will be loaded dynamically -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include "include/footerscripts.php"; ?>
<script>
$(document).ready(function() {
    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

	$("#supplier").select2({
		dropdownParent: $('#suppliermodal'),
		width: '100%',
		ajax: {
			url: "<?php echo base_url() ?>Materialdetail/Getsupplierlist",
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
                { extend: 'csv', className: 'btn btn-success btn-sm', title: 'Machine Information', text: '<i class="fas fa-file-csv mr-2"></i> CSV', },
                { extend: 'pdf', className: 'btn btn-danger btn-sm', title: 'Machine Information', text: '<i class="fas fa-file-pdf mr-2"></i> PDF', },
                { 
                    extend: 'print', 
                    title: 'Machine Information',
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
                <style>
        :root {
            --primary: #8B4513;
            --secondary: #D2691E;
            --accent: #CD853F;
            --success: #28a745;
            --light: #f8f9fa;
            --dark: #343a40;
            --text-dark: #212529;
            --text-light: #f8f9fa;
            --border: #dee2e6;
            --shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .pos-container {
            display: grid;
            grid-template-columns: 250px 1fr 350px;
            grid-template-rows: 1fr auto;
            gap: 15px;
            height: 100vh;
            padding: 15px;
            background: white;
        }

        /* Categories Panel */
        .categories-panel {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .categories-header {
            background: var(--primary);
            color: white;
            padding: 15px;
            font-weight: 600;
            text-align: center;
        }

        .search-container {
            padding: 15px;
            border-bottom: 1px solid var(--border);
        }

        .categories-list {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .category-item {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .category-item:hover, .category-item.active {
            background-color: var(--secondary);
            color: white;
        }

        /* Products Panel */
        .products-panel {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .products-header {
            background: var(--primary);
            color: white;
            padding: 15px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 15px;
            flex: 1;
            overflow-y: auto;
        }

        .product-card {
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
        }

        .product-image {
            height: 100px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-info {
            padding: 10px;
        }

        .product-name {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .product-price {
            color: var(--success);
            font-weight: 700;
            font-size: 16px;
        }

        /* Cart Panel */
        .cart-panel {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .cart-header {
            background: var(--primary);
            color: white;
            padding: 15px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: var(--success);
            font-weight: 700;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-btn {
            width: 25px;
            height: 25px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .cart-summary {
            padding: 15px;
            border-top: 2px solid var(--border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total-row {
            font-weight: 700;
            font-size: 18px;
            color: var(--success);
            border-top: 1px solid var(--border);
            padding-top: 10px;
        }

        /* Customer Panel */
        .customer-panel {
            grid-column: 1 / span 2;
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 15px;
        }

        .customer-header {
            background: var(--primary);
            color: white;
            padding: 12px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .customer-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Payment Panel */
        .payment-panel {
            background: white;
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .payment-header {
            background: var(--primary);
            color: white;
            padding: 12px 15px;
            margin: -15px -15px 15px -15px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quick-amounts {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .amount-btn {
            padding: 8px;
            background: var(--light);
            border: 1px solid var(--border);
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .amount-btn:hover {
            background: var(--secondary);
            color: white;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .payment-method {
            padding: 10px;
            border: 2px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
        }

        .payment-method.active {
            border-color: var(--secondary);
            background: var(--secondary);
            color: white;
        }

        .checkout-btn {
            background: var(--success);
            color: white;
            border: none;
            padding: 15px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin-top: auto;
            transition: all 0.3s;
        }

        .checkout-btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        /* Utility Classes */
        .text-success { color: var(--success); }
        .text-accent { color: var(--accent); }
        .bg-light { background: var(--light); }
    </style>

    <div class="pos-container">
        <!-- Categories Panel -->
        <div class="categories-panel">
            <div class="categories-header">
                <i class="fas fa-list me-2"></i>Categories
            </div>
            <div class="search-container">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search categories...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="categories-list">
                <div class="category-item active">All Items</div>
                <div class="category-item">Appetizers</div>
                <div class="category-item">Main Courses</div>
                <div class="category-item">Desserts</div>
                <div class="category-item">Beverages</div>
                <div class="category-item">Specials</div>
            </div>
        </div>

        <!-- Products Panel -->
        <div class="products-panel">
            <div class="products-header">
                <span>Products</span>
                <div>
                    <button class="btn btn-sm btn-light me-2">
                        <i class="fas fa-chair"></i> Tables
                    </button>
                    <button class="btn btn-sm btn-light">
                        <i class="fas fa-globe"></i> Orders
                    </button>
                </div>
            </div>
            <div class="search-container">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search products...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="products-grid">
                <!-- Product cards will be dynamically loaded here -->
                <div class="product-card">
                    <div class="product-image">
                        <i class="fas fa-utensils fa-2x text-muted"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-name">Grilled Chicken</div>
                        <div class="product-price">$12.99</div>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <i class="fas fa-pizza-slice fa-2x text-muted"></i>
                    </div>
                    <div class="product-info">
                        <div class="product-name">Margherita Pizza</div>
                        <div class="product-price">$14.99</div>
                    </div>
                </div>
                <!-- Add more product cards as needed -->
            </div>
        </div>

        <!-- Cart Panel -->
        <div class="cart-panel">
            <div class="cart-header">
                <span>Cart</span>
                <span class="badge bg-light text-dark">3 items</span>
            </div>
            <div class="cart-items">
                <div class="cart-item">
                    <div class="cart-item-details">
                        <div class="cart-item-name">Grilled Chicken</div>
                        <div class="cart-item-price">$12.99</div>
                    </div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <span>1</span>
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
                <!-- More cart items -->
            </div>
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Tax:</span>
                    <span>$0.00</span>
                </div>
                <div class="summary-row">
                    <span>Discount:</span>
                    <span>$0.00</span>
                </div>
                <div class="summary-row total-row">
                    <span>Total:</span>
                    <span>$0.00</span>
                </div>
            </div>
        </div>

        <!-- Customer Panel -->
        <div class="customer-panel">
            <div class="customer-header">
                <span>Customer Information</span>
                <button class="btn btn-sm btn-light">
                    <i class="fas fa-plus"></i> Add Customer
                </button>
            </div>
            <div class="customer-fields">
                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" placeholder="Select or add customer">
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" class="form-control" placeholder="Phone number">
                </div>
                <div class="mb-3">
                    <label class="form-label">Loyalty Points</label>
                    <input type="text" class="form-control" value="0" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Transaction Notes</label>
                    <input type="text" class="form-control" placeholder="Add notes if needed">
                </div>
            </div>
        </div>

        <!-- Payment Panel -->
        <div class="payment-panel">
            <div class="payment-header">
                <span>Payment</span>
                <span>Invoice #001</span>
            </div>
            <div class="quick-amounts">
                <div class="amount-btn">₨100</div>
                <div class="amount-btn">₨500</div>
                <div class="amount-btn">₨1000</div>
                <div class="amount-btn">₨2000</div>
            </div>
            <div class="payment-methods">
                <div class="payment-method active">
                    <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                    <div>Cash</div>
                </div>
                <div class="payment-method">
                    <i class="fas fa-credit-card fa-2x mb-2"></i>
                    <div>Card</div>
                </div>
                <div class="payment-method">
                    <i class="fas fa-qrcode fa-2x mb-2"></i>
                    <div>Digital</div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Amount Tendered</label>
                <input type="number" class="form-control" placeholder="0.00">
            </div>
            <div class="mb-3">
                <label class="form-label">Change</label>
                <input type="text" class="form-control" value="0.00" readonly>
            </div>
            <button class="checkout-btn">
                <i class="fas fa-cash-register me-2"></i> CHECKOUT
            </button>
        </div>
    </div>

    <script>
        // Simple JavaScript for interactivity
        document.querySelectorAll('.category-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.category-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.querySelectorAll('.amount-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const amount = this.textContent.replace('₨', '');
                // Set the amount in the tender input
                document.querySelector('input[type="number"]').value = amount;
            });
        });
    </script>
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
                url: '<?php echo base_url() ?>Materialdetail/Materialdetailedit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#materialname').val(obj.materialname);
                    $('#materialcategory').val(obj.materialcategory);
                    $('#unitprice').val(obj.unitprice);
					$('#unitperctn').val(obj.unitperctn);
                    $('#materialcode').val(obj.materialcode);
                    $('#reorder').val(obj.reorderlevel);
                    $('#comment').val(obj.comment);
                    $('#supplier').val(obj.supplier);
					$('#unit').val(obj.unit);
                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });

	$('#dataTable tbody').on('click', '.btnSuppliers', function () {
		var id = $(this).attr('id');
		$('#hidematerialid').val(id);
		$('#suppliermodal').modal('show');
	});

	$('#dataTable').on('click', '.btnSupplierList', function () {
		var materialId = $(this).attr('id');

		$.ajax({
			url: "<?php echo base_url() ?>Materialdetail/getMaterialSuppliers",
			type: "POST",
			data: {
				material_id: materialId
			},
			dataType: "json",
			success: function (response) {
				var tbody = $("#supplierTable tbody");
				tbody.empty();
				if (response.length > 0) {
					$.each(response, function (i, item) {
						tbody.append(`
                        <tr>
                            <td>${i+1}</td>
                            <td>${item.suppliername}</td>
							<td>Rs. ${new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(item.unitprice)}</td>
                        </tr>
                    `);
					});
				} else {
					tbody.append(`<tr><td colspan="5" class="text-center">No suppliers found</td></tr>`);
				}

				$("#materialSuppliersModal").modal("show");
			}
		});
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