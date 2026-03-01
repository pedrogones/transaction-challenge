<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuários') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Botão criar --}}
                    @can('user.create')
                        <div class="mb-4 flex justify-end">
                            <a href="{{ route('users.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                                + Novo Usuário
                            </a>
                        </div>
                    @endcan
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Perfis
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Email Verificado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Registrado em
                                </th>

                                @canany(['user.update', 'user.delete'])
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Ações
                                    </th>
                                @endcanany
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-md">
                                            {{ $user->roles()->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->email_verified_at)
                                            <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-md">
                                                    Verificado
                                                </span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-md">
                                                    Pendente
                                                </span>
                                        @endif
                                    </td>

                                    {{-- Data --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    {{-- Ações --}}
                                    @canany(['user.update', 'user.delete'])
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">

                                            @can('user.update')
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs font-semibold">
                                                    Editar
                                                </a>
                                            @endcan

                                            @can('user.delete')
                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                      method="POST"
                                                      class="inline-block form-delete">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold">
                                                        Deletar
                                                    </button>
                                                </form>
                                            @endcan

                                        </td>
                                    @endcanany

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Nenhum usuário encontrado.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<script>

</script>
