<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f4f6f8 !important;
            margin: 0;
            font-family: 'Montserrat', serif !important;
            overflow-x: hidden;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
        }
        .content-wrapper.minimized {
            margin-left: 60px;
        }
        .content {
            margin-top: 60px;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }
        .revenue-card, .summary-card {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            flex: 1;
            min-width: 250px;
            max-width: 400px;
        }
        .revenue-card p, .summary-card p {
            margin: 0.4rem 0;
            font-size: 0.85rem;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.4rem;
        }
        .revenue-card p strong, .summary-card p strong {
            color: #343a40;
            font-weight: 600;
            flex: 0 0 40%;
        }
        .revenue-card p span, .summary-card p span {
            color: #495057;
            flex: 0 0 60%;
            text-align: right;
        }
        .chart-container {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-top: 20px;
            margin-bottom: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-top: 65px;
        }
        .modal-content h3 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: #343a40;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            position: relative;
        }
        .modal-header .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.1rem;
            color: #343a40;
            opacity: 0.7;
        }
        .modal-header .close:hover {
            opacity: 1;
        }
        .form-group label {
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
            color: #495057;
        }
        .form-control, .form-control select {
            height: calc(1.6rem + 2px);
            border-radius: 0.3rem;
            font-size: 0.8rem;
            padding: 0.3rem 0.5rem;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus, .form-control select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
        }
        .form-group select.form-control {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%23333" d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }
        .invalid-feedback {
            font-size: 0.7rem;
            color: #dc3545;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
        }
        .was-validated .form-control:valid, .form-control.is-valid {
            border-color: #28a745;
        }
        .modal-backdrop.show {
            backdrop-filter: blur(6px);
        }
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
            align-items: center;
        }
        .form-note {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.8rem;
            text-align: center;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
            align-items: center;
        }
        .form-group {
            padding-right: 5px;
            padding-left: 5px;
            margin-bottom: 0.8rem;
        }
        .table-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 8px;
            text-align: center;
        }
        .filter-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            padding: 1rem;
        }
        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .modal-content {
                padding: 0.8rem;
            }
            .form-row {
                display: flex;
                flex-wrap: wrap;
                margin-right: -5px;
                margin-left: -5px;
            }
            .form-group {
                padding-right: 5px;
                padding-left: 5px;
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 0.6rem;
            }
            .add-btn-container {
                justify-content: center;
                gap: 8px;
            }
            .btn-custom {
                font-size: 0.8rem;
                padding: 0.3rem 0.6rem;
            }
            .filter-modal .modal-content {
                max-width: 90%;
                padding: 0.8rem;
            }
            .filter-modal .modal-title {
                font-size: 1rem;
            }
            .form-group label {
                font-size: 0.75rem;
            }
            .form-control, .form-control select {
                height: calc(1.5rem + 2px);
                font-size: 0.75rem;
                padding: 0.25rem 0.4rem;
            }
            .invalid-feedback {
                font-size: 0.65rem;
            }
            .form-note {
                font-size: 0.7rem;
            }
            .chart-container {
                padding: 1rem;
            }
            .revenue-card, .summary-card {
                min-width: 100%;
                max-width: 100%;
            }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .content-wrapper.minimized {
                margin-left: 0;
            }
            .modal-content {
                padding: 0.9rem;
            }
            .add-btn-container {
                justify-content: center;
                gap: 8px;
            }
            .btn-custom {
                font-size: 0.85rem;
            }
            .filter-modal .modal-content {
                max-width: 95%;
            }
            .form-group label {
                font-size: 0.8rem;
            }
            .form-control, .form-control select {
                height: calc(1.6rem + 2px);
                font-size: 0.8rem;
                padding: 0.3rem 0.5rem;
            }
            .invalid-feedback {
                font-size: 0.7rem;
            }
            .revenue-card, .summary-card {
                min-width: 45%;
                max-width: 48%;
            }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper {
                margin-left: 200px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .modal-content {
                padding: 1rem;
            }
            .revenue-card, .summary-card {
                min-width: 40%;
                max-width: 45%;
            }
        }
        @media (min-width: 992px) {
            .filter-modal .modal-content {
                max-width: 500px;
            }
            .revenue-card, .summary-card {
                min-width: 30%;
                max-width: 35%;
            }
        }
        @media (hover: none) {
            .btn-custom:hover {
                transform: none;
            }
        }
    </style>
