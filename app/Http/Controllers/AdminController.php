<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('adminpage.dashboard');
    }
    public function product(){
        return view('adminpage.product');
    }
    public function stok(){
        return view('adminpage.stok');
    }
    public function suplier(){
        return view('adminpage.suplier');
    }
    public function pengguna(){
        return view('adminpage.pengguna');
    }
    public function laporan(){
        return view('adminpage.laporan');
    }
    public function settings(){
        return view('adminpage.settings');
    }
}
