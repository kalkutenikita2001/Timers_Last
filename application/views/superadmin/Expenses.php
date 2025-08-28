<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>Expenses Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', serif !important;
            background-color: #f4f6f8 !important;
            color: #333;
            min-height: 100vh;
            margin: 0;
            padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
            overflow-x: hidden;
        }

        .content-wrapper {
            margin-left: 15rem;
            padding: 1.5rem;
            transition: all 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
        }

        .content-wrapper.minimized {
            margin-left: 4rem;
        }

        .container {
            max-width: calc(1200px + 2vw);
            margin: 4rem auto 0;
            width: 100%;
        }

        /* Option Buttons Styles */
        .option-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .option-buttons button {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 1.5rem;
            padding: 10px 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            touch-action: manipulation;
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

        /* Add Button, Filter, and Center Select */
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
        }

        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        .center-select-container {
            margin-bottom: 1.5rem;
        }

        .center-select-container select {
            height: calc(1.8rem + 2px);
            border-radius: 0.3rem;
            font-size: 0.85rem;
            padding: 0.3rem 0.5rem;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: 100%;
            max-width: 300px;
        }

        .center-select-container select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
        }

        /* Table Styles */
        .table-container {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
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
            white-space: nowrap;
            text-align: center;
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            padding: 1rem;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
            color: #000;
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

        .action-btn {
            font-size: clamp(0.8rem, 2vw, 0.85rem);
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .action-btn.thumbs-up {
            background-color: #28a745;
            color: white;
        }

        .action-btn.cross {
            background-color: #dc3545;
            color: white;
        }

        .action-btn:hover {
            filter: brightness(90%);
        }

        .action-btn:disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
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

        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            position: relative;
        }

        .modal-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            color: #343a40;
            width: 100%;
        }

        .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            font-size: 1.25rem;
            color: #343a40;
            opacity: 0.7;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close:hover {
            opacity: 1;
            background: #e0e0e0;
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

        .form-group textarea {
            resize: vertical;
            min-height: 3rem;
        }

        .invalid-feedback {
            font-size: 0.75rem;
            color: #dc3545;
        }

        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            background: #ffeaea;
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
            margin-right: -5px;
            margin-left: -5px;
            align-items: center;
        }

        .form-group {
            padding-right: 5px;
            padding-left: 5px;
            margin-bottom: 0.8rem;
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

        /* Add/Edit Expense Modal Styles */
        .add-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            padding: 1rem;
        }

        /* Filter Expense Modal Styles */
        .filter-modal .modal-content {
            max-width: 500px;
            margin: auto;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            padding: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 320px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 0.5rem !important;
            }

            .container {
                margin-top: 3rem;
            }

            .table {
                font-size: 0.7rem;
            }

            .table th:nth-child(3), .table td:nth-child(3),
            .table th:nth-child(4), .table td:nth-child(4) {
                display: none;
            }

            .action-btn {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }

            .modal-content {
                padding: 0.8rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .form-group {
                padding: 0;
                margin-bottom: 0.6rem;
            }

            .option-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .option-buttons button {
                width: 100%;
                font-size: 0.7rem;
                padding: 0.5rem 1rem;
            }

            .add-btn-container {
                justify-content: center;
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn-custom {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .center-select-container select {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .confirmation-modal .modal-content,
            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 98%;
                padding: 0.8rem;
            }

            .modal-title {
                font-size: 1.1rem;
            }

            .confirmation-modal .modal-body {
                font-size: 0.9rem;
            }

            .btn-confirm, .btn-cancel {
                padding: 0.3rem 1rem;
                font-size: 0.8rem;
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

        @media (min-width: 321px) and (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }

            .container {
                margin-top: 3.5rem;
            }

            .table {
                font-size: 0.8rem;
            }

            .table th:nth-child(4), .table td:nth-child(4) {
                display: none;
            }

            .action-btn {
                font-size: 0.8rem;
                padding: 0.3rem 0.5rem;
            }

            .modal-content {
                padding: 0.9rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .form-group {
                padding: 0;
                margin-bottom: 0.6rem;
            }

            .option-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }

            .option-buttons button {
                width: 100%;
                font-size: 0.75rem;
                padding: 0.6rem 1.2rem;
            }

            .add-btn-container {
                justify-content: center;
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-custom {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .center-select-container select {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .confirmation-modal .modal-content,
            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 95%;
                padding: 0.8rem;
            }

            .modal-title {
                font-size: 1.1rem;
            }

            .confirmation-modal .modal-body {
                font-size: 0.9rem;
            }

            .btn-confirm, .btn-cancel {
                padding: 0.3rem 1rem;
                font-size: 0.8rem;
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
                padding: 1.25rem !important;
            }

            .content-wrapper.minimized {
                margin-left: 0;
            }

            .container {
                margin-top: 4rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th:nth-child(4), .table td:nth-child(4) {
                display: none;
            }

            .modal-content {
                padding: 1rem;
            }

            .form-row {
                flex-direction: row;
                gap: 1rem;
            }

            .option-buttons {
                flex-direction: row;
                gap: 0.75rem;
            }

            .add-btn-container {
                justify-content: center;
                gap: 0.75rem;
            }

            .btn-custom {
                font-size: 0.9rem;
            }

            .center-select-container select {
                font-size: 0.9rem;
            }

            .confirmation-modal .modal-content,
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
                margin-left: 12rem;
            }

            .content-wrapper.minimized {
                margin-left: 4rem;
            }

            .table {
                font-size: 0.9rem;
            }

            .modal-content {
                max-width: calc(450px + 2vw);
            }
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            .content-wrapper {
                margin-left: 14rem;
            }

            .modal-content {
                max-width: calc(480px + 2vw);
            }
        }

        @media (min-width: 1201px) {
            .content-wrapper {
                margin-left: 15rem;
            }

            .confirmation-modal .modal-content {
                max-width: 400px;
            }

            .add-modal .modal-content,
            .filter-modal .modal-content {
                max-width: 500px;
            }
        }

        @media (min-width: 1600px) {
            .content-wrapper {
                margin-left: 16rem;
            }

            .modal-content {
                max-width: calc(520px + 2vw);
            }

            .table {
                font-size: 1rem;
            }

            .option-buttons button {
                font-size: 1rem;
                padding: 0.75rem 2.5rem;
            }

            .btn-custom {
                font-size: 1.1rem;
                padding: 0.6rem 1.2rem;
            }

            .btn-confirm, .btn-cancel {
                font-size: 0.9rem;
                padding: 0.5rem 1.5rem;
            }
        }

        /* Touch device hover fix */
        @media (hover: none) {
            .action-btn:hover,
            .btn-custom:hover,
            .option-buttons button:hover,
            .btn-confirm:hover,
            .btn-cancel:hover,
            .close:hover {
                transform: none;
                background-color: inherit;
                box-shadow: none;
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
        <div class="container">
            <!-- Option Buttons -->
            <div class="option-buttons">
                <button class="active" onclick="switchOption('centerwise')">Centerwise Expenses</button>
                <button onclick="switchOption('own')">Own Expenses</button>
            </div>

            <div class="add-btn-container">
                <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                     <i class="bi bi-funnel me-2"></i> Filter
                </button>
                <button class="btn btn-custom" data-toggle="modal" data-target="#expenseModal">
                    <i class="fas fa-plus mr-1"></i> Add Expense
                </button>
            </div>

            <!-- Center Select for Centerwise Expenses -->
            <div class="center-select-container" id="centerSelectContainer">
                <div class="form-group">
                    <label for="centerSelect">Select Center <span class="text-danger">*</span></label>
                    <select id="centerSelect" name="centerSelect" class="form-control" required>
                        <option value="">-- Select Center --</option>
                        <!-- Populated via AJAX -->
                    </select>
                    <div class="invalid-feedback">Please select a center.</div>
                </div>
            </div>

            <!-- Centerwise Expenses Table -->
            <div class="table-container" id="centerwiseTableContainer">
                <table class="table table-bordered table-hover" id="centerwiseTable">
                    <thead class="thead-dark1">
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="centerwiseTableBody">
                        <!-- Populated via AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Own Expenses Table -->
            <div class="table-container" id="ownTableContainer" style="display: none;">
                <table class="table table-bordered table-hover" id="ownTable">
                    <thead class="thead-dark1">
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ownTableBody">
                        <!-- Populated via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <div class="modal fade add-modal" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="expenseLabel">Add Income / Expenses</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" novalidate>
                    <input type="hidden" id="expenseId" name="expenseId">
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6" id="expenseCenterField">
                            <label for="expenseCenter">Center <span class="text-danger">*</span></label>
                            <select id="expenseCenter" name="expenseCenter" class="form-control" required>
                                <option value="">-- Select Center --</option>
                                <!-- Populated via AJAX -->
                            </select>
                            <div class="invalid-feedback">Please select a center.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Title is required, letters and spaces only, max 50 characters.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Date is required and must not be a future date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">Amount (₹) <span class="text-danger">*</span></label>
                            <input type="number" id="amount" name="amount" class="form-control" step="0.01" min="1" required>
                            <div class="invalid-feedback">Amount is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6" id="descriptionField">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" class="form-control" required maxlength="200" rows="2"></textarea>
                            <div class="invalid-feedback">Description is required, max 200 characters.</div>
                        </div>
                        <div class="form-group col-md-6" id="categoryField" style="display: none;">
                            <label for="category">Category <span class="text-danger">*</span></label>
                            <input type="text" id="category" name="category" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Category is required, letters and spaces only, max 50 characters.</div>
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

    <!-- Filter Modal -->
    <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="filterLabel">Filter Expenses</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="form-note">Fill at least one field to apply a filter.</div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6" id="filterCenterField">
                            <label for="filterCenter">Center</label>
                            <select id="filterCenter" name="filterCenter" class="form-control">
                                <option value="">-- Select Center --</option>
                                <!-- Populated via AJAX -->
                            </select>
                            <div class="invalid-feedback">Please select a valid center.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="filterTitle">Title</label>
                            <input type="text" id="filterTitle" name="filterTitle" class="form-control" pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Title must contain only letters and spaces, max 50 characters.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6" id="filterDescriptionField">
                            <label for="filterDescription">Description</label>
                            <input type="text" id="filterDescription" name="filterDescription" class="form-control" maxlength="200">
                            <div class="invalid-feedback">Description must be 200 characters or less.</div>
                        </div>
                        <div class="form-group col-md-6" id="filterCategoryField" style="display: none;">
                            <label for="filterCategory">Category</label>
                            <input type="text" id="filterCategory" name="filterCategory" class="form-control" pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Category must contain only letters and spaces, max 50 characters.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Clear</button>
                        <button type="submit" class="btn btn-confirm">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let editingRow = null;
            let currentOption = 'centerwise';
            let currentExpenseId = null;
            let currentAction = null;

            // CSRF Token Setup
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';

            // Load Centers for Dropdowns
            function loadCenters() {
                $.ajax({
                    url: '<?php echo base_url('center/get_centers'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const centerSelect = $('#centerSelect');
                            const expenseCenter = $('#expenseCenter');
                            const filterCenter = $('#filterCenter');
                            centerSelect.empty().append('<option value="">-- Select Center --</option>');
                            expenseCenter.empty().append('<option value="">-- Select Center --</option>');
                            filterCenter.empty().append('<option value="">-- Select Center --</option>');
                            response.data.forEach(center => {
                                const option = `<option value="${center.id}">${center.center_name}</option>`;
                                centerSelect.append(option);
                                expenseCenter.append(option);
                                filterCenter.append(option);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error loading centers.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading centers.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Clear form on modal close
            $('#expenseModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('expenseForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                editingRow = null;
                $('#expenseId').val('');
                $('#expenseLabel').text('Add Income / Expenses');
                toggleFormFields('centerwise');
            });

            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                toggleFilterFields('centerwise');
            });

            // Toggle form fields based on option
            function toggleFormFields(option) {
                const descriptionField = document.getElementById('descriptionField');
                const categoryField = document.getElementById('categoryField');
                const expenseCenterField = document.getElementById('expenseCenterField');
                if (option === 'own') {
                    descriptionField.style.display = 'none';
                    categoryField.style.display = 'block';
                    expenseCenterField.style.display = 'none';
                } else {
                    descriptionField.style.display = 'block';
                    categoryField.style.display = 'none';
                    expenseCenterField.style.display = 'block';
                }
            }

            // Toggle filter fields based on option
            function toggleFilterFields(option) {
                const descriptionField = document.getElementById('filterDescriptionField');
                const categoryField = document.getElementById('filterCategoryField');
                const filterCenterField = document.getElementById('filterCenterField');
                if (option === 'own') {
                    descriptionField.style.display = 'none';
                    categoryField.style.display = 'block';
                    filterCenterField.style.display = 'none';
                } else {
                    descriptionField.style.display = 'block';
                    categoryField.style.display = 'none';
                    filterCenterField.style.display = 'block';
                }
            }

            // Load expenses
            function loadExpenses(option = 'centerwise') {
                const centerId = option === 'centerwise' ? $('#centerSelect').val() : '';
                if (option === 'centerwise' && !centerId) {
                    $('#centerwiseTableBody').empty().append('<tr><td colspan="5" class="text-center">Please select a center.</td></tr>');
                    return;
                }
                const url = option === 'own' ? '<?php echo base_url('expense/get_own_expenses'); ?>' : '<?php echo base_url('expense/get_centerwise_expenses'); ?>';
                const data = option === 'centerwise' ? { [csrfName]: csrfToken, center_id: centerId } : { [csrfName]: csrfToken };
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $(`#${option}TableBody`);
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="5" class="text-center">No records found.</td></tr>');
                            return;
                        }
                        data.forEach(item => {
                            const rowClass = item.status === 'approved' ? 'approved' : item.status === 'rejected' ? 'rejected' : '';
                            const rowStyle = item.status === 'approved' ? 'background-color: #d4edda;' : item.status === 'rejected' ? 'background-color: #f8d7da;' : '';
                            const approveDisabled = item.status !== 'pending' ? 'disabled' : '';
                            const rejectDisabled = item.status !== 'pending' ? 'disabled' : '';
                            const detail = option === 'centerwise' ? item.description : item.category;
                            const row = `
                                <tr class="${rowClass}" style="${rowStyle}" data-center-id="${item.center_id || ''}">
                                    <td>${item.title}</td>
                                    <td>${new Date(item.date).toLocaleDateString('en-GB')}</td>
                                    <td>Rs.${parseFloat(item.amount).toFixed(0)}</td>
                                    <td>${detail}</td>
                                    <td>
                                        <button class="action-btn thumbs-up" title="Approve" data-id="${item.id}" data-title="${item.title}" ${approveDisabled}><i class="fas fa-check"></i></button>
                                        <button class="action-btn cross" title="Reject" data-id="${item.id}" data-title="${item.title}" ${rejectDisabled}><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr class="horizontal-line"><td colspan="5"></td></tr>
                            `;
                            tableBody.append(row);
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading expenses.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Initial load
            loadCenters();
            $('#centerSelect').on('change', function() {
                if (currentOption === 'centerwise') {
                    loadExpenses('centerwise');
                }
            });

            // Expense Form validation
            function validateExpenseForm() {
                const form = document.getElementById('expenseForm');
                let isValid = true;

                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const expenseCenter = form.querySelector('#expenseCenter');
                const title = form.querySelector('#title');
                const date = form.querySelector('#date');
                const amount = form.querySelector('#amount');
                const description = form.querySelector('#description');
                const category = form.querySelector('#category');

                if (currentOption === 'centerwise' && !expenseCenter.value) {
                    expenseCenter.setCustomValidity('Center is required.');
                    expenseCenter.classList.add('is-invalid');
                    isValid = false;
                } else if (currentOption === 'centerwise') {
                    expenseCenter.classList.add('is-valid');
                }

                if (!title.value.trim()) {
                    title.setCustomValidity('Title is required.');
                    title.classList.add('is-invalid');
                    isValid = false;
                } else if (!/^[A-Za-z\s]+$/.test(title.value)) {
                    title.setCustomValidity('Title must contain only letters and spaces.');
                    title.classList.add('is-invalid');
                    isValid = false;
                } else if (title.value.length > 50) {
                    title.setCustomValidity('Title must be 50 characters or less.');
                    title.classList.add('is-invalid');
                    isValid = false;
                } else {
                    title.classList.add('is-valid');
                }

                const today = new Date().toISOString().split('T')[0];
                if (!date.value) {
                    date.setCustomValidity('Date is required.');
                    date.classList.add('is-invalid');
                    isValid = false;
                } else if (date.value > today) {
                    date.setCustomValidity('Date must not be a future date.');
                    date.classList.add('is-invalid');
                    isValid = false;
                } else {
                    date.classList.add('is-valid');
                }

                if (!amount.value || isNaN(amount.value) || amount.value <= 0) {
                    amount.setCustomValidity('Amount must be greater than 0.');
                    amount.classList.add('is-invalid');
                    isValid = false;
                } else {
                    amount.classList.add('is-valid');
                }

                if (currentOption === 'centerwise') {
                    if (!description.value.trim()) {
                        description.setCustomValidity('Description is required.');
                        description.classList.add('is-invalid');
                        isValid = false;
                    } else if (description.value.length > 200) {
                        description.setCustomValidity('Description must be 200 characters or less.');
                        description.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        description.classList.add('is-valid');
                    }
                } else {
                    if (!category.value.trim()) {
                        category.setCustomValidity('Category is required.');
                        category.classList.add('is-invalid');
                        isValid = false;
                    } else if (!/^[A-Za-z\s]+$/.test(category.value)) {
                        category.setCustomValidity('Category must contain only letters and spaces.');
                        category.classList.add('is-invalid');
                        isValid = false;
                    } else if (category.value.length > 50) {
                        category.setCustomValidity('Category must be 50 characters or less.');
                        category.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        category.classList.add('is-valid');
                    }
                }

                return isValid;
            }

            // Filter Form validation
            function validateFilterForm() {
                const form = document.getElementById('filterForm');
                let isValid = true;
                let atLeastOneFilled = false;

                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const filterCenter = form.querySelector('#filterCenter');
                const filterTitle = form.querySelector('#filterTitle');
                const filterDescription = form.querySelector('#filterDescription');
                const filterCategory = form.querySelector('#filterCategory');

                if (filterCenter.value.trim()) {
                    atLeastOneFilled = true;
                    filterCenter.classList.add('is-valid');
                }

                if (filterTitle.value.trim()) {
                    atLeastOneFilled = true;
                    if (!/^[A-Za-z\s]+$/.test(filterTitle.value)) {
                        filterTitle.setCustomValidity('Title must contain only letters and spaces.');
                        filterTitle.classList.add('is-invalid');
                        isValid = false;
                    } else if (filterTitle.value.length > 50) {
                        filterTitle.setCustomValidity('Title must be 50 characters or less.');
                        filterTitle.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        filterTitle.classList.add('is-valid');
                    }
                } else {
                    filterTitle.classList.add('is-valid');
                }

                if (currentOption === 'centerwise' && filterDescription.value.trim()) {
                    atLeastOneFilled = true;
                    if (filterDescription.value.length > 200) {
                        filterDescription.setCustomValidity('Description must be 200 characters or less.');
                        filterDescription.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        filterDescription.classList.add('is-valid');
                    }
                } else if (currentOption === 'own' && filterCategory.value.trim()) {
                    atLeastOneFilled = true;
                    if (!/^[A-Za-z\s]+$/.test(filterCategory.value)) {
                        filterCategory.setCustomValidity('Category must contain only letters and spaces.');
                        filterCategory.classList.add('is-invalid');
                        isValid = false;
                    } else if (filterCategory.value.length > 50) {
                        filterCategory.setCustomValidity('Category must be 50 characters or less.');
                        filterCategory.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        filterCategory.classList.add('is-valid');
                    }
                }

                if (!atLeastOneFilled) {
                    filterTitle.setCustomValidity('At least one filter field must be filled.');
                    filterTitle.classList.add('is-invalid');
                    isValid = false;
                }

                return isValid;
            }

            // Real-time validation for Expense Form
            $('#expenseForm').find('input, textarea, select').on('input', function() {
                const input = this;
                if (input.id === 'expenseCenter' && currentOption === 'centerwise') {
                    if (!input.value) {
                        input.setCustomValidity('Center is required.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                } else if (input.id === 'title') {
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
                    if (!input.value || isNaN(input.value) || input.value <= 0) {
                        input.setCustomValidity('Amount must be greater than 0.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                } else if (input.id === 'description' && currentOption === 'centerwise') {
                    if (!input.value.trim()) {
                        input.setCustomValidity('Description is required.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (input.value.length > 200) {
                        input.setCustomValidity('Description must be 200 characters or less.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                } else if (input.id === 'category' && currentOption === 'own') {
                    if (!input.value.trim()) {
                        input.setCustomValidity('Category is required.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (!/^[A-Za-z\s]+$/.test(input.value)) {
                        input.setCustomValidity('Category must contain only letters and spaces.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else if (input.value.length > 50) {
                        input.setCustomValidity('Category must be 50 characters or less.');
                        input.classList.add('is-invalid');
                        input.classList.remove('is-valid');
                    } else {
                        input.setCustomValidity('');
                        input.classList.remove('is-invalid');
                        input.classList.add('is-valid');
                    }
                }
            });

            // Real-time validation for Filter Form
            $('#filterForm').find('input, select').on('input', function() {
                const form = document.getElementById('filterForm');
                const filterCenter = form.querySelector('#filterCenter');
                const filterTitle = form.querySelector('#filterTitle');
                const filterDescription = form.querySelector('#filterDescription');
                const filterCategory = form.querySelector('#filterCategory');

                if (this.id === 'filterCenter') {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else if (this.id === 'filterTitle') {
                    if (!this.value.trim() || (/^[A-Za-z\s]+$/.test(this.value) && this.value.length <= 50)) {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.setCustomValidity('Title must contain only letters and spaces.');
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    }
                } else if (this.id === 'filterDescription' && currentOption === 'centerwise') {
                    if (!this.value.trim() || this.value.length <= 200) {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.setCustomValidity('Description must be 200 characters or less.');
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    }
                } else if (this.id === 'filterCategory' && currentOption === 'own') {
                    if (!this.value.trim() || (/^[A-Za-z\s]+$/.test(this.value) && this.value.length <= 50)) {
                        this.setCustomValidity('');
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.setCustomValidity('Category must contain only letters and spaces.');
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    }
                }
            });

            // Expense Form submission
            $('#expenseForm').on('submit', function(e) {
                e.preventDefault();
                if (validateExpenseForm()) {
                    const formData = new FormData(this);
                    const data = {
                        [csrfName]: csrfToken,
                        center_id: formData.get('expenseCenter'),
                        title: formData.get('title'),
                        date: formData.get('date'),
                        amount: parseFloat(formData.get('amount')).toFixed(2),
                        description: currentOption === 'centerwise' ? formData.get('description') : formData.get('category'),
                        type: currentOption
                    };
                    const url = formData.get('expenseId') ? '<?php echo base_url('expense/update_expense'); ?>' : '<?php echo base_url('expense/add_expense'); ?>';
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
                                loadExpenses(currentOption);
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error saving expense.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    });
                }
                this.classList.add('was-validated');
            });

            // Filter Form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                if (validateFilterForm()) {
                    const formData = new FormData(this);
                    const data = {
                        [csrfName]: csrfToken,
                        center_id: formData.get('filterCenter'),
                        title: formData.get('filterTitle'),
                        description: currentOption === 'centerwise' ? formData.get('filterDescription') : formData.get('filterCategory'),
                        type: currentOption
                    };

                    $.ajax({
                        url: '<?php echo base_url('expense/get_centerwise_expenses'); ?>',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(data) {
                            const tableBody = $(`#${currentOption}TableBody`);
                            tableBody.empty();
                            if (data.length === 0) {
                                tableBody.append('<tr><td colspan="5" class="text-center">No records match the filter criteria.</td></tr>');
                            } else {
                                data.forEach(item => {
                                    const rowClass = item.status === 'approved' ? 'approved' : item.status === 'rejected' ? 'rejected' : '';
                                    const rowStyle = item.status === 'approved' ? 'background-color: #d4edda;' : item.status === 'rejected' ? 'background-color: #f8d7da;' : '';
                                    const approveDisabled = item.status !== 'pending' ? 'disabled' : '';
                                    const rejectDisabled = item.status !== 'pending' ? 'disabled' : '';
                                    const detail = currentOption === 'centerwise' ? item.description : item.category;
                                    const row = `
                                        <tr class="${rowClass}" style="${rowStyle}" data-center-id="${item.center_id || ''}">
                                            <td>${item.title}</td>
                                            <td>${new Date(item.date).toLocaleDateString('en-GB')}</td>
                                            <td>Rs.${parseFloat(item.amount).toFixed(0)}</td>
                                            <td>${detail}</td>
                                            <td>
                                                <button class="action-btn thumbs-up" title="Approve" data-id="${item.id}" data-title="${item.title}" ${approveDisabled}><i class="fas fa-check"></i></button>
                                                <button class="action-btn cross" title="Reject" data-id="${item.id}" data-title="${item.title}" ${rejectDisabled}><i class="fas fa-times"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                                    `;
                                    tableBody.append(row);
                                });
                            }
                            $('#filterModal').modal('hide');
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
                }
                this.classList.add('was-validated');
            });

            // Approve and Reject functionality
            $(document).on('click', '.thumbs-up, .cross', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const title = $(this).data('title');
                const row = $(this).closest('tr');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Already Processed',
                        text: `Expense "${title}" has already been processed.`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                    return;
                }
                currentExpenseId = id;
                currentAction = $(this).hasClass('thumbs-up') ? 'approve' : 'reject';
                const actionText = currentAction === 'approve' ? 'Approve' : 'Reject';
                $('#confirmActionLabel').text(`${actionText} Expense`);
                $('#confirmMessage').text(`Are you sure you want to ${actionText.toLowerCase()} the expense "${title}"?`);
                $('#confirmActionModal').modal('show');
            });

            // Handle confirmation modal confirm button
            $('#confirmActionBtn').on('click', function() {
                const url = currentAction === 'approve' 
                    ? '<?php echo base_url('expense/approve_expense'); ?>/' + currentExpenseId 
                    : '<?php echo base_url('expense/reject_expense'); ?>/' + currentExpenseId;
                const title = $(`.action-btn[data-id="${currentExpenseId}"]`).data('title');
                const row = $(`.action-btn[data-id="${currentExpenseId}"]`).closest('tr');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const status = currentAction === 'approve' ? 'approved' : 'rejected';
                            row.addClass(status).css('backgroundColor', status === 'approved' ? '#d4edda' : '#f8d7da');
                            row.find('.thumbs-up').prop('disabled', true);
                            row.find('.cross').prop('disabled', true);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: `Expense "${title}" ${currentAction}d at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
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
                            text: `Error ${currentAction}ing expense.`,
                            showConfirmButton: true,
                            timer: 3000
                        });
                        $('#confirmActionModal').modal('hide');
                    }
                });
            });

            // Option switching functionality
            window.switchOption = function(option) {
                currentOption = option;
                $('.option-buttons button').removeClass('active');
                $(`.option-buttons button:contains("${option === 'centerwise' ? 'Centerwise Expenses' : 'Own Expenses'}")`).addClass('active');

                document.getElementById('centerwiseTableContainer').style.display = option === 'centerwise' ? 'block' : 'none';
                document.getElementById('ownTableContainer').style.display = option === 'own' ? 'block' : 'none';
                document.getElementById('centerSelectContainer').style.display = option === 'centerwise' ? 'block' : 'none';

                toggleFormFields(option);
                toggleFilterFields(option);
                loadExpenses(option);
            };

            // Open expense modal with appropriate fields
            $('.btn-custom').on('click', function() {
                toggleFormFields(currentOption);
                loadCenters();
            });

            // Sidebar toggle functionality
            $('#sidebarToggle').on('click', function() {
                if (window.innerWidth <= 576) {
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
                if (window.innerWidth <= 576) {
                    $('#sidebar').removeClass('minimized');
                    $('.navbar').removeClass('sidebar-minimized');
                    $('#contentWrapper').removeClass('minimized');
                }
            });

            // Clear focus on modal buttons to prevent navbar highlight
            $('.btn-custom').on('click', function() {
                $(this).blur();
            });
        });
    </script>
</body>
</html>