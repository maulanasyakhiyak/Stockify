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

    public function store($data){
      $validator = Validator::make($data, [
        'new_first_name' => 'required|string|min:2|max:50',
        'new_last_name'  => 'required|string|min:2|max:50',
        'new_email'      => 'required|email|max:255|unique:users,email',
        'new_password'   => 'required|string|min:8|confirmed',
        'new_role'       => 'required|string|in:staff,manager',
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
          
          'role.required'           => 'Role is required.',
          'role.string'             => 'Role must be a string.',
          'role.in'                 => 'Chose a role',
      ]);
    
      if ($validator->fails()) {
        throw new ValidationException($validator);
      }

      try {
        $this->mainRepository->store($data);
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

    protected function comparing_data_user($data,$id){
      $finded =  $this->mainRepository->find($id);
      $data_to_compare = $finded->toArray();
      $compared = [];
      foreach ($data as $key => $value) {
        if (isset($data_to_compare[$key]) && $data_to_compare[$key] !== $value && $data[$key] !== null) {
          $compared[$key] = $data[$key];
        }
      }
      return $compared;
    }

    public function update($data, $id){
      // dd($data);
      $compared = $this->comparing_data_user($data,$id);
      // dd($compared);
      $validator = Validator::make($compared, [
        'first_name' => 'sometimes|required|string|min:2|max:50',
        'last_name'  => 'sometimes|required|string|min:2|max:50',
        'email'      => 'sometimes|required|email|max:255|unique:users,email',
        'role'       => 'sometimes|required|string|in:admin,staff,manager',
        ], [
          'first_name.required' => 'First name is required.',
          'first_name.string'   => 'First name must be a string.',
          'first_name.min'      => 'First name must be at least 2 characters.',
          'first_name.max'      => 'First name must not exceed 50 characters.',
          
          'last_name.required'  => 'Last name is required.',
          'last_name.string'    => 'Last name must be a string.',
          'last_name.min'       => 'Last name must be at least 2 characters.',
          'last_name.max'       => 'Last name must not exceed 50 characters.',
          
          'email.required'      => 'Email is required.',
          'email.email'         => 'Email must be a valid email address.',
          'email.max'           => 'Email must not exceed 255 characters.',
          'email.unique'        => 'This email is already taken.',
          
          'role.required'           => 'Role is required.',
          'role.string'             => 'Role must be a string.',
          'role.in'                 => 'Role must be one of the following: admin, user, manager.',
      ]);

      if ($validator->fails()) {
        throw new ValidationException($validator);
      }

      try {
        $result = $this->mainRepository->update($compared,$id);
        if($result){
          return [
            'status' => 'success',
            'message' => 'Berhasil update user',
          ];
        }
        return 'unchanged';
      } catch (Exception $e) {
        return [
          'status' => 'error',
          'message' => 'Gagal update user : ' . $e->getMessage(),
        ];
      }

    }
    // Define your custom methods :)
}
