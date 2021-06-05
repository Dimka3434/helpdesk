<?php

namespace App\Services;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubcategoryService
 *
 * @package App\Services
 */
class SubcategoryService
{
    /**
     * @var Subcategory
     */
    private Subcategory $model;

    /**
     * SubcategoryService constructor.
     */
    public function __construct()
    {
        $this->model = new Subcategory;
    }

    /**
     * Создать подкатегорию
     *
     * @param array $data
     * @param int $categoryId
     *
     * @return Builder|Model
     */
    public function createSubcategory(array $data, int $categoryId)
    {
        $data['category_id'] = $categoryId;

        return $this->model->newQuery()
            ->create($data);
    }

    /**
     * Обновить подкатегорию
     *
     * @param int $id
     * @param array $data
     *
     * @return bool|int
     */
    public function updateCategory(int $id, array $data)
    {
        return $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    /**
     * Удалить подкатегорию
     *
     * @param int $id
     *
     * @return bool|mixed|null
     */
    public function deleteSubcategory(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    /**
     * Получить список подкатегорий
     *
     * @return Subcategory[]|Collection
     */
    public function getAll()
    {
        return Subcategory::all();
    }
}
