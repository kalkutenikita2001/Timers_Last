<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <!-- Bootstrap CSS (required for table classes) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef !important;
            color: #fff;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            margin-left: 250px; /* Default margin matching sidebar width */
            padding: 10px;
            transition: all 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px; /* Margin when sidebar is minimized */
        }

        .container {
            max-width: 1200px;
            margin: 70px auto 0; /* Adjusted for navbar height */
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
            border-radius: 15px; /* Increased border radius for a softer look */
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
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
            border-radius: 8px; /* Rounded filter button */
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background: #d0d0d0;
        }

        table {
            width: 100%;
            border-collapse: separate; /* Allows border-radius on cells */
            border-spacing: 0;
            background: #fff;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #000;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 12px 15px; /* Increased padding for better spacing */
            text-align: center;
            border-top-left-radius: 15px; /* Rounded top-left corner */
            border-top-right-radius: 15px; /* Rounded top-right corner */
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 12px 15px; /* Increased padding for better spacing */
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
        }

        /* Ensure the first and last td in the last row have rounded corners */
        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 15px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 15px;
        }

        .action-cell {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%; /* Circular buttons for a modern look */
            cursor: pointer;
            background: none;
            color: #007bff;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease; /* Smooth hover effect */
        }

        .action-btn:hover {
            color: #0056b3;
            transform: scale(1.1); /* Slight scale on hover for interactivity */
        }

        /* Add Button */
        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .add-btn {
            background: linear-gradient(to right, #ff4040, #470000);
            color: white;
            border: none;
            border-radius: 10px; /* Increased border radius for a softer look */
            padding: 6px 10px;
            font-size: 12px;
            width: 200px;
            cursor: pointer;
        }

        .add-btn:hover {
            background: linear-gradient(to right, #ff3030, #360000);
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
            background: #f5f5f5;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            text-align: center;
            padding: 20px 25px 15px;
            border-bottom: 1px solid #e0e0e0;
            position: relative;
        }

        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin: 0;
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
            border-radius: 8px; /* Rounded inputs for consistency */
            font-size: 14px;
            background: white;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 0 3px rgba(211, 47, 47, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .date-input {
            position: relative;
        }

        .date-input input[type="date"] {
            position: relative;
            padding-right: 40px;
        }

        .date-input::after {
            content: "📅";
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 16px;
        }

        .error {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.invalid input,
        .form-group.invalid textarea {
            border-color: #d32f2f;
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
                padding: 5px !important;
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
                            <label for="name">Name :</label>
                            <input type="text" id="name" name="name" required>
                            <div class="error">Name is required</div>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch :</label>
                            <input type="text" id="batch" name="batch" required>
                            <div class="error">Batch is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Level :</label>
                            <input type="text" id="level" name="level" required>
                            <div class="error">Level is required</div>
                        </div>
                        <div class="form-group">
                            <label for="category">Category :</label>
                            <input type="text" id="category" name="category" required>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

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
            totalTableBody.innerHTML = ''; // Clear existing rows

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

            // Clear previous errors
            clearValidationErrors();

            // Validate name
            if (!name.value.trim()) {
                name.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate batch
            if (!batch.value.trim()) {
                batch.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate level
            if (!level.value.trim()) {
                level.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate category
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
                // Note: Total tab has different columns (totalDays, percentage), so editing might need adjustment
                // For now, we'll update only name and batch; consider adding totalDays/percentage fields if needed
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