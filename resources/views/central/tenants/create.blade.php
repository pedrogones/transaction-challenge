<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Novo tenant</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Crie um tenant com dominio proprio e provisionamento automatico de banco.
                        </p>
                    </div>

                    <form action="{{ route('central.tenants.store') }}" method="POST">
                        @csrf
                        @include('central.tenants.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>