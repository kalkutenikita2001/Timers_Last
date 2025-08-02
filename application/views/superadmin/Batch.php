<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Batch Management</title>
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
      border-left: 2px solid #ff4040;
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
      position: relative;
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
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
        <div class="row justify-content-start" id="batchRow">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-1">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Batch:</span> B1</p>
                <p><span>Date:</span> 15/07/2025</p>
                <p><span>Time:</span> 6 to 7 AM</p>
                <p><span>Category:</span> Coach</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-2">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Batch:</span> B1</p>
                <p><span>Date:</span> 15/07/2025</p>
                <p><span>Time:</span> 6 to 7 AM</p>
                <p><span>Category:</span> Coach</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-3">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Batch:</span> B1</p>
                <p><span>Date:</span> 15/07/2025</p>
                <p><span>Time:</span> 6 to 7 AM</p>
                <p><span>Category:</span> Coach</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-4">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Batch:</span> B1</p>
                <p><span>Date:</span> 15/07/2025</p>
                <p><span>Time:</span> 6 to 7 AM</p>
                <p><span>Category:</span> Coach</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
            </div>
          </div>
        </div>

        <!-- Add Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addBatchModal">Add Batch</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Batch Modal -->
  <div class="modal fade" id="addBatchModal" tabindex="-1" aria-labelledby="addBatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addBatchLabel">Add Batch</h3>
        <form id="batchForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="batch">Batch <span class="text-danger">*</span>:</label>
              <input type="text" id="batch" name="batch" class="form-control" required />
              <div class="invalid-feedback">Please enter a batch name.</div>
            </div>
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
            <div class="form-group col-md-6">
              <label for="category">Category <span class="text-danger">*</span>:</label>
              <select id="category" name="category" class="form-control" required>
                <option value="">Select</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
          </div>
          <button type="submit" class="submit-btn btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!-- View Batch Modal -->
  <div class="modal fade" id="viewBatchModal" tabindex="-1" aria-labelledby="viewBatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewBatchLabel">Batch Details</h3>
        <div class="card-details">
          <p>Batch: <span id="viewBatch"></span></p>
          <p>Date: <span id="viewDate"></span></p>
          <p>Time: <span id="viewTime"></span></p>
          <p>Category: <span id="viewCategory"></span></p>
        </div>
        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Batches</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterBatch">Batch:</label>
              <input type="text" id="filterBatch" name="filterBatch" class="form-control" />
            </div>
            <div class="form-group col-md-6">
              <label for="filterDate">Date:</label>
              <input type="text" id="filterDate" name="filterDate" class="form-control" placeholder="DD/MM/YYYY" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterTime">Time:</label>
              <input type="text" id="filterTime" name="filterTime" class="form-control" placeholder="H to H AM/PM" />
            </div>
            <div class="form-group col-md-6">
              <label for="filterCategory">Category:</label>
              <input type="text" id="filterCategory" name="filterCategory" class="form-control" />
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
      let cardCounter = 5; // Start counter after existing cards (card-1 to card-4)
      const form = document.getElementById('batchForm');
      const filterForm = document.getElementById('filterForm');
      if (!form) {
        console.error('Batch form not found!');
        return;
      }
      if (!filterForm) {
        console.error('Filter form not found!');
        return;
      }

      // Store initial cards for filtering
      const initialCards = Array.from(document.querySelectorAll('#batchRow .col-12')).map(card => card.outerHTML);

      // Form submission for adding batches
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
        const newCard = `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-${cardCounter}">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Batch:</span> ${batch}</p>
                <p><span>Date:</span> ${date}</p>
                <p><span>Time:</span> ${time}</p>
                <p><span>Category:</span> ${category}</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch="${batch}" data-date="${date}" data-time="${time}" data-category="${category}">View</button>
            </div>
          </div>
        `;

        // Append new card to the row
        const batchRow = document.getElementById('batchRow');
        if (batchRow) {
          batchRow.insertAdjacentHTML('beforeend', newCard);
          initialCards.push(newCard); // Add to initial cards for filtering
          cardCounter++;
        } else {
          console.error('batchRow element not found!');
        }

        // Reset form and close modal
        form.reset();
        form.classList.remove('was-validated');
        $('#addBatchModal').modal('hide');
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
        const filterBatch = document.getElementById('filterBatch').value.trim().toLowerCase();
        const filterDate = document.getElementById('filterDate').value.trim().toLowerCase();
        const filterTime = document.getElementById('filterTime').value.trim().toLowerCase();
        const filterCategory = document.getElementById('filterCategory').value.trim().toLowerCase();

        // Filter cards
        const filteredCards = initialCards.filter(card => {
          const cardElement = document.createElement('div');
          cardElement.innerHTML = card;
          const batch = cardElement.querySelector('p:nth-child(1) span').nextSibling.textContent.trim().toLowerCase();
          const date = cardElement.querySelector('p:nth-child(2) span').nextSibling.textContent.trim().toLowerCase();
          const time = cardElement.querySelector('p:nth-child(3) span').nextSibling.textContent.trim().toLowerCase();
          const category = cardElement.querySelector('p:nth-child(4) span').nextSibling.textContent.trim().toLowerCase();

          return (!filterBatch || batch.includes(filterBatch)) &&
                 (!filterDate || date.includes(filterDate)) &&
                 (!filterTime || time.includes(filterTime)) &&
                 (!filterCategory || category.includes(filterCategory));
        });

        // Update card display
        const row = document.getElementById('batchRow');
        row.innerHTML = filteredCards.length ? filteredCards.join('') : '<p class="text-center">No batches match the filter criteria.</p>';

        // Close modal
        $('#filterModal').modal('hide');
      });

      // Handle view button clicks
      $('#viewBatchModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const batch = button.data('batch');
        const date = button.data('date');
        const time = button.data('time');
        const category = button.data('category');

        const modal = $(this);
        modal.find('#viewBatchLabel').text(`Batch Details - ${batch}`);
        modal.find('#viewBatch').text(batch);
        modal.find('#viewDate').text(date);
        modal.find('#viewTime').text(time);
        modal.find('#viewCategory').text(category);
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
      $('#addBatchModal, #filterModal, #viewBatchModal').on('show.bs.modal', function () {
        document.getElementById('mainContent').classList.add('blur');
      });

      $('#addBatchModal, #filterModal, #viewBatchModal').on('hidden.bs.modal', function () {
        document.getElementById('mainContent').classList.remove('blur');
      });
    })();
  </script>
</body>
</html>