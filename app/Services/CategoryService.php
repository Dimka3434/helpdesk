<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryService
 *
 * @package App\Services
 */
class CategoryService
{
    /**
     * @var Category
     */
    private Category $model;

    /**
     * CategoryService constructor.
     */
    public function __construct()
    {
        $this->model = new Category;
    }

    /**
     * Создание категории
     * @param array $data
     *
     * @return Builder|Model
     */
    public function createCategory(array $data)
    {
        return $this->model->newQuery()
            ->create($data);
    }

    /**
     * Обновление категории
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
     * Удаление категории
     * @param int $id
     *
     * @return bool|mixed|null
     */
    public function deleteCategory(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    /**
     * Получение списка категорий
     * @return Builder[]|Collection
     */
    public function getAllWithSubcategories()
    {
        return Category::with('subcategories')->get();
    }
}
