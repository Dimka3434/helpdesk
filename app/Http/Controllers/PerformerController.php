<?php

namespace App\Http\Controllers;

use App\Http\Requests\Performer\StorePerformerRequest;
use App\Http\Requests\Performer\UpdatePerformerRequest;
use App\Services\PerformerService;
use Illuminate\Http\RedirectResponse;

/**
 * Class PerformerController
 *
 * @package App\Http\Controllers
 */
class PerformerController extends Controller
{
    /**
     * @var PerformerService
     */
    private PerformerService $performerService;

    /**
     * PerformerController constructor.
     *
     * @param PerformerService $performerService
     */
    public function __construct(PerformerService $performerService)
    {
        $this->performerService = $performerService;
    }

    /**
     * Создать исполнителя
     *
     * @param StorePerformerRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StorePerformerRequest $request): RedirectResponse
    {
        $this->performerService->createPerformer($request->validated());

        return redirect()->back();
    }

    /**
     * Обновление исполнителя
     *
     * @param UpdatePerformerRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(UpdatePerformerRequest $request, $id): RedirectResponse
    {
        $this->performerService->updatePerformer($id, $request->validated());

        return redirect()->back();
    }

    /**
     * Удаление исполнителя
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->performerService->deletePerformer($id);

        return redirect()->back();
    }
}
