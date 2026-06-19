<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\model\ProductModel;
use App\model\PostTerminal;
use App\model\CartModel;
use App\model\CartItems;
use App\model\OrderModel;
class CashierScreenController extends BaseController
{
    public function index()
    {
       return view('admin/pos');
    }




public function checkout()
{
    $CartItems = model('CartItems');
    $OrderModel = model('OrderModel');
    $CartModel = model('CartModel');

   

    // $order = $CartItems->getOrders();
    $grandtotal = $this->request->getPost('grandtotal');
    $items = json_decode($this->request->getPost('items'), true);

     $orderData = [
            'subtotal' =>   $grandtotal,
            'total_amount' =>  $grandtotal,
            'payment_method' => 'cash',
        ];

        $OrderModel->insert($orderData);

        if ($OrderModel->affectedRows() > 0) {

            $orderid = $OrderModel->getInsertID();

            $batchData =[];


            foreach ($items as $item) {
                
                $batchData[] = [
                    'order_id' => $orderid,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ];
            }

            $CartItems->insertBatch($batchData);

            if ($CartItems->affectedRows() > 0) {
                $CartModel->where('user_id', session()->get('user_id'))->delete();


                // return $this->response->setJSON([
                //     'status' => 'success',
                //     'message' => 'Cart is cleared!'
                // ]);

            }
        }

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Order Done!'
    ]);
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
    $user = session()->get('user_id');
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
        'quantity' => 1,
        'user_id' => $user,
    ]);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Item added to cart',
        'data' => $data
    ]);
}

public function addtocartClick()
{
   $model = model('CartModel');

   $product_id = $this->request->getPost('product_id');
   $user = session()->get('user_id');


   $existingItem = $model
   ->where('product_id', $product_id)->first();

   if ($existingItem) {
       // Increase quantity
        $model->update(
            $existingItem['cart_id'],
            [
                'quantity' => $existingItem['quantity'] + 1
            ]
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Item quantity updated',
        ]);
   }

   $model->insert([
    'product_id' => $product_id,
    'quantity' => 1,
    'user_id' => $user,
   ]);

   return $this->response->setJSON([
    'status' => 'success',
    'message' => 'Item added to cart!'
   ]);
}

public function updateQuantity()
{
    $model = model('CartModel');

    $cart_id = $this->request->getPost('id');
    $newqty = $this->request->getPost('newQty');

    $data = [
        'quantity' => $newqty,
    ];

    $model->update($cart_id, $data);

    if (!$model) {
       return $this->response->getJSON([
        'status' => 'error',
        'message' => 'Data not updated!'
       ]);
    }

    return $this->response->getJSON([
        'status' => 'success',
        'message' => 'Data updated successfully!'
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
