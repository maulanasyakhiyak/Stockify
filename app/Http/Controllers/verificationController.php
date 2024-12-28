<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class verificationController extends Controller
{
    public function index(){
        if (Auth::user()->email_verified_at) {
        return redirect('/');
        }    
        return view('auth.verify-email');
    }
    
    public function verification(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect('/home');
    }

    public function send_verification(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!');
    }
}
