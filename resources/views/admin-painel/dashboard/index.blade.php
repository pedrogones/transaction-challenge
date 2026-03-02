<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="hero-gradient rounded-3xl p-8 card-border">
        <div class="flex items-start justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold">Olá, {{ Auth::user()->name }}</h1>
                <p class="text-slate-200/80 mt-4">Aqui está o resumo das suas transações hoje.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-3">
            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">TOTAL HOJE</div>
                <div class="text-2xl font-bold mt-2">R${{$today['value']}} </div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">APROVADAS</div>
                <div class="text-2xl font-bold mt-2"> {{$today['aproves']}} </div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">NEGADAS</div>
                <div class="text-2xl font-bold mt-2"> {{$today['negative']}} </div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">EM PROCESSO</div>
                <div class="text-2xl font-bold mt-2"> {{$today['inProcess']}} </div>
            </div>
        </div>
        <div class="flex items-start justify-between gap-6">
            <div>
                <p class="text-slate-200/80 mt-3">Resumo geral das suas transações.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">TOTAL</div>
                <div class="text-2xl font-bold mt-2">R${{$total['value']}}</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">APROVADAS</div>
                <div class="text-2xl font-bold mt-2">{{$total['aproves']}}</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">NEGADAS</div>
                <div class="text-2xl font-bold mt-2">{{$total['negative']}}</div>
            </div>

            <div class="glass rounded-2xl p-5 card-border">
                <div class="text-xs text-slate-300/70 font-semibold">EM PROCESSO</div>
                <div class="text-2xl font-bold mt-2">{{$total['inProcess']}}</div>
            </div>
        </div>
    </div>
</x-app-layout>
