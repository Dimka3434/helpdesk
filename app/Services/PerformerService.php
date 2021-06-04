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
    private User $model;

    /**
     * PerformerService constructor.
     */
    public function __construct()
    {
        $this->model = new User;
    }

    /**
     * @param array $data
     */
    public function createPerformer(array $data)
    {
        $this->model->newQuery()
            ->create($data);
    }

    /**
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
