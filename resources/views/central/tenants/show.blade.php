<x-app-layout>
    @php
        $domain = $tenant->domains->first()->domain ?? '-';
        $name = $tenant->name ?? $tenant->data['name'] ?? $tenant->id;
        $isActive = (bool) ($tenant->data['is_active'] ?? true);
    @endphp

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-6">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Detalhes do tenant</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Visao geral do tenant no painel central.</p>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">ID</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ $tenant->id }}</dd>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Nome</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ $name }}</dd>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Dominio</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ $domain }}</dd>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ $isActive ? 'Ativo' : 'Inativo' }}</dd>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Criado em</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ optional($tenant->created_at)->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Atualizado em</dt>
                            <dd class="mt-1 text-sm text-gray-800 dark:text-gray-100">{{ optional($tenant->updated_at)->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('central.tenants.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">Voltar</a>
                        @can('tenant.update')
                            <a href="{{ route('central.tenants.edit', $tenant->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm">Editar</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
