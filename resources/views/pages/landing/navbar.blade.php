<nav class="flex items-center justify-between p-6 lg:px-8 bg-white/10 backdrop-blur-md" aria-label="Global">
    <div class="flex lg:flex-1">
        <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">Your Company</span>
            <img class="w-auto h-8" src="" alt="anecake logo">
        </a>
    </div>
    <div class="flex lg:hidden">
        <button type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
            data-drawer-placement="right" aria-controls="drawer-right-example"
            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-12">
        
        <a href="#home" class="text-md font-semibold leading-6 text-gray-900">Home</a>
        <a href="#dateCheck" class="text-md font-semibold leading-6 text-gray-900">Produk</a>
        <a href="#pricing" class="text-md font-semibold leading-6 text-gray-900">Layanan</a>
        <a href="#call" class="text-md font-semibold leading-6 text-gray-900">Hubungi Kami</a>
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        <a href="{{route('login')}}" class="text-sm font-semibold leading-6 text-gray-900">Log in <span
                aria-hidden="true">&rarr;</span></a>
    </div>
</nav>