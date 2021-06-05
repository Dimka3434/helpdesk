<?php

namespace App\Services;

use App\Models\User;

/**
 * Class PerformerService
 *
 * @package App\Services
 */
class PerformerService
{
    /**
     * @var User
     */
    private User $model;

    /**
     * PerformerService constructor.
     */
    public function __construct()
    {
        $this->model = new User;
    }

    /**
     * Создание исполнителя
     * @param array $data
     */
    public function createPerformer(array $data)
    {
        $this->model->newQuery()
            ->create($data);
    }

    /**
     * Обновление исполнителя
     * @param int $id
     * @param array $data
     */
    public function updatePerformer(int $id, array $data)
    {
        $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    /**
     * Удаление исполнителя
     * @param int $id
     *
     * @return bool|mixed|null
     */
    public function deletePerformer(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    /**
     * Прикрепить к категории
     * @param int $id
     * @param int $categoryId
     *
     * @return mixed
     */
    public function attachToCategory(int $id, int $categoryId)
    {
        return $this->model->newQuery()->categories()->attach($categoryId);
    }

    /**
     * Открепить от категории
     * @param int $id
     * @param int $categoryId
     *
     * @return mixed
     */
    public function detachToCategory(int $id, int $categoryId)
    {
        return $this->model->newQuery()->categories()->detach($categoryId);
    }
}
