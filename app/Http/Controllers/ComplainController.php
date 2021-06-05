<?php

namespace App\Http\Controllers;

use App\Http\Requests\Problem\StoreProblemRequest;
use App\Services\CategoryService;
use App\Services\ProblemService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    private ProblemService $problemService;
    private CategoryService $categoryService;

    public function __construct(ProblemService $problemService, CategoryService $categoryService)
    {
        $this->problemService = $problemService;
        $this->categoryService = $categoryService;
    }

    /**
     * Отображение формы для создание заявки
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = $this->categoryService->getAllWithSubcategories();

        return view('pages.complains.create', ['categories' => $categories]);
    }

    /**
     * Создание заявки
     *
     * @param StoreProblemRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreProblemRequest $request): RedirectResponse
    {
        $problem = $this->problemService->storeProblem(
            auth()->id(),
            $request->validated()
        );

        return redirect()->back()->with('success', 'Ваша заявка о проблему успешно создана. Номер заявки: ' . $problem->id);
    }

    /**
     * Отображение заявки
     *
     * @param Request $request
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(Request $request)
    {
        $id = ltrim($request->query('id'), '#');

        $problem = $this->problemService->getById($id);
        if (!$problem) {
            return redirect()->route('complains.create')->with('error', 'Заявка не найдена!');
        }

        $categories = $this->categoryService->getAllWithSubcategories();

        return view('pages.complains.show', ['problem' => $problem, 'categories' => $categories]);
    }
}
