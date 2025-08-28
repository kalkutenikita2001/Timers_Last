<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>Student Management System</title>
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
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
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        .status-inactive {
            background-color: rgba(231, 74, 59, 0.2);
            color: #e74a3b;
        }
        .status-pending {
            background-color: rgba(246, 194, 62, 0.2);
            color: #f6c23e;
        }
        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .main-content {
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        .main-content.minimized {
            margin-left: 60px;
        }
        .content-wrapper {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
        }
        .content-wrapper.minimized {
            margin-left: 60px;
        }
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow-x: auto;
        }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
            min-width: 600px;
        }
        .table th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
            color: #000;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.85rem;
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
        .clickable {
            cursor: pointer;
        }
        .clickable:hover {
            background-color: #f8f9fa;
        }
        .btn-tooltip {
            position: relative;
            font-size: 0.85rem;
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .btn-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 100;
        }
        .action-btn.edit-btn {
            background-color: #ffc107;
            color: #000;
        }
        .action-btn.delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .action-btn.view-btn {
            background-color: #28a745;
            color: white;
        }
        .action-btn.renew-btn {
            background-color: #17a2b8;
            color: white;
        }
        .action-btn:hover:not(:disabled) {
            filter: brightness(90%);
        }
        .action-btn:disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
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
            flex: 0 0 50%;
            max-width: 50%;
        }
        .step-nav {
            display: flex;
            justify-content: space-between;
            background-color: #e9ecef;
            border-radius: 0.5rem 0.5rem 0 0;
            padding: 1rem;
            margin-bottom: 1.5rem;
            gap: 30px;
            flex-wrap: wrap;
        }
        .step-nav span {
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            color: #6c757d;
            position: relative;
            transition: color 0.3s ease;
        }
        .step-nav span i {
            margin-left: 10px;
            font-size: 1.5rem;
            color: #007bff;
            transition: color 0.3s ease;
        }
        .step-nav span.step-active {
            color: #007bff;
            font-weight: 700;
        }
        .step-nav span.step-active i {
            color: #0056b3;
        }
        .receipt-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .receipt-card p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            color: #343a40;
        }
        .receipt-card p strong {
            color: #1a1a1a;
            font-weight: 600;
        }
        .modal-footer {
            border-top: none;
            padding-top: 1rem;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }
        .modal-footer .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 0.375rem;
            padding: 0.6rem 1.25rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .modal-footer .btn-secondary:hover {
            background-color: #5a6268;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
            min-width: 120px;
        }
        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        @media (max-width: 576px) {
            .main-content {
                margin-left: 0 !important;
                padding: 0.5rem !important;
            }
            .content-wrapper {
                margin-left: 0 !important;
            }
            .container-fluid {
                padding: 0 0.5rem;
            }
            .table {
                font-size: 0.7rem;
                min-width: 100%;
            }
            .table th:nth-child(4), .table td:nth-child(4),
            .table th:nth-child(7), .table td:nth-child(7) {
                display: none;
            }
            .action-btn {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
            .modal-content {
                padding: 0.8rem;
                margin-top: 30px;
            }
            .form-row {
                flex-direction: column;
                gap: 0.5rem;
                margin-bottom: 0.5rem;
            }
            .form-group {
                padding: 0;
                margin-bottom: 0.6rem;
                flex: 0 0 100%;
                max-width: 100%;
            }
            .card-header .d-flex {
                justify-content: center;
                flex-direction: column;
                gap: 0.5rem;
            }
            .btn-custom {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }
            .step-nav {
                flex-direction: column;
                gap: 0.5rem;
                padding: 0.75rem;
            }
            .step-nav span {
                font-size: 0.7rem;
                padding: 5px;
            }
            .step-nav span i {
                font-size: 1rem;
                margin-left: 8px;
            }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .main-content {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .content-wrapper {
                margin-left: 0 !important;
            }
            .container-fluid {
                margin-top: 3.5rem;
                padding: 0 0.75rem;
            }
            .table {
                font-size: 0.8rem;
            }
            .table th:nth-child(7), .table td:nth-child(7) {
                display: none;
            }
            .action-btn {
                font-size: 0.8rem;
                padding: 0.3rem 0.5rem;
            }
            .modal-content {
                padding: 0.9rem;
                margin-top: 40px;
            }
            .form-row {
                flex-direction: row;
                flex-wrap: wrap;
            }
            .form-group {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .card-header .d-flex {
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .btn-custom {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
            .step-nav {
                gap: 0.75rem;
            }
            .step-nav span {
                font-size: 0.8rem;
            }
            .step-nav span i {
                font-size: 1.2rem;
                margin-left: 8px;
            }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .main-content {
                margin-left: 250px;
            }
            .content-wrapper {
                margin-left: 250px;
            }
            .main-content.minimized {
                margin-left: 60px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .container-fluid {
                margin-top: 4rem;
                padding: 0 1rem;
            }
            .table {
                font-size: 0.9rem;
            }
            .modal-content {
                max-width: calc(450px + 2vw);
                margin-top: 60px;
            }
            .step-nav {
                gap: 25px;
            }
            .step-nav span i {
                font-size: 1.4rem;
                margin-left: 10px;
            }
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .content-wrapper {
                margin-left: 250px;
            }
            .main-content.minimized {
                margin-left: 60px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .container-fluid {
                padding: 0 1rem;
            }
            .modal-content {
                max-width: calc(480px + 2vw);
                margin-top: 65px;
            }
        }
        @media (min-width: 1201px) {
            .content-wrapper {
                margin-left: 250px;
            }
            .main-content.minimized {
                margin-left: 60px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .container-fluid {
                padding: 0 1rem;
            }
            .modal-content {
                max-width: 800px;
                margin-top: 65px;
            }
        }
        @media (min-width: 1600px) {
            .main-content {
                margin-left: 250px;
            }
            .content-wrapper {
                margin-left: 250px;
            }
            .main-content.minimized {
                margin-left: 60px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .container-fluid {
                margin-top: 4rem;
                padding: 0 1rem;
            }
            .modal-content {
                max-width: calc(520px + 2vw);
                margin-top: 65px;
            }
            .table {
                font-size: 1rem;
            }
            .btn-custom {
                font-size: 1.1rem;
                padding: 0.6rem 1.2rem;
            }
        }
        @media (hover: none) {
            .action-btn:hover,
            .btn-custom:hover,
            .close:hover {
                transform: none;
                background-color: inherit;
                box-shadow: none;
            }
        }
        .form-control {
            padding: 1.375rem .75rem;
        }
       
    </style> 
</head>
<body class="bg-light">
   
 <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>
<!-- =------------------------------------------------------------------------------------------------------------------- -->

    <!-- Main Content Wrapper -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col">
                    <h2 class="mb-4"><i class="fas fa-users me-2"></i>Student Management</h2>
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Student List</h5>
                            <div class="d-flex gap-2">
                                <!-- Add Student and Filter buttons removed -->
                            </div>
                        </div>
                        <div class="card-body">

                            <!-- Search and Filter -->
                            <div class="row mb-3">
                                <!-- Search Input -->
                                <div class="col-12 col-md-6 mb-2 mb-md-0">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Search students...">
                                    </div>
                                </div>
                                
                                <!-- Filters & Export -->
                                <div class="col-12 col-md-6">
                                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-end">
                                        <select class="form-select w-100 w-md-auto" id="statusFilter">
                                            <option value="">All Statuses</option>
                                            <option value="active">Active</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                        <select class="form-select w-100 w-md-auto" id="categoryFilter">
                                            <option value="">All Categories</option>
                                            <option value="Beginner">Beginner</option>
                                            <option value="Intermediate">Intermediate</option>
                                            <option value="Advanced">Advanced</option>
                                        </select>
                                        <button class="btn btn-outline-primary w-100 w-md-auto" id="exportBtn">
                                            <i class="fas fa-download me-1"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- ------------------------------------------------------------------------------------------- -->
                            <!-- Student Table -->
                            <div class="table-container">
                                <table class="table table-bordered table-hover" id="studentTable">
                                    <thead>
                                        <tr>
                                            <th class="clickable" data-sort="name">Name <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="id">ID <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="batch">Batch <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="center">Center <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="contact">Contact <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="category">Category <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="plan_expiry">Plan Expiry <i class="fas fa-sort"></i></th>
                                            <th class="clickable" data-sort="status">Status <i class="fas fa-sort"></i></th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="studentTableBody">
                                        <!-- Data will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            <nav aria-label="Page navigation" class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="editLabel" class="modal-title w-100 text-center">Edit Student</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" novalidate>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editName">Name <span class="text-danger">*</span></label>
                            <input type="text" id="editName" name="editName" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces" minlength="2" maxlength="50" placeholder="Enter Name"/>
                            <div class="invalid-feedback">Please enter a valid name (2-50 letters and spaces only).</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editContact">Contact <span class="text-danger">*</span></label>
                            <input type="tel" id="editContact" name="editContact" class="form-control" required pattern="[0-9]{10}" title="Contact should be a 10-digit number" maxlength="10" placeholder="Enter Contact"/>
                            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editCenter">Center <span class="text-danger">*</span></label>
                            <select id="editCenter" name="editCenter" class="form-control" required>
                                <option value="">-- Select Center --</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid center.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editBatch">Batch <span class="text-danger">*</span></label>
                            <select id="editBatch" name="editBatch" class="form-control" required>
                                <option value="">-- Select Batch --</option>
                            </select>
                            <div class="invalid-feedback">Please select a valid batch.</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editCategory">Category <span class="text-danger">*</span></label>
                            <select id="editCategory" name="editCategory" class="form-control" required>
                                <option value="">Select</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <div class="invalid-feedback">Please select a category.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Receipt View Modal -->
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="receiptLabel" class="modal-title w-100 text-center">Admission Receipt</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="receipt-card">
                        <p><strong>Name:</strong> <span id="receiptName"></span></p>
                        <p><strong>Contact:</strong> <span id="receiptContact"></span></p>
                        <p><strong>Center:</strong> <span id="receiptCenter"></span></p>
                        <p><strong>Batch:</strong> <span id="receiptBatch"></span></p>
                        <p><strong>Category:</strong> <span id="receiptCategory"></span></p>
                        <p><strong>Total Fees:</strong> Rs. <span id="receiptTotalFees"></span></p>
                        <p><strong>Amount Paid:</strong> Rs. <span id="receiptAmountPaid"></span></p>
                        <p><strong>Remaining Amount:</strong> Rs. <span id="receiptRemainingAmount"></span></p>
                        <p><strong>Payment Method:</strong> <span id="receiptPaymentMethod"></span></p>
                        <p><strong>Attendance Link:</strong> <a id="attendancelink" href="#" target="_blank" style="word-break: break-all; display: inline-block; max-width: 100%;"></a></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Renew Admission Modal -->
    <div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="renewLabel" class="modal-title w-100 text-center">Renew Admission</h3>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="step-nav">
                    <span class="step-active">1. Renew Fees <i class="fas fa-arrow-right"></i></span>
                </div>
                <form id="renewForm" novalidate>
                    <input type="hidden" id="renewName" name="renewName">
                    <input type="hidden" id="renewContact" name="renewContact">
                    <input type="hidden" id="renewCenter" name="renewCenter">
                    <input type="hidden" id="renewBatch" name="renewBatch">
                    <input type="hidden" id="renewCategory" name="renewCategory">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="renewTotalFees">Total Fees <span class="text-danger">*</span></label>
                            <input type="number" id="renewTotalFees" name="renewTotalFees" class="form-control" required min="1" max="100000" title="Total fees must be between 1 and 100,000" placeholder="Enter Total Fees"/>
                            <div class="invalid-feedback">Please enter a valid total fees amount (1-100,000).</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="renewAmountPaid">Amount Paid <span class="text-danger">*</span></label>
                            <input type="number" id="renewAmountPaid" name="renewAmountPaid" class="form-control" required min="0" title="Amount paid must be a positive number or zero" placeholder="Enter Amount Paid"/>
                            <div class="invalid-feedback">Please enter a valid amount paid (0 or more, not exceeding total fees).</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="renewRemainingAmount">Remaining Amount <span class="text-danger">*</span></label>
                            <input type="number" id="renewRemainingAmount" name="renewRemainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly placeholder="Remaining Amount"/>
                            <div class="invalid-feedback">Please ensure remaining amount is valid.</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="renewPaymentMethod">Payment Method <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check">
                                    <input type="radio" id="renewCash" name="renewPaymentMethod" class="form-check-input" value="Cash" required>
                                    <label class="form-check-label" for="renewCash">Cash</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="renewOnline" name="renewPaymentMethod" class="form-check-input" value="Online">
                                    <label class="form-check-label" for="renewOnline">Online</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please select a payment method.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom">Renew Admission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            const forms = ['editForm', 'renewForm'].map(id => document.getElementById(id));
            const tableBody = document.querySelector('#studentTableBody');
            const baseUrl = '<?php echo base_url(); ?>';
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const exportBtn = document.getElementById('exportBtn');

            // Function to load centers dynamically
            function loadCenters(selectElement) {
                $.ajax({
                    url: baseUrl + 'Admission/get_centers',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log('loadCenters response:', response);
                        selectElement.innerHTML = '<option value="">-- Select Center --</option>';
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(center => {
                                selectElement.insertAdjacentHTML('beforeend', `<option value="${center.id}">${center.name}</option>`);
                            });
                        } else {
                            selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>No centers available</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('loadCenters error:', xhr.responseText, status, error);
                        selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>Error loading centers</option>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load centers: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            }

            // Function to load batches dynamically
            function loadBatches(selectElement, centerId) {
                $.ajax({
                    url: baseUrl + 'Admission/get_batches/' + centerId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log('loadBatches response:', response);
                        selectElement.innerHTML = '<option value="">-- Select Batch --</option>';
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(batch => {
                                selectElement.insertAdjacentHTML('beforeend', `<option value="${batch.id}">${batch.timing}</option>`);
                            });
                        } else {
                            selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>No batches available</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('loadBatches error:', xhr.responseText, status, error);
                        selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>Error loading batches</option>');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load batches: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            }

            // Load initial students
            function loadStudents() {
                $.ajax({
                    url: '<?= base_url('Admission/get_students') ?>',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('loadStudents response:', response);
                        tableBody.innerHTML = '';
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(student => {
                                const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(student.name || 'N/A')}&background=4e73df&color=fff`;
                                const planExpiry = student.joining_date ? new Date(new Date(student.joining_date).getTime() + (student.duration * 30 * 24 * 60 * 60 * 1000)).toISOString().split('T')[0] : 'N/A';
                                const status = student.remaining_amount <= 0 ? 'Active' : 'Pending';
                                const row = `
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="${avatarUrl}" alt="Avatar" class="student-avatar">
                                                <div>
                                                    <div>${student.name || 'N/A'}</div>
                                                    <small class="text-muted">${student.email || 'N/A'}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${student.id || 'N/A'}</td>
                                        <td>${student.batch_timing || 'N/A'}</td>
                                        <td>${student.center_name || 'N/A'}</td>
                                        <td>${student.contact || 'N/A'}</td>
                                        <td>${student.category || 'N/A'}</td>
                                        <td>${planExpiry}</td>
                                        <td><span class="status-badge status-${status.toLowerCase()}">${status}</span></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="action-btn view-btn btn-tooltip" data-bs-toggle="modal" data-bs-target="#receiptModal" data-id="${student.id}" data-tooltip="View Details"><i class="fas fa-eye"></i></button>
                                                <button class="action-btn edit-btn btn-tooltip" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${student.id}" data-tooltip="Edit Student"><i class="fas fa-edit"></i></button>
                                                <button class="action-btn delete-btn btn-tooltip" data-id="${student.id}" data-tooltip="Delete Student"><i class="fas fa-trash"></i></button>
                                                <button class="action-btn renew-btn btn-tooltip" data-bs-toggle="modal" data-bs-target="#renewModal" data-id="${student.id}" data-tooltip="Renew Access"><i class="fas fa-sync"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="horizontal-line"><td colspan="9"></td></tr>
                                `;
                                tableBody.insertAdjacentHTML('beforeend', row);
                            });
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="9" class="text-center">No students found.</td></tr>';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('loadStudents error:', xhr.responseText, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load students: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                        tableBody.innerHTML = '<tr><td colspan="9" class="text-center">No students found.</td></tr>';
                    }
                });
            }

            // Initial load
            loadStudents();
            loadCenters(document.getElementById('editCenter'));

            // Form validation
            forms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    let isValid = form.checkValidity();
                    if (form.id === 'renewForm') {
                        const totalFeesInput = form.querySelector('#renewTotalFees');
                        const amountPaidInput = form.querySelector('#renewAmountPaid');
                        const totalFees = parseFloat(totalFeesInput.value) || 0;
                        const amountPaid = parseFloat(amountPaidInput.value) || 0;
                        if (amountPaid > totalFees) {
                            amountPaidInput.setCustomValidity('Amount paid cannot exceed total fees.');
                            isValid = false;
                        } else {
                            amountPaidInput.setCustomValidity('');
                        }
                    }
                    if (!isValid) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            // Real-time validation for renew amount paid
            document.getElementById('renewAmountPaid').addEventListener('input', function () {
                const totalFeesInput = document.getElementById('renewTotalFees');
                const remainingAmountInput = document.getElementById('renewRemainingAmount');
                const totalFees = parseFloat(totalFeesInput.value) || 0;
                const amountPaid = parseFloat(this.value) || 0;
                if (amountPaid > totalFees) {
                    this.setCustomValidity('Amount paid cannot exceed total fees.');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    remainingAmountInput.value = Math.max(0, totalFees - amountPaid);
                }
            });

            // Real-time validation for renew total fees
            document.getElementById('renewTotalFees').addEventListener('input', function () {
                const amountPaidInput = document.getElementById('renewAmountPaid');
                const remainingAmountInput = document.getElementById('renewRemainingAmount');
                const totalFees = parseFloat(this.value) || 0;
                const amountPaid = parseFloat(amountPaidInput.value) || 0;
                if (totalFees < 1 || totalFees > 100000) {
                    this.setCustomValidity('Total fees must be between 1 and 100,000.');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    if (amountPaid > totalFees) {
                        amountPaidInput.setCustomValidity('Amount paid cannot exceed total fees.');
                        amountPaidInput.classList.add('is-invalid');
                        amountPaidInput.classList.remove('is-valid');
                    } else {
                        amountPaidInput.setCustomValidity('');
                        amountPaidInput.classList.remove('is-invalid');
                        amountPaidInput.classList.add('is-valid');
                        remainingAmountInput.value = Math.max(0, totalFees - amountPaid);
                    }
                }
            });

            // Update batches when center changes in edit modal
            $('#editCenter').on('change', function () {
                const centerId = $(this).val();
                if (centerId) {
                    loadBatches(document.getElementById('editBatch'), centerId);
                } else {
                    $('#editBatch').html('<option value="">-- Select Batch --</option>');
                }
            });

            // Edit functionality
            $(document).on('click', '.edit-btn', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('Admission/get_student/') ?>' + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('get_student response:', response);
                        if (response) {
                            $('#editName').val(response.name || '');
                            $('#editContact').val(response.contact || '');
                            $('#editCenter').val(response.center_id || '');
                            $('#editCategory').val(response.category || '');
                            $('#editForm').data('id', id);
                            loadBatches(document.getElementById('editBatch'), response.center_id);
                            setTimeout(() => $('#editBatch').val(response.batch_id || ''), 500);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load student data',
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('get_student error:', xhr.responseText, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load student data: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            });

            // Save edited student details
            $('#editForm').on('submit', function (event) {
                if (this.checkValidity()) {
                    event.preventDefault();
                    const id = $(this).data('id');
                    const updatedData = {
                        id: id,
                        name: $('#editName').val().trim(),
                        contact: $('#editContact').val().trim(),
                        center_id: $('#editCenter').val(),
                        batch_id: $('#editBatch').val(),
                        category: $('#editCategory').val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                        url: '<?= base_url('Admission/update_student') ?>',
                        method: 'POST',
                        data: updatedData,
                        dataType: 'json',
                        success: function(response) {
                            console.log('update_student response:', response);
                            if (response.success) {
                                $('#editModal').modal('hide');
                                forms.forEach(f => f.classList.remove('was-validated'));
                                loadStudents();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Student updated successfully',
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to update student',
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('update_student error:', xhr.responseText, status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update student: ' + (xhr.responseJSON?.message || error),
                                timer: 3000
                            });
                        }
                    });
                }
                this.classList.add('was-validated');
            });

            // Delete functionality
            $(document).on('click', '.delete-btn', function () {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('Admission/delete_student/') ?>' + id,
                            method: 'POST',
                            data: { '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
                            dataType: 'json',
                            success: function(response) {
                                console.log('delete_student response:', response);
                                if (response.success) {
                                    loadStudents();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted',
                                        text: 'Student deleted successfully',
                                        timer: 3000
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message || 'Failed to delete student',
                                        timer: 3000
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('delete_student error:', xhr.responseText, status, error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete student: ' + (xhr.responseJSON?.message || error),
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            });

            // Renew admission functionality
            $('#renewForm').on('submit', function (event) {
                if (this.checkValidity()) {
                    event.preventDefault();
                    const id = $(this).data('id');
                    const renewData = {
                        id: id,
                        name: $('#renewName').val(),
                        contact: $('#renewContact').val(),
                        center_id: $('#renewCenter').val(),
                        batch_id: $('#renewBatch').val(),
                        category: $('#renewCategory').val(),
                        total_fees: $('#renewTotalFees').val(),
                        paid_amount: $('#renewAmountPaid').val(),
                        payment_method: $('input[name="renewPaymentMethod"]:checked').val(),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                        url: '<?= base_url('Admission/renew_student') ?>',
                        method: 'POST',
                        data: renewData,
                        dataType: 'json',
                        success: function(response) {
                            console.log('renew_student response:', response);
                            if (response.success) {
                                $('#receiptName').text(response.student.name || 'N/A');
                                $('#receiptContact').text(response.student.contact || 'N/A');
                                $('#receiptCenter').text(response.student.center_name || 'N/A');
                                $('#receiptBatch').text(response.student.batch_timing || 'N/A');
                                $('#receiptCategory').text(response.student.category || 'N/A');
                                $('#receiptTotalFees').text(response.student.total_fees || 'N/A');
                                $('#receiptAmountPaid').text(response.student.paid_amount || 'N/A');
                                $('#receiptRemainingAmount').text(response.student.remaining_amount || 'N/A');
                                $('#receiptPaymentMethod').text(response.student.payment_method || 'N/A');
                                $('#attendancelink').attr('href', response.student.attendance_link || '#').text(response.student.attendance_link || 'N/A');
                                $('#renewModal').modal('hide');
                                $('#receiptModal').modal('show');
                                forms.forEach(f => f.reset());
                                forms.forEach(f => f.classList.remove('was-validated'));
                                loadStudents();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Admission renewed successfully',
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to renew admission',
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('renew_student error:', xhr.responseText, status, error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to renew admission: ' + (xhr.responseJSON?.message || error),
                                timer: 3000
                            });
                        }
                    });
                }
                this.classList.add('was-validated');
            });

            // Populate renew modal with student data
            $(document).on('click', '.renew-btn', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('Admission/get_student/') ?>' + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('get_student for renew response:', response);
                        if (response) {
                            $('#renewName').val(response.name || '');
                            $('#renewContact').val(response.contact || '');
                            $('#renewCenter').val(response.center_id || '');
                            $('#renewBatch').val(response.batch_id || '');
                            $('#renewCategory').val(response.category || '');
                            $('#renewForm').data('id', id);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load student data',
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('get_student for renew error:', xhr.responseText, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load student data: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            });

            // View receipt details
            $(document).on('click', '.view-btn', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: '<?= base_url('Admission/get_student/') ?>' + id,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('get_student for receipt response:', response);
                        if (response) {
                            $('#receiptName').text(response.name || 'N/A');
                            $('#receiptContact').text(response.contact || 'N/A');
                            $('#receiptCenter').text(response.center_name || 'N/A');
                            $('#receiptBatch').text(response.batch_timing || 'N/A');
                            $('#receiptCategory').text(response.category || 'N/A');
                            $('#receiptTotalFees').text(response.total_fees || 'N/A');
                            $('#receiptAmountPaid').text(response.paid_amount || 'N/A');
                            $('#receiptRemainingAmount').text(response.remaining_amount || 'N/A');
                            $('#receiptPaymentMethod').text(response.payment_method || 'N/A');
                            $('#attendancelink').attr('href', response.attendance_link || '#').text(response.attendance_link || 'N/A');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load receipt data',
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('get_student for receipt error:', xhr.responseText, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load receipt data: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr:not(.horizontal-line)');
                rows.forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    const id = row.cells[1].textContent.toLowerCase();
                    const batch = row.cells[2].textContent.toLowerCase();
                    const center = row.cells[3].textContent.toLowerCase();
                    const contact = row.cells[4].textContent.toLowerCase();
                    const category = row.cells[5].textContent.toLowerCase();
                    const planExpiry = row.cells[6].textContent.toLowerCase();
                    const status = row.cells[7].textContent.toLowerCase();
                    row.style.display = (
                        name.includes(searchTerm) ||
                        id.includes(searchTerm) ||
                        batch.includes(searchTerm) ||
                        center.includes(searchTerm) ||
                        contact.includes(searchTerm) ||
                        category.includes(searchTerm) ||
                        planExpiry.includes(searchTerm) ||
                        status.includes(searchTerm)
                    ) ? '' : 'none';
                    const horizontalLine = row.nextElementSibling;
                    if (horizontalLine && horizontalLine.classList.contains('horizontal-line')) {
                        horizontalLine.style.display = row.style.display;
                    }
                });
            });

            // Status and Category filter
            function applyFilters() {
                const status = statusFilter.value.toLowerCase();
                const category = categoryFilter.value.toLowerCase();
                const rows = tableBody.querySelectorAll('tr:not(.horizontal-line)');
                rows.forEach(row => {
                    const rowStatus = row.cells[7].textContent.toLowerCase();
                    const rowCategory = row.cells[5].textContent.toLowerCase();
                    const statusMatch = !status || rowStatus.includes(status);
                    const categoryMatch = !category || rowCategory.includes(category);
                    row.style.display = (statusMatch && categoryMatch) ? '' : 'none';
                    const horizontalLine = row.nextElementSibling;
                    if (horizontalLine && horizontalLine.classList.contains('horizontal-line')) {
                        horizontalLine.style.display = row.style.display;
                    }
                });
            }

            statusFilter.addEventListener('change', applyFilters);
            categoryFilter.addEventListener('change', applyFilters);

            // Sorting functionality
            let sortDirection = {};
            $('.clickable').on('click', function () {
                const column = $(this).data('sort');
                sortDirection[column] = !sortDirection[column];
                const rows = Array.from(tableBody.querySelectorAll('tr:not(.horizontal-line)'));
                rows.sort((a, b) => {
                    let aValue, bValue;
                    switch (column) {
                        case 'name':
                            aValue = a.cells[0].textContent.toLowerCase();
                            bValue = b.cells[0].textContent.toLowerCase();
                            break;
                        case 'id':
                            aValue = a.cells[1].textContent;
                            bValue = b.cells[1].textContent;
                            break;
                        case 'batch':
                            aValue = a.cells[2].textContent;
                            bValue = b.cells[2].textContent;
                            break;
                        case 'center':
                            aValue = a.cells[3].textContent;
                            bValue = b.cells[3].textContent;
                            break;
                        case 'contact':
                            aValue = a.cells[4].textContent;
                            bValue = b.cells[4].textContent;
                            break;
                        case 'category':
                            aValue = a.cells[5].textContent.toLowerCase();
                            bValue = b.cells[5].textContent.toLowerCase;
                            break;
                        case 'plan_expiry':
                            aValue = new Date(a.cells[6].textContent);
                            bValue = new Date(b.cells[6].textContent);
                            break;
                        case 'status':
                            aValue = a.cells[7].textContent.toLowerCase();
                            bValue = b.cells[7].textContent.toLowerCase;
                            break;
                    }
                    if (column === 'plan_expiry') {
                        return sortDirection[column] ? aValue - bValue : bValue - aValue;
                    }
                    return sortDirection[column]
                        ? aValue > bValue ? 1 : -1
                        : aValue < bValue ? 1 : -1;
                });
                tableBody.innerHTML = '';
                rows.forEach(row => {
                    tableBody.appendChild(row);
                    const horizontalLine = document.createElement('tr');
                    horizontalLine.className = 'horizontal-line';
                    horizontalLine.innerHTML = '<td colspan="9"></td>';
                    tableBody.appendChild(horizontalLine);
                });
                $('.clickable i').removeClass('fa-sort-up fa-sort-down').addClass('fa-sort');
                $(this).find('i').removeClass('fa-sort').addClass(sortDirection[column] ? 'fa-sort-up' : 'fa-sort-down');
            });

            // Export functionality
            exportBtn.addEventListener('click', function () {
                $.ajax({
                    url: '<?= base_url('Admission/export_students') ?>',
                    method: 'POST',
                    data: { '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
                    dataType: 'json',
                    success: function(response) {
                        console.log('export_students response:', response);
                        if (Array.isArray(response) && response.length > 0) {
                            const csvContent = [
                                'Name,ID,Batch,Center,Contact,Category,Plan Expiry,Status',
                                ...response.map(student => {
                                    const planExpiry = student.joining_date ? new Date(new Date(student.joining_date).getTime() + (student.duration * 30 * 24 * 60 * 60 * 1000)).toISOString().split('T')[0] : 'N/A';
                                    const status = student.remaining_amount <= 0 ? 'Active' : 'Pending';
                                    return `"${student.name || ''}","${student.id || ''}","${student.batch_timing || ''}","${student.center_name || ''}","${student.contact || ''}","${student.category || ''}","${planExpiry}","${status}"`;
                                })
                            ].join('\n');
                            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                            const link = document.createElement('a');
                            link.href = URL.createObjectURL(blob);
                            link.download = 'students_export.csv';
                            link.click();
                            URL.revokeObjectURL(link.href);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Students exported successfully',
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No students available to export',
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('export_students error:', xhr.responseText, status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to export students: ' + (xhr.responseJSON?.message || error),
                            timer: 3000
                        });
                    }
                });
            });

            // Reset forms on modal close
            $('.modal').on('hidden.bs.modal', function () {
                forms.forEach(f => {
                    f.reset();
                    f.classList.remove('was-validated');
                });
            });
        });
    </script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');
            const mainContent = document.querySelector('.main-content');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle('active');
                        navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                    } else {
                        const isMinimized = sidebar.classList.toggle('minimized');
                        navbar.classList.toggle('sidebar-minimized', isMinimized);
                        contentWrapper.classList.toggle('minimized', isMinimized);
                        mainContent.classList.toggle('minimized', isMinimized);
                    }
                });
            }
        });
    </script>
<!-- =----------
</body>
</html>