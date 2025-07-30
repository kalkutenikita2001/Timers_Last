<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Centers UI</title>
  <!-- Bootstrap CSS -->
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
    .filter-btn {
      background: linear-gradient(90deg, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      font-size: 15px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .filter-btn:hover {
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
      background-color: #444;
      color: white;
      padding: 10px;
      transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
    }
    .content {
      margin-top: 60px;
    }
    .blur {
      filter: blur(5px);
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
      .add-center-btn, .filter-btn {
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
      .add-center-btn, .filter-btn {
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
      .navbar {
        left: 0;
        width: 100%;
      }
      .navbar.sidebar-minimized {
        left: 0;
        width: 100%;
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
      .add-center-btn, .filter-btn {
        width: 150px;
        font-size: 14px;
      }
      .modal-content {
        max-width: 450px;
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
        max-width: 18.75rem;
        margin: 0.9375rem;
      }
      .add-center-btn, .filter-btn {
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
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <!-- Filter Button -->
        <div class="header-container">
          <button class="filter-btn btn btn-danger" data-toggle="modal" data-target="#filterModal">Filter</button>
        </div>
        <div class="row justify-content-start" id="centerCards">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-1">
              <i class="fas fa-building card-icon"></i>
              <div class="card-details">
                <p><span>Center Name:</span> ABC</p>
                <p><span>Admin:</span> Jony Deo</p>
                <p><span>Coordinator:</span> John Deo</p>
                <p><span>Coach:</span> John Deo</p>
                <p><span>Address:</span> Shantinagar, Nashik, Maharashtra-456789</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" data-center-name="ABC" data-admin="Jony Deo" data-coordinator="John Deo" data-coach="John Deo" data-address="Shantinagar, Nashik, Maharashtra-456789">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-2">
              <i class="fas fa-building card-icon"></i>
              <div class="card-details">
                <p><span>Center Name:</span> ABC</p>
                <p><span>Admin:</span> Jony Deo</p>
                <p><span>Coordinator:</span> John Deo</p>
                <p><span>Coach:</span> John Deo</p>
                <p><span>Address:</span> Shantinagar, Nashik, Maharashtra-456789</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" data-center-name="ABC" data-admin="Jony Deo" data-coordinator="John Deo" data-coach="John Deo" data-address="Shantinagar, Nashik, Maharashtra-456789">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-3">
              <i class="fas fa-building card-icon"></i>
              <div class="card-details">
                <p><span>Center Name:</span> ABC</p>
                <p><span>Admin:</span> Jony Deo</p>
                <p><span>Coordinator:</span> John Deo</p>
                <p><span>Coach:</span> John Deo</p>
                <p><span>Address:</span> Shantinagar, Nashik, Maharashtra-456789</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" data-center-name="ABC" data-admin="Jony Deo" data-coordinator="John Deo" data-coach="John Deo" data-address="Shantinagar, Nashik, Maharashtra-456789">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-4">
              <i class="fas fa-building card-icon"></i>
              <div class="card-details">
                <p><span>Center Name:</span> ABC</p>
                <p><span>Admin:</span> Jony Deo</p>
                <p><span>Coordinator:</span> John Deo</p>
                <p><span>Coach:</span> John Deo</p>
                <p><span>Address:</span> Shantinagar, Nashik, Maharashtra-456789</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" data-center-name="ABC" data-admin="Jony Deo" data-coordinator="John Deo" data-coach="John Deo" data-address="Shantinagar, Nashik, Maharashtra-456789">View</button>
            </div>
          </div>
        </div>

        <!-- Add Center Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addCenterModal">Add Center</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Center Modal -->
  <div class="modal fade" id="addCenterModal" tabindex="-1" aria-labelledby="addCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <h3 id="addCenterLabel">Add Center</h3>
        <form id="centerForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="centerName">Center Name <span class="text-danger">*</span>:</label>
              <input type="text" id="centerName" name="centerName" class="form-control" required />
              <div class="invalid-feedback">Please enter center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coordinator">Coordinator <span class="text-danger">*</span>:</label>
              <select id="coordinator" name="coordinator" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="John">John</option>
                <option value="Smith">Smith</option>
              </select>
              <div class="invalid-feedback">Please select a coordinator.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="admin">Admin <span class="text-danger">*</span>:</label>
              <input type="text" id="admin" name="admin" class="form-control" required />
              <div class="invalid-feedback">Please enter admin name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coach">Coach <span class="text-danger">*</span>:</label>
              <select id="coach" name="coach" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="Coach A">Coach A</option>
                <option value="Coach B">Coach B</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="address">Address <span class="text-danger">*</span>:</label>
              <input type="text" id="address" name="address" class="form-control" required />
              <div class="invalid-feedback">Please enter address.</div>
            </div>
          </div>
          <button type="submit" class="submit-btn btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!-- View Center Modal -->
  <div class="modal fade" id="viewCenterModal" tabindex="-1" aria-labelledby="viewCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <h3 id="viewCenterLabel">Center Details</h3>
        <div class="card-details">
          <p>Center Name: <span id="viewCenterName"></span></p>
          <p>Admin: <span id="viewAdmin"></span></p>
          <p>Coordinator: <span id="viewCoordinator"></span></p>
          <p>Coach: <span id="viewCoach"></span></p>
          <p>Address: <span id="viewAddress"></span></p>
        </div>
        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <h3 id="filterLabel">Filter Centers</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterCenterName">Center Name:</label>
              <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" />
            </div>
            <div class="form-group col-md-6">
              <label for="filterAdmin">Admin:</label>
              <input type="text" id="filterAdmin" name="filterAdmin" class="form-control" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterCoordinator">Coordinator:</label>
              <input type="text" id="filterCoordinator" name="filterCoordinator" class="form-control" />
            </div>
            <div class="form-group col-md-6">
              <label for="filterCoach">Coach:</label>
              <input type="text" id="filterCoach" name="filterCoach" class="form-control" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterAddress">Address:</label>
              <input type="text" id="filterAddress" name="filterAddress" class="form-control" />
            </div>
          </div>
          <button type="submit" class="submit-btn btn btn-primary">Apply Filter</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Submission, View Modal, and Filter Handling -->
  <script>
    (function () {
      'use strict';
      const form = document.getElementById('centerForm');
      const filterForm = document.getElementById('filterForm');
      if (!form) {
        console.error('Center form not found!');
        return;
      }
      if (!filterForm) {
        console.error('Filter form not found!');
        return;
      }

      // Store initial cards for filtering
      const initialCards = Array.from(document.querySelectorAll('#centerCards .col-12')).map(card => card.outerHTML);

      // Form submission for adding centers
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!form.checkValidity()) {
          form.classList.add('was-validated');
          return;
        }

        // Get form values
        const centerName = document.getElementById('centerName').value.trim();
        const coordinator = document.getElementById('coordinator').value;
        const admin = document.getElementById('admin').value.trim();
        const coach = document.getElementById('coach').value;
        const address = document.getElementById('address').value.trim();

        // Create new card
        let cardCounter = document.querySelectorAll('.center-card').length + 1;
        const newCard = `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-${cardCounter}">
              <i class="fas fa-building card-icon"></i>
              <div class="card-details">
                <p><span>Center Name:</span> ${centerName}</p>
                <p><span>Admin:</span> ${admin}</p>
                <p><span>Coordinator:</span> ${coordinator}</p>
                <p><span>Coach:</span> ${coach}</p>
                <p><span>Address:</span> ${address}</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" data-center-name="${centerName}" data-admin="${admin}" data-coordinator="${coordinator}" data-coach="${coach}" data-address="${address}">View</button>
            </div>
          </div>
        `;

        // Append new card to the row
        const row = document.querySelector('#centerCards');
        if (row) {
          row.insertAdjacentHTML('beforeend', newCard);
          initialCards.push(newCard); // Add to initial cards for filtering
        } else {
          console.error('Row element not found!');
        }

        // Reset form and close modal
        form.reset();
        form.classList.remove('was-validated');
        $('#addCenterModal').modal('hide');
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

        // Get filter values
        const filterCenterName = document.getElementById('filterCenterName').value.trim().toLowerCase();
        const filterAdmin = document.getElementById('filterAdmin').value.trim().toLowerCase();
        const filterCoordinator = document.getElementById('filterCoordinator').value.trim().toLowerCase();
        const filterCoach = document.getElementById('filterCoach').value.trim().toLowerCase();
        const filterAddress = document.getElementById('filterAddress').value.trim().toLowerCase();

        // Filter cards
        const filteredCards = initialCards.filter(card => {
          const cardElement = document.createElement('div');
          cardElement.innerHTML = card;
          const centerName = cardElement.querySelector('p:nth-child(1) span').textContent.toLowerCase();
          const admin = cardElement.querySelector('p:nth-child(2) span').textContent.toLowerCase();
          const coordinator = cardElement.querySelector('p:nth-child(3) span').textContent.toLowerCase();
          const coach = cardElement.querySelector('p:nth-child(4) span').textContent.toLowerCase();
          const address = cardElement.querySelector('p:nth-child(5) span').textContent.toLowerCase();

          return (!filterCenterName || centerName.includes(filterCenterName)) &&
                 (!filterAdmin || admin.includes(filterAdmin)) &&
                 (!filterCoordinator || coordinator.includes(filterCoordinator)) &&
                 (!filterCoach || coach.includes(filterCoach)) &&
                 (!filterAddress || address.includes(filterAddress));
        });

        // Update card display
        const row = document.getElementById('centerCards');
        row.innerHTML = filteredCards.length ? filteredCards.join('') : '<p class="text-center">No centers match the filter criteria.</p>';

        // Close modal
        $('#filterModal').modal('hide');
      });

      // Handle view button clicks
      $('#viewCenterModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const centerName = button.data('center-name');
        const admin = button.data('admin');
        const coordinator = button.data('coordinator');
        const coach = button.data('coach');
        const address = button.data('address');

        const modal = $(this);
        modal.find('#viewCenterLabel').text(`Center Details - ${centerName}`);
        modal.find('#viewCenterName').text(centerName);
        modal.find('#viewAdmin').text(admin);
        modal.find('#viewCoordinator').text(coordinator);
        modal.find('#viewCoach').text(coach);
        modal.find('#viewAddress').text(address);
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
      $('#addCenterModal, #filterModal').on('show.bs.modal', function () {
        document.getElementById('mainContent').classList.add('blur');
      });

      $('#addCenterModal, #filterModal').on('hidden.bs.modal', function () {
        document.getElementById('mainContent').classList.remove('blur');
      });
    })();
  </script>
</body>
</html>