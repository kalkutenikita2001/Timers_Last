<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Student</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"/>

  <style>
     :root {
            --primary-color: #ff4040;
            --secondary-color: #f8f9fa;
            --accent-color: #007bff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Montserrat', serif !important;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .section-content {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        h4 {
            font-weight: 700;
            font-size: 20px;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }
        
        h5 {
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .facility-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .facility-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .facility-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .facility-name {
            font-size: 18px;
            font-weight: 600;
            color: #470000;
        }
        
        .facility-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #e6f7ee;
            color: #28a745;
        }
        
        .status-expired {
            background-color: #fef3eb;
            color: #fd7e14;
        }
        
        .status-completed {
            background-color: #e6f0ff;
            color: #007bff;
        }
        
        .facility-actions {
            margin-bottom: 15px;
        }
        
        .btn-renew {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s;
        }
        
        .btn-renew:hover {
            background: #300000;
            color: white;
            transform: translateY(-2px);
        }
        
        .facility-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .facility-detail-item {
            display: flex;
            align-items: center;
        }
        
        .facility-detail-item i {
            margin-right: 10px;
            color: var(--primary-color);
            width: 20px;
        }
        
        .facility-duration {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
        }
        
        .duration-bar {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin: 10px 0;
            overflow: hidden;
        }
        
        .duration-progress {
            height: 100%;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            border-radius: 4px;
        }
        
        .duration-info {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #6c757d;
        }
        
        .required-field::after {
            content: " *";
            color: var(--primary-color);
        }
        
        .sub-type-info {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .sub-type-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .sub-type-option {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .sub-type-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .sub-type-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(255, 64, 64, 0.05);
        }
        
        .sub-type-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .sub-type-details {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 8px;
        }
        
        .amount {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .duration-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .duration-option {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .duration-option:hover {
            border-color: var(--primary-color);
        }
        
        .duration-option.selected {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 64, 64, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #e03a3a;
            border-color: #e03a3a;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modal-header .close {
            color: white;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .inner-layout {
            display: flex;
            gap: 20px;
        }

        .inner-sidebar {
            width: 220px;
            padding: 15px 10px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            position: sticky;
            top: 90px;
            height: fit-content;
        }

        .inner-sidebar .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,0.1);
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.25s ease;
        }
        .inner-sidebar .menu-item i {
            color: #ffecec;
            font-size: 16px;
            transition: color 0.25s ease;
        }
        .inner-sidebar .menu-item:hover {
            background: rgba(255,255,255,0.25);
            transform: translateX(5px);
        }
        .inner-sidebar .menu-item:hover i {
            color: #fff;
        }
        .inner-sidebar .menu-item.active {
            background: #fff;
            color: #470000;
            font-weight: 600;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }
        .inner-sidebar .menu-item.active i {
            color: #470000;
        }

        .details-area {
            flex: 1;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        .section-content {
            display: none;
            margin-top: 15px;
        }
        .section-content.active {
            display: block;
        }

        .section-title {
            font-weight: 600;
            font-size: 16px;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .btn-success {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            border: none;
        }
        .btn-success:hover {
            background: #300000;
        }
        .btn-secondary {
            background: #666;
            border: none;
        }

        .progress-bar {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
        }

        .detail-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            color: #333;
        }

        .batch-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .batch-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        .batch-card.active {
            border-left: 4px solid #ff4040;
            background-color: #fff9f9;
        }
        .batch-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #e0e0e0;
        }
        .batch-name {
            font-weight: 600;
            color: #470000;
            font-size: 18px;
        }
        .batch-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-upcoming {
            background-color: #e6f0ff;
            color: #0066cc;
        }
        .batch-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .batch-detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .batch-detail-item i {
            color: #ff4040;
            width: 20px;
        }

        .re-admission-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f9f9f9;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .re-admission-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .re-admission-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .re-admission-name {
            font-weight: 600;
            color: #470000;
        }
        .re-admission-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
        }
        .re-admission-detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .re-admission-detail-item i {
            color: #ff4040;
            width: 16px;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        }
        .modal-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .modal-header .close {
            color: white;
            text-shadow: none;
            opacity: 0.8;
        }
        .modal-header .close:hover {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 60px 12px 12px;
            }
            .inner-layout {
                flex-direction: column;
            }
            .inner-sidebar {
                width: 100%;
                position: static;
            }
            .facility-header, .batch-header, .re-admission-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .facility-actions {
                position: static;
                margin-top: 10px;
                align-self: flex-end;
            }
            .facility-details-grid, .batch-details-grid, .re-admission-details-grid {
                grid-template-columns: 1fr;
            }
            .duration-options {
                flex-direction: column;
            }
        }
        @media (min-width: 769px) and (max-width: 991px) {
            .content-wrapper {
                margin-left: 200px;
                padding: 70px 18px 18px;
            }
            .content-wrapper.minimized {
                margin-left: 60px;
            }
            .inner-sidebar {
                width: 200px;
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
  <div class="container mt-5">
    <div class="inner-layout">
      
      <!-- Inner Sidebar -->
      <div class="inner-sidebar">
        <a href="#" class="menu-item active" onclick="showSection(event,'reAdmissionList')">
          <i class="fas fa-list"></i> Renew Students List
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'basicData')">
          <i class="fas fa-user"></i> Personal Details
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'batchDetails')">
          <i class="fas fa-file-alt"></i> Batch Details
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'feesDetails')">
          <i class="fas fa-lock"></i> Fees Details
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'facilities')">
          <i class="fas fa-building"></i> Facilities
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'Renew_admission')">
          <i class="fas fa-wallet"></i> Renew Admission
        </a>
      </div>

      <!-- Details Area -->
      <div class="details-area">
        <div class="progress-container mb-4">
          <div class="progress">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 16.67%;">
              Step 1 of 6
            </div>
          </div>
        </div>

        <!-- Section: Renew Students List -->
        <div class="section-content active" id="reAdmissionList">
          <h4>Renew Students List</h4>
          <p>List of students eligible for renewal based on expiry date.</p>
          <div class="row" id="reAdmissionCards"></div>
          <div class="text-right mt-4">
            <button type="button" class="btn btn-success next0">Next <i class="fas fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- Section: Basic Data -->
        <div class="section-content" id="basicData">
          <h4>Personal Details</h4>
          <p>Student's personal information and contact details.</p>
          <div class="row" id="personalDetails">
            <!-- Personal details will be dynamically populated -->
          </div>
          <div class="text-right mt-4">
            <button type="button" class="btn btn-secondary back0"><i class="fas fa-arrow-left"></i> Back</button>
            <button type="button" class="btn btn-success next1">Next <i class="fas fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- Section: Batch Details -->
        <div class="section-content" id="batchDetails">
          <h4>Batch Details</h4>
          <p>Information about the student's current and previous batches.</p>
          
          <h5 class="mt-4 mb-3">Current Batch</h5>
          <div id="currentBatchDetails">
            <!-- Current batch details will be dynamically populated -->
          </div>
          
          <h5 class="mt-5 mb-3">Previous Batches</h5>
          <div id="previousBatchDetails">
            <!-- Previous batch details will be dynamically populated -->
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary back1"><i class="fas fa-arrow-left"></i> Back</button>
            <button type="button" class="btn btn-success next2">Next <i class="fas fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- Section: Fees Details -->
        <div class="section-content" id="feesDetails">
          <h4>Fees Details</h4>
          <p>Information about the student's fees, payment status, and related details.</p>
          <div id="feesDetailsContent">
            <!-- Fees details will be dynamically populated -->
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary back2"><i class="fas fa-arrow-left"></i> Back</button>
            <button type="button" class="btn btn-success next3">Next <i class="fas fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- Section: Facilities -->
        <div class="section-content" id="facilities">
          <h4>Facilities</h4>
          <p>Information about additional facilities availed by the student.</p>
          
          <h5 class="mt-4 mb-3">Current Facilities</h5>
          <div id="currentFacilities">
            <!-- Current facilities will be dynamically populated -->
          </div>
          
          <h5 class="mt-5 mb-3">Previous Facilities</h5>
          <div id="previousFacilities">
            <!-- Previous facilities will be dynamically populated -->
          </div>

          <h5 class="mt-5 mb-3">Add New Facility</h5>
          <form id="facilityForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="required-field"><i class="fas fa-building"></i> Select Facility</label>
                <select id="facilityType" class="form-control" required onchange="showSubTypes()">
                  <option value="">-- Select Facility --</option>
                  <option value="hostel">Hostel Accommodation</option>
                  <option value="mess">Mess Facility</option>
                  <option value="locker">Locker</option>
                  <option value="transport">Transport Service</option>
                  <option value="gym">Gym Membership</option>
                  <option value="library">Library Access</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label class="required-field"><i class="fas fa-money-bill-wave"></i> Amount (₹)</label>
                <input type="number" id="facilityAmount" class="form-control" placeholder="Enter amount" required>
              </div>
            </div>
            
            <div id="subTypeContainer" class="sub-type-info">
              <h6 id="subTypeTitle">Select Facility Type</h6>
              <div id="subTypeOptions" class="sub-type-options"></div>
            </div>
            
            <div class="form-group">
              <label class="required-field"><i class="fas fa-clock"></i> Select Duration</label>
              <div class="duration-options">
                <div class="duration-option" onclick="selectDuration(1)">1 Month</div>
                <div class="duration-option" onclick="selectDuration(3)">3 Months</div>
                <div class="duration-option selected" onclick="selectDuration(6)">6 Months</div>
                <div class="duration-option" onclick="selectDuration(12)">1 Year</div>
                <div class="duration-option" onclick="selectDuration(0)">Custom</div>
              </div>
              <input type="hidden" id="selectedDuration" value="6">
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label class="required-field"><i class="fas fa-calendar-plus"></i> Start Date</label>
                <input type="date" id="facilityStartDate" class="form-control" required onchange="updateExpiryDate()">
              </div>
              <div class="form-group col-md-6">
                <label class="required-field"><i class="fas fa-calendar-check"></i> Expiry Date</label>
                <input type="date" id="facilityExpiryDate" class="form-control" required readonly>
              </div>
            </div>
            
            <div class="form-group">
              <label><i class="fas fa-sticky-note"></i> Additional Notes</label>
              <textarea id="facilityNotes" class="form-control" rows="3" placeholder="Any additional information about the facility"></textarea>
            </div>
            
            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-secondary back3"><i class="fas fa-arrow-left"></i> Back</button>
              <button type="submit" class="btn btn-primary" id="addFacilityBtn"><i class="fas fa-plus"></i> Add Facility</button>
              <button type="button" class="btn btn-success next4">Next <i class="fas fa-arrow-right"></i></button>
            </div>
          </form>
        </div>

        <!-- Section: Renew Admission -->
        <div class="section-content" id="Renew_admission">
          <h4>Renew Admission</h4>
          <p>Fill the form to renew the student's admission including details of student, batch, facility and payment.</p>

          <form id="renewAdmissionForm">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-user"></i> Select Student *</label>
                <select name="student_id" id="studentSelect" class="form-control" required>
                  <option value="">-- Select Student --</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-signal"></i> Level *</label>
                <select name="level" class="form-control" required>
                  <option value="">-- Select Level --</option>
                  <option>Beginner</option>
                  <option>Intermediate</option>
                  <option>Advanced</option>
                </select>
              </div>
            </div>

            <div class="section-title mb-2"><i class="fas fa-layer-group"></i> Batch Details</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-users"></i> Select Batch *</label>
                <select name="batch_id" id="batchSelect" class="form-control" required>
                  <option value="">-- Select Batch --</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-clock"></i> Duration *</label>
                <select name="duration" id="durationSelect" class="form-control" required>
                  <option value="">-- Select Duration --</option>
                  <option value="3">3 Months</option>
                  <option value="6">6 Months</option>
                  <option value="12">1 Year</option>
                </select>
              </div>
            </div>

            <div class="section-title mb-2"><i class="fas fa-calendar-alt"></i> Date Information</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-calendar-plus"></i> Join Date *</label>
                <input type="date" name="join_date" id="joinDate" class="form-control" required>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-calendar-times"></i> Expiry Date *</label>
                <input type="date" name="expiry_date" id="expiryDate" class="form-control" readonly>
              </div>
            </div>

            <div class="section-title mb-2"><i class="fas fa-money-bill-wave"></i> Payment Details</div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label><i class="fas fa-rupee-sign"></i> Base Fees Amount (₹) *</label>
                <input type="number" name="base_fees" id="baseFees" class="form-control" placeholder="Enter amount" required oninput="calculateTotalFees()">
              </div>
              <div class="form-group col-md-4">
                <label><i class="fas fa-rupee-sign"></i> Facilities Amount (₹)</label>
                <input type="number" name="facilities_amount" id="facilitiesAmount" class="form-control" readonly value="0">
              </div>
              <div class="form-group col-md-4">
                <label><i class="fas fa-rupee-sign"></i> Total Amount (₹) *</label>
                <input type="number" name="total_amount" id="totalAmount" class="form-control" readonly>
              </div>
              <div class="form-group col-md-4">
                <label><i class="fas fa-credit-card"></i> Payment Mode *</label>
                <select name="payment_mode" class="form-control" required>
                  <option value="">-- Select Payment Mode --</option>
                  <option>Cash</option>
                  <option>UPI</option>
                  <option>Bank Transfer</option>
                  <option>Card</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label><i class="fas fa-receipt"></i> Receipt No.</label>
                <input type="text" name="receipt_no" class="form-control" readonly value="RCPT<?php echo time(); ?>">
              </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
              <button type="button" class="btn btn-secondary back4"><i class="fas fa-arrow-left"></i> Back</button>
              <button type="submit" class="btn btn-success">Generate Receipt <i class="fas fa-check"></i></button>
            </div>
          </form>
        </div>

        <!-- Renew Facility Modal -->
        <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="renewModalLabel">Renew Facility</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="renewForm">
                  <input type="hidden" id="renewFacilityName">
                  <div class="form-group">
                    <label for="renewAmount">Amount (₹)</label>
                    <input type="number" class="form-control" id="renewAmount" required>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-clock"></i> Select Duration</label>
                    <div class="duration-options">
                      <div class="duration-option" onclick="selectRenewDuration(1)">1 Month</div>
                      <div class="duration-option" onclick="selectRenewDuration(3)">3 Months</div>
                      <div class="duration-option selected" onclick="selectRenewDuration(6)">6 Months</div>
                      <div class="duration-option" onclick="selectRenewDuration(12)">1 Year</div>
                      <div class="duration-option" onclick="selectRenewDuration(0)">Custom</div>
                    </div>
                    <input type="hidden" id="renewDuration" value="6">
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="renewStartDate">Start Date</label>
                      <input type="date" class="form-control" id="renewStartDate" required onchange="updateRenewExpiryDate()">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="renewExpiryDate">Expiry Date</label>
                      <input type="date" class="form-control" id="renewExpiryDate" required readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="renewNotes">Additional Notes</label>
                    <textarea class="form-control" id="renewNotes" rows="3"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmRenew">Confirm Renewal</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  let selectedStudentId = null;

  function showSection(event, sectionId) {
    event.preventDefault();
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.section-content').forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    updateProgressBar(sectionId);
    if (sectionId === 'Renew_admission') {
      loadStudentOptions();
      if (selectedStudentId) {
        loadRenewAdmissionForm(selectedStudentId);
      }
    }
  }

  function updateProgressBar(sectionId) {
    const progressBar = document.getElementById("progressBar");
    let step = 1;
    switch(sectionId) {
      case "reAdmissionList": step = 1; break;
      case "basicData": step = 2; break;
      case "batchDetails": step = 3; break;
      case "feesDetails": step = 4; break;
      case "facilities": step = 5; break;
      case "Renew_admission": step = 6; break;
    }
    const percentage = (step / 6) * 100;
    progressBar.style.width = percentage + "%";
    progressBar.innerText = `Step ${step} of 6`;
  }

  function navigateTo(currentId, nextId) {
    document.querySelectorAll(".section-content").forEach(sec => sec.classList.remove("active"));
    document.getElementById(nextId).classList.add("active");
    document.querySelectorAll(".menu-item").forEach(item => item.classList.remove("active"));
    document.querySelector(`.menu-item[onclick*='${nextId}']`).classList.add("active");
    updateProgressBar(nextId);
    if (nextId === 'Renew_admission') {
      loadStudentOptions();
      if (selectedStudentId) {
        loadRenewAdmissionForm(selectedStudentId);
      }
    }
  }

  function loadReAdmissions() {
    $.ajax({
      url: '<?php echo base_url('index.php/admission/get_deactivated_students'); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        $('#reAdmissionCards').empty();
        if (response && Array.isArray(response)) {
          response.forEach(student => {
            const expiryDate = new Date(student.joining_date);
            expiryDate.setMonth(expiryDate.getMonth() + parseInt(student.duration));
            const isExpired = expiryDate < new Date();
            if (isExpired) {
              let card = `
                <div class="col-md-4">
                  <div class="re-admission-card">
                    <div class="re-admission-header">
                      <div class="re-admission-name">${escapeHtml(student.name)}</div>
                      <button class="btn btn-renew view-btn" data-student-id="${student.id}">View</button>
                    </div>
                    <div class="re-admission-details-grid">
                      <div class="re-admission-detail-item"><i class="fas fa-phone"></i> ${escapeHtml(student.contact || 'N/A')}</div>
                      <div class="re-admission-detail-item"><i class="fas fa-building"></i> ${escapeHtml(student.center_name || 'N/A')}</div>
                      <div class="re-admission-detail-item"><i class="fas fa-calendar-alt"></i> Expiry: ${expiryDate.toLocaleDateString()}</div>
                    </div>
                  </div>
                </div>`;
              $('#reAdmissionCards').append(card);
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load renew students list. Please try again.',
            confirmButtonText: 'OK'
          });
        }
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to load renew students list. Please check your connection or try again later.',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function loadStudentOptions() {
    $.ajax({
      url: '<?php echo base_url('index.php/admission/get_deactivated_students'); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(students) {
        $('#studentSelect').empty().append('<option value="">-- Select Student --</option>');
        if (students && Array.isArray(students)) {
          students.forEach(student => {
            $('#studentSelect').append(`<option value="${student.id}">${escapeHtml(student.name)}</option>`);
          });
          if (selectedStudentId) {
            $('#studentSelect').val(selectedStudentId);
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load student options. Please try again.',
            confirmButtonText: 'OK'
          });
        }
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to load student options. Please check your connection or try again later.',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  function loadRenewAdmissionForm(studentId) {
    if (!studentId || isNaN(studentId)) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Invalid student ID selected. Please select a valid student.',
        confirmButtonText: 'OK'
      });
      selectedStudentId = null;
      $('#studentSelect').val('');
      $('#renewAdmissionForm')[0].reset();
      return;
    }
    $.ajax({
      url: '<?php echo base_url('index.php/admission/get_student'); ?>/' + studentId,
      type: 'GET',
      dataType: 'json',
      success: function(student) {
        if (student && student.id) {
          selectedStudentId = student.id;
          $('#personalDetails').html(`
            <div class="col-md-6">
              <div class="detail-row"><div class="detail-label"><i class="fas fa-user"></i> Name</div><div class="detail-value">${escapeHtml(student.name || 'N/A')}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-user-friends"></i> Parent Name</div><div class="detail-value">${escapeHtml(student.parent_name || 'N/A')}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-envelope"></i> Email</div><div class="detail-value">${escapeHtml(student.email || 'N/A')}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-home"></i> Address</div><div class="detail-value">${escapeHtml(student.address || 'N/A')}</div></div>
            </div>
            <div class="col-md-6">
              <div class="detail-row"><div class="detail-label"><i class="fas fa-phone-alt"></i> Contact</div><div class="detail-value">${escapeHtml(student.contact || 'N/A')}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-phone-alt"></i> Emergency Contact</div><div class="detail-value">${escapeHtml(student.emergency_contact || 'N/A')}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-calendar-alt"></i> Date of Birth</div><div class="detail-value">${student.dob ? new Date(student.dob).toLocaleDateString() : 'N/A'}</div></div>
              <div class="detail-row"><div class="detail-label"><i class="fas fa-venus-mars"></i> Gender</div><div class="detail-value">${escapeHtml(student.gender || 'N/A')}</div></div>
            </div>
          `);

          $('#currentBatchDetails').html(`
            <div class="batch-card active">
              <div class="batch-header">
                <div class="batch-name">${escapeHtml(student.batch_name || 'N/A')}</div>
                <div class="batch-status status-active">Active</div>
              </div>
              <div class="batch-details-grid">
                <div class="batch-detail-item"><i class="fas fa-university"></i><span><strong>Center:</strong> ${escapeHtml(student.center_name || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-chalkboard-teacher"></i><span><strong>Coach:</strong> ${escapeHtml(student.coach || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-calendar-alt"></i><span><strong>Start Date:</strong> ${student.joining_date ? new Date(student.joining_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="batch-detail-item"><i class="fas fa-calendar-check"></i><span><strong>End Date:</strong> ${student.expiry_date ? new Date(student.expiry_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="batch-detail-item"><i class="fas fa-clock"></i><span><strong>Timing:</strong> ${escapeHtml(student.batch_timing || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-user-tie"></i><span><strong>Coordinator:</strong> ${escapeHtml(student.coordinator || 'N/A')}</span></div>
              </div>
            </div>
          `);

          $('#previousBatchDetails').html((student.previous_batches || []).map(batch => `
            <div class="batch-card">
              <div class="batch-header">
                <div class="batch-name">${escapeHtml(batch.name)}</div>
                <div class="batch-status status-completed">Completed</div>
              </div>
              <div class="batch-details-grid">
                <div class="batch-detail-item"><i class="fas fa-university"></i><span><strong>Center:</strong> ${escapeHtml(batch.center || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-chalkboard-teacher"></i><span><strong>Coach:</strong> ${escapeHtml(batch.coach || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-calendar-plus"></i><span><strong>Join Date:</strong> ${batch.join_date ? new Date(batch.join_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="batch-detail-item"><i class="fas fa-calendar-check"></i><span><strong>Expiry Date:</strong> ${batch.expiry_date ? new Date(batch.expiry_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="batch-detail-item"><i class="fas fa-clock"></i><span><strong>Timing:</strong> ${escapeHtml(batch.timing || 'N/A')}</span></div>
                <div class="batch-detail-item"><i class="fas fa-award"></i><span><strong>Grade:</strong> ${escapeHtml(batch.grade || 'N/A')}</span></div>
              </div>
            </div>
          `).join(''));

          $('#feesDetailsContent').html(`
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-wallet"></i> Total Fees *</label>
                <input type="number" id="totalFees" class="form-control" value="${student.total_fees || ''}" required>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-money-check-alt"></i> Amount Paid *</label>
                <input type="number" id="paidAmount" class="form-control" value="${student.paid_amount || ''}" required>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-balance-scale"></i> Remaining Amount *</label>
                <input type="number" id="remainingAmount" class="form-control" value="${(student.total_fees - student.paid_amount) || 0}" readonly>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-credit-card"></i> Payment Method *</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment" value="Cash" ${student.payment_method === 'Cash' ? 'checked' : ''}>
                  <label class="form-check-label">Cash</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment" value="Online" ${student.payment_method === 'Online' ? 'checked' : ''}>
                  <label class="form-check-label">Online</label>
                </div>
              </div>
            </div>
          `);

          $('#currentFacilities').html((student.facilities || []).map(fac => `
            <div class="facility-card">
              <div class="facility-header">
                <div class="facility-name">${escapeHtml(fac.name)}</div>
                <div class="facility-status status-active">Active</div>
              </div>
              <div class="facility-details-grid">
                <div class="facility-detail-item"><i class="${fac.icon || 'fas fa-info-circle'}"></i><span><strong>${fac.detail_label || 'Details'}:</strong> ${escapeHtml(fac.details || 'N/A')}</span></div>
                <div class="facility-detail-item"><i class="fas fa-calendar-plus"></i><span><strong>Start Date:</strong> ${fac.start_date ? new Date(fac.start_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="facility-detail-item"><i class="fas fa-calendar-check"></i><span><strong>Expiry Date:</strong> ${fac.expiry_date ? new Date(fac.expiry_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="facility-detail-item"><i class="fas fa-money-bill-wave"></i><span><strong>Amount:</strong> ₹${fac.amount ? fac.amount.toLocaleString() : '0'}/month</span></div>
              </div>
              <div class="facility-duration">
                <div class="d-flex justify-content-between">
                  <span><strong>Duration:</strong> ${fac.duration || 'N/A'} months</span>
                  <span><strong>Remaining:</strong> ${fac.remaining || '0'} months</span>
                </div>
                <div class="duration-bar">
                  <div class="duration-progress" style="width: ${fac.progress || 0}%"></div>
                </div>
                <div class="duration-info">
                  <span>Started: ${fac.start_date ? new Date(fac.start_date).toLocaleDateString() : 'N/A'}</span>
                  <span>Ends: ${fac.expiry_date ? new Date(fac.expiry_date).toLocaleDateString() : 'N/A'}</span>
                </div>
              </div>
            </div>
          `).join(''));

          $('#previousFacilities').html((student.previous_facilities || []).map(fac => `
            <div class="facility-card">
              <div class="facility-header">
                <div class="facility-name">${escapeHtml(fac.name)}</div>
                <div class="facility-status status-${fac.status.toLowerCase()}">${fac.status}</div>
              </div>
              <div class="facility-actions">
                <button class="btn btn-renew" data-toggle="modal" data-target="#renewModal" data-facility="${escapeHtml(fac.name)}">
                  <i class="fas fa-sync-alt"></i> Renew
                </button>
              </div>
              <div class="facility-details-grid">
                <div class="facility-detail-item"><i class="${fac.icon || 'fas fa-info-circle'}"></i><span><strong>${fac.detail_label || 'Details'}:</strong> ${escapeHtml(fac.details || 'N/A')}</span></div>
                <div class="facility-detail-item"><i class="fas fa-calendar-plus"></i><span><strong>Start Date:</strong> ${fac.start_date ? new Date(fac.start_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="facility-detail-item"><i class="fas fa-calendar-check"></i><span><strong>Expiry Date:</strong> ${fac.expiry_date ? new Date(fac.expiry_date).toLocaleDateString() : 'N/A'}</span></div>
                <div class="facility-detail-item"><i class="fas fa-money-bill-wave"></i><span><strong>Amount:</strong> ₹${fac.amount ? fac.amount.toLocaleString() : '0'}/month</span></div>
              </div>
              <div class="facility-duration">
                <div class="d-flex justify-content-between">
                  <span><strong>Duration:</strong> ${fac.duration || 'N/A'} months</span>
                  <span><strong>Status:</strong> ${fac.status}</span>
                </div>
                <div class="duration-bar">
                  <div class="duration-progress" style="width: 100%"></div>
                </div>
                <div class="duration-info">
                  <span>Started: ${fac.start_date ? new Date(fac.start_date).toLocaleDateString() : 'N/A'}</span>
                  <span>Ended: ${fac.expiry_date ? new Date(fac.expiry_date).toLocaleDateString() : 'N/A'}</span>
                </div>
              </div>
            </div>
          `).join(''));

          $('#batchSelect').empty().append('<option value="">-- Select Batch --</option>');
          $.ajax({
            url: '<?php echo base_url('index.php/admission/get_batches'); ?>/' + (student.center_id || ''),
            type: 'GET',
            dataType: 'json',
            success: function(batches) {
              if (batches && Array.isArray(batches)) {
                batches.forEach(batch => {
                  $('#batchSelect').append(`<option value="${batch.id}">${escapeHtml(batch.timing)} (${escapeHtml(batch.category)})</option>`);
                });
                $('#batchSelect').val(student.batch_id || '');
              }
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load batches.',
                confirmButtonText: 'OK'
              });
            }
          });

          $('#durationSelect').val(student.duration || '');
          $('#joinDate').val(student.joining_date || '');
          const expiryDate = new Date(student.joining_date || new Date());
          if (student.duration) expiryDate.setMonth(expiryDate.getMonth() + parseInt(student.duration));
          $('#expiryDate').val(student.duration ? expiryDate.toISOString().split('T')[0] : '');
          $('#baseFees').val(student.base_fees || '');
          $('#facilitiesAmount').val(student.facilities_amount || 0);
          $('#totalAmount').val(student.total_amount || '');
          $('select[name="payment_mode"]').val(student.payment_mode || '');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No student data found for the selected ID.',
            confirmButtonText: 'OK'
          });
          selectedStudentId = null;
          $('#studentSelect').val('');
          $('#renewAdmissionForm')[0].reset();
          loadStudentOptions();
        }
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Failed to load student details.',
          confirmButtonText: 'OK'
        });
        selectedStudentId = null;
        $('#studentSelect').val('');
        $('#renewAdmissionForm')[0].reset();
        loadStudentOptions();
      }
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.querySelector('.navbar');
    const contentWrapper = document.getElementById('contentWrapper');

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          if (sidebar) {
            sidebar.classList.toggle('active');
            if (navbar) navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
          }
        } else {
          if (sidebar && contentWrapper) {
            const isMinimized = sidebar.classList.toggle('minimized');
            if (navbar) navbar.classList.toggle('sidebar-minimized', isMinimized);
            contentWrapper.classList.toggle('minimized', isMinimized);
          }
        }
      });
    }

    // Calculate remaining amount when fees or paid amount changes
    const totalFeesInput = document.getElementById('totalFees');
    const paidAmountInput = document.getElementById('paidAmount');
    const remainingAmountInput = document.getElementById('remainingAmount');
    
    function calculateRemainingAmount() {
      if (totalFeesInput && paidAmountInput && remainingAmountInput) {
        const total = parseFloat(totalFeesInput.value) || 0;
        const paid = parseFloat(paidAmountInput.value) || 0;
        remainingAmountInput.value = (total - paid).toFixed(2);
      }
    }
    
    if (totalFeesInput && paidAmountInput) {
      totalFeesInput.addEventListener('input', calculateRemainingAmount);
      paidAmountInput.addEventListener('input', calculateRemainingAmount);
    }

    // Set up event listeners for date calculation
    const joinDateInput = document.getElementById('joinDate');
    const durationSelect = document.getElementById('durationSelect');
    
    if (joinDateInput && durationSelect) {
      joinDateInput.addEventListener('change', calculateExpiryDate);
      durationSelect.addEventListener('change', calculateExpiryDate);
      const today = new Date().toISOString().split('T')[0];
      joinDateInput.value = today;
      calculateExpiryDate();
    }

    // Navigation buttons
    document.querySelector('.next0')?.addEventListener('click', () => navigateTo('reAdmissionList', 'basicData'));
    document.querySelector('.back0')?.addEventListener('click', () => navigateTo('basicData', 'reAdmissionList'));
    document.querySelector('.next1')?.addEventListener('click', () => navigateTo('basicData', 'batchDetails'));
    document.querySelector('.back1')?.addEventListener('click', () => navigateTo('batchDetails', 'basicData'));
    document.querySelector('.next2')?.addEventListener('click', () => navigateTo('batchDetails', 'feesDetails'));
    document.querySelector('.back2')?.addEventListener('click', () => navigateTo('feesDetails', 'batchDetails'));
    document.querySelector('.next3')?.addEventListener('click', () => navigateTo('feesDetails', 'facilities'));
    document.querySelector('.back3')?.addEventListener('click', () => navigateTo('facilities', 'feesDetails'));
    document.querySelector('.next4')?.addEventListener('click', () => navigateTo('facilities', 'Renew_admission'));
    document.querySelector('.back4')?.addEventListener('click', () => navigateTo('Renew_admission', 'facilities'));

    // Load re-admissions list on page load
    loadReAdmissions();

    // View student details
    $(document).on('click', '.view-btn', function() {
      selectedStudentId = $(this).data('student-id');
      if (!selectedStudentId || isNaN(selectedStudentId)) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Invalid student ID selected.',
          confirmButtonText: 'OK'
        });
        return;
      }
      loadRenewAdmissionForm(selectedStudentId);
      navigateTo('reAdmissionList', 'basicData');
    });

    // Update student selection
    $('#studentSelect').on('change', function() {
      selectedStudentId = $(this).val();
      if (selectedStudentId) {
        loadRenewAdmissionForm(selectedStudentId);
      } else {
        $('#renewAdmissionForm')[0].reset();
        selectedStudentId = null;
      }
    });

    // Save renew admission
    $('#renewAdmissionForm').on('submit', function(e) {
      e.preventDefault();
      if (!selectedStudentId || isNaN(selectedStudentId)) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please select a valid student for renewal.',
          confirmButtonText: 'OK'
        });
        return;
      }
      const formData = {
        student_id: selectedStudentId,
        level: $('select[name="level"]').val(),
        batch_id: $('#batchSelect').val(),
        duration: $('#durationSelect').val(),
        join_date: $('#joinDate').val(),
        expiry_date: $('#expiryDate').val(),
        base_fees: $('#baseFees').val(),
        facilities_amount: $('#facilitiesAmount').val(),
        total_amount: $('#totalAmount').val(),
        payment_mode: $('select[name="payment_mode"]').val(),
        receipt_no: $('input[name="receipt_no"]').val()
      };
      $.ajax({
        url: '<?php echo base_url('index.php/admission/renew_student'); ?>',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
          if (response && response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Admission renewed successfully!',
              confirmButtonText: 'OK'
            }).then(() => {
              loadReAdmissions();
              navigateTo('Renew_admission', 'reAdmissionList');
              $('#renewAdmissionForm')[0].reset();
              selectedStudentId = null;
              $('#studentSelect').val('');
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message || 'Failed to renew admission.',
              confirmButtonText: 'OK'
            });
          }
        },
        error: function(xhr) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while renewing: ' + (xhr.responseJSON ? xhr.responseJSON.message : xhr.statusText),
            confirmButtonText: 'OK'
          });
        }
      });
    });
  });

  function calculateExpiryDate() {
    const joinDateInput = document.getElementById('joinDate');
    const durationSelect = document.getElementById('durationSelect');
    const expiryDateInput = document.getElementById('expiryDate');
    
    if (joinDateInput.value && durationSelect.value) {
      const joinDate = new Date(joinDateInput.value);
      const duration = parseInt(durationSelect.value);
      const expiryDate = new Date(joinDate);
      expiryDate.setMonth(expiryDate.getMonth() + duration);
      expiryDateInput.value = expiryDate.toISOString().split('T')[0];
    } else {
      expiryDateInput.value = '';
    }
  }

  function calculateTotalFees() {
    const baseFees = parseFloat(document.getElementById('baseFees').value) || 0;
    const facilitiesAmount = parseFloat(document.getElementById('facilitiesAmount').value) || 0;
    const totalAmount = baseFees + facilitiesAmount;
    document.getElementById('totalAmount').value = totalAmount;
  }

  function escapeHtml(unsafe) {
    return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }

  const facilitySubTypes = {
    hostel: [
      { id: 'singleNonAC', name: 'Single Seater (Non-AC)', details: 'Private room with attached bathroom', amount: 8000 },
      { id: 'singleAC', name: 'Single Seater (AC)', details: 'Private AC room with attached bathroom', amount: 12000 },
      { id: 'doubleNonAC', name: 'Double Seater (Non-AC)', details: 'Shared room with attached bathroom', amount: 6000 },
      { id: 'doubleAC', name: 'Double Seater (AC)', details: 'Shared AC room with attached bathroom', amount: 9000 },
      { id: 'tripleNonAC', name: 'Triple Seater (Non-AC)', details: 'Shared room for three students', amount: 5000 }
    ],
    mess: [
      { id: 'breakfastOnly', name: 'Breakfast Only', details: 'Morning meals only', amount: 3000 },
      { id: 'lunchOnly', name: 'Lunch Only', details: 'Afternoon meals only', amount: 4000 },
      { id: 'dinnerOnly', name: 'Dinner Only', details: 'Evening meals only', amount: 3500 },
      { id: 'breakfastDinner', name: 'Breakfast & Dinner', details: 'Morning and evening meals', amount: 6000 },
      { id: 'fullMeal', name: 'Full Meal Plan', details: 'All three meals included', amount: 9000 }
    ],
    locker: [
      { id: 'small', name: 'Small Locker', details: 'Ideal for books and small items', amount: 1000 },
      { id: 'medium', name: 'Medium Locker', details: 'Fits a backpack and books', amount: 1500 },
      { id: 'large', name: 'Large Locker', details: 'Spacious for multiple items', amount: 2000 },
      { id: 'premium', name: 'Premium Locker', details: 'Extra secure with digital lock', amount: 2500 }
    ],
    transport: [
      { id: 'oneWay', name: 'One Way Service', details: 'Transport to or from campus', amount: 2500 },
      { id: 'twoWay', name: 'Two Way Service', details: 'Transport to and from campus', amount: 4000 },
      { id: 'weekend', name: 'Weekend Service', details: 'Weekend transport only', amount: 2000 },
      { id: 'premiumBus', name: 'Premium Bus Service', details: 'AC bus with guaranteed seating', amount: 5000 }
    ],
    gym: [
      { id: 'basic', name: 'Basic Membership', details: 'Access to cardio and weight areas', amount: 1500 },
      { id: 'premium', name: 'Premium Membership', details: 'Includes classes and trainer consultation', amount: 3000 },
      { id: 'pool', name: 'Gym + Pool Access', details: 'Full gym access plus swimming pool', amount: 4000 }
    ],
    library: [
      { id: 'basic', name: 'Basic Access', details: 'Book borrowing and reading area access', amount: 500 },
      { id: 'research', name: 'Research Access', details: 'Includes journal and database access', amount: 1500 },
      { id: 'premium', name: 'Premium Access', details: '24/7 access with study rooms', amount: 2500 }
    ],
    other: [
      { id: 'custom', name: 'Custom Facility', details: 'Specify details in notes', amount: 0 }
    ]
  };

  const facilityTypeLabels = {
    hostel: 'Hostel Type',
    mess: 'Meal Plan',
    locker: 'Locker Size',
    transport: 'Transport Plan',
    gym: 'Membership Type',
    library: 'Access Level',
    other: 'Facility Type'
  };

  function showSubTypes() {
    const facilityType = document.getElementById('facilityType').value;
    const subTypeContainer = document.getElementById('subTypeContainer');
    const subTypeOptions = document.getElementById('subTypeOptions');
    const subTypeTitle = document.getElementById('subTypeTitle');
    
    subTypeOptions.innerHTML = '';
    if (facilityType && facilitySubTypes[facilityType]) {
      subTypeContainer.style.display = 'block';
      subTypeTitle.textContent = `Select ${facilityTypeLabels[facilityType]}`;
      facilitySubTypes[facilityType].forEach(subType => {
        const optionDiv = document.createElement('div');
        optionDiv.className = 'sub-type-option';
        optionDiv.setAttribute('data-id', subType.id);
        optionDiv.setAttribute('data-amount', subType.amount);
        optionDiv.innerHTML = `
          <div class="sub-type-name">${subType.name}</div>
          <div class="sub-type-details">${subType.details}</div>
          <div class="amount">₹${subType.amount.toLocaleString()}/month</div>
        `;
        optionDiv.addEventListener('click', function() {
          document.querySelectorAll('.sub-type-option').forEach(opt => opt.classList.remove('selected'));
          this.classList.add('selected');
          document.getElementById('facilityAmount').value = subType.amount;
        });
        subTypeOptions.appendChild(optionDiv);
      });
    } else {
      subTypeContainer.style.display = 'none';
    }
  }

  window.onload = function() {
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('facilityStartDate').value = formattedDate;
    document.getElementById('renewStartDate').value = formattedDate;
    updateExpiryDate();
    updateRenewExpiryDate();
  };

  function selectDuration(months) {
    document.querySelectorAll('#facilityForm .duration-option').forEach(opt => opt.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('selectedDuration').value = months;
    updateExpiryDate();
  }

  function selectRenewDuration(months) {
    document.querySelectorAll('#renewForm .duration-option').forEach(opt => opt.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('renewDuration').value = months;
    updateRenewExpiryDate();
  }

  function updateExpiryDate() {
    const startDate = new Date(document.getElementById('facilityStartDate').value);
    const duration = parseInt(document.getElementById('selectedDuration').value);
    if (!isNaN(startDate.getTime()) && duration > 0) {
      const expiryDate = new Date(startDate);
      expiryDate.setMonth(expiryDate.getMonth() + duration);
      document.getElementById('facilityExpiryDate').value = expiryDate.toISOString().split('T')[0];
    }
  }

  function updateRenewExpiryDate() {
    const startDate = new Date(document.getElementById('renewStartDate').value);
    const duration = parseInt(document.getElementById('renewDuration').value);
    if (!isNaN(startDate.getTime()) && duration > 0) {
      const expiryDate = new Date(startDate);
      expiryDate.setMonth(expiryDate.getMonth() + duration);
      document.getElementById('renewExpiryDate').value = expiryDate.toISOString().split('T')[0];
    }
  }

  $('#renewModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const facilityName = button.data('facility');
    const modal = $(this);
    modal.find('.modal-title').text('Renew ' + facilityName);
    modal.find('#renewFacilityName').val(facilityName);
  });

  document.getElementById('facilityForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Facility added successfully!');
    // Add server-side submission logic here
  });

  document.getElementById('confirmRenew').addEventListener('click', function() {
    alert('Facility renewed successfully!');
    $('#renewModal').modal('hide');
    // Add server-side renewal logic here
  });
</script>
</body>
</html>