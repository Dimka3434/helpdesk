<?php

namespace App\Services;

use App\Models\Subcategory;

class SubcategoryService
{
    private Subcategory $model;

    public function __construct()
    {
        $this->model = new Subcategory;
    }

    public function createSubcategory(array $data, int $categoryId)
    {
        $data['category_id'] = $categoryId;

        return $this->model->newQuery()
            ->create($data);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->model->newQuery()
            ->find($id)
            ->update($data);
    }

    public function deleteSubcategory(int $id)
    {
        return $this->model->newQuery()
            ->find($id)
            ->delete();
    }

    public function getAll()
    {

        return Subcategory::all();
    }
}