</head>
<body>
    <!-- Filter Revenue Modal -->
    <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="filterLabel" class="modal-title w-100 text-center">Filter Revenue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="form-note">Fill at least one field to apply a filter.</div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-12">
                            <label for="filterCenterName">Center Name</label>
                            <select id="filterCenterName" name="filterCenterName" class="form-control">
                                <option value="">All Centers</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid center.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" name="startDate" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Start Date must not be a future date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" name="endDate" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">End Date must not be before Start Date or a future date.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Clear</button>
                        <button type="submit" class="btn btn-confirm">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
            <div class="container-fluid">
                <!-- Cards Container -->
                <div class="cards-container">
                    <!-- Total Revenue Card -->
                    <div class="revenue-card">
                        <h3 class="table-title">Revenue by Center Name</h3>
                        <p><strong>Daily Revenue:</strong> <span id="totalDailyRevenue">₹0</span></p>
                        <p><strong>Weekly Revenue:</strong> <span id="totalWeeklyRevenue">₹0</span></p>
                        <p><strong>Monthly Revenue:</strong> <span id="totalMonthlyRevenue">₹0</span></p>
                        <p><strong>Yearly Revenue:</strong> <span id="totalYearlyRevenue">₹0</span></p>
                    </div>

                    <!-- Summary Card with View All Button -->
                    <div class="summary-card">
                        <h3 class="table-title"> Total Revenue </h3>
                        <!-- <p><strong>Daily Revenue:</strong> <span id="summaryDailyRevenue">₹0</span></p>
                        <p><strong>Weekly Revenue:</strong> <span id="summaryWeeklyRevenue">₹0</span></p>
                        <p><strong>Monthly Revenue:</strong> <span id="summaryMonthlyRevenue">₹0</span></p>
                        <p><strong>Yearly Revenue:</strong> <span id="summaryYearlyRevenue">₹0</span></p> -->
                        <div class="add-btn-container">
                            <button id="viewAllBtn" class="btn btn-custom">View All</button>
                        </div>
                    </div>
                     <!-- Filter Button -->
                <div class="add-btn-container">
                    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                </div>

               
                <!-- Bar Graph -->
                <!-- <div class="chart-container">
                    <div class="table-title">Revenue Breakdown</div>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div> -->
        </div>
    </div> 

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let revenueChart = null;

            // CSRF Token Setup
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            const baseUrl = '<?php echo base_url(); ?>';
            const centerUrl = baseUrl + 'Center/get_centers';
            const revenueUrl = '<?php echo base_url('revenue/get_revenues'); ?>';

            // Load centers dynamically into the dropdown
            function loadCenters() {
                $.ajax({
                    url: centerUrl,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const selectElement = $('#filterCenterName');
                        selectElement.empty();
                        selectElement.append('<option value="">All Centers</option>');
                        if (response.status === 'success' && response.data.length > 0) {
                            response.data.forEach(center => {
                                selectElement.append(`<option value="${center.center_name}">${center.center_name}</option>`);
                            });
                        } else {
                            selectElement.append('<option value="" disabled>No centers available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching centers:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load centers.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Initialize or update bar chart
            function updateChart(data) {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                const labels = ['Daily', 'Weekly', 'Monthly', 'Yearly'];
                const amounts = [
                    data.totalDaily || 0,
                    data.totalWeekly || 0,
                    data.totalMonthly || 0,
                    data.totalYearly || 0
                ];

                if (revenueChart) {
                    revenueChart.data.datasets[0].data = amounts;
                    revenueChart.update();
                } else {
                    revenueChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Revenue (₹)',
                                data: amounts,
                                backgroundColor: [
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(255, 206, 86, 0.6)',
                                    'rgba(75, 192, 192, 0.6)',
                                    'rgba(153, 102, 255, 0.6)'
                                ],
                                borderColor: [
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Revenue (₹)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Time Period'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }

            // Load revenues and update both cards and chart
            function loadRevenues(filters = {}) {
                $.ajax({
                    url: revenueUrl,
                    type: 'POST',
                    data: { ...filters, [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        let totalDaily = 0, totalWeekly = 0, totalMonthly = 0, totalYearly = 0;

                        if (!data || data.length === 0) {
                            Swal.fire({
                                icon: 'info',
                                title: 'No Data',
                                text: 'No revenue records found for the selected filters.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        } else {
                            data.forEach(item => {
                                totalDaily += parseFloat(item.daily_revenue || 0);
                                totalWeekly += parseFloat(item.weekly_revenue || 0);
                                totalMonthly += parseFloat(item.monthly_revenue || 0);
                                totalYearly += parseFloat(item.yearly_revenue || 0);
                            });
                        }

                        // Update total revenue card
                        $('#totalDailyRevenue').text(`₹${totalDaily.toFixed(0)}`);
                        $('#totalWeeklyRevenue').text(`₹${totalWeekly.toFixed(0)}`);
                        $('#totalMonthlyRevenue').text(`₹${totalMonthly.toFixed(0)}`);
                        $('#totalYearlyRevenue').text(`₹${totalYearly.toFixed(0)}`);

                        // Update summary card
                        $('#summaryDailyRevenue').text(`₹${totalDaily.toFixed(0)}`);
                        $('#summaryWeeklyRevenue').text(`₹${totalWeekly.toFixed(0)}`);
                        $('#summaryMonthlyRevenue').text(`₹${totalMonthly.toFixed(0)}`);
                        $('#summaryYearlyRevenue').text(`₹${totalYearly.toFixed(0)}`);

                        // Update bar chart
                        updateChart({
                            totalDaily,
                            totalWeekly,
                            totalMonthly,
                            totalYearly
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching revenues:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load revenues.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Update summary card when "View All" button is clicked
            function updateSummaryCard() {
                const daily = $('#totalDailyRevenue').text();
                const weekly = $('#totalWeeklyRevenue').text();
                const monthly = $('#totalMonthlyRevenue').text();
                const yearly = $('#totalYearlyRevenue').text();

                $('#summaryDailyRevenue').text(daily);
                $('#summaryWeeklyRevenue').text(weekly);
                $('#summaryMonthlyRevenue').text(monthly);
                $('#summaryYearlyRevenue').text(yearly);
            }

            // Load centers when filter modal is opened
            $('#filterModal').on('show.bs.modal', function() {
                loadCenters();
            });

            // Initial revenue load
            loadRevenues();

            // Form validation
            function validateFilterForm() {
                const form = document.getElementById('filterForm');
                form.addEventListener('submit', function(event) {
                    let isValid = true;
                    let atLeastOneFilled = false;

                    const startDateInput = form.querySelector('#startDate');
                    const endDateInput = form.querySelector('#endDate');
                    const centerNameInput = form.querySelector('#filterCenterName');
                    const today = new Date().toISOString().split('T')[0];

                    // Check if at least one field is filled
                    if (startDateInput.value || endDateInput.value || centerNameInput.value) {
                        atLeastOneFilled = true;
                    }

                    // Validate start date
                    if (startDateInput.value && startDateInput.value > today) {
                        startDateInput.setCustomValidity('Start Date must not be a future date.');
                        startDateInput.classList.add('is-invalid');
                        startDateInput.classList.remove('is-valid');
                        isValid = false;
                    } else {
                        startDateInput.setCustomValidity('');
                        startDateInput.classList.remove('is-invalid');
                        startDateInput.classList.add('is-valid');
                    }

                    // Validate end date
                    if (endDateInput.value && endDateInput.value > today) {
                        endDateInput.setCustomValidity('End Date must not be a future date.');
                        endDateInput.classList.add('is-invalid');
                        endDateInput.classList.remove('is-valid');
                        isValid = false;
                    } else if (startDateInput.value && endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                        endDateInput.setCustomValidity('End Date must not be before Start Date.');
                        endDateInput.classList.add('is-invalid');
                        endDateInput.classList.remove('is-valid');
                        isValid = false;
                    } else {
                        endDateInput.setCustomValidity('');
                        endDateInput.classList.remove('is-invalid');
                        endDateInput.classList.add('is-valid');
                    }

                    // Ensure at least one filter is applied
                    if (!atLeastOneFilled) {
                        centerNameInput.setCustomValidity('At least one filter field must be filled.');
                        centerNameInput.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        centerNameInput.setCustomValidity('');
                        centerNameInput.classList.remove('is-invalid');
                        centerNameInput.classList.add('is-valid');
                    }

                    if (!isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);

                // Real-time validation
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('input', () => {
                        const startDateInput = form.querySelector('#startDate');
                        const endDateInput = form.querySelector('#endDate');
                        const today = new Date().toISOString().split('T')[0];

                        if (input.id === 'startDate') {
                            if (input.value && input.value > today) {
                                input.setCustomValidity('Start Date must not be a future date.');
                                input.classList.add('is-invalid');
                                input.classList.remove('is-valid');
                            } else {
                                input.setCustomValidity('');
                                input.classList.remove('is-invalid');
                                input.classList.add('is-valid');
                            }
                        } else if (input.id === 'endDate') {
                            if (input.value && input.value > today) {
                                input.setCustomValidity('End Date must not be a future date.');
                                input.classList.add('is-invalid');
                                input.classList.remove('is-valid');
                            } else if (startDateInput.value && input.value && new Date(input.value) < new Date(startDateInput.value)) {
                                input.setCustomValidity('End Date must not be before Start Date.');
                                input.classList.add('is-invalid');
                                input.classList.remove('is-valid');
                            } else {
                                input.setCustomValidity('');
                                input.classList.remove('is-invalid');
                                input.classList.add('is-valid');
                            }
                        }
                    });
                });
            }

            validateFilterForm();

            // Clear filter form on modal close
            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });
                loadRevenues(); // Reload default data
            });

            // Filter form submission
            $('#filterForm').on('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                }
                event.preventDefault();

                const formData = new FormData(this);
                const filters = {
                    center_name: formData.get('filterCenterName'),
                    start_date: formData.get('startDate'),
                    end_date: formData.get('endDate'),
                    [csrfName]: csrfToken
                };

                loadRevenues(filters);
                $('#filterModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Filter applied successfully.',
                    showConfirmButton: true,
                    timer: 3000
                });
            });

            // View All button click handler
            $('#viewAllBtn').on('click', function() {
                updateSummaryCard();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Revenue summary updated.',
                    showConfirmButton: true,
                    timer: 2000
                });
            });
        });
    </script>
</body>
</html>