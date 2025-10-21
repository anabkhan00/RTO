<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RTO Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#1E293B',
                        gold: '#D4B373',
                        mycolr: '#26203B3D',
                        searchh: '#1E293B14'
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    boxShadow: {
                        graysoft: '0 4px 15px rgba(0, 0, 0, 0.1)',
                        graydeep: '0 6px 25px rgba(0, 0, 0, 0.2)',
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-gray-100 font-[Poppins,sans-serif] relative">
    @include('rto.layout.sidebar')
    <div id="mainContent" class="transition-all duration-300 ml-64 min-h-screen bg-gray-100">
        @include('rto.layout.header')
        <main class="p-6">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>