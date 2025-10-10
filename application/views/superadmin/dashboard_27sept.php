<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- SINGLE Chart.js include -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.25/dist/jspdf.plugin.autotable.min.js"></script>

  <style>
    :root {
      --accent-1: #ff4040;
      --accent-2: #470000;
      --card-bg: #ffffff;
      --muted-bg: #f4f6f8;
    }

    html, body {
      height: 100%;
    }

    body {
      background-color: var(--muted-bg) !important;
      color: #1a1a1a;
      font-family: 'Montserrat', serif;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Dashboard wrapper */
    .dashboard-wrapper {
      margin-left: 250px;
      padding: 24px;
      transition: all 0.25s ease-in-out;
      background-color: var(--muted-bg);
      min-height: 100vh;
    }

    .dashboard-wrapper.minimized {
      margin-left: 60px;
    }

    /* Stat cards */
    .card-stat {
      background: linear-gradient(135deg, var(--accent-1) 0%, var(--accent-2) 100%);
      color: white;
      border-radius: 12px;
      text-align: left;
      height: 130px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      position: relative;
      padding: 18px 18px 18px 18px;
      padding-right: 58px; /* reserve space for icon to avoid overlap */
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
      overflow: visible;
    }

    .card-stat:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.10);
    }

    .card-stat h4,
    .card-stat span {
      margin: 0;
      word-break: break-word;
      white-space: normal;
    }

    .card-stat h4 {
      margin: 6px 0 4px;
      font-size: 24px;
      font-weight: 700;
      letter-spacing: 0.4px;
      line-height: 1;
    }

    .card-stat span {
      font-size: 13px;
      opacity: 0.95;
    }

    /* icon on card */
    .card-icon {
      position: absolute;
      top: 14px;
      right: 14px;
      font-size: 28px;
      opacity: 0.7;
      pointer-events: none;
    }

    /* Buttons */
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
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .btn-custom:hover {
      background: linear-gradient(90deg, var(--accent-1), #e63939);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(255, 64, 64, 0.14);
    }

    .chart-container {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 24px;
      margin-bottom: 24px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
      transition: box-shadow 0.3s ease;
      min-height: 220px; /* helps Chart.js layout */
    }

    .center-box {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.04);
    }

    /* Center list default layout (desktop) */
    .center-list {
      display: flex;
      flex-direction: column;
      gap: 10px;
      max-height: 300px;
      overflow-y: auto;
      padding-right: 6px; /* room for scrollbar */
      -webkit-overflow-scrolling: touch;
    }

    .center-list .center-btn {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 100%;
      padding: 12px 14px;
      background: #fff;
      border: 1px solid #e9e9e9;
      border-radius: 8px;
      color: #1a1a1a;
      font-weight: 600;
      font-size: 15px;
      cursor: pointer;
      text-align: left;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      transition: transform .16s ease, box-shadow .16s ease, background .16s ease;
      box-shadow: 0 3px 8px rgba(0,0,0,0.03);
    }

    .center-list .center-btn .bi {
      min-width: 20px;
      text-align: center;
      opacity: 0.85;
    }

    .center-list .center-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(0,0,0,0.06);
      background: #fbfbfb;
    }

    .center-list .center-btn.selected-center {
      background: linear-gradient(135deg, rgba(255, 64, 64, 0.06), rgba(255,64,64,0.02));
      border-color: var(--accent-1);
      box-shadow: 0 10px 22px rgba(255,64,64,0.06);
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
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
    }

    .modal-content {
      border-radius: 12px;
      padding: 24px;
      border: 2px solid transparent;
      background: linear-gradient(white, white) padding-box, linear-gradient(135deg, var(--accent-1), var(--accent-2)) border-box;
      box-shadow: 0 8px 26px rgba(0, 0, 0, 0.08);
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
      transition: color 0.2s ease, transform 0.12s ease;
    }

    .modal-close-btn:hover {
      color: var(--accent-1);
      transform: scale(1.05);
    }

    .form-control:focus {
      border-color: var(--accent-1);
      box-shadow: 0 0 6px rgba(255, 64, 64, 0.16);
      outline: none;
    }

    .h6 {
      font-weight: 700 !important;
      color: #1a1a1a;
      font-size: 1.05rem;
    }

    /* Responsive rules */
    @media (max-width: 991.98px) {
      .dashboard-wrapper {
        margin-left: 0 !important;
        padding: 16px;
      }

      .card-stat {
        height: auto;
        padding: 14px;
        border-radius: 10px;
      }

      .chart-container {
        padding: 16px;
      }

      .center-list {
        max-height: 260px;
      }
    }

    /* Mobile overlay sidebar and center-list improvements (REPLACEMENT for the existing mobile block) */
