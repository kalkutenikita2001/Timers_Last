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
    <!-- Segoe UI Fallback -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
               background-color: #f4f6f8 !important;
            color: #333;
            min-height: 100vh;
            margin: 0;
            padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
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

        /* Add Button and Filter */
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
            
        }

        .add-btn {
            background: #dc3545;
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

        .add-btn:hover {
            background: #c82333;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        .btn-filter {
            background: #ffffff;
            border: 1px solid white;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
            
        }
        .btn{
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-filter:hover {
            background: #e0e0e0;
            color: #000;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-container {
            /* overflow-x: auto; */
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
            /* background-color: #343a40; */
            color: black;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            /* padding: 1rem; */
            text-align: center;
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
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
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table .horizontal-line td {
            border: none;
            background-color: #dee2e6;
            height: 1px;
            padding: 0;
        }

        .action-btn {
            background: none;
            border: none;
            font-size: clamp(0.8rem, 2vw, 1rem);
            margin: 0 0.25rem;
            transition: transform 0.2s ease;
            color: #6c757d;
            padding: 0.5rem;
        }

        .action-btn:hover {
            transform: scale(1.2);
            color: #007bff;
        }

        .action-btn:disabled {
            color: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Modal Styles */
        .modal-content {
            background: #f5f5f5;
            margin: 8% auto;
            padding: clamp(1rem, 3vw, 1.5rem);
            border-radius: 0.5rem;
            width: 90%;
            max-width: calc(500px + 2vw);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            text-align: center;
            padding: 0;
            border-bottom: none;
            position: relative;
        }

        .modal-title {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            font-weight: 600;
            color: #333;
            margin: 0;
            /* padding: 1.5rem 1rem 1rem; */
        }

        .close {
            position: absolute;
            right: 1rem;
            top: 1rem;
            color: #666;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close:hover {
            color: #000;
            background: #e0e0e0;
        }

        .modal-body {
            padding: 1rem 2rem 2rem;
        }

        .form-row {
            display: flex;
            /* gap: 1rem; */
            margin-bottom: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .form-group {
            flex: 1;
            min-width: 0;
            padding: 0 0.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            background: white;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 6rem;
        }

        .error {
            color: #dc3545;
            font-size: clamp(0.7rem, 1.8vw, 0.875rem);
            margin-top: 0.25rem;
            display: none;
        }

        .form-group.invalid input,
        .form-group.invalid textarea {
            border-color: #dc3545;
            background: #ffeaea;
        }

        .form-group.invalid .error {
            display: block;
        }

        .save-btn {
            /* background: #dc3545; */
            color: black;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 0.25rem;
            font-size: clamp(0.9rem, 2vw, 1rem);
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 1.5rem auto 0;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
        }

        .save-btn:hover {
            /* background: #c82333; */
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Filter Modal Styles */
        #filterModal .modal-content {
            max-width: calc(400px + 2vw);
        }

        #filterModal .close {
            top: 0.75rem;
            right: 0.75rem;
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
                padding: 0.3rem;
            }

            .modal-content {
                width: 98%;
                margin: 5% auto;
                padding: 0.5rem;
            }

            .modal-body {
                padding: 0.75rem 1rem 1.5rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .form-group {
                padding: 0;
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

            .add-btn, .btn-filter {
                width: 100%;
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }

            .save-btn {
                font-size: 0.75rem;
                padding: 0.5rem 1.5rem;
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
                padding: 0.4rem;
            }

            .modal-content {
                width: 95%;
                margin: 8% auto;
                padding: 1rem;
            }

            .modal-body {
                padding: 1rem 1.5rem 1.5rem;
            }

            .form-row {
                flex-direction: column;
                gap: 0.75rem;
            }

            .form-group {
                padding: 0;
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

            .add-btn, .btn-filter {
                width: 100%;
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }

            .save-btn {
                font-size: 0.875rem;
                padding: 0.6rem 1.5rem;
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
                width: 90%;
                margin: 10% auto;
            }

            .modal-body {
                padding: 1.25rem 1.75rem;
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

            .add-btn, .btn-filter {
                font-size: 0.9rem;
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

            .modal-content {
                max-width: calc(500px + 2vw);
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

            .add-btn, .btn-filter {
                font-size: 1.1rem;
                padding: 0.6rem 1.2rem;
            }

            .save-btn {
                font-size: 1.1rem;
                padding: 0.75rem 2rem;
            }
        }

        /* Touch device hover fix */
        @media (hover: none) {
            .action-btn:hover,
            .add-btn:hover,
            .btn-filter:hover,
            .option-buttons button:hover,
            .save-btn:hover {
                background-color: inherit;
                transform: none;
                box-shadow: none;
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
        <div class="container">
            <!-- Option Buttons -->
            <div class="option-buttons">
                <button class="active" onclick="switchOption('centerwise')">Centerwise Expenses</button>
                <button onclick="switchOption('own')">Own Expenses</button>
            </div>

          
<div class="add-btn-container">
    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-filter mr-1"></i> Filter
    </button>
    <button class="btn btn-custom" data-toggle="modal" data-target="#expenseModal">
        <i class="fas fa-plus mr-1"></i> Add Expense
    </button>
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
                        <tr>
                            <td>Rent</td>
                            <td>01/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdhjkhfv bnmvhfgtdvjhgjjhg</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Rent"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Rent"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                        <tr>
                            <td>Food</td>
                            <td>15/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdhjkhfv bnmvhfgtdvjhgjjhg</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Food"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Food"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                        <tr>
                            <td>Rent</td>
                            <td>15/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdhjkhfv bnmvhfgtdvjhgjjhg</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Rent"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Rent"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
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
                        <tr>
                            <td>Groceries</td>
                            <td>01/07/2025</td>
                            <td>Rs.2500</td>
                            <td>Personal</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Groceries"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Groceries"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                        <tr>
                            <td>Utilities</td>
                            <td>05/07/2025</td>
                            <td>Rs.1200</td>
                            <td>Household</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Utilities"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Utilities"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                        <tr>
                            <td>Fuel</td>
                            <td>10/07/2025</td>
                            <td>Rs.3000</td>
                            <td>Travel</td>
                            <td>
                                <button class="action-btn thumbs-up" data-title="Fuel"><i class="fas fa-check"></i></button>
                                <button class="action-btn cross" data-title="Fuel"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                        <tr class="horizontal-line"><td colspan="5"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title w-100" id="expenseLabel">Add Income / Expenses</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="expenseForm" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50">
                                <div class="error">Title is required, letters and spaces only, max 50 characters.</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Date <span class="text-danger">*</span></label>
                                <input type="date" id="date" name="date" class="form-control" required max="<?php echo date('Y-m-d'); ?>">
                                <div class="error">Date is required and must not be a future date.</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Amount (₹) <span class="text-danger">*</span></label>
                                <input type="number" id="amount" name="amount" class="form-control" step="0.01" min="1" required>
                                <div class="error">Amount is required and must be greater than 0.</div>
                            </div>
                            <div class="form-group col-md-6" id="descriptionField">
                                <label for="description">Description <span class="text-danger">*</span></label>
                                <textarea id="description" name="description" class="form-control" required maxlength="200"></textarea>
                                <div class="error">Description is required, max 200 characters.</div>
                            </div>
                            <div class="form-group col-md-6" id="categoryField" style="display: none;">
                                <label for="category">Category <span class="text-danger">*</span></label>
                                <input type="text" id="category" name="category" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50">
                                <div class="error">Category is required, letters and spaces only, max 50 characters.</div>
                            </div>
                        </div>
                        <button type="submit" class="save-btn">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title w-100" id="filterLabel">Filter Expenses</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="filterForm" novalidate>
                        <div class="form-note">Fill at least one field to apply a filter.</div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="filterTitle">Title</label>
                                <input type="text" id="filterTitle" name="filterTitle" class="form-control" pattern="[A-Za-z\s]+" maxlength="50">
                                <div class="error">Title must contain only letters and spaces, max 50 characters.</div>
                            </div>
                            <div class="form-group col-md-6" id="filterDescriptionField">
                                <label for="filterDescription">Description</label>
                                <input type="text" id="filterDescription" name="filterDescription" class="form-control" maxlength="200">
                                <div class="error">Description must be 200 characters or less.</div>
                            </div>
                            <div class="form-group col-md-6" id="filterCategoryField" style="display: none;">
                                <label for="filterCategory">Category</label>
                                <input type="text" id="filterCategory" name="filterCategory" class="form-control" pattern="[A-Za-z\s]+" maxlength="50">
                                <div class="error">Category must contain only letters and spaces, max 50 characters.</div>
                            </div>
                        </div>
                        <button type="submit" class="save-btn">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let editingRow = null;
            let currentOption = 'centerwise';
            const centerwiseRows = Array.from(document.querySelectorAll('#centerwiseTableBody tr:not(.horizontal-line)'))
                .map(row => row.outerHTML);
            const ownRows = Array.from(document.querySelectorAll('#ownTableBody tr:not(.horizontal-line)'))
                .map(row => row.outerHTML);

            // Clear form on modal close
            $('#expenseModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('expenseForm');
                form.reset();
                form.classList.remove('was-validated');
                clearValidationErrors();
                editingRow = null;
                toggleFormFields('centerwise');
            });

            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input').forEach(input => input.setCustomValidity(''));
                toggleFilterFields('centerwise');
            });

            function clearValidationErrors() {
                const formGroups = document.querySelectorAll('.form-group');
                formGroups.forEach(group => {
                    group.classList.remove('invalid');
                });
            }

            // Toggle form fields based on option
            function toggleFormFields(option) {
                const descriptionField = document.getElementById('descriptionField');
                const categoryField = document.getElementById('categoryField');
                if (option === 'own') {
                    descriptionField.style.display = 'none';
                    categoryField.style.display = 'block';
                } else {
                    descriptionField.style.display = 'block';
                    categoryField.style.display = 'none';
                }
            }

            // Toggle filter fields based on option
            function toggleFilterFields(option) {
                const descriptionField = document.getElementById('filterDescriptionField');
                const categoryField = document.getElementById('filterCategoryField');
                if (option === 'own') {
                    descriptionField.style.display = 'none';
                    categoryField.style.display = 'block';
                } else {
                    descriptionField.style.display = 'block';
                    categoryField.style.display = 'none';
                }
            }

            // Expense Form validation
            function validateExpenseForm() {
                const form = document.getElementById('expenseForm');
                let isValid = true;

                clearValidationErrors();

                const title = form.querySelector('#title');
                const date = form.querySelector('#date');
                const amount = form.querySelector('#amount');
                const description = form.querySelector('#description');
                const category = form.querySelector('#category');

                if (!title.value.trim()) {
                    title.setCustomValidity('Title is required.');
                    title.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else if (!/^[A-Za-z\s]+$/.test(title.value)) {
                    title.setCustomValidity('Title must contain only letters and spaces.');
                    title.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else if (title.value.length > 50) {
                    title.setCustomValidity('Title must be 50 characters or less.');
                    title.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else {
                    title.setCustomValidity('');
                }

                const today = new Date().toISOString().split('T')[0];
                if (!date.value) {
                    date.setCustomValidity('Date is required.');
                    date.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else if (date.value > today) {
                    date.setCustomValidity('Date must not be a future date.');
                    date.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else {
                    date.setCustomValidity('');
                }

                if (!amount.value || isNaN(amount.value) || amount.value <= 0) {
                    amount.setCustomValidity('Amount must be greater than 0.');
                    amount.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else {
                    amount.setCustomValidity('');
                }

                if (currentOption === 'centerwise') {
                    if (!description.value.trim()) {
                        description.setCustomValidity('Description is required.');
                        description.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else if (description.value.length > 200) {
                        description.setCustomValidity('Description must be 200 characters or less.');
                        description.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else {
                        description.setCustomValidity('');
                    }
                } else {
                    if (!category.value.trim()) {
                        category.setCustomValidity('Category is required.');
                        category.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else if (!/^[A-Za-z\s]+$/.test(category.value)) {
                        category.setCustomValidity('Category must contain only letters and spaces.');
                        category.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else if (category.value.length > 50) {
                        category.setCustomValidity('Category must be 50 characters or less.');
                        category.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else {
                        category.setCustomValidity('');
                    }
                }

                return isValid;
            }

            // Filter Form validation
            function validateFilterForm() {
                const form = document.getElementById('filterForm');
                let isValid = true;
                let atLeastOneFilled = false;

                clearValidationErrors();

                const filterTitle = form.querySelector('#filterTitle');
                const filterDescription = form.querySelector('#filterDescription');
                const filterCategory = form.querySelector('#filterCategory');

                if (filterTitle.value.trim()) {
                    atLeastOneFilled = true;
                    if (!/^[A-Za-z\s]+$/.test(filterTitle.value)) {
                        filterTitle.setCustomValidity('Title must contain only letters and spaces.');
                        filterTitle.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else if (filterTitle.value.length > 50) {
                        filterTitle.setCustomValidity('Title must be 50 characters or less.');
                        filterTitle.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else {
                        filterTitle.setCustomValidity('');
                    }
                } else {
                    filterTitle.setCustomValidity('');
                }

                if (currentOption === 'centerwise' && filterDescription.value.trim()) {
                    atLeastOneFilled = true;
                    if (filterDescription.value.length > 200) {
                        filterDescription.setCustomValidity('Description must be 200 characters or less.');
                        filterDescription.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else {
                        filterDescription.setCustomValidity('');
                    }
                } else if (currentOption === 'own' && filterCategory.value.trim()) {
                    atLeastOneFilled = true;
                    if (!/^[A-Za-z\s]+$/.test(filterCategory.value)) {
                        filterCategory.setCustomValidity('Category must contain only letters and spaces.');
                        filterCategory.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else if (filterCategory.value.length > 50) {
                        filterCategory.setCustomValidity('Category must be 50 characters or less.');
                        filterCategory.closest('.form-group').classList.add('invalid');
                        isValid = false;
                    } else {
                        filterCategory.setCustomValidity('');
                    }
                }

                if (!atLeastOneFilled) {
                    filterTitle.setCustomValidity('At least one filter field must be filled.');
                    filterTitle.closest('.form-group').classList.add('invalid');
                    isValid = false;
                } else {
                    filterTitle.setCustomValidity('');
                }

                return isValid;
            }

            // Real-time validation for Expense Form
            $('#expenseForm').find('input, textarea').on('input', function() {
                const input = this;
                if (input.id === 'title') {
                    if (!input.value.trim()) {
                        input.setCustomValidity('Title is required.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (!/^[A-Za-z\s]+$/.test(input.value)) {
                        input.setCustomValidity('Title must contain only letters and spaces.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (input.value.length > 50) {
                        input.setCustomValidity('Title must be 50 characters or less.');
                        input.closest('.form-group').classList.add('invalid');
                    } else {
                        input.setCustomValidity('');
                        input.closest('.form-group').classList.remove('invalid');
                    }
                } else if (input.id === 'date') {
                    const today = new Date().toISOString().split('T')[0];
                    if (!input.value) {
                        input.setCustomValidity('Date is required.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (input.value > today) {
                        input.setCustomValidity('Date must not be a future date.');
                        input.closest('.form-group').classList.add('invalid');
                    } else {
                        input.setCustomValidity('');
                        input.closest('.form-group').classList.remove('invalid');
                    }
                } else if (input.id === 'amount') {
                    if (!input.value || isNaN(input.value) || input.value <= 0) {
                        input.setCustomValidity('Amount must be greater than 0.');
                        input.closest('.form-group').classList.add('invalid');
                    } else {
                        input.setCustomValidity('');
                        input.closest('.form-group').classList.remove('invalid');
                    }
                } else if (input.id === 'description' && currentOption === 'centerwise') {
                    if (!input.value.trim()) {
                        input.setCustomValidity('Description is required.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (input.value.length > 200) {
                        input.setCustomValidity('Description must be 200 characters or less.');
                        input.closest('.form-group').classList.add('invalid');
                    } else {
                        input.setCustomValidity('');
                        input.closest('.form-group').classList.remove('invalid');
                    }
                } else if (input.id === 'category' && currentOption === 'own') {
                    if (!input.value.trim()) {
                        input.setCustomValidity('Category is required.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (!/^[A-Za-z\s]+$/.test(input.value)) {
                        input.setCustomValidity('Category must contain only letters and spaces.');
                        input.closest('.form-group').classList.add('invalid');
                    } else if (input.value.length > 50) {
                        input.setCustomValidity('Category must be 50 characters or less.');
                        input.closest('.form-group').classList.add('invalid');
                    } else {
                        input.setCustomValidity('');
                        input.closest('.form-group').classList.remove('invalid');
                    }
                }
            });

            // Real-time validation for Filter Form
            $('#filterForm').find('input').on('input', function() {
                const form = document.getElementById('filterForm');
                const filterTitle = form.querySelector('#filterTitle');
                const filterDescription = form.querySelector('#filterDescription');
                const filterCategory = form.querySelector('#filterCategory');

                if (this.id === 'filterTitle') {
                    if (!this.value.trim() || (/^[A-Za-z\s]+$/.test(this.value) && this.value.length <= 50)) {
                        this.setCustomValidity('');
                        this.closest('.form-group').classList.remove('invalid');
                    } else {
                        this.setCustomValidity('Title must contain only letters and spaces.');
                        this.closest('.form-group').classList.add('invalid');
                    }
                } else if (this.id === 'filterDescription' && currentOption === 'centerwise') {
                    if (!this.value.trim() || this.value.length <= 200) {
                        this.setCustomValidity('');
                        this.closest('.form-group').classList.remove('invalid');
                    } else {
                        this.setCustomValidity('Description must be 200 characters or less.');
                        this.closest('.form-group').classList.add('invalid');
                    }
                } else if (this.id === 'filterCategory' && currentOption === 'own') {
                    if (!this.value.trim() || (/^[A-Za-z\s]+$/.test(this.value) && this.value.length <= 50)) {
                        this.setCustomValidity('');
                        this.closest('.form-group').classList.remove('invalid');
                    } else {
                        this.setCustomValidity('Category must contain only letters and spaces.');
                        this.closest('.form-group').classList.add('invalid');
                    }
                }
            });

            // Expense Form submission
            $('#expenseForm').on('submit', function(e) {
                e.preventDefault();
                if (validateExpenseForm()) {
                    const formData = new FormData(this);
                    const data = {
                        title: formData.get('title'),
                        date: formData.get('date'),
                        amount: `Rs.${parseFloat(formData.get('amount')).toFixed(0)}`,
                        description: currentOption === 'centerwise' ? formData.get('description') : formData.get('category')
                    };

                    const tableBody = document.getElementById(currentOption === 'centerwise' ? 'centerwiseTableBody' : 'ownTableBody');
                    const rowArray = currentOption === 'centerwise' ? centerwiseRows : ownRows;

                    if (editingRow) {
                        updateRow(editingRow, data);
                        rowArray[Array.from(tableBody.querySelectorAll('tr:not(.horizontal-line)')).indexOf(editingRow)] = editingRow.outerHTML;
                    } else {
                        addNewRow(data);
                        rowArray.push(tableBody.querySelector('tr:not(.horizontal-line):last-child').outerHTML);
                    }

                    $('#expenseModal').modal('hide');
                }
                this.classList.add('was-validated');
            });

            // Filter Form submission
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                if (validateFilterForm()) {
                    const filterTitle = $('#filterTitle').val().trim().toLowerCase();
                    const filterDescription = $('#filterDescription').val().trim().toLowerCase();
                    const filterCategory = $('#filterCategory').val().trim().toLowerCase();

                    const tableBody = document.getElementById(currentOption === 'centerwise' ? 'centerwiseTableBody' : 'ownTableBody');
                    const rowArray = currentOption === 'centerwise' ? centerwiseRows : ownRows;
                    tableBody.innerHTML = '';

                    const filteredRows = rowArray.filter(row => {
                        const rowElement = document.createElement('div');
                        rowElement.innerHTML = row;
                        const title = rowElement.querySelector('td:nth-child(1)').textContent.toLowerCase();
                        const dateText = rowElement.querySelector('td:nth-child(2)').textContent;
                        const amount = parseFloat(rowElement.querySelector('td:nth-child(3)').textContent.replace('Rs.', ''));
                        const detail = rowElement.querySelector('td:nth-child(4)').textContent.toLowerCase();

                        return (!filterTitle || title.includes(filterTitle)) &&
                               (currentOption === 'centerwise' ? (!filterDescription || detail.includes(filterDescription)) : (!filterCategory || detail.includes(filterCategory)));
                    });

                    tableBody.innerHTML = filteredRows.length ? filteredRows.join('<tr class="horizontal-line"><td colspan="5"></td></tr>') : 
                        '<tr><td colspan="5" class="text-center">No records match the filter criteria.</td></tr>';

                    $('#filterModal').modal('hide');
                }
                this.classList.add('was-validated');
            });

            // Add new row to table
            function addNewRow(data) {
                const tableBody = document.getElementById(currentOption === 'centerwise' ? 'centerwiseTableBody' : 'ownTableBody');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${data.title}</td>
                    <td>${new Date(data.date).toLocaleDateString('en-GB')}</td>
                    <td>${data.amount}</td>
                    <td>${data.description}</td>
                    <td>
                        <button class="action-btn thumbs-up" data-title="${data.title}"><i class="fas fa-check"></i></button>
                        <button class="action-btn cross" data-title="${data.title}"><i class="fas fa-times"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
                const separator = document.createElement('tr');
                separator.className = 'horizontal-line';
                separator.innerHTML = '<td colspan="5"></td>';
                tableBody.appendChild(separator);
            }

            // Update existing row
            function updateRow(row, data) {
                const cells = row.querySelectorAll('td');
                cells[0].textContent = data.title;
                cells[1].textContent = new Date(data.date).toLocaleDateString('en-GB');
                cells[2].textContent = data.amount;
                cells[3].textContent = data.description;
                cells[4].innerHTML = `
                    <button class="action-btn thumbs-up" data-title="${data.title}"><i class="fas fa-check"></i></button>
                    <button class="action-btn cross" data-title="${data.title}"><i class="fas fa-times"></i></button>
                `;
            }

            // Approve and Reject functionality
            $(document).on('click', '.thumbs-up', function() {
                const row = $(this).closest('tr');
                const title = $(this).data('title');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    alert(`Expense "${title}" has already been processed.`);
                    return;
                }
                row.addClass('approved').css('backgroundColor', '#d4edda');
                $(this).prop('disabled', true).css('color', '#28a745');
                row.find('.cross').prop('disabled', true).css('color', '#ccc');
                alert(`Expense "${title}" approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
            });

            $(document).on('click', '.cross', function() {
                const row = $(this).closest('tr');
                const title = $(this).data('title');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    alert(`Expense "${title}" has already been processed.`);
                    return;
                }
                row.addClass('rejected').css('backgroundColor', '#f8d7da');
                $(this).prop('disabled', true).css('color', '#dc3545');
                row.find('.thumbs-up').prop('disabled', true).css('color', '#ccc');
                alert(`Expense "${title}" rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
            });

            // Option switching functionality
            window.switchOption = function(option) {
                currentOption = option;
                $('.option-buttons button').removeClass('active');
                $(`.option-buttons button:contains("${option === 'centerwise' ? 'Centerwise Expenses' : 'Own Expenses'}")`).addClass('active');

                document.getElementById('centerwiseTableContainer').style.display = option === 'centerwise' ? 'block' : 'none';
                document.getElementById('ownTableContainer').style.display = option === 'own' ? 'block' : 'none';

                toggleFormFields(option);
                toggleFilterFields(option);
            };

            // Open expense modal with appropriate fields
            $('.add-btn').on('click', function() {
                toggleFormFields(currentOption);
            });

            // Open filter modal with appropriate fields
            $('.btn-filter').on('click', function() {
                toggleFilterFields(currentOption);
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
            $('.add-btn, .btn-filter').on('click', function() {
                $(this).blur();
            });
        });
    </script>
</body>
</html>