load_products();

function load_products() {

    $.ajax({
    url: '/admin/products/fetch',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        let rows = '';
        let status = '';
        let text = '';
        $.each(response, function(index, product) {

        	if (product.product_status ==="active") {
        	 status = ' backgroundBadge-success';
             text = 'Active';
        	}else{
        	 status = ' backgroundBadge-danger';
             text = 'InActive';
        	}


            rows += `
                <tr>
                <td><img src="${product.product_image}" style="width: 70px; height:70px;"></td>
                    <td>
                    ${product.product_name}<br>
                <small class="text-secondary">Barcode: ${product.barcode}</small>
                    </td>
                    <td>₱${parseFloat(product.price).toFixed(2)}</td>
                    <td>${product.category_name}</td>

            	<td><span class="${status} font-weight-bold">${text}</span> </td>
            	<td>
            			<div class="dropdown open">
            				<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            					Action
            				</button>
            				<div class="dropdown-menu" aria-labelledby="dropdownMenu1">
            					<a class="dropdown-item" onclick="editProducts(${product.product_id})">Upload Image</a>
            					<a class="dropdown-item" onclick="deleteProducts(${product.product_id})">Delete</a>
            					<a class="dropdown-item" id="editData"
            					   data-id="${product.product_id}"
            					   data-category="${product.category_id}"
            					   data-product="${product.product_name}"
                                   data-description="${product.description}"
            					   data-price="${product.price}"
            					   data-status="${product.product_status}" data-toggle="modal" data-target="#modal-update-products">Edit</a>
            				</div>
            			</div>
            	</td>
                </tr>
            `;
        });

        $('#mytable').html(rows);
            $('#productTable').DataTable();
    }
});
}

$(document).on('click', '#editData', function(){
    $('#product_id').val($(this).data('id'));
	$('#u_category_id').val($(this).data('category'));
	$('#u_product_name').val($(this).data('product'));
    $('#u_description').val($(this).data('description'));
	$('#u_price').val($(this).data('price'));
	$('#u_product_status').val($(this).data('status'));
});
	
	
function updateProductInfo(){
	let product_id = $('#product_id').val();
	let u_category_id = $('#u_category_id').val();
	let u_product_name = $('#u_product_name').val();
    let u_description = $('#u_description').val();
	let u_price = $('#u_price').val();
	let u_product_status = $('#u_product_status').val();


$.ajax({
		url: '/admin/product/update',
		type: 'post',
		data: {
			product_id: product_id,
			u_category_id: u_category_id,
			u_product_name: u_product_name,
            u_description: u_description,
			u_price: u_price,
			u_product_status: u_product_status
		},
		success: function (response) {
            console.log(response);
			load_products();
		}
	});


} 


function editProducts(product_id){
	window.location = `/admin/product/edit/${product_id}`;
}

function deleteProducts(product_id){
	$.ajax({
			url: '/admin/delete/product',
			type: 'post',
			data: {
				product_id: product_id
			},
			success: function (response) {
				load_products();
			}
		});
}

$('#barcode').on('input', function (e) {

   

        e.preventDefault();

        let barcode = $(this).val().trim();

        if (barcode == '') return;

        $.ajax({
            url: '/admin/products/get-product-barcode',
            type: 'POST',
            data: {
                barcode: barcode
            },
            dataType: 'json',

            beforeSend: function () {
                $('#product_name').val('Loading...');
            },

      success: function (response) {

    console.log(response);

    if (response.status == 'success') {

        console.log(response.product_image);

        $('#product_name')
            .val(response.product_name);

        $('#price')
            .val(response.price);

        $('#previewImage').attr('src', response.product_image);
        $('#description').val(response.description);
        $('#product_url_img')
            .val(response.product_image);

    } else {

        alert('Product not found');
    }
},
            error: function () {
                alert('API Error');
            }
        });


});


$('#addNewProducts').on('click', function () {

    let formData = new FormData();
    formData.append('barcode', $('#barcode').val());
    formData.append('category_id', $('#category_id').val());
    formData.append('product_name', $('#product_name').val());
    formData.append('description', $('#description').val());
    formData.append('price', $('#price').val());
    formData.append('product_status', $('#product_status').val());

    let product_url_img = $('#product_url_img').val();
    // Add image file
    let productImage = $('#product_image')[0].files[0];
    formData.append('product_image', productImage);

    if (productImage === "") {
	formData.append('product_image', productImage);
    }else{
    formData.append('product_url_img', product_url_img);
    }

    $.ajax({
        url: '/admin/products/create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            alert(response.message);
            load_products();

            // Optional: reset form
            $('#category_id').val('');
            $('#product_name').val('');
            $('#description').val();
            $('#price').val('');
            $('#product_status').val('');
            $('#product_image').val('');
        },
        error: function (xhr) {
            console.log(xhr.responseJSON);
            alert('Something went wrong.');
        }
    });

});

// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
})
loadSelectionCategory();
function loadSelectionCategory() {
     
	$.ajax({
			url: '/admin/category/fetch',
			type: 'get',
			dataType: 'json',
			success: function (response) {
				let rows = '';
				rows = '<option selected>Open this select menu</option>';
				$.each(response, function(index, categories){
					
					rows +=
				`
					
					<option value="${categories.category_id}">${categories.category_name}</option>
				`; 
				});
		
				$('#category_id').html(rows);
				$('#u_category_id').html(rows);
			}
		});
}


