<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateRoleRequest;
use App\Services\Roles\RoleService;
use Illuminate\Auth\Access\AuthorizationException;

class RoleController extends Controller
{
    protected RoleService $roleService;
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    protected string $viewPath = 'admin-painel';
    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('role.view');
        $roles = $this->roleService->getAll();
        return view($this->viewPath.'.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('role.create');
        $permissions = $this->roleService->getAllPermissions();

        return view($this->viewPath.'.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(StoreUpdateRoleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('role.create');

        $this->roleService->create($request->all());
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id)
    {
        $this->authorize('role.show');

        $role = $this->roleService->findById($id);
        $permissions = $this->roleService->getAllPermissions();

        return view($this->viewPath.'.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(string $id)
    {
        $this->authorize('role.update');

        $role = $this->roleService->findById($id);
        $permissions = $this->roleService->getAllPermissions();

        return view($this->viewPath.'.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(StoreUpdateRoleRequest $request, string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('role.update');

        $role = $this->roleService->findById($id);
        if(secureRole($role))
        $this->roleService->update($role, $request->all());

        return redirect()->route('roles.index')->with('success', 'Role atualizada com sucesso!');

    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('role.delete');

        $role = $this->roleService->findById($id);
        if(secureRole($role)){
            return redirect()->route('roles.index')
                ->with('error', 'Role não pode ser removida!');
        }
        $this->roleService->delete($role);

        return redirect()->route('roles.index')->with('success', 'Role removida com sucesso!');
    }
}
