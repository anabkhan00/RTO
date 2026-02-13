<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PlaceBridge - @yield('page-title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>

<style>
    /* Remove toastr background icons (tick, error, info, warning) */
    #toast-container > .toast {
        background-image: none !important;
        padding-left: 14px !important;
    }

    /* Compact professional sizing */
    #toast-container > div {
        padding: 10px 14px;
        width: 280px;
        font-size: 13px;
        line-height: 1.4;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    #toast-container .toast-title {
        font-size: 13px;
        font-weight: 600;
    }

    #toast-container .toast-message {
        font-size: 12px;
    }

    #toast-container .toast-close-button {
        font-size: 16px;
        top: 6px;
        right: 8px;
        opacity: 0.6;
    }
</style>



    <script>
        tailwind.config = {
            /*  */
            theme: {
                extend: {
                    colors: {
                        brand: '#1E293B', // Dark navy
                        gold: '#D4B373', // Gold accent
                        mycolr: '#26203B3D',
                        searchh: '#1E293B14'
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        graysoft: '0 4px 15px rgba(0, 0, 0, 0.1)', // subtle grey shadow
                        graydeep: '0 6px 25px rgba(0, 0, 0, 0.2)', // deeper grey shadow
                    },
                },
            },
        }
    </script>
    @stack('styles')
</head>


<body class="bg-gray-100 font-[Poppins,sans-serif] relative">
    <!-- Sidebar -->
    @include('admin.layout.sidebar')
    <!-- Right Sidebar (context panel) -->
    <aside id="rightSidebar"
        class="fixed top-0 right-0 h-full w-80 bg-white border-l border-gray-200 shadow-xl transform translate-x-full transition-transform duration-300 z-40">
        <div id="rightSidebarContent" class="h-full">
            @yield('right-sidebar')
        </div>
    </aside>
    <button id="rightSidebarToggle"
        class="fixed bottom-6 right-6 hidden items-center gap-2 px-3 py-2 rounded-full bg-brand text-white text-xs font-medium shadow-lg hover:bg-gold transition-colors z-50"
        type="button">
        <i class="bi bi-layout-sidebar-inset-reverse"></i>
        Panel
    </button>
    <!-- Main Content -->
    <div id="mainContent" class="transition-all duration-300 ml-64 min-h-screen bg-gray-100">
        <!-- Top Bar -->
        @include('admin.layout.header')

        <!-- Content -->

        <main class="p-6">
            @yield('content')
        </main>

    </div>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('vendor-scripts')
    <!-- Google Maps API -->
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 4000,
            extendedTimeOut: 1500,
            newestOnTop: true
        };

        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif
        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}');
            @endforeach
        @endif
    </script>
    <script>
        (function() {
            const sidebar = document.getElementById('rightSidebar');
            const content = document.getElementById('rightSidebarContent');
            const toggle = document.getElementById('rightSidebarToggle');
            if (!sidebar || !content || !toggle) return;

            const hasContent = !!content.querySelector('[data-right-sidebar="true"]');
            if (!hasContent) return;

            toggle.classList.remove('hidden');
            toggle.classList.add('inline-flex');

            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('translate-x-full');
            });
        })();
    </script>
    @stack('scripts')
    @yield('scripts')
</body>

</html>
