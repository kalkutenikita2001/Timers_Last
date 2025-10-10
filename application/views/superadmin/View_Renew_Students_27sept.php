<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Student</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

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
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      position: sticky;
      top: 90px;
      height: fit-content;
    }

    .inner-sidebar .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      background: rgba(255, 255, 255, 0.1);
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
      background: rgba(255, 255, 255, 0.25);
      transform: translateX(5px);
    }

    .inner-sidebar .menu-item:hover i {
      color: #fff;
    }

    .inner-sidebar .menu-item.active {
      background: #fff;
      color: #470000;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }

    .inner-sidebar .menu-item.active i {
      color: #470000;
    }

    .details-area {
      flex: 1;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
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
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .batch-card:hover {
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
            <i class="fas fa-lock"></i>Current Fees Details
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
                  <div class="detail-value">
                    <input type="text" name="student_name" id="studentName" placeholder="Enter name"
                      class="form-control">
                  </div>
                </div>

                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-user-friends"></i> Parent Name</div>
                  <div class="detail-value">
                    <input type="text" name="parent_name" id="parentName" placeholder="Not specified"
                      class="form-control">
                  </div>
                </div>

                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
                  <div class="detail-value">
                    <input type="email" name="email" id="email" placeholder="Not specified" class="form-control">
                  </div>
                </div>
                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-map-marker-alt"></i> Address</div>
                  <div class="detail-value">
                    <textarea name="address" id="address" placeholder="Not specified" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-phone-alt"></i> Contact</div>
                  <div class="detail-value">
                    <input type="text" name="contact" id="contact" placeholder="Not specified" class="form-control">
                  </div>
                </div>

                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-phone-alt"></i> Emergency Contact</div>
                  <div class="detail-value">
                    <input type="text" id="emergencyContact" name="emergency_contact" class="form-control">
                  </div>
                </div>
                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-calendar-alt"></i> Date of Birth</div>
                  <div class="detail-value">
                    <input type="date" id="dob" name="dob" class="form-control">
                  </div>
                </div>
                <div class="detail-row">
                  <div class="detail-label"><i class="fas fa-calendar"></i> Joining Date</div>
                  <div class="detail-value">
                    <input type="date" class="form-control" id="joiningDate" readonly />
                  </div>
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


            <div class="d-flex justify-content-between mt-3 mb-3">
              <button type="button" class="btn btn-info toggleNewBatchForm">
                <i class="fas fa-plus"></i> Add
              </button>
            </div>

            <!-- Hidden New Batch Form -->
            <div class="newBatchForm"
              style="display: none; border: 1px solid #ddd; padding: 15px; margin-top: 15px; border-radius: 5px;">
              <h5 class="mb-3" style="color: #28a745;">New Batch Details</h5>

              <div class="form-row">
                <div class="form-group col-md-6 col-sm-12">
                  <label><i class="fas fa-university"></i> Center *</label>
                  <select class="form-control" id="centerSelect" name="center" required>
                    <option value="">Select Center</option>
                    <!-- Populated by JavaScript -->
                  </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                  <label><i class="fas fa-calendar-alt"></i> Course Duration *</label>
                  <select class="form-control" id="courseDuration" name="course_duration" required>
                    <option value="">Select Duration</option>
                    <option value="1">1 Month</option>
                    <option value="2">2 Months</option>
                    <option value="3">3 Months</option>
                  </select>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                  <label><i class="fas fa-users"></i> Batch *</label>
                  <select class="form-control" id="batchSelect" name="batch" required>
                    <option value="">Select Batch</option>
                    <!-- Populated by JavaScript -->
                  </select>

                  <input type="hidden" id="selectedBatchId" name="batch_id">
                </div>
              </div>
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

            <h5 class="mt-4 mb-3" style="color: #ff4040;">Current Facilities These Facilities Will Be Remove After Renew
              Addmission </h5>
            <div id="currentFacilities"></div>

            <!-- Add New Facility -->
            <h5 class="mt-5 mb-3" style="color: #ff4040;">Add New Facility For Student</h5>

            <form id="facilityForm">


              <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Select additional facilities for the student. These will be added to
                the total fees.
              </div>
              <div class="row" id="facilitiesContainer">
                <!-- Locker Facility -->
                <div class="row" id="facilityCards"></div>

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

              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary back3"><i class="fas fa-arrow-left"></i> Back</button>
                <!-- <button type="submit" class="btn btn-primary" id="addFacilityBtn"><i class="fas fa-plus"></i> Add
                  Facility</button> -->
                <button type="button" class="btn btn-success next4">Next <i class="fas fa-arrow-right"></i></button>
              </div>
            </form>
          </div>

          <!-- Section: Renew Admission -->
          <div class="section-content" id="Renew_admission">
            <h4>Renew Admission</h4>
            <p>Fill the form to renew the student's admission including details of student, batch, facility and payment.
            </p>

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

              <!-- <div class="section-title mb-2"><i class="fas fa-layer-group"></i> Batch Details</div>
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
 -->
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
                  <label><i class="fas fa-rupee-sign"></i> Course Amount (₹) *</label>
                  <input type="number" name="base_fees" id="baseFees" class="form-control" placeholder="Enter amount"
                    required>
                </div>

                <div class="form-group col-md-4">
                  <label><i class="fas fa-rupee-sign"></i> old Remaining Amount (₹)</label>
                  <input type="number" name="old_amount" id="old_amount" class="form-control" readonly value="0">
                </div>

                <div class="form-group col-md-4">
                  <label><i class="fas fa-rupee-sign"></i> Facilities Amount (₹)</label>
                  <input type="number" name="facilities_amount" id="facilitiesAmount" class="form-control" readonly
                    value="0">
                </div>


                <div class="form-group col-md-4">
                  <label><i class="fas fa-rupee-sign"></i> Now Paying Amount (₹) *</label>
                  <input type="number" name="paid_fees" id="paidAmounts" class="form-control" placeholder="Enter amount"
                    required>
                </div>

                <div class="form-group col-md-4">
                  <label><i class="fas fa-rupee-sign"></i> New Remaining Fees Amount (₹) *</label>
                  <input type="number" name="new_remaining" id="newRemainingAmount" class="form-control" readonly
                    required>
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
                <button type="button" id="generateReceiptBtn" class="btn btn-success">
                  Generate Receipt <i class="fas fa-check"></i>
                </button>
              </div>
            </form>
          </div>

          <!-- Renew Facility Modal -->
          <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel"
            aria-hidden="true">
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
                        <input type="date" class="form-control" id="renewStartDate" required
                          onchange="updateRenewExpiryDate()">
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

    $(document).ready(function () {
      // Toggle New Batch Form
      $('.toggleNewBatchForm').click(function () {
        $('.newBatchForm').slideToggle(); // toggles the form visibility

        // Change button icon/text
        if ($('.newBatchForm').is(':visible')) {
          $(this).html('<i class="fas fa-minus"></i> Hide New Batch');
        } else {
          $(this).html('<i class="fas fa-plus"></i> Add New Batch');
        }
      });
    });



    document.addEventListener("DOMContentLoaded", function () {
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Fetch Centers, Batches, Categories, and Lockers -->
  <script>
    const baseUrl = "<?= base_url(); ?>"; // CI3 base URL

    // 🔹 Fetch centers
    function fetchCenters() {
      $.ajax({
        url: baseUrl + "Admission/get_centers",
        method: "GET",
        dataType: "json",
        success: function (data) {
          const centerSelect = $('#centerSelect');
          centerSelect.empty().append('<option value="">Select Center</option>');
          data.forEach(center => {
            centerSelect.append(`<option value="${center.id}">${center.name}</option>`);
          });
        },
        error: function () {
          alert('Failed to fetch centers');
        }
      });
    }

    // 🔹 Fetch categories
    function fetchCategories() {
      $.ajax({
        url: baseUrl + "Admission/get_categories",
        method: "GET",
        dataType: "json",
        success: function (data) {
          const categorySelect = $('#categorySelect');
          categorySelect.empty().append('<option value="">Select Category</option>');
          data.forEach(category => {
            categorySelect.append(`<option value="${category}">${category}</option>`);
          });
        },
        error: function () {
          alert('Failed to fetch categories');
        }
      });
    }

    // 🔹 Fetch lockers
    function fetchLockers(centerId) {
      $.ajax({
        url: baseUrl + "Center/getFacilities/" + centerId,
        method: "GET",
        dataType: "json",
        success: function (data) {
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
        error: function () {
          $('#lockerStatus').text('Error fetching lockers');
          $('#lockerCheckbox').prop('disabled', true).closest('.facility-card').addClass('facility-unavailable');
        }
      });
    }

    // 🔹 Fetch batches (and update batch select)
    function fetchBatches(centerId) {
      const batchSelect = $('#batchSelect');
      const batchTimeInfo = $('#batchTimeInfo');
      const batchList = $('#batchList');

      batchSelect.empty().append('<option value="">Select Batch</option>');
      batchTimeInfo.hide();
      batchList.empty();

      if (centerId) {
        $.ajax({
          url: baseUrl + "Admission/get_batches/" + centerId,
          method: "GET",
          dataType: "json",
          success: function (data) {
            if (data.length > 0) {
              data.forEach(batch => {
                // Add to dropdown
                batchSelect.append(`
                                <option value="${batch.id}" 
                                    data-batchName="${batch.batch_name}" 
                                    data-timing="${batch.start_time}-${batch.end_time}" 
                                    data-startDate="${batch.start_date}"
                                    data-category="${batch.category}"
                                    data-days="${batch.days}">
                                    (${batch.batch_name}) - (${batch.start_time}-${batch.end_time}) (${batch.category})
                                </option>
                            `);

                // Add to detailed batch schedule list
                batchList.append(`
                                <div class="single-batch card p-2 mb-2 shadow-sm">
                                    <h6 id="batchName_${batch.id}"><strong>${batch.batch_name}</strong></h6>
                                    <p id="batchTime_${batch.id}">
                                        <i class="fas fa-clock"></i> ${batch.start_time} - ${batch.end_time}
                                    </p>
                                    <p id="batchDate_${batch.id}">
                                        <i class="fas fa-calendar"></i> Start Date: ${batch.start_date}
                                    </p>
                                    <p id="batchCategory_${batch.id}">
                                        <i class="fas fa-tag"></i> Category: ${batch.category}
                                    </p>
                                  
                                </div>
                            `);
              });
              fetchLockers(centerId);
            } else {
              batchSelect.append('<option disabled>No batches available</option>');
              batchList.html("<p>No batch schedule available.</p>");
            }
          },
          error: function () {
            alert('Failed to fetch batches');
          }
        });
      }
    }

    // // 🔹 Event: Center select change
    $('#centerSelect').change(function () {
      const centerId = $(this).val();
      loadFacilitiesdata(centerId);
      fetchBatches(centerId);

    });




    // 🔹 Event: Batch select change
    // 🔹 Event: Batch select change
    $('#batchSelect').change(function () {
      const batchTimeInfo = $('#batchTimeInfo');
      const batchTimeSlots = $('#batchTimeSlots');
      const batchDays = $('#batchDays');

      batchTimeSlots.empty();
      batchDays.empty();
      batchTimeInfo.hide();

      const selectedOption = $(this).find('option:selected');
      const batchId = selectedOption.val();   // ✅ Batch ID
      const timing = selectedOption.data('timing');
      const startDate = selectedOption.data('startdate');
      const category = selectedOption.data('category');
      const days = selectedOption.data('days') ? selectedOption.data('days').split(',') : [];

      // ✅ Save selected batch id
      $('#selectedBatchId').val(batchId);

      if (timing) {
        batchTimeSlots.append(`
      <div class="time-slot">
        <i class="fas fa-clock text-success"></i>
        <span>Timing: ${timing}</span><br>
        <i class="fas fa-calendar"></i> Start Date: ${startDate}<br>
        <i class="fas fa-tag"></i> Category: ${category}
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

    // 🔹 Init calls
    $(document).ready(function () {
      fetchCenters();
      fetchCategories();
    });

    function loadFacilitiesdata(centerId) {
      console.log("Loading facilities for center:", centerId); // ✅ Debug
      $("#facilityCards").empty();
      $.ajax({
        url: baseUrl + "center/getFacilitiesByCenterId/" + centerId,
        method: "GET",
        dataType: "json",
        success: function (response) {
          if (response.status === "success" && response.data.length > 0) {
            console.log("Facilities API response:", response); // ✅ Debug

            // Group facilities by name
            const grouped = {};
            response.data.forEach(fac => {
              if (!grouped[fac.facility_name]) {
                grouped[fac.facility_name] = [];
              }
              grouped[fac.facility_name].push(fac);
            });

            // Build facility cards
            Object.keys(grouped).forEach(facilityName => {
              const options = grouped[facilityName]
                .map(fac => `
              <option value="${fac.rent_amount}" 
                      data-id="${fac.id}" 
                      data-date="${fac.rent_date || '-'}">
                ${fac.subtype_name || "N/A"} (₹${fac.rent_amount})
              </option>`)
                .join("");

              const facilityId = "facilityCheckbox_" + facilityName.replace(/\s+/g, '_');

              const facilityCard = `
            <div class="col-md-4 col-sm-12 mb-3">
              <div class="facility-card" data-facility="${facilityName}">
                <div class="form-check">
                  <input class="form-check-input facility-checkbox" type="checkbox" id="${facilityId}">
                  <label class="form-check-label" for="${facilityId}">
                    <strong><i class="fas fa-building"></i> ${facilityName}</strong>
                  </label>
                </div>
                <div class="facility-details mt-2" style="display:none;">
                  <div class="form-group">
                    <label>Select Type</label>
                    <select class="form-control facility-subtype" disabled>
                      <option value="">-- Select --</option>
                      ${options}
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Rent Date</label>
                    <input type="text" class="form-control rent-date" readonly>
                  </div>
                </div>
                <div class="facility-toggle">Show details <i class="fas fa-chevron-down"></i></div>
              </div>
            </div>
          `;

              $("#facilityCards").append(facilityCard);
            });

            bindFacilityEvents();
          } else {
            $("#facilityCards").html(`<p class="text-danger">No facilities found.</p>`);
          }
        }
      });
    }

    function bindFacilityEvents() {
      // Toggle details
      $('.facility-toggle').off().on('click', function () {
        const details = $(this).siblings('.facility-details');
        details.slideToggle();
        const icon = $(this).find('i');
        if (icon.hasClass('fa-chevron-down')) {
          $(this).html('Hide details <i class="fas fa-chevron-up"></i>');
        } else {
          $(this).html('Show details <i class="fas fa-chevron-down"></i>');
        }
      });

      // Enable dropdown when checkbox selected
      $('.facility-checkbox').off().on('change', function () {
        const facilityCard = $(this).closest('.facility-card');
        const subtypeSelect = facilityCard.find('.facility-subtype');
        if ($(this).is(':checked')) {
          subtypeSelect.prop('disabled', false);
          facilityCard.addClass('selected');
        } else {
          subtypeSelect.prop('disabled', true).val("");
          facilityCard.removeClass('selected');
        }
        updateFacilitiesSummary();
        calculateTotalFeess();
      });

      // Update summary when subtype changes
      $('.facility-subtype').off().on('change', function () {
        const facilityCard = $(this).closest('.facility-card');
        const rentDate = $(this).find(':selected').data('date') || '-';
        facilityCard.find('.rent-date').val(rentDate);
        updateFacilitiesSummary();
        calculateTotalFeess();
      });
    }

    // function updateFacilitiesSummary() {
    //   const summaryBody = $('#facilitiesSummary tbody');
    //   summaryBody.empty();
    //   let total = 0;

    //   $('.facility-checkbox:checked').each(function () {
    //     const facilityCard = $(this).closest('.facility-card');
    //     const facilityName = facilityCard.data('facility');
    //     const subtypeSelect = facilityCard.find('.facility-subtype');
    //     const selectedOption = subtypeSelect.find('option:selected');
    //     const subtype = selectedOption.text();
    //     const rentAmount = parseFloat(selectedOption.val()) || 0;

    //     if (subtype && rentAmount > 0) {
    //       total += rentAmount;
    //       summaryBody.append(`
    //     <tr>
    //       <td>${facilityName}</td>
    //       <td>${subtype}</td>
    //       <td class="text-right">₹${rentAmount.toLocaleString()}</td>
    //     </tr>
    //   `);
    //     }
    //   });

    //   $('#facilitiesTotal').text('₹' + total.toLocaleString());
    //   $('#facilitiesAmount').val(total); // ✅ correct field from your HTML
    //   calculateTotalFeess();
    // }


    let selectedFacilities = []; // global array

    function updateFacilitiesSummary() {
      const summaryBody = $('#facilitiesSummary tbody');
      summaryBody.empty();
      let total = 0;
      selectedFacilities = []; // reset

      $('.facility-checkbox:checked').each(function () {
        const facilityCard = $(this).closest('.facility-card');
        const facilityName = facilityCard.data('facility');
        const subtypeSelect = facilityCard.find('.facility-subtype');
        const selectedOption = subtypeSelect.find('option:selected');

        const facilityId = selectedOption.data('id');  // ✅ ID from option
        const rentAmount = parseFloat(selectedOption.val()) || 0;
        const subtype = selectedOption.text();

        if (subtype && rentAmount > 0) {
          total += rentAmount;

          // Push into global array
          selectedFacilities.push({
            id: facilityId,
            name: facilityName,
            subtype: subtype,
            amount: rentAmount
          });

          // Update UI
          summaryBody.append(`
        <tr>
          <td>${facilityName}</td>
          <td>${subtype}</td>
          <td class="text-right">₹${rentAmount.toLocaleString()}</td>
        </tr>
      `);
        }
      });

      $('#facilitiesTotal').text('₹' + total.toLocaleString());
      $('#facilitiesAmount').val(total);
      calculateTotalFeess();
    }


    // function calculateTotalFeess() {

    //   const baseFees = parseFloat($('#baseFees').val()) || 0; // ✅
    //   const oldAmount = parseFloat($('#old_amount').val()) || 0; // ✅
    //   const facilitiesAmount = parseFloat($('#facilitiesAmount').val()) || 0; // ✅

    //   const totalAmount = baseFees + oldAmount + facilitiesAmount;
    //   $('#totalAmount').val(totalAmount); // ✅

    //   $('#totalFees').val(totalAmount); // ✅ your second section's total fees field
    //   calculateRemainingAmount();
    // }

    // function calculateRemainingAmount() {
    //   const totalFees = parseFloat($('#totalFees').val()) || 0;
    //   const paidAmount = parseFloat($('#paidAmount').val()) || 0;
    //   const remainingAmount = totalFees - paidAmount;
    //   $('#remainingAmount').val(remainingAmount >= 0 ? remainingAmount : 0);
    // }

    function calculateTotalFeess() {
      const baseFees = parseFloat($('#baseFees').val()) || 0;       // Course Amount
      const oldAmount = parseFloat($('#old_amount').val()) || 0;    // Old Remaining
      const facilitiesAmount = parseFloat($('#facilitiesAmount').val()) || 0; // Facilities

      const totalAmount = baseFees + oldAmount + facilitiesAmount;

      $('#totalAmount').val(totalAmount);   // Total Amount
      $('#totalFees').val(totalAmount);     // Hidden / backend field

      calculateRemainingAmount();
    }

    function calculateRemainingAmount() {
      const totalFees = parseFloat($('#totalFees').val()) || 0;
      const paidAmount = parseFloat($('#paidAmounts').val()) || 0;  // Paid Fees
      const remainingAmount = totalFees - paidAmount;

      $('#newRemainingAmount').val(remainingAmount >= 0 ? remainingAmount : 0); // Show new remaining
    }


    $(document).ready(function () {
      $('#baseFees').on('input', calculateTotalFeess);  // Course Amount change
      $('#paidAmounts').on('input', calculateRemainingAmount); // Paid Amount change
    });

    // Event bindings
    // $(document).ready(function () {
    //   $('#baseFees').on('input', calculateTotalFeess);
    //   $('#paidAmount').on('input', calculateRemainingAmount);
    // });

  </script>

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
          loadFacilitiesdata(data.center_id);
        },
        error: function () {
          alert('Failed to fetch student data. Please try again.');
        }
      });
    });

    function populateStudentData(data) {
      // Personal Details
      // $('#studentName').text(data.name || 'Not specified');
      // $('#parentName').text(data.parent_name || 'Not specified');
      // $('#email').text(data.email || 'Not specified');
      // $('#address').text(data.address || 'Not specified');
      // $('#contact').text(data.contact || 'Not specified');
      // $('#emergencyContact').text(data.emergency_contact || 'Not specified');
      // $('#dob').text(data.dob ? new Date(data.dob).toLocaleDateString() : 'Not specified');
      // $('#renewStudentName').val(data.id).text(data.name || 'Not specified');
      // $('#joiningDate').text(data.joining_date ? new Date(data.joining_date).toLocaleDateString() : 'Not specified');

      // // Batch Details
      // const batchStatusClass = data.status?.toLowerCase() === 'deactive' ? 'status-deactive' : 'status-active';
      // $('#batchName').text(data.batch_name || 'Not specified');
      // $('#batchStatus').text(data.status || 'Not specified').addClass(batchStatusClass);



      $('#studentName').val(data.name || '');

      $('#parentName').val(data.parent_name || 'Not specified');
      $('#email').val(data.email || '');
      $('#address').val(data.address || '');

      $('#contact').val(data.contact || '');

      // Emergency Contact
      $('#emergencyContact').val(data.emergency_contact || '');

      // Date of Birth (for <input type="date"> expects yyyy-mm-dd)
      $('#dob').val(data.dob || '');

      // Prevent past date selection
      let today = new Date().toISOString().split('T')[0]; // format: yyyy-mm-dd
      $('#dob').attr('max', today);

      $('#renewStudentName').val(data.id).text(data.name || 'Not specified');
      // Set Joining Date value (if exists, else blank)
      $('#joiningDate').val(data.joining_date || '');

      // Make sure user cannot type/change
      $('#joiningDate').prop('readonly', true);
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

      $('#old_amount').val(data.remaining_amount || '0.00');


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

  <script>
    document.getElementById("generateReceiptBtn").addEventListener("click", async function () {
      console.log("button clicked");

      const center_id = document.getElementById("centerSelect").value;
      const baseFees = document.getElementById("baseFees").value;
      const newRemaining = document.getElementById("newRemainingAmount").value; // ✅ take calculated value
      const studentName = document.getElementById("studentName").value;
      const parentName = document.getElementById("parentName").value;
      const email = document.getElementById("email").value;
      const address = document.getElementById("address").value;
      const contact = document.getElementById("contact").value;
      const batchId = document.getElementById("selectedBatchId").value;
      const courseDuration = document.getElementById("courseDuration").value;
      const level = document.querySelector('select[name="level"]').value;
      const paidAmounts = document.getElementById("paidAmounts").value;
      const totalAmount = document.getElementById("totalAmount").value;
      const paymentMode = document.querySelector('select[name="payment_mode"]').value; // ✅ payment mode
      const receiptNo = document.querySelector('input[name="receipt_no"]').value;
      const joinDate = document.getElementById("joinDate").value;
      const expiryDate = document.getElementById("expiryDate").value;

      const facilitiesAmount = document.getElementById("facilitiesAmount").value;





      const urlSegments = window.location.pathname.split("/");
      const studentId = urlSegments[urlSegments.length - 1];

      // 🚨 Validation for studentId
      if (!studentId || studentId.trim() === "" || isNaN(studentId)) {
        Swal.fire("Error", "Invalid Student ID. Cannot proceed.", "error");
        return;
      }

      // ✅ Validation
      if (!baseFees) {
        Swal.fire("Error", "Please enter Course Amount", "error");
        return;
      }
      if (!paymentMode) {
        Swal.fire("Error", "Please select a Payment Mode", "error");
        return;
      }

      if (!joinDate) {
        Swal.fire("Error", "Please select a Join Date", "error");
        return;
      }

      // // Check center
      // if (!center_id) {
      //   Swal.fire("Error", "Please select a Center", "error");
      //   return;
      // }

      // Check batch if center is selected
      if (center_id) {
        if (!batchId || batchId.trim() === "") {
          Swal.fire("Error", "Please add/select a Batch for the selected Center", "error");
          return;
        }

        // if (!branch_id || branch_id.trim() === "") {
        //   Swal.fire("Error", "Please add/select a Branch for the selected Center", "error");
        //   return;
        // }
      }




      const formData = new FormData();
      selectedFacilities.forEach((fac, index) => {
        formData.append(`facilities[${index}][id]`, fac.id);
        formData.append(`facilities[${index}][name]`, fac.name);
        formData.append(`facilities[${index}][subtype]`, fac.subtype);
        formData.append(`facilities[${index}][amount]`, fac.amount);
      });




      formData.append("student_id", studentId);

      formData.append("facilities_amount", facilitiesAmount);

      formData.append("center_id", center_id);
      formData.append("baseFees", baseFees);
      formData.append("newRemaining", newRemaining);

      formData.append("studentName", studentName);
      formData.append("parentName", parentName);
      formData.append("email", email);
      formData.append("address", address);
      formData.append("contact", contact);

      formData.append("batch_id", batchId);
      formData.append("course_duration", courseDuration);
      formData.append("level", level);

      formData.append("paid_fees", paidAmounts);
      formData.append("total_amount", totalAmount);
      formData.append("payment_mode", paymentMode);
      formData.append("receipt_no", receiptNo);

      formData.append("join_date", joinDate);
      formData.append("expiry_date", expiryDate);

      try {
        const response = await fetch(baseUrl + "Admission/renewaddmission", {
          method: "POST",
          body: formData
        });

        const result = await response.json();

        if (result.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Receipt Generated",
            text: result.message,
            timer: 2000,
            showConfirmButton: false,
            
            
          });
           window.location.href = '<?= base_url('receipt?student_id=') ?>' + studentId;
        }
        else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: result.message
          });
        }
      } catch (error) {
        Swal.fire({
          icon: "error",
          title: "Server Error",
          text: "Something went wrong. Please try again."
        });
      }
    });
  </script>



</body>

</html>