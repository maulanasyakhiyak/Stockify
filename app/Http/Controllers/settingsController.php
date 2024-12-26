<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class settingsController extends Controller
{
    public function index(){
        return view('adminpage.settings');
    }

    public function updateSettings(Request $request){
        config(['app_settings.app_name' => $request->input('NEW_APP_NAME')]);
        return redirect()->back();
    }
}
