<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Student</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>

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
      background: #f9f9f9;
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
      flex-wrap: wrap;
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
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      gap: 8px;
    }
    
    .btn-renew {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border: none;
      padding: 6px 12px;
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
    .status-deactive {
      background-color: #f2f2f2;
      color: #666;
    }
    .batch-details-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    @media (max-width: 768px) {
      .batch-details-grid {
        grid-template-columns: 1fr;
      }
      .facility-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .facility-actions {
        position: static;
        margin-top: 10px;
        align-self: flex-end;
      }
      .facility-details-grid {
        grid-template-columns: 1fr;
      }
      .duration-options {
        flex-direction: column;
      }
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
        <a href="#" class="menu-item active" onclick="showSection(event,'basicData')">
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
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 20%;">
              Step 1 of 5
            </div>
          </div>
        </div>

        <!-- Section: Basic Data -->
        <div class="section-content active" id="basicData">
          <h4>Personal Details</h4>
          <p>Student's personal information and contact details.</p>

          <div class="row">
            <div class="col-md-6">
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user"></i> Name</div>
                <div class="detail-value" id="studentName"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-user-friends"></i> Parent Name</div>
                <div class="detail-value" id="parentName"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
                <div class="detail-value" id="email"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-home"></i> Address</div>
                <div class="detail-value" id="address"></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-phone-alt"></i> Contact</div>
                <div class="detail-value" id="contact"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-phone-alt"></i> Emergency Contact</div>
                <div class="detail-value" id="emergencyContact"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-calendar-alt"></i> Date of Birth</div>
                <div class="detail-value" id="dob"></div>
              </div>
              <div class="detail-row">
                <div class="detail-label"><i class="fas fa-calendar"></i> Joining Date</div>
                <div class="detail-value" id="joiningDate">Not specified</div>
              </div>
            </div>
          </div>

          <div class="text-right mt-4">
            <button type="button" class="btn btn-success next1">Next <i class="fas fa-arrow-right"></i></button>
          </div>
        </div>

        <!-- Section: Batch Details -->
        <div class="section-content" id="batchDetails">
          <h4>Batch Details</h4>
          <p>Information about the student's current and previous batches.</p>
          
          <h5 class="mt-4 mb-3" style="color: #ff4040;">Current Batch</h5>
          
          <div class="batch-card active">
            <div class="batch-header">
              <div class="batch-name" id="batchName"></div>
              <div class="batch-status" id="batchStatus"></div>
            </div>
            <div class="batch-details-grid" id="batchDetailsGrid"></div>
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

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><i class="fas fa-wallet"></i> Total Fees *</label>
              <input type="number" id="totalFees" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <label><i class="fas fa-money-check-alt"></i> Amount Paid *</label>
              <input type="number" id="paidAmount" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <label><i class="fas fa-balance-scale"></i> Remaining Amount *</label>
              <input type="number" id="remainingAmount" class="form-control" readonly>
            </div>
            <div class="form-group col-md-6">
              <label><i class="fas fa-credit-card"></i> Payment Method *</label>
              <input type="text" id="paymentMethod" class="form-control" readonly>
            </div>
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
          
          <h5 class="mt-4 mb-3" style="color: #ff4040;">Current Facilities</h5>
          <div id="currentFacilities"></div>

          <!-- Add New Facility -->
          <h5 class="mt-5 mb-3" style="color: #ff4040;">Add New Facility</h5>
          
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

          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-user"></i> Select Student *</label>
                <select name="student_id" class="form-control" required>
                  <option value="" id="renewStudentName"></option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label><i class="fas fa-signal"></i> Level *</label>
                <select name="level" class="form-control" required>
                  <option value="">-- Select Level --</option>
                  <option value="Beginner">Beginner</option>
                  <option value="Intermediate">Intermediate</option>
                  <option value="Advanced">Advanced</option>
                </select>
              </div>
            </div>

            <div class="section-title mb-2"><i class="fas fa-layer-group"></i> Batch Details</div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label><i class="fas fa-users"></i> Select Batch *</label>
                <select name="batch_id" class="form-control" required>
                  <option value="">-- Select Batch --</option>
                  <option value="morning">Morning Batch</option>
                  <option value="evening">Evening Batch</option>
                  <option value="weekend">Weekend Batch</option>
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
<script>
  // =================== Fetch Student Data ===================
  $(document).ready(function () {
    const urlSegments = window.location.pathname.split('/');
    const studentId = urlSegments[urlSegments.length - 1];

    // Fetch student details
    $.ajax({
      url: '<?php echo base_url("Admission/get_student/"); ?>' + studentId,
      method: 'GET',
      success: function (data) {
        populateStudentData(data);
        fetchStudentFacilities(studentId); // Fetch facilities separately
      },
      error: function () {
        alert('Failed to fetch student data. Please try again.');
      }
    });
  });

  function populateStudentData(data) {
    // Personal Details
    $('#studentName').text(data.name || 'Not specified');
    $('#parentName').text(data.parent_name || 'Not specified');
    $('#email').text(data.email || 'Not specified');
    $('#address').text(data.address || 'Not specified');
    $('#contact').text(data.contact || 'Not specified');
    $('#emergencyContact').text(data.emergency_contact || 'Not specified');
    $('#dob').text(data.dob ? new Date(data.dob).toLocaleDateString() : 'Not specified');
    $('#renewStudentName').val(data.id).text(data.name || 'Not specified');
    $('#joiningDate').text(data.joining_date ? new Date(data.joining_date).toLocaleDateString() : 'Not specified');

    // Batch Details
    const batchStatusClass = data.status?.toLowerCase() === 'deactive' ? 'status-deactive' : 'status-active';
    $('#batchName').text(data.batch_name || 'Not specified');
    $('#batchStatus').text(data.status || 'Not specified').addClass(batchStatusClass);

    const batchDetailsGrid = $('#batchDetailsGrid');
    batchDetailsGrid.empty();

    const batchDetails = [
      { icon: 'university', label: 'Center', value: data.center_name || 'Not specified' },
      { icon: 'chalkboard-teacher', label: 'Coach', value: data.coach || 'Not specified' },
      { icon: 'calendar-alt', label: 'Joining Date', value: data.joining_date ? new Date(data.joining_date).toLocaleDateString() : 'Not specified' },
      { icon: 'clock', label: 'Timing', value: data.batch_start_time || 'Not specified' },
      { icon: 'signal', label: 'Level', value: data.student_progress_category || 'Not specified' }
    ];

    batchDetails.forEach(detail => {
      batchDetailsGrid.append(`
        <div class="batch-detail-item">
          <i class="fas fa-${detail.icon}"></i>
          <span><strong>${detail.label}:</strong> ${detail.value}</span>
        </div>
      `);
    });

    // Fees Details
    $('#totalFees').val(data.total_fees || '0.00');
    $('#paidAmount').val(data.paid_amount || '0.00');
    $('#remainingAmount').val(data.remaining_amount || '0.00');
    $('#paymentMethod').val(data.payment_method || 'Not specified');

    // Renew Admission
    $('#renewStudentName').val(data.id).text(data.name);
    $('select[name="level"]').val(data.student_progress_category || '');
  }

  // =================== Fetch Facilities ===================
 function fetchStudentFacilities(studentId) {
  $.ajax({
    url: '<?php echo base_url("Admission/get_facility_by_student_id/"); ?>' + studentId,
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      const facilitiesContainer = $('#currentFacilities');
      facilitiesContainer.empty();

      if (response.status === "success" && response.data && response.data.length > 0) {
        response.data.forEach(facility => {
          facilitiesContainer.append(`
            <div class="facility-card">
              <div class="facility-header">
                <div class="facility-name">${facility.facility_name}</div>
                <div class="facility-status status-active">Active</div>
              </div>
              <div class="facility-details-grid">
                
                <div class="facility-detail-item">
                  <i class="fas fa-money-bill-wave"></i>
                  <span><strong>Amount:</strong> ₹${parseFloat(facility.amount).toLocaleString()}</span>
                </div>
                
              </div>
            </div>
          `);
        });
      } else {
        facilitiesContainer.append('<p>No facilities assigned.</p>');
      }
    },
    error: function () {
      alert('Failed to fetch facilities. Please try again.');
    }
  });
}
  // Fetch and render facilities for a student
function loadFacilities(studentId) {
  $.ajax({
    url: base_url + "Admission/get_facilities/" + studentId, // your API route
    type: "GET",
    dataType: "json",
    success: function (response) {
      if (response && response.length > 0) {
        let html = "";
        response.forEach(facility => {
          html += `
            <div class="card mb-2 shadow-sm p-3">
              <div class="d-flex justify-content-between align-items-center">
                <strong>${facility.name}</strong>
                <span class="badge badge-success">₹${facility.amount}</span>
              </div>
             
            </div>
          `;
        });
        $("#currentFacilities").html(html);
      } else {
        $("#currentFacilities").html(`<p class="text-muted">No facilities added yet.</p>`);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error loading facilities:", error);
      $("#currentFacilities").html(`<p class="text-danger">Failed to load facilities.</p>`);
    }
  });
}


  // =================== Sidebar & Navigation ===================
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

    // Navigation
    document.querySelector(".next1")?.addEventListener("click", () => navigateTo("basicData", "batchDetails"));
    document.querySelector(".next2")?.addEventListener("click", () => navigateTo("batchDetails", "feesDetails"));
    document.querySelector(".next3")?.addEventListener("click", () => navigateTo("feesDetails", "facilities"));
    document.querySelector(".next4")?.addEventListener("click", () => navigateTo("facilities", "Renew_admission"));
    document.querySelector(".back1")?.addEventListener("click", () => navigateTo("batchDetails", "basicData"));
    document.querySelector(".back2")?.addEventListener("click", () => navigateTo("feesDetails", "batchDetails"));
    document.querySelector(".back3")?.addEventListener("click", () => navigateTo("facilities", "feesDetails"));
    document.querySelector(".back4")?.addEventListener("click", () => navigateTo("Renew_admission", "facilities"));
  });

  function showSection(event, sectionId) {
    event.preventDefault();
    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');
    document.querySelectorAll('.section-content').forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    updateProgressBar(sectionId);
  }

  function navigateTo(currentId, nextId) {
    document.querySelectorAll(".section-content").forEach(sec => sec.classList.remove("active"));
    document.getElementById(nextId).classList.add("active");
    document.querySelectorAll(".menu-item").forEach(item => item.classList.remove("active"));
    document.querySelector(`.menu-item[onclick*='${nextId}']`).classList.add("active");
    updateProgressBar(nextId);
  }

  function updateProgressBar(sectionId) {
    const progressBar = document.getElementById("progressBar");
    let step = 1;

    switch (sectionId) {
      case "basicData": step = 1; break;
      case "batchDetails": step = 2; break;
      case "feesDetails": step = 3; break;
      case "facilities": step = 4; break;
      case "Renew_admission": step = 5; break;
    }

    const percentage = (step / 5) * 100;
    progressBar.style.width = percentage + "%";
    progressBar.innerText = `Step ${step} of 5`;
  }

  // =================== Facility Expiry Date ===================
  window.onload = function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('facilityStartDate').value = today;
    document.getElementById('renewStartDate').value = today;
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

  // =================== Renew Facility ===================
  $('#renewModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const facilityName = button.data('facility');
    const modal = $(this);
    modal.find('.modal-title').text('Renew ' + facilityName);
    modal.find('#renewFacilityName').val(facilityName);
  });

  document.getElementById('facilityForm').addEventListener('submit', function (event) {
    event.preventDefault();
    alert('Facility added successfully!');
  });

  document.getElementById('confirmRenew').addEventListener('click', function () {
    alert('Facility renewed successfully!');
    $('#renewModal').modal('hide');
  });

  // =================== Fees Calculation ===================
  function calculateTotalFees() {
    const baseFees = parseFloat(document.getElementById('baseFees').value) || 0;
    const facilitiesAmount = parseFloat(document.getElementById('facilitiesAmount').value) || 0;
    document.getElementById('totalAmount').value = (baseFees + facilitiesAmount).toFixed(2);
  }
</script>

</body>
</html>