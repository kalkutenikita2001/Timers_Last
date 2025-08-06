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

        /* Option Buttons Styles */
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

        /* Table Styles */
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

        /* Button Styles */
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

        /* Modal Styles */
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

        /* Form Styles for Add and Filter Modals */
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

        /* Confirmation Modal Styles */
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

        /* View Modal Enhanced Styles */
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
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-top: none;
        }

        /* Add/Edit Revenue Modal Styles */
        .add-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            padding: 1rem;
        }

        /* Filter Revenue Modal Styles */
        .filter-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            padding: 1rem;
        }

        /* Responsive Design */
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
            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 90%;
                padding: 0.8rem;
            }

            .confirmation-modal .modal-title,
            .add-modal .modal-title,
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
            .add-modal .modal-content,
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

            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 500px;
            }
        }

        /* Touch device hover fix */
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
                    <button class="active" data-option="centerwise">Centerwise Expenses</button>
                    <button data-option="totalrevenue">Total Revenue</button>
                </div>

                <!-- Add Button and Filter -->
                <div class="add-btn-container">
                    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <button class="btn btn-custom" data-toggle="modal" data-target="#expenseModal">
                        <i class="fas fa-plus mr-1"></i> Add Revenue
                    </button>
                </div>

                <!-- Revenue Table -->
                <div class="table-container">
                    <div class="table-title">Revenue Records</div>
                    <table class="table table-bordered table-hover" id="expenseTable">
                        <thead class="thead-dark1">
                            <tr>
                                <th data-tooltip="Title of the revenue entry">Title</th>
                                <th data-tooltip="Revenue for the specific day">Daily Revenue(₹)</th>
                                <th data-tooltip="Revenue for the week">Weekly Revenue(₹)</th>
                                <th data-tooltip="Revenue for the month">Monthly Revenue(₹)</th>
                                <th data-tooltip="Revenue for the year">Yearly Revenue(₹)</th>
                                <th data-tooltip="View, Approve, or Reject the record">Action</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTableBody">
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Revenue Modal -->
    <div class="modal fade add-modal" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="expenseLabel" class="modal-title w-100 text-center">Add Revenue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" novalidate>
                    <input type="hidden" id="revenueId" name="revenueId">
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required
                                   pattern="[A-Za-z\s]+" maxlength="50" title="Title should contain only letters and spaces, max 50 characters">
                            <div class="invalid-feedback">Title is required, letters and spaces only, max 50 characters.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="center_name">Center Name <span class="text-danger">*</span></label>
                            <select id="center_name" name="center_name" class="form-control" required>
                                <option value="">Select Center</option>
                                <option value="ABC">ABC</option>
                                <option value="XYZ">XYZ</option>
                                <option value="PQR">PQR</option>
                                <option value="LMN">LMN</option>
                            </select>
                            <div class="invalid-feedback">Center Name is required.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Date is required and must not be a future date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="dailyRevenue">Daily Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="dailyRevenue" name="dailyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Daily Revenue must be greater than 0">
                            <div class="invalid-feedback">Daily Revenue is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="weeklyRevenue">Weekly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="weeklyRevenue" name="weeklyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Weekly Revenue must be greater than 0">
                            <div class="invalid-feedback">Weekly Revenue is required and must be greater than 0.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="monthlyRevenue">Monthly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="monthlyRevenue" name="monthlyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Monthly Revenue must be greater than 0">
                            <div class="invalid-feedback">Monthly Revenue is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="yearlyRevenue">Yearly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="yearlyRevenue" name="yearlyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Yearly Revenue must be greater than 0">
                            <div class="invalid-feedback">Yearly Revenue is required and must be greater than 0.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="2" maxlength="200"></textarea>
                            <div class="invalid-feedback">Notes must be less than 200 characters.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-confirm">Save</button>
                    </div>
                </form>
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
                        <p><strong>Title:</strong> <span id="viewTitle"></span></p>
                        <p><strong>Center Name:</strong> <span id="viewCenterName"></span></p>
                        <p><strong>Date:</strong> <span id="viewDate"></span></p>
                        <p><strong>Daily Revenue:</strong> <span id="viewDailyRevenue"></span></p>
                        <p><strong>Weekly Revenue:</strong> <span id="viewWeeklyRevenue"></span></p>
                        <p><strong>Monthly Revenue:</strong> <span id="viewMonthlyRevenue"></span></p>
                        <p><strong>Yearly Revenue:</strong> <span id="viewYearlyRevenue"></span></p>
                        <p><strong>Notes:</strong> <span id="viewNotes"></span></p>
                        <p id="statusField"><strong>Status:</strong> <span id="viewStatus"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-confirm edit-btn" data-dismiss="modal" data-toggle="modal" data-target="#expenseModal">Edit</button>
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
                        <div class="form-group col-md-6">
                            <label for="filterTitle">Title</label>
                            <input type="text" id="filterTitle" name="filterTitle" class="form-control"
                                   pattern="[A-Za-z\s]+" maxlength="50" title="Title should contain only letters and spaces, max 50 characters">
                            <div class="invalid-feedback">Title must contain only letters and spaces, max 50 characters.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="filterCenterName">Center Name</label>
                            <select id="filterCenterName" name="filterCenterName" class="form-control">
                                <option value="">All Centers</option>
                                <option value="ABC">ABC</option>
                                <option value="XYZ">XYZ</option>
                                <option value="PQR">PQR</option>
                                <option value="LMN">LMN</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" name="startDate" class="form-control"
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Start Date must not be a future date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" name="endDate" class="form-control"
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">End Date must not be before Start Date or a future date.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="minDailyRevenue">Min Daily Revenue(₹)</label>
                            <input type="number" id="minDailyRevenue" name="minDailyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Daily Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Daily Revenue must be 0 or greater.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="maxDailyRevenue">Max Daily Revenue(₹)</label>
                            <input type="number" id="maxDailyRevenue" name="maxDailyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Daily Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Daily Revenue must be 0 or greater and not less than Min Daily Revenue.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="minWeeklyRevenue">Min Weekly Revenue(₹)</label>
                            <input type="number" id="minWeeklyRevenue" name="minWeeklyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Weekly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Weekly Revenue must be 0 or greater.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="maxWeeklyRevenue">Max Weekly Revenue(₹)</label>
                            <input type="number" id="maxWeeklyRevenue" name="maxWeeklyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Weekly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Weekly Revenue must be 0 or greater and not less than Min Weekly Revenue.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="minMonthlyRevenue">Min Monthly Revenue(₹)</label>
                            <input type="number" id="minMonthlyRevenue" name="minMonthlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Monthly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Monthly Revenue must be 0 or greater.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="maxMonthlyRevenue">Max Monthly Revenue(₹)</label>
                            <input type="number" id="maxMonthlyRevenue" name="maxMonthlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Monthly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Monthly Revenue must be 0 or greater and not less than Min Monthly Revenue.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="minYearlyRevenue">Min Yearly Revenue(₹)</label>
                            <input type="number" id="minYearlyRevenue" name="minYearlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Yearly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Yearly Revenue must be 0 or greater.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="maxYearlyRevenue">Max Yearly Revenue(₹)</label>
                            <input type="number" id="maxYearlyRevenue" name="maxYearlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Yearly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Yearly Revenue must be 0 or greater and not less than Min Yearly Revenue.</div>
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
            let editingRow = null;
            let currentRevenueId = null;
            let currentAction = null;
            let currentStatus = null; // Track current status for View modal

            // CSRF Token Setup
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';

            // Form validation function
            function validateForm(formId) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(event) {
                    let isValid = true;
                    let atLeastOneFilled = false;

                    // Custom validation for expenseForm
                    if (formId === 'expenseForm') {
                        const titleInput = form.querySelector('#title');
                        const centerNameInput = form.querySelector('#center_name');
                        const dateInput = form.querySelector('#date');
                        const dailyRevenueInput = form.querySelector('#dailyRevenue');
                        const weeklyRevenueInput = form.querySelector('#weeklyRevenue');
                        const monthlyRevenueInput = form.querySelector('#monthlyRevenue');
                        const yearlyRevenueInput = form.querySelector('#yearlyRevenue');
                        const notesInput = form.querySelector('#notes');

                        // Title validation
                        if (!titleInput.value.trim()) {
                            titleInput.setCustomValidity('Title is required.');
                            isValid = false;
                        } else if (!/^[A-Za-z\s]+$/.test(titleInput.value)) {
                            titleInput.setCustomValidity('Title must contain only letters and spaces.');
                            isValid = false;
                        } else if (titleInput.value.length > 50) {
                            titleInput.setCustomValidity('Title must be 50 characters or less.');
                            isValid = false;
                        } else {
                            titleInput.setCustomValidity('');
                        }

                        // Center Name validation
                        if (!centerNameInput.value) {
                            centerNameInput.setCustomValidity('Center Name is required.');
                            isValid = false;
                        } else {
                            centerNameInput.setCustomValidity('');
                        }

                        // Date validation
                        const today = new Date().toISOString().split('T')[0];
                        if (!dateInput.value) {
                            dateInput.setCustomValidity('Date is required.');
                            isValid = false;
                        } else if (dateInput.value > today) {
                            dateInput.setCustomValidity('Date must not be a future date.');
                            isValid = false;
                        } else {
                            dateInput.setCustomValidity('');
                        }

                        // Revenue validation
                        const revenueFields = [
                            { input: dailyRevenueInput, name: 'Daily Revenue' },
                            { input: weeklyRevenueInput, name: 'Weekly Revenue' },
                            { input: monthlyRevenueInput, name: 'Monthly Revenue' },
                            { input: yearlyRevenueInput, name: 'Yearly Revenue' }
                        ];

                        revenueFields.forEach(field => {
                            const value = parseFloat(field.input.value);
                            if (!field.input.value || isNaN(value)) {
                                field.input.setCustomValidity(`${field.name} is required.`);
                                isValid = false;
                            } else if (value <= 0) {
                                field.input.setCustomValidity(`${field.name} must be greater than 0.`);
                                isValid = false;
                            } else {
                                field.input.setCustomValidity('');
                            }
                        });

                        // Notes validation
                        if (notesInput.value.length > 200) {
                            notesInput.setCustomValidity('Notes must be less than 200 characters.');
                            isValid = false;
                        } else {
                            notesInput.setCustomValidity('');
                        }
                    }

                    // Custom validation for filterForm
                    if (formId === 'filterForm') {
                        const inputs = form.querySelectorAll('input, select');
                        inputs.forEach(input => {
                            if (input.value.trim() !== '') {
                                atLeastOneFilled = true;
                            }
                        });

                        // Title validation
                        const titleInput = form.querySelector('#filterTitle');
                        if (titleInput.value && !/^[A-Za-z\s]+$/.test(titleInput.value)) {
                            titleInput.setCustomValidity('Title must contain only letters and spaces.');
                            isValid = false;
                        } else if (titleInput.value.length > 50) {
                            titleInput.setCustomValidity('Title must be 50 characters or less.');
                            isValid = false;
                        } else {
                            titleInput.setCustomValidity('');
                        }

                        // Date validation
                        const startDateInput = form.querySelector('#startDate');
                        const endDateInput = form.querySelector('#endDate');
                        const today = new Date().toISOString().split('T')[0];
                        if (startDateInput.value && startDateInput.value > today) {
                            startDateInput.setCustomValidity('Start Date must not be a future date.');
                            isValid = false;
                        } else {
                            startDateInput.setCustomValidity('');
                        }
                        if (endDateInput.value && endDateInput.value > today) {
                            endDateInput.setCustomValidity('End Date must not be a future date.');
                            isValid = false;
                        } else if (startDateInput.value && endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                            endDateInput.setCustomValidity('End Date must not be before Start Date.');
                            isValid = false;
                        } else {
                            endDateInput.setCustomValidity('');
                        }

                        // Revenue range validation
                        const revenueFields = [
                            { min: 'minDailyRevenue', max: 'maxDailyRevenue', name: 'Daily Revenue' },
                            { min: 'minWeeklyRevenue', max: 'maxWeeklyRevenue', name: 'Weekly Revenue' },
                            { min: 'minMonthlyRevenue', max: 'maxMonthlyRevenue', name: 'Monthly Revenue' },
                            { min: 'minYearlyRevenue', max: 'maxYearlyRevenue', name: 'Yearly Revenue' }
                        ];

                        revenueFields.forEach(field => {
                            const minInput = form.querySelector(`#${field.min}`);
                            const maxInput = form.querySelector(`#${field.max}`);
                            const minValue = parseFloat(minInput.value) || 0;
                            const maxValue = parseFloat(maxInput.value) || 0;
                            if (minInput.value && minValue < 0) {
                                minInput.setCustomValidity(`${field.name} must be 0 or greater.`);
                                isValid = false;
                            } else {
                                minInput.setCustomValidity('');
                            }
                            if (maxInput.value && maxValue < 0) {
                                maxInput.setCustomValidity(`${field.name} must be 0 or greater.`);
                                isValid = false;
                            } else if (minInput.value && maxInput.value && maxValue < minValue) {
                                maxInput.setCustomValidity(`Max ${field.name} must not be less than Min ${field.name}.`);
                                isValid = false;
                            } else {
                                maxInput.setCustomValidity('');
                            }
                        });

                        if (!atLeastOneFilled) {
                            form.querySelector('#filterTitle').setCustomValidity('At least one filter field must be filled.');
                            isValid = false;
                        } else {
                            form.querySelector('#filterTitle').setCustomValidity('');
                        }
                    }

                    if (!isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);

                // Real-time validation for expenseForm
                if (formId === 'expenseForm') {
                    const inputs = form.querySelectorAll('input, textarea, select');
                    inputs.forEach(input => {
                        input.addEventListener('input', () => {
                            if (input.id === 'title') {
                                if (!input.value.trim()) {
                                    input.setCustomValidity('Title is required.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else if (!/^[A-Za-z\s]+$/.test(input.value)) {
                                    input.setCustomValidity('Title must contain only letters and spaces.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else if (input.value.length > 50) {
                                    input.setCustomValidity('Title must be 50 characters or less.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else {
                                    input.setCustomValidity('');
                                    input.classList.remove('is-invalid');
                                    input.classList.add('is-valid');
                                }
                            } else if (input.id === 'center_name') {
                                if (!input.value) {
                                    input.setCustomValidity('Center Name is required.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else {
                                    input.setCustomValidity('');
                                    input.classList.remove('is-invalid');
                                    input.classList.add('is-valid');
                                }
                            } else if (input.id === 'date') {
                                const today = new Date().toISOString().split('T')[0];
                                if (!input.value) {
                                    input.setCustomValidity('Date is required.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else if (input.value > today) {
                                    input.setCustomValidity('Date must not be a future date.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else {
                                    input.setCustomValidity('');
                                    input.classList.remove('is-invalid');
                                    input.classList.add('is-valid');
                                }
                            } else if (['dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue'].includes(input.id)) {
                                const value = parseFloat(input.value);
                                const fieldName = input.id.replace(/([A-Z])/g, ' $1');
                                if (!input.value || isNaN(value)) {
                                    input.setCustomValidity(`${fieldName} is required.`);
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else if (value <= 0) {
                                    input.setCustomValidity(`${fieldName} must be greater than 0.`);
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else {
                                    input.setCustomValidity('');
                                    input.classList.remove('is-invalid');
                                    input.classList.add('is-valid');
                                }
                            } else if (input.id === 'notes') {
                                if (input.value.length > 200) {
                                    input.setCustomValidity('Notes must be less than 200 characters.');
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

                // Real-time validation for filterForm
                if (formId === 'filterForm') {
                    const startDateInput = form.querySelector('#startDate');
                    const endDateInput = form.querySelector('#endDate');
                    const revenueFields = [
                        'minDailyRevenue', 'maxDailyRevenue',
                        'minWeeklyRevenue', 'maxWeeklyRevenue',
                        'minMonthlyRevenue', 'maxMonthlyRevenue',
                        'minYearlyRevenue', 'maxYearlyRevenue'
                    ];
                    const titleInput = form.querySelector('#filterTitle');

                    titleInput.addEventListener('input', () => {
                        if (titleInput.value && !/^[A-Za-z\s]+$/.test(titleInput.value)) {
                            titleInput.setCustomValidity('Title must contain only letters and spaces.');
                            titleInput.classList.add('is-invalid');
                            titleInput.classList.remove('is-valid');
                        } else if (titleInput.value.length > 50) {
                            titleInput.setCustomValidity('Title must be 50 characters or less.');
                            titleInput.classList.add('is-invalid');
                            titleInput.classList.remove('is-valid');
                        } else {
                            titleInput.setCustomValidity('');
                            titleInput.classList.remove('is-invalid');
                            titleInput.classList.add('is-valid');
                        }
                    });

                    startDateInput.addEventListener('input', validateDates);
                    endDateInput.addEventListener('input', validateDates);

                    revenueFields.forEach(field => {
                        form.querySelector(`#${field}`).addEventListener('input', () => validateRevenue(field));
                    });

                    function validateDates() {
                        const today = new Date().toISOString().split('T')[0];
                        if (startDateInput.value && startDateInput.value > today) {
                            startDateInput.setCustomValidity('Start Date must not be a future date.');
                            startDateInput.classList.add('is-invalid');
                            startDateInput.classList.remove('is-valid');
                        } else {
                            startDateInput.setCustomValidity('');
                            startDateInput.classList.remove('is-invalid');
                            startDateInput.classList.add('is-valid');
                        }
                        if (endDateInput.value && endDateInput.value > today) {
                            endDateInput.setCustomValidity('End Date must not be a future date.');
                            endDateInput.classList.add('is-invalid');
                            endDateInput.classList.remove('is-valid');
                        } else if (startDateInput.value && endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                            endDateInput.setCustomValidity('End Date must not be before Start Date.');
                            endDateInput.classList.add('is-invalid');
                            endDateInput.classList.remove('is-valid');
                        } else {
                            endDateInput.setCustomValidity('');
                            endDateInput.classList.remove('is-invalid');
                            endDateInput.classList.add('is-valid');
                        }
                    }

                    function validateRevenue(fieldId) {
                        const field = form.querySelector(`#${fieldId}`);
                        const pairId = fieldId.startsWith('min') 
                            ? fieldId.replace('min', 'max') 
                            : fieldId.replace('max', 'min');
                        const pair = form.querySelector(`#${pairId}`);
                        const fieldValue = parseFloat(field.value) || 0;
                        const pairValue = parseFloat(pair.value) || 0;

                        if (field.value && fieldValue < 0) {
                            field.setCustomValidity(`${fieldId.replace(/([A-Z])/g, ' $1')} must be 0 or greater.`);
                            field.classList.add('is-invalid');
                            field.classList.remove('is-valid');
                        } else if (fieldId.startsWith('max') && field.value && pair.value && fieldValue < pairValue) {
                            field.setCustomValidity(`${fieldId.replace(/([A-Z])/g, ' $1')} must not be less than ${pairId.replace(/([A-Z])/g, ' $1')}.`);
                            field.classList.add('is-invalid');
                            field.classList.remove('is-valid');
                        } else {
                            field.setCustomValidity('');
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        }
                    }
                }
            }

            // Validate forms
            ['expenseForm', 'filterForm'].forEach(validateForm);

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

            // Load revenues
            function loadRevenues(option = 'centerwise') {
                const url = option === 'totalrevenue' ? '<?php echo base_url('revenue/get_total_revenue'); ?>' : '<?php echo base_url('revenue/get_revenues'); ?>';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#expenseTableBody');
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
                            const row = `
                                <tr class="${rowClass}" style="${rowStyle}">
                                    <td>${item.title}</td>
                                    <td>${parseFloat(item.daily_revenue).toFixed(0)}</td>
                                    <td>${parseFloat(item.weekly_revenue).toFixed(0)}</td>
                                    <td>${parseFloat(item.monthly_revenue).toFixed(0)}</td>
                                    <td>${parseFloat(item.yearly_revenue).toFixed(0)}</td>
                                    <td>
                                        <i class="fas fa-info-circle action-icon info-icon" title="View Details" data-toggle="modal" data-target="#viewModal" 
                                           data-id="${item.id}" data-title="${item.title}" data-center="${item.center_name}" 
                                           data-date="${item.date}" data-daily="${item.daily_revenue}" 
                                           data-weekly="${item.weekly_revenue}" data-monthly="${item.monthly_revenue}" 
                                           data-yearly="${item.yearly_revenue}" data-notes="${item.notes}" 
                                           data-status="${item.status}"></i>
                                        <button class="action-btn approve-btn" title="Approve" data-id="${item.id}" 
                                           data-title="${item.title}" ${approveDisabled}>Approve</button>
                                        <button class="action-btn reject-btn" title="Reject" data-id="${item.id}" 
                                           data-title="${item.title}" ${rejectDisabled}>Reject</button>
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

            // Initial load
            loadRevenues();

            // Expense form submission
            $('#expenseForm').on('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                }
                event.preventDefault();

                const formData = new FormData(this);
                const data = {
                    [csrfName]: csrfToken,
                    title: formData.get('title'),
                    center_name: formData.get('center_name'),
                    date: formData.get('date'),
                    daily_revenue: parseFloat(formData.get('dailyRevenue')).toFixed(2),
                    weekly_revenue: parseFloat(formData.get('weeklyRevenue')).toFixed(2),
                    monthly_revenue: parseFloat(formData.get('monthlyRevenue')).toFixed(2),
                    yearly_revenue: parseFloat(formData.get('yearlyRevenue')).toFixed(2),
                    notes: formData.get('notes') || 'N/A'
                };
                const url = formData.get('revenueId') ? '<?php echo base_url('revenue/update_revenue'); ?>' : '<?php echo base_url('revenue/add_revenue'); ?>';
                if (formData.get('revenueId')) {
                    data.id = formData.get('revenueId');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: response.status === 'success' ? 'success' : 'error',
                            title: response.status === 'success' ? 'Success' : 'Error',
                            text: response.message,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        if (response.status === 'success') {
                            $('#expenseModal').modal('hide');
                            $('#expenseForm')[0].reset();
                            $('#expenseForm').removeClass('was-validated');
                            $('#expenseLabel').text('Add Revenue');
                            $('#revenueId').val('');
                            loadRevenues($('.option-buttons button.active').data('option'));
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error saving revenue.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            });

            // View modal population
            $('#viewModal').on('show.bs.modal', function(event) {
                const icon = $(event.relatedTarget);
                currentRevenueId = icon.data('id');
                const title = icon.data('title');
                const center = icon.data('center');
                const date = icon.data('date');
                const daily = icon.data('daily');
                const weekly = icon.data('weekly');
                const monthly = icon.data('monthly');
                const yearly = icon.data('yearly');
                const notes = icon.data('notes');
                currentStatus = icon.data('status'); // Update currentStatus

                const modal = $(this);
                modal.find('#viewLabel').text(`Revenue Details - ${title}`);
                modal.find('#viewTitle').text(title);
                modal.find('#viewCenterName').text(center);
                modal.find('#viewDate').text(date);
                modal.find('#viewDailyRevenue').text(`₹${parseFloat(daily).toFixed(0)}`);
                modal.find('#viewWeeklyRevenue').text(`₹${parseFloat(weekly).toFixed(0)}`);
                modal.find('#viewMonthlyRevenue').text(`₹${parseFloat(monthly).toFixed(0)}`);
                modal.find('#viewYearlyRevenue').text(`₹${parseFloat(yearly).toFixed(0)}`);
                modal.find('#viewNotes').text(notes || 'N/A');
                const statusField = modal.find('#statusField');
                statusField.removeClass('status-approved status-rejected');
                if (currentStatus === 'approved') {
                    statusField.addClass('status-approved');
                } else if (currentStatus === 'rejected') {
                    statusField.addClass('status-rejected');
                }
                modal.find('#viewStatus').text(currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1));
            });

            // Edit button in view modal
            $(document).on('click', '.edit-btn', function() {
                $.ajax({
                    url: '<?php echo base_url('revenue/get_revenue'); ?>/' + currentRevenueId,
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#expenseLabel').text('Edit Revenue');
                            $('#revenueId').val(data.id);
                            $('#title').val(data.title);
                            $('#center_name').val(data.center_name);
                            $('#date').val(data.date);
                            $('#dailyRevenue').val(data.daily_revenue);
                            $('#weeklyRevenue').val(data.weekly_revenue);
                            $('#monthlyRevenue').val(data.monthly_revenue);
                            $('#yearlyRevenue').val(data.yearly_revenue);
                            $('#notes').val(data.notes);
                            // Trigger validation to show initial valid state
                            $('#expenseForm').find('input, select, textarea').trigger('input');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading revenue data.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
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
                const data = {
                    [csrfName]: csrfToken,
                    title: formData.get('filterTitle'),
                    center_name: formData.get('filterCenterName'),
                    start_date: formData.get('startDate'),
                    end_date: formData.get('endDate'),
                    min_daily_revenue: formData.get('minDailyRevenue') || 0,
                    max_daily_revenue: formData.get('maxDailyRevenue') || '',
                    min_weekly_revenue: formData.get('minWeeklyRevenue') || 0,
                    max_weekly_revenue: formData.get('maxWeeklyRevenue') || '',
                    min_monthly_revenue: formData.get('minMonthlyRevenue') || 0,
                    max_monthly_revenue: formData.get('maxMonthlyRevenue') || '',
                    min_yearly_revenue: formData.get('minYearlyRevenue') || 0,
                    max_yearly_revenue: formData.get('maxYearlyRevenue') || ''
                };

                $.ajax({
                    url: '<?php echo base_url('revenue/get_revenues'); ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#expenseTableBody');
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="6" class="text-center">No records match the filter criteria.</td></tr>');
                        } else {
                            data.forEach(item => {
                                const rowClass = item.status === 'approved' ? 'approved' : item.status === 'rejected' ? 'rejected' : '';
                                const rowStyle = item.status === 'approved' ? 'background-color: #d4edda;' : item.status === 'rejected' ? 'background-color: #f8d7da;' : '';
                                const approveDisabled = item.status !== 'pending' ? 'disabled' : '';
                                const rejectDisabled = item.status !== 'pending' ? 'disabled' : '';
                                const row = `
                                    <tr class="${rowClass}" style="${rowStyle}">
                                        <td>${item.title}</td>
                                        <td>${parseFloat(item.daily_revenue).toFixed(0)}</td>
                                        <td>${parseFloat(item.weekly_revenue).toFixed(0)}</td>
                                        <td>${parseFloat(item.monthly_revenue).toFixed(0)}</td>
                                        <td>${parseFloat(item.yearly_revenue).toFixed(0)}</td>
                                        <td>
                                            <i class="fas fa-info-circle action-icon info-icon" title="View Details" data-toggle="modal" data-target="#viewModal" 
                                               data-id="${item.id}" data-title="${item.title}" data-center="${item.center_name}" 
                                               data-date="${item.date}" data-daily="${item.daily_revenue}" 
                                               data-weekly="${item.weekly_revenue}" data-monthly="${item.monthly_revenue}" 
                                               data-yearly="${item.yearly_revenue}" data-notes="${item.notes}" 
                                               data-status="${item.status}"></i>
                                            <button class="action-btn approve-btn" title="Approve" data-id="${item.id}" 
                                               data-title="${item.title}" ${approveDisabled}>Approve</button>
                                            <button class="action-btn reject-btn" title="Reject" data-id="${item.id}" 
                                               data-title="${item.title}" ${rejectDisabled}>Reject</button>
                                        </td>
                                    </tr>
                                    <tr class="horizontal-line"><td colspan="6"></td></tr>
                                `;
                                tableBody.append(row);
                            });
                        }
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
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error applying filter.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            });

            // Show confirmation modal for approve/reject
            $(document).on('click', '.approve-btn, .reject-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const title = $(this).data('title');
                const row = $(this).closest('tr');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Already Processed',
                        text: `Revenue "${title}" has already been processed.`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                    return;
                }
                currentRevenueId = id;
                currentAction = $(this).hasClass('approve-btn') ? 'approve' : 'reject';
                const actionText = currentAction === 'approve' ? 'Approve' : 'Reject';
                $('#confirmActionLabel').text(`${actionText} Revenue`);
                $('#confirmMessage').text(`Are you sure you want to ${actionText.toLowerCase()} the revenue "${title}"?`);
                $('#confirmActionModal').modal('show');
            });

            // Handle confirmation modal confirm button
            $('#confirmActionBtn').on('click', function() {
                const url = currentAction === 'approve' 
                    ? '<?php echo base_url('revenue/approve_revenue'); ?>/' + currentRevenueId 
                    : '<?php echo base_url('revenue/reject_revenue'); ?>/' + currentRevenueId;
                const title = $(`.action-btn[data-id="${currentRevenueId}"]`).data('title');
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
                            // Update data-status attribute in the view icon
                            row.find('.info-icon').data('status', currentStatus);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: `Revenue "${title}" ${currentAction}d at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
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

            // Reset expense form when opening
            $('#expenseModal').on('show.bs.modal', function() {
                $('#expenseForm')[0].reset();
                $('#expenseForm').removeClass('was-validated');
                $('#expenseForm').find('input, select, textarea').removeClass('is-valid is-invalid');
                $('#expenseLabel').text('Add Revenue');
                $('#revenueId').val('');
            });
        });
    </script>
</body>
</html>