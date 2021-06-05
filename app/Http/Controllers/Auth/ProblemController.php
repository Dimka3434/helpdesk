<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Problem\StoreProblemRequest;
use App\Services\CategoryService;
use App\Services\ProblemService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    private ProblemService $problemService;
    private CategoryService $categoryService;

    public function __construct(ProblemService $problemService, CategoryService $categoryService)
    {
        $this->problemService = $problemService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $problems = $this->problemService->getProblemsByUserId(auth()->id());

        return view('pages.account.problems.index', ['problems' => $problems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = $this->categoryService->getAllWithSubcategories();

        return view('pages.account.problems.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(StoreProblemRequest $request): RedirectResponse
    {
        $problem = $this->problemService->storeProblem(
            auth()->id(),
            $request->validated()
        );

        return redirect()->route('account.problems.index');
    }

    /**
     * Display the specified resource.
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

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
