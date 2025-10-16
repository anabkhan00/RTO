<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Place Bridge Login</title>
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
                    <button id="loginTab"
                        class="flex-1 py-2 font-semibold text-white bg-brand rounded-lg transition duration-300 hover:bg-[#D4B373]"
                        onclick="showForm('login')">
                        Sign In
                    </button>
                    <button id="signupTab"
                        class="flex-1 py-2 font-semibold text-gray-700 rounded-lg transition duration-300 hover:bg-[#D4B373] hover:text-white"
                        onclick="showForm('signup')">
                        Sign Up
                    </button>
                </div>

                <!-- LOGIN FORM -->
                <form id="loginForm" class="space-y-3">
                    <div class="text-left">
                        <label class="block text-sm font-semibold mb-1">Email</label>
                        <input type="email" placeholder="Enter Email"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />

                    </div>

                    <div class="text-left">
                        <div class="flex justify-between">
                            <label class="block text-sm font-semibold ">Password</label>
                            <a href="#"
                                class="text-sm text-mycolr float-right mb-1 text-sm underline decoration-mycolr hover:decoration-gold transition-all">
                                Forgot Password?
                            </a>

                        </div>
                        <input type="password" placeholder="Enter Password"
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />

                    </div>
                    <!-- Password Tips -->
                    <ul class="text-xs text-start text-mycolr space-y-1">
                        <li><i class="bi bi-check-lg"></i> Password Strength: Weak</li>
                        <li><i class="bi bi-check-lg"></i> Cannot contain your name or email</li>
                        <li><i class="bi bi-check-lg"></i> At least 8 characters</li>
                        <li><i class="bi bi-check-lg"></i> Contains a number or symbol</li>
                    </ul>
                    <button type="button"
                        class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                        Sign In
                    </button>




                </form>

                <!-- SIGNUP FORM -->
                <form id="signupForm" class="space-y-3 hidden">
                    <p>Training Organization Information</p>
                    <div class="text-left">
                        <label class="block text-sm font-semibold mb-1"> Name</label>
                        <input type="text" placeholder="Enter Name"
                            class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
<div class="w-full flex flex-wrap ">
  <div class="w-full md:w-1/2 pe-2">
    <div class="text-left">
      <label class="block text-sm font-semibold mb-1">Phone Number</label>
      <input type="email" placeholder="Enter Phone Number"
        class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
    </div>
  </div>
  
  <div class="w-full md:w-1/2 ps-2">
    <div class="text-left">
      <label class="block text-sm font-semibold mb-1">Email</label>
      <input type="password" placeholder="Enter Email"
        class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
    </div>
  </div>
</div>
   <div class="w-full flex flex-wrap ">
  <div class="w-full md:w-1/2 pe-2">
    <div class="text-left">
      <label class="block text-sm font-semibold mb-1">Password</label>
      <input type="email" placeholder="Enter Password"
        class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
    </div>
  </div>
  
  <div class="w-full md:w-1/2 ps-2">
    <div class="text-left">
      <label class="block text-sm font-semibold mb-1">Confirm Password</label>
      <input type="password" placeholder="Confirm Password"
        class="w-full border border-gold bg-white rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
    </div>
  </div>
</div>

               
            
                    <button type="button"
                        class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                        Sign Up
                    </button>




                </form>
                <p class="mt-5 text-xs text-center text-mycolr font-medium">By signing up to create an account I accept
                    Company’s <span class="text-brand">Terms of use & Privacy Policy.</span></p>
            </div>
        </div>
    </div>
    <script>
        function showForm(type) {
            const loginForm = document.getElementById("loginForm");
            const signupForm = document.getElementById("signupForm");
            const loginTab = document.getElementById("loginTab");
            const signupTab = document.getElementById("signupTab");

            if (type === "signup") {
                loginForm.classList.add("hidden");
                signupForm.classList.remove("hidden");

                // Active signup
                signupTab.classList.add("bg-brand", "text-white");
                signupTab.classList.remove("text-gray-700");

                // Inactive login
                loginTab.classList.remove("bg-brand", "text-white");
                loginTab.classList.add("text-gray-700");
            } else {
                signupForm.classList.add("hidden");
                loginForm.classList.remove("hidden");

                // Active login
                loginTab.classList.add("bg-brand", "text-white");
                loginTab.classList.remove("text-gray-700");

                // Inactive signup
                signupTab.classList.remove("bg-brand", "text-white");
                signupTab.classList.add("text-gray-700");
            }
        }
    </script>
</body>

</html>
