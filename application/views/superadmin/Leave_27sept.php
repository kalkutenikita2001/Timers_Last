<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f6f8;
            padding-top: 60px;
        }

        h4 {
            color: white !important;
            font-size: 1.2rem;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .table th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white !important;
        }

        .badge-success {
            background: #28a745;
        }

        .badge-danger {
            background: #dc3545;
        }

        .badge-warning {
            background: #ffc107;
            color: black;
        }

        @media (max-width: 767px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 10px;
            }

            h4 {
                font-size: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 10px;
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                white-space: nowrap;
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
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt mr-2"></i>Leave Management</h4>
                </div>
                <div class="card-body">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            <div class="mb-3">
                                <label for="roleFilter"><strong>Filter by Role:</strong></label>
                                <select id="roleFilter" class="form-control" style="width:200px; display:inline-block; margin-left:10px;">
                                    <option value="all">All</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- Leaves Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Applicant Name</th>
                                    <th>Center Name</th>
                                    <th>Role</th>
                                    <th>Leave Type</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($leaves)): ?>
                                    <?php foreach ($leaves as $lv): ?>
                                        <tr>
                                            <td><?= $lv->applicant_name ?></td>
                                            <td><?= $lv->user_name ?></td>
                                            <td><?= $lv->role ?></td>
                                            <td><?= $lv->leave_type ?></td>
                                            <td><?= date("d/m/Y", strtotime($lv->from_date)) ?></td>
                                            <td><?= date("d/m/Y", strtotime($lv->to_date)) ?></td>
                                            <td><?= $lv->reason ?></td>
                                            <td>
                                                <?php if ($lv->status == 'approved'): ?>
                                                    <span class="badge badge-success">Approved</span>
                                                <?php elseif ($lv->status == 'rejected'): ?>
                                                    <span class="badge badge-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                    <?php
                                                    $user_role = $this->session->userdata('role');

                                                    if (($user_role == 'admin' && $lv->role == 'Student') || ($user_role == 'superadmin')): ?>

                                                        <a href="<?= base_url("Leave/change_status/$lv->id/approved") ?>" class="btn btn-sm btn-success">Approve</a>
                                                        <a href="<?= base_url("Leave/change_status/$lv->id/rejected") ?>" class="btn btn-sm btn-danger">Reject</a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No leave requests found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Apply Leave Modal -->
    <!-- Apply Leave Modal -->
    <div class="modal fade" id="leaveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Apply for Leave</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('Leave/add_leave') ?>" id="addLeaveForm" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Admin ID -->
                            <input type="hidden" name="user_id" value="<?= $this->session->userdata('id'); ?>">
                            <div class="col-md-12 mb-3">
                                <label>Applicant Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter applicant name" required>
                                <div class="invalid-feedback">Applicant name is required.</div>
                            </div>


                            <!-- Designation -->
                            <div class="col-md-6 mb-3">
                                <label>Designation</label>
                                <select name="designation" id="designationSelect" class="form-control" required>
                                    <option value="">-- Select Designation --</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                <div class="invalid-feedback">Designation is required.</div>
                            </div>

                            <!-- Leave Type -->
                            <div class="col-md-6 mb-3">
                                <label>Leave Type</label>
                                <select name="leave_type" id="leaveTypeSelect" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="Sick">Sick</option>
                                    <option value="Casual">Casual</option>
                                    <option value="Tournament">Tournament</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Other">Other</option>
                                </select>
                                <input type="text" id="leaveTypeOther" name="leave_type_other" class="form-control mt-2" placeholder="Enter leave type" style="display:none;">
                                <div class="invalid-feedback">Leave type is required.</div>
                            </div>

                            <!-- Start Date -->
                            <div class="col-md-6 mb-3">
                                <label>Start Date</label>
                                <input type="date" name="from_date" class="form-control" required>
                                <div class="invalid-feedback">Start date is required.</div>
                            </div>

                            <!-- End Date -->
                            <div class="col-md-6 mb-3">
                                <label>End Date</label>
                                <input type="date" name="to_date" class="form-control" required>
                                <div class="invalid-feedback">End date is required.</div>
                            </div>

                            <!-- Reason -->
                            <div class="col-12 mb-3">
                                <label>Reason</label>
                                <textarea name="reason" class="form-control" rows="3" required></textarea>
                                <div class="invalid-feedback">Reason is required.</div>
                            </div>

                            <!-- Center Name (Autofill & readonly) -->
                            <div class="col-md-6 mb-3">
                                <label>Center Name</label>
                                <input
                                    type="text"
                                    name="center_name"
                                    class="form-control"
                                    placeholder="Enter Center Name"
                                    value="<?= $this->session->userdata('username'); ?>"
                                    required>
                                <div class="invalid-feedback">Center Name is required.</div>
                            </div>



                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4" id="saveBtn" disabled>Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <!-- <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-filter mr-2"></i>Filter Leaves</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('Leave/filter') ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>From Date</label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>To Date</label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Leave Type</label>
                                <input type="text" name="leave_type" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Any --</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary px-4">Clear</button>
                        <button type="submit" class="btn btn-danger px-4">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            const form = $('#addLeaveForm');
            const saveBtn = $('#saveBtn');

            // Show/hide "Other" input for Designation
            $('#designationSelect').change(function() {
                if ($(this).val() === 'Other') {
                    $('#designationOther').show().attr('required', true);
                } else {
                    $('#designationOther').hide().val('').attr('required', false);
                }
            });

            // Show/hide "Other" input for Leave Type
            $('#leaveTypeSelect').change(function() {
                if ($(this).val() === 'Other') {
                    $('#leaveTypeOther').show().attr('required', true);
                } else {
                    $('#leaveTypeOther').hide().val('').attr('required', false);
                }
            });

            function checkFormValidity() {
                if (form[0].checkValidity()) {
                    saveBtn.prop('disabled', false);
                } else {
                    saveBtn.prop('disabled', true);
                }
            }

            form.find('input, select, textarea').on('input change', checkFormValidity);

            form.on('submit', function(event) {
                if (!form[0].checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.addClass('was-validated');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            <?php if ($this->session->flashdata('message')): ?>
                let type = "<?= $this->session->flashdata('message'); ?>";
                let msg = "<?= $this->session->flashdata('msg_text'); ?>";

                Swal.fire({
                    icon: type === 'success' ? 'success' : 'error',
                    title: type === 'success' ? 'Success' : 'Error',
                    text: msg,
                    confirmButtonColor: '#d33'
                });
            <?php endif; ?>
        });
    </script>
    <script>
        const roleFilter = document.getElementById('roleFilter');
        const table = document.querySelector('.table tbody');
        const rows = table.querySelectorAll('tr');

        roleFilter.addEventListener('change', function() {
            const selectedRole = this.value;

            rows.forEach(row => {
                const roleCell = row.cells[2]; // Role column (0-indexed)
                if (!roleCell) return;

                if (selectedRole === 'all' || roleCell.textContent === selectedRole) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle'); // Button to toggle
            const sidebar = document.getElementById('sidebar'); // Sidebar element
            const contentWrapper = document.getElementById('contentWrapper'); // Main content wrapper
            const navbar = document.querySelector('.navbar'); // Navbar

            if (!sidebarToggle || !sidebar || !contentWrapper || !navbar) return;

            sidebarToggle.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    // Mobile: show/hide sidebar
                    sidebar.classList.toggle('active');
                    navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                } else {
                    // Desktop: minimize/maximize sidebar
                    const isMinimized = sidebar.classList.toggle('minimized');
                    contentWrapper.classList.toggle('minimized', isMinimized);
                    navbar.classList.toggle('sidebar-minimized', isMinimized);
                }
            });

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 &&
                    sidebar.classList.contains('active') &&
                    !sidebar.contains(e.target) &&
                    e.target !== sidebarToggle &&
                    !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                    navbar.classList.add('sidebar-hidden');
                }
            });
        });
    </script>

</body>

</html>