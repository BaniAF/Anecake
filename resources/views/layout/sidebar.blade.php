<ul class="menu p-4 w-80 min-h-full bg-base-100 text-base-content border-r-2 border-base-300 space-y-4">
    <!-- Sidebar content here -->
    <li>
        <h2 class="menu-title">Dashboard</h2>
        <ul class="space-y-2">
            <li>
                @auth    
                <li>
                    <a href="{{ route('owner.dashboard') }}" @class(['active' => Route::is('owner.dashboard')]) >
                        <x-tabler-dashboard class="size-5" />
                        <span>Dashboard</span>
                    </a>
                </li>
                @endauth
                <a href="{{ route('admin.dashboard') }}" @class(['active' => Route::is('admin.home')]) >
                    <x-tabler-dashboard class="size-5" />
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Data Master</h2>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.produk') }}" @class(['active' => Route::is('admin.produk')]) >
                    <x-tabler-tools-kitchen-2 class="size-5" />
                    <span>Daftar Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.kategori') }}" @class(['active' => Route::is('admin.kategori')]) >
                    <x-tabler-category-2 class="size-5" />
                    <span>Kategori Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaksi') }}" @class(['active' => Route::is('admin.transaksi')]) >
                    <x-tabler-transaction-dollar class="size-5" />
                    <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.order') }}" @class(['active' => Route::is('admin.order')]) >
                    <x-tabler-transfer class="size-5" />
                    <span>Order</span>
                </a>
            </li>
        </ul>
    </li>
    
    <li>
        <h2 class="menu-title">Setting</h2>
        <ul class="space-y-2">
            {{-- <li>
                <a href="{{route('admin.status')}}">
                    <x-tabler-message-code class="size-5" />
                    <span>Status</span>
                </a>
            </li> --}}
            <li>
                <a href="#">
                    <x-tabler-user class="size-5" />
                    <span>Pengguna</span>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" id="logout">
                    @csrf
                    <button type="submit" class="flex" id="btnLogout">
                        <x-tabler-logout class="size-5 mr-2" />
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </li>

</ul>



