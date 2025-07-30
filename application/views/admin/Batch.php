<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Batch Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #e9ecef !important;
      margin: 0;
      font-family: 'Montserrat', serif;
      overflow-x: hidden;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 1.25rem;
      transition: all 0.3s ease-in-out;
    }

    .content-wrapper.minimized {
      margin-left: 60px;
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
      border-radius: 0.5rem;
      padding: 0.5rem 0.9375rem;
      width: 8.75rem;
      font-size: 0.9375rem;
      margin: 1.5625rem auto;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .add-center-btn:hover {
      background: linear-gradient(90deg, #ff3030, #360000);
      transform: translateY(-0.125rem);
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    .button-container {
      display: flex;
      justify-content: center;
    }

    .filter-btn {
      position: absolute;
      top: 1.25rem;
      right: 1.25rem;
      background: linear-gradient(90deg, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 0.5rem;
      padding: 0.5rem 0.9375rem;
      font-size: 0.9375rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .filter-btn:hover {
      background: linear-gradient(90deg, #ff3030, #360000);
      transform: translateY(-0.125rem);
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    .modal-content {
      background-color: #ffffff;
      border-radius: 0.9375rem;
      padding: 1.875rem;
      max-width: 40.625rem;
      margin: auto;
      border: 0.125rem solid #007bff;
      box-shadow: 0 0.3125rem 0.9375rem rgba(0, 0, 0, 0.1);
      margin-top: 4.5625rem;
    }

    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 1.875rem;
      color: #333;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(0.375rem);
    }

    .form-group label {
      font-weight: 500;
      font-size: 0.9375rem;
      color: #444;
    }

    .form-control {
      height: 2.8125rem;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      border: 0.0625rem solid #ced4da;
      transition: border-color 0.3s ease;
    }

    .form-control:focus {
      border-color: #ff4040;
      box-shadow: 0 0 0.3125rem rgba(255, 64, 64, 0.3);
    }

    .submit-btn {
      background: linear-gradient(to top, #990000, #ff0000);
      border: none;
      color: white;
      border-radius: 0.625rem;
      padding: 0.75rem;
      width: 9.375rem;
      font-weight: 600;
      display: block;
      margin: 1.5625rem auto 0;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .submit-btn:hover {
      transform: translateY(-0.125rem);
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
    }

    .invalid-feedback {
      color: #dc3545;
      font-size: 0.75rem;
    }

    .view-modal-content {
      background-color: #ffffff;
      border-radius: 0.9375rem;
      padding: 1.875rem;
      max-width: 31.25rem;
      margin: auto;
      border: 0.125rem solid #007bff;
      box-shadow: 0 0.3125rem 0.9375rem rgba(0, 0, 0, 0.1);
    }

    .view-modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 1.25rem;
      color: #333;
    }

    .view-modal-content p {
      margin: 0.625rem 0;
      font-size: 0.9375rem;
      color: #444;
    }

    @media (max-width: 768px) {
      body {
        padding-left: 0;
      }
      .content-wrapper {
        margin-left: 0 !important;
        padding: 0.9375rem !important;
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
      .add-center-btn {
        width: 100%;
        max-width: 12.5rem;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
      }
      .filter-btn {
        top: 0.9375rem;
        right: 0.9375rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
      }
      .modal-content {
        max-width: 90%;
        padding: 1.25rem;
        margin-top: 2.5rem;
      }
      .view-modal-content {
        max-width: 90%;
        padding: 1.25rem;
      }
      .form-control {
        font-size: 0.8125rem;
      }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
      .content-wrapper {
        margin-left: 12.5rem;
      }
      .content-wrapper.minimized {
        margin-left: 3.75rem;
      }
      .center-card {
        max-width: 15.625rem;
        margin: 0.5rem;
      }
      .add-center-btn {
        max-width: 15.625rem;
      }
      .filter-btn {
        top: 1.25rem;
        right: 1.25rem;
      }
      .modal-content {
        max-width: 35rem;
      }
      .view-modal-content {
        max-width: 28.125rem;
      }
    }

    @media (min-width: 1025px) {
      .content-wrapper {
        padding: 2.5rem;
      }
      .center-card {
        max-width: 18.75rem;
        margin: 0.9375rem;
      }
      .modal-content {
        max-width: 40.625rem;
      }
      .view-modal-content {
        max-width: 31.25rem;
      }
    }

    /* Touch device hover fix */
    @media (hover: none) {
      .view-btn:hover,
      .add-center-btn:hover,
      .filter-btn:hover {
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
      <button class="filter-btn" data-toggle="modal" data-target="#filterModal">Filter</button>
      <div class="row justify-content-center">
        <!-- Batch Cards -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-1">
            <i class="fas fa-calendar-alt card-icon"></i>
            <div class="card-details">
              <p><span>Batch:</span> B1</p>
              <p><span>Date:</span> 15/07/2025</p>
              <p><span>Time:</span> 6 to 7 AM</p>
              <p><span>Category:</span> Coach</p>
              <p><span>Group Size:</span> 6</p>
              <p><span>Coach:</span> John Doe</p>
              <p><span>Admissions:</span> 4</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewModal" data-card-id="card-1">View</button>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-2">
            <i class="fas fa-calendar-alt card-icon"></i>
            <div class="card-details">
              <p><span>Batch:</span> B2</p>
              <p><span>Date:</span> 16/07/2025</p>
              <p><span>Time:</span> 7 to 8 AM</p>
              <p><span>Category:</span> Coach</p>
              <p><span>Group Size:</span> 6</p>
              <p><span>Coach:</span> Jane Smith</p>
              <p><span>Admissions:</span> 3</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewModal" data-card-id="card-2">View</button>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-3">
            <i class="fas fa-calendar-alt card-icon"></i>
            <div class="card-details">
              <p><span>Batch:</span> B3</p>
              <p><span>Date:</span> 17/07/2025</p>
              <p><span>Time:</span> 8 to 9 AM</p>
              <p><span>Category:</span> Coach</p>
              <p><span>Group Size:</span> 6</p>
              <p><span>Coach:</span> Mike Johnson</p>
              <p><span>Admissions:</span> 5</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewModal" data-card-id="card-3">View</button>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-4">
            <i class="fas fa-calendar-alt card-icon"></i>
            <div class="card-details">
              <p><span>Batch:</span> B4</p>
              <p><span>Date:</span> 18/07/2025</p>
              <p><span>Time:</span> 9 to 10 AM</p>
              <p><span>Category:</span> Coach</p>
              <p><span>Group Size:</span> 6</p>
              <p><span>Coach:</span> Sarah Brown</p>
              <p><span>Admissions:</span> 2</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewModal" data-card-id="card-4">View</button>
          </div>
        </div>
      </div>

      <!-- Add Button -->
      <div class="button-container">
        <button class="add-center-btn btn btn-danger" data-toggle="modal" data-target="#addBatchModal">Add Batch</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Batch Modal -->
<div class="modal fade" id="addBatchModal" tabindex="-1" aria-labelledby="addBatchLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="addBatchLabel">Add Batch</h3>
      <form id="batchForm" novalidate>
        <div class="form-row">
          <div class="form-group col-12 col-md-6">
            <label for="batch">Batch <span class="text-danger">*</span>:</label>
            <input type="text" id="batch" name="batch" class="form-control" required />
            <div class="invalid-feedback">Please enter a batch name.</div>
          </div>
          <div class="form-group col-12 col-md-6">
            <label for="date">Date <span class="text-danger">*</span>:</label>
            <input type="date" id="date" name="date" class="form-control" required />
            <div class="invalid-feedback">Please select a date.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-12 col-md-6">
            <label for="time">Time <span class="text-danger">*</span>:</label>
            <input type="time" id="time" name="time" class="form-control" required />
            <div class="invalid-feedback">Please select a time.</div>
          </div>
          <div class="form-group col-12 col-md-6">
            <label for="category">Category <span class="text-danger">*</span>:</label>
            <select id="category" name="category" class="form-control" required>
              <option value="">Select</option>
              <option>Coach</option>
              <option>Coordinator</option>
            </select>
            <div class="invalid-feedback">Please select a category.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-12 col-md-6">
            <label for="groupSize">Group Size <span class="text-danger">*</span>:</label>
            <input type="number" id="groupSize" name="groupSize" class="form-control" max="6" min="1" value="6" required />
            <div class="invalid-feedback">Please enter a valid group size (1-6).</div>
          </div>
          <div class="form-group col-12 col-md-6">
            <label for="coach">Assigned Coach <span class="text-danger">*</span>:</label>
            <select id="coach" name="coach" class="form-control" required>
              <option value="">Select</option>
              <option>John Doe</option>
              <option>Jane Smith</option>
              <option>Mike Johnson</option>
              <option>Sarah Brown</option>
            </select>
            <div class="invalid-feedback">Please select a coach.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-12 col-md-6">
            <label for="admissions">Admissions <span class="text-danger">*</span>:</label>
            <input type="number" id="admissions" name="admissions" class="form-control" min="0" max="6" value="0" required />
            <div class="invalid-feedback">Please enter valid admissions (0-6).</div>
          </div>
        </div>

        <button type="submit" class="submit-btn btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="view-modal-content">
      <h3 id="viewModalLabel">Batch Details</h3>
      <p><strong>Batch:</strong> B1</p>
      <p><strong>Date:</strong> 15/07/2025</p>
      <p><strong>Time:</strong> 6 to 7 AM</p>
      <p><strong>Category:</strong> Coach</p>
      <p><strong>Group Size:</strong> 6</p>
      <p><strong>Coach:</strong> John Doe</p>
      <p><strong>Admissions:</strong> 4</p>
      <p><strong>Attendance:</strong> 80%</p>
      <p><strong>Notes:</strong> Session went well, all attendees participated actively.</p>
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
    const form = document.getElementById('batchForm');
    if (!form) {
      console.error('Batch form not found!');
      return;
    }

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      event.stopPropagation();

      if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
      }

      // Get form values
      const batch = document.getElementById('batch').value.trim();
      const dateRaw = document.getElementById('date').value;
      const timeRaw = document.getElementById('time').value;
      const category = document.getElementById('category').value;
      const groupSize = document.getElementById('groupSize').value;
      const coach = document.getElementById('coach').value;
      const admissions = document.getElementById('admissions').value;

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
              <p><span>Batch:</span> ${batch}</p>
              <p><span>Date:</span> ${date}</p>
              <p><span>Time:</span> ${time}</p>
              <p><span>Category:</span> ${category}</p>
              <p><span>Group Size:</span> ${groupSize}</p>
              <p><span>Coach:</span> ${coach}</p>
              <p><span>Admissions:</span> ${admissions}</p>
            </div>
            <button class="view-btn" data-toggle="modal" data-target="#viewModal" data-card-id="card-${cardCounter}">View</button>
          </div>
        </div>
      `;

      // Append new card to the row
      const row = document.querySelector('.row.justify-content-center');
      if (row) {
        row.insertAdjacentHTML('beforeend', newCard);
      } else {
        console.error('Row element not found!');
      }

      // Reset form and close modal
      form.reset();
      form.classList.remove('was-validated');
      $('#addBatchModal').modal('hide');
    });

    // Ensure validation feedback on input
    form.addEventListener('input', function () {
      if (form.checkValidity()) {
        form.classList.remove('was-validated');
      }
    });

    // Populate View Modal with dummy data based on card clicked
    $('#viewModal').on('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const cardId = button.getAttribute('data-card-id');
      const card = document.getElementById(cardId);
      const details = card.querySelector('.card-details').getElementsByTagName('p');

      let batch = '', date = '', time = '', category = '', groupSize = '', coach = '', admissions = '';
      for (let p of details) {
        const span = p.querySelector('span');
        if (span) {
          const key = p.textContent.replace(': ' + span.textContent, '').trim();
          const value = span.textContent;
          switch (key) {
            case 'Batch': batch = value; break;
            case 'Date': date = value; break;
            case 'Time': time = value; break;
            case 'Category': category = value; break;
            case 'Group Size': groupSize = value; break;
            case 'Coach': coach = value; break;
            case 'Admissions': admissions = value; break;
          }
        }
      }

      const modal = $(this);
      modal.find('#viewModalLabel').text(`Batch Details - ${batch}`);
      modal.find('p:nth-child(2)').text(`Batch: ${batch}`);
      modal.find('p:nth-child(3)').text(`Date: ${date}`);
      modal.find('p:nth-child(4)').text(`Time: ${time}`);
      modal.find('p:nth-child(5)').text(`Category: ${category}`);
      modal.find('p:nth-child(6)').text(`Group Size: ${groupSize}`);
      modal.find('p:nth-child(7)').text(`Coach: ${coach}`);
      modal.find('p:nth-child(8)').text(`Admissions: ${admissions}`);
      modal.find('p:nth-child(9)').text(`Attendance: ${Math.floor(Math.random() * 101)}%`);
      modal.find('p:nth-child(10)').text(`Notes: Session went well, ${Math.floor(Math.random() * 6)} attendees participated actively.`);
    });
  })();

  // Sidebar toggle functionality
  document.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.querySelector('.navbar');
    const contentWrapper = document.getElementById('contentWrapper');

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
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
</script>
</body>
</html>