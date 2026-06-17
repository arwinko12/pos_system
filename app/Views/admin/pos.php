<?= $this->extend('layouts/admin') ?>

<?=  $this->section('content') ?>
<h5>POS Terminal</h5>
<div class="row">

	<div class="col-lg-8">
        <div class="row">
            <div class="col-sm-4">
                <div class="input-group input-group-md mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-filter"></i></span>
                  </div>
                 <select class="c-select form-control" id="categoryOptions">
                    
                </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="input-group input-group-md mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fas fa-search"></i></span>
                  </div>
                  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
        </div>

		<div class="row" id="rowGallery"></div>

		<div class="d-flex justify-content-center mt-3">
    <ul class="pagination" id="pagination"></ul>
</div>
	</div>
<div class="col-lg-4">

    <div class="card shadow-sm border-0 cart-container sticky-top " style="z-index: 1;">

        <!-- Header -->
        <div class="card-header bg-white border-0 pb-0">
        
         
            <h5 class="font-weight-bold mb-0">
                <i class="fas fa-shopping-cart text-primary mr-2"></i>
                Order Summary
            </h5>
            <div id="cart_error_msg"></div>
        </div>

        <div class="card-body">

            <!-- Barcode Input -->
            <div class="mb-3">
                <label class="font-weight-bold small text-muted">
                    Scan Barcode
                </label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white border-0">
                            <i class="fas fa-barcode"></i>
                        </span>
                    </div>

                    <input type="text"
                           class="form-control border-left-0"
                           id="scanbarcode"
                           placeholder="Scan or enter barcode">
                </div>
            </div>

            <!-- Cart Table -->
            <div class="table-responsive cart-table">
                <table class="table table-borderless table-sm align-middle mb-0">

                    <thead class="thead-light">
                        <tr>
                            <th>Product</th>
                            <th width="80">Qty</th>
                            <th width="100">Subtotal</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>

                    <tbody id="rowCart">

                        <!-- Example -->
                        <!--
                        <tr>
                            <td>Coke 1.5L</td>
                            <td>2</td>
                            <td>₱120</td>
                        </tr>
                        -->

                    </tbody>

                </table>
            </div>

            <!-- Total -->
            <div class="mt-3 border-top pt-3">

                <div class="d-flex justify-content-between">
                    <span class="font-weight-bold">
                        Total
                    </span>

                    <h4 class="text-danger font-weight-bold mb-0" id="totalAmount">

                    </h4>
                </div>

            </div>

            <!-- Buttons -->
            <div class="row mt-4">

                <div class="col-6">
                    <button class="btn btn-outline-dark btn-block">
                        <i class="fas fa-print mr-2"></i>
                        Receipt
                    </button>
                </div>

                <div class="col-6">
                    <button class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-credit-card mr-2"></i>
                        Checkout
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>
</div>
<?= $this->endSection() ?>