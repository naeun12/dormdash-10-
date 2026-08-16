@include('landlord.auth.partials.header')

<div class="col-md-2 sidebar-modern" id="sidebarMenu">
    <div class="brand-wrapper p-4">
        <a class="navbar-brand d-flex align-items-center text-white text-decoration-none">
            <div class="logo-container me-2">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="Logo" width="40">
            </div>
            <span class="logo-text fw-bold fs-4">DormDash</span>
        </a>
    </div>

    <div class="nav-scrollable">
        <ul class="nav flex-column px-3">
            
            <li class="nav-label mt-2">MAIN</li>
            <li class="nav-item mb-1">
                <a href="{{ route('landlord.dashboard', ['landlordId' => session('landlord_id')]) }}"
                    class="nav-link-modern {{ request()->routeIs('landlord.dashboard') ? 'active-item' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-label mt-4">PROPERTY MANAGEMENT</li>
            <li class="nav-item mb-1">
                <a href="{{ route('landlord.dormanagement', ['landlordId' => session('landlord_id')]) }}"
                    class="nav-link-modern {{ request()->routeIs('landlord.dormanagement') ? 'active-item' : '' }}">
                    <i class="bi bi-house-add"></i>
                    <span>Dorm Management</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('landlordRoomManagement', ['landlordId' => session('landlord_id')]) }}"
                    class="nav-link-modern {{ request()->routeIs('landlordRoomManagement') ? 'active-item' : '' }}">
                    <i class="bi bi-door-open"></i>
                    <span>Manage Rooms</span>
                </a>
            </li>

           
    </div>
</div>

    <link rel="stylesheet" href="{{ asset('css/landlord/sidebar.css') }}">
