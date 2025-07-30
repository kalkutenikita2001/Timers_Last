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
      background: linear-gradient(90deg, #ff4040, #470000);
      color: white;
      border-radius: 12px;
      padding: 15px;
      margin: 10px;
      width: 100%;
      max-width: 220px;
      font-size: 13px;
      position: relative;
      text-align: left;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 250px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .card-icon {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 16px;
      color: rgba(255, 255, 255, 0.8);
      transition: color 0.3s ease;
    }

    .center-card:hover .card-icon {
      color: white;
    }

    .card-details {
      padding-top: 5px;
      overflow: hidden;
    }

    .card-details p {
      margin: 5px 0;
      font-weight: 500;
      line-height: 1.4;
      word-wrap: break-word;
    }

    .card-details p:first-child {
      font-size: 14px;
      font-weight: 600;
      color: #fff;
    }

    .card-details p span {
      font-weight: 400;
    }

    .view-btn {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 6px;
      padding: 5px 12px;
      width: 70px;
      font-size: 12px;
      margin-top: 10px;
      text-align: center;
      display: block;
      margin-left: auto;
      margin-right: auto;
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    }

    .view-btn:hover {
      background-color: rgba(255, 255, 255, 0.4);
      color: #333;
      transform: translateY(-2px);
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
      max-width: 650px;
      margin: auto;
      border: 2px solid #007bff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 30px;
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
        max-width: 100%;
        height: auto;
        min-height: 220px;
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
        max-width: 180px;
        height: 240px;
      }
      .participate-btn {
        width: 140px;
        font-size: 13px;
      }
      .modal-content {
        max-width: 95%;
        padding: 20px;
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
        max-width: 200px;
      }
      .participate-btn {
        width: 150px;
        font-size: 14px;
      }
    }

    @media (min-width: 992px) {
      .center-card {
        max-width: 220px;
      }
      .participate-btn {
        width: 180px;
        font-size: 15px;
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
                  <p>Title: <span>Independence day</span></p>
                  <p>Center: <span>ABC</span></p>
                  <p>Date: <span>15/08/2025</span></p>
                  <p>Time: <span>6 to 7 AM</span></p>
                  <p>Description: <span>Shantinagar, Nashik, Maharashtra - 456789</span></p>
                </div>
                <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
              <div class="center-card" id="card-2">
                <i class="fas fa-calendar-alt card-icon"></i>
                <div class="card-details">
                  <p>Title: <span>Independence day</span></p>
                  <p>Center: <span>ABC</span></p>
                  <p>Date: <span>15/08/2025</span></p>
                  <p>Time: <span>6 to 7 AM</span></p>
                  <p>Description: <span>Shantinagar, Nashik, Maharashtra - 456789</span></p>
                </div>
                <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
              <div class="center-card" id="card-3">
                <i class="fas fa-calendar-alt card-icon"></i>
                <div class="card-details">
                  <p>Title: <span>Independence day</span></p>
                  <p>Center: <span>ABC</span></p>
                  <p>Date: <span>15/08/2025</span></p>
                  <p>Time: <span>6 to 7 AM</span></p>
                  <p>Description: <span>Shantinagar, Nashik, Maharashtra - 456789</span></p>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="viewEventLabel">Event/Notice Details</h3>
      <div class="card-details">
        <p>Title: <span id="viewTitle"></span></p>
        <p>Center: <span id="viewCenter"></span></p>
        <p>Date: <span id="viewDate"></span></p>
        <p>Time: <span id="viewTime"></span></p>
        <p>Description: <span id="viewDescription"></span></p>
      </div>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
              <p>Title: <span>${title}</span></p>
              <p>Center: <span>${center}</span></p>
              <p>Date: <span>${date}</span></p>
              <p>Time: <span>${time}</span></p>
              <p>Description: <span>${description}</span></p>
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

    // Handle view button clicks
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('view-btn')) {
        document.getElementById('viewTitle').textContent = e.target.getAttribute('data-title');
        document.getElementById('viewCenter').textContent = e.target.getAttribute('data-center');
        document.getElementById('viewDate').textContent = e.target.getAttribute('data-date');
        document.getElementById('viewTime').textContent = e.target.getAttribute('data-time');
        document.getElementById('viewDescription').textContent = e.target.getAttribute('data-description');
      }
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
