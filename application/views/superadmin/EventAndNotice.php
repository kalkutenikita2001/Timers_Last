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
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .delete-btn {
      color: white;
      background: #dc3545;
    }
    .delete-btn:hover {
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
      margin-top: 20px; /* Reduced from 60px to minimize gap */
    }
    .blur {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
    /* Responsive Design */
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
  <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <!-- Filter Button -->
        <div class="header-container">
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">
            <i class="bi bi-funnel me-2"></i> Filter
          </button>
        </div>
        <div class="row justify-content-start" id="eventRow">
          <!-- Event cards will be loaded dynamically via AJAX -->
        </div>

        <!-- Add Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addEventModal">Add Event/Notice</button>
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
                <option value="ABC">ABC</option>
                <option value="XYZ">XYZ</option>
                <option value="PQR">PQR</option>
                <option value="LMN">LMN</option>
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
                <option value="ABC">ABC</option>
                <option value="XYZ">XYZ</option>
                <option value="PQR">PQR</option>
                <option value="LMN">LMN</option>
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
              <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" placeholder="Enter center name" />
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

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Submission, View Modal, Update, Delete, and Filter Handling -->
  <script>
    (function () {
      'use strict';
      let cardCounter = 1;
      const form = document.getElementById('eventForm');
      const filterForm = document.getElementById('filterForm');
      const viewForm = document.getElementById('viewEventForm');
      if (!form) {
        console.error('Event form not found!');
        return;
      }
      if (!filterForm) {
        console.error('Filter form not found!');
        return;
      }
      if (!viewForm) {
        console.error('View form not found!');
        return;
      }

      // CSRF Token
      const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
      const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

      // Function to load events
      function loadEvents(filters = {}) {
        $.ajax({
          url: '<?php echo base_url('event_notice/get_events'); ?>',
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
                const date = new Date(event.date);
                const formattedDate = `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth() + 1).toString().padStart(2, '0')}/${date.getFullYear()}`;
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
                      <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-event-id="${event.id}" data-title="${event.title}" data-center-name="${event.center_name}" data-date="${formattedDate}" data-time="${event.time}" data-description="${event.description}">View</button>
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

      // Load events on page load
      document.addEventListener('DOMContentLoaded', function() {
        loadEvents();
      });

      // Form submission for adding events/notices
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }

        const title = document.getElementById('title').value.trim();
        const centerName = document.getElementById('center_name').value;
        const dateRaw = document.getElementById('date').value;
        const timeRaw = document.getElementById('time').value;
        const description = document.getElementById('description').value.trim();

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        $.ajax({
          url: '<?php echo base_url('event_notice/add_event'); ?>',
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
              form.reset();
              form.classList.remove('was-validated');
              $('#addEventModal').modal('hide');
            } else {
              console.error('Error adding event:', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      });

      // Ensure validation feedback on input for add form
      form.addEventListener('input', function () {
        if (form.checkValidity()) {
          form.classList.remove('was-validated');
        }
      });

      // Filter form submission
      filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const filterTitle = document.getElementById('filterTitle').value.trim();
        const filterCenterName = document.getElementById('filterCenterName').value.trim();
        const filterDate = document.getElementById('filterDate').value.trim();
        const filterTime = document.getElementById('filterTime').value.trim();
        const filterDescription = document.getElementById('filterDescription').value.trim();

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
        modal.find('#viewDate').val(new Date(date.split('/').reverse().join('-')).toISOString().split('T')[0]);
        modal.find('#viewTime').val(time.split(' to ')[0].trim());
        modal.find('#viewDescription').val(description);
        modal.find('.update-btn').data('event-id', eventId);
        modal.find('.delete-btn').data('event-id', eventId);
      });

      // Handle update form submission
      viewForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!viewForm.checkValidity()) {
          viewForm.classList.add('was-validated');
          return;
        }

        const eventId = $(viewForm).find('.update-btn').data('event-id');
        const title = document.getElementById('viewTitle').value.trim();
        const centerName = document.getElementById('viewCenterName').value;
        const dateRaw = document.getElementById('viewDate').value;
        const timeRaw = document.getElementById('viewTime').value;
        const description = document.getElementById('viewDescription').value.trim();

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        $.ajax({
          url: '<?php echo base_url('event_notice/update_event'); ?>',
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
              viewForm.classList.remove('was-validated');
              $('#viewEventModal').modal('hide');
            } else {
              console.error('Error updating event:', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      });

      // Ensure validation feedback on input for view form
      viewForm.addEventListener('input', function () {
        if (viewForm.checkValidity()) {
          viewForm.classList.remove('was-validated');
        }
      });

      // Handle delete button click
      viewForm.querySelector('.delete-btn').addEventListener('click', function () {
        const eventId = $(this).data('event-id');
        $.ajax({
          url: '<?php echo base_url('event_notice/delete_event'); ?>',
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
              console.error('Error deleting event:', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      });

      // Sidebar toggle functionality
      document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');
        const contentWrapper = document.getElementById('contentWrapper');

        if (sidebarToggle) {
          sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth <= 576) {
              // Mobile behavior
              if (sidebar) {
                sidebar.classList.toggle('active');
                navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
              }
            } else {
              // Desktop behavior - minimize/maximize
              if (sidebar && contentWrapper) {
                const isMinimized = sidebar.classList.toggle('minimized');
                navbar.classList.toggle('sidebar-minimized', isMinimized);
                contentWrapper.classList.toggle('minimized', isMinimized);
              }
            }
          });
        }
      });

      // Modal blur effect
      $('#addEventModal, #filterModal, #viewEventModal').on('show.bs.modal', function () {
        document.getElementById('mainContent').classList.add('blur');
      });

      $('#addEventModal, #filterModal, #viewEventModal').on('hidden.bs.modal', function () {
        document.getElementById('mainContent').classList.remove('blur');
      });
    })();
  </script>
</body>
</html>