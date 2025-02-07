<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserEloquentRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findUser($id) : Model
    {
        return $this->model->findOrFail($id);
    }

    public function paginateUsers(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function createUser(array $data) : Model
    {
        return $this->model->create($data);
    }

    public function updateUser($id, array $data) 
    {
        $user = $this->findUser($id);
        return $user->update($data);
    }

    public function deleteUser($id) 
    {
        $user = $this->findUser($id);
        return $user->delete();
    }
}
