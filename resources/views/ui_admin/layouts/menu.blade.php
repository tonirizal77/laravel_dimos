
@php
    $usaha = DB::table("usaha")->where('id', Auth::user()->usaha_id)->first();
@endphp

<ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu">
    <!-- Add icons to the links using the .nav-icon class
        with font-awesome or any other icon font library -->

    {{-- <li class="nav-header">MENU NAVIGATION</li> --}}
    <li class="nav-item">
        <a href="{{ route('dashboard.index') }}" class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <!-- Usaha not aktif-->
    @if (Auth::user()->usaha_id == null || (Auth::user()->usaha_id != null && $usaha->status == false))
        <li class="nav-header">TRANSACTION</li>
        <li class="nav-item {{ Request::segment(1) == 'pembelian' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::segment(1) == 'pembelian' ? 'active' : '' }}">
                <i class="nav-icon fas fa-store"></i>
                <p>Pembelian Barang<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('/pembelian/daftar-pembelian') }}" class="nav-link {{ Request::segment(2) == 'daftar-pembelian' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Daftar Nota Pembelian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Daftar Hutang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>History Hutang</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item {{ Request::segment(1) == 'order' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::segment(1) == 'order' ? 'active' : '' }}">
                <i class="nav-icon fas fa-store"></i>
                <p>Order Barang<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Buat Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Daftar Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>History Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Menunggu Pembayaran</p>
                    </a>
                </li>
            </ul>
        </li>
        <!-- admin -->
        <li class="nav-header">PENGATURAN</li>
        <li class="nav-item {{ Request::segment(1) == 'usaha' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::segment(1) == 'usaha' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tools"></i>
                <p>Data Toko / Usaha<i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('/usaha/profile-usaha') }}" class="nav-link {{ Request::segment(2) == 'profile-usaha' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Setting Data Usaha</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/usaha/account') }}" class="nav-link {{ Request::segment(2) == 'account' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-angle-double-right"></i>
                        <p>Akun Usaha & Aktivasi</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    <!-- Usaha aktif-->
    @if (Auth::user()->usaha_id != null && $usaha->status == true)
        <!-- Admin -->
        @if (Auth::user()->role_id == 1)
            <li class="nav-header">MASTER DATA</li>
            <li class="nav-item {{ Request::segment(1) == 'master-data' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'master-data' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-database"></i>
                    <p>Master Data<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/master-data/category') }}" class="nav-link {{ Request::segment(2) == 'category' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Kategori Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/master-data/satuans') }}" class="nav-link {{ Request::segment(2) == 'satuans' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Satuan Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/master-data/products') }}" class="nav-link {{ Request::segment(2) == 'products' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Products / Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/master-data/suppliers') }}" class="nav-link {{ Request::segment(2) == 'suppliers' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Supplier / Vendor</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/master-data/customers') }}" class="nav-link {{ Request::segment(2) == 'customers' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Pelanggan / Customer</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">TRANSACTION</li>
            <li class="nav-item {{ Request::segment(1) == 'penjualan' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'penjualan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Penjualan Barang<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/penjualan/pos-kasir') }}" class="nav-link {{ Request::segment(2) == 'pos-kasir' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>POS - Kasir</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Piutang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>History Piutang</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'pembelian' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'pembelian' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-store"></i>
                    <p>Pembelian Barang<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/pembelian/nota-pembelian') }}" class="nav-link {{ Request::segment(2) == 'nota-pembelian' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Buat Nota Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/pembelian/daftar-pembelian') }}" class="nav-link {{ Request::segment(2) == 'daftar-pembelian' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Nota Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Hutang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>History Hutang</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'order' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'order' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cloud-download-alt"></i>
                    <p>
                        Order Masuk<i class="right fas fa-angle-left"></i>
                        <span class="right badge badge-danger">New</span>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/order/daftar-order') }}" class="nav-link {{ Request::segment(2) == 'daftar-order' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Order</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/order/history-order') }}" class="nav-link {{ Request::segment(2) == 'history-order' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>History Order</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">MANAJEMEN STOCK</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i>
                    <p>
                        Manajemen Stock
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Mutasi Stock</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Kartu Stock</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Stock Opname</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">LAPORAN</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-shipping-fast"></i>
                    <p>
                        Penjualan
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Periode Penjualan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Barang Paling Laris</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Barang Tidak Laku</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Piutang Customer</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cart-arrow-down"></i>
                    <p>
                        Pembelian
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Periode Pembelian</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Hutang Usaha</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Transaksi Supplier
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Periode</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Supplier</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Rekapitulasi Transaksi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Transaksi Customer<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Periode</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Barang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Transaksi Per Customer</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Rekapitulasi Transaksi</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">PENGATURAN</li>
            <li class="nav-item {{ Request::segment(1) == 'usaha' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'usaha' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tools"></i>
                    <p>Data Toko / Usaha<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/usaha/profile-usaha') }}" class="nav-link {{ Request::segment(2) == 'profile-usaha' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Setting Data Usaha</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/usaha/account') }}" class="nav-link {{ Request::segment(2) == 'account' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Akun Usaha & Aktivasi</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengaturan/user-management') }}" class="nav-link {{ Request::segment(2) == 'user-management' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-address-book"></i>
                    <p>Pengguna / User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengaturan/notifikasi') }}" class="nav-link {{ Request::segment(2) == 'notifikasi' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bell"></i>
                    <p>Notifikasi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengaturan/lain-lain') }}" class="nav-link {{ Request::segment(2) == 'lain-lain' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Lain-lain</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengaturan/payment-gateway') }}" class="nav-link {{ Request::segment(2) == 'payment-gateway' ? 'active' : '' }}">
                    <i class="nav-icon fab fa-cc-visa"></i>
                    <p>Payment Gateway</p>
                </a>
            </li>

        @endif

        <!-- Khusus Kasir -->
        @if (Auth::user()->role_id == 3)
            <li class="nav-header">MASTER DATA</li>
            <li class="nav-item {{ Request::segment(1) == 'master-data' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'master-data' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-database"></i>
                    <p>Master Data<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/master-data/customers') }}" class="nav-link {{ Request::segment(1) == 'customers' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Pelanggan / Customer</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-header">TRANSACTION</li>
            <li class="nav-item {{ Request::segment(1) == 'penjualan' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'penjualan' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Penjualan Barang<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/penjualan/pos-kasir') }}" class="nav-link {{ Request::segment(2) == 'pos-kasir' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>POS - Kasir</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Piutang</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>History Piutang</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::segment(1) == 'order' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ Request::segment(1) == 'order' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cloud-download-alt"></i>
                    <p>
                        Order Masuk<i class="right fas fa-angle-left"></i>
                        <span class="right badge badge-danger">New</span>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/order/daftar-order') }}" class="nav-link {{ Request::segment(2) == 'daftar-order' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>Daftar Order</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/order/history-order') }}" class="nav-link {{ Request::segment(2) == 'history-order' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-angle-double-right"></i>
                            <p>History Order</p>
                        </a>
                    </li>
                </ul>
            </li>

        @endif
    @endif

    <!-- Khusus Owner -->
    @if (Auth::user()->role_id == 0)
        <li class="nav-header">REGISTER MEMBERS</li>
        <li class="nav-item">
            <a href="{{ url('/register') }}" class="nav-link {{ Request::segment(1) == 'register' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Register Baru</p>
            </a>
        </li>
    @endif
</ul>
