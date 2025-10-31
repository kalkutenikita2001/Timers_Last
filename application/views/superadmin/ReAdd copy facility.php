<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Member Registrations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

    <style>
        :root {
            --accent: #ff4040;
            --accent-dark: #470000;
            --muted: #f4f6f8;
            --text-dark: #111111;
            --text-light: #ffffff;
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
        }

        .sidebar.minimized {
            width: 60px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
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

        .form-control.is-invalid {
            border-color: var(--accent);
        }

        .invalid-feedback {
            color: var(--accent);
            display: block;
        }

        label {
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%) !important;
            border: none !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        i.fas,
        i.far,
        i.fab {
            color: var(--accent) !important;
        }

        .btn .fa-trash {
            color: inherit !important;
        }

        .nav-tabs .nav-link {
            color: var(--text-dark);
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            color: var(--accent);
            border-bottom: 3px solid var(--accent);
        }

        .court-slot-block,
        .plan-block,
        .facility-block {
            border: 2px solid var(--accent);
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(255, 64, 64, 0.15);
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            flex: 1 1 22%;
            box-sizing: border-box;
            cursor: pointer;
        }

        .court-slot-block:hover,
        .plan-block:hover,
        .facility-block:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(255, 64, 64, 0.25);
            border-color: #ff0000;
        }

        .court-slot-block h5,
        .plan-block h5,
        .facility-block h5 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--accent);
        }

        .court-slot-block h5 small,
        .plan-block h5 small,
        .facility-block h5 small {
            color: #555;
            font-weight: 400;
        }

        .court-slot-block p,
        .plan-block p,
        .facility-block p {
            font-size: 0.9rem;
            color: #333;
        }

        #courtSlotsView,
        #facilityPreview,
        #slotPreview,
        #planPreview,
        #planSelection,
        #facilitySelection {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .slot-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot-box,
        .plan-box,
        .facility-box {
            min-width: 80px;
            padding: 6px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #e6ffe6, #ccffcc);
            border: 1px solid #28a745;
            font-size: 0.85rem;
            color: #2c3e50;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .slot-box:hover,
        .plan-box:hover,
        .facility-box:hover {
            background: linear-gradient(135deg, #ccffcc, #b2f2b2);
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .slot-box.selected,
        .plan-box.selected,
        .facility-box.selected {
            background: linear-gradient(135deg, #ffcccc, #ff9999);
            border: 1px solid var(--accent);
        }

        .plan-block.selected,
        .facility-block.selected {
            background: linear-gradient(135deg, #fff5f5, #ffe6e6);
            border: 2px solid var(--accent-dark);
        }

        .payment-summary {
            background-color: var(--muted);
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .payment-summary .row {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .payment-summary .total {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--accent);
        }

        .installment-details {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-top: 15px;
            border: 1px solid #ddd;
            display: none;
        }

        .installment-table {
            width: 100%;
            margin-top: 10px;
        }

        .installment-table th {
            background-color: var(--muted);
            padding: 8px;
            text-align: left;
        }

        .installment-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .member-type-toggle {
            display: flex;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .member-type-toggle button {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background-color: #f8f9fa;
            font-weight: 500;
            transition: all 0.3s;
        }

        .member-type-toggle button.active {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            color: white;
        }

        .member-type-toggle button:first-child {
            border-right: 1px solid #ddd;
        }

        .group-member-section {
            display: none;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .group-member-row {
            background-color: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--accent);
        }

        .facility-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border-radius: 10px;
        }

        .facility-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .facility-card.selected {
            border: 2px solid #007bff !important;
            background-color: #f8f9ff;
        }

        .group-member-row h6 {
            color: var(--accent);
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remove-member {
            background-color: white;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .add-member-btn {
            margin-top: 10px;
        }

        .member-facility-row {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #007bff;
        }

        .assign-block {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

            .court-slot-block,
            .plan-block,
            .facility-block {
                flex: 1 1 100%;
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
                    <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i> Member Registration</h4>
                </div>
                <div class="card-body">
                    <!-- Member Type Selection -->
                    <div class="member-type-toggle">
                        <button type="button" class="active" id="individualBtn">Individual Registration</button>
                        <button type="button" id="groupBtn">Group Registration</button>
                    </div>

                    <!-- Personal Details -->
                    <h5 class="mb-3"><i class="fas fa-user mr-2 text-primary"></i>Personal Details</h5>
                    <form id="memberForm">
                        <!-- Individual Member Form -->
                        <div id="individualForm">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="memberName" placeholder="Enter Full Name" required>
                                    <div class="invalid-feedback">Please enter member name.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="memberGender" required>
                                        <option value="" selected disabled>Select Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                    <div class="invalid-feedback">Please select gender.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="memberEmail" placeholder="Enter Email Address" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel"
                                        class="form-control"
                                        id="memberPhone"
                                        placeholder="Enter 10-digit Phone Number"
                                        pattern="[0-9]{10}"
                                        maxlength="10"
                                        minlength="10"
                                        required
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="memberDOB" required>
                                    <div class="invalid-feedback">Please select date of birth.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Blood Group</label>
                                    <select class="form-control" id="memberBloodGroup">
                                        <option value="" selected disabled>Select Blood Group</option>
                                        <option>A+</option>
                                        <option>A-</option>
                                        <option>B+</option>
                                        <option>B-</option>
                                        <option>AB+</option>
                                        <option>AB-</option>
                                        <option>O+</option>
                                        <option>O-</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="memberAddress" rows="3" placeholder="Enter Full Address" required></textarea>
                                    <div class="invalid-feedback">Please enter address.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alternate Mobile Number</label>
                                    <input type="tel" class="form-control" id="memberAltPhone" placeholder="Enter Alternate Phone Number" oninput="this.value=this.value.replace(/[^0-9]/g, '' ).slice(0,10);">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="memberJoiningDate" required>
                                    <div class="invalid-feedback">Please select joining date.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Upload Document</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="documentUpload">
                                        <label class="custom-file-label" for="documentUpload">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group Members Section -->
                        <div id="groupForm" class="group-member-section">
                            <h5 class="mb-3"><i class="fas fa-users mr-2 text-primary"></i>Group Members</h5>

                            <div id="groupMembersContainer">
                                <!-- Group member rows will be added here dynamically -->
                            </div>

                            <button type="button" class="btn btn-outline-primary add-member-btn" id="addMemberBtn">
                                <i class="fas fa-plus mr-2"></i> Add Another Member
                            </button>
                        </div>

                        <hr>

                        <!-- Tabs for Subscription, Facility, Payment -->
                        <ul class="nav nav-tabs" id="memberTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="subscription-tab" data-toggle="tab" href="#subscription" role="tab">Subscription</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="facility-tab" data-toggle="tab" href="#facility" role="tab">Facility Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab">Payment Details</a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 border border-top-0" id="memberTabsContent">
                            <!-- Subscription Tab -->
                            <div class="tab-pane fade show active" id="subscription" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Select Center <span class="text-danger">*</span></label>
                                        <select class="form-control" id="centerSelect" required>
                                            <option value="" selected disabled>Select Center</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a center.</div>
                                    </div>
                                </div>

                                <!-- COURT & SLOT SELECTION -->
                                <div id="slotSelection" class="mt-4" style="display: none;">
                                    <div class="form-row">
                                        <!-- Choose Court -->
                                        <div class="form-group col-md-6">
                                            <label>Choose Court <span class="text-danger">*</span></label>
                                            <select class="form-control" id="courtSelect" required>
                                                <option value="" selected disabled>Select Court</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a court.</div>
                                        </div>

                                        <!-- Choose Slot -->
                                        <div class="form-group col-md-6">
                                            <label>Choose Slot <span class="text-danger">*</span></label>
                                            <select class="form-control" id="slotSelect" required>
                                                <option value="" selected disabled>Select Slot</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a slot.</div>
                                        </div>
                                    </div>

                                    <!-- Plan Section -->
                                    <div id="planSelection" class="mt-4" style="display: none;">
                                        <h6>Available Plans</h6>
                                        <div id="planPreview" class="mt-3">
                                            <!-- Dynamic plan content will appear here -->
                                        </div>
                                        <div class="invalid-feedback" id="planError" style="display: none;">Please select a plan.</div>

                                        <div class="form-row mt-4">
                                            <div class="form-group col-md-4">
                                                <label>Plan Start Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="planStartDate" required>
                                                <div class="invalid-feedback">Please select plan start date.</div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Plan End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="planEndDate" readonly required>
                                                <div class="invalid-feedback">Please select plan start date first.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Facility Details Tab -->
                            <div class="tab-pane fade" id="facility" role="tabpanel">
                                <div id="facilitySelection">
                                    <h6>Available Facilities</h6>
                                    <div id="facilityLoader" class="text-center mt-3" style="display: none;">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <p class="mt-2">Loading facilities...</p>
                                    </div>

                                    <!-- Dynamic Facility Content -->
                                    <div id="facilityPreview" class="mt-3 row">
                                        <!-- Facilities from API will appear here -->
                                    </div>

                                    <!-- Group assignment area: assign facilities to each group member -->
                                    <div id="groupFacilityAssignments" class="mt-4" style="display: none;">
                                        <h6>Assign Facilities to Group Members</h6>
                                        <div id="groupFacilityAssignmentsContainer"></div>
                                    </div>

                                    <div class="invalid-feedback" id="facilityError" style="display: none;">
                                        Please select a facility.
                                    </div>
                                </div>

                                <!-- Individual member facility dates (for individual registration) -->
                                <div id="individualFacilityDates" class="form-row mt-4">
                                    <div class="form-group col-md-4">
                                        <label>Facility Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="facilityStartDate" required>
                                        <div class="invalid-feedback">Please select facility start date.</div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Facility End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="facilityEndDate" required>
                                        <div class="invalid-feedback">Please select facility end date.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details Tab -->
                            <div class="tab-pane fade" id="payment" role="tabpanel">
                                <h6 class="mb-3">Invoice Details</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Date</label>
                                        <input type="text" class="form-control" id="invoiceDate" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Invoice ID</label>
                                        <input type="text" class="form-control" id="invoiceId" readonly>
                                    </div>
                                </div>

                                <h6 class="mt-4 mb-3">Payment Details</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Discount (%)</label>
                                        <input type="number" class="form-control" id="discountPercent" min="0" max="100" value="0">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Payment Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="paymentType" required>
                                            <option value="" selected disabled>Select Payment Type</option>
                                            <option>Full Payment</option>
                                            <option>Installment</option>
                                        </select>
                                        <div class="invalid-feedback">Please select payment type.</div>
                                    </div>
                                </div>

                                <!-- Installment Details Section -->
                                <div class="installment-details" id="installmentDetails">
                                    <h6>Installment Plan</h6>
                                    <table class="installment-table">
                                        <thead>
                                            <tr>
                                                <th>Installment</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="installmentTableBody">
                                            <!-- Installment rows will be added here dynamically -->
                                        </tbody>
                                    </table>
                                </div>

                                <div class="payment-summary">
                                    <h6>Payment Summary</h6>
                                    <div class="row">
                                        <div class="col-8">Plan Fees</div>
                                        <div class="col-4 text-right">₹ <span id="planFees">0</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">Facility Fee</div>
                                        <div class="col-4 text-right">₹ <span id="facilityFees">0</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">Discount</div>
                                        <div class="col-4 text-right">₹ <span id="discountAmount">0</span></div>
                                    </div>
                                    <div class="row total">
                                        <div class="col-8">Total Amount</div>
                                        <div class="col-4 text-right">₹ <span id="totalAmount">0</span></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" id="addPaymentBtn">
                                        <i class="fas fa-plus mr-2"></i> Add Payment
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-secondary mr-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Member</button>
                        </div>
                    </form>
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
            let allVenues = [];
            let selectedFacility = null;
            let memberCount = 0;
            window.activeAssignMemberId = null;
            window.facilityUsage = {};
            window.memberFacilities = {};
            window.currentFacilities = [];

            // Initialize member type toggle
            $('#individualBtn').on('click', function() {
                $(this).addClass('active');
                $('#groupBtn').removeClass('active');
                $('#individualForm').show();
                $('#groupForm').hide();
                $('#individualFacilityDates').show();
            });

            $('#groupBtn').on('click', function() {
                $(this).addClass('active');
                $('#individualBtn').removeClass('active');
                $('#individualForm').hide();
                $('#groupForm').show();
                $('#individualFacilityDates').hide();
                if (memberCount === 0) {
                    addGroupMember();
                }
            });

            // Sidebar toggle functionality
            $('#toggleSidebar').on('click', function() {
                $('.sidebar').toggleClass('minimized');
                $('.navbar').toggleClass('sidebar-minimized');
                $('#contentWrapper').toggleClass('minimized');
            });

            // When Facility tab is shown, render assignments for group members
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                if ($(e.target).attr('id') === 'facility-tab') {
                    renderGroupFacilityAssignments();
                }
            });

            // Add group member functionality
            function addGroupMember() {
                memberCount++;
                const memberRow = `
                    <div class="group-member-row" id="memberRow${memberCount}">
                        <h6>Member ${memberCount} <button type="button" class="remove-member" data-id="${memberCount}"><i class="fas fa-trash"></i></button></h6>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="groupMemberName${memberCount}" placeholder="Enter Full Name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Gender <span class="text-danger">*</span></label>
                                <select class="form-control" name="groupMemberGender${memberCount}" required>
                                    <option value="" selected disabled>Select Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="groupMemberEmail${memberCount}" placeholder="Enter Email Address" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="groupMemberPhone${memberCount}" placeholder="Enter Phone Number" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="groupMemberDOB${memberCount}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Blood Group</label>
                                <select class="form-control" name="groupMemberBloodGroup${memberCount}">
                                    <option value="" selected disabled>Select Blood Group</option>
                                    <option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
                                    <option>O+</option>
                                    <option>O-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="groupMemberAddress${memberCount}" rows="2" placeholder="Enter Full Address" required></textarea>
                            </div>
                        </div>
                    </div>
                `;

                $('#groupMembersContainer').append(memberRow);

                // Add event listener to the remove button
                $(`#memberRow${memberCount} .remove-member`).on('click', function() {
                    const id = $(this).data('id');
                    $(`#memberRow${id}`).remove();
                    reorderMembers();
                });

                renderGroupFacilityAssignments();
            }

            function reorderMembers() {
                const memberRows = $('.group-member-row');
                memberCount = 0;

                memberRows.each(function(index) {
                    memberCount++;
                    $(this).find('h6').html(`Member ${memberCount} <button type="button" class="remove-member" data-id="${memberCount}"><i class="fas fa-times"></i></button>`);
                    $(this).attr('id', `memberRow${memberCount}`);
                    $(this).find('.remove-member').data('id', memberCount);
                });
                renderGroupFacilityAssignments();
            }

            $('#addMemberBtn').on('click', function() {
                addGroupMember();
            });

            // Set current date for invoice
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            $('#invoiceDate').val(formattedDate);

            // Generate invoice ID
            function generateInvoiceId() {
                const timestamp = today.getTime();
                const random = Math.floor(Math.random() * 1000);
                return `INV-${timestamp}-${random}`;
            }

            $('#invoiceId').val(generateInvoiceId());

            // 🔹 1️⃣ Fetch all venues from API
            $.ajax({
                url: "<?php echo base_url('VenueController/getAllVenues'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        allVenues = response.data;

                        // Populate centers dynamically
                        let options = `<option value="" selected disabled>Select Center</option>`;
                        allVenues.forEach(venue => {
                            options += `<option value="${venue.id}">${venue.venue_name} - ${venue.location}</option>`;
                        });
                        $("#centerSelect").html(options);
                    }
                },
                error: function(err) {
                    console.error("Error loading venues:", err);
                }
            });

            // 🔹 2️⃣ When center selected → show court, slot, and facility dropdowns
            $("#centerSelect").on("change", function() {
                const venueId = $(this).val();
                const venue = allVenues.find(v => v.id == venueId);
                if (!venue) return;

                $("#slotSelection").show();
                $("#facilityPreview").empty();
                $("#facilityLoader").show();

                // ✅ Populate courts dropdown
                let courtOptions = `<option value="" selected disabled>Select Court</option>`;
                if (venue.courts.length > 0) {
                    venue.courts.forEach(court => {
                        courtOptions += `<option value="${court.id}">${court.court_name} (${court.court_type || 'N/A'})</option>`;
                    });
                } else {
                    courtOptions = `<option disabled>No courts available</option>`;
                }
                $("#courtSelect").html(courtOptions);

                // ✅ Populate slots dropdown
                let slotOptions = `<option value="" selected disabled>Select Slot</option>`;
                if (venue.slots.length > 0) {
                    venue.slots.forEach(slot => {
                        slotOptions += `<option value="${slot.id}">${slot.slot_name} (${slot.from_time} - ${slot.to_time})</option>`;
                    });
                } else {
                    slotOptions = `<option disabled>No slots available</option>`;
                }
                $("#slotSelect").html(slotOptions);

                // ✅ Store venue for later
                $("#slotSelection").data("venue", venue);

                // ✅ Populate facilities (Facility tab)
                loadFacilitiesForVenue(venue);
            });

            // 🔹 3️⃣ Load facilities dynamically
            function loadFacilitiesForVenue(venue) {
                const facilityPreview = $("#facilityPreview");
                const facilityLoader = $("#facilityLoader");
                let selectedFacilities = new Set();
                let totalRent = 0;

                facilityPreview.empty();

                if (!venue.facilities || venue.facilities.length === 0) {
                    facilityLoader.hide();
                    facilityPreview.html(`<p class="text-muted">No facilities available for this center.</p>`);
                    return;
                }

                facilityLoader.hide();
                window.currentFacilities = venue.facilities || [];
                updateAllAssignmentSelects();
                let facilitiesHTML = "";

                venue.facilities.forEach(facility => {
                    facilitiesHTML += `
            <div class="col-md-4 mb-3" style="width: 100%;">
                <div class="card h-100 shadow-sm facility-card" 
                    data-id="${facility.id}" 
                    data-rent="${facility.rent}">
                    <div class="card-body text-center">
                        <h6 class="card-title mb-1">${facility.facility_name}</h6>
                        <p class="text-muted small mb-1">Type: ${facility.facility_type || 'N/A'}</p>
                        <p class="text-primary mb-2">Rent: ₹${facility.rent}</p>
                        <button type="button" class="btn btn-outline-primary btn-sm select-facility-btn">
                            Select
                        </button>
                    </div>
                </div>
            </div>
        `;
                });

                facilityPreview.html(facilitiesHTML);

                // Add total rent section dynamically (if not present)
                if ($("#totalRentContainer").length === 0) {
                    facilityPreview.after(`
            <div id="totalRentContainer" class="mt-3">
                <h6>Total Rent: ₹<span id="totalRent">0</span></h6>
            </div>
            <input type="hidden" id="selectedFacilities" name="selectedFacilities">
            <input type="hidden" id="facilityRent" name="facilityRent">
        `);
                }

                // ✅ Multiple Facility Selection Logic
                $(".select-facility-btn").on("click", function() {
                    const card = $(this).closest(".facility-card");
                    const facilityId = card.data("id");
                    const rent = parseFloat(card.data("rent"));

                    if (selectedFacilities.has(facilityId)) {
                        // Deselect
                        selectedFacilities.delete(facilityId);
                        totalRent -= rent;
                        card.removeClass("selected").css({
                            "border": "",
                            "box-shadow": ""
                        });
                        $(this).text("Select").removeClass("btn-primary").addClass("btn-outline-primary");
                    } else {
                        // Select
                        selectedFacilities.add(facilityId);
                        totalRent += rent;
                        card.addClass("selected").css({
                            "border": "2px solid #007bff",
                            "box-shadow": "0 0 8px rgba(0, 123, 255, 0.5)"
                        });
                        $(this).text("Selected").removeClass("btn-outline-primary").addClass("btn-primary");
                    }

                    // Update total rent and store selections
                    $("#totalRent").text(totalRent.toFixed(2));
                    $("#facilityRent").val(totalRent);
                    $("#selectedFacilities").val(Array.from(selectedFacilities).join(","));

                    $("#facilityError").toggle(selectedFacilities.size === 0);
                });
            }

            // Build options HTML for facility selects based on selected center
            function getFacilitiesOptionsHtml() {
                const facilities = window.currentFacilities || [];
                if (!facilities.length) return '<option value="" disabled>No facilities available</option>';
                let html = '<option value="" selected disabled>Select Facility</option>';
                facilities.forEach(f => {
                    html += `<option value="${f.id}" data-rent="${f.rent}">${f.facility_name} - ₹${f.rent}</option>`;
                });
                return html;
            }

            // Update existing assignment selects to reflect the currently selected center's facilities
            function updateAllAssignmentSelects() {
                const html = getFacilitiesOptionsHtml();
                $(`select[name^='member_'][name$='_facility[]']`).each(function() {
                    const prev = $(this).val();
                    $(this).html(html);
                    if (prev) $(this).val(prev);
                });
            }

            // 🔹 4️⃣ Slot selection → show plans
            $("#slotSelect").on("change", function() {
                const venue = $("#slotSelection").data("venue");
                if (!venue) return;
                $("#planSelection").show();

                let plansHTML = "";
                if (venue.plans.length > 0) {
                    venue.plans.forEach(plan => {
                        plansHTML += `
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="planRadio" id="plan_${plan.id}" 
                            data-fees="${plan.total_fees}" data-duration="${plan.duration}" 
                            data-period="${plan.period}" value="${plan.id}">
                        <label class="form-check-label" for="plan_${plan.id}">
                            <strong>${plan.membership_name}</strong> - ${plan.duration} ${plan.period}<br>
                            Reg: ₹${plan.registration_fees}, Coaching: ₹${plan.coaching_fees}, Total: ₹${plan.total_fees}
                        </label>
                    </div>
                `;
                    });
                } else {
                    plansHTML = `<p class="text-muted">No plans available for this center.</p>`;
                }

                $("#planPreview").html(plansHTML);
            });

            // 🔹 5️⃣ Plan selection → auto-calculate end date
            $(document).on("change", "input[name='planRadio']", function() {
                const fees = $(this).data("fees");
                const duration = $(this).data("duration");
                const period = $(this).data("period");

                $("#planFees").text(fees || 0);
                $("#planStartDate").val("");
                $("#planEndDate").val("");

                $("#planStartDate").off("change").on("change", function() {
                    let startDate = new Date($(this).val());
                    if (startDate && duration && period) {
                        let endDate = new Date(startDate);
                        if (period === "Month") endDate.setMonth(endDate.getMonth() + parseInt(duration));
                        if (period === "Year") endDate.setFullYear(endDate.getFullYear() + parseInt(duration));
                        if (period === "Day") endDate.setDate(endDate.getDate() + parseInt(duration));
                        $("#planEndDate").val(endDate.toISOString().split("T")[0]);
                    }
                });
            });

            // Add facility assignment blocks for group members inside the Facility tab
            function renderGroupFacilityAssignments() {
                const container = $('#groupFacilityAssignmentsContainer');
                container.empty();
                const memberRows = $('.group-member-row');
                if (memberRows.length === 0) {
                    $('#groupFacilityAssignments').hide();
                    return;
                }

                // show container
                $('#groupFacilityAssignments').show();

                memberRows.each(function(index) {
                    const el = $(this);
                    const idAttr = el.attr('id') || '';
                    const rid = idAttr.replace('memberRow', '') || (index + 1);
                    const memberName = el.find(`input[name='groupMemberName${rid}']`).val() || `Member ${rid}`;

                    const block = $(
                        `<div class="assign-block border p-3 mb-2" id="assignMember_${rid}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div><strong>${memberName}</strong></div>
                                <div><button type="button" class="btn btn-sm btn-outline-secondary add-assignment" data-member-id="${rid}"><i class="fas fa-plus mr-1"></i> Add Facility</button></div>
                            </div>
                            <div id="assignMemberFacilities_${rid}" class="mt-3"></div>
                        </div>`
                    );

                    container.append(block);

                    // bind add-assignment button
                    block.find('.add-assignment').on('click', function() {
                        const memId = $(this).data('member-id');
                        const memberName = $(this).closest('.assign-block').find('strong').text();
                        window.activeAssignMemberId = memId;
                        $('a#facility-tab').tab('show');

                        Swal.fire({
                            icon: 'info',
                            title: 'Select Facility',
                            text: `Click on any facility to assign it to ${memberName}`,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            const preview = $('#facilityPreview');
                            if (preview.length) preview[0].scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            $('.facility-card').css({
                                'outline': '3px dashed #007bff'
                            });
                        }, 200);
                    });
                });
            }

            // Enhanced function to add facility with per-member dates
            function addFacilityToMember(memberId, selectedFacilityId) {
                const container = $(`#assignMemberFacilities_${memberId}`);
                if (!container.length) return;

                const idx = container.find('.member-facility-row').length;

                // Calculate default dates
                const today = new Date().toISOString().split('T')[0];
                const oneMonthLater = new Date();
                oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);
                const defaultEndDate = oneMonthLater.toISOString().split('T')[0];

                const row = $(
                    `<div class="member-facility-row border p-3 mb-3 rounded">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <label class="font-weight-bold">Facility</label>
                    <select class="form-control" name="member_${memberId}_facility[]" required>${getFacilitiesOptionsHtml()}</select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control facility-start-date" name="member_${memberId}_facility_start[]" value="${today}" required />
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control facility-end-date" name="member_${memberId}_facility_end[]" value="${defaultEndDate}" required />
                </div>
                <div class="col-md-2">
                    <label class="font-weight-bold">Actions</label>
                    <button type="button" class="btn btn-danger btn-sm remove-member-facility btn-block">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
            </div>
        </div>`
                );

                row.find('.remove-member-facility').on('click', function() {
                    const facilityId = row.find('select').val();
                    if (facilityId && window.facilityUsage[facilityId]) {
                        window.facilityUsage[facilityId]--;
                    }
                    row.remove();
                });

                container.append(row);

                // If a specific facility was provided, set it
                if (selectedFacilityId) {
                    row.find('select').val(selectedFacilityId);

                    if (!window.facilityUsage[selectedFacilityId]) {
                        window.facilityUsage[selectedFacilityId] = 0;
                    }
                    window.facilityUsage[selectedFacilityId]++;
                }

                // Exit assignment mode
                window.activeAssignMemberId = null;
                $('.facility-card').css({
                    'outline': ''
                });
            }

            // When user clicks a facility card while in assignment mode, assign that facility to the active member
            $(document).on('click', '.facility-card', function(e) {
                if (!window.activeAssignMemberId) return;

                e.preventDefault();
                e.stopPropagation();
                const facilityId = $(this).data('id');
                const memberId = window.activeAssignMemberId;

                addFacilityToMember(memberId, facilityId);

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Facility assigned to Member ' + memberId,
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            // Payment type change - show/hide installment details
            $('#paymentType').on('change', function() {
                if ($(this).val() === 'Installment') {
                    $('#installmentDetails').show();
                    generateInstallmentPlan();
                } else {
                    $('#installmentDetails').hide();
                }
                $(this).removeClass('is-invalid');
                updatePaymentSummary();
            });

            // Generate installment plan
            function generateInstallmentPlan() {
                const totalAmount = parseInt($('#totalAmount').text()) || 0;
                if (totalAmount === 0) return;

                const today = new Date();
                const tableBody = $('#installmentTableBody');
                tableBody.empty();

                const installmentCount = 4;
                const installmentAmount = Math.ceil(totalAmount / installmentCount);

                for (let i = 1; i <= installmentCount; i++) {
                    const dueDate = new Date(today);
                    dueDate.setMonth(dueDate.getMonth() + i);

                    const formattedDate = dueDate.toISOString().split('T')[0];

                    const row = `
            <tr>
                <td>Installment ${i}</td>
                <td>₹ ${i === installmentCount ? totalAmount - (installmentAmount * (installmentCount - 1)) : installmentAmount}</td>
                <td>${formattedDate}</td>
            </tr>
        `;

                    tableBody.append(row);
                }
            }

            // Update payment summary
            function updatePaymentSummary() {
                const planFees = parseInt($('#planFees').text()) || 0;
                const facilityFees = parseInt($('#facilityFees').text()) || 0;
                const discountPercent = parseInt($('#discountPercent').val()) || 0;
                const discountAmount = (planFees + facilityFees) * (discountPercent / 100);
                const totalAmount = (planFees + facilityFees) - discountAmount;

                $('#discountAmount').text(discountAmount.toFixed(0));
                $('#totalAmount').text(totalAmount.toFixed(0));

                if ($('#paymentType').val() === 'Installment') {
                    generateInstallmentPlan();
                }
            }

            // Discount calculation
            $('#discountPercent').on('input', function() {
                updatePaymentSummary();
            });

            // Add payment button
            $('#addPaymentBtn').on('click', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Added!',
                    text: 'Payment details have been recorded successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            // Form submission
            $("#memberForm").on("submit", function(e) {
                e.preventDefault();

                const selectedFacilities = $("#selectedFacilities").val() ?
                    $("#selectedFacilities").val().split(",").map(id => ({
                        id: id,
                        rent: parseFloat($("#facilityRent").val()) / $("#selectedFacilities").val().split(",").length,
                        start_date: $("#facilityStartDate").val(),
                        end_date: $("#facilityEndDate").val()
                    })) : [];

                // Collect group members and their assigned facilities with individual dates
                const groupMembers = [];
                $('.group-member-row').each(function(index) {
                    const row = $(this);
                    const idAttr = row.attr('id') || '';
                    const rid = idAttr.replace('memberRow', '') || (index + 1);

                    const member = {
                        name: row.find(`input[name='groupMemberName${rid}']`).val() || '',
                        gender: row.find(`select[name='groupMemberGender${rid}']`).val() || '',
                        email: row.find(`input[name='groupMemberEmail${rid}']`).val() || '',
                        phone: row.find(`input[name='groupMemberPhone${rid}']`).val() || '',
                        dob: row.find(`input[name='groupMemberDOB${rid}']`).val() || '',
                        blood_group: row.find(`select[name='groupMemberBloodGroup${rid}']`).val() || '',
                        address: row.find(`textarea[name='groupMemberAddress${rid}']`).val() || '',
                        facilities: []
                    };

                    // Collect assigned facilities with individual dates from Facility tab container
                    const assignContainer = $(`#assignMemberFacilities_${rid}`);
                    if (assignContainer.length) {
                        assignContainer.find('.member-facility-row').each(function() {
                            const facilityRow = $(this);
                            const facilityId = facilityRow.find(`select[name='member_${rid}_facility[]']`).val();
                            const startDate = facilityRow.find(`input[name='member_${rid}_facility_start[]']`).val();
                            const endDate = facilityRow.find(`input[name='member_${rid}_facility_end[]']`).val();

                            if (facilityId && startDate && endDate) {
                                member.facilities.push({
                                    id: facilityId,
                                    start_date: startDate,
                                    end_date: endDate
                                });
                            }
                        });
                    }

                    if (member.name || member.email) {
                        groupMembers.push(member);
                    }
                });

                let payload = {};
                if (groupMembers.length > 0) {
                    // Group registration payload
                    payload = {
                        group: true,
                        venue_id: $("#centerSelect").val(),
                        court_id: $("#courtSelect").val(),
                        slot_id: $("#slotSelect").val(),
                        plan_id: $("input[name='planRadio']:checked").val(),
                        plan_start_date: $("#planStartDate").val(),
                        plan_end_date: $("#planEndDate").val(),
                        members: groupMembers,
                        invoice_id: $("#invoiceId").val(),
                        invoice_date: $("#invoiceDate").val(),
                        discount_percent: $("#discountPercent").val(),
                        payment_type: $("#paymentType").val(),
                        total_amount: $("#totalAmount").text()
                    };
                } else {
                    // Individual member payload (uses global facility dates)
                    payload = {
                        name: $("#memberName").val(),
                        gender: $("#memberGender").val(),
                        email: $("#memberEmail").val(),
                        phone: $("#memberPhone").val(),
                        dob: $("#memberDOB").val(),
                        blood_group: $("#memberBloodGroup").val(),
                        address: $("#memberAddress").val(),
                        alt_phone: $("#memberAltPhone").val(),
                        joining_date: $("#memberJoiningDate").val(),
                        document_path: $("#documentUpload").val(),
                        venue_id: $("#centerSelect").val(),
                        court_id: $("#courtSelect").val(),
                        slot_id: $("#slotSelect").val(),
                        plan_id: $("input[name='planRadio']:checked").val(),
                        plan_start_date: $("#planStartDate").val(),
                        plan_end_date: $("#planEndDate").val(),
                        facilities: selectedFacilities,
                        invoice_id: $("#invoiceId").val(),
                        invoice_date: $("#invoiceDate").val(),
                        discount_percent: $("#discountPercent").val(),
                        payment_type: $("#paymentType").val(),
                        total_amount: $("#totalAmount").text()
                    };
                }

                // Validate group member facilities
                if (groupMembers.length > 0) {
                    let hasFacilityErrors = false;
                    groupMembers.forEach((member, index) => {
                        member.facilities.forEach(facility => {
                            if (!facility.start_date || !facility.end_date) {
                                hasFacilityErrors = true;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Missing Facility Dates',
                                    text: `Please provide start and end dates for all facilities assigned to ${member.name || 'Member ' + (index + 1)}`,
                                    timer: 4000,
                                    showConfirmButton: true
                                });
                            }
                        });
                    });

                    if (hasFacilityErrors) {
                        return;
                    }
                }

                console.log('Payload:', payload);

                $.ajax({
                    url: "<?php echo base_url('api/member/register'); ?>",
                    type: "POST",
                    data: JSON.stringify(payload),
                    contentType: "application/json",
                    success: function(res) {
                        if (res.status === "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Member Registered!',
                                text: 'Member details have been saved successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $("#memberForm")[0].reset();
                                $('#groupMembersContainer').empty();
                                memberCount = 0;
                                window.facilityUsage = {};
                                window.memberFacilities = {};
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Registration Failed',
                                text: res.message || 'Failed to register member.',
                                timer: 3000,
                                showConfirmButton: true
                            });
                        }
                    },
                    error: function(err) {
                        console.error("API Error:", err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Failed to register member. Please try again.',
                            timer: 3000,
                            showConfirmButton: true
                        });
                    }
                });
            });

            // File input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
</body>

</html>