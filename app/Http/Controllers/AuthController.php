<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function showLoginForm(){
        return view('layouts.admin',['title' => 'Maintenance Mode', 'routeName' =>'a']);
    }
}
