<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use PhpParser\Node\Stmt\Else_;

class userController extends Controller
{
    protected $userRepository;
    protected $userService;
    
    public function __construct(UserRepository $userRepository,UserService $userService)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        
    }

    public function index(){
        $users = $this->userRepository->index();
        return view('adminpage.pengguna.pengguna', compact('users'));
    }

    public function create(){  
        return view('adminpage.pengguna.pengguna_baru');
    }
    public function store(Request $req){
        // dd($req->all());
        $result = $this->userService->store([
        'new_first_name' => $req->input('new_first_name'),
        'new_last_name' => $req->input('new_last_name'),
        'new_email' => $req->input('new_email'),
        'new_password' => $req->input('new_password'),
        'new_password_confirmation' => $req->input('new_password_confirmation'),
        'new_role' => $req->input('new_role')
        ]);

        if($result['status'] == 'success'){    
            return redirect()->route('admin.users.index')->with('success', $result['message']);
        }
        return redirect()->back()->withErrors($result['message']);

    }

    public function update(Request $request, $id){
        $result = $this->userService->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email'      => $request->input('email'),
            'role'       => $request->input('role'),
        ],$id);
        // dd($result);    
        if($result == 'unchanged'){
            return redirect()->back();
        }
        if($result['status'] == 'success'){
            return redirect()->back()->with($result['status'], $result['message']);
        }else{
            return redirect()->back()->withErrors( $result['message']);
        }
    }
    public function destroy($id){
        $result = $this->userService->destroy($id);
        if($result['status'] == 'success'){
            return redirect()->back()->with($result['status'], $result['message']);
        }else{
            return redirect()->back()->withErrors( $result['message']);
        }
    }
}
