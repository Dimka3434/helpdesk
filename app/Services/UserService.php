<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 * @package App\Services
 */
class UserService
{
    /**
     * @var User
     */
    private User $model;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->model = new User;
    }

    /**
     * Создать пользователя
     *
     * @param array $data
     *
     * @return Builder|Model
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->model->newQuery()
            ->create($data);
    }

    /**
     * Обновить пользователя
     *
     * @param int $id
     * @param array $data
     *
     * @return bool|int
     */
    public function updateUser(int $id, array $data)
    {
        return $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    /**
     * Удалить пользователя
     *
     * @param int $id
     *
     * @return bool|mixed|null
     */
    public function deleteUser(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    /**
     * Получить всех пользователей
     *
     * @return Builder[]|Collection
     */
    public function getAll()
    {
        return $this->model->newQuery()
            ->get();
    }

    /**
     * Получить пользователя по айди
     *
     * @param int $id
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById(int $id)
    {
        return $this->model->newQuery()
            ->find($id);
    }

    /**
     * Получить список исполнителей
     *
     * @return Builder[]|Collection
     */
    public function getPerformers()
    {
        return $this->model->newQuery()
            ->where('type', User::TYPE_PERFORMER)
            ->get();
    }
}
