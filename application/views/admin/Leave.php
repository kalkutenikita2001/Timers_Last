<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
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
        /* Table Styles */
        .table-container {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 20px;
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
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 400px;
            margin: 10% auto;
            position: relative;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            text-align: center;
        }
        .modal-header h2 {
            font-weight: 700;
            margin: 0.5rem 0 1rem;
            font-size: 1.25rem;
            color: #343a40;
        }
        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            color: #666;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            width: 24px;
            height: 24px;
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
            padding: 10px 15px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }
        .form-group {
            flex: 1;
            min-width: 100%;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 12px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 12px;
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
            min-height: 60px;
        }
        .date-input {
            position: relative;
        }
        .date-input input[type="date"] {
            padding-right: 30px;
        }
        .date-input::after {
            /* content: "📅"; */
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 14px;
        }
        .error {
            color: #dc3545;
            font-size: 10px;
            margin-top: 3px;
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
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 15px auto 0;
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
            transition: all 0.3s ease;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(211, 47, 47, 0.4);
        }
        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        /* Filter Modal Styles */
        .filter-modal {
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
        .filter-modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 400px;
            margin: 10% auto;
            position: relative;
        }
        .filter-modal-header {
            border-bottom: none;
            padding-bottom: 0;
            text-align: center;
        }
        .filter-modal-header h2 {
            font-weight: 700;
            margin: 0.5rem 0 1rem;
            font-size: 1.25rem;
            color: #343a40;
        }
        .filter-modal-body {
            padding: 10px 15px;
        }
        .filter-form-group {
            margin-bottom: 10px;
        }
        .filter-form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 12px;
        }
        .filter-form-group input,
        .filter-form-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 12px;
            background: white;
            color: #333;
            transition: border-color 0.3s ease;
        }
        .filter-form-group input:focus,
        .filter-form-group select:focus {
            outline: none;
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .filter-btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .apply-filter-btn, .reset-filter-btn {
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
            transition: all 0.3s ease;
        }
        .reset-filter-btn {
            background: #e0e0e0;
            color: #333;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .apply-filter-btn:hover, .reset-filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(211, 47, 47, 0.4);
        }
        .reset-filter-btn:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
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
            .modal-content, .filter-modal-content {
                width: 95%;
                max-width: 350px;
                margin: 15% auto;
            }
            .modal-body, .filter-modal-body {
                padding: 10px;
            }
            .form-row {
                flex-direction: column;
                gap: 8px;
            }
            .add-btn {
                padding: 8px 20px;
                font-size: 14px;
            }
        }
        @media (max-width: 480px) {
            .modal-content, .filter-modal-content {
                width: 98%;
                max-width: 300px;
                margin: 10% auto;
            }
            .modal-body, .filter-modal-body {
                padding: 8px;
            }
            .form-group label, .filter-form-group label {
                font-size: 11px;
            }
            .form-group input, .form-group textarea, .filter-form-group input, .filter-form-group select {
                padding: 6px 8px;
                font-size: 11px;
            }
            .save-btn, .apply-filter-btn, .reset-filter-btn {
                padding: 6px 15px;
                font-size: 12px;
            }
        }
        @media (min-width: 769px) and (max-width: 1024px) {
            .content-wrapper {
                margin-left: 200px;
            }
            .modal-content, .filter-modal-content {
                max-width: 450px;
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
                <button class="filter-btn" onclick="openFilterModal()">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
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
                                <button class="action-btn view-btn" onclick="viewLeave(this)"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editLeave(this)"><i class="fas fa-edit"></i></button>
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
                                <button class="action-btn view-btn" onclick="viewLeave(this)"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editLeave(this)"><i class="fas fa-edit"></i></button>
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
                                <button class="action-btn view-btn" onclick="viewLeave(this)"><i class="fas fa-eye"></i></button>
                                <button class="action-btn edit-btn" onclick="editLeave(this)"><i class="fas fa-edit"></i></button>
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
                            <label for="name">Name <span class="text-danger">*</span>:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                            <div class="error">Name is required</div>
                        </div>
                    </div>
                    <div class="form-row">
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
                    </div>
                    <div class="form-row">
                        <div class="form-group date-input">
                            <label for="date">Date <span class="text-danger">*</span>:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                            <div class="error">Date is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="reason">Reason <span class="text-danger">*</span>:</label>
                            <input type="text" id="reason" name="reason" class="form-control" required>
                            <div class="error">Reason is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span>:</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
                            <div class="error">Description is required</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Modal -->
    <div id="filterModal" class="filter-modal">
        <div class="filter-modal-content">
            <div class="filter-modal-header">
                <span class="close" onclick="closeFilterModal()">×</span>
                <h2>Filter Leaves</h2>
            </div>
            <div class="filter-modal-body">
                <form id="filterForm">
                    <div class="filter-form-group">
                        <label for="filterName">Name:</label>
                        <input type="text" id="filterName" name="filterName" class="form-control">
                    </div>
                    <div class="filter-form-group">
                        <label for="filterBatch">Batch:</label>
                        <input type="text" id="filterBatch" name="filterBatch" class="form-control">
                    </div>
                    <div class="filter-form-group">
                        <label for="filterLevel">Level:</label>
                        <input type="text" id="filterLevel" name="filterLevel" class="form-control">
                    </div>
                    <div class="filter-form-group">
                        <label for="filterDate">Date:</label>
                        <input type="date" id="filterDate" name="filterDate" class="form-control">
                    </div>
                    <div class="filter-btn-container">
                        <button type="button" class="reset-filter-btn" onclick="resetFilter()">Reset</button>
                        <button type="submit" class="apply-filter-btn">Apply</button>
                    </div>
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
            document.querySelector('.modal-title').textContent = 'Add Leave';
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

            if (!date.value) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!reason.value.trim()) {
                reason.closest('.form-group').classList.add('invalid');
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
                    name: formData.get('name'),
                    batch: formData.get('batch'),
                    level: formData.get('level'),
                    date: formData.get('date'),
                    reason: formData.get('reason'),
                    description: formData.get('description')
                };

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
                    <button class="action-btn view-btn" onclick="viewLeave(this)"><i class="fas fa-eye"></i></button>
                    <button class="action-btn edit-btn" onclick="editLeave(this)"><i class="fas fa-edit"></i></button>
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
            const [day, month, year] = cells[3].textContent.split('/');
            document.getElementById('date').value = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
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

        // Filter Modal functionality
        const filterModal = document.getElementById('filterModal');
        const filterForm = document.getElementById('filterForm');
        let originalRows = [];

        function openFilterModal() {
            filterModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            // Store original table rows if not already stored
            if (!originalRows.length) {
                const tableBody = document.getElementById('leaveTableBody');
                originalRows = Array.from(tableBody.querySelectorAll('tr')).map(row => row.outerHTML);
            }
            filterForm.reset();
        }

        function closeFilterModal() {
            filterModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            filterForm.reset();
        }

        function resetFilter() {
            filterForm.reset();
            const tableBody = document.getElementById('leaveTableBody');
            tableBody.innerHTML = originalRows.join('');
            closeFilterModal();
        }

        // Filter form submission
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const filterData = {
                name: document.getElementById('filterName').value.trim().toLowerCase(),
                batch: document.getElementById('filterBatch').value.trim().toLowerCase(),
                level: document.getElementById('filterLevel').value.trim().toLowerCase(),
                date: document.getElementById('filterDate').value
            };

            const tableBody = document.getElementById('leaveTableBody');
            tableBody.innerHTML = '';

            const filteredRows = originalRows.filter(row => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = row;
                const cells = tempDiv.querySelectorAll('td');
                const rowData = {
                    name: cells[0].textContent.toLowerCase(),
                    batch: cells[1].textContent.toLowerCase(),
                    level: cells[2].textContent.toLowerCase(),
                    date: cells[3].textContent
                };

                return (
                    (!filterData.name || rowData.name.includes(filterData.name)) &&
                    (!filterData.batch || rowData.batch.includes(filterData.batch)) &&
                    (!filterData.level || rowData.level.includes(filterData.level)) &&
                    (!filterData.date || rowData.date === new Date(filterData.date).toLocaleDateString('en-GB'))
                );
            });

            tableBody.innerHTML = filteredRows.join('');
            closeFilterModal();
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
    </script>
</body>
</html>