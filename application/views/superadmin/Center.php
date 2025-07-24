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
      margin: 0; /* Ensure no default margin */
      font-family: 'Montserrat', serif;
    }
    .content-wrapper {
      margin-left: 250px; /* Default margin matching sidebar width */
      padding: 0px;
      transition: all 0.3s ease-in-out;
    }
    .content-wrapper.minimized {
      margin-left: 60px; /* Margin when sidebar is minimized */
    }
    .center-card {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border-radius: 10px;
      padding: 15px;
      margin: 10px;
      width: 100%;
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
      padding: 5px 5px;
      width: 31%;
      text-align: left;
      font-size: 12px;
      margin-left: 65px;
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
    }
    .view-btn:hover {
      background-color: rgba(255, 255, 255, 0.4);
      color: #333;
      transform: translateY(-2px);
    }
    .view-btn i {
      float: right;
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
    .button-container {
      display: flex;
      justify-content: center;
    }
    .blur {
      filter: blur(5px);
    }
    @media (max-width: 768px) {
      body {
        padding-left: 0;
      }
      .sidebar {
        width: 100%;
        position: relative;
      }
      .navbar {
        left: 0;
      }
      .content-wrapper {
        margin-left: 0 !important;
        padding: 15px !important;
      }
      .row.justify-content-center {
        flex-direction: column;
        align-items: center;
      }
      .col-12.col-sm-6.col-md-4.col-lg-3 {
        max-width: 200px;
      }
    }
    @media (min-width: 769px) and (max-width: 1024px) {
      .content-wrapper {
        margin-left: 200px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
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
        <div class="row justify-content-center">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-start">
            <div class="center-card" id="card-1">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Admin :</strong> Jony Deo</p>
                <p><strong>Coordinator :</strong> John Deo</p>
                <p><strong>Coach :</strong> John Deo</p>
                <p><strong>Address :</strong> Shantinagar, Nashik, Maharashtra-456789</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <!-- Copy more cards as needed -->
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-start">
            <div class="center-card" id="card-2">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Admin :</strong> Jony Deo</p>
                <p><strong>Coordinator :</strong> John Deo</p>
                <p><strong>Coach :</strong> John Deo</p>
                <p><strong>Address :</strong> Shantinagar, Nashik, Maharashtra-456789</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-start">
            <div class="center-card" id="card-3">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Admin :</strong> Jony Deo</p>
                <p><strong>Coordinator :</strong> John Deo</p>
                <p><strong>Coach :</strong> John Deo</p>
                <p><strong>Address :</strong> Shantinagar, Nashik, Maharashtra-456789</p>
                <button class="view-btn">View</button>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-start">
            <div class="center-card" id="card-4">
              <div class="card-body">
                <i class="fas fa-plus-circle card-icon"></i>
                <p><strong>Center Name :</strong> ABC</p>
                <p><strong>Admin :</strong> Jony Deo</p>
                <p><strong>Coordinator :</strong> John Deo</p>
                <p><strong>Coach :</strong> John Deo</p>
                <p><strong>Address :</strong> Shantinagar, Nashik, Maharashtra-456789</p>
                <button class="view-btn">View</button>
              </div>
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
  <div class="modal fade" id="addCenterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content" style="background-color: #f1eaea;">
        <div class="modal-header">
          <h5 class="modal-title w-100 text-center">Add Center</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeBlur()">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="centerForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Center Name :</label>
                <input type="text" class="form-control" id="centerName" required />
                <div class="invalid-feedback">Please enter center name.</div>
              </div>
              <div class="form-group col-md-6">
                <label>Select Coordinator :</label>
                <select class="form-control" id="coordinator" required>
                  <option value="">-- Select --</option>
                  <option value="John">John</option>
                  <option value="Smith">Smith</option>
                </select>
                <div class="invalid-feedback">Please select a coordinator.</div>
              </div>
              <div class="form-group col-md-6">
                <label>Admin :</label>
                <input type="text" class="form-control" id="admin" required />
                <div class="invalid-feedback">Please enter admin name.</div>
              </div>
              <div class="form-group col-md-6">
                <label>Select Coach :</label>
                <select class="form-control" id="coach" required>
                  <option value="">-- Select --</option>
                  <option value="Coach A">Coach A</option>
                  <option value="Coach B">Coach B</option>
                </select>
                <div class="invalid-feedback">Please select a coach.</div>
              </div>
              <div class="form-group col-md-12">
                <label>Address :</label>
                <input type="text" class="form-control" id="address" required />
                <div class="invalid-feedback">Please enter address.</div>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn text-white" style="background: linear-gradient(to right, #ff4040, #470000);">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Blur Control and Form Submission -->
  <script>
    $('#addCenterModal').on('show.bs.modal', function () {
      document.getElementById('mainContent').classList.add('blur');
    });

    $('#addCenterModal').on('hidden.bs.modal', function () {
      document.getElementById('mainContent').classList.remove('blur');
    });

    document.getElementById('centerForm').addEventListener('submit', function (e) {
      e.preventDefault();
      e.stopPropagation();

      if (!this.checkValidity()) {
        this.classList.add('was-validated');
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
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-start">
          <div class="center-card" id="card-${cardCounter}">
            <div class="card-body">
              <i class="fas fa-plus-circle card-icon"></i>
              <p><strong>Center Name :</strong> ${centerName}</p>
              <p><strong>Admin :</strong> ${admin}</p>
              <p><strong>Coordinator :</strong> ${coordinator}</p>
              <p><strong>Coach :</strong> ${coach}</p>
              <p><strong>Address :</strong> ${address}</p>
              <button class="view-btn">View</button>
            </div>
          </div>
        </div>
      `;

      // Append new card to the row
      const row = document.querySelector('.row.justify-content-center');
      row.insertAdjacentHTML('beforeend', newCard);

      // Reset form and close modal
      this.reset();
      this.classList.remove('was-validated');
      $('#addCenterModal').modal('hide');
    });

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