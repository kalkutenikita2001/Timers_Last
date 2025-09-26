<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Management</title>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            --primary-color: #ff4040;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content-wrapper {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding-top: 70px;
            min-height: 100vh;
            transition: all 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
            width: calc(100% - 60px);
        }

        .main-content {
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background: var(--primary-gradient);
            padding: 15px 20px;
        }

        .table thead {
            background: var(--primary-gradient);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(255, 64, 64, 0.05);
        }

        .student-id {
            font-weight: bold;
            color: var(--primary-color);
        }

        .fees {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        .search-container {
            position: relative;
        }

        .search-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        #tableSearch {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #ced4da;
            width: 250px;
        }

        @media (max-width: 768px) {

            .content-wrapper,
            .content-wrapper.minimized {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }

            .main-content {
                padding: 15px;
            }

            #tableSearch {
                width: 100% !important;
                margin-top: 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .table th,
            .table td {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {

            .content-wrapper,
            .content-wrapper.minimized {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }

            .main-content {
                padding: 10px;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                padding: 10px;
                background: white;
            }

            .table td {
                text-align: right;
                padding: 8px 10px;
                position: relative;
                border: none;
                border-bottom: 1px solid #f1f1f1;
            }

            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                padding-right: 15px;
                text-align: left;
                font-weight: bold;
                color: #6c757d;
            }

            .status-cell:before,
            .action-cell:before {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-light">
    <!-- Sidebar & Navbar would be included here -->
    <!-- Sidebar -->
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('admin/Include/Navbar') ?>
    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header text-white d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="fas fa-users me-2"></i> Student List</h4>
                            <div class="search-container mt-2 mt-md-0">
                                <i class="fas fa-search"></i>
                                <input id="tableSearch" class="form-control form-control-sm" type="text" placeholder="Search students..." />
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0" id="studentsTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px;">ID</th>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Batch Name</th>
                                            <th>Category</th>
                                            <th>Fees</th>
                                            <th>Status</th>
                                            <th style="min-width: 140px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($students)): ?>
                                            <?php foreach ($students as $stu): ?>
                                                <tr>
                                                    <td data-label="ID" class="student-id"></td>

                                                    <td data-label="Name"><?= $stu['name'] ?></td>
                                                    <td data-label="Level"><?= $stu['student_progress_category'] ?></td>
                                                    <td data-label="Batch Name"><?= $stu['batch_name'] ?></td>
                                                    <td data-label="Category"><?= $stu['category'] ?></td>
                                                    <td data-label="Fees" class="fees">₹<?= number_format($stu['total_fees'], 2) ?></td>
                                                    <td data-label="Status" class="status-cell">
                                                        <?php if ($stu['status'] == 'Active'): ?>
                                                            <span class="badge bg-success">Active</span>
                                                        <?php elseif ($stu['status'] == 'Pending'): ?>
                                                            <span class="badge bg-warning text-dark">Pending</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Deactive</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="Action" class="action-cell">
                                                        <div class="action-buttons">
                                                            <a href="<?= base_url('admin/student_details/' . $stu['id']); ?>" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No students found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-muted small d-flex justify-content-between">
                            <div>* This list is static for demo purposes. Integrate with DB later via a Model.</div>
                            <div class="text-end"><span class="me-2">Showing 4 of 4 records</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#tableSearch").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#studentsTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            function setupResponsiveTable() {
                if ($(window).width() < 576) {
                    $("#studentsTable thead th").each(function(i) {
                        const label = $(this).text();
                        $("#studentsTable tbody td").eq(i).attr("data-label", label);
                    });
                } else {
                    $("#studentsTable tbody td").removeAttr("data-label");
                }
            }

            setupResponsiveTable();
            $(window).resize(setupResponsiveTable);
        });
    </script>
    <script>
        $(document).ready(function() {
            function updateRowNumbers() {
                $("#studentsTable tbody tr:visible").each(function(index) {
                    $(this).find(".student-id").text(index + 1);
                });
            }

            // Initial numbering
            updateRowNumbers();

            // Re-number after search filter
            $("#tableSearch").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#studentsTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
                updateRowNumbers();
            });
        });



        // Sidebar toggle functionality
        $('#sidebarToggle').on('click', function() {
            if ($(window).width() <= 576) {
                $('#sidebar').toggleClass('active');
                $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
            } else {
                const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
                $('.navbar').toggleClass('sidebar-minimized', isMinimized);
                $('#contentWrapper').toggleClass('minimized', isMinimized);
            }
        });
    </script>

</body>

</html>