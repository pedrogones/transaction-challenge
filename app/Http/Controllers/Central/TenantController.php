<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreUpdateTenantRequest;
use App\Models\Tenant;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TenantController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('tenant.view');

        $tenants = Tenant::query()
            ->with('domains')
            ->latest()
            ->paginate(15);

        return view('central.tenants.index', compact('tenants'));
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('tenant.create');
        $tenant = null;

        return view('central.tenants.create', compact('tenant'));
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreUpdateTenantRequest $request): RedirectResponse
    {
        $this->authorize('tenant.create');

        $validated = $request->validated();

        $tenantId = $validated['id'] ?: Str::slug($validated['name']);
        $tenantId = $tenantId !== '' ? $tenantId : (string) Str::uuid();

        if(Tenant::query()->where('id', $tenantId)->exists()){
            return back()->withInput(['name' => $validated['name'], 'id'=>$tenantId, 'domain' => $validated['domain']])->withErrors(['id' => 'Este identificador de tenant já está em uso.']);
        }

        $tenant = Tenant::create([
            'id' => Str::lower($tenantId),
            'name' => $validated['name'],
            'is_active' => (bool) $validated['is_active'],
        ]);

        $tenant->domains()->create([
            'domain' => Str::lower($validated['domain']),
        ]);

        return redirect()
            ->route('central.tenants.index')
            ->with('success', 'Tenant criado com sucesso.');
    }

    /**
     * @throws AuthorizationException
     */
    public function show(string $id): View
    {
        $this->authorize('tenant.view');

        $tenant = Tenant::query()
            ->with('domains')
            ->findOrFail($id);

        return view('central.tenants.show', compact('tenant'));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(string $id): View
    {
        $this->authorize('tenant.update');

        $tenant = Tenant::query()
            ->with('domains')
            ->findOrFail($id);

        return view('central.tenants.edit', compact('tenant'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(StoreUpdateTenantRequest $request, string $id): RedirectResponse
    {
        $this->authorize('tenant.update');

        $tenant = Tenant::query()
            ->with('domains')
            ->findOrFail($id);

        $primaryDomain = $tenant->domains->first();

        $validated = $request->validated();
        $tenant->update([
            'data' => array_merge($tenant->data ?? [], [
                'name' => $validated['name'],
                'is_active' => (bool) $validated['is_active']]),
            'name' => $validated['name']
        ]);

        if ($primaryDomain) {
            $primaryDomain->update([
                'domain' => Str::lower($validated['domain']),
            ]);
        } else {
            $tenant->domains()->create([
                'domain' => Str::lower($validated['domain']),
            ]);
        }

        return redirect()
            ->route('central.tenants.index')
            ->with('success', 'Tenant atualizado com sucesso.');
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->authorize('tenant.delete');

        $tenant = Tenant::query()->findOrFail($id);
        $tenant->delete();

        return redirect()
            ->route('central.tenants.index')
            ->with('success', 'Tenant removido com sucesso.');
    }
}
