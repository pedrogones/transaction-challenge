<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Perfil') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('roles.store') }}" autocomplete="off" method="POST">
                        @csrf
                        @include('admin-painel.roles.form')
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
