<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{

    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Оторбражение старниы с настройками
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = $this->categoryService->getAllWithSubcategories();

        return view('pages.categories.index', ['categories' => $categories]);
    }

    /**
     * Создание категории
     *
     * @param StoreCategoryRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->createCategory($request->validated());

        return redirect()->back()->with('success', 'Категория успешно создана');
    }

    /**
     * Обновление категории
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, int $id): RedirectResponse
    {
        $this->categoryService->updateCategory($id, $request->validated());

        return redirect()->back();
    }

    /**
     * Удаление категории
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->back()->with('success', 'Категория успешно удалена');
    }
}
