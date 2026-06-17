load_product_items();

let allProducts = [];
let currentPage = 1;
let itemsPerPage = 8; // 8 items = 2 rows in col-sm-3

function load_product_items(category) {

    $.ajax({
        url: '/admin/pos/fetch',
        type: 'GET',
        dataType: 'json',

        success: function(response) {

            allProducts = response;
            renderProducts();
            renderPagination();
        }
    });
}


function renderProducts() {

    let rows = '';

    // pagination start/end
    let start = (currentPage - 1) * itemsPerPage;
    let end = start + itemsPerPage;

    let paginatedProducts = allProducts.slice(start, end);

    $.each(paginatedProducts, function(index, product) {

        let productImage = '';

        if (
            product.product_image.startsWith('http://') ||
            product.product_image.startsWith('https://')
        ) {

            productImage = product.product_image;

        } else {

            productImage = '/' + product.product_image;
        }

        rows += `
        <div class="col-sm-3 g-0 col-6 mb-3">
            <div class="card border-1 card-items">

                <img class="card-img-top"
                     src="${productImage}"
                     alt="${product.product_name}">

                <div class="card-body">

                    <h6 class="product-name">
                        ${product.product_name}
                    </h6>

                    <small class="price-label">
                        Price
                    </small>

                    <p class="product-price">
                        ₱${parseFloat(product.price).toFixed(2)}
                    </p>

                </div>
            </div>
        </div>
        `;
    });

    $('#rowGallery').html(rows);
}


function renderPagination() {

    let totalPages = Math.ceil(allProducts.length / itemsPerPage);

    let pagination = '';

    // Previous button
    pagination += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="prev">
                Previous
            </a>
        </li>
    `;

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {

        pagination += `
            <li class="page-item ${currentPage === i ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">
                    ${i}
                </a>
            </li>
        `;
    }

    // Next button
    pagination += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="next">
                Next
            </a>
        </li>
    `;

    $('#pagination').html(pagination);
}


// Pagination click event
$(document).on('click', '.page-link', function(e) {

    e.preventDefault();

    let page = $(this).data('page');

    let totalPages = Math.ceil(allProducts.length / itemsPerPage);

    if (page === 'prev' && currentPage > 1) {

        currentPage--;

    } else if (page === 'next' && currentPage < totalPages) {

        currentPage++;

    } else if (!isNaN(page)) {

        currentPage = parseInt(page);
    }

    renderProducts();
    renderPagination();
});


function addTocart(product_id){
	alert(product_id)
}





load_cart_items();

function load_cart_items() {

    $.ajax({
        url: '/admin/pos/cart',
        type: 'GET',
        dataType: 'json',

        success: function(response) {

            let rows = '';
            let grandTotal = 0; // total of all cart items

            $.each(response, function(index, cart) {

                let qty = parseInt(cart.quantity);
                let item_price = parseFloat(cart.price);

                let totalAmount = qty * item_price;

              

                rows += `
                <tr>
                    <td>
                     <img style="height: 30px; width: 30px;" class="border-1"
                     src="${cart.product_image}"
                     alt="${cart.product_name}">
                    <br>
                    <small class="text-secondary" style="font-size:10px;">${cart.product_name}</small>
                    </td>

                    <td style="white-space: nowrap; width: 140px;">

                        <div class="qty-control">

                            <button type="button"
                                    class="btn btn-sm btn-light minusQty"
                                    data-id="${cart.id}">
                                <i class="fas fa-minus"></i>
                            </button>

                            <input type="text"
                                   class="form-control text-center qty-input"
                                   value="${cart.quantity}"
                                   readonly>

                            <button type="button"
                                    class="btn btn-sm btn-light plusQty"
                                    data-id="${cart.id}">
                                <i class="fas fa-plus"></i>
                            </button>

                        </div>

                    </td>

                    <td>
                        ₱${totalAmount.toFixed(2)}
                    </td>
                    <td><button class="btn btn-sm btn-light border-1" onclick="removeItemFromCart(${cart.cart_id})"><i class="fa fa-close text-danger"></i></button></td>
                </tr>
                `;


            });

            $('#rowCart').html(rows);


        }
    });
}

$('#scanbarcode').on('change', function () {
     $('#cart_error_msg').hide();
    let Barcode = $(this).val();

    $.ajax({
        url: '/admin/post/getbarcodeItem',
        type: 'post',
        dataType: 'json',
        data: {
            Barcode: Barcode
        },
        success: function (response) {
            loadTotalAmountCart();
            // Clear input
            $('#scanbarcode').val('');

            // Check status from controller
            if (response.status === 'success') {

                 $('#cart_error_msg').html(`<div class="alert alert-success text-center" role="alert">
                        <strong>Success</strong> ${response.message}
                     </div>`).show();
                // reload cart
                load_cart_items();

            } else if (response.status === 'error') {

                 $('#cart_error_msg').html(`<div class="alert alert-danger text-center" role="alert">
                         <strong>Error</strong> ${response.message}
                     </div>`).show();
            }
        },

        error: function (xhr, status, error) {
            // console.log(error);

            alert('May problem sa server request');
        }
    });
});

loadTotalAmountCart();
function loadTotalAmountCart() {
	$.ajax({
			url: '/admin/pos/totalamount',
			type: 'get',
			dataType: 'json',
			success: function (response) {
                // alert(response.total_price)
				$('#totalAmount').text('₱ ' + parseFloat(response.total_price).toFixed(2));
			}
		});
}

function removeItemFromCart(cart_id){
    $('#cart_error_msg').hide();
    $.ajax({
            url: '/admin/pos/deleteCartitem',
            type: 'post',
            data: {
                cart_id: cart_id,
            },
            success: function (response) {
                if (response.status ==="success") {

                     $('#cart_error_msg').html(`<div class="alert alert-success text-center" role="alert">
                        <strong>Success</strong> ${response.message}
                     </div>`).show();
                }else if(response.status === "error"){
                     $('#cart_error_msg').html(`<div class="alert alert-danger text-center" role="alert">
                         <strong>Error</strong> ${response.message}
                     </div>`).show();
                }
                load_cart_items();
                loadTotalAmountCart();
            }
        });
   }

fetchCategoriesPerName();
   function fetchCategoriesPerName() {

    $.ajax({
            url: '/admin/category/fetch',
            type: 'get',
            dataType: 'json',
            success: function (response) {
                let rows = '';
                rows = '<option selected>All Category</option>';
                $.each(response, function(i, category){
                    rows +=
                `
                     <option value="${category.category_id}">${category.category_name}</option>
                `;
                });

                 $('#categoryOptions').html(rows);
            }
        });
      
   }


$('#categoryOptions').on('change', function(){
    let category = $(this).val();
});
