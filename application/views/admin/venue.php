<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Locker Fees</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #e9ecef !important;
            color: #333;
            min-height: 100vh;
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
        }
        .filter-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }
        .filter-btn {
            color: black;
            border: none;
            border-radius: 5px;
            padding: 8px 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .table-container {
            background: #fff;
            border-radius: 10px;
            /* overflow: hidden; */
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            color: black;
            padding: 15px;
            text-align: center;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        .action-cell {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .action-btn {
            background: none;
            border: none;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            color: #6c757d;
        }
        .action-btn:hover {
            transform: scale(1.3);
            color: #007bff;
        }
        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 25px;
        }
        .add-btn {
            /* background: linear-gradient(135deg, #ff4040, #c62828); */
            color: black;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
        }
        .modal-content {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            max-width: 600px;
            width: 90%;
            margin: 5% auto;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            position: relative;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            text-align: center;
        }
        .modal-header h2 {
            font-weight: 700;
            font-size: 1.8rem;
            color: #343a40;
        }
        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
        }
        .close:hover {
            color: #dc3545;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 600;
            font-size: 1rem;
            color: #343a40;
            margin-bottom: 0.5rem;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            /* border-color: #007bff; */
            /* box-shadow: 0 0 8px rgba(0,123,255,0.2); */
        }
        .save-btn {
            /* background: linear-gradient(135deg, #d32f2f, #b71c1c); */
            color: black;
            border: none;
            border-radius: 25px;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            display: block;
            margin: 20px auto;
            /* box-shadow: 0 4px 15px rgba(211,47,47,0.3); */
            transition: all 0.3s ease;
        }
        .save-btn:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 6px 20px rgba(211,47,47,0.4); */
        }
        .error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }
        .form-group.invalid .form-control {
            border-color: #dc3545;
            /* box-shadow: 0 0 8px rgba(220,53,69,0.2); */
        }
        .form-group.invalid .error {
            display: block;
        }
        .invoice-btn {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .invoice-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40,167,69,0.4);
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
                min-width: 900px;
            }
            .modal-content {
                width: 95%;
                margin: 10% auto;
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
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
            </div>
            <!-- Main Table -->
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Venue</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Racket Fee</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <tr>
                            <td>Main Hall</td>
                            <td>Locker Fee</td>
                            <td>15/07/2025</td>
                            <td>Rs.50.00</td>
                            <td>Racket rental for match</td>
                            <td>
                                <div class="action-cell">
                                    <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn invoice-btn" onclick="generateInvoice(this)">Generate Invoice</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Outdoor Court</td>
                            <td>Locker Fee</td>
                            <td>15/07/2025</td>
                            <td>Rs.50.00</td>
                            <td>Racket rental for practice</td>
                            <td>
                                <div class="action-cell">
                                    <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn invoice-btn" onclick="generateInvoice(this)">Generate Invoice</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Add Button -->
            <div class="add-btn-container">
                <button class="add-btn" onclick="openModal()">Add Venue Locker Fee</button>
            </div>
        </div>
    </div>
    <!-- Add/Edit Modal -->
    <div id="expenseModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 class="modal-title">Add Venue Locker Fee</h2>
            </div>
            <div class="modal-body">
                <form id="expenseForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="venue">Venue <span class="text-danger">*</span>:</label>
                            <select id="venue" name="venue" class="form-control" required>
                                <option value="">Select Venue</option>
                                <option value="Main Hall">Main Hall</option>
                                <option value="Outdoor Court">Outdoor Court</option>
                                <option value="Indoor Arena">Indoor Arena</option>
                            </select>
                            <div class="error">Please select a venue</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span>:</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                            <div class="error">Please enter a valid title</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="date">Date <span class="text-danger">*</span>:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                            <div class="error">Please select a valid date</div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amount">Racket Fee <span class="text-danger">*</span>:</label>
                            <input type="number" id="amount" name="amount" step="0.01" class="form-control" required min="0.01" value="50.00">
                            <div class="error">Racket fee must be greater than 0</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span>:</label>
                        <textarea id="description" name="description" class="form-control" required></textarea>
                        <div class="error">Please enter a description</div>
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
                <span class="close" onclick="closeFilterModal()">&times;</span>
                <h2>Filter Locker Fees</h2>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="filterVenue">Venue:</label>
                            <select id="filterVenue" name="filterVenue" class="form-control">
                                <option value="">All Venues</option>
                                <option value="Main Hall">Main Hall</option>
                                <option value="Outdoor Court">Outdoor Court</option>
                                <option value="Indoor Arena">Indoor Arena</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="filterTitle">Title:</label>
                            <input type="text" id="filterTitle" name="filterTitle" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="filterDate">Date:</label>
                            <input type="date" id="filterDate" name="filterDate" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="filterMinAmount">Min Racket Fee:</label>
                            <input type="number" id="filterMinAmount" name="filterMinAmount" step="0.01" class="form-control" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="filterMaxAmount">Max Racket Fee:</label>
                            <input type="number" id="filterMaxAmount" name="filterMaxAmount" step="0.01" class="form-control" min="0">
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Apply Filter</button>
                    <button type="button" class="save-btn" onclick="resetFilter()">Reset</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const expenseModal = document.getElementById('expenseModal');
        const filterModal = document.getElementById('filterModal');
        const expenseForm = document.getElementById('expenseForm');
        const filterForm = document.getElementById('filterForm');
        let editingRow = null;
        let originalRows = [];

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
        }

        function closeFilterModal() {
            filterModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function resetForm() {
            expenseForm.reset();
            clearValidationErrors(expenseForm);
            document.querySelector('.modal-title').textContent = 'Add Venue Locker Fee';
            document.getElementById('date').value = new Date().toISOString().split('T')[0];
            document.getElementById('amount').value = '50.00';
            document.getElementById('venue').value = '';
        }

        function clearValidationErrors(form) {
            form.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('invalid');
            });
        }

        function validateForm(form) {
            let isValid = true;
            clearValidationErrors(form);

            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim() || (input.type === 'number' && input.value <= 0)) {
                    input.closest('.form-group').classList.add('invalid');
                    isValid = false;
                }
            });

            return isValid;
        }

        expenseForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateForm(this)) {
                const formData = new FormData(this);
                const data = {
                    venue: formData.get('venue'),
                    title: formData.get('title'),
                    date: formatDate(formData.get('date')),
                    amount: `Rs.${parseFloat(formData.get('amount')).toFixed(2)}`,
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

        filterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const filters = {
                venue: formData.get('filterVenue').toLowerCase(),
                title: formData.get('filterTitle').toLowerCase(),
                date: formData.get('filterDate'),
                minAmount: parseFloat(formData.get('filterMinAmount')) || 0,
                maxAmount: parseFloat(formData.get('filterMaxAmount')) || Infinity
            };
            applyFilter(filters);
            closeFilterModal();
        });

        function resetFilter() {
            filterForm.reset();
            const tableBody = document.getElementById('expenseTableBody');
            tableBody.innerHTML = '';
            originalRows.forEach(row => tableBody.appendChild(row.cloneNode(true)));
        }

        function applyFilter(filters) {
            const tableBody = document.getElementById('expenseTableBody');
            if (originalRows.length === 0) {
                originalRows = Array.from(tableBody.querySelectorAll('tr'));
            }
            tableBody.innerHTML = '';
            originalRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const venue = cells[0].textContent.toLowerCase();
                const title = cells[1].textContent.toLowerCase();
                const date = cells[2].textContent;
                const amount = parseFloat(cells[3].textContent.replace('Rs.', ''));

                if (
                    (!filters.venue || venue.includes(filters.venue)) &&
                    (!filters.title || title.includes(filters.title)) &&
                    (!filters.date || date === formatDate(filters.date)) &&
                    (amount >= filters.minAmount && amount <= filters.maxAmount)
                ) {
                    tableBody.appendChild(row.cloneNode(true));
                }
            });
        }

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function addNewRow(data) {
            const tableBody = document.getElementById('expenseTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${data.venue}</td>
                <td>${data.title}</td>
                <td>${data.date}</td>
                <td>${data.amount}</td>
                <td>${data.description}</td>
                <td>
                    <div class="action-cell">
                        <button class="action-btn view-btn" onclick="viewExpense(this)"><i class="fas fa-eye"></i></button>
                        <button class="action-btn edit-btn" onclick="editExpense(this)"><i class="fas fa-edit"></i></button>
                        <button class="action-btn invoice-btn" onclick="generateInvoice(this)">Generate Invoice</button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
            originalRows.push(row);
        }

        function updateRow(row, data) {
            const cells = row.querySelectorAll('td');
            cells[0].textContent = data.venue;
            cells[1].textContent = data.title;
            cells[2].textContent = data.date;
            cells[3].textContent = data.amount;
            cells[4].textContent = data.description;
            originalRows = Array.from(document.getElementById('expenseTableBody').querySelectorAll('tr'));
        }

        function viewExpense(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            alert(`Venue: ${cells[0].textContent}\nTitle: ${cells[1].textContent}\nDate: ${cells[2].textContent}\nRacket Fee: ${cells[3].textContent}\nDescription: ${cells[4].textContent}`);
        }

        function editExpense(button) {
            editingRow = button.closest('tr');
            const cells = editingRow.querySelectorAll('td');
            const dateStr = cells[2].textContent;
            const [day, month, year] = dateStr.split('/');
            const formattedDate = `${year}-${month}-${day}`;
            document.getElementById('venue').value = cells[0].textContent;
            document.getElementById('title').value = cells[1].textContent;
            document.getElementById('date').value = formattedDate;
            document.getElementById('amount').value = cells[3].textContent.replace('Rs.', '');
            document.getElementById('description').value = cells[4].textContent;
            document.querySelector('.modal-title').textContent = 'Edit Venue Locker Fee';
            openModal();
        }

        function generateInvoice(button) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            const invoiceData = {
                venue: cells[0].textContent,
                title: cells[1].textContent,
                date: cells[2].textContent,
                amount: cells[3].textContent,
                description: cells[4].textContent
            };

            const invoiceWindow = window.open('', '_blank');
            invoiceWindow.document.write(`
                <html>
                <head>
                    <title>Invoice</title>
                    <style>
                        body { font-family: 'Montserrat', sans-serif; padding: 20px; }
                        .invoice-container { max-width: 800px; margin: auto; border: 1px solid #ccc; padding: 20px; }
                        .invoice-header { text-align: center; margin-bottom: 20px; }
                        .invoice-details { margin-bottom: 20px; }
                        .invoice-details p { margin: 5px 0; }
                        .print-btn { 
                            background: linear-gradient(135deg, #28a745, #218838);
                            color: white;
                            border: none;
                            padding: 10px 20px;
                            border-radius: 5px;
                            cursor: pointer;
                        }
                        @media print {
                            .print-btn { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <h2>Venue Locker Fee Invoice</h2>
                            <p>Generated on: ${new Date().toLocaleDateString()}</p>
                        </div>
                        <div class="invoice-details">
                            <p><strong>Venue:</strong> ${invoiceData.venue}</p>
                            <p><strong>Title:</strong> ${invoiceData.title}</p>
                            <p><strong>Date:</strong> ${invoiceData.date}</p>
                            <p><strong>Racket Fee:</strong> ${invoiceData.amount}</p>
                            <p><strong>Description:</strong> ${invoiceData.description}</p>
                        </div>
                        <button class="print-btn" onclick="window.print()">Print Invoice</button>
                    </div>
                </body>
                </html>
            `);
            invoiceWindow.document.close();
        }

        ['venue', 'title', 'date', 'amount', 'description'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                if (this.type === 'number') {
                    if (this.value && this.value > 0) {
                        this.closest('.form-group').classList.remove('invalid');
                    } else {
                        this.closest('.form-group').classList.add('invalid');
                    }
                } else {
                    if (this.value.trim()) {
                        this.closest('.form-group').classList.remove('invalid');
                    } else {
                        this.closest('.form-group').classList.add('invalid');
                    }
                }
            });
        });

        document.getElementById('date').value = new Date().toISOString().split('T')[0];
        document.getElementById('amount').value = '50.00';

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