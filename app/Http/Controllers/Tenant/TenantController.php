<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('domains')->get();
        return view('central.tenants.index', compact('tenants'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'string', 'max:50'],
            'domain' => ['required', 'string', 'max:255'],
        ]);

        $tenant = Tenant::create(['id' => $data['id']]);
        $tenant->domains()->create(['domain' => $data['domain']]);

        Artisan::call('tenants:migrate', ['--tenants' => [$tenant->id]]);

        return redirect()->route('central.tenants.index')
            ->with('success', 'Tenant criado com sucesso.');
    }
}
