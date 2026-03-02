<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transações') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @can('transaction.create')
                <div class="mb-4 flex justify-end">
                    <a href="{{ route('transactions.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow">
                        + Nova Transação
                    </a>
                </div>
            @endcan

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-5">
                        <label for="transactionSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                            Pesquisar transações
                        </label>
                        <input id="transactionSearch" type="text" placeholder="Busque por status, valor, data..." class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"/>
                    </div>
                    <div id="transactionsGrid" class="grid md:grid-cols-2 gap-4">
                        @forelse($transactions as $transaction)
                                    <div
                                        class="transaction-item relative flex items-center justify-between border border-gray-200 dark:border-gray-700 rounded-lg px-5 py-4 hover:shadow-sm transition cursor-pointer"
                                        data-id="{{ $transaction->id }}"
                                        data-status="{{ strtolower($transaction->status ?? '') }}"
                                        data-value="R$ {{ number_format($transaction->value, 2, ',', '.') }}"
                                        data-date="{{ $transaction->present()->createdFormatDateTime }}"
                                    >
                                <div class="flex items-center gap-4 text-sm md:text-base text-gray-800 dark:text-gray-100">
                                    <span class="font-semibold">
                                        R$ {{ number_format($transaction->value, 2, ',', '.') }}
                                    </span>
                                    @php
                                        $statusColors = [
                                            'Em processamento' => 'bg-yellow-100 text-yellow-700',
                                            'Aprovada' => 'bg-green-100 text-green-700',
                                            'Negada' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    - <span class="px-2 py-1 text-xs font-semibold rounded-md {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-700' }}"> {{ $transaction->status }} </span>  -  <span class="text-gray-500 dark:text-gray-400"> {{ $transaction->present()->createdFormatDateTime }} </span>
                                </div>

                                @canany(['transaction.view', 'transaction.update', 'transaction.delete'])
                                    <div class="relative">
                                    <button type="button"  class="btn-dropdown p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" data-dropdown="{{ $transaction->id }}">
                                        ⋮
                                    </button>

                                    <div id="dropdown-{{ $transaction->id }}" class="dropdown-menu hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-50">

                                        <button type="button" class="btn-view block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600" data-id="{{ $transaction->id }}"  >
                                            Ver
                                        </button>

                                        @can('transaction.update')
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 btn-edit">
                                            Editar
                                        </a>
                                        @endcan
                                        @can('transaction.delete')
                                        <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}" class="form-delete">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                                                Excluir
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                                @endcanany
                            </div>

                        @empty
                            <div class="text-center text-gray-500 py-10">
                                Nenhuma transação encontrada.
                            </div>
                        @endforelse

                    </div>
                    <div id="noResults" class="hidden text-center text-gray-500 py-10">
                        Nenhuma transação encontrada para o filtro aplicado.
                    </div>
                    <div class="mt-6">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('admin-painel.transactions.modal-show')
    <script>
        $(document).ready(function () {

            $('#transactionSearch').on('keyup', function () {
                let search = $(this).val().toLowerCase().trim();
                let visibleCount = 0;

                $('.transaction-item').each(function () {
                    let status = ($(this).data('status') || '').toString().toLowerCase();
                    let value  = ($(this).data('value') || '').toString().toLowerCase();
                    let date   = ($(this).data('date') || '').toString().toLowerCase();

                    let text = status + ' ' + value + ' ' + date;

                    if (text.includes(search)) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });
                if (visibleCount === 0) {
                    $('#noResults').removeClass('hidden');
                } else {
                    $('#noResults').addClass('hidden');
                }
            });

        });
    </script>
</x-app-layout>
