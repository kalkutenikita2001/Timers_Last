<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa !important;
            color: #333;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }
        .content-wrapper.minimized {
            margin-left: 60px;
        }
        .container {
            max-width: 1200px;
            margin: 70px auto 0;
            width: 100%;
        }
        /* Tab Styles */
        .tab-buttons {
            display: flex;
            background: #e0e0e0;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .tab-btn {
            flex: 1;
            padding: 10px;
            background: #d3d3d3;
            border: none;
            cursor: pointer;
            color: #000;
            font-weight: 600;
        }
        .tab-btn.active {
            background: #fff;
            color: #000;
        }
        /* Main Table Styles */
        .table-container {
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
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
            background: #e0e0e0;
            color: #000;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }
        .filter-btn:hover {
            background: #d0d0d0;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
        }
        .table thead th {
            background-color: #343a40;
            color: #fff;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 12px 15px;
            text-align: center;
            font-weight: 600;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 12px 15px;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .action-cell {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
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
        /* Add Button */
        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .add-btn {
            background: linear-gradient(90deg, #ff4040, #470000);
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .add-btn:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }
        .modal-header h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #343a40;
        }
        .close {
            position: absolute;
            right: 20px;
            top: 20px;
            color: #666;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            width: 30px;
            height: 30px;
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
            padding: 20px 25px;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #333;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
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
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            color: white;
            border: none;
            padding: 10px 35px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 20px auto 0;
            box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
            transition: all 0.3s ease;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
        }
        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        /* Responsive Design */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .container {
                margin-top: 60px;
            }
            .table-container {
                overflow-x: auto;
            }
            table {
                min-width: 800px;
            }
            th, td {
                padding: 8px 6px;
                font-size: 12px;
            }
            .tab-buttons {
                flex-direction: column;
            }
            .tab-btn {
                width: 100%;
            }
            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
            .modal-body {
                padding: 15px;
            }
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            .add-btn {
                padding: 8px 20px;
                font-size: 14px;
            }
        }
        @media (max-width: 480px) {
            .modal-content {
                width: 98%;
                margin: 5% auto;
            }
            .modal-body {
                padding: 12px;
            }
            .form-group label {
                font-size: 12px;
            }
            .form-group input,
            .form-group textarea {
                padding: 8px 10px;
                font-size: 12px;
            }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .content-wrapper {
                margin-left: 200px;
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
                <button class="filter-btn">
                    <i class="bi bi-funnel me-1"></i> Filter
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
                <button class="add-btn" onclick="openModal()">Add Attendance</button>
            </div>
        </div>
    </div>
    <!-- Modal -->
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
                            <input type="text" id="name" name="name" class="form-control" required>
                            <div class="error">Name is required</div>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch <span class="text-danger">*</span>:</label>
                            <input type="text" id="batch" name="batch" class="form-control" required>
                            <div class="error">Batch is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Level <span class="text-danger">*</span>:</label>
                            <input type="text" id="level" name="level" class="form-control" required>
                            <div class="error">Level is required</div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category <span class="text-danger">*</span>:</label>
                            <input type="text" id="category" name="category" class="form-control" required>
                            <div class="error">Category is required</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap + Font Awesome + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script>
        // Tab functionality with dynamic data for Total Attendance
        function showTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.table-container').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
            document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add('active');
            if (tabName === 'total') {
                populateTotalAttendance();
            }
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
        }

        // Modal functionality
        const modal = document.getElementById('attendanceModal');
        const form = document.getElementById('attendanceForm');
        let editingRow = null;
        let currentTab = 'daily';

        function openModal() {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            resetForm();
        }

        function closeModal() {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
            editingRow = null;
        }

        function resetForm() {
            form.reset();
            clearValidationErrors();
        }

        function clearValidationErrors() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                group.classList.remove('invalid');
            });
        }

        // Form validation
        function validateForm() {
            const name = document.getElementById('name');
            const batch = document.getElementById('batch');
            const level = document.getElementById('level');
            const category = document.getElementById('category');
            let isValid = true;

            clearValidationErrors();

            if (!name.value.trim()) {
                name.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!batch.value.trim()) {
                batch.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!level.value.trim()) {
                level.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!category.value.trim()) {
                category.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        // Form submission
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
                } else {
                    addNewRow(data, currentTab);
                }
                closeModal();
            }
        });

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
            let message = `Name: ${cells[0].textContent}\nBatch: ${cells[1].textContent}`;
            if (tab === 'total') {
                message += `\nTotal Days: ${cells[2].textContent}\nPercentage: ${cells[3].textContent}`;
            } else {
                message += `\nLevel: ${cells[2].textContent}\nCategory: ${cells[3].textContent}`;
            }
            alert(message);
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

        // Real-time validation
        document.getElementById('name').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('batch').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('level').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('category').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
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
