<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcategory\StoreSubcategoryRequest;
use App\Http\Requests\Subcategory\UpdateSubcategoryRequest;
use App\Services\SubcategoryService;
use Illuminate\Http\RedirectResponse;

/**
 * Class SubcategoryController
 *
 * @package App\Http\Controllers
 */
class SubcategoryController extends Controller
{
    /**
     * @var SubcategoryService
     */
    private SubcategoryService $subcategoryService;

    /**
     * SubcategoryController constructor.
     *
     * @param SubcategoryService $subcategoryService
     */
    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    /**
     * Создать подкатегорию
     *
     * @param StoreSubcategoryRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $this->subcategoryService->createSubcategory($request->validated(), $request->id);

        return redirect()->back()->with('success', 'Подкатегория успешно создана');
    }

    /**
     * Обновить подкатегорию
     *
     * @param UpdateSubcategoryRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(UpdateSubcategoryRequest $request, int $id): RedirectResponse
    {
        $this->subcategoryService->updateCategory($id, $request->validated());

        return redirect()->back();
    }

    /**
     * Удалить подкатегорию
     *
     * @param int $id
     * @param int $subcategoryId
     *
     * @return RedirectResponse
     */
    public function destroy(int $id, int $subcategoryId): RedirectResponse
    {
        $this->subcategoryService->deleteSubcategory($subcategoryId);

        return redirect()->back()->with('success', 'Подкатегория успешно удалена');
    }
}
