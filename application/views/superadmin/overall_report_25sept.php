<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        body {
            font-family: 'Montserrat', sans-serif !important;
            background-color: #f4f6f8;
            padding-top: 60px;
            /* Space for fixed navbar */
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
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
        }

        .kpi-card__trend.positive {
            color: #28a745;
        }

        .kpi-card__trend.negative {
            color: #dc3545;
        }

        /* Updated Table Styling */
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
            color: white !important;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid #dee2e6;
        }

        .data-table td {
            padding: 12px 15px;
            font-size: 0.85rem;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        .data-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Ensure consistent column widths */
        .data-table th,
        .data-table td {
            min-width: 100px;
            /* Minimum width for columns */
            max-width: 200px;
            /* Maximum width to prevent overflow */
            white-space: normal;
            /* Allow text wrapping for long content */
            word-wrap: break-word;
        }

        /* Specific column width adjustments for each table */
        #facilityRevenueDetailsTables th:nth-child(1),
        #facilityRevenueDetailsTables td:nth-child(1) {
            width: 10%;
        }

        /* Facility ID */
        #facilityRevenueDetailsTables th:nth-child(2),
        #facilityRevenueDetailsTables td:nth-child(2) {
            width: 10%;
        }

        /* Center ID */
        #facilityRevenueDetailsTables th:nth-child(3),
        #facilityRevenueDetailsTables td:nth-child(3) {
            width: 20%;
        }

        /* Name */
        #facilityRevenueDetailsTables th:nth-child(4),
        #facilityRevenueDetailsTables td:nth-child(4) {
            width: 20%;
        }

        /* Subtype */
        #facilityRevenueDetailsTables th:nth-child(5),
        #facilityRevenueDetailsTables td:nth-child(5) {
            width: 20%;
        }

        /* Rent Amount */
        #facilityRevenueDetailsTables th:nth-child(6),
        #facilityRevenueDetailsTables td:nth-child(6) {
            width: 20%;
        }

        /* Rent Date */

        #eventRevenueDetailsTables th:nth-child(1),
        #eventRevenueDetailsTables td:nth-child(1) {
            width: 10%;
        }

        /* Event ID */
        #eventRevenueDetailsTables th:nth-child(2),
        #eventRevenueDetailsTables td:nth-child(2) {
            width: 20%;
        }

        /* Name */
        #eventRevenueDetailsTables th:nth-child(3),
        #eventRevenueDetailsTables td:nth-child(3) {
            width: 15%;
        }

        /* Date */
        #eventRevenueDetailsTables th:nth-child(4),
        #eventRevenueDetailsTables td:nth-child(4) {
            width: 15%;
        }

        /* Fee */
        #eventRevenueDetailsTables th:nth-child(5),
        #eventRevenueDetailsTables td:nth-child(5) {
            width: 15%;
        }

        /* Participants */
        #eventRevenueDetailsTables th:nth-child(6),
        #eventRevenueDetailsTables td:nth-child(6) {
            width: 25%;
        }

        /* Total Revenue */

        #studentFeeDetailsTables th:nth-child(1),
        #studentFeeDetailsTables td:nth-child(1) {
            width: 10%;
        }

        /* Student ID */
        #studentFeeDetailsTables th:nth-child(2),
        #studentFeeDetailsTables td:nth-child(2) {
            width: 25%;
        }

        /* Name */
        #studentFeeDetailsTables th:nth-child(3),
        #studentFeeDetailsTables td:nth-child(3) {
            width: 15%;
        }

        /* Center ID */
        #studentFeeDetailsTables th:nth-child(4),
        #studentFeeDetailsTables td:nth-child(4) {
            width: 15%;
        }

        /* Batch ID */
        #studentFeeDetailsTables th:nth-child(5),
        #studentFeeDetailsTables td:nth-child(5) {
            width: 15%;
        }

        /* Paid Amount */
        #studentFeeDetailsTables th:nth-child(6),
        #studentFeeDetailsTables td:nth-child(6) {
            width: 20%;
        }

        /* Remaining Amount */

        #expensesTable1 th:nth-child(1),
        #expensesTable1 td:nth-child(1) {
            width: 10%;
        }

        /* ID */
        #expensesTable1 th:nth-child(2),
        #expensesTable1 td:nth-child(2) {
            width: 15%;
        }

        /* Center ID */
        #expensesTable1 th:nth-child(3),
        #expensesTable1 td:nth-child(3) {
            width: 25%;
        }

        /* Title */
        #expensesTable1 th:nth-child(4),
        #expensesTable1 td:nth-child(4) {
            width: 15%;
        }

        /* Date */
        #expensesTable1 th:nth-child(5),
        #expensesTable1 td:nth-child(5) {
            width: 15%;
        }

        /* Amount */
        #expensesTable1 th:nth-child(6),
        #expensesTable1 td:nth-child(6) {
            width: 20%;
        }

        /* Status */

        #studentsTables th:nth-child(1),
        #studentsTables td:nth-child(1) {
            width: 10%;
        }

        /* ID */
        #studentsTables th:nth-child(2),
        #studentsTables td:nth-child(2) {
            width: 25%;
        }

        /* Name */
        #studentsTables th:nth-child(3),
        #studentsTables td:nth-child(3) {
            width: 15%;
        }

        /* Center */
        #studentsTables th:nth-child(4),
        #studentsTables td:nth-child(4) {
            width: 15%;
        }

        /* Batch */
        #studentsTables th:nth-child(5),
        #studentsTables td:nth-child(5) {
            width: 15%;
        }

        /* Level */
        #studentsTables th:nth-child(6),
        #studentsTables td:nth-child(6) {
            width: 20%;
        }

        /* Status */

        #staffTables th:nth-child(1),
        #staffTables td:nth-child(1) {
            width: 10%;
        }

        /* ID */
        #staffTables th:nth-child(2),
        #staffTables td:nth-child(2) {
            width: 25%;
        }

        /* Name */
        #staffTables th:nth-child(3),
        #staffTables td:nth-child(3) {
            width: 15%;
        }

        /* Center ID */
        #staffTables th:nth-child(4),
        #staffTables td:nth-child(4) {
            width: 20%;
        }

        /* Role */
        #staffTables th:nth-child(5),
        #staffTables td:nth-child(5) {
            width: 30%;
        }

        /* Joining Date */

        #eventsTables th:nth-child(1),
        #eventsTables td:nth-child(1) {
            width: 10%;
        }

        /* ID */
        #eventsTables th:nth-child(2),
        #eventsTables td:nth-child(2) {
            width: 20%;
        }

        /* Name */
        #eventsTables th:nth-child(3),
        #eventsTables td:nth-child(3) {
            width: 15%;
        }

        /* Date */
        #eventsTables th:nth-child(4),
        #eventsTables td:nth-child(4) {
            width: 15%;
        }

        /* Fee */
        #eventsTables th:nth-child(5),
        #eventsTables td:nth-child(5) {
            width: 15%;
        }

        /* Max Participants */
        #eventsTables th:nth-child(6),
        #eventsTables td:nth-child(6) {
            width: 25%;
        }

        /* Venue */

        .pagination-container .btn {
            margin: 0 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 10px;
            }

            .kpi-grid,
            .revenue-overview-grid,
            .charts-grid {
                grid-template-columns: 1fr !important;
            }

            .chart-container {
                height: auto !important;
            }

            .data-table th,
            .data-table td {
                font-size: 0.75rem;
                padding: 8px 10px;
                min-width: 80px;
                max-width: 150px;
            }
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .revenue-overview-grid,
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .dashboard-section {
            display: none;
        }

        .dashboard-section.active {
            display: block;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header__search input {
            width: 200px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid">
            <h3 class="text-center mb-4">Analytics And Reports </h3>

            <!-- Dashboard Overview Section -->
            <section id="dashboard" class="dashboard-section active">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Dashboard Overview</h4>
                    </div>
                    <div class="card-body">
                        <div class="section-header">
                            <h2>Dashboard Overview</h2>
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
                                    <!-- <p class="kpi-card__value" id="kpi-total-revenue">₹17500</p> -->
                                    <span class="kpi-card__trend positive">↗ +12.5%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="red" data-navigate="total-expenses">
                                <div class="kpi-card__icon">💸</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Expenses</h4>
                                    <p class="kpi-card__value" id="kpi-total-expenses">₹12000</p>
                                    <span class="kpi-card__trend negative">↘ -2.3%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="blue" data-navigate="total-students">
                                <div class="kpi-card__icon">👥</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Students</h4>
                                    <p class="kpi-card__value" id="kpi-total-students">11</p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="purple" data-navigate="active-students">
                                <div class="kpi-card__icon">✅</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Active Students</h4>
                                    <p class="kpi-card__value" id="kpi-active-students">4</p>
                                    <span class="kpi-card__trend positive">↗ +5.1%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="orange" data-navigate="total-batches">
                                <div class="kpi-card__icon">📅</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Batches</h4>
                                    <p class="kpi-card__value" id="kpi-total-batches">4</p>
                                    <span class="kpi-card__trend positive">↗ +15.7%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="teal" data-navigate="total-centers">
                                <div class="kpi-card__icon">🏢</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Centers</h4>
                                    <p class="kpi-card__value" id="kpi-total-centers">10</p>
                                    <span class="kpi-card__trend positive">↗ +18.9%</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="cyan" data-navigate="total-staff">
                                <div class="kpi-card__icon">🧑‍🏫</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Staff</h4>
                                    <p class="kpi-card__value" id="kpi-total-staff">5</p>
                                    <span class="kpi-card__trend positive">↗ +3</span>
                                </div>
                            </div>
                            <div class="kpi-card" data-color="yellow" data-navigate="total-events">
                                <div class="kpi-card__icon">🎉</div>
                                <div class="kpi-card__content">
                                    <h4 class="kpi-card__title">Total Events</h4>
                                    <p class="kpi-card__value" id="kpi-total-events">8</p>
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
                                    <div class="card-body" style="position: relative; height: 300px;">
                                        <canvas id="revenueMonthlyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Student Distribution by Level</h4>
                                    </div>
                                    <div class="card-body" style="position: relative; height: 300px;">
                                        <canvas id="studentLevelDistributionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Revenue vs Expense (Month Wise)</h4>
                                    </div>
                                    <div class="card-body" style="position: relative; height: 300px;">
                                        <canvas id="revenueVsExpenseChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card" style="display: flex; flex-direction: row; gap: 24px; align-items: stretch;">
                                    <div style="flex: 1; display: flex; flex-direction: column;">
                                        <div class="card-header">
                                            <h4>Batch Distribution by Level</h4>
                                        </div>
                                        <div class="card-body" style="position: relative; height: 300px;">
                                            <canvas id="batchLevelChart"></canvas>
                                        </div>
                                    </div>
                                    <div style="flex: 1; display: flex; flex-direction: column;">
                                        <div class="card-header">
                                            <h4>Staff Distribution by Role</h4>
                                        </div>
                                        <div class="card-body" style="position: relative; height: 300px;">
                                            <canvas id="staffRoleChart"></canvas>
                                        </div>
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
                            <h2>Total Revenue Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                                <button class="btn btn--primary" id="exportRevenueCSV">Export CSV</button>
                            </div>
                        </div>

                        <!-- Revenue Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">💰</div>
                                <div class="overview-card__content">
                                    <h4>Total Revenue</h4>
                                    <p class="overview-card__value">₹17500</p>
                                    <span class="kpi-card__trend positive">↗ +12.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">💳</div>
                                <div class="overview-card__content">
                                    <h4>Outstanding Fees</h4>
                                    <p class="overview-card__value">₹72100</p>
                                    <span class="kpi-card__trend positive">↗ +17.8%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📈</div>
                                <div class="overview-card__content">
                                    <h4>Fees from Events</h4>
                                    <p class="overview-card__value">₹950</p>
                                    <span class="kpi-card__trend positive">↗ +8.9%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🏓</div>
                                <div class="overview-card__content">
                                    <h4>Facility Rental Revenue</h4>
                                    <p class="overview-card__value">₹13675</p>
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
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="revenueMonthlyChartUnder"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Revenue Distribution</h4>
                                    </div>
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="revenueDistributionChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Facilities Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Facility Revenue Details</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="facilityRevenueDetailsTables">
                                        <thead>
                                            <tr>
                                                <th>Facility ID</th>
                                                <th>Center ID</th>
                                                <th>Name</th>
                                                <th>Subtype</th>
                                                <th>Rent Amount</th>
                                                <th>Rent Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Events Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Event Revenue Details</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="eventRevenueDetailsTables">
                                        <thead>
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Fee</th>
                                                <th>Participants</th>
                                                <th>Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue by Students Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Student Fee Details</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="studentFeeDetailsTables">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Center ID</th>
                                                <th>Batch ID</th>
                                                <th>Paid Amount</th>
                                                <th>Remaining Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
                            <h2>Total Expenses Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                                <button class="btn btn--primary" id="exportExpensesCSV">Export CSV</button>
                            </div>
                        </div>

                        <!-- Expense Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">💸</div>
                                <div class="overview-card__content">
                                    <h4>Total Expenses</h4>
                                    <p class="overview-card__value">₹12000</p>
                                    <span class="kpi-card__trend negative">↘ -2.3%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🏢</div>
                                <div class="overview-card__content">
                                    <h4>Center Expenses</h4>
                                    <p class="overview-card__value">₹12000</p>
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
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="expenseCategoriesChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Monthly Expense Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="expenseTrendChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Expenses Details</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="expensesTable1">
                                        <thead>
                                            <tr>
                                                <th data-sort="id">ID</th>
                                                <th data-sort="center">Center ID</th>
                                                <th data-sort="title">Title</th>
                                                <th data-sort="date">Date</th>
                                                <th data-sort="amount">Amount</th>
                                                <th data-sort="status">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
                            <h2>Students Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                                <button class="btn btn--primary" id="exportStudentsCSV">Export CSV</button>
                            </div>
                        </div>

                        <!-- Students Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">👥</div>
                                <div class="overview-card__content">
                                    <h4>Total Students</h4>
                                    <p class="overview-card__value">11</p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">✅</div>
                                <div class="overview-card__content">
                                    <h4>Active Students</h4>
                                    <p class="overview-card__value">4</p>
                                    <span class="kpi-card__trend negative">↘ -12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📈</div>
                                <div class="overview-card__content">
                                    <h4>Beginner Students</h4>
                                    <p class="overview-card__value">10</p>
                                    <span class="kpi-card__trend positive">↗ +10.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📊</div>
                                <div class="overview-card__content">
                                    <h4>Intermediate Students</h4>
                                    <p class="overview-card__value">1</p>
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
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="studentsLevelChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Attendance Trend</h4>
                                    </div>
                                    <div class="card-body" style="position: relative; height: 350px;">
                                        <canvas id="attendanceTrendChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Students Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Student List</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="studentsTables">
                                        <thead>
                                            <tr>
                                                <th data-sort="id">ID</th>
                                                <th data-sort="name">Name</th>
                                                <th data-sort="center">Center</th>
                                                <th data-sort="batch">Batch</th>
                                                <th data-sort="level">Level</th>
                                                <th data-sort="status">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                            <h2>Staff Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                                <button class="btn btn--primary" id="exportStaffCSV">Export CSV</button>
                            </div>
                        </div>

                        <!-- Staff Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">🧑‍🏫</div>
                                <div class="overview-card__content">
                                    <h4>Total Staff</h4>
                                    <p class="overview-card__value">5</p>
                                    <span class="kpi-card__trend positive">↗ +5.1%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👨‍💼</div>
                                <div class="overview-card__content">
                                    <h4>Admins</h4>
                                    <p class="overview-card__value">3</p>
                                    <span class="kpi-card__trend negative">↘ -8%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">🧑‍🏫</div>
                                <div class="overview-card__content">
                                    <h4>Coaches</h4>
                                    <p class="overview-card__value">1</p>
                                    <span class="kpi-card__trend positive">↗ +12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👩‍💼</div>
                                <div class="overview-card__content">
                                    <h4>Managers</h4>
                                    <p class="overview-card__value">1</p>
                                    <span class="kpi-card__trend positive">↗ +18%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Staff Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Staff List</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="staffTables">
                                        <thead>
                                            <tr>
                                                <th data-sort="id">ID</th>
                                                <th data-sort="name">Name</th>
                                                <th data-sort="center">Center ID</th>
                                                <th data-sort="role">Role</th>
                                                <th data-sort="joining">Joining Date</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
                            <h2>Events Analytics</h2>
                            <div class="section-actions">
                                <button class="btn btn--secondary" onclick="showSection('dashboard')">← Back to Dashboard</button>
                                <button class="btn btn--primary" id="exportEventsCSV">Export CSV</button>
                            </div>
                        </div>

                        <!-- Events Overview Cards -->
                        <div class="revenue-overview-grid">
                            <div class="overview-card">
                                <div class="overview-card__icon">🎉</div>
                                <div class="overview-card__content">
                                    <h4>Total Events</h4>
                                    <p class="overview-card__value">8</p>
                                    <span class="kpi-card__trend positive">↗ +8.2%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">👥</div>
                                <div class="overview-card__content">
                                    <h4>Total Participants</h4>
                                    <p class="overview-card__value">8</p>
                                    <span class="kpi-card__trend negative">↘ -12%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">💰</div>
                                <div class="overview-card__content">
                                    <h4>Total Event Revenue</h4>
                                    <p class="overview-card__value">₹950</p>
                                    <span class="kpi-card__trend positive">↗ +10.5%</span>
                                </div>
                            </div>
                            <div class="overview-card">
                                <div class="overview-card__icon">📅</div>
                                <div class="overview-card__content">
                                    <h4>Upcoming Events</h4>
                                    <p class="overview-card__value">2</p>
                                    <span class="kpi-card__trend negative">↘ -5.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Events Table -->
                        <div class="data-table-container">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Event List</h4>
                                </div>
                                <div class="card-body">
                                    <table class="data-table" id="eventsTables">
                                        <thead>
                                            <tr>
                                                <th data-sort="id">ID</th>
                                                <th data-sort="name">Name</th>
                                                <th data-sort="date">Date</th>
                                                <th data-sort="fee">Fee</th>
                                                <th data-sort="participants">Max Participants</th>
                                                <th data-sort="venue">Venue</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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

        // Sidebar toggle functionality
        $('#sidebarToggle').on('click', function() {
            if ($(window).width() <= 576) {
                $('#sidebar').toggleClass('active');
                $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
            } else {
                const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
                $('.navbar').toggleClass('sidebar-minimized', isMinimized);
                $('#contentWrapper').toggleClass('minimized', isMinimized);
            }
        });

        // Section navigation
        function showSection(sectionId) {
            document.querySelectorAll('.dashboard-section').forEach(function(sec) {
                sec.classList.remove('active');
            });
            var target = document.getElementById(sectionId);
            if (target) target.classList.add('active');
            window.scrollTo(0, 0);
        }

        // KPI card navigation
        document.querySelectorAll('.kpi-card').forEach(card => {
            card.addEventListener('click', () => {
                const section = card.getAttribute('data-navigate');
                showSection(section);
            });
        });

        // Chart: Monthly Revenue Trend
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById("revenueMonthlyChart").getContext("2d");
            const fallbackData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                revenue: [50000, 90000, 110000, 100000, 100000, 120000, 125000],
            };
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: fallbackData.labels,
                    datasets: [{
                        label: "Revenue",
                        data: fallbackData.revenue,
                        backgroundColor: "rgba(40, 167, 69, 0.2)",
                        borderColor: "rgba(40, 167, 69, 1)",
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top"
                        },
                        title: {
                            display: true,
                            text: "Monthly Revenue Trend",
                            font: {
                                size: 16
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "₹" + value.toLocaleString();
                                },
                                stepSize: 50000,
                                max: 130000,
                            },
                        },
                        x: {
                            ticks: {
                                color: "#666"
                            },
                            grid: {
                                display: false
                            }
                        },
                    },
                },
            });
        });

        // Chart: Student Distribution by Level
        document.addEventListener("DOMContentLoaded", function() {
            const studentLevelData = {
                labels: ['Beginner', 'Intermediate', 'Advanced'],
                datasets: [{
                    data: [10, 1, 0],
                    backgroundColor: ['#28a745', '#ffc107', '#007bff']
                }]
            };
            const studentLevelCtx = document.getElementById('studentLevelDistributionChart');
            if (studentLevelCtx) {
                new Chart(studentLevelCtx, {
                    type: 'doughnut',
                    data: studentLevelData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#000'
                                }
                            }
                        }
                    }
                });
            }
        });

        // Chart: Revenue vs Expense
        document.addEventListener("DOMContentLoaded", function() {
            const revenueVsExpenseData = {
                labels: ['Sep 2025'],
                revenue: [17500],
                expense: [12000]
            };
            const ctx = document.getElementById('revenueVsExpenseChart2').getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: revenueVsExpenseData.labels,
                        datasets: [{
                                label: 'Revenue',
                                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 1,
                                data: revenueVsExpenseData.revenue
                            },
                            {
                                label: 'Expense',
                                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                                borderColor: 'rgba(220, 53, 69, 1)',
                                borderWidth: 1,
                                data: revenueVsExpenseData.expense
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '₹' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });

        // Chart: Batch Distribution by Level
        document.addEventListener("DOMContentLoaded", function() {
            const batchLevelData = {
                labels: ['Beginner', 'Intermediate', 'Advanced'],
                datasets: [{
                    data: [3, 1, 0],
                    backgroundColor: ['#28a745', '#ffc107', '#007bff'],
                    borderWidth: 1
                }]
            };
            const batchCtx = document.getElementById('batchLevelChart').getContext('2d');
            new Chart(batchCtx, {
                type: 'doughnut',
                data: batchLevelData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#000'
                            }
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        });

        // Chart: Staff Distribution by Role
        document.addEventListener("DOMContentLoaded", function() {
            const staffRoleData = {
                labels: ['Admin', 'Manager', 'Coach', 'Support'],
                datasets: [{
                    data: [3, 1, 1, 0],
                    backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545'],
                    borderWidth: 1
                }]
            };
            const staffCtx = document.getElementById('staffRoleChart').getContext('2d');
            new Chart(staffCtx, {
                type: 'doughnut',
                data: staffRoleData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#000'
                            }
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
        });

        // Chart: Monthly Revenue Trends (Revenue Section)
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById("revenueMonthlyChartUnder").getContext("2d");
            const fallbackData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
                revenue: [50000, 90000, 110000, 100000, 100000, 120000, 125000],
            };
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: fallbackData.labels,
                    datasets: [{
                        label: "Revenue",
                        data: fallbackData.revenue,
                        backgroundColor: "rgba(40, 167, 69, 0.2)",
                        borderColor: "rgba(40, 167, 69, 1)",
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top"
                        },
                        title: {
                            display: true,
                            text: "Monthly Revenue Trend",
                            font: {
                                size: 16
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "₹" + value.toLocaleString();
                                },
                                stepSize: 50000,
                                max: 130000,
                            },
                        },
                        x: {
                            ticks: {
                                color: "#666"
                            },
                            grid: {
                                display: false
                            }
                        },
                    },
                },
            });
        });

        // Chart: Expense Categories
        document.addEventListener("DOMContentLoaded", function() {
            const expenseCategoriesData = {
                labels: ['Center Expenses', 'Staff Salaries', 'Facility Maintenance'],
                datasets: [{
                    data: [12000, 0, 0],
                    backgroundColor: CHART_COLORING.slice(0, 3)
                }]
            };
            const categoriesCtx = document.getElementById('expenseCategoriesChart2');
            if (categoriesCtx) {
                new Chart(categoriesCtx, {
                    type: 'doughnut',
                    data: expenseCategoriesData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#000'
                                }
                            }
                        }
                    }
                });
            }
        });

        // Chart: Monthly Expense Trend
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById("expenseTrendChart2").getContext("2d");
            const fallbackData = {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
                expense: [0, 0, 0, 0, 0, 0, 36042.15, 0],
            };
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: fallbackData.labels,
                    datasets: [{
                        label: "Expense",
                        data: fallbackData.expense,
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: "top"
                        },
                        title: {
                            display: true,
                            text: "Monthly Expense Trend",
                            font: {
                                size: 16
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return "₹" + value.toLocaleString();
                                },
                                stepSize: 50000,
                                suggestedMax: 100000,
                            },
                        },
                        x: {
                            ticks: {
                                color: "#666"
                            },
                            grid: {
                                display: false
                            }
                        },
                    },
                },
            });
        });

        // Chart: Students by Level
        document.addEventListener("DOMContentLoaded", function() {
            const studentsLevelData = {
                labels: ["Beginner", "Intermediate", "Advanced"],
                datasets: [{
                    data: [10, 1, 0],
                    backgroundColor: ['#28a745', '#ffc107', '#007bff'],
                }]
            };
            const levelCtx = document.getElementById("studentsLevelChart2");
            if (levelCtx) {
                new Chart(levelCtx, {
                    type: "doughnut",
                    data: studentsLevelData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "bottom",
                                labels: {
                                    color: '#000'
                                }
                            }
                        },
                    },
                });
            }
        });

        // Table: Facility Revenue Details
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#facilityRevenueDetailsTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#facilityRevenueDetailsTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '11',
                    center_id: null,
                    facility_name: 'shoes',
                    subtype_name: null,
                    rent_amount: '0.00',
                    rent_date: null
                },
                {
                    id: '12',
                    center_id: null,
                    facility_name: 'shoes',
                    subtype_name: 'Small',
                    rent_amount: '200.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '13',
                    center_id: null,
                    facility_name: 'shoes',
                    subtype_name: 'Small',
                    rent_amount: '200.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '14',
                    center_id: null,
                    facility_name: 'shoes',
                    subtype_name: 'Small',
                    rent_amount: '200.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '15',
                    center_id: '19',
                    facility_name: 'shoes',
                    subtype_name: 'Small',
                    rent_amount: '200.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '16',
                    center_id: '19',
                    facility_name: 'shoes',
                    subtype_name: 'Small',
                    rent_amount: '200.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '17',
                    center_id: '19',
                    facility_name: 'shoes',
                    subtype_name: 'big',
                    rent_amount: '500.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '18',
                    center_id: '23',
                    facility_name: 'Shoe',
                    subtype_name: 'sports 94777757854 number',
                    rent_amount: '5075.00',
                    rent_date: '2025-09-02'
                },
                {
                    id: '19',
                    center_id: '25',
                    facility_name: 'Swimming Pool',
                    subtype_name: 'Small',
                    rent_amount: '500.00',
                    rent_date: '2025-09-08'
                },
                {
                    id: '20',
                    center_id: '25',
                    facility_name: 'Swimming Pool',
                    subtype_name: 'Medium',
                    rent_amount: '800.00',
                    rent_date: '2025-09-08'
                },
                {
                    id: '21',
                    center_id: '25',
                    facility_name: 'Swimming Pool',
                    subtype_name: 'Large',
                    rent_amount: '1200.00',
                    rent_date: '2025-09-08'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No facility data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.center_id || 'N/A'}</td>
                        <td>${item.facility_name}</td>
                        <td>${item.subtype_name || 'N/A'}</td>
                        <td>₹${parseFloat(item.rent_amount || 0).toLocaleString()}</td>
                        <td>${item.rent_date || 'N/A'}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Event Revenue Details
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#eventRevenueDetailsTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#eventRevenueDetailsTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '1',
                    name: 'team',
                    date: '2025-09-04',
                    fee: '100.00'
                },
                {
                    id: '2',
                    name: 'Annual Marathon Run',
                    date: '2025-09-04',
                    fee: '150.00'
                },
                {
                    id: '3',
                    name: 'Intercollege Football Tournament',
                    date: '2025-09-29',
                    fee: '100.00'
                },
                {
                    id: '5',
                    name: 'xyz',
                    date: '2025-09-15',
                    fee: '100.00'
                },
                {
                    id: '6',
                    name: 'marathon',
                    date: '2025-09-08',
                    fee: '200.00'
                },
                {
                    id: '7',
                    name: 'hoi',
                    date: '2025-09-08',
                    fee: '100.00'
                },
                {
                    id: '8',
                    name: 'volleyball',
                    date: '2025-09-09',
                    fee: '100.00'
                },
                {
                    id: '9',
                    name: 'team',
                    date: '2025-09-16',
                    fee: '200.00'
                }
            ];
            const participants = [{
                    event_id: '3'
                }, {
                    event_id: '5'
                }, {
                    event_id: '3'
                }, {
                    event_id: '1'
                },
                {
                    event_id: '3'
                }, {
                    event_id: '3'
                }, {
                    event_id: '5'
                }, {
                    event_id: '6'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No event data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const participantsCount = participants.filter(p => p.event_id === item.id).length;
                    const totalRevenue = participantsCount * parseFloat(item.fee || 0);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.date}</td>
                        <td>₹${parseFloat(item.fee || 0).toLocaleString()}</td>
                        <td>${participantsCount}</td>
                        <td>₹${totalRevenue.toLocaleString()}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Student Fee Details
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#studentFeeDetailsTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#studentFeeDetailsTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '203',
                    name: 'Sadashiv Mohite',
                    center_id: '15',
                    batch_id: '16',
                    paid_amount: '100.00',
                    remaining_amount: '1200.00'
                },
                {
                    id: '204',
                    name: 'Rushikesh Thomare',
                    center_id: '9',
                    batch_id: '10',
                    paid_amount: '1000.00',
                    remaining_amount: '9300.00'
                },
                {
                    id: '237',
                    name: 'Prajwal Ramdas Wakulkar',
                    center_id: '20',
                    batch_id: '23',
                    paid_amount: '4000.00',
                    remaining_amount: '5200.00'
                },
                {
                    id: '266',
                    name: 'Saurav Shahaji Nalawde',
                    center_id: '21',
                    batch_id: '19',
                    paid_amount: '100.00',
                    remaining_amount: '900.00'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No student fee data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.center_id}</td>
                        <td>${item.batch_id}</td>
                        <td>₹${parseFloat(item.paid_amount || 0).toLocaleString()}</td>
                        <td>₹${parseFloat(item.remaining_amount || 0).toLocaleString()}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Expenses Details
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#expensesTable1 tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#expensesTable1').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '1',
                    center_id: '20',
                    title: 'tennis mat',
                    date: '2025-09-04',
                    amount: '2000.00',
                    status: 'approved'
                },
                {
                    id: '2',
                    center_id: '20',
                    title: 'mat',
                    date: '2025-09-08',
                    amount: '1000.00',
                    status: 'approved'
                },
                {
                    id: '3',
                    center_id: '20',
                    title: 'fghhhj',
                    date: '2025-09-15',
                    amount: '2000.00',
                    status: 'approved'
                },
                {
                    id: '4',
                    center_id: '20',
                    title: 'tennis bat',
                    date: '2025-09-16',
                    amount: '2000.00',
                    status: 'approved'
                },
                {
                    id: '5',
                    center_id: '20',
                    title: 'tennis bat',
                    date: '2025-09-16',
                    amount: '2000.00',
                    status: 'approved'
                },
                {
                    id: '8',
                    center_id: '20',
                    title: 'mts',
                    date: '2025-09-16',
                    amount: '1000.00',
                    status: 'approved'
                },
                {
                    id: '9',
                    center_id: '25',
                    title: 'tennis ball',
                    date: '2025-09-16',
                    amount: '2000.00',
                    status: 'approved'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No expense data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.center_id}</td>
                        <td>${item.title}</td>
                        <td>${item.date}</td>
                        <td>₹${parseFloat(item.amount || 0).toLocaleString()}</td>
                        <td>${item.status}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Students List
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#studentsTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#studentsTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '203',
                    name: 'Sadashiv Mohite',
                    center_id: '15',
                    batch_id: '16',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '204',
                    name: 'Rushikesh Thomare',
                    center_id: '9',
                    batch_id: '10',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '237',
                    name: 'Prajwal Ramdas Wakulkar',
                    center_id: '20',
                    batch_id: '23',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '266',
                    name: 'Saurav Shahaji Nalawde',
                    center_id: '21',
                    batch_id: '19',
                    level: 'Intermediate',
                    status: 'Active'
                },
                {
                    id: '267',
                    name: 'John Doe',
                    center_id: '20',
                    batch_id: '23',
                    level: 'Beginner',
                    status: 'Inactive'
                },
                {
                    id: '268',
                    name: 'Jane Smith',
                    center_id: '15',
                    batch_id: '16',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '269',
                    name: 'Alice Johnson',
                    center_id: '9',
                    batch_id: '10',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '270',
                    name: 'Bob Brown',
                    center_id: '21',
                    batch_id: '19',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '271',
                    name: 'Emma Wilson',
                    center_id: '20',
                    batch_id: '23',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '272',
                    name: 'Liam Davis',
                    center_id: '15',
                    batch_id: '16',
                    level: 'Beginner',
                    status: 'Active'
                },
                {
                    id: '273',
                    name: 'Olivia Martinez',
                    center_id: '9',
                    batch_id: '10',
                    level: 'Beginner',
                    status: 'Active'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No student data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.center_id}</td>
                        <td>${item.batch_id}</td>
                        <td>${item.level}</td>
                        <td>${item.status}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Staff List
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#staffTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#staffTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '1',
                    name: 'Admin User',
                    center_id: '9',
                    role: 'Admin',
                    joining_date: '2025-09-01'
                },
                {
                    id: '2',
                    name: 'John Manager',
                    center_id: '15',
                    role: 'Manager',
                    joining_date: '2025-09-01'
                },
                {
                    id: '3',
                    name: 'Coach Smith',
                    center_id: '20',
                    role: 'Coach',
                    joining_date: '2025-09-01'
                },
                {
                    id: '4',
                    name: 'Admin Two',
                    center_id: '21',
                    role: 'Admin',
                    joining_date: '2025-09-01'
                },
                {
                    id: '5',
                    name: 'Admin Three',
                    center_id: '25',
                    role: 'Admin',
                    joining_date: '2025-09-01'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 20px;">No staff data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.center_id}</td>
                        <td>${item.role}</td>
                        <td>${item.joining_date}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Table: Events List
        document.addEventListener('DOMContentLoaded', function() {
            const tableBody = document.querySelector('#eventsTables tbody');
            const paginationContainer = document.createElement('div');
            paginationContainer.className = 'pagination-container';
            paginationContainer.style.textAlign = 'center';
            paginationContainer.style.marginTop = '20px';
            document.querySelector('#eventsTables').after(paginationContainer);

            const rowsPerPage = 10;
            let currentPage = 1;
            let allData = [{
                    id: '1',
                    name: 'team',
                    date: '2025-09-04',
                    fee: '100.00',
                    max_participants: '10',
                    venue: 'Center 15'
                },
                {
                    id: '2',
                    name: 'Annual Marathon Run',
                    date: '2025-09-04',
                    fee: '150.00',
                    max_participants: '50',
                    venue: 'Center 20'
                },
                {
                    id: '3',
                    name: 'Intercollege Football Tournament',
                    date: '2025-09-29',
                    fee: '100.00',
                    max_participants: '20',
                    venue: 'Center 21'
                },
                {
                    id: '5',
                    name: 'xyz',
                    date: '2025-09-15',
                    fee: '100.00',
                    max_participants: '15',
                    venue: 'Center 9'
                },
                {
                    id: '6',
                    name: 'marathon',
                    date: '2025-09-08',
                    fee: '200.00',
                    max_participants: '30',
                    venue: 'Center 25'
                },
                {
                    id: '7',
                    name: 'hoi',
                    date: '2025-09-08',
                    fee: '100.00',
                    max_participants: '10',
                    venue: 'Center 15'
                },
                {
                    id: '8',
                    name: 'volleyball',
                    date: '2025-09-09',
                    fee: '100.00',
                    max_participants: '12',
                    venue: 'Center 20'
                },
                {
                    id: '9',
                    name: 'team',
                    date: '2025-09-16',
                    fee: '200.00',
                    max_participants: '20',
                    venue: 'Center 21'
                }
            ];

            function renderPagination(totalRows) {
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                paginationContainer.innerHTML = '';
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.className = 'btn btn-secondary';
                prevButton.style.margin = '0 5px';
                prevButton.disabled = currentPage === 1;
                prevButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(prevButton);

                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, currentPage + 2);

                if (startPage > 1) {
                    const firstPage = document.createElement('button');
                    firstPage.textContent = '1';
                    firstPage.className = 'btn btn-secondary';
                    firstPage.style.margin = '0 5px';
                    firstPage.addEventListener('click', () => {
                        currentPage = 1;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(firstPage);
                    if (startPage > 2) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `btn ${i === currentPage ? 'btn-primary' : 'btn-secondary'}`;
                    pageButton.style.margin = '0 5px';
                    pageButton.addEventListener('click', () => {
                        currentPage = i;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(pageButton);
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        const dots = document.createElement('span');
                        dots.textContent = '...';
                        dots.style.margin = '0 5px';
                        paginationContainer.appendChild(dots);
                    }
                    const lastPage = document.createElement('button');
                    lastPage.textContent = totalPages;
                    lastPage.className = 'btn btn-secondary';
                    lastPage.style.margin = '0 5px';
                    lastPage.addEventListener('click', () => {
                        currentPage = totalPages;
                        renderPage();
                        renderPagination(totalRows);
                    });
                    paginationContainer.appendChild(lastPage);
                }

                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.className = 'btn btn-secondary';
                nextButton.style.margin = '0 5px';
                nextButton.disabled = currentPage === totalPages;
                nextButton.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderPage();
                        renderPagination(totalRows);
                    }
                });
                paginationContainer.appendChild(nextButton);
            }

            function renderPage() {
                tableBody.innerHTML = '';
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const pageData = allData.slice(start, end);

                if (pageData.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 20px;">No event data found</td></tr>';
                    return;
                }

                pageData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.date}</td>
                        <td>₹${parseFloat(item.fee || 0).toLocaleString()}</td>
                        <td>${item.max_participants}</td>
                        <td>${item.venue}</td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            renderPage();
            renderPagination(allData.length);
        });

        // Chart: Revenue Distribution
        document.addEventListener("DOMContentLoaded", function() {
            const revenueDistributionData = {
                labels: ['Facility Rental', 'Event Fees', 'Student Fees'],
                datasets: [{
                    data: [13675, 950, 2875],
                    backgroundColor: ['#28a745', '#ffc107', '#007bff']
                }]
            };
            const ctx = document.getElementById('revenueDistributionChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: revenueDistributionData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: '#000'
                                }
                            }
                        }
                    }
                });
            }
        });

        // Chart: Attendance Trend
        document.addEventListener("DOMContentLoaded", function() {
            const attendanceTrendData = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    label: 'Attendance',
                    data: [8, 9, 7, 10, 11, 9, 8, 10],
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            };
            const ctx = document.getElementById('attendanceTrendChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: attendanceTrendData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Attendance Trend',
                                font: {
                                    size: 16
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 2
                                }
                            },
                            x: {
                                ticks: {
                                    color: '#666'
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });

        // Global Search Functionality
        document.getElementById('globalSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.kpi-card, .overview-card, .data-table tbody tr').forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Export CSV Functionality
        function exportTableToCSV(tableId, filename) {
            const table = document.getElementById(tableId);
            const rows = table.querySelectorAll('tr');
            let csv = [];
            rows.forEach(row => {
                const cols = row.querySelectorAll('td, th');
                const rowData = Array.from(cols).map(col => `"${col.textContent.replace(/"/g, '""')}"`).join(',');
                csv.push(rowData);
            });
            const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        document.getElementById('exportRevenueCSV').addEventListener('click', () => {
            exportTableToCSV('facilityRevenueDetailsTables', 'facility_revenue.csv');
            exportTableToCSV('eventRevenueDetailsTables', 'event_revenue.csv');
            exportTableToCSV('studentFeeDetailsTables', 'student_fees.csv');
        });

        document.getElementById('exportExpensesCSV').addEventListener('click', () => {
            exportTableToCSV('expensesTable1', 'expenses.csv');
        });

        document.getElementById('exportStudentsCSV').addEventListener('click', () => {
            exportTableToCSV('studentsTables', 'students.csv');
        });

        document.getElementById('exportStaffCSV').addEventListener('click', () => {
            exportTableToCSV('staffTables', 'staff.csv');
        });

        document.getElementById('exportEventsCSV').addEventListener('click', () => {
            exportTableToCSV('eventsTables', 'events.csv');
        });
    </script>
</body>

</html>