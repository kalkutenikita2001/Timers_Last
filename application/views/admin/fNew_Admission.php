<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Member Registration</title>
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

        /* Make all Font Awesome icons red */
        i.fas,
        i.far,
        i.fab {
            color: var(--accent) !important;
        }

        /* Keep trash icons their default color */
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
    <?php $this->load->view('admin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('admin/Include/Navbar') ?>
    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid mt-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user-plus mr-2"></i> Member Registration</h4>
                </div>
                <div class="card-body">
                    <!-- Personal Details -->
                    <h5 class="mb-3"><i class="fas fa-user mr-2 text-primary"></i>Personal Details</h5>
                    <form id="memberForm">
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
                                <input type="tel" class="form-control" id="memberPhone" placeholder="Enter Phone Number" required>
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
                                <input type="tel" class="form-control" id="memberAltPhone" placeholder="Enter Alternate Phone Number">
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
                                            <option>ABC Sports Arena - Pune</option>
                                            <option>XYZ Fitness Center - Mumbai</option>
                                            <option>PQR Gym - Delhi</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a center.</div>
                                    </div>
                                </div>

                                <div id="slotSelection" class="mt-4" style="display: none;">
                                    <h6>Available Slots</h6>
                                    <div id="courtSlotsView" class="mt-3">
                                        <!-- Dynamic slot content will appear here -->
                                    </div>
                                    <div class="invalid-feedback" id="slotError" style="display: none;">Please select a time slot.</div>

                                    <div class="form-row mt-4">
                                        <div class="form-group col-md-6">
                                            <label>Select Category <span class="text-danger">*</span></label>
                                            <select class="form-control" id="categorySelect" required>
                                                <option value="" selected disabled>Select Category</option>
                                                <option>Regular</option>
                                                <option>Premium</option>
                                                <option>VIP</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a category.</div>
                                        </div>
                                    </div>

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
                                    <div id="facilityPreview" class="mt-3">
                                        <!-- Dynamic facility content will appear here -->
                                    </div>
                                    <div class="invalid-feedback" id="facilityError" style="display: none;">Please select a facility.</div>
                                </div>

                                <div class="form-row mt-4">
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
                                    <div class="form-group col-md-4">
                                        <label>Rent</label>
                                        <input type="text" class="form-control" id="facilityRent" readonly>
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
                                                <!-- <th>Status</th> -->
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
            // Sidebar toggle functionality
            $('#toggleSidebar').on('click', function() {
                $('.sidebar').toggleClass('minimized');
                $('.navbar').toggleClass('sidebar-minimized');
                $('#contentWrapper').toggleClass('minimized');
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

            // Center selection - show slots
            $('#centerSelect').on('change', function() {
                if ($(this).val()) {
                    $('#slotSelection').show();
                    renderCourtSlots();
                    $(this).removeClass('is-invalid');
                } else {
                    $('#slotSelection').hide();
                    $('#planSelection').hide();
                }
            });

            // Category selection - show plans
            $('#categorySelect').on('change', function() {
                if ($(this).val()) {
                    $('#planSelection').show();
                    renderPlans();
                    $(this).removeClass('is-invalid');
                } else {
                    $('#planSelection').hide();
                }
            });

            // Plan start date change - calculate end date
            $('#planStartDate').on('change', function() {
                const selectedPlan = $('.plan-block.selected');
                if (selectedPlan.length > 0) {
                    const duration = selectedPlan.data('duration');
                    const period = selectedPlan.data('period');
                    const startDate = new Date($(this).val());

                    if (startDate && duration) {
                        const endDate = new Date(startDate);

                        if (period === 'Month') {
                            endDate.setMonth(endDate.getMonth() + parseInt(duration));
                        } else if (period === 'Week') {
                            endDate.setDate(endDate.getDate() + (parseInt(duration) * 7));
                        } else if (period === 'Year') {
                            endDate.setFullYear(endDate.getFullYear() + parseInt(duration));
                        }

                        $('#planEndDate').val(endDate.toISOString().split('T')[0]);
                        $(this).removeClass('is-invalid');
                    }
                }
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

                updatePaymentSummary(); // ADD THIS LINE
            });

            // Generate installment plan
            // Generate installment plan
            function generateInstallmentPlan() {
                const totalAmount = parseInt($('#totalAmount').text()) || 0;
                if (totalAmount === 0) return;

                const today = new Date();
                const tableBody = $('#installmentTableBody');
                tableBody.empty();

                // Create 4 installments
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

            // Render court slots
            function renderCourtSlots() {
                const courts = [{
                        name: 'Court 1',
                        category: 'Badminton'
                    },
                    {
                        name: 'Court 2',
                        category: 'Tennis'
                    },
                    {
                        name: 'Court 3',
                        category: 'Squash'
                    }
                ];

                const slots = [{
                        from: '06:00',
                        to: '08:00',
                        name: 'Morning Slot'
                    },
                    {
                        from: '08:00',
                        to: '10:00',
                        name: 'Morning Slot'
                    },
                    {
                        from: '16:00',
                        to: '18:00',
                        name: 'Evening Slot'
                    },
                    {
                        from: '18:00',
                        to: '20:00',
                        name: 'Evening Slot'
                    }
                ];

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
                            <div class="slot-box" data-from="${slot.from}" data-to="${slot.to}">
                                ${formatTime(slot.from)} - ${formatTime(slot.to)}<br><small>${slot.name}</small>
                            </div>
                        `);
                        courtDiv.find('.slot-grid').append(slotBox);
                    });

                    container.append(courtDiv);
                });

                // Add click event to slot boxes
                $('.slot-box').on('click', function() {
                    $('.slot-box').removeClass('selected');
                    $(this).addClass('selected');
                    $('#slotError').hide();
                });
            }

            // Render plans based on category
            function renderPlans() {
                const category = $('#categorySelect').val();
                let plans = [];

                if (category === 'Regular') {
                    plans = [{
                            name: 'Basic Monthly',
                            duration: 1,
                            period: 'Month',
                            price: 1500,
                            registration: 500,
                            coaching: 0
                        },
                        {
                            name: 'Basic Quarterly',
                            duration: 3,
                            period: 'Month',
                            price: 4000,
                            registration: 500,
                            coaching: 0
                        },
                        {
                            name: 'Basic Yearly',
                            duration: 1,
                            period: 'Year',
                            price: 12000,
                            registration: 500,
                            coaching: 0
                        }
                    ];
                } else if (category === 'Premium') {
                    plans = [{
                            name: 'Premium Monthly',
                            duration: 1,
                            period: 'Month',
                            price: 2500,
                            registration: 1000,
                            coaching: 500
                        },
                        {
                            name: 'Premium Quarterly',
                            duration: 3,
                            period: 'Month',
                            price: 7000,
                            registration: 1000,
                            coaching: 500
                        },
                        {
                            name: 'Premium Yearly',
                            duration: 1,
                            period: 'Year',
                            price: 20000,
                            registration: 1000,
                            coaching: 500
                        }
                    ];
                } else if (category === 'VIP') {
                    plans = [{
                            name: 'VIP Monthly',
                            duration: 1,
                            period: 'Month',
                            price: 4000,
                            registration: 1500,
                            coaching: 1000
                        },
                        {
                            name: 'VIP Quarterly',
                            duration: 3,
                            period: 'Month',
                            price: 11000,
                            registration: 1500,
                            coaching: 1000
                        },
                        {
                            name: 'VIP Yearly',
                            duration: 1,
                            period: 'Year',
                            price: 35000,
                            registration: 1500,
                            coaching: 1000
                        }
                    ];
                }

                const container = $('#planPreview');
                container.empty();

                plans.forEach(plan => {
                    const planDiv = $(`
                        <div class="plan-block mb-3" data-duration="${plan.duration}" data-period="${plan.period}" data-price="${plan.price}" data-registration="${plan.registration}" data-coaching="${plan.coaching}">
                            <h5>${plan.name}</h5>
                            <p>Duration: ${plan.duration} ${plan.period}</p>
                            <p>Price: ₹${plan.price}</p>
                            <p>Registration: ₹${plan.registration}</p>
                            <p>Coaching: ₹${plan.coaching}</p>
                        </div>
                    `);

                    container.append(planDiv);
                });

                // Add click event to plan blocks
                $('.plan-block').on('click', function() {
                    $('.plan-block').removeClass('selected');
                    $(this).addClass('selected');

                    // Update plan fees in payment summary
                    const planPrice = $(this).data('price');
                    $('#planFees').text(planPrice);
                    updatePaymentSummary();

                    // Clear and enable date fields
                    $('#planStartDate').val('');
                    $('#planEndDate').val('');
                    $('#planStartDate').prop('disabled', false);

                    $('#planError').hide();
                });
            }

            // Render facilities
            function renderFacilities() {
                const facilities = [{
                        name: 'Badminton Court',
                        type: 'Sports',
                        rent: 1500,
                        description: 'Professional badminton court with wooden flooring'
                    },
                    {
                        name: 'Swimming Pool',
                        type: 'Aquatic',
                        rent: 2000,
                        description: 'Olympic size swimming pool with trained instructors'
                    },
                    {
                        name: 'Gym',
                        type: 'Fitness',
                        rent: 1000,
                        description: 'Fully equipped gym with modern equipment'
                    },
                    {
                        name: 'Yoga Studio',
                        type: 'Wellness',
                        rent: 1200,
                        description: 'Peaceful yoga studio with certified instructors'
                    },
                    {
                        name: 'Squash Court',
                        type: 'Sports',
                        rent: 1300,
                        description: 'Professional squash court with glass walls'
                    },
                    {
                        name: 'Basketball Court',
                        type: 'Sports',
                        rent: 1800,
                        description: 'Full-size basketball court with floodlights'
                    }
                ];

                const container = $('#facilityPreview');
                container.empty();

                facilities.forEach(facility => {
                    const facilityDiv = $(`
                        <div class="facility-block mb-3" data-name="${facility.name}" data-rent="${facility.rent}">
                            <h5>${facility.name} - <small>${facility.type}</small></h5>
                            <p>${facility.description}</p>
                            <p>Rent: ₹${facility.rent}/month</p>
                        </div>
                    `);

                    container.append(facilityDiv);
                });

                // Add click event to facility blocks
                $('.facility-block').on('click', function() {
                    $('.facility-block').removeClass('selected');
                    $(this).addClass('selected');

                    // Update facility rent in form and payment summary
                    const facilityRent = $(this).data('rent');
                    const facilityName = $(this).data('name');
                    $('#facilityRent').val('₹ ' + facilityRent);
                    $('#facilityFees').text(facilityRent);
                    updatePaymentSummary(); // ADD THIS LINE

                    $('#facilityError').hide();
                });
            }

            // Call renderFacilities on page load for the facility tab
            renderFacilities();

            // Format time to 12-hour format
            function formatTime(time) {
                if (!time) return '';
                let [h, m] = time.split(':');
                h = parseInt(h);
                const ampm = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                return `${("0"+h).slice(-2)}:${m} ${ampm}`;
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

                // Regenerate installment plan if installment tab is visible
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

            // Form submission with comprehensive validation
            $('#memberForm').on('submit', function(e) {
                e.preventDefault();

                // Reset all validation states
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                let isValid = true;

                // Validate personal details
                const requiredFields = [
                    '#memberName', '#memberGender', '#memberEmail', '#memberPhone',
                    '#memberDOB', '#memberAddress', '#memberJoiningDate'
                ];

                requiredFields.forEach(field => {
                    if (!$(field).val()) {
                        $(field).addClass('is-invalid');
                        isValid = false;
                    }
                });

                // Validate email format
                const email = $('#memberEmail').val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    $('#memberEmail').addClass('is-invalid');
                    isValid = false;
                }

                // Validate phone number (basic validation)
                const phone = $('#memberPhone').val();
                const phoneRegex = /^\d{10}$/;
                if (phone && !phoneRegex.test(phone)) {
                    $('#memberPhone').addClass('is-invalid');
                    isValid = false;
                }

                // Validate subscription tab if active
                if ($('#subscription-tab').hasClass('active')) {
                    if (!$('#centerSelect').val()) {
                        $('#centerSelect').addClass('is-invalid');
                        isValid = false;
                    }

                    if (!$('.slot-box.selected').length) {
                        $('#slotError').show();
                        isValid = false;
                    }

                    if (!$('#categorySelect').val()) {
                        $('#categorySelect').addClass('is-invalid');
                        isValid = false;
                    }

                    if (!$('.plan-block.selected').length) {
                        $('#planError').show();
                        isValid = false;
                    }

                    if (!$('#planStartDate').val()) {
                        $('#planStartDate').addClass('is-invalid');
                        isValid = false;
                    }
                }

                // Validate facility tab if active
                if ($('#facility-tab').hasClass('active')) {
                    if (!$('.facility-block.selected').length) {
                        $('#facilityError').show();
                        isValid = false;
                    }

                    if (!$('#facilityStartDate').val()) {
                        $('#facilityStartDate').addClass('is-invalid');
                        isValid = false;
                    }

                    if (!$('#facilityEndDate').val()) {
                        $('#facilityEndDate').addClass('is-invalid');
                        isValid = false;
                    }
                }

                // Validate payment tab if active
                if ($('#payment-tab').hasClass('active')) {
                    if (!$('#paymentType').val()) {
                        $('#paymentType').addClass('is-invalid');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill all required fields correctly.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Member Registered!',
                    text: 'Member details have been saved successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            // File input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Real-time validation for email
            $('#memberEmail').on('blur', function() {
                const email = $(this).val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailRegex.test(email)) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Real-time validation for phone
            $('#memberPhone').on('blur', function() {
                const phone = $(this).val();
                const phoneRegex = /^\d{10}$/;
                if (phone && !phoneRegex.test(phone)) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>