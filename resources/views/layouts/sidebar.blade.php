@php
    $tenantContext = function_exists('tenant') ? tenant() : null;
    $isTenantContext = ! is_null($tenantContext);
    $dashboardRoute = $isTenantContext ? 'dashboard.index' : 'central.dashboard';
    $logoutRoute = $isTenantContext ? 'logout' : 'central.logout';

    $navItem = function ($active) {
        return $active
            ? 'bg-white/5 text-white ring-1 ring-white/10'
            : 'text-slate-300 hover:text-white hover:bg-white/5';
    };
@endphp

<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black/60 z-40 lg:hidden"></div>
<aside
    id="appSidebar"
    class="fixed lg:static z-50 lg:z-auto inset-y-0 left-0 w-72
           -translate-x-full lg:translate-x-0 transition-transform duration-200
           bg-slate-950/90 lg:bg-slate-950 border-r border-white/5
           flex flex-col"
>
    <div class="h-16 px-5 flex items-center justify-between border-b border-white/5">
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-blue-500 flex items-center justify-center font-bold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="leading-tight">
                <div class="font-semibold text-sm">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-400">{{ $isTenantContext ? 'Tenant: ' . $tenantContext->id : 'Painel Central' }}</div>
            </div>
        </a>

        <button type="button" class="lg:hidden text-slate-300 hover:text-white" data-sidebar-close>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <div class="px-4 py-5 flex-1 overflow-y-auto scrollbar-dark">
        <div class="text-[11px] tracking-wider text-slate-500 mb-3">Visao Geral</div>

        <nav class="space-y-1">
            <a href="{{ route($dashboardRoute) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs($isTenantContext ? 'dashboard.*' : 'central.dashboard')) }}">
                <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5-8l2 2"/>
                    </svg>
                </span>
                <span class="font-medium text-sm">Dashboard</span>
            </a>

            @if($isTenantContext)
                @can('transaction.view')
                    <a href="{{ route('transactions.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs('transactions.*')) }}">
                        <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v10m-7-6h14"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm">Transacoes</span>
                    </a>
                @endcan

                @can('archive.view')
                    <a href="{{ route('archives.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs('archives.*')) }}">
                        <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4zm4 4h8M8 12h8M8 16h6"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm">Anexos</span>
                    </a>
                @endcan

                @can('role.view')
                    <a href="{{ route('roles.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs('roles.*')) }}">
                        <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm">Perfis</span>
                    </a>
                @endcan

                @can('user.view')
                    <a href="{{ route('users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs('users.*')) }}">
                        <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H2v-2a4 4 0 014-4h4m4-6a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm">Usuarios</span>
                    </a>
                @endcan
            @else
                @can('tenant.view')
                    <a href="{{ route('central.tenants.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl {{ $navItem(request()->routeIs('central.tenants.*')) }}">
                        <span class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                        </span>
                        <span class="font-medium text-sm">Tenants</span>
                    </a>
                @endcan
            @endif
        </nav>

        <div class="mt-8">
            <div class="text-[11px] tracking-wider text-slate-500 mb-3">CONTA</div>

            <div class="glass rounded-2xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center font-semibold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-semibold truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-slate-300/70 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route($logoutRoute) }}" class="mt-4">
                    @csrf
                    <button type="submit"
                            class="w-full px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-sm font-medium">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>