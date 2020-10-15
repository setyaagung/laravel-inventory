<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Inventory <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->segment(1) == 'supplier') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('supplier.index')}}">
            <i class="fas fa-fw fa-user-friends"></i>
        <span>Supplier</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->segment(1) == 'product') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('product.index')}}">
            <i class="fas fa-fw fa-box"></i>
        <span>Produk</span>
        </a>
    </li>

    <li class="nav-item {{ (request()->segment(1) == 'purchase') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('purchase.index')}}">
            <i class="fas fa-fw fa-cart-plus"></i>
        <span>Pemesanan</span>
        </a>
    </li>

    <li class="nav-item {{ (request()->segment(1) == 'goodreceipt') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('goodreceipt.index')}}">
            <i class="fas fa-fw fa-receipt"></i>
        <span>Good Receipt</span>
        </a>
    </li>

    <li class="nav-item {{ (request()->segment(1) == 'sale') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('sale.create')}}">
            <i class="fas fa-fw fa-receipt"></i>
        <span>POS</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>