<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Staff Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f8 !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
      font-style: normal;
      overflow-x: hidden;
    }
    .content-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s ease-in-out;
      position: relative;
      min-height: 100vh;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .header-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
    }
    .filter-btn {
      background: #ffffff;
      color: #000000;
      border: 1px solid #ced4da;
      border-radius: 8px;
      padding: 8px 15px;
      font-size: 15px;
      font-style: normal;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .filter-btn:hover {
      background: #f0f0f0;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .center-card {
      background-color: #ffffff;
      border-radius: 1rem;
      padding: 1rem;
      width: 100%;
      max-width: 22rem;
      border-left: 2px solid #ff4040;
      position: relative;
      color: #333;
      font-size: 0.875rem;
      font-style: normal;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: auto;
      min-height: 10rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .card-icon {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      font-size: 1.125rem;
      color: #333;
    }
    .card-details {
      padding-top: 0.25rem;
    }
    .card-details p {
      margin: 0.3rem 0;
      line-height: 1.4;
      color: #333;
      font-style: normal;
    }
    .card-details p:first-child {
      font-size: 1rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .card-details p span {
      font-weight: 500;
      color: #444;
    }
    .view-btn {
      margin-top: 0.5rem;
      padding: 0.4rem 1rem;
      border: none;
      background-color: #eee;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      font-weight: bold;
      font-style: normal;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .view-btn:hover {
      background-color: #ddd;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .add-center-btn {
      color: black;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      width: 180px;
      font-size: 15px;
      font-style: normal;
      margin: 25px auto;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .add-center-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .button-container {
      display: flex;
      justify-content: center;
    }
    .modal-content {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 20px;
      max-width: 500px;
      margin: auto;
      border: 2px solid #007bff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 15px;
      color: #333;
      font-style: normal;
    }
    .modal-close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: Maintenant
      cursor: pointer;
      transition: color 0.3s ease, transform 0.2s ease;
    }
    .modal-close-btn:hover {
      color: #ff4040;
      transform: scale(1.2);
    }
    .modal-backdrop.show {
      backdrop-filter: blur(6px);
    }
    .form-group {
      margin-bottom: 0.75rem;
    }
    .form-group label {
      font-weight: 500;
      font-size: 14px;
      color: #444;
      margin-bottom: 4px;
      display: block;
      font-style: normal;
    }
    .form-control, .form-control select {
      height: 38px;
      border-covid: 8px;
      font-size: 13px;
      border: 1px solid #ced4da;
      font-style: normal;
      transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-control select:focus {
      border-color: #ff4040;
      box-shadow: 0 0 5px rgba(255, 64, 64, 0.3);
    }
    .form-control::placeholder {
      color: #999;
    }
    .form-group select.form-control {
      appearance: none;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%23333" d="M7 10l5 5 5-5z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 12px;
    }
    .submit-btn, .close-btn, .update-btn, .delete-btn {
      border-radius: 8px;
      padding: 8px;
      font-weight: 600;
      width: 120px;
      margin: 6px 5px;
      border: none;
      color: #000000;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
      font-style: normal;
    }
    .submit-btn {
      background: #ffffff;
    }
    .submit-btn:hover {
      background: #f0f0f0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .close-btn {
      background: #e0e0e0;
      color: #333;
    }
    .close-btn:hover {
      background: #d0d0d0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .update-btn {
      background: #007bff;
      color: white;
    }
    .update-btn:hover {
      background: #0056b3;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .delete-btn {
      background: #dc3545;
      color: white;
    }
    .delete-btn:hover {
      background: #c82333;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .invalid-feedback {
      color: #dc3545;
      font-size: 12px;
      margin-top: 4px;
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
    }
    .navbar {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      color: white;
      padding: 10px;
      transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
    }
    .content {
      margin-top: 20px;
    }
    .blur {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0;
        padding: 10px;
      }
      .center-card {
        padding: 0.75rem;
        max-width: 100%;
        margin: 0.3125rem;
        font-size: 0.8125rem;
      }
      .card-details p:first-child {
        font-size: 0.9375rem;
      }
      .view-btn {
        font-size: 0.8125rem;
        padding: 0.3rem 0.75rem;
      }
      .add-center-btn, .filter-btn {
        width: 120px;
        font-size: 12px;
        padding: 6px 10px;
      }
      .modal-content {
        max-width: 90%;
        padding: 12px;
      }
      .form-row {
        flex-direction: column;
        gap: 8px;
      }
      .form-control, .form-control select {
        height: 34px;
        font-size: 12px;
      }
      .form-group label {
        font-size: 13px;
      }
      .submit-btn, .close-btn, .update-btn, .delete-btn {
        width: 100px;
        padding: 6px;
        font-size: 12px;
      }
      .modal-content h3 {
        font-size: 1rem;
      }
    }
    @media (min-width: 577px) and (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 15px;
      }
      .content-wrapper.minimized {
        margin-left: 0;
      }
      .center-card {
        max-width: 18rem;
        margin: 0.5rem;
        font-size: 0.875rem;
      }
      .add-center-btn, .filter-btn {
        width: 140px;
        font-size: 13px;
      }
      .modal-content {
        max-width: 90%;
        padding: 15px;
      }
      .form-row {
        gap: 10px;
      }
      .submit-btn, .close-btn, .update-btn, .delete-btn {
        width: 100px;
        font-size: 12px;
      }
      .navbar {
        left: 0;
        width: 100%;
      }
      .navbar.sidebar-minimized {
        left: 0;
        width: 100%;
      }
      #filterModal .form-row {
        flex-direction: column;
        gap: 8px;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
        padding: 15px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
      }
      .center-card {
        max-width: 18rem;
        margin: 0.5rem;
        font-size: 0.875rem;
      }
      .add-center-btn, .filter-btn {
        width: 150px;
        font-size: 14px;
      }
      .modal-content {
        max-width: 450px;
        padding: 15px;
      }
      .navbar {
        left: 200px;
        width: calc(100% - 200px);
      }
      .navbar.sidebar-minimized {
        left: 60px;
        width: calc(100% - 60px);
      }
    }
    @media (min-width: 992px) {
      .center-card {
        max-width: 22rem;
      }
      .add-center-btn, .filter-btn {
        width: 180px;
        font-size: 15px;
      }
      .modal-content {
        max-width: 500px;
      }
    }
    @media (hover: none) {
      .view-btn:hover,
      .add-center-btn:hover,
      .filter-btn:hover,
      .submit-btn:hover,
      .update-btn:hover,
      .delete-btn:hover,
      .close-btn:hover,
      .modal-close-btn:hover {
        background-color: inherit;
        transform: none;
        box-shadow: none;
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
        <div class="header-container">
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">
            <i class="bi bi-funnel me-2"></i> Filter
          </button>
        </div>
        <div class="row justify-content-start" id="staffRow"></div>
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addStaffModal">Add Staff</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addStaffLabel">Add Staff</h3>
        <form id="staffForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Name <span class="text-danger">*</span></label>
              <input type="text" id="name" name="name" class="form-control" placeholder="Enter name" required />
              <div class="invalid-feedback">Please enter a name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="contact">Contact <span class="text-danger">*</span></label>
              <input type="tel" id="contact" name="contact" class="form-control" placeholder="Enter contact number" required pattern="[0-9]{10}" />
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="address">Address <span class="text-danger">*</span></label>
              <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" required />
              <div class="invalid-feedback">Please enter an address.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="centerName">Center Name <span class="text-danger">*</span></label>
              <select id="centerName" name="centerName" class="form-control" required>
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a center.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="batch">Batch <span class="text-danger">*</span></label>
              <select id="batch" name="batch" class="form-control" required>
                <option value="">-- Select Batch --</option>
                <!-- Batches will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a batch.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="date">Date <span class="text-danger">*</span></label>
              <input type="date" id="date" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="time">Time <span class="text-danger">*</span></label>
              <input type="time" id="time" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select time.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="category">Category <span class="text-danger">*</span></label>
              <select id="category" name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="submit-btn btn">Submit</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="viewStaffModal" tabindex="-1" aria-labelledby="viewStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewStaffLabel">Staff Details</h3>
        <form id="viewStaffForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="viewName">Name <span class="text-danger">*</span></label>
              <input type="text" id="viewName" name="name" class="form-control" placeholder="Enter name" required />
              <div class="invalid-feedback">Please enter a name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewContact">Contact <span class="text-danger">*</span></label>
              <input type="tel" id="viewContact" name="contact" class="form-control" placeholder="Enter contact number" required pattern="[0-9]{10}" />
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewAddress">Address <span class="text-danger">*</span></label>
              <input type="text" id="viewAddress" name="address" class="form-control" placeholder="Enter address" required />
              <div class="invalid-feedback">Please enter an address.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCenterName">Center Name <span class="text-danger">*</span></label>
              <select id="viewCenterName" name="centerName" class="form-control" required>
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a center.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewBatch">Batch <span class="text-danger">*</span></label>
              <select id="viewBatch" name="batch" class="form-control" required>
                <option value="">-- Select Batch --</option>
                <!-- Batches will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a batch.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewDate">Date <span class="text-danger">*</span></label>
              <input type="date" id="viewDate" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewTime">Time <span class="text-danger">*</span></label>
              <input type="time" id="viewTime" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select time.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCategory">Category <span class="text-danger">*</span></label>
              <select id="viewCategory" name="category" class="form-control" required>
                <option value="">-- Select Category --</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="update-btn btn">Update</button>
            <button type="button" class="delete-btn btn">Delete</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Staff</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterName">Name</label>
              <input type="text" id="filterName" name="filterName" class="form-control" placeholder="Enter name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterContact">Contact</label>
              <input type="text" id="filterContact" name="filterContact" class="form-control" placeholder="Enter contact number" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterAddress">Address</label>
              <input type="text" id="filterAddress" name="filterAddress" class="form-control" placeholder="Enter address" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterCenterName">Center Name</label>
              <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" placeholder="Enter center name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterBatch">Batch</label>
              <input type="text" id="filterBatch" name="filterBatch" class="form-control" placeholder="Enter batch" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterDate">Date</label>
              <input type="text" id="filterDate" name="filterDate" class="form-control" placeholder="DD/MM/YYYY" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterTime">Time</label>
              <input type="text" id="filterTime" name="filterTime" class="form-control" placeholder="H to H AM/PM" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterCategory">Category</label>
              <input type="text" id="filterCategory" name="filterCategory" class="form-control" placeholder="Enter category" />
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

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function () {
      'use strict';

      const baseUrl = '<?php echo base_url(); ?>';
      const staffUrl = baseUrl + 'staff/';
      const centerUrl = baseUrl + 'center/get_centers';
      const batchUrl = baseUrl + 'batch/get_batches';

      function formatDateForDisplay(dateStr) {
        if (!dateStr) return '';
        const [year, month, day] = dateStr.split('-');
        return `${day}/${month}/${year}`;
      }

      function formatTimeForDisplay(timeStr) {
        if (!timeStr) return '';
        const [hours, minutes] = timeStr.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        return `${displayHour} to ${nextHour} ${period}`;
      }

      // Function to load centers dynamically
      function loadCenters(selectElement) {
        $.ajax({
          url: centerUrl,
          method: 'GET',
          success: function (response) {
            if (response.status === 'success') {
              const centers = response.data;
              selectElement.empty();
              selectElement.append('<option value="">-- Select Center --</option>');
              if (centers.length === 0) {
                selectElement.append('<option value="" disabled>No centers available</option>');
              } else {
                centers.forEach(center => {
                  selectElement.append(`<option value="${center.center_name}">${center.center_name}</option>`);
                });
              }
            } else {
              console.error('Error fetching centers:', response.message);
              selectElement.append('<option value="" disabled>Error loading centers</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            selectElement.append('<option value="" disabled>Error loading centers</option>');
          }
        });
      }

      // Function to load batches dynamically
      function loadBatches(selectElement) {
        $.ajax({
          url: batchUrl,
          method: 'POST',
          data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          dataType: 'json',
          success: function (response) {
            if (response.status === 'success') {
              const batches = response.data;
              selectElement.empty();
              selectElement.append('<option value="">-- Select Batch --</option>');
              if (batches.length === 0) {
                selectElement.append('<option value="" disabled>No batches available</option>');
              } else {
                batches.forEach(batch => {
                  selectElement.append(`<option value="${batch.batch}">${batch.batch}</option>`);
                });
              }
            } else {
              console.error('Error fetching batches:', response.message);
              selectElement.append('<option value="" disabled>Error loading batches</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            selectElement.append('<option value="" disabled>Error loading batches</option>');
          }
        });
      }

      function loadStaff(filters = {}) {
        $.ajax({
          url: staffUrl + 'get_staff',
          method: 'GET',
          data: filters,
          success: function (response) {
            if (response.status === 'success') {
              const staff = response.data;
              const row = $('#staffRow');
              row.empty();
              if (staff.length === 0) {
                row.html('<p class="text-center">No staff match the filter criteria.</p>');
                return;
              }
              staff.forEach(member => {
                const card = `
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="center-card" id="card-${member.id}">
                      <i class="fas fa-user card-icon"></i>
                      <div class="card-details">
                        <p><span>Name:</span> ${member.name}</p>
                        <p><span>Contact:</span> ${member.contact}</p>
                        <p><span>Address:</span> ${member.address}</p>
                        <p><span>Center Name:</span> ${member.center_name}</p>
                        <p><span>Batch:</span> ${member.batch}</p>
                        <p><span>Date:</span> ${formatDateForDisplay(member.date)}</p>
                        <p><span>Time:</span> ${member.time}</p>
                        <p><span>Category:</span> ${member.category}</p>
                      </div>
                      <button class="view-btn" data-toggle="modal" data-target="#viewStaffModal" 
                              data-staff-id="${member.id}" 
                              data-name="${member.name}" 
                              data-contact="${member.contact}" 
                              data-address="${member.address}" 
                              data-center-name="${member.center_name}" 
                              data-batch="${member.batch}" 
                              data-date="${member.date}" 
                              data-time="${member.time}" 
                              data-category="${member.category}">View</button>
                    </div>
                  </div>
                `;
                row.append(card);
              });
            } else {
              console.error('Error fetching staff:', response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      }

      $(document).ready(function () {
        loadStaff();
        // Load centers and batches when modals are opened
        $('#addStaffModal').on('show.bs.modal', function () {
          loadCenters($('#centerName'));
          loadBatches($('#batch'));
        });
        $('#viewStaffModal').on('show.bs.modal', function () {
          loadCenters($('#viewCenterName'));
          loadBatches($('#viewBatch'));
        });
      });

      $('#staffForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const timeRaw = $('#time').val();
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const formattedTime = `${displayHour} to ${nextHour} ${period}`;

        const formData = {
          name: $('#name').val().trim(),
          contact: $('#contact').val().trim(),
          address: $('#address').val().trim(),
          centerName: $('#centerName').val(),
          batch: $('#batch').val(),
          date: $('#date').val(),
          time: formattedTime,
          category: $('#category').val(),
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
          url: staffUrl + 'add_staff',
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response.status === 'success') {
              loadStaff();
              $('#staffForm').removeClass('was-validated').trigger('reset');
              $('#addStaffModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while adding the staff.');
          }
        });
      });

      $('#staffForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const filters = {
          name: $('#filterName').val().trim(),
          contact: $('#filterContact').val().trim(),
          address: $('#filterAddress').val().trim(),
          center_name: $('#filterCenterName').val().trim(),
          batch: $('#filterBatch').val().trim(),
          date: $('#filterDate').val().trim(),
          time: $('#filterTime').val().trim(),
          category: $('#filterCategory').val().trim()
        };

        loadStaff(filters);
        $('#filterModal').modal('hide');
      });

      $('#viewStaffModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const staffId = button.data('staff-id');
        const name = button.data('name');
        const contact = button.data('contact');
        const address = button.data('address');
        const centerName = button.data('center-name');
        const batch = button.data('batch');
        const date = button.data('date');
        const time = button.data('time');
        const category = button.data('category');

        const modal = $(this);
        modal.find('#viewStaffLabel').text(`Staff Details - ${name}`);
        modal.find('#viewName').val(name);
        modal.find('#viewContact').val(contact);
        modal.find('#viewAddress').val(address);
        modal.find('#viewCenterName').val(centerName);
        modal.find('#viewBatch').val(batch);
        modal.find('#viewDate').val(date);
        modal.find('#viewTime').val(time.split(' to ')[0].trim());
        modal.find('#viewCategory').val(category);
        modal.find('.update-btn').data('staff-id', staffId);
        modal.find('.delete-btn').data('staff-id', staffId);
      });

      $('#viewStaffForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const staffId = $(this).find('.update-btn').data('staff-id');
        const timeRaw = $('#viewTime').val();
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const formattedTime = `${displayHour} to ${nextHour} ${period}`;

        const formData = {
          name: $('#viewName').val().trim(),
          contact: $('#viewContact').val().trim(),
          address: $('#viewAddress').val().trim(),
          centerName: $('#viewCenterName').val(),
          batch: $('#viewBatch').val(),
          date: $('#viewDate').val(),
          time: formattedTime,
          category: $('#viewCategory').val(),
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        };

        $.ajax({
          url: staffUrl + 'update_staff/' + staffId,
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response.status === 'success') {
              loadStaff();
              $('#viewStaffForm').removeClass('was-validated');
              $('#viewStaffModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while updating the staff.');
          }
        });
      });

      $('#viewStaffForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      $('#viewStaffForm .delete-btn').on('click', function () {
        const staffId = $(this).data('staff-id');
        if (confirm('Are you sure you want to delete this staff member?')) {
          $.ajax({
            url: staffUrl + 'delete_staff/' + staffId,
            method: 'POST',
            data: {
              '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function (response) {
              if (response.status === 'success') {
                loadStaff();
                $('#viewStaffModal').modal('hide');
              } else {
                alert(response.message);
              }
            },
            error: function (xhr, status, error) {
              console.error('AJAX error:', error);
              alert('An error occurred while deleting the staff.');
            }
          });
        }
      });

      $(document).ready(function () {
        const sidebarToggle = $('#sidebarToggle');
        const sidebar = $('#sidebar');
        const navbar = $('.navbar');
        const contentWrapper = $('#contentWrapper');

        if (sidebarToggle.length) {
          sidebarToggle.on('click', function () {
            if (window.innerWidth <= 576) {
              sidebar.toggleClass('active');
              navbar.toggleClass('sidebar-hidden', !sidebar.hasClass('active'));
            } else {
              const isMinimized = sidebar.toggleClass('minimized').hasClass('minimized');
              navbar.toggleClass('sidebar-minimized', isMinimized);
              contentWrapper.toggleClass('minimized', isMinimized);
            }
          });
        }
      });

      $('#addStaffModal, #filterModal, #viewStaffModal').on('show.bs.modal', function () {
        $('#mainContent').addClass('blur');
      });

      $('#addStaffModal, #filterModal, #viewStaffModal').on('hidden.bs.modal', function () {
        $('#mainContent').removeClass('blur');
      });
    })();
  </script>
</body>
</html>