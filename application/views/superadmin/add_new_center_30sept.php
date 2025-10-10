<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
      <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-left: 0;
            padding-top: 56px;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            height: calc(100% - 56px);
            width: 250px;
            z-index: 1000;
            background-color: #343a40;
            padding-top: 20px;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .collapsed-sidebar .main-content {
            margin-left: 0;
        }

        .header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            padding: 25px 0;
            margin-bottom: 30px;
        }

        .progress-container {
            margin: 30px 0;
            padding: 0 15px;
        }

        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            color: #ff4040;
            border-bottom: 2px solid #ff4040;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #e03a3a 0%, #3a0000 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .progress-bar {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
            color: #6c757d;
        }

        .step-active .step-circle {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
        }

        .step-label {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }

        .step-active .step-label {
            color: #ff4040;
            font-weight: 600;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        .conditional-field {
            display: none;
        }

        .add-more-btn {
            margin-top: 10px;
        }

        .staff-table,
        .facility-table,
        .batch-table {
            margin-top: 20px;
        }

        .facility-card,
        .batch-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
        }

        .toggle-sidebar {
            cursor: pointer;
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }

            .main-content {
                margin-left: 0 !important;
            }

            .show-sidebar .sidebar {
                width: 250px;
            }
        }
            
            @media  screen and (max-width: 576px) {
            .form-action .btn {
                width: 100% !important;
                margin-bottom: 10px;
            }
        }
        
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>
    <div class="content-wrapper" id="contentWrapper">
        <!-- Main Content -->
        <div class="main-content">
            <div class="header text-center">
                <p class="lead">Add and manage your sports Center details</p>
            </div>
            <div class="container-fluid">
                <!-- Progress Bar -->
                <div class="progress-container">
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="step step-active">
                            <div class="step-circle">1</div>
                            <div class="step-label">Center Details</div>
                        </div>
                        <div class="step">
                            <div class="step-circle">2</div>
                            <div class="step-label">Batch Details</div>
                        </div>
                        <div class="step">
                            <div class="step-circle">3</div>
                            <div class="step-label">Staff Details</div>
                        </div>
                        <div class="step">
                            <div class="step-circle">4</div>
                            <div class="step-label">Facility Details</div>
                        </div>
                    </div>
                </div>
                <!-- Center Details Form -->
                <div class="form-container form-section active" id="center-details">
                    <h3 class="section-title"><i class="fas fa-info-circle me-2"></i>Center Details</h3>
                    <form id="centerForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="centerName" class="form-label required-field">Center Name</label>
                                <input type="text" class="form-control" id="centerName" placeholder="Enter center Name" required>
                                <div class="invalid-feedback">Center name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="centerNumber" class="form-label required-field">Center Number</label>
                                <input type="text" class="form-control" id="centerNumber" readonly required>
                                <div class="invalid-feedback">Center number is required.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label required-field">Address</label>
                            <textarea class="form-control" id="address" rows="3" placeholder="Enter center Address" required></textarea>
                            <div class="invalid-feedback">Address is required.</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label required-field">Latitude</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="latitude"
                                    name="latitude"
                                    step="0.00000001"
                                    placeholder="Enter latitude (e.g., 19.0760)"
                                    required>
                                <div class="invalid-feedback">Latitude must be between -90 and 90.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label required-field">Longitude</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="longitude"
                                    name="longitude"
                                    step="0.0000001"
                                    placeholder="Enter longitude (e.g., 72.8777)"
                                    required>
                                <div class="invalid-feedback">Longitude must be between -180 and 180.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="openingTime" class="form-label required-field">Opening Time</label>
                                <input type="time" class="form-control" id="openingTime" placeholder="Select Opening Time" required>
                                <div class="invalid-feedback">Opening time is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="closingTime" class="form-label required-field">Closing Time</label>
                                <input type="time" class="form-control" id="closingTime"  placeholder="Select closing Time" required>
                                <div class="invalid-feedback">Closing time must be after opening time.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                 <label for="center_rent" class="form-label required-field">Rent</label>
                            <input type="number" id="center_rent" name="center_rent" class="form-control"
                                placeholder="Enter Rent Amount" required min="1" />
                            <div class="invalid-feedback">Please enter a valid rent amount greater than 0.</div>
                                
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label required-field">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <div class="invalid-feedback">Password must be at least 8 characters.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="printPaidDate" class="form-label">Paid Date</label>
                                <input type="date" class="form-control" id="printPaidDate"  placeholder="Select Recend Rent Paid Date">
                           
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-next" data-next="batch-details">
                                Next: Batch Details <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("centerForm");
                        const nextBtn = form.querySelector(".btn-next");
                        const centerNumber = document.getElementById("centerNumber");
                        const openingTime = document.getElementById("openingTime");
                        const closingTime = document.getElementById("closingTime");
                        const password = document.getElementById("password");
                        const togglePassword = document.getElementById("togglePassword");
                        const latitude = document.getElementById("latitude");
                        const longitude = document.getElementById("longitude");

                        function generateCenterNumber() {
                            const date = new Date();
                            const yy = date.getFullYear().toString().slice(-2);
                            const mm = String(date.getMonth() + 1).padStart(2, "0");
                            const dd = String(date.getDate()).padStart(2, "0");
                            const random = Math.floor(100 + Math.random() * 900);
                            centerNumber.value = `CTR-${yy}${mm}${dd}-${random}`;
                            validateForm();
                        }

                        togglePassword.addEventListener("click", function() {
                            const type = password.getAttribute("type") === "password" ? "text" : "password";
                            password.setAttribute("type", type);
                            this.querySelector("i").classList.toggle("fa-eye");
                            this.querySelector("i").classList.toggle("fa-eye-slash");
                        });

                        function validateForm() {
                            let isValid = form.checkValidity();
                            if (openingTime.value && closingTime.value) {
                                if (closingTime.value <= openingTime.value) {
                                    closingTime.setCustomValidity("Closing time must be after opening time.");
                                    isValid = false;
                                } else {
                                    closingTime.setCustomValidity("");
                                }
                            }
                            if (latitude.value) {
                                const latValue = parseFloat(latitude.value);
                                if (latValue < -90 || latValue > 90) {
                                    latitude.setCustomValidity("Latitude must be between -90 and 90.");
                                    isValid = false;
                                } else {
                                    latitude.setCustomValidity("");
                                }
                            }
                            if (longitude.value) {
                                const lonValue = parseFloat(longitude.value);
                                if (lonValue < -180 || lonValue > 180) {
                                    longitude.setCustomValidity("Longitude must be between -180 and 180.");
                                    isValid = false;
                                } else {
                                    longitude.setCustomValidity("");
                                }
                            }
                            form.classList.add("was-validated");
                            nextBtn.disabled = !isValid;
                        }

                        form.querySelectorAll("input, textarea, select").forEach((input) => {
                            input.addEventListener("input", validateForm);
                            input.addEventListener("change", validateForm);
                        });

                        generateCenterNumber();
                        validateForm();
                    });
                </script>

                <!-- Batch Details Form -->
                <div class="form-container form-section" id="batch-details">
                    <h3 class="section-title"><i class="fas fa-layer-group me-2"></i>Batch Details</h3>
                    <form id="batchForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="batchName" class="form-label required-field">Batch Name</label>
                                <input type="text" class="form-control" id="batchName"  placeholder="Enter Batch Name" required>
                                <div class="invalid-feedback">Batch name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="batchLevel" class="form-label required-field">Level</label>
                                <select class="form-select" id="batchLevel" required>
                                    <option value="">Select Level</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                                <div class="invalid-feedback">Please select a level.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="batchStartTime" class="form-label required-field">Start Time</label>
                                <input type="time" class="form-control" id="batchStartTime" required>
                                <div class="invalid-feedback">Start time is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="batchEndTime" class="form-label required-field">End Time</label>
                                <input type="time" class="form-control" id="batchEndTime" required>
                                <div class="invalid-feedback">End time must be after start time.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label required-field">Start Date</label>
                                <input type="date" class="form-control" id="startDate" required>
                                <div class="invalid-feedback">Start date is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label required-field">End Date</label>
                                <input type="date" class="form-control" id="endDate" required>
                                <div class="invalid-feedback">End date must be after start date.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="duration" class="form-label required-field">Duration (Months)</label>
                                <input type="number" class="form-control" id="duration" min="1" readonly required>
                                <div class="invalid-feedback">Duration must be at least 1 month.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="category" class="form-label required-field">Category</label>
                                <input type="text" class="form-control" id="category" required placeholder="Enter category">
                                <div class="invalid-feedback">Category is required.</div>
                            </div>
                        </div>
                        <!--<div class="d-flex justify-content-between">-->
                        <!--    <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="center-details">-->
                        <!--        <i class="fas fa-arrow-left me-2"></i> Back to Center Details-->
                        <!--    </button>-->
                        <!--    <div>-->
                        <!--        <button type="button" class="btn btn-info mb-3" id="addAnotherBatch">-->
                        <!--            <i class="fas fa-plus me-2"></i> Add Another Batch-->
                        <!--        </button>-->
                        <!--        <button type="button" class="btn btn-primary btn-next" data-next="staff-details">-->
                        <!--            Next: Staff Details <i class="fas fa-arrow-right ms-2"></i>-->
                        <!--        </button>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
         <div class="d-flex form-action flex-wrap justify-content-between">
            
            <div class="flex-0">
                <button type="button" class="btn btn-primary" id="addAnotherBatch">
                    <i class="fas fa-plus me-2"></i> Add Another Batch
                </button>
                <button type="button" class="btn btn-primary btn-next" data-next="staff-details" disabled="">
                    Next: Staff Details <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="center-details">
                <i class="fas fa-arrow-left me-2"></i> Back to Center Details
            </button>
        </div>
                    </form>
                    <h5>Added Batches</h5>
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-bordered table-striped table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th>Batch Name</th>
                                    <th>Level</th>
                                    <th>Time</th>
                                    <th>Dates</th>
                                    <th>Duration</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="batchList">
                                <tr>
                                    <td colspan="7" class="text-center">No batches added yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const form = document.getElementById("batchForm");
                        const nextBtn = form.querySelector(".btn-next");
                        const batchStartTime = document.getElementById("batchStartTime");
                        const batchEndTime = document.getElementById("batchEndTime");
                        const startDate = document.getElementById("startDate");
                        const endDate = document.getElementById("endDate");
                        const duration = document.getElementById("duration");
                        let batches = [];

                        function calculateDuration() {
                            if (startDate.value && endDate.value) {
                                const start = new Date(startDate.value);
                                const end = new Date(endDate.value);
                                if (end >= start) {
                                    let months = (end.getFullYear() - start.getFullYear()) * 12;
                                    months += end.getMonth() - start.getMonth();
                                    if (end.getDate() < start.getDate()) {
                                        months--;
                                    }
                                    duration.value = months >= 1 ? months : 1;
                                    duration.setCustomValidity("");
                                } else {
                                    duration.value = "";
                                    duration.setCustomValidity("End date must be after start date.");
                                }
                            } else {
                                duration.value = "";
                                duration.setCustomValidity("Please select start and end dates.");
                            }
                            validateForm();
                        }

                        function validateForm() {
                            let isValid = form.checkValidity();
                            if (batchStartTime.value && batchEndTime.value) {
                                if (batchEndTime.value <= batchStartTime.value) {
                                    batchEndTime.setCustomValidity("End time must be after start time.");
                                    isValid = false;
                                } else {
                                    batchEndTime.setCustomValidity("");
                                }
                            }
                            if (startDate.value && endDate.value) {
                                const start = new Date(startDate.value);
                                const end = new Date(endDate.value);
                                if (end <= start) {
                                    endDate.setCustomValidity("End date must be after start date.");
                                    isValid = false;
                                } else {
                                    endDate.setCustomValidity("");
                                }
                            }
                            if (duration.value < 1) {
                                duration.setCustomValidity("Duration must be at least 1 month.");
                                isValid = false;
                            } else {
                                duration.setCustomValidity("");
                            }
                            form.classList.add("was-validated");
                            nextBtn.disabled = batches.length === 0;
                        }

                        function updateBatchList() {
                            const batchList = document.getElementById("batchList");
                            if (batches.length === 0) {
                                batchList.innerHTML = '<tr><td colspan="7" class="text-center">No batches added yet</td></tr>';
                                nextBtn.disabled = true;
                                return;
                            }
                            batchList.innerHTML = '';
                            batches.forEach((batch, index) => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${batch.batch_name}</td>
                                    <td>${batch.batch_level}</td>
                                    <td>${batch.start_time} - ${batch.end_time}</td>
                                    <td>${batch.start_date} to ${batch.end_date}</td>
                                    <td>${batch.duration} months</td>
                                    <td>${batch.category}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger remove-batch" data-index="${index}">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </td>
                                `;
                                batchList.appendChild(row);
                            });
                            document.querySelectorAll('.remove-batch').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const index = this.getAttribute('data-index');
                                    batches.splice(index, 1);
                                    updateBatchList();
                                    updateBatchDropdown();
                                    validateForm();
                                });
                            });
                            nextBtn.disabled = false;
                        }

                        function updateBatchDropdown() {
                            const assignedBatchSelect = document.getElementById('assignedBatch');
                            if (!assignedBatchSelect) return;
                            assignedBatchSelect.innerHTML = '<option value="">Select Batch</option>';
                            batches.forEach((batch, index) => {
                                const option = document.createElement('option');
                                option.value = index;
                                option.textContent = batch.batch_name;
                                assignedBatchSelect.appendChild(option);
                            });
                        }

                        document.getElementById("addAnotherBatch").addEventListener('click', function() {
                            const batchName = document.getElementById('batchName');
                            const batchLevel = document.getElementById('batchLevel');
                            const batchStartTime = document.getElementById('batchStartTime');
                            const batchEndTime = document.getElementById('batchEndTime');
                            const startDate = document.getElementById('startDate');
                            const endDate = document.getElementById('endDate');
                            const duration = document.getElementById('duration');
                            const category = document.getElementById('category');

                            let isValid = true;
                            [batchName, batchLevel, batchStartTime, batchEndTime, startDate, endDate, duration, category].forEach(field => {
                                if (!field.value) {
                                    field.classList.add('is-invalid');
                                    isValid = false;
                                } else {
                                    field.classList.remove('is-invalid');
                                }
                            });
                            if (!isValid) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Please fill all required fields before adding batch.'
                                });
                                return;
                            }

                            const batchData = {
                                center_id: savedCenterId,
                                batch_name: batchName.value,
                                batch_level: batchLevel.value,
                                start_time: batchStartTime.value,
                                end_time: batchEndTime.value,
                                start_date: startDate.value,
                                end_date: endDate.value,
                                duration: duration.value,
                                category: category.value
                            };

                            $.ajax({
                                url: baseUrl + "Center/saveBatch",
                                type: "POST",
                                contentType: "application/json",
                                data: JSON.stringify(batchData),
                                success: function(response) {
                                    try {
                                        const res = JSON.parse(response);
                                        if (res.status === "success") {
                                            batches.push(batchData);
                                            updateBatchList();
                                            updateBatchDropdown();
                                            form.reset();
                                            validateForm();
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: 'Batch saved successfully!'
                                            });
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: res.message
                                            });
                                        }
                                    } catch (e) {
                                        console.error("Invalid JSON response", response);
                                    }
                                },
                                error: function(xhr) {
                                    console.error("Error:", xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Something went wrong while saving batch!'
                                    });
                                }
                            });
                        });

                        form.querySelectorAll("input, select").forEach((input) => {
                            input.addEventListener("input", validateForm);
                            input.addEventListener("change", validateForm);
                        });

                        startDate.addEventListener("change", calculateDuration);
                        endDate.addEventListener("change", calculateDuration);

                        validateForm();
                    });
                </script>

                <!-- Staff Details Form -->
                <div class="form-container form-section" id="staff-details">
                    <h3 class="section-title"><i class="fas fa-users me-2"></i>Staff Details</h3>
                    <form id="staffForm" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="staffName" class="form-label required-field">Staff Name</label>
                                <input type="text" class="form-control" id="staffName"  placrholder="Enter Staff Name" required>
                                <div class="invalid-feedback">Staff name is required.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="contactNo" class="form-label required-field">Contact Number</label>
                                <input type="tel" class="form-control" id="contactNo" pattern="^[0-9]{10}$" maxlength="10" required>
                                <div class="invalid-feedback">Enter a valid 10-digit contact number.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="role" class="form-label required-field">Role</label>
                                <select class="form-select" id="role" required>
                                    <option value="">Select Role</option>
                                    <option value="admin">Administrator</option>
                                    <option value="manager">Manager</option>
                                    <option value="coach">Coach</option>
                                    <option value="support">Support Staff</option>
                                </select>
                                <div class="invalid-feedback">Please select a role.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="joiningDate" class="form-label required-field">Joining Date</label>
                                <input type="date" class="form-control" id="joiningDate" required>
                                <div class="invalid-feedback">Joining date is required.</div>
                            </div>
                        </div>
                        <div id="coachAssignment" class="conditional-field d-none">
                            <h5 class="mt-4 mb-3">Coach Batch Assignment</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="assignedBatch" class="form-label">Assign Batch</label>
                                    <div class="input-group">
                                        <select class="form-select" id="assignedBatch">
                                            <option value="">Loading batches...</option>
                                        </select>
                                        <button type="button" class="btn btn-success" id="addBatchBtn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <ul class="list-group mt-2" id="assignedBatchList"></ul>
                                </div>
                                <div class="col-md-6">
                                    <label for="coachLevel" class="form-label">Coach Level</label>
                                    <select class="form-select" id="coachLevel">
                                        <option value="">Select Level</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="coachCategory" class="form-label">Category Specialization</label>
                                    <select class="form-select" id="coachCategory">
                                        <option value="">Select Category</option>
                                        <option value="corporate">Corporate</option>
                                        <option value="individual">Individual</option>
                                        <option value="group">Group</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="coachDuration" class="form-label">Session Duration (hours)</label>
                                    <input type="number" class="form-control" id="coachDuration" min="1">
                                </div>
                            </div>
                        </div>
                        <!--<div class="d-flex justify-content-between mt-4">-->
                        <!--    <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="batch-details">-->
                        <!--        <i class="fas fa-arrow-left me-2"></i> Back to Batch Details-->
                        <!--    </button>-->
                        <!--    <div>-->
                        <!--        <button type="button" class="btn btn-info" id="addAnotherStaff">-->
                        <!--            <i class="fas fa-plus me-2"></i> Add Another Staff-->
                        <!--        </button>-->
                        <!--        <button type="button" class="btn btn-primary btn-next" data-next="facility-details">-->
                        <!--            Next: Facility Details <i class="fas fa-arrow-right ms-2"></i>-->
                        <!--        </button>-->
                        <!--    </div>-->
                        <!--</div>-->
                        
                        <div class="d-flex form-action flex-wrap justify-content-between">
            
            <div class="flex-0">
                <button type="button" class="btn btn-primary" id="addAnotherStaff">
                    <i class="fas fa-plus me-2"></i> Add Another Staff
                </button>
                <button type="button" class="btn btn-primary btn-next" data-next="facility-details" disabled="">
                    Next: Facility Details <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
            <!--<button type="button" class="btn btn-outline-secondary btn-prev" data-prev="center-details">-->
            <!--    <i class="fas fa-arrow-left me-2"></i> Back to Center Details-->
            <!--</button>-->
        </div>
         
                    </form>
                    <div class="staff-table mt-4">
                        <h5 class="mb-3">Added Staff</h5>
                        <table class="table table-bordered table-striped table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Joining Date</th>
                                    <th>Assigned Batch</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="staffList">
                                <tr>
                                    <td colspan="6" class="text-center">No staff members added yet</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script>
                    let selectedBatches = [];
                    let staffMembers = [];
                    document.addEventListener("DOMContentLoaded", function() {
                        const staffForm = document.getElementById("staffForm");
                        const nextBtn = staffForm.querySelector(".btn-next");
                        const roleSelect = document.getElementById("role");
                        const coachFields = document.getElementById("coachAssignment");

                        document.getElementById("addBatchBtn").addEventListener("click", function() {
                            const assignedBatchSelect = document.getElementById("assignedBatch");
                            const batchId = assignedBatchSelect.value;
                            const batchText = assignedBatchSelect.options[assignedBatchSelect.selectedIndex]?.text;
                            if (!batchId) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Please select a batch to assign'
                                });
                                return;
                            }
                            if (selectedBatches.some(b => b.id === batchId)) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'This batch is already assigned!'
                                });
                                return;
                            }
                            selectedBatches.push({
                                id: batchId,
                                name: batchText
                            });
                            renderAssignedBatchList();
                        });

                        function renderAssignedBatchList() {
                            const list = document.getElementById("assignedBatchList");
                            list.innerHTML = "";
                            selectedBatches.forEach((batch, index) => {
                                const li = document.createElement("li");
                                li.className = "list-group-item d-flex justify-content-between align-items-center";
                                li.innerHTML = `
                                    ${batch.name}
                                    <button type="button" class="btn btn-sm btn-danger remove-batch" data-index="${index}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                `;
                                list.appendChild(li);
                            });
                            document.querySelectorAll(".remove-batch").forEach(btn => {
                                btn.addEventListener("click", function() {
                                    const idx = this.getAttribute("data-index");
                                    selectedBatches.splice(idx, 1);
                                    renderAssignedBatchList();
                                });
                            });
                        }

                        function validateStaffForm() {
                            let isValid = staffForm.checkValidity();
                            staffForm.classList.add("was-validated");
                            nextBtn.disabled = !isValid;
                        }

                        roleSelect.addEventListener("change", function() {
                            if (roleSelect.value === "coach") {
                                coachFields.classList.remove("d-none");
                            } else {
                                coachFields.classList.add("d-none");
                            }
                            validateStaffForm();
                        });

                        document.getElementById("addAnotherStaff").addEventListener("click", function() {
                            const staffName = document.getElementById('staffName').value.trim();
                            const contactNo = document.getElementById('contactNo').value.trim();
                            const role = document.getElementById('role').value;
                            const joiningDate = document.getElementById('joiningDate').value;

                            const staffData = {
                                center_id: savedCenterId,
                                staff_name: staffName,
                                contact_no: contactNo,
                                role: role,
                                joining_date: joiningDate,
                                assigned_batch: role === 'coach' ? [...selectedBatches] : [],
                                coach_level: role === 'coach' ? document.getElementById('coachLevel').value : 'N/A',
                                coach_category: role === 'coach' ? document.getElementById('coachCategory').value : 'N/A',
                                coach_duration: role === 'coach' ? document.getElementById('coachDuration').value : 'N/A'
                            };

                            $.ajax({
                                url: baseUrl + "Center/saveStaff",
                                type: "POST",
                                contentType: "application/json",
                                data: JSON.stringify(staffData),
                                success: function(response) {
                                    const res = JSON.parse(response);
                                    if (res.status === "success") {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: 'Staff saved successfully!'
                                        });
                                        staffData.staff_id = res.staff_id;
                                        staffMembers.push(staffData);
                                        updateStaffList();
                                        resetStaffForm();
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Error saving staff: ' + res.message
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    console.error(xhr.responseText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Failed to save staff.'
                                    });
                                }
                            });
                        });

                        function resetStaffForm() {
                            staffForm.reset();
                            staffForm.classList.remove("was-validated");
                            coachFields.classList.add("d-none");
                            selectedBatches = [];
                            renderAssignedBatchList();
                        }

                        function updateStaffList() {
                            const staffList = document.getElementById('staffList');
                            const nextBtn = document.querySelector('.btn-next[data-next="facility-details"]');
                            if (staffMembers.length === 0) {
                                staffList.innerHTML = '<tr><td colspan="6" class="text-center">No staff members added yet</td></tr>';
                                nextBtn.disabled = true;
                                return;
                            }
                            staffList.innerHTML = '';
                            staffMembers.forEach((staff, index) => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${staff.staff_name}</td>
                                    <td>${staff.contact_no}</td>
                                    <td>${staff.role.charAt(0).toUpperCase() + staff.role.slice(1)}</td>
                                    <td>${staff.joining_date}</td>
                                    <td>${staff.assigned_batch.length > 0
                                            ? staff.assigned_batch.map(b => b.name).join(", ")
                                            : 'N/A'}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1 edit-staff" data-index="${index}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger delete-staff" data-index="${index}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                `;
                                staffList.appendChild(row);
                            });
                            nextBtn.disabled = false;

                            document.querySelectorAll('.edit-staff').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const idx = this.getAttribute('data-index');
                                    editStaff(idx);
                                });
                            });
                            document.querySelectorAll('.delete-staff').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const idx = this.getAttribute('data-index');
                                    deleteStaff(idx);
                                });
                            });
                        }

                        function editStaff(index) {
                            const staff = staffMembers[index];
                            document.getElementById('staffName').value = staff.staff_name;
                            document.getElementById('contactNo').value = staff.contact_no;
                            document.getElementById('role').value = staff.role;
                            document.getElementById('joiningDate').value = staff.joining_date;
                            if (staff.role === 'coach') {
                                selectedBatches = [...staff.assigned_batch];
                                renderAssignedBatchList();
                                document.getElementById('coachLevel').value = staff.coach_level;
                                document.getElementById('coachCategory').value = staff.coach_category;
                                document.getElementById('coachDuration').value = staff.coach_duration;
                                coachFields.classList.remove('d-none');
                            }
                            staffMembers.splice(index, 1);
                            updateStaffList();
                        }

                        function deleteStaff(index) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You will not be able to recover this staff member!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, keep it'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    staffMembers.splice(index, 1);
                                    updateStaffList();
                                    Swal.fire(
                                        'Deleted!',
                                        'Staff member has been deleted.',
                                        'success'
                                    );
                                }
                            });
                        }

                        staffForm.querySelectorAll("input, select").forEach(el => {
                            el.addEventListener("input", validateStaffForm);
                            el.addEventListener("change", validateStaffForm);
                        });
                    });
                </script>

                <!-- Facility Details Form -->
                <div class="form-container form-section" id="facility-details">
                    <h3 class="section-title"><i class="fas fa-dumbbell me-2"></i> Facility Details</h3>
                    <form id="facilityForm" novalidate>
                        <input type="hidden" name="center_id" value="<?php echo $this->session->userdata('center_id'); ?>">
                        <div class="mb-3">
                            <label for="facilityName" class="form-label required-field">Facility Name</label>
                            <input type="text" class="form-control" id="facilityName" name="facility_name"  placeholder="Enter facility Name" required>
                            <div class="invalid-feedback">Facility name is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtypes & Rent</label>
                            <div id="subTypeContainer">
                                <div class="row mb-2 subTypeRow">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Subtype name" name="subtype_name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" placeholder="Rent" name="subtype_rent" min="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm removeSubType">X</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addSubTypeRow">
                                + Add Subtype
                            </button>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary btn-prev" data-prev="staff-details">
                                <i class="fas fa-arrow-left me-2"></i> Back to Staff Details
                            </button>
                            <div>
                                <button type="button" class="btn btn-primary" id="addAnotherFacility">
                                    <i class="fas fa-plus me-2"></i> Add Another Facility
                                </button>
                                <button type="button" class="btn btn-primary" id="submitAllFacilities">
                                    <i class="fas fa-save me-2"></i> Submit All
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="facility-table mt-4">
                        <h5 class="mb-3">Added Facilities</h5>
                        <div id="facilityList">
                            <p class="text-center">No facilities added yet</p>
                        </div>
                    </div>
                </div>
                <script>
    const centerId = "<?php echo $this->session->userdata('center_id'); ?>";
</script>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const facilityForm = document.getElementById("facilityForm");
                        let facilities = [];

                        function validateFacilityForm() {
                            let isValid = facilityForm.checkValidity();
                            facilityForm.classList.add("was-validated");
                            return isValid;
                        }

                        function updateFacilityList() {
                            const facilityList = document.getElementById("facilityList");
                            if (facilities.length === 0) {
                                facilityList.innerHTML = '<p class="text-center">No facilities added yet</p>';
                                return;
                            }
                            facilityList.innerHTML = '';
                            facilities.forEach((facility, index) => {
                                const card = document.createElement('div');
                                card.className = 'facility-card';
                                card.innerHTML = `
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>${facility.name} </h6>
                                            <ul class="mt-2">
                                                ${facility.subTypes.map(st => `<li>${st.subType} - Rent: ₹${st.rent || 0}</li>`).join("")}
                                            </ul>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-1 edit-facility" data-index="${index}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger delete-facility" data-index="${index}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                facilityList.appendChild(card);
                            });

                            document.querySelectorAll('.edit-facility').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const index = this.getAttribute('data-index');
                                    editFacility(index);
                                });
                            });
                            document.querySelectorAll('.delete-facility').forEach(btn => {
                                btn.addEventListener('click', function() {
                                    const index = this.getAttribute('data-index');
                                    deleteFacility(index);
                                });
                            });
                        }

                        function editFacility(index) {
                            const facility = facilities[index];
                            document.getElementById('facilityName').value = facility.name;
                            const subTypeContainer = document.getElementById('subTypeContainer');
                            subTypeContainer.innerHTML = '';
                            facility.subTypes.forEach(subType => {
                                const row = document.createElement('div');
                                row.className = 'row mb-2 subTypeRow';
                                row.innerHTML = `
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Subtype name" name="subtype_name" value="${subType.subType}">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" placeholder="Rent" name="subtype_rent" min="0" value="${subType.rent}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm removeSubType">X</button>
                                    </div>
                                `;
                                subTypeContainer.appendChild(row);
                            });
                            facilities.splice(index, 1);
                            updateFacilityList();
                        }

                        function deleteFacility(index) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You will not be able to recover this facility!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, keep it'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    facilities.splice(index, 1);
                                    updateFacilityList();
                                    Swal.fire(
                                        'Deleted!',
                                        'Facility has been deleted.',
                                        'success'
                                    );
                                }
                            });
                        }

                        document.getElementById("addSubTypeRow").addEventListener("click", function() {
                            const container = document.getElementById("subTypeContainer");
                            const row = document.createElement("div");
                            row.className = "row mb-2 subTypeRow";
                            row.innerHTML = `
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="Subtype name" name="subtype_name">
                                </div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" placeholder="Rent" name="subtype_rent" min="0">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm removeSubType">X</button>
                                </div>
                            `;
                            container.appendChild(row);
                            row.querySelector(".removeSubType").addEventListener("click", function() {
                                row.remove();
                            });
                        });

                        document.getElementById("addAnotherFacility").addEventListener("click", function() {
                            const facilityName = document.getElementById("facilityName").value;
                            const subTypes = [];
                            document.querySelectorAll("#subTypeContainer .subTypeRow").forEach(row => {
                                const subType = row.querySelector("input[name='subtype_name']").value;
                                const rent = row.querySelector("input[name='subtype_rent']").value;
                                if (subType) {
                                    subTypes.push({
                                        subType,
                                        rent: rent || 0
                                    });
                                }
                            });

                            if (!facilityName) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Please enter Facility Name.'
                                });
                                return;
                            }

                          

                            if (subTypes.length === 0) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Please add at least one Subtype with rent.'
                                });
                                return;
                            }

                            const facilityData = {
                                name: facilityName,
                                subTypes: subTypes
                            };

                            facilities.push(facilityData);
                            updateFacilityList();
                            facilityForm.reset();
                            document.getElementById("subTypeContainer").innerHTML = `
                                <div class="row mb-2 subTypeRow">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" placeholder="Subtype name" name="subtype_name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" placeholder="Rent" name="subtype_rent" min="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm removeSubType">X</button>
                                    </div>
                                </div>
                            `;
                        });
