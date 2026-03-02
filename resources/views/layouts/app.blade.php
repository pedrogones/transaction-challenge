<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass {
            background: rgba(17, 24, 39, 0.55);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.08);
        }
        .card-border {
            border: 1px solid rgba(255,255,255,.07);
        }
        .scrollbar-dark::-webkit-scrollbar { width: 10px; }
        .scrollbar-dark::-webkit-scrollbar-thumb { background: rgba(255,255,255,.10); border-radius: 10px; }
        .scrollbar-dark::-webkit-scrollbar-track { background: transparent; }
        .hero-gradient{
            background:
                radial-gradient(1200px 500px at 10% 10%, rgba(168,85,247,.35), transparent 50%),
                radial-gradient(900px 450px at 90% 30%, rgba(59,130,246,.35), transparent 55%),
                linear-gradient(135deg, rgba(168,85,247,.35), rgba(59,130,246,.35));
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-950 text-slate-100">
<div class="min-h-screen flex">

    <div class="loader hidden" id="globalLoader">
        <div class="three-body">
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
            <div class="three-body__dot"></div>
        </div>
    </div>

    @auth
        @include('layouts.sidebar')
    @endauth

    <div class="flex-1 flex flex-col min-w-0">
        @auth
            @include('layouts.topbar')
        @endauth

        <main class="flex-1 p-6 lg:p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            timeOut: 3500,
            positionClass: 'toast-top-right'
        };

        @if(session('success')) toastr.success(@json(session('success'))); @endif
        @if(session('error')) toastr.error(@json(session('error'))); @endif
        @if(session('warning')) toastr.warning(@json(session('warning'))); @endif
        @if(session('info')) toastr.info(@json(session('info'))); @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error(@json($error));
            @endforeach
        @endif
    });

    $(document).on('submit', '.form-delete', function (e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Tem certeza?',
            text: 'Esse registro sera excluido.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });

    $(document).on('click', '[data-sidebar-open]', function () {
        $('#sidebarOverlay').removeClass('hidden');
        $('#appSidebar').removeClass('-translate-x-full');
    });

    $(document).on('click', '[data-sidebar-close]', function () {
        $('#sidebarOverlay').addClass('hidden');
        $('#appSidebar').addClass('-translate-x-full');
    });

    $(document).on('click', '#sidebarOverlay', function () {
        $('#sidebarOverlay').addClass('hidden');
        $('#appSidebar').addClass('-translate-x-full');
    });
</script>
@stack('scripts')
</body>
</html>
