function CreateUsers(){
	let full_name = $('#full_name').val();
	let username = $('#username').val();
	let password = $('#password').val();
	let role = $('#role').val();

	$.ajax({
			url: '/admin/users/create',
			type: 'post',
			data: {
				full_name: full_name,
				username: username,
				password: password,
				role: role
			},
			success: function (response) {
				
				load_users();
			}
		});
}

load_users();
function load_users() {
	$.ajax({
			url: '/admin/users/fetch',
			type: 'get',
			dataType: 'json',
			success: function (response) {
				let rows = '';
				let counter  = 0;
				$.each(response, function(index, users){
					rows += 
						`		<tr>
									<td>${++counter}</td>
									<td>${users.full_name}</td>
									<td>${users.username}</td>
									<td>${users.role}</td>
						<td>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#">Edit</a>
								<a class="dropdown-item" href="#">Delete</a>
								<a class="dropdown-item" href="#">View</a>
							</div>
						</div>
						</td>
								</tr>
						`;
				});

				$('#userTable').html(rows);
				$('#UserTable').DataTable();
			}
		});
}


