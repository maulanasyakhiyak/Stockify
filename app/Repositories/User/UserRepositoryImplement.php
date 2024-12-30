<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use LaravelEasyRepository\Implementations\Eloquent;

use function Laravel\Prompts\error;

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

    public function find($id){
        return $this->model->find($id);
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

    public function store($data){
        // dd($data);
        $user = $this->model->create([
            'first_name' => $data['new_first_name'],
            'last_name' =>  $data['new_last_name'],
            'email' => $data['new_email'],
            'password' => Hash::make($data['new_password']),
            'role' => $data['new_role']
        ]);
        return $user;
    }

    public function update($data,$id){
        $user = $this->model->find($id);
        if (isset($data['role']) && $data['role'] == 'admin') {
            throw new \Exception('Nice try');
        }
        if (!empty($data)) {
            $updatedUser = $user->update($data);
        } else {
            $updatedUser = false;
        }
        
        return $updatedUser;
    }

    public function destroy($id)
    {
       return $this->model->destroy($id);
    }

    // Write something awesome :)
}
