<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Отображение списка пользователей
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = $this->userService->getAll();

        return view('pages.users.index', ['users' => $users]);
    }

    /**
     * Отображениеи формы создания польхователя
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('pages.users.create');
    }

    /**
     * Создание пользователя
     *
     * @param StoreUserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = $this->userService->createUser($request->validated());

        return redirect()->route('users.index');
    }

    /**
     * Получение и отображение пользователя
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        $user = $this->userService->getById($id);

        return view('pages.users.show', ['user' => $user]);
    }

    /**
     * Обновление пользователя
     *
     * @param UpdateUserRequest $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $this->userService->updateUser($id, $request->validated());

        return redirect()->route('users.index');
    }

    /**
     * Удалить пользователя
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->userService->deleteUser($id);

        return redirect()->route('users.index');
    }
}
