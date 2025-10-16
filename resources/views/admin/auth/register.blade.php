<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Place Bridge Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#1E293B', // Dark navy
                        gold: '#D4B373', // Gold accent
                        mycolr: '#26203B3D',
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

<body class="h-screen w-screen font-sans bg-gray-100 font-poppins">
    <div class="flex h-full w-full">

        <!-- LEFT SIDE -->
        <div class="hidden md:flex w-1/2  text-white p-10"
            style="background-image: url('{{ asset('assets/images/loginbackground.svg') }}'); background-size: cover;">

            <div class="flex flex-col justify-between h-full ">
                <!-- Top Section -->
                <div>
                    <h1 class="text-4xl font-bold  leading-snug text-brand">Welcome to Place Bridge</h1>
                    <p class="text-lg text-brand font-medium mt-3 leading-snug">Connecting students with real industry
                        experience</p>
                </div>

                <!-- Bottom Section -->
                <div>
                    <h2 class="text-4xl font-bold  leading-snug text-brand mb-3">Seamless Collaboration</h2>
                    <p class="text-lg text-brand font-medium mt-3 leading-snug">
                        Connecting students with meaningful work placement opportunities across Australia.
                    </p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex w-full md:w-[55%] justify-center items-center bg-white px-3 md:px-6 relative">
            <div class="w-full max-w-md">

                <!-- Logo -->
                <div class="mb-3 text-start">
                    <img src="{{ asset('assets/images/logo.svg') }}" class="w-50 " alt="Logo">
                </div>

                <div class="flex bg-gray-100 rounded-full mb-2 overflow-hidden p-1">
                    <a href="{{ route('login') }}"
                        class="flex-1 py-2 font-semibold text-gray-700 rounded-lg transition duration-300 hover:bg-[#D4B373] hover:text-white text-center">
                        Sign In
                    </a>
                    <button
                        class="flex-1 py-2 font-semibold text-white bg-brand rounded-lg transition duration-300 hover:bg-[#D4B373]">
                        Sign Up
                    </button>
                </div>

                <!-- REGISTER FORM -->
                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="text-left">
                        <label class="block text-sm font-semibold mb-1">Role</label>
                        <select name="role" id="roleSelect" required onchange="toggleFields()"
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200">
                            <option value="">Select Role</option>
                            <option value="user">Student</option>
                            <option value="rto">RTO</option>
                        </select>
                    </div>

                    <div class="text-left">
                        <label class="block text-sm font-semibold mb-1">Name</label>
                        <input type="text" name="name" placeholder="Enter Name" required
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div class="text-left">
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" placeholder="Enter Email" required
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <!-- Student Address Field -->
                    <div id="studentField" class="text-left hidden">
                        <label class="block text-sm font-semibold mb-1">Address</label>
                        <input type="text" name="address" placeholder="Enter Address"
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <!-- RTO Number Field -->
                    <div id="rtoField" class="text-left hidden">
                        <label class="block text-sm font-semibold mb-1">RTO Number</label>
                        <input type="text" name="rto_number" placeholder="Enter RTO Number"
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div class="w-full flex flex-wrap">
                        <div class="w-full md:w-1/2 pe-2">
                            <div class="text-left">
                                <label class="block text-sm font-semibold mb-1">Password</label>
                                <input type="password" name="password" placeholder="Enter Password" required
                                    class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                            </div>
                        </div>

                        <div class="w-full md:w-1/2 ps-2">
                            <div class="text-left">
                                <label class="block text-sm font-semibold mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required
                                    class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                        Sign Up
                    </button>
                </form>

                <p class="mt-5 text-xs text-center text-mycolr font-medium">By signing up to create an account I accept
                    Company's <span class="text-brand">Terms of use & Privacy Policy.</span></p>
            </div>
        </div>
    </div>
<script>
function toggleFields() {
    const roleSelect = document.getElementById('roleSelect');
    const studentField = document.getElementById('studentField');
    const rtoField = document.getElementById('rtoField');
    
    // Hide all fields first
    studentField.classList.add('hidden');
    rtoField.classList.add('hidden');
    
    // Show relevant field based on selection
    if (roleSelect.value === 'user') {
        studentField.classList.remove('hidden');
    } else if (roleSelect.value === 'rto') {
        rtoField.classList.remove('hidden');
    }
}
</script>

</body>

</html>