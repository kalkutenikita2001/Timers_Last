<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Center Management UI</title>
  
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
  <style>
    :root {
      --primary-color: #007bff;
      --accent-color: #ff4d4f;
      --background-color: #f8fafc;
      --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      --card-hover-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      --button-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    body {
      background-color: var(--background-color) !important;
      margin: 0;
      font-family: 'Inter', sans-serif !important;
      overflow-x: hidden;
    }
    .content-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: var(--transition);
      min-height: 100vh;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .filter-wrapper {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
    }
    .filter-btn,
    .add-center-btn {
      background: #ffffff;
      color: #1a202c;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 15px;
      font-weight: 500;
      box-shadow: var(--button-shadow);
      transition: var(--transition);
    }
    .filter-btn:hover,
    .add-center-btn:hover {
      background: linear-gradient(135deg, #f7fafc, #edf2f7);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .center-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px;
      width: 100%;
      border-left: 4px solid var(--accent-color);
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      margin-bottom: 20px;
    }
    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--card-hover-shadow);
    }
    .card-icon {
      font-size: 1.5rem;
      color: #4a5568;
      margin-bottom: 10px;
    }
    .card-details p {
      margin: 8px 0;
      font-size: 0.9rem;
      color: #2d3748;
      line-height: 1.6;
    }
    .card-details p:first-child {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 10px;
    }
    .card-details p span {
      font-weight: 500;
      color: #1a202c;
    }
    .view-btn {
      margin-top: 12px;
      padding: 8px 16px;
      border: none;
      background: #edf2f7;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
    }
    .view-btn:hover {
      background: #e2e8f0;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .accordion .card {
      border: none;
      margin-bottom: 10px;
    }
    .accordion .card-header {
      background: #f7fafc;
      border-radius: 8px;
      padding: 10px 15px;
      cursor: pointer;
    }
    .accordion .card-body {
      background: #ffffff;
      border-radius: 0 0 8px 8px;
      padding: 15px;
    }
    .sub-card {
      background: #f8fafc;
      border-radius: 8px;
      padding: 10px;
      margin-bottom: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }
    .modal-content {
      background: #ffffff;
      border-radius: 12px;
      padding: 30px;
      border: 2px solid var(--primary-color);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      position: relative;
      animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
      color: #1a202c;
    }
    .modal-close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #4a5568;
      cursor: pointer;
      transition: var(--transition);
    }
    .modal-close-btn:hover {
      color: var(--accent-color);
      transform: scale(1.1);
    }
    .modal-backdrop.show {
      backdrop-filter: blur(8px);
    }
    .form-group {
      margin-bottom: 1.5rem;
    }
    .form-group label {
      font-weight: 500;
      font-size: 0.95rem;
      color: #2d3748;
      margin-bottom: 10px;
      display: block;
    }
    .form-control,
    .form-control select {
      height: 44px;
      border-radius: 8px;
      font-size: 0.95rem;
      border: 1px solid #e2e8f0;
      transition: var(--transition);
    }
    .form-control:focus,
    .form-control select:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 8px rgba(255, 77, 79, 0.2);
    }
    .form-control::placeholder {
      color: #a0aec0;
    }
    .form-group select.form-control {
      appearance: none;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%234a5568" d="M7 10l5 5 5-5z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 14px;
    }
    .submit-btn,
    .close-btn,
    .next-btn,
    .add-facility-btn,
    .remove-facility-btn {
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 500;
      font-size: 0.95rem;
      margin: 8px;
      border: none;
      transition: var(--transition);
    }
    .submit-btn,
    .next-btn,
    .add-facility-btn {
        background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: #ffffff;
    }
    .submit-btn:hover,
    .next-btn:hover,
    .add-facility-btn:hover {
           background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .close-btn,
    .remove-facility-btn {
      background: #e2e8f0;
      color: #4a5568;
    }
    .close-btn:hover,
    .remove-facility-btn:hover {
      background: #cbd5e0;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .invalid-feedback {
      color: #e53e3e;
      font-size: 0.85rem;
      margin-top: 8px;
    }
    .facility-entry,
    .batch-entry,
    .staff-entry {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background: #f7fafc;
      position: relative;
    }
    .facility-entry .remove-facility-btn,
    .batch-entry .remove-batch-btn,
    .staff-entry .remove-staff-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 5px 10px;
      font-size: 0.85rem;
    }
    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      width: 250px;
      background: #2d3748;
      color: #ffffff;
      padding-top: 20px;
      transition: var(--transition);
    }
    .navbar {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      padding: 12px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: var(--transition);
      z-index: 1000;
    }
    .content {
      margin-top: 60px;
    }
    .blur {
      filter: blur(6px);
      transition: var(--transition);
    }
    .step-nav {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .step-nav span {
      margin: 0 15px;
      font-size: 0.95rem;
      color: #718096;
      font-weight: 500;
    }
    .step-nav .step-active {
      color: #1a202c;
      font-weight: 600;
    }
    /* Toggle-specific styles */
    .sidebar.minimized {
      width: 60px;
    }
    .sidebar.active {
      transform: translateX(0);
    }
    .navbar.sidebar-minimized {
      left: 60px;
    }
    .navbar.sidebar-hidden {
      left: 0;
    }
    /* Responsive Design */
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0;
        padding: 12px;
      }
      .center-card {
        padding: 15px;
        font-size: 0.85rem;
      }
      .filter-btn,
      .add-center-btn {
        width: 100%;
        max-width: 140px;
        font-size: 0.85rem;
        padding: 8px 12px;
      }
      .modal-content {
        padding: 20px;
      }
      .sidebar {
        width: 250px;
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .navbar {
        left: 0;
      }
    }
    @media (min-width: 577px) and (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 15px;
      }
      .center-card {
        margin: 12px auto;
      }
      .filter-btn,
      .add-center-btn {
        width: 160px;
        font-size: 0.9rem;
      }
      .modal-content {
        max-width: 90%;
        padding: 20px;
      }
      .sidebar {
        width: 250px;
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .navbar {
        left: 0;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
        padding: 18px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
      }
      .center-card {
        margin: 12px auto;
      }
      .filter-btn,
      .add-center-btn {
        width: 170px;
        font-size: 0.95rem;
      }
      .modal-content {
        max-width: 500px;
      }
      .sidebar {
        width: 200px;
      }
      .sidebar.minimized {
        width: 60px;
      }
      .navbar {
        left: 200px;
      }
      .navbar.sidebar-minimized {
        left: 60px;
      }
    }
    @media (min-width: 992px) {
      .filter-btn,
      .add-center-btn {
        width: 180px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <?php $this->load->view('superadmin/Include/Navbar') ?>
  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <div class="filter-wrapper">
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">
            <i class="fas fa-filter mr-2"></i> Filter
          </button>
        </div>
        <div class="row" id="centerCards"></div>
        <div class="button-container d-flex justify-content-center mt-4">
          <button class="add-center-btn" data-toggle="modal" data-target="#newCenterModal">
            <i class="fas fa-plus mr-2"></i> Add Center
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- New Center Modal (Step 1: Center Details) -->
  <div class="modal fade" id="newCenterModal" tabindex="-1" aria-labelledby="newCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="newCenterLabel">Center Details</h3>
        <div class="step-nav">
          <span class="step-active">1. Center Details <i class="fas fa-arrow-right"></i></span>
          <span>2. Batch Management <i class="fas fa-arrow-right"></i></span>
          <span>3. Facility Management <i class="fas fa-arrow-right"></i></span>
          <span>4. Staff Management</span>
        </div>
        <form id="centerForm">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="center_name">Center Name <span class="text-danger">*</span></label>
              <input type="text" id="center_name" name="center_name" class="form-control" required placeholder="Enter Center Name" />
            </div>
            <div class="form-group col-md-6">
              <label for="center_timing">Timing <span class="text-danger">*</span></label>
              <input type="time" id="center_timing" name="center_timing" class="form-control" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="center_rent">Center Rent <span class="text-danger">*</span></label>
              <input type="number" id="center_rent" name="center_rent" class="form-control" required placeholder="Enter Rent Amount" />
            </div>
            <div class="form-group col-md-6">
              <label for="center_rent_date">Rent Date <span class="text-danger">*</span></label>
              <input type="date" id="center_rent_date" name="center_rent_date" class="form-control" required />
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
            <button type="button" class="next-btn btn" id="centerNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- New Center Modal (Step 2: Batch Management) -->
  <div class="modal fade" id="batchModal" tabindex="-1" aria-labelledby="batchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="batchLabel">Batch Management</h3>
        <div class="step-nav">
          <span>1. Center Details <i class="fas fa-arrow-right"></i></span>
          <span class="step-active">2. Batch Management <i class="fas fa-arrow-right"></i></span>
          <span>3. Facility Management <i class="fas fa-arrow-right"></i></span>
          <span>4. Staff Management</span>
        </div>
        <!-- <form id="batchForm"> -->
          <form id="batchForm" method="post" action="<?= base_url('Center/save_batch') ?>">

          <div id="batchEntries">
            <div class="batch-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_timing_0">Batch Timing <span class="text-danger">*</span></label>
                  <input type="time" id="batch_timing_0" name="batch_timing[]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="start_date_0">Start Date <span class="text-danger">*</span></label>
                  <input type="date" id="start_date_0" name="start_date[]" class="form-control" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_category_0">Category <span class="text-danger">*</span></label>
                  <select id="batch_category_0" name="batch_category[]" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                  </select>
                </div>
              </div>
              <button type="button" class="remove-batch-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="add-batch-btn btn">Add Batch</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
            <button type="button" class="next-btn btn" id="batchNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- New Center Modal (Step 3: Facility Management) -->
  <div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="facilityLabel">Facility Management</h3>
        <div class="step-nav">
          <span>1. Center Details <i class="fas fa-arrow-right"></i></span>
          <span>2. Batch Management <i class="fas fa-arrow-right"></i></span>
          <span class="step-active">3. Facility Management <i class="fas fa-arrow-right"></i></span>
          <span>4. Staff Management</span>
        </div>
        <form id="facilityForm">
          <div id="facilityEntries">
            <div class="facility-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="facility_0">Facility <span class="text-danger">*</span></label>
                  <select id="facility_0" name="facility[]" class="form-control" required>
                    <option value="">Select Facility</option>
                    <option value="Locker">Locker</option>
                    <option value="Shoe">Shoe</option>
                    <option value="Racket">Racket</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="locker_no_0">Locker No</label>
                  <input type="text" id="locker_no_0" name="locker_no[]" class="form-control" placeholder="Enter Locker No" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="facility_rent_0">Rent <span class="text-danger">*</span></label>
                  <input type="number" id="facility_rent_0" name="facility_rent[]" class="form-control" required placeholder="Enter Rent Amount" />
                </div>
                <div class="form-group col-md-6">
                  <label for="facility_rent_date_0">Rent Date <span class="text-danger">*</span></label>
                  <input type="date" id="facility_rent_date_0" name="facility_rent_date[]" class="form-control" required />
                </div>
              </div>
              <button type="button" class="remove-facility-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="add-facility-btn btn">Add Facility</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
            <button type="button" class="next-btn btn" id="facilityNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- New Center Modal (Step 4: Staff Management) -->
  <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="staffLabel">Staff Management</h3>
        <div class="step-nav">
          <span>1. Center Details <i class="fas fa-arrow-right"></i></span>
          <span>2. Batch Management <i class="fas fa-arrow-right"></i></span>
          <span>3. Facility Management <i class="fas fa-arrow-right"></i></span>
          <span class="step-active">4. Staff Management</span>
        </div>
        <form id="staffForm">
          <div id="staffEntries">
            <div class="staff-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="staff_category_0">Category <span class="text-danger">*</span></label>
                  <select id="staff_category_0" name="staff_category[]" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="coach">Coach</option>
                    <option value="co-ordinator">Co-ordinator</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="staff_name_0">Staff Name <span class="text-danger">*</span></label>
                  <input type="text" id="staff_name_0" name="staff_name[]" class="form-control" required placeholder="Enter Staff Name" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="staff_timing_0">Timing <span class="text-danger">*</span></label>
                  <input type="time" id="staff_timing_0" name="staff_timing[]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="join_date_0">Join Date <span class="text-danger">*</span></label>
                  <input type="date" id="join_date_0" name="join_date[]" class="form-control" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_selection_0">Batch Selection <span class="text-danger">*</span></label>
                  <select id="batch_selection_0" name="batch_selection[]" class="form-control" required>
                    <option value="">Select Batch Timing</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="contact_0">Contact <span class="text-danger">*</span></label>
                  <input type="text" id="contact_0" name="contact[]" class="form-control" required placeholder="Enter Contact" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="address_0">Address <span class="text-danger">*</span></label>
                  <input type="text" id="address_0" name="address[]" class="form-control" required placeholder="Enter Address" />
                </div>
              </div>
              <button type="button" class="remove-staff-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="add-staff-btn btn">Add Staff</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
            <button type="submit" class="submit-btn btn" id="submitAllData">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Centers</h3>
        <form id="filterForm">
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterCenterName">Center Name</label>
              <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" placeholder="Enter center name" />
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="submit-btn btn">Apply Filter</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- View Center Modal -->
  <div class="modal fade" id="viewCenterModal" tabindex="-1" aria-labelledby="viewCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewCenterLabel">View Center Details</h3>
        <div class="accordion" id="viewAccordion">
          <!-- Center Details -->
          <div class="card">
            <div class="card-header" id="headingCenter" data-toggle="collapse" data-target="#collapseCenter" aria-expanded="true" aria-controls="collapseCenter">
              <h5 class="mb-0">Center Details</h5>
            </div>
            <div id="collapseCenter" class="collapse show" aria-labelledby="headingCenter" data-parent="#viewAccordion">
              <div class="card-body">
                <dl class="row">
                  <dt class="col-sm-3">Center Name:</dt>
                  <dd class="col-sm-9" id="view_center_name"></dd>
                  <dt class="col-sm-3">Timing:</dt>
                  <dd class="col-sm-9" id="view_timing"></dd>
                  <dt class="col-sm-3">Rent:</dt>
                  <dd class="col-sm-9" id="view_center_rent"></dd>
                  <dt class="col-sm-3">Rent Date:</dt>
                  <dd class="col-sm-9" id="view_rent_date"></dd>
                </dl>
              </div>
            </div>
          </div>
          <!-- Batches -->
          <div class="card">
            <div class="card-header" id="headingBatches" data-toggle="collapse" data-target="#collapseBatches" aria-expanded="false" aria-controls="collapseBatches">
              <h5 class="mb-0">Batches</h5>
            </div>
            <div id="collapseBatches" class="collapse" aria-labelledby="headingBatches" data-parent="#viewAccordion">
              <div class="card-body">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Timing</th>
                      <th>Start Date</th>
                      <th>Category</th>
                    </tr>
                  </thead>
                  <tbody id="view_batches"></tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Facilities -->
          <div class="card">
            <div class="card-header" id="headingFacilities" data-toggle="collapse" data-target="#collapseFacilities" aria-expanded="false" aria-controls="collapseFacilities">
              <h5 class="mb-0">Facilities</h5>
            </div>
            <div id="collapseFacilities" class="collapse" aria-labelledby="headingFacilities" data-parent="#viewAccordion">
              <div class="card-body">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Locker No</th>
                      <th>Rent</th>
                      <th>Rent Date</th>
                    </tr>
                  </thead>
                  <tbody id="view_facilities"></tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Staff -->
          <div class="card">
            <div class="card-header" id="headingStaff" data-toggle="collapse" data-target="#collapseStaff" aria-expanded="false" aria-controls="collapseStaff">
              <h5 class="mb-0">Staff</h5>
            </div>
            <div id="collapseStaff" class="collapse" aria-labelledby="headingStaff" data-parent="#viewAccordion">
              <div class="card-body">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Name</th>
                      <th>Timing</th>
                      <th>Join Date</th>
                      <th>Batch Timing</th>
                      <th>Contact</th>
                      <th>Address</th>
                    </tr>
                  </thead>
                  <tbody id="view_staff"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="button" class="close-btn btn" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      let centerData = {};
      let batchData = [];
      let facilityData = [];
      let staffData = [];

      // Add Batch Entry
      $('.add-batch-btn').click(function() {
        let index = $('#batchEntries .batch-entry').length;
        let newEntry = `
          <div class="batch-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_timing_${index}">Batch Timing <span class="text-danger">*</span></label>
                <input type="time" id="batch_timing_${index}" name="batch_timing[]" class="form-control" required />
              </div>
              <div class="form-group col-md-6">
                <label for="start_date_${index}">Start Date <span class="text-danger">*</span></label>
                <input type="date" id="start_date_${index}" name="start_date[]" class="form-control" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_category_${index}">Category <span class="text-danger">*</span></label>
                <select id="batch_category_${index}" name="batch_category[]" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="Beginner">Beginner</option>
                  <option value="Intermediate">Intermediate</option>
                  <option value="Advanced">Advanced</option>
                </select>
              </div>
            </div>
            <button type="button" class="remove-batch-btn btn">Remove</button>
          </div>`;
        $('#batchEntries').append(newEntry);
      });

      // Remove Batch Entry
      $(document).on('click', '.remove-batch-btn', function() {
        if ($('#batchEntries .batch-entry').length > 1) {
          $(this).closest('.batch-entry').remove();
        }
      });

      // Add Facility Entry
      $('.add-facility-btn').click(function() {
        let index = $('#facilityEntries .facility-entry').length;
        let newEntry = `
          <div class="facility-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="facility_${index}">Facility <span class="text-danger">*</span></label>
                <select id="facility_${index}" name="facility[]" class="form-control" required>
                  <option value="">Select Facility</option>
                  <option value="Locker">Locker</option>
                  <option value="Shoe">Shoe</option>
                  <option value="Racket">Racket</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="locker_no_${index}">Locker No</label>
                <input type="text" id="locker_no_${index}" name="locker_no[]" class="form-control" placeholder="Enter Locker No" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="facility_rent_${index}">Rent <span class="text-danger">*</span></label>
                <input type="number" id="facility_rent_${index}" name="facility_rent[]" class="form-control" required placeholder="Enter Rent Amount" />
              </div>
              <div class="form-group col-md-6">
                <label for="facility_rent_date_${index}">Rent Date <span class="text-danger">*</span></label>
                <input type="date" id="facility_rent_date_${index}" name="facility_rent_date[]" class="form-control" required />
              </div>
            </div>
            <button type="button" class="remove-facility-btn btn">Remove</button>
          </div>`;
        $('#facilityEntries').append(newEntry);
      });

      // Remove Facility Entry
      $(document).on('click', '.remove-facility-btn', function() {
        if ($('#facilityEntries .facility-entry').length > 1) {
          $(this).closest('.facility-entry').remove();
        }
      });

      // Add Staff Entry
      $('.add-staff-btn').click(function() {
        let index = $('#staffEntries .staff-entry').length;
        let newEntry = `
          <div class="staff-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="staff_category_${index}">Category <span class="text-danger">*</span></label>
                <select id="staff_category_${index}" name="staff_category[]" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="coach">Coach</option>
                  <option value="co-ordinator">Co-ordinator</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="staff_name_${index}">Staff Name <span class="text-danger">*</span></label>
                <input type="text" id="staff_name_${index}" name="staff_name[]" class="form-control" required placeholder="Enter Staff Name" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="staff_timing_${index}">Timing <span class="text-danger">*</span></label>
                <input type="time" id="staff_timing_${index}" name="staff_timing[]" class="form-control" required />
              </div>
              <div class="form-group col-md-6">
                <label for="join_date_${index}">Join Date <span class="text-danger">*</span></label>
                <input type="date" id="join_date_${index}" name="join_date[]" class="form-control" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_selection_${index}">Batch Selection <span class="text-danger">*</span></label>
                <select id="batch_selection_${index}" name="batch_selection[]" class="form-control" required>
                  <option value="">Select Batch Timing</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="contact_${index}">Contact <span class="text-danger">*</span></label>
                <input type="text" id="contact_${index}" name="contact[]" class="form-control" required placeholder="Enter Contact" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="address_${index}">Address <span class="text-danger">*</span></label>
                <input type="text" id="address_${index}" name="address[]" class="form-control" required placeholder="Enter Address" />
              </div>
            </div>
            <button type="button" class="remove-staff-btn btn">Remove</button>
          </div>`;
        $('#staffEntries').append(newEntry);
        updateBatchSelections();
      });

      // Remove Staff Entry
      $(document).on('click', '.remove-staff-btn', function() {
        if ($('#staffEntries .staff-entry').length > 1) {
          $(this).closest('.staff-entry').remove();
        }
      });

      // Update Batch Selection Dropdowns
      function updateBatchSelections() {
        let batchTimings = batchData.map(batch => batch.timing);
        $('.staff-entry select[name="batch_selection[]"]').each(function() {
          let currentVal = $(this).val();
          $(this).empty().append('<option value="">Select Batch Timing</option>');
          batchTimings.forEach(timing => {
            $(this).append(`<option value="${timing}">${timing}</option>`);
          });
          if (currentVal && batchTimings.includes(currentVal)) {
            $(this).val(currentVal);
          }
        });
      }

      // Step 1: Center Details
      $('#centerNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#centerForm')[0].checkValidity()) {
          centerData = {
            name: $('#center_name').val(),
            timing: $('#center_timing').val(),
            rent: $('#center_rent').val(),
            rent_date: $('#center_rent_date').val()
          };
          $('#newCenterModal').modal('hide');
          $('#batchModal').modal('show');
        } else {
          $('#centerForm')[0].reportValidity();
        }
      });

      // Step 2: Batch Management
      $('#batchNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#batchForm')[0].checkValidity()) {
          batchData = [];
          $('#batchEntries .batch-entry').each(function() {
            batchData.push({
              timing: $(this).find('input[name="batch_timing[]"]').val(),
              start_date: $(this).find('input[name="start_date[]"]').val(),
              category: $(this).find('select[name="batch_category[]"]').val()
            });
          });
          $('#batchModal').modal('hide');
          $('#facilityModal').modal('show');
        } else {
          $('#batchForm')[0].reportValidity();
        }
      });

      // Step 3: Facility Management
      $('#facilityNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#facilityForm')[0].checkValidity()) {
          facilityData = [];
          $('#facilityEntries .facility-entry').each(function() {
            facilityData.push({
              type: $(this).find('select[name="facility[]"]').val(),
              locker_no: $(this).find('input[name="locker_no[]"]').val(),
              rent: $(this).find('input[name="facility_rent[]"]').val(),
              rent_date: $(this).find('input[name="facility_rent_date[]"]').val()
            });
          });
          $('#facilityModal').modal('hide');
          $('#staffModal').modal('show');
          updateBatchSelections();
        } else {
          $('#facilityForm')[0].reportValidity();
        }
      });

      // Step 4: Staff Management - Submit All Data
      $('#staffForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#staffForm')[0].checkValidity()) {
          staffData = [];
          $('#staffEntries .staff-entry').each(function() {
            staffData.push({
              category: $(this).find('select[name="staff_category[]"]').val(),
              name: $(this).find('input[name="staff_name[]"]').val(),
              timing: $(this).find('input[name="staff_timing[]"]').val(),
              join_date: $(this).find('input[name="join_date[]"]').val(),
              batch_timing: $(this).find('select[name="batch_selection[]"]').val(),
              contact: $(this).find('input[name="contact[]"]').val(),
              address: $(this).find('input[name="address[]"]').val()
            });
          });

          let formData = {
            center: centerData,
            batches: batchData,
            facilities: facilityData,
            staff: staffData
          };

          $.ajax({
            url: 'http://localhost/timersacademy/index.php/center/save', // Hardcoded for testing
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Center added successfully!',
                confirmButtonText: 'OK'
              }).then(() => {
                $('#staffModal').modal('hide');
                $('#centerForm, #batchForm, #facilityForm, #staffForm').trigger('reset');
                centerData = {};
                batchData = [];
                facilityData = [];
                staffData = [];
                loadCenters();
              });
            },
            error: function(xhr, status, error) {
              console.log('Error Details:', xhr.responseText);
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add center: ' + (xhr.responseJSON?.message || error),
                confirmButtonText: 'OK'
              });
            }
          });
        } else {
          $('#staffForm')[0].reportValidity();
        }
      });

      // Load centers on page load
      function loadCenters() {
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/get_all', // Hardcoded for testing
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#centerCards').empty();
            response.forEach(center => {
              let card = `
                <div class="col-md-4">
                  <div class="center-card">
                    <div class="card-icon"><i class="fas fa-building"></i></div>
                    <div class="card-details">
                      <p>${center.name}</p>
                      <p><span>Timing:</span> ${center.timing}</p>
                      <p><span>Rent:</span> ${center.rent}</p>
                      <p><span>Rent Date:</span> ${center.rent_date}</p>
                      <button class="view-btn" data-center-id="${center.id}">View Details</button>
                    </div>
                  </div>
                </div>`;
              $('#centerCards').append(card);
            });
          },
          error: function(xhr, status, error) {
            console.log('Load Centers Error:', xhr.responseText);
          }
        });
      }

      // View Center Details
      $(document).on('click', '.view-btn', function() {
        let centerId = $(this).data('center-id');
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/get/' + centerId, // Hardcoded for testing
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#view_center_name').text(response.center.name);
            $('#view_timing').text(response.center.timing);
            $('#view_center_rent').text(response.center.rent);
            $('#view_rent_date').text(response.center.rent_date);

            $('#view_batches').empty();
            response.batches.forEach(batch => {
              $('#view_batches').append(`
                <tr>
                  <td>${batch.timing}</td>
                  <td>${batch.start_date}</td>
                  <td>${batch.category}</td>
                </tr>`);
            });

            $('#view_facilities').empty();
            response.facilities.forEach(facility => {
              $('#view_facilities').append(`
                <tr>
                  <td>${facility.type}</td>
                  <td>${facility.locker_no || 'N/A'}</td>
                  <td>${facility.rent}</td>
                  <td>${facility.rent_date}</td>
                </tr>`);
            });

            $('#view_staff').empty();
            response.staff.forEach(staff => {
              $('#view_staff').append(`
                <tr>
                  <td>${staff.category}</td>
                  <td>${staff.name}</td>
                  <td>${staff.timing}</td>
                  <td>${staff.join_date}</td>
                  <td>${staff.batch_timing}</td>
                  <td>${staff.contact}</td>
                  <td>${staff.address}</td>
                </tr>`);
            });

            $('#viewCenterModal').modal('show');
          },
          error: function(xhr, status, error) {
            console.log('View Center Error:', xhr.responseText);
          }
        });
      });

      // Filter Centers
      $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        let filterName = $('#filterCenterName').val();
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/filter', // Hardcoded for testing
          type: 'POST',
          data: { filterCenterName: filterName },
          dataType: 'json',
          success: function(response) {
            $('#centerCards').empty();
            response.forEach(center => {
              let card = `
                <div class="col-md-4">
                  <div class="center-card">
                    <div class="card-icon"><i class="fas fa-building"></i></div>
                    <div class="card-details">
                      <p>${center.name}</p>
                      <p><span>Timing:</span> ${center.timing}</p>
                      <p><span>Rent:</span> ${center.rent}</p>
                      <p><span>Rent Date:</span> ${center.rent_date}</p>
                      <button class="view-btn" data-center-id="${center.id}">View Details</button>
                    </div>
                  </div>
                </div>`;
              $('#centerCards').append(card);
            });
            $('#filterModal').modal('hide');
          },
          error: function(xhr, status, error) {
            console.log('Filter Centers Error:', xhr.responseText);
          }
        });
      });

      // Initial load of centers
      loadCenters();

      // Sidebar toggle functionality
      function setupSidebarToggle() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');
        const contentWrapper = document.getElementById('contentWrapper');

        if (sidebarToggle && sidebar && navbar && contentWrapper) {
          sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
              // Mobile view: toggle sidebar visibility
              sidebar.classList.toggle('active');
              navbar.classList.toggle('sidebar-hidden', sidebar.classList.contains('active'));
            } else {
              // Desktop view: toggle minimized state
              const isMinimized = sidebar.classList.toggle('minimized');
              navbar.classList.toggle('sidebar-minimized', isMinimized);
              contentWrapper.classList.toggle('minimized', isMinimized);
            }
          });

          // Handle window resize to reset states for responsiveness
          window.addEventListener('resize', () => {
            if (window.innerWidth <= 768) {
              // Mobile view: ensure sidebar is hidden by default, remove minimized
              sidebar.classList.remove('minimized');
              contentWrapper.classList.remove('minimized');
              navbar.classList.remove('sidebar-minimized');
              if (!sidebar.classList.contains('active')) {
                navbar.classList.add('sidebar-hidden');
              }
            } else {
              // Desktop view: remove active (mobile) state, restore minimized if applicable
              sidebar.classList.remove('active');
              navbar.classList.remove('sidebar-hidden');
              if (sidebar.classList.contains('minimized')) {
                contentWrapper.classList.add('minimized');
                navbar.classList.add('sidebar-minimized');
              } else {
                contentWrapper.classList.remove('minimized');
                navbar.classList.remove('sidebar-minimized');
              }
            }
          });

          // Mutation observer to sync content wrapper and navbar with sidebar state
          const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
              if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const isMinimized = sidebar.classList.contains('minimized');
                const isActive = sidebar.classList.contains('active');
                if (window.innerWidth <= 768) {
                  contentWrapper.classList.remove('minimized');
                  navbar.classList.toggle('sidebar-hidden', isActive);
                } else {
                  contentWrapper.classList.toggle('minimized', isMinimized);
                  navbar.classList.toggle('sidebar-minimized', isMinimized);
                }
              }
            });
          });

          observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });

          // Remove focus from toggle button to prevent navbar highlight
          $('#sidebarToggle').on('click', function() {
            $(this).blur();
          });
        }
      }

      // Initialize toggle functionality
      setupSidebarToggle();
    });
  </script>
</body>
</html>