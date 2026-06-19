<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1>Category</h1>

<button type="button" class="btn btn-primary mb-3 btn-sm" data-toggle="modal" data-target="#modal-add-category">Add Record</button>

<div class="card">
	<div class="card-body">
		<table id="mycategorytable" class="table table-striped table-sm table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>Category Nane</th>
			<th>Action</th>

		</tr>
	</thead>
	<tbody id="categoryRow">
		
	</tbody>
</table>
	</div>
</div>


<div class="modal fade" id="modal-add-category">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create New Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				
			</div>

			<div class="modal-body">
				<div class="mb-3">
					<label>Category Name</label>
					<input type="text" class="form-control" name="category_name" id="category_name">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="addCategory()">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal-update-category">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Update Category Details</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<input type="hidden" id="categoryID">
					<label>Category Name</label>
					<input type="text" class="form-control" name="u_category_name" id="u_category_name">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="updateCategory()">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?= $this->endSection() ?>