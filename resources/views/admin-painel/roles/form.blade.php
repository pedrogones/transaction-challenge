@php
    $isEdit = isset($role);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="w-full">
        <label class="label-text" for="name">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', $role->name ?? '') }}" placeholder="Ex. João Silva"
            class="input w-full @error('name') border-red-500 @enderror">

        @error('name')
        <span class="helper-text text-red-500">{{ $message }}</span>
        @enderror
    </div>
</div>

<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
        Permissões
    </h3>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-y-3 gap-x-6">

        @foreach($permissions as $permission)
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission_{{ $permission->id }}" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    {{ isset($role) && $role->hasPermissionTo($permission->name) ? 'checked' : '' }} >

                <label
                    for="permission_{{ $permission->id }}"
                    class="text-sm text-gray-700 dark:text-gray-300"
                >
                    {{ $permission->name }}
                </label>
            </div>
        @endforeach

    </div>

    @error('permissions')
    <span class="text-sm text-red-500">{{ $message }}</span>
    @enderror
</div>
<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('roles.index') }}"
       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">
        Cancelar
    </a>
    <button type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">
        {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
    </button>

</div>
