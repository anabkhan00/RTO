<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RTO Dashboard</title>
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
    <link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
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
</head>

<body class="bg-gray-100 font-[Poppins,sans-serif] relative">
    <!-- Sidebar -->
    @include('rto.layout.sidebar')
    <!-- Main Content -->
    <div id="mainContent" class="transition-all duration-300 ml-64 min-h-screen bg-gray-100">
        <!-- Top Bar -->
        @include('rto.layout.header')

        <!-- Content -->

        <main class="p-6">
            @yield('content')
        </main>

    </div>
    {{-- <script src="{{asset('assets/js/main.js') }}"></script> --}}
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000"
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
         document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.getElementById("mainContent");
            const menuBtn = document.getElementById("menuBtn");

            if (menuBtn && sidebar && mainContent) {
                menuBtn.addEventListener("click", () => {
                    sidebar.classList.toggle("-translate-x-full");
                    mainContent.classList.toggle("ml-64");
                    mainContent.classList.toggle("ml-0");
                });
            }

            // ---- Modal Logic ----
            const modal = document.getElementById("rtoModal");
            const openModalBtn = document.getElementById("openModalBtn");
            const closeModalBtn = document.getElementById("closeModalBtn");
            const closeModalBtn2 = document.getElementById("closeModalBtn2");

            if (openModalBtn && modal) {
                openModalBtn.addEventListener("click", () => modal.classList.remove("hidden"));
            }

            if (closeModalBtn && modal) {
                closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
            }

            if (closeModalBtn2 && modal) {
                closeModalBtn2.addEventListener("click", () => modal.classList.add("hidden"));
            }

            if (modal) {
                modal.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        modal.classList.add("hidden");
                    }
                });
            }
        });


        // const openModalBtn = document.getElementById("openModalBtn");
        // const closeModalBtn = document.getElementById("closeModalBtn");
        // const closeModalBtn2 = document.getElementById("closeModalBtn2");
        const modal = document.getElementById("rtoModal");

        openModalBtn.addEventListener("click", () => {
            modal.classList.remove("hidden");
        });

        closeModalBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        closeModalBtn2.addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        // close modal on clicking outside
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });
    </script>
</body>

</html>
