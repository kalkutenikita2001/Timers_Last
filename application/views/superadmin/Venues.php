<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>Super Admin - Venues</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        /* Same styles as admin/venues.php */
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
        .action-btn.batches {
            background-color: #ffc107;
            color: black;
        }
        .action-btn.assign-admin {
            background-color: #17a2b8;
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
            .table th:nth-child(5), .table td:nth-child(5), .table th:nth-child(6), .table td:nth-child(6) { display: none; }
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
            .table th:nth-child(5), .table td:nth-child(5), .table th:nth-child(6), .table td:nth-child(6) { display: none; }
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
            .table th:nth-child(5), .table td:nth-child(5), .table th:nth-child(6), .table td:nth-child(6) { display: none; }
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
        .batches-table {
            margin-top: 1rem;
        }
        .add-batch-btn {
            margin-bottom: 1rem;
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
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>
    <div class="content-wrapper" id="contentWrapper">
        <div class="container">
            <div class="add-btn-container">
                <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
                    <i class="bi bi-funnel me-2"></i> Filter
                </button>
                <button class="btn btn-custom" data-toggle="modal" data-target="#venueModal">
                    <i class="fas fa-plus mr-1"></i> Add Venue
                </button>
            </div>
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Time Start</th>
                            <th>Time End</th>
                            <th>Description</th>
                            <th>Location</th>
                            <th>Assigned Admin</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="venueTableBody">
                        <?php if (!empty($venues)): ?>
                            <?php foreach ($venues as $venue): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($venue->name); ?></td>
                                    <td><?php echo htmlspecialchars($venue->time_start); ?></td>
                                    <td><?php echo htmlspecialchars($venue->time_end); ?></td>
                                    <td><?php echo htmlspecialchars($venue->description); ?></td>
                                    <td><?php echo htmlspecialchars($venue->location ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($venue->assigned_admin_name ?? 'None'); ?></td>
                                    <td>
                                        <button class="action-btn view" data-id="<?php echo $venue->id; ?>" onclick="viewVenue(this)" title="View Venue Details"><i class="fas fa-eye"></i></button>
                                        <button class="action-btn edit" data-id="<?php echo $venue->id; ?>" onclick="editVenue(this)" title="Edit Venue"><i class="fas fa-edit"></i></button>
                                        <button class="action-btn delete" data-id="<?php echo $venue->id; ?>" onclick="deleteVenue(this)" title="Delete Venue"><i class="fas fa-trash"></i></button>
                                        <button class="action-btn batches" data-id="<?php echo $venue->id; ?>" onclick="manageBatches(this)" title="Manage Batches for this Venue"><i class="fas fa-list"></i></button>
                                        <button class="action-btn assign-admin" data-id="<?php echo $venue->id; ?>" onclick="assignAdmin(this)" title="Assign Admin"><i class="fas fa-user-plus"></i></button>
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
    <!-- Add/Edit Venue Modal -->
    <div class="modal fade add-modal" id="venueModal" tabindex="-1" aria-labelledby="venueLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="venueLabel">Add Venue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="venueForm" novalidate>
                    <input type="hidden" id="venueId" name="venueId">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" required pattern="[A-Za-z\s]+" maxlength="50" placeholder="Enter venue name (letters and spaces only)">
                        <div class="invalid-feedback">Name is required, letters and spaces only, max 50 characters.</div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="time_start">Time Start <span class="text-danger">*</span></label>
                            <input type="time" id="time_start" name="time_start" class="form-control" required placeholder="Select start time">
                            <div class="invalid-feedback">Start time is required.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="time_end">Time End <span class="text-danger">*</span></label>
                            <input type="time" id="time_end" name="time_end" class="form-control" required placeholder="Select end time">
                            <div class="invalid-feedback">End time is required and must be after start time.</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea id="description" name="description" class="form-control" required maxlength="200" rows="2" placeholder="Enter description (max 200 characters)"></textarea>
                        <div class="invalid-feedback">Description is required, max 200 characters.</div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location <span class="text-danger">*</span></label>
                        <input type="text" id="location" name="location" class="form-control" required pattern="[A-Za-z\s]+" maxlength="100" placeholder="Enter location (letters and spaces only)">
                        <div class="invalid-feedback">Location is required, letters and spaces only, max 100 characters.</div>
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
                    <h3 class="modal-title w-100" id="filterLabel">Filter Venues</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="filterForm" novalidate>
                    <div class="form-note text-center mb-2" style="font-size: clamp(0.7rem, 1.5vw, 0.85rem);">Fill at least one field to apply a filter.</div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterName">Name</label>
                            <input type="text" id="filterName" name="filterName" class="form-control" pattern="[A-Za-z\s]+" maxlength="50" placeholder="Enter name to filter">
                            <div class="invalid-feedback">Name must contain only letters and spaces, max 50 characters.</div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterLocation">Location</label>
                            <input type="text" id="filterLocation" name="filterLocation" class="form-control" pattern="[A-Za-z\s]+" maxlength="100" placeholder="Enter location to filter">
                            <div class="invalid-feedback">Location must contain only letters and spaces, max 100 characters.</div>
                        </div>
                    </div>
                    <div class="form-row d-flex">
                        <div class="form-group col-12 col-md-6">
                            <label for="filterTimeStart">Time Start</label>
                            <input type="time" id="filterTimeStart" name="filterTimeStart" class="form-control" placeholder="Select start time to filter">
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <label for="filterTimeEnd">Time End</label>
                            <input type="time" id="filterTimeEnd" name="filterTimeEnd" class="form-control" placeholder="Select end time to filter">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="filterAdmin">Assigned Admin</label>
                        <select id="filterAdmin" name="filterAdmin" class="form-control">
                            <option value="" selected>All Admins</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?php echo $admin->id; ?>"><?php echo htmlspecialchars($admin->name); ?></option>
                            <?php endforeach; ?>
                        </select>
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
                    <h3 class="modal-title w-100" id="viewLabel">Venue Details</h3>
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
    <!-- Manage Batches Modal -->
    <div class="modal fade" id="batchesModal" tabindex="-1" aria-labelledby="batchesLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="batchesLabel">Manage Batches</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-note">Here you can view, edit, delete existing batches or add new ones for this venue.</div>
                    <div class="table-container batches-table">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Duration (hrs)</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="batchesTableBody">
                                <!-- Batches will be populated dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <h5>Add/Edit Batch</h5>
                    <form id="batchForm" novalidate>
                        <input type="hidden" id="batchVenueId" name="batchVenueId">
                        <input type="hidden" id="batchId" name="batchId">
                        <div class="form-row d-flex">
                            <div class="form-group col-12 col-md-6">
                                <label for="batchType">Type <span class="text-danger">*</span></label>
                                <select id="batchType" name="batchType" class="form-control" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="corporate">Corporate</option>
                                    <option value="group">Group</option>
                                </select>
                                <div class="invalid-feedback">Type is required.</div>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="batchDuration">Duration (hrs) <span class="text-danger">*</span></label>
                                <input type="number" id="batchDuration" name="batchDuration" class="form-control" min="1" required placeholder="Enter duration in hours">
                                <div class="invalid-feedback">Duration is required and must be at least 1 hour.</div>
                            </div>
                        </div>
                        <div class="form-row d-flex">
                            <div class="form-group col-12 col-md-6">
                                <label for="batchTimeStart">Time Start <span class="text-danger">*</span></label>
                                <input type="time" id="batchTimeStart" name="batchTimeStart" class="form-control" required>
                                <div class="invalid-feedback">Start time is required.</div>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="batchTimeEnd">Time End <span class="text-danger">*</span></label>
                                <input type="time" id="batchTimeEnd" name="batchTimeEnd" class="form-control" required>
                                <div class="invalid-feedback">End time is required and must be after start time.</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-confirm add-batch-btn">Save Batch</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Assign Admin Modal -->
    <div class="modal fade" id="assignAdminModal" tabindex="-1" aria-labelledby="assignAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100" id="assignAdminLabel">Assign Admin</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="assignAdminForm" novalidate>
                    <input type="hidden" id="assignVenueId" name="assignVenueId">
                    <div class="form-group">
                        <label for="adminId">Select Admin <span class="text-danger">*</span></label>
                        <select id="adminId" name="adminId" class="form-control" required>
                            <option value="" disabled selected>Select an admin</option>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?php echo $admin->id; ?>"><?php echo htmlspecialchars($admin->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select an admin.</div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-confirm">Assign</button>
                    </div>
                </form>
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

            // Utility function for number formatting
            function number_format(number, decimals = 2) {
                return Number(number).toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Reset venue modal on close
            $('#venueModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('venueForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                editingRow = null;
                $('#venueId').val('');
                $('#venueLabel').text('Add Venue');
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
                loadAllVenues();
            });

            // Reset batches modal on close
            $('#batchesModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('batchForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                $('#batchId').val('');
                $('#batchesTableBody').empty();
            });

            // Reset assign admin modal on close
            $('#assignAdminModal').on('hidden.bs.modal', function() {
                const form = document.getElementById('assignAdminForm');
                form.reset();
                form.classList.remove('was-validated');
                form.querySelectorAll('select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-valid', 'is-invalid');
                });
                $('#assignVenueId').val('');
            });

            // Validate venue form
            function validateVenueForm() {
                const form = document.getElementById('venueForm');
                let isValid = true;

                form.querySelectorAll('input, textarea, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const name = form.querySelector('#name');
                const time_start = form.querySelector('#time_start');
                const time_end = form.querySelector('#time_end');
                const description = form.querySelector('#description');
                const location = form.querySelector('#location');

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

                if (!time_start.value) {
                    time_start.setCustomValidity('Start time is required.');
                    isValid = false;
                } else {
                    time_start.classList.add('is-valid');
                }

                if (!time_end.value) {
                    time_end.setCustomValidity('End time is required.');
                    isValid = false;
                } else if (time_end.value <= time_start.value) {
                    time_end.setCustomValidity('End time must be after start time.');
                    isValid = false;
                } else {
                    time_end.classList.add('is-valid');
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

                if (!location.value.trim()) {
                    location.setCustomValidity('Location is required.');
                    isValid = false;
                } else if (!/^[A-Za-z\s]+$/.test(location.value)) {
                    location.setCustomValidity('Location must contain only letters and spaces.');
                    isValid = false;
                } else if (location.value.length > 100) {
                    location.setCustomValidity('Location must be 100 characters or less.');
                    isValid = false;
                } else {
                    location.classList.add('is-valid');
                }

                return isValid;
            }

            // Validate batch form
            function validateBatchForm() {
                const form = document.getElementById('batchForm');
                let isValid = true;

                form.querySelectorAll('input, select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const batchType = form.querySelector('#batchType');
                const batchDuration = form.querySelector('#batchDuration');
                const batchTimeStart = form.querySelector('#batchTimeStart');
                const batchTimeEnd = form.querySelector('#batchTimeEnd');

                if (!batchType.value) {
                    batchType.setCustomValidity('Type is required.');
                    isValid = false;
                } else {
                    batchType.classList.add('is-valid');
                }

                if (!batchDuration.value || isNaN(batchDuration.value) || batchDuration.value < 1) {
                    batchDuration.setCustomValidity('Duration must be at least 1 hour.');
                    isValid = false;
                } else {
                    batchDuration.classList.add('is-valid');
                }

                if (!batchTimeStart.value) {
                    batchTimeStart.setCustomValidity('Start time is required.');
                    isValid = false;
                } else {
                    batchTimeStart.classList.add('is-valid');
                }

                if (!batchTimeEnd.value) {
                    batchTimeEnd.setCustomValidity('End time is required.');
                    isValid = false;
                } else if (batchTimeEnd.value <= batchTimeStart.value) {
                    batchTimeEnd.setCustomValidity('End time must be after start time.');
                    isValid = false;
                } else {
                    batchTimeEnd.classList.add('is-valid');
                }

                return isValid;
            }

            // Validate assign admin form
            function validateAssignAdminForm() {
                const form = document.getElementById('assignAdminForm');
                let isValid = true;

                form.querySelectorAll('select').forEach(input => {
                    input.setCustomValidity('');
                    input.classList.remove('is-invalid', 'is-valid');
                });

                const adminId = form.querySelector('#adminId');
                if (!adminId.value) {
                    adminId.setCustomValidity('Please select an admin.');
                    isValid = false;
                } else {
                    adminId.classList.add('is-valid');
                }

                return isValid;
            }

            // Load all venues
            function loadAllVenues() {
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues'); ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        updateVenueTable(data);
                        csrfToken = data.csrf_token || csrfToken;
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load venues. Please try again.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Update venue table with data
            function updateVenueTable(data) {
                const tableBody = $('#venueTableBody');
                tableBody.empty();
                if (data.venues.length === 0) {
                    tableBody.append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
                } else {
                    data.venues.forEach(item => {
                        const row = `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.time_start}</td>
                                <td>${item.time_end}</td>
                                <td>${item.description}</td>
                                <td>${item.location || 'N/A'}</td>
                                <td>${item.assigned_admin_name || 'None'}</td>
                                <td>
                                    <button class="action-btn view" data-id="${item.id}" onclick="viewVenue(this)" title="View Venue Details"><i class="fas fa-eye"></i></button>
                                    <button class="action-btn edit" data-id="${item.id}" onclick="editVenue(this)" title="Edit Venue"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete" data-id="${item.id}" onclick="deleteVenue(this)" title="Delete Venue"><i class="fas fa-trash"></i></button>
                                    <button class="action-btn batches" data-id="${item.id}" onclick="manageBatches(this)" title="Manage Batches for this Venue"><i class="fas fa-list"></i></button>
                                    <button class="action-btn assign-admin" data-id="${item.id}" onclick="assignAdmin(this)" title="Assign Admin"><i class="fas fa-user-plus"></i></button>
                                </td>
                            </tr>
                            <tr class="horizontal-line"><td colspan="7"></td></tr>
                        `;
                        tableBody.append(row);
                    });
                }
            }

            // Submit venue form
            $('#venueForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                form.classList.add('was-validated');
                if (validateVenueForm()) {
                    const formData = new FormData(form);
                    const data = {
                        [csrfName]: csrfToken,
                        name: formData.get('name'),
                        time_start: formData.get('time_start'),
                        time_end: formData.get('time_end'),
                        description: formData.get('description'),
                        location: formData.get('location'),
                        id: formData.get('venueId') || null
                    };
                    const url = data.id ? '<?php echo base_url('superadmin/venues/update'); ?>' : '<?php echo base_url('superadmin/venues/add'); ?>';
                    const action = data.id ? 'updated' : 'added';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#venueModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: `Venue ${action} successfully`,
                                    showConfirmButton: true,
                                    timer: 3000
                                }).then(() => {
                                    loadAllVenues();
                                    csrfToken = response.csrf_token || csrfToken;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || `Error ${action} venue.`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to save venue. Please try again.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    });
                }
            });

            // View venue
            window.viewVenue = function(button) {
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues/get_by_id'); ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const venue = response.data;
                            $('#viewModalContent').html(`
                                <p><strong>Name:</strong> ${venue.name}</p>
                                <p><strong>Time Start:</strong> ${venue.time_start}</p>
                                <p><strong>Time End:</strong> ${venue.time_end}</p>
                                <p><strong>Description:</strong> ${venue.description || 'No description'}</p>
                                <p><strong>Location:</strong> ${venue.location || 'N/A'}</p>
                                <p><strong>Assigned Admin:</strong> ${venue.assigned_admin_name || 'None'}</p>
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
                            text: 'Failed to load venue details.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Edit venue
            window.editVenue = function(button) {
                editingRow = $(button).closest('tr');
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues/get_by_id'); ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const venue = response.data;
                            $('#venueId').val(venue.id);
                            $('#name').val(venue.name);
                            $('#time_start').val(venue.time_start);
                            $('#time_end').val(venue.time_end);
                            $('#description').val(venue.description);
                            $('#location').val(venue.location);
                            $('#venueLabel').text('Edit Venue');
                            $('#venueModal').modal('show');
                            $('#venueForm').find('input, textarea').trigger('input');
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
                            text: 'Failed to load venue for editing.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Delete venue
            window.deleteVenue = function(button) {
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
                            url: '<?php echo base_url('superadmin/venues/delete'); ?>/' + id,
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
                                    if ($('#venueTableBody tr').length === 0) {
                                        $('#venueTableBody').append('<tr><td colspan="7" class="text-center">No records found.</td></tr>');
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
                                    text: 'Failed to delete venue.',
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Manage batches
            window.manageBatches = function(button) {
                const venueId = $(button).data('id');
                $('#batchVenueId').val(venueId);
                loadBatches(venueId);
                $('#batchesModal').modal('show');
            };

            // Load batches for venue
            function loadBatches(venueId) {
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues/get_batches_by_venue'); ?>/' + venueId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        const tableBody = $('#batchesTableBody');
                        tableBody.empty();
                        if (response.status === 'success') {
                            if (response.batches.length === 0) {
                                tableBody.append('<tr><td colspan="5" class="text-center">No batches found for this venue.</td></tr>');
                            } else {
                                response.batches.forEach(item => {
                                    const row = `
                                        <tr>
                                            <td>${item.type}</td>
                                            <td>${item.duration}</td>
                                            <td>${item.time_start}</td>
                                            <td>${item.time_end}</td>
                                            <td>
                                                <button class="action-btn edit" data-id="${item.id}" onclick="editBatch(this)" title="Edit Batch"><i class="fas fa-edit"></i></button>
                                                <button class="action-btn delete" data-id="${item.id}" onclick="deleteBatch(this)" title="Delete Batch"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    `;
                                    tableBody.append(row);
                                });
                            }
                            csrfToken = response.csrf_token || csrfToken;
                        } else {
                            tableBody.append('<tr><td colspan="5" class="text-center">No batches found.</td></tr>');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load batches.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            }

            // Submit batch form
            $('#batchForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                form.classList.add('was-validated');
                if (validateBatchForm()) {
                    const formData = new FormData(form);
                    const data = {
                        [csrfName]: csrfToken,
                        venue_id: formData.get('batchVenueId'),
                        type: formData.get('batchType'),
                        duration: formData.get('batchDuration'),
                        time_start: formData.get('batchTimeStart'),
                        time_end: formData.get('batchTimeEnd'),
                        id: formData.get('batchId') || null
                    };
                    const url = data.id ? '<?php echo base_url('superadmin/venues/update_batch'); ?>' : '<?php echo base_url('superadmin/venues/add_batch'); ?>';
                    const action = data.id ? 'updated' : 'added';

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: `Batch ${action} successfully`,
                                    showConfirmButton: true,
                                    timer: 3000
                                }).then(() => {
                                    loadBatches(data.venue_id);
                                    form.reset();
                                    $('#batchId').val('');
                                    form.classList.remove('was-validated');
                                    form.querySelectorAll('input, textarea, select').forEach(input => {
                                        input.setCustomValidity('');
                                        input.classList.remove('is-valid', 'is-invalid');
                                    });
                                    csrfToken = response.csrf_token || csrfToken;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || `Error ${action} batch.`,
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to save batch.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    });
                }
            });

            // Edit batch
            window.editBatch = function(button) {
                const id = $(button).data('id');
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues/get_batch_by_id'); ?>/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            const batch = response.data;
                            $('#batchId').val(batch.id);
                            $('#batchType').val(batch.type);
                            $('#batchDuration').val(batch.duration);
                            $('#batchTimeStart').val(batch.time_start);
                            $('#batchTimeEnd').val(batch.time_end);
                            $('#batchForm').find('input, select').trigger('change');
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
                            text: 'Failed to load batch for editing.',
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                });
            };

            // Delete batch
            window.deleteBatch = function(button) {
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
                            url: '<?php echo base_url('superadmin/venues/delete_batch'); ?>/' + id,
                            type: 'POST',
                            data: { [csrfName]: csrfToken },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    row.remove();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                    csrfToken = response.csrf_token || csrfToken;
                                    if ($('#batchesTableBody tr').length === 0) {
                                        $('#batchesTableBody').append('<tr><td colspan="5" class="text-center">No batches found for this venue.</td></tr>');
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
                                    text: 'Failed to delete batch.',
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        });
                    }
                });
            };

            // Assign admin
            window.assignAdmin = function(button) {
                const venueId = $(button).data('id');
                $('#assignVenueId').val(venueId);
                $('#assignAdminModal').modal('show');
            };

            // Submit assign admin form
            $('#assignAdminForm').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                form.classList.add('was-validated');
                if (validateAssignAdminForm()) {
                    const formData = new FormData(form);
                    const data = {
                        [csrfName]: csrfToken,
                        venue_id: formData.get('assignVenueId'),
                        admin_id: formData.get('adminId')
                    };

                    $.ajax({
                        url: '<?php echo base_url('superadmin/venues/assign_admin'); ?>',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                $('#assignAdminModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Admin assigned successfully',
                                    showConfirmButton: true,
                                    timer: 3000
                                }).then(() => {
                                    loadAllVenues();
                                    csrfToken = response.csrf_token || csrfToken;
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Error assigning admin.',
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to assign admin.',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        }
                    });
                }
            });

            // Submit filter form
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = {
                    filterName: formData.get('filterName'),
                    filterLocation: formData.get('filterLocation'),
                    filterTimeStart: formData.get('filterTimeStart'),
                    filterTimeEnd: formData.get('filterTimeEnd'),
                    filterAdmin: formData.get('filterAdmin')
                };
                $.ajax({
                    url: '<?php echo base_url('superadmin/venues'); ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        updateVenueTable(response);
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

            // Real-time validation for venue form
            $('#venueForm input, #venueForm textarea, #venueForm select').on('input change', function() {
                validateVenueForm();
            });

            // Real-time validation for batch form
            $('#batchForm input, #batchForm select').on('input change', function() {
                validateBatchForm();
            });

            // Real-time validation for assign admin form
            $('#assignAdminForm select').on('change', function() {
                validateAssignAdminForm();
            });

            // Remove focus from buttons after click
            $('.btn-custom, .action-btn').on('click', function() {
                $(this).blur();
            });
        });
    </script>
</body>
</html>