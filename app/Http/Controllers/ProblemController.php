<?php

namespace App\Http\Controllers;

use App\Http\Requests\CloseProblemRequest;
use App\Http\Requests\MakeProblemDoneRequest;
use App\Http\Requests\MakeProblemUnderwayRequest;
use App\Http\Requests\Problem\AssignPerformerRequest;
use App\Services\ProblemService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class ProblemController
 *
 * @package App\Http\Controllers
 */
class ProblemController extends Controller
{
    /**
     * @var ProblemService $problemService
     */
    private ProblemService $problemService;
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * ProblemController constructor.
     *
     * @param ProblemService $problemService
     * @param UserService $userService
     */
    public function __construct(ProblemService $problemService, UserService $userService)
    {
        $this->problemService = $problemService;
        $this->userService = $userService;
    }

    /**
     * Показать список проблем
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $problems = $this->problemService->getAll($request->type ?? 'checking');
        $performers = $this->userService->getPerformers();

        return view('pages.problems.index', ['problems' => $problems, 'performers' => $performers]);
    }

    /**
     * Показать форму создания проблемы
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('pages.problems.create');
    }

    /**
     * Удалить проблему
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->problemService->deleteProblem($id);

        return redirect()->route('problems.index');
    }

    /**
     * Назначить исполнителя
     * @param AssignPerformerRequest $request
     *
     * @return RedirectResponse
     */
    public function assignPerformer(AssignPerformerRequest $request): RedirectResponse
    {
        $this->problemService->assignToPerformer($request->problem_id, $request->performer_id, $request->priority);

        return redirect()->route('problems.index');
    }

    /**
     * Перевести проблему в статус "В работе"
     * @param MakeProblemUnderwayRequest $request
     *
     * @return RedirectResponse
     */
    public function makeProblemUnderway(MakeProblemUnderwayRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->problemService->makeProblemUnderway($data['problem_id']);

        return redirect()->route('performers.problems');
    }

    /**
     * Сделать проблему "Выполненной"
     * @param MakeProblemDoneRequest $request
     *
     * @return RedirectResponse
     */
    public function makeProblemDone(MakeProblemDoneRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->problemService->makeProblemDone($data['problem_id'], $data['commentary'] ?? '');

        return redirect()->route('performers.problems');
    }

    /**
     * Закрыть проблему
     * @param CloseProblemRequest $request
     *
     * @return RedirectResponse
     */
    public function closeProblem(CloseProblemRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->problemService->closeProblem($data['problem_id'], $data['commentary'] ?? '');

        return redirect()->route('problems.index');
    }

    /**
     * Получить привязанные к исполнителю проблемы
     * @return Application|Factory|View
     */
    public function getAssignedProblems()
    {
        $problems = $this->problemService->getAssignedProblemsByPerformerId(
            auth()->id()
        );

        return view('pages.performers.problems.index', ['problems' => $problems]);
    }
}
