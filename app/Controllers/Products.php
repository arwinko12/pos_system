<?php

namespace App\Controllers;
// use App\model\ProductModel;

class Products extends BaseController
{
    protected $helpers = ['form'];
    public function Product_page(): string
    {
  

        return view('admin/products');

    }
     public function editProdView($id)
     {
        $model = model('ProductModel');
        $data['product'] = $model->getProductId($id);
         return view('admin/update_product_image', $data);
     }

     // public function updateProdview($id){

     //    $model = model('ProductModel');
     //    $data['product'] = $model->getProductsJoinCategory($id);
     //    return view('admin/edit_products', $data);
     // }
 public function fetchProducts()
{
    $model = model('ProductModel');

    $products = $model->getProducts();

    return $this->response->setJSON($products);
}

public function fetchProductCat()
{
    $model = model('ProductModel');
    $category = $model->getCategory();

    return $this->response->setJSON($category);
}
// public function save()
// {
//     $data = [
//         'category_id' => $this->request->getPost('category_id'),
//         'product_name' => $this->request->getPost('product_name'),
//         'price' => $this->request->getPost('price'),
//         'product_status' => $this->request->getPost('product_status'),
//     ];

//     return $this->response->setJSON($data);
// }
public function CreateNewProduct()
{
    helper(['form']);

    $data = $this->request->getPost([
        'barcode',
        'category_id',
        'product_name',
        'description',
        'price',
        'product_status',
        'product_url_img'
    ]);

    // Get uploaded file
    $image = $this->request->getFile('product_image');

    // Base validation rules
    $rules = [
        'barcode'         => 'required',
        'category_id'     => 'required|numeric',
        'product_name'    => 'required|max_length[100]',
        'description' => 'required',
        'price'           => 'required|max_length[50]',
        'product_status'  => 'required|max_length[100]',
    ];

    // Validate image only if uploaded
    if ($image && $image->isValid()) {
        $rules['product_image'] =
            'max_size[product_image,2048]
            |is_image[product_image]
            |mime_in[product_image,image/jpg,image/jpeg,image/png,image/webp]';
    }

    // Run validation
    if (!$this->validate($rules)) {
        return $this->response->setJSON([
            'status' => 'error',
            'errors' => $this->validator->getErrors()
        ])->setStatusCode(422);
    }

    // Default image
    $imageName = null;

    // Case 1: User uploaded image
    if ($image && $image->isValid() && !$image->hasMoved()) {

        $imageName = $image->getRandomName();

        $image->move(
            FCPATH . 'uploads/products',
            $imageName
        );
    }

    // Case 2: Barcode API image URL
    elseif (!empty($data['product_url_img'])) {

        $imageName = $data['product_url_img'];
    }

    $model = model('ProductModel');

    // Save product
    $model->save([
        'barcode'         => $data['barcode'],
        'category_id'     => $data['category_id'],
        'product_name'    => $data['product_name'],
        'description'     => $data['description'],
        'price'           => $data['price'],
        'product_status'  => $data['product_status'],
        'product_image'   => $imageName
    ]);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Product created successfully!'
    ]);
}

public function GetProductBarcode()
{
    $barcode = $this->request->getPost('barcode');

    $url = "https://api.upcitemdb.com/prod/trial/lookup?upc=" . $barcode;

    $response = file_get_contents($url);

    $data = json_decode($response, true);

    if (!empty($data['items'])) {

        $item = $data['items'][0];

        return $this->response->setJSON([
            'status' => 'success',
            'product_name' => $item['title'] ?? '',
            'description' => $item['description'] ?? '',
            'product_image' => $item['images'][0] ?? '',
            'price' => $item['lowest_recorded_price'] ?? '0'
        ]);
    }

    return $this->response->setJSON([
        'status' => 'error'
    ]);
}

public function deleteProduct()
{
    $model = model('ProductModel');
    $id = $this->request->getPost('product_id');

    if ($id && $model->delete($id)) {
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Product Deleted successfully',
        ]);
    }

    // FIXED: Added fallback error response
    return $this->response->setJSON([
        'status'  => 'error',
        'message' => 'Failed to delete product or invalid ID.',
    ])->setStatusCode(400);
}

public function upload()
{
    $model = model('ProductModel');
    $product_id = $this->request->getPost('product_id');

    $validationRule = [
        'userfile' => [
            'label' => 'Image File',
            'rules' => [
                'uploaded[userfile]',
                'is_image[userfile]',
                'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                'max_size[userfile,2048]', // Bumped to 2MB since 100KB is very small for modern photos
            ],
        ],
    ];

    // FIX 4: Use $this->validate() so CodeIgniter inspects global files arrays automatically
    if (! $this->validate($validationRule)) {
        $data = ['errors' => $this->validator->getErrors()];
        return view('admin/products', $data);
    }

    $img = $this->request->getFile('userfile');

    if ($img->isValid() && ! $img->hasMoved()) {
        
        // FIX 3: Generate a safe random string filename
        $newName = $img->getRandomName();

        // Save directly to public/uploads/products/ using FCPATH
        $img->move(FCPATH . 'uploads/products', $newName);

        // FIX 1 & 2: Create a clean string path and execute the update inside the SUCCESS block
        $dbImagePath = 'uploads/products/' . $newName;

        $model->update($product_id, [
            'product_image' => $dbImagePath 
        ]);

        // Redirect back to your dashboard with a success message state
        return redirect()->to('/admin/products')->with('success', 'Image uploaded successfully!');
    }

    // Error Fallback
    $data = ['errors' => ['userfile' => 'The file is invalid or has already been moved.']];
    return view('admin/products', $data);
}


public function updateProductsinfo()
{
    $model = model('ProductModel');
    $id = $this->request->getPost('product_id');
    $data = [
        
        'category_id' => $this->request->getPost('u_category_id'),
        'product_name' => $this->request->getPost('u_product_name'),
        'description' => $this->request->getPost('u_description'),
        'price' => $this->request->getPost('u_price'),
        'product_status' => $this->request->getPost('u_product_status'),
        
    ];

    $model->update($id, $data);

    if (!$model) {
        return redirect()->to('/admin/products')->with('error', 'Data not updated!');
    }

   return redirect()->to('/admin/products')->with('success', 'Image updated successfully!');
}

}
