<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income and Expenses</title>
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
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
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
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
        .form-group.invalid input,
        .form-group.invalid textarea {
            border-color: #dc3545;
        }
        .form-group.invalid .error {
            display: block;
        }
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
            .modal-content {
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
            }
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .content-wrapper {
                margin-left: 200px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
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
                <button class="add-btn" onclick="openModal()">Add Income/Expenses</button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="expenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 class="modal-title">Add Income / Expenses</h2>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span>:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                            <div class="error">Title is required</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date">Date <span class="text-danger">*</span>:</label>
                            <div class="date-input">
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="error">Date is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="amount">Amount <span class="text-danger">*</span>:</label>
                            <input type="number" id="amount" name="amount" step="0.01" class="form-control" required min="0.01">
                            <div class="error">Amount must be greater than 0</div>
                        </div>
                        <div class="form-group col-md-6">
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

            clearValidationErrors();

            if (!title.value.trim()) {
                title.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!date.value) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!amount.value || amount.value <= 0) {
                amount.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

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
            document.querySelector('.modal-title').textContent = 'Edit Income / Expenses';
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
    </script>
</body>
</html>
