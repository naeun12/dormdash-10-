@include('tenant.accountprocess.partials.header')
<header class="sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg bg-white py-3">
        <div class="container navigation-style">
            <a class="navbar-brand d-flex align-items-center gap-2 text-black" href="{{ route('landingpage') }}">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="DormDash Logo" width="55" class="d-inline-block align-text-top">
                <span class="fw-bold fs-4 logo-text" style="letter-spacing: -1px; color: #003C87;">
                    Dorm<span style="color: #FC7D07;">Dash</span>
                </span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileNav" aria-controls="mobileNav">
                <i class="bi bi-list fs-1" style="color: #003C87;"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link fw-semibold px-3" href="{{ route('landingpage') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle custom-nav-link fw-semibold px-3"
                            href="#" id="aboutUsDropdownDesktop" role="button" data-bs-toggle="dropdown">
                            About Us
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg mt-3 animate__animated animate__fadeInUp"
                            style="border-radius: 15px; min-width: 180px;">
                            <li>
                                <a class="dropdown-item py-2 px-4 rounded-3" href="{{ route('landingpage') }}">
                                    <i class="bi bi-building-fill me-2" style="color: #003C87;"></i> Company Info
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link fw-semibold px-3" href="{{ route('landingpage') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-link fw-semibold px-3" href="{{ route('landingpage') }}">FAQs</a>
                    </li>
                </ul>
            </div>

            <div class="d-none d-lg-flex gap-2 ms-3">
                <a href="{{route('login-tenant')}}" class="btn fw-bold px-4 rounded-pill shadow-sm " 
                 style="background: #FC7D07; border: none; transition: 0.3s;">Resident</a>
                
                <a href="{{ route('landlord-Login') }}" class="btn text-white fw-bold px-4 rounded-pill shadow-sm landlord-btn disabled" 
                    style="background: #e9ecef; color: #6c757d; border: none;" >Property Owner</a>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start border-0 shadow" tabindex="-1" id="mobileNav" style="border-top-right-radius: 25px; border-bottom-right-radius: 25px;">
        <div class="offcanvas-header p-4 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="Logo" width="50">
                <span class="fw-bold fs-4" style="color: #003C87;">DormDash</span>
            </div>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body px-4 py-4">
            <ul class="navbar-nav gap-2">
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-semibold p-3 text-dark rounded-4 bg-light mb-2" href="{{ route('landingpage') }}">
                        <i class="bi bi-house-door-fill me-3" style="color: #003C87;"></i> Home
                    </a>
                </li>
                </ul>
        </div>
        <div class="offcanvas-footer p-4 d-flex flex-column gap-2">
             <a href="{{route('login-tenant')}}" class="btn btn-light fw-bold w-100 py-3 rounded-4 disabled">Login as Resident</a>
             <a href="{{ route('landlord-Login') }}" class="btn text-white fw-bold w-100 py-3 rounded-4" style="background: #FC7D07;">Login as Property Owner</a>
        </div>
    </div>
</header>

<style>

</style>