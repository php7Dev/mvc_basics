<?php

namespace App\Controllers;

use App\Models\Users;
use Core\View\View;
use Core\Requests;

class UserController{

    public function __construct(){
       
    }

    public function index(Requests $request){
        
        print_r($request->all());

    }

    public function list(){
      
        $user = new Users();
     
        /*
        $user->insert([
            'u_name' => 'Nagd',
            'u_pwd' => 29,
            'u_cdate' => date('Y-m-d')
       ]);*/

       var_dump($user->all());

    }

    public function remove($id){
        $user = new Users();
        echo $user->delete($id); 
    }
}

