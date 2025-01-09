<?php

namespace App\Services\AppSettings;

use App\Models\AppSetting;
use LaravelEasyRepository\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AppSettingsServiceImplement extends Service implements AppSettingsService{

  /**
   * @return path of image
   */

  private function SaveImage($image){
    $path = public_path('static/images/');
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $filename = 'logo.' . $image->getClientOriginalExtension();
    $manager = new ImageManager(new Driver);
    $manager->read($image)
            ->resize(200,200)
            ->save($path.$filename);
    return 'static/images/'.$filename;
  }

  public function UpdateApp($data){
    $validator = Validator::make($data,[
        'image_file' => 'nullable|mimes:png|max:2048',
    ]);
    if ($validator->fails()) {
      throw new ValidationException($validator);
    }
    $query = AppSetting::first();
    if(!$query){
      $query = new AppSetting();
      $query->logo_path = 'static/images/logo.svg';
    }
    if (isset($data['image_file'])) {
      if($query->logo_path && file_exists(public_path($query->logo_path))){
        unlink(public_path($query->logo_path));
      }
      $image = $this->SaveImage($data['image_file']);
      $query->logo_path = $image;
    }
    if (isset($data['app_name'])) {
      $query->app_name = $data['app_name'];
    }
    $query->save();
  }
}
