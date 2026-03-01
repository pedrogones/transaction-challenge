<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Arquivos') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- Tabela --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Nome
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Tipo
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Categoria
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Tamanho
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Criado em
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($archives as $archive)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                    {{-- Nome --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $archive->original_name }}
                                        <div class="text-xs text-gray-500">
                                            {{ $archive->mime_type }}
                                        </div>
                                    </td>

                                    {{-- Tipo --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        <span class="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-md">
                                            {{ $archive->type }}
                                        </span>
                                    </td>

                                    {{-- Categoria --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ $archive->category ?? '-' }}
                                    </td>

                                    {{-- Tamanho --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ number_format($archive->size / 1024, 2) }} KB
                                    </td>

                                    {{-- Data --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $archive->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                        <a href="{{url('storage/' . $archive->path)}}"
                                           target="_blank"
                                           class="inline-flex items-center justify-center w-9 h-9 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full shadow transition"
                                           title="Visualizar">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                         c4.477 0 8.268 2.943 9.542 7
                                                         -1.274 4.057-5.065 7-9.542 7
                                                         -4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Nenhum arquivo encontrado.
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
