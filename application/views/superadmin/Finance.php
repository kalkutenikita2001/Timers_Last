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
        .option-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .option-buttons button {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        .option-buttons button.active {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }
        .option-buttons button:hover {
            background: #333;
            color: #fff;
        }
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
            position: relative;
        }
        .table thead th:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            background: #343a40;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            white-space: nowrap;
            z-index: 10;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.9rem;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .table .horizontal-line td {
            border: none;
            background-color: #dee2e6;
            height: 1px;
            padding: 0;
        }
        .action-icon {
            font-size: 1.2rem;
            margin: 0 0.5rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .action-icon.info-icon {
            color: #17a2b8;
        }
        .action-btn {
            font-size: 0.85rem;
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .action-btn.approve-btn {
            background-color: #28a745;
            color: white;
            border: none;
        }
        .action-btn.reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .action-btn:hover {
            filter: brightness(90%);
        }
        .action-btn:disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 1rem;
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
            font-size: 1.25rem;
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
            font-size: 1.25rem;
            color: #343a40;
            opacity: 0.7;
        }
        .modal-header .close:hover {
            opacity: 1;
        }
        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.3rem;
            color: #495057;
        }
        .form-control, .form-control select {
            height: calc(1.8rem + 2px);
            border-radius: 0.3rem;
            font-size: 0.85rem;
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
            font-size: 0.75rem;
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
            font-size: 0.8rem;
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
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 10px;
        }
        .confirmation-modal .modal-content {
            max-width: 400px;
            margin: auto;
            border-radius: 0.75rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }
        .confirmation-modal .modal-header {
            border-bottom: none;
            padding: 0.5rem 1.5rem;
        }
        .confirmation-modal .modal-title {
            font-size: 1.25rem;
            color: #343a40;
            font-weight: 600;
        }
        .confirmation-modal .modal-body {
            text-align: center;
            font-size: 1rem;
            color: #495057;
            padding: 1rem 1.5rem;
        }
        .confirmation-modal .modal-footer {
            justify-content: center;
            gap: 15px;
            padding: 1rem 1.5rem;
            border-top: none;
        }
        .btn-confirm {
            background: #28a745;
            color: white;
            border-radius: 0.25rem;
            padding: 0.4rem 1.2rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
            border-radius: 0.25rem;
            padding: 0.4rem 1.2rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        .view-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }
        .view-modal .modal-body {
            padding: 1.5rem;
        }
        .receipt-card {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .receipt-card p {
            margin: 0.5rem 0;
            font-size: 0.95rem;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        .receipt-card p strong {
            color: #343a40;
            font-weight: 600;
            flex: 0 0 40%;
        }
        .receipt-card p span {
            color: #495057;
            flex: 0 0 60%;
            text-align: right;
        }
        .receipt-card p.status-approved span {
            color: #28a745;
            font-weight: 600;
        }
        .receipt-card p.status-rejected span {
            color: #dc3545;
            font-weight: 600;
        }
        .view-modal .modal-footer {
            justify-content: center;
            padding: 1rem 1.5rem;
            border-top: none;
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
            .table {
                font-size: 0.8rem;
            }
            .action-icon, .action-btn {
                margin: 0.1rem;
                font-size: 0.8rem;
                padding: 0.2rem 0.4rem;
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
            .option-buttons {
                flex-direction: column;
                gap: 10px;
            }
            .option-buttons button {
                width: 100%;
                font-size: 12px;
                padding: 8px 20px;
            }
            .add-btn-container {
                justify-content: center;
                gap: 10px;
            }
            .btn-custom {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
            .confirmation-modal .modal-content,
            .view-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 90%;
                padding: 0.8rem;
            }
            .confirmation-modal .modal-title,
            .filter-modal .modal-title {
                font-size: 1.1rem;
            }
            .confirmation-modal .modal-body {
                font-size: 0.9rem;
            }
            .btn-confirm, .btn-cancel {
                padding: 0.3rem 1rem;
                font-size: 0.8rem;
            }
            .receipt-card {
                padding: 1rem;
            }
            .receipt-card p {
                font-size: 0.85rem;
            }
            .form-group label {
                font-size: 0.8rem;
            }
            .form-control, .form-control select {
                height: calc(1.6rem + 2px);
                font-size: 0.8rem;
                padding: 0.25rem 0.4rem;
            }
            .invalid-feedback {
                font-size: 0.7rem;
            }
            .form-note {
                font-size: 0.75rem;
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
            .table {
                font-size: 0.85rem;
            }
            .modal-content {
                padding: 0.9rem;
            }
            .add-btn-container {
                justify-content: center;
                gap: 8px;
            }
            .option-buttons {
                gap: 8px;
            }
            .btn-custom {
                font-size: 0.9rem;
            }
            .confirmation-modal .modal-content,
            .view-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 95%;
            }
            .form-group label {
                font-size: 0.85rem;
            }
            .form-control, .form-control select {
                height: calc(1.7rem + 2px);
                font-size: 0.85rem;
                padding: 0.3rem 0.5rem;
            }
            .invalid-feedback {
                font-size: 0.75rem;
            }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper {
                margin-left: 200px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .table {
                font-size: 0.9rem;
            }
            .modal-content {
                padding: 1rem;
            }
        }
        @media (min-width: 992px) {
            .confirmation-modal .modal-content {
                max-width: 400px;
            }
            .view-modal .modal-content {
                max-width: 500px;
            }
            .filter-modal .modal-content {
                max-width: 500px;
            }
        }
        @media (hover: none) {
            .action-icon:hover,
            .action-btn:hover,
            .btn-custom:hover,
            .option-buttons button:hover,
            .btn-confirm:hover,
            .btn-cancel:hover {
                transform: none;
            }
            .table thead th:hover::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Confirmation Modal for Approve/Reject -->
    <div class="modal fade confirmation-modal" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="confirmActionLabel" class="modal-title w-100 text-center"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-confirm" id="confirmActionBtn">Confirm</button>
                </div>
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
                <!-- Option Buttons -->
                <div class="option-buttons">
                    <button class="active" data-option="centerwise">Centerwise Revenue</button>
                    <button data-option="totalrevenue">Total Revenue</button>
                </div>

                <!-- Filter Button -->
                <div class="add-btn-container">
                    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                </div>

                <!-- Revenue Table -->
                <div class="table-container">
                    <div class="table-title">Revenue Records</div>
                    <table class="table table-bordered table-hover" id="revenueTable">
                        <thead class="thead-dark1">
                            <tr>
                                <th data-tooltip="Name of the center">Center Name</th>
                                <th data-tooltip="Revenue for the specific day">Daily Revenue(₹)</th>
                                <th data-tooltip="Revenue for the week">Weekly Revenue(₹)</th>
                                <th data-tooltip="Revenue for the month">Monthly Revenue(₹)</th>
                                <th data-tooltip="Revenue for the year">Yearly Revenue(₹)</th>
                                <th data-tooltip="View, Approve, or Reject the record">Action</th>
                            </tr>
                        </thead>
                        <tbody id="revenueTableBody">
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- View Revenue Modal -->
    <div class="modal fade view-modal" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="viewLabel" class="modal-title w-100 text-center">Revenue Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="receipt-card">
                        <p><strong>Center Name:</strong> <span id="viewCenterName"></span></p>
                        <p><strong>Date:</strong> <span id="viewDate"></span></p>
                        <p><strong>Daily Revenue:</strong> <span id="viewDailyRevenue"></span></p>
                        <p><strong>Weekly Revenue:</strong> <span id="viewWeeklyRevenue"></span></p>
                        <p><strong>Monthly Revenue:</strong> <span id="viewMonthlyRevenue"></span></p>
                        <p><strong>Yearly Revenue:</strong> <span id="viewYearlyRevenue"></span></p>
                        <p id="statusField"><strong>Status:</strong> <span id="viewStatus"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
                                <!-- Populated dynamically via AJAX -->
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

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let currentRevenueId = null;
            let currentAction = null;
            let currentStatus = null;

            // CSRF Token Setup
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            const baseUrl = '<?php echo base_url(); ?>';
            const centerUrl = baseUrl + 'center/get_centers';

            // Function to format date for display
            function formatDateForDisplay(dateStr) {
                if (!dateStr) return 'N/A';
                const [year, month, day] = dateStr.split('-');
                return `${day}/${month}/${year}`;
            }

            // Function to load centers dynamically
            function loadCenters() {
                $.ajax({
                    url: centerUrl,
                    method: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            const centers = response.data;
                            const selectElement = $('#filterCenterName');
                            selectElement.empty();
                            selectElement.append('<option value="">All Centers</option>');
                            if (centers.length === 0) {
                                selectElement.append('<option value="" disabled>No centers available</option>');
                            } else {
                                centers.forEach(center => {
                                    selectElement.append(`<option value="${center.center_name}">${center.center_name}</option>`);
                                });
                            }
                        } else {
                            console.error('Error fetching centers:', response.message);
                            selectElement.append('<option value="" disabled>Error loading centers</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        selectElement.append('<option value="" disabled>Error loading centers</option>');
                    }
                });
            }

            // Load revenues
            function loadRevenues(option = 'centerwise', filters = {}) {
                const url = option === 'totalrevenue' ? '<?php echo base_url('revenue/get_total_revenue'); ?>' : '<?php echo base_url('revenue/get_revenues'); ?>';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { ...filters, [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#revenueTableBody');
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="6" class="text-center">No records found.</td></tr>');
                            return;
                        }
                        data.forEach(item => {
                            const rowClass = item.status === 'approved' ? 'approved' : item.status === 'rejected' ? 'rejected' : '';
                            const rowStyle = item.status === 'approved' ? 'background-color: #d4edda;' : item.status === 'rejected' ? 'background-color: #f8d7da;' : '';
                            const approveDisabled = item.status !== 'pending' ? 'disabled' : '';
                            const rejectDisabled = item.status !== 'pending' ? 'disabled' : '';
                            const formattedDate = formatDateForDisplay(item.date);
                            const row = `
                                <tr class="${rowClass}" style="${rowStyle}">
                                    <td>${item.center_name}</td>
                                    <td>₹${parseFloat(item.daily_revenue).toFixed(0)}</td>
                                    <td>₹${parseFloat(item.weekly_revenue).toFixed(0)}</td>
                                    <td>₹${parseFloat(item.monthly_revenue).toFixed(0)}</td>
                                    <td>₹${parseFloat(item.yearly_revenue).toFixed(0)}</td>
                                    <td>
                                        <i class="fas fa-info-circle action-icon info-icon" title="View Details" data-toggle="modal" data-target="#viewModal" 
                                           data-id="${item.id}" data-center="${item.center_name}" data-date="${item.date}" 
                                           data-daily="${item.daily_revenue}" data-weekly="${item.weekly_revenue}" 
                                           data-monthly="${item.monthly_revenue}" data-yearly="${item.yearly_revenue}" 
                                           data-status="${item.status}"></i>
                                        <button class="action-btn approve-btn" title="Approve" data-id="${item.id}" 
                                           data-center="${item.center_name}" ${approveDisabled}>Approve</button>
                                        <button class="action-btn reject-btn" title="Reject" data-id="${item.id}" 
                                           data-center="${item.center_name}" ${rejectDisabled}>Reject</button>
                                    </td>
                                </tr>
                                <tr class="horizontal-line"><td colspan="6"></td></tr>
                            `;
                            tableBody.append(row);
                        });
                    },
                    error: function() {
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

            // Load centers when filter modal is shown
            $('#filterModal').on('show.bs.modal', function() {
                loadCenters();
            });

            // Initial load
            loadRevenues();

            // Filter form validation
            function validateFilterForm() {
                const form = document.getElementById('filterForm');
                form.addEventListener('submit', function(event) {
                    let isValid = true;
                    let atLeastOneFilled = false;

                    const startDateInput = form.querySelector('#startDate');
                    const endDateInput = form.querySelector('#endDate');
                    const centerNameInput = form.querySelector('#filterCenterName');
                    const today = new Date().toISOString().split('T')[0];

                    if (startDateInput.value || endDateInput.value || centerNameInput.value) {
                        atLeastOneFilled = true;
                    }

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

                    if (!atLeastOneFilled) {
                        centerNameInput.setCustomValidity('At least one filter field must be filled.');
                        isValid = false;
                    } else {
                        centerNameInput.setCustomValidity('');
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
                    [csrfName]: csrfToken,
                    center_name: formData.get('filterCenterName'),
                    start_date: formData.get('startDate'),
                    end_date: formData.get('endDate')
                };

                loadRevenues($('.option-buttons button.active').data('option'), filters);
                $('#filterModal').modal('hide');
                $('#filterForm')[0].reset();
                $('#filterForm').removeClass('was-validated');
                $('#filterForm').find('input, select').trigger('input');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Filter applied successfully.',
                    showConfirmButton: true,
                    timer: 3000
                });
            });

            // View modal population
            $('#viewModal').on('show.bs.modal', function(event) {
                const icon = $(event.relatedTarget);
                currentRevenueId = icon.data('id');
                const center = icon.data('center');
                const date = formatDateForDisplay(icon.data('date'));
                const daily = icon.data('daily');
                const weekly = icon.data('weekly');
                const monthly = icon.data('monthly');
                const yearly = icon.data('yearly');
                currentStatus = icon.data('status');

                const modal = $(this);
                modal.find('#viewLabel').text(`Revenue Details - ${center}`);
                modal.find('#viewCenterName').text(center);
                modal.find('#viewDate').text(date);
                modal.find('#viewDailyRevenue').text(`₹${parseFloat(daily).toFixed(0)}`);
                modal.find('#viewWeeklyRevenue').text(`₹${parseFloat(weekly).toFixed(0)}`);
                modal.find('#viewMonthlyRevenue').text(`₹${parseFloat(monthly).toFixed(0)}`);
                modal.find('#viewYearlyRevenue').text(`₹${parseFloat(yearly).toFixed(0)}`);
                const statusField = modal.find('#statusField');
                statusField.removeClass('status-approved status-rejected');
                if (currentStatus === 'approved') {
                    statusField.addClass('status-approved');
                } else if (currentStatus === 'rejected') {
                    statusField.addClass('status-rejected');
                }
                modal.find('#viewStatus').text(currentStatus ? currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1) : 'Pending');
            });

            // Show confirmation modal for approve/reject
            $(document).on('click', '.approve-btn, .reject-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const center = $(this).data('center');
                const row = $(this).closest('tr');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Already Processed',
                        text: `Revenue for "${center}" has already been processed.`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                    return;
                }
                currentRevenueId = id;
                currentAction = $(this).hasClass('approve-btn') ? 'approve' : 'reject';
                const actionText = currentAction === 'approve' ? 'Approve' : 'Reject';
                $('#confirmActionLabel').text(`${actionText} Revenue`);
                $('#confirmMessage').text(`Are you sure you want to ${actionText.toLowerCase()} the revenue for "${center}"?`);
                $('#confirmActionModal').modal('show');
            });

            // Handle confirmation modal confirm button
            $('#confirmActionBtn').on('click', function() {
                const url = currentAction === 'approve' 
                    ? '<?php echo base_url('revenue/approve_revenue'); ?>/' + currentRevenueId 
                    : '<?php echo base_url('revenue/reject_revenue'); ?>/' + currentRevenueId;
                const center = $(`.action-btn[data-id="${currentRevenueId}"]`).data('center');
                const row = $(`.action-btn[data-id="${currentRevenueId}"]`).closest('tr');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            currentStatus = currentAction === 'approve' ? 'approved' : 'rejected';
                            row.addClass(currentStatus).css('backgroundColor', currentStatus === 'approved' ? '#d4edda' : '#f8d7da');
                            row.find('.approve-btn').prop('disabled', true);
                            row.find('.reject-btn').prop('disabled', true);
                            row.find('.info-icon').data('status', currentStatus);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: `Revenue for "${center}" ${currentAction}d at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                        $('#confirmActionModal').modal('hide');
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: `Error ${currentAction}ing revenue.`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        $('#confirmActionModal').modal('hide');
                    }
                });
            });

            // Option switching functionality
            $('.option-buttons button').on('click', function() {
                const option = $(this).data('option');
                $('.option-buttons button').removeClass('active');
                $(this).addClass('active');
                loadRevenues(option);
            });

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

            // Handle window resize
            $(window).on('resize', function() {
                if ($(window).width() <= 576) {
                    $('#sidebar').removeClass('minimized');
                    $('.navbar').removeClass('sidebar-minimized');
                    $('#contentWrapper').removeClass('minimized');
                }
            });
        });
    </script>
</body>
</html>