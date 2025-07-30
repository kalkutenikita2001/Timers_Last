<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses</title>
    <!-- Bootstrap CSS -->
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
            color: #333;
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

        .filter-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
        }

        .filter-btn {
            background: linear-gradient(to right, #ff4040, #470000);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 10px;
            font-size: 12px;
            width: 100px;
            cursor: pointer;
        }

        .filter-btn:hover {
            background: linear-gradient(to right, #ff3030, #360000);
        }

        .table-container {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #000;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 12px 15px;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 12px 15px;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:last-child td:first-child {
            border-bottom-left-radius: 15px;
        }

        .table tbody tr:last-child td:last-child {
            border-bottom-right-radius: 15px;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
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
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            background: none;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .view-btn {
            color: black;
        }

        .edit-btn {
            color: black;
        }

        .view-btn:hover {
            color: #0056b3;
            transform: scale(1.1);
        }

        .edit-btn:hover {
            color: #0056b3;
            transform: scale(1.1);
        }

        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .add-btn {
            background: linear-gradient(90deg, #ff4040, #470000);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            width: 200px;
            font-size: 15px;
            margin: 25px auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .add-btn:hover {
            background: linear-gradient(to right, #ff3030, #360000);
        }

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
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('admin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container">
            <!-- Filter Button -->
            <div class="filter-wrapper">
                <button class="filter-btn">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>

            <!-- Main Table -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <tr>
                            <td>Rent</td>
                            <td>15/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdfghjkl;ertyuiouygfdsfghj</td>
                            <td>
                                <div class="action-cell">
                                    <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Fees</td>
                            <td>15/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdfghjkl;ertyuiouygfdsfghj</td>
                            <td>
                                <div class="action-cell">
                                    <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Rent</td>
                            <td>15/07/2025</td>
                            <td>Rs.5674</td>
                            <td>sdfghjkl;ertyuiouygfdsfghj</td>
                            <td>
                                <div class="action-cell">
                                    <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Add Button -->
            <div class="add-btn-container">
                <button class="add-btn" onclick="openModal()">Add Income/Expences</button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="expenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">×</span>
                <h2 class="modal-title">Add Income / Expences</h2>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span>:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                            <div class="error">Title is required</div>
                        </div>
                        <div class="form-group">
                            <label for="date">Date <span class="text-danger">*</span>:</label>
                            <div class="date-input">
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="error">Date is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="amount">Amount <span class="text-danger">*</span>:</label>
                            <input type="number" id="amount" name="amount" step="0.01" class="form-control" required min="0.01">
                            <div class="error">Amount must be greater than 0</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span>:</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Enter description..." required></textarea>
                            <div class="error">Description is required</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn btn btn-primary">Save</button>
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
        const modal = document.getElementById('expenseModal');
        const form = document.getElementById('expenseForm');
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
            const title = document.getElementById('title');
            const date = document.getElementById('date');
            const amount = document.getElementById('amount');
            const description = document.getElementById('description');

            let isValid = true;

            // Clear previous errors
            clearValidationErrors();

            // Validate title
            if (!title.value.trim()) {
                title.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate date
            if (!date.value) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            // Validate amount
            if (!amount.value || amount.value <= 0) {
                amount.closest('.form-group').classList.add('invalid');
                amount.closest('.form-group').querySelector('.error').textContent = 'Amount must be greater than 0';
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
                    title: formData.get('title'),
                    date: formatDate(formData.get('date')),
                    amount: `Rs.${formData.get('amount')}`,
                    description: formData.get('description') || 'No description'
                };

                if (editingRow) {
                    updateRow(editingRow, data);
                } else {
                    addNewRow(data);
                }

                closeModal();
            }
        });

        // Format date to DD/MM/YYYY
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Add new row to table
        function addNewRow(data) {
            const tableBody = document.getElementById('expenseTableBody');
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${data.title}</td>
                <td>${data.date}</td>
                <td>${data.amount}</td>
                <td>${data.description}</td>
                <td>
                    <div class="action-cell">
                        <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                    </div>
                </td>
            `;

            tableBody.appendChild(row);
        }

        // Update existing row
        function updateRow(row, data) {
            const cells = row.querySelectorAll('td');
            cells[0].textContent = data.title;
            cells[1].textContent = data.date;
            cells[2].textContent = data.amount;
            cells[3].textContent = data.description;
        }

        // View expense
        function viewExpense(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');

            alert(`Title: ${cells[0].textContent}\nDate: ${cells[1].textContent}\nAmount: ${cells[2].textContent}\nDescription: ${cells[3].textContent}`);
        }

        // Edit expense
        function editExpense(button) {
            editingRow = button.closest('tr');
            const cells = editingRow.querySelectorAll('td');

            // Convert date back to YYYY-MM-DD format
            const dateStr = cells[1].textContent;
            const [day, month, year] = dateStr.split('/');
            const formattedDate = `${year}-${month}-${day}`;

            // Fill form with existing data
            document.getElementById('title').value = cells[0].textContent;
            document.getElementById('date').value = formattedDate;
            document.getElementById('amount').value = cells[2].textContent.replace('Rs.', '');
            document.getElementById('description').value = cells[3].textContent;

            // Change modal title
            document.querySelector('.modal-title').textContent = 'Edit Income / Expences';

            openModal();
        }

        // Real-time validation
        document.getElementById('title').addEventListener('input', function() {
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

        document.getElementById('amount').addEventListener('input', function() {
            if (this.value && this.value > 0) {
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

        // Set current date as default
        document.getElementById('date').value = new Date().toISOString().split('T')[0];

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        // Mobile behavior
                        if (sidebar) {
                            sidebar.classList.toggle('active');
                            navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                        }
                    } else {
                        // Desktop behavior - minimize/maximize
                        if (sidebar && contentWrapper) {
                            const isMinimized = sidebar.classList.toggle('minimized');
                            navbar.classList.toggle('sidebar-minimized', isMinimized);
                            contentWrapper.classList.toggle('minimized', isMinimized);
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
