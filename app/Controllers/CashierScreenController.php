<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\model\ProductModel;
use App\model\PostTerminal;
use App\model\CartModel;
class CashierScreenController extends BaseController
{
    public function index()
    {
       return view('admin/pos');
    }

public function getProductItems()
{
    $model = model('ProductModel');

    $category_id = $this->request->getGet('category_id');
    $searchElement = $this->request->getGet('searchElement');

    $data = $model->getProducts($category_id, $searchElement);

    return $this->response->setJSON($data);
}

    public function fetchCartItems()
    {
        $model = model('PosTerminal');
        $data = $model->getCartItem();

        return $this->response->setJSON($data);
    }
public function getBarcode()
{
    $productModel = model('PosTerminal');
    $cartModel = model('CartModel');

    $barcode = trim($this->request->getPost('Barcode'));

    // Validate empty barcode
    if (empty($barcode)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Barcode is required'
        ]);
    }

    // Find product
    $data = $productModel->getItemsByBarcode($barcode);

    // Product not found
    if (!$data) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Item not found'
        ]);
    }

    $product_id = $data['product_id'];

    // Check if already in cart
    $existingItem = $cartModel
        ->where('product_id', $product_id)
        ->first();

    if ($existingItem) {

        // Increase quantity
        $cartModel->update(
            $existingItem['cart_id'],
            [
                'quantity' => $existingItem['quantity'] + 1
            ]
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Item quantity updated',
            'data' => $data
        ]);
    }

    // Insert new cart item
    $cartModel->insert([
        'product_id' => $product_id,
        'quantity' => 1
    ]);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Item added to cart',
        'data' => $data
    ]);
}


public function TotalCartAMount()
{
    $model = model('PosTerminal');
    $data = $model->getCartTotal();

    return $this->response->setJSON($data);
}

public function removeItemfromCart()
{
    $model = model('CartModel');
    $cartID = $this->request->getPost('cart_id');
    $data = $model->getUserById($cartID);

    if (!$data) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Unknown method!',
        ]);
    }
    $model->delete($data['cart_id']);

    return   $this->response->setJSON([
            'status' => 'success',
            'message' => 'data deleted successfully!',
        ]);
}

}
