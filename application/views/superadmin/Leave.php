<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
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
            background-color: #e9ecef !important;
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
            justify-content: space-around;
            background: #fff;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 17px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .tab-buttons button {
            flex: 1;
            text-align: center;
            color: #000;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px;
            font-weight: 600;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .tab-buttons button.active {
            color: #007bff;
            border-bottom: 2px solid #007bff;
        }
        .tab-buttons button:hover {
            color: #0056b3;
        }
        /* Table Styles */
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
            background: #fff;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #343a40;
            color: #fff;
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
            transition: background-color 0.3s ease;
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
            transition: transform 0.2s ease, color 0.3s ease;
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
            background: linear-gradient(to right, #ff4040, #470000);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 10px;
            font-size: 12px;
            width: 200px;
            cursor: pointer;
            transition: all 0.3s ease;
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
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease-in-out;
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
            padding: 25px;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            flex: 1;
            position: relative;
            animation: slideInField 0.3s ease-in-out;
            animation-fill-mode: backwards;
        }
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        @keyframes slideInField {
            from { transform: translateY(10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 15px;
            color: #333;
            transition: color 0.3s ease;
        }
        .form-group input:focus + label,
        .form-group textarea:focus + label {
            color: #d32f2f;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 8px rgba(211, 47, 47, 0.3);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .error {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 6px;
            display: none;
            font-weight: 500;
        }
        .form-group.invalid input,
        .form-group.invalid textarea {
            border-color: #d32f2f;
            background: #ffeaea;
            animation: shake 0.3s ease;
        }
        .form-group.invalid .error {
            display: block;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
        .save-btn {
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            color: white;
            border: none;
            padding: 12px 40px;
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
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
        }
        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .save-btn:active {
            animation: pulse 0.2s ease;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }
        /* Responsive Design */
        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .container {
                margin-top: 60px;
            }
            .table {
                min-width: 800px;
                font-size: 0.8rem;
            }
            .table td, .table th {
                padding: 0.5rem;
            }
            .action-btn {
                font-size: 0.8rem;
                margin: 0 0.1rem;
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
                margin-bottom: 15px;
            }
            .form-group label {
                font-size: 14px;
            }
            .form-group input,
            .form-group textarea {
                padding: 10px;
                font-size: 13px;
            }
            .add-btn {
                font-size: 14px;
            }
            .tab-buttons {
                flex-direction: column;
                gap: 5px;
            }
            .tab-buttons button {
                font-size: 12px;
                padding: 8px;
            }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }
            .table {
                min-width: 800px;
                font-size: 0.85rem;
            }
            .modal-content {
                width: 90%;
                padding: 1.25rem;
            }
            .tab-buttons {
                gap: 8px;
            }
            .form-row {
                gap: 15px;
            }
            .form-group label {
                font-size: 14px;
            }
            .form-group input,
            .form-group textarea {
                padding: 11px;
                font-size: 13.5px;
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
                width: 80%;
            }
        }
        @media (min-width: 992px) {
            .igliano: .modal-content {
                max-width: 500px;
            }
        }
        /* Touch device hover fix */
        @media (hover: none) {
            .action-btn:hover,
            .add-btn:hover,
            .save-btn:hover,
            .tab-buttons button:hover {
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
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"><i class="fas fa-check"></i></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"><i class="fas fa-times"></i></button>
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
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"><i class="fas fa-check"></i></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"><i class="fas fa-times"></i></button>
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
                            <button class="action-btn thumbs-up" onclick="approveLeave(this)"><i class="fas fa-check"></i></button>
                            <button class="action-btn cross" onclick="rejectLeave(this)"><i class="fas fa-times"></i></button>
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
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required aria-describedby="nameError">
                            <div id="nameError" class="error">Please enter a valid name (letters only, min 2 characters)</div>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <input type="text" id="batch" name="batch" required aria-describedby="batchError">
                            <div id="batchError" class="error">Please enter a valid batch (alphanumeric, 1-10 characters)</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Level</label>
                            <input type="text" id="level" name="level" required aria-describedby="levelError">
                            <div id="levelError" class="error">Please enter Beginner, Intermediate, or Advanced</div>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required aria-describedby="dateError">
                            <div id="dateError" class="error">Please select a future date</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input type="text" id="reason" name="reason" required aria-describedby="reasonError">
                        <div id="reasonError" class="error">Please enter a reason (min 5 characters)</div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required aria-describedby="descriptionError"></textarea>
                        <div id="descriptionError" class="error">Please enter a description (10-500 characters)</div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sample data for each center
        const centerData = {
            'Center 1': [
                { name: 'Jane Doe', batch: 'B1', level: 'Intermediate', date: '2025-07-15', reason: 'sdfghj', description: 'sdfghjertyuiopasdfghj' },
                { name: 'John Smith', batch: 'B1', level: 'Intermediate', date: '2025-07-16', reason: 'Medical', description: 'Doctor appointment' },
                { name: 'Alice Brown', batch: 'B1', level: 'Intermediate', date: '2025-07-17', reason: 'Personal', description: 'Family event' }
            ],
            'Center 2': [
                { name: 'Bob Wilson', batch: 'B2', level: 'Beginner', date: '2025-07-18', reason: 'Vacation', description: 'Annual leave' },
                { name: 'Emma Davis', batch: 'B2', level: 'Beginner', date: '2025-07-19', reason: 'Sick', description: 'Flu recovery' }
            ],
            'Center 3': [
                { name: 'Michael Lee', batch: 'B3', level: 'Advanced', date: '2025-07-20', reason: 'Emergency', description: 'Family emergency' },
                { name: 'Sarah Adams', batch: 'B3', level: 'Advanced', date: '2025-07-21', reason: 'Travel', description: 'Business trip' }
            ],
            'Center 4': [
                { name: 'David Clark', batch: 'B4', level: 'Intermediate', date: '2025-07-22', reason: 'Personal', description: 'Personal commitment' }
            ]
        };

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
            form.querySelector('.save-btn').disabled = false;
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

            // Validate name (letters only, min 2 characters)
            if (!name.value.trim() || !/^[a-zA-Z\s]{2,}$/.test(name.value.trim())) {
                name.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate batch (alphanumeric, 1-10 characters)
            if (!batch.value.trim() || !/^[a-zA-Z0-9]{1,10}$/.test(batch.value.trim())) {
                batch.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate level (Beginner, Intermediate, Advanced)
            const validLevels = ['Beginner', 'Intermediate', 'Advanced'];
            if (!level.value.trim() || !validLevels.includes(level.value.trim())) {
                level.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate date (future date)
            const today = new Date('2025-07-31');
            const selectedDate = new Date(date.value);
            if (!date.value || selectedDate <= today) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate reason (min 5 characters)
            if (!reason.value.trim() || reason.value.trim().length < 5) {
                reason.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate description (10-500 characters)
            if (!description.value.trim() || description.value.trim().length < 10 || description.value.trim().length > 500) {
                description.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const saveBtn = form.querySelector('.save-btn');
            saveBtn.disabled = true; // Disable button during submission
            
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
                    const activeCenter = document.querySelector('.tab-buttons button.active').textContent;
                    centerData[activeCenter].push(data);
                }

                closeModal();
            } else {
                saveBtn.disabled = false; // Re-enable button if validation fails
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
                    <button class="action-btn thumbs-up" onclick="approveLeave(this)"><i class="fas fa-check"></i></button>
                    <button class="action-btn cross" onclick="rejectLeave(this)"><i class="fas fa-times"></i></button>
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

        // Approve and Reject functionality
        function approveLeave(button) {
            const row = button.closest('tr');
            row.style.backgroundColor = '#d4edda';
            alert(`Leave for ${row.cells[0].textContent} approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }

        function rejectLeave(button) {
            const row = button.closest('tr');
            row.style.backgroundColor = '#f8d7da';
            alert(`Leave for ${row.cells[0].textContent} rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 576) {
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

            // Initialize Center 1 table on page load
            switchTab('Center 1');
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

            // Clear table body
            const tableBody = document.getElementById('leaveTableBody');
            tableBody.innerHTML = '';

            // Populate table with data for the selected center
            const data = centerData[center] || [];
            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No records available for this center.</td></tr>';
            } else {
                data.forEach(item => addNewRow(item));
            }
        }
    </script>
</body>
</html>
