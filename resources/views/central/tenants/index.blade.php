<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4 flex justify-end">
                @can('tenant.create')
                    <a href="{{ route('central.tenants.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                        + Novo tenant
                    </a>
                @endcan
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Tenants</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gerenciamento central de domínios.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Dominio</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Criado em</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Acoes</th>
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($tenants as $tenant)
                                @php
                                    $domain = $tenant?->domains?->first()->domain ?? '-';
                                    $name = $tenant?->name ?? $tenant?->data['name'] ?? $tenant->id;
                                    $isActive = (bool) ($tenant->data['is_active'] ?? true);
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $tenant->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $name }}</td>
                                    <td class="px-4 py-3 text-sm text-blue-700 dark:text-blue-200"><a class="cursor-pointer border-b " href="http://{{$domain}}:8000" target="_blank" > {{ $domain }}</a></td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($isActive)
                                            <span class="px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700">Ativo</span>
                                        @else
                                            <span class="px-2 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-700">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ optional($tenant->created_at)->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-sm text-right space-x-2">
                                        @can('tenant.view')
                                            <a href="{{ route('central.tenants.show', $tenant->id) }}" class="inline-flex px-3 py-1.5 bg-slate-600 hover:bg-slate-700 text-white rounded-md text-xs">Ver</a>
                                        @endcan
                                        @can('tenant.update')
                                            <a href="{{ route('central.tenants.edit', $tenant->id) }}" class="inline-flex px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-xs">Editar</a>
                                        @endcan
                                        @can('tenant.delete')
                                            <form action="{{ route('central.tenants.destroy', $tenant->id) }}" method="POST" class="inline-block form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs">Excluir</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400">Nenhum tenant encontrado.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $tenants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
