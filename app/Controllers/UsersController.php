<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\model\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
       
        
       return view('admin/users');
    }

    public function UsersFetch()
    {
         $model = model('UserModel');

       $users = $model->getUsers();

       return $this->response->setJSON($users);

    }

  

  

    public function CreateNewUsers()
    {
         $model = model('UserModel');

         $rawData = [
            'full_name' => $this->request->getPost('full_name'),
            'username' => $this->request->getPost('username'),
            'user_password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
         ];

         if (!$this->validateData($rawData,[
            'full_name' => 'required|max_length[100]',
            'username' => 'required|max_length[100]',
            'user_password' => 'required|max_length[100]',
            'role' => 'required|max_length[100]',
         ])) {
             return redirect()->back()->withInput()->width('errors', 'data not validated! ');
         }

         $post = $this->validator->getValidated();

         $model->save([
            'full_name' => $post['full_name'],
            'username' => $post['username'],
            'user_password' => $post['user_password'],
            'role' => $post['role'],
        ]);

         return redirect()->to('admin/users')->with('success', 'data updated successfully!');


    }


    public function loginUser()
    {
        

        $rules = [
            'username' => 'required',
            'user_password' => 'required'
        ];

  

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $user_password = $this->request->getPost('user_password');

    
        $model = model('UserModel');

        $user = $model->getUserByUsername($username);

          if (!$user) {
            return redirect()
                ->to('/')
                ->with('error', 'User not found');
        }

       if (!password_verify($user_password, $user['user_password'])) {
           return redirect()->back()->with('error', 'Incorrect Username or Password');
       }

         session()->set([
            'user_id'  => $user['user_id'],
            'full_name' => $user['full_name'],
            'username' => $user['username'],
            'role' => $user['role'],
            'logged_in' => true
        ]);



        return redirect()->to('admin/dashboard');
    }

    public function logoutSession()
    {
       session()->destroy();
       return redirect()->to('/')->with('success', 'Logout Success!');
    }
}
