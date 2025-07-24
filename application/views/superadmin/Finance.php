<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Management</title>
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

        /* Option Buttons Styles */
        .option-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .option-buttons button {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .option-buttons button.active {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .option-buttons button:hover {
            background: #333;
            color: #fff;
        }

        /* Add Button and Filter */
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
            align-items: center;
        }

        .add-btn {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            background: #c82333;
        }

        .filter-btn {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background: #5a6268;
        }

        /* Table Styles */
        .table-container {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin: 0;
        }

        .table thead th {
            background-color: #333;
            color: #fff;
            border-bottom: 2px solid #ddd;
            white-space: nowrap;
            padding: 15px 10px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .table tbody tr:hover {
            background-color: #e0e0e0;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 15px 10px;
            color: #000;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
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
            border: 2px dashed #666;
            border-radius: 50%;
            cursor: pointer;
            background: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            border-color: #000;
        }

        .action-btn.thumbs-up::before {
            content: "👍";
        }

        .action-btn.cross::before {
            content: "✖";
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
            background-color: rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: #f5f5f5;
            margin: 8% auto;
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
            padding: 25px 25px 20px;
            border-bottom: none;
            position: relative;
        }

        .modal-title {
            font-size: 22px;
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
            padding: 20px 40px 40px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full-width {
            flex: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .date-input {
            position: relative;
        }

        .date-input input[type="date"] {
            position: relative;
            padding-right: 40px;
        }

        .date-input::after {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 16px;
        }

        .error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.invalid input,
        .form-group.invalid textarea,
        .form-group.invalid select {
            border-color: #dc3545;
            background: #ffeaea;
        }

        .form-group.invalid .error {
            display: block;
        }

        .save-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 40px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 30px auto 0;
            transition: all 0.3s ease;
        }

        .save-btn:hover {
            background: #c82333;
        }

        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Filter Modal Styles */
        #filterModal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
        }

        #filterModal .modal-content {
            max-width: 400px;
        }

        #filterModal .close {
            top: 15px;
            right: 15px;
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
                padding: 10px 8px;
                font-size: 12px;
            }

            .modal-content {
                width: 95%;
                margin: 10% auto;
            }

            .modal-body {
                padding: 15px 20px 30px;
            }

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .add-btn-container {
                justify-content: center;
                flex-direction: column;
                gap: 10px;
            }

            .option-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .option-buttons button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .modal-content {
                width: 98%;
                margin: 5% auto;
            }

            .modal-body {
                padding: 12px 15px 25px;
            }

            .form-group label {
                font-size: 12px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 10px 12px;
                font-size: 12px;
            }

            .option-buttons button {
                padding: 8px 20px;
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
        <!-- Option Buttons -->
        <div class="option-buttons">
            <button class="active" onclick="switchOption('centerwise')">Centerwise Expenses</button>
            <button onclick="switchOption('totalrevenue')">Total Revenue</button>
        </div>

        <!-- Add Button and Filter -->
        <div class="add-btn-container">
            <button class="filter-btn" onclick="openFilterModal()">Filter</button>
            <button class="add-btn" onclick="openModal()">Add Revenue</button>
        </div>

        <!-- Revenue Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Daily Revenue(₹)</th>
                        <th>Weekly Revenue(₹)</th>
                        <th>Monthly Revenue(₹)</th>
                        <th>Yearly Revenue(₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expenseTableBody">
                    <tr>
                        <td>Rent</td>
                        <td>Rs.500</td>
                        <td>Rs.3500</td>
                        <td>Rs.15000</td>
                        <td>Rs.180000</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                            <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Food</td>
                        <td>Rs.300</td>
                        <td>Rs.2100</td>
                        <td>Rs.9000</td>
                        <td>Rs.108000</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                            <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Rent</td>
                        <td>Rs.500</td>
                        <td>Rs.3500</td>
                        <td>Rs.15000</td>
                        <td>Rs.180000</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                            <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>

    <!-- Revenue Modal -->
    <div id="expenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">×</span>
                <h2 class="modal-title">Add Revenue</h2>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="title">Title <span class="required">*</span></label>
                            <input type="text" id="title" name="title" maxlength="50" required>
                            <div class="error">Title is required and must be less than 50 characters</div>
                        </div>
                        <div class="form-group date-input">
                            <label for="date">Date <span class="required">*</span></label>
                            <input type="date" id="date" name="date" required>
                            <div class="error">Date is required and must not be a future date</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="dailyRevenue">Daily Revenue(₹) <span class="required">*</span></label>
                            <input type="number" id="dailyRevenue" name="dailyRevenue" step="0.01" min="1" required>
                            <div class="error">Daily Revenue is required and must be greater than 0</div>
                        </div>
                        <div class="form-group">
                            <label for="weeklyRevenue">Weekly Revenue(₹) <span class="required">*</span></label>
                            <input type="number" id="weeklyRevenue" name="weeklyRevenue" step="0.01" min="1" required>
                            <div class="error">Weekly Revenue is required and must be greater than 0</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="monthlyRevenue">Monthly Revenue(₹) <span class="required">*</span></label>
                            <input type="number" id="monthlyRevenue" name="monthlyRevenue" step="0.01" min="1" required>
                            <div class="error">Monthly Revenue is required and must be greater than 0</div>
                        </div>
                        <div class="form-group">
                            <label for="yearlyRevenue">Yearly Revenue(₹) <span class="required">*</span></label>
                            <input type="number" id="yearlyRevenue" name="yearlyRevenue" step="0.01" min="1" required>
                            <div class="error">Yearly Revenue is required and must be greater than 0</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="notes">Notes</label>
                            <textarea id="notes" name="notes" maxlength="200"></textarea>
                            <div class="error">Notes must be less than 200 characters</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeFilterModal()">×</span>
                <h2 class="modal-title">Filter Revenue</h2>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="form-row">
                        <div class="form-group date-input">
                            <label for="startDate">Start Date :</label>
                            <input type="date" id="startDate" name="startDate">
                        </div>
                        <div class="form-group date-input">
                            <label for="endDate">End Date :</label>
                            <input type="date" id="endDate" name="endDate">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="minDailyRevenue">Min Daily Revenue(₹) :</label>
                            <input type="number" id="minDailyRevenue" name="minDailyRevenue" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="maxDailyRevenue">Max Daily Revenue(₹) :</label>
                            <input type="number" id="maxDailyRevenue" name="maxDailyRevenue" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="minWeeklyRevenue">Min Weekly Revenue(₹) :</label>
                            <input type="number" id="minWeeklyRevenue" name="minWeeklyRevenue" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="maxWeeklyRevenue">Max Weekly Revenue(₹) :</label>
                            <input type="number" id="maxWeeklyRevenue" name="maxWeeklyRevenue" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="minMonthlyRevenue">Min Monthly Revenue(₹) :</label>
                            <input type="number" id="minMonthlyRevenue" name="minMonthlyRevenue" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="maxMonthlyRevenue">Max Monthly Revenue(₹) :</label>
                            <input type="number" id="maxMonthlyRevenue" name="maxMonthlyRevenue" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="minYearlyRevenue">Min Yearly Revenue(₹) :</label>
                            <input type="number" id="minYearlyRevenue" name="minYearlyRevenue" min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="maxYearlyRevenue">Max Yearly Revenue(₹) :</label>
                            <input type="number" id="maxYearlyRevenue" name="maxYearlyRevenue" min="0" step="0.01">
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Apply Filter</button>
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
        const expenseModal = document.getElementById('expenseModal');
        const filterModal = document.getElementById('filterModal');
        const expenseForm = document.getElementById('expenseForm');
        const filterForm = document.getElementById('filterForm');
        let editingRow = null;

        function openModal() {
            expenseModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            resetForm();
        }

        function closeModal() {
            expenseModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            resetForm();
            editingRow = null;
        }

        function openFilterModal() {
            filterModal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            filterForm.reset();
        }

        function closeFilterModal() {
            filterModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function resetForm() {
            expenseForm.reset();
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
            const dailyRevenue = document.getElementById('dailyRevenue');
            const weeklyRevenue = document.getElementById('weeklyRevenue');
            const monthlyRevenue = document.getElementById('monthlyRevenue');
            const yearlyRevenue = document.getElementById('yearlyRevenue');
            const notes = document.getElementById('notes');
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Set to midnight for comparison

            let isValid = true;

            // Clear previous errors
            clearValidationErrors();

            if (!title.value.trim() || title.value.length > 50) {
                title.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!date.value || new Date(date.value) > currentDate) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!dailyRevenue.value || isNaN(dailyRevenue.value) || dailyRevenue.value <= 0) {
                dailyRevenue.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!weeklyRevenue.value || isNaN(weeklyRevenue.value) || weeklyRevenue.value <= 0) {
                weeklyRevenue.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!monthlyRevenue.value || isNaN(monthlyRevenue.value) || monthlyRevenue.value <= 0) {
                monthlyRevenue.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!yearlyRevenue.value || isNaN(yearlyRevenue.value) || yearlyRevenue.value <= 0) {
                yearlyRevenue.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (notes.value && notes.value.length > 200) {
                notes.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        // Form submission
        expenseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                const formData = new FormData(expenseForm);
                const data = {
                    title: formData.get('title'),
                    date: formData.get('date'),
                    dailyRevenue: `Rs.${parseFloat(formData.get('dailyRevenue')).toFixed(0)}`,
                    weeklyRevenue: `Rs.${parseFloat(formData.get('weeklyRevenue')).toFixed(0)}`,
                    monthlyRevenue: `Rs.${parseFloat(formData.get('monthlyRevenue')).toFixed(0)}`,
                    yearlyRevenue: `Rs.${parseFloat(formData.get('yearlyRevenue')).toFixed(0)}`,
                    notes: formData.get('notes') || 'N/A'
                };

                const tableBody = document.getElementById('expenseTableBody');
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
            const tableBody = document.getElementById('expenseTableBody');
            const row = document.createElement('tr');
            const currentOption = document.querySelector('.option-buttons .active').textContent.toLowerCase();
            if (currentOption === 'total revenue') {
                row.innerHTML = `
                    <td>${data.title}</td>
                    <td>${data.dailyRevenue}</td>
                    <td>${data.weeklyRevenue}</td>
                    <td>${data.monthlyRevenue}</td>
                    <td>${data.yearlyRevenue}</td>
                    <td class="action-cell">
                        <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                        <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                    </td>
                `;
            } else {
                row.innerHTML = `
                    <td>${data.title}</td>
                    <td>${data.dailyRevenue}</td>
                    <td>${data.weeklyRevenue}</td>
                    <td>${data.monthlyRevenue}</td>
                    <td>${data.yearlyRevenue}</td>
                    <td class="action-cell">
                        <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                        <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                    </td>
                `;
            }
            tableBody.appendChild(row);
        }

        // Update existing row
        function updateRow(row, data) {
            const cells = row.querySelectorAll('td');
            cells[0].textContent = data.title;
            cells[1].textContent = data.dailyRevenue;
            cells[2].textContent = data.weeklyRevenue;
            cells[3].textContent = data.monthlyRevenue;
            cells[4].textContent = data.yearlyRevenue;
        }

        // Real-time validation
        document.getElementById('title').addEventListener('input', function() {
            if (this.value.trim() && this.value.length <= 50) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('date').addEventListener('change', function() {
            const currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0);
            if (this.value && new Date(this.value) <= currentDate) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('dailyRevenue').addEventListener('input', function() {
            if (this.value && !isNaN(this.value) && this.value > 0) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('weeklyRevenue').addEventListener('input', function() {
            if (this.value && !isNaN(this.value) && this.value > 0) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('monthlyRevenue').addEventListener('input', function() {
            if (this.value && !isNaN(this.value) && this.value > 0) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('yearlyRevenue').addEventListener('input', function() {
            if (this.value && !isNaN(this.value) && this.value > 0) {
                this.closest('.form-group').classList.remove('invalid');
            } else {
                this.closest('.form-group').classList.add('invalid');
            }
        });

        document.getElementById('notes').addEventListener('input', function() {
            if (!this.value || this.value.length <= 200) {
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

        // Option switching functionality
        function switchOption(option) {
            const buttons = document.querySelectorAll('.option-buttons button');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if ((btn.textContent === 'Centerwise Expenses' && option === 'centerwise') || 
                    (btn.textContent === 'Total Revenue' && option === 'totalrevenue')) {
                    btn.classList.add('active');
                }
            });

            const tableBody = document.getElementById('expenseTableBody');
            tableBody.innerHTML = '';
            if (option === 'totalrevenue') {
                const totalRevenue = [
                    { title: 'Center A', dailyRevenue: 'Rs.500', weeklyRevenue: 'Rs.3500', monthlyRevenue: 'Rs.15000', yearlyRevenue: 'Rs.180000' },
                    { title: 'Center B', dailyRevenue: 'Rs.300', weeklyRevenue: 'Rs.2100', monthlyRevenue: 'Rs.9000', yearlyRevenue: 'Rs.108000' },
                    { title: 'Center C', dailyRevenue: 'Rs.400', weeklyRevenue: 'Rs.2800', monthlyRevenue: 'Rs.12000', yearlyRevenue: 'Rs.144000' }
                ];
                totalRevenue.forEach(data => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${data.title}</td>
                        <td>${data.dailyRevenue}</td>
                        <td>${data.weeklyRevenue}</td>
                        <td>${data.monthlyRevenue}</td>
                        <td>${data.yearlyRevenue}</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                            <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            } else {
                const centerwiseExpenses = [
                    { title: 'Rent', dailyRevenue: 'Rs.500', weeklyRevenue: 'Rs.3500', monthlyRevenue: 'Rs.15000', yearlyRevenue: 'Rs.180000' },
                    { title: 'Food', dailyRevenue: 'Rs.300', weeklyRevenue: 'Rs.2100', monthlyRevenue: 'Rs.9000', yearlyRevenue: 'Rs.108000' },
                    { title: 'Rent', dailyRevenue: 'Rs.500', weeklyRevenue: 'Rs.3500', monthlyRevenue: 'Rs.15000', yearlyRevenue: 'Rs.180000' }
                ];
                centerwiseExpenses.forEach(data => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${data.title}</td>
                        <td>${data.dailyRevenue}</td>
                        <td>${data.weeklyRevenue}</td>
                        <td>${data.monthlyRevenue}</td>
                        <td>${data.yearlyRevenue}</td>
                        <td class="action-cell">
                            <button class="action-btn thumbs-up" onclick="approveExpense(this)"></button>
                            <button class="action-btn cross" onclick="rejectExpense(this)"></button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        }

        // Approve and Reject functionality
        function approveExpense(button) {
            const row = button.closest('tr');
            row.style.backgroundColor = '#d4edda';
            alert(`Revenue approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }

        function rejectExpense(button) {
            const row = button.closest('tr');
            row.style.backgroundColor = '#f8d7da';
            alert(`Revenue rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);
        }

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === expenseModal) {
                closeModal();
            }
            if (event.target === filterModal) {
                closeFilterModal();
            }
        });

        // Filter functionality
        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const minDailyRevenue = document.getElementById('minDailyRevenue').value;
            const maxDailyRevenue = document.getElementById('maxDailyRevenue').value;
            const minWeeklyRevenue = document.getElementById('minWeeklyRevenue').value;
            const maxWeeklyRevenue = document.getElementById('maxWeeklyRevenue').value;
            const minMonthlyRevenue = document.getElementById('minMonthlyRevenue').value;
            const maxMonthlyRevenue = document.getElementById('maxMonthlyRevenue').value;
            const minYearlyRevenue = document.getElementById('minYearlyRevenue').value;
            const maxYearlyRevenue = document.getElementById('maxYearlyRevenue').value;

            const tableBody = document.getElementById('expenseTableBody');
            const rows = tableBody.getElementsByTagName('tr');

            for (let row of rows) {
                const dateCell = row.cells[1].textContent; // Assuming date is not directly in table, using first revenue column for filter context
                const dailyRevenue = row.cells[1].textContent.replace('Rs.', '');
                const weeklyRevenue = row.cells[2].textContent.replace('Rs.', '');
                const monthlyRevenue = row.cells[3].textContent.replace('Rs.', '');
                const yearlyRevenue = row.cells[4].textContent.replace('Rs.', '');
                let showRow = true;

                if (startDate && new Date(dateCell) < new Date(startDate)) showRow = false;
                if (endDate && new Date(dateCell) > new Date(endDate)) showRow = false;
                if (minDailyRevenue && parseFloat(dailyRevenue) < parseFloat(minDailyRevenue)) showRow = false;
                if (maxDailyRevenue && parseFloat(dailyRevenue) > parseFloat(maxDailyRevenue)) showRow = false;
                if (minWeeklyRevenue && parseFloat(weeklyRevenue) < parseFloat(minWeeklyRevenue)) showRow = false;
                if (maxWeeklyRevenue && parseFloat(weeklyRevenue) > parseFloat(maxWeeklyRevenue)) showRow = false;
                if (minMonthlyRevenue && parseFloat(monthlyRevenue) < parseFloat(minMonthlyRevenue)) showRow = false;
                if (maxMonthlyRevenue && parseFloat(monthlyRevenue) > parseFloat(maxMonthlyRevenue)) showRow = false;
                if (minYearlyRevenue && parseFloat(yearlyRevenue) < parseFloat(minYearlyRevenue)) showRow = false;
                if (maxYearlyRevenue && parseFloat(yearlyRevenue) > parseFloat(maxYearlyRevenue)) showRow = false;

                row.style.display = showRow ? '' : 'none';
            }

            closeFilterModal();
        });
    </script>
</body>
</html>