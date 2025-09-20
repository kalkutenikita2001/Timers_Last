<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <!-- <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>"> -->
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
  

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.25/dist/jspdf.plugin.autotable.min.js"></script>
  <style>
    /* --- your styles (unchanged except a few additions for carousel) --- */
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
      background: #ffffff;
      border: 1px solid #e0e0e0;
      color: #1a1a1a;
      padding: 12px 16px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 600;
      text-align: left;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
      position: relative;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      min-width: 200px;
    }

    .center-btn:hover {
      background: linear-gradient(135deg, rgba(255, 245, 245, 1), #ffecec);
      border-color: #ff4040;
      transform: translateX(4px);
      box-shadow: 0 4px 10px rgba(255, 64, 64, 0.2);
    }

    .center-btn i {
      color: #ff4040;
      font-size: 18px;
      flex-shrink: 0;
    }

    .center-btn:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 64, 64, 0.25);
    }

    /* Left Accent Bar */
    .center-btn::before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 5px;
      background: #ff4040;
      opacity: 0;
      transition: opacity 0.3s ease;
      border-radius: 8px 0 0 8px;
    }

    .center-btn:hover::before {
      opacity: 1;
    }

    /* Selected center highlight */
    .center-btn.selected-center {
      background: linear-gradient(135deg, rgba(255, 64, 64, 0.08), rgba(255, 64, 64, 0.03));
      border-color: #ff4040;
      box-shadow: 0 6px 12px rgba(255, 64, 64, 0.08);
    }

    /* Carousel-specific styles */
    .center-carousel-wrap {
      position: relative;
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 12px;
    }

    .center-carousel {
      display: flex;
      gap: 12px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding-bottom: 6px;
      -webkit-overflow-scrolling: touch;
      scrollbar-width: thin;
      scrollbar-color: rgba(0,0,0,0.12) transparent;
      padding-left: 6px;
      padding-right: 6px;
      flex: 1 1 auto;
    }

    .center-carousel::-webkit-scrollbar {
      height: 8px;
    }

    .center-carousel::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,0.12);
      border-radius: 8px;
    }

    .carousel-arrow {
      background: white;
      border: 1px solid #e6e6e6;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 6px rgba(0,0,0,0.06);
      transition: transform 0.15s ease, box-shadow 0.15s ease;
      flex: 0 0 auto;
    }

    .carousel-arrow:active {
      transform: scale(0.98);
    }

    .carousel-arrow i {
      font-size: 16px;
      color: #444;
    }

    /* show subtle left/right fade to indicate scrollable content */
    .center-carousel-wrap::before,
    .center-carousel-wrap::after {
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      width: 36px;
      pointer-events: none;
      transition: opacity 0.2s ease;
    }
    .center-carousel-wrap::before {
      left: 0;
      background: linear-gradient(90deg, rgba(244,246,248,1) 0%, rgba(244,246,248,0) 100%);
    }
    .center-carousel-wrap::after {
      right: 0;
      background: linear-gradient(-90deg, rgba(244,246,248,1) 0%, rgba(244,246,248,0) 100%);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .center-btn { min-width: 160px; font-size: 14px; padding: 10px 12px; }
      .carousel-arrow { width: 32px; height: 32px; }
    }

    /* rest of your styles (unchanged) */
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
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
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

    .h6 { font-weight: 700 !important; color: #1a1a1a; font-size: 1.1rem; }
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
          <div class="card-stat" onclick="openStatList('active')">
            <i class="bi bi-person-lines-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4 id="activeStudentsCard"><?= isset($activeStudents) ? $activeStudents : 0 ?></h4>
              <span>Active Students</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="openStatList('attendance')">
            <i class="bi bi-person-check-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4 id="attendanceRateCard"><?= isset($attendanceRate) ? $attendanceRate : 0 ?>%</h4>
              <span>Attendance Rate</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="openStatList('due')">
            <i class="bi bi-currency-rupee card-icon"></i>
            <div class="d-flex flex-column">
              <h4 id="dueAmountCard"><?= isset($totalDue) ? $totalDue : 0 ?></h4>
              <span>Due Amount</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="card-stat" onclick="openStatList('paid')">
            <i class="bi bi-bar-chart-line-fill card-icon"></i>
            <div class="d-flex flex-column">
              <h4 id="paidAmountCard">Rs.<?= isset($totalIncome) ? number_format($totalIncome) : '0' ?></h4>
              <span>Paid Amounts</span>
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
  <div class="center-box mb-3" style="background: #f0eaea;">
    <h6 class="fw-bold text-start">Centers</h6>
    <!-- Scrollable container -->
    <div class="d-grid gap-2 mt-3" style="max-height: 300px; overflow-y: auto; padding-right: 5px;">
      <?php if (!empty($centers)): ?>
        <?php foreach ($centers as $c): ?>
          <button class="btn center-btn text-start"
            value="<?= $c->id ?>"
            onclick="selectCenter('<?= $c->id ?>', this)">
            <i class="bi bi-house-door-fill me-2"></i>
            <?= htmlspecialchars($c->name) ?>
          </button>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-muted">No centers available.</p>
      <?php endif; ?>
    </div>
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


            <!-- Optional: small hint -->
            <div class="mt-2">
              <small class="text-muted">Click a center to filter stats</small>
            </div>
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

  <!-- Modal: stat list (unchanged) -->
  <div class="modal fade" id="statListModal" tabindex="-1" aria-labelledby="statListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <div class="modal-body">
          <div class="stat-modal-header mb-3">
            <h5 class="modal-title" id="statListModalLabel">Students</h5>
            <div>
              <small class="text-muted" id="statListSubLabel">Showing results</small>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped stat-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Parent</th>
                  <th>Batch</th>
                  <th>Level</th>
                  <th>Paid</th>
                  <th>Remaining</th>
                  <th>Status</th>
                  <th>Last Attendance</th>
                </tr>
              </thead>
              <tbody id="statListTableBody">
                <!-- Filled by JS -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // track currently selected center (null = all centers)
    window.selectedCenterId = null;

    document.addEventListener('DOMContentLoaded', () => {
      initializeCharts();
      setupSidebarToggle();
      setupModalBlur();

      // center carousel init
      initCenterCarousel();

      // on load, fetch global stats (no center filter)
      fetchCenterStats(null);
    });

    // initialize center carousel behavior (buttons & drag)
    function initCenterCarousel() {
      const carousel = document.getElementById('centerCarousel');
      const leftBtn = document.getElementById('centerScrollLeft');
      const rightBtn = document.getElementById('centerScrollRight');
      if (!carousel) return;

      const scrollAmount = 300; // px per click - adjust if needed

      leftBtn && leftBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      });
      rightBtn && rightBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      });

      // enable dragging to scroll (desktop)
      let isDown = false;
      let startX, scrollLeft;
      carousel.addEventListener('mousedown', (e) => {
        isDown = true;
        carousel.classList.add('dragging');
        startX = e.pageX - carousel.offsetLeft;
        scrollLeft = carousel.scrollLeft;
      });
      carousel.addEventListener('mouseup', () => {
        isDown = false;
        carousel.classList.remove('dragging');
      });
      carousel.addEventListener('mouseleave', () => {
        isDown = false;
        carousel.classList.remove('dragging');
      });
      carousel.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - carousel.offsetLeft;
        const walk = (x - startX) * 1; // scroll-fast multiplier
        carousel.scrollLeft = scrollLeft - walk;
      });

      // keyboard accessibility: left/right arrow scroll when carousel is focused
      carousel.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') {
          carousel.scrollBy({ left: 200, behavior: 'smooth' });
        } else if (e.key === 'ArrowLeft') {
          carousel.scrollBy({ left: -200, behavior: 'smooth' });
        }
      });
    }

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
      const modals = ['addCenterModal', 'editCenterModal', 'statListModal'];
      modals.forEach(modalId => {
        const modalEl = document.getElementById(modalId);
        if (modalEl) {
          modalEl.addEventListener('show.bs.modal', () => {
            const container = document.querySelector('.container-fluid');
            if (container) container.classList.add('blur');
          });
          modalEl.addEventListener('hidden.bs.modal', () => {
            const container = document.querySelector('.container-fluid');
            if (container) container.classList.remove('blur');
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


    }

    /**
     * Fetch stats for a center (or all centers when centerId is null)
     * and update the 4 stat cards.
     */
    function fetchCenterStats(centerId) {
      let url = '<?= base_url("dashboard/center_stats") ?>';
      if (centerId !== null && centerId !== undefined) {
        url += '?center_id=' + encodeURIComponent(centerId);
      }

      fetch(url, { credentials: 'same-origin' })
        .then(resp => {
          if (!resp.ok) throw new Error('Network response was not ok');
          return resp.json();
        })
        .then(json => {
          if (!json || json.status !== 'success' || !json.data) {
            console.warn('Invalid stats response:', json);
            return;
          }
          const d = json.data;
          const activeEl = document.getElementById('activeStudentsCard');
          const attendanceEl = document.getElementById('attendanceRateCard');
          const dueEl = document.getElementById('dueAmountCard');
          const paidEl = document.getElementById('paidAmountCard');

          if (activeEl) activeEl.innerText = (d.active_students !== undefined) ? d.active_students : 0;
          if (attendanceEl) attendanceEl.innerText = (d.attendance_rate !== undefined) ? (d.attendance_rate + '%') : '0%';
          if (dueEl) dueEl.innerText = (d.total_due !== undefined) ? formatNumber(d.total_due) : 0;
          if (paidEl) paidEl.innerText = (d.total_paid !== undefined) ? ('Rs.' + formatNumber(d.total_paid)) : 'Rs.0';
        })
        .catch(err => {
          console.error('Error fetching center stats:', err);
        });
    }

    // helper to format number with 2 decimals or thousand separators
    function formatNumber(n) {
      if (n === null || n === undefined) return '0';
      if (Number(n) === Math.floor(n)) {
        return Number(n).toLocaleString('en-IN');
      } else {
        return Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
    }

    /**
     * Called when clicking a center button.
     * We set the global selectedCenterId and fetch stats for that center.
     * This preserves previous behavior and also allows the stat-popups to filter by center.
     */
    function selectCenter(centerId, btnEl = null) {
      // update selected center global
      window.selectedCenterId = centerId;

      // Fetch new stats for the selected center (existing behavior)
      fetchCenterStats(centerId);

      // Optional: original edit modal population (only if those elements exist)
      const editName = document.getElementById('editCenterName');
      const editLocation = document.getElementById('editCenterLocation');
      const editCapacity = document.getElementById('editCenterCapacity');
      const editId = document.getElementById('editCenterId');

      // Dummy fallback data for UI — keep as before
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

      if (editName) editName.value = data.name;
      if (editLocation) editLocation.value = data.location;
      if (editCapacity) editCapacity.value = data.capacity;
      if (editId) editId.value = centerId;

      const editModalEl = document.getElementById('editCenterModal');
      if (editModalEl) {
        const modal = new bootstrap.Modal(editModalEl);
        modal.show();
      }

      // Update selected button highlight (visual)
      try {
        document.querySelectorAll('.center-btn').forEach(b => b.classList.remove('selected-center'));
        if (btnEl) btnEl.classList.add('selected-center');
      } catch (e) {}
    }

    /**
     * Open the stat list modal for a given filter:
     * 'active' | 'attendance' | 'due' | 'paid'
     * Uses window.selectedCenterId (null = all centers)
     */
    function openStatList(filter) {
      const centerId = window.selectedCenterId || null;
      const url = '<?= base_url("dashboard/students_list") ?>?filter=' + encodeURIComponent(filter) + (centerId ? '&center_id=' + encodeURIComponent(centerId) : '');

      // Update modal title/sub
      const modalTitle = {
        active: 'Active Students',
        attendance: 'Recently Attended (7 days)',
        due: 'Students with Due Amount',
        paid: 'Students who Paid'
      }[filter] || 'Students';

      document.getElementById('statListModalLabel').innerText = modalTitle;
      const subLabel = centerId ? ('Center ID: ' + centerId) : 'All centers';
      document.getElementById('statListSubLabel').innerText = subLabel;

      // Clear previous rows and show spinner row
      const tbody = document.getElementById('statListTableBody');
      tbody.innerHTML = '<tr><td colspan="10" class="text-center py-4">Loading...</td></tr>';

      fetch(url, { credentials: 'same-origin' })
        .then(resp => {
          if (!resp.ok) throw new Error('Network response was not ok');
          return resp.json();
        })
        .then(json => {
          if (!json || json.status !== 'success' || !Array.isArray(json.data)) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">No data available</td></tr>';
            return;
          }

          const rows = json.data;
          if (rows.length === 0) {
            tbody.innerHTML = '<tr><td colspan="10" class="text-center">No students found.</td></tr>';
          } else {
            tbody.innerHTML = '';
            rows.forEach((r, idx) => {
              const tr = document.createElement('tr');

              const name = r.name || '';
              const contact = r.contact || '';
              const parent = r.parent_name || '';
              const batch = r.batch_id || '';
              const level = r.student_progress_category || '';
              const paid = (r.paid_amount !== null && r.paid_amount !== undefined) ? Number(r.paid_amount).toLocaleString('en-IN') : '0';
              const remaining = (r.remaining_amount !== null && r.remaining_amount !== undefined) ? Number(r.remaining_amount).toLocaleString('en-IN') : '0';
              const status = r.status || '';
              const last_att = r.last_attendance ? r.last_attendance.split(' ')[0] : '';

              tr.innerHTML = `
                <td>${idx + 1}</td>
                <td>${escapeHtml(name)}</td>
                <td>${escapeHtml(contact)}</td>
                <td>${escapeHtml(parent)}</td>
                <td>${escapeHtml(batch)}</td>
                <td>${escapeHtml(level)}</td>
                <td>${paid}</td>
                <td>${remaining}</td>
                <td>${escapeHtml(status)}</td>
                <td>${escapeHtml(last_att)}</td>
              `;
              tbody.appendChild(tr);
            });
          }
        })
        .catch(err => {
          console.error('Error fetching student list:', err);
          tbody.innerHTML = '<tr><td colspan="10" class="text-center text-danger">Failed to load data</td></tr>';
        });

      // show modal
      const modalEl = document.getElementById('statListModal');
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
    }

    // simple HTML escape for insertion into table cells
    function escapeHtml(unsafe) {
      if (unsafe === null || unsafe === undefined) return '';
      return String(unsafe)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
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

    function submitCenterForm() {
      const centerName = document.getElementById('centerName').value;
      const centerLocation = document.getElementById('centerLocation').value;
      const centerCapacity = document.getElementById('centerCapacity').value;

      if (centerName && centerLocation && centerCapacity) {
        alert(`Center "${centerName}" added successfully!`);
        const modal = bootstrap.Modal.getInstance(document.getElementById('addCenterModal'));
        if (modal) modal.hide();
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
        if (modal) modal.hide();
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
  
  <script>
    const ctx = document.getElementById('studentChart').getContext('2d');
    const studentChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Basic', 'Intermediate', 'Advanced'],
        datasets: [{
          data: [
            <?= $studentDistribution['Beginner'] ?? 0 ?>,
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
