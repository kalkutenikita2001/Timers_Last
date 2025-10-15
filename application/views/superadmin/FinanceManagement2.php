<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Academy Finance Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            overflow-x: hidden;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .nav-container {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background: #fff;
            border-bottom: 2px solid #e74c3c;
            box-shadow: 0 2px 6px rgba(231, 76, 60, 0.2);
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-tabs {
            display: flex;
            margin-left: 20px;
            gap: 15px;
        }
        .nav-tabs a {
            padding: 10px 20px;
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-tabs a.active {
            color: #e74c3c;
            border-bottom: 2px solid #e74c3c;
            font-weight: 700;
        }
        .nav-tabs a:hover {
            color: #e74c3c;
            transform: translateY(-2px);
        }
        .filters {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .filters select, .filters input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9em;
            transition: all 0.3s ease;
            background: #fff;
            color: #333;
        }
        .filters select:focus, .filters input:focus {
            border-color: #e74c3c;
            outline: none;
            box-shadow: 0 0 5px rgba(231, 76, 60, 0.3);
        }
        .content {
            padding: 30px 0;
            transition: all 0.3s ease;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .filter-section {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border-left: 4px solid #e74c3c;
        }
        .filter-section label {
            font-weight: 500;
            color: #333;
        }
        .filter-section button {
            padding: 8px 15px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .filter-section button:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        .summary-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 100%;
            max-width: 350px;
            transition: all 0.3s ease;
        }
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(231, 76, 60, 0.2);
        }
        .summary-card h3 {
            margin-bottom: 15px;
            color: #e74c3c;
            font-size: 1.2em;
            text-align: center;
            font-weight: 700;
        }
        .summary-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 12px;
            background: #fff;
            border-left: 4px solid #e74c3c;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .summary-item:hover {
            background: #fef0ef;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.1);
        }
        .summary-item i {
            margin-right: 10px;
            font-size: 1.2em;
            color: #e74c3c;
            width: 25px;
        }
        .summary-item span {
            flex: 1;
            color: #555;
            font-weight: 500;
        }
        .summary-item .value {
            font-weight: bold;
            color: #e74c3c;
            font-size: 1.2em;
            min-width: 120px;
            text-align: right;
        }
        /* Extra bold styling for financial amounts */
        #paid-amount, #pending-amount, #expense-amount {
            font-weight: 900 !important;
            font-size: 1.4em !important;
            color: #d32f2f !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 6px rgba(231, 76, 60, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #e74c3c;
            color: #fff;
            font-weight: 600;
        }
        tr:hover td {
            background: #f8f9fa;
        }
        .center-badge {
            font-size: 0.8em;
            padding: 4px 8px;
            border-radius: 12px;
        }
        .add-form {
            margin-top: 20px;
            display: none;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(231, 76, 60, 0.1);
            border-left: 4px solid #e74c3c;
        }
        .add-form.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .add-form input, .add-form select {
            margin-right: 10px;
            margin-bottom: 10px;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9em;
            transition: all 0.3s ease;
            width: auto;
            min-width: 150px;
        }
        .add-form input:focus, .add-form select:focus {
            border-color: #e74c3c;
            outline: none;
            box-shadow: 0 0 5px rgba(231, 76, 60, 0.3);
        }
        .add-form button {
            padding: 10px 20px;
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .add-form button:hover {
            background: #c0392b;
            transform: translateY(-2px);
        }
        .center-info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #2196f3;
        }
        @media (max-width: 768px) {
            .nav-tabs {
                flex-direction: column;
                gap: 10px;
            }
            .filters {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
            .summary-card {
                max-width: 100%;
            }
            .container {
                padding: 0 10px;
            }
            .nav-container {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }
            .nav-tabs {
                margin-left: 0;
                margin-bottom: 15px;
            }
            .add-form input, .add-form select {
                width: 100%;
                min-width: unset;
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
     <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>
    <div class="container">
        <div class="nav-container">
            <div class="nav-tabs">
                <a class="active" onclick="showTab('overview')">📊 Overview</a>
                <a onclick="showTab('income')">💰 Income</a>
                <a onclick="showTab('expense')">💸 Expenses</a>
            </div>
            <div class="filters">
                <select id="date-filter" onchange="applyGlobalFilters()">
                    <option value="">All Periods</option>
                    <option value="2025-10" selected>Oct 2025</option>
                </select>
                <select id="center-filter" onchange="applyGlobalFilters()">
                    <option value="">All Centers</option>
                    <option value="Center1">Center 1</option>
                    <option value="Center2">Center 2</option>
                </select>
                <input type="text" id="search" placeholder="🔍 Search..." onkeyup="applyGlobalFilters()">
            </div>
        </div>
        
        <div class="content">
            <div id="overview" class="tab-content active">
                <div class="row">
                    <div class="col-md-6">
                        <div class="summary-card" id="income-summary-card">
                            <h3 id="income-title">Income Summary</h3>
                            <div class="summary-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Paid Amount</span>
                                <span class="value" id="paid-amount">₹0</span>
                            </div>
                            <div class="summary-item">
                                <i class="fas fa-hourglass-half"></i>
                                <span>Pending Amount</span>
                                <span class="value" id="pending-amount">₹0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="summary-card" id="expense-summary-card">
                            <h3 id="expense-title">Expense Summary</h3>
                            <div class="summary-item">
                                <i class="fas fa-minus-circle"></i>
                                <span>Total Expense</span>
                                <span class="value" id="expense-amount">₹0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="income" class="tab-content">
                <h3>Income Management</h3>
                <div class="filter-section">
                    <label>Additional Filter:</label>
                    <select id="filter-type-income" onchange="toggleDateFilter('income')">
                        <option value="">None</option>
                        <option value="datewise">Date Range</option>
                    </select>
                    <div id="date-filter-income" style="display:none; gap:5px; align-items:center;">
                        <input type="date" id="date-from-income"> 
                        <span>to</span> 
                        <input type="date" id="date-to-income">
                    </div>
                    <button onclick="applyFilter('income')" class="btn btn-sm">Apply Filter</button>
                    <button onclick="toggleAddForm('income')" class="btn btn-sm btn-success">+ Add Income</button>
                </div>
                <div id="income-data">
                    <div style="margin-bottom:15px;">
                        <strong>Total Amount: </strong><span id="income-total">₹0</span> | 
                        <strong>Pending: </strong><span id="income-pending">₹0</span>
                    </div>
                    <div class="table-responsive">
                        <table id="income-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Center</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="add-form" id="income-add-form">
                    <h4>Add New Income Entry</h4>
                    <input type="text" id="inc-name" placeholder="Student Name" required>
                    <input type="text" id="inc-plan" placeholder="Training Plan" required>
                    <input type="number" id="inc-amount" placeholder="Amount (₹)" required>
                    <select id="inc-status" required>
                        <option value="received">Received</option>
                        <option value="pending">Pending</option>
                    </select>
                    <select id="inc-center" required>
                        <option value="Center1">Center 1</option>
                        <option value="Center2">Center 2</option>
                    </select>
                    <br>
                    <button onclick="addIncomeEntry()" class="btn btn-primary">Add Income</button>
                    <button onclick="toggleAddForm('income')" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
            
            <div id="expense" class="tab-content">
                <h3>Expense Management</h3>
                <div class="filter-section">
                    <label>Additional Filter:</label>
                    <select id="filter-type-exp" onchange="toggleDateFilter('expense')">
                        <option value="">None</option>
                        <option value="datewise">Date Range</option>
                    </select>
                    <div id="date-filter-exp" style="display:none; gap:5px; align-items:center;">
                        <input type="date" id="date-from-exp"> 
                        <span>to</span> 
                        <input type="date" id="date-to-exp">
                    </div>
                    <button onclick="applyFilter('expense')" class="btn btn-sm">Apply Filter</button>
                    <button onclick="toggleAddForm('expense')" class="btn btn-sm btn-success">+ Add Expense</button>
                </div>
                <div id="expense-data">
                    <div style="margin-bottom:15px;">
                        <strong>Total Expenses: </strong><span id="expense-total">₹0</span>
                    </div>
                    <div class="table-responsive">
                        <table id="expense-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Center</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="add-form" id="expense-add-form">
                    <h4>Add New Expense Entry</h4>
                    <div class="center-info">
                        <strong>Note:</strong> Expense will be deducted from selected center's total income only.
                    </div>
                    <input type="text" id="exp-item" placeholder="Item Name" required>
                    <input type="text" id="exp-desc" placeholder="Description" required>
                    <input type="number" id="exp-amount" placeholder="Amount (₹)" required>
                    <input type="text" id="exp-category" placeholder="Category" required>
                    <select id="exp-center" required>
                        <option value="Center1">Center 1</option>
                        <option value="Center2">Center 2</option>
                    </select>
                    <br>
                    <button onclick="addExpenseEntry()" class="btn btn-primary">Add Expense</button>
                    <button onclick="toggleAddForm('expense')" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Center-wise data tracking
        let centerData = {
            "Center1": { totalIncome: 0, totalExpense: 0, netAmount: 0 },
            "Center2": { totalIncome: 0, totalExpense: 0, netAmount: 0 }
        };

        let incomeData = [
            { name: "Ravi Kumar", plan: "Beginner", received: "Yes", pending: "No", amount: 1000, date: "2025-10-01", center: "Center1" },
            { name: "Priya Sharma", plan: "Intermediate", received: "No", pending: "Yes", amount: 1500, date: "2025-10-03", center: "Center2" },
            { name: "Amit Singh", plan: "Advanced", received: "Yes", pending: "No", amount: 2000, date: "2025-10-05", center: "Center1" }
        ];
        
        let expenseData = [
            { item: "Shuttlecocks", desc: "Pack of 50", amount: 500, category: "Equipment", date: "2025-10-02", center: "Center1" },
            { item: "Court Rent", desc: "Monthly", amount: 1000, category: "Facility", date: "2025-10-04", center: "Center2" }
        ];

        // Initialize center data
        function initializeCenterData() {
            // Reset center data
            Object.keys(centerData).forEach(center => {
                centerData[center] = { totalIncome: 0, totalExpense: 0, netAmount: 0 };
            });
            
            // Calculate income totals
            incomeData.forEach(entry => {
                if (entry.received === "Yes") {
                    centerData[entry.center].totalIncome += entry.amount;
                    centerData[entry.center].netAmount += entry.amount;
                }
            });
            
            // Calculate expense totals
            expenseData.forEach(entry => {
                centerData[entry.center].totalExpense += entry.amount;
                centerData[entry.center].netAmount -= entry.amount;
            });
        }

        function getCenterTotals(centerName) {
            const center = centerData[centerName] || { totalIncome: 0, totalExpense: 0, netAmount: 0 };
            return {
                paid: center.totalIncome,
                expense: center.totalExpense,
                net: center.netAmount,
                pending: getPendingAmountForCenter(centerName)
            };
        }

        function getPendingAmountForCenter(centerName) {
            return incomeData
                .filter(entry => entry.center === centerName && entry.pending === "Yes")
                .reduce((sum, entry) => sum + entry.amount, 0);
        }

        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
            document.querySelectorAll('.nav-tabs a').forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            document.querySelector(`.nav-tabs a[onclick="showTab('${tabId}')"]`).classList.add('active');
            applyGlobalFilters();
        }

        function toggleDateFilter(tab) {
            const filterType = document.getElementById(`filter-type-${tab}`).value;
            document.getElementById(`date-filter-${tab}`).style.display = filterType === 'datewise' ? 'inline-flex' : 'none';
        }

        function applyFilter(tab) {
            applyGlobalFilters();
        }

        function applyGlobalFilters() {
            const activeTab = document.querySelector('.tab-content.active').id;
            if (activeTab === 'overview') {
                updateSummary();
            } else if (activeTab === 'income') {
                updateIncomeDisplay();
            } else if (activeTab === 'expense') {
                updateExpenseDisplay();
            }
        }

        function getFilteredData(data, tab) {
            let filtered = [...data];
            const month = document.getElementById('date-filter').value;
            const center = document.getElementById('center-filter').value;
            const searchTerm = document.getElementById('search').value.toLowerCase();

            if (month) filtered = filtered.filter(entry => entry.date.startsWith(month));
            if (center && center !== "") filtered = filtered.filter(entry => entry.center === center);
            if (searchTerm) {
                filtered = filtered.filter(entry => 
                    Object.values(entry).some(val => val.toString().toLowerCase().includes(searchTerm))
                );
            }

            const filterType = document.getElementById(`filter-type-${tab}`)?.value;
            if (filterType === 'datewise') {
                const fromDate = document.getElementById(`date-from-${tab}`)?.value;
                const toDate = document.getElementById(`date-to-${tab}`)?.value;
                if (fromDate && toDate) {
                    filtered = filtered.filter(entry => {
                        const entryDate = new Date(entry.date);
                        return entryDate >= new Date(fromDate) && entryDate <= new Date(toDate);
                    });
                }
            }
            return filtered;
        }

        function toggleAddForm(tab) {
            const formId = tab + '-add-form';
            const form = document.getElementById(formId);
            form.classList.toggle('show');
        }

        // CENTER-SPECIFIC INCOME ADDITION
        function addIncomeEntry() {
            const name = document.getElementById('inc-name').value.trim();
            const plan = document.getElementById('inc-plan').value.trim();
            const amount = parseFloat(document.getElementById('inc-amount').value);
            const status = document.getElementById('inc-status').value;
            const center = document.getElementById('inc-center').value;
            const date = new Date().toISOString().split('T')[0];

            if (!name || !plan || isNaN(amount) || !center) {
                alert('Please fill all required fields');
                return;
            }

            const newEntry = { 
                name, plan, 
                received: status === 'received' ? 'Yes' : 'No', 
                pending: status === 'pending' ? 'Yes' : 'No', 
                amount, date, center 
            };
            
            incomeData.push(newEntry);
            
            // Update center-specific totals
            if (status === 'received') {
                centerData[center].totalIncome += amount;
                centerData[center].netAmount += amount;
            }
            
            alert(`✅ ${status === 'received' ? 'Income' : 'Pending payment'} ₹${amount.toLocaleString()} added to ${center}`);
            applyGlobalFilters();
            clearAddForm('income');
        }

        // CENTER-SPECIFIC EXPENSE DEDUCTION
        function addExpenseEntry() {
            const item = document.getElementById('exp-item').value.trim();
            const desc = document.getElementById('exp-desc').value.trim();
            const amount = parseFloat(document.getElementById('exp-amount').value);
            const category = document.getElementById('exp-category').value.trim();
            const center = document.getElementById('exp-center').value;
            const date = new Date().toISOString().split('T')[0];

            if (!item || !desc || isNaN(amount) || !category || !center) {
                alert('Please fill all required fields');
                return;
            }

            // Check center funds availability
            const centerTotals = getCenterTotals(center);
            if (amount > centerTotals.paid) {
                alert(`❌ Insufficient funds in ${center}!\nAvailable: ₹${centerTotals.paid.toLocaleString()}\nRequired: ₹${amount.toLocaleString()}`);
                return;
            }

            const newEntry = { item, desc, amount, category, date, center };
            expenseData.push(newEntry);
            
            // Deduct from specific center only
            centerData[center].totalExpense += amount;
            centerData[center].netAmount -= amount;
            
            alert(`✅ Expense ₹${amount.toLocaleString()} deducted from ${center}\nRemaining balance: ₹${centerData[center].netAmount.toLocaleString()}`);
            applyGlobalFilters();
            clearAddForm('expense');
        }

        function clearAddForm(tab) {
            const inputs = document.querySelectorAll(`#${tab}-add-form input, #${tab}-add-form select`);
            inputs.forEach(input => input.value = '');
        }

        function updateIncomeDisplay() {
            const filteredData = getFilteredData(incomeData, 'income');
            const tbody = document.querySelector('#income-table tbody');
            tbody.innerHTML = '';
            
            let totalAmount = 0, pendingAmount = 0;
            
            filteredData.forEach(entry => {
                const row = `
                    <tr>
                        <td>${entry.name}</td>
                        <td>${entry.plan}</td>
                        <td><span class="badge ${entry.received === 'Yes' ? 'bg-success' : 'bg-warning'}">${entry.received}</span></td>
                        <td><strong class="text-success">₹${entry.amount.toLocaleString()}</strong></td>
                        <td>${entry.date}</td>
                        <td><span class="badge ${entry.center === 'Center1' ? 'bg-primary' : 'bg-warning'}">${entry.center}</span></td>
                    </tr>
                `;
                tbody.innerHTML += row;
                totalAmount += entry.amount;
                if (entry.pending === "Yes") pendingAmount += entry.amount;
            });
            
            document.getElementById('income-total').textContent = `₹${totalAmount.toLocaleString()}`;
            document.getElementById('income-pending').textContent = `₹${pendingAmount.toLocaleString()}`;
        }

        function updateExpenseDisplay() {
            const filteredData = getFilteredData(expenseData, 'expense');
            const tbody = document.querySelector('#expense-table tbody');
            tbody.innerHTML = '';
            
            let totalExpense = 0;
            
            filteredData.forEach(entry => {
                const row = `
                    <tr>
                        <td>${entry.item}</td>
                        <td>${entry.desc}</td>
                        <td><strong class="text-danger">₹${entry.amount.toLocaleString()}</strong></td>
                        <td><span class="badge bg-secondary">${entry.category}</span></td>
                        <td>${entry.date}</td>
                        <td><span class="badge ${entry.center === 'Center1' ? 'bg-primary' : 'bg-warning'}">${entry.center}</span></td>
                    </tr>
                `;
                tbody.innerHTML += row;
                totalExpense += entry.amount;
            });
            
            document.getElementById('expense-total').textContent = `₹${totalExpense.toLocaleString()}`;
        }

        function updateSummary() {
            const selectedCenter = document.getElementById('center-filter').value;
            let paidAmount, pendingAmount, expenseAmount;
            let centerTitle = '';
            
            if (selectedCenter && selectedCenter !== "") {
                // Center-specific totals
                const totals = getCenterTotals(selectedCenter);
                paidAmount = totals.paid;
                pendingAmount = totals.pending;
                expenseAmount = totals.expense;
                centerTitle = ` - ${selectedCenter}`;
            } else {
                // Overall totals
                paidAmount = incomeData.filter(entry => entry.received === "Yes").reduce((sum, entry) => sum + entry.amount, 0);
                pendingAmount = incomeData.filter(entry => entry.pending === "Yes").reduce((sum, entry) => sum + entry.amount, 0);
                expenseAmount = expenseData.reduce((sum, entry) => sum + entry.amount, 0);
            }

            document.getElementById('paid-amount').innerHTML = `<strong>₹${paidAmount.toLocaleString()}</strong>`;
            document.getElementById('pending-amount').innerHTML = `<strong>₹${pendingAmount.toLocaleString()}</strong>`;
            document.getElementById('expense-amount').innerHTML = `<strong>₹${expenseAmount.toLocaleString()}</strong>`;
            
            // Update titles
            document.getElementById('income-title').textContent = `Income Summary${centerTitle}`;
            document.getElementById('expense-title').textContent = `Expense Summary${centerTitle}`;
        }

        // Initialize and start
        initializeCenterData();
        showTab('overview');
        updateSummary();
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>