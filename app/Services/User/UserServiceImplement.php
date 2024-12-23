<?php

namespace App\Services\User;

use LaravelEasyRepository\Service;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserServiceImplement extends Service implements UserService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    public function new_user($data){
      $validator = Validator::make($data, [
        'new_first_name' => 'required|string|min:2|max:50',
        'new_last_name'  => 'required|string|min:2|max:50',
        'new_email'      => 'required|email|max:255|unique:users,email',
        'new_password'   => 'required|string|min:8|confirmed',
        'confirm_new_password' => 'required|string|same:new_password',
        'new_phone'      => 'required|string|min:10|max:15',
      ], [
        'new_first_name.required' => 'First name is required.',
        'new_first_name.string'   => 'First name must be a string.',
        'new_first_name.min'      => 'First name must be at least 2 characters.',
        'new_first_name.max'      => 'First name must not exceed 50 characters.',
        
        'new_last_name.required'  => 'Last name is required.',
        'new_last_name.string'    => 'Last name must be a string.',
        'new_last_name.min'       => 'Last name must be at least 2 characters.',
        'new_last_name.max'       => 'Last name must not exceed 50 characters.',
        
        'new_email.required'      => 'Email is required.',
        'new_email.email'         => 'Email must be a valid email address.',
        'new_email.max'           => 'Email must not exceed 255 characters.',
        'new_email.unique'        => 'This email is already taken.',
        
        'new_password.required'   => 'Password is required.',
        'new_password.string'     => 'Password must be a string.',
        'new_password.min'        => 'Password must be at least 8 characters.',
        'new_password.confirmed'  => 'Password confirmation does not match.',
        
        'confirm_new_password.required' => 'Password confirmation is required.',
        'confirm_new_password.string'   => 'Password confirmation must be a string.',
        'confirm_new_password.same'     => 'Password confirmation must match the password.',
        
        'new_phone.required'      => 'Phone number is required.',
        'new_phone.string'        => 'Phone number must be a string.',
        'new_phone.min'           => 'Phone number must be at least 10 characters.',
        'new_phone.max'           => 'Phone number must not exceed 15 characters.',
      ]);
      if ($validator->fails()) {
        throw new ValidationException($validator);
      }

      try {
        $this->mainRepository->new_user($data);
        return [
          'status' => 'success',
          'message' => 'Berhasil menambahkan user baru',
        ];
      } catch (Exception $e) {
        return [
          'status' => 'error',
          'message' => 'Gagal menambahkan user baru : ' . $e->getMessage(),
        ];
      }
    }

    // Define your custom methods :)
}
