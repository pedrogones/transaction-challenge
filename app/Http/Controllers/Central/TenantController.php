<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
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
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('tenant.create');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'tenant_id' => ['nullable', 'string', 'max:50', 'regex:/^[a-zA-Z0-9\\-]+$/', 'unique:tenants,id'],
            'domain' => ['required', 'string', 'max:255', 'unique:domains,domain'],
            'is_active' => ['required', 'boolean'],
        ]);

        $tenantId = $validated['tenant_id'] ?: Str::slug($validated['name']);
        $tenantId = $tenantId !== '' ? $tenantId : (string) Str::uuid();

        $tenant = Tenant::create([
            'id' => Str::lower($tenantId),
            'data' => [
                'name' => $validated['name'],
                'is_active' => (bool) $validated['is_active'],
            ],
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
    public function update(Request $request, string $id): RedirectResponse
    {
        $this->authorize('tenant.update');

        $tenant = Tenant::query()
            ->with('domains')
            ->findOrFail($id);

        $primaryDomain = $tenant->domains->first();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'domain' => [
                'required',
                'string',
                'max:255',
                Rule::unique('domains', 'domain')->ignore($primaryDomain?->id),
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $tenant->update([
            'data' => array_merge($tenant->data ?? [], [
                'name' => $validated['name'],
                'is_active' => (bool) $validated['is_active'],
            ]),
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
