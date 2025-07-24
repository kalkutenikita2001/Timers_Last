<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
       background-color: #e9ecef !important;
      color: #000;
      font-family: 'Montserrat', serif;
      overflow-x: hidden;
    }
    .dashboard-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s ease-in-out;
    }
    .dashboard-wrapper.minimized {
      margin-left: 60px;
    }
    
    /* Additional sidebar states */
    .dashboard-wrapper.sidebar-minimized {
      margin-left: 60px;
    }
    
    .dashboard-wrapper.sidebar-collapsed {
      margin-left: 60px;
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
    .btn-custom {
      font-size: 14px;
      background-color: #D9D9D9;
      border: none;
      padding: 10px 20px;
      margin-right: 8px;
      color: black;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
      min-width: 140px;
    }
    .btn-custom:hover {
      background-color: #ff4040;
      color: white;
      transform: translateY(-1px);
    }
    .chart-container {
      background: white;
      border-radius: 10px;
      padding: 37px;
      margin-bottom: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .center-box {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }
    .add-center-btn {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border: none;
      width: 100%;
      margin-top: 10px;
      padding: 10px;
      font-size: 14px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-weight: 600;
    }
    .add-center-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(255, 64, 64, 0.3);
    }
    .center-btn {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #333;
      padding: 10px 15px;
      border-radius: 5px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .center-btn:hover {
      background: #e9ecef;
      transform: translateX(5px);
    }
    .legend-item {
      display: flex;
      align-items: center;
      font-size: 12px;
      margin-top: 8px;
    }
    .legend-color {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin-right: 8px;
    }
    .filter-btn {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #333;
      padding: 5px 15px;
      border-radius: 5px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s ease;
    }
    .filter-btn:hover {
      background: #e9ecef;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .dashboard-wrapper {
        margin-left: 0 !important;
        padding: 15px !important;
      }
      .card-stat {
        height: 100px;
      }
      .card-stat h4 {
        font-size: 20px;
      }
      .btn-custom {
        font-size: 12px;
        padding: 8px 16px;
        min-width: 120px;
      }
      .chart-container {
        padding: 15px;
      }
      .center-box {
        padding: 15px;
      }
    }
    
    @media (max-width: 576px) {
      .btn-custom {
        font-size: 11px;
        padding: 6px 12px;
        min-width: 100px;
        margin-bottom: 5px;
      }
      .card-stat {
        height: 90px;
      }
      .card-stat h4 {
        font-size: 18px;
      }
      .card-stat span {
        font-size: 11px;
      }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
      .dashboard-wrapper {
        margin-left: 200px;
      }
      .dashboard-wrapper.minimized {
        margin-left: 60px;
      }
    }
    h6{
      font-weight: 1000 !important;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- Dashboard Content -->
  <div class="dashboard-wrapper" id="dashboardWrapper">
    <div class="container-fluid px-3">
      <!-- Stats Cards -->
      <div class="row g-3 mb-4 text-center">
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('activeStudents')">
            <div class="d-flex justify-content-between align-items-center px-2">
              <div class="text-start">
                <h4>2450</h4>
                <span>Active Students</span>
              </div>
              <i class="bi bi-person-lines-fill fs-3 opacity-50"></i>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('attendanceRate')">
            <div class="d-flex justify-content-between align-items-center px-2">
              <div class="text-start">
                <h4>85%</h4>
                <span>Attendance Rate</span>
              </div>
              <i class="bi bi-person-check-fill fs-3 opacity-50"></i>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('feeDefaulters')">
            <div class="d-flex justify-content-between align-items-center px-2">
              <div class="text-start">
                <h4>2450</h4>
                <span>Fee Defaulters</span>
              </div>
              <i class="bi bi-currency-rupee fs-3 opacity-50"></i>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('monthlyProfits')">
            <div class="d-flex justify-content-between align-items-center px-2">
              <div class="text-start">
                <h4>Rs.42450</h4>
                <span>Monthly profits</span>
              </div>
              <i class="bi bi-bar-chart-line-fill fs-3 opacity-50"></i>
            </div>
          </div>
        </div>
      </div>

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




      <!-- Charts & Side Panel -->
      <div class="row">
        <div class="col-lg-9">
          <!-- Weekly Attendance -->
          <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Weekly Attendance</h6>
              <button class="btn filter-btn" onclick="filterAttendance()">Filter</button>
            </div>
            <canvas id="attendanceChart" height="100"></canvas>
          </div>

          <!-- Revenue Overview -->
          <div class="chart-container">
            <h6>Revenue Overview</h6>
            <canvas id="revenueChart" height="100"></canvas>
          </div>
        </div>

        <!-- Right Sidebar Panels -->
        <div class="col-lg-3">
          <!-- Center List -->
          <div class="center-box mb-3" style="background: #f0eaea;">
            <h6 class="fw-bold text-start">Centers</h6>
            <div class="d-grid gap-2 mt-3">
              <button class="btn center-btn text-start" onclick="selectCenter('center1')">
                <i class="bi bi-house-door-fill me-2"></i> Center 1
              </button>
              <button class="btn center-btn text-start" onclick="selectCenter('center2')">
                <i class="bi bi-building-fill-check me-2"></i> Center 2
              </button>
              <button class="btn center-btn text-start" onclick="selectCenter('center3')">
                <i class="bi bi-geo-alt-fill me-2"></i> Center 3
              </button>
              <button class="btn center-btn text-start" onclick="selectCenter('center4')">
                <i class="bi bi-diagram-3-fill me-2"></i> Center 4
              </button>
            </div>
            <button class="add-center-btn mt-4" onclick="addNewCenter()">
              <i class="bi bi-plus-circle me-2"></i> Add Center
            </button>
          </div>

          <!-- Student Distribution -->
          <div class="center-box">
            <h6>Student Distribution</h6>
            <canvas id="studentChart" height="180"></canvas>
            <div class="mt-3">
              <div class="legend-item"><span class="legend-color" style="background:#990000"></span> Basic</div>
              <div class="legend-item"><span class="legend-color" style="background:#000000"></span> Intermediate</div>
              <div class="legend-item"><span class="legend-color" style="background:#f4b6b6"></span> Advanced</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
    });

    function setupSidebarToggle() {
      // Listen for sidebar toggle events
      const toggleBtn = document.querySelector('.sidebar-toggle');
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      
      // Check if elements exist
      if (toggleBtn && dashboardWrapper) {
        toggleBtn.addEventListener('click', function() {
          // Toggle dashboard wrapper class
          dashboardWrapper.classList.toggle('minimized');
        });
      }
      
      // Alternative: Listen for custom events if your sidebar uses them
      document.addEventListener('sidebarToggle', function(e) {
        const dashboardWrapper = document.getElementById('dashboardWrapper');
        if (dashboardWrapper) {
          if (e.detail && e.detail.minimized) {
            dashboardWrapper.classList.add('minimized');
          } else {
            dashboardWrapper.classList.remove('minimized');
          }
        }
      });
      
      // Alternative: Monitor sidebar state changes
      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'class') {
            const sidebar = document.querySelector('.sidebar, #sidebar, .main-sidebar');
            const dashboardWrapper = document.getElementById('dashboardWrapper');
            
            if (sidebar && dashboardWrapper) {
              // Check if sidebar has minimized/collapsed class
              if (sidebar.classList.contains('minimized') || 
                  sidebar.classList.contains('collapsed') ||
                  sidebar.classList.contains('sidebar-collapse')) {
                dashboardWrapper.classList.add('minimized');
              } else {
                dashboardWrapper.classList.remove('minimized');
              }
            }
          }
        });
      });
      
      // Start observing sidebar for class changes
      const sidebar = document.querySelector('.sidebar, #sidebar, .main-sidebar');
      if (sidebar) {
        observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
      }
    }

    function initializeCharts() {
      // Weekly Attendance Chart
      const ctx = document.getElementById("attendanceChart").getContext("2d");
      const gradient = ctx.createLinearGradient(0, 0, 0, 200);
      gradient.addColorStop(0, "#D9D9D9");
      gradient.addColorStop(0.5, "#ff4040");
      gradient.addColorStop(1, "#470000");

      new Chart(ctx, {
        type: "bar",
        data: {
          labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
          datasets: [{
            label: "Attendance",
            data: [90, 85, 75, 92, 80, 85, 90],
            backgroundColor: gradient,
            borderRadius: 10,
            barThickness: 30
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
          },
          scales: {
            x: {
              grid: { display: false },
              ticks: { font: { size: 12 } }
            },
            y: {
              beginAtZero: true,
              max: 110,
              grid: { display: false },
              ticks: {
                stepSize: 25,
                font: { size: 12 }
              }
            }
          }
        }
      });

      // Revenue Chart
      new Chart(document.getElementById("revenueChart"), {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
          datasets: [{
            label: "Revenue",
            data: [20000, 25000, 30000, 40000, 37000, 42000, 38000, 35000],
            borderColor: "#ff4040",
            tension: 0.3,
            fill: false
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { display: false }},
          scales: { y: { beginAtZero: true } }
        }
      });

      // Student Distribution Chart
      new Chart(document.getElementById("studentChart"), {
        type: "doughnut",
        data: {
          labels: ["Basic", "Intermediate", "Advanced"],
          datasets: [{
            data: [33, 33, 34],
            backgroundColor: ["#990000", "#000000", "#f4b6b6"],
            borderRadius: 8,
            borderWidth: 3,
            borderColor: "#f0eaea",
            cutout: "70%"
          }]
        },
        options: {
          responsive: true,
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

    // Click handlers
    function handleStatClick(statType) {
      console.log(`Clicked on ${statType}`);
      alert(`You clicked on ${statType.replace(/([A-Z])/g, ' $1').toLowerCase()}`);
    }

    function exportToExcel() {
      console.log('Exporting to Excel...');
      alert('Excel export functionality would be implemented here');
    }

    function exportToPDF() {
      console.log('Exporting to PDF...');
      alert('PDF export functionality would be implemented here');
    }

    function filterAttendance() {
      console.log('Opening attendance filter...');
      alert('Attendance filter functionality would be implemented here');
    }

    function selectCenter(centerId) {
      console.log(`Selected center: ${centerId}`);
      alert(`You selected ${centerId}`);
    }

    // Manual toggle function (call this from your sidebar toggle button)
    function toggleDashboard() {
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      if (dashboardWrapper) {
        dashboardWrapper.classList.toggle('minimized');
      }
    }
    
    // Expose function globally so it can be called from sidebar
    window.toggleDashboard = toggleDashboard;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>