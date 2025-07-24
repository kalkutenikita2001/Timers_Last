<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Staff Management</title>

  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
       background-color: #e9ecef !important;
      margin: 0; /* Remove default margin */
    }

    .content-wrapper {
      margin-left: 250px; /* Default margin matching sidebar width */
      padding: 20px;
      transition: all 0.3s ease-in-out;
      position: relative; /* Ensure positioning context for filter button */
    }

    .content-wrapper.minimized {
      margin-left: 60px; /* Margin when sidebar is minimized */
    }

    .content {
      position: relative; /* Ensure positioning context */
    }

    .center-card {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border-radius: 10px;
      padding: 15px;
      margin: 10px;
      width: 100%;
      max-width: 200px;
      font-size: 12px;
      position: relative;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .center-card .card-body {
      padding: 10px 0;
    }

    .center-card p {
      margin-bottom: 5px;
      line-height: 1.2;
    }

    .card-icon {
      position: absolute;
      top: 5px;
      right: 5px;
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
      transition: color 0.3s ease;
    }

    .center-card:hover .card-icon {
      color: white;
    }

    .view-btn {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      border: 1px solid white;
      border-radius: 5px;
      padding: 5px 10px;
      width: 31%;
      font-size: 12px;
      margin-left: 65px;
      text-align: left;
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    }

    .view-btn:hover {
      background-color: rgba(255, 255, 255, 0.4);
      color: #333;
      transform: translateY(-2px);
    }

    .add-center-btn {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 5px;
      padding: 8px 15px;
      width: 120px;
      font-size: 14px;
      margin: 20px auto;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .add-center-btn:hover {
      background: linear-gradient(to right, #ff3030, #360000);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .button-container {
      display: flex;
      justify-content: center;
    }

    .modal-content {
      background-color: #f8f0f0;
      border-radius: 10px;
      padding: 20px;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(5px);
    }

    .form-group label {
      font-weight: bold;
    }

    .submit-btn {
      background: linear-gradient(to right, #c40000, #470000);
      border: none;
      color: white;
      border-radius: 5px;
      padding: 8px 20px;
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
      .content {
        padding-top: 50px; /* Adjusted for mobile */
      }
      .row.justify-content-center {
        flex-direction: column;
        align-items: center;
      }
      .col-12.col-sm-6.col-md-4.col-lg-3 {
        max-width: 100%;
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
        <div class="row justify-content-center" id="staffRow">
          <!-- Staff Cards -->
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-1">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Name :</strong> Jony Deo</p>
                <p><strong>Contact :</strong> 7896059485</p>
                <p><strong>Address :</strong> Nashik</p>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Batch :</strong> B1</p>
                <p><strong>Date :</strong> 15/07/2025</p>
                <p><strong>Time :</strong> 6 to 7 AM</p>
                <p><strong>Category :</strong> Coach</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-2">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Name :</strong> Jony Deo</p>
                <p><strong>Contact :</strong> 7896059485</p>
                <p><strong>Address :</strong> Nashik</p>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Batch :</strong> B2</p>
                <p><strong>Date :</strong> 15/07/2025</p>
                <p><strong>Time :</strong> 6 to 7 AM</p>
                <p><strong>Category :</strong> Coach</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-3">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Name :</strong> Jony Deo</p>
                <p><strong>Contact :</strong> 7896059485</p>
                <p><strong>Address :</strong> Nashik</p>
                <p><strong>Center Name :</strong> XYZ</p>
                <p><strong>Batch :</strong> B1</p>
                <p><strong>Date :</strong> 15/07/2025</p>
                <p><strong>Time :</strong> 6 to 7 AM</p>
                <p><strong>Category :</strong> Coach</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-4">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Name :</strong> Jony Deo</p>
                <p><strong>Contact :</strong> 7896059485</p>
                <p><strong>Address :</strong> Nashik</p>
                <p><strong>Center Name :</strong> XYZ</p>
                <p><strong>Batch :</strong> B2</p>
                <p><strong>Date :</strong> 15/07/2025</p>
                <p><strong>Time :</strong> 6 to 7 AM</p>
                <p><strong>Category :</strong> Coach</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addStaffModal">Add Staff</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Staff Modal -->
  <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <h5 class="text-center mb-4" id="addStaffLabel">Add Staff</h5>
        <form id="staffForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Name:</label>
              <input type="text" class="form-control" name="name" required />
              <div class="invalid-feedback">Please enter a name.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Contact:</label>
              <input type="tel" class="form-control" name="contact" required pattern="[0-9]{10}" />
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Address:</label>
              <input type="text" class="form-control" name="address" required />
              <div class="invalid-feedback">Please enter an address.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Center Name:</label>
              <input type="text" class="form-control" name="centerName" required />
              <div class="invalid-feedback">Please enter center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Batch:</label>
              <input type="text" class="form-control" name="batch" required />
              <div class="invalid-feedback">Please enter batch.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Date:</label>
              <input type="date" class="form-control" name="date" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Time:</label>
              <input type="time" class="form-control" name="time" required />
              <div class="invalid-feedback">Please select time.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Category:</label>
              <select class="form-control" name="category" required>
                <option value="">Select</option>
                <option>Coach</option>
                <option>Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="submit-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript for Form Submission and Card Creation -->
  <script>
    (function () {
      'use strict';
      let cardCounter = 5; // Start counter after existing cards (card-1 to card-4)

      const form = document.getElementById('staffForm');
      if (!form) {
        console.error('Form element not found!');
        return;
      }

      form.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        console.log('Form submit event triggered');

        if (!form.checkValidity()) {
          console.log('Form is invalid');
          form.classList.add('was-validated');
          return;
        }

        console.log('Form is valid, processing submission');

        // Get form values
        const name = form.querySelector('[name="name"]').value;
        const contact = form.querySelector('[name="contact"]').value;
        const address = form.querySelector('[name="address"]').value;
        const centerName = form.querySelector('[name="centerName"]').value;
        const batch = form.querySelector('[name="batch"]').value;
        const dateRaw = form.querySelector('[name="date"]').value;
        const timeRaw = form.querySelector('[name="time"]').value;
        const category = form.querySelector('[name="category"]').value;

        console.log('Form data:', { name, contact, address, centerName, batch, dateRaw, timeRaw, category });

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

        console.log('Formatted date:', date, 'Formatted time:', time);

        // Create new card
        const newCard = `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-${cardCounter}">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Name :</strong> ${name}</p>
                <p><strong>Contact :</strong> ${contact}</p>
                <p><strong>Address :</strong> ${address}</p>
                <p><strong>Center Name :</strong> ${centerName}</p>
                <p><strong>Batch :</strong> ${batch}</p>
                <p><strong>Date :</strong> ${date}</p>
                <p><strong>Time :</strong> ${time}</p>
                <p><strong>Category :</strong> ${category}</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
        `;

        console.log('New card HTML generated');

        // Append new card to the row
        const staffRow = document.getElementById('staffRow');
        if (staffRow) {
          staffRow.insertAdjacentHTML('beforeend', newCard);
          cardCounter++;
          console.log('Card appended, counter:', cardCounter);
        } else {
          console.error('staffRow element not found!');
        }

        // Reset form and close modal
        form.reset();
        form.classList.remove('was-validated');
        $('#addStaffModal').modal('hide');
        console.log('Form reset and modal closed');
      });

      // Ensure the form is validated on input
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