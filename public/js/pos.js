load_product_items();

let allProducts = [];
let currentPage = 1;
let itemsPerPage = 8; // 8 items = 2 rows in col-sm-3

function load_product_items(category_id = '', searchElement = '') {
    $.ajax({
        url: '/admin/pos/fetch',
        type: 'GET',
        dataType: 'json',
        data:{
            category_id: category_id,
            searchElement: searchElement
        },
        success: function(response) {

            allProducts = response;
            // console.log(response);
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
        <div class=" col-sm-3 col-6 p-1" >
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
                <button type="button" onclick="addTocartbtn(${product.product_id})" class="btn btn-primary rounded-circle btn-sm"><i class="fas fa-plus"></i></button>


                </div>
            </div>
        </div>
        `;
    });

    $('#rowGallery').html(rows);
}

function addTocartbtn(product_id){
$.ajax({
            url: '/admin/pos/clickadd',
            type: 'post',
            data: {
                product_id: product_id
            },
            success: function (response) {
                // console.log(response);
                load_cart_items();
                loadTotalAmountCart();
            },
            error: function(xhr, status, error){
            console.log(xhr.responseText);
        }
        });
}

$('#print-reciept-btn').on('click', function () {

    $.ajax({
        url: '/admin/pos/receipt',
        type: 'GET',
        dataType: 'json',

        success: function (response) {

            if (response.length === 0) {
                alert('No receipt found.');
                return;
            }

            // Dahil naka orderBy DESC ka, unang data ang latest order
            let invoiceNo = response[0].invoice_no;
            let orderDate = response[0].date_ordered;
            let totalAmount = response[0].total_amount;
            let paymentMethod = response[0].payment_method;

            let items = '';

            $.each(response, function (index, item) {

                // Para isang invoice lang ang ipakita
                if (item.invoice_no === invoiceNo) {

                    items += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td>${item.quantity}</td>
                            <td>${parseFloat(item.price).toFixed(2)}</td>
                            <td>${parseFloat(item.subtotal).toFixed(2)}</td>
                        </tr>
                    `;
                }
            });

            let receipt = `
                <div style="font-family:monospace; padding:20px; widh: 100%;">
                    <h3 style="text-align:center;">
                        MY POS STORE
                    </h3>

                    <hr>

                    <p>
                        Invoice : ${invoiceNo}<br>
                        Date : ${orderDate}<br>
                        Payment : ${paymentMethod}
                    </p>

                    <table width="100%" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th align="left">Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${items}
                        </tbody>
                    </table>

                    <hr>

                    <h4 style="text-align:right;">
                        TOTAL : ₱${parseFloat(totalAmount).toFixed(2)}
                    </h4>

                    <p style="text-align:center;">
                        Thank you for your purchase!
                    </p>
                </div>
            `;

            // Popup Window
            let printWindow = window.open('', '', 'width=400,height=600');

            printWindow.document.write(receipt);
            printWindow.document.close();
            printWindow.focus();

            // Auto Print
            printWindow.print();
            // printWindow.close(); // optional
        },

        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});


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

                            <button
                                type="button"
                                class="btn btn-sm btn-light minusQty"
                                data-id="${cart.cart_id}"
                                data-current-qty="${qty}">
                                <i class="fas fa-minus"></i>
                            </button>

                            <input type="text"
                                   class="form-control text-center  qty-input" 
                                    data-id="${cart.cart_id}" 
                                    data-prod="${cart.product_id}"
                                    data-qty="${qty}"
                                    data-subtotal="${totalAmount}"
                                   value="${qty}"
                                   readonly>

                            <button type="button"
                                    class="btn btn-sm btn-light plusQty"
                                    data-id="${cart.cart_id}" data-currentQty="${qty}">
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

$(document).on('click', '.minusQty', function (e) {
    e.preventDefault();

    let id = $(this).data('id');
    let input = $(this).siblings('.qty-input');
    let qty = parseInt(input.val()) || 0;

    if (qty <= 0) {
        return; // prevent negative values
    }

    let newQty = qty - 1;
// alert(newQty)
    $.ajax({
        url: '/admin/pos/updateqty',
        type: 'POST',
        data: {
            id: id,
            newQty: newQty
        },
        success: function (response) {
            // console.log(response);
            loadTotalAmountCart();
            load_cart_items();
        }
    });
});

$('#checkout-btn').on('click', function () {

   let items = [];
   let grandtotal = $('#grandtotal').val();
$('.qty-input').each(function () {
    items.push({
        product_id: $(this).data('prod'),
        quantity: parseInt($(this).val()),
        subtotal: $(this).data('subtotal'),
    });
});


if (items === "" || grandtotal === "") {
    $('#cart_error_msg').html(`<div class="alert alert-danger text-center" role="alert">
                         <strong>Oops</strong> Cart is empty!
                     </div>`).show().fadeOut(3000);
}else{
        // alert(JSON.stringify(items));
    $.ajax({
        url: '/admin/pos/inserOrderItems',
        type: 'POST',
        data: {
           items: JSON.stringify(items),
           grandtotal: grandtotal
        },
        success: function (response) {
            // console.log(response);
            load_cart_items();
              if (response.status === "success") {
                   $('#cart_error_msg').html(`<div class="alert alert-success text-center" role="alert">
                        <strong>Success</strong> ${response.message}
                     </div>`).show();

            } else if (response.status === 'error') {

                 $('#cart_error_msg').html(`<div class="alert alert-danger text-center" role="alert">
                         <strong>Error</strong> ${response.message}
                     </div>`).show();
            }
            $('#totalAmount').text('₱ 0.00');
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText);
        }

    });
}


});


$(document).on('click', '.plusQty', function (e) {
    $('#cart_error_msg').hide();
    e.preventDefault();
    let id = $(this).data('id');
    let input = $(this).siblings('.qty-input');
    let qty = parseInt(input.val()) || 0;

     let newQty = qty + 1; 

      $.ajax({
        url: '/admin/pos/updateqty',
        type: 'POST',
        data: {
            id: id,
            newQty: newQty
        },
        success: function (response) {
            // console.log(response);
         
            loadTotalAmountCart();
            load_cart_items();
        }
    });
});

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
                $('#grandtotal').val(response.total_price);
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
                rows = '<option value="" selected>All Category</option>';
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
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

$('#categoryOptions').on('change', function () {
    let category = $(this).val();
    let search = $('#searchItem').val();

    load_product_items(category, search);
});

$('#searchItem').on('keyup', function () {
    let search = $(this).val();
    let category = $('#categoryOptions').val();

    load_product_items(category, search);
});