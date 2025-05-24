<?php

namespace App\Controllers;

use App\Models\Users;
use Core\View\View;
use Core\Requests;

class UserController{

    public function __construct(){
       
    }

    public function index(Requests $request){
       
        $user = new Users();
        /*echo '<pre>';
        var_dump($user->all());*/

        View::render("home",["users" => $user->all()]);

    }

    public function create(Requests $requests){
       
        $user = new Users();
        $user->insert($requests->all());

    }

    public function list(){
      
       $user = new Users();
       var_dump($user->all());

    }

    public function remove($id){
        $user = new Users();
        echo $user->delete($id); 
    }
}

