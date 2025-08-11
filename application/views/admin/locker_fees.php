<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>Venue Locker Fees</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
            transition: all 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
            padding: 1rem;
        }
        .content-wrapper.minimized {
            margin-left: 4rem;
        }
        .container {
            max-width: 100%;
            width: 100%;
            margin: 1rem auto 0;
            padding: 0 1rem;
        }
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: clamp(0.7rem, 2vw, 1rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
        }
        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        .table-container {
            margin-top: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow-x: auto; /* Enable horizontal scrolling on small screens */
        }
        .table {
            width: 100%;
            min-width: 600px; /* Minimum width to ensure table usability */
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
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
            padding: 0.75rem;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            font-size: clamp(0.6rem, 1.2vw, 0.85rem);
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
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            margin: 0 0.2rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .action-btn.view {
            background-color: #28a745;
            color: white;
        }
        .action-btn.edit {
            background-color: #007bff;
            color: white;
        }
        .action-btn.delete {
            background-color: #dc3545;
            color: white;
        }
        .action-btn:hover {
            filter: brightness(90%);
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 500px;
            margin: 0 auto;
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
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: #343a40;
            width: 100%;
        }
        .close {
            position: absolute;
            right: 0.5rem;
            top: 0.5rem;
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: #343a40;
            opacity: 0.7;
            width: 1.5rem;
            height: 1.5rem;
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
        .form-group label {
            font-weight: 600;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            margin-bottom: 0.3rem;
            color: #495057;
        }
        .form-control, .form-control select {
            height: calc(1.5rem + 2px);
            border-radius: 0.3rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            padding: 0.25rem 0.5rem;
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
            font-size: clamp(0.6rem, 1.2vw, 0.75rem);
            color: #dc3545;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            background: #ffeaea;
        }
        .was-validated .form-control:valid, .form-control.is-valid {
            border-color: #28a745;
        }
        .modal-footer {
            justify-content: center;
            gap: 10px;
            padding: 1rem 0;
            border-top: none;
        }
        .btn-confirm {
            background: #28a745;
            color: white;
            border-radius: 0.25rem;
            padding: 0.4rem 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
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
            padding: 0.4rem 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        @media (max-width: 320px) {
            .content-wrapper { margin-left: 0 !important; padding: 0.5rem; }
            .container { margin-top: 0.5rem; padding: 0 0.5rem; }
            .table { font-size: 0.6rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .action-btn { font-size: 0.6rem; padding: 0.15rem 0.3rem; margin: 0 0.1rem; }
            .modal-content { padding: 0.5rem; width: 95%; }
            .form-row { flex-direction: column; gap: 0.3rem; }
            .form-group { margin-bottom: 0.4rem; }
            .add-btn-container { justify-content: center; flex-direction: column; gap: 0.3rem; }
            .btn-custom { font-size: 0.65rem; padding: 0.25rem 0.5rem; }
            .modal-title { font-size: 0.9rem; }
            .form-group label { font-size: 0.65rem; }
            .form-control, .form-control select { height: calc(1.4rem + 2px); font-size: 0.65rem; padding: 0.2rem 0.3rem; }
        }
        @media (min-width: 321px) and (max-width: 576px) {
            .content-wrapper { margin-left: 0 !important; padding: 0.75rem; }
            .container { margin-top: 0.75rem; padding: 0 0.75rem; }
            .table { font-size: 0.7rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .action-btn { font-size: 0.7rem; padding: 0.2rem 0.4rem; margin: 0 0.15rem; }
            .modal-content { padding: 0.75rem; width: 90%; }
            .form-row { flex-direction: column; gap: 0.5rem; }
            .form-group { margin-bottom: 0.5rem; }
            .add-btn-container { justify-content: center; flex-direction: column; gap: 0.5rem; }
            .btn-custom { font-size: 0.75rem; padding: 0.3rem 0.6rem; }
            .modal-title { font-size: 1rem; }
            .form-group label { font-size: 0.7rem; }
            .form-control, .form-control select { height: calc(1.5rem + 2px); font-size: 0.7rem; padding: 0.2rem 0.4rem; }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .content-wrapper { margin-left: 0 !important; padding: 1rem; }
            .table { font-size: 0.8rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .modal-content { padding: 1rem; width: 85%; }
            .form-row { flex-direction: row; gap: 0.75rem; }
            .add-btn-container { justify-content: flex-end; gap: 0.75rem; }
            .btn-custom { font-size: 0.8rem; }
            .form-group label { font-size: 0.75rem; }
            .form-control, .form-control select { height: calc(1.6rem + 2px); font-size: 0.75rem; padding: 0.25rem 0.5rem; }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper { margin-left: 12rem; }
            .modal-content { max-width: 450px; }
            .table { font-size: 0.85rem; }
            .form-group label { font-size: 0.8rem; }
            .form-control, .form-control select { height: calc(1.7rem + 2px); font-size: 0.8rem; }
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .content-wrapper { margin-left: 14rem; }
            .modal-content { max-width: 480px; }
            .table { font-size: 0.9rem; }
            .form-group label { font-size: 0.85rem; }
            .form-control, .form-control select { height: calc(1.8rem + 2px); font-size: 0.85rem; }
        }
        @media (min-width: 1201px) and (max-width: 1599px) {
            .content-wrapper { margin-left: 15rem; }
            .modal-content { max-width: 500px; }
            .table { font-size: 0.95rem; }
            .form-group label { font-size: 0.9rem; }
            .form-control, .form-control select { height: calc(1.9rem + 2px); font-size: 0.9rem; }
        }
        @media (min-width: 1600px) {
            .content-wrapper { margin-left: 16rem; }
            .modal-content { max-width: 520px; }
            .table { font-size: 1rem; }
            .btn-custom { font-size: 1rem; padding: 0.5rem 1rem; }
            .form-group label { font-size: 0.95rem; }
            .form-control, .form-control select { height: calc(2rem + 2px); font-size: 0.95rem; }
        }
        @media (hover: none) {
            .action-btn:hover, .btn-custom:hover, .close:hover { transform: none; background-color: inherit; box-shadow: none; }
        }
        .view-modal-content {
            padding: 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
        }
        .view-modal-content p {
            margin-bottom: 0.5rem;
        }
        .form-control{
                padding: 1.375rem .75rem !important;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('admin/Include/Navbar') ?>
    <div class="content-wrapper" id="contentWrapper">
        <div class="container">
            <div class="add-btn-container">
                <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                <button class="btn btn-custom" data-toggle="modal" data-target="#expenseModal">
                    <i class="fas fa-plus mr-1"></i> Add Venue Locker Fee
                </button>
            </div>
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Venue</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Racket Fee</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <?php if (!empty($locker_fees)): ?>
                            <?php foreach ($locker_fees as $fee): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($fee->venue); ?></td>
                                    <td><?php echo htmlspecialchars($fee->title); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($fee->date)); ?></td>
                                    <td>Rs.<?php echo number_format($fee->amount, 2); ?></td>
                                    <td><?php echo htmlspecialchars($fee->description); ?></td>
                                    <td>
                                        <button class="action-btn view" data-id="<?php echo $fee->id; ?>" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit" data-id="<?php echo $fee->id; ?>" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete" data-id="<?php echo $fee->id; ?>" onclick="deleteExpense(this)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="horizontal-line"><td colspan="6"></td></tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add/Edit Modal -->
    <div class="modal fade add-modal" id="expenseModal" tabindex="-1" aria-labelledby="expenseLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="expenseLabel">Add Venue Locker Fee</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" novalidate>
                    <input type="hidden" id="expenseId" name="expenseId">
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-12 col-md-6">
                            <label for="venue">Venue <span class="text-danger">*</span></label>
                            <select id="venue" name="venue" class="form-control" required>
                                <option value="">Select Venue</option>
                                <option value="Main Hall">Main Hall</option>
                                <option value="Outdoor Court">Outdoor Court</option>
                                <option value="Indoor Arena">Indoor Arena</option>
                            </select>
                            <div class="invalid-feedback">Please select a venue</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Title is required, letters and spaces only, max 50 characters.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-12 col-md-6">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required max="<?php echo date('Y-m-d'); ?>">
                            <div class="invalid-feedback">Date is required and must not be a future date.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="amount">Racket Fee (₹) <span class="text-danger">*</span></label>
                            <input type="number" id="amount" name="amount" class="form-control" step="0.01" min="0.01" required>
                            <div class="invalid-feedback">Racket fee is required and must be greater than 0.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" required maxlength="200" rows="2"></textarea>
                        <div class="invalid-feedback">Description is required, max 200 characters.</div>
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
                    <h3 class="modal-title w-100" id="filterLabel">Filter Locker Fees</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="form-note text-center mb-2" style="font-size: clamp(0.7rem, 1.5vw, 0.85rem);">Fill at least one field to apply a filter.</div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterVenue">Venue</label>
                            <select id="filterVenue" name="filterVenue" class="form-control">
                                <option value="">All Venues</option>
                                <option value="Main Hall">Main Hall</option>
                                <option value="Outdoor Court">Outdoor Court</option>
                                <option value="Indoor Arena">Indoor Arena</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterTitle">Title</label>
                            <input type="text" id="filterTitle" name="filterTitle" class="form-control" pattern="[A-Za-z\s]+" maxlength="50">
                            <div class="invalid-feedback">Title must contain only letters and spaces, max 50 characters.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterDate">Date</label>
                            <input type="date" id="filterDate" name="filterDate" class="form-control" max="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterMinAmount">Min Racket Fee (₹)</label>
                            <input type="number" id="filterMinAmount" name="filterMinAmount" class="form-control" step="0.01" min="0">
                            <div class="invalid-feedback">Min amount must be a valid number.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex align-items-center">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterMaxAmount">Max Racket Fee (₹)</label>
                            <input type="number" id="filterMaxAmount" name="filterMaxAmount" class="form-control" step="0.01" min="0">
                            <div class="invalid-feedback">Max amount must be a valid number.</div>
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
    <!-- View Modal -->
    <div class="modal fade view-modal" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="viewLabel">Locker Fee Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="view-modal-content" id="viewModalContent">
                    <!-- Content will be populated dynamically -->
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let editingRow = null;
            let csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';

            // Utility function for number formatting
            function number_format(number, decimals = 2) {
                return Number(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Reset expense modal on close
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
                $('#expenseLabel').text('Add Venue Locker Fee');
            });

            // Reset filter modal on close
            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                loadAllLockerFees();
            });

            // Validate expense form
            function validateExpenseForm() {
                const form = document.getElementById('expenseForm');
                let isValid = true;

                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const venue = form.querySelector('#venue');
                const title = form.querySelector('#title');
                const date = form.querySelector('#date');
                const amount = form.querySelector('#amount');
                const description = form.querySelector('#description');

                if (!venue.value) {
                    venue.setCustomValidity('Venue is required.');
                    if (form.classList.contains('was-validated')) venue.classList.add('is-invalid');
                    isValid = false;
                } else {
                    venue.classList.add('is-valid');
                }

                if (!title.value.trim()) {
                    title.setCustomValidity('Title is required.');
                    if (form.classList.contains('was-validated')) title.classList.add('is-invalid');
                    isValid = false;
                } else if (!/^[A-Za-z\s]+$/.test(title.value)) {
                    title.setCustomValidity('Title must contain only letters and spaces.');
                    if (form.classList.contains('was-validated')) title.classList.add('is-invalid');
                    isValid = false;
                } else if (title.value.length > 50) {
                    title.setCustomValidity('Title must be 50 characters or less.');
                    if (form.classList.contains('was-validated')) title.classList.add('is-invalid');
                    isValid = false;
                } else {
                    title.classList.add('is-valid');
                }

                const today = new Date().toISOString().split('T')[0];
                if (!date.value) {
                    date.setCustomValidity('Date is required.');
                    if (form.classList.contains('was-validated')) date.classList.add('is-invalid');
                    isValid = false;
                } else if (date.value > today) {
                    date.setCustomValidity('Date must not be a future date.');
                    if (form.classList.contains('was-validated')) date.classList.add('is-invalid');
                    isValid = false;
                } else {
                    date.classList.add('is-valid');
                }

                if (!amount.value || isNaN(amount.value) || amount.value <= 0) {
                    amount.setCustomValidity('Amount must be greater than 0.');
                    if (form.classList.contains('was-validated')) amount.classList.add('is-invalid');
                    isValid = false;
                } else {
                    amount.classList.add('is-valid');
                }

                if (!description.value.trim()) {
                    description.setCustomValidity('Description is required.');
                    if (form.classList.contains('was-validated')) description.classList.add('is-invalid');
                    isValid = false;
                } else if (description.value.length > 200) {
                    description.setCustomValidity('Description must be 200 characters or less.');
                    if (form.classList.contains('was-validated')) description.classList.add('is-invalid');
                    isValid = false;
                } else {
                    description.classList.add('is-valid');
                }

                return isValid;
            }

            // Validate filter form
            function validateFilterForm() {
                const form = document.getElementById('filterForm');
                let isValid = true;
                let atLeastOneFilled = false;

                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const filterVenue = form.querySelector('#filterVenue');
                const filterTitle = form.querySelector('#filterTitle');
                const filterDate = form.querySelector('#filterDate');
                const filterMinAmount = form.querySelector('#filterMinAmount');
                const filterMaxAmount = form.querySelector('#filterMaxAmount');

                if (filterVenue.value || filterTitle.value.trim() || filterDate.value || filterMinAmount.value || filterMaxAmount.value) {
                    atLeastOneFilled = true;
                }

                if (!atLeastOneFilled) {
                    filterVenue.setCustomValidity('At least one filter field must be filled.');
                    if (form.classList.contains('was-validated')) filterVenue.classList.add('is-invalid');
                    isValid = false;
                } else {
                    filterVenue.classList.add('is-valid');
                }

                if (filterTitle.value.trim()) {
                    if (!/^[A-Za-z\s]+$/.test(filterTitle.value)) {
                        filterTitle.setCustomValidity('Title must contain only letters and spaces.');
                        if (form.classList.contains('was-validated')) filterTitle.classList.add('is-invalid');
                        isValid = false;
                    } else if (filterTitle.value.length > 50) {
                        filterTitle.setCustomValidity('Title must be 50 characters or less.');
                        if (form.classList.contains('was-validated')) filterTitle.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        filterTitle.classList.add('is-valid');
                    }
                }

                const today = new Date().toISOString().split('T')[0];
                if (filterDate.value && filterDate.value > today) {
                    filterDate.setCustomValidity('Date must not be a future date.');
                    if (form.classList.contains('was-validated')) filterDate.classList.add('is-invalid');
                    isValid = false;
                } else if (filterDate.value) {
                    filterDate.classList.add('is-valid');
                }

                if (filterMinAmount.value && (isNaN(filterMinAmount.value) || filterMinAmount.value < 0)) {
                    filterMinAmount.setCustomValidity('Min amount must be a valid number.');
                    if (form.classList.contains('was-validated')) filterMinAmount.classList.add('is-invalid');
                    isValid = false;
                } else if (filterMinAmount.value) {
                    filterMinAmount.classList.add('is-valid');
                }

                if (filterMaxAmount.value && (isNaN(filterMaxAmount.value) || filterMaxAmount.value < 0)) {
                    filterMaxAmount.setCustomValidity('Max amount must be a valid number.');
                    if (form.classList.contains('was-validated')) filterMaxAmount.classList.add('is-invalid');
                    isValid = false;
                } else if (filterMaxAmount.value) {
                    filterMaxAmount.classList.add('is-valid');
                }

                return isValid;
            }

            // Load all locker fees (used when clearing filters)
            function loadAllLockerFees() {
                $.ajax({
                    url: '<?php echo base_url('admincontroller/locker_fees/index'); ?>',
                    type: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(data) {
                        const tableBody = $('#expenseTableBody');
                        tableBody.empty();
                        if (data.locker_fees.length === 0) {
                            tableBody.append('<tr><td colspan="6" class="text-center">No records found.</td></tr>');
                        } else {
                            data.locker_fees.forEach(item => {
                                const row = `
                                    <tr>
                                        <td>${item.venue}</td>
                                        <td>${item.title}</td>
                                        <td>${new Date(item.date).toLocaleDateString('en-GB')}</td>
                                        <td>Rs.${number_format(item.amount, 2)}</td>
                                        <td>${item.description}</td>
                                        <td>
                                            <button class="action-btn view" data-id="${item.id}" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                            <button class="action-btn edit" data-id="${item.id}" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                            <button class="action-btn delete" data-id="${item.id}" onclick="deleteExpense(this)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr class="horizontal-line"><td colspan="6"></td></tr>
                                `;
                                tableBody.append(row);
                            });
                        }
                        csrfToken = data.csrf_token || csrfToken;
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error loading locker fees.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Submit expense form (add/edit)
            $('#expenseForm').on('submit', function(e) {
                e.preventDefault();
                if (validateExpenseForm()) {
                    const formData = new FormData(this);
                    const data = {
                        [csrfName]: csrfToken,
                        venue: formData.get('venue'),
                        title: formData.get('title'),
                        date: formData.get('date'),
                        amount: parseFloat(formData.get('amount')).toFixed(2),
                        description: formData.get('description'),
                        id: formData.get('expenseId') || null
                    };
                    const url = data.id ? '<?php echo base_url('admincontroller/locker_fees/update'); ?>' : '<?php echo base_url('admincontroller/locker_fees/add'); ?>';
                    const action = data.id ? 'updated' : 'added';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#expenseModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: `Locker fee ${action} successfully`,
                                    showConfirmButton: true,
                                    timer: 3000
                                }).then(() => {
                                    if (!data.id) {
                                        const newRow = `
                                            <tr>
                                                <td>${data.venue}</td>
                                                <td>${data.title}</td>
                                                <td>${new Date(data.date).toLocaleDateString('en-GB')}</td>
                                                <td>Rs.${number_format(data.amount, 2)}</td>
                                                <td>${data.description}</td>
                                                <td>
                                                    <button class="action-btn view" data-id="${response.insert_id}" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                                    <button class="action-btn edit" data-id="${response.insert_id}" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                                    <button class="action-btn delete" data-id="${response.insert_id}" onclick="deleteExpense(this)"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr class="horizontal-line"><td colspan="6"></td></tr>
                                        `;
                                        $('#expenseTableBody').prepend(newRow);
                                        if ($('#expenseTableBody tr').length === 2) {
                                            $('#expenseTableBody tr:last').remove();
                                        }
                                    } else {
                                        editingRow.find('td:nth-child(1)').text(data.venue);
                                        editingRow.find('td:nth-child(2)').text(data.title);
                                        editingRow.find('td:nth-child(3)').text(new Date(data.date).toLocaleDateString('en-GB'));
                                        editingRow.find('td:nth-child(4)').text(`Rs.${number_format(data.amount, 2)}`);
                                        editingRow.find('td:nth-child(5)').text(data.description);
                                    }
                                    csrfToken = response.csrf_token || csrfToken;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || `Error ${action} locker fee.`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: `An error occurred while ${action} the locker fee. Please try again.`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            console.log('AJAX Error: ', status, error);
                        }
                    });
                }
                this.classList.add('was-validated');
            });

            // Submit filter form
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                if (validateFilterForm()) {
                    const formData = new FormData(this);
                    const filters = {
                        [csrfName]: csrfToken,
                        filterVenue: formData.get('filterVenue') || '',
                        filterTitle: formData.get('filterTitle') || '',
                        filterDate: formData.get('filterDate') || '',
                        filterMinAmount: formData.get('filterMinAmount') || '',
                        filterMaxAmount: formData.get('filterMaxAmount') || ''
                    };

                    $.ajax({
                        url: '<?php echo base_url('admincontroller/locker_fees/filter'); ?>',
                        type: 'POST',
                        data: filters,
                        dataType: 'json',
                        success: function(data) {
                            const tableBody = $('#expenseTableBody');
                            tableBody.empty();
                            if (data.locker_fees.length === 0) {
                                tableBody.append('<tr><td colspan="6" class="text-center">No records match the filter criteria.</td></tr>');
                            } else {
                                data.locker_fees.forEach(item => {
                                    const row = `
                                        <tr>
                                            <td>${item.venue}</td>
                                            <td>${item.title}</td>
                                            <td>${new Date(item.date).toLocaleDateString('en-GB')}</td>
                                            <td>Rs.${number_format(item.amount, 2)}</td>
                                            <td>${item.description}</td>
                                            <td>
                                                <button class="action-btn view" data-id="${item.id}" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                                <button class="action-btn edit" data-id="${item.id}" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                                <button class="action-btn delete" data-id="${item.id}" onclick="deleteExpense(this)"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr class="horizontal-line"><td colspan="6"></td></tr>
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
                            csrfToken = data.csrf_token || csrfToken;
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

            // View expense details
            window.viewExpense = function(button) {
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('admincontroller/locker_fees/get_by_id'); ?>/' + id,
                    type: 'GET',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const fee = response.data;
                            $('#viewModalContent').html(`
                                <p><strong>Venue:</strong> ${fee.venue}</p>
                                <p><strong>Title:</strong> ${fee.title}</p>
                                <p><strong>Date:</strong> ${new Date(fee.date).toLocaleDateString('en-GB')}</p>
                                <p><strong>Racket Fee:</strong> Rs.${number_format(fee.amount, 2)}</p>
                                <p><strong>Description:</strong> ${fee.description || 'No description'}</p>
                            `);
                            $('#viewModal').modal('show');
                            csrfToken = response.csrf_token || csrfToken;
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
                            text: 'Error fetching locker fee details.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Edit expense
            window.editExpense = function(button) {
                editingRow = $(button).closest('tr');
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('admincontroller/locker_fees/get_by_id'); ?>/' + id,
                    type: 'GET',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const fee = response.data;
                            $('#expenseId').val(fee.id);
                            $('#venue').val(fee.venue);
                            $('#title').val(fee.title);
                            $('#date').val(fee.date);
                            $('#amount').val(fee.amount);
                            $('#description').val(fee.description);
                            $('#expenseLabel').text('Edit Venue Locker Fee');
                            $('#expenseModal').modal('show');
                            $('#expenseForm').find('input, textarea, select').trigger('input');
                            csrfToken = response.csrf_token || csrfToken;
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
                            text: 'Error fetching locker fee details.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Delete expense
            window.deleteExpense = function(button) {
                const id = $(button).data('id');
                const row = $(button).closest('tr');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo base_url('admincontroller/locker_fees/delete'); ?>/' + id,
                            type: 'POST',
                            data: { [csrfName]: csrfToken },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    row.next('.horizontal-line').remove();
                                    row.remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                    csrfToken = response.csrf_token || csrfToken;
                                    if ($('#expenseTableBody tr').length === 0) {
                                        $('#expenseTableBody').append('<tr><td colspan="6" class="text-center">No records found.</td></tr>');
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
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error deleting locker fee.',
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Sidebar toggle
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

            // Real-time validation for expense form
            $('#expenseForm input, #expenseForm textarea, #expenseForm select').on('input change', function() {
                validateExpenseForm();
            });

            // Real-time validation for filter form
            $('#filterForm input, #filterForm select').on('input change', function() {
                validateFilterForm();
            });

            // Remove focus from buttons after click
            $('.btn-custom, .action-btn').on('click', function() {
                $(this).blur();
            });
        });
    </script>
</body>
</html>