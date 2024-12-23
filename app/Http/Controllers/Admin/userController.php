<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;

class userController extends Controller
{
    protected $userRepository;
    protected $userService;
    
    public function __construct(UserRepository $userRepository,UserService $userService)
    {
        $this->userService = $userService;
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
    public function newUserProcess(Request $req){
        $result = $this->userService->new_user([
        'new_first_name' => $req->input('new_first_name'),
        'new_last_name' => $req->input('new_last_name'),
        'new_email' => $req->input('new_email'),
        'new_password' => $req->input('new_password'),
        'confirm_new_password' => $req->input('confirm_new_password'),
        'new_role' => $req->input('new_role')
        ]);

        if($result['status'] == 'success'){    
            return redirect()->route('admin.pengguna')->with('success', $result['message']);
        }
        return redirect()->back()->withErrors($result['message']);

    }
}
