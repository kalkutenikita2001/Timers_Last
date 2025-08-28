<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admission</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f4f6f8 !important;
            margin: 0;
            font-family: 'Montserrat', serif !important;
            font-style: normal;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            background-color: #333;
            color: white;
            padding-top: 20px;
            transition: all 0.3s ease-in-out;
        }

        .sidebar.minimized {
            width: 60px;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            color: white;
            padding: 10px;
            transition: left 0.3s ease-in-out;
        }

        .navbar.sidebar-minimized {
            left: 60px;
        }

        /* Content */
        .content-wrapper {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        /* Mobile Sidebar Overlay */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
                z-index: 1000;
            }

            .navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
                padding: 70px 15px 15px 15px;
            }
        }

        @media (max-width: 576px) {
            .stepper {
                margin: 0 10px !important;
                flex-wrap: wrap;
            }

            .step {
                flex: 1 1 50%;
                margin-bottom: 10px;
            }

            .line {
                display: none;
            }

            .form-row .form-group {
                margin-bottom: 15px;
            }

            .facility-card {
                margin-bottom: 20px;
            }
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            color: #fff !important;
        }

        /* Buttons Primary */
        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            border: none !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Stepper */
        .stepper {
            display: flex;
            align-items: center;
            margin: 0 200px;
            justify-content: space-between;
        }

        .step {
            text-align: center;
            position: relative;
            flex: 1;
        }

        .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #ccc;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
            font-weight: bold;
        }

        .step.active .circle {
            background: #b30000;
        }

        .label {
            font-size: 14px;
            margin-top: 5px;
        }

        .line {
            flex: 1;
            height: 2px;
            background: #ccc;
            margin: 0 15px;
            margin-bottom: 20px;
        }

        .step.active~.line {
            background: #b30000;
        }

        /* Facility Cards */
        .facility-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .facility-card:hover {
            border-color: #b30000;
            box-shadow: 0 0 10px rgba(179, 0, 0, 0.2);
        }

        .facility-card.selected {
            border-color: #b30000;
            background-color: rgba(179, 0, 0, 0.05);
        }

        .facility-price {
            font-weight: bold;
            color: #b30000;
        }

        .facility-details {
            display: none;
            margin-top: 10px;
        }

        .facility-toggle {
            cursor: pointer;
            color: #b30000;
        }

        .facility-status {
            font-size: 12px;
            color: #555;
        }

        .facility-unavailable {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Batch time styling */
        .batch-time-container {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 3px solid #b30000;
        }

        .time-slot {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .time-slot span {
            margin-left: 10px;
        }

        .batch-days {
            margin-top: 10px;
        }

        .day-checkbox {
            margin-right: 5px;
        }

        /* Validation Styles */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: none;
            color: #dc3545;
            font-size: 12px;
        }

        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <!-- Main Content Wrapper -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="container">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0"><i class="fas fa-user-graduate mr-2"></i>Student Admission Form</h4>
                        </div>
                        <div class="card-body">

                            <!-- Stepper -->
                            <div class="stepper d-flex justify-content-center mb-4">
                                <div class="step active">
                                    <div class="circle">1</div>
                                    <div class="label">Personal</div>
                                </div>
                                <div class="line"></div>
                                <div class="step">
                                    <div class="circle">2</div>
                                    <div class="label">Batch</div>
                                </div>
                                <div class="line"></div>
                                <div class="step">
                                    <div class="circle">3</div>
                                    <div class="label">Facilities</div>
                                </div>
                                <div class="line"></div>
                                <div class="step">
                                    <div class="circle">4</div>
                                    <div class="label">Fees</div>
                                </div>
                            </div>

                            <form id="admissionForm" novalidate>
                                <div class="tab-content">

                                    <!-- Step 1: Personal Information -->
                                    <div class="tab-pane fade show active" id="step1">
                                        <div class="form-row">
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-user"></i> Name *</label>
                                                <input type="text" class="form-control" name="studentName" placeholder="Enter student name" required>
                                                <div class="invalid-feedback">Please enter a valid name.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-mobile-alt"></i> Contact (Whatsapp) *</label>
                                                <input type="text" class="form-control" name="contact" placeholder="Enter 10-digit phone number" pattern="[6-9][0-9]{9}" maxlength="10" required>
                                                <div class="invalid-feedback">Please enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-user-friends"></i> Parent Name *</label>
                                                <input type="text" class="form-control" name="parentName" placeholder="Enter parent name" required>
                                                <div class="invalid-feedback">Please enter a valid parent name.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-phone-alt"></i> Emergency Contact *</label>
                                                <input type="text" class="form-control" name="emergencyContact" placeholder="Enter 10-digit emergency contact" pattern="[6-9][0-9]{9}" maxlength="10" required>
                                                <div class="invalid-feedback">Please enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-envelope"></i> Email</label>
                                                <input type="email" class="form-control" name="email" placeholder="Enter email address">
                                                <div class="invalid-feedback">Please enter a valid email address.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-calendar-alt"></i> Date of Birth *</label>
                                                <input type="date" class="form-control" name="dob" placeholder="Select date of birth" required max="<?php echo date('Y-m-d'); ?>">
                                                <div class="invalid-feedback">Please select a valid date of birth.</div>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12">
                                                <label><i class="fas fa-home"></i> Address *</label>
                                                <textarea class="form-control" name="address" rows="2" placeholder="Enter full address" required></textarea>
                                                <div class="invalid-feedback">Please enter a valid address.</div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-primary next1">Next <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Batch Information -->
                                    <div class="tab-pane fade" id="step2">
                                        <div class="form-row">
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-university"></i> Center *</label>
                                                <select class="form-control" id="centerSelect" name="center" required>
                                                    <option value="">Select Center</option>
                                                    <!-- Populated by JavaScript -->
                                                </select>
                                                <div class="invalid-feedback">Please select a center.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-users"></i> Batch *</label>
                                                <select class="form-control" id="batchSelect" name="batch" required>
                                                    <option value="">Select Batch</option>
                                                    <!-- Populated by JavaScript -->
                                                </select>
                                                <div class="invalid-feedback">Please select a batch.</div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div id="batchTimeInfo" class="batch-time-container">
                                                    <h6><i class="fas fa-clock"></i> Batch Schedule</h6>
                                                    <div id="batchTimeSlots"></div>
                                                    <div class="batch-days" id="batchDays"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-layer-group"></i> Category *</label>
                                                <select class="form-control" id="categorySelect" name="category" required>
                                                    <option value="">Select Category</option>
                                                    <!-- Populated by JavaScript -->
                                                </select>
                                                <div class="invalid-feedback">Please select a category.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-chalkboard-teacher"></i> Coach *</label>
                                                <input type="text" class="form-control" name="coach" placeholder="Enter coach name" required>
                                                <div class="invalid-feedback">Please enter a valid coach name.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-user-tie"></i> Coordinator *</label>
                                                <input type="text" class="form-control" name="coordinator" placeholder="Enter coordinator name" required>
                                                <div class="invalid-feedback">Please enter a valid coordinator name.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-user-tie"></i> Coordinator Phone *</label>
                                                <input type="text" class="form-control" name="coordinatorPhone" placeholder="Enter 10-digit phone number" pattern="[6-9][0-9]{9}" maxlength="10" required>
                                                <div class="invalid-feedback">Please enter a valid 10-digit Indian phone number starting with 6, 7, 8, or 9.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-clock"></i> Batch Time *</label>
                                                <input type="time" class="form-control" name="batchTime" placeholder="Select batch time" required>
                                                <div class="invalid-feedback">Please select a valid batch time.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-clock"></i> Duration *</label>
                                                <select class="form-control" name="duration" required>
                                                    <option value="">Select Duration</option>
                                                    <option value="1">1 hour</option>
                                                    <option value="1.5">1.5 hours</option>
                                                    <option value="2">2 hours</option>
                                                    <option value="2.5">2.5 hours</option>
                                                    <option value="3">3 hours</option>
                                                    <option value="4">4 hours</option>
                                                </select>
                                                <div class="invalid-feedback">Please select a duration.</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary back1"><i class="fas fa-arrow-left"></i> Back</button>
                                            <button type="button" class="btn btn-primary next2">Next <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Facilities -->
                                    <div class="tab-pane fade" id="step3">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> Select additional facilities for the student. These will be added to the total fees.
                                        </div>
                                        <div class="row" id="facilitiesContainer">
                                            <!-- Locker Facility -->
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <div class="facility-card" data-facility="locker">
                                                    <div class="form-check">
                                                        <input class="form-check-input facility-checkbox" type="checkbox" id="lockerCheckbox" data-price="500">
                                                        <label class="form-check-label" for="lockerCheckbox">
                                                            <strong><i class="fas fa-lock"></i> Locker</strong>
                                                        </label>
                                                        <span class="facility-price float-right">₹500/semester</span>
                                                    </div>
                                                    <div class="facility-status mt-1" id="lockerStatus">Checking availability...</div>
                                                    <div class="facility-details mt-2">
                                                        <div class="form-group">
                                                            <label>Locker Size</label>
                                                            <select class="form-control locker-size">
                                                                <option value="500">Small (₹500)</option>
                                                                <option value="750">Medium (₹750)</option>
                                                                <option value="1000">Large (₹1,000)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Locker Number</label>
                                                            <select class="form-control locker-number" disabled>
                                                                <option value="">Select Locker Number</option>
                                                                <!-- Populated by JavaScript -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="facility-toggle">Show details <i class="fas fa-chevron-down"></i></div>
                                                </div>
                                            </div>
                                            <!-- Racket Facility -->
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <div class="facility-card" data-facility="racket">
                                                    <div class="form-check">
                                                        <input class="form-check-input facility-checkbox" type="checkbox" id="racketCheckbox" data-price="300">
                                                        <label class="form-check-label" for="racketCheckbox">
                                                            <strong><i class="fas fa-table-tennis"></i> Racket Rental</strong>
                                                        </label>
                                                        <span class="facility-price float-right">₹300/month</span>
                                                    </div>
                                                    <div class="facility-details mt-2">
                                                        <div class="form-group">
                                                            <label>Racket Type</label>
                                                            <select class="form-control racket-type">
                                                                <option value="300">Standard (₹300)</option>
                                                                <option value="500">Professional (₹500)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Duration (months)</label>
                                                            <input type="number" class="form-control racket-months" value="1" min="1" placeholder="Enter months" required>
                                                            <div class="invalid-feedback">Please enter a valid duration (at least 1 month).</div>
                                                        </div>
                                                    </div>
                                                    <div class="facility-toggle">Show details <i class="fas fa-chevron-down"></i></div>
                                                </div>
                                            </div>
                                            <!-- Shoe Facility -->
                                            <div class="col-md-4 col-sm-12 mb-3">
                                                <div class="facility-card" data-facility="shoe">
                                                    <div class="form-check">
                                                        <input class="form-check-input facility-checkbox" type="checkbox" id="shoeCheckbox" data-price="200">
                                                        <label class="form-check-label" for="shoeCheckbox">
                                                            <strong><i class="fas fa-shoe-prints"></i> Shoe Rental</strong>
                                                        </label>
                                                        <span class="facility-price float-right">₹200/month</span>
                                                    </div>
                                                    <div class="facility-details mt-2">
                                                        <div class="form-group">
                                                            <label>Shoe Size</label>
                                                            <select class="form-control shoe-size">
                                                                <option value="200">Standard (₹200)</option>
                                                                <option value="300">Premium (₹300)</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Duration (months)</label>
                                                            <input type="number" class="form-control shoe-months" value="1" min="1" placeholder="Enter months" required>
                                                            <div class="invalid-feedback">Please enter a valid duration (at least 1 month).</div>
                                                        </div>
                                                    </div>
                                                    <div class="facility-toggle">Show details <i class="fas fa-chevron-down"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mt-4">
                                            <div class="card-header">
                                                <h5 class="mb-0"><i class="fas fa-receipt"></i> Facilities Summary</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm" id="facilitiesSummary">
                                                    <thead>
                                                        <tr>
                                                            <th>Facility</th>
                                                            <th>Details</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Populated by JavaScript -->
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2" class="text-right">Additional Facilities Total:</th>
                                                            <th class="text-right" id="facilitiesTotal">₹0</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-secondary back2"><i class="fas fa-arrow-left"></i> Back</button>
                                            <button type="button" class="btn btn-primary next3">Next <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </div>

                                    <!-- Step 4: Fees -->
                                    <div class="tab-pane fade" id="step4">
                                        <div class="form-row">
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-book"></i> Course Fees *</label>
                                                <input type="number" id="courseFees" name="courseFees" class="form-control" value="0" min="0" placeholder="Enter course fees" required>
                                                <div class="invalid-feedback">Please enter a valid course fee.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-plus-circle"></i> Additional Facilities Fees</label>
                                                <input type="number" id="additionalFees" name="additionalFees" class="form-control" readonly placeholder="Calculated automatically">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-calendar-alt"></i> Date of Admission *</label>
                                                <input type="date" id="admissionDate" name="admissionDate" class="form-control" readonly placeholder="Today's date">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-calendar-check"></i> Date of Joining *</label>
                                                <input type="date" id="joiningDate" name="joiningDate" class="form-control" required min="<?php echo date('Y-m-d'); ?>" placeholder="Select joining date">
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i> From joining date student will be active.
                                                </small>
                                                <div class="invalid-feedback">Please select a valid joining date.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-wallet"></i> Total Fees *</label>
                                                <input type="number" id="totalFees" name="totalFees" class="form-control" readonly placeholder="Calculated automatically">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-money-check-alt"></i> Amount Paid *</label>
                                                <input type="number" id="paidAmount" name="paidAmount" class="form-control" min="0" placeholder="Enter amount paid" required>
                                                <div class="invalid-feedback">Please enter a valid amount paid.</div>
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-balance-scale"></i> Remaining Amount *</label>
                                                <input type="number" id="remainingAmount" name="remainingAmount" class="form-control" readonly placeholder="Calculated automatically">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label><i class="fas fa-credit-card"></i> Payment Method *</label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" value="Cash" required>
                                                    <label class="form-check-label">Cash</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="paymentMethod" value="Online">
                                                    <label class="form-check-label">Online</label>
                                                </div>
                                                <div class="invalid-feedback">Please select a payment method.</div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary back3"><i class="fas fa-arrow-left"></i> Back</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-receipt"></i> Generate Receipt
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle('active');
                        navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                    } else {
                        const isMinimized = sidebar.classList.toggle('minimized');
                        navbar.classList.toggle('sidebar-minimized', isMinimized);
                        contentWrapper.classList.toggle('minimized', isMinimized);
                    }
                });
            }
        });
    </script>

    <!-- Stepper Navigation -->
    <script>
        function setStep(step) {
            $(".tab-pane").removeClass("show active");
            $("#step" + step).addClass("show active");
            $(".step").removeClass("active");
            $(".step").each(function(index) {
                if (index < step) {
                    $(this).addClass("active");
                }
            });
        }

        $(".next1").click(function() {
            if (validateStep(1)) setStep(2);
        });
        $(".next2").click(function() {
            if (validateStep(2)) setStep(3);
        });
        $(".next3").click(function() {
            if (validateStep(3)) setStep(4);
        });
        $(".back1").click(() => setStep(1));
        $(".back2").click(() => setStep(2));
        $(".back3").click(() => setStep(3));
    </script>

    <!-- Form Validation -->
    <script>
        function validateStep(step) {
            let isValid = true;
            const fields = $(`#step${step} [required]`);
            fields.each(function() {
                const field = $(this);
                field.removeClass('is-invalid');
                if (!field.val()) {
                    field.addClass('is-invalid');
                    isValid = false;
                } else {
                    if (field.attr('type') === 'text' && !field.val().trim()) {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                    if (field.attr('type') === 'email' && field.val() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.val())) {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                    if (field.attr('name') === 'contact' || field.attr('name') === 'emergencyContact' || field.attr('name') === 'coordinatorPhone') {
                        if (!/^[6-9][0-9]{9}$/.test(field.val())) {
                            field.addClass('is-invalid');
                            isValid = false;
                        }
                    }
                    if (field.attr('type') === 'number' && field.val() < 0) {
                        field.addClass('is-invalid');
                        isValid = false;
                    }
                }
            });
            if (step === 4 && !$('input[name="paymentMethod"]:checked').val()) {
                $('input[name="paymentMethod"]').closest('.form-group').find('.invalid-feedback').show();
                isValid = false;
            } else {
                $('input[name="paymentMethod"]').closest('.form-group').find('.invalid-feedback').hide();
            }
            return isValid;
        }

        $(document).ready(function() {
            $('#admissionForm input, #admissionForm select').on('input change', function() {
                $(this).removeClass('is-invalid');
                if ($(this).attr('required') && !$(this).val()) {
                    $(this).addClass('is-invalid');
                } else if ($(this).attr('name') === 'contact' || $(this).attr('name') === 'emergencyContact' || $(this).attr('name') === 'coordinatorPhone') {
                    if (!/^[6-9][0-9]{9}$/.test($(this).val())) {
                        $(this).addClass('is-invalid');
                    }
                }
            });
        });
    </script>

    <!-- Date Handling -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let today = new Date().toISOString().split('T')[0];
            let admissionDateInput = document.getElementById("admissionDate");
            let joiningDateInput = document.getElementById("joiningDate");

            admissionDateInput.value = today;
            joiningDateInput.setAttribute("min", today);

            // Fetch centers and categories on page load
            fetchCenters();
            fetchCategories();
        });
    </script>

    <!-- Fetch Centers, Batches, Categories, and Lockers -->
    <script>
        function fetchCenters() {
            $.ajax({
                url: '<?= base_url('admission/get_centers') ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const centerSelect = $('#centerSelect');
                    centerSelect.empty().append('<option value="">Select Center</option>');
                    data.forEach(center => {
                        centerSelect.append(`<option value="${center.id}">${center.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch centers');
                }
            });
        }

        function fetchCategories() {
            $.ajax({
                url: '<?= base_url('admission/get_categories') ?>',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const categorySelect = $('#categorySelect');
                    categorySelect.empty().append('<option value="">Select Category</option>');
                    data.forEach(category => {
                        categorySelect.append(`<option value="${category}">${category}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch categories');
                }
            });
        }

        function fetchLockers(centerId) {
            $.ajax({
                url: '<?= base_url('admission/get_lockers/') ?>' + centerId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const lockerSelect = $('.locker-number');
                    const lockerStatus = $('#lockerStatus');
                    lockerSelect.empty().append('<option value="">Select Locker Number</option>');
                    if (data.length === 0) {
                        lockerStatus.text('No lockers available');
                        $('#lockerCheckbox').prop('disabled', true).closest('.facility-card').addClass('facility-unavailable');
                    } else {
                        lockerStatus.text(`${data.filter(l => !l.is_booked).length} lockers available`);
                        $('#lockerCheckbox').prop('disabled', false).closest('.facility-card').removeClass('facility-unavailable');
                        data.forEach(locker => {
                            const status = locker.is_booked ? ' (Booked)' : ' (Available)';
                            lockerSelect.append(`<option value="${locker.locker_no}" ${locker.is_booked ? 'disabled' : ''}>${locker.locker_no}${status}</option>`);
                        });
                    }
                    lockerSelect.prop('disabled', false);
                },
                error: function() {
                    $('#lockerStatus').text('Error fetching lockers');
                    $('#lockerCheckbox').prop('disabled', true).closest('.facility-card').addClass('facility-unavailable');
                }
            });
        }

        $('#centerSelect').change(function() {
            const centerId = $(this).val();
            const batchSelect = $('#batchSelect');
            const batchTimeInfo = $('#batchTimeInfo');
            batchSelect.empty().append('<option value="">Select Batch</option>');
            batchTimeInfo.hide();
            $('#lockerStatus').text('Select a center to check locker availability');
            $('.locker-number').prop('disabled', true);

            if (centerId) {
                $.ajax({
                    url: '<?= base_url('admission/get_batches/') ?>' + centerId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        data.forEach(batch => {
                            batchSelect.append(`<option value="${batch.id}" data-timing="${batch.timing}" data-days="${batch.days}">${batch.timing} (${batch.category})</option>`);
                        });
                        fetchLockers(centerId);
                    },
                    error: function() {
                        alert('Failed to fetch batches');
                    }
                });
            }
        });

        $('#batchSelect').change(function() {
            const batchTimeInfo = $('#batchTimeInfo');
            const batchTimeSlots = $('#batchTimeSlots');
            const batchDays = $('#batchDays');
            batchTimeSlots.empty();
            batchDays.empty();
            batchTimeInfo.hide();

            const selectedOption = $(this).find('option:selected');
            const timing = selectedOption.data('timing');
            const days = selectedOption.data('days') ? selectedOption.data('days').split(',') : [];

            if (timing) {
                batchTimeSlots.append(`
                    <div class="time-slot">
                        <i class="fas fa-play-circle text-success"></i>
                        <span>Timing: ${timing}</span>
                    </div>
                `);
                batchDays.append('<strong>Days:</strong><br>');
                days.forEach(day => {
                    batchDays.append(`
                        <div class="form-check form-check-inline">
                            <input class="form-check-input day-checkbox" type="checkbox" checked disabled>
                            <label class="form-check-label">${day}</label>
                        </div>
                    `);
                });
                batchTimeInfo.show();
            }
        });
    </script>

    <!-- Facilities Management -->
    <script>
        $(document).ready(function() {
            $('.facility-toggle').click(function() {
                const details = $(this).siblings('.facility-details');
                const icon = $(this).find('i');
                details.slideToggle();
                if (icon.hasClass('fa-chevron-down')) {
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    $(this).html('Hide details <i class="fas fa-chevron-up"></i>');
                } else {
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    $(this).html('Show details <i class="fas fa-chevron-down"></i>');
                }
            });

            $('.facility-card').click(function(e) {
                if (!$(e.target).is('input, select, option, .form-control') && !$(this).hasClass('facility-unavailable')) {
                    const checkbox = $(this).find('.facility-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    if (checkbox.prop('checked')) {
                        $(this).addClass('selected');
                        $(this).find('.facility-details').slideDown();
                        $(this).find('.facility-toggle').html('Hide details <i class="fas fa-chevron-up"></i>');
                    } else {
                        $(this).removeClass('selected');
                    }
                    updateFacilitiesSummary();
                    calculateTotalFees();
                }
            });

            $('.facility-checkbox, .locker-size, .locker-number, .racket-type, .racket-months, .shoe-size, .shoe-months').change(function() {
                updateFacilitiesSummary();
                calculateTotalFees();
            });

            $('#paidAmount').on('input', function() {
                calculateRemainingAmount();
            });

            $('#courseFees').on('input', function() {
                calculateTotalFees();
            });

            updateFacilitiesSummary();

            function updateFacilitiesSummary() {
                const summaryBody = $('#facilitiesSummary tbody');
                summaryBody.empty();
                let total = 0;

                $('.facility-checkbox:checked').each(function() {
                    const facilityCard = $(this).closest('.facility-card');
                    const facilityType = facilityCard.data('facility');
                    let facilityName = '';
                    let details = '';
                    let amount = 0;

                    switch(facilityType) {
                        case 'locker':
                            facilityName = 'Locker';
                            const lockerSize = facilityCard.find('.locker-size option:selected').text();
                            const lockerNumber = facilityCard.find('.locker-number option:selected').val() || 'Not selected';
                            const lockerPrice = parseFloat(facilityCard.find('.locker-size').val());
                            amount = lockerPrice;
                            details = `${lockerSize}, Locker No: ${lockerNumber}`;
                            break;
                        case 'racket':
                            facilityName = 'Racket Rental';
                            const racketType = facilityCard.find('.racket-type option:selected').text();
                            const months = facilityCard.find('.racket-months').val();
                            const racketPrice = parseFloat(facilityCard.find('.racket-type').val());
                            amount = racketPrice * months;
                            details = `${racketType} for ${months} month(s)`;
                            break;
                        case 'shoe':
                            facilityName = 'Shoe Rental';
                            const shoeSize = facilityCard.find('.shoe-size option:selected').text();
                            const shoeMonths = facilityCard.find('.shoe-months').val();
                            const shoePrice = parseFloat(facilityCard.find('.shoe-size').val());
                            amount = shoePrice * shoeMonths;
                            details = `${shoeSize} for ${shoeMonths} month(s)`;
                            break;
                    }

                    total += amount;

                    summaryBody.append(`
                        <tr>
                            <td>${facilityName}</td>
                            <td>${details}</td>
                            <td class="text-right">₹${amount.toLocaleString()}</td>
                        </tr>
                    `);
                });

                $('#facilitiesTotal').text('₹' + total.toLocaleString());
                $('#additionalFees').val(total);
            }

            function calculateTotalFees() {
                const courseFees = parseFloat($('#courseFees').val()) || 0;
                const additionalFees = parseFloat($('#additionalFees').val()) || 0;
                const totalFees = courseFees + additionalFees;
                $('#totalFees').val(totalFees);
                calculateRemainingAmount();
            }

            function calculateRemainingAmount() {
                const totalFees = parseFloat($('#totalFees').val()) || 0;
                const paidAmount = parseFloat($('#paidAmount').val()) || 0;
                const remainingAmount = totalFees - paidAmount;
                $('#remainingAmount').val(remainingAmount);
            }
        });
    </script>

    <!-- Form Submission -->
    <script>
        $('#admissionForm').on('submit', function(e) {
            e.preventDefault();
            if (!validateStep(4)) return;

            const formData = $(this).serializeArray().reduce((obj, item) => {
                obj[item.name] = item.value;
                return obj;
            }, {});

            // Add facilities summary
            formData.facilities = [];
            $('.facility-checkbox:checked').each(function() {
                const facilityCard = $(this).closest('.facility-card');
                const facilityType = facilityCard.data('facility');
                let facilityName = '';
                let details = '';
                let amount = 0;

                switch(facilityType) {
                    case 'locker':
                        facilityName = 'Locker';
                        const lockerSize = facilityCard.find('.locker-size option:selected').text();
                        const lockerNumber = facilityCard.find('.locker-number option:selected').val() || 'Not selected';
                        const lockerPrice = parseFloat(facilityCard.find('.locker-size').val());
                        amount = lockerPrice;
                        details = `${lockerSize}, Locker No: ${lockerNumber}`;
                        break;
                    case 'racket':
                        facilityName = 'Racket Rental';
                        const racketType = facilityCard.find('.racket-type option:selected').text();
                        const months = facilityCard.find('.racket-months').val();
                        const racketPrice = parseFloat(facilityCard.find('.racket-type').val());
                        amount = racketPrice * months;
                        details = `${racketType} for ${months} month(s)`;
                        break;
                    case 'shoe':
                        facilityName = 'Shoe Rental';
                        const shoeSize = facilityCard.find('.shoe-size option:selected').text();
                        const shoeMonths = facilityCard.find('.shoe-months').val();
                        const shoePrice = parseFloat(facilityCard.find('.shoe-size').val());
                        amount = shoePrice * shoeMonths;
                        details = `${shoeSize} for ${shoeMonths} month(s)`;
                        break;
                }

                formData.facilities.push({
                    name: facilityName,
                    details: details,
                    amount: amount
                });
            });

            $.ajax({
                url: '<?= base_url('admission/save') ?>',
                method: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = '<?= base_url('receipt?student_id=') ?>' + response.student_id;
                    } else {
                        alert('Failed to save admission: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error submitting form: ' + error);
                }
            });
        });
    </script>

</body>

</html>