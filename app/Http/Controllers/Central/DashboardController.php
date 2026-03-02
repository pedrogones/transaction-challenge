<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Auth\Access\AuthorizationException;
use Stancl\Tenancy\Database\Models\Domain;

class DashboardController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $this->authorize('tenant.view');

        $totalTenants = Tenant::query()->count();
        $totalDomains = Domain::query()->count();
        $latestTenants = Tenant::query()
            ->with('domains')
            ->latest()
            ->take(5)
            ->get();

        return view('central.dashboard.index', compact('totalTenants', 'totalDomains', 'latestTenants'));
    }
}
