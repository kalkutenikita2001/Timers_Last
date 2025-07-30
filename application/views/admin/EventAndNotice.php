<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event & Notice Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #e9ecef !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
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

    .participate-btn {
      background: linear-gradient(90deg, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      font-size: 15px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .participate-btn:hover {
      background: linear-gradient(90deg, #ff3030, #360000);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .center-card {
      background-color: #ffffff;
      border-radius: 1.25rem;
      padding: 1.25rem;
      width: 100%;
      max-width: 18.75rem;
      border-left: 2px solid #ff4040; /* Added red border on left side */
      position: relative;
      margin: 0.625rem;
      color: #333;
      font-size: 0.9375rem;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: auto;
    }

    .card-icon {
      position: absolute;
      top: 0.9375rem;
      right: 0.9375rem;
      font-size: 1.25rem;
      color: #333;
    }

    .card-details {
      padding-top: 0.3125rem;
    }

    .card-details p {
      margin: 0.5rem 0;
      line-height: 1.5;
      color: #333;
    }

    .card-details p:first-child {
      font-size: 1.125rem;
      font-weight: bold;
      margin-bottom: 0.75rem;
    }

    .card-details p span {
      font-weight: 500;
      color: #444;
    }

    .view-btn {
      margin-top: 0.9375rem;
      padding: 0.5rem 1.25rem;
      border: none;
      background-color: #eee;
      border-radius: 0.5rem;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .view-btn:hover {
      background-color: #ddd;
      transform: translateY(-0.125rem);
    }

    .add-center-btn {
      background: linear-gradient(90deg, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      width: 180px;
      font-size: 15px;
      margin: 25px auto;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .add-center-btn:hover {
      background: linear-gradient(90deg, #ff3030, #360000);
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
      padding: 30px;
      max-width: 500px;
      margin: auto;
      border: 2px solid #007bff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(6px);
    }

    .form-group label {
      font-weight: 500;
      font-size: 15px;
      color: #444;
    }

    .form-control {
      height: 45px;
      border-radius: 8px;
      font-size: 14px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #ff4040;
      box-shadow: 0 0 5px rgba(255, 64, 64, 0.3);
    }

    .submit-btn {
      background: linear-gradient(to top, #990000, #ff0000);
      border: none;
      color: white;
      border-radius: 10px;
      padding: 12px;
      width: 150px;
      font-weight: 600;
      display: block;
      margin: 25px auto 0;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .close-btn {
      padding: 5px 10px;
      font-size: 14px;
      width: 80px;
    }

    .invalid-feedback {
      color: #dc3545;
      font-size: 12px;
    }

    /* Responsive Design */
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0;
        padding: 10px;
      }
      .center-card {
        padding: 0.9375rem;
        max-width: 100%;
        margin: 0.3125rem;
      }
      .card-details p:first-child {
        font-size: 1rem;
      }
      .view-btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.9375rem;
      }
      .participate-btn {
        width: 120px;
        font-size: 12px;
        padding: 6px 10px;
      }
      .modal-content {
        max-width: 90%;
        padding: 15px;
      }
      .form-control {
        height: 40px;
        font-size: 13px;
      }
      .submit-btn {
        width: 120px;
        padding: 10px;
      }
      .close-btn {
        width: 60px;
        font-size: 12px;
        padding: 3px 8px;
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
        max-width: 15.625rem;
        margin: 0.5rem;
      }
      .participate-btn {
        width: 140px;
        font-size: 13px;
      }
      .modal-content {
        max-width: 90%;
        padding: 20px;
      }
      .close-btn {
        width: 70px;
        font-size: 13px;
        padding: 4px 10px;
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
        max-width: 15.625rem;
        margin: 0.5rem;
      }
      .participate-btn {
        width: 150px;
        font-size: 14px;
      }
      .modal-content {
        max-width: 450px;
      }
    }

    @media (min-width: 992px) {
      .center-card {
        max-width: 18.75rem;
        margin: 0.9375rem;
      }
      .participate-btn {
        width: 180px;
        font-size: 15px;
      }
      .modal-content {
        max-width: 500px;
      }
    }

    /* Touch device hover fix */
    @media (hover: none) {
      .view-btn:hover,
      .add-center-btn:hover,
      .participate-btn:hover {
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
  <div class="content">
    <div class="container-fluid">
      <!-- Participate Button -->
      <div class="header-container">
        <button class="participate-btn btn btn-danger" data-toggle="modal" data-target="#participateModal">Participate</button>
      </div>
      <div class="row justify-content-start">
        <!-- Event & Notice Cards -->
        <div class="col-12">
          <div class="row justify-content-start">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
              <div class="center-card" id="card-1">
                <i class="fas fa-calendar-alt card-icon"></i>
                <div class="card-details">
                  <p><span>Title:</span> Independence day</p>
                  <p><span>Center:</span> ABC</p>
                  <p><span>Date:</span> 15/08/2025</p>
                  <p><span>Time:</span> 6 to 7 AM</p>
                  <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                </div>
                <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
              <div class="center-card" id="card-2">
                <i class="fas fa-calendar-alt card-icon"></i>
                <div class="card-details">
                  <p><span>Title:</span> Independence day</p>
                  <p><span>Center:</span> ABC</p>
                  <p><span>Date:</span> 15/08/2025</p>
                  <p><span>Time:</span> 6 to 7 AM</p>
                  <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                </div>
                <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
              <div class="center-card" id="card-3">
                <i class="fas fa-calendar-alt card-icon"></i>
                <div class="card-details">
                  <p><span>Title:</span> Independence day</p>
                  <p><span>Center:</span> ABC</p>
                  <p><span>Date:</span> 15/08/2025</p>
                  <p><span>Time:</span> 6 to 7 AM</p>
                  <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                </div>
                <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Add Button -->
      <div class="button-container">
        <button class="add-center-btn btn btn-danger" data-toggle="modal" data-target="#addEventModal">Add Event/Notice</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="addEventLabel">Add Event/Notice</h3>
      <form id="eventForm" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="title">Title <span class="text-danger">*</span>:</label>
            <input type="text" id="title" name="title" class="form-control" required />
            <div class="invalid-feedback">Please enter a title.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="center">Center <span class="text-danger">*</span>:</label>
            <input type="text" id="center" name="center" class="form-control" required />
            <div class="invalid-feedback">Please enter a center.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="date">Date <span class="text-danger">*</span>:</label>
            <input type="date" id="date" name="date" class="form-control" required />
            <div class="invalid-feedback">Please select a date.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="time">Time <span class="text-danger">*</span>:</label>
            <input type="time" id="time" name="time" class="form-control" required />
            <div class="invalid-feedback">Please select a time.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="description">Description <span class="text-danger">*</span>:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
            <div class="invalid-feedback">Please enter a description.</div>
          </div>
        </div>

        <button type="submit" class="submit-btn btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

<!-- View Event Modal -->
<div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <h3 id="viewEventLabel">Event/Notice Details</h3>
      <div class="card-details">
        <p>Title: <span id="viewTitle"></span></p>
        <p>Center: <span id="viewCenter"></span></p>
        <p>Date: <span id="viewDate"></span></p>
        <p>Time: <span id="viewTime"></span></p>
        <p>Description: <span id="viewDescription"></span></p>
      </div>
      <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<!-- Participate Modal -->
<div class="modal fade" id="participateModal" tabindex="-1" aria-labelledby="participateLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="participateLabel">Participate in Event</h3>
      <form id="participateForm" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="studentName">Student Name <span class="text-danger">*</span>:</label>
            <select id="studentName" name="studentName" class="form-control" required>
              <option value="">Select Student</option>
              <option>Jane Doe</option>
              <option>John Smith</option>
            </select>
            <div class="invalid-feedback">Please select a student.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="eventTitle">Event Title <span class="text-danger">*</span>:</label>
            <select id="eventTitle" name="eventTitle" class="form-control" required>
              <option value="">Select Event</option>
              <option>Independence day</option>
            </select>
            <div class="invalid-feedback">Please select an event.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="paymentMode">Payment Mode <span class="text-danger">*</span>:</label>
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
        <button type="submit" class="submit-btn btn btn-primary">Confirm Participation</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap + jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Form Validation and Card Creation -->
<script>
  (function () {
    'use strict';
    const form = document.getElementById('eventForm');
    const participateForm = document.getElementById('participateForm');
    if (!form) {
      console.error('Event form not found!');
      return;
    }
    if (!participateForm) {
      console.error('Participate form not found!');
      return;
    }

    // Event form submission
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      event.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      // Get form values
      const title = document.getElementById('title').value.trim();
      const center = document.getElementById('center').value.trim();
      const dateRaw = document.getElementById('date').value;
      const timeRaw = document.getElementById('time').value;
      const description = document.getElementById('description').value.trim();

      // Format date to DD/MM/YYYY
      const dateObj = new Date(dateRaw);
      const date = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;

      // Format time to "H to H+1 AM/PM"
      const [hours, minutes] = timeRaw.split(':');
      const hourNum = parseInt(hours, 10);
      const period = hourNum >= 12 ? 'PM' : 'AM';
      const displayHour = hourNum % 12 || 12;
      const nextHour = (hourNum + 1) % 12 || 12;
      const time = `${displayHour} to ${nextHour} ${period}`;

      // Create new card
      let cardCounter = document.querySelectorAll('.center-card').length + 1;
      const newCard = `
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-${cardCounter}">
            <i class="fas fa-calendar-alt card-icon"></i>
            <div class="card-details">
              <p><span>Title:</span> ${title}</p>
              <p><span>Center:</span> ${center}</p>
              <p><span>Date:</span> ${date}</p>
              <p><span>Time:</span> ${time}</p>
              <p><span>Description:</span> ${description}</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="${title}" data-center="${center}" data-date="${date}" data-time="${time}" data-description="${description}">View</button>
          </div>
        </div>
      `;

      // Append new card to the row
      const row = document.querySelector('.row.justify-content-start .row');
      if (row) {
        row.insertAdjacentHTML('beforeend', newCard);
        // Update event dropdown in participate modal
        const eventSelect = document.getElementById('eventTitle');
        const newOption = document.createElement('option');
        newOption.value = title;
        newOption.textContent = title;
        eventSelect.appendChild(newOption);
      } else {
        console.error('Row element not found!');
      }

      // Reset form and close modal
      form.reset();
      form.classList.remove('was-validated');
      $('#addEventModal').modal('hide');
    });

    // Ensure validation feedback on input for event form
    form.addEventListener('input', function () {
      if (form.checkValidity()) {
        form.classList.remove('was-validated');
      }
    });

    // Participate form submission
    participateForm.addEventListener('submit', function (event) {
      event.preventDefault();
      event.stopPropagation();

      if (!participateForm.checkValidity()) {
        participateForm.classList.add('was-validated');
        return;
      }

      const studentName = document.getElementById('studentName').value;
      const eventTitle = document.getElementById('eventTitle').value;
      const paymentMode = document.querySelector('input[name="paymentMode"]:checked').value;

      // Perform action: Display confirmation and log participation
      alert(`Participation confirmed for ${studentName} in the ${eventTitle} event with payment mode: ${paymentMode}`);
      console.log(`Student ${studentName} registered for ${eventTitle} event with payment mode: ${paymentMode} on ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);

      // Reset form and close modal
      participateForm.reset();
      participateForm.classList.remove('was-validated');
      $('#participateModal').modal('hide');
    });

    // Ensure validation feedback on input for participate form
    participateForm.addEventListener('input', function () {
      if (participateForm.checkValidity()) {
        participateForm.classList.remove('was-validated');
      }
    });

    // Handle view button clicks with jQuery modal event
    $('#viewEventModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget);
      const title = button.data('title');
      const center = button.data('center');
      const date = button.data('date');
      const time = button.data('time');
      const description = button.data('description');

      const modal = $(this);
      modal.find('#viewEventLabel').text(`Event/Notice Details - ${title}`);
      modal.find('#viewTitle').text(title);
      modal.find('#viewCenter').text(center);
      modal.find('#viewDate').text(date);
      modal.find('#viewTime').text(time);
      modal.find('#viewDescription').text(description);
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
  })();
</script>
</body>
</html>