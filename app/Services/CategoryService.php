<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    private Category $model;

    public function __construct()
    {
        $this->model = new Category;
    }

    public function createCategory(array $data)
    {
        return $this->model->newQuery()
            ->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    public function deleteCategory(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    public function getAllWithSubcategories()
    {
        return Category::with('subcategories')->get();
    }
}
