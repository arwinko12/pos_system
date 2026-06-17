<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<h1>Users</h1>

<button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#modal-add-users">Add Record</button>

<table id="UserTable" class="table table-striped table-sm table-hover">
	<thead>
		<tr>
			<th>No.</th>
			<th>FullName</th>
			<th>Username</th>
			<th>Role</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody id="userTable">
	
	</tbody>
</table>


<div class="modal fade" id="modal-add-users">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create New User</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				
			</div>
			<div class="modal-body">
				<div class="mb-3">
					<label>FullName</label>
					<input type="text" class="form-control" name="full_name" id="full_name">
				</div>

					<div class="mb-3">
					<label>Username</label>
					<input type="text" class="form-control" name="username" id="username">
				</div>

					<div class="mb-3">
					<label>Password</label>
					<input type="text" class="form-control" name="password" id="password">
				</div>

					<div class="mb-3">
					<label>role</label>
					<select class="c-select form-control" name="role" id="role">
						<option selected>Open this select menu</option>
						<option value="admin">Admin</option>
						<option value="staff">Staff</option>
						<option value="cashier">Cashier</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="CreateUsers()">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?= $this->endSection() ?>