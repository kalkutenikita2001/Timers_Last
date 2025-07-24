<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event & Notice Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #e9ecef !important;
      margin: 0; /* Remove default margin */
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .content-wrapper {
      margin-left: 250px; /* Default margin matching sidebar width */
      padding: 20px;
      transition: all 0.3s ease-in-out;
    }

    .content-wrapper.minimized {
      margin-left: 60px; /* Margin when sidebar is minimized */
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
      text-align: start;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .card-icon {
      position: absolute;
      top: 8px;
      right: 8px;
      font-size: 16px;
      color: rgba(255, 255, 255, 0.8);
      transition: color 0.3s ease;
    }

    .center-card:hover .card-icon {
      color: white;
    }

    .view-btn {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.5);
      border-radius: 6px;
      padding: 4px 12px;
      width: 70px;
      font-size: 12px;
      margin-top: 12px;
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

    @media (max-width: 768px) {
      body {
        padding-left: 0;
      }
      .content-wrapper {
        margin-left: 0 !important;
        padding: 15px !important;
      }
      .modal-content {
        max-width: 95%;
        padding: 20px;
      }
      .center-card {
        max-width: 180px;
      }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
      .content-wrapper {
        margin-left: 200px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
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
  <div class="content">
    <div class="container-fluid">
      <div class="row justify-content-start">
        <!-- Event & Notice Cards -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-1">
            <i class="fas fa-calendar-alt card-icon"></i>
            <p>Title: Independence day</p>
            <p>Center: ABC</p>
            <p>Date: 15/08/2025</p>
            <p>Time: 6 to 7 AM</p>
            <p>Description: Shantinagar, Nashik, Maharashtra - 456789</p>
            <button class="view-btn">View</button>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-2">
            <i class="fas fa-calendar-alt card-icon"></i>
            <p>Title: Independence day</p>
            <p>Center: ABC</p>
            <p>Date: 15/08/2025</p>
            <p>Time: 6 to 7 AM</p>
            <p>Description: Shantinagar, Nashik, Maharashtra - 456789</p>
            <button class="view-btn">View</button>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
          <div class="center-card" id="card-3">
            <i class="fas fa-calendar-alt card-icon"></i>
            <p>Title: Independence day</p>
            <p>Center: ABC</p>
            <p>Date: 15/08/2025</p>
            <p>Time: 6 to 7 AM</p>
            <p>Description: Shantinagar, Nashik, Maharashtra - 456789</p>
            <button class="view-btn">View</button>
          </div>
        </div>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="addEventLabel">Add Event/Notice</h3>
      <form id="eventForm" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="title">Title :</label>
            <input type="text" id="title" name="title" class="form-control" required />
            <div class="invalid-feedback">Please enter a title.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="center">Center :</label>
            <input type="text" id="center" name="center" class="form-control" required />
            <div class="invalid-feedback">Please enter a center.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="date">Date :</label>
            <input type="date" id="date" name="date" class="form-control" required />
            <div class="invalid-feedback">Please select a date.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="time">Time :</label>
            <input type="time" id="time" name="time" class="form-control" required />
            <div class="invalid-feedback">Please select a time.</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="description">Description :</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
            <div class="invalid-feedback">Please enter a description.</div>
          </div>
        </div>

        <button type="submit" class="submit-btn">Submit</button>
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
    if (!form) {
      console.error('Event form not found!');
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
            <p>Title: ${title}</p>
            <p>Center: ${center}</p>
            <p>Date: ${date}</p>
            <p>Time: ${time}</p>
            <p>Description: ${description}</p>
            <button class="view-btn">View</button>
          </div>
        </div>
      `;

      // Append new card to the row
      const row = document.querySelector('.row.justify-content-start');
      if (row) {
        row.insertAdjacentHTML('beforeend', newCard);
      } else {
        console.error('Row element not found!');
      }

      // Reset form and close modal
      form.reset();
      form.classList.remove('was-validated');
      $('#addEventModal').modal('hide');
    });

    // Ensure validation feedback on input
    form.addEventListener('input', function () {
      if (form.checkValidity()) {
        form.classList.remove('was-validated');
      }
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