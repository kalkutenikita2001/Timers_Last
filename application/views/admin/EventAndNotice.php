<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event & Notice Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
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
    .filter-btn, .participate-btn {
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
    .filter-btn:hover, .participate-btn:hover {
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
      color: #333;
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
    .form-control, .form-control textarea, .form-control select {
      height: 38px;
      border-radius: 8px;
      font-size: 13px;
      border: 1px solid #ced4da;
      font-style: normal;
      transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-control textarea:focus, .form-control select:focus {
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
      color: white;
      background: #007bff;
    }
    .update-btn:hover {
      background: #0056b3;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .delete-btn {
      color: white;
      background: #dc3545;
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
      .add-center-btn, .filter-btn, .participate-btn {
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
      .form-control, .form-control textarea, .form-control select {
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
      .add-center-btn, .filter-btn, .participate-btn {
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
      .add-center-btn, .filter-btn, .participate-btn {
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
      .add-center-btn, .filter-btn, .participate-btn {
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
      .participate-btn:hover,
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
  <!-- Sidebar -->
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('admin/Include/Navbar') ?>

  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <!-- Filter and Participate Buttons -->
        <div class="header-container">
          <button class="participate-btn btn" data-toggle="modal" data-target="#participateModal" aria-label="Open participate modal">Participate</button>
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">
             <i class="bi bi-funnel me-2"></i>Filter</button>
        </div>
        <div class="row justify-content-start" id="eventRow">
          <!-- Event cards will be loaded dynamically via AJAX -->
        </div>

        <!-- Add Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addEventModal">
             <i class="fas fa-plus mr-1"></i>Add Event/Notice</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addEventLabel">Add Event/Notice</h3>
        <form id="eventForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">Title <span class="text-danger">*</span></label>
              <input type="text" id="title" name="title" class="form-control" placeholder="Enter event title" required />
              <div class="invalid-feedback">Please enter a title.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="center_name">Center Name <span class="text-danger">*</span></label>
              <select id="center_name" name="center_name" class="form-control" required>
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="date">Date <span class="text-danger">*</span></label>
              <input type="date" id="date" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="time">Time <span class="text-danger">*</span></label>
              <input type="time" id="time" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select a time.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="description">Description <span class="text-danger">*</span></label>
              <textarea id="description" name="description" class="form-control" placeholder="Enter description" required></textarea>
              <div class="invalid-feedback">Please enter a description.</div>
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

  <!-- View Event Modal -->
  <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewEventLabel">Event/Notice Details</h3>
        <form id="viewEventForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="viewTitle">Title <span class="text-danger">*</span></label>
              <input type="text" id="viewTitle" name="title" class="form-control" placeholder="Enter event title" required />
              <div class="invalid-feedback">Please enter a title.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCenterName">Center Name <span class="text-danger">*</span></label>
              <select id="viewCenterName" name="center_name" class="form-control" required>
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewDate">Date <span class="text-danger">*</span></label>
              <input type="date" id="viewDate" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewTime">Time <span class="text-danger">*</span></label>
              <input type="time" id="viewTime" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select a time.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="viewDescription">Description <span class="text-danger">*</span></label>
              <textarea id="viewDescription" name="description" class="form-control" placeholder="Enter description" required></textarea>
              <div class="invalid-feedback">Please enter a description.</div>
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

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Events/Notices</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterTitle">Title</label>
              <input type="text" id="filterTitle" name="filterTitle" class="form-control" placeholder="Enter event title" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterCenterName">Center Name</label>
              <select id="filterCenterName" name="filterCenterName" class="form-control">
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
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
              <label for="filterDescription">Description</label>
              <input type="text" id="filterDescription" name="filterDescription" class="form-control" placeholder="Enter description" />
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

  <!-- Participate Modal -->
  <div class="modal fade" id="participateModal" tabindex="-1" aria-labelledby="participateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="participateLabel">Participate in Event</h3>
        <form id="participateForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="studentName">Student Name <span class="text-danger">*</span></label>
              <select id="studentName" name="studentName" class="form-control" required>
                <option value="">-- Select Student --</option>
                <!-- Students will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a student.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="eventTitle">Event Title <span class="text-danger">*</span></label>
              <select id="eventTitle" name="eventTitle" class="form-control" required>
                <option value="">-- Select Event --</option>
                <!-- Events will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select an event.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="paymentMode">Payment Mode <span class="text-danger">*</span></label>
              <div>
                <div class="form-check">
                  <input type="radio" id="cash" name="paymentMode" class="form-check-input" value="Cash" required>
                  <label class="form-check-label" for="cash">Cash</label>
                </div>
                <div class="form-check">
                  <input type="radio" id="online" name="paymentMode" class="form-check-input" value="Online">
                  <label class="form-check-label" for="online">Online</label>
                </div>
              </div>
              <div class="invalid-feedback">Please select a payment mode.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="submit-btn btn">Confirm Participation</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Submission, View Modal, Update, Delete, Filter, and Participation Handling -->
  <script>
    (function () {
      'use strict';
      let cardCounter = 1;
      const baseUrl = '<?php echo base_url(); ?>';
      const eventUrl = baseUrl + 'event_notice/';
      const centerUrl = baseUrl + 'center/get_centers';
      const studentUrl = baseUrl + 'Student_controller/index';
      const participationUrl = baseUrl + 'event_notice/add_participation';
      const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
      const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

      // Function to format date for display
      function formatDateForDisplay(dateStr) {
        if (!dateStr) return '';
        const [year, month, day] = dateStr.split('-');
        return `${day}/${month}/${year}`;
      }

      // Function to format time for display
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
          dataType: 'json',
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

      // Function to load students dynamically
      function loadStudents(selectElement) {
        $.ajax({
          url: studentUrl,
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            selectElement.empty();
            selectElement.append('<option value="">-- Select Student --</option>');
            if (response.status === 'success' && response.students && response.students.length > 0) {
              response.students.forEach(student => {
                selectElement.append(`<option value="${student.name}">${student.name}</option>`);
              });
            } else {
              console.warn('No students found:', response.message);
              selectElement.append('<option value="" disabled>No students available</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error fetching students:', error, xhr.responseText);
            selectElement.append('<option value="" disabled>Error loading students</option>');
          }
        });
      }

      // Function to load events for participation dropdown
      function loadEventsForDropdown(selectElement) {
        $.ajax({
          url: eventUrl + 'get_events',
          type: 'POST',
          data: { [csrfName]: csrfHash },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const events = response.data;
              selectElement.empty();
              selectElement.append('<option value="">-- Select Event --</option>');
              if (events.length === 0) {
                selectElement.append('<option value="" disabled>No events available</option>');
              } else {
                events.forEach(event => {
                  selectElement.append(`<option value="${event.title}">${event.title}</option>`);
                });
              }
            } else {
              console.error('Error fetching events:', response.message);
              selectElement.append('<option value="" disabled>Error loading events</option>');
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
            selectElement.append('<option value="" disabled>Error loading events</option>');
          }
        });
      }

      // Function to load events
      function loadEvents(filters = {}) {
        $.ajax({
          url: eventUrl + 'get_events',
          type: 'POST',
          data: { ...filters, [csrfName]: csrfHash },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const eventRow = document.getElementById('eventRow');
              eventRow.innerHTML = '';
              if (response.data.length === 0) {
                eventRow.innerHTML = '<p class="text-center">No events/notices match the filter criteria.</p>';
                return;
              }
              response.data.forEach(event => {
                const formattedDate = formatDateForDisplay(event.date);
                const card = `
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="center-card" id="card-${cardCounter}">
                      <i class="fas fa-calendar-alt card-icon"></i>
                      <div class="card-details">
                        <p><span>Title:</span> ${event.title}</p>
                        <p><span>Center:</span> ${event.center_name}</p>
                        <p><span>Date:</span> ${formattedDate}</p>
                        <p><span>Time:</span> ${event.time}</p>
                        <p><span>Description:</span> ${event.description}</p>
                      </div>
                      <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" 
                              data-event-id="${event.id}" 
                              data-title="${event.title}" 
                              data-center-name="${event.center_name}" 
                              data-date="${event.date}" 
                              data-time="${event.time}" 
                              data-description="${event.description}">View</button>
                    </div>
                  </div>
                `;
                eventRow.insertAdjacentHTML('beforeend', card);
                cardCounter++;
              });
            } else {
              console.error('Error loading events:', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      }

      // Load events, centers, and students on page load
      $(document).ready(function() {
        loadEvents();
        $('#addEventModal').on('show.bs.modal', function () {
          loadCenters($('#center_name'));
        });
        $('#viewEventModal').on('show.bs.modal', function () {
          loadCenters($('#viewCenterName'));
        });
        $('#filterModal').on('show.bs.modal', function () {
          loadCenters($('#filterCenterName'));
        });
        $('#participateModal').on('show.bs.modal', function () {
          loadStudents($('#studentName'));
          loadEventsForDropdown($('#eventTitle'));
        });
      });

      // Form submission for adding events/notices
      $('#eventForm').on('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const title = $('#title').val().trim();
        const centerName = $('#center_name').val();
        const dateRaw = $('#date').val();
        const timeRaw = $('#time').val();
        const description = $('#description').val().trim();

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        $.ajax({
          url: eventUrl + 'add_event',
          type: 'POST',
          data: {
            title: title,
            center_name: centerName,
            date: dateRaw,
            time: time,
            description: description,
            [csrfName]: csrfHash
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              loadEvents();
              $('#eventForm').removeClass('was-validated').trigger('reset');
              $('#addEventModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while adding the event/notice.');
          }
        });
      });

      // Ensure validation feedback on input for add form
      $('#eventForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      // Filter form submission
      $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const filterTitle = $('#filterTitle').val().trim();
        const filterCenterName = $('#filterCenterName').val();
        const filterDate = $('#filterDate').val().trim();
        const filterTime = $('#filterTime').val().trim();
        const filterDescription = $('#filterDescription').val().trim();

        const filters = {};
        if (filterTitle) filters.title = filterTitle;
        if (filterCenterName) filters.center_name = filterCenterName;
        if (filterDate) filters.date = filterDate;
        if (filterTime) filters.time = filterTime;
        if (filterDescription) filters.description = filterDescription;

        loadEvents(filters);
        $('#filterModal').modal('hide');
      });

      // Handle view button clicks
      $('#viewEventModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const eventId = button.data('event-id');
        const title = button.data('title');
        const centerName = button.data('center-name');
        const date = button.data('date');
        const time = button.data('time');
        const description = button.data('description');

        const modal = $(this);
        modal.find('#viewEventLabel').text(`Event/Notice Details - ${title}`);
        modal.find('#viewTitle').val(title);
        modal.find('#viewCenterName').val(centerName);
        modal.find('#viewDate').val(date);
        modal.find('#viewTime').val(time.split(' to ')[0].trim());
        modal.find('#viewDescription').val(description);
        modal.find('.update-btn').data('event-id', eventId);
        modal.find('.delete-btn').data('event-id', eventId);
      });

      // Handle update form submission
      $('#viewEventForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const eventId = $(this).find('.update-btn').data('event-id');
        const title = $('#viewTitle').val().trim();
        const centerName = $('#viewCenterName').val();
        const dateRaw = $('#viewDate').val();
        const timeRaw = $('#viewTime').val();
        const description = $('#viewDescription').val().trim();

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        $.ajax({
          url: eventUrl + 'update_event',
          type: 'POST',
          data: {
            id: eventId,
            title: title,
            center_name: centerName,
            date: dateRaw,
            time: time,
            description: description,
            [csrfName]: csrfHash
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              loadEvents();
              $('#viewEventForm').removeClass('was-validated');
              $('#viewEventModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while updating the event/notice.');
          }
        });
      });

      // Ensure validation feedback on input for view form
      $('#viewEventForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      // Handle delete button click
      $('#viewEventForm .delete-btn').on('click', function () {
        const eventId = $(this).data('event-id');
        if (confirm('Are you sure you want to delete this event/notice?')) {
          $.ajax({
            url: eventUrl + 'delete_event',
            type: 'POST',
            data: {
              id: eventId,
              [csrfName]: csrfHash
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === 'success') {
                loadEvents();
                $('#viewEventModal').modal('hide');
              } else {
                alert(response.message);
              }
            },
            error: function(xhr, status, error) {
              console.error('AJAX error:', error);
              alert('An error occurred while deleting the event/notice.');
            }
          });
        }
      });

      // Handle participation form submission
      $('#participateForm').on('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const studentName = $('#studentName').val();
        const eventTitle = $('#eventTitle').val();
        const paymentMode = $('input[name="paymentMode"]:checked').val();

        $.ajax({
          url: participationUrl,
          type: 'POST',
          data: {
            student_name: studentName,
            event_title: eventTitle,
            payment_mode: paymentMode,
            [csrfName]: csrfHash
          },
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              alert(`Participation confirmed for ${studentName} in the ${eventTitle} event with payment mode: ${paymentMode}`);
              $('#participateForm').removeClass('was-validated').trigger('reset');
              $('#participateModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while registering participation.');
          }
        });
      });

      // Ensure validation feedback on input for participate form
      $('#participateForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      // Sidebar toggle functionality
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

      // Modal blur effect
      $('#addEventModal, #filterModal, #viewEventModal, #participateModal').on('show.bs.modal', function () {
        $('#mainContent').addClass('blur');
      });

      $('#addEventModal, #filterModal, #viewEventModal, #participateModal').on('hidden.bs.modal', function () {
        $('#mainContent').removeClass('blur');
      });
    })();
  </script>
</body>
</html>