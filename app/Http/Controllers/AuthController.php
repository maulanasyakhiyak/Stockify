<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function showLoginForm(){
        return view('example.content.authentication.sign-in',['title' => 'Maintenance Mode']);
    }
}
