<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\model\CategoryModel;
class CategoryController extends BaseController
{
    public function index()
    {
       return view('admin/category');
    }

    public function fetchCategory()
    {
        $model = model('CategoryModel');

        $data = $model->getCategorybyName();

        return $this->response->setJSON($data);
    }


    public function createNewCategory()
    {
        $model = model('CategoryModel');

        $data = [
            'category_name' => $this->request->getPost('category_name'),
        ];


        if (!$this->validateData($data,[
            'category_name' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Please fill all fields');
        }

        $post = $this->validator->getValidated();

        $model->save([
            'category_name' => $post['category_name'],
        ]);


       return redirect()->to('admin/category')->with('success', 'data added successfully!');


    }

    public function updateCategory()
    {
       $model = model('CategoryModel');

       $id = $this->request->getPost('categoryID');

       $data = [

        'category_name' => $this->request->getPost('u_category_name'),
                            
    ];
      // if (!$this->validateData($data,[
      //       'category_id' => 'required',
      //       'category_name' => 'required',
      //       'description' => 'required'
      //   ])) {
      //       return redirect()->back()->withInput()->with('error', 'Please fill all fields');
      //   }




    $model->update($id, $data);

    return redirect()->to('admin/category')->with('success', 'Data Updated successfully!');
    }
}
