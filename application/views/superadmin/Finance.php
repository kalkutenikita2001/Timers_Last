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
            /* background-color: #343a40; */
            color: black;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.9rem;
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
            font-size: 1rem;
            margin: 0 0.25rem;
            transition: transform 0.2s ease;
            color: #6c757d;
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

        /* Button Styles */
        .btn-custom {
            background:#6c757d;
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
            padding: 1.5rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-top: 65px;
        }

        .modal-content h3 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #343a40;
        }

        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-control {
            height: calc(2.25rem + 2px);
            border-radius: 0.25rem;
            font-size: 0.9rem;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .invalid-feedback {
            font-size: 0.875rem;
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
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
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
            margin-bottom: 1rem;
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

            .action-btn {
                margin: 0.1rem;
                font-size: 0.8rem;
            }

            .modal-content {
                padding: 1rem;
                /* max-width: 95%; */
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
            }

            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
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
                /* flex-direction: column; */
                gap: 10px;
            }

            .btn-custom {
                width: 120px;
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
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
                /* max-width: 90%; */
                padding: 1.25rem;
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
                max-width: 80%;
            }
        }

        @media (min-width: 992px) {
            .modal-content {
                /* max-width: 600px; */
            }
        }

        /* Touch device hover fix */
        @media (hover: none) {
            .action-btn:hover,
            .btn-custom:hover,
            .option-buttons button:hover {
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
                    <table class="table table-bordered table-hover" id="expenseTable">
                        <thead class="thead-dark1">
                            <tr>
                                <th>Title</th>
                                <th>Daily Revenue(₹)</th>
                                <th>Weekly Revenue(₹)</th>
                                <th>Monthly Revenue(₹)</th>
                                <th>Yearly Revenue(₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTableBody">
                            <tr>
                                <td>Rent</td>
                                <td>500</td>
                                <td>3500</td>
                                <td>15000</td>
                                <td>180000</td>
                                <td>
                                    <button class="action-btn view-btn" data-toggle="modal" data-target="#viewModal" 
                                            data-title="Rent" data-date="2025-07-30" data-daily="500" data-weekly="3500" 
                                            data-monthly="15000" data-yearly="180000" data-notes="N/A">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn thumbs-up" data-title="Rent"><i class="fas fa-check"></i></button>
                                    <button class="action-btn cross" data-title="Rent"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr class="horizontal-line"><td colspan="6"></td></tr>
                            <tr>
                                <td>Food</td>
                                <td>300</td>
                                <td>2100</td>
                                <td>9000</td>
                                <td>108000</td>
                                <td>
                                    <button class="action-btn view-btn" data-toggle="modal" data-target="#viewModal" 
                                            data-title="Food" data-date="2025-07-30" data-daily="300" data-weekly="2100" 
                                            data-monthly="9000" data-yearly="108000" data-notes="N/A">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn thumbs-up" data-title="Food"><i class="fas fa-check"></i></button>
                                    <button class="action-btn cross" data-title="Food"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr class="horizontal-line"><td colspan="6"></td></tr>
                            <tr>
                                <td>Rent</td>
                                <td>500</td>
                                <td>3500</td>
                                <td>15000</td>
                                <td>180000</td>
                                <td>
                                    <button class="action-btn view-btn" data-toggle="modal" data-target="#viewModal" 
                                            data-title="Rent" data-date="2025-07-30" data-daily="500" data-weekly="3500" 
                                            data-monthly="15000" data-yearly="180000" data-notes="N/A">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn thumbs-up" data-title="Rent"><i class="fas fa-check"></i></button>
                                    <button class="action-btn cross" data-title="Rent"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            <tr class="horizontal-line"><td colspan="6"></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Revenue Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="expenseLabel" class="modal-title w-100 text-center">Add Revenue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" novalidate>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required
                                   pattern="[A-Za-z\s]+" maxlength="50" title="Title should contain only letters and spaces, max 50 characters">
                            <div class="invalid-feedback">Title is required, letters and spaces only, max 50 characters.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Date is required and must not be a future date.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="dailyRevenue">Daily Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="dailyRevenue" name="dailyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Daily Revenue must be greater than 0">
                            <div class="invalid-feedback">Daily Revenue is required and must be greater than 0.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="weeklyRevenue">Weekly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="weeklyRevenue" name="weeklyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Weekly Revenue must be greater than 0">
                            <div class="invalid-feedback">Weekly Revenue is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="monthlyRevenue">Monthly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="monthlyRevenue" name="monthlyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Monthly Revenue must be greater than 0">
                            <div class="invalid-feedback">Monthly Revenue is required and must be greater than 0.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="yearlyRevenue">Yearly Revenue(₹) <span class="text-danger">*</span></label>
                            <input type="number" id="yearlyRevenue" name="yearlyRevenue" class="form-control" required
                                   min="1" step="0.01" title="Yearly Revenue must be greater than 0">
                            <div class="invalid-feedback">Yearly Revenue is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-12">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" class="form-control" rows="3" maxlength="200"></textarea>
                            <div class="invalid-feedback">Notes must be less than 200 characters.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Revenue Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
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
                        <p><strong>Date:</strong> <span id="viewDate"></span></p>
                        <p><strong>Daily Revenue:</strong> ₹<span id="viewDailyRevenue"></span></p>
                        <p><strong>Weekly Revenue:</strong> ₹<span id="viewWeeklyRevenue"></span></p>
                        <p><strong>Monthly Revenue:</strong> ₹<span id="viewMonthlyRevenue"></span></p>
                        <p><strong>Yearly Revenue:</strong> ₹<span id="viewYearlyRevenue"></span></p>
                        <p><strong>Notes:</strong> <span id="viewNotes"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Revenue Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" name="startDate" class="form-control"
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Start Date must not be a future date.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" name="endDate" class="form-control"
                                   max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">End Date must not be before Start Date or a future date.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="minDailyRevenue">Min Daily Revenue(₹)</label>
                            <input type="number" id="minDailyRevenue" name="minDailyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Daily Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Daily Revenue must be 0 or greater.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="maxDailyRevenue">Max Daily Revenue(₹)</label>
                            <input type="number" id="maxDailyRevenue" name="maxDailyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Daily Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Daily Revenue must be 0 or greater and not less than Min Daily Revenue.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="minWeeklyRevenue">Min Weekly Revenue(₹)</label>
                            <input type="number" id="minWeeklyRevenue" name="minWeeklyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Weekly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Weekly Revenue must be 0 or greater.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="maxWeeklyRevenue">Max Weekly Revenue(₹)</label>
                            <input type="number" id="maxWeeklyRevenue" name="maxWeeklyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Weekly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Weekly Revenue must be 0 or greater and not less than Min Weekly Revenue.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="minMonthlyRevenue">Min Monthly Revenue(₹)</label>
                            <input type="number" id="minMonthlyRevenue" name="minMonthlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Monthly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Monthly Revenue must be 0 or greater.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="maxMonthlyRevenue">Max Monthly Revenue(₹)</label>
                            <input type="number" id="maxMonthlyRevenue" name="maxMonthlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Monthly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Monthly Revenue must be 0 or greater and not less than Min Monthly Revenue.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="minYearlyRevenue">Min Yearly Revenue(₹)</label>
                            <input type="number" id="minYearlyRevenue" name="minYearlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Min Yearly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Min Yearly Revenue must be 0 or greater.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-md-6">
                            <label for="maxYearlyRevenue">Max Yearly Revenue(₹)</label>
                            <input type="number" id="maxYearlyRevenue" name="maxYearlyRevenue" class="form-control"
                                   min="0" step="0.01" title="Max Yearly Revenue must be 0 or greater">
                            <div class="invalid-feedback">Max Yearly Revenue must be 0 or greater and not less than Min Yearly Revenue.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
                        <button type="submit" class="btn btn-custom">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let editingRow = null;
            const initialRows = Array.from(document.querySelectorAll('#expenseTableBody tr:not(.horizontal-line)'))
                .map(row => row.outerHTML);

            // Form validation function
            function validateForm(formId) {
                const form = document.getElementById(formId);
                form.addEventListener('submit', function(event) {
                    let isValid = true;
                    let atLeastOneFilled = false;

                    // Custom validation for expenseForm
                    if (formId === 'expenseForm') {
                        const titleInput = form.querySelector('#title');
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
                        const inputs = form.querySelectorAll('input');
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

                // Real-time validation
                if (formId === 'expenseForm') {
                    const inputs = form.querySelectorAll('input, textarea');
                    inputs.forEach(input => {
                        input.addEventListener('input', () => {
                            if (input.id === 'title') {
                                if (!input.value.trim()) {
                                    input.setCustomValidity('Title is required.');
                                } else if (!/^[A-Za-z\s]+$/.test(input.value)) {
                                    input.setCustomValidity('Title must contain only letters and spaces.');
                                } else if (input.value.length > 50) {
                                    input.setCustomValidity('Title must be 50 characters or less.');
                                } else {
                                    input.setCustomValidity('');
                                }
                            } else if (input.id === 'date') {
                                const today = new Date().toISOString().split('T')[0];
                                if (!input.value) {
                                    input.setCustomValidity('Date is required.');
                                } else if (input.value > today) {
                                    input.setCustomValidity('Date must not be a future date.');
                                } else {
                                    input.setCustomValidity('');
                                }
                            } else if (['dailyRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue'].includes(input.id)) {
                                const value = parseFloat(input.value);
                                if (!input.value || isNaN(value)) {
                                    input.setCustomValidity(`${input.id.replace(/([A-Z])/g, ' $1')} is required.`);
                                } else if (value <= 0) {
                                    input.setCustomValidity(`${input.id.replace(/([A-Z])/g, ' $1')} must be greater than 0.`);
                                } else {
                                    input.setCustomValidity('');
                                }
                            } else if (input.id === 'notes') {
                                if (input.value.length > 200) {
                                    input.setCustomValidity('Notes must be less than 200 characters.');
                                } else {
                                    input.setCustomValidity('');
                                }
                            }
                        });
                    });
                }

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
                        } else if (titleInput.value.length > 50) {
                            titleInput.setCustomValidity('Title must be 50 characters or less.');
                        } else {
                            titleInput.setCustomValidity('');
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
                        } else {
                            startDateInput.setCustomValidity('');
                            startDateInput.classList.remove('is-invalid');
                        }
                        if (endDateInput.value && endDateInput.value > today) {
                            endDateInput.setCustomValidity('End Date must not be a future date.');
                            endDateInput.classList.add('is-invalid');
                        } else if (startDateInput.value && endDateInput.value && new Date(endDateInput.value) < new Date(startDateInput.value)) {
                            endDateInput.setCustomValidity('End Date must not be before Start Date.');
                            endDateInput.classList.add('is-invalid');
                        } else {
                            endDateInput.setCustomValidity('');
                            endDateInput.classList.remove('is-invalid');
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
                        } else if (fieldId.startsWith('max') && field.value && pair.value && fieldValue < pairValue) {
                            field.setCustomValidity(`${fieldId.replace(/([A-Z])/g, ' $1')} must not be less than ${pairId.replace(/([A-Z])/g, ' $1')}.`);
                            field.classList.add('is-invalid');
                        } else {
                            field.setCustomValidity('');
                            field.classList.remove('is-invalid');
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
                form.querySelectorAll('input').forEach(input => input.setCustomValidity(''));
            });

            // Expense form submission
            $('#expenseForm').on('submit', function(event) {
                if (this.checkValidity()) {
                    event.preventDefault();

                    const formData = new FormData(this);
                    const data = {
                        title: formData.get('title'),
                        date: formData.get('date'),
                        dailyRevenue: parseFloat(formData.get('dailyRevenue')).toFixed(0),
                        weeklyRevenue: parseFloat(formData.get('weeklyRevenue')).toFixed(0),
                        monthlyRevenue: parseFloat(formData.get('monthlyRevenue')).toFixed(0),
                        yearlyRevenue: parseFloat(formData.get('yearlyRevenue')).toFixed(0),
                        notes: formData.get('notes') || 'N/A'
                    };

                    const tableBody = document.getElementById('expenseTableBody');
                    if (editingRow) {
                        updateRow(editingRow, data);
                    } else {
                        addNewRow(data);
                        initialRows.push(tableBody.lastElementChild.outerHTML); // Add to initialRows for filtering
                    }

                    $('#expenseModal').modal('hide');
                    this.reset();
                    this.classList.remove('was-validated');
                    editingRow = null;
                }
            });

            // Add new row to table
            function addNewRow(data) {
                const tableBody = document.getElementById('expenseTableBody');
                const row = `
                    <tr>
                        <td>${data.title}</td>
                        <td>${data.dailyRevenue}</td>
                        <td>${data.weeklyRevenue}</td>
                        <td>${data.monthlyRevenue}</td>
                        <td>${data.yearlyRevenue}</td>
                        <td>
                            <button class="action-btn view-btn" data-toggle="modal" data-target="#viewModal" 
                                    data-title="${data.title}" data-date="${data.date}" data-daily="${data.dailyRevenue}" 
                                    data-weekly="${data.weeklyRevenue}" data-monthly="${data.monthlyRevenue}" 
                                    data-yearly="${data.yearlyRevenue}" data-notes="${data.notes}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn thumbs-up" data-title="${data.title}"><i class="fas fa-check"></i></button>
                            <button class="action-btn cross" data-title="${data.title}"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                    <tr class="horizontal-line"><td colspan="6"></td></tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            }

            // Update existing row
            function updateRow(row, data) {
                const cells = row.querySelectorAll('td');
                cells[0].textContent = data.title;
                cells[1].textContent = data.dailyRevenue;
                cells[2].textContent = data.weeklyRevenue;
                cells[3].textContent = data.monthlyRevenue;
                cells[4].textContent = data.yearlyRevenue;
                const viewBtn = cells[5].querySelector('.view-btn');
                viewBtn.setAttribute('data-title', data.title);
                viewBtn.setAttribute('data-date', data.date);
                viewBtn.setAttribute('data-daily', data.dailyRevenue);
                viewBtn.setAttribute('data-weekly', data.weeklyRevenue);
                viewBtn.setAttribute('data-monthly', data.monthlyRevenue);
                viewBtn.setAttribute('data-yearly', data.yearlyRevenue);
                viewBtn.setAttribute('data-notes', data.notes);
                cells[5].querySelector('.thumbs-up').setAttribute('data-title', data.title);
                cells[5].querySelector('.cross').setAttribute('data-title', data.title);
            }

            // View modal population
            $('#viewModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget);
                const title = button.data('title');
                const date = button.data('date');
                const daily = button.data('daily');
                const weekly = button.data('weekly');
                const monthly = button.data('monthly');
                const yearly = button.data('yearly');
                const notes = button.data('notes');

                const modal = $(this);
                modal.find('#viewLabel').text(`Revenue Details - ${title}`);
                modal.find('#viewTitle').text(title);
                modal.find('#viewDate').text(date);
                modal.find('#viewDailyRevenue').text(daily);
                modal.find('#viewWeeklyRevenue').text(weekly);
                modal.find('#viewMonthlyRevenue').text(monthly);
                modal.find('#viewYearlyRevenue').text(yearly);
                modal.find('#viewNotes').text(notes);
            });

            // Filter form submission
            $('#filterForm').on('submit', function(event) {
                event.preventDefault();
                if (!this.checkValidity()) return;

                const filterTitle = $('#filterTitle').val().trim().toLowerCase();
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                const minDailyRevenue = parseFloat($('#minDailyRevenue').val()) || 0;
                const maxDailyRevenue = parseFloat($('#maxDailyRevenue').val()) || Infinity;
                const minWeeklyRevenue = parseFloat($('#minWeeklyRevenue').val()) || 0;
                const maxWeeklyRevenue = parseFloat($('#maxWeeklyRevenue').val()) || Infinity;
                const minMonthlyRevenue = parseFloat($('#minMonthlyRevenue').val()) || 0;
                const maxMonthlyRevenue = parseFloat($('#maxMonthlyRevenue').val()) || Infinity;
                const minYearlyRevenue = parseFloat($('#minYearlyRevenue').val()) || 0;
                const maxYearlyRevenue = parseFloat($('#maxYearlyRevenue').val()) || Infinity;

                const filteredRows = initialRows.filter(row => {
                    const rowElement = document.createElement('div');
                    rowElement.innerHTML = row;
                    const title = rowElement.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const dailyRevenue = parseFloat(rowElement.querySelector('td:nth-child(2)').textContent);
                    const weeklyRevenue = parseFloat(rowElement.querySelector('td:nth-child(3)').textContent);
                    const monthlyRevenue = parseFloat(rowElement.querySelector('td:nth-child(4)').textContent);
                    const yearlyRevenue = parseFloat(rowElement.querySelector('td:nth-child(5)').textContent);
                    const date = rowElement.querySelector('.view-btn').getAttribute('data-date');

                    return (!filterTitle || title.includes(filterTitle)) &&
                           (!startDate || new Date(date) >= new Date(startDate)) &&
                           (!endDate || new Date(date) <= new Date(endDate)) &&
                           (dailyRevenue >= minDailyRevenue && dailyRevenue <= maxDailyRevenue) &&
                           (weeklyRevenue >= minWeeklyRevenue && weeklyRevenue <= maxWeeklyRevenue) &&
                           (monthlyRevenue >= minMonthlyRevenue && monthlyRevenue <= maxMonthlyRevenue) &&
                           (yearlyRevenue >= minYearlyRevenue && yearlyRevenue <= maxYearlyRevenue);
                });

                const tableBody = document.getElementById('expenseTableBody');
                tableBody.innerHTML = filteredRows.length ? filteredRows.join('<tr class="horizontal-line"><td colspan="6"></td></tr>') : '<tr><td colspan="6" class="text-center">No records match the filter criteria.</td></tr>';

                $('#filterModal').modal('hide');
                this.reset();
                this.classList.remove('was-validated');
                this.querySelectorAll('input').forEach(input => input.setCustomValidity(''));
            });

            // Approve and Reject functionality
            $(document).on('click', '.thumbs-up', function() {
                const row = $(this).closest('tr');
                const title = $(this).data('title');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    alert(`Revenue "${title}" has already been processed.`);
                    return;
                }
                row.addClass('approved').css('backgroundColor', '#d4edda');
                $(this).prop('disabled', true).css('color', '#28a745');
                row.find('.cross').prop('disabled', true).css('color', '#ccc');
                alert(`Revenue "${title}" approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
            });

            $(document).on('click', '.cross', function() {
                const row = $(this).closest('tr');
                const title = $(this).data('title');
                if (row.hasClass('approved') || row.hasClass('rejected')) {
                    alert(`Revenue "${title}" has already been processed.`);
                    return;
                }
                row.addClass('rejected').css('backgroundColor', '#f8d7da');
                $(this).prop('disabled', true).css('color', '#dc3545');
                row.find('.thumbs-up').prop('disabled', true).css('color', '#ccc');
                alert(`Revenue "${title}" rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
            });

            // Option switching functionality
            $('.option-buttons button').on('click', function() {
                const option = $(this).data('option');
                $('.option-buttons button').removeClass('active');
                $(this).addClass('active');

                const tableBody = document.getElementById('expenseTableBody');
                tableBody.innerHTML = '';

                if (option === 'totalrevenue') {
                    const totalRevenue = [
                        { title: 'Center A', date: '2025-07-30', dailyRevenue: '500', weeklyRevenue: '3500', monthlyRevenue: '15000', yearlyRevenue: '180000', notes: 'N/A' },
                        { title: 'Center B', date: '2025-07-30', dailyRevenue: '300', weeklyRevenue: '2100', monthlyRevenue: '9000', yearlyRevenue: '108000', notes: 'N/A' },
                        { title: 'Center C', date: '2025-07-30', dailyRevenue: '400', weeklyRevenue: '2800', monthlyRevenue: '12000', yearlyRevenue: '144000', notes: 'N/A' }
                    ];
                    totalRevenue.forEach(data => addNewRow(data));
                } else {
                    const centerwiseExpenses = [
                        { title: 'Rent', date: '2025-07-30', dailyRevenue: '500', weeklyRevenue: '3500', monthlyRevenue: '15000', yearlyRevenue: '180000', notes: 'N/A' },
                        { title: 'Food', date: '2025-07-30', dailyRevenue: '300', weeklyRevenue: '2100', monthlyRevenue: '9000', yearlyRevenue: '108000', notes: 'N/A' },
                        { title: 'Rent', date: '2025-07-30', dailyRevenue: '500', weeklyRevenue: '3500', monthlyRevenue: '15000', yearlyRevenue: '180000', notes: 'N/A' }
                    ];
                    centerwiseExpenses.forEach(data => addNewRow(data));
                }
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