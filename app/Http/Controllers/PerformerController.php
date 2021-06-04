<?php

namespace App\Http\Controllers;

use App\Http\Requests\Performer\StorePerformerRequest;
use App\Http\Requests\Performer\UpdatePerformerRequest;
use App\Services\PerformerService;

class PerformerController extends Controller
{
    private PerformerService $performerService;

    public function __construct(PerformerService $performerService)
    {
        $this->performerService = $performerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerformerRequest $request)
    {
        $this->performerService->createPerformer($request->validated());
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerformerRequest $request, $id)
    {
        $this->performerService->updatePerformer($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->performerService->deletePerformer($id);
    }
}
