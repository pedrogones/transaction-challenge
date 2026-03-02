<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Editar tenant</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Atualize os dados do tenant e seu dominio principal.
                        </p>
                    </div>

                    <form action="{{ route('central.tenants.update', $tenant->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('central.tenants.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>