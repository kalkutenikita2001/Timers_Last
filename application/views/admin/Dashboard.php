<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.25/dist/jspdf.plugin.autotable.min.js"></script>
  <style>
    body {
      background-color: #f4f6f8 !important;
      color: #1a1a1a;
      font-family: 'Montserrat', serif;
      overflow-x: hidden;
    }

    .dashboard-wrapper {
      margin-left: 250px;
      padding: 24px;
      transition: all 0.3s ease-in-out;
      background-color: #f4f6f8;
    }

    .dashboard-wrapper.minimized {
      margin-left: 60px;
    }

    .dashboard-wrapper.sidebar-minimized,
    .dashboard-wrapper.sidebar-collapsed {
      margin-left: 60px;
    }

    .card-stat {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border-radius: 12px;
      text-align: left;
      height: 130px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      font-size: 14px;
      cursor: pointer;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      padding: 18px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .card-stat:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(255, 64, 64, 0.3);
    }

    .card-stat h4 {
      margin: 12px 0 4px;
      font-size: 26px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }

    .card-stat span {
      font-size: 14px;
      opacity: 0.9;
    }

    .card-icon {
      position: absolute;
      top: 12px;
      right: 12px;
      font-size: 26px;
      opacity: 0.6;
      transition: opacity 0.3s ease;
    }

    .card-stat:hover .card-icon {
      opacity: 0.8;
    }

    .btn-custom {
      font-size: 14px;
      background: linear-gradient(90deg, #e0e0e0, #d0d0d0);
      border: none;
      padding: 10px 20px;
      margin-right: 8px;
      color: #1a1a1a;
      font-weight: 600;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
      min-width: 140px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn-custom:hover {
      background: linear-gradient(90deg, #ff4040, #e63939);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(255, 64, 64, 0.3);
    }

    .btn-custom:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.2);
    }

    .chart-container {
      background: white;
      border-radius: 12px;
      padding: 24px;
      margin-bottom: 24px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }

    .chart-container:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .center-box {
      background: white;
      border-radius: 12px;
      padding: 24px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }

    .center-box:hover {
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .add-center-btn {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border: none;
      width: 100%;
      margin-top: 12px;
      padding: 12px;
      font-size: 14px;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .add-center-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(255, 64, 64, 0.3);
    }

    .add-center-btn:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.2);
    }

    .center-btn {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #333;
      padding: 10px 15px;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .center-btn:hover {
      background: #e9ecef;
      transform: translateX(6px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .center-btn:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.2);
    }

    .legend-item {
      display: flex;
      align-items: center;
      font-size: 13px;
      margin-top: 10px;
      color: #333;
    }

    .legend-color {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      margin-right: 8px;
    }

    .filter-btn {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      color: #333;
      padding: 6px 16px;
      border-radius: 6px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filter-btn:hover {
      background: #e9ecef;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .filter-btn:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.2);
    }

    .modal-content {
      border-radius: 12px;
      padding: 24px;
      border: 2px solid transparent;
      background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #ff4040, #470000) border-box;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      position: relative;
    }

    .modal-close-btn {
      position: absolute;
      top: 12px;
      right: 12px;
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

    .modal-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1a1a1a;
    }

    .form-label {
      font-weight: 600;
      color: #333;
      font-size: 14px;
    }

    .form-control {
      border-radius: 6px;
      border: 1px solid #ced4da;
      font-size: 14px;
      padding: 10px;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #ff4040;
      box-shadow: 0 0 6px rgba(255, 64, 64, 0.3);
      outline: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ff4040, #470000);
      border: none;
      border-radius: 6px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, #e63939, #360000);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(255, 64, 64, 0.3);
    }

    .btn-primary:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.2);
    }

    .btn-secondary {
      background: #6c757d;
      border: none;
      border-radius: 6px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-secondary:hover {
      background: #5a6268;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(108, 117, 125, 0.2);
    }

    h6 {
      font-weight: 700 !important;
      color: #1a1a1a;
      font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .dashboard-wrapper {
        margin-left: 0 !important;
        padding: 15px !important;
      }

      .card-stat {
        height: 110px;
      }

      .card-stat h4 {
        font-size: 22px;
      }

      .card-stat span {
        font-size: 12px;
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

      .modal-content {
        padding: 15px;
      }

      .modal-title {
        font-size: 1.3rem;
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
        height: 100px;
      }

      .card-stat h4 {
        font-size: 18px;
      }

      .card-stat span {
        font-size: 11px;
      }

      .modal-content {
        padding: 12px;
      }

      .modal-title {
        font-size: 1.2rem;
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
  </style>
</head>

<body>
  <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>
  <!-- Dashboard Content -->
  <div class="dashboard-wrapper" id="dashboardWrapper">
    .
    <div class="container-fluid px-3">
      <!-- Stats Cards -->
      <div class="row g-3 mb-4 text-center">
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('activeStudents')">
            <i class="bi bi-person-lines-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4><?php echo $active_students; ?></h4>
              <span>Active Students</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('attendanceRate')">
            <i class="bi bi-person-check-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4><?php echo $attendance_rate; ?>%</h4>
              <span>Attendance Rate</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('feeDefaulters')">
            <i class="bi bi-currency-rupee card-icon"></i>
            <div class="d-flex flex-column">
              <h4><?php echo $fee_defaulters; ?></h4>
              <span>Fee Defaulters</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="handleStatClick('monthlyProfits')">
            <i class="bi bi-bar-chart-line-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4>Rs.<?php echo number_format($monthly_profits, 0); ?></h4>
              <span>Monthly profits</span>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center gap-3 my-4">
        <div class="bg-gray px-3 py-2 rounded d-flex align-items-center">
          <button class="btn btn-sm btn-custom" onclick="exportToExcel()">
            <i class="bi bi-download me-1"></i> Export Excel
          </button>
        </div>
        <div class="bg-gray px-3 py-2 rounded d-flex align-items-center">
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
            <button class="add-center-btn mt-4" data-bs-toggle="modal" data-bs-target="#addCenterModal">
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

  <!-- Add Center Modal -->
  <div class="modal fade" id="addCenterModal" tabindex="-1" aria-labelledby="addCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h5 class="modal-title" id="addCenterModalLabel">Add New Center</h5>
        <div class="modal-body">
          <form id="addCenterForm">
            <div class="mb-3">
              <label for="centerName" class="form-label">Center Name</label>
              <input type="text" class="form-control" id="centerName" required>
            </div>
            <div class="mb-3">
              <label for="centerLocation" class="form-label">Location</label>
              <input type="text" class="form-control" id="centerLocation" required>
            </div>
            <div class="mb-3">
              <label for="centerCapacity" class="form-label">Capacity</label>
              <input type="number" class="form-control" id="centerCapacity" required>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitCenterForm()">Save Center</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Center Modal -->
  <div class="modal fade" id="editCenterModal" tabindex="-1" aria-labelledby="editCenterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h5 class="modal-title" id="editCenterModalLabel">Edit Center</h5>
        <div class="modal-body">
          <form id="editCenterForm">
            <div class="mb-3">
              <label for="editCenterName" class="form-label">Center Name</label>
              <input type="text" class="form-control" id="editCenterName" required>
            </div>
            <div class="mb-3">
              <label for="editCenterLocation" class="form-label">Location</label>
              <input type="text" class="form-control" id="editCenterLocation" required>
            </div>
            <div class="mb-3">
              <label for="editCenterCapacity" class="form-label">Capacity</label>
              <input type="number" class="form-control" id="editCenterCapacity" required>
            </div>
            <input type="hidden" id="editCenterId">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitEditCenterForm()">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
      setupModalBlur();
    });

    function setupSidebarToggle() {
      const toggleBtn = document.querySelector('.sidebar-toggle');
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      if (toggleBtn && dashboardWrapper) {
        toggleBtn.addEventListener('click', function() {
          dashboardWrapper.classList.toggle('minimized');
        });
      }

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

      const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
          if (mutation.type === 'class') {
            const sidebar = document.querySelector('.sidebar, #sidebar, .main-sidebar');
            const dashboardWrapper = document.getElementById('dashboardWrapper');
            if (sidebar && dashboardWrapper) {
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

      const sidebar = document.querySelector('.sidebar, #sidebar, .main-sidebar');
      if (sidebar) {
        observer.observe(sidebar, {
          attributes: true,
          attributeFilter: ['class']
        });
      }
    }

    function setupModalBlur() {
      const modals = ['addCenterModal', 'editCenterModal'];
      modals.forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
          modalEl.addEventListener('show.bs.modal', () => {
            document.querySelector('.container-fluid').classList.add('blur');
          });
          modalEl.addEventListener('hidden.bs.modal', () => {
            document.querySelector('.container-fluid').classList.remove('blur');
          });
        }
      });
    }

    function initializeCharts() {
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
            legend: {
              display: false
            },
            tooltip: {
              enabled: true
            }
          },
          scales: {
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            },
            y: {
              beginAtZero: true,
              max: 110,
              grid: {
                display: false
              },
              ticks: {
                stepSize: 25,
                font: {
                  size: 12
                }
              }
            }
          }
        }
      });

      new Chart(document.getElementById("revenueChart"), {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug"],
          datasets: [{
            label: "Revenue",
            data: [20000, 25000, 30000, 40000, 37000, 42000, 38000, 35000],
            borderColor: "#ff4040",
            tension: 0.3,
            fill: false,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                color: "#f0f0f0"
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            },
            x: {
              grid: {
                display: false
              },
              ticks: {
                font: {
                  size: 12
                }
              }
            }
          }
        }
      });

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
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return `${context.label}: ${context.parsed}%`;
                }
              }
            }
          }
        }
      });
    }

    function handleStatClick(statType) {
      console.log(`Clicked on ${statType}`);
      alert(`You clicked on ${statType.replace(/([A-Z])/g, ' $1').toLowerCase()}`);
    }

    function exportToExcel() {
      const data = [
        ["Name", "Contact", "Center", "Batch", "Level", "Category"],
        ["Jane Doe", "9876543210", "ABC", "B1", "Intermediate", "Complete"],
        ["John Smith", "9876543211", "XYZ", "B2", "Advanced", "Pending"],
        ["Sarah Wilson", "9876543212", "PQR", "B3", "Beginner", "Complete"],
        ["Emma Brown", "9876543213", "DEF", "B4", "Intermediate", "Pending"],
        ["Michael Lee", "9876543214", "GHI", "B5", "Advanced", "Complete"]
      ];

      const ws = XLSX.utils.aoa_to_sheet(data);
      const wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Students Data");
      XLSX.writeFile(wb, "Students_Data_Export.xlsx");
    }

    function exportToPDF() {
      const {
        jsPDF
      } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(18);
      doc.text("Students Data", 14, 15);

      doc.autoTable({
        head: [
          ["Name", "Contact", "Center", "Batch", "Level", "Category"]
        ],
        body: [
          ["Jane Doe", "9876543210", "ABC", "B1", "Intermediate", "Complete"],
          ["John Smith", "9876543211", "XYZ", "B2", "Advanced", "Pending"],
          ["Sarah Wilson", "9876543212", "PQR", "B3", "Beginner", "Complete"],
          ["Emma Brown", "9876543213", "DEF", "B4", "Intermediate", "Pending"],
          ["Michael Lee", "9876543214", "GHI", "B5", "Advanced", "Complete"]
        ],
        startY: 25
      });

      doc.save("Students_Data_Export.pdf");
    }

    function filterAttendance() {
      console.log('Opening attendance filter...');
      alert('Attendance filter functionality would be implemented here');
    }

    function selectCenter(centerId) {
      // Dummy data for demonstration (replace with actual data retrieval logic)
      const centerData = {
        center1: {
          name: "Center 1",
          location: "Mumbai",
          capacity: 100
        },
        center2: {
          name: "Center 2",
          location: "Delhi",
          capacity: 150
        },
        center3: {
          name: "Center 3",
          location: "Bangalore",
          capacity: 120
        },
        center4: {
          name: "Center 4",
          location: "Chennai",
          capacity: 80
        }
      };

      const data = centerData[centerId] || {
        name: centerId,
        location: "Unknown",
        capacity: 100
      };
      document.getElementById('editCenterName').value = data.name;
      document.getElementById('editCenterLocation').value = data.location;
      document.getElementById('editCenterCapacity').value = data.capacity;
      document.getElementById('editCenterId').value = centerId;

      const modal = new bootstrap.Modal(document.getElementById('editCenterModal'));
      modal.show();
    }

    function submitCenterForm() {
      const centerName = document.getElementById('centerName').value;
      const centerLocation = document.getElementById('centerLocation').value;
      const centerCapacity = document.getElementById('centerCapacity').value;

      if (centerName && centerLocation && centerCapacity) {
        alert(`Center "${centerName}" added successfully!`);
        const modal = bootstrap.Modal.getInstance(document.getElementById('addCenterModal'));
        modal.hide();
      } else {
        alert('Please fill in all fields.');
      }
    }

    function submitEditCenterForm() {
      const centerName = document.getElementById('editCenterName').value;
      const centerLocation = document.getElementById('editCenterLocation').value;
      const centerCapacity = document.getElementById('editCenterCapacity').value;
      const centerId = document.getElementById('editCenterId').value;

      if (centerName && centerLocation && centerCapacity) {
        alert(`Center "${centerName}" updated successfully!`);
        const modal = bootstrap.Modal.getInstance(document.getElementById('editCenterModal'));
        modal.hide();
      } else {
        alert('Please fill in all fields.');
      }
    }

    function toggleDashboard() {
      const dashboardWrapper = document.getElementById('dashboardWrapper');
      if (dashboardWrapper) {
        dashboardWrapper.classList.toggle('minimized');
      }
    }

    window.toggleDashboard = toggleDashboard;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('studentChart').getContext('2d');
    const studentChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Basic', 'Intermediate', 'Advanced'],
        datasets: [{
          data: [
            <?= $studentDistribution['Basic'] ?? 0 ?>,
            <?= $studentDistribution['Intermediate'] ?? 0 ?>,
            <?= $studentDistribution['Advanced'] ?? 0 ?>
          ],
          backgroundColor: ['#990000', '#000000', '#f4b6b6']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  </script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');

    // Create gradient
    const gradient = revenueCtx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#ff4040'); // top color
    gradient.addColorStop(1, '#470000'); // bottom color

    const revenueChart = new Chart(revenueCtx, {
      type: 'line',
      data: {
        labels: [
          <?php foreach ($monthlyRevenue as $row) {
            echo "'" . $row['month'] . "',";
          } ?>
        ],
        datasets: [{
          label: 'Revenue',
          data: [
            <?php foreach ($monthlyRevenue as $row) {
              echo $row['revenue'] . ",";
            } ?>
          ],
          fill: true,
          borderColor: '#ff4040',
          backgroundColor: gradient,
          tension: 0.3,
          borderWidth: 2,
          pointBackgroundColor: '#470000',
          pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>