<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Add Expenses</title>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

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

        .action-btn {
            padding: 5px 10px;
            margin: 0 3px;
            border-radius: 4px;
            cursor: pointer;
        }

        .thumbs-up {
            background-color: #28a745;
            color: white;
        }

        .cross {
            background-color: #dc3545;
            color: white;
        }

        /* 🔑 Mobile fix: remove sidebar margin */
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

            .d-flex.justify-content-between>div {
                width: 100%;
            }

            .d-flex.justify-content-between button {
                width: 100%;
                margin-bottom: 5px;
            }

            .table th,
            .table td {
                font-size: 0.8rem;
                white-space: nowrap;
            }

            /* Make modal content adjust better */
            .modal-dialog {
                margin: 10px;
            }

            .modal-body .row>div {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .modal-title {
                font-size: 1rem;
            }
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

        .action-btn {
            padding: 5px 10px;
            margin: 0 3px;
            border-radius: 4px;
            cursor: pointer;
        }

        .thumbs-up {
            background-color: #28a745;
            color: white;
        }

        .cross {
            background-color: #dc3545;
            color: white;
        }

        /* 📱 Mobile First Approach */

        /* Extra Small Devices (Phones, <576px) */
        @media (max-width: 575.98px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 10px;
            }

            .card,
            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                white-space: nowrap;
            }

            .modal-dialog {
                margin: 10px;
                max-width: 95%;
            }

            .navbar .navbar-brand {
                font-size: 1rem;
            }

            /* Sidebar collapsed on mobile */
            #sidebar {
                position: fixed;
                left: -250px;
                width: 250px;
                top: 0;
                height: 100%;
                /*background: #470000;*/
                transition: all 0.3s ease;
                z-index: 1050;
            }

            #sidebar.active {
                left: 0;
            }

            #contentWrapper {
                margin-left: 0 !important;
            }

            /* Overlay when sidebar opens */
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1049;
            }

            .overlay.active {
                display: block;
            }
        }

        /* Small Devices (≥576px and <768px) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .content-wrapper {
                margin-left: 0 !important;
            }
        }

        /* Medium Devices (≥768px and <992px) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .content-wrapper {
                margin-left: 200px;
            }

            #sidebar {
                width: 200px;
            }
        }

        /* Large Devices (≥992px and <1200px) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .content-wrapper {
                margin-left: 220px;
            }

            /* #sidebar {
                width: 220px;
            } */
        }

        /* Extra Large Devices (≥1200px) */
        @media (min-width: 1200px) {
            .content-wrapper {
                margin-left: 250px;
            }

            /* #sidebar {
                width: 250px;
            } */
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('admin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Expense Management</h4>
                </div>
                <div class="card-body">

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mb-4">
                        <div class="center-select-container" id="centerSelectContainer">
                            <select class="form-control form-control-sm" style="width: 200px;">
                                <option value="">-- Center Name --</option>
                                <?php foreach ($centers as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <!-- <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#filterModal">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button> -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#expenseModal">
                                <i class="fas fa-plus mr-1"></i> Add Expense
                            </button>
                        </div>
                    </div>

                    <!-- Expenses Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Center</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Added By</th>
                                    <th>Status</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($expenses)): ?>
                                    <?php foreach ($expenses as $exp): ?>
                                        <tr>
                                            <td></td>
                                            <td><?= $exp->center_name ?></td>
                                            <td><?= $exp->title ?></td>
                                            <td><?= date("d/m/Y", strtotime($exp->date)) ?></td>
                                            <td>₹ <?= number_format($exp->amount, 2) ?></td>
                                            <td><?= $exp->category ?></td>
                                            <td><?= $exp->description ?></td>
                                            <td><?= $exp->added_by ?></td>
                                            <td>
                                                <?php if ($exp->status == 'approved'): ?>
                                                    <span class="badge badge-success">Approved</span>
                                                <?php elseif ($exp->status == 'rejected'): ?>
                                                    <span class="badge badge-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <!-- <td>
                                                <?php if ($exp->status == 'approved'): ?>
                                                    <span class="badge badge-success">Approved</span>
                                                <?php elseif ($exp->status == 'rejected'): ?>
                                                    <span class="badge badge-danger">Rejected</span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">Pending</span>
                                                <?php endif; ?>
                                            </td> -->



                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No expenses found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Add Expense</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('Admin/add_expense') ?>" id="addExpenseForm" novalidate>

                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="added_by" value="admin">

                            <!-- <div class="form-group col-md-12">
                                <label for="center_id">Select Center</label>
                                <select name="center_id" class="form-control" required>
                                    <option value="">-- Select Center --</option>
                                    <?php foreach ($centers as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Please select a center.</div>
                            </div> -->
                            <input type="hidden" name="center_id" value="<?= $this->session->userdata('id'); ?>">

                            <div class="col-md-6 mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                                <div class="invalid-feedback">Title is required.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                                <div class="invalid-feedback">Please select a date.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Amount (₹)</label>
                                <input type="number" name="amount" class="form-control" required min="1">
                                <div class="invalid-feedback">Enter a valid amount.</div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control" required>
                                <div class="invalid-feedback">Category is required.</div>
                            </div>

                            <div class="col-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                                <div class="invalid-feedback">Description is required.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4" id="saveBtn" disabled>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-filter mr-2"></i>Filter Expenses</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="<?= base_url('Expense/filter') ?>">
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
                                <label>Min Amount</label>
                                <input type="number" name="min_amount" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Max Amount</label>
                                <input type="number" name="max_amount" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Category</label>
                                <input type="text" name="category" class="form-control">
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
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Confirm Approve
        $(document).on('click', '.approve-btn', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this expense!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Confirm Reject
        $(document).on('click', '.reject-btn', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "This expense will be rejected!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        // Add Expense Success Alert
        // $('#addExpenseForm').on('submit', function() {
        //     Swal.fire({
        //         title: 'Success!',
        //         text: 'Expense has been added successfully!',
        //         icon: 'success',
        //         timer: 2000,
        //         showConfirmButton: false
        //     });
        // });
    </script>
    <script>
        $(document).ready(function() {
            const form = $('#addExpenseForm');
            const saveBtn = $('#saveBtn');

            function checkFormValidity() {
                if (form[0].checkValidity()) {
                    saveBtn.prop('disabled', false);
                } else {
                    saveBtn.prop('disabled', true);
                }
            }

            // Check validity on input change
            form.find('input, select, textarea').on('input change', function() {
                checkFormValidity();
            });

            // Bootstrap validation styling
            form.on('submit', function(event) {
                if (!form[0].checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.addClass('was-validated');
            });
        });
        // Before submitting, if added_by is superadmin, set status to approved
        $('#addExpenseForm').on('submit', function() {
            let addedBy = $('input[name="added_by"]').val();
            if (addedBy === "superadmin") {
                $('#statusField').val("approved");
            }

            Swal.fire({
                title: 'Success!',
                text: 'Expense has been added successfully!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        });
        // Confirm Approve
        $(document).on('click', '.approve-btn', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let btn = $(this); // reference to clicked button

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this expense!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.addClass("disabled").css("pointer-events", "none"); // disable approve
                    btn.siblings(".reject-btn").addClass("disabled").css("pointer-events", "none"); // disable reject
                    window.location.href = url;
                }
            });
        });

        // Confirm Reject
        $(document).on('click', '.reject-btn', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let btn = $(this);

            Swal.fire({
                title: 'Are you sure?',
                text: "This expense will be rejected!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reject it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.addClass("disabled").css("pointer-events", "none"); // disable reject
                    btn.siblings(".approve-btn").addClass("disabled").css("pointer-events", "none"); // disable approve
                    window.location.href = url;
                }
            });
        });
        $(document).ready(function() {
            // Set date input to only allow today's date
            let today = new Date().toISOString().split('T')[0];
            $('input[name="date"]').attr('min', today);
            $('input[name="date"]').attr('max', today);

            // Optional: auto-fill today's date
            $('input[name="date"]').val(today);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('table tbody tr').each(function() {
                let addedBy = $(this).find('td:nth-child(7)').text().trim().toLowerCase();
                if (addedBy !== 'admin') {
                    $(this).hide();
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tbody = document.querySelector("table tbody");
            const rows = tbody.querySelectorAll("tr");

            rows.forEach((row, index) => {
                // Skip row if it has "No expenses found"
                if (row.querySelector("td[colspan]")) return;

                // Set first cell to Sr.No
                row.cells[0].textContent = index + 1;
            });
        });
    </script>


</body>

</html>