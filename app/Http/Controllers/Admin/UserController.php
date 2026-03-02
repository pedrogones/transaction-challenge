<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserRequest;
use App\Services\Roles\RoleService;
use App\Services\Users\UserService;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    protected UserService $userService;
    protected RoleService $roleService;
    protected string $viewPath = 'admin-painel.users';

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('user.view');

        $users = $this->userService->getAllPaginated();

        return view($this->viewPath . '.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('user.create');

        $roles = $this->roleService->getAll();
        $user = null;

        return view($this->viewPath . '.create', compact('roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreUpdateUserRequest $request)
    {
        $this->authorize('user.create');

        $created = $this->userService->create($request->validated());
        if ($created) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario criado com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro ao criar usuário');
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id)
    {
        $this->authorize('user.view');

        $user = $this->userService->findById($id);

        return view($this->viewPath . '.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(string $id)
    {
        $this->authorize('user.update');

        $user = $this->userService->findById($id);
        $roles = $this->roleService->getAll();

        return view($this->viewPath . '.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(StoreUpdateUserRequest $request, string $id)
    {
        $this->authorize('user.update');
        $user = $this->userService->findById($id);
        $updated = $this->userService->update($user, $request->all());

        if ($updated) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario atualizado com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro ao atualizar usuário');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('user.delete');

        $user = $this->userService->findById($id);
        $deleted = $this->userService->delete($user);

        if ($deleted) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Usuario removido com sucesso.');
        }

        return redirect()->back()->with('error', 'Erro ao remover usuário');
    }
}
