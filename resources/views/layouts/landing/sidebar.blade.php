<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a>
        </li>
        <li class="nav-title">
            Produk
        </li>

        {{-- Kategori --}}
        <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Kategori</a>
        </li>

        {{-- Produk --}}
        <li class="nav-item"><a class="nav-link" href="{{ route('produk.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Produk</a>
        </li>

        {{-- Transaksi --}}
        <li class="nav-item"><a class="nav-link" href="{{ route('transaksi.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Transaksi</a>
        </li>

    </ul>
</div>
