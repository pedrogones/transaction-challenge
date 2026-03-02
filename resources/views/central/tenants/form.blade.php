@php
    $isEdit = isset($tenant);
    $primaryDomain = $tenant?->domains?->first()->domain ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">Nome do tenant</label>
        <input type="text" name="name" id="name" value="{{ old('name', $tenant->data['name'] ?? '') }}" placeholder="Ex.: Empresa XPTO"
            class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
        @error('name')
        <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="domain">Dominio do tenant</label>
        <input type="text" name="domain" id="domain" value="{{ old('domain', $primaryDomain) }}" placeholder="Ex.: empresa.localhost" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('domain') border-red-500 @enderror">
        @error('domain')
        <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>

    @if(!$isEdit)
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="tenant_id">Identificador (opcional)</label>
            <input type="text" name="tenant_id" id="tenant_id" value="{{ old('tenant_id') }}" placeholder="Ex.: empresa-exemplo" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('tenant_id') border-red-500 @enderror">
            @error('tenant_id')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
    @else
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Identificador</label>
            <div class="w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 px-3 py-2 text-gray-700 dark:text-gray-200">
                {{ $tenant->id }}
            </div>
        </div>
    @endif

    <div class="w-full">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="is_active">Status</label>
        <select name="is_active" id="is_active" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('is_active') border-red-500 @enderror">
            @php
                $activeValue = old('is_active', (int) ($tenant->data['is_active'] ?? 1));
            @endphp
            <option value="1" {{ (string) $activeValue === '1' ? 'selected' : '' }}>Ativo</option>
            <option value="0" {{ (string) $activeValue === '0' ? 'selected' : '' }}>Inativo</option>
        </select>
        @error('is_active')
        <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('central.tenants.index') }}" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm" >
        Cancelar
    </a>
    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold" >
        {{ $isEdit ? 'Atualizar tenant' : 'Criar tenant' }}
    </button>
</div>
