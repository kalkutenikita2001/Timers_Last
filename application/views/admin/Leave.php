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
            transition: all 0.3s ease-in-out;
            position: relative;
            min-height: 100vh;
            padding: 1rem;
        }
        .content-wrapper.minimized {
            margin-left: 4rem;
        }
        .container {
            max-width: 100%;
            width: 100%;
            margin: 1rem auto 0;
            padding: 0 1rem;
        }
        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: clamp(0.7rem, 2vw, 1rem);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
        }
        .btn-custom:hover {
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }
        .table-container {
            margin-top: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            overflow-x: auto;
        }
        .table {
            width: 100%;
            min-width: 600px;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            text-align: center;
            font-weight: 600;
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
            padding: 0.75rem;
        }
        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            font-size: clamp(0.6rem, 1.2vw, 0.85rem);
            color: #000;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }
        .table .horizontal-line td {
            border: none;
            background-color: #dee2e6;
            height: 1px;
            padding: 0;
        }
        .action-btn {
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            margin: 0 0.2rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .action-btn.view {
            background-color: #28a745;
            color: white;
        }
        .action-btn.edit {
            background-color: #007bff;
            color: white;
        }
        .action-btn.delete {
            background-color: #dc3545;
            color: white;
        }
        .action-btn:hover {
            filter: brightness(90%);
        }
        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            width: 90%;
            max-width: 500px;
            margin: 0 auto;
        }
        .modal-header {
            border-bottom: none;
            padding-bottom: 0;
            position: relative;
        }
        .modal-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: #343a40;
            width: 100%;
        }
        .close {
            position: absolute;
            right: 0.5rem;
            top: 0.5rem;
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: #343a40;
            opacity: 0.7;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .close:hover {
            opacity: 1;
            background: #e0e0e0;
        }
        .form-group {
            margin-bottom: 1rem !important;
        }
        .form-group label {
            font-weight: 600;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            margin-bottom: 0.3rem;
            color: #495057;
        }
        .form-control, .form-control select {
            height: calc(1.5rem + 2px);
            border-radius: 0.3rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            padding: 0.25rem 0.5rem;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
            border: 1px solid #ced4da;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus, .form-control select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
        }
        .form-group select.form-control {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%23333" d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 3rem;
        }
        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: clamp(0.6rem, 1.2vw, 0.75rem);
            color: #dc3545;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            background: #ffeaea;
        }
        .was-validated .form-control:valid, .form-control.is-valid {
            border-color: #28a745;
        }
        .modal-footer {
            justify-content: center;
            gap: 10px;
            padding: 1rem 0;
            border-top: none;
        }
        .btn-confirm {
            background: #28a745;
            color: white;
            border-radius: 0.25rem;
            padding: 0.4rem 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            transition: all 0.3s ease;
        }
        .btn-confirm:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
            border-radius: 0.25rem;
            padding: 0.4rem 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #c82333;
            transform: translateY(-1px);
        }
        @media (max-width: 320px) {
            .content-wrapper { margin-left: 0 !important; padding: 0.5rem; }
            .container { margin-top: 0.5rem; padding: 0 0.5rem; }
            .table { font-size: 0.6rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .action-btn { font-size: 0.6rem; padding: 0.15rem 0.3rem; margin: 0 0.1rem; }
            .modal-content { padding: 0.5rem; width: 95%; }
            .form-row { flex-direction: column; gap: 0.3rem; }
            .form-group { margin-bottom: 0.4rem !important; }
            .add-btn-container { justify-content: center; flex-direction: column; gap: 0.3rem; }
            .btn-custom { font-size: 0.65rem; padding: 0.25rem 0.5rem; }
            .modal-title { font-size: 0.9rem; }
            .form-group label { font-size: 0.65rem; }
            .form-control, .form-control select { height: calc(1.4rem + 2px); font-size: 0.65rem; padding: 0.2rem 0.3rem; }
        }
        @media (min-width: 321px) and (max-width: 576px) {
            .content-wrapper { margin-left: 0 !important; padding: 0.75rem; }
            .container { margin-top: 0.75rem; padding: 0 0.75rem; }
            .table { font-size: 0.7rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .action-btn { font-size: 0.7rem; padding: 0.2rem 0.4rem; margin: 0 0.15rem; }
            .modal-content { padding: 0.75rem; width: 90%; }
            .form-row { flex-direction: column; gap: 0.5rem; }
            .form-group { margin-bottom: 0.5rem !important; }
            .add-btn-container { justify-content: center; flex-direction: column; gap: 0.5rem; }
            .btn-custom { font-size: 0.75rem; padding: 0.3rem 0.6rem; }
            .modal-title { font-size: 1rem; }
            .form-group label { font-size: 0.7rem; }
            .form-control, .form-control select { height: calc(1.5rem + 2px); font-size: 0.7rem; padding: 0.2rem 0.4rem; }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .content-wrapper { margin-left: 0 !important; padding: 1rem; }
            .table { font-size: 0.8rem; }
            .table th:nth-child(5), .table td:nth-child(5) { display: none; }
            .modal-content { padding: 1rem; width: 85%; }
            .form-row { flex-direction: row; gap: 0.75rem; }
            .add-btn-container { justify-content: flex-end; gap: 0.75rem; }
            .btn-custom { font-size: 0.8rem; }
            .form-group label { font-size: 0.75rem; }
            .form-control, .form-control select { height: calc(1.6rem + 2px); font-size: 0.75rem; padding: 0.25rem 0.5rem; }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper { margin-left: 12rem; }
            .modal-content { max-width: 450px; }
            .table { font-size: 0.85rem; }
            .form-group label { font-size: 0.8rem; }
            .form-control, .form-control select { height: calc(1.7rem + 2px); font-size: 0.8rem; }
        }
        @media (min-width: 992px) and (max-width: 1200px) {
            .content-wrapper { margin-left: 14rem; }
            .modal-content { max-width: 480px; }
            .table { font-size: 0.9rem; }
            .form-group label { font-size: 0.85rem; }
            .form-control, .form-control select { height: calc(1.8rem + 2px); font-size: 0.85rem; }
        }
        @media (min-width: 1201px) and (max-width: 1599px) {
            .content-wrapper { margin-left: 15rem; }
            .modal-content { max-width: 500px; }
            .table { font-size: 0.95rem; }
            .form-group label { font-size: 0.9rem; }
            .form-control, .form-control select { height: calc(1.9rem + 2px); font-size: 0.9rem; }
        }
        @media (min-width: 1600px) {
            .content-wrapper { margin-left: 16rem; }
            .modal-content { max-width: 520px; }
            .table { font-size: 1rem; }
            .btn-custom { font-size: 1rem; padding: 0.5rem 1rem; }
            .form-group label { font-size: 0.95rem; }
            .form-control, .form-control select { height: calc(2rem + 2px); font-size: 0.95rem; }
        }
        @media (hover: none) {
            .action-btn:hover, .btn-custom:hover, .close:hover { transform: none; background-color: inherit; box-shadow: none; }
        }
        .view-modal-content {
            padding: 1rem;
            font-size: clamp(0.7rem, 1.5vw, 0.9rem);
        }
        .view-modal-content p {
            margin-bottom: 0.5rem;
        }
        .form-control {
            padding: 0.375rem 0.75rem !important;
        }
        .form-control[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
        .modal-note {
            font-size: clamp(0.7rem, 1.5vw, 0.85rem);
            color: #6c757d;
            text-align: center;
            margin-bottom: 1rem;
        }
        .form-row {
            align-items: flex-start !important;
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
            <div class="add-btn-container">
                <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                     <i class="bi bi-funnel me-2"></i> Filter
                </button>
                <button class="btn btn-custom" data-toggle="modal" data-target="#leaveModal">
                    <i class="fas fa-plus mr-1"></i> Add Leave
                </button>
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
                        <?php if (!empty($leaves)): ?>
                            <?php foreach ($leaves as $leave): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($leave->name); ?></td>
                                    <td><?php echo htmlspecialchars($leave->batch); ?></td>
                                    <td><?php echo htmlspecialchars($leave->level); ?></td>
                                    <td><?php echo htmlspecialchars($leave->date); ?></td>
                                    <td><?php echo htmlspecialchars($leave->reason); ?></td>
                                    <td><?php echo htmlspecialchars($leave->description); ?></td>
                                    <td>
                                        <button class="action-btn view" data-id="<?php echo $leave->id; ?>" onclick="viewLeave(this)" title="View Leave Details"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit" data-id="<?php echo $leave->id; ?>" onclick="editLeave(this)" title="Edit Leave"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete" data-id="<?php echo $leave->id; ?>" onclick="deleteLeave(this)" title="Delete Leave"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="horizontal-line"><td colspan="7"></td></tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No records found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add/Edit Leave Modal -->
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="leaveLabel">Add Leave</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="leaveForm" novalidate>
                    <input type="hidden" id="leaveId" name="leaveId">
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50" placeholder="Enter full name">
                            <div class="invalid-feedback">Name is required, letters and spaces only, max 50 characters.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="batch">Batch <span class="text-danger">*</span></label>
                            <select id="batch" name="batch" class="form-control" required>
                                <option value="">-- Select Batch --</option>
                                <!-- Batches will be populated dynamically -->
                            </select>
                            <div class="invalid-feedback">Batch is required.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="level">Level <span class="text-danger">*</span></label>
                            <select id="level" name="level" class="form-control" required>
                                <option value="">-- Select Level --</option>
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <div class="invalid-feedback">Level is required.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="date">Date <span class="text-danger">*</span></label>
                            <input type="date" id="date" name="date" class="form-control" required>
                            <div class="invalid-feedback">Date is required.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason <span class="text-danger">*</span></label>
                        <input type="text" id="reason" name="reason" class="form-control" required maxlength="100" placeholder="Enter reason for leave">
                        <div class="invalid-feedback">Reason is required, max 100 characters.</div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" required maxlength="200" rows="2" placeholder="Enter detailed description (max 200 characters)"></textarea>
                        <div class="invalid-feedback">Description is required, max 200 characters.</div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-confirm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Filter Modal -->
    <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="filterLabel">Filter Leaves</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="modal-note">Fill at least one field to apply a filter.</div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterName">Name</label>
                            <input type="text" id="filterName" name="filterName" class="form-control" pattern="[A-Za-z\s]+" maxlength="50" placeholder="Enter name to filter">
                            <div class="invalid-feedback">Name must contain only letters and spaces, max 50 characters.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterBatch">Batch</label>
                            <select id="filterBatch" name="filterBatch" class="form-control">
                                <option value="">-- Select Batch --</option>
                                <!-- Batches will be populated dynamically -->
                            </select>
                        </div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterLevel">Level</label>
                            <input type="text" id="filterLevel" name="filterLevel" class="form-control" maxlength="20" placeholder="Enter level to filter">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterDate">Date</label>
                            <input type="date" id="filterDate" name="filterDate" class="form-control" placeholder="Select date to filter">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Clear</button>
                        <button type="submit" class="btn btn-confirm">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade view-modal" id="viewModal" tabindex="-1" aria-labelledby="viewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="viewLabel">Leave Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="view-modal-content" id="viewModalContent">
                    <!-- Content will be populated dynamically -->
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let editingRow = null;
            let csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
            const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';

            // Load batches dynamically into the batch dropdown
            function loadBatches(selectElement) {
                const baseUrl = '<?php echo base_url(); ?>';
                const batchUrl = baseUrl + 'batch/get_batches';

                $.ajax({
                    url: batchUrl,
                    method: 'POST',
                    data: { [csrfName]: csrfToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            selectElement.empty();
                            selectElement.append('<option value="">-- Select Batch --</option>');
                            if (response.data.length === 0) {
                                selectElement.append('<option value="" disabled>No batches available</option>');
                            } else {
                                response.data.forEach(batch => {
                                    selectElement.append(`<option value="${batch.batch}">${batch.batch}</option>`);
                                });
                            }
                        } else {
                            console.error('Error fetching batches:', response.message);
                            selectElement.append('<option value="" disabled>Error loading batches</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        selectElement.append('<option value="" disabled>Error loading batches</option>');
                    }
                });
            }

            // Reset leave modal on close
            $('#leaveModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('leaveForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select, textarea').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                $('#batch').empty().append('<option value="">-- Select Batch --</option>');
                $('#level').val('');
                editingRow = null;
                $('#leaveId').val('');
                $('#leaveLabel').text('Add Leave');
            });

            // Load batches when leave modal is shown
            $('#leaveModal').on('show.bs.modal', function() {
                loadBatches($('#batch'));
            });

            // Load batches when filter modal is shown
            $('#filterModal').on('show.bs.modal', function() {
                loadBatches($('#filterBatch'));
            });

            // Reset filter modal on close
            $('#filterModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('filterForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                $('#filterBatch').empty().append('<option value="">-- Select Batch --</option>');
                loadAllLeaves();
            });

            // Validate leave form
            function validateLeaveForm() {
                const form = document.getElementById('leaveForm');
                let isValid = true;

                form.querySelectorAll('input, select, textarea').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const name = form.querySelector('#name');
                const batch = form.querySelector('#batch');
                const level = form.querySelector('#level');
                const date = form.querySelector('#date');
                const reason = form.querySelector('#reason');
                const description = form.querySelector('#description');

                if (!name.value.trim()) {
                    name.setCustomValidity('Name is required.');
                    isValid = false;
                } else if (!/^[A-Za-z\s]+$/.test(name.value)) {
                    name.setCustomValidity('Name must contain only letters and spaces.');
                    isValid = false;
                } else if (name.value.length > 50) {
                    name.setCustomValidity('Name must be 50 characters or less.');
                    isValid = false;
                } else {
                    name.classList.add('is-valid');
                }

                if (!batch.value.trim()) {
                    batch.setCustomValidity('Batch is required.');
                    isValid = false;
                } else {
                    batch.classList.add('is-valid');
                }

                if (!level.value.trim()) {
                    level.setCustomValidity('Level is required.');
                    isValid = false;
                } else {
                    level.classList.add('is-valid');
                }

                if (!date.value) {
                    date.setCustomValidity('Date is required.');
                    isValid = false;
                } else {
                    date.classList.add('is-valid');
                }

                if (!reason.value.trim()) {
                    reason.setCustomValidity('Reason is required.');
                    isValid = false;
                } else if (reason.value.length > 100) {
                    reason.setCustomValidity('Reason must be 100 characters or less.');
                    isValid = false;
                } else {
                    reason.classList.add('is-valid');
                }

                if (!description.value.trim()) {
                    description.setCustomValidity('Description is required.');
                    isValid = false;
                } else if (description.value.length > 200) {
                    description.setCustomValidity('Description must be 200 characters or less.');
                    isValid = false;
                } else {
                    description.classList.add('is-valid');
                }

                return isValid;
            }

            // Load all leaves
            function loadAllLeaves() {
                $.ajax({
                    url: '<?php echo base_url('admin/leaves'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        updateLeaveTable(data);
                        csrfToken = data.csrf_token || csrfToken;
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load leaves. Please try again.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Update leave table with data
            function updateLeaveTable(data) {
                const tableBody = $('#leaveTableBody');
                tableBody.empty();
                if (data.leaves.length === 0) {
                    tableBody.append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
                } else {
                    data.leaves.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.batch}</td>
                                <td>${item.level}</td>
                                <td>${new Date(item.date).toLocaleDateString('en-GB')}</td>
                                <td>${item.reason}</td>
                                <td>${item.description}</td>
                                <td>
                                    <button class="action-btn view" data-id="${item.id}" onclick="viewLeave(this)" title="View Leave Details"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit" data-id="${item.id}" onclick="editLeave(this)" title="Edit Leave"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete" data-id="${item.id}" onclick="deleteLeave(this)" title="Delete Leave"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr class="horizontal-line"><td colspan="7"></td></tr>
                        `;
                        tableBody.append(row);
                    });
                }
            }

            // Submit leave form
            $('#leaveForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                form.classList.add('was-validated');
                if (validateLeaveForm()) {
                    const formData = new FormData(form);
                    const data = {
                        [csrfName]: csrfToken,
                        name: formData.get('name'),
                        batch: formData.get('batch'),
                        level: formData.get('level'),
                        date: formData.get('date'),
                        reason: formData.get('reason'),
                        description: formData.get('description'),
                        id: formData.get('leaveId') || null
                    };
                    const url = data.id ? '<?php echo base_url('admin/leaves/update'); ?>' : '<?php echo base_url('admin/leaves/add'); ?>';
                    const action = data.id ? 'updated' : 'added';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#leaveModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: `Leave ${action} successfully`,
                                    showConfirmButton: true,
                                    timer: 3000
                                }).then(() => {
                                    loadAllLeaves();
                                    csrfToken = response.csrf_token || csrfToken;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || `Error ${action} leave.`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to save leave. Please try again.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    });
                }
            });

            // View leave
            window.viewLeave = function(button) {
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('admin/leaves/get_by_id'); ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const leave = response.data;
                            $('#viewModalContent').html(`
                                <p><strong>Name:</strong> ${leave.name}</p>
                                <p><strong>Batch:</strong> ${leave.batch}</p>
                                <p><strong>Level:</strong> ${leave.level}</p>
                                <p><strong>Date:</strong> ${new Date(leave.date).toLocaleDateString('en-GB')}</p>
                                <p><strong>Reason:</strong> ${leave.reason}</p>
                                <p><strong>Description:</strong> ${leave.description || 'No description'}</p>
                            `);
                            $('#viewModal').modal('show');
                            csrfToken = response.csrf_token || csrfToken;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load leave details.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Edit leave
            window.editLeave = function(button) {
                editingRow = $(button).closest('tr');
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('admin/leaves/get_by_id'); ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const leave = response.data;
                            $('#leaveId').val(leave.id);
                            $('#name').val(leave.name);
                            $('#batch').val(leave.batch);
                            $('#level').val(leave.level);
                            const date = new Date(leave.date);
                            $('#date').val(`${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`);
                            $('#reason').val(leave.reason);
                            $('#description').val(leave.description);
                            $('#leaveLabel').text('Edit Leave');
                            $('#leaveModal').modal('show');
                            $('#leaveForm').find('input, select, textarea').trigger('change');
                            csrfToken = response.csrf_token || csrfToken;
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load leave for editing.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Delete leave
            window.deleteLeave = function(button) {
                const id = $(button).data('id');
                const row = $(button).closest('tr');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo base_url('admin/leaves/delete'); ?>/' + id,
                            type: 'POST',
                            data: { [csrfName]: csrfToken },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    row.next('.horizontal-line').remove();
                                    row.remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                    csrfToken = response.csrf_token || csrfToken;
                                    if ($('#leaveTableBody tr').length === 0) {
                                        $('#leaveTableBody').append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
                                    }
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.message,
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to delete leave.',
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Submit filter form
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {
                    filterName: formData.get('filterName'),
                    filterBatch: formData.get('filterBatch'),
                    filterLevel: formData.get('filterLevel'),
                    filterDate: formData.get('filterDate')
                };
                $.ajax({
                    url: '<?php echo base_url('admin/leaves'); ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        updateLeaveTable(response);
                        csrfToken = response.csrf_token || csrfToken;
                        $('#filterModal').modal('hide');
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to apply filter.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            });

            // Sidebar toggle
            $('#sidebarToggle').on('click', function() {
                if (window.innerWidth <= 576) {
                    $('#sidebar').toggleClass('active');
                    $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
                } else {
                    const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
                    $('.navbar').toggleClass('sidebar-minimized', isMinimized);
                    $('#contentWrapper').toggleClass('minimized', isMinimized);
                }
            });

            // Handle window resize
            $(window).on('resize', function() {
                if (window.innerWidth <= 576) {
                    $('#sidebar').removeClass('minimized');
                    $('.navbar').removeClass('sidebar-minimized');
                    $('#contentWrapper').removeClass('minimized');
                }
            });

            // Real-time validation for leave form
            $('#leaveForm input, #leaveForm select, #leaveForm textarea').on('input change', function() {
                validateLeaveForm();
            });

            // Remove focus from buttons after click
            $('.btn-custom, .action-btn').on('click', function() {
                $(this).blur();
            });
        });
    </script>
</body>
</html>
