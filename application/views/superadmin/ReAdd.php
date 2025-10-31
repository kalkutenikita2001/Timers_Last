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
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

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

        .selected {
            border: 2px solid #007bff;
            background: #e9f5ff;
        }

        .installment-details {
            margin-top: 20px;
            display: none;
        }

        .installment-table {
            width: 100%;
            border-collapse: collapse;
        }

        .installment-table th,
        .installment-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .payment-summary .row {
            padding: 5px 0;
        }

        .payment-summary .total {
            font-weight: bold;
            border-top: 2px solid #000;
            margin-top: 10px;
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
                    <h4 class="mb-0">Member Registration</h4>
                </div>
                <div class="card-body">
                    <!-- Member Type Selection -->
                    <div class="member-type-toggle">
                        <button type="button" class="active" id="individualBtn">Individual Registration</button>
                        <button type="button" id="groupBtn">Group Registration</button>
                    </div>

                    <!-- Personal Details -->
                    <h5 class="mb-3">Personal Details</h5>
                    <form id="memberForm">
                        <!-- Individual Member Form -->
                        <div id="individualForm">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="memberName" name="name" placeholder="Enter Full Name" >
                                    <div class="invalid-feedback">Please enter member name.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="memberGender" name="gender" >
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
                                    <input type="email" class="form-control" id="memberEmail" name="email" placeholder="Enter Email Address" >
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel"
                                        class="form-control"
                                        id="memberPhone"
                                        name="phone"
                                        placeholder="Enter 10-digit Phone Number"
                                        pattern="[0-9]{10}"
                                        maxlength="10"
                                        minlength="10"
                                        
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">
                                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="memberDOB" name="dob" >
                                    <div class="invalid-feedback">Please select date of birth.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Blood Group</label>
                                    <select class="form-control" id="memberBloodGroup" name="blood_group">
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
                                    <textarea class="form-control" id="memberAddress" name="address" rows="3" placeholder="Enter Full Address" ></textarea>
                                    <div class="invalid-feedback">Please enter address.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Alternate Mobile Number</label>
                                    <input type="tel" class="form-control" id="memberAltPhone" name="alt_phone" placeholder="Enter Alternate Phone Number" oninput="this.value=this.value.replace(/[^0-9]/g, '' ).slice(0,10);">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="memberJoiningDate" name="joining_date" >
                                    <div class="invalid-feedback">Please select joining date.</div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Upload Document</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="documentUpload" name="document">
                                        <label class="custom-file-label" for="documentUpload">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Group Members Section -->
                        <div id="groupForm" class="group-member-section">
                            <h5 class="mb-3">Group Members</h5>

                            <div id="groupMembersContainer">
                                <!-- Group member rows will be added here dynamically -->
                            </div>

                            <button type="button" class="btn btn-outline-primary add-member-btn" id="addMemberBtn">
                                Add Another Member
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
                                        <select class="form-control" id="centerSelect" name="venue_id" >
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
                                            <select class="form-control" id="courtSelect" name="court_id" >
                                                <option value="" selected disabled>Select Court</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a court.</div>
                                        </div>

                                        <!-- Choose Slot -->
                                        <div class="form-group col-md-6">
                                            <label>Choose Slot <span class="text-danger">*</span></label>
                                            <select class="form-control" id="slotSelect" name="slot_id" >
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
                                                <input type="date" class="form-control" id="planStartDate" name="plan_start_date" >
                                                <div class="invalid-feedback">Please select plan start date.</div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Plan End Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="planEndDate" name="plan_end_date"  >
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

                                    <!-- Group assignment area -->
                                    <div id="groupFacilityAssignments" class="mt-4" style="display: none;">
                                        <h6>Assign Facilities to Group Members</h6>
                                        <div id="groupFacilityAssignmentsContainer"></div>
                                    </div>

                                    <div class="invalid-feedback" id="facilityError" style="display: none;">
                                        Please select a facility.
                                    </div>
                                </div>

                                <div class="form-row mt-4">
                                    <div class="form-group col-md-4">
                                        <label>Facility Start Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="facilityStartDate" name="facility_start_date">
                                        <div class="invalid-feedback">Please select facility start date.</div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Facility End Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="facilityEndDate" name="facility_end_date">
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
                                        <input type="text" class="form-control" id="invoiceDate" name="invoice_date" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Invoice ID</label>
                                        <input type="text" class="form-control" id="invoiceId" name="invoice_id" readonly>
                                    </div>
                                </div>

                                <h6 class="mt-4 mb-3">Payment Details</h6>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Discount (%)</label>
                                        <input type="number" class="form-control" id="discountPercent" name="discount_percent" min="0" max="100" value="0">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Payment Type <span class="text-danger">*</span></label>
                                        <select class="form-control" id="paymentType" name="payment_type" >
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
                                    <!-- Subtotal (Plan + Facility) -->
                                    <div class="row mt-2">
                                        <div class="col-8"><strong>Subtotal</strong></div>
                                        <div class="col-4 text-right"><strong>₹ <span id="subtotal">0</span></strong></div>
                                    </div>
                                    <!-- Final Total (after discount) -->
                                    <div class="row mt-2 total">
                                        <div class="col-8"><strong>Total Amount</strong></div>
                                        <div class="col-4 text-right"><strong>₹ <span id="totalAmount">0</span></strong></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" id="addPaymentBtn">
                                        Add Payment
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

    <!-- Hidden inputs for facility selection (must have name!) -->
    <input type="hidden" id="selectedFacilities" name="selected_facilities">
    <input type="hidden" id="facilityRent" name="facility_rent">

    <script>
        $(document).ready(function () {
            let allVenues = [];
            let selectedFacility = null;
            window.activeAssignMemberId = null;

            /* ---------- PAYMENT CALCULATION GLOBALS ---------- */
            let selectedPlanFees = 0;
            let selectedFacilityFees = 0;
            let discountPercent = 0;
            let groupMemberCount = 1;

            function animateTotalChange() {
                $("#subtotal, #totalAmount").fadeOut(100).fadeIn(200);
            }

            function updatePaymentSummary() {
                const planTotal = selectedPlanFees * groupMemberCount;
                const discountAmt = (planTotal + selectedFacilityFees) * discountPercent / 100;
                const subtotal = planTotal + selectedFacilityFees;
                const total = subtotal - discountAmt;

                $("#planFees").text(planTotal.toFixed(2));
                $("#facilityFees").text(selectedFacilityFees.toFixed(2));
                $("#discountAmount").text(discountAmt.toFixed(2));
                $("#subtotal").text(subtotal.toFixed(2));
                $("#totalAmount").text(total.toFixed(2));
                animateTotalChange();
            }

            /* ---------- 1. FETCH VENUES ---------- */
            $.ajax({
                url: "<?php echo base_url('VenueController/getAllVenues'); ?>",
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        allVenues = response.data;
                        let options = `<option value="" selected disabled>Select Center</option>`;
                        allVenues.forEach(venue => {
                            options += `<option value="${venue.id}">${venue.venue_name} - ${venue.location}</option>`;
                        });
                        $("#centerSelect").html(options);
                    }
                },
                error: function (err) { console.error("Error loading venues:", err); }
            });

            /* ---------- 2. CENTER CHANGE ---------- */
            $("#centerSelect").on("change", function () {
                const venueId = $(this).val();
                const venue = allVenues.find(v => v.id == venueId);
                if (!venue) return;

                $("#slotSelection").show();
                $("#facilityPreview").empty();
                $("#facilityLoader").show();

                let courtOptions = `<option value="" selected disabled>Select Court</option>`;
                if (venue.courts.length) {
                    venue.courts.forEach(c => courtOptions += `<option value="${c.id}">${c.court_name} (${c.court_type || 'N/A'})</option>`);
                } else courtOptions = `<option disabled>No courts available</option>`;
                $("#courtSelect").html(courtOptions);

                let slotOptions = `<option value="" selected disabled>Select Slot</option>`;
                if (venue.slots.length) {
                    venue.slots.forEach(s => slotOptions += `<option value="${s.id}">${s.slot_name} (${s.from_time} - ${s.to_time})</option>`);
                } else slotOptions = `<option disabled>No slots available</option>`;
                $("#slotSelect").html(slotOptions);

                $("#slotSelection").data("venue", venue);
                loadFacilitiesForVenue(venue);
            });

            /* ---------- 3. FACILITIES ---------- */
            function loadFacilitiesForVenue(venue) {
                const preview = $("#facilityPreview");
                const loader = $("#facilityLoader");
                let selectedFacilities = new Set();
                let totalRent = 0;

                preview.empty();

                if (!venue.facilities || venue.facilities.length === 0) {
                    loader.hide();
                    preview.html(`<p class="text-muted">No facilities available for this center.</p>`);
                    return;
                }

                loader.hide();
                window.currentFacilities = venue.facilities || [];
                updateAllAssignmentSelects();

                let html = "";
                venue.facilities.forEach(f => {
                    html += `
                <div class="col-md-4 mb-3" style="width:100%;">
                    <div class="card h-100 shadow-sm facility-card" data-id="${f.id}" data-rent="${f.rent}">
                        <div class="card-body text-center">
                            <h6 class="card-title mb-1">${f.facility_name}</h6>
                            <p class="text-muted small mb-1">Type: ${f.facility_type || 'N/A'}</p>
                            <p class="text-primary mb-2">Rent: ₹${f.rent}</p>
                            <button type="button" class="btn btn-outline-primary btn-sm select-facility-btn">Select</button>
                        </div>
                    </div>
                </div>`;
                });
                preview.html(html);

                $(".select-facility-btn").off("click").on("click", function () {
                    const card = $(this).closest(".facility-card");
                    const id = card.data("id");
                    const rent = parseFloat(card.data("rent"));

                    if (selectedFacilities.has(id)) {
                        selectedFacilities.delete(id);
                        totalRent -= rent;
                        card.removeClass("selected").css({ "border": "", "box-shadow": "" });
                        $(this).text("Select").removeClass("btn-primary").addClass("btn-outline-primary");
                    } else {
                        selectedFacilities.add(id);
                        totalRent += rent;
                        card.addClass("selected").css({ "border": "2px solid #007bff", "box-shadow": "0 0 8px rgba(0,123,255,0.5)" });
                        $(this).text("Selected").removeClass("btn-outline-primary").addClass("btn-primary");
                    }

                    selectedFacilityFees = totalRent;
                    $("#totalRent").text(totalRent.toFixed(2));
                    $("#facilityRent").val(totalRent);
                    $("#selectedFacilities").val(Array.from(selectedFacilities).join(","));
                    $("#facilityError").toggle(selectedFacilities.size === 0);

                    updatePaymentSummary();
                });
            }

            function getFacilitiesOptionsHtml() {
                const f = window.currentFacilities || [];
                if (!f.length) return '<option value="" disabled>No facilities available</option>';
                let h = '<option value="" selected disabled>Select Facility</option>';
                f.forEach(x => h += `<option value="${x.id}" data-rent="${x.rent}">${x.facility_name} - ₹${x.rent}</option>`);
                return h;
            }

            function updateAllAssignmentSelects() {
                const h = getFacilitiesOptionsHtml();
                $(`select[name^='member_'][name$='_facility[]']`).each(function () {
                    const prev = $(this).val();
                    $(this).html(h);
                    if (prev) $(this).val(prev);
                });
            }

            /* ---------- 4. SLOT → PLANS ---------- */
            $("#slotSelect").on("change", function () {
                const venue = $("#slotSelection").data("venue");
                if (!venue) return;
                $("#planSelection").show();

                let html = "";
                if (venue.plans.length) {
                    venue.plans.forEach(p => {
                        html += `
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="plan_id" id="plan_${p.id}"
                               data-fees="${p.total_fees}" data-duration="${p.duration}" data-period="${p.period}" value="${p.id}" >
                        <label class="form-check-label" for="plan_${p.id}">
                            <strong>${p.membership_name}</strong> - ${p.duration} ${p.period}<br>
                            Reg: ₹${p.registration_fees}, Coaching: ₹${p.coaching_fees}, Total: ₹${p.total_fees}
                        </label>
                    </div>`;
                    });
                } else html = `<p class="text-muted">No plans available for this center.</p>`;
                $("#planPreview").html(html);
            });

            /* ---------- 5. PLAN SELECTION ---------- */
            $(document).on("change", "input[name='plan_id']", function () {
                selectedPlanFees = parseFloat($(this).data("fees")) || 0;
                groupMemberCount = $('#groupForm').is(':visible') ? $('.group-member-row').length : 1;
                updatePaymentSummary();

                $("#planStartDate").val("");
                $("#planEndDate").val("");

                $("#planStartDate").off("change").on("change", function () {
                    const start = new Date($(this).val());
                    const dur = $(this).closest("input[name='plan_id']").data("duration");
                    const per = $(this).closest("input[name='plan_id']").data("period");
                    if (!start || !dur || !per) return;
                    const end = new Date(start);
                    if (per === "Month") end.setMonth(end.getMonth() + parseInt(dur));
                    if (per === "Year") end.setFullYear(end.getFullYear() + parseInt(dur));
                    if (per === "Day") end.setDate(end.getDate() + parseInt(dur));
                    $("#planEndDate").val(end.toISOString().split("T")[0]);
                });
            });

            /* ---------- DISCOUNT ---------- */
            $("#discountPercent").on("input", function () {
                discountPercent = parseFloat($(this).val()) || 0;
                updatePaymentSummary();
            });

            /* ---------- PAYMENT TYPE ---------- */
            $("#paymentType").on("change", function () {
                if ($(this).val() === "Installment") {
                    $("#installmentDetails").show();
                    $("#addPaymentBtn").show();
                } else {
                    $("#installmentDetails").hide();
                    $("#addPaymentBtn").hide();
                    $("#installmentTableBody").empty();
                }
            });

            /* ---------- ADD INSTALLMENT ROW ---------- */
            $("#addPaymentBtn").on("click", function () {
                const cnt = $("#installmentTableBody tr").length + 1;
                const row = `
                <tr>
                    <td>Installment ${cnt}</td>
                    <td><input type="number" class="form-control installment-amount" min="1" ></td>
                    <td><input type="date" class="form-control installment-date" ></td>
                </tr>`;
                $("#installmentTableBody").append(row);
            });

            /* ---------- FORM SUBMIT (GROUP + INDIVIDUAL) ---------- */
            $("#memberForm").on("submit", function (e) {
                e.preventDefault();

                const isGroup = $('#groupForm').is(':visible');
                groupMemberCount = isGroup ? $('.group-member-row').length : 1;
                const planTotal = selectedPlanFees * groupMemberCount;

                // Generate group ID
                const groupId = isGroup ? 'GRP-' + Date.now() + '-' + Math.floor(Math.random() * 1000) : null;

                // Collect group members
                const groupMembers = [];
                if (isGroup) {
                    $('.group-member-row').each(function (index) {
                        const row = $(this);
                        const rid = row.attr('id').replace('memberRow', '') || (index + 1);
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

                        const assignContainer = $(`#assignMemberFacilities_${rid}`);
                        if (assignContainer.length) {
                            assignContainer.find(`select[name='member_${rid}_facility[]']`).each(function (i) {
                                const fid = $(this).val();
                                const start = assignContainer.find(`input[name='member_${rid}_facility_start[]']`).eq(i).val();
                                const end = assignContainer.find(`input[name='member_${rid}_facility_end[]']`).eq(i).val();
                                if (fid) {
                                    member.facilities.push({
                                        id: fid,
                                        start_date: start,
                                        end_date: end,
                                        rent: window.currentFacilities.find(f => f.id == fid)?.rent || 0
                                    });
                                }
                            });
                        }

                        if (member.name || member.email) groupMembers.push(member);
                    });
                }

                let payload = {};

                if (isGroup && groupMembers.length > 0) {
                    payload = {
                        group: true,
                        group_id: groupId,
                        venue_id: $("#centerSelect").val(),
                        court_id: $("#courtSelect").val(),
                        slot_id: $("#slotSelect").val(),
                        plan_id: $("input[name='plan_id']:checked").val(),
                        plan_start_date: $("#planStartDate").val(),
                        plan_end_date: $("#planEndDate").val(),
                        plan_fees_per_member: selectedPlanFees,
                        total_plan_fees: planTotal,
                        members: groupMembers,
                        invoice_id: $("#invoiceId").val(),
                        invoice_date: $("#invoiceDate").val(),
                        discount_percent: $("#discountPercent").val(),
                        payment_type: $("#paymentType").val(),
                        total_amount: $("#totalAmount").text()
                    };
                } else {
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
                        document_path: $("#documentUpload").val() ? $("#documentUpload")[0].files[0].name : '',
                        venue_id: $("#centerSelect").val(),
                        court_id: $("#courtSelect").val(),
                        slot_id: $("#slotSelect").val(),
                        plan_id: $("input[name='plan_id']:checked").val(),
                        plan_start_date: $("#planStartDate").val(),
                        plan_end_date: $("#planEndDate").val(),
                        plan_fees: selectedPlanFees,
                        facilities: $("#selectedFacilities").val() ? $("#selectedFacilities").val().split(",").map(id => ({
                            id: id,
                            rent: parseFloat($("#facilityRent").val()) / $("#selectedFacilities").val().split(",").length,
                            start_date: $("#facilityStartDate").val(),
                            end_date: $("#facilityEndDate").val()
                        })) : [],
                        invoice_id: $("#invoiceId").val(),
                        invoice_date: $("#invoiceDate").val(),
                        discount_percent: $("#discountPercent").val(),
                        payment_type: $("#paymentType").val(),
                        total_amount: $("#totalAmount").text()
                    };
                }

                $.ajax({
                    url: "<?php echo base_url('api/member/register'); ?>",
                    type: "POST",
                    data: JSON.stringify(payload),
                    contentType: "application/json",
                    success: function (res) {
                        if (res.status === "success") {
                            Swal.fire('Success', isGroup ? `Group registered! ID: ${groupId}` : `Member registered! ID: ${res.member_id}`, 'success');
                            $("#memberForm")[0].reset();
                            $("#groupMembersContainer").empty();
                        } else {
                            Swal.fire('Group Added Successfully', res.message, 'Success');
                        }
                    },
                    error: function (err) {
                        console.error("API Error:", err);
                        Swal.fire('Failed', 'Failed to register.', 'error');
                    }
                });
            });

            /* ---------- MEMBER TYPE TOGGLE ---------- */
            $('#individualBtn').on('click', function () {
                $(this).addClass('active');
                $('#groupBtn').removeClass('active');
                $('#individualForm').show();
                $('#groupForm').hide();
                groupMemberCount = 1;
                updatePaymentSummary();
            });
            $('#groupBtn').on('click', function () {
                $(this).addClass('active');
                $('#individualBtn').removeClass('active');
                $('#individualForm').hide();
                $('#groupForm').show();
                if ($('.group-member-row').length === 0) addGroupMember();
                groupMemberCount = $('.group-member-row').length;
                updatePaymentSummary();
            });

            /* ---------- GROUP MEMBER ADD/REMOVE ---------- */
            let memberCount = 0;
            function addGroupMember() {
                memberCount++;
                const memberRow = `
                <div class="group-member-row" id="memberRow${memberCount}">
                    <h6>Member ${memberCount} <button type="button" class="remove-member" data-id="${memberCount}"><i class="fas fa-trash"></i></button></h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="groupMemberName${memberCount}" placeholder="Enter Full Name" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Gender <span class="text-danger">*</span></label>
                            <select class="form-control" name="groupMemberGender${memberCount}" >
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
                            <input type="email" class="form-control" name="groupMemberEmail${memberCount}" placeholder="Enter Email Address" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="groupMemberPhone${memberCount}" placeholder="Enter Phone Number" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="groupMemberDOB${memberCount}" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Blood Group</label>
                            <select class="form-control" name="groupMemberBloodGroup${memberCount}">
                                <option value="" selected disabled>Select Blood Group</option>
                                <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                                <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="groupMemberAddress${memberCount}" rows="2" placeholder="Enter Full Address" ></textarea>
                        </div>
                    </div>
                </div>`;
                $('#groupMembersContainer').append(memberRow);
                $(`#memberRow${memberCount} .remove-member`).on('click', function () {
                    $(`#memberRow${$(this).data('id')}`).remove();
                    groupMemberCount = $('.group-member-row').length;
                    updatePaymentSummary();
                    reorderMembers();
                });
                groupMemberCount = $('.group-member-row').length;
                updatePaymentSummary();
                renderGroupFacilityAssignments();
            }

            function reorderMembers() {
                const rows = $('.group-member-row');
                memberCount = 0;
                rows.each(function () {
                    memberCount++;
                    $(this).find('h6').html(`Member ${memberCount} <button type="button" class="remove-member" data-id="${memberCount}"><i class="fas fa-times"></i></button>`);
                    $(this).attr('id', `memberRow${memberCount}`);
                    $(this).find('.remove-member').data('id', memberCount);
                });
                renderGroupFacilityAssignments();
            }

            $('#addMemberBtn').on('click', addGroupMember);

            /* ---------- INVOICE DATE & ID ---------- */
            const today = new Date();
            $('#invoiceDate').val(today.toISOString().split('T')[0]);
            $('#invoiceId').val(`INV-${today.getTime()}-${Math.floor(Math.random() * 1000)}`);

            /* ---------- FACILITY TAB RENDER ---------- */
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if ($(e.target).attr('id') === 'facility-tab') renderGroupFacilityAssignments();
            });

            function renderGroupFacilityAssignments() {
                const cont = $('#groupFacilityAssignmentsContainer');
                cont.empty();
                const rows = $('.group-member-row');
                if (!rows.length) { $('#groupFacilityAssignments').hide(); return; }
                $('#groupFacilityAssignments').show();

                rows.each(function (idx) {
                    const el = $(this);
                    const rid = el.attr('id').replace('memberRow', '') || (idx + 1);
                    const name = el.find(`input[name='groupMemberName${rid}']`).val() || `Member ${rid}`;

                    const block = $(`
                    <div class="assign-block border p-3 mb-2" id="assignMember_${rid}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><strong>${name}</strong></div>
                            <div><button type="button" class="btn btn-sm btn-outline-secondary add-assignment" data-member-id="${rid}"><i class="fas fa-plus mr-1"></i> Add Facility</button></div>
                        </div>
                        <div id="assignMemberFacilities_${rid}" class="mt-3"></div>
                    </div>`);
                    cont.append(block);

                    block.find('.add-assignment').on('click', function () {
                        window.activeAssignMemberId = $(this).data('member-id');
                        $('a#facility-tab').tab('show');
                        Swal.fire({ icon: 'info', title: 'Select Facility', text: `Click any facility to assign to ${name}`, timer: 2000, showConfirmButton: false });
                        setTimeout(() => {
                            $('#facilityPreview')[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                            $('.facility-card').css({ 'outline': '3px dashed #007bff' });
                        }, 200);
                    });
                });
            }

            $(document).on('click', '.facility-card', function (e) {
                if (!window.activeAssignMemberId) return;
                e.preventDefault(); e.stopPropagation();
                const fid = $(this).data('id');
                const mid = window.activeAssignMemberId;
                addFacilityToMember(mid, fid);
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Facility assigned', timer: 1500, showConfirmButton: false });
            });

            function addFacilityToMember(memberId, facilityId) {
                const cont = $(`#assignMemberFacilities_${memberId}`);
                if (!cont.length) return;
                const idx = cont.find('.member-facility-row').length;
                const row = $(`
                <div class="member-facility-row d-flex align-items-center mb-2">
                    <select class="form-control mr-2" name="member_${memberId}_facility[]">${getFacilitiesOptionsHtml()}</select>
                    <input type="date" class="form-control mr-2" name="member_${memberId}_facility_start[]" />
                    <input type="date" class="form-control mr-2" name="member_${memberId}_facility_end[]" />
                    <button type="button" class="btn btn-danger btn-sm remove-member-facility"><i class="fas fa-times"></i></button>
                </div>`);
                row.find('.remove-member-facility').on('click', () => row.remove());
                cont.append(row);
                if (facilityId) row.find('select').val(facilityId);
                window.activeAssignMemberId = null;
                $('.facility-card').css({ 'outline': '' });
            }

            $('.custom-file-input').on('change', function () {
                const fn = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fn);
            });
        });
    </script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>