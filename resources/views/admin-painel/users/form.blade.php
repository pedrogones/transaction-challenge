@php
    $isEdit = isset($user);
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="w-full">
        <label class="label-text" for="name">Nome</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" placeholder="Ex. João Silva"
            class="input w-full @error('name') border-red-500 @enderror">

        @error('name')
        <span class="helper-text text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="w-full">
        <label class="label-text" for="email">Email</label>
        <input type="email" name="email" id="email"     autocomplete="new-email" value="{{ old('email', $user?->email) }}" placeholder="email@email.com" class="input w-full @error('email') border-red-500 @enderror">
        @error('email')
        <span class="helper-text text-red-500">{{ $message }}</span>
        @enderror
    </div>
    <div class="w-full">
        <label class="label-text" for="password"> Senha
            @if($isEdit)
                <span class="text-xs text-gray-400">(deixe em branco para não alterar)</span>
            @endif
        </label>
        <input type="password" name="password" id="password" class="input w-full @error('password') border-red-500 @enderror">
        @error('password')
        <span class="helper-text text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="w-full">
        <label class="label-text" for="password_confirmation">
            Confirmar Senha
        </label>
        <input type="password" name="password_confirmation" id="password_confirmation"  class="input w-full" >
    </div>

</div>

<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">
        Perfis (Roles)
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

        @foreach($roles as $roleItem)
            <div class="flex items-center gap-2">
                <input type="checkbox" name="roles[]" value="{{ $roleItem->name }}" id="role_{{ $roleItem->id }}" class="checkbox"
                    {{ (isset($user) && $user->hasRole($roleItem->name)) ? 'checked' : '' }}>
                <label class="label-text text-base" for="role_{{ $roleItem->id }}">
                    {{ $roleItem->name }}
                </label>
            </div>
        @endforeach

    </div>
    @error('roles')
    <span class="helper-text text-red-500">{{ $message }}</span>
    @enderror
</div>
<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('users.index') }}"
       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm">
        Cancelar
    </a>
    <button type="submit"
            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold">
        {{ $isEdit ? 'Atualizar' : 'Cadastrar' }}
    </button>

</div>
