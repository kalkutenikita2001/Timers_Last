<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
  <style>
    body {
      background-color: #e9ecef !important;
      color: #fff;
      font-family: 'Montserrat', sans-serif;
      overflow-x: hidden;
    }
    .dashboard-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s ease-in-out;
      min-height: 100vh;
      max-width: calc(100vw - 250px);
      box-sizing: border-box;
    }
    .dashboard-wrapper.minimized {
      margin-left: 60px;
      max-width: calc(100vw - 60px);
    }
    .dashboard-wrapper.sidebar-minimized {
      margin-left: 60px;
      max-width: calc(100vw - 60px);
    }
    .dashboard-wrapper.sidebar-collapsed {
      margin-left: 60px;
      max-width: calc(100vw - 60px);
    }
    .dashboard-wrapper.sidebar-hidden {
      margin-left: 0;
      max-width: 100vw;
    }
    .container-fluid {
      max-width: 100%;
      margin: 0 auto;
      overflow-x: hidden;
      padding: 0 15px;
    }
    .top-stats-row {
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 20px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      align-items: center;
    }
    .card-stat {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border-radius: 10px;
      text-align: center;
      height: 120px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-stat:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .card-stat h4 {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
    }
    .card-stat span {
      font-size: 13px;
    }
    .export-section {
      text-align: center;
      margin: 20px 0;
    }
    .btn-custom {
      background-color: black;
      border: none;
      padding: 10px 20px;
      margin: 0 5px;
      color: #fff;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 14px;
      min-width: 140px;
      position: relative;
      overflow: hidden;
    }
    .btn-custom:hover {
      background-color: #333;
      color: white;
      transform: translateY(-1px);
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .btn-custom::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }
    .btn-custom:active::after {
      width: 200px;
      height: 200px;
      opacity: 0;
    }
    .main-content {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      margin-bottom: 20px;
      width: 100%;
      max-width: 100%;
    }
    .students-table-container {
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 100%;
      overflow: hidden;
      background: #fff;
    }
    .students-table-container h6 {
      font-weight: 700;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      color: black;
    }
    .filter-btn, .add-btn {
      background: #333;
      border: 1px solid #444;
      color: #fff;
      padding: 5px 15px;
      border-radius: 5px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s ease;
      white-space: nowrap;
      position: relative;
      overflow: hidden;
    }
    .filter-btn:hover, .add-btn:hover {
      background: #444;
      transform: translateY(-1px);
    }
    .add-btn {
      background: #ff4040;
      border-color: #ff4040;
    }
    .add-btn:hover {
      background: #cc3333;
    }
    .filter-btn::after, .add-btn::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.4s ease, height 0.4s ease;
    }
    .filter-btn:active::after, .add-btn:active::after {
      width: 150px;
      height: 150px;
      opacity: 0;
    }
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      overflow-y: hidden;
      -webkit-overflow-scrolling: touch;
      border-radius: 5px;
    }
    .students-table {
      width: 100%;
      min-width: 700px;
      font-size: 12px;
      border-collapse: collapse;
      table-layout: fixed;
      background-color: #fff;
      color: #000;
    }
    .students-table th {
      background: #333;
      padding: 10px 8px;
      text-align: left;
      border-bottom: 1px solid #444;
      font-weight: 600;
      white-space: nowrap;
      position: sticky;
      top: 0;
      z-index: 10;
      color: #fff;
    }
    .students-table th:nth-child(1) { width: 15%; }
    .students-table th:nth-child(2) { width: 15%; }
    .students-table th:nth-child(3) { width: 12%; }
    .students-table th:nth-child(4) { width: 12%; }
    .students-table th:nth-child(5) { width: 15%; }
    .students-table th:nth-child(6) { width: 18%; }
    .students-table th:nth-child(7) { width: 13%; }
    .students-table td {
      padding: 10px 8px;
      border-bottom: 1px solid #ddd;
      font-size: 11px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .students-table tr:hover {
      background: #f5f5f5;
    }
    .action-icons {
      display: flex;
      gap: 5px;
      justify-content: flex-start;
    }
    .action-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px 8px;
      border-radius: 3px;
      transition: all 0.2s ease;
      font-size: 12px;
      color: black;
      position: relative;
      overflow: hidden;
      min-width: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .action-btn:hover {
      transform: scale(1.1);
    }
    .action-btn.view-btn:hover {
      background: #007bff;
      color: white;
    }
    .action-btn.edit-btn:hover {
      background: #28a745;
      color: white;
    }
    .action-btn.delete-btn:hover {
      background: #dc3545;
      color: white;
    }
    .bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
      width: 100%;
      max-width: 100%;
    }
    .attendance-container, .staff-container {
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      min-height: 250px;
      width: 100%;
      max-width: 100%;
      background: #fff;
    }
    .attendance-container h6, .staff-container h6 {
      font-weight: 700;
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
      color: black;
    }
    .attendance-table, .staff-table {
      width: 100%;
      min-width: 300px;
      font-size: 11px;
      border-collapse: collapse;
      table-layout: fixed;
      background-color: #fff;
      color: #000;
    }
    .attendance-table th, .staff-table th {
      background: #333;
      padding: 8px 6px;
      text-align: left;
      border-bottom: 1px solid #444;
      font-weight: 600;
      white-space: nowrap;
      font-size: 10px;
      color: #fff;
    }
    .attendance-table th:nth-child(1) { width: 25%; }
    .attendance-table th:nth-child(2) { width: 15%; }
    .attendance-table th:nth-child(3) { width: 20%; }
    .attendance-table th:nth-child(4) { width: 25%; }
    .attendance-table th:nth-child(5) { width: 15%; }
    .staff-table th:nth-child(1) { width: 30%; }
    .staff-table th:nth-child(2) { width: 25%; }
    .staff-table th:nth-child(3) { width: 30%; }
    .staff-table th:nth-child(4) { width: 15%; }
    .attendance-table td, .staff-table td {
      padding: 8px 6px;
      border-bottom: 1px solid #ddd;
      font-size: 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .attendance-table tr:hover, .staff-table tr:hover {
      background: #f5f5f5;
    }
    .chart-container {
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
      min-height: 250px;
      width: 100%;
      max-width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: #fff;
    }
    .chart-container h6 {
      font-weight: 700;
      margin-bottom: 15px;
      color: black;
    }
    .chart-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      max-height: 160px;
    }
    #studentChart {
      max-width: 120px !important;
      max-height: 120px !important;
    }
    .legend-item {
      display: flex;
      align-items: center;
      font-size: 11px;
      margin: 3px 0;
      justify-content: flex-start;
      color: black;
    }
    .legend-color {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-right: 8px;
      flex-shrink: 0;
    }
    .modal-content {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 20px;
      max-width: 500px;
      margin: auto;
      border: 2px solid #007bff;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      position: relative;
      color: #000;
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 15px;
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
    .form-group {
      margin-bottom: 0.75rem;
    }
    .form-group label {
      font-weight: 500;
      font-size: 14px;
      color: #444;
      margin-bottom: 4px;
      display: block;
    }
    .form-control {
      height: 38px;
      border-radius: 8px;
      font-size: 13px;
      border: 1px solid #ced4da;
      transition: border-color 0.3s ease;
    }
    .form-control:focus {
      border-color: #ff4040;
      box-shadow: 0 0 5px rgba(255, 64, 64, 0.3);
    }
    .form-control.is-invalid {
      border-color: #dc3545;
    }
    .form-control::placeholder {
      color: #999;
    }
    .submit-btn, .close-btn {
      border-radius: 8px;
      padding: 8px;
      font-weight: 600;
      width: 120px;
      margin: 6px 5px;
      border: none;
      color: #000000;
      box-shadow: 0 3px 6px rgba(0,0,0,0.1);
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .submit-btn {
      background: #ffffff;
    }
    .submit-btn:hover {
      background: #f0f0f0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .close-btn {
      background: #e0e0e0;
      color: #333;
    }
    .close-btn:hover {
      background: #d0d0d0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.2);
    }
    .invalid-feedback {
      color: #dc3545;
      font-size: 12px;
      margin-top: 4px;
    }
    .status-badge {
      padding: 2px 6px;
      border-radius: 10px;
      font-size: 9px;
      font-weight: 600;
      white-space: nowrap;
    }
    .status-complete {
      background: #d4edda;
      color: #155724;
    }
    .status-intermediate {
      background: #fff3cd;
      color: #856404;
    }
    .status-pending {
      background: #f8d7da;
      color: #721c24;
    }
    .status-present {
      background: #d4edda;
      color: #155724;
    }
    .status-absent {
      background: #f8d7da;
      color: #721c24;
    }
    @media (max-width: 1400px) {
      .card-stat {
        flex: 1 1 25%;
        min-width: 140px;
      }
    }
    @media (max-width: 1200px) {
      .main-content {
        grid-template-columns: 1fr;
      }
      .bottom-grid {
        grid-template-columns: 1fr 1fr;
      }
      .card-stat {
        flex: 1 1 30%;
        min-width: 120px;
      }
    }
    @media (max-width: 992px) {
      .bottom-grid {
        grid-template-columns: 1fr;
      }
      .card-stat {
        flex: 1 1 40%;
        min-width: 100px;
      }
    }
    @media (max-width: 768px) {
      .dashboard-wrapper {
        margin-left: 0 !important;
        padding: 15px !important;
        max-width: 100vw !important;
      }
      .container-fluid {
        padding: 0 10px;
      }
      .top-stats-row {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: auto auto;
        gap: 15px;
      }
      .card-stat {
        flex: 1 1 100%;
        min-width: 100%;
        margin-bottom: 10px;
      }
      .main-content {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      .bottom-grid {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      .btn-custom {
        font-size: 12px;
        padding: 6px 12px;
        min-width: 100px;
        margin: 5px;
      }
      .students-table-container,
      .attendance-container,
      .staff-container,
      .chart-container {
        padding: 15px;
      }
      .students-table-container h6,
      .attendance-container h6,
      .staff-container h6 {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
      .filter-btn, .add-btn {
        padding: 4px 10px;
        font-size: 11px;
      }
      .modal-content {
        max-width: 90%;
        padding: 15px;
      }
      .form-row {
        flex-direction: column;
        gap: 8px;
      }
      .form-control {
        height: 34px;
        font-size: 12px;
      }
      .form-group label {
        font-size: 13px;
      }
      .submit-btn, .close-btn {
        width: 100px;
        padding: 6px;
        font-size: 12px;
      }
      .modal-content h3 {
        font-size: 1rem;
      }
    }
    @media (max-width: 576px) {
      .dashboard-wrapper {
        padding: 10px !important;
      }
      .container-fluid {
        padding: 0 5px;
      }
      .top-stats-row {
        padding: 10px;
      }
      .card-stat .stat-number {
        font-size: 18px;
      }
      .card-stat .stat-label {
        font-size: 10px;
      }
      .students-table, .attendance-table, .staff-table {
        font-size: 10px;
        min-width: 280px;
      }
      .students-table th, .students-table td,
      .attendance-table th, .attendance-table td,
      .staff-table th, .staff-table td {
        padding: 6px 4px;
        font-size: 9px;
      }
      .action-btn {
        font-size: 11px;
        padding: 3px;
      }
      #studentChart {
        max-width: 100px !important;
        max-height: 100px !important;
      }
      .modal-content {
        max-width: 95%;
        padding: 12px;
      }
      .btn-custom {
        font-size: 11px;
        padding: 5px 10px;
        min-width: 90px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('admin/Include/Navbar') ?>
  <!-- Dashboard Content -->
  <div class="dashboard-wrapper" id="dashboardWrapper">
    <div class="container-fluid">
      <!-- Top Stats Row -->
      <div class="top-stats-row">
        <div class="card-stat" onclick="handleStatClick('totalStudents')" style="position: relative;">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>2450</h4>
              <span>Total Students</span>
            </div>
          </div>
          <i class="bi bi-person-lines-fill fs-3 opacity-50" style="position: absolute; top: 5px; right: 15px;"></i>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalBranches')" style="position: relative;">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>25</h4>
              <span>Total Branches</span>
            </div>
          </div>
          <i class="bi bi-building fs-3 opacity-50" style="position: absolute; top: 5px; right: 15px;"></i>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalRevenue')" style="position: relative;">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>Rs.50000</h4>
              <span>Total Revenue</span>
            </div>
          </div>
          <i class="bi bi-currency-rupee fs-3 opacity-50" style="position: absolute; top: 5px; right: 15px;"></i>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalExpense')" style="position: relative;">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>Rs.3000</h4>
              <span>Total Expense</span>
            </div>
          </div>
          <i class="bi bi-graph-down fs-3 opacity-50" style="position: absolute; top: 5px; right: 15px;"></i>
        </div>
      </div>
      <!-- Export Buttons -->
      <div class="d-flex justify-content-center gap-2 my-3 flex-wrap">
        <div class=" px-2 py-1 rounded  d-flex align-items-center">
          <button class="bg-white btn btn-sm btn-custom shadow-sm" onclick="exportToExcel()">
            <i class="bi bi-download me-1"></i> Excel
          </button>
        </div>
        <div class=" px-2 py-1 rounded  d-flex align-items-center">
          <button class="bg-white btn btn-sm btn-custom shadow-sm" onclick="exportToPDF()">
            <i class="bi bi-download me-1"></i> PDF
          </button>
        </div>
      </div>
      <!-- Main Content Grid -->
      <div class="main-content">
        <!-- Recently Added Students -->
        <div class="students-table-container">
          <h6>
            Recently Added Students
            <div>
              <button class="filter-btn me-2" data-bs-toggle="modal" data-bs-target="#studentsFilterModal">
                <i class="bi bi-funnel"></i> Filter
              </button>
              <button class="add-btn" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                 <i class="fas fa-plus mr-1"></i>Add Student
              </button>
            </div>
          </h6>
          <div class="table-responsive">
            <table class="students-table table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Center</th>
                  <th>Batch</th>
                  <th>Level</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="studentsTableBody">
                <!-- Dynamic content will be populated here -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Bottom Grid -->
      <div class="bottom-grid">
        <!-- Student Attendance -->
        <div class="attendance-container">
          <h6>
            Student Attendance
            <button class="filter-btn" data-bs-toggle="modal" data-bs-target="#attendanceFilterModal">
              <i class="bi bi-funnel"></i> Filter
            </button>
          </h6>
          <div class="table-responsive">
            <table class="attendance-table table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Batch</th>
                  <th>Level</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="attendanceTableBody">
                <!-- Dynamic content will be populated here -->
              </tbody>
            </table>
          </div>
        </div>
        <!-- Total Staff -->
        <div class="staff-container">
          <h6>
            Total Staff
            <button class="filter-btn" data-bs-toggle="modal" data-bs-target="#staffFilterModal">
              <i class="bi bi-funnel"></i> Filter
            </button>
          </h6>
          <div class="table-responsive">
            <table class="staff-table table table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="staffTableBody">
                <!-- Dynamic content will be populated here -->
              </tbody>
            </table>
          </div>
        </div>
        <!-- Total Students Chart -->
        <div class="chart-container">
          <h6>Total Students</h6>
          <div class="chart-wrapper">
            <canvas id="studentChart"></canvas>
          </div>
          <div class="mt-2">
            <div class="legend-item">
              <span class="legend-color" style="background:#ff6b6b"></span> Beginner (30%)
            </div>
            <div class="legend-item">
              <span class="legend-color" style="background:#ffeb3b"></span> Intermediate (40%)
            </div>
            <div class="legend-item">
              <span class="legend-color" style="background:#4ecdc4"></span> Advanced (30%)
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Students Filter Modal -->
    <div class="modal fade" id="studentsFilterModal" tabindex="-1" aria-labelledby="studentsFilterLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="studentsFilterLabel">Filter Students</h3>
          <form id="studentsFilterForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="filterStudentName">Name</label>
                <input type="text" id="filterStudentName" name="name" class="form-control" placeholder="Enter name" pattern="[A-Za-z\s]+" />
                <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStudentContact">Contact</label>
                <input type="tel" id="filterStudentContact" name="contact" class="form-control" placeholder="Enter contact" pattern="[0-9]{10}" />
                <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStudentCenter">Center</label>
                <input type="text" id="filterStudentCenter" name="center" class="form-control" placeholder="Enter center" pattern="[A-Za-z0-9\s]+" />
                <div class="invalid-feedback">Please enter a valid center name.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStudentBatch">Batch</label>
                <input type="text" id="filterStudentBatch" name="batch" class="form-control" placeholder="Enter batch" pattern="[A-Za-z0-9\s]+" />
                <div class="invalid-feedback">Please enter a valid batch code.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStudentLevel">Level</label>
                <select id="filterStudentLevel" name="level" class="form-control">
                  <option value="">Select</option>
                  <option>Beginner</option>
                  <option>Intermediate</option>
                  <option>Advanced</option>
                </select>
                <div class="invalid-feedback">Please select a level.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStudentCategory">Category</label>
                <select id="filterStudentCategory" name="category" class="form-control">
                  <option value="">Select</option>
                  <option>Complete</option>
                  <option>Pending</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="submit-btn btn">Apply Filter</button>
              <button type="button" class="close-btn btn" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="addStudentLabel">Add Student</h3>
          <form id="addStudentForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="addStudentName">Name</label>
                <input type="text" id="addStudentName" name="name" class="form-control" placeholder="Enter name" pattern="[A-Za-z\s]+" required />
                <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
              </div>
              <div class="form-group col-md-12">
                <label for="addStudentContact">Contact</label>
                <input type="tel" id="addStudentContact" name="contact" class="form-control" placeholder="Enter contact" pattern="[0-9]{10}" required />
                <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="addStudentCenter">Center</label>
                <select id="addStudentCenter" name="center" class="form-control" required>
                  <option value="">-- Select Center --</option>
                </select>
                <div class="invalid-feedback">Please select a center.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="addStudentBatch">Batch</label>
                <select id="addStudentBatch" name="batch" class="form-control" required>
                  <option value="">-- Select Batch --</option>
                </select>
                <div class="invalid-feedback">Please select a batch.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="addStudentLevel">Level</label>
                <select id="addStudentLevel" name="level" class="form-control" required>
                  <option value="">Select</option>
                  <option>Beginner</option>
                  <option>Intermediate</option>
                  <option>Advanced</option>
                </select>
                <div class="invalid-feedback">Please select a level.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="addStudentCategory">Category</label>
                <select id="addStudentCategory" name="category" class="form-control" required>
                  <option value="">Select</option>
                  <option>Complete</option>
                  <option>Pending</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="submit-btn btn">Add Student</button>
              <button type="button" class="close-btn btn" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="editStudentLabel">Edit Student</h3>
          <form id="editStudentForm" novalidate>
            <input type="hidden" id="editStudentId">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="editStudentName">Name</label>
                <input type="text" id="editStudentName" name="name" class="form-control" placeholder="Enter name" pattern="[A-Za-z\s]+" required />
                <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
              </div>
              <div class="form-group col-md-12">
                <label for="editStudentContact">Contact</label>
                <input type="tel" id="editStudentContact" name="contact" class="form-control" placeholder="Enter contact" pattern="[0-9]{10}" required />
                <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="editStudentCenter">Center</label>
                <input type="text" id="editStudentCenter" name="center" class="form-control" placeholder="Enter center" pattern="[A-Za-z0-9\s]+" required />
                <div class="invalid-feedback">Please enter a valid center name.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="editStudentBatch">Batch</label>
                <input type="text" id="editStudentBatch" name="batch" class="form-control" placeholder="Enter batch" pattern="[A-Za-z0-9\s]+" required />
                <div class="invalid-feedback">Please enter a valid batch code.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="editStudentLevel">Level</label>
                <select id="editStudentLevel" name="level" class="form-control" required>
                  <option value="">Select</option>
                  <option>Beginner</option>
                  <option>Intermediate</option>
                  <option>Advanced</option>
                </select>
                <div class="invalid-feedback">Please select a level.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="editStudentCategory">Category</label>
                <select id="editStudentCategory" name="category" class="form-control" required>
                  <option value="">Select</option>
                  <option>Complete</option>
                  <option>Pending</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="submit-btn btn">Save Changes</button>
              <button type="button" class="close-btn btn" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- View Student Modal -->
    <div class="modal fade" id="viewStudentModal" tabindex="-1" aria-labelledby="viewStudentLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="viewStudentLabel">Student Details</h3>
          <div id="viewStudentContent"></div>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="close-btn btn" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Attendance Filter Modal -->
    <div class="modal fade" id="attendanceFilterModal" tabindex="-1" aria-labelledby="attendanceFilterLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="attendanceFilterLabel">Filter Attendance</h3>
          <form id="attendanceFilterForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="filterAttendanceName">Name</label>
                <input type="text" id="filterAttendanceName" name="name" class="form-control" placeholder="Enter name" pattern="[A-Za-z\s]+" />
                <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterAttendanceBatch">Batch</label>
                <input type="text" id="filterAttendanceBatch" name="batch" class="form-control" placeholder="Enter batch" pattern="[A-Za-z0-9\s]+" />
                <div class="invalid-feedback">Please enter a valid batch code.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterAttendanceLevel">Level</label>
                <select id="filterAttendanceLevel" name="level" class="form-control">
                  <option value="">Select</option>
                  <option>Beginner</option>
                  <option>Intermediate</option>
                  <option>Advanced</option>
                </select>
                <div class="invalid-feedback">Please select a level.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterAttendanceCategory">Category</label>
                <select id="filterAttendanceCategory" name="category" class="form-control">
                  <option value="">Select</option>
                  <option>Present</option>
                  <option>Absent</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="submit-btn btn">Apply Filter</button>
              <button type="button" class="close-btn btn" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Staff Filter Modal -->
    <div class="modal fade" id="staffFilterModal" tabindex="-1" aria-labelledby="staffFilterLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
          <h3 id="staffFilterLabel">Filter Staff</h3>
          <form id="staffFilterForm" novalidate>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="filterStaffName">Name</label>
                <input type="text" id="filterStaffName" name="name" class="form-control" placeholder="Enter name" pattern="[A-Za-z\s]+" />
                <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStaffName">Contact</label>
                <input type="tel" id="filterStaffContact" name="contact" class="form-control" placeholder="Enter contact" pattern="[0-9]{10}" />
                <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
              </div>
              <div class="form-group col-md-12">
                <label for="filterStaffCategory">Category</label>
                <select id="filterStaffCategory" name="category" class="form-control">
                  <option value="">Select</option>
                  <option>Coach</option>
                  <option>Coordinator</option>
                  <option>Admin</option>
                  <option>Trainer</option>
                  <option>Manager</option>
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="submit-btn btn">Apply Filter</button>
              <button type="button" class="close-btn btn" data-bs-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    // Dummy data
    const studentData = {
      jane: { name: 'Jane Doe', contact: '9876543210', center: 'ABC', batch: 'B1', level: 'Intermediate', category: 'Complete' },
      john: { name: 'John Smith', contact: '9876543211', center: 'XYZ', batch: 'B2', level: 'Advanced', category: 'Pending' },
      sarah: { name: 'Sarah Wilson', contact: '9876543212', center: 'PQR', batch: 'B3', level: 'Beginner', category: 'Complete' },
      emma: { name: 'Emma Brown', contact: '9876543213', center: 'DEF', batch: 'B4', level: 'Intermediate', category: 'Pending' },
      michael: { name: 'Michael Lee', contact: '9876543214', center: 'GHI', batch: 'B5', level: 'Advanced', category: 'Complete' }
    };
    const attendanceData = {
      jane: { name: 'Jane Doe', batch: 'B1', level: 'Basic', category: 'Present' },
      john: { name: 'John Smith', batch: 'B2', level: 'Advanced', category: 'Absent' },
      sarah: { name: 'Sarah Wilson', batch: 'B3', level: 'Intermediate', category: 'Present' },
      emma: { name: 'Emma Brown', batch: 'B4', level: 'Intermediate', category: 'Present' },
      michael: { name: 'Michael Lee', batch: 'B5', level: 'Advanced', category: 'Absent' }
    };
    const staffData = {
      alice: { name: 'Alice Johnson', contact: '9876543213', category: 'Coordinator' },
      bob: { name: 'Bob Brown', contact: '9876543214', category: 'Admin' },
      carol: { name: 'Carol Davis', contact: '9876543215', category: 'Coach' },
      david: { name: 'David Wilson', contact: '9876543216', category: 'Trainer' },
      eve: { name: 'Eve Taylor', contact: '9876543217', category: 'Manager' }
    };

    // Function to fetch and populate Centers
    function loadCenters(selectElementId) {
        $.ajax({
            url: '<?php echo base_url("center/get_centers"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                const selectElement = document.getElementById(selectElementId);
                selectElement.innerHTML = '<option value="">-- Select Center --</option>';
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    response.data.forEach(center => {
                        const option = document.createElement('option');
                        option.value = center.center_name;
                        option.textContent = center.center_name;
                        selectElement.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No centers available';
                    option.disabled = true;
                    selectElement.appendChild(option);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching centers:', error);
                const selectElement = document.getElementById(selectElementId);
                selectElement.innerHTML = '<option value="" disabled>Error loading centers</option>';
            }
        });
    }

    // Function to fetch and populate Batches
    function loadBatches(selectElementId) {
        $.ajax({
            url: '<?php echo base_url("batch/get_batches"); ?>',
            method: 'POST',
            data: { '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
            dataType: 'json',
            success: function(response) {
                const selectElement = document.getElementById(selectElementId);
                selectElement.innerHTML = '<option value="">-- Select Batch --</option>';
                if (response.status === 'success' && response.data && response.data.length > 0) {
                    response.data.forEach(batch => {
                        const option = document.createElement('option');
                        option.value = batch.batch;
                        option.textContent = batch.batch;
                        selectElement.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No batches available';
                    option.disabled = true;
                    selectElement.appendChild(option);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching batches:', error);
                const selectElement = document.getElementById(selectElementId);
                selectElement.innerHTML = '<option value="" disabled>Error loading batches</option>';
            }
        });
    }

    // Function to fetch and autocomplete Student Names
    function loadStudentNames(inputElementId) {
        $.ajax({
            url: '<?php echo base_url("Student_controller/get_students"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success' && response.students && response.students.length > 0) {
                    const names = response.students.map(student => student.name);
                    $(`#${inputElementId}`).autocomplete({
                        source: names,
                        minLength: 2
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching student names:', error);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
      renderTables();
      setupFilterForms();
      setupAddStudentForm();
      setupEditStudentForm();
    });

    function validateForm(form) {
      const inputs = form.querySelectorAll('input[required], select[required]');
      let isValid = true;
      inputs.forEach(input => {
        if (!input.value || (input.pattern && !new RegExp(input.pattern).test(input.value))) {
          input.classList.add('is-invalid');
          isValid = false;
        } else {
          input.classList.remove('is-invalid');
        }
      });
      return isValid;
    }

    function renderTables(filters = {}) {
      renderStudentsTable(filters.students || {});
      renderAttendanceTable(filters.attendance || {});
      renderStaffTable(filters.staff || {});
    }

    function renderStudentsTable(filter = {}) {
      const tbody = document.getElementById('studentsTableBody');
      tbody.innerHTML = '';
      let data = Object.entries(studentData);
      if (Object.keys(filter).length > 0) {
        data = data.filter(([id, student]) => {
          return Object.entries(filter).every(([key, value]) => {
            if (!value) return true;
            return String(student[key.toLowerCase()]).toLowerCase().includes(value.toLowerCase());
          });
        });
      }
      data.forEach(([id, student]) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${student.name}</td>
          <td>${student.contact}</td>
          <td>${student.center}</td>
          <td>${student.batch}</td>
          <td>${student.level}</td>
          <td><span class="status-badge status-${student.category.toLowerCase()}">${student.category}</span></td>
          <td>
            <div class="action-icons">
              <button class="action-btn view-btn" onclick="viewStudent('${id}')" title="View Student" data-bs-toggle="modal" data-bs-target="#viewStudentModal">
                <i class="bi bi-eye"></i>
              </button>
              <button class="action-btn edit-btn" onclick="editStudent('${id}')" title="Edit Student" data-bs-toggle="modal" data-bs-target="#editStudentModal">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="action-btn delete-btn" onclick="deleteStudent('${id}')" title="Delete Student">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function renderAttendanceTable(filter = {}) {
      const tbody = document.getElementById('attendanceTableBody');
      tbody.innerHTML = '';
      let data = Object.entries(attendanceData);
      if (Object.keys(filter).length > 0) {
        data = data.filter(([id, record]) => {
          return Object.entries(filter).every(([key, value]) => {
            if (!value) return true;
            return String(record[key.toLowerCase()]).toLowerCase().includes(value.toLowerCase());
          });
        });
      }
      data.forEach(([id, record]) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${record.name}</td>
          <td>${record.batch}</td>
          <td>${record.level}</td>
          <td><span class="status-badge status-${record.category.toLowerCase()}">${record.category}</span></td>
          <td>
            <button class="action-btn view-btn" onclick="viewAttendance('${id}')" title="View Attendance">
              <i class="bi bi-eye"></i>
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function renderStaffTable(filter = {}) {
      const tbody = document.getElementById('staffTableBody');
      tbody.innerHTML = '';
      let data = Object.entries(staffData);
      if (Object.keys(filter).length > 0) {
        data = data.filter(([id, staff]) => {
          return Object.entries(filter).every(([key, value]) => {
            if (!value) return true;
            return String(staff[key.toLowerCase()]).toLowerCase().includes(value.toLowerCase());
          });
        });
      }
      data.forEach(([id, staff]) => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${staff.name}</td>
          <td>${staff.contact}</td>
          <td>${staff.category}</td>
          <td>
            <button class="action-btn view-btn" onclick="viewStaff('${id}')" title="View Staff">
              <i class="bi bi-eye"></i>
            </button>
          </td>
        `;
        tbody.appendChild(row);
      });
    }

    function setupFilterForms() {
      const studentsFilterForm = document.getElementById('studentsFilterForm');
      const attendanceFilterForm = document.getElementById('attendanceFilterForm');
      const staffFilterForm = document.getElementById('staffFilterForm');
      studentsFilterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;
        const filter = {
          name: document.getElementById('filterStudentName').value.trim(),
          contact: document.getElementById('filterStudentContact').value.trim(),
          center: document.getElementById('filterStudentCenter').value.trim(),
          batch: document.getElementById('filterStudentBatch').value.trim(),
          level: document.getElementById('filterStudentLevel').value,
          category: document.getElementById('filterStudentCategory').value
        };
        renderTables({ students: filter });
        bootstrap.Modal.getInstance(document.getElementById('studentsFilterModal')).hide();
      });
      attendanceFilterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;
        const filter = {
          name: document.getElementById('filterAttendanceName').value.trim(),
          batch: document.getElementById('filterAttendanceBatch').value.trim(),
          level: document.getElementById('filterAttendanceLevel').value,
          category: document.getElementById('filterAttendanceCategory').value
        };
        renderTables({ attendance: filter });
        bootstrap.Modal.getInstance(document.getElementById('attendanceFilterModal')).hide();
      });
      staffFilterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!validateForm(this)) return;
        const filter = {
          name: document.getElementById('filterStaffName').value.trim(),
          contact: document.getElementById('filterStaffContact').value.trim(),
          category: document.getElementById('filterStaffCategory').value
        };
        renderTables({ staff: filter });
        bootstrap.Modal.getInstance(document.getElementById('staffFilterModal')).hide();
      });
    }

    function setupAddStudentForm() {
      const addStudentForm = document.getElementById('addStudentForm');
      const addStudentModal = document.getElementById('addStudentModal');

      // Load Centers and Batches when the modal is shown
      $(addStudentModal).on('shown.bs.modal', function() {
        loadCenters('addStudentCenter');
        loadBatches('addStudentBatch');
        loadStudentNames('addStudentName');
      });

      addStudentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!validateForm(this)) return;
        const name = document.getElementById('addStudentName').value.trim();
        const contact = document.getElementById('addStudentContact').value.trim();
        const center = document.getElementById('addStudentCenter').value;
        const batch = document.getElementById('addStudentBatch').value;
        const level = document.getElementById('addStudentLevel').value;
        const category = document.getElementById('addStudentCategory').value;
        const id = name.toLowerCase().replace(/\s+/g, '');
        studentData[id] = { name, contact, center, batch, level, category };
        attendanceData[id] = { name, batch, level, category: category === 'Complete' ? 'Present' : 'Absent' };
        renderTables();
        bootstrap.Modal.getInstance(document.getElementById('addStudentModal')).hide();
        Swal.fire({
          icon: 'success',
          title: 'Student Added',
          text: 'Student added successfully!',
          timer: 1500,
          showConfirmButton: false
        });
      });
    }

    function setupEditStudentForm() {
      const editStudentForm = document.getElementById('editStudentForm');
      editStudentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!validateForm(this)) return;
        const id = document.getElementById('editStudentId').value;
        const name = document.getElementById('editStudentName').value.trim();
        const contact = document.getElementById('editStudentContact').value.trim();
        const center = document.getElementById('editStudentCenter').value.trim();
        const batch = document.getElementById('editStudentBatch').value.trim();
        const level = document.getElementById('editStudentLevel').value;
        const category = document.getElementById('editStudentCategory').value;
        studentData[id] = { name, contact, center, batch, level, category };
        attendanceData[id] = { name, batch, level, category: category === 'Complete' ? 'Present' : 'Absent' };
        renderTables();
        bootstrap.Modal.getInstance(document.getElementById('editStudentModal')).hide();
        Swal.fire({
          icon: 'success',
          title: 'Student Updated',
          text: 'Student updated successfully!',
          timer: 1500,
          showConfirmButton: false
        });
      });
    }

    function setupSidebarToggle() {
      const toggleBtn = document.querySelector('.sidebar-toggle');
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');

      if (toggleBtn && dashboardWrapper && sidebar && navbar) {
        toggleBtn.addEventListener('click', function() {
          if (window.innerWidth <= 768) {
            // Mobile behavior: toggle sidebar visibility
            sidebar.classList.toggle('active');
            const isHidden = sidebar.classList.contains('active');
            dashboardWrapper.classList.toggle('sidebar-hidden', isHidden);
            navbar.classList.toggle('sidebar-hidden', isHidden);
          } else {
            // Desktop behavior: minimize/maximize sidebar
            const isMinimized = sidebar.classList.toggle('minimized');
            dashboardWrapper.classList.toggle('minimized', isMinimized);
            navbar.classList.toggle('sidebar-minimized', isMinimized);
          }
        });
      }

      // Handle window resize
      window.addEventListener('resize', function() {
        const dashboardWrapper = document.getElementById('dashboardWrapper');
        const sidebar = document.getElementById('sidebar');
        const navbar = document.querySelector('.navbar');

        if (window.innerWidth <= 768) {
          // Mobile view
          if (sidebar.classList.contains('minimized')) {
            sidebar.classList.remove('minimized');
            dashboardWrapper.classList.remove('minimized');
            navbar.classList.remove('sidebar-minimized');
          }
          if (sidebar.classList.contains('active')) {
            dashboardWrapper.classList.add('sidebar-hidden');
            navbar.classList.add('sidebar-hidden');
          } else {
            dashboardWrapper.classList.remove('sidebar-hidden');
            navbar.classList.remove('sidebar-hidden');
          }
        } else {
          // Desktop view
          if (sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            dashboardWrapper.classList.remove('sidebar-hidden');
            navbar.classList.remove('sidebar-hidden');
          }
        }
      });
    }

    function initializeCharts() {
      const ctx = document.getElementById("studentChart");
      if (ctx) {
        new Chart(ctx, {
          type: "doughnut",
          data: {
            labels: ["Beginner", "Intermediate", "Advanced"],
            datasets: [{
              data: [30, 40, 30],
              backgroundColor: ["#ff6b6b", "#ffeb3b", "#4ecdc4"],
              borderWidth: 0,
              cutout: "75%"
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: function (context) {
                    return `${context.label}: ${context.parsed}%`;
                  }
                }
              }
            }
          }
        });
      }
    }

    function handleStatClick(statType) {
      Swal.fire({
        icon: 'info',
        title: `Clicked on ${statType.replace(/([A-Z])/g, ' $1').trim()}`
      });
    }

    function exportToExcel() {
      const students = Object.values(studentData).map(s => ({
        Name: s.name,
        Contact: s.contact,
        Center: s.center,
        Batch: s.batch,
        Level: s.level,
        Category: s.category
      }));
      const worksheet = XLSX.utils.json_to_sheet(students);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "Students");
      XLSX.writeFile(workbook, "students_data.xlsx");
    }

    function exportToPDF() {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();
      doc.setFontSize(16);
      doc.text('Students Data', 14, 20);
      const students = Object.values(studentData).map(s => [
        s.name,
        s.contact,
        s.center,
        s.batch,
        s.level,
        s.category
      ]);
      doc.autoTable({
        head: [['Name', 'Contact', 'Center', 'Batch', 'Level', 'Category']],
        body: students,
        startY: 30,
        styles: { fontSize: 10 },
        headStyles: { fillColor: [51, 51, 51], textColor: [255, 255, 255] },
        columnStyles: {
          0: { cellWidth: 40 },
          1: { cellWidth: 30 },
          2: { cellWidth: 25 },
          3: { cellWidth: 20 },
          4: { cellWidth: 25 },
          5: { cellWidth: 30 }
        }
      });
      doc.save('students_data.pdf');
    }

    function viewStudent(id) {
      const student = studentData[id];
      if (student) {
        const content = document.getElementById('viewStudentContent');
        content.innerHTML = `
          <p><strong>Name:</strong> ${student.name}</p>
          <p><strong>Contact:</strong> ${student.contact}</p>
          <p><strong>Center:</strong> ${student.center}</p>
          <p><strong>Batch:</strong> ${student.batch}</p>
          <p><strong>Level:</strong> ${student.level}</p>
          <p><strong>Category:</strong> ${student.category}</p>
        `;
      }
    }

    function editStudent(id) {
      const student = studentData[id];
      if (student) {
        document.getElementById('editStudentId').value = id;
        document.getElementById('editStudentName').value = student.name;
        document.getElementById('editStudentContact').value = student.contact;
        document.getElementById('editStudentCenter').value = student.center;
        document.getElementById('editStudentBatch').value = student.batch;
        document.getElementById('editStudentLevel').value = student.level;
        document.getElementById('editStudentCategory').value = student.category;
      }
    }

    function deleteStudent(id) {
      const student = studentData[id];
      if (!student) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Student not found!'
        });
        return;
      }
      Swal.fire({
        title: `Are you sure you want to delete ${student.name}?`,
        text: "This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          delete studentData[id];
          delete attendanceData[id];
          renderTables();
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Student has been deleted.',
            timer: 1500,
            showConfirmButton: false
          });
        }
      });
    }

    function viewAttendance(id) {
      const record = attendanceData[id];
      if (record) {
        Swal.fire({
          icon: 'info',
          title: 'Attendance Details',
          html: `
            <p><strong>Name:</strong> ${record.name}</p>
            <p><strong>Batch:</strong> ${record.batch}</p>
            <p><strong>Level:</strong> ${record.level}</p>
            <p><strong>Status:</strong> ${record.category}</p>
          `
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Attendance record not found!'
        });
      }
    }

    function viewStaff(id) {
      const staff = staffData[id];
      if (staff) {
        Swal.fire({
          icon: 'info',
          title: 'Staff Details',
          html: `
            <p><strong>Name:</strong> ${staff.name}</p>
            <p><strong>Contact:</strong> ${staff.contact}</p>
            <p><strong>Category:</strong> ${staff.category}</p>
          `
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Staff member not found!'
        });
      }
    }

    // Global function to handle sidebar toggle from external components
    window.toggleDashboard = function() {
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');
      if (dashboardWrapper && sidebar && navbar) {
        if (window.innerWidth <= 768) {
          sidebar.classList.toggle('active');
          navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
          dashboardWrapper.classList.toggle('sidebar-hidden', sidebar.classList.contains('active'));
        } else {
          const isMinimized = sidebar.classList.toggle('minimized');
          navbar.classList.toggle('sidebar-minimized', isMinimized);
          dashboardWrapper.classList.toggle('minimized', isMinimized);
        }
      }
    };
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
