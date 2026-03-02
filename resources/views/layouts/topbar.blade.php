@php
    $tenantContext = function_exists('tenant') ? tenant() : null;
    $isTenantContext = ! is_null($tenantContext);
@endphp

<header class="sticky top-0 z-30 bg-slate-950/70 backdrop-blur border-b border-white/5">
    <div class="h-16 px-4 lg:px-8 flex items-center gap-3">

        <button type="button" class="lg:hidden text-slate-300 hover:text-white" data-sidebar-open>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            @if($isTenantContext)
                @can('transaction.create')
                    <a href="{{ route('transactions.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-gradient-to-r from-violet-500 to-blue-500 text-white text-sm font-semibold shadow">
                        <span class="text-lg leading-none">+</span>
                        Nova Transacao
                    </a>
                @endcan
            @else
                @can('tenant.create')
                    <a href="{{ route('central.tenants.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-gradient-to-r from-violet-500 to-blue-500 text-white text-sm font-semibold shadow">
                        <span class="text-lg leading-none">+</span>
                        Novo Tenant
                    </a>
                @endcan
            @endif
        </div>
    </div>
</header>