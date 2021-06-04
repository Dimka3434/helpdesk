<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcategory\StoreSubcategoryRequest;
use App\Http\Requests\Subcategory\UpdateSubcategoryRequest;
use App\Services\SubcategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    private SubcategoryService $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function store(StoreSubcategoryRequest $request): RedirectResponse
    {
        $this->subcategoryService->createSubcategory($request->validated(), $request->id);

        return redirect()->back()->with('success', 'Подкатегория успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubcategoryRequest $request, $id)
    {
        $this->subcategoryService->updateCategory($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id, int $subcategoryId): RedirectResponse
    {
        $this->subcategoryService->deleteSubcategory($subcategoryId);

        return redirect()->back()->with('success', 'Подкатегория успешно удалена');
    }
}
