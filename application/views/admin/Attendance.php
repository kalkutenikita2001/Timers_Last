<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
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
            max-width: 1200px;
            margin: 4rem auto 0;
            width: 100%;
            padding: 0 1rem;
        }
        /* Tab Styles */
        .tab-buttons {
            display: flex;
            background: linear-gradient(90deg, #f8f9fa, #e9ecef);
            border-radius: 12px 12px 0 0;
            overflow: hidden;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .tab-btn {
            flex: 1;
            padding: 12px;
            background: #e9ecef;
            border: none;
            cursor: pointer;
            color: #333;
            font-weight: 700;
            font-size: 16px;
            border-radius: 15px 5px;
            transition: all 0.3s ease;
        }
        .tab-btn.active {
            background: linear-gradient(90deg, #ff4040, #b71c1c);
            color: #fff;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .tab-btn:hover {
            background: #d0d0d0;
            color: #000;
        }
        /* Main Table Styles */
        .table-container {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .filter-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }
        .filter-btn {
            background: #e9ecef;
            color: black;
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
        .filter-btn:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        table {
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
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 1rem;
        }
        .table td, .table th {
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
        .action-cell {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }
        .action-btn {
            font-size: 0.85rem;
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            background: none;
            color: #6c757d;
        }
        .action-btn.edit-btn {
            color: #ffc107;
        }
        .action-btn.view-btn {
            color: #28a745;
        }
        .action-btn:hover:not(:disabled) {
            filter: brightness(90%);
            transform: scale(1.2);
        }
        /* Add Button */
        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .add-btn {
            background: #e9ecef;
            color: black;
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
        .add-btn:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
            max-width: 600px;
            margin: 65px auto;
            position: relative;
            width: 87% !important;
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
            cursor: pointer;
        }
        .close:hover {
            opacity: 1;
            background: #e0e0e0;
        }
        .modal-body {
            padding: 1rem;
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
            margin-bottom: 0.8rem;
            flex: 0 0 50%;
            max-width: 50%;
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
            width: 100%;
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
        .form-group textarea {
            resize: vertical;
            min-height: 3rem;
            width: 100%;
        }
        .invalid-feedback {
            font-size: 0.75rem;
            color: #dc3545;
            display: none;
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
        .save-btn, .apply-filter-btn {
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
            display: block;
            margin: 1rem auto 0;
        }
        .save-btn:hover, .apply-filter-btn:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        .save-btn:disabled, .apply-filter-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        /* Filter Modal Specific Styles */
        .filter-modal-content {
            max-width: 500px;
            margin: 65px auto;
        }
        /* Responsive Design */
        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 0.5rem !important;
            }
            .container {
                margin-top: 3rem;
                padding: 0 0.5rem;
            }
            .table {
                font-size: 0.7rem;
                min-width: 800px; /* Force horizontal scroll */
            }
            .action-btn {
                font-size: 0.7rem;
                padding: 0.2rem 0.4rem;
            }
            .modal-content {
                padding: 0.8rem;
                width: 95%;
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
            .add-btn-container {
                justify-content: center;
                flex-direction: column;
                gap: 0.5rem;
            }
            .btn-custom, .add-btn, .filter-btn {
                font-size: 0.75rem;
                padding: 0.3rem 0.6rem;
            }
            .tab-buttons {
                flex-direction: column;
                border-radius: 8px;
            }
            .tab-btn {
                width: 100%;
                font-size: 14px;
                padding: 10px;
                border-radius: 10px 3px;
            }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .container {
                margin-top: 3.5rem;
                padding: 0 0.75rem;
            }
            .table {
                font-size: 0.8rem;
                min-width: 700px; /* Force horizontal scroll if needed */
            }
            .action-btn {
                font-size: 0.8rem;
                padding: 0.3rem 0.5rem;
            }
            .modal-content {
                padding: 0.9rem;
                margin-top: 40px;
                width: 90%;
            }
            .form-row {
                flex-direction: row;
                flex-wrap: wrap;
            }
            .form-group {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .add-btn-container {
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .btn-custom, .add-btn, .filter-btn {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
            }
            .tab-buttons {
                flex-direction: row;
            }
            .tab-btn {
                font-size: 15px;
                padding: 10px;
            }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper {
                margin-left: 12rem;
            }
            .content-wrapper.minimized {
                margin-left: 4rem;
            }
            .container {
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
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .content-wrapper {
                margin-left: 14rem;
            }
            .container {
                margin-top: 4rem;
                padding: 0 1rem;
            }
            .modal-content {
                max-width: calc(480px + 2vw);
                margin-top: 65px;
            }
        }
        @media (min-width: 1201px) {
            .content-wrapper {
                margin-left: 15rem;
            }
            .container {
                margin-top: 4rem;
                padding: 0 1rem;
            }
            .modal-content {
                max-width: 500px;
                margin-top: 65px;
            }
        }
        @media (min-width: 1600px) {
            .content-wrapper {
                margin-left: 16rem;
            }
            .container {
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
            .btn-custom, .add-btn, .filter-btn {
                font-size: 1.1rem;
                padding: 0.6rem 1.2rem;
            }
        }
        @media (hover: none) {
            .action-btn:hover,
            .btn-custom:hover,
            .add-btn:hover,
            .filter-btn:hover,
            .close:hover {
                transform: none;
                background-color: inherit;
                box-shadow: none;
            }
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
            <!-- Tab Buttons -->
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="showTab('daily')">Daily Attendance</button>
                <button class="tab-btn" onclick="showTab('total')">Total Attendance</button>
            </div>
            <!-- Filter Button -->
            <div class="filter-wrapper">
                <button class="filter-btn" onclick="openFilterModal()">
                     <i class="bi bi-funnel me-2"></i> Filter
                </button>
            </div>
            <!-- Daily Attendance Table -->
            <div id="dailyTab" class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Level</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="dailyTableBody">
                        <tr>
                            <td>Jane Doe</td>
                            <td>B1</td>
                            <td>Intermediate</td>
                            <td>Corporate</td>
                            <td class="action-cell">
                                <button class="action-btn view-btn" onclick="viewAttendance(this, 'daily')"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editAttendance(this, 'daily')"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>John Smith</td>
                            <td>B2</td>
                            <td>Beginner</td>
                            <td>Individual</td>
                            <td class="action-cell">
                                <button class="action-btn view-btn" onclick="viewAttendance(this, 'daily')"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editAttendance(this, 'daily')"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Alice Johnson</td>
                            <td>B3</td>
                            <td>Advanced</td>
                            <td>Corporate</td>
                            <td class="action-cell">
                                <button class="action-btn view-btn" onclick="viewAttendance(this, 'daily')"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editAttendance(this, 'daily')"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Bob Wilson</td>
                            <td>B4</td>
                            <td>Intermediate</td>
                            <td>Individual</td>
                            <td class="action-cell">
                                <button class="action-btn view-btn" onclick="viewAttendance(this, 'daily')"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editAttendance(this, 'daily')"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Total Attendance Table -->
            <div id="totalTab" class="table-container" style="display: none;">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Batch</th>
                            <th>Total Days</th>
                            <th>Percentage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="totalTableBody">
                        <!-- Initial empty, will be populated dynamically -->
                    </tbody>
                </table>
            </div>
            <!-- Add Button -->
            <div class="add-btn-container">
                <button class="add-btn" onclick="openModal()">
                     <i class="fas fa-plus mr-1"></i>Add Attendance</button>
            </div>
        </div>
    </div>
    <!-- Add/Edit Attendance Modal -->
    <div id="attendanceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">×</span>
                <h2 class="modal-title">Add Attendance</h2>
            </div>
            <div class="modal-body">
                <form id="attendanceForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span>:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
                            <div class="invalid-feedback">Name is required</div>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch <span class="text-danger">*</span>:</label>
                            <select id="batch" name="batch" class="form-control" required>
                                <option value="">-- Select Batch --</option>
                                <!-- Batches will be populated dynamically -->
                            </select>
                            <div class="invalid-feedback">Batch is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Level <span class="text-danger">*</span>:</label>
                            <input type="text" id="level" name="level" class="form-control" placeholder="Enter Level" required>
                            <div class="invalid-feedback">Level is required</div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category <span class="text-danger">*</span>:</label>
                            <input type="text" id="category" name="category" class="form-control" placeholder="Enter Category" required>
                            <div class="invalid-feedback">Category is required</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Modal -->
    <div id="filterModal" class="modal">
        <div class="modal-content filter-modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeFilterModal()">×</span>
                <h2 class="modal-title">Filter Attendance</h2>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="filterName">Name:</label>
                            <input type="text" id="filterName" name="filterName" class="form-control" placeholder="Enter Name to Filter">
                        </div>
                        <div class="form-group">
                            <label for="filterBatch">Batch:</label>
                            <select id="filterBatch" name="filterBatch" class="form-control">
                                <option value="">-- Select Batch --</option>
                                <!-- Batches will be populated dynamically -->
                            </select>
                            <div class="invalid-feedback">Please select a valid batch.</div>
                        </div>
                    </div>
                    <div class="form-row" id="dailyFilterFields">
                        <div class="form-group">
                            <label for="filterLevel">Level:</label>
                            <input type="text" id="filterLevel" name="filterLevel" class="form-control" placeholder="Enter Level to Filter">
                        </div>
                        <div class="form-group">
                            <label for="filterCategory">Category:</label>
                            <input type="text" id="filterCategory" name="filterCategory" class="form-control" placeholder="Enter Category to Filter">
                        </div>
                    </div>
                    <button type="submit" class="apply-filter-btn">Apply Filter</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap + Font Awesome + jQuery + SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tab functionality with dynamic data for Total Attendance
        function showTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.table-container').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
            document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add('active');
            currentTab = tabName;
            if (tabName === 'total') {
                populateTotalAttendance();
            }
            // Show/hide daily filter fields based on tab
            document.getElementById('dailyFilterFields').style.display = tabName === 'daily' ? 'flex' : 'none';
            // Reset filters when switching tabs
            resetFilters();
        }

        // Populate Total Attendance table with different data
        function populateTotalAttendance() {
            const totalTableBody = document.getElementById('totalTableBody');
            totalTableBody.innerHTML = '';
            const totalData = [
                { name: 'Jane Doe', batch: 'B1', totalDays: 20, percentage: '90%', id: 1 },
                { name: 'John Smith', batch: 'B2', totalDays: 18, percentage: '85%', id: 2 },
                { name: 'Alice Johnson', batch: 'B3', totalDays: 22, percentage: '95%', id: 3 },
                { name: 'Bob Wilson', batch: 'B4', totalDays: 15, percentage: '75%', id: 4 }
            ];
            totalData.forEach(data => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${data.name}</td>
                    <td>${data.batch}</td>
                    <td>${data.totalDays}</td>
                    <td>${data.percentage}</td>
                    <td class="action-cell">
                        <button class="action-btn view-btn" onclick="viewAttendance(this, 'total', ${data.id})"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-btn" onclick="editAttendance(this, 'total', ${data.id})"><i class="fas fa-edit"></i></button>
                    </td>
                `;
                totalTableBody.appendChild(row);
            });
            applyFilters(); // Apply filters after populating
        }

        // Modal functionality for Add/Edit
        const modal = document.getElementById('attendanceModal');
        const form = document.getElementById('attendanceForm');
        let editingRow = null;
        let currentTab = 'daily';

        function openModal() {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            resetForm();
            loadBatches(); // Load batches when modal opens
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
            editingRow = null;
        }

        function resetForm() {
            form.reset();
            const batchSelect = document.getElementById('batch');
            batchSelect.innerHTML = '<option value="">-- Select Batch --</option>'; // Reset batch dropdown
            clearValidationErrors();
        }

        function clearValidationErrors() {
            const formGroups = document.querySelectorAll('#attendanceForm .form-group');
            formGroups.forEach(group => {
                group.classList.remove('was-validated');
                group.querySelector('.invalid-feedback').style.display = 'none';
            });
        }

        // Filter Modal functionality
        const filterModal = document.getElementById('filterModal');
        const filterForm = document.getElementById('filterForm');

        function openFilterModal() {
            filterModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            // Ensure filter fields reflect current tab
            document.getElementById('dailyFilterFields').style.display = currentTab === 'daily' ? 'flex' : 'none';
            loadFilterBatches(); // Load batches when filter modal opens
        }

        function closeFilterModal() {
            filterModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            resetFilters();
        }

        function resetFilters() {
            filterForm.reset();
            const filterBatchSelect = document.getElementById('filterBatch');
            filterBatchSelect.innerHTML = '<option value="">-- Select Batch --</option>'; // Reset batch dropdown
            applyFilters(); // Re-apply filters to refresh table
        }

        // Load batches dynamically into the batch dropdown (Add/Edit Modal)
        function loadBatches() {
            const batchSelect = document.getElementById('batch');
            const baseUrl = '<?php echo base_url(); ?>';
            const batchUrl = baseUrl + 'batch/get_batches';
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

            $.ajax({
                url: batchUrl,
                method: 'POST',
                data: { [csrfName]: csrfHash },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        batchSelect.innerHTML = '<option value="">-- Select Batch --</option>';
                        if (response.data.length === 0) {
                            batchSelect.innerHTML += '<option value="" disabled>No batches available</option>';
                        } else {
                            response.data.forEach(batch => {
                                batchSelect.innerHTML += `<option value="${batch.batch}">${batch.batch}</option>`;
                            });
                        }
                    } else {
                        console.error('Error fetching batches:', response.message);
                        batchSelect.innerHTML += '<option value="" disabled>Error loading batches</option>';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    batchSelect.innerHTML += '<option value="" disabled>Error loading batches</option>';
                }
            });
        }

        // Load batches dynamically into the filter batch dropdown
        function loadFilterBatches() {
            const filterBatchSelect = document.getElementById('filterBatch');
            const baseUrl = '<?php echo base_url(); ?>';
            const batchUrl = baseUrl + 'batch/get_batches';
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
            const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

            $.ajax({
                url: batchUrl,
                method: 'POST',
                data: { [csrfName]: csrfHash },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        filterBatchSelect.innerHTML = '<option value="">-- Select Batch --</option>';
                        if (response.data.length === 0) {
                            filterBatchSelect.innerHTML += '<option value="" disabled>No batches available</option>';
                        } else {
                            response.data.forEach(batch => {
                                filterBatchSelect.innerHTML += `<option value="${batch.batch}">${batch.batch}</option>`;
                            });
                        }
                    } else {
                        console.error('Error fetching batches:', response.message);
                        filterBatchSelect.innerHTML += '<option value="" disabled>Error loading batches</option>';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    filterBatchSelect.innerHTML += '<option value="" disabled>Error loading batches</option>';
                }
            });
        }

        // Form validation for Add/Edit
        function validateForm() {
            const name = document.getElementById('name');
            const batch = document.getElementById('batch');
            const level = document.getElementById('level');
            const category = document.getElementById('category');
            let isValid = true;
            clearValidationErrors();

            if (!name.value.trim()) {
                name.closest('.form-group').classList.add('was-validated');
                name.closest('.form-group').querySelector('.invalid-feedback').style.display = 'block';
                isValid = false;
            }
            if (!batch.value.trim()) {
                batch.closest('.form-group').classList.add('was-validated');
                batch.closest('.form-group').querySelector('.invalid-feedback').style.display = 'block';
                isValid = false;
            }
            if (!level.value.trim()) {
                level.closest('.form-group').classList.add('was-validated');
                level.closest('.form-group').querySelector('.invalid-feedback').style.display = 'block';
                isValid = false;
            }
            if (!category.value.trim()) {
                category.closest('.form-group').classList.add('was-validated');
                category.closest('.form-group').querySelector('.invalid-feedback').style.display = 'block';
                isValid = false;
            }
            return isValid;
        }

        // Form submission for Add/Edit
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateForm()) {
                const formData = new FormData(form);
                const data = {
                    name: formData.get('name'),
                    batch: formData.get('batch'),
                    level: formData.get('level'),
                    category: formData.get('category')
                };
                const tableBody = document.getElementById(currentTab + 'TableBody');
                if (editingRow) {
                    updateRow(editingRow, data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Attendance updated successfully.',
                        timer: 2000
                    });
                } else {
                    addNewRow(data, currentTab);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Attendance added successfully.',
                        timer: 2000
                    });
                }
                closeModal();
                applyFilters(); // Re-apply filters after adding/editing
            }
        });

        // Filter form submission
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
            closeFilterModal();
        });

        // Apply filters to table
        function applyFilters() {
            const filterName = document.getElementById('filterName').value.toLowerCase();
            const filterBatch = document.getElementById('filterBatch').value.toLowerCase();
            const filterLevel = document.getElementById('filterLevel').value.toLowerCase();
            const filterCategory = document.getElementById('filterCategory').value.toLowerCase();
            const tableBody = document.getElementById(currentTab + 'TableBody');
            const rows = tableBody.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const name = cells[0].textContent.toLowerCase();
                const batch = cells[1].textContent.toLowerCase();
                let matches = true;
                if (filterName && !name.includes(filterName)) {
                    matches = false;
                }
                if (filterBatch && !batch.includes(filterBatch)) {
                    matches = false;
                }
                if (currentTab === 'daily') {
                    const level = cells[2].textContent.toLowerCase();
                    const category = cells[3].textContent.toLowerCase();
                    if (filterLevel && !level.includes(filterLevel)) {
                        matches = false;
                    }
                    if (filterCategory && !category.includes(filterCategory)) {
                        matches = false;
                    }
                }
                row.style.display = matches ? '' : 'none';
            });
        }

        // Add new row to table
        function addNewRow(data, tab) {
            const tableBody = document.getElementById(tab + 'TableBody');
            const row = document.createElement('tr');
            if (tab === 'daily') {
                row.innerHTML = `
                    <td>${data.name}</td>
                    <td>${data.batch}</td>
                    <td>${data.level}</td>
                    <td>${data.category}</td>
                    <td class="action-cell">
                        <button class="action-btn view-btn" onclick="viewAttendance(this, '${tab}')"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-btn" onclick="editAttendance(this, '${tab}')"><i class="fas fa-edit"></i></button>
                    </td>
                `;
            } else if (tab === 'total') {
                row.innerHTML = `
                    <td>${data.name}</td>
                    <td>${data.batch}</td>
                    <td>${data.totalDays || 'N/A'}</td>
                    <td>${data.percentage || 'N/A'}</td>
                    <td class="action-cell">
                        <button class="action-btn view-btn" onclick="viewAttendance(this, '${tab}')"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-btn" onclick="editAttendance(this, '${tab}')"><i class="fas fa-edit"></i></button>
                    </td>
                `;
            }
            tableBody.appendChild(row);
        }

        // Update existing row
        function updateRow(row, data) {
            const cells = row.querySelectorAll('td');
            if (currentTab === 'daily') {
                cells[0].textContent = data.name;
                cells[1].textContent = data.batch;
                cells[2].textContent = data.level;
                cells[3].textContent = data.category;
            } else if (currentTab === 'total') {
                cells[0].textContent = data.name;
                cells[1].textContent = data.batch;
            }
        }

        // View attendance
        function viewAttendance(button, tab, id) {
            currentTab = tab;
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            let message = `<strong>Name:</strong> ${cells[0].textContent}<br>
                           <strong>Batch:</strong> ${cells[1].textContent}`;
            if (tab === 'total') {
                message += `<br><strong>Total Days:</strong> ${cells[2].textContent}<br>
                            <strong>Percentage:</strong> ${cells[3].textContent}`;
            } else {
                message += `<br><strong>Level:</strong> ${cells[2].textContent}<br>
                            <strong>Category:</strong> ${cells[3].textContent}`;
            }
            Swal.fire({
                title: 'Attendance Details',
                html: message,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        }

        // Edit attendance
        function editAttendance(button, tab, id) {
            currentTab = tab;
            editingRow = button.closest('tr');
            const cells = editingRow.querySelectorAll('td');
            document.getElementById('name').value = cells[0].textContent;
            document.getElementById('batch').value = cells[1].textContent;
            if (tab === 'daily') {
                document.getElementById('level').value = cells[2].textContent;
                document.getElementById('category').value = cells[3].textContent;
            }
            document.querySelector('.modal-title').textContent = 'Edit Attendance';
            openModal();
        }

        // Real-time validation for Add/Edit form
        document.getElementById('name').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('was-validated');
                this.closest('.form-group').querySelector('.invalid-feedback').style.display = 'none';
            }
        });
        document.getElementById('batch').addEventListener('change', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('was-validated');
                this.closest('.form-group').querySelector('.invalid-feedback').style.display = 'none';
            }
        });
        document.getElementById('level').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('was-validated');
                this.closest('.form-group').querySelector('.invalid-feedback').style.display = 'none';
            }
        });
        document.getElementById('category').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('was-validated');
                this.closest('.form-group').querySelector('.invalid-feedback').style.display = 'none';
            }
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        if (sidebar) {
                            sidebar.classList.toggle('active');
                            navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                        }
                    } else {
                        if (sidebar && contentWrapper) {
                            const isMinimized = sidebar.classList.toggle('minimized');
                            navbar.classList.toggle('sidebar-minimized', isMinimized);
                            contentWrapper.classList.toggle('minimized', isMinimized);
                        }
                    }
                });
            }
        });

        // Initialize with daily tab active
        showTab('daily');
    </script>
</body>
</html>