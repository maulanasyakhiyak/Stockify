<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;

class userController extends Controller
{
    protected $userRepository;
    
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        
    }

    public function index()
    {
        $users = $this->userRepository->index(5);
        return view('adminpage.pengguna.pengguna', compact('users'));
    }

    public function newUser(){
        return view('adminpage.pengguna.pengguna_baru');
    }
    public function newUserProcess(){
        return view('adminpage.pengguna.pengguna_baru');
    }
}
