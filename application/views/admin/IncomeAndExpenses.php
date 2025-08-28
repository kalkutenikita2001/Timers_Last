<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        /* Existing styles remain unchanged */
        body {
            background-color: #f4f6f8 !important;
            margin: 0;
            font-family: 'Montserrat', serif !important;
            overflow-x: hidden;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 1.5rem;
            transition: all 0.3s ease-in-out;
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
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .option-buttons button {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
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
            margin: 1rem 0;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
        }
        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
            color: #343a40;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            border-bottom: 2px solid #dee2e6;
            padding: 0.75rem;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            vertical-align: middle;
            position: relative;
        }
        .table thead th:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            background: #343a40;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 10;
            top: -2rem;
            left: 50%;
            transform: translateX(-50%);
        }
        .table td {
            padding: 0.5rem;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.875rem;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .table tbody tr.approved {
            background-color: #d4edda;
        }
        .table tbody tr.rejected {
            background-color: #f8d7da;
        }
        .action-icon {
            font-size: 1.1rem;
            margin: 0 0.3rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .action-icon.info-icon {
            color: #17a2b8;
        }
        .action-btn {
            font-size: 0.75rem;
            margin: 0 0.2rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.2rem;
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
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        .modal-content {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            position: relative;
        }
        .modal-header .close {
            position: absolute;
            right: 0.75rem;
            top: 0.75rem;
            font-size: 1.25rem;
            color: #343a40;
            opacity: 0.7;
        }
        .modal-header .close:hover {
            opacity: 1;
        }
        .modal-header h3 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            color: #343a40;
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
        .form-note {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.8rem;
            text-align: center;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.25rem;
            align-items: center;
        }
        .form-group {
            padding: 0 0.25rem;
            margin-bottom: 0.75rem;
            flex: 1 1 100%;
        }
        .confirmation-modal .modal-content {
            max-width: 90%;
            margin: 1rem auto;
        }
        .confirmation-modal .modal-title {
            font-size: 1.1rem;
            color: #343a40;
            font-weight: 600;
        }
        .confirmation-modal .modal-body {
            text-align: center;
            font-size: 0.95rem;
            color: #495057;
            padding: 1rem;
        }
        .confirmation-modal .modal-footer {
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            border-top: none;
        }
        .btn-confirm {
            background: #28a745;
            color: white;
            border-radius: 0.2rem;
            padding: 0.4rem 1rem;
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
            border-radius: 0.2rem;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        .view-modal .modal-content {
            max-width: 90%;
            margin: 1rem auto;
        }
        .receipt-card {
            background: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .receipt-card p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
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
            padding: 1rem;
            border-top: none;
        }
        /* New styles for folder-like structure in filter modal */
        .filter-folder {
            border: 1px solid #ced4da;
            border-radius: 0.3rem;
            margin-bottom: 0.75rem;
            background: #f8f9fa;
        }
        .filter-folder-header {
            padding: 0.5rem 1rem;
            background: #e9ecef;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-folder-header:hover {
            background: #dee2e6;
        }
        .filter-folder-body {
            padding: 1rem;
        }
        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 0.75rem !important;
            }
            .content {
                margin-top: 50px;
            }
            .table-container {
                margin: 0.5rem 0;
            }
            .table {
                font-size: 0.75rem;
            }
            .table thead th {
                padding: 0.5rem;
                font-size: 0.75rem;
            }
            .table td {
                padding: 0.4rem;
                font-size: 0.75rem;
            }
            .action-icon {
                font-size: 1rem;
                margin: 0 0.2rem;
            }
            .action-btn {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
            .option-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            .option-buttons button {
                width: 100%;
                font-size: 0.8rem;
                padding: 0.5rem;
            }
            .add-btn-container {
                justify-content: flex-end;
                gap: 0.5rem;
            }
            .btn-custom {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
            .modal-content {
                padding: 0.75rem;
                margin: 0.5rem;
            }
            .modal-header h3 {
                font-size: 1rem;
            }
            .form-group label {
                font-size: 0.75rem;
            }
            .form-control, .form-control select {
                height: calc(1.5rem + 2px);
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
            .invalid-feedback {
                font-size: 0.65rem;
            }
            .form-note {
                font-size: 0.7rem;
            }
            .confirmation-modal .modal-content,
            .view-modal .modal-content,
            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 95%;
            }
            .confirmation-modal .modal-title {
                font-size: 1rem;
            }
            .confirmation-modal .modal-body {
                font-size: 0.85rem;
            }
            .btn-confirm, .btn-cancel {
                padding: 0.3rem 0.8rem;
                font-size: 0.75rem;
            }
            .receipt-card {
                padding: 0.75rem;
            }
            .receipt-card p {
                font-size: 0.8rem;
            }
            .filter-folder-header {
                font-size: 0.8rem;
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
                font-size: 0.8rem;
            }
            .table thead th {
                padding: 0.6rem;
                font-size: 0.8rem;
            }
            .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            .action-btn {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
            .option-buttons {
                gap: 0.5rem;
            }
            .btn-custom {
                font-size: 0.85rem;
            }
            .modal-content {
                padding: 0.85rem;
            }
            .confirmation-modal .modal-content,
            .view-modal .modal-content,
            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 90%;
            }
            .form-group label {
                font-size: 0.8rem;
            }
            .form-control, .form-control select {
                height: calc(1.6rem + 2px);
                font-size: 0.8rem;
            }
            .invalid-feedback {
                font-size: 0.7rem;
            }
        }
        @media (min-width: 769px) {
            .form-group {
                flex: 0 0 50%;
                max-width: 50%;
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
            .filter-folder-header:hover {
                background: #e9ecef;
            }
        }
    </style>
</head>
<body>
    <!-- Confirmation Modal -->
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

    <!-- Sidebar and Navbar -->
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <?php $this->load->view('admin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
            <div class="container-fluid">
                <!-- Option Buttons -->
                <div class="option-buttons">
                    <button class="active" data-option="income_expenses">Income & Expenses</button>
                    <button data-option="summary">Summary</button>
                </div>

                <!-- Add and Filter Buttons -->
                <div class="add-btn-container">
                    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                        <i class="bi bi-funnel me-2"></i> Filter
                    </button>
                    <button class="btn btn-custom" data-toggle="modal" data-target="#expenseModal">
                        <i class="fas fa-plus mr-1"></i> Add Income/Expense
                    </button>
                </div>

                <!-- Income/Expenses Table -->
                <div class="table-container" id="incomeExpensesTable">
                    <div class="table-title">Income and Expense Records</div>
                    <table class="table table-bordered table-hover" id="expenseTable">
                        <thead>
                            <tr>
                                <th data-tooltip="Title of the entry">Title</th>
                                <th data-tooltip="Center Name">Center Name</th>
                                <th data-tooltip="Type of transaction">Type</th>
                                <th data-tooltip="Date of the transaction">Date</th>
                                <th data-tooltip="Amount of the transaction">Amount(₹)</th>
                                <th data-tooltip="Description of the transaction">Description</th>
                                <th data-tooltip="View, Approve, or Reject the record">Action</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTableBody">
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>

                <!-- Summary Table -->
                <div class="table-container" id="summaryTable" style="display: none;">
                    <div class="table-title">Financial Summary by Center</div>
                    <table class="table table-bordered table-hover" id="summaryTableContent">
                        <thead>
                            <tr>
                                <th data-tooltip="Center Name">Center Name</th>
                                <th data-tooltip="Total Income">Total Income(₹)</th>
                                <th data-tooltip="Total Expense">Total Expense(₹)</th>
                                <th data-tooltip="Balance (Income - Expense)">Balance(₹)</th>
                            </tr>
                        </thead>
                        <tbody id="summaryTableBody">
                            <!-- Populated via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade add-modal" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="expenseLabel" class="modal-title w-100 text-center">Add Income/Expense</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" novalidate>
                    <input type="hidden" id="expenseId" name="expenseId">
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required
                                   pattern="[A-Za-z\s]+" maxlength="50" title="Title should contain only letters and spaces, max 50 characters">
                            <div class="invalid-feedback">Title is required, letters and spaces only, max 50 characters.</div>
                        </div>
                        <div class="form-group">
                            <label for="center_name">Center Name <span class="text-danger">*</span></label>
                            <select id="center_name" name="center_name" class="form-control" required>
                                <option value="">Select Center</option>
                                <!-- Populated via AJAX -->
                            </select>
                            <div class="invalid-feedback">Center Name is required.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group">
                            <label for="type">Type <span class="text-danger">*</span></label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                            <div class="invalid-feedback">Type is required.</div>
                        </div>
                        <div class="form-group">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Date is required and must not be a future date.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group">
                            <label for="amount">Amount(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="amount" name="amount" class="form-control" required
                                   min="0.01" step="0.01" title="Amount must be greater than 0">
                            <div class="invalid-feedback">Amount is required and must be greater than 0.</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="3" maxlength="200"></textarea>
                            <div class="invalid-feedback">Description must be less than 200 characters.</div>
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

    <!-- View Modal -->
    <div class="modal fade view-modal" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="viewLabel" class="modal-title w-100 text-center">Income/Expense Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="receipt-card">
                        <p><strong>Title:</strong> <span id="viewTitle"></span></p>
                        <p><strong>Center Name:</strong> <span id="viewCenterName"></span></p>
                        <p><strong>Type:</strong> <span id="viewType"></span></p>
                        <p><strong>Date:</strong> <span id="viewDate"></span></p>
                        <p><strong>Amount:</strong> <span id="viewAmount"></span></p>
                        <p><strong>Description:</strong> <span id="viewDescription"></span></p>
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

    <!-- Filter Modal -->
    <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="filterLabel" class="modal-title w-100 text-center">Filter Income/Expenses</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="form-note">Fill at least one field to apply a filter.</div>
                    <div class="filter-folder">
                        <div class="filter-folder-header" data-toggle="collapse" data-target="#filterFields" aria-expanded="true" aria-controls="filterFields">
                            Filter Options
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div id="filterFields" class="collapse show">
                            <div class="filter-folder-body">
                                <div class="form-row d-flex align-items-center">
                                    <div class="form-group">
                                        <label for="filterTitle">Title</label>
                                        <input type="text" id="filterTitle" name="filterTitle" class="form-control"
                                               pattern="[A-Za-z\s]+" maxlength="50" title="Title should contain only letters and spaces, max 50 characters">
                                        <div class="invalid-feedback">Title must contain only letters and spaces, max 50 characters.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="filterCenterName">Center Name</label>
                                        <select id="filterCenterName" name="filterCenterName" class="form-control">
                                            <option value="">All Centers</option>
                                            <!-- Populated via AJAX -->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row d-flex align-items-center">
                                    <div class="form-group">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" id="startDate" name="startDate" class="form-control"
                                               max="<?php echo date('Y-m-d'); ?>">
                                        <div class="invalid-feedback">Start Date must not be a future date.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="endDate">End Date</label>
                                        <input type="date" id="endDate" name="endDate" class="form-control"
                                               max="<?php echo date('Y-m-d'); ?>">
                                        <div class="invalid-feedback">End Date must not be before Start Date or a future date.</div>
                                    </div>
                                </div>
                                <div class="form-row d-flex align-items-center">
                                    <div class="form-group">
                                        <label for="minAmount">Min Amount(₹)</label>
                                        <input type="number" id="minAmount" name="minAmount" class="form-control"
                                               min="0" step="0.01" title="Min Amount must be 0 or greater">
                                        <div class="invalid-feedback">Min Amount must be 0 or greater.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="maxAmount">Max Amount(₹)</label>
                                        <input type="number" id="maxAmount" name="maxAmount" class="form-control"
                                               min="0" step="0.01" title="Max Amount must be 0 or greater">
                                        <div class="invalid-feedback">Max Amount must be 0 or greater and not less than Min Amount.</div>
                                    </div>
                                </div>
                            </div>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let editingRow = null;
            let currentExpenseId = null;
            let currentAction = null;
            let currentStatus = null;
            let currentView = 'income_expenses';

            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            const baseUrl = '<?php echo base_url(); ?>';

            // Function to fetch centers and populate dropdowns
            function loadCenters() {
                $.ajax({
                    url: baseUrl + 'center/get_centers',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const centers = response.data;
                            const centerSelect = $('#center_name');
                            const filterCenterSelect = $('#filterCenterName');

                            // Clear existing options except the default ones
                            centerSelect.find('option:not(:first)').remove();
                            filterCenterSelect.find('option:not(:first)').remove();

                            // Populate dropdowns
                            centers.forEach(center => {
                                centerSelect.append(`<option value="${center.center_name}">${center.center_name}</option>`);
                                filterCenterSelect.append(`<option value="${center.center_name}">${center.center_name}</option>`);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load centers.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error fetching centers.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Call loadCenters when the page loads and when modals are opened
            loadCenters();

            $('#expenseModal, #filterModal').on('show.bs.modal', function() {
                loadCenters();
            });

            function validateForm(formId) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(event) {
                    let isValid = true;
                    let atLeastOneFilled = false;

                    if (formId === 'expenseForm') {
                        const titleInput = form.querySelector('#title');
                        const centerNameInput = form.querySelector('#center_name');
                        const typeInput = form.querySelector('#type');
                        const dateInput = form.querySelector('#date');
                        const amountInput = form.querySelector('#amount');
                        const descriptionInput = form.querySelector('#description');

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

                        if (!centerNameInput.value) {
                            centerNameInput.setCustomValidity('Center Name is required.');
                            isValid = false;
                        } else {
                            centerNameInput.setCustomValidity('');
                        }

                        if (!typeInput.value) {
                            typeInput.setCustomValidity('Type is required.');
                            isValid = false;
                        } else {
                            typeInput.setCustomValidity('');
                        }

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

                        const amountValue = parseFloat(amountInput.value);
                        if (!amountInput.value || isNaN(amountValue)) {
                            amountInput.setCustomValidity('Amount is required.');
                            isValid = false;
                        } else if (amountValue <= 0) {
                            amountInput.setCustomValidity('Amount must be greater than 0.');
                            isValid = false;
                        } else {
                            amountInput.setCustomValidity('');
                        }

                        if (descriptionInput.value.length > 200) {
                            descriptionInput.setCustomValidity('Description must be less than 200 characters.');
                            isValid = false;
                        } else {
                            descriptionInput.setCustomValidity('');
                        }
                    }

                    if (formId === 'filterForm') {
                        const inputs = form.querySelectorAll('input, select');
                        inputs.forEach(input => {
                            if (input.value.trim() !== '') {
                                atLeastOneFilled = true;
                            }
                        });

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

                        const minAmountInput = form.querySelector('#minAmount');
                        const maxAmountInput = form.querySelector('#maxAmount');
                        const minAmountValue = parseFloat(minAmountInput.value) || 0;
                        const maxAmountValue = parseFloat(maxAmountInput.value) || 0;
                        if (minAmountInput.value && minAmountValue < 0) {
                            minAmountInput.setCustomValidity('Min Amount must be 0 or greater.');
                            isValid = false;
                        } else {
                            minAmountInput.setCustomValidity('');
                        }
                        if (maxAmountInput.value && maxAmountValue < 0) {
                            maxAmountInput.setCustomValidity('Max Amount must be 0 or greater.');
                            isValid = false;
                        } else if (minAmountInput.value && maxAmountInput.value && maxAmountValue < minAmountValue) {
                            maxAmountInput.setCustomValidity('Max Amount must not be less than Min Amount.');
                            isValid = false;
                        } else {
                            maxAmountInput.setCustomValidity('');
                        }

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
                            } else if (input.id === 'type') {
                                if (!input.value) {
                                    input.setCustomValidity('Type is required.');
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
                            } else if (input.id === 'amount') {
                                const value = parseFloat(input.value);
                                if (!input.value || isNaN(value)) {
                                    input.setCustomValidity('Amount is required.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else if (value <= 0) {
                                    input.setCustomValidity('Amount must be greater than 0.');
                                    input.classList.add('is-invalid');
                                    input.classList.remove('is-valid');
                                } else {
                                    input.setCustomValidity('');
                                    input.classList.remove('is-invalid');
                                    input.classList.add('is-valid');
                                }
                            } else if (input.id === 'description') {
                                if (input.value.length > 200) {
                                    input.setCustomValidity('Description must be less than 200 characters.');
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

                if (formId === 'filterForm') {
                    const startDateInput = form.querySelector('#startDate');
                    const endDateInput = form.querySelector('#endDate');
                    const titleInput = form.querySelector('#filterTitle');
                    const minAmountInput = form.querySelector('#minAmount');
                    const maxAmountInput = form.querySelector('#maxAmount');

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
                    minAmountInput.addEventListener('input', validateAmount);
                    maxAmountInput.addEventListener('input', validateAmount);

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

                    function validateAmount() {
                        const minValue = parseFloat(minAmountInput.value) || 0;
                        const maxValue = parseFloat(maxAmountInput.value) || 0;
                        if (minAmountInput.value && minValue < 0) {
                            minAmountInput.setCustomValidity('Min Amount must be 0 or greater.');
                            minAmountInput.classList.add('is-invalid');
                            minAmountInput.classList.remove('is-valid');
                        } else {
                            minAmountInput.setCustomValidity('');
                            minAmountInput.classList.remove('is-invalid');
                            minAmountInput.classList.add('is-valid');
                        }
                        if (maxAmountInput.value && maxValue < 0) {
                            maxAmountInput.setCustomValidity('Max Amount must be 0 or greater.');
                            maxAmountInput.classList.add('is-invalid');
                            maxAmountInput.classList.remove('is-valid');
                        } else if (minAmountInput.value && maxAmountInput.value && maxValue < minValue) {
                            maxAmountInput.setCustomValidity('Max Amount must not be less than Min Amount.');
                            maxAmountInput.classList.add('is-invalid');
                            maxAmountInput.classList.remove('is-valid');
                        } else {
                            maxAmountInput.setCustomValidity('');
                            maxAmountInput.classList.remove('is-invalid');
                            maxAmountInput.classList.add('is-valid');
                        }
                    }
                }
            }

            ['expenseForm', 'filterForm'].forEach(validateForm);

            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });
            });

            function loadIncomeExpenses() {
                $.ajax({
                    url: '<?php echo base_url('admincontroller/income_expenses/get_income_expenses'); ?>',
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#expenseTableBody');
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
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
                                    <td>${item.center_name}</td>
                                    <td>${item.type.charAt(0).toUpperCase() + item.type.slice(1)}</td>
                                    <td>${item.date}</td>
                                    <td>₹${parseFloat(item.amount).toFixed(2)}</td>
                                    <td>${item.description}</td>
                                    <td>
                                        <i class="fas fa-info-circle action-icon info-icon" title="View Details" data-toggle="modal" data-target="#viewModal"
                                           data-id="${item.id}" data-title="${item.title}" data-center="${item.center_name}"
                                           data-type="${item.type}" data-date="${item.date}" data-amount="${item.amount}"
                                           data-description="${item.description}" data-status="${item.status}"></i>
                                        <button class="action-btn approve-btn" title="Approve" data-id="${item.id}"
                                           data-title="${item.title}" ${approveDisabled}>Approve</button>
                                        <button class="action-btn reject-btn" title="Reject" data-id="${item.id}"
                                           data-title="${item.title}" ${rejectDisabled}>Reject</button>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load records.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            function loadSummary() {
                $.ajax({
                    url: '<?php echo base_url('admincontroller/income_expenses/get_summary'); ?>',
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#summaryTableBody');
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="4" class="text-center">No summary data available.</td></tr>');
                            return;
                        }
                        data.forEach(item => {
                            const row = `
                                <tr>
                                    <td>${item.center_name}</td>
                                    <td>₹${parseFloat(item.total_income).toFixed(2)}</td>
                                    <td>₹${parseFloat(item.total_expense).toFixed(2)}</td>
                                    <td>₹${parseFloat(item.balance).toFixed(2)}</td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load summary.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            function toggleView(view) {
                if (view === 'income_expenses') {
                    $('#incomeExpensesTable').show();
                    $('#summaryTable').hide();
                    loadIncomeExpenses();
                } else {
                    $('#incomeExpensesTable').hide();
                    $('#summaryTable').show();
                    loadSummary();
                }
                currentView = view;
            }

            loadIncomeExpenses();

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
                    type: formData.get('type'),
                    date: formData.get('date'),
                    amount: parseFloat(formData.get('amount')).toFixed(2),
                    description: formData.get('description') || 'N/A'
                };
                const url = formData.get('expenseId') ? '<?php echo base_url('admincontroller/income_expenses/update_income_expense'); ?>' : '<?php echo base_url('admincontroller/income_expenses/add_income_expense'); ?>';
                if (formData.get('expenseId')) {
                    data.id = formData.get('expenseId');
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
                            $('#expenseLabel').text('Add Income/Expense');
                            $('#expenseId').val('');
                            if (currentView === 'income_expenses') {
                                loadIncomeExpenses();
                            } else {
                                loadSummary();
                            }
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error saving record.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            });

            $('#viewModal').on('show.bs.modal', function(event) {
                const icon = $(event.relatedTarget);
                currentExpenseId = icon.data('id');
                const title = icon.data('title');
                const center = icon.data('center');
                const type = icon.data('type');
                const date = icon.data('date');
                const amount = icon.data('amount');
                const description = icon.data('description');
                currentStatus = icon.data('status');

                const modal = $(this);
                modal.find('#viewLabel').text(`Income/Expense Details - ${title}`);
                modal.find('#viewTitle').text(title);
                modal.find('#viewCenterName').text(center);
                modal.find('#viewType').text(type.charAt(0).toUpperCase() + type.slice(1));
                modal.find('#viewDate').text(date);
                modal.find('#viewAmount').text(`₹${parseFloat(amount).toFixed(2)}`);
                modal.find('#viewDescription').text(description || 'N/A');
                const statusField = modal.find('#statusField');
                statusField.removeClass('status-approved status-rejected');
                if (currentStatus === 'approved') {
                    statusField.addClass('status-approved');
                } else if (currentStatus === 'rejected') {
                    statusField.addClass('status-rejected');
                }
                modal.find('#viewStatus').text(currentStatus.charAt(0).toUpperCase() + currentStatus.slice(1));
            });

            $(document).on('click', '.edit-btn', function() {
                $.ajax({
                    url: '<?php echo base_url('admincontroller/income_expenses/get_income_expense'); ?>/' + currentExpenseId,
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const data = response.data;
                            $('#expenseLabel').text('Edit Income/Expense');
                            $('#expenseId').val(data.id);
                            $('#title').val(data.title);
                            $('#center_name').val(data.center_name);
                            $('#type').val(data.type);
                            $('#date').val(data.date);
                            $('#amount').val(data.amount);
                            $('#description').val(data.description);
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
                            text: 'Error loading record data.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            });

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
                    min_amount: formData.get('minAmount') || 0,
                    max_amount: formData.get('maxAmount') || ''
                };

                const url = currentView === 'income_expenses'
                    ? '<?php echo base_url('admincontroller/income_expenses/get_income_expenses'); ?>'
                    : '<?php echo base_url('admincontroller/income_expenses/get_summary'); ?>';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        if (currentView === 'income_expenses') {
                            const tableBody = $('#expenseTableBody');
                            tableBody.empty();
                            if (data.length === 0) {
                                tableBody.append('<tr><td colspan="7" class="text-center">No records match the filter criteria.</td></tr>');
                            } else {
                                data.forEach(item => {
                                    const rowClass = item.status === 'approved' ? 'approved' : item.status === 'rejected' ? 'rejected' : '';
                                    const rowStyle = item.status === 'approved' ? 'background-color: #d4edda;' : item.status === 'rejected' ? 'background-color: #f8d7da;' : '';
                                    const approveDisabled = item.status !== 'pending' ? 'disabled' : '';
                                    const rejectDisabled = item.status !== 'pending' ? 'disabled' : '';
                                    const row = `
                                        <tr class="${rowClass}" style="${rowStyle}">
                                            <td>${item.title}</td>
                                            <td>${item.center_name}</td>
                                            <td>${item.type.charAt(0).toUpperCase() + item.type.slice(1)}</td>
                                            <td>${item.date}</td>
                                            <td>₹${parseFloat(item.amount).toFixed(2)}</td>
                                            <td>${item.description}</td>
                                            <td>
                                                <i class="fas fa-info-circle action-icon info-icon" title="View Details" data-toggle="modal" data-target="#viewModal"
                                                   data-id="${item.id}" data-title="${item.title}" data-center="${item.center_name}"
                                                   data-type="${item.type}" data-date="${item.date}" data-amount="${item.amount}"
                                                   data-description="${item.description}" data-status="${item.status}"></i>
                                                <button class="action-btn approve-btn" title="Approve" data-id="${item.id}"
                                                   data-title="${item.title}" ${approveDisabled}>Approve</button>
                                                <button class="action-btn reject-btn" title="Reject" data-id="${item.id}"
                                                   data-title="${item.title}" ${rejectDisabled}>Reject</button>
                                            </td>
                                        </tr>
                                    `;
                                    tableBody.append(row);
                                });
                            }
                        } else {
                            const tableBody = $('#summaryTableBody');
                            tableBody.empty();
                            if (data.length === 0) {
                                tableBody.append('<tr><td colspan="4" class="text-center">No summary data available.</td></tr>');
                            } else {
                                data.forEach(item => {
                                    const row = `
                                        <tr>
                                            <td>${item.center_name}</td>
                                            <td>₹${parseFloat(item.total_income).toFixed(2)}</td>
                                            <td>₹${parseFloat(item.total_expense).toFixed(2)}</td>
                                            <td>₹${parseFloat(item.balance).toFixed(2)}</td>
                                        </tr>
                                    `;
                                    tableBody.append(row);
                                });
                            }
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

            $(document).on('click', '.approve-btn, .reject-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const title = $(this).data('title');
                const row = $(this).closest('tr');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Already Processed',
                        text: `Record "${title}" has already been processed.`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                    return;
                }
                currentExpenseId = id;
                currentAction = $(this).hasClass('approve-btn') ? 'approve' : 'reject';
                const actionText = currentAction === 'approve' ? 'Approve' : 'Reject';
                $('#confirmActionLabel').text(`${actionText} Income/Expense`);
                $('#confirmMessage').text(`Are you sure you want to ${actionText.toLowerCase()} the record "${title}"?`);
                $('#confirmActionModal').modal('show');
            });

            $('#confirmActionBtn').on('click', function() {
                const url = currentAction === 'approve'
                    ? '<?php echo base_url('admincontroller/income_expenses/approve_income_expense'); ?>/' + currentExpenseId
                    : '<?php echo base_url('admincontroller/income_expenses/reject_income_expense'); ?>/' + currentExpenseId;
                const title = $(`.action-btn[data-id="${currentExpenseId}"]`).data('title');
                const row = $(`.action-btn[data-id="${currentExpenseId}"]`).closest('tr');

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
                                text: `Record "${title}" ${currentAction}d at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            if (currentView === 'summary') {
                                loadSummary();
                            }
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
                            text: `Error ${currentAction}ing record.`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        $('#confirmActionModal').modal('hide');
                    }
                });
            });

            $('.option-buttons button').on('click', function() {
                const option = $(this).data('option');
                $('.option-buttons button').removeClass('active');
                $(this).addClass('active');
                toggleView(option);
            });

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

            $(window).on('resize', function() {
                if ($(window).width() <= 576) {
                    $('#sidebar').removeClass('minimized');
                    $('.navbar').removeClass('sidebar-minimized');
                    $('#contentWrapper').removeClass('minimized');
                }
            });

            $('#expenseModal').on('show.bs.modal', function() {
                $('#expenseForm')[0].reset();
                $('#expenseForm').removeClass('was-validated');
                $('#expenseForm').find('input, select, textarea').removeClass('is-valid is-invalid');
                $('#expenseLabel').text('Add Income/Expense');
                $('#expenseId').val('');
                $('#date').val(new Date().toISOString().split('T')[0]);
            });
        });
    </script>
</body>
</html>