@media (max-width: 575.98px) {
  /* sidebar overlay */
  .sidebar, #sidebar, .main-sidebar {
    position: fixed !important;
    top: 0;
    left: 0;
    height: 100vh;
    width: 260px;
    transform: translateX(-100%);
    z-index: 1080;
    background: #fff;
    box-shadow: 0 14px 40px rgba(0,0,0,0.18);
    transition: transform .28s ease;
  }
  .sidebar.active, #sidebar.active, .main-sidebar.active {
    transform: translateX(0);
  }

  .sidebar-backdrop {
    display: none;
  }
  body.sidebar-open .sidebar-backdrop {
    display: block;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.42);
    z-index: 1070;
  }

  /* make the dashboard content use less padding on mobile */
  .dashboard-wrapper {
    margin-left: 0 !important;
    padding: 10px;
  }

  /* compact center-box padding */
  .center-box {
    padding: 12px;
  }

  /* center-list on mobile: compact, denser items */
  .center-list {
    max-height: calc(100vh - 220px); /* leave room for header/footer */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
    padding: 6px; /* tighter padding */
    gap: 8px; /* smaller gap */
  }

  /* compact center buttons: full width, smaller padding and radius */
  .center-list .center-btn {
    white-space: normal; /* allow wrapping if needed */
    align-items: center;  /* vertically center icon + text */
    padding: 8px 10px;    /* smaller vertical padding */
    background: #fff;     /* keep but subtle */
    border: 1px solid #eee;
    border-radius: 8px;   /* smaller radius so not pill-like */
    font-size: 14px;      /* slightly smaller text */
    line-height: 1.2;
    gap: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    height: auto;
    min-height: 40px;     /* compact min height */
  }

  /* icon alignment */
  .center-list .center-btn .bi {
    min-width: 20px;
    text-align: center;
    opacity: 0.9;
    font-size: 16px;
  }

  /* avoid huge left indent on the name container */
  .center-list .center-btn > div {
    flex: 1;
    overflow: hidden;
    text-align: left;
    padding: 0; /* remove internal padding if any */
  }

  /* visually indicate selection without huge visual weight */
  .center-list .center-btn.selected-center {
    background: linear-gradient(135deg, rgba(255,64,64,0.06), rgba(255,64,64,0.02));
    border-color: var(--accent-1);
    box-shadow: 0 6px 12px rgba(255,64,64,0.06);
  }

  /* slightly reduce card-stat font sizes on mobile too */
  .card-stat h4 { font-size: 20px; }
  .card-stat span { font-size: 12px; }
  .card-stat { padding-right: 44px; }

  /* Reduce chart container paddings on very small screens so charts get more space */
  .chart-container { padding: 14px; }

  /* Scrollbar adjustments (thin overlay feel) */
  .center-list::-webkit-scrollbar { width: 8px; }
  .center-list::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.08); border-radius: 6px; }
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
              <!-- padding-right in .card-stat prevents overlap with icon -->
              <h4 id="paidAmountCard"><?= isset($totalIncome) ? number_format($totalIncome) : '0' ?></h4>
              <span>Paid Amounts</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts & Side Panel -->
      <div class="row">
        <div class="col-lg-9">
          <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Weekly Attendance</h6>
              <!-- <button class="btn filter-btn" onclick="filterAttendance()">Filter</button> -->
            </div>
            <div style="position:relative; height:220px;">
              <canvas id="attendanceChart"></canvas>
            </div>
          </div>

          <div class="chart-container">
            <h6>Revenue Overview</h6>
            <div style="position:relative; height:337px;">
              <canvas id="revenueChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="center-box mb-3" style="background: #f7efef;">
            <h6 class="fw-bold text-start">Centers</h6>
            <div class="center-list mt-3">
              <?php if (!empty($centers)): ?>
                <?php foreach ($centers as $c): ?>
                  <!-- Added type="button" and data-center-id to avoid accidental form submits and to aid debug -->
                  <button type="button" class="center-btn" data-center-id="<?= htmlspecialchars($c->id) ?>" value="<?= htmlspecialchars($c->id) ?>" onclick="selectCenter('<?= htmlspecialchars($c->id) ?>', this)">
                    <i class="bi bi-house-door-fill"></i>
                    <div style="flex:1; overflow:hidden; text-align:left;">
                      <?= htmlspecialchars($c->name) ?>
                    </div>
                  </button>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">No centers available.</p>
              <?php endif; ?>
            </div>
          </div>

          <div class="center-box">
            <h6>Student Distribution</h6>
            <div style="position:relative; height:180px;">
              <canvas id="studentChart"></canvas>
            </div>
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

  <!-- Modal: stat list -->
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

  <!-- Sidebar backdrop (used for mobile overlay) -->
  <div class="sidebar-backdrop" aria-hidden="true" style="display:none;"></div>

  <script>
    // track currently selected center (null = all centers)
    window.selectedCenterId = null;

    // keep chart instances global to avoid double-creation
    window.attendanceChart = null;
    window.revenueChart = null;
    window.studentChart = null;

    document.addEventListener('DOMContentLoaded', () => {
      // sidebar controller will auto-initialize from the script at the bottom (it wires toggles & fallback)
      setupModalBlur();
      initOrUpdateCharts();
      fetchCenterStats(null);

      // wire backdrop click to close mobile sidebar (works alongside controller)
      const backdrop = document.querySelector('.sidebar-backdrop');
      if (backdrop) {
        backdrop.addEventListener('click', () => {
          document.body.classList.remove('sidebar-open');
          document.querySelectorAll('.sidebar, #sidebar, .main-sidebar').forEach(s => s.classList.remove('active'));
          backdrop.style.display = 'none';
          document.body.style.overflow = '';
        });
      }
    });

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

    /* Charts (unchanged logic except updateCharts guard improvements) */
    function initOrUpdateCharts() {
      const attCtx = document.getElementById("attendanceChart").getContext("2d");
      const attGradient = attCtx.createLinearGradient(0, 0, 0, 200);
      attGradient.addColorStop(0, "#D9D9D9");
      attGradient.addColorStop(0.5, "#ff4040");
      attGradient.addColorStop(1, "#470000");

      const attData = {
        labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
        datasets: [{
          label: "Attendance",
          // placeholder values; will be replaced by AJAX data when available
          data: [90, 85, 75, 92, 80, 85, 90],
          backgroundColor: attGradient,
          borderRadius: 10,
          barThickness: 30
        }]
      };

      const attOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { enabled: true } },
        scales: {
          x: { grid: { display: false }, ticks: { font: { size: 12 } } },
          y: { beginAtZero: true, max: 110, grid: { display: false }, ticks: { stepSize: 25, font: { size: 12 } } }
        }
      };

      if (window.attendanceChart) {
        window.attendanceChart.data = attData;
        window.attendanceChart.options = attOptions;
        window.attendanceChart.update();
      } else {
        window.attendanceChart = new Chart(attCtx, { type: "bar", data: attData, options: attOptions });
      }

      const revCtx = document.getElementById('revenueChart').getContext('2d');
      const revGradient = revCtx.createLinearGradient(0, 0, 0, 400);
      revGradient.addColorStop(0, '#ff4040');
      revGradient.addColorStop(1, '#470000');

      const revenueLabels = [
        <?php foreach ($monthlyRevenue as $row) { echo "'" . $row['month'] . "',"; } ?>
      ];
      const revenueDataValues = [
        <?php foreach ($monthlyRevenue as $row) { echo $row['revenue'] . ","; } ?>
      ];

      const revData = {
        labels: revenueLabels,
        datasets: [{
          label: 'Revenue',
          data: revenueDataValues,
          fill: true,
          borderColor: '#ff4040',
          backgroundColor: revGradient,
          tension: 0.3,
          borderWidth: 2,
          pointBackgroundColor: '#470000',
          pointRadius: 4
        }]
      };

      const revOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: true } }, scales: { y: { beginAtZero: true } } };

      if (window.revenueChart) {
        window.revenueChart.data = revData;
        window.revenueChart.options = revOptions;
        window.revenueChart.update();
      } else {
        window.revenueChart = new Chart(revCtx, { type: 'line', data: revData, options: revOptions });
      }

      const stuCtx = document.getElementById('studentChart').getContext('2d');
      const studentDistributionData = [
        <?= $studentDistribution['Beginner'] ?? 0 ?>,
        <?= $studentDistribution['Intermediate'] ?? 0 ?>,
        <?= $studentDistribution['Advanced'] ?? 0 ?>
      ];

      const stuData = {
        labels: ['Basic', 'Intermediate', 'Advanced'],
        datasets: [{
          data: studentDistributionData,
          backgroundColor: ['#990000', '#000000', '#f4b6b6']
        }]
      };

      const stuOptions = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

      if (window.studentChart) {
        window.studentChart.data = stuData;
        window.studentChart.options = stuOptions;
        window.studentChart.update();
      } else {
        window.studentChart = new Chart(stuCtx, { type: 'doughnut', data: stuData, options: stuOptions });
      }
    }

    // Improved guard: ensure arrays update even if all zeros; coerce to numbers
    window.updateCharts = function({ attendance = null, revenue = null, studentDist = null }) {
      if (Array.isArray(attendance) && window.attendanceChart) {
        window.attendanceChart.data.datasets[0].data = attendance.map(v => Number(v) || 0);
        window.attendanceChart.update();
      }
      if (revenue && Array.isArray(revenue.labels) && Array.isArray(revenue.data) && window.revenueChart) {
        window.revenueChart.data.labels = revenue.labels;
        window.revenueChart.data.datasets[0].data = revenue.data.map(v => Number(v) || 0);
        window.revenueChart.update();
      }
      if (Array.isArray(studentDist) && window.studentChart) {
        window.studentChart.data.datasets[0].data = studentDist.map(v => Number(v) || 0);
        window.studentChart.update();
      }
    };

    function fetchCenterStats(centerId) {
      let url = '<?= base_url("dashboard/center_stats") ?>';
      if (centerId !== null && centerId !== undefined && String(centerId) !== '') {
        url += '?center_id=' + encodeURIComponent(centerId);
      }

      // debug helper - check browser console when clicking centers
      console.debug('fetchCenterStats ->', url);

      fetch(url, { credentials: 'same-origin' })
        .then(resp => {
          if (!resp.ok) throw new Error('Network response was not ok: ' + resp.status);
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
          if (paidEl) paidEl.innerText = (d.total_paid !== undefined) ? ( formatNumber(d.total_paid)) : 'Rs.0';

          // Weekly attendance
          if (Array.isArray(d.weekly_attendance)) {
            // ensure chart exists
            if (!window.attendanceChart) initOrUpdateCharts();
            window.updateCharts({ attendance: d.weekly_attendance });
          }

          // Revenue
          if (d.revenue && Array.isArray(d.revenue.labels) && Array.isArray(d.revenue.data)) {
            if (!window.revenueChart) initOrUpdateCharts();
            window.updateCharts({ revenue: { labels: d.revenue.labels, data: d.revenue.data } });
          }

          // Student distribution
          if (Array.isArray(d.student_distribution)) {
            if (!window.studentChart) initOrUpdateCharts();
            window.updateCharts({ studentDist: d.student_distribution });
          }

          if (d.debug_center_id !== undefined) {
            console.debug('center_stats returned debug_center_id:', d.debug_center_id);
          }
        })
        .catch(err => {
          console.error('Error fetching center stats:', err);
        });
    }

    function formatNumber(n) {
      if (n === null || n === undefined) return '0';
      if (Number(n) === Math.floor(n)) {
        return Number(n).toLocaleString('en-IN');
      } else {
        return Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
    }

    // normalize center id and reliably trigger fetch + UI selection
    function selectCenter(centerId, btnEl = null) {
      // normalize center id to either numeric-string or null
      if (centerId === '' || centerId === undefined || centerId === null) {
        window.selectedCenterId = null;
      } else {
        window.selectedCenterId = (String(centerId).match(/^\d+$/)) ? String(centerId) : centerId;
      }

      // UI selection class
      try {
        document.querySelectorAll('.center-btn').forEach(b => b.classList.remove('selected-center'));
        if (btnEl && btnEl.classList) btnEl.classList.add('selected-center');
      } catch (e) {
        console.warn('selectCenter UI update failed', e);
      }

      // fetch stats
      fetchCenterStats(window.selectedCenterId);
    }

    function openStatList(filter) {
      const centerId = window.selectedCenterId || null;
      const url = '<?= base_url("dashboard/students_list") ?>?filter=' + encodeURIComponent(filter) + (centerId ? '&center_id=' + encodeURIComponent(centerId) : '');

      const modalTitle = {
        active: 'Active Students',
        attendance: 'Recently Attended (7 days)',
        due: 'Students with Due Amount',
        paid: 'Students who Paid'
      }[filter] || 'Students';

      document.getElementById('statListModalLabel').innerText = modalTitle;
      const subLabel = centerId ? ('Center ID: ' + centerId) : 'All centers';
      document.getElementById('statListSubLabel').innerText = subLabel;

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

      const modalEl = document.getElementById('statListModal');
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
    }

    function escapeHtml(unsafe) {
      if (unsafe === null || unsafe === undefined) return '';
      return String(unsafe).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
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
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF();

      doc.setFontSize(18);
      doc.text("Students Data", 14, 15);

      doc.autoTable({
        head: [["Name", "Contact", "Center", "Batch", "Level", "Category"]],
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
      if (dashboardWrapper) dashboardWrapper.classList.toggle('minimized');
    }
    window.toggleDashboard = toggleDashboard;
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
/*
  Robust sidebar controller:
  - single-click on desktop (pointerdown wired to toggles)
  - mobile overlay behaviour (open/close)
  - dedupes touch -> click synthetic events
  - fallback toggle button inserted into navbar if none exists
  This is the same controller pattern used in the Finance.php you shared.
*/
(function () {
  // --- Configuration ---
  const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
  const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
  const WRAPPER_IDS = ['dashboardWrapper', 'financeWrap'];
  const DESKTOP_WIDTH_CUTOFF = 576;
  const SIDEBAR_OPEN_CLASS = 'active';
  const SIDEBAR_MIN_CLASS = 'minimized';
  const BODY_OVERLAY_CLASS = 'sidebar-open';
  const CSS_VAR = '--sidebar-width';
  const SIDEBAR_WIDTH_OPEN = '250px';
  const SIDEBAR_WIDTH_MIN = '60px';

  // --- Helpers ---
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));
  const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
  const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.wrap') || qs('.dashboard-wrapper');

  function isMobile() { return window.innerWidth <= DESKTOP_WIDTH_CUTOFF; }

  // Ensure single backdrop exists
  let backdrop = qs('.sidebar-backdrop');
  if (!backdrop) {
    backdrop = document.createElement('div');
    backdrop.className = 'sidebar-backdrop';
    backdrop.style.position = 'fixed';
    backdrop.style.inset = '0';
    backdrop.style.background = 'rgba(0,0,0,0.42)';
    backdrop.style.zIndex = '1070';
    backdrop.style.display = 'none';
    backdrop.style.opacity = '0';
    backdrop.style.transition = 'opacity .18s ease';
    document.body.appendChild(backdrop);
  }

  // Prevent double-toggles
  let lock = false;
  function lockFor(ms=320) { lock = true; clearTimeout(lock._t); lock._t = setTimeout(()=> lock=false, ms); }

  // Track last interactive event to suppress follow-up synthetic clicks
  let lastInteractionAt = 0;
  const INTERACTION_GAP = 700; // ms

  function openMobileSidebar() {
    const s = sidebarEl(); if (!s) return;
    s.classList.add(SIDEBAR_OPEN_CLASS);
    document.body.classList.add(BODY_OVERLAY_CLASS);
    document.body.style.overflow = 'hidden';
    backdrop.style.display = 'block';
    requestAnimationFrame(()=> backdrop.style.opacity = '1');
  }

  function closeMobileSidebar() {
    const s = sidebarEl(); if (s) s.classList.remove(SIDEBAR_OPEN_CLASS);
    document.body.classList.remove(BODY_OVERLAY_CLASS);
    document.body.style.overflow = '';
    backdrop.style.opacity = '0';
    setTimeout(()=> { if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display = 'none'; }, 220);
  }

  function toggleDesktopSidebar() {
    const s = sidebarEl(); if (!s) return;
    const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
    const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin);
    const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
    document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
    document.dispatchEvent(new CustomEvent('sidebarToggle', { detail: { minimized: isMin } }));
    setTimeout(()=> window.dispatchEvent(new Event('resize')), 220);
  }

  function handleToggleEvent(e) {
    // suppress clicks immediately after a pointerdown/touch (we set lastInteractionAt)
    if (e && e.type === 'click' && (Date.now() - lastInteractionAt) < INTERACTION_GAP) {
      return;
    }

    if (lock) return;
    if (isMobile()) {
      lockFor(260);
      if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); else openMobileSidebar();
    } else {
      lockFor(260);
      toggleDesktopSidebar();
    }
  }

  // --- Wire direct handlers to toggle elements (click + pointerdown) ---
  function wireToggleButtons() {
    const toggles = qsa(TOGGLE_SELECTORS);
    toggles.forEach(el => {
      if (el.__sidebarToggleBound) return;
      el.__sidebarToggleBound = true;

      // pointerdown catches mouse/pen/touch early — immediate reaction on press
      el.addEventListener('pointerdown', function (ev) {
        // mark the interaction time so the following click is ignored by handleToggleEvent
        lastInteractionAt = Date.now();
        // Call handler directly for instantaneous response on desktop/mouse
        try { handleToggleEvent(ev); } catch (err) { console.warn('sidebar pointerdown handler error', err); }
      }, { passive: true });

      // Keep click handler as backup (keyboard activation or other environments)
      el.addEventListener('click', function (ev) {
        // mark interaction time (for safety)
        lastInteractionAt = Date.now();
        // Let delegated handlers decide; still call handler to be sure
        try { handleToggleEvent(ev); } catch (err) { console.warn('sidebar click handler error', err); }
      });
    });
  }

  // Global pointerdown: only use for touch/pen if a toggle was pressed outside wireToggleButtons
  document.addEventListener('pointerdown', function (ev) {
    if (ev.pointerType === 'touch' || ev.pointerType === 'pen') {
      const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
      if (toggle) {
        lastInteractionAt = Date.now();
        handleToggleEvent(ev);
      }
    }
  }, { passive: true });

  // Delegated click: covers dynamic toggles, keyboard, and acts as backup
  document.addEventListener('click', function (ev) {
    const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
    if (toggle) {
      // If a recent pointerdown already handled this, handleToggleEvent will ignore the click
      handleToggleEvent(ev);
    }
  });

  // Backdrop click closes mobile sidebar
  backdrop.addEventListener('click', function () {
    if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) return;
    closeMobileSidebar();
  });

  // Close overlay when clicking a link inside sidebar on mobile (common UX)
  document.addEventListener('click', function (e) {
    if (!isMobile()) return;
    const inside = e.target.closest && e.target.closest(SIDEBAR_SELECTORS);
    if (!inside) return;
    const anchor = e.target.closest && e.target.closest('a');
    if (anchor && anchor.getAttribute('href') && anchor.getAttribute('href') !== '#') {
      setTimeout(closeMobileSidebar, 160);
    }
  });

  // ESC closes overlay
  document.addEventListener('keydown', function (ev) {
    if (ev.key === 'Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) {
      closeMobileSidebar();
    }
  });

  // Resize handling
  let resizeTimer = null;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      if (!isMobile()) {
        closeMobileSidebar();
        const s = sidebarEl();
        const isMin = s && s.classList.contains(SIDEBAR_MIN_CLASS);
        document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
      }
    }, 120);
  });

  // If page initially had sidebar-open, ensure backdrop visible
  if (document.body.classList.contains(BODY_OVERLAY_CLASS)) {
    backdrop.style.display = 'block';
    backdrop.style.opacity = '1';
    document.body.style.overflow = 'hidden';
  }

  // Provide fallback toggle button if none exists, and wire toggles
  (function ensureFallbackToggle() {
    if (qs(TOGGLE_SELECTORS)) {
      wireToggleButtons();
      return;
    }
    const navbar = qs('.navbar, header, .main-header, .topbar');
    if (!navbar) return;
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.id = 'sidebarToggle';
    btn.className = 'btn btn-sm btn-light sidebar-toggle';
    btn.setAttribute('aria-label', 'Toggle sidebar');
    btn.style.marginRight = '8px';
    btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    navbar.prepend(btn);

    wireToggleButtons();
  })();

  // Also wire buttons on DOMContentLoaded (in case toggles are added later)
  document.addEventListener('DOMContentLoaded', () => {
    wireToggleButtons();
  });

})();
</script>

</body>

</html>
