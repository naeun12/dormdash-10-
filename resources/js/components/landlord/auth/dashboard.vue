<template>
    <div class="main-content w-100">
        <div class="dashboard-content px-2 px-md-4 py-3">
            <!-- Header -->
            <div class="stats-filter-card p-4 mb-4 shadow-sm border-0">
                <div
                    class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4"
                >
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-icon-box">
                            <i
                                class="bi bi-person-badge-fill text-white fs-3"
                            ></i>
                        </div>

                        <div>
                            <span class="nav-label d-block mb-1">
                                PROPERTIES OF
                            </span>

                            <h3 class="fw-800 text-dark mb-0">Demo Test</h3>
                        </div>
                    </div>

                    <div
                        class="d-flex flex-column flex-md-row gap-3 flex-grow-1 justify-content-lg-end"
                    >
                        <!-- Date -->
                        <div class="filter-group">
                            <label class="nav-label"> REPORT DATE </label>

                            <div class="input-with-icon">
                                <i class="bi bi-calendar3"></i>

                                <input
                                    type="date"
                                    class="form-control modern-input"
                                />
                            </div>
                        </div>

                        <!-- Dormitory -->
                        <div class="filter-group">
                            <label class="nav-label"> SELECT DORMITORY </label>

                            <div class="dropdown">
                                <button
                                    class="btn modern-dropdown-btn dropdown-toggle w-100"
                                    type="button"
                                    data-bs-toggle="dropdown"
                                >
                                    <i class="bi bi-building me-2"></i>
                                    All Dormitories
                                </button>

                                <ul
                                    class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2"
                                >
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Dormitory A
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Dormitory B
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            Dormitory C
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Export -->
                        <div class="filter-group d-flex align-items-end">
                            <button
                                class="btn download-btn w-100"
                                type="button"
                            >
                                <i class="bi bi-cloud-arrow-down-fill me-2"></i>
                                Export PDF Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row g-4 mb-4">
                <!-- Tenants -->
                <div class="col-12 col-md-6">
                    <div class="modern-stat-card bg-brand-blue">
                        <div class="glass-shine"></div>

                        <div class="card-inner">
                            <div class="stat-content">
                                <span class="stat-category"> MANAGEMENT </span>

                                <h5 class="stat-title">Total Tenants</h5>

                                <h2 class="stat-number">24</h2>
                            </div>

                            <div class="stat-visual">
                                <div class="icon-blob">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-action-bar">
                            <span>View Directory</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </div>

                <!-- Vacant Beds -->
                <div class="col-12 col-md-6">
                    <div class="modern-stat-card bg-brand-orange">
                        <div class="glass-shine"></div>

                        <div class="card-inner">
                            <div class="stat-content">
                                <span class="stat-category">
                                    AVAILABILITY
                                </span>

                                <h5 class="stat-title">Vacant Beds</h5>

                                <h2 class="stat-number">8</h2>
                            </div>

                            <div class="stat-visual">
                                <div class="icon-blob">
                                    <i class="bi bi-door-open-fill"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-action-bar">
                            <span>Manage Inventory</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts d-flex flex-wrap gap-4 mb-4">
                <!-- Revenue -->
                <div class="modern-chart-card flex-grow-1">
                    <div class="chart-header">
                        <div class="header-icon-box">
                            <i class="bi bi-graph-up-arrow text-primary"></i>
                        </div>

                        <div>
                            <span class="nav-label"> REVENUE TRENDS </span>

                            <h6 class="fw-bold m-0">Highest Rooms Profits</h6>
                        </div>
                    </div>

                    <div class="chart-body pt-3">
                        <div class="row text-center">
                            <div class="col">
                                <h6>Room 101</h6>
                                <h4>₱12,500</h4>
                            </div>

                            <div class="col">
                                <h6>Room 102</h6>
                                <h4>₱10,800</h4>
                            </div>

                            <div class="col">
                                <h6>Room 201</h6>
                                <h4>₱9,500</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gender -->
                <div class="modern-chart-card flex-grow-1">
                    <div class="chart-header">
                        <div class="header-icon-box icon-orange">
                            <i class="bi bi-person-lines-fill text-primary"></i>
                        </div>

                        <div>
                            <span class="nav-label"> DEMOGRAPHICS </span>

                            <h6 class="fw-bold m-0">Occupants by Gender</h6>
                        </div>
                    </div>

                    <div class="chart-body pt-3">
                        <div class="row">
                            <div class="col-6">
                                <div class="p-3 rounded bg-light text-center">
                                    <i class="bi bi-gender-male fs-3"></i>

                                    <h5 class="mt-2">Male</h5>

                                    <h3>15</h3>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="p-3 rounded bg-light text-center">
                                    <i class="bi bi-gender-female fs-3"></i>

                                    <h5 class="mt-2">Female</h5>

                                    <h3>9</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="row g-4">
                <div class="col-12 col-lg-6">
                    <div class="modern-table-card">
                        <div class="card-top-accent bg-brand-blue"></div>

                        <div class="p-4">
                            <div
                                class="d-flex justify-content-between align-items-center mb-4"
                            >
                                <div>
                                    <span class="nav-label"> LOGISTICS </span>

                                    <h5 class="fw-bold m-0">
                                        <i
                                            class="bi bi-calendar-check-fill me-2 text-brand-blue"
                                        >
                                        </i>

                                        Recent Bookings
                                    </h5>
                                </div>

                                <span class="status-pill pill-blue">
                                    Live Update
                                </span>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Tenant Name</th>
                                            <th>Move-In</th>
                                            <th class="text-end">Room</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">
                                                Maria Santos
                                            </td>

                                            <td>Aug 15, 2026</td>

                                            <td class="text-end">
                                                <span class="room-tag">
                                                    101
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">John Cruz</td>

                                            <td>Aug 14, 2026</td>

                                            <td class="text-end">
                                                <span class="room-tag">
                                                    102
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Anna Reyes</td>

                                            <td>Aug 13, 2026</td>

                                            <td class="text-end">
                                                <span class="room-tag">
                                                    201
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservations -->
                <div class="col-12 col-lg-6">
                    <div class="modern-table-card">
                        <div class="card-top-accent bg-brand-orange"></div>

                        <div class="p-4">
                            <div
                                class="d-flex justify-content-between align-items-center mb-4"
                            >
                                <div>
                                    <span class="nav-label"> PENDING </span>

                                    <h5 class="fw-bold m-0">
                                        <i
                                            class="bi bi-person-plus-fill me-2 text-brand-orange"
                                        >
                                        </i>

                                        Recent Reservations
                                    </h5>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Tenant Name</th>

                                            <th class="text-end">
                                                Room Assigned
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">
                                                Pedro Garcia
                                            </td>

                                            <td class="text-end">
                                                <span
                                                    class="room-tag orange-tag"
                                                >
                                                    202
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Sofia Tan</td>

                                            <td class="text-end">
                                                <span
                                                    class="room-tag orange-tag"
                                                >
                                                    203
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Kevin Lim</td>

                                            <td class="text-end">
                                                <span
                                                    class="room-tag orange-tag"
                                                >
                                                    301
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Dashboard",
};
</script>

<style scoped src="../../../../css/landlord/dashboard.css"></style>
