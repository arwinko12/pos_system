<?php

namespace App\Controllers;
use App\model\UserModel;
class Home extends BaseController
{
    public function index()
    {
       if (session()->get('logged_in')) {
            return redirect()->to('admin/index');
        }else{
             return view('index');
        }
       
    }

     public function Admin()
    {

      
        return view('admin/index');
    }

}
