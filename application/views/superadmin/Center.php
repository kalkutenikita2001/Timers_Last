<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Centers UI</title>
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
    .filter-wrapper {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 10px;
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
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <div class="filter-wrapper">
          <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal" aria-label="Open filter modal">
            <i class="bi bi-funnel me-2"></i> Filter
          </button>
        </div>
        
        <div class="row justify-content-start" id="centerCards"></div>

        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addCenterModal">Add Center</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addCenterModal" tabindex="-1" aria-labelledby="addCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addCenterLabel">Add Center</h3>
        <form id="centerForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="centerName">Center Name <span class="text-danger">*</span></label>
              <input type="text" id="centerName" name="centerName" class="form-control" placeholder="Enter center name" required />
              <div class="invalid-feedback">Please enter center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coordinator">Coordinator <span class="text-danger">*</span></label>
              <select id="coordinator" name="coordinator" class="form-control" required>
                <option value="">-- Select Coordinator --</option>
                <option value="John">John</option>
                <option value="Smith">Smith</option>
              </select>
              <div class="invalid-feedback">Please select a coordinator.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="admin">Admin <span class="text-danger">*</span></label>
              <input type="text" id="admin" name="admin" class="form-control" placeholder="Enter admin name" required />
              <div class="invalid-feedback">Please enter admin name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coach">Coach <span class="text-danger">*</span></label>
              <select id="coach" name="coach" class="form-control" required>
                <option value="">-- Select Coach --</option>
                <option value="Coach A">Coach A</option>
                <option value="Coach B">Coach B</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="address">Address <span class="text-danger">*</span></label>
              <input type="text" id="address" name="address" class="form-control" placeholder="Enter address" required />
              <div class="invalid-feedback">Please enter address.</div>
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

  <div class="modal fade" id="viewCenterModal" tabindex="-1" aria-labelledby="viewCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewCenterLabel">Center Details</h3>
        <form id="viewCenterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="viewCenterName">Center Name <span class="text-danger">*</span></label>
              <input type="text" id="viewCenterName" name="centerName" class="form-control" placeholder="Enter center name" required />
              <div class="invalid-feedback">Please enter center name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCoordinator">Coordinator <span class="text-danger">*</span></label>
              <select id="viewCoordinator" name="coordinator" class="form-control" required>
                <option value="">-- Select Coordinator --</option>
                <option value="John">John</option>
                <option value="Smith">Smith</option>
              </select>
              <div class="invalid-feedback">Please select a coordinator.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewAdmin">Admin <span class="text-danger">*</span></label>
              <input type="text" id="viewAdmin" name="admin" class="form-control" placeholder="Enter admin name" required />
              <div class="invalid-feedback">Please enter admin name.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCoach">Coach <span class="text-danger">*</span></label>
              <select id="viewCoach" name="coach" class="form-control" required>
                <option value="">-- Select Coach --</option>
                <option value="Coach A">Coach A</option>
                <option value="Coach B">Coach B</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="viewAddress">Address <span class="text-danger">*</span></label>
              <input type="text" id="viewAddress" name="address" class="form-control" placeholder="Enter address" required />
              <div class="invalid-feedback">Please enter address.</div>
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

  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="filterLabel">Filter Centers</h3>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterCenterName">Center Name</label>
              <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" placeholder="Enter center name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterAdmin">Admin</label>
              <input type="text" id="filterAdmin" name="filterAdmin" class="form-control" placeholder="Enter admin name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterCoordinator">Coordinator</label>
              <input type="text" id="filterCoordinator" name="filterCoordinator" class="form-control" placeholder="Enter coordinator name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterCoach">Coach</label>
              <input type="text" id="filterCoach" name="filterCoach" class="form-control" placeholder="Enter coach name" />
            </div>
            <div class="form-group col-md-12">
              <label for="filterAddress">Address</label>
              <input type="text" id="filterAddress" name="filterAddress" class="form-control" placeholder="Enter address" />
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

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function () {
      'use strict';

      const baseUrl = '<?php echo base_url(); ?>center/';

      function loadCenters(filters = {}) {
        $.ajax({
          url: baseUrl + 'get_centers',
          method: 'GET',
          data: filters,
          success: function (response) {
            if (response.status === 'success') {
              const centers = response.data;
              const row = $('#centerCards');
              row.empty();
              if (centers.length === 0) {
                row.html('<p class="text-center">No centers match the filter criteria.</p>');
                return;
              }
              centers.forEach(center => {
                const card = `
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="center-card" id="card-${center.id}">
                      <i class="fas fa-building card-icon"></i>
                      <div class="card-details">
                        <p><span>Center Name:</span> ${center.center_name}</p>
                        <p><span>Admin:</span> ${center.admin}</p>
                        <p><span>Coordinator:</span> ${center.coordinator}</p>
                        <p><span>Coach:</span> ${center.coach}</p>
                        <p><span>Address:</span> ${center.address}</p>
                      </div>
                      <button class="view-btn" data-toggle="modal" data-target="#viewCenterModal" 
                              data-center-id="${center.id}" 
                              data-center-name="${center.center_name}" 
                              data-admin="${center.admin}" 
                              data-coordinator="${center.coordinator}" 
                              data-coach="${center.coach}" 
                              data-address="${center.address}">View</button>
                    </div>
                  </div>
                `;
                row.append(card);
              });
            } else {
              console.error('Error fetching centers:', response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
          }
        });
      }

      $(document).ready(function () {
        loadCenters();
      });

      $('#centerForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const formData = {
          centerName: $('#centerName').val().trim(),
          admin: $('#admin').val().trim(),
          coordinator: $('#coordinator').val(),
          coach: $('#coach').val(),
          address: $('#address').val().trim()
        };

        $.ajax({
          url: baseUrl + 'add_center',
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response.status === 'success') {
              loadCenters();
              $('#centerForm').removeClass('was-validated').trigger('reset');
              $('#addCenterModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while adding the center.');
          }
        });
      });

      $('#centerForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const filters = {
          center_name: $('#filterCenterName').val().trim(),
          admin: $('#filterAdmin').val().trim(),
          coordinator: $('#filterCoordinator').val().trim(),
          coach: $('#filterCoach').val().trim(),
          address: $('#filterAddress').val().trim()
        };

        loadCenters(filters);
        $('#filterModal').modal('hide');
      });

      $('#viewCenterModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const centerId = button.data('center-id');
        const centerName = button.data('center-name');
        const admin = button.data('admin');
        const coordinator = button.data('coordinator');
        const coach = button.data('coach');
        const address = button.data('address');

        const modal = $(this);
        modal.find('#viewCenterLabel').text(`Center Details - ${centerName}`);
        modal.find('#viewCenterName').val(centerName);
        modal.find('#viewAdmin').val(admin);
        modal.find('#viewCoordinator').val(coordinator);
        modal.find('#viewCoach').val(coach);
        modal.find('#viewAddress').val(address);
        modal.find('.update-btn').data('center-id', centerId);
        modal.find('.delete-btn').data('center-id', centerId);
      });

      $('#viewCenterForm').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!this.checkValidity()) {
          $(this).addClass('was-validated');
          return;
        }

        const centerId = $(this).find('.update-btn').data('center-id');
        const formData = {
          centerName: $('#viewCenterName').val().trim(),
          admin: $('#viewAdmin').val().trim(),
          coordinator: $('#viewCoordinator').val(),
          coach: $('#viewCoach').val(),
          address: $('#viewAddress').val().trim()
        };

        $.ajax({
          url: baseUrl + 'update_center/' + centerId,
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response.status === 'success') {
              loadCenters();
              $('#viewCenterForm').removeClass('was-validated');
              $('#viewCenterModal').modal('hide');
            } else {
              alert(response.message);
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX error:', error);
            alert('An error occurred while updating the center.');
          }
        });
      });

      $('#viewCenterForm').on('input', function () {
        if (this.checkValidity()) {
          $(this).removeClass('was-validated');
        }
      });

      $('#viewCenterForm .delete-btn').on('click', function () {
        const centerId = $(this).data('center-id');
        if (confirm('Are you sure you want to delete this center?')) {
          $.ajax({
            url: baseUrl + 'delete_center/' + centerId,
            method: 'POST',
            success: function (response) {
              if (response.status === 'success') {
                loadCenters();
                $('#viewCenterModal').modal('hide');
              } else {
                alert(response.message);
              }
            },
            error: function (xhr, status, error) {
              console.error('AJAX error:', error);
              alert('An error occurred while deleting the center.');
            }
          });
        }
      });

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

      $('#addCenterModal, #filterModal, #viewCenterModal').on('show.bs.modal', function () {
        $('#mainContent').addClass('blur');
      });

      $('#addCenterModal, #filterModal, #viewCenterModal').on('hidden.bs.modal', function () {
        $('#mainContent').removeClass('blur');
      });
    })();
  </script>
</body>
</html>