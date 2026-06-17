<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1>Products</h1>

<div class="mb-3">

	
	<div class="modal fade" id="modal-add-products">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<h4 class="modal-title">Add Product Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
								<div class="mb-3">
						<label>Barcode</label>
						<input type="text" id="barcode" class="form-control">
					</div>

				<div class="mb-3">
					<label>Category</label>
					<select class="form-control js-example-basic-single" style="width: 100%;"  id="category_id" name="category_id"></select>
				</div>

				<div class="mb-3">
					<label>Product Name</label>
					<input type="text" id="product_name" name="product_name" class="form-control">
				</div>
					<div class="mb-3">
					<label>Description</label>
					<textarea class="form-control" name="description" id="description"></textarea>
				</div>
						</div>
							<div class="col-md-6">
								<div class="mb-3">
					<label>Price</label>
					<input type="text" id="price" name="price" class="form-control">
				</div>

				<div class="mb-3">
					<label>Product Status</label>
					<select class="c-select form-control" id="product_status" name="product_status">
						<option selected>Open this select menu</option>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>
			<div class="mb-3">
				<label>Upload Product Image</label>

				<input type="file" class="form-control" id="product_image" name="product_image">
				<input type="hidden" class="form-control" id="product_url_img" name="product_url_img">

			</div>
			  <div class="col-md-12 text-center mb-3">
        <img id="previewImage"
             src="https://via.placeholder.com/150"
             class="img-fluid rounded border"
             style="height:150px;width:150px;object-fit:cover;">
    </div>
						</div>
					</div>
				


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="addNewProducts">Submit</button>
				</div>
			
					
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>


<!-- end of add modal -->

<div class="modal fade" id="modal-update-products">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Product Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>

			</div>
			<div class="modal-body">
				
				<div class="mb-3">
					<label>Category</label>
					<input type="hidden" id="product_id">
					<select class="c-select form-control" id="u_category_id" name="u_category_id"></select>
				</div>

				<div class="mb-3">
					<label>Product Name</label>
					<input type="text" id="u_product_name" name="u_product_name" class="form-control">
				</div>
				<div class="mb-3">
					<label>Description</label>
					<textarea class="form-control" id="u_description"></textarea>
				</div>
				<div class="mb-3">
					<label>Price</label>
					<input type="text" id="u_price" name="u_price" class="form-control">
				</div>

				<div class="mb-3">
					<label>Product Status</label>
					<select class="c-select form-control" id="u_product_status" name="u_product_status">
						<option selected>Open this select menu</option>
						<option value="active">Active</option>
						<option value="inactive">Inactive</option>
					</select>
				</div>
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="updateProductInfo()">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<button type="button" class="btn btn-primary mb-3 btn-sm" data-toggle="modal" data-target="#modal-add-products">Add Record</button>
<div class="table-responsive">
		<table id="productTable" class="table table-hover table-striped table-sm">
	<thead>
		<tr>
			<th>Product Image</th>
			<th>Product Name</th>
			<!-- <th>Description</th> -->
			<th>Price</th>
			<th>Category</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="mytable">

		
		
	</tbody>
</table>
</div>


<?= $this->endSection() ?>