<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/logo.png') }}" alt="Kawaii Apartement Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.banner.index') }}"
                        class="nav-link{{request()->is('admin/banner*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            Data Banner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.room.index') }}"
                        class="nav-link{{request()->is('admin/room*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Data Kamar
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reservasi.index') }}"
                        class="nav-link{{request()->is('admin/reservasi*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-swatchbook"></i>
                        <p>
                            Reservasi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.tamu.index') }}"
                        class="nav-link{{request()->is('admin/tamu*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Data Tamu
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.voucher.index') }}"
                        class="nav-link{{request()->is('admin/voucher*') ? ' active' : '' }}">
                        <i class="fas fa-ticket-alt"></i>
                        <p>
                            Data Voucher
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>