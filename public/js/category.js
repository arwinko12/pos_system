load_category();
function load_category() {
	$.ajax({
			url: '/admin/category/fetch',
			type: 'get',
			dataType: 'json',
			success: function (response) {
				let rows = '';
				let counter = 0;
				$.each(response, function(index, category) {
					rows +=
				`
					<tr>
						<td>${++counter}</td>
						<td>${category.category_name}</td>
						<td><div class="btn-group">
							<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#" id="editCategoryButton" data-id="${category.category_id}" data-name="${category.category_name}" data-toggle="modal" data-target="#modal-update-category">Edit</a>
								<a class="dropdown-item" href="#">Delete</a>

							</div>
						</div></td>
					</tr>
				`;
				});

				$('#categoryRow').html(rows);
				$('#mycategorytable').DataTable();
			}
		});
}


function addCategory(){
	let category_name = $('#category_name').val();

	$.ajax({
			url: '/admin/category/create',
			type: 'post',
			data: {
				category_name: category_name,
			},
			success: function (response) {
				// alert(response)
				load_category();
			}
		});
}

$(document).on('click','#editCategoryButton', function(){
$('#categoryID').val($(this).data('id'));
	$('#u_category_name').val($(this).data('name'));
	// alert()
})


function updateCategory(){

	let categoryID = $('#categoryID').val();
	let u_category_name = $('#u_category_name').val();
	$.ajax({
			url: '/admin/category/update',
			type: 'post',
			data: {
				categoryID: categoryID,
				u_category_name: u_category_name
			},
			success: function (response) {
				alert(response)
				load_category();
			}
		});
}