<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="hero-gradient rounded-3xl p-8 card-border">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold">Bom dia, {{ Auth::user()->name }}</h1>
                <p class="text-slate-200/80 mt-1">Aqui está o resumo das suas transações hoje.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-8">
            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">TOTAL HOJE</div>
                <div class="text-2xl font-bold mt-2">R$ 0,00</div>
                <div class="text-xs text-emerald-300/90 mt-2">+0% em relação a ontem</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">APROVADAS</div>
                <div class="text-2xl font-bold mt-2">0</div>
                <div class="text-xs text-emerald-300/90 mt-2">+0% em relação a ontem</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">NEGADAS</div>
                <div class="text-2xl font-bold mt-2">0</div>
                <div class="text-xs text-emerald-300/90 mt-2">+0% em relação a ontem</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">EM PROCESSO</div>
                <div class="text-2xl font-bold mt-2">0</div>
                <div class="text-xs text-emerald-300/90 mt-2">+0% em relação a ontem</div>
            </div>
        </div>
    </div>
</x-app-layout>
