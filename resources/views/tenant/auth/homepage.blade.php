@include('tenant.auth.partials.navigation')

<!-- Hero Section with Full-Width Carousel -->
<section class="">
    <div id="dormDashCarousel" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel">
        <div class="carousel-indicators custom-indicators">
            <button type="button" data-bs-target="#dormDashCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
            <button type="button" data-bs-target="#dormDashCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#dormDashCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner shadow-lg">
            <div class="carousel-item active">
                <div class="hero-overlay"></div>
                <img src="{{ asset('images/tenant/homepage/caruasel/img2.jpg') }}" class="d-block w-100 hero-img" alt="Slide 1">
                <div class="carousel-caption text-start custom-caption animate__animated animate__fadeInUp">
                    <h1 class="display-4 fw-bold">Welcome to <span class="text-dash-orange">DormDash</span></h1>
                    <p class="lead opacity-90">Find your ideal dormitory with ease—search, compare, and connect all in one place.</p>
                    <div class="mt-4">
                       
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <div class="hero-overlay"></div>
                <img src="{{ asset('images/tenant/homepage/caruasel/image1.jpg') }}" class="d-block w-100 hero-img" alt="Slide 2">
                <div class="carousel-caption text-start custom-caption animate__animated animate__fadeInUp">
                    <h1 class="display-4 fw-bold">Comfortable & <span class="text-dash-orange">Affordable</span></h1>
                    <p class="lead opacity-90">Browse verified listings tailored for students and young professionals across the city.</p>
                </div>
            </div>

            <div class="carousel-item">
                <div class="hero-overlay"></div>
                <img src="{{ asset('images/tenant/homepage/caruasel/image3.jpg') }}" class="d-block w-100 hero-img" alt="Slide 3">
                <div class="carousel-caption text-start custom-caption animate__animated animate__fadeInUp">
                    <h1 class="display-4 fw-bold">Direct <span class="text-dash-orange">Connections</span></h1>
                    <p class="lead opacity-90">Message property owners directly and secure your next home hassle-free with our verified system.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#dormDashCarousel" data-bs-slide="prev">
            <span class="control-icon"><i class="bi bi-chevron-left"></i></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#dormDashCarousel" data-bs-slide="next">
            <span class="control-icon"><i class="bi bi-chevron-right"></i></span>
        </button>
    </div>
</section>

<style>
    /* Hero Image and Overlay */
    .hero-img {
        height: 80vh;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(0, 60, 135, 0.7) 0%, rgba(0, 0, 0, 0.2) 100%);
        z-index: 1;
    }

    /* Custom Glassmorphism Caption */
    .custom-caption {
        z-index: 2;
        bottom: 20% !important;
        left: 10% !important;
        right: auto !important;
        max-width: 600px;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .text-dash-orange {
        color: #FC7D07;
    }

    .btn-dash-primary {
        background-color: #003C87;
        color: white;
        border: none;
        transition: 0.3s;
    }

    .btn-dash-primary:hover {
        background-color: #002c63;
        transform: translateY(-3px);
        color: white;
    }

    /* Custom Indicators */
    .custom-indicators [button] {
        width: 40px;
        height: 5px;
        border-radius: 5px;
        margin: 0 5px;
    }

    .custom-indicators .active {
        background-color: #FC7D07 !important;
    }

    /* Modern Controls */
    .control-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        backdrop-filter: blur(5px);
        font-size: 1.5rem;
        transition: 0.3s;
    }

    .carousel-control-next:hover .control-icon,
    .carousel-control-prev:hover .control-icon {
        background: #FC7D07;
        color: white;
    }

    /* Mobile Adjustments */
    @media (max-width: 768px) {
        .hero-img { height: 60vh; }
        .custom-caption {
            left: 5% !important;
            right: 5% !important;
            bottom: 10% !important;
            padding: 1.5rem;
            text-align: center !important;
        }
        .carousel-caption h1 { font-size: 2rem; }
    }
</style>
<!-- HTML -->
<div id="homepage">
    <tenants-auth-homepage></tenants-auth-homepage>
</div>

@include('tenant.auth.partials.footer')
