<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Venue Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            /* requested theme variables */
            --accent: #ff4040;
            --accent-dark: #470000;
            --muted: #f4f6f8;
            --grad: linear-gradient(135deg, var(--accent), var(--accent-dark));

            /* map old variables to keep compatibility */
            --primary-gradient: var(--grad);
            --secondary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --accent-color: var(--accent);
            --light-accent: rgba(255, 64, 64, 0.08);
            --dark-bg: #1a1d29;
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
            --border-radius: 12px;
            --transition: all 0.22s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        body {
            background: var(--muted);
            color: #111;
            overflow-x: hidden;
            font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Helvetica, Arial;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }



        /* Card thumbnail and headline tweaks */
        .venue-thumb {
            height: 80px;
            background: linear-gradient(90deg, rgba(255, 64, 64, 0.12), rgba(71, 0, 0, 0.08));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-dark);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .venue-title {
            font-weight: 700;
            color: var(--accent-dark);
        }

        .sidebar {
            position: relative;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: var(--dark-bg);
            color: white;
            padding-top: 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .sidebar.minimized {
            width: 70px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            color: white;
            padding: 15px 25px;
            transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 999;
        }

        .navbar.sidebar-minimized {
            left: 70px;
        }

        .content-wrapper {
            margin-left: 280px;
            padding: 10px 30px 30px 30px !important;
            transition: margin-left 0.3s ease-in-out;
            min-height: 100vh;
        }

        .content-wrapper.minimized {
            margin-left: 70px;
        }

        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: var(--border-radius);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .card-header {
            background: var(--primary-gradient) !important;
            color: #fff !important;
            border-top-left-radius: var(--border-radius) !important;
            border-top-right-radius: var(--border-radius) !important;
            padding: 15px 20px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e1e5eb;
            padding: 10px 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 64, 64, 0.25);
        }

        .form-control.is-invalid {
            border-color: var(--accent-color);
        }

        .invalid-feedback {
            color: var(--accent-color);
            font-weight: 500;
        }

        label {
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: var(--transition);
        }

        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            box-shadow: 0 4px 15px rgba(255, 64, 64, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(255, 64, 64, 0.4);
        }

        .btn-outline-primary {
            color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        /* Make all Font Awesome icons red */
        i.fas,
        i.far,
        i.fab {
            color: var(--accent-color) !important;
        }

        /* Keep trash icons their default color */
        .btn .fa-trash {
            color: inherit !important;
        }

        .court-slot-block {
            border: 2px solid var(--accent-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(255, 64, 64, 0.15);
            transition: var(--transition);
            flex: 1 1 22%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .court-slot-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .court-slot-block:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(255, 64, 64, 0.25);
            border-color: #ff0000;
        }

        .court-slot-block h5 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--accent-color);
        }

        .court-slot-block h5 small {
            color: #666;
            font-weight: 500;
        }

        .court-slot-block p {
            font-size: 0.95rem;
            color: #444;
            margin-bottom: 5px;
        }

        /* Container Flexbox */
        #courtSlotsView,
        #facilityPreview,
        #slotPreview,
        #planPreview {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Slot boxes */
        .slot-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .slot-box {
            min-width: 90px;
            padding: 8px 15px;
            border-radius: 8px;
            background: linear-gradient(135deg, #e6ffe6, #ccffcc);
            border: 1px solid #28a745;
            font-size: 0.9rem;
            color: #2c3e50;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .slot-box:hover {
            background: linear-gradient(135deg, #ccffcc, #b2f2b2);
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Venue Cards */
        .venue-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            margin-bottom: 25px;
            overflow: hidden;
            position: relative;
            border: 2px solid red;
        }

        .venue-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
        }

        .venue-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="70" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="20" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>') no-repeat center;
            opacity: 0.3;
            pointer-events: none;
        }

        .venue-card-header {
            background: white;
            color: red;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            padding: 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid red;
        }

        .venue-card-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            animation: float 20s infinite linear;
            pointer-events: none;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(-20px, -20px);
            }
        }

        .venue-card-body {
            padding: 20px;
            background: #fff;
        }

        .venue-card-footer {
            background-color: #f8f9fa;
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
            padding: 15px 20px;
        }

        /* Status Badge */
        .status-badge {
            position: absolute;
            top: 15px;
            right: 3px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Enhanced Button Hover Effects */
        .venue-card-footer .btn {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
        }

        .venue-card-footer .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .venue-card-footer .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .venue-card-footer .btn-success:hover {
            background: linear-gradient(135deg, #28a745, #20c997);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .venue-card-footer .btn-info:hover {
            background: linear-gradient(135deg, #17a2b8, #138496);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
        }

        .venue-card-footer .btn-danger:hover {
            background: linear-gradient(135deg, #dc3545, #c82333);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        /* Modal Animations */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: translate(0, -50px);
        }

        .modal.show .modal-dialog {
            transform: translate(0, 0);
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
        }

        /* Enhanced Visual Indicators */
        .venue-stat {
            display: inline-flex;
            align-items: center;
            background: var(--light-accent);
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin-right: 8px;
            margin-bottom: 4px;
        }

        .venue-stat i {
            margin-right: 4px;
            color: var(--accent-color);
        }

        /* Modal styling */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .modal-header {

            color: white;
            border-top-left-radius: var(--border-radius);
            border-top-right-radius: var(--border-radius);
            padding: 20px;
        }

        .modal-body {
            padding: 25px;
            background-color: #f9fafc;
        }

        .modal-footer {
            border-bottom-left-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
            padding: 15px 25px;
            background-color: #fff;
        }

        /* Form sections */
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .form-section h5 {
            color: var(--accent-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-accent);
            font-weight: 700;
        }

        /* Preview sections */
        .preview-section {
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .preview-section h6 {
            color: var(--accent-color);
            margin-bottom: 15px;
            font-weight: 700;
        }

        /* Plan items */
        .plan-item {
            border: 1px solid #e1e5eb !important;
            border-radius: var(--border-radius) !important;
            padding: 20px !important;
            background: #fff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
            transition: var(--transition);
            margin-bottom: 20px !important;
        }

        .plan-item:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
            transform: translateY(-3px);
        }

        /* Installment styling */
        .installment-amount-container {
            background: var(--light-accent);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .court-slot-block {
                flex: 1 1 30%;
            }
        }

        @media (max-width: 992px) {
            .court-slot-block {
                flex: 1 1 45%;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
                padding: 100px 15px 15px 15px;
            }

            .court-slot-block {
                flex: 1 1 100%;
            }

            .modal-dialog {
                margin: 20px auto;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 90px 10px 10px 10px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
        }

        /* Animation for new elements */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .venue-card,
        .court-slot-block,
        .plan-item {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #c1c1c1ff;
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Badge styling */
        .badge-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Status indicators */
        .status-active {
            display: inline-block;
            width: 10px;
            height: 10px;
            background: #00b894;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-inactive {
            display: inline-block;
            width: 10px;
            height: 10px;
            background: #dfe6e9;
            border-radius: 50%;
            margin-right: 5px;
        }

        .view-venue i,
        .edit-venue i {
            color: white !important;
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
            <!-- Add Venue Button -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-building mr-2"></i> Venue Management</h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#venueModal">
                    <i class="fas fa-plus mr-2"></i> Add New Center
                </button>
            </div>

            <!-- Venue Cards Display -->
            <div id="venueCardsContainer" class="row">
                <!-- Venue cards will be dynamically added here -->
            </div>

            <!-- Venue Modal -->
            <div class="modal fade" id="venueModal" tabindex="-1" role="dialog" aria-labelledby="venueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="venueModalLabel"><i class="fas fa-building mr-2"></i> Add New Center</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>


                            <span aria-hidden="true">&times;</span>
                        </div>
                        <div class="modal-body">
                            <form id="venueForm">
                                <!-- Venue Details -->
                                <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Venue Details</h5>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Venue Name </label>
                                        <input type="text" class="form-control" id="venueName" placeholder="Enter Venue Name" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Location </label>
                                        <input type="text" class="form-control" id="venueLocation" placeholder="Enter Location" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Password</label>
                                        <input type="text" class="form-control" id="password" placeholder="Enter Password" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Number of Courts <span class="text-danger">*</span></label>
                                        <input type="number" id="numCourts" class="form-control" placeholder="e.g. 3" min="1" required>
                                    </div>
                                </div>

                                <!-- Court Details Container -->
                                <div id="courtDetailsContainer"></div>

                                <div id="courtSlotsView" class="mt-4">
                                    <!-- Dynamically generated court slot views will appear here -->
                                </div>

                                <hr>

                                <!-- Facilities / Amenities -->
                                <h5 class="mb-3"><i class="fas fa-dumbbell mr-2 text-primary"></i>Facilities / Amenities</h5>
                                <div id="facilityContainer">
                                    <div class="form-row facility-item mb-2">
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control" placeholder="Facility Name">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="text" class="form-control" placeholder="Type">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input type="number" class="form-control" placeholder="Rent">
                                        </div>
                                        <div class="form-group col-md-1 text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-facility"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="addFacility" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Facility</button>

                                <div id="facilityPreview" class="mt-3"></div>

                                <hr>

                                <!-- Slot Management -->
                                <h5 class="mb-3"><i class="fas fa-clock mr-2 text-primary"></i>Add Slots</h5>
                                <div id="slotContainer">
                                    <div class="form-row slot-item mb-2">
                                        <div class="form-group col-md-4">
                                            <label>From</label>
                                            <input type="time" class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>To</label>
                                            <input type="time" class="form-control">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Category/Name</label>
                                            <input type="text" class="form-control" placeholder="e.g. Morning Slot">
                                        </div>
                                        <div class="form-group col-md-1 text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-slot mt-4"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="addSlot" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Slot</button>

                                <div id="slotPreview" class="mt-3"></div>
                                <hr>

                                <h5 class="mb-3"><i class="fas fa-tags mr-2 text-primary"></i>Pricing / Membership Plans</h5>
                                <div id="planContainer">
                                    <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
                                        <!-- Row 1: Name, Duration, Period, Slot -->
                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label>MembershipName </label>
                                                <input type="text" class="form-control" placeholder="Membership Name">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Duration</label>
                                                <input type="number" class="form-control" placeholder="Duration">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Period</label>
                                                <select class="form-control">
                                                    <option selected disabled>Select Period</option>
                                                    <option>Week</option>
                                                    <option>Month</option>
                                                    <option>Year</option>
                                                </select>
                                            </div>
                                            <!-- <div class="form-group col-md-3">
                                                <label>Slot</label>
                                                <input type="text" class="form-control" placeholder="Enter Slot">
                                            </div> -->

                                            <div class="form-group col-md-2 text-center align-self-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-plan">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Row 2: Registration Fees, Coaching Fees -->
                                        <div class="form-row mt-2">
                                            <div class="form-group col-md-3">
                                                <label>Registration Fees</label>
                                                <input type="number" class="form-control" placeholder="Registration Fees">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Coaching Fees</label>
                                                <input type="number" class="form-control" placeholder="Coaching Fees">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Total Fees</label>
                                                <input type="number" class="form-control" placeholder="Total Fees" readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Number of Installments</label>
                                                <input type="number" class="form-control installment-count" placeholder="Number of Installments">
                                            </div>


                                        </div>
                                        <div class="installment-amount-container mt-2"></div>

                                    </div>
                                </div>

                                <button type="button" id="addPlan" class="btn btn-outline-primary btn-sm mb-3">
                                    <i class="fas fa-plus"></i> Add Plan
                                </button>

                                <div id="planPreview" class="mt-3"></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button></button>

                            <button type="button" class="btn btn-primary" id="saveVenue">Save Center</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Venue Modal -->
    <div class="modal fade" id="viewVenueModal" tabindex="-1" role="dialog" aria-labelledby="viewVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewVenueModalLabel"><i class="fas fa-eye mr-2"></i> View Venue Details</h5>
                    <button type="button" class="close text-red" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="viewVenueContent">
                        <!-- Venue details will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="viewDashboard">Dashboard</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Venue Modal -->
    <div class="modal fade" id="editVenueModal" tabindex="-1" role="dialog" aria-labelledby="editVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVenueModalLabel"><i class="fas fa-edit mr-2"></i> Edit Center</h5>
                    <button type="button" class="close text-red" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form id="editVenueForm">
                        <input type="hidden" id="editVenueId">
                        <!-- Venue Details -->
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Venue Details</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Venue Name </label>
                                <input type="text" class="form-control" id="editVenueName" placeholder="Enter Venue Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Location</label>
                                <input type="text" class="form-control" id="editVenueLocation" placeholder="Enter Location" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Password</label>
                                <input type="text" class="form-control" id="password" placeholder="Enter Password" required>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Number of Courts <span class="text-danger">*</span></label>
                                <input type="number" id="editNumCourts" class="form-control" placeholder="e.g. 3" min="1" required>
                            </div>
                        </div>

                        <!-- Court Details Container -->
                        <div id="editCourtDetailsContainer"></div>

                        <div id="editCourtSlotsView" class="mt-4">
                            <!-- Dynamically generated court slot views will appear here -->
                        </div>

                        <hr>

                        <!-- Facilities / Amenities -->
                        <h5 class="mb-3"><i class="fas fa-dumbbell mr-2 text-primary"></i>Facilities / Amenities</h5>
                        <div id="editFacilityContainer">
                            <!-- Facilities will be dynamically added here -->
                        </div>
                        <button type="button" id="editAddFacility" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Facility</button>

                        <div id="editFacilityPreview" class="mt-3"></div>

                        <hr>

                        <!-- Slot Management -->
                        <h5 class="mb-3"><i class="fas fa-clock mr-2 text-primary"></i>Add Slots</h5>
                        <div id="editSlotContainer">
                            <!-- Slots will be dynamically added here -->
                        </div>
                        <button type="button" id="editAddSlot" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Slot</button>

                        <div id="editSlotPreview" class="mt-3"></div>
                        <hr>

                        <h5 class="mb-3"><i class="fas fa-tags mr-2 text-primary"></i>Pricing / Membership Plans</h5>
                        <div id="editPlanContainer">
                            <!-- Plans will be dynamically added here -->
                        </div>
                        <button type="button" id="editAddPlan" class="btn btn-outline-primary btn-sm mb-3">
                            <i class="fas fa-plus"></i> Add Plan
                        </button>

                        <div id="editPlanPreview" class="mt-3"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>



                    <button type="button" class="btn btn-primary" id="updateVenue">Update Center</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var base_url = "<?php echo base_url(); ?>";
    </script>

    <script>
        // Sample data for demonstration
        let venues = [{
                id: 1,
                name: "ABC Sports Arena",
                location: "Pune",
                courts: 4,
                facilities: ["Badminton", "Gym"],
                slots: ["6:00 AM - 9:00 AM", "4:00 PM - 7:00 PM"],
                plans: [{
                        planType: "Monthly",
                        fields: {
                            membershipName: "",
                            duration: "",
                            period: "",
                            slot: "",
                            registrationFees: 0,
                            coachingFees: 0,
                            totalFees: 0
                        }
                    },
                    {
                        planType: "Yearly",
                        fields: {
                            membershipName: "abc",
                            duration: "3 month",
                            period: "2 month",
                            slot: "3 month",
                            registrationFees: 400,
                            coachingFees: 1000,
                            totalFees: 1400
                        }
                    }
                ]
            },
            {
                id: 2,
                name: "XYZ Fitness Center",
                location: "Mumbai",
                courts: 3,
                facilities: ["Swimming Pool", "Squash"],
                slots: ["7:00 AM - 10:00 AM", "5:00 PM - 8:00 PM"],
                plans: [{
                        planType: "Weekly",
                        fields: {
                            membershipName: "",
                            duration: "",
                            period: "",
                            slot: "",
                            registrationFees: 0,
                            coachingFees: 0,
                            totalFees: 0
                        }
                    },
                    {
                        planType: "Monthly",
                        fields: {
                            membershipName: "",
                            duration: "",
                            period: "",
                            slot: "",
                            registrationFees: 0,
                            coachingFees: 0,
                            totalFees: 0
                        }
                    }
                ]
            }
        ];

        // Function to display venue cards
        function displayVenueCards() {
            const container = $('#venueCardsContainer');
            container.html('<div class="col-12 text-center py-5"><h5>Loading venues...</h5></div>');

            $.ajax({
                url: base_url + 'venue/getAll',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    container.empty();

                    if (response.status !== 'success' || !response.data || response.data.length === 0) {
                        container.html('<div class="col-12 text-center py-5"><h5>No venues added yet. Click "Add New Center" to get started.</h5></div>');
                        return;
                    }

                    response.data.forEach(venue => {
                        const facilitiesCount = venue.facilities ? venue.facilities.length : 0;
                        const slotsCount = venue.slots ? venue.slots.length : 0;
                        const plansCount = venue.plans ? venue.plans.length : 0;
                        const courtsCount = venue.courts ? venue.courts.length : 0;

                        const card = $(`
                    <div class="col-md-6 col-lg-4">
                        <div class="venue-card">
                            <div class="venue-card-header">
                                <div class="status-badge">Active</div>
                                <h5 class="mb-0">${venue.venue_name}</h5>
                                <p class="mb-0"><i class="fas fa-map-marker-alt mr-1"></i> ${venue.location}</p>
                            </div>
                            <div class="venue-card-body">
                                <div class="venue-stat"><i class="fas fa-gavel"></i> ${courtsCount} Courts</div>
                                <div class="venue-stat"><i class="fas fa-dumbbell"></i> ${facilitiesCount} Facilities</div>
                                <div class="venue-stat"><i class="fas fa-clock"></i> ${slotsCount} Slots</div>
                                <div class="venue-stat"><i class="fas fa-tags"></i> ${plansCount} Plans</div>
                            </div>
                            <div class="venue-card-footer d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm mr-2 view-venue" data-id="${venue.id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-danger btn-sm mr-2 edit-venue" data-id="${venue.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-venue" data-id="${venue.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `);
                        container.append(card);
                    });
                },
                error: function() {
                    container.html('<div class="col-12 text-center py-5"><h5>Error loading venues. Please try again later.</h5></div>');
                }
            });
        }
        // Handle Delete Venue
        $(document).on('click', '.delete-venue', function() {
            const venueId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the venue and all its related data (courts, facilities, slots, and plans).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: base_url + 'venue/delete/' + venueId,
                        method: 'POST',
                        success: function(response) {
                            const res = JSON.parse(response);
                            if (res.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Venue deleted successfully.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                displayVenueCards(); // Refresh the venue list dynamically
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: res.message || 'Failed to delete venue.'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Server Error',
                                text: 'Unable to delete venue. Please try again.'
                            });
                        }
                    });
                }
            });
        });


        // Initialize venue cards display
        displayVenueCards();

        // Form functionality
        // Add Facility
        $('#addFacility').on('click', function() {
            $('#facilityContainer').append(`
                <div class="form-row facility-item mb-2">
                    <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Facility Name"></div>
                    <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Type"></div>
                    <div class="form-group col-md-3"><input type="number" class="form-control" placeholder="Rent"></div>
                    <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-facility"><i class="fas fa-trash"></i></button></div>
                </div>
            `);
            renderFacilityPreview();
        });

        // Remove Facility
        $(document).on('click', '.remove-facility', function() {
            let row = $(this).closest('.facility-item');
            Swal.fire({
                title: 'Are you sure?',
                text: "This facility will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    renderFacilityPreview();
                    Swal.fire('Deleted!', 'Facility has been removed.', 'success');
                }
            });
        });

        // Add Slot
        $('#addSlot').on('click', function() {
            $('#slotContainer').append(`
                <div class="form-row slot-item mb-2">
                    <div class="form-group col-md-4"><label>From</label><input type="time" class="form-control"></div>
                    <div class="form-group col-md-4"><label>To</label><input type="time" class="form-control"></div>
                    <div class="form-group col-md-3"><label>Category/Name</label><input type="text" class="form-control"></div>
                    <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-slot mt-4"><i class="fas fa-trash"></i></button></div>
                </div>
            `);
            renderSlotPreview();
        });

        // Remove Slot
        $(document).on('click', '.remove-slot', function() {
            let row = $(this).closest('.slot-item');
            Swal.fire({
                title: 'Are you sure?',
                text: "This slot will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    renderSlotPreview();
                    Swal.fire('Deleted!', 'Slot has been removed.', 'success');
                }
            });
        });

        // Add Plan
        $('#addPlan').on('click', function() {
            $('#planContainer').append(`
                <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                        <label>Membership plan</label>
                            <input type="text" class="form-control" placeholder="Membership Name">
                        </div>
                        <div class="form-group col-md-2">
                        <label>Duration</label>
                            <input type="number" class="form-control" placeholder="Duration">
                        </div>
                        <div class="form-group col-md-2">
                        <label>Period</label>
                            <select class="form-control">
                                <option selected disabled>Select Period</option>
                                <option>Week</option>
                                <option>Month</option>
                                <option>Year</option>
                            </select>
                        </div>
                       <div class="form-group col-md-3">
                        <label>Slot</label>
    <input type="text" class="form-control" placeholder="Enter Slot">
</div>

                        <div class="form-group col-md-2 text-center align-self-end">
                            <button type="button" class="btn btn-danger btn-sm remove-plan">
                                <i class="fas fa-trash"></i> 
                            </button>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-md-3">
                            <input type="number" class="form-control" placeholder="Registration Fees">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Coaching Fees</label>
                            <input type="number" class="form-control" placeholder="Coaching Fees">
                        </div>
                        <div class="form-group col-md-3">
                        <label>Total Fees</label>
                            <input type="number" class="form-control" placeholder="Total Fees">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Number of Installments</label>
                                                <input type="number" class="form-control installment-count" placeholder="Number of Installments">
                                            </div>


                                        </div>
                                        <div class="installment-amount-container mt-2"></div>
                    </div>
                </div>
            `);
            renderPlanPreview();
        });

        // Remove Plan
        $(document).on('click', '.remove-plan', function() {
            let row = $(this).closest('.plan-item');
            Swal.fire({
                title: 'Are you sure?',
                text: "This plan will be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    renderPlanPreview();
                    Swal.fire('Deleted!', 'Plan has been removed.', 'success');
                }
            });
        });

        // Generate court details based on number of courts
        $('#numCourts').on('input', function() {
            let num = parseInt($(this).val()) || 0;
            let container = $('#courtDetailsContainer');
            container.empty(); // Clear previous inputs

            for (let i = 1; i <= num; i++) {
                container.append(`
                    <div class="form-row mb-2 court-item">
    <div class="form-group col-md-6">
        <label>Court ${i} Name</label>
        <input type="text" name="court_name[]" class="form-control" placeholder="Enter Court ${i} Name">
    </div>
    <div class="form-group col-md-6">
        <label>Court ${i} Category</label>
        <input type="text" name="court_type[]" class="form-control" placeholder="Enter Court ${i} Category">
    </div>
</div>

                `);
            }
        });

        // Save venue
        // Save venue - Fixed version
        $('#saveVenue').on('click', function() {
            const venueName = $('#venueName').val();
            const venueLocation = $('#venueLocation').val();
            const password = $('#password').val();
            const numCourts = $('#numCourts').val();

            if (!venueName || !venueLocation || !password || !numCourts) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Information',
                    text: 'Please fill in all required fields.',
                    confirmButtonColor: '#ff4040'
                });
                return;
            }

            // ✅ Collect court details
            const courts = [];
            $('#courtDetailsContainer .court-item').each(function(index) {
                const courtName = $(this).find('input[name="court_name[]"]').val();
                const courtType = $(this).find('input[name="court_type[]"]').val();

                if (courtName) {
                    courts.push({
                        court_name: courtName,
                        court_type: courtType,
                    });
                }
            });

            // ✅ Collect facilities
            const facilities = [];
            $('#facilityContainer .facility-item').each(function() {
                const name = $(this).find('input').eq(0).val();
                const type = $(this).find('input').eq(1).val();
                const rent = $(this).find('input').eq(2).val();
                if (name) {
                    facilities.push({
                        facility_name: name,
                        facility_type: type,
                        rent: rent
                    });
                }
            });

            // ✅ Collect slots
            const slots = [];
            $('#slotContainer .slot-item').each(function() {
                const fromTime = $(this).find('input[type="time"]').eq(0).val();
                const toTime = $(this).find('input[type="time"]').eq(1).val();
                const slotName = $(this).find('input[type="text"]').eq(0).val();
                if (fromTime && toTime) {
                    slots.push({
                        from_time: fromTime,
                        to_time: toTime,
                        slot_name: slotName
                    });
                }
            });

            // ✅ Collect plans
            const plans = [];
            $('#planContainer .plan-item').each(function() {
                const membershipName = $(this).find('input').eq(0).val();
                const duration = $(this).find('input').eq(1).val();
                const period = $(this).find('select').val();
                const slot = $(this).find('input').eq(3).val();
                const registration = $(this).find('input').eq(4).val();
                const coaching = $(this).find('input').eq(5).val();
                const total = $(this).find('input').eq(6).val();
                const installments = $(this).find('input').eq(7).val();

                if (membershipName) {
                    plans.push({
                        membership_name: membershipName,
                        duration: duration,
                        period: period,
                        slot: slot,
                        registration_fees: registration,
                        coaching_fees: coaching,
                        total_fees: total,
                        installments: installments
                    });
                }
            });

            // ✅ Prepare data to send
            const venueData = {
                venue_name: venueName,
                location: venueLocation,
                password: password,
                num_courts: numCourts,
                courts: courts,
                facilities: facilities,
                slots: slots,
                plans: plans
            };

            // Show loading state
            const saveButton = $('#saveVenue');
            const originalText = saveButton.html();
            saveButton.html('<i class="fas fa-spinner fa-spin mr-2"></i> Saving...').prop('disabled', true);

            console.log('Sending data:', venueData); // Debug log

            // ✅ AJAX request - Fixed version
            $.ajax({
                url: base_url + 'venue/save',
                method: 'POST',
                data: venueData, // Changed from JSON.stringify to regular form data
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    // Restore button state
                    saveButton.html(originalText).prop('disabled', false);

                    console.log('Response received:', response); // Debug log

                    // No need to parse response since dataType: 'json' handles it
                    if (response.status === 'success') {
                        // SweetAlert Success Notification
                        Swal.fire({
                            icon: 'success',
                            title: 'Center Added Successfully!',
                            text: 'The new center has been added to the system.',
                            confirmButtonText: 'Great!',
                            confirmButtonColor: '#ff4040',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        }).then((result) => {
                            // Reset form and close modal
                            $('#venueForm')[0].reset();
                            $('#venueModal').modal('hide');
                            $('#courtDetailsContainer').empty();
                            $('#facilityContainer').empty();
                            $('#slotContainer').empty();
                            $('#planContainer').empty();

                            // Refresh venue cards display
                            displayVenueCards();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Failed to save venue.',
                            confirmButtonColor: '#ff4040'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Restore button state
                    saveButton.html(originalText).prop('disabled', false);

                    console.error('AJAX Error:', status, error); // Debug log

                    let errorMessage = 'Could not connect to backend. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            const parsedResponse = JSON.parse(xhr.responseText);
                            errorMessage = parsedResponse.message || errorMessage;
                        } catch (e) {
                            errorMessage = xhr.responseText || errorMessage;
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: errorMessage,
                        confirmButtonColor: '#ff4040'
                    });
                }
            });
        });
        // Delete venue
        // Helper functions
        function formatTime(time) {
            if (!time) return '';
            let [h, m] = time.split(':');
            h = parseInt(h);
            const ampm = h >= 12 ? 'PM' : 'AM';
            h = h % 12 || 12;
            return `${("0"+h).slice(-2)}:${m} ${ampm}`;
        }

        function renderCourtSlots() {
            const courts = [];
            $('#courtDetailsContainer .court-item').each(function() {
                const courtName = $(this).find('input').eq(0).val();
                const courtCategory = $(this).find('input').eq(1).val();
                if (courtName) {
                    courts.push({
                        name: courtName,
                        category: courtCategory
                    });
                }
            });

            const slots = [];
            $('#slotContainer .slot-item').each(function() {
                const fromTime = $(this).find('input[type="time"]').eq(0).val();
                const toTime = $(this).find('input[type="time"]').eq(1).val();
                const slotName = $(this).find('input[type="text"]').val();
                if (fromTime && toTime) {
                    slots.push({
                        from: fromTime,
                        to: toTime,
                        name: slotName
                    });
                }
            });

            const container = $('#courtSlotsView');
            container.empty();

            courts.forEach(court => {
                const courtDiv = $(`
                    <div class="court-slot-block mb-3">
                        <h5>${court.name} - <small>${court.category}</small></h5>
                        <div class="slot-grid"></div>
                    </div>
                `);

                slots.forEach(slot => {
                    const slotBox = $(`
                        <div class="slot-box">
                            ${formatTime(slot.from)} - ${formatTime(slot.to)}<br><small>${slot.name}</small>
                        </div>
                    `);
                    courtDiv.find('.slot-grid').append(slotBox);
                });

                container.append(courtDiv);
            });
        }

        function renderFacilityPreview() {
            const container = $('#facilityPreview');
            container.empty();

            $('#facilityContainer .facility-item').each(function() {
                const name = $(this).find('input').eq(0).val();
                const type = $(this).find('input').eq(1).val();
                const rent = $(this).find('input').eq(2).val();

                if (name) {
                    const div = $(`
                        <div class="court-slot-block mb-2">
                            <h5>${name} - <small>${type}</small></h5>
                            <p>Rent: ₹${rent || 0}</p>
                        </div>
                    `);
                    container.append(div);
                }
            });
        }

        function renderSlotPreview() {
            const container = $('#slotPreview');
            container.empty();

            $('#slotContainer .slot-item').each(function() {
                const from = $(this).find('input[type="time"]').eq(0).val();
                const to = $(this).find('input[type="time"]').eq(1).val();
                const name = $(this).find('input[type="text"]').val();

                if (from && to) {
                    const div = $(`
                        <div class="court-slot-block mb-2">
                            <h5>${name || 'Slot'}</h5>
                            <p>${formatTime(from)} - ${formatTime(to)}</p>
                        </div>
                    `);
                    container.append(div);
                }
            });
        }

        // function renderPlanPreview() {
        //     const container = $('#planPreview');
        //     container.empty();

        //     $('#planContainer .plan-item').each(function() {
        //         const membershipName = $(this).find('input').eq(0).val();
        //         const duration = $(this).find('input').eq(1).val();
        //         const period = $(this).find('select').eq(0).val();
        //         const slot = $(this).find('select').eq(1).val();
        //         const regFee = $(this).find('input').eq(2).val();
        //         const coachingFee = $(this).find('input').eq(3).val();

        //         if (membershipName && duration && period) {
        //             const div = $(`
        //                 <div class="court-slot-block mb-2">
        //                     <h5>${membershipName} - ${duration} ${period} <small>${slot || ''}</small></h5>
        //                     <p>Registration: ₹${regFee || 0}, Coaching: ₹${coachingFee || 0}</p>
        //                 </div>
        //             `);
        //             container.append(div);
        //         }
        //     });
        // }
        function renderPlanPreview() {
            const container = $('#planPreview');
            container.empty();

            $('#planContainer .plan-item').each(function() {
                const membershipName = $(this).find('input').eq(0).val();
                const duration = $(this).find('input').eq(1).val();
                const period = $(this).find('select').eq(0).val();
                const slot = $(this).find('input').eq(3).val() || ''; // Correct slot input
                const regFee = parseFloat($(this).find('input').eq(3).val()) || 0;
                // const coachingFee = parseFloat($(this).find('input').eq(3).val()) || 0;
                const coachingFee = parseFloat($(this).find('input').eq(4).val()) || 0;
                const totalFeeInput = parseFloat($(this).find('input').eq(4).val()) || 0;

                // Correct totalFee calculation
                const totalFee = (regFee + coachingFee);

                if (membershipName && duration && period) {
                    const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${membershipName} - ${duration} ${period} <small>${slot}</small></h5>
                    <p>Registration: ₹${regFee}, Coaching: ₹${coachingFee}, <strong>Total: ₹${totalFee}</strong></p>
                </div>
            `);
                    container.append(div);
                }
            });
        }



        // Update previews when user types in inputs
        $(document).on('input change', '#facilityContainer input', renderFacilityPreview);
        $(document).on('input change', '#slotContainer input', renderSlotPreview);
        $(document).on('change', '#planContainer input, #planContainer select', renderPlanPreview);

        // Update previews when adding/removing items
        $('#addFacility, #addSlot, #addPlan').on('click', function() {
            renderFacilityPreview();
            renderSlotPreview();
            renderPlanPreview();
        });

        $(document).on('click', '.remove-facility, .remove-slot, .remove-plan', function() {
            renderFacilityPreview();
            renderSlotPreview();
            renderPlanPreview();
        });

        // Update court slots when court details change
        $(document).on('input', '#courtDetailsContainer input', function() {
            renderCourtSlots();
        });
    </script>
    <script>
        // Universal modal close handler
        // This ensures any close control (data-dismiss, data-bs-dismiss, or .close) will reliably hide its modal.
        (function($) {
            // Use event delegation to catch future elements too
            $(document).on('click', '[data-dismiss], [data-bs-dismiss], .close', function(e) {
                // Allow native behavior for links if they have href and are not intended to close modal
                try {
                    e.preventDefault();
                } catch (err) {}

                var $el = $(this);

                // Find the closest modal element
                var $modal = $el.closest('.modal');

                // If the button references a target, attempt to find that modal
                if (!$modal.length) {
                    var target = $el.attr('data-target') || $el.attr('data-bs-target');
                    if (target) {
                        // data-target can be a selector
                        try {
                            $modal = $(target);
                        } catch (err) {
                            $modal = $();
                        }
                    }
                }

                if (!$modal || !$modal.length) return;

                // Try Bootstrap 4 jQuery modal hide first (if available)
                try {
                    if (typeof $modal.modal === 'function') {
                        $modal.modal('hide');
                        return;
                    }
                } catch (err) {
                    // ignore and try BS5
                }

                // Try Bootstrap 5 Modal JS API if present
                try {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        var modalEl = $modal.get(0);
                        var instance = bootstrap.Modal.getInstance(modalEl);
                        if (!instance) instance = new bootstrap.Modal(modalEl);
                        instance.hide();
                        return;
                    }
                } catch (err) {
                    // ignore and fallback
                }

                // Fallback: remove show class and hide modal/backdrop manually
                try {
                    $modal.removeClass('show').css('display', 'none').attr('aria-hidden', 'true').attr('aria-modal', 'false');
                    // remove any backdrop(s) and restore body state
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                } catch (err) {
                    // nothing else we can do
                }
            });
        })(jQuery);
    </script>
    <script>
        // Edit venue functionality
        $(document).on('click', '.edit-venue', function() {
            const venueId = $(this).data('id');
            const venue = venues.find(v => v.id === venueId);

            if (venue) {
                // Populate basic venue info
                $('#editVenueId').val(venue.id);
                $('#editVenueName').val(venue.name);
                $('#editVenueLocation').val(venue.location);
                $('#editNumCourts').val(venue.courts);

                // Generate court details
                generateEditCourtDetails(venue.courts);

                // Populate facilities
                populateEditFacilities(venue.facilities || []);

                // Populate slots
                populateEditSlots(venue.slots || []);

                // Populate plans
                populateEditPlans(venue.plans || []);

                // Show modal
                $('#editVenueModal').modal('show');
            }
        });

        // Generate court details for edit
        function generateEditCourtDetails(numCourts) {
            const container = $('#editCourtDetailsContainer');
            container.empty();

            for (let i = 1; i <= numCourts; i++) {
                container.append(`
            <div class="form-row mb-2 court-item">
                <div class="form-group col-md-6">
                    <label>Court ${i} Name</label>
                    <input type="text" class="form-control" placeholder="Enter Court ${i} Name">
                </div>
                <div class="form-group col-md-6">
                    <label>Court ${i} Category</label>
                    <input type="text" class="form-control" placeholder="Enter Court ${i} Category">
                </div>
            </div>
        `);
            }
        }

        // Populate facilities for edit
        function populateEditFacilities(facilities) {
            const container = $('#editFacilityContainer');
            container.empty();

            facilities.forEach((facility, index) => {
                container.append(`
            <div class="form-row facility-item mb-2">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" placeholder="Facility Name" value="${facility}">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" placeholder="Type">
                </div>
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" placeholder="Rent">
                </div>
                <div class="form-group col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-edit-facility">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
            });

            renderEditFacilityPreview();
        }

        // Populate slots for edit
        function populateEditSlots(slots) {
            const container = $('#editSlotContainer');
            container.empty();

            slots.forEach(slot => {
                const [fromTime, toTime] = slot.split(' - ');
                container.append(`
            <div class="form-row slot-item mb-2">
                <div class="form-group col-md-4">
                    <label>From</label>
                    <input type="time" class="form-control" value="${convertTo24Hour(fromTime)}">
                </div>
                <div class="form-group col-md-4">
                    <label>To</label>
                    <input type="time" class="form-control" value="${convertTo24Hour(toTime)}">
                </div>
                <div class="form-group col-md-3">
                    <label>Category/Name</label>
                    <input type="text" class="form-control" placeholder="e.g. Morning Slot">
                </div>
                <div class="form-group col-md-1 text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-edit-slot mt-4">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
            });

            renderEditSlotPreview();
        }

        // Populate plans for edit
        function populateEditPlans(plans) {
            const container = $('#editPlanContainer');
            container.empty();

            plans.forEach(plan => {
                container.append(`
            <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
                <div class="form-row">
                    <div class="form-group col-md-3">
                    <label>Membership plan</label>
                        <input type="text" class="form-control" placeholder="Membership Name" value="${plan}">
                    </div>
                    <div class="form-group col-md-2">
                    <label>Duration</label>
                        <input type="number" class="form-control" placeholder="Duration">
                    </div>
                    <div class="form-group col-md-2">
                    <label>Period</label>
                        <select class="form-control">
                            <option selected disabled>Select Period</option>
                            <option>Week</option>
                            <option>Month</option>
                            <option>Year</option>
                        </select>
                    </div>
                   <div class="form-group col-md-3">
                    <label>Slot</label>
    <input type="text" class="form-control" placeholder="Enter Slot">
</div>

                    <div class="form-group col-md-2 text-center align-self-end">
                        <button type="button" class="btn btn-danger btn-sm remove-edit-plan">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-3">
                    <label>Registration Fees</label>
                        <input type="number" class="form-control" placeholder="Registration Fees">
                    </div>
                    <div class="form-group col-md-3">
                    <label>Coaching Fees</label>
                        <input type="number" class="form-control" placeholder="Coaching Fees">
                    </div><div class="form-group col-md-3">
                    <label>Total Fees</label>
                        <input type="number" class="form-control" placeholder="Total Fees">
                    </div>
                    <div class="form-group col-md-3">
                    <label>Number of Installments</label>
                                                <input type="number" class="form-control installment-count" placeholder="Number of Installments">
                                            </div>
                                        </div>
                                        <div class="installment-amount-container mt-2"></div>
                </div>
            </div>
        `);
            });

            renderEditPlanPreview();
        }

        // Helper function to convert time to 24-hour format
        function convertTo24Hour(timeStr) {
            if (!timeStr) return '';
            const [time, modifier] = timeStr.split(' ');
            let [hours, minutes] = time.split(':');

            if (modifier === 'PM' && hours !== '12') {
                hours = parseInt(hours, 10) + 12;
            }
            if (modifier === 'AM' && hours === '12') {
                hours = '00';
            }

            return `${hours}:${minutes}`;
        }

        // Update venue
        $('#updateVenue').on('click', function() {
            const venueId = parseInt($('#editVenueId').val());
            const venueIndex = venues.findIndex(v => v.id === venueId);

            if (venueIndex === -1) return;

            // Basic validation
            const venueName = $('#editVenueName').val();
            const venueLocation = $('#editVenueLocation').val();

            if (!venueName || !venueLocation) {
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Information',
                    text: 'Please fill in all required fields.',
                });
                return;
            }

            // Collect facilities
            const facilities = [];
            $('#editFacilityContainer .facility-item').each(function() {
                const name = $(this).find('input').eq(0).val();
                if (name) {
                    facilities.push(name);
                }
            });

            // Collect slots
            const slots = [];
            $('#editSlotContainer .slot-item').each(function() {
                const fromTime = $(this).find('input[type="time"]').eq(0).val();
                const toTime = $(this).find('input[type="time"]').eq(1).val();
                if (fromTime && toTime) {
                    slots.push(`${formatTime(fromTime)} - ${formatTime(toTime)}`);
                }
            });

            // Collect plans
            const plans = [];
            $('#editPlanContainer .plan-item').each(function() {
                const membershipName = $(this).find('input').eq(0).val();
                if (membershipName) {
                    plans.push(membershipName);
                }
            });

            // Update venue object
            venues[venueIndex] = {
                ...venues[venueIndex],
                name: venueName,
                location: venueLocation,
                courts: parseInt($('#editNumCourts').val()) || 0,
                facilities: facilities,
                slots: slots,
                plans: plans
            };

            // Update display
            displayVenueCards();

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Venue has been updated successfully.',
                timer: 2000,
                showConfirmButton: false
            });

            // Close modal
            $('#editVenueModal').modal('hide');
        });

        // Add event listeners for edit modal
        $('#editAddFacility').on('click', function() {
            $('#editFacilityContainer').append(`
        <div class="form-row facility-item mb-2">
            <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Facility Name"></div>
            <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Type"></div>
            <div class="form-group col-md-3"><input type="number" class="form-control" placeholder="Rent"></div>
            <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-edit-facility"><i class="fas fa-trash"></i></button></div>
        </div>
    `);
            renderEditFacilityPreview();
        });

        $('#editAddSlot').on('click', function() {
            $('#editSlotContainer').append(`
        <div class="form-row slot-item mb-2">
            <div class="form-group col-md-4"><label>From</label><input type="time" class="form-control"></div>
            <div class="form-group col-md-4"><label>To</label><input type="time" class="form-control"></div>
            <div class="form-group col-md-3"><label>Category/Name</label><input type="text" class="form-control"></div>
            <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-edit-slot mt-4"><i class="fas fa-trash"></i></button></div>
        </div>
    `);
            renderEditSlotPreview();
        });

        $('#editAddPlan').on('click', function() {
            $('#editPlanContainer').append(`
        <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" placeholder="Membership Name">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" class="form-control" placeholder="Duration">
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control">
                        <option selected disabled>Select Period</option>
                        <option>Week</option>
                        <option>Month</option>
                        <option>Year</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
    <input type="text" class="form-control" placeholder="Enter Slot">
</div>

                <div class="form-group col-md-2 text-center align-self-end">
                    <button type="button" class="btn btn-danger btn-sm remove-edit-plan">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="form-row mt-2">
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" placeholder="Registration Fees">
                </div>
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" placeholder="Coaching Fees">
                </div>
                <div class="form-group col-md-3">
                        <input type="number" class="form-control" placeholder="Total Fees">
                    </div>
       <div class="installment-amount-container mt-2"></div>
            </div>
        </div>
    `);
            renderEditPlanPreview();
        });

        // Remove functionality for edit modal
        $(document).on('click', '.remove-edit-facility', function() {
            $(this).closest('.facility-item').remove();
            renderEditFacilityPreview();
        });

        $(document).on('click', '.remove-edit-slot', function() {
            $(this).closest('.slot-item').remove();
            renderEditSlotPreview();
        });

        $(document).on('click', '.remove-edit-plan', function() {
            $(this).closest('.plan-item').remove();
            renderEditPlanPreview();
        });

        // Preview rendering functions for edit modal
        function renderEditFacilityPreview() {
            const container = $('#editFacilityPreview');
            container.empty();

            $('#editFacilityContainer .facility-item').each(function() {
                const name = $(this).find('input').eq(0).val();
                const type = $(this).find('input').eq(1).val();
                const rent = $(this).find('input').eq(2).val();

                if (name) {
                    const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${name} - <small>${type}</small></h5>
                    <p>Rent: ₹${rent || 0}</p>
                </div>
            `);
                    container.append(div);
                }
            });
        }

        function renderEditSlotPreview() {
            const container = $('#editSlotPreview');
            container.empty();

            $('#editSlotContainer .slot-item').each(function() {
                const from = $(this).find('input[type="time"]').eq(0).val();
                const to = $(this).find('input[type="time"]').eq(1).val();
                const name = $(this).find('input[type="text"]').val();

                if (from && to) {
                    const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${name || 'Slot'}</h5>
                    <p>${formatTime(from)} - ${formatTime(to)}</p>
                </div>
            `);
                    container.append(div);
                }
            });
        }

        function renderEditPlanPreview() {
            const container = $('#editPlanPreview');
            container.empty();

            $('#editPlanContainer .plan-item').each(function() {
                const membershipName = $(this).find('input').eq(0).val();
                const duration = $(this).find('input').eq(1).val();
                const period = $(this).find('select').eq(0).val();
                const slot = $(this).find('select').eq(1).val();
                const regFee = $(this).find('input').eq(2).val();
                const coachingFee = $(this).find('input').eq(3).val();

                if (membershipName && duration && period) {
                    const div = $(`
                <div class="court-slot-block mb-3 p-2 border rounded bg-light">
                    <h5>${membershipName} - ${duration} ${period} <small>${slot || ''}</small></h5>
                    <p>Registration: ₹${regFee || 0}, Coaching: ₹${coachingFee || 0}</p>
                    <div class="installments-preview"></div>
                </div>
            `);

                    // Add installment details if any
                    $(this).find('.installment-amount').each(function(index) {
                        const amount = $(this).val() || 0;
                        const dueDate = $(this).closest('.form-row').find('.installment-due-date').val() || '';
                        const installmentDiv = $(`
                    <p>Installment ${index + 1}: ₹${amount} ${dueDate ? ' - Due: ' + dueDate : ''}</p>
                `);
                        div.find('.installments-preview').append(installmentDiv);
                    });

                    container.append(div);
                }
            });
        }

        // Update previews when user types in edit modal inputs
        $(document).on('input change', '#editFacilityContainer input', renderEditFacilityPreview);
        $(document).on('input change', '#editSlotContainer input', renderEditSlotPreview);
        $(document).on('change', '#editPlanContainer input, #editPlanContainer select', renderEditPlanPreview);
    </script>
    <script>
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('installment-count')) {
                const count = parseInt(e.target.value);
                const container = e.target.closest('.plan-item').querySelector('.installment-amount-container');
                container.innerHTML = ''; // clear old fields

                if (!isNaN(count) && count > 0) {
                    for (let i = 1; i <= count; i++) {
                        const div = document.createElement('div');
                        div.classList.add('form-row', 'mb-2');

                        div.innerHTML = `
                    <div class="form-group col-md-3">
                        <label>Installment ${i} Amount</label>
                        <input type="number" class="form-control installment-amount" placeholder="Enter installment amount ${i}">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Next Due Date ${i}</label>
                        <input type="date" class="form-control installment-due-date">
                    </div>
                `;

                        container.appendChild(div);
                    }
                }
            }
        });
    </script>
    <script>
        // View venue functionality
        let currentVenue = null; // Store current venue data

        $(document).on('click', '.view-venue', function() {
            const venueId = $(this).data('id');

            $.ajax({
                url: base_url + 'VenueController/get/' + venueId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const venue = response.data;
                        showVenueDetails(venue);
                        $('#viewVenueModal').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Not Found',
                            text: response.message || 'Could not load venue details.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Failed to fetch venue details.'
                    });
                }
            });
        });
        // Function to show venue details
        function showVenueDetails(venue) {
            const viewContent = $('#viewVenueContent');

            viewContent.html(`
        <div class="row">
            <!-- Venue Info -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-building mr-2"></i>Venue Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <h6><i class="fas fa-tag text-primary mr-2"></i>Venue Name</h6>
                                <p class="text-muted">${venue.venue_name}</p>
                            </div>
                            <div class="col-md-3">
                                <h6><i class="fas fa-map-marker-alt text-primary mr-2"></i>Location</h6>
                                <p class="text-muted">${venue.location}</p>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="bi bi-eye" id="toggleIcon" style="color: red;"></i>
</i>Password</h6>
                                <p class="text-muted">${venue.password}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h6><i class="fas fa-gavel text-primary mr-2"></i>Courts</h6>
                                <p class="text-muted">${venue.courts.length}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Facilities -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-dumbbell mr-2"></i>Facilities</h5>
                    </div>
                    <div class="card-body">
                        ${venue.facilities && venue.facilities.length > 0 ?
                            venue.facilities.map(f => `
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success mr-2"></i>
                                    <span>${f.facility_name} (${f.facility_type}) - ₹${f.rent}</span>
                                </div>
                            `).join('') :
                            '<p class="text-muted">No facilities added</p>'
                        }
                    </div>
                </div>
            </div>

            <!-- Slots -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-clock mr-2"></i>Available Slots</h5>
                    </div>
                    <div class="card-body">
                        ${venue.slots && venue.slots.length > 0 ?
                            venue.slots.map(s => `
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-calendar-alt text-info mr-2"></i>
                                    <span>${s.slot_name} (${s.from_time} - ${s.to_time})</span>
                                </div>
                            `).join('') :
                            '<p class="text-muted">No slots added</p>'
                        }
                    </div>
                </div>
            </div>

            <!-- Plans -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0"><i class="fas fa-tags mr-2"></i>Membership Plans</h5>
                    </div>
                    <div class="card-body">
                        ${venue.plans && venue.plans.length > 0 ?
                            venue.plans.map(p => `
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-star text-warning mr-2"></i>
                                    <span>${p.membership_name} - ₹${p.total_fees} (${p.installments} installments)</span>
                                </div>
                            `).join('') :
                            '<p class="text-muted">No plans added</p>'
                        }
                    </div>
                </div>
            </div>
        </div>
    `);
        }
        // Function to show venue dashboard
        function showVenueDashboard() {
            const viewContent = $('#viewVenueContent');
            const facilitiesCount = currentVenue.facilities ? currentVenue.facilities.length : 0;
            const slotsCount = currentVenue.slots ? currentVenue.slots.length : 0;
            const plansCount = currentVenue.plans ? currentVenue.plans.length : 0;

            viewContent.html(`
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Venue Dashboard - ${currentVenue.name}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h2 class="text-primary">${currentVenue.courts}</h2>
                                                <p class="mb-0"><i class="fas fa-gavel mr-1"></i>Courts</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h2 class="text-success">${facilitiesCount}</h2>
                                                <p class="mb-0"><i class="fas fa-dumbbell mr-1"></i>Facilities</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h2 class="text-info">${slotsCount}</h2>
                                                <p class="mb-0"><i class="fas fa-clock mr-1"></i>Slots</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="card bg-light border-0">
                                            <div class="card-body">
                                                <h2 class="text-warning">${plansCount}</h2>
                                                <p class="mb-0"><i class="fas fa-tags mr-1"></i>Plans</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }

        // Dashboard button click handler
        $('#viewDashboard').on('click', function() {
            if (currentVenue) {
                showVenueDashboard();
            }
        });
    </script>
    <script>
        (function($) {
            // Use SweetAlert to confirm modal close when there are unsaved changes.
            // Keep snapshots of form state when a modal is shown.
            const modalSnapshots = new Map();

            // Snapshot first form inside a modal when it opens
            $(document).on('shown.bs.modal shown.bs.modal', '.modal', function() {
                const $m = $(this);
                const $form = $m.find('form').first();
                if ($form.length) modalSnapshots.set($m.attr('id') || '', $form.serialize());
            });

            // Enhanced close handler: if form changed, ask via SweetAlert; otherwise close normally
            $(document).on('click', '[data-dismiss], [data-bs-dismiss], .close', function(e) {
                const $btn = $(this);
                let $modal = $btn.closest('.modal');

                // fallback to target selector if the button isn't inside the modal
                if (!$modal.length) {
                    const target = $btn.attr('data-target') || $btn.attr('data-bs-target');
                    if (target) $modal = $(target);
                }
                if (!$modal.length) return;

                const id = $modal.attr('id') || '';
                const $form = $modal.find('form').first();
                const initial = modalSnapshots.get(id) || '';
                const current = $form.length ? $form.serialize() : '';

                // If form exists and changed -> confirm
                if ($form.length && initial !== current) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Discard changes?',
                        text: 'You have unsaved changes. Do you want to discard them?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Discard',
                        cancelButtonText: 'Keep editing'
                    }).then(result => {
                        if (result.isConfirmed) {
                            modalSnapshots.delete(id);
                            // Try Bootstrap jQuery hide, then BS5 API, then fallback DOM removal
                            try {
                                if (typeof $modal.modal === 'function') {
                                    $modal.modal('hide');
                                    return;
                                }
                            } catch (err) {}
                            try {
                                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                                    const instance = bootstrap.Modal.getInstance($modal.get(0)) || new bootstrap.Modal($modal.get(0));
                                    instance.hide();
                                    return;
                                }
                            } catch (err) {}
                            // Fallback
                            $modal.removeClass('show').css('display', 'none').attr('aria-hidden', 'true').attr('aria-modal', 'false');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                        }
                    });
                    return;
                }

                // No changes — proceed to close as before
                try {
                    e.preventDefault();
                    if (typeof $modal.modal === 'function') {
                        $modal.modal('hide');
                        return;
                    }
                } catch (err) {}
                try {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modalEl = $modal.get(0);
                        const instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        instance.hide();
                        return;
                    }
                } catch (err) {}
                try {
                    $modal.removeClass('show').css('display', 'none').attr('aria-hidden', 'true').attr('aria-modal', 'false');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                } catch (err) {}
            });

            // Clear snapshot when modal fully hidden
            $(document).on('hidden.bs.modal', '.modal', function() {
                const id = $(this).attr('id') || '';
                modalSnapshots.delete(id);
            });

            // Small SweetAlert toast helper
            window.SwalToast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });

        })(jQuery);
    </script>
    <script>
        // Function to calculate total fees for a specific plan item
        function calculateTotal(planItem) {
            const regInput = planItem.querySelector('input[placeholder="Registration Fees"]');
            const coachInput = planItem.querySelector('input[placeholder="Coaching Fees"]');
            const totalInput = planItem.querySelector('input[placeholder="Total Fees"]');

            if (regInput && coachInput && totalInput) {
                const reg = parseFloat(regInput.value) || 0;
                const coach = parseFloat(coachInput.value) || 0;
                const total = reg + coach;
                totalInput.value = total.toFixed(2);
            }
        }

        // Event delegation for dynamically created plan items
        document.addEventListener('input', function(e) {
            // Check if the input is a registration fee or coaching fee field
            const target = e.target;
            const placeholder = target.getAttribute('placeholder');

            if (placeholder === 'Registration Fees' || placeholder === 'Coaching Fees') {
                // Find the parent plan item
                const planItem = target.closest('.plan-item');
                if (planItem) {
                    calculateTotal(planItem);
                }
            }
        });

        // Also calculate totals when new plans are added
        $(document).on('click', '#addPlan, #editAddPlan', function() {
            // Small delay to ensure the new plan is rendered
            setTimeout(() => {
                $('.plan-item').each(function() {
                    calculateTotal(this);
                });
            }, 100);
        });

        // Calculate totals when the modal opens (for edit modal)
        $(document).on('shown.bs.modal', '#venueModal, #editVenueModal', function() {
            $('.plan-item').each(function() {
                calculateTotal(this);
            });
        });

        // Initialize totals for existing plan items on page load
        $(document).ready(function() {
            $('.plan-item').each(function() {
                calculateTotal(this);
            });
        });
    </script>

</body>

</html>