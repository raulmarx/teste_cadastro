<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    public function findUser(int $id) : Model;
    public function paginateUsers(int $perPage = 15);
    public function createUser(array $userData);
    public function updateUser(string $id, array $userData);
    public function deleteUser($id);
}
