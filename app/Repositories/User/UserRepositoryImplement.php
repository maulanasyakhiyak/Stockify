<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LaravelEasyRepository\Implementations\Eloquent;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index($page = null, $search = null){
        $query = $this->model->query();

        if($search){
            $query->where('name', 'like', "%{$search}%");
        }

        if($page){
            return $query->paginate($page);
        }

        return $query->get();
    }

    public function new_user($data){
        $user = $this->model->create([
            'name' => $data['new_first_name'] . ' ' . $data['new_last_name'],
            'email' => $data['new_email'],
            'password' => Hash::make($data['new_password']),
            'role' => $data['new_role']
        ]);
        return $user;
    }

    // Write something awesome :)
}
