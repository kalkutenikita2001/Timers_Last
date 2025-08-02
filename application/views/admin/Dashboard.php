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

    .filter-modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #1a1a1a;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
      z-index: 1000;
      color: #fff;
      width: 300px;
      max-height: 80vh;
      overflow-y: auto;
    }

    .filter-modal.active {
      display: block;
    }

    .filter-option {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #444;
      transition: background 0.2s ease;
      display: flex;
      align-items: center;
    }

    .filter-option:hover {
      background: #222;
    }

    .filter-option input[type="checkbox"] {
      margin-right: 10px;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }

    .modal-overlay.active {
      display: block;
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
        padding: 8px 16px;
        min-width: 120px;
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
        padding: 5px 12px;
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
      
      .students-table-container,
      .attendance-container,
      .staff-container,
      .chart-container {
        padding: 12px;
      }
      
      .action-btn {
        font-size: 11px;
        padding: 3px;
      }
      
      #studentChart {
        max-width: 100px !important;
        max-height: 100px !important;
      }
      
      .filter-modal {
        width: 250px;
      }
    }
    .btn1 {
      background: black;
      color: white;
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
      <div class="d-flex justify-content-center gap-3 my-4">
        <div class="bg-white px-3 py-2 rounded shadow-sm d-flex align-items-center">
          <button class="btn btn-sm btn-custom" onclick="exportToExcel()">
            <i class="bi bi-download me-1"></i> Export Excel
          </button>
        </div>
        <div class="bg-white px-3 py-2 rounded shadow-sm d-flex align-items-center">
          <button class="btn btn-sm btn-custom" onclick="exportToPDF()">
            <i class="bi bi-download me-1"></i> Export PDF
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
              <button class="filter-btn me-2" onclick="toggleFilterModal('students')">
                <i class="bi bi-funnel"></i> Filter
              </button>
              <button class="add-btn" onclick="addStudent()">
                Add Student
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
            <button class="filter-btn" onclick="toggleFilterModal('attendance')">
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
            <button class="filter-btn" onclick="toggleFilterModal('staff')">
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
              <span class="legend-color" style="background:#ff6b6b"></span> Intermediate (40%)
            </div>
            <div class="legend-item">
              <span class="legend-color" style="background:#4ecdc4"></span> Advanced (30%)
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal-overlay" id="modalOverlay" onclick="closeFilterModal()"></div>
  <div class="filter-modal" id="filterModal">
    <h6>Filter By</h6>
    <div class="filter-options">
      <div class="filter-option"><input type="checkbox" name="filter" value="Name"> Name</div>
      <div class="filter-option"><input type="checkbox" name="filter" value="Contact"> Contact</div>
      <div class="filter-option"><input type="checkbox" name="filter" value="Center"> Center</div>
      <div class="filter-option"><input type="checkbox" name="filter" value="Batch"> Batch</div>
      <div class="filter-option"><input type="checkbox" name="filter" value="Level"> Level</div>
      <div class="filter-option"><input type="checkbox" name="filter" value="Category"> Category</div>
      <button class="btn btn-sm btn-custom mt-3" onclick="applyMultiFilter()">Apply Filters</button>
    </div>
  </div>

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

    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
      renderTables();
    });

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
          return Object.entries(filter).every(([key, value]) => student[key.toLowerCase()] === value);
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
              <button class="action-btn view-btn" onclick="viewStudent('${id}')" title="View Student">
                <i class="bi bi-eye"></i>
              </button>
              <button class="action-btn edit-btn" onclick="editStudent('${id}')" title="Edit Student">
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
          return Object.entries(filter).every(([key, value]) => record[key.toLowerCase()] === value);
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
          return Object.entries(filter).every(([key, value]) => staff[key.toLowerCase()] === value);
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

    function setupSidebarToggle() {
      const toggleBtn = document.querySelector('.sidebar-toggle');
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      const sidebar = document.getElementById('sidebar');

      if (toggleBtn && dashboardWrapper && sidebar) {
        toggleBtn.addEventListener('click', function() {
          const isMinimized = sidebar.classList.toggle('minimized');
          dashboardWrapper.classList.toggle('minimized', isMinimized);
        });
      }

      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'class' && dashboardWrapper) {
            if (sidebar && sidebar.classList.contains('minimized')) {
              dashboardWrapper.classList.add('minimized');
            } else {
              dashboardWrapper.classList.remove('minimized');
            }
          }
        });
      });

      if (sidebar) {
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
      }
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
              backgroundColor: ["#ff6b6b", "yellow", "#4ecdc4"],
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
      alert(`Clicked on ${statType.replace(/([A-Z])/g, ' $1').trim()}`);
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
  try {
    // Ensure jsPDF and autoTable are available
    if (!window.jspdf || !window.jspdf.jsPDF) {
      alert('jsPDF library is not loaded properly.');
      return;
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Set document title
    doc.setFontSize(16);
    doc.text('Students Data', 14, 20);

    // Prepare data for the table
    const students = Object.values(studentData).map(s => [
      s.name,
      s.contact,
      s.center,
      s.batch,
      s.level,
      s.category
    ]);

    // Check if autoTable is available
    if (typeof doc.autoTable !== 'function') {
      alert('jsPDF autoTable plugin is not loaded properly.');
      return;
    }

    // Generate table
    doc.autoTable({
      head: [['Name', 'Contact', 'Center', 'Batch', 'Level', 'Category']],
      body: students,
      startY: 30,
      styles: { fontSize: 10 },
      headStyles: { fillColor: [51, 51, 51], textColor: [255, 255, 255] },
      columnStyles: {
        0: { cellWidth: 40 }, // Name
        1: { cellWidth: 30 }, // Contact
        2: { cellWidth: 25 }, // Center
        3: { cellWidth: 20 }, // Batch
        4: { cellWidth: 25 }, // Level
        5: { cellWidth: 30 }  // Category
      }
    });

    // Save the PDF
    doc.save('students_data.pdf');
  } catch (error) {
    console.error('Error exporting to PDF:', error);
    alert('An error occurred while exporting to PDF. Please check the console for details.');
  }
}

    // Student Action Functions
    function addStudent() {
      const name = prompt('Enter Student Name:');
      if (!name) return;
      
      const contact = prompt('Enter Student Contact:');
      if (!contact) return;
      
      const center = prompt('Enter Student Center:');
      if (!center) return;
      
      const batch = prompt('Enter Student Batch:');
      if (!batch) return;
      
      const level = prompt('Enter Student Level (Beginner/Intermediate/Advanced):');
      if (!level) return;
      
      const category = prompt('Enter Student Category (Complete/Pending):');
      if (!category) return;
      
      const id = name.toLowerCase().replace(/\s+/g, '');
      studentData[id] = { name, contact, center, batch, level, category };
      attendanceData[id] = { name, batch, level, category: category === 'Complete' ? 'Present' : 'Absent' };
      
      renderTables();
      alert('Student added successfully!');
    }

    function viewStudent(id) {
      const student = studentData[id];
      if (student) {
        const details = `
Student Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Name: ${student.name}
Contact: ${student.contact}
Center: ${student.center}
Batch: ${student.batch}
Level: ${student.level}
Category: ${student.category}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━`;
        alert(details);
      } else {
        alert('Student not found!');
      }
    }

    function editStudent(id) {
      const student = studentData[id];
      if (!student) {
        alert('Student not found!');
        return;
      }
      
      const newName = prompt('Edit Student Name:', student.name);
      if (newName === null) return;
      
      const newContact = prompt('Edit Student Contact:', student.contact);
      if (newContact === null) return;
      
      const newCenter = prompt('Edit Student Center:', student.center);
      if (newCenter === null) return;
      
      const newBatch = prompt('Edit Student Batch:', student.batch);
      if (newBatch === null) return;
      
      const newLevel = prompt('Edit Student Level:', student.level);
      if (newLevel === null) return;
      
      const newCategory = prompt('Edit Student Category:', student.category);
      if (newCategory === null) return;
      
      // Update student data
      studentData[id] = { 
        name: newName, 
        contact: newContact, 
        center: newCenter, 
        batch: newBatch, 
        level: newLevel, 
        category: newCategory 
      };
      
      // Update attendance data if exists
      if (attendanceData[id]) {
        attendanceData[id] = { 
          name: newName, 
          batch: newBatch, 
          level: newLevel, 
          category: newCategory === 'Complete' ? 'Present' : 'Absent' 
        };
      }
      
      renderTables();
      alert('Student updated successfully!');
    }

    function deleteStudent(id) {
      const student = studentData[id];
      if (!student) {
        alert('Student not found!');
        return;
      }
      
      const confirmation = confirm(`Are you sure you want to delete student "${student.name}"?\n\nThis action cannot be undone.`);
      if (confirmation) {
        delete studentData[id];
        delete attendanceData[id];
        renderTables();
        alert('Student deleted successfully!');
      }
    }

    // Attendance Action Functions
    function viewAttendance(id) {
      const record = attendanceData[id];
      if (record) {
        const details = `
Attendance Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Name: ${record.name}
Batch: ${record.batch}
Level: ${record.level}
Status: ${record.category}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━`;
        alert(details);
      } else {
        alert('Attendance record not found!');
      }
    }

    // Staff Action Functions
    function viewStaff(id) {
      const staff = staffData[id];
      if (staff) {
        const details = `
Staff Details:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Name: ${staff.name}
Contact: ${staff.contact}
Category: ${staff.category}
━━━━━━━━━━━━━━━━━━━━━━━━━━━━`;
        alert(details);
      } else {
        alert('Staff member not found!');
      }
    }

    // Filter Modal Functions
    function toggleFilterModal(section) {
      const modal = document.getElementById('filterModal');
      const overlay = document.getElementById('modalOverlay');
      modal.classList.add('active');
      overlay.classList.add('active');
      modal.dataset.section = section;

      // Reset checkboxes
      modal.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
      });
    }

    function closeFilterModal() {
      const modal = document.getElementById('filterModal');
      const overlay = document.getElementById('modalOverlay');
      modal.classList.remove('active');
      overlay.classList.remove('active');
    }

    function applyMultiFilter() {
      const section = document.getElementById('filterModal').dataset.section;
      const checkboxes = document.querySelectorAll('#filterModal input[type="checkbox"]:checked');
      if (checkboxes.length === 0) {
        alert('Please select at least one filter to apply.');
        return;
      }

      const filters = {};
      checkboxes.forEach(checkbox => {
        const value = prompt(`Enter value for ${checkbox.value}:`);
        if (value) {
          filters[checkbox.value.toLowerCase()] = value;
        }
      });

      if (Object.keys(filters).length > 0) {
        const allFilters = {};
        allFilters[section.toLowerCase()] = filters;
        renderTables(allFilters);
        alert(`Applied multi-filter on ${section} with: ${JSON.stringify(filters)}`);
      }
      closeFilterModal();
    }

    window.toggleDashboard = function() {
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      const sidebar = document.getElementById('sidebar');
      if (dashboardWrapper && sidebar) {
        const isMinimized = sidebar.classList.toggle('minimized');
        dashboardWrapper.classList.toggle('minimized', isMinimized);
      }
    };
    
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>