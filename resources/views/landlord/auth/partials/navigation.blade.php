@if (session('landlord_logged_in'))
    <header class="modern-top-bar py-2 px-4 d-flex justify-content-between align-items-center">
        
        <div class="d-flex align-items-center gap-3">
            <button class="btn d-md-none p-0 border-0 text-primary-blue" type="button" id="sidebarToggle">
                <i class="bi bi-text-left fs-1"></i>
            </button>
            
            <div class="header-breadcrumb d-none d-sm-block">
                <span class="text-muted small fw-medium text-uppercase tracking-wider">Workspace</span>
                <h4 class="mb-0 fw-800 text-dark header-title-text">{{ $headerName }}</h4>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3 gap-md-4">

           

            <div class="dropdown">
                <button class="icon-btn-circle position-relative" type="button"
                    id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                   
                </button>

                <ul class="dropdown-menu dropdown-menu-end modern-dropdown mt-3" aria-labelledby="notificationDropdown">
                    <li class="dropdown-header-box">
                        <h6 class="mb-0 text-white">Notifications</h6>
                      
                    </li>

                    <div class="notif-scroll-area">
                       
                    </div>

                    <li><hr class="dropdown-divider"></li>
                    <li class="p-2 pt-0">
                        <a href="" class="view-all-btn">
                            See all activity
                        </a>
                    </li>
                </ul>
            </div>

            <div class="dropdown">
                <button class="profile-trigger" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-container">
                        <img src="{{ asset(session('landlord_avatar')) }}" alt="Avatar">
                        <div class="status-indicator"></div>
                    </div>
                    <div class="profile-info d-none d-md-block text-start">
                        <p class="user-name mb-0">Landlord Panel</p>
                        <p class="user-role mb-0">Online</p>
                    </div>
                    <i class="bi bi-chevron-down ms-2 d-none d-md-block opacity-50"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end modern-dropdown mt-3" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item py-2" href="">
                            <i class="bi bi-person-badge me-2 text-primary-blue"></i> My Account
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
@endif

<link rel="stylesheet" href="{{ asset('css/landlord/navigation.css') }}">