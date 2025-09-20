<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Password</title>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?= base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Page-specific CSS -->
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
            color: white;
        }

        .table thead {
            background: var(--primary-gradient);
            color: white;
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

    <?= $custom_css ?? '' ?>
</head>

<body class="bg-light">

    <!-- Sidebar & Navbar -->
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="mb-4">View All Passwords</h2>
                </div>
            </div>

            <!-- Center Details Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Center Details</h5>
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" id="centerSearch" class="form-control" placeholder="Search centers...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="centerTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Center Number</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($center_data as $center): ?>
                                    <tr>
                                        <td><?= $center['id'] ?></td>
                                        <td><?= $center['name'] ?></td>
                                        <td><?= $center['center_number'] ?></td>
                                        <td><?= $center['center_number'] ?? 'N/A' ?></td>
                                        <td class="password-cell">
                                            <span class="password-text"><?= $center['password'] ?></span>
                                        </td>
                                        <td><?= $center['created_at'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Accounts</h5>
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="userTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_data as $user): ?>
                                    <tr>
                                        <td><?= $user['id'] ?></td>
                                        <td><?= $user['username'] ?></td>
                                        <td class="password-cell">
                                            <span class="password-text"><?= $user['password'] ?></span>
                                        </td>
                                        <td><?= $user['role'] ?></td>
                                        <td><?= $user['created_at'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript for this page -->
    <script>
        $(document).ready(function() {
            // Search functionality for center table
            $("#centerSearch").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#centerTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            // Search functionality for user table
            $("#userSearch").on("keyup", function() {
                const value = $(this).val().toLowerCase();
                $("#userTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>


    <script>
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