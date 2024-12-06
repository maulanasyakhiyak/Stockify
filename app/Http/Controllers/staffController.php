<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class staffController extends Controller
{
   public function index(){
    return redirect()->route('staff.dashboard');
   }

   public function dashboard(){
    return view('staffpage.dashboard');
   }

}
