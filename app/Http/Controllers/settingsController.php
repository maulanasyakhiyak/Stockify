<?php

namespace App\Http\Controllers;

use App\Services\AppSettings\AppSettingsService;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    protected $appSettingsService;
    public function __construct(AppSettingsService $appSettingsService)
    {
        $this->appSettingsService = $appSettingsService;
    }
    public function index(){
        return view('adminpage.settings');
    }

    public function store(Request $request){
        // dd($request->file('logo'));
        $this->appSettingsService->UpdateApp([
            'image_file' => $request->file('logo'), 
            'app_name' => $request->input('NEW_APP_NAME')
        ]);
        return redirect()->back()->with('success', 'berhasil');
    }
}
