 
        <header class="grid grid-cols-3 items-center bg-white p-4 shadow-md sticky top-0 z-40">
            <!-- LEFT: Toggle + Title -->
            <div class="flex items-center gap-3">
                <button id="menuBtn" class="text-2xl text-gray-700 focus:outline-none">
                    <img src="{{ asset('assets/images/todle.svg') }}" class="w-8" />

                </button>
                <h2 class="font-semibold text-lg">RTO</h2>
            </div>

            <!-- CENTER: Search -->
            <div class="flex justify-center hidden md:block">
                <div class="relative w-full max-w-2xl">
                    <input type="text" placeholder="Search..."
                        class="w-full py-2 pl-4 pr-10 rounded-xl bg-searchh text-brand placeholder-mycolr focus:outline-none focus:ring-1 focus:ring-brand" />
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute right-4 top-3 text-gray-700"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </div>
            </div>


            <!-- RIGHT: User Info + Profile -->
            <div class="flex justify-end items-center gap-3">
                <div class="text-right hidden md:block">
                    <p class="font-semibold text-sm">Ahmad Ali</p>
                    <p class="text-xs text-gray-500">ahmad@example.com</p>
                </div>
                <div class="hidden md:block">
                    <img src="{{ asset('assets/images/profile.svg') }}" class="w-10 " />
                </div>
            </div>
        </header>