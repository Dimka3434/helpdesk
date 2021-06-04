<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private User $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->newQuery()
            ->create($data);
    }

    public function updateUser(int $id, array $data)
    {
        return $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    public function deleteUser(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    public function getAll()
    {
        return $this->model->newQuery()
            ->get();
    }

    public function getById(int $id)
    {
        return $this->model->newQuery()
            ->find($id);
    }

    public function getPerformers()
    {
        return $this->model->newQuery()
            ->where('type', User::TYPE_PERFORMED)
            ->get();
    }
}
