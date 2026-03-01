<div id="transactionModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 px-4">
    <div class="w-1/2 max-w-2xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-lg font-semibold text-center text-gray-900 dark:text-gray-100">
                    Detalhes da Transação
                </h3>
                <p id="txHumanDate" class="text-xs text-gray-500 dark:text-gray-300 mt-1"></p>
            </div>

            <button id="btnCloseTransactionModal" type="button"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-200">
                ✕
            </button>
        </div>

        <div class="px-6 py-5">

            <div id="transactionModalBody" class="hidden">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">Valor da transação</p>
                        <p id="txValue" class="mt-1 text-xl font-semibold text-gray-900 dark:text-gray-100"></p>
                    </div>

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">Status</p>
                        <div class="mt-2">
                            <span id="txStatusBadge" class="px-2 py-1 text-xs font-semibold rounded-md"></span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">CPF do pagador</p>
                        <p id="txCpf" class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100"></p>
                    </div>

                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">Data e horário</p>
                        <p id="txDate" class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100"></p>
                    </div>

                    <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">Usuário que realizou a operação</p>
                        <p id="txUser" class="mt-1 text-base font-medium text-gray-900 dark:text-gray-100"></p>
                    </div>

                    <div class="mt-4 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="text-xs text-gray-500 dark:text-gray-300">Arquivo</p>

                        <div class="mt-2 flex items-center justify-between gap-3 flex-wrap">
                            <p id="txArchiveName" class="text-sm font-medium text-gray-900 dark:text-gray-100 break-all"></p>

                            <a id="txArchiveLink" href="#" target="_blank"
                               class="text-sm text-indigo-600 hover:text-indigo-800 underline hidden">
                                Abrir arquivo
                            </a>
                        </div>
                    </div>
                </div>


                <div class="mt-5 flex justify-end">
                    <button type="button" id="btnCloseTransactionModal2"
                            class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100">
                        Fechar
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(function () {
        function showLoader() {
            $('#globalLoader').removeClass('hidden');
        }
        function hideLoader() {
            $('#globalLoader').addClass('hidden');
        }
        function closeAllDropdowns() {
            $('.dropdown-menu').addClass('hidden');
            $('.btn-dropdown').attr('aria-expanded', 'false');
        }
        $(document).on('click', '.btn-edit', function (e) {
            e.stopPropagation();
        });
        $(document).on('click', '.btn-dropdown', function (e) {
            e.stopPropagation();

            const id = $(this).data('dropdown');
            const $menu = $('#dropdown-' + id);

            $('.dropdown-menu').not($menu).addClass('hidden');

            $menu.toggleClass('hidden');
        });

        $(document).on('click', function () {
            closeAllDropdowns();
        });

        function openTransactionModal(id) {

            console.log(id);
            const modal = $('#transactionModal');
            const loading = $('#transactionModalLoading');
            const body = $('#transactionModalBody');

            modal.removeClass('hidden').addClass('flex');
            loading.removeClass('hidden');
            body.addClass('hidden');

            showLoader();

            $.ajax({
                type: "GET",
                url: "{{route('ajax-show-transaction')}}",
                data: { id: id },
                success: function (response) {

                    $('#txValue').text(response.value_formatted ?? '-');
                    $('#txCpf').text(response.cpf_formatted ?? response.cpf ?? '-');
                    $('#txUser').text(response.user_name ?? '-');

                    $('#txStatusBadge')
                        .removeClass()
                        .addClass('px-2 py-1 text-xs font-semibold rounded-md ' + (response.status_class ?? 'bg-gray-100 text-gray-700'))
                        .text(response.status ?? '-');

                    $('#txDate').text(response.created_at ?? '-');
                    $('#txHumanDate').text(response.created_at ?? '');

                    if (response.archive_original_name) {
                        $('#txArchiveName').text(response.archive_original_name);
                        $('#txArchiveLink')
                            .attr('href', response.archive_url ?? '#')
                            .removeClass('hidden');
                    } else {
                        $('#txArchiveName').text('Sem arquivo');
                        $('#txArchiveLink').addClass('hidden');
                    }

                    loading.addClass('hidden');
                    body.removeClass('hidden');
                    hideLoader();
                },
                error: function () {
                    hideLoader();
                    loading.addClass('hidden');

                    if (window.Swal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Falha ao carregar a transação.'
                        });
                    }
                }
            });
        }

        function closeTransactionModal() {
            $('#transactionModal').addClass('hidden').removeClass('flex');
        }

        window.openTransactionModal = openTransactionModal;

        $('#btnCloseTransactionModal, #btnCloseTransactionModal2')
            .on('click', closeTransactionModal);

        $('#transactionModal').on('click', function (e) {
            if (e.target === this) closeTransactionModal();
        });

        $(document).on('click', '.transaction-item', function () {
            const id = $(this).data('id');
            openTransactionModal(id);
        });

        $(document).on('click', '.btn-view', function (e) {
            e.stopPropagation();
            closeAllDropdowns();

            const id = $(this).data('id');
            openTransactionModal(id);
        });

        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation();
        });


    });
</script>
