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
  <style>
    body {
      background-color: #e9ecef !important;
      color: #fff;
      font-family: 'Montserrat', sans-serif; /* Corrected to sans-serif as per font import */
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
    
    /* Additional sidebar states */
    .dashboard-wrapper.sidebar-minimized {
      margin-left: 60px;
      max-width: calc(100vw - 60px);
    }
    
    .dashboard-wrapper.sidebar-collapsed {
      margin-left: 60px;
      max-width: calc(100vw - 60px);
    }

    /* Container Fluid */
    .container-fluid {
      max-width: 100%;
      margin: 0 auto;
      overflow-x: hidden;
      padding: 0 15px;
    }

    /* Top Stats Cards */
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
      transition: transform 0.2s ease;
    }
    .card-stat:hover {
      transform: translateY(-2px);
    }
    .card-stat h4 {
      margin: 0;
      font-size: 24px;
      font-weight: 700;
    }
    .card-stat span {
      font-size: 13px;
    }

    /* Export Buttons */
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
    }

    .btn-custom:hover {
      background-color: #333;
      color: white;
      transform: translateY(-1px);
    }

    /* Main Content Grid */
    .main-content {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      margin-bottom: 20px;
      width: 100%;
      max-width: 100%;
    }

    /* Recently Added Students Table */
    .students-table-container {
      /* background: #1a1a1a; */
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
    }

    .filter-btn:hover, .add-btn:hover {
      background: #444;
    }

    .add-btn {
      background: #ff4040;
      color: white;
      border-color: #ff4040;
    }

    .add-btn:hover {
      background: #cc3333;
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
      background-color: #fff; /* Changed to white background */
      color: #000; /* Changed text color to black for readability */
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
      color: #fff; /* Header text remains white */
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
      border-bottom: 1px solid #ddd; /* Lighter border for white background */
      font-size: 11px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .students-table tr:hover {
      background: #f5f5f5; /* Light gray hover for white table */
    }

    .action-icons {
      display: flex;
      gap: 5px;
      justify-content: flex-start;
    }

    .action-icons i {
      cursor: pointer;
      padding: 4px;
      border-radius: 3px;
      transition: all 0.2s ease;
      font-size: 12px;
      color: black;
    }

    .action-icons .bi-eye:hover {
      background: #007bff;
      color: white;
    }

    .action-icons .bi-pencil:hover {
      background: #28a745;
      color: white;
    }

    .action-icons .bi-trash:hover {
      background: #dc3545;
      color: white;
    }

    /* Bottom Grid Layout */
    .bottom-grid {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 20px;
      width: 100%;
      max-width: 100%;
    }

    /* Student Attendance & Staff Sections */
    .attendance-container, .staff-container {
      /* background: #1a1a1a; */
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
      background-color: #fff; /* Changed to white background */
      color: #000; /* Changed text color to black for readability */
    }

    .attendance-table th, .staff-table th {
      background: #333;
      padding: 8px 6px;
      text-align: left;
      border-bottom: 1px solid #444;
      font-weight: 600;
      white-space: nowrap;
      font-size: 10px;
      color: #fff; /* Header text remains white */
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
      border-bottom: 1px solid #ddd; /* Lighter border for white background */
      font-size: 10px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .attendance-table tr:hover, .staff-table tr:hover {
      background: #f5f5f5; /* Light gray hover for white table */
    }

    /* Total Students Donut Chart */
    .chart-container {
      /* background: #1a1a1a; */
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

    /* Filter Modal */
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
    }

    .filter-option:hover {
      background: #222;
    }

    /* Overlay for modal */
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

    /* Status badges */
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

    /* Responsive Design */
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
      
      .action-icons i {
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
    .btn1{
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
        <div class="card-stat" onclick="handleStatClick('totalStudents')">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>2450</h4>
              <span>Total Students</span>
            </div>
            <i class="bi bi-person-lines-fill fs-3 opacity-50"></i>
          </div>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalBranches')">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>25</h4>
              <span>Total Branches</span>
            </div>
            <i class="bi bi-building fs-3 opacity-50"></i>
          </div>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalRevenue')">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>Rs.50000</h4>
              <span>Total Revenue</span>
            </div>
            <i class="bi bi-currency-rupee fs-3 opacity-50"></i>
          </div>
        </div>
        <div class="card-stat" onclick="handleStatClick('totalExpense')">
          <div class="d-flex justify-content-between align-items-center px-2">
            <div class="text-start">
              <h4>Rs.3000</h4>
              <span>Total Expense</span>
            </div>
            <i class="bi bi-graph-down fs-3 opacity-50"></i>
          </div>
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
              <tbody>
                <tr>
                  <td>Jane Doe</td>
                  <td>9876543210</td>
                  <td>ABC</td>
                  <td>B1</td>
                  <td>Intermediate</td>
                  <td><span class="status-badge status-complete">Complete</span></td>
                  <td>
                    <div class="action-icons">
                      <i class="bi bi-eye" onclick="viewStudent('jane')"></i>
                      <i class="bi bi-pencil" onclick="editStudent('jane')"></i>
                      <i class="bi bi-trash" onclick="deleteStudent('jane')"></i>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>John Smith</td>
                  <td>9876543211</td>
                  <td>XYZ</td>
                  <td>B2</td>
                  <td>Advanced</td>
                  <td><span class="status-badge status-intermediate">Pending</span></td>
                  <td>
                    <div class="action-icons">
                      <i class="bi bi-eye" onclick="viewStudent('john')"></i>
                      <i class="bi bi-pencil" onclick="editStudent('john')"></i>
                      <i class="bi bi-trash" onclick="deleteStudent('john')"></i>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Sarah Wilson</td>
                  <td>9876543212</td>
                  <td>PQR</td>
                  <td>B3</td>
                  <td>Beginner</td>
                  <td><span class="status-badge status-complete">Complete</span></td>
                  <td>
                    <div class="action-icons">
                      <i class="bi bi-eye" onclick="viewStudent('sarah')"></i>
                      <i class="bi bi-pencil" onclick="editStudent('sarah')"></i>
                      <i class="bi bi-trash" onclick="deleteStudent('sarah')"></i>
                    </div>
                  </td>
                </tr>
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
              <tbody>
                <tr>
                  <td>Jane Doe</td>
                  <td>B1</td>
                  <td>Basic</td>
                  <td><span class="status-badge status-complete">Present</span></td>
                  <td><i class="bi bi-eye" onclick="viewAttendance('jane')"></i></td>
                </tr>
                <tr>
                  <td>John Smith</td>
                  <td>B2</td>
                  <td>Advanced</td>
                  <td><span class="status-badge status-intermediate">Absent</span></td>
                  <td><i class="bi bi-eye" onclick="viewAttendance('john')"></i></td>
                </tr>
                <tr>
                  <td>Sarah Wilson</td>
                  <td>B3</td>
                  <td>Intermediate</td>
                  <td><span class="status-badge status-complete">Present</span></td>
                  <td><i class="bi bi-eye" onclick="viewAttendance('sarah')"></i></td>
                </tr>
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
              <tbody>
                <tr>
                  <td>Alice Johnson</td>
                  <td>9876543213</td>
                  <td>Coordinator</td>
                  <td><i class="bi bi-eye" onclick="viewStaff('alice')"></i></td>
                </tr>
                <tr>
                  <td>Bob Brown</td>
                  <td>9876543214</td>
                  <td>Admin</td>
                  <td><i class="bi bi-eye" onclick="viewStaff('bob')"></i></td>
                </tr>
                <tr>
                  <td>Carol Davis</td>
                  <td>9876543215</td>
                  <td>Coach</td>
                  <td><i class="bi bi-eye" onclick="viewStaff('carol')"></i></td>
                </tr>
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
    <div class="filter-option" onclick="applyFilter('Name')">Name</div>
    <div class="filter-option" onclick="applyFilter('Contact')">Contact</div>
    <div class="filter-option" onclick="applyFilter('Center')">Center</div>
    <div class="filter-option" onclick="applyFilter('Batch')">Batch</div>
    <div class="filter-option" onclick="applyFilter('Level')">Level</div>
    <div class="filter-option" onclick="applyFilter('Category')">Category</div>
    <div class="filter-option" onclick="applyFilter('Action')">Action</div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
    });

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
              backgroundColor: ["#ff6b6b", "#ff6b6b", "#4ecdc4"],
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
      console.log(`Clicked on ${statType}`);
    }

    function exportToExcel() {
      console.log('Exporting to Excel...');
      alert('Excel export functionality would be implemented here');
    }

    function exportToPDF() {
      console.log('Exporting to PDF...');
      alert('PDF export functionality would be implemented here');
    }

    function addStudent() {
      console.log('Adding new student...');
    }

    function viewStudent(id) {
      const studentData = {
        jane: { name: 'Jane Doe', contact: '9876543210', center: 'ABC', batch: 'B1', level: 'Intermediate', category: 'Complete' },
        john: { name: 'John Smith', contact: '9876543211', center: 'XYZ', batch: 'B2', level: 'Advanced', category: 'Pending' },
        sarah: { name: 'Sarah Wilson', contact: '9876543212', center: 'PQR', batch: 'B3', level: 'Beginner', category: 'Complete' }
      };
      
      const student = studentData[id];
      if (student) {
        alert(`Student Details:\nName: ${student.name}\nContact: ${student.contact}\nCenter: ${student.center}\nBatch: ${student.batch}\nLevel: ${student.level}\nCategory: ${student.category}`);
      }
    }

    function editStudent(id) {
      const studentData = {
        jane: { name: 'Jane Doe', contact: '9876543210', center: 'ABC', batch: 'B1', level: 'Intermediate', category: 'Complete' },
        john: { name: 'John Smith', contact: '9876543211', center: 'XYZ', batch: 'B2', level: 'Advanced', category: 'Pending' },
        sarah: { name: 'Sarah Wilson', contact: '9876543212', center: 'PQR', batch: 'B3', level: 'Beginner', category: 'Complete' }
      };
      
      const student = studentData[id];
      if (student) {
        const newName = prompt(`Edit Student Name:`, student.name);
        const newContact = prompt(`Edit Student Contact:`, student.contact);
        const newCenter = prompt(`Edit Student Center:`, student.center);
        const newBatch = prompt(`Edit Student Batch:`, student.batch);
        const newLevel = prompt(`Edit Student Level:`, student.level);
        
        if (newName && newContact && newCenter && newBatch && newLevel) {
          alert(`Student Updated Successfully!\nName: ${newName}\nContact: ${newContact}\nCenter: ${newCenter}\nBatch: ${newBatch}\nLevel: ${newLevel}`);
        }
      }
    }

    function deleteStudent(id) {
      if (confirm(`Are you sure you want to delete ${id}?`)) {
        console.log(`Deleted student: ${id}`);
      }
    }

    function viewAttendance(id) {
      console.log(`Viewing attendance: ${id}`);
    }

    function viewStaff(id) {
      console.log(`Viewing staff: ${id}`);
    }

    function toggleFilterModal(section) {
      const modal = document.getElementById('filterModal');
      const overlay = document.getElementById('modalOverlay');
      modal.classList.add('active');
      overlay.classList.add('active');

      // Store the section for filter application
      modal.dataset.section = section;
    }

    function closeFilterModal() {
      const modal = document.getElementById('filterModal');
      const overlay = document.getElementById('modalOverlay');
      modal.classList.remove('active');
      overlay.classList.remove('active');
    }

    function applyFilter(field) {
      const section = document.getElementById('filterModal').dataset.section;
      console.log(`Applying filter on ${section} by ${field}`);
      closeFilterModal();
      // Here you would typically implement filtering logic based on the field
      alert(`Filter applied on ${section} by ${field}. (Implement backend logic here)`);
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>