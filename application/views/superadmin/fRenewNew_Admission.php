<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Renewal Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

    <style>
        :root {
            --accent: #ff4040;
            /* Primary brand red */
            --accent-dark: #470000;
            /* Deep maroon for depth and contrast */
            --muted: #f4f6f8;
            /* Soft background gray */
            --text-dark: #111111;
            /* Default text color */
            --text-light: #ffffff;
            /* Light text for dark backgrounds */
        }

        body {
            background-color: var(--muted) !important;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial !important;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            background-color: #333;
            color: white;
            padding-top: 20px;
            z-index: 1000;
            transition: width 0.3s ease-in-out;
        }

        .sidebar.minimized {
            width: 60px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            color: white;
            padding: 10px;
            transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
            background: white;
            z-index: 999;
        }

        .navbar.sidebar-minimized {
            left: 60px;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 10px 20px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .card {
            border: none;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%) !important;
            color: var(--text-light) !important;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%) !important;
            border: none !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-secondary {
            background: #6c757d !important;
            border: none !important;
        }

        /* Make all Font Awesome icons red */
        i.fas,
        i.far,
        i.fab {
            color: var(--accent) !important;
        }

        .table th {
            background-color: var(--accent-dark);
            color: var(--text-light);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #e6ffe6;
            color: #28a745;
        }

        .status-expired {
            background-color: #ffe6e6;
            color: #dc3545;
        }

        .status-upcoming {
            background-color: #fff3cd;
            color: #856404;
        }

        .renew-btn {
            background: white !important;
            border: none !important;
        }

        .renew-btn:hover {
            opacity: 0.9;
        }

        .filter-section {
            display: none;
            /* Initially hidden */
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .page-item.active .page-link {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .page-link {
            color: var(--accent);
        }

        .page-link:hover {
            color: var(--accent-dark);
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid mt-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-sync-alt mr-2"></i> Membership Renewals</h4>
                    <div>
                        <button class="btn btn-light btn-sm mr-2" id="filterBtn">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <button class="btn btn-light btn-sm" id="exportBtn">
                            <i class="fas fa-download mr-1"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="filter-section" id="filterSection">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Status</label>
                                <select class="form-control" id="statusFilter">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="expired">Expired</option>
                                    <option value="upcoming">Upcoming Renewal</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Plan Type</label>
                                <select class="form-control" id="planFilter">
                                    <option value="">All Plans</option>
                                    <option value="basic">Basic</option>
                                    <option value="premium">Premium</option>
                                    <option value="vip">VIP</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Renewal Date</label>
                                <input type="date" class="form-control" id="renewalDateFilter">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary btn-block" id="applyFilters">
                                    <i class="fas fa-check mr-1"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Renewals Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="renewalsTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Plan</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Renewal Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamic rows will be populated here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Renewal Confirmation Modal -->
    <div class="modal fade" id="renewalModal" tabindex="-1" role="dialog" aria-labelledby="renewalModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renewalModalLabel">Confirm Renewal</h5>
                    <button type="button" class="btn btn-light border-0" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <p>Are you sure you want to renew the membership for <strong id="memberName"></strong>?</p>
                    <p>Current Plan: <span id="currentPlan" class="font-weight-bold"></span></p>
                    <p>Renewal Date: <span id="renewalDate" class="font-weight-bold"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                    <button type="button" class="btn btn-primary" id="confirmRenewal">Proceed to Renewal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Sample data for the table
            const renewalsData = [{
                    id: 1,
                    name: "Rajesh Kumar",
                    plan: "Premium Monthly",
                    startDate: "2023-10-01",
                    endDate: "2023-11-01",
                    renewalDate: "2023-11-02",
                    status: "active"
                },
                {
                    id: 2,
                    name: "Priya Sharma",
                    plan: "Basic Quarterly",
                    startDate: "2023-09-15",
                    endDate: "2023-12-15",
                    renewalDate: "2023-12-16",
                    status: "active"
                },
                {
                    id: 3,
                    name: "Amit Patel",
                    plan: "VIP Yearly",
                    startDate: "2022-12-01",
                    endDate: "2023-12-01",
                    renewalDate: "2023-12-02",
                    status: "upcoming"
                },
                {
                    id: 4,
                    name: "Sneha Gupta",
                    plan: "Premium Monthly",
                    startDate: "2023-09-01",
                    endDate: "2023-10-01",
                    renewalDate: "2023-10-02",
                    status: "expired"
                },
                {
                    id: 5,
                    name: "Vikram Singh",
                    plan: "Basic Monthly",
                    startDate: "2023-10-10",
                    endDate: "2023-11-10",
                    renewalDate: "2023-11-11",
                    status: "active"
                },
                {
                    id: 6,
                    name: "Anjali Mehta",
                    plan: "Premium Quarterly",
                    startDate: "2023-08-01",
                    endDate: "2023-11-01",
                    renewalDate: "2023-11-02",
                    status: "expired"
                },
                {
                    id: 7,
                    name: "Rahul Verma",
                    plan: "VIP Monthly",
                    startDate: "2023-10-15",
                    endDate: "2023-11-15",
                    renewalDate: "2023-11-16",
                    status: "active"
                },
                {
                    id: 8,
                    name: "Neha Joshi",
                    plan: "Basic Yearly",
                    startDate: "2022-11-20",
                    endDate: "2023-11-20",
                    renewalDate: "2023-11-21",
                    status: "upcoming"
                }
            ];

            // Initialize the page
            function initializePage() {
                populateTable(renewalsData);

                // Add sidebar toggle functionality if needed
                addSidebarToggle();
            }

            // Add sidebar toggle functionality
            function addSidebarToggle() {
                // Check if toggle button exists in the sidebar
                const toggleBtn = $('#toggleSidebar');
                if (toggleBtn.length > 0) {
                    toggleBtn.on('click', function() {
                        $('.sidebar').toggleClass('minimized');
                        $('.navbar').toggleClass('sidebar-minimized');
                        $('#contentWrapper').toggleClass('minimized');
                    });
                }
            }

            // Toggle filter section
            $('#filterBtn').on('click', function() {
                $('#filterSection').slideToggle();
            });

            // Populate table with data
            function populateTable(data) {
                const tbody = $('#renewalsTable tbody');
                tbody.empty();

                if (data.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                                No records found matching your criteria
                            </td>
                        </tr>
                    `);
                    return;
                }

                data.forEach(item => {
                    const statusClass = getStatusClass(item.status);
                    const statusText = getStatusText(item.status);

                    const row = `
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.plan}</td>
                            <td>${formatDate(item.startDate)}</td>
                            <td>${formatDate(item.endDate)}</td>
                            <td>${formatDate(item.renewalDate)}</td>
                            <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                            <td>
                                <button class="btn btn-sm renew-btn renew-admission" data-id="${item.id}" data-name="${item.name}" data-plan="${item.plan}" data-renewal="${item.renewalDate}">
                                    <i class="fas fa-sync-alt mr-1"></i> 
                                </button>
                                <button><i class="bi bi-stop-circle text-danger"></i>
</button>
                            </td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            }

            // Format date to display in table
            function formatDate(dateString) {
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return new Date(dateString).toLocaleDateString('en-US', options);
            }

            // Get status class based on status value
            function getStatusClass(status) {
                switch (status) {
                    case 'active':
                        return 'status-active';
                    case 'expired':
                        return 'status-expired';
                    case 'upcoming':
                        return 'status-upcoming';
                    default:
                        return '';
                }
            }

            // Get status text based on status value
            function getStatusText(status) {
                switch (status) {
                    case 'active':
                        return 'Active';
                    case 'expired':
                        return 'Expired';
                    case 'upcoming':
                        return 'Upcoming Renewal';
                    default:
                        return '';
                }
            }

            // Filter functionality
            $('#applyFilters').on('click', function() {
                const statusFilter = $('#statusFilter').val();
                const planFilter = $('#planFilter').val();
                const renewalDateFilter = $('#renewalDateFilter').val();

                let filteredData = renewalsData;

                if (statusFilter) {
                    filteredData = filteredData.filter(item => item.status === statusFilter);
                }

                if (planFilter) {
                    filteredData = filteredData.filter(item =>
                        item.plan.toLowerCase().includes(planFilter.toLowerCase())
                    );
                }

                if (renewalDateFilter) {
                    filteredData = filteredData.filter(item =>
                        item.renewalDate === renewalDateFilter
                    );
                }

                populateTable(filteredData);

                // Show success message if filters applied
                if (statusFilter || planFilter || renewalDateFilter) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Filters Applied',
                        text: `Found ${filteredData.length} record(s)`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });

            // Export functionality
            $('#exportBtn').on('click', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Data Exported',
                    text: 'Renewal data has been exported successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            // Renew admission button click
            $(document).on('click', '.renew-admission', function() {
                const memberId = $(this).data('id');
                const memberName = $(this).data('name');
                const currentPlan = $(this).data('plan');
                const renewalDate = $(this).data('renewal');

                // Set modal content
                $('#memberName').text(memberName);
                $('#currentPlan').text(currentPlan);
                $('#renewalDate').text(formatDate(renewalDate));

                // Show modal
                $('#renewalModal').modal('show');
            });

            // Confirm renewal and redirect
            $('#confirmRenewal').on('click', function() {
                // Show loading state
                $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> Redirecting...');
                $(this).prop('disabled', true);

                // Redirect to the specified URL after a short delay
                setTimeout(function() {
                    window.location.href = 'http://localhost/Timers_Academy/superadmin/fNew_Admission';
                }, 1000);
            });

            // Reset modal state when hidden
            $('#renewalModal').on('hidden.bs.modal', function() {
                $('#confirmRenewal').html('Proceed to Renewal');
                $('#confirmRenewal').prop('disabled', false);
            });

            // Clear filters functionality
            function clearFilters() {
                $('#statusFilter').val('');
                $('#planFilter').val('');
                $('#renewalDateFilter').val('');
                populateTable(renewalsData);
            }

            // Add clear filters button if needed
            function addClearFiltersButton() {
                const clearBtn = $('<button>')
                    .addClass('btn btn-outline-secondary btn-sm ml-2')
                    .html('<i class="fas fa-times mr-1"></i> Clear')
                    .on('click', clearFilters);

                $('#applyFilters').after(clearBtn);
            }

            // Initialize the page
            initializePage();
        });
    </script>
</body>

</html>