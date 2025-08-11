<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>Leave Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', serif !important;
            background-color: #f4f6f8 !important;
            color: #333;
            min-height: 100vh;
            margin: 0;
            padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
            overflow-x: hidden;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 2vw;
            transition: all 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .content-wrapper.minimized {
            margin-left: 60px;
            width: calc(100% - 60px);
        }

        .container {
            max-width: calc(1200px + 2vw);
            margin: 4rem auto 0;
            width: 100%;
            padding: 0 1rem;
        }

        .tab-buttons {
            display: flex;
            justify-content: center;
            gap: 1vw;
            background: transparent;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .tab-buttons button {
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            text-align: center;
        }

        .tab-buttons button.active {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
            border-color: #ff4040;
        }

        .tab-buttons button:hover {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
            transform: translateY(-2px);
        }

        .table-container {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            text-align: center;
            font-weight: 600;
            font-size: clamp(0.75rem, 2vw, 0.9rem);
            padding: 1rem;
        }

        .table td, .table th {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
            color: #000;
        }

        .table tbody tr {
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .action-btn {
            background: none;
            border: none;
            font-size: 1rem;
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn.thumbs-up {
            background-color: #28a745;
            color: white;
        }

        .action-btn.cross {
            background-color: #dc3545;
            color: white;
        }

        .action-btn:hover {
            filter: brightness(90%);
        }

        .action-btn:disabled {
            background-color: #ccc !important;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1.5rem;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            touch-action: manipulation;
        }

        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: #fff;
            margin: 10% auto;
            padding: 15px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.3s ease-in-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            text-align: center;
            padding: 15px;
            border-bottom: none;
            position: relative;
        }

        .modal-title {
            font-size: clamp(1.2rem, 4vw, 1.5rem);
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .close {
            position: absolute;
            right: 15px;
            top: 15px;
            color: #666;
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #dc3545;
        }

        .modal-body {
            padding: 15px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -5px;
            margin-left: -5px;
            align-items: center;
        }

        .form-group {
            padding-right: 5px;
            padding-left: 5px;
            margin-bottom: 0.8rem;
            flex: 0 0 50%;
            max-width: 50%;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 600;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            color: #333;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
            background: #fff;
            color: #333;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus, .form-group textarea:focus, .form-group select:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 60px;
        }

        .error {
            color: #dc3545;
            font-size: clamp(0.7rem, 1.8vw, 0.8rem);
            margin-top: 4px;
            display: none;
            font-weight: 500;
        }

        .form-group.invalid input, .form-group.invalid textarea, .form-group.invalid select {
            border-color: #dc3545;
            box-shadow: 0 0 6px rgba(220, 53, 69, 0.2);
        }

        .form-group.invalid .error {
            display: block;
        }

        .save-btn {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 20px;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 15px auto 0;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .save-btn:hover {
            transform: translateY(-2px);
        }

        .save-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        @media (max-width: 576px) {
            body {
                padding: 0.5rem;
            }

            .content-wrapper {
                margin-left: 0 !important;
                padding: 0.5rem !important;
                width: 100%;
            }

            .container {
                margin-top: 3rem;
                padding: 0 0.5rem;
            }

            .table-container {
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 800px;
                font-size: clamp(0.65rem, 2vw, 0.7rem);
            }

            .table td, .table th {
                padding: 0.5rem;
            }

            .action-btn {
                font-size: clamp(0.65rem, 2vw, 0.7rem);
                padding: 0.2rem 0.4rem;
            }

            .modal-content {
                width: 95%;
                max-width: 360px;
                margin: 15% auto;
                padding: 10px;
            }

            .modal-header {
                padding: 10px;
            }

            .modal-title {
                font-size: clamp(1rem, 3.5vw, 1.2rem);
            }

            .close {
                font-size: clamp(1rem, 3vw, 1.2rem);
                right: 10px;
                top: 10px;
            }

            .modal-body {
                padding: 10px;
            }

            .form-row {
                flex-direction: column;
            }

            .form-group {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 0.6rem;
            }

            .add-btn-container {
                justify-content: center;
            }

            .btn-custom {
                font-size: clamp(0.7rem, 2vw, 0.75rem);
                padding: 0.3rem 0.6rem;
            }

            .tab-buttons {
                flex-direction: column;
                gap: 8px;
                align-items: center;
            }

            .tab-buttons button {
                font-size: clamp(0.7rem, 2vw, 0.75rem);
                padding: 8px 15px;
                width: 100%;
                max-width: 180px;
            }
        }

        @media (min-width: 577px) and (max-width: 767px) {
            .content-wrapper {
                margin-left: 200px;
                padding: 1rem;
                width: calc(100% - 200px);
            }

            .content-wrapper.minimized {
                margin-left: 60px;
                width: calc(100% - 60px);
            }

            .container {
                margin-top: 3.5rem;
                padding: 0 0.75rem;
            }

            .table {
                font-size: clamp(0.75rem, 2vw, 0.8rem);
            }

            .modal-content {
                width: 90%;
                max-width: 450px;
                margin: 12% auto;
            }

            .modal-body {
                padding: 12px;
            }

            .form-row {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .form-group {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .tab-buttons button {
                font-size: clamp(0.75rem, 2vw, 0.8rem);
                padding: 8px 15px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .content-wrapper {
                margin-left: 200px;
                padding: 1.5rem;
                width: calc(100% - 200px);
            }

            .content-wrapper.minimized {
                margin-left: 60px;
                width: calc(100% - 60px);
            }

            .container {
                margin-top: 4rem;
                padding: 0 1rem;
            }

            .table {
                font-size: clamp(0.8rem, 2vw, 0.85rem);
            }

            .modal-content {
                width: 90%;
                max-width: 500px;
                margin: 10% auto;
            }

            .modal-body {
                padding: 12px;
            }

            .form-row {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .form-group {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .tab-buttons button {
                font-size: clamp(0.8rem, 2vw, 0.85rem);
                padding: 10px 20px;
            }
        }

        @media (min-width: 992px) {
            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
            }

            .modal-content {
                max-width: 600px;
            }

            .tab-buttons button {
                font-size: clamp(0.85rem, 2vw, 0.875rem);
            }
        }

        @media (hover: none) {
            .action-btn:hover, .btn-custom:hover, .save-btn:hover, .tab-buttons button:hover {
                background-color: inherit;
                transform: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <?php $this->load->view('superadmin/Include/Navbar') ?>
    <div class="content-wrapper" id="contentWrapper">
        <div class="container">
            <div class="tab-buttons">
                <button class="active" onclick="switchTab('Center 1')">Center 1</button>
                <button onclick="switchTab('Center 2')">Center 2</button>
                <button onclick="switchTab('Center 3')">Center 3</button>
                <button onclick="switchTab('Center 4')">Center 4</button>
            </div>
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
                    </tbody>
                </table>
            </div>
            <div class="add-btn-container">
                <button class="btn btn-custom" onclick="openModal()">
                    <i class="fas fa-plus me-1"></i> Add Leave
                </button>
            </div>
        </div>
    </div>
    <div id="leaveModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2 class="modal-title">Add Leave</h2>
            </div>
            <div class="modal-body">
                <form id="leaveForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required placeholder="Enter full name">
                            <div class="error">Please enter a valid name (letters only, min 2 characters)</div>
                        </div>
                        <div class="form-group">
                            <label for="batch">Batch</label>
                            <select id="batch" name="batch" class="form-control" required>
                                <option value="">Select Batch</option>
                            </select>
                            <div class="error">Please select a valid batch</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select id="level" name="level" class="form-control" required>
                                <option value="">Select Level</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <div class="error">Please select a level</div>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                            <div class="error">Please select a future date</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <input type="text" id="reason" name="reason" class="form-control" required placeholder="Enter reason for leave">
                            <div class="error">Please enter a reason (min 5 characters)</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" required placeholder="Enter detailed description"></textarea>
                            <div class="error">Please enter a description (10-500 characters)</div>
                        </div>
                    </div>
                    <button type="submit" class="save-btn">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';
        const modal = document.getElementById('leaveModal');
        const form = document.getElementById('leaveForm');
        let editingRow = null;

        function openModal() {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            resetForm();
            loadBatches();
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

        function validateForm() {
            const name = document.getElementById('name');
            const batch = document.getElementById('batch');
            const level = document.getElementById('level');
            const date = document.getElementById('date');
            const reason = document.getElementById('reason');
            const description = document.getElementById('description');

            let isValid = true;
            clearValidationErrors();

            if (!name.value.trim() || !/^[a-zA-Z\s]{2,}$/.test(name.value.trim())) {
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

            const today = new Date();
            const selectedDate = new Date(date.value);
            if (!date.value || selectedDate <= today) {
                date.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!reason.value.trim() || reason.value.trim().length < 5) {
                reason.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            if (!description.value.trim() || description.value.trim().length < 10 || description.value.trim().length > 500) {
                description.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const saveBtn = form.querySelector('.save-btn');
            saveBtn.disabled = true;

            if (validateForm()) {
                const formData = new FormData(form);
                const activeCenter = document.querySelector('.tab-buttons button.active').textContent;
                const data = {
                    name: formData.get('name'),
                    batch: formData.get('batch'),
                    level: formData.get('level'),
                    date: formData.get('date'),
                    reason: formData.get('reason'),
                    description: formData.get('description'),
                    center: activeCenter,
                    status: 'Pending',
                    [csrfName]: csrfHash
                };

                $.ajax({
                    url: '<?php echo base_url('leave/add_leave'); ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            fetchLeaves(activeCenter);
                            closeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Leave request added successfully!',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to add leave.',
                                showConfirmButton: true
                            });
                        }
                        saveBtn.disabled = false;
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again.',
                            showConfirmButton: true
                        });
                        saveBtn.disabled = false;
                    }
                });
            } else {
                saveBtn.disabled = false;
            }
        });

        function loadBatches() {
            $.ajax({
                url: '<?php echo base_url('leave/get_batches'); ?>',
                type: 'POST',
                data: { [csrfName]: csrfHash },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const batchSelect = document.getElementById('batch');
                        batchSelect.innerHTML = '<option value="">Select Batch</option>';
                        response.data.forEach(batch => {
                            const option = document.createElement('option');
                            option.value = batch.batch;
                            option.textContent = batch.batch;
                            batchSelect.appendChild(option);
                        });
                    } else {
                        console.error('Error loading batches:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }

        function addNewRow(data) {
            const tableBody = document.getElementById('leaveTableBody');
            const row = document.createElement('tr');
            const isApproved = data.status === 'Approved';
            const isRejected = data.status === 'Rejected';
            const approveDisabled = isApproved || isRejected ? 'disabled' : '';
            const rejectDisabled = isApproved || isRejected ? 'disabled' : '';
            const rowBackground = isApproved ? 'background-color: #d4edda;' : isRejected ? 'background-color: #f8d7da;' : '';

            row.setAttribute('data-id', data.id);
            row.style.cssText = rowBackground;
            row.innerHTML = `
                <td>${data.name}</td>
                <td>${data.batch}</td>
                <td>${data.level}</td>
                <td>${new Date(data.date).toLocaleDateString('en-GB')}</td>
                <td>${data.reason}</td>
                <td>${data.description}</td>
                <td>
                    <button class="action-btn thumbs-up" onclick="approveLeave(this, ${data.id})" ${approveDisabled}><i class="fas fa-check"></i></button>
                    <button class="action-btn cross" onclick="rejectLeave(this, ${data.id})" ${rejectDisabled}><i class="fas fa-times"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        }

        function approveLeave(button, leaveId) {
            const row = button.closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to approve the leave for ${row.cells[0].textContent}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url('leave/update_status'); ?>',
                        type: 'POST',
                        data: { id: leaveId, status: 'Approved', [csrfName]: csrfHash },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                row.style.backgroundColor = '#d4edda';
                                button.disabled = true;
                                row.querySelector('.action-btn.cross').disabled = true;
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Approved',
                                    text: `Leave for ${row.cells[0].textContent} approved at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to approve leave.',
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        }

        function rejectLeave(button, leaveId) {
            const row = button.closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to reject the leave for ${row.cells[0].textContent}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo base_url('leave/update_status'); ?>',
                        type: 'POST',
                        data: { id: leaveId, status: 'Rejected', [csrfName]: csrfHash },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                row.style.backgroundColor = '#f8d7da';
                                button.disabled = true;
                                row.querySelector('.action-btn.thumbs-up').disabled = true;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Rejected',
                                    text: `Leave for ${row.cells[0].textContent} rejected at ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to reject leave.',
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                                showConfirmButton: true
                            });
                        }
                    });
                }
            });
        }

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

            switchTab('Center 1');
        });

        function fetchLeaves(center) {
            $.ajax({
                url: '<?php echo base_url('leave/get_leaves'); ?>',
                type: 'POST',
                data: { center: center, [csrfName]: csrfHash },
                dataType: 'json',
                success: function(response) {
                    const tableBody = document.getElementById('leaveTableBody');
                    tableBody.innerHTML = '';
                    if (response.status === 'success') {
                        const data = response.data || [];
                        if (data.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No records available for this center.</td></tr>';
                        } else {
                            data.forEach(item => addNewRow(item));
                        }
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Error loading data.</td></tr>';
                        console.error('Error fetching leaves:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    const tableBody = document.getElementById('leaveTableBody');
                    tableBody.innerHTML = '<tr><td colspan="7" class="text-center">An error occurred. Please try again.</td></tr>';
                    console.error('AJAX error:', error);
                }
            });
        }

        function switchTab(center) {
            const buttons = document.querySelectorAll('.tab-buttons button');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                if (btn.textContent === center) {
                    btn.classList.add('active');
                }
            });
            fetchLeaves(center);
        }
    </script>
</body>
</html>
