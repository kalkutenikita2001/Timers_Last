<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Batch Management</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #e9ecef !important;
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
      margin: 0.625rem;
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
    .form-control, .form-control select {
      height: 38px;
      border-radius: 8px;
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
      color: white;
    }
    .update-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .delete-btn {
      color: white;
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
      margin-top: 60px;
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
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">Filter</button>
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
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch-id="card-1" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
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
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch-id="card-2" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
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
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch-id="card-3" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
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
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch-id="card-4" data-batch="B1" data-date="15/07/2025" data-time="6 to 7 AM" data-category="Coach">View</button>
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
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addBatchLabel">Add Batch</h3>
        <form id="batchForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="batch">Batch <span class="text-danger">*</span></label>
              <input type="text" id="batch" name="batch" class="form-control" placeholder="Enter batch name" required />
              <div class="invalid-feedback">Please enter a batch name.</div>
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

  <!-- View Batch Modal -->
  <div class="modal fade" id="viewBatchModal" tabindex="-1" aria-labelledby="viewBatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewBatchLabel">Batch Details</h3>
        <form id="viewBatchForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="viewBatch">Batch <span class="text-danger">*</span></label>
              <input type="text" id="viewBatch" name="batch" class="form-control" placeholder="Enter batch name" required />
              <div class="invalid-feedback">Please enter a batch name.</div>
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

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Batches</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterBatch">Batch</label>
              <input type="text" id="filterBatch" name="filterBatch" class="form-control" placeholder="Enter batch name" />
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

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Submission, View Modal, Update, Delete, and Filter Handling -->
  <script>
    (function () {
      'use strict';
      let cardCounter = 5;
      const form = document.getElementById('batchForm');
      const filterForm = document.getElementById('filterForm');
      const viewForm = document.getElementById('viewBatchForm');
      if (!form) {
        console.error('Batch form not found!');
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

      // Store initial cards for filtering
      let initialCards = Array.from(document.querySelectorAll('#batchRow .col-12')).map(card => card.outerHTML);

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
              <button class="view-btn" data-toggle="modal" data-target="#viewBatchModal" data-batch-id="card-${cardCounter}" data-batch="${batch}" data-date="${date}" data-time="${time}" data-category="${category}">View</button>
            </div>
          </div>
        `;

        // Append new card to the row
        const batchRow = document.getElementById('batchRow');
        if (batchRow) {
          batchRow.insertAdjacentHTML('beforeend', newCard);
          initialCards.push(newCard);
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
        const batchId = button.data('batch-id');
        const batch = button.data('batch');
        const date = button.data('date');
        const time = button.data('time');
        const category = button.data('category');

        const modal = $(this);
        modal.find('#viewBatchLabel').text(`Batch Details - ${batch}`);
        modal.find('#viewBatch').val(batch);
        modal.find('#viewDate').val(new Date(date.split('/').reverse().join('-')).toISOString().split('T')[0]);
        modal.find('#viewTime').val(time.split(' to ')[0].trim());
        modal.find('#viewCategory').val(category);
        modal.find('.update-btn').data('batch-id', batchId);
        modal.find('.delete-btn').data('batch-id', batchId);
      });

      // Handle update form submission
      viewForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!viewForm.checkValidity()) {
          viewForm.classList.add('was-validated');
          return;
        }

        const batchId = $(viewForm).find('.update-btn').data('batch-id');
        const batch = document.getElementById('viewBatch').value.trim();
        const dateRaw = document.getElementById('viewDate').value;
        const timeRaw = document.getElementById('viewTime').value;
        const category = document.getElementById('viewCategory').value;

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

        // Update the card
        const card = document.getElementById(batchId);
        if (card) {
          card.querySelector('p:nth-child(1) span').nextSibling.textContent = ` ${batch}`;
          card.querySelector('p:nth-child(2) span').nextSibling.textContent = ` ${date}`;
          card.querySelector('p:nth-child(3) span').nextSibling.textContent = ` ${time}`;
          card.querySelector('p:nth-child(4) span').nextSibling.textContent = ` ${category}`;
          card.querySelector('.view-btn').setAttribute('data-batch', batch);
          card.querySelector('.view-btn').setAttribute('data-date', date);
          card.querySelector('.view-btn').setAttribute('data-time', time);
          card.querySelector('.view-btn').setAttribute('data-category', category);

          // Update initialCards
          const cardIndex = initialCards.findIndex(c => c.includes(`id="${batchId}"`));
          if (cardIndex !== -1) {
            initialCards[cardIndex] = card.parentElement.outerHTML;
          }
        }

        // Reset form and close modal
        viewForm.classList.remove('was-validated');
        $('#viewBatchModal').modal('hide');
      });

      // Ensure validation feedback on input for view form
      viewForm.addEventListener('input', function () {
        if (viewForm.checkValidity()) {
          viewForm.classList.remove('was-validated');
        }
      });

      // Handle delete button click
      viewForm.querySelector('.delete-btn').addEventListener('click', function () {
        const batchId = $(this).data('batch-id');
        const card = document.getElementById(batchId);
        if (card) {
          const cardContainer = card.parentElement;
          cardContainer.remove();
          // Update initialCards
          initialCards = initialCards.filter(c => !c.includes(`id="${batchId}"`));
          $('#viewBatchModal').modal('hide');
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