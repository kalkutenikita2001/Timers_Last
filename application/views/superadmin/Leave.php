<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
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
            margin-left: 250px;
            padding: 10px;
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
            justify-content: space-around;
            background: #fff;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 17px;
        }

        .tab-buttons button {
            flex: 1;
            text-align: center;
            color: #000;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px;
            font-weight: bold;
            background: none;
            cursor: pointer;
        }

        .tab-buttons button.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }

        /* Table Styles */
        .table-container {
            background: #fff;
            border-radius: 15px; /* Added rounded corners */
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Added subtle shadow */
            margin-bottom: 20px;
            overflow-x: auto;
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

        .table tbody tr:hover {
            background-color: #f1f1f1; /* Subtle hover effect */
            transition: background-color 0.3s ease;
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
            border: 2px dashed #000;
            border-radius: 50%;
            cursor: pointer;
            background: none;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease, border-color 0.3s ease; /* Smooth transitions */
        }

        .action-btn.thumbs-up::before {
            content: "👍";
        }

        .action-btn.cross::before {
            content: "✖";
        }

        .action-btn:hover {
            transform: scale(1.1); /* Slight scale on hover */
            border-color: #007bff; /* Change border color on hover */
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
            border-radius: 5px;
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
            border-radius: 8px;
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
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <div class="content-wrapper" id="contentWrapper">
    <div class="container">
        <!-- Tab Buttons -->
        <div class="tab-buttons">
            <button class="active" onclick="switchTab('Center 1')">Center 1</button>
            <button onclick="switchTab('Center 2')">Center 2</button>
            <button onclick="switchTab('Center 3')">Center 3</button>
            <button onclick="switchTab('Center 4')">Center 4</button>
        </div>

        <!-- Leave Table -->
        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Batch</th>
                        <th>Level</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="leaveTableBody">
                    <tr>
                        <td>Jane Doe</td>
                        <td>B1</td>
                        <td>Intermediate</td>
                        <td>15/07/2025</td>
                        <td>sdfghj</td>
                        <td>sdfghjertyuiopasdfghj</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Doe</td>
                        <td>B1</td>
                        <td>Intermediate</td>
                        <td>15/07/2025</td>
                        <td>sdfghj</td>
                        <td>sdfghjertyuiopasdfghj</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane Doe</td>
                        <td>B1</td>
                        <td>Intermediate</td>
                        <td>15/07/2025</td>
                        <td>sdfghj</td>
                        <td>sdfghjertyuiopasdfghj</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add Button -->
        <div class="add-btn-container">
            <button class="add-btn" onclick="openModal()">Add Leave</button>
        </div>
    </div>
  </div>

    <!-- Modal -->
    <div id="leaveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">×</span>
                <h2 class="modal-title">Add Leave</h2>
            </div>
            <div class="modal-body">
                <form id="leaveForm">
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
                        <div class="form-group date-input">
                            <label for="date">Date :</label>
                            <input type="date" id="date" name="date" required>
                            <div class="error">Date is required</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason :</label>
                        <input type="text" id="reason" name="reason" required>
                        <div class="error">Reason is required</div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea id="description" name="description" required></textarea>
                        <div class="error">Description is required</div>
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
        // Modal functionality
        const modal = document.getElementById('leaveModal');
        const form = document.getElementById('leaveForm');
        let editingRow = null;

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
            const date = document.getElementById('date');
            const reason = document.getElementById('reason');
            const description = document.getElementById('description');
            
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

            // Validate date
            if (!date.value) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate reason
            if (!reason.value.trim()) {
                reason.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate description
            if (!description.value.trim()) {
                description.closest('.form-group').classList.add('invalid');
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
                    date: formData.get('date'),
                    reason: formData.get('reason'),
                    description: formData.get('description')
                };

                const tableBody = document.getElementById('leaveTableBody');
                if (editingRow) {
                    updateRow(editingRow, data);
                } else {
                    addNewRow(data);
                }

                closeModal();
            }
        });

        // Add new row to table
        function addNewRow(data) {
            const tableBody = document.getElementById('leaveTableBody');
            const row = document.createElement('tr');
            
            row.innerHTML = `
                <td>${data.name}</td>
                <td>${data.batch}</td>
                <td>${data.level}</td>
                <td>${new Date(data.date).toLocaleDateString('en-GB')}</td>
                <td>${data.reason}</td>
                <td>${data.description}</td>
                <td class="action-cell">
                    <button class="action-btn thumbs-up" onclick="approveLeave(this)"></button>
                    <button class="action-btn cross" onclick="rejectLeave(this)"></button>
                </td>
            `;
            
            tableBody.appendChild(row);
        }

        // Update existing row
        function updateRow(row, data) {
            const cells = row.querySelectorAll('td');
            cells[0].textContent = data.name;
            cells[1].textContent = data.batch;
            cells[2].textContent = data.level;
            cells[3].textContent = new Date(data.date).toLocaleDateString('en-GB');
            cells[4].textContent = data.reason;
            cells[5].textContent = data.description;
        }

        // View leave
        function viewLeave(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            alert(`Name: ${cells[0].textContent}\nBatch: ${cells[1].textContent}\nLevel: ${cells[2].textContent}\nDate: ${cells[3].textContent}\nReason: ${cells[4].textContent}\nDescription: ${cells[5].textContent}`);
        }

        // Edit leave
        function editLeave(button) {
            editingRow = button.closest('tr');
            const cells = editingRow.querySelectorAll('td');
            
            document.getElementById('name').value = cells[0].textContent;
            document.getElementById('batch').value = cells[1].textContent;
            document.getElementById('level').value = cells[2].textContent;
            document.getElementById('date').value = cells[3].textContent.split('/').reverse().join('-');
            document.getElementById('reason').value = cells[4].textContent;
            document.getElementById('description').value = cells[5].textContent;
            
            document.querySelector('.modal-title').textContent = 'Edit Leave';
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

        document.getElementById('date').addEventListener('input', function() {
            if (this.value) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('reason').addEventListener('input', function() {
            if (this.value.trim()) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('description').addEventListener('input', function() {
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

        // Tab switching functionality
        function switchTab(center) {
            const buttons = document.querySelectorAll('.tab-buttons button');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent === center) {
                    btn.classList.add('active');
                }
            });
        }

        // Approve and Reject functionality
        function approveLeave(button) {
            const row = button.closest('tr');
            alert(`Leave for ${row.cells[0].textContent} approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }

        function rejectLeave(button) {
            const row = button.closest('tr');
            alert(`Leave for ${row.cells[0].textContent} rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }
    </script>
</body>
</html>