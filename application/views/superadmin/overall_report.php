<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Badminton Academy</title>
    <!-- Favicon -->
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/analytics.css'); ?>">
   <style>
    /* Base Styles */
    html { box-sizing: border-box; }
    *, *::before, *::after { box-sizing: inherit; }
    body {
        font-family: 'Montserrat', sans-serif !important;
        background-color: #f4f6f8;
        margin: 0;
        padding-top: 60px;
        -webkit-text-size-adjust: 100%;
    }

    .container-responsive {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .content-wrapper {
        margin-left: 250px;
        padding: 15px;
        transition: margin-left 0.3s ease;
    }

    .content-wrapper.minimized {
        margin-left: 60px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        width: 100%;
        min-height: 400px;
        display: flex; /* Added to ensure consistent card sizing */
        flex-direction: column; /* Added for vertical layout */
        height: 100%; /* Added to make card fill entire height of chart-container */
    }

    .card-header {
        background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
        color: white;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
        font-size: clamp(1rem, 3vw, 1.2rem);
    }

    .btn-primary,
    .btn--primary {
        background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
        border: none;
    }

    .btn-primary:hover,
    .btn--primary:hover {
        opacity: 0.9;
    }

    .btn-secondary,
    .btn--secondary {
        background: #6c757d;
        border: none;
    }

    .btn-secondary:hover,
    .btn--secondary:hover {
        opacity: 0.9;
    }

    .kpi-card,
    .overview-card {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        cursor: pointer;
        transition: transform 0.2s;
        width: 100%;
        min-height: 150px;
        display: flex;
        align-items: center;
    }

    .kpi-card:hover,
    .overview-card:hover {
        transform: translateY(-2px);
    }

    .kpi-card__trend.positive {
        color: #28a745;
    }

    .kpi-card__trend.negative {
        color: #dc3545;
    }

    .kpi-card__content,
    .overview-card__content {
        flex: 1;
    }

    .kpi-card__title,
    .overview-card__title {
        font-size: clamp(1rem, 2.5vw, 1.1rem);
        margin-bottom: 10px;
    }

    .kpi-card__value,
    .overview-card__value {
        font-size: clamp(1.2rem, 3.5vw, 1.5rem);
        font-weight: 600;
    }

    /* Table Styling */
    .data-table-container {
        overflow-x: auto;
        margin-bottom: 30px;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    .data-table-container::-webkit-scrollbar {
        display: none;  /* Chrome, Safari, Opera */
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .data-table th {
        background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
        color: white;
        padding: 15px 20px;
        text-align: left;
        font-weight: 600;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
        border-bottom: 2px solid #dee2e6;
    }

    .data-table td {
        padding: 15px 20px;
        font-size: clamp(0.85rem, 2.5vw, 0.95rem);
        border-bottom: 1px solid #dee2e6;
        text-align: left;
    }

    .data-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Grid Layouts */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .revenue-overview-grid,
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    /* Chart Containers */
    .chart-container {
        width: 100%;
        height: clamp(300px, 50vw, 450px);
        position: relative;
        overflow: hidden;
    }

    .chart-container canvas {
        width: 100% !important;
        height: 100% !important;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-body {
        flex: 1; /* Added to allow card-body to expand and fill remaining space */
        display: flex; /* Added for flexible layout */
        flex-direction: column; /* Added for vertical layout */
        position: relative;
        overflow: hidden;
    }

    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .header__search input {
        width: 100%;
        max-width: 300px;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .pagination-container .btn {
        padding: 8px 15px;
        font-size: clamp(0.8rem, 2.5vw, 0.9rem);
    }

    /* Error Message for Charts */
    .chart-error {
        display: none;
        text-align: center;
        color: #dc3545;
        padding: 15px;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    /* Responsive Adjustments */
    @media (max-width: 1200px) {
        .kpi-grid,
        .revenue-overview-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .chart-container {
            height: clamp(250px, 45vw, 400px);
        }
    }

    @media (max-width: 992px) {
        .content-wrapper {
            margin-left: 60px;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .chart-container {
            height: clamp(250px, 40vw, 350px);
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            margin-left: 0 !important;
            padding: 10px;
        }

        .kpi-grid,
        .revenue-overview-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .charts-grid {
            grid-template-columns: 1fr;
            gap: 20px; /* Gap between graphs on mobile */
        }

        .chart-container {
            height: clamp(300px, 100vw, 500px); /* Increased height for full graph on mobile */
            overflow: visible;
            padding: 15px;
            margin-bottom: 20px; /* Gap after each graph card */
        }

        .chart-container canvas {
            max-height: 100%;
            max-width: 100%;
        }

        .card {
            min-height: auto;
        }

        .card-header {
            padding: 12px 15px;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .kpi-card,
        .overview-card {
            padding: 15px;
            min-height: 120px;
        }

        .kpi-card__value,
        .overview-card__value {
            font-size: clamp(1rem, 3vw, 1.2rem);
        }

        .kpi-card__title,
        .overview-card__title {
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .data-table th,
        .data-table td {
            font-size: clamp(0.75rem, 2vw, 0.85rem);
            padding: 10px 12px;
        }

        .section-header {
            flex-direction: column;
            gap: 10px;
        }

        .header__search input,
        .section-actions {
            width: 100%;
            max-width: 100%;
        }

        .section-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .pagination-container .btn {
            padding: 6px 12px;
            font-size: clamp(0.7rem, 2vw, 0.8rem);
        }
    }

    @media (max-width: 576px) {
        .chart-container {
            height: clamp(250px, 100vw, 400px); /* Adjusted for smaller mobile screens */
            padding: 10px;
            margin-bottom: 15px;
        }

        .card {
            min-height: 250px;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 10px 12px;
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        }

        .kpi-card,
        .overview-card {
            padding: 12px;
            min-height: 100px;
            flex-direction: column;
            text-align: center;
        }

        .kpi-card__icon,
        .overview-card__icon {
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .kpi-card__value,
        .overview-card__value {
            font-size: clamp(0.9rem, 3vw, 1rem);
        }

        .kpi-card__title,
        .overview-card__title {
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        }

        .data-table {
            border: 0;
            display: block;
        }

        .data-table thead {
            display: none;
        }

        .data-table tbody,
        .data-table tr,
        .data-table td {
            display: block;
            width: 100%;
        }

        .data-table tr {
            margin-bottom: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eee;
            position: relative;
            font-size: clamp(0.7rem, 2.5vw, 0.8rem);
        }

        .data-table td:last-child {
            border-bottom: 0;
        }

        .data-table td::before {
            content: attr(data-label);
            display: block;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            font-size: clamp(0.75rem, 2.5vw, 0.85rem);
        }

        .pagination-container {
            gap: 8px;
            margin-top: 15px;
        }

        .pagination-container .btn {
            padding: 5px 10px;
            font-size: clamp(0.65rem, 2vw, 0.75rem);
        }
    }

    /* Fix for Two Charts in a Single Row */
    .card-body[style*="grid-template-columns"] {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        padding: 20px;
    }

    .card-body[style*="grid-template-columns"] > div {
        background: #ffffff;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        padding: 15px;
    }

    .card-body[style*="grid-template-columns"] > div .card-header {
        background: none !important;
        color: #333;
        padding: 0 0 15px 0 !important;
        border-bottom: 1px solid #eee;
        border-radius: 0 !important;
        font-size: clamp(0.9rem, 2.5vw, 1rem);
    }

    @media (max-width: 992px) {
        .card-body[style*="grid-template-columns"] {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 576px) {
        .card-body[style*="grid-template-columns"] {
            gap: 15px;
            padding: 10px;
        }

        .card-body[style*="grid-template-columns"] > div {
            padding: 10px;
        }

        .card-body[style*="grid-template-columns"] > div .card-header {
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
        }
    }

    /* Dashboard Section Visibility */
    .dashboard-section {
        display: none;
    }

    .dashboard-section.active {
        display: block;
    }

    @media (min-width: 992px) {
        .charts-grid {
            grid-template-columns: repeat(3, 1fr); /* Force 3 charts per row on desktop */
        }
    }
</style>
</head>
<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container-responsive">
            <h3 class="text-center mb-4" style="font-size: clamp(1.5rem, 4vw, 1.8rem);">Analytics And Reports</h3>

            <!-- Dashboard Overview Section -->
            <section id="dashboard" class="dashboard-section active">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Dashboard Overview</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Dashboard Overview</h2>
                            <div class="header__search">
                                <input type="text" id="globalSearch" class="form-control" placeholder="Global search...">
                            </div>
                        </div>

                        <!-- KPI Cards Grid -->
                        <div class="kpi-grid">
                            <div class="kpi-card" data-color="green" data-navigate="total-revenue">
                                <div class="kpi-card__icon">💰</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Revenue</h4>
                                    <p class="kpi-card__value" id="kpi-total-revenue"></p>
                                    <span class="kpi-card__trend positive">↗ +12.5%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="red" data-navigate="total-expenses">
                                <div class="kpi-card__icon">💸</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Expenses</h4>
                                    <p class="kpi-card__value" id="kpi-total-expenses"></p>
                                    <span class="kpi-card__trend negative">↘ -2.3%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="blue" data-navigate="total-students">
                                <div class="kpi-card__icon">👥</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Students</h4>
                                    <p class="kpi-card__value" id="kpi-total-students"></p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="purple" data-navigate="total-students">
                                <div class="kpi-card__icon">✅</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Active Students</h4>
                                    <p class="kpi-card__value" id="kpi-active-students"></p>
                                    <span class="kpi-card__trend positive">↗ +5.1%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="orange" data-navigate="total-batches">
                                <div class="kpi-card__icon">📅</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Batches</h4>
                                    <p class="kpi-card__value" id="kpi-total-batches"></p>
                                    <span class="kpi-card__trend positive">↗ +15.7%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="teal" data-navigate="total-centers">
                                <div class="kpi-card__icon">🏢</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Centers</h4>
                                    <p class="kpi-card__value" id="kpi-total-centers"></p>
                                    <span class="kpi-card__trend positive">↗ +18.9%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="cyan" data-navigate="total-staff">
                                <div class="kpi-card__icon">🧑‍🏫</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Staff</h4>
                                    <p class="kpi-card__value" id="kpi-total-staff"></p>
                                    <span class="kpi-card__trend positive">↗ +3</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="yellow" data-navigate="total-events">
                                <div class="kpi-card__icon">🎉</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Events</h4>
                                    <p class="kpi-card__value" id="kpi-total-events"></p>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="indigo" data-navigate="attendance">
                                <div class="kpi-card__icon">📊</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Attendances</h4>
                                    <p class="kpi-card__value" id="kpi-total-attendances"></p>
                                    <span class="kpi-card__trend positive">↗ +10%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Charts -->
                        <div class="charts-grid">
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Monthly Revenue Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="revenueMonthlyChart"></canvas>
                                        <div class="chart-error" id="revenueMonthlyChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Student Distribution by Level</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="studentLevelDistributionChart"></canvas>
                                        <div class="chart-error" id="studentLevelDistributionChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Revenue vs Expense (Month Wise)</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="revenueVsExpenseChart2"></canvas>
                                        <div class="chart-error" id="revenueVsExpenseChart2Error">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Batch Distribution by Level</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="batchLevelChart"></canvas>
                                        <div class="chart-error" id="batchLevelChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Staff Distribution by Role</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="staffRoleChart"></canvas>
                                        <div class="chart-error" id="staffRoleChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Total Revenue Section -->
            <section id="total-revenue" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Total Revenue Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Total Revenue Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Revenue Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">💰</div>
                                <div class="overview-card__content">
                                    <h4>Total Revenue</h4>
                                    <p class="overview-card__value" id="revenue-total-revenue"></p>
                                    <span class="kpi-card__trend positive">↗ +12.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">💳</div>
                                <div class="overview-card__content">
                                    <h4>Outstanding Fees</h4>
                                    <p class="overview-card__value" id="revenue-outstanding-fees"></p>
                                    <span class="kpi-card__trend positive">↗ +17.8%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📈</div>
                                <div class="overview-card__content">
                                    <h4>Fees from Events</h4>
                                    <p class="overview-card__value" id="revenue-event-fees"></p>
                                    <span class="kpi-card__trend positive">↗ +8.9%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🏓</div>
                                <div class="overview-card__content">
                                    <h4>Facility Rental Revenue</h4>
                                    <p class="overview-card__value" id="revenue-facility-revenue"></p>
                                    <span class="kpi-card__trend positive">↗ +12.4%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Charts -->
                        <div class="charts-grid">
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Monthly Revenue Trends</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="revenueMonthlyChartUnder"></canvas>
                                        <div class="chart-error" id="revenueMonthlyChartUnderError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Revenue Distribution</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="revenueDistributionChart"></canvas>
                                        <div class="chart-error" id="revenueDistributionChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Facilities Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Facility Revenue Details</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=facility_revenue') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="facilityRevenueDetailsTables">
                                        <thead>
                                            <tr>
                                                <th data-label="Facility ID">Facility ID</th>
                                                <th data-label="Center ID">Center ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Subtype">Subtype</th>
                                                <th data-label="Rent Amount">Rent Amount</th>
                                                <th data-label="Rent Date">Rent Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="facilityPagination"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Events Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Event Revenue Details</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=event_revenue') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="eventRevenueDetailsTables">
                                        <thead>
                                            <tr>
                                                <th data-label="Event ID">Event ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Date">Date</th>
                                                <th data-label="Fee">Fee</th>
                                                <th data-label="Participants">Participants</th>
                                                <th data-label="Total Revenue">Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="eventPagination"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Students Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Student Fee Details</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=student_fees') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="studentFeeDetailsTables">
                                        <thead>
                                            <tr>
                                                <th data-label="Student ID">Student ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Center ID">Center ID</th>
                                                <th data-label="Batch ID">Batch ID</th>
                                                <th data-label="Paid Amount">Paid Amount</th>
                                                <th data-label="Remaining Amount">Remaining Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="studentFeePagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Total Expenses Section -->
            <section id="total-expenses" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Total Expenses Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Total Expenses Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Expense Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">💸</div>
                                <div class="overview-card__content">
                                    <h4>Total Expenses</h4>
                                    <p class="overview-card__value" id="expenses-total-expenses"></p>
                                    <span class="kpi-card__trend negative">↘ -2.3%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🏢</div>
                                <div class="overview-card__content">
                                    <h4>Center Expenses</h4>
                                    <p class="overview-card__value" id="expenses-center-expenses"></p>
                                    <span class="kpi-card__trend positive">↗ +5.2%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🧑‍🏫</div>
                                <div class="overview-card__content">
                                    <h4>Staff Salaries</h4>
                                    <p class="overview-card__value">₹0</p>
                                    <span class="kpi-card__trend positive">↗ +3.8%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🏓</div>
                                <div class="overview-card__content">
                                    <h4>Facility Maintenance</h4>
                                    <p class="overview-card__value">₹0</p>
                                    <span class="kpi-card__trend negative">↘ -8.1%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Expense Charts -->
                        <div class="charts-grid">
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Expense Categories</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="expenseCategoriesChart2"></canvas>
                                        <div class="chart-error" id="expenseCategoriesChart2Error">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Monthly Expense Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="expenseTrendChart2"></canvas>
                                        <div class="chart-error" id="expenseTrendChart2Error">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Expenses Details</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=expenses') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="expensesTable1">
                                        <thead>
                                            <tr>
                                                <th data-label="ID">ID</th>
                                                <th data-label="Center">Center ID</th>
                                                <th data-label="Title">Title</th>
                                                <th data-label="Date">Date</th>
                                                <th data-label="Amount">Amount</th>
                                                <th data-label="Status">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="expensesPagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Total Students Section -->
            <section id="total-students" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-users mr-2"></i>Students Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Students Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Students Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">👥</div>
                                <div class="overview-card__content">
                                    <h4>Total Students</h4>
                                    <p class="overview-card__value" id="students-total-students"></p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">✅</div>
                                <div class="overview-card__content">
                                    <h4>Active Students</h4>
                                    <p class="overview-card__value" id="students-active-students"></p>
                                    <span class="kpi-card__trend negative">↘ -12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📈</div>
                                <div class="overview-card__content">
                                    <h4>Beginner Students</h4>
                                    <p class="overview-card__value" id="students-beginner-students"></p>
                                    <span class="kpi-card__trend positive">↗ +10.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📊</div>
                                <div class="overview-card__content">
                                    <h4>Intermediate Students</h4>
                                    <p class="overview-card__value" id="students-intermediate-students"></p>
                                    <span class="kpi-card__trend negative">↘ -5.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Students Charts -->
                        <div class="charts-grid">
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Students by Level</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="studentsLevelChart2"></canvas>
                                        <div class="chart-error" id="studentsLevelChart2Error">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Attendance Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="attendanceTrendChart"></canvas>
                                        <div class="chart-error" id="attendanceTrendChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Students Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Student List</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=students') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="studentsTables">
                                        <thead>
                                            <tr>
                                                <th data-label="ID">ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Center">Center</th>
                                                <th data-label="Batch">Batch</th>
                                                <th data-label="Level">Level</th>
                                                <th data-label="Status">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="studentsPagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Total Batches Section -->
            <section id="total-batches" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-calendar mr-2"></i>Batches Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Batches Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Batches Tables by Center -->
                        <?php
                        // Fetch all centers from center_details table
                        $centers = [
                            [
                                'id' => 84,
                                'name' => 'test center1',
                                'center_number' => 'CTR-250925',
                                'address' => 'Nashik',
                                'latitude' => 60.800000,
                                'longitude' => 12.800000,
                                'rent_amount' => 5000.00,
                                'rent_paid_date' => '2025-09-24',
                                'center_timing_from' => '08:00:00',
                                'center_timing_to' => '20:00:00'
                            ],
                            [
                                'id' => 85,
                                'name' => 'center 1',
                                'center_number' => 'CTR-250925',
                                'address' => 'Pune',
                                'latitude' => 12.000000,
                                'longitude' => 15.500000,
                                'rent_amount' => 2000.00,
                                'rent_paid_date' => '2025-09-25',
                                'center_timing_from' => '08:00:00',
                                'center_timing_to' => '21:00:00'
                            ],
                            [
                                'id' => 86,
                                'name' => 'MTS',
                                'center_number' => 'CTR-250925',
                                'address' => 'Pandit Colony',
                                'latitude' => 20.003972,
                                'longitude' => 73.776835,
                                'rent_amount' => 3000.00,
                                'rent_paid_date' => '2025-09-25',
                                'center_timing_from' => '08:00:00',
                                'center_timing_to' => '20:00:00'
                            ]
                        ];

                        // Fetch all batches
                        $batches = [
                            [
                                'id' => 85,
                                'center_id' => 84,
                                'batch_name' => 'b1',
                                'batch_level' => 'beginner',
                                'start_time' => '09:00:00',
                                'end_time' => '10:00:00',
                                'start_date' => '2025-09-26',
                                'end_date' => '2025-11-26',
                                'duration' => 2,
                                'category' => 'corporate'
                            ],
                            [
                                'id' => 86,
                                'center_id' => 84,
                                'batch_name' => 'b2',
                                'batch_level' => 'intermediate',
                                'start_time' => '11:00:00',
                                'end_time' => '12:00:00',
                                'start_date' => '2025-09-26',
                                'end_date' => '2025-10-26',
                                'duration' => 1,
                                'category' => ''
                            ],
                            [
                                'id' => 87,
                                'center_id' => 84,
                                'batch_name' => 'b3',
                                'batch_level' => 'advanced',
                                'start_time' => '12:00:00',
                                'end_time' => '13:00:00',
                                'start_date' => '2025-09-25',
                                'end_date' => '2025-10-25',
                                'duration' => 1,
                                'category' => ''
                            ],
                            [
                                'id' => 92,
                                'center_id' => 84,
                                'batch_name' => 'b4',
                                'batch_level' => 'advanced',
                                'start_time' => '12:30:00',
                                'end_time' => '13:30:00',
                                'start_date' => '2025-09-30',
                                'end_date' => '2025-10-30',
                                'duration' => 0,
                                'category' => 'individual'
                            ],
                            [
                                'id' => 93,
                                'center_id' => 85,
                                'batch_name' => 'batch1',
                                'batch_level' => 'beginner',
                                'start_time' => '09:00:00',
                                'end_time' => '10:00:00',
                                'start_date' => '2025-09-25',
                                'end_date' => '2025-11-25',
                                'duration' => 2,
                                'category' => 'corporate'
                            ],
                            [
                                'id' => 94,
                                'center_id' => 85,
                                'batch_name' => 'BATCH2',
                                'batch_level' => 'intermediate',
                                'start_time' => '11:35:00',
                                'end_time' => '12:35:00',
                                'start_date' => '2025-09-26',
                                'end_date' => '2025-10-26',
                                'duration' => 1,
                                'category' => ''
                            ],
                            [
                                'id' => 96,
                                'center_id' => 85,
                                'batch_name' => 'batch3',
                                'batch_level' => 'advanced',
                                'start_time' => '13:20:00',
                                'end_time' => '14:20:00',
                                'start_date' => '2025-09-30',
                                'end_date' => '2025-10-30',
                                'duration' => 1,
                                'category' => ''
                            ],
                            [
                                'id' => 98,
                                'center_id' => 86,
                                'batch_name' => 'abc',
                                'batch_level' => 'beginner',
                                'start_time' => '12:25:00',
                                'end_time' => '13:25:00',
                                'start_date' => '2025-09-27',
                                'end_date' => '2025-10-27',
                                'duration' => 0,
                                'category' => 'individual'
                            ]
                        ];

                        // Group batches by center_id
                        $batches_by_center = [];
                        foreach ($batches as $batch) {
                            $batches_by_center[$batch['center_id']][] = $batch;
                        }

                        // Display center-wise tables
                        foreach ($centers as $center) {
                            ?>
                            <div class="data-table-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Center: <?php echo htmlspecialchars($center['name']); ?> (ID: <?php echo $center['id']; ?>)</h4>
                                        <a href="<?= base_url('analytics/export_csv?type=center_details&center_id=' . $center['id']) ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="data-table" id="centerDetailsTable_<?php echo $center['id']; ?>">
                                            <thead>
                                                <tr>
                                                    <th data-label="ID">ID</th>
                                                    <th data-label="Name">Name</th>
                                                    <th data-label="Center Number">Center Number</th>
                                                    <th data-label="Address">Address</th>
                                                    <th data-label="Latitude">Latitude</th>
                                                    <th data-label="Longitude">Longitude</th>
                                                    <th data-label="Rent Amount">Rent Amount</th>
                                                    <th data-label="Rent Paid Date">Rent Paid Date</th>
                                                    <th data-label="Timing From">Timing From</th>
                                                    <th data-label="Timing To">Timing To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="ID"><?php echo htmlspecialchars($center['id']); ?></td>
                                                    <td data-label="Name"><?php echo htmlspecialchars($center['name']); ?></td>
                                                    <td data-label="Center Number"><?php echo htmlspecialchars($center['center_number']); ?></td>
                                                    <td data-label="Address"><?php echo htmlspecialchars($center['address']); ?></td>
                                                    <td data-label="Latitude"><?php echo htmlspecialchars($center['latitude']); ?></td>
                                                    <td data-label="Longitude"><?php echo htmlspecialchars($center['longitude']); ?></td>
                                                    <td data-label="Rent Amount">₹<?php echo number_format($center['rent_amount'], 2); ?></td>
                                                    <td data-label="Rent Paid Date"><?php echo htmlspecialchars($center['rent_paid_date']); ?></td>
                                                    <td data-label="Timing From"><?php echo htmlspecialchars($center['center_timing_from']); ?></td>
                                                    <td data-label="Timing To"><?php echo htmlspecialchars($center['center_timing_to']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Batches for this center -->
                            <div class="data-table-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Batches for Center: <?php echo htmlspecialchars($center['name']); ?> (ID: <?php echo $center['id']; ?>)</h4>
                                        <a href="<?= base_url('analytics/export_csv?type=batches&center_id=' . $center['id']) ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="data-table" id="batchesTable_<?php echo $center['id']; ?>">
                                            <thead>
                                                <tr>
                                                    <th data-label="ID">ID</th>
                                                    <th data-label="Center ID">Center ID</th>
                                                    <th data-label="Name">Name</th>
                                                    <th data-label="Level">Level</th>
                                                    <th data-label="Start Time">Start Time</th>
                                                    <th data-label="End Time">End Time</th>
                                                    <th data-label="Start Date">Start Date</th>
                                                    <th data-label="End Date">End Date</th>
                                                    <th data-label="Duration">Duration</th>
                                                    <th data-label="Category">Category</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $center_batches = isset($batches_by_center[$center['id']]) ? $batches_by_center[$center['id']] : [];
                                                if (empty($center_batches)) {
                                                    echo '<tr><td colspan="10" style="text-align: center; padding: 20px;">No batches found for this center</td></tr>';
                                                } else {
                                                    foreach ($center_batches as $batch) {
                                                        ?>
                                                        <tr>
                                                            <td data-label="ID"><?php echo htmlspecialchars($batch['id']); ?></td>
                                                            <td data-label="Center ID"><?php echo htmlspecialchars($batch['center_id']); ?></td>
                                                            <td data-label="Name"><?php echo htmlspecialchars($batch['batch_name']); ?></td>
                                                            <td data-label="Level"><?php echo htmlspecialchars(ucfirst($batch['batch_level'])); ?></td>
                                                            <td data-label="Start Time"><?php echo htmlspecialchars($batch['start_time']); ?></td>
                                                            <td data-label="End Time"><?php echo htmlspecialchars($batch['end_time']); ?></td>
                                                            <td data-label="Start Date"><?php echo htmlspecialchars($batch['start_date']); ?></td>
                                                            <td data-label="End Date"><?php echo htmlspecialchars($batch['end_date']); ?></td>
                                                            <td data-label="Duration"><?php echo htmlspecialchars($batch['duration']); ?> months</td>
                                                            <td data-label="Category"><?php echo htmlspecialchars($batch['category'] ?: 'N/A'); ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Total Centers Section -->
            <section id="total-centers" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-building mr-2"></i>Centers Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Centers Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Centers Tables -->
                        <?php
                        foreach ($centers as $center) {
                            ?>
                            <div class="data-table-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Center: <?php echo htmlspecialchars($center['name']); ?> (ID: <?php echo $center['id']; ?>)</h4>
                                        <a href="<?= base_url('analytics/export_csv?type=center_details&center_id=' . $center['id']) ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                    </div>
                                    <div class="card-body">
                                        <table class="data-table" id="centerDetailsTable_<?php echo $center['id']; ?>">
                                            <thead>
                                                <tr>
                                                    <th data-label="ID">ID</th>
                                                    <th data-label="Name">Name</th>
                                                    <th data-label="Center Number">Center Number</th>
                                                    <th data-label="Address">Address</th>
                                                    <th data-label="Latitude">Latitude</th>
                                                    <th data-label="Longitude">Longitude</th>
                                                    <th data-label="Rent Amount">Rent Amount</th>
                                                    <th data-label="Rent Paid Date">Rent Paid Date</th>
                                                    <th data-label="Timing From">Timing From</th>
                                                    <th data-label="Timing To">Timing To</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="ID"><?php echo htmlspecialchars($center['id']); ?></td>
                                                    <td data-label="Name"><?php echo htmlspecialchars($center['name']); ?></td>
                                                    <td data-label="Center Number"><?php echo htmlspecialchars($center['center_number']); ?></td>
                                                    <td data-label="Address"><?php echo htmlspecialchars($center['address']); ?></td>
                                                    <td data-label="Latitude"><?php echo htmlspecialchars($center['latitude']); ?></td>
                                                    <td data-label="Longitude"><?php echo htmlspecialchars($center['longitude']); ?></td>
                                                    <td data-label="Rent Amount">₹<?php echo number_format($center['rent_amount'], 2); ?></td>
                                                    <td data-label="Rent Paid Date"><?php echo htmlspecialchars($center['rent_paid_date']); ?></td>
                                                    <td data-label="Timing From"><?php echo htmlspecialchars($center['center_timing_from']); ?></td>
                                                    <td data-label="Timing To"><?php echo htmlspecialchars($center['center_timing_to']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Total Staff Section -->
            <section id="total-staff" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-user-tie mr-2"></i>Staff Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Staff Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Staff Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">🧑‍🏫</div>
                                <div class="overview-card__content">
                                    <h4>Total Staff</h4>
                                    <p class="overview-card__value" id="staff-total-staff"></p>
                                    <span class="kpi-card__trend positive">↗ +5.1%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👨‍💼</div>
                                <div class="overview-card__content">
                                    <h4>Admins</h4>
                                    <p class="overview-card__value" id="staff-admins"></p>
                                    <span class="kpi-card__trend negative">↘ -8%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🧑‍🏫</div>
                                <div class="overview-card__content">
                                    <h4>Coaches</h4>
                                    <p class="overview-card__value" id="staff-coaches"></p>
                                    <span class="kpi-card__trend positive">↗ +12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👩‍💼</div>
                                <div class="overview-card__content">
                                    <h4>Managers</h4>
                                    <p class="overview-card__value" id="staff-managers"></p>
                                    <span class="kpi-card__trend positive">↗ +18%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Staff Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Staff List</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=staff') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="staffTables">
                                        <thead>
                                            <tr>
                                                <th data-label="ID">ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Center">Center ID</th>
                                                <th data-label="Role">Role</th>
                                                <th data-label="Joining Date">Joining Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="staffPagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Total Events Section -->
            <section id="total-events" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-calendar-alt mr-2"></i>Events Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Events Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Events Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">🎉</div>
                                <div class="overview-card__content">
                                    <h4>Total Events</h4>
                                    <p class="overview-card__value" id="events-total-events"></p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👥</div>
                                <div class="overview-card__content">
                                    <h4>Total Participants</h4>
                                    <p class="overview-card__value" id="events-total-participants"></p>
                                    <span class="kpi-card__trend negative">↘ -12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">💰</div>
                                <div class="overview-card__content">
                                    <h4>Total Event Revenue</h4>
                                    <p class="overview-card__value" id="events-total-event-revenue"></p>
                                    <span class="kpi-card__trend positive">↗ +10.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📅</div>
                                <div class="overview-card__content">
                                    <h4>Upcoming Events</h4>
                                    <p class="overview-card__value" id="events-upcoming-events"></p>
                                    <span class="kpi-card__trend negative">↘ -5.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Events Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Event List</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=events') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="eventsTables">
                                        <thead>
                                            <tr>
                                                <th data-label="ID">ID</th>
                                                <th data-label="Name">Name</th>
                                                <th data-label="Date">Date</th>
                                                <th data-label="Fee">Fee</th>
                                                <th data-label="Participants">Max Participants</th>
                                                <th data-label="Venue">Venue</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="eventsPagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Attendance Section -->
            <section id="attendance" class="dashboard-section">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-calendar-check mr-2"></i>Attendance Analytics</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2 style="font-size: clamp(1.2rem, 3.5vw, 1.5rem);">Attendance Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                            </div>
                        </div>

                        <!-- Attendance Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">📊</div>
                                <div class="overview-card__content">
                                    <h4>Total Attendances</h4>
                                    <p class="overview-card__value" id="attendance-total-attendances"></p>
                                    <span class="kpi-card__trend positive">↗ +10%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">✅</div>
                                <div class="overview-card__content">
                                    <h4>Present Count</h4>
                                    <p class="overview-card__value" id="attendance-present-count"></p>
                                    <span class="kpi-card__trend positive">↗ +15%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">❌</div>
                                <div class="overview-card__content">
                                    <h4>Absent Count</h4>
                                    <p class="overview-card__value" id="attendance-absent-count"></p>
                                    <span class="kpi-card__trend negative">↘ -5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📈</div>
                                <div class="overview-card__content">
                                    <h4>Present Rate</h4>
                                    <p class="overview-card__value" id="attendance-present-rate"></p>
                                    <span class="kpi-card__trend positive">↗ +12%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Charts -->
                        <div class="charts-grid">
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Attendance Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="attendanceTrendChart2"></canvas>
                                        <div class="chart-error" id="attendanceTrendChart2Error">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Present vs Absent</h4>
                                    </div>
                                    <div class="card-body" style="position: relative;">
                                        <canvas id="attendancePieChart"></canvas>
                                        <div class="chart-error" id="attendancePieChartError">Failed to load chart data</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Attendance Details</h4>
                                    <a href="<?= base_url('analytics/export_csv?type=attendance') ?>" class="btn btn--primary btn-sm">Export CSV</a>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="attendanceTables">
                                        <thead>
                                            <tr>
                                                <th data-label="ID">ID</th>
                                                <th data-label="Student ID">Student ID</th>
                                                <th data-label="Date">Date</th>
                                                <th data-label="Time">Time</th>
                                                <th data-label="Status">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="pagination-container" id="attendancePagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- JavaScript for Charts and Tables -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const BASE_URL = "<?= base_url(); ?>";
        const CHART_COLORING = ['#28a745', '#ffc107', '#007bff', '#dc3545'];
        let dashboardData = {};

        // Wait for Chart.js to load
        function waitForChartJs(callback) {
            if (typeof Chart !== 'undefined') {
                callback();
            } else {
                setTimeout(() => waitForChartJs(callback), 100);
            }
        }

        // Fetch dashboard data with error handling
        function fetchDashboardData() {
            fetch(`${BASE_URL}analytics/get_dashboard_data`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    dashboardData = data || {};
                    updateKPIs();
                    waitForChartJs(renderCharts);
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                    document.querySelectorAll('.chart-error').forEach(el => {
                        el.style.display = 'block';
                    });
                });
        }

        fetchDashboardData();

        function updateKPIs() {
            // Fallback values if data is missing
            const defaults = {
                total_revenue: 0,
                total_expenses: 0,
                total_students: 0,
                active_students: 0,
                total_batches: 0,
                total_centers: 0,
                total_staff: 0,
                total_events: 0,
                total_attendances: 0,
                outstanding_fees: 0,
                event_fees: 0,
                facility_revenue: 0,
                beginner_students: 0,
                intermediate_students: 0,
                admins: 0,
                coaches: 0,
                managers: 0,
                total_participants: 0,
                total_event_revenue: 0,
                upcoming_events: 0,
                present_count: 0,
                absent_count: 0
            };

            dashboardData = { ...defaults, ...dashboardData };

            document.getElementById('kpi-total-revenue').textContent = `₹${dashboardData.total_revenue.toLocaleString()}`;
            document.getElementById('kpi-total-expenses').textContent = `₹${dashboardData.total_expenses.toLocaleString()}`;
            document.getElementById('kpi-total-students').textContent = dashboardData.total_students;
            document.getElementById('kpi-active-students').textContent = dashboardData.active_students;
            document.getElementById('kpi-total-batches').textContent = dashboardData.total_batches;
            document.getElementById('kpi-total-centers').textContent = dashboardData.total_centers;
            document.getElementById('kpi-total-staff').textContent = dashboardData.total_staff;
            document.getElementById('kpi-total-events').textContent = dashboardData.total_events;
            document.getElementById('kpi-total-attendances').textContent = dashboardData.total_attendances;

            // Revenue Section KPIs
            document.getElementById('revenue-total-revenue').textContent = `₹${dashboardData.total_revenue.toLocaleString()}`;
            document.getElementById('revenue-outstanding-fees').textContent = `₹${dashboardData.outstanding_fees.toLocaleString()}`;
            document.getElementById('revenue-event-fees').textContent = `₹${dashboardData.event_fees.toLocaleString()}`;
            document.getElementById('revenue-facility-revenue').textContent = `₹${dashboardData.facility_revenue.toLocaleString()}`;

            // Expenses Section
            document.getElementById('expenses-total-expenses').textContent = `₹${dashboardData.total_expenses.toLocaleString()}`;
            document.getElementById('expenses-center-expenses').textContent = `₹${dashboardData.total_expenses.toLocaleString()}`;

            // Students Section
            document.getElementById('students-total-students').textContent = dashboardData.total_students;
            document.getElementById('students-active-students').textContent = dashboardData.active_students;
            document.getElementById('students-beginner-students').textContent = dashboardData.beginner_students;
            document.getElementById('students-intermediate-students').textContent = dashboardData.intermediate_students;

            // Staff Section
            document.getElementById('staff-total-staff').textContent = dashboardData.total_staff;
            document.getElementById('staff-admins').textContent = dashboardData.admins;
            document.getElementById('staff-coaches').textContent = dashboardData.coaches;
            document.getElementById('staff-managers').textContent = dashboardData.managers;

            // Events Section
            document.getElementById('events-total-events').textContent = dashboardData.total_events;
            document.getElementById('events-total-participants').textContent = dashboardData.total_participants;
            document.getElementById('events-total-event-revenue').textContent = `₹${dashboardData.total_event_revenue.toLocaleString()}`;
            document.getElementById('events-upcoming-events').textContent = dashboardData.upcoming_events;

            // Attendance Section
            document.getElementById('attendance-total-attendances').textContent = dashboardData.total_attendances;
            document.getElementById('attendance-present-count').textContent = dashboardData.present_count;
            document.getElementById('attendance-absent-count').textContent = dashboardData.absent_count;
            const total = dashboardData.present_count + dashboardData.absent_count;
            const presentRate = total > 0 ? ((dashboardData.present_count / total) * 100).toFixed(1) + '%' : '0%';
            document.getElementById('attendance-present-rate').textContent = presentRate;
        }

        function renderCharts() {
            // Ensure canvas elements exist and hide error messages
            document.querySelectorAll('.chart-container canvas').forEach(canvas => {
                const errorEl = document.getElementById(`${canvas.id}Error`);
                if (errorEl) errorEl.style.display = 'none';
            });

            // Fallback data for charts
            const defaultChartData = {
                monthly_revenue: [{ label: 'Jan', value: 0 }, { label: 'Feb', value: 0 }],
                student_distribution: [{ label: 'Beginner', value: 0 }, { label: 'Intermediate', value: 0 }],
                revenue_vs_expense: {
                    revenue: [{ label: 'Jan', value: 0 }, { label: 'Feb', value: 0 }],
                    expense: [{ label: 'Jan', value: 0 }, { label: 'Feb', value: 0 }]
                },
                batch_distribution: [{ label: 'Beginner', value: 0 }, { label: 'Intermediate', value: 0 }],
                staff_distribution: [{ label: 'Admin', value: 0 }, { label: 'Coach', value: 0 }],
                attendance_trend: [{ label: 'Jan', present: 0, absent: 0 }, { label: 'Feb', present: 0, absent: 0 }]
            };

            dashboardData = {
                ...dashboardData,
                monthly_revenue: dashboardData.monthly_revenue || defaultChartData.monthly_revenue,
                student_distribution: dashboardData.student_distribution || defaultChartData.student_distribution,
                revenue_vs_expense: dashboardData.revenue_vs_expense || defaultChartData.revenue_vs_expense,
                batch_distribution: dashboardData.batch_distribution || defaultChartData.batch_distribution,
                staff_distribution: dashboardData.staff_distribution || defaultChartData.staff_distribution,
                attendance_trend: dashboardData.attendance_trend || defaultChartData.attendance_trend
            };

            // Chart.js Global Defaults
            Chart.defaults.font.size = clamp(10, window.innerWidth / 100, 14);
            Chart.defaults.plugins.legend.labels.boxWidth = clamp(20, window.innerWidth / 50, 30);
            Chart.defaults.plugins.legend.labels.padding = clamp(6, window.innerWidth / 100, 12);

            try {
                // Monthly Revenue (Dashboard)
                const revenueMonthlyCtx = document.getElementById('revenueMonthlyChart')?.getContext('2d');
                if (revenueMonthlyCtx) {
                    new Chart(revenueMonthlyCtx, {
                        type: 'line',
                        data: {
                            labels: dashboardData.monthly_revenue.map(item => item.label),
                            datasets: [{
                                label: 'Revenue',
                                data: dashboardData.monthly_revenue.map(item => item.value),
                                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: getChartOptions('Monthly Revenue Trend')
                    });
                }

                // Student Level Distribution (Dashboard)
                const studentLevelCtx = document.getElementById('studentLevelDistributionChart')?.getContext('2d');
                if (studentLevelCtx) {
                    new Chart(studentLevelCtx, {
                        type: 'doughnut',
                        data: {
                            labels: dashboardData.student_distribution.map(item => item.label),
                            datasets: [{
                                data: dashboardData.student_distribution.map(item => item.value),
                                backgroundColor: CHART_COLORING
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                // Revenue vs Expense (Dashboard)
                const revenueVsExpenseCtx = document.getElementById('revenueVsExpenseChart2')?.getContext('2d');
                if (revenueVsExpenseCtx) {
                    new Chart(revenueVsExpenseCtx, {
                        type: 'bar',
                        data: {
                            labels: dashboardData.revenue_vs_expense.revenue.map(item => item.label),
                            datasets: [{
                                label: 'Revenue',
                                data: dashboardData.revenue_vs_expense.revenue.map(item => item.value),
                                backgroundColor: 'rgba(40, 167, 69, 0.7)'
                            }, {
                                label: 'Expense',
                                data: dashboardData.revenue_vs_expense.expense.map(item => item.value),
                                backgroundColor: 'rgba(220, 53, 69, 0.7)'
                            }]
                        },
                        options: getBarOptions('Revenue vs Expense')
                    });
                }

                // Batch Level (Dashboard)
                const batchLevelCtx = document.getElementById('batchLevelChart')?.getContext('2d');
                if (batchLevelCtx) {
                    new Chart(batchLevelCtx, {
                        type: 'doughnut',
                        data: {
                            labels: dashboardData.batch_distribution.map(item => item.label.charAt(0).toUpperCase() + item.label.slice(1)), // Capitalize first letter
                            datasets: [{
                                data: dashboardData.batch_distribution.map(item => item.value),
                                backgroundColor: CHART_COLORING
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                // Staff Role (Dashboard)
                const staffRoleCtx = document.getElementById('staffRoleChart')?.getContext('2d');
                if (staffRoleCtx) {
                    new Chart(staffRoleCtx, {
                        type: 'doughnut',
                        data: {
                            labels: dashboardData.staff_distribution.map(item => item.label.charAt(0).toUpperCase() + item.label.slice(1)), // Capitalize first letter
                            datasets: [{
                                data: dashboardData.staff_distribution.map(item => item.value),
                                backgroundColor: CHART_COLORING
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                // Monthly Revenue Under (Revenue Section)
                const revenueMonthlyUnderCtx = document.getElementById('revenueMonthlyChartUnder')?.getContext('2d');
                if (revenueMonthlyUnderCtx) {
                    new Chart(revenueMonthlyUnderCtx, {
                        type: 'bar',
                        data: {
                            labels: dashboardData.monthly_revenue.map(item => item.label),
                            datasets: [{
                                label: 'Revenue',
                                data: dashboardData.monthly_revenue.map(item => item.value),
                                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 2
                            }]
                        },
                        options: getChartOptions('Monthly Revenue Trends')
                    });
                }

                // Revenue Distribution (Revenue Section)
                const revenueDistributionCtx = document.getElementById('revenueDistributionChart')?.getContext('2d');
                if (revenueDistributionCtx) {
                    new Chart(revenueDistributionCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Facility Rental', 'Event Fees', 'Student Fees'],
                            datasets: [{
                                data: [
                                    dashboardData.facility_revenue,
                                    dashboardData.event_fees,
                                    dashboardData.total_revenue - dashboardData.facility_revenue - dashboardData.event_fees
                                ],
                                backgroundColor: CHART_COLORING.slice(0, 3)
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                // Expense Categories (Expenses Section)
                const expenseCategoriesCtx = document.getElementById('expenseCategoriesChart2')?.getContext('2d');
                if (expenseCategoriesCtx) {
                    new Chart(expenseCategoriesCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Center Expenses', 'Staff Salaries', 'Facility Maintenance'],
                            datasets: [{
                                data: [dashboardData.total_expenses, 0, 0],
                                backgroundColor: CHART_COLORING.slice(0, 3)
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                // Expense Trend (Expenses Section)
                const expenseTrendCtx = document.getElementById('expenseTrendChart2')?.getContext('2d');
                if (expenseTrendCtx) {
                    new Chart(expenseTrendCtx, {
                        type: 'line',
                        data: {
                            labels: dashboardData.revenue_vs_expense.expense.map(item => item.label),
                            datasets: [{
                                label: 'Expense',
                                data: dashboardData.revenue_vs_expense.expense.map(item => item.value),
                                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                                borderColor: 'rgba(220, 53, 69, 1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: getChartOptions('Monthly Expense Trend')
                    });
                }

                // Students Level (Students Section)
                const studentsLevelCtx = document.getElementById('studentsLevelChart2')?.getContext('2d');
                if (studentsLevelCtx) {
                    new Chart(studentsLevelCtx, {
                        type: 'doughnut',
                        data: {
                            labels: dashboardData.student_distribution.map(item => item.label),
                            datasets: [{
                                data: dashboardData.student_distribution.map(item => item.value),
                                backgroundColor: CHART_COLORING
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }

                //  Attendance Trend (Students Section)
                const attendanceTrendCtx = document.getElementById('attendanceTrendChart')?.getContext('2d');
if (attendanceTrendCtx) {
    new Chart(attendanceTrendCtx, {
        type: 'line',
        data: {
            labels: dashboardData.attendance_trend.map(item => item.label),
            datasets: [{
                label: 'Present',
                data: dashboardData.attendance_trend.map(item => item.present),
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }, {
                label: 'Absent',
                data: dashboardData.attendance_trend.map(item => item.absent),
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...getChartOptions('Attendance Trend'),
            scales: {
                ...getChartOptions('Attendance Trend').scales,
                y: {
                    ...getChartOptions('Attendance Trend').scales.y,
                    title: {
                        display: true,
                        text: 'Count', // Custom Y-axis label for Attendance Trend
                        font: { size: clamp(10, window.innerWidth / 100, 14) ,weight: 'bold'},
                        color: '#666'
                    }
                }
            }
        }
    });
}
          

         // Attendance Trend 2 (Attendance Section)
const attendanceTrend2Ctx = document.getElementById('attendanceTrendChart2')?.getContext('2d');
if (attendanceTrend2Ctx) {
    new Chart(attendanceTrend2Ctx, {
        type: 'line',
        data: {
            labels: dashboardData.attendance_trend.map(item => item.label),
            datasets: [{
                label: 'Present',
                data: dashboardData.attendance_trend.map(item => item.present),
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }, {
                label: 'Absent',
                data: dashboardData.attendance_trend.map(item => item.absent),
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            ...getChartOptions('Attendance Trend'),
            scales: {
                ...getChartOptions('Attendance Trend').scales,
                y: {
                    ...getChartOptions('Attendance Trend').scales.y,
                    title: {
                        display: true,
                        text: 'Count', // Custom Y-axis label for Attendance Trend
                        font: { size: clamp(10, window.innerWidth / 100, 14),weight: 'bold' },
                        color: '#666'
                    }
                }
            }
        }
    });
}

                // Present vs Absent Pie (Attendance Section)
                const attendancePieCtx = document.getElementById('attendancePieChart')?.getContext('2d');
                if (attendancePieCtx) {
                    new Chart(attendancePieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Present', 'Absent'],
                            datasets: [{
                                data: [dashboardData.present_count, dashboardData.absent_count],
                                backgroundColor: ['#28a745', '#dc3545']
                            }]
                        },
                        options: getDoughnutOptions()
                    });
                }
            } catch (error) {
                console.error('Error rendering charts:', error);
                document.querySelectorAll('.chart-error').forEach(el => {
                    el.style.display = 'block';
                });
            }
        }

        function clamp(min, val, max) {
            return Math.min(Math.max(val, min), max);
        }

        function getChartOptions(titleText) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: "top",
                labels: {
                    font: { size: clamp(10, window.innerWidth / 100, 14) },
                    padding: clamp(6, window.innerWidth / 100, 12)
                }
            },
            title: {
                display: true,
                text: titleText,
                font: { size: clamp(12, window.innerWidth / 80, 16),weight: 'bold' },
                padding: { top: 10, bottom: 10 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: clamp(9, window.innerWidth / 100, 12) },
                    callback: function(value) {
                        return "₹" + value.toLocaleString();
                    }
                },
                padding: 10,
                title: {
                    display: true,
                    text: 'Amount (₹)', // Y-axis label
                    font: { size: clamp(10, window.innerWidth / 100, 14),weight: 'bold' },
                    color: '#666'
                }
            },
            x: {
                ticks: {
                    font: { size: clamp(9, window.innerWidth / 100, 12) },
                    color: "#666",
                    maxRotation: 45,
                    minRotation: 0
                },
                grid: { display: false },
                title: {
                    display: true,
                    text: 'Month', // X-axis label
                    font: { size: clamp(10, window.innerWidth / 100, 14),weight: 'bold' },
                    color: '#666'
                }
            }
        },
        layout: {
            padding: 10
        }
    };
}

        function getDoughnutOptions() {
            return {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: clamp(10, window.innerWidth / 100, 14) },
                            padding: clamp(6, window.innerWidth / 100, 12),
                            color: '#000'
                        }
                    }
                },
                layout: {
                    padding: 10
                }
            };
        }

        function getBarOptions(titleText) {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: { size: clamp(10, window.innerWidth / 100, 14) },
                    padding: clamp(6, window.innerWidth / 100, 12)
                }
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    font: { size: clamp(9, window.innerWidth / 100, 12) },
                    callback: function(value) { return '₹' + value.toLocaleString(); }
                },
                title: {
                    display: true,
                    text: 'Amount (₹)', // Y-axis label
                    font: { size: clamp(10, window.innerWidth / 100, 14) ,weight: 'bold'},
                    color: '#666'
                }
            },
            x: {
                ticks: {
                    font: { size: clamp(9, window.innerWidth / 100, 12) },
                    maxRotation: 45,
                    minRotation: 0
                },
                title: {
                    display: true,
                    text: 'Month', // X-axis label
                    font: { size: clamp(10, window.innerWidth / 100, 14),weight: 'bold' },
                    color: '#666'
                }
            }
        },
        layout: {
            padding: 10
        }
    };
}

        // Render Table with Pagination
        function renderTable(type, tableId, paginationId, columns) {
            const tableBody = document.querySelector(`#${tableId} tbody`);
            let currentPage = 1;

            function fetchPage(page) {
                fetch(`${BASE_URL}analytics/get_table_data?type=${type}&page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        if (data.records.length === 0) {
                            tableBody.innerHTML = `<tr><td colspan="${columns.length}" style="text-align: center; padding: 20px;">No data found</td></tr>`;
                            return;
                        }
                        data.records.forEach(item => {
                            const row = document.createElement('tr');
                            columns.forEach(col => {
                                let value = item[col.key] || 'N/A';
                                if (col.format) value = col.format(value);
                                const cell = document.createElement('td');
                                cell.setAttribute('data-label', document.querySelector(`#${tableId} th[data-label="${col.key}"]`)?.getAttribute('data-label') || col.key);
                                cell.innerHTML = value;
                                row.appendChild(cell);
                            });
                            tableBody.appendChild(row);
                        });
                        renderPagination(data.total_records, page, paginationId, fetchPage);
                    });
            }
            fetchPage(currentPage);
        }

        function renderPagination(totalRows, currentPage, paginationId, fetchPage) {
            const totalPages = Math.ceil(totalRows / 10);
            const container = document.getElementById(paginationId);
            container.innerHTML = '';
            if (totalPages <= 1) return;

            const prev = createButton('Previous', currentPage > 1, () => fetchPage(currentPage - 1));
            container.appendChild(prev);

            const start = Math.max(1, currentPage - 2);
            const end = Math.min(totalPages, currentPage + 2);

            if (start > 1) container.appendChild(createButton('1', true, () => fetchPage(1)));
            if (start > 2) container.appendChild(createSpan('...'));

            for (let i = start; i <= end; i++) {
                container.appendChild(createButton(i, i !== currentPage, () => fetchPage(i), i === currentPage ? 'btn-primary' : 'btn-secondary'));
            }

            if (end < totalPages - 1) container.appendChild(createSpan('...'));

            if (end < totalPages) {
                container.appendChild(createButton(totalPages, true, () => fetchPage(totalPages)));
            }

            const next = createButton('Next', currentPage < totalPages, () => fetchPage(currentPage + 1));
            container.appendChild(next);
        }

        function createButton(text, enabled, onClick, className = 'btn-secondary') {
            const button = document.createElement('button');
            button.className = `btn btn--${className}`;
            button.textContent = text;
            button.disabled = !enabled;
            if (enabled) button.addEventListener('click', onClick);
            return button;
        }

        function createSpan(text) {
            const span = document.createElement('span');
            span.textContent = text;
            span.style.padding = '8px 12px';
            span.style.color = '#666';
            return span;
        }

        // Initialize Tables
        function initializeTables() {
            renderTable('facility_revenue', 'facilityRevenueDetailsTables', 'facilityPagination', [
                { key: 'id', label: 'Facility ID' },
                { key: 'center_id', label: 'Center ID' },
                { key: 'facility_name', label: 'Name' },
                { key: 'subtype_name', label: 'Subtype' },
                { key: 'rent_amount', label: 'Rent Amount', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'rent_date', label: 'Rent Date' }
            ]);

            renderTable('event_revenue', 'eventRevenueDetailsTables', 'eventPagination', [
                { key: 'id', label: 'Event ID' },
                { key: 'name', label: 'Name' },
                { key: 'date', label: 'Date' },
                { key: 'fee', label: 'Fee', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'participants', label: 'Participants' },
                { key: 'total_revenue', label: 'Total Revenue', format: v => `₹${Number(v).toLocaleString()}` }
            ]);

            renderTable('student_fees', 'studentFeeDetailsTables', 'studentFeePagination', [
                { key: 'id', label: 'Student ID' },
                { key: 'name', label: 'Name' },
                { key: 'center_id', label: 'Center ID' },
                { key: 'batch_id', label: 'Batch ID' },
                { key: 'paid_amount', label: 'Paid Amount', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'remaining_amount', label: 'Remaining Amount', format: v => `₹${Number(v).toLocaleString()}` }
            ]);

            renderTable('expenses', 'expensesTable1', 'expensesPagination', [
                { key: 'id', label: 'ID' },
                { key: 'center_id', label: 'Center' },
                { key: 'title', label: 'Title' },
                { key: 'date', label: 'Date' },
                { key: 'amount', label: 'Amount', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'status', label: 'Status' }
            ]);

            renderTable('students', 'studentsTables', 'studentsPagination', [
                { key: 'id', label: 'ID' },
                { key: 'name', label: 'Name' },
                { key: 'center_id', label: 'Center' },
                { key: 'batch_id', label: 'Batch' },
                { key: 'level', label: 'Level' },
                { key: 'status', label: 'Status' }
            ]);

            renderTable('batches', 'batchesTables', 'batchesPagination', [
                { key: 'id', label: 'ID' },
                { key: 'center_id', label: 'Center ID' },
                { key: 'name', label: 'Name' },
                { key: 'level', label: 'Level' },
                { key: 'start_time', label: 'Start Time' },
                { key: 'end_time', label: 'End Time' },
                { key: 'start_date', label: 'Start Date' },
                { key: 'end_date', label: 'End Date' },
                { key: 'duration', label: 'Duration' },
                { key: 'category', label: 'Category' }
            ]);

            renderTable('centers', 'centersTables', 'centersPagination', [
                { key: 'id', label: 'ID' },
                { key: 'name', label: 'Name' },
                { key: 'center_number', label: 'Center Number' },
                { key: 'address', label: 'Address' },
                { key: 'latitude', label: 'Latitude' },
                { key: 'longitude', label: 'Longitude' },
                { key: 'rent_amount', label: 'Rent Amount', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'rent_paid_date', label: 'Rent Paid Date' },
                { key: 'timing_from', label: 'Timing From' },
                { key: 'timing_to', label: 'Timing To' }
            ]);

            renderTable('staff', 'staffTables', 'staffPagination', [
                { key: 'id', label: 'ID' },
                { key: 'name', label: 'Name' },
                { key: 'center_id', label: 'Center' },
                { key: 'role', label: 'Role' },
                { key: 'joining_date', label: 'Joining Date' }
            ]);

            renderTable('events', 'eventsTables', 'eventsPagination', [
                { key: 'id', label: 'ID' },
                { key: 'name', label: 'Name' },
                { key: 'date', label: 'Date' },
                { key: 'fee', label: 'Fee', format: v => `₹${Number(v).toLocaleString()}` },
                { key: 'max_participants', label: 'Participants' },
                { key: 'venue', label: 'Venue' }
            ]);

            renderTable('attendance', 'attendanceTables', 'attendancePagination', [
                { key: 'id', label: 'ID' },
                { key: 'student_id', label: 'Student ID' },
                { key: 'date', label: 'Date' },
                { key: 'time', label: 'Time' },
                { key: 'status', label: 'Status' }
            ]);
        }

        // Show Section
        function showSection(sectionId) {
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.remove('active');
            });
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        // Global Search
        document.getElementById('globalSearch').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.kpi-card').forEach(card => {
                const title = card.querySelector('.kpi-card__title').textContent.toLowerCase();
                const value = card.querySelector('.kpi-card__value').textContent.toLowerCase();
                card.style.display = (title.includes(query) || value.includes(query)) ? 'flex' : 'none';
            });

            document.querySelectorAll('.data-table tbody tr').forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(query)) {
                        match = true;
                    }
                });
                row.style.display = match ? 'table-row' : 'none';
            });
        });

        // KPI Card Navigation
        document.querySelectorAll('.kpi-card').forEach(card => {
            card.addEventListener('click', () => {
                const section = card.getAttribute('data-navigate');
                if (section) showSection(section);
            });
        });

        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('contentWrapper');
            sidebar.classList.toggle('minimized');
            contentWrapper.classList.toggle('minimized');
        });

        // Resize Handler for Charts
        window.addEventListener('resize', () => {
            if (typeof Chart !== 'undefined') {
                Chart.instances.forEach(chart => {
                    chart.options.font = { size: clamp(10, window.innerWidth / 100, 14) };
                    chart.options.plugins.legend.labels.font = { size: clamp(10, window.innerWidth / 100, 14) };
                    chart.options.plugins.legend.labels.padding = clamp(6, window.innerWidth / 100, 12);
                    chart.options.plugins.title.font = { size: clamp(12, window.innerWidth / 80, 16) };
                    chart.options.scales.y.ticks.font = { size: clamp(9, window.innerWidth / 100, 12) };
                    chart.options.scales.x.ticks.font = { size: clamp(9, window.innerWidth / 100, 12) };
                    chart.resize();
                });
            }
        });

        // Initialize on Page Load
        document.addEventListener('DOMContentLoaded', () => {
            initializeTables();
            // Ensure charts are responsive on initial load
            window.dispatchEvent(new Event('resize'));
        });
    </script>
</body>
</html>