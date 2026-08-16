@include('landingpage.partials.header')
<header class="sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/Logo/logo.png') }}" alt="DormDash Logo" width="60" class="me-2">
                <span class="fw-bold fs-4 logo-text" style="color: #003C87; letter-spacing: -1px;">
                    Dorm<span style="color: #FC7D07;">Dash</span>
                </span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link fw-semibold" href="#home">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle nav-custom-link fw-semibold" href="#" id="aboutUsDropdownDesktop" role="button" data-bs-toggle="dropdown">
                            About
                        </a>
                        <ul class="dropdown-menu border-0 shadow-lg p-3 rounded-3" aria-labelledby="aboutUsDropdownDesktop">
                            <li><a class="dropdown-item rounded-2 py-2" href="#about-us"><i class="bi bi-building me-2"></i> About Us</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link fw-semibold" href="#contact-us">Contact</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link nav-custom-link fw-semibold" href="#faqs">FAQs</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login-tenant') }}" class="btn px-4 py-2 rounded-pill text-white fw-bold shadow-sm" style="background-color: #003C87; transition: 0.3s;">
                            Login / Join
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start border-0 shadow" tabindex="-1" id="mobileNav" style="width: 280px;">
        <div class="offcanvas-header border-bottom py-4">
            <span class="fw-bold fs-4" style="color: #003C87;">Dorm<span style="color: #FC7D07;">Dash</span></span>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav gap-2">
                <li class="nav-item"><a class="nav-link fw-bold text-dark py-2" href="#home"><i class="bi bi-house me-2"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark py-2" href="#about-us"><i class="bi bi-info-circle me-2"></i> About Us</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark py-2" href="#contact-us"><i class="bi bi-telephone me-2"></i> Contact Us</a></li>
                <li class="nav-item"><a class="nav-link fw-bold text-dark py-2" href="#faqs"><i class="bi bi-question-circle me-2"></i> FAQs</a></li>
            </ul>
            <div class="mt-5 px-2">
                <a href="{{ route('login-tenant') }}" class="btn w-100 py-3 rounded-3 text-white fw-bold shadow-sm" style="background-color: #003C87;">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</header>