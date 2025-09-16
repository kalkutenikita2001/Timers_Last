<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List - Super Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            --primary-color: #ff4040;
            --dark-bg: #343a40;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Content wrapper positioning */
        .content-wrapper {
            margin-left: 250px;
            transition: margin-left 0.3s ease-in-out;
            padding-top: 70px;
            min-height: 100vh;
            width: calc(100% - 250px);
            position: relative;
            box-sizing: border-box;
            z-index: 1;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
            width: calc(100% - 60px);
        }

        .main-content {
            padding: 20px;
            transition: all 0.3s ease-in-out;
            width: 100%;
            box-sizing: border-box;
        }

        /* Container adjustments */
        .container-fluid {
            padding-left: 20px;
            padding-right: 20px;
        }

        /* Card adjustments for better spacing */
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .main-content.minimized {
            margin-left: 0;
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-sm {
            border-radius: 4px;
            margin: 2px;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }

            .content-wrapper.minimized {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .main-content {
                padding: 15px;
            }

            .card-header h4 {
                font-size: 1.2rem;
            }

            .table-responsive {
                border: none;
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

            .action-buttons {
                display: flex;
                flex-wrap: wrap;
            }

            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
            }

            .content-wrapper.minimized {
                margin-left: 60px;
                width: calc(100% - 60px);
            }
        }

        @media (min-width: 1025px) {
            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
            }

            .content-wrapper.minimized {
                margin-left: 60px;
                width: calc(100% - 60px);
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                width: 100% !important;
                padding-top: 60px;
            }

            .content-wrapper.minimized {
                margin-left: 0 !important;
                width: 100% !important;
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

            .status-cell,
            .action-cell {
                text-align: center !important;
            }

            .status-cell:before,
            .action-cell:before {
                display: none;
            }

            .action-buttons {
                justify-content: center;
            }
        }

        /* Custom enhancements */
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

        .student-id {
            font-weight: bold;
            color: var(--primary-color);
        }

        .fees {
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>

    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <!-- Main Content -->
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header text-white d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h4 class="mb-0"><i class="fas fa-users me-2"></i> Student List</h4>

                            <!-- Quick search (client-side filter) -->
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
                                            <th>Batch</th>
                                            <th>Facility</th>
                                            <th>Fees</th>
                                            <th>Status</th>
                                            <th style="min-width: 140px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- STATIC DEMO ROWS -->
                                        <tr
                                            data-id="1"
                                            data-name="Rahul Sharma"
                                            data-level="Beginner"
                                            data-batch="Morning"
                                            data-facility="Existing"
                                            data-fees="5000"
                                            data-status="Active">
                                            <td data-label="ID" class="student-id">1</td>
                                            <td data-label="Name">Rahul Sharma</td>
                                            <td data-label="Level">Beginner</td>
                                            <td data-label="Batch">Morning</td>
                                            <td data-label="Facility">Existing</td>
                                            <td data-label="Fees" class="fees">₹5000</td>
                                            <td data-label="Status" class="status-cell">
                                                <span class="badge badge-success">Active</span>
                                            </td>
                                            <td data-label="Action" class="action-cell">
                                                <div class="action-buttons">
                                                    <a href="<?php echo base_url('superadmin/student_details/1'); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr
                                            data-id="2"
                                            data-name="Priya Patil"
                                            data-level="Intermediate"
                                            data-batch="Evening"
                                            data-facility="New"
                                            data-fees="8000"
                                            data-status="Deactive">
                                            <td data-label="ID" class="student-id">2</td>
                                            <td data-label="Name">Priya Patil</td>
                                            <td data-label="Level">Intermediate</td>
                                            <td data-label="Batch">Evening</td>
                                            <td data-label="Facility">New</td>
                                            <td data-label="Fees" class="fees">₹8000</td>
                                            <td data-label="Status" class="status-cell">
                                                <span class="badge badge-danger">Deactive</span>
                                            </td>
                                            <td data-label="Action" class="action-cell">
                                                <div class="action-buttons">
                                                    <a href="<?php echo base_url('superadmin/student_details/2'); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr
                                            data-id="3"
                                            data-name="Amit Singh"
                                            data-level="Advanced"
                                            data-batch="Weekend"
                                            data-facility="Existing"
                                            data-fees="10000"
                                            data-status="Pending">
                                            <td data-label="ID" class="student-id">3</td>
                                            <td data-label="Name">Amit Singh</td>
                                            <td data-label="Level">Advanced</td>
                                            <td data-label="Batch">Weekend</td>
                                            <td data-label="Facility">Existing</td>
                                            <td data-label="Fees" class="fees">₹10000</td>
                                            <td data-label="Status" class="status-cell">
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                            <td data-label="Action" class="action-cell">
                                                <div class="action-buttons">
                                                    <a href="<?php echo base_url('superadmin/student_details/3'); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr
                                            data-id="4"
                                            data-name="Sneha Desai"
                                            data-level="Beginner"
                                            data-batch="Morning"
                                            data-facility="New"
                                            data-fees="6000"
                                            data-status="Active">
                                            <td data-label="ID" class="student-id">4</td>
                                            <td data-label="Name">Sneha Desai</td>
                                            <td data-label="Level">Beginner</td>
                                            <td data-label="Batch">Morning</td>
                                            <td data-label="Facility">New</td>
                                            <td data-label="Fees" class="fees">₹6000</td>
                                            <td data-label="Status" class="status-cell">
                                                <span class="badge badge-success">Active</span>
                                            </td>
                                            <td data-label="Action" class="action-cell">
                                                <div class="action-buttons">
                                                    <a href="<?php echo base_url('superadmin/student_details/4'); ?>" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- /STATIC DEMO ROWS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-muted small d-flex justify-content-between">
                            <div>* This list is static for demo purposes. Integrate with DB later via a Model.</div>
                            <div class="text-end">
                                <span class="me-2">Showing 4 of 4 records</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Search functionality
            $("#tableSearch").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#studentsTable tbody tr").filter(function() {
                    const text = $(this).text().toLowerCase();
                    $(this).toggle(text.indexOf(value) > -1);
                });
            });

            // Add responsive labels to table cells for mobile
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

            // Initial call
            setupResponsiveTable();

            // Call on window resize
            $(window).resize(function() {
                setupResponsiveTable();
            });
        });
    </script>
</body>

</html>