document.getElementById("submitAllFacilities").addEventListener("click", function () {
    if (facilities.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please add at least one facility.'
        });
        return;
    }

    // Send one facility at a time
    facilities.forEach(facility => {
        const payload = {
            center_id: "<?php echo $this->session->userdata('center_id'); ?>",
            facility_name: facility.name,
            subTypes: facility.subTypes
        };

        $.ajax({
            url: baseUrl + "Center/saveFacility",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(payload),
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message
                        }).then(() => {
                            window.location.href = baseUrl + "superadmin/CenterManagement2";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message
                        });
                    }
                } catch (e) {
                    console.error("Invalid JSON response", response);
                }
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong!'
                });
            }
        });
    });
});

                            });
                        
                </script>

                <!-- Batch Modal -->
                <div class="modal fade" id="batchModal" tabindex="-1" aria-labelledby="batchLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="batchLabel">Add Batch</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="modalBatchForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="batch_timing" class="form-label">Batch Timing</label>
                                            <input type="time" id="batch_timing" name="batch_timing" class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="batch_category" class="form-label">Category</label>
                                            <select id="batch_category" name="batch_category" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="Beginner">Beginner</option>
                                                <option value="Intermediate">Intermediate</option>
                                                <option value="Advanced">Advanced</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="batchSubmitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Facility Modal -->
                <div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="facilityLabel">Add Facility</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="modalFacilityForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="facility" class="form-label">Facility</label>
                                            <select id="facility" name="facility" class="form-control">
                                                <option value="">Select Facility</option>
                                                <option value="Locker">Locker</option>
                                                <option value="Shoe">Shoe</option>
                                                <option value="Racket">Racket</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="locker_no" class="form-label">Locker No</label>
                                            <input type="text" id="locker_no" name="locker_no" class="form-control"
                                                placeholder="Enter Locker No" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="facility_rent" class="form-label">Rent</label>
                                            <input type="number" id="facility_rent" name="facility_rent"
                                                class="form-control" placeholder="Enter Rent Amount" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="facility_rent_date" class="form-label">Rent Date</label>
                                            <input type="date" id="facility_rent_date" name="facility_rent_date"
                                                class="form-control" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="facilitySubmitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Modal -->
                <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staffLabel">Add Staff</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="modalStaffForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="staff_category" class="form-label">Category</label>
                                            <select id="staff_category" name="staff_category" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="coach">Coach</option>
                                                <option value="co-ordinator">Co-ordinator</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="staff_name" class="form-label">Staff Name</label>
                                            <input type="text" id="staff_name" name="staff_name" class="form-control"
                                                placeholder="Enter Staff Name" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="staff_timing" class="form-label">Timing</label>
                                            <input type="time" id="staff_timing" name="staff_timing"
                                                class="form-control" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="staff_salary" class="form-label">Salary</label>
                                            <input type="number" id="staff_salary" name="staff_salary"
                                                class="form-control" placeholder="Enter Salary" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="staffSubmitBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const batchModal = new bootstrap.Modal(document.getElementById('batchModal'));
                    const facilityModal = new bootstrap.Modal(document.getElementById('facilityModal'));
                    const staffModal = new bootstrap.Modal(document.getElementById('staffModal'));

                    document.getElementById("batchSubmitBtn").addEventListener("click", function() {
                        batchModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Batch added successfully!'
                        });
                    });
                    document.getElementById('facilitySubmitBtn').addEventListener('click', function() {
                        facilityModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Facility added successfully!'
                        });
                    });
                    document.getElementById('staffSubmitBtn').addEventListener('click', function() {
                        staffModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Staff added successfully!'
                        });
                    });

                    const progressBar = document.querySelector('.progress-bar');
                    const steps = document.querySelectorAll('.step');
                    const formSections = document.querySelectorAll('.form-section');
                    const nextButtons = document.querySelectorAll('.btn-next');
                    const prevButtons = document.querySelectorAll('.btn-prev');
                    const toggleSidebarBtn = document.querySelector('.toggle-sidebar');
                    let currentStep = 1;
                    const totalSteps = 4;

                    if (toggleSidebarBtn) {
                        toggleSidebarBtn.addEventListener('click', function() {
                            document.body.classList.toggle('show-sidebar');
                        });
                    }

                    function updateProgress() {
                        const progressPercentage = (currentStep / totalSteps) * 100;
                        if (progressBar) progressBar.style.width = progressPercentage + '%';
                        steps.forEach((step, index) => {
                            if (index < currentStep) {
                                step.classList.add('step-active');
                            } else {
                                step.classList.remove('step-active');
                            }
                        });
                    }

                    nextButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const nextSectionId = this.getAttribute('data-next');
                            const currentSection = document.querySelector('.form-section.active');
                            const currentForm = currentSection.querySelector('form');

                            // If moving to Staff Details and batches exist, proceed directly
                            if (nextSectionId === 'staff-details') {
                                const batchRows = document.querySelectorAll('#batchList tr');
                                if (batchRows.length > 1 || (batchRows.length === 1 && !batchRows[0].querySelector('td[colspan]'))) {
                                    currentStep++;
                                    updateProgress();
                                    formSections.forEach(section => section.classList.remove('active'));
                                    document.getElementById(nextSectionId).classList.add('active');
                                    return;
                                }
                            }

                            // If moving to Facility Details and staff exist, proceed directly
                            if (nextSectionId === 'facility-details') {
                                const staffRows = document.querySelectorAll('#staffList tr');
                                if (staffRows.length > 1 || (staffRows.length === 1 && !staffRows[0].querySelector('td[colspan]'))) {
                                    currentStep++;
                                    updateProgress();
                                    formSections.forEach(section => section.classList.remove('active'));
                                    document.getElementById(nextSectionId).classList.add('active');
                                    return;
                                }
                            }

                            // Otherwise, validate form
                            if (currentForm && currentForm.id !== 'batchForm') {
                                const requiredFields = currentSection.querySelectorAll('[required]');
                                let isValid = true;
                                requiredFields.forEach(field => {
                                    if (!field.value) {
                                        field.classList.add('is-invalid');
                                        isValid = false;
                                    } else {
                                        field.classList.remove('is-invalid');
                                    }
                                });
                                if (!isValid) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Please fill all required fields before proceeding.'
                                    });
                                    return;
                                }
                            }

                            currentStep++;
                            updateProgress();
                            formSections.forEach(section => section.classList.remove('active'));
                            document.getElementById(nextSectionId).classList.add('active');
                        });
                    });

                    prevButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const prevSectionId = this.getAttribute('data-prev');
                            currentStep--;
                            updateProgress();
                            formSections.forEach(section => section.classList.remove('active'));
                            document.getElementById(prevSectionId).classList.add('active');
                        });
                    });

                    updateProgress();
                });

                const baseUrl = "<?= base_url(); ?>";
                let savedCenterId = null;

                $("#centerForm").on("submit", function(e) {
                    e.preventDefault();
                    const payload = {
                        name: $("#centerName").val(),
                        address: $("#address").val(),
                        center_number: $("#centerNumber").val(),
                        rent_amount: $("#center_rent").val() || "0",
                        rent_paid_date: $("#printPaidDate").val(),
                        center_timing_from: $("#openingTime").val(),
                        center_timing_to: $("#closingTime").val(),
                        latitude: $("#latitude").val(),
                        longitude: $("#longitude").val(),
                        password: $("#password").val()
                    };
                    $.ajax({
                        url: baseUrl + "Center/saveCenter",
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(payload),
                        success: function(response) {
                            try {
                                const res = JSON.parse(response);
                                if (res.status === "success") {
                                    savedCenterId = res.center_id;
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Center saved successfully!'
                                    });
                                    $(".form-section").removeClass("active");
                                    $("#batch-details").addClass("active");
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: res.message
                                    });
                                }
                            } catch (e) {
                                console.error("Invalid JSON response", response);
                            }
                        },
                        error: function(xhr) {
                            console.error("Error:", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong!'
                            });
                        }
                    });
                });

                $(".btn-next[data-next='batch-details']").on("click", function() {
                    $("#centerForm").trigger("submit");
                });

                $(document).on("click", ".remove-batch", function() {
                    const batchId = $(this).data("batch-id");
                    if (batchId) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this batch!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, keep it'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: baseUrl + "Center/deleteBatch/" + batchId,
                                    type: "POST",
                                    success: function(response) {
                                        try {
                                            const res = JSON.parse(response);
                                            if (res.status === "success") {
                                                $(`tr[data-batch-id="${batchId}"]`).remove();
                                                Swal.fire(
                                                    'Deleted!',
                                                    'Batch removed successfully!',
                                                    'success'
                                                );
                                                loadBatchesForStaff();
                                                if ($("#batchList tr").length === 0) {
                                                    $("#batchList").html(`
                                                        <tr>
                                                            <td colspan="7" class="text-center">No batches added yet</td>
                                                        </tr>
                                                    `);
                                                }
                                            } else {
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: res.message
                                                });
                                            }
                                        } catch (e) {
                                            console.error("Invalid JSON response", response);
                                        }
                                    },
                                    error: function(xhr) {
                                        console.error("Error:", xhr.responseText);
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: 'Something went wrong!'
                                        });
                                    }
                                });
                            }
                        });
                    }
                });

                function loadBatchesForStaff() {
                    if (!savedCenterId) return;
                    $.ajax({
                        url: baseUrl + "Center/getBatchesByCenter/" + savedCenterId,
                        type: "GET",
                        success: function(response) {
                            try {
                                const res = JSON.parse(response);
                                if (res.status === "success") {
                                    $("#assignedBatch").empty().append('<option value="">Select Batch</option>');
                                    res.data.forEach(batch => {
                                        $("#assignedBatch").append(
                                            `<option value="${batch.id}">${batch.batch_name} (${batch.batch_level})</option>`
                                        );
                                    });
                                } else {
                                    console.warn("No batches found for this center");
                                }
                            } catch (e) {
                                console.error("Invalid JSON response", response);
                            }
                        },
                        error: function(xhr) {
                            console.error("Error fetching batches:", xhr.responseText);
                        }
                    });
                }

                $("#role").on("change", function() {
                    if ($(this).val() === "coach") {
                        $("#coachAssignment").show();
                        loadBatchesForStaff();
                    } else {
                        $("#coachAssignment").hide();
                    }
                });
            </script>
        </div>
    </div>
</body>

</html>