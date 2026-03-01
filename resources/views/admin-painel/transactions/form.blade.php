@php
    $statuses = ['Em processamento', 'Aprovada', 'Negada'];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- CPF --}}
    <div class="w-full">
        <label for="value" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Vlor da Transação <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="value"
            id="value"
            value="{{ old('value', $transaction->value ?? '') }}"
            placeholder="0.00"
            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('value') border-red-500 @enderror"
        >

        @error('value')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>
    <div class="w-full">
        <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            CPF <span class="text-red-500">*</span>
        </label>

        <input
            type="text"
            name="cpf"
            id="cpf"
            value="{{ old('cpf', $transaction->cpf ?? '') }}"
            placeholder="123.456.789-00"
            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('cpf') border-red-500 @enderror"
        >

        @error('cpf')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div class="w-full">
        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Status <span class="text-red-500">*</span>
        </label>

        <select
            name="status"
            id="status"
            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('status') border-red-500 @enderror"
        >
            @foreach($statuses as $status)
                <option value="{{ $status }}" {{ old('status', $transaction->status ?? '') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        @error('status')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-6">
    <label for="archive" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        Arquivo <span class="text-red-500">*</span>
    </label>

    <div class="flex items-center justify-center w-full">
        <label
            class="relative flex flex-col items-center justify-center w-full min-h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 hover:border-indigo-500 bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:hover:border-indigo-400 transition overflow-hidden"
            for="archive"
        >
            <div id="archiveEmpty" class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-3 text-gray-400"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M7 16V8m0 0l-4 4m4-4l4 4m6 4v-8m0 0l-4 4m4-4l4 4"/>
                </svg>

                <p class="mb-2 text-sm text-gray-500 dark:text-gray-300">
                    <span class="font-semibold">Clique para enviar</span> ou arraste o arquivo
                </p>

                <p class="text-xs text-gray-500 dark:text-gray-400">
                    PDF, JPG ou PNG (máx. 5MB)
                </p>
                <input type="hidden" name="archive_id" value="{{ isset($transaction) && $transaction->archive ? $transaction->archive->id : ''  }}">
                @if(isset($transaction) && $transaction->archive)
                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                        <span class="font-medium">Arquivo atual: {{$transaction->archive->original_name}}</span>

                        <a
                            href="{{ Storage::url($transaction->archive->path) }}"
                            target="_blank"
                            class="ml-1 text-indigo-600 hover:text-indigo-800 underline"
                        >
                            Ver arquivo atual
                        </a>
                    </div>
                @endif
            </div>

            <div id="archiveSelected" class="hidden w-full p-4">
                <div class="flex items-start gap-4">

                    {{-- PREVIEW DA IMAGEM --}}
                    <img
                        id="archivePreview"
                        src=""
                        alt="Preview do arquivo"
                        class="hidden w-20 h-20 rounded-lg object-cover border border-gray-200 dark:border-gray-600 bg-white"
                    />

                    <div class="flex-1">
                        <div class="flex items-center gap-2">
    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-md bg-green-100 text-green-700">
        Upload selecionado
    </span>
                            <span id="archiveTypeBadge"
                                  class="hidden inline-flex items-center px-2 py-1 text-xs font-semibold rounded-md bg-gray-100 text-gray-700">
        PDF
    </span>
                        </div>

                        <p id="archiveName" class="mt-2 text-sm font-medium text-gray-800 dark:text-gray-100 break-all"></p>
                        <p id="archiveMeta" class="mt-1 text-xs text-gray-500 dark:text-gray-300"></p>

                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-300">
                            Clique aqui para trocar o arquivo
                        </p>
                    </div>
                </div>
            </div>

            <input
                id="archive"
                name="archive"
                type="file"
                accept=".pdf,.jpg,.jpeg,.png"
                class="hidden"
            />
        </label>
    </div>

    @error('archive')
    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>

{{-- Botões --}}
<div class="mt-8 flex justify-end gap-3">

    <a href="{{ route('transactions.index') }}"
       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm transition">
        Cancelar
    </a>

    <button type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow transition">
        {{ isset($transaction) ? 'Atualizar Transação' : 'Criar Transação' }}
    </button>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(function () {

        function cpfMask(value) {
            value = value.replace(/\D/g, '').slice(0, 11);

            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

            return value;
        }

        $('#cpf').on('input', function () {
            this.value = cpfMask(this.value);
        });

        const $input = $('#archive');
        const $empty = $('#archiveEmpty');
        const $selected = $('#archiveSelected');

        const $preview = $('#archivePreview');
        const $name = $('#archiveName');
        const $meta = $('#archiveMeta');
        const $typeBadge = $('#archiveTypeBadge');

        function bytesToMB(bytes) {
            return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
        }

        function resetSelected() {
            $preview.attr('src', '').addClass('hidden');
            $typeBadge.addClass('hidden').text('');
            $name.text('');
            $meta.text('');
        }

        $input.on('change', function () {
            const file = this.files && this.files[0] ? this.files[0] : null;

            if (!file) {
                resetSelected();
                $selected.addClass('hidden');
                $empty.removeClass('hidden');
                return;
            }

            $empty.addClass('hidden');
            $selected.removeClass('hidden');

            $name.text(file.name);
            $meta.text(bytesToMB(file.size));

            const type = (file.type || '').toLowerCase();

            if (type.includes('pdf')) {
                $typeBadge.removeClass('hidden').text('PDF');
                $preview.addClass('hidden').attr('src', '');
                return;
            }

            if (type.includes('image')) {
                $typeBadge.removeClass('hidden').text('IMAGEM');

                const reader = new FileReader();
                reader.onload = function (e) {
                    $preview.attr('src', e.target.result).removeClass('hidden');
                };
                reader.readAsDataURL(file);
                return;
            }

            $typeBadge.removeClass('hidden').text('ARQUIVO');
            $preview.addClass('hidden').attr('src', '');
        });
    });
</script>
