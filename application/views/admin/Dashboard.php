<!-- application/views/admin/Dashboard.php (updated: improved sidebar close, backdrop fix, navbar sync, responsive cards, show center/batch names) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Dashboard</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.3/jspdf.plugin.autotable.min.js"></script>

  <style>
    :root {
      --list-height: 360px;
      --sidebar-width: 260px;       /* open width */
      --sidebar-min-width: 60px;    /* minimized width */
      --muted-bg: #e9ecef;
    }
    * { box-sizing: border-box; }
    body{font-family:'Montserrat',sans-serif;background:var(--muted-bg);color:#111;overflow-x:hidden;margin:0}

    /* Navbar sync: navbar margin-left follows --sidebar-width, and reduces when minimized */
    .header, .main-header, .topbar {
      transition: margin-left .25s ease, padding .25s ease;
      margin-left: var(--sidebar-width);
    }

    /* main navbar (fixed) - responsive to CSS variables */
    .navbar {
      box-shadow: 0 2px 4px rgba(0,0,0,0.08);
      padding: 10px 20px;
      position: fixed;
      top: 0;
      z-index: 1100;
      height: 60px;
      left: var(--sidebar-width);
      width: calc(100% - var(--sidebar-width));
      overflow-x: hidden;
      transition: width .28s ease, left .28s ease;
      background: #fff;
      display:flex;
      align-items:center;
      gap:12px;
    }
    /* when sidebar is minimized we toggle this class on navbar to update left/width */
    .navbar.sidebar-minimized {
      left: var(--sidebar-min-width);
      width: calc(100% - var(--sidebar-min-width));
    }

    /* Dashboard wrapper */
    .dashboard{margin-left:var(--sidebar-width);padding:18px;padding-top:94px;min-height:100vh;transition:.25s}
    .dashboard.minimized{margin-left:var(--sidebar-min-width)}

    .card-stat{border-radius:12px;padding:18px;color:#fff;cursor:pointer;display:flex;justify-content:space-between;align-items:center;transition:transform .12s, box-shadow .12s;overflow:hidden;min-height:84px}
    .card-stat:hover{transform:translateY(-4px);box-shadow:0 10px 20px rgba(0,0,0,.12)}
    .card-stat h3{margin:0;font-weight:700;font-size:28px;line-height:1}
    .card-stat p{margin:0;font-size:13px;opacity:.95}
    /* responsive grid for stat cards - prevents overflow on small screens */
    .stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:15px;margin-bottom:18px}
    .card-stat .meta-wrap { display:flex;flex-direction:column;gap:6px;min-width:0;overflow:hidden }
    .card-stat .meta-wrap h3, .card-stat .meta-wrap p { overflow-wrap: anywhere; word-break: break-word; white-space: normal; }

    .btn-custom{background:#000;color:#fff;border:none;padding:8px 14px;border-radius:6px;font-weight:600}
    .table-card, .chart-card, .attendance-card{background:#fff;color:#000;border-radius:12px;padding:16px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
    .students-table{width:100%;min-width:0;font-size:13px}
    .students-table th{background:#333;color:#fff;position:sticky;top:0}
    .status-badge{padding:4px 8px;border-radius:10px;font-weight:700;font-size:11px}
    .status-complete{background:#d4edda;color:#155724}
    .status-pending{background:#f8d7da;color:#721c24}

    @media(max-width:992px){
      .dashboard{margin-left:0;padding:12px;padding-top:84px}.stat-grid{grid-template-columns:repeat(2,1fr)}
      .navbar{left:0;width:100%}
      .navbar.sidebar-minimized{left:0;width:100%}
    }
    @media(max-width:576px){
      .stat-grid{grid-template-columns:repeat(1,1fr)}.btn-custom{padding:6px 10px;font-size:13px}
      .dashboard{padding-top:84px}
      .card-stat h3{font-size:22px}
      .card-stat{min-height:72px;padding:14px}
    }

    .students-table-container { max-height: var(--list-height); overflow:auto; background:#fff; border-radius:8px; padding:8px; }
    .students-table thead th { position: sticky; top: 0; background:#333; color:#fff; z-index: 2; }
    .loading-row { text-align:center; padding:18px; color:#666; }
    .search-controls .input-group .form-control { height:36px; }
    .students-info { font-size:13px; color:#666; }

    .attendance-list-container { max-height: var(--list-height); overflow:auto; border-radius:8px; padding:8px; background:#fff; }
    .attendance-list-container table thead th { position: sticky; top: 0; background:#f8f9fa; z-index: 2; }
    .attendance-list-container table tbody tr td { vertical-align: middle; color:#000; }

    .row.g-3 > .col-lg-6 { display: flex; align-items: stretch; }
    .attendance-card, .chart-card { display:flex; flex-direction:column; flex:1; padding: 12px; }
    .attendance-card .attendance-list-container { flex:1; }

    .chart-card .chart-wrapper { height: 300px; display:flex; align-items:center; justify-content:center; padding:8px; background:transparent; border-radius:6px; }
    .chart-wrapper canvas { width:100% !important; height:100% !important; display:block; }

    .card-stat.active-filter { outline: 3px solid rgba(0,0,0,0.06); box-shadow: 0 12px 28px rgba(0,0,0,0.12); }

    /* View modal styling (make it look nicer) */
    .student-modal .modal-header { border-bottom: none; }
    .student-card { border-radius:10px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,.12); }
    .student-card .left { background: linear-gradient(180deg,#0d6efd33,#0d6efd11); padding:20px; min-width:180px; }
    .student-card h5 { margin-bottom:6px; font-weight:700; }
    .student-card .meta { font-size:13px; color:#444; }
    .student-card .muted { color:#666; font-size:13px; }

    @media(max-width:768px){
      .chart-card .chart-wrapper { height:220px; }
      .students-table thead th:nth-child(3), .students-table td:nth-child(3) { display: none; } /* hide center on small */
    }

    .mt-2 { margin-top:.5rem !important; }

    /* Mobile overlay sidebar */
    @media (max-width: 576px) {
      .sidebar, #sidebar, .main-sidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh;
        width: var(--sidebar-width);
        transform: translateX(-100%);
        z-index: 1080;
        background: #fff;
        box-shadow: 0 14px 40px rgba(0,0,0,0.18);
        transition: transform .28s ease;
      }
      .sidebar.active, #sidebar.active, .main-sidebar.active { transform: translateX(0); }
      body.sidebar-open { overflow: hidden; }
      .dashboard { padding: 10px; }
      /* ensure backdrop covers everything and can receive clicks */
      .sidebar-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.42); z-index: 1070; display:none; opacity:0; transition: opacity .18s ease; pointer-events:none; }
      .sidebar-backdrop.visible { display:block; pointer-events:auto; opacity:1; }
      .navbar { left: 0; width: 100%; }
    }
  </style>
</head>
<body>
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <?php $this->load->view('admin/Include/Navbar') ?>

  <div class="dashboard" id="dashboard">
    <div class="container-fluid">
      <div class="stat-grid">
        <div class="card-stat" id="stat-total" style="background:linear-gradient(90deg,#ff4040,#470000)" onclick="handleStat('total')">
          <div class="meta-wrap">
            <h3 id="totalCount">0</h3><p>Total Students</p>
          </div><i class="bi bi-people-fill fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" id="stat-active" style="background:linear-gradient(90deg,#ff6b6b,#8b0000)" onclick="handleStat('active')">
          <div class="meta-wrap"><h3 id="activeCount">0</h3><p>Active Students</p></div><i class="bi bi-person-check fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" id="stat-deactive" style="background:linear-gradient(90deg,#ff9a9a,#330000)" onclick="handleStat('deactive')">
          <div class="meta-wrap"><h3 id="deactiveCount">0</h3><p>Deactive Students</p></div><i class="bi bi-person-x fs-3 opacity-50"></i>
        </div>
        <div class="card-stat" id="stat-center" style="background:linear-gradient(90deg,#ff4040,#470000);flex-direction:column;justify-content:center" onclick="handleStat('center')">
          <div class="meta-wrap" style="text-align:left;width:100%"><h6 style="font-size:13px;margin-bottom:6px;opacity:.9">Center</h6><h4 id="centerName" style="margin:0;font-weight:800">—</h4></div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Recently Added Students</h6>
              <div></div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-2 search-controls flex-column flex-md-row gap-2">
              <div class="input-group w-100 w-md-50">
                <input id="studentSearch" class="form-control form-control-sm" placeholder="Search by name or contact..." aria-label="Search students">
                <button id="studentSearchBtn" class="btn btn-sm btn-dark" type="button"><i class="bi bi-search"></i></button>
                <button id="studentClearBtn" class="btn btn-sm btn-secondary" type="button">Clear</button>
              </div>
              <div class="d-flex align-items-center gap-2 ms-md-auto">
                <small id="studentsInfo" class="students-info">Loading…</small>
                <button id="loadMoreBtn" class="btn btn-sm btn-outline-primary">Load more</button>
              </div>
            </div>

            <div class="students-table-container">
              <table class="table students-table table-striped mb-0">
                <thead>
                  <tr><th>Name</th><th>Contact</th><th>Center</th><th>Batch</th><th>Level</th><th>Category</th><th>Action</th></tr>
                </thead>
                <tbody id="studentsTableBody">
                  <tr><td colspan="7" class="loading-row">Loading students…</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="attendance-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="mb-0">Student Attendance</h6>
              <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#attendanceFilterModal"><i class="bi bi-funnel"></i> Filter</button>
            </div>
            <div class="attendance-list-container">
              <table class="table table-striped mb-0" id="attendanceTable">
                <thead><tr><th>Name</th><th>Batch</th><th>Level</th><th>Status</th></tr></thead>
                <tbody id="attendanceTableBody"></tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="chart-card">
            <div class="chart-card p-0">
              <h6 class="mb-2">Total Students</h6>
              <div class="chart-wrapper"><canvas id="studentChart"></canvas></div>
              <div class="mt-2">
                <small><span class="me-3"><i class="bi bi-square-fill" style="color:#ff6b6b"></i> Beginner</span>
                <span class="me-3"><i class="bi bi-square-fill" style="color:#ffeb3b"></i> Intermediate</span>
                <span><i class="bi bi-square-fill" style="color:#4ecdc4"></i> Advanced</span></small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals (unchanged content) -->
    <!-- Add student modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Add Student</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="addStudentForm" class="mt-2">
        <input class="form-control mb-2" id="addStudentName" placeholder="Name" required pattern="[A-Za-z\s]+">
        <input class="form-control mb-2" id="addStudentContact" placeholder="Contact" required pattern="[0-9]{10}">
        <select id="addStudentCenter" class="form-control mb-2" required><option value="">-- Select Center --</option></select>
        <select id="addStudentBatch" class="form-control mb-2" required><option value="">-- Select Batch --</option></select>
        <select id="addStudentLevel" class="form-control mb-2" required><option value="">Level</option><option>Beginner</option><option>Intermediate</option><option>Advanced</option></select>
        <select id="addStudentCategory" class="form-control mb-2" required><option value="">Category</option><option>Complete</option><option>Pending</option></select>
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Add</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

    <!-- Edit student modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Edit Student</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="editStudentForm" class="mt-2">
        <input type="hidden" id="editStudentId" name="id">
        <div class="row">
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentName" name="name" placeholder="Name" required></div>
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentContact" name="contact" placeholder="Contact"></div>
        </div>
        <div class="row">
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentParent" name="parent_name" placeholder="Parent name"></div>
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentEmergency" name="emergency_contact" placeholder="Emergency contact"></div>
        </div>
        <div class="row">
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentEmail" name="email" placeholder="Email"></div>
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentDob" name="dob" placeholder="DOB"></div>
        </div>
        <div class="row">
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentAddress" name="address" placeholder="Address"></div>
          <div class="col-md-6"><input class="form-control mb-2" id="editStudentLevel" name="student_progress_category" placeholder="Level"></div>
        </div>

        <div class="d-flex justify-content-center">
          <button class="btn btn-success me-2" type="submit">Save</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
        </div>
      </form>
    </div></div></div>

    <!-- View student modal -->
    <div class="modal fade" id="viewStudentModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content p-0 student-card">
      <div class="d-flex justify-content-between p-3 border-bottom bg-white">
        <div><h5 class="mb-0">Student Details</h5><small class="muted" id="viewStudentSmall"></small></div>
        <div class="d-flex gap-2">
          <button id="viewEditBtn" class="btn btn-sm btn-outline-success"><i class="bi bi-pencil"></i> Edit</button>
          <button id="viewDeleteBtn" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
          <button class="btn btn-sm btn-light" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
        </div>
      </div>

      <div class="d-flex flex-column flex-md-row">
        <div class="left p-3">
          <h5 id="viewName">—</h5>
          <div class="meta" id="viewLevel">Level —</div>
          <div class="muted mt-2" id="viewContact">Contact —</div>
          <div class="muted mt-1" id="viewCenter">Center —</div>
        </div>

        <div class="p-3 flex-fill bg-white">
          <ul class="nav nav-tabs" id="studentTab" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabGeneral" type="button">General</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabFees" type="button">Fees</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabContact" type="button">Contact</button></li>
          </ul>
          <div class="tab-content p-3">
            <div class="tab-pane fade show active" id="tabGeneral">
              <div id="viewGeneralHtml"></div>
            </div>
            <div class="tab-pane fade" id="tabFees">
              <div id="viewFeesHtml"></div>
            </div>
            <div class="tab-pane fade" id="tabContact">
              <div id="viewContactHtml"></div>
            </div>
          </div>
        </div>
      </div>
    </div></div></div>

    <!-- Attendance filter modal -->
    <div class="modal fade" id="attendanceFilterModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content p-3">
      <div class="d-flex justify-content-between"><h5>Filter Attendance</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <form id="attendanceFilterForm" class="mt-2">
        <input class="form-control mb-2" id="filterAttendanceName" placeholder="Name">
        <div class="d-flex justify-content-center"><button class="btn btn-light me-2" type="submit">Apply</button><button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button></div>
      </form>
    </div></div></div>

  </div> <!-- /dashboard -->

  <!-- Single backdrop element (we ensure it's present and controlled by JS) -->
  <div class="sidebar-backdrop" aria-hidden="true"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Robust sidebar script - fixes: closes when clicking outside, backdrop hide/fade fix, navbar sync -->
  <script>
    (function () {
      // --- Configuration ---
      const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
      const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
      const WRAPPER_ID = 'dashboard';
      const DESKTOP_WIDTH_CUTOFF = 576;
      const SIDEBAR_OPEN_CLASS = 'active';
      const SIDEBAR_MIN_CLASS = 'minimized';
      const BODY_OVERLAY_CLASS = 'sidebar-open';
      const SIDEBAR_OPEN_WIDTH = '260px';
      const SIDEBAR_MIN_WIDTH = '60px';

      // --- Helpers ---
      const qs = s => document.querySelector(s);
      const qsa = s => Array.from(document.querySelectorAll(s));
      const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
      const wrapperEl = () => document.getElementById(WRAPPER_ID) || qs('.dashboard');
      const navbarEl = () => qs('.navbar, header, .main-header, .topbar');

      function isMobile() { return window.innerWidth <= DESKTOP_WIDTH_CUTOFF; }

      // Ensure single backdrop exists
      let backdrop = qs('.sidebar-backdrop');
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'sidebar-backdrop';
        document.body.appendChild(backdrop);
      }
      // normalize backdrop style (safe so inline HTML works)
      backdrop.style.position = 'fixed';
      backdrop.style.inset = '0';
      backdrop.style.background = 'rgba(0,0,0,0.42)';
      backdrop.style.zIndex = '1070';
      backdrop.style.display = 'none';
      backdrop.style.opacity = '0';
      backdrop.style.transition = 'opacity .18s ease';
      backdrop.style.pointerEvents = 'none';

      // Prevent double-toggles
      let lock = false;
      function lockFor(ms=320) { lock = true; clearTimeout(lock._t); lock._t = setTimeout(()=> lock=false, ms); }

      // Track last touch/pointer time to avoid handling the follow-up synthetic click
      let lastTouchAt = 0;
      const TOUCH_CLICK_GAP = 700; // ms

      function setToggleAria(isExpanded) {
        qsa(TOGGLE_SELECTORS).forEach(t => t.setAttribute('aria-expanded', String(!!isExpanded)));
      }

      function setMainAriaHidden(hide) {
        // attempt to mark main/dashboard content as aria-hidden for accessibility when overlay open
        const targets = ['main', '#'+WRAPPER_ID, 'header', 'footer', '.container-fluid'];
        targets.forEach(sel => {
          const el = qs(sel);
          if (!el) return;
          if (hide) el.setAttribute('aria-hidden', 'true'); else el.removeAttribute('aria-hidden');
        });
      }

      // focus trap (minimal)
      let releaseFocusTrap = null, previouslyFocused = null;
      function trapFocusWithinSidebar() {
        const s = sidebarEl(); if (!s) return () => {};
        const focusables = Array.from(s.querySelectorAll('a,button,input,select,textarea,[tabindex]:not([tabindex="-1"])')).filter(Boolean);
        if (focusables.length === 0) return () => {};
        const first = focusables[0], last = focusables[focusables.length - 1];
        previouslyFocused = document.activeElement;
        first.focus();
        function onKey(e){
          if (e.key === 'Tab') {
            if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
            else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
          }
          if (e.key === 'Escape') {
            closeMobileSidebar();
          }
        }
        document.addEventListener('keydown', onKey);
        return function(){ document.removeEventListener('keydown', onKey); if (previouslyFocused && previouslyFocused.focus) previouslyFocused.focus(); };
      }

      function openMobileSidebar() {
        const s = sidebarEl(); if (!s) return;
        s.classList.add(SIDEBAR_OPEN_CLASS);
        document.body.classList.add(BODY_OVERLAY_CLASS);
        document.body.style.overflow = 'hidden';
        // show backdrop with fade
        backdrop.style.display = 'block';
        backdrop.style.pointerEvents = 'auto';
        requestAnimationFrame(()=> backdrop.style.opacity = '1');
        setToggleAria(true);
        setMainAriaHidden(true);
        releaseFocusTrap = trapFocusWithinSidebar();
      }

      function closeMobileSidebar() {
        const s = sidebarEl(); if (s) s.classList.remove(SIDEBAR_OPEN_CLASS);
        document.body.classList.remove(BODY_OVERLAY_CLASS);
        document.body.style.overflow = '';
        // hide backdrop cleanly and disable pointer events immediately so clicks don't get swallowed
        backdrop.style.opacity = '0';
        backdrop.style.pointerEvents = 'none';
        setTimeout(()=> {
          if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display = 'none';
        }, 220);
        setToggleAria(false);
        setMainAriaHidden(false);
        if (releaseFocusTrap) { releaseFocusTrap(); releaseFocusTrap = null; }
      }

      function toggleDesktopSidebar() {
        const s = sidebarEl(); if (!s) return;
        const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
        const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin);
        // update CSS var so layout + navbar follow
        document.documentElement.style.setProperty('--sidebar-width', isMin ? (SIDEBAR_MIN_WIDTH) : (SIDEBAR_OPEN_WIDTH));
        // toggle class on navbar for CSS fallback
        const nav = navbarEl(); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
        document.dispatchEvent(new CustomEvent('sidebarToggle', { detail: { minimized: isMin } }));
        setTimeout(() => window.dispatchEvent(new Event('resize')), 220);
      }

      function handleToggleEvent(e) {
        // If this is a click that immediately follows a touch, ignore it
        if (e && e.type === 'click' && (Date.now() - lastTouchAt) < TOUCH_CLICK_GAP) {
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

      // Prefer pointerdown for touch responsiveness, but dedupe with subsequent click
      document.addEventListener('pointerdown', function (ev) {
        if (ev.pointerType === 'touch' || ev.pointerType === 'pen') {
          const toggle = ev.target.closest(TOGGLE_SELECTORS);
          if (toggle) {
            lastTouchAt = Date.now();
            handleToggleEvent(ev);
          }
        }
      }, { passive: true });

      // Click handler for mouse/keyboard OR synthetic click (ignored when recent touch)
      document.addEventListener('click', function (ev) {
        const toggle = ev.target.closest(TOGGLE_SELECTORS);
        if (toggle) {
          handleToggleEvent(ev);
          return;
        }

        const s = sidebarEl();

        // If sidebar is open (mobile overlay), clicking outside the sidebar closes it.
        if (isMobile() && document.body.classList.contains(BODY_OVERLAY_CLASS)) {
          const insideSidebar = !!ev.target.closest(SIDEBAR_SELECTORS);
          const clickedModalOrFocusable = !!ev.target.closest('.modal, .modal *');
          if (!insideSidebar && !clickedModalOrFocusable) {
            closeMobileSidebar();
          }
        }

        // On desktop, if sidebar is expanded (i.e. NOT minimized), clicking outside should minimize it.
        if (!isMobile() && s && !s.classList.contains(SIDEBAR_MIN_CLASS)) {
          const insideSidebar = !!ev.target.closest(SIDEBAR_SELECTORS);
          const insideToggle = !!ev.target.closest(TOGGLE_SELECTORS);
          const clickedModalOrFocusable = !!ev.target.closest('.modal, .modal *');
          if (!insideSidebar && !insideToggle && !clickedModalOrFocusable) {
            // minimize (toggle) the sidebar
            toggleDesktopSidebar();
          }
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
        const inside = e.target.closest(SIDEBAR_SELECTORS);
        if (!inside) return;
        const anchor = e.target.closest('a');
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
            document.documentElement.style.setProperty('--sidebar-width', isMin ? SIDEBAR_MIN_WIDTH : SIDEBAR_OPEN_WIDTH);
            // ensure navbar class sync
            const nav = navbarEl(); if (nav) nav.classList.toggle('sidebar-minimized', !!isMin);
          }
        }, 120);
      });

      // If page initially had sidebar-open, ensure backdrop visible
      if (document.body.classList.contains(BODY_OVERLAY_CLASS)) {
        backdrop.style.display = 'block';
        backdrop.style.opacity = '1';
        backdrop.style.pointerEvents = 'auto';
        document.body.style.overflow = 'hidden';
      }

      // Provide fallback toggle button if none exists
      (function ensureFallbackToggle() {
        if (qs(TOGGLE_SELECTORS)) return;
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
      })();

    })();
  </script>

  <script>
    // ---------- placeholder data structures used by demo handlers ----------
    const studentData = {}; // kept for legacy demo functions but main list comes from AJAX
    const attendanceData = {...studentData};

    // ---------- render helpers for tables (filled by AJAX) ----------
    function renderTables(){ /* kept for compatibility; main list is fetched via AJAX fetchPage() */ }

    // ---------- View student: fetch from server and show attractive modal ----------
    function viewStudent(id) {
      if (!id) return;
      $('#viewGeneralHtml,#viewFeesHtml,#viewContactHtml,#viewStudentSmall').html('');
      $('#viewName,#viewLevel,#viewContact,#viewCenter').text('Loading...');

      $.ajax({
        url: '<?php echo base_url("admin/get_student_by_id/"); ?>' + id,
        method: 'GET',
        dataType: 'json'
      }).done(function(res) {
        if (!res || !res.success) {
          Swal.fire('Not found','Student not found or access denied','error');
          return;
        }
        const s = res.student;

        // header meta
        $('#viewName').text(s.name || '—');
        $('#viewLevel').text((s.student_progress_category || s.level) ? ('Level: ' + (s.student_progress_category || s.level)) : 'Level: —');
        $('#viewContact').text('Contact: ' + (s.contact || '—'));
        // Note: this will be replaced by name via lookup if available (handled below in initDynamic)
        $('#viewCenter').text('Center: ' + (s.center || s.center_id || '—'));
        $('#viewStudentSmall').text('ID: ' + (s.id || '-') + ' • Status: ' + (s.status || '-'));

        // General
        const generalHtml = `
          <p><strong>Parent:</strong> ${s.parent_name || '-' } <small class="text-muted">(${s.emergency_contact || '-'})</small></p>
          <p><strong>DOB:</strong> ${s.dob || '-'}</p>
          <p><strong>Address:</strong> ${s.address || '-'}</p>
          <p><strong>Batch:</strong> ${s.batch || s.batch_id || '-'} ${s.batch_time ? ' • ' + s.batch_time : ''}</p>
          <p><strong>Coach:</strong> ${s.coach || '-'}</p>
          <p><strong>Coordinator:</strong> ${s.coordinator || '-'} ${s.coordinator_phone ? ' • ' + s.coordinator_phone : ''}</p>
        `;
        $('#viewGeneralHtml').html(generalHtml);

        // Fees
        const feesHtml = `
          <p><strong>Total:</strong> ₹${s.total_fees || '0'}</p>
          <p><strong>Paid:</strong> ₹${s.paid_amount || '0'}</p>
          <p><strong>Remaining:</strong> ₹${s.remaining_amount || '0'}</p>
          <p><strong>Payment Method:</strong> ${s.payment_method || '-'}</p>
        `;
        $('#viewFeesHtml').html(feesHtml);

        // Contacts
        const contactHtml = `
          <p><strong>Email:</strong> ${s.email || '-'}</p>
          <p><strong>Emergency:</strong> ${s.emergency_contact || '-'}</p>
          <p><strong>Admission:</strong> ${s.admission_date || '-'} • <strong>Joining:</strong> ${s.joining_date || '-'}</p>
          <p><strong>Last attendance:</strong> ${s.last_attendance || '-'}</p>
        `;
        $('#viewContactHtml').html(contactHtml);

        // wire Edit/Delete action buttons (use current id)
        $('#viewEditBtn').off('click').on('click', function(){
          $('#viewStudentModal').modal('hide');
          setTimeout(()=> editStudent(s.id), 200);
        });

        $('#viewDeleteBtn').off('click').on('click', function(){
          Swal.fire({
            title: 'Delete student?',
            text: 'This will permanently remove the student record.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete'
          }).then(result => {
            if (result.isConfirmed) {
              $.ajax({
                url: '<?php echo base_url("admin/delete_student_ajax/"); ?>' + s.id,
                method: 'POST',
                dataType: 'json'
              }).done(function(resp){
                if (resp && resp.success) {
                  Swal.fire('Deleted','Student removed','success');
                  // refresh list
                  resetAndLoad();
                  $('#viewStudentModal').modal('hide');
                } else {
                  Swal.fire('Error', (resp && resp.message) || 'Could not delete', 'error');
                }
              }).fail(function(){ Swal.fire('Error','Request failed','error'); });
            }
          });
        });

        // show modal
        const modal = new bootstrap.Modal(document.getElementById('viewStudentModal'));
        modal.show();
      }).fail(function(){
        Swal.fire('Error','Failed to fetch student','error');
      });
    }

    // ---------- Edit student: fetch details & show edit modal, submit via AJAX ----------
    function editStudent(id) {
      if (!id) return;
      $.ajax({
        url: '<?php echo base_url("admin/get_student_by_id/"); ?>' + id,
        method: 'GET',
        dataType: 'json'
      }).done(function(res){
        if (!res || !res.success) { Swal.fire('Not found','Student not found','error'); return; }
        const s = res.student;
        $('#editStudentId').val(s.id || '');
        $('#editStudentName').val(s.name || '');
        $('#editStudentContact').val(s.contact || '');
        $('#editStudentParent').val(s.parent_name || '');
        $('#editStudentEmergency').val(s.emergency_contact || '');
        $('#editStudentEmail').val(s.email || '');
        $('#editStudentDob').val(s.dob || '');
        $('#editStudentAddress').val(s.address || '');
        $('#editStudentLevel').val(s.student_progress_category || '');

        const modal = new bootstrap.Modal(document.getElementById('editStudentModal'));
        modal.show();
      }).fail(function(){ Swal.fire('Error','Could not load student','error'); });
    }

    // handle edit form submit via AJAX
    $('#editStudentForm').on('submit', function(e){
      e.preventDefault();
      const fd = $(this).serialize();
      $.ajax({
        url: '<?php echo base_url("admin/update_student_ajax"); ?>',
        method: 'POST',
        data: fd,
        dataType: 'json'
      }).done(function(res){
        if (res && res.success) {
          Swal.fire({icon:'success',title:'Saved',timer:1200,showConfirmButton:false});
          bootstrap.Modal.getInstance(document.getElementById('editStudentModal')).hide();
          resetAndLoad();
        } else {
          Swal.fire('Error', (res && res.message) || 'Save failed','error');
        }
      }).fail(function(){ Swal.fire('Error','Request failed','error'); });
    });

    // deleteStudent still used in table action (calls server)
    function deleteStudent(id){
      if(!id) return;
      Swal.fire({title:`Delete?`,icon:'warning',showCancelButton:true,confirmButtonText:'Yes'}).then(res=>{
        if(res.isConfirmed){
          $.ajax({
            url: '<?php echo base_url("admin/delete_student_ajax/"); ?>' + id,
            method: 'POST',
            dataType: 'json'
          }).done(function(resp){
            if(resp && resp.success){ Swal.fire('Deleted','', 'success'); resetAndLoad(); }
            else Swal.fire('Error', (resp && resp.message) || 'Failed', 'error');
          }).fail(()=> Swal.fire('Error','Request failed','error'));
        }
      });
    }

    // ---------- Chart init (keeps responsiveness) ----------
    function initChart(){
      const ctx=document.getElementById('studentChart');
      new Chart(ctx,{type:'doughnut',data:{labels:['Beginner','Intermediate','Advanced'],datasets:[{data:[30,40,30],backgroundColor:['#ff6b6b','#ffeb3b','#4ecdc4'],cutout:'70%'}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}}}});
    }

    // ---------- AJAX-driven students list + attendance + stats (same logic as before) ----------
    (function initDynamic() {
      const BASE_STATS_URL = '<?php echo base_url("admin/get_center_stats"); ?>';
      const BASE_STUDENTS_URL = '<?php echo base_url("admin/get_students_ajax"); ?>';
      const BASE_ATTENDANCE_URL = '<?php echo base_url("admin/get_attendance_ajax"); ?>';
      const BASE_CHART_URL = '<?php echo base_url("admin/get_students_chart"); ?>';

      // --- NEW: lookup maps for center & batch names (frontend fallback) ---
      let CENTER_MAP = {}, BATCH_MAP = {};
      function fetchLookups() {
        const CENTERS_URL = '<?php echo base_url("admin/get_centers_list"); ?>';
        const BATCHES_URL = '<?php echo base_url("admin/get_batches_list"); ?>';

        $.getJSON(CENTERS_URL).done(function(res){
          if(res && res.success && Array.isArray(res.centers)){
            res.centers.forEach(c => { CENTER_MAP[String(c.id)] = c.name || c.center_name || c.title || c.name; });
            // Also populate add/edit select options if present
            if($('#addStudentCenter').length){
              $('#addStudentCenter').empty().append('<option value="">-- Select Center --</option>');
              res.centers.forEach(c => { $('#addStudentCenter').append(`<option value="${c.id}">${$('<div/>').text(c.name||c.center_name||c.title||'').html()}</option>`); });
            }
          }
        }).fail(()=> console.warn('Could not load centers lookup'));

        $.getJSON(BATCHES_URL).done(function(res){
          if(res && res.success && Array.isArray(res.batches)){
            res.batches.forEach(b => { BATCH_MAP[String(b.id)] = b.name || b.batch_name || b.title || b.name; });
            if($('#addStudentBatch').length){
              $('#addStudentBatch').empty().append('<option value="">-- Select Batch --</option>');
              res.batches.forEach(b => { $('#addStudentBatch').append(`<option value="${b.id}">${$('<div/>').text(b.name||b.batch_name||b.title||'').html()}</option>`); });
            }
          }
        }).fail(()=> console.warn('Could not load batches lookup'));
      }

      let currentFilter = { type: 'total', status: null, center_name: null };
      function setActiveCard(type) { $('.card-stat').removeClass('active-filter'); if (type) $('#stat-' + type).addClass('active-filter'); }
      function handleStat(type) {
        if (!type) type='total';
        currentFilter.type = type; currentFilter.status=null; currentFilter.center_name=null;
        if (type==='active') currentFilter.status='Active'; else if (type==='deactive') currentFilter.status='Deactive'; else if (type==='center') currentFilter.center_name = $('#centerName').text();
        setActiveCard(type); resetAndLoad();
      }
      window.handleStat = handleStat;

      function fetchCenterStats(){
        $.getJSON(BASE_STATS_URL).done(function(res){
          if (res && res.success) {
            $('#centerName').text(res.center_name);
            $('#totalCount').text(res.total_students);
            $('#activeCount').text(res.active_students||0);
            $('#deactiveCount').text(res.deactive_students||0);
          }
        });
      }

      function fetchAttendance(){
        $.getJSON(BASE_ATTENDANCE_URL).done(function(res){
          const tbody = $('#attendanceTableBody'); tbody.empty();
          if(!res || !res.success || !res.attendance || res.attendance.length===0){ tbody.html('<tr><td colspan="4" class="loading-row">No attendance records</td></tr>'); return; }
          res.attendance.forEach(r=>{
            const statusText = r.status || '';
            const badgeClass = (statusText.toLowerCase()==='present') ? 'status-complete' : 'status-pending';
            // r.batch may already be a name; fallback to lookup
            const batchDisplay = r.batch || BATCH_MAP[String(r.batch_id || r.batch)] || (r.batch_id ? ('#'+r.batch_id) : '-');
            tbody.append(`<tr><td>${$('<div/>').text(r.name||'N/A').html()}</td><td>${$('<div/>').text(batchDisplay||'-').html()}</td><td>${$('<div/>').text(r.level||'-').html()}</td><td><span class="status-badge ${badgeClass}">${$('<div/>').text(statusText).html()}</span></td></tr>`);
          });
        }).fail(()=> console.error('Failed attendance'));
      }

      let chartInstance = null;
      function fetchChart(){
        $.getJSON(BASE_CHART_URL).done(function(res){
          if(!res || !res.success) return;
          const ctx=document.getElementById('studentChart');
          if(chartInstance && chartInstance.destroy) chartInstance.destroy();
          chartInstance = new Chart(ctx, { type:'doughnut', data:{ labels: res.labels || ['Beginner','Intermediate','Advanced'], datasets:[{ data: res.data || [0,0,0], backgroundColor:['#ff6b6b','#ffeb3b','#4ecdc4'], cutout:'70%'}]}, options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}}});
          setTimeout(()=>{ try{ chartInstance.resize(); }catch(e){} },50);
        }).fail(()=>console.error('chart fail'));
      }

      // students list pagination/search
      const perPage=10; let page=1; let loading=false; let noMore=false; let currentSearch='';
      const $container = $('.students-table-container'); const $tbody = $('#studentsTableBody'); const $info = $('#studentsInfo'); const $loadMore = $('#loadMoreBtn');
      const $searchInp = $('#studentSearch'); const $searchBtn = $('#studentSearchBtn'); const $clearBtn = $('#studentClearBtn');

      function esc(t){ return $('<div/>').text(t||'').html(); }

      // ---------- UPDATED renderStudents: use names (server-provided or lookup) ----------
      function renderStudents(rows, append=true){
        if(!append) $tbody.empty();
        if(rows.length===0 && !append){ $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>'); return; }
        const html = rows.map(s => {
          const category = s.category || s.status || '';
          const badgeClass = category === 'Complete' ? 'status-complete' : 'status-pending';
          // Prefer server-provided name fields, else lookup, else fallback id
          const centerDisplay = s.center_name || s.center || CENTER_MAP[String(s.center_id || s.center)] || (s.center_id ? ('#'+s.center_id) : '-');
          const batchDisplay  = s.batch_name  || s.batch  || BATCH_MAP[String(s.batch_id || s.batch)]  || (s.batch_id ? ('#'+s.batch_id) : '-');

          return `<tr>
            <td>${esc(s.name)}</td>
            <td>${esc(s.contact)}</td>
            <td>${esc(centerDisplay)}</td>
            <td>${esc(batchDisplay)}</td>
            <td>${esc(s.level)}</td>
            <td><span class="status-badge ${badgeClass}">${esc(category)}</span></td>
            <td><div class="d-flex gap-1">
              <button class="btn btn-sm btn-outline-secondary" onclick="viewStudent('${s.id}')"><i class="bi bi-eye"></i></button>
              <button class="btn btn-sm btn-outline-success" onclick="editStudent('${s.id}')"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-sm btn-outline-danger" onclick="deleteStudent('${s.id}')"><i class="bi bi-trash"></i></button>
            </div></td>
          </tr>`;
        }).join('');
        $tbody.append(html);
      }

      function fetchPage(p, opts={append:true}){
        if(loading || noMore) return;
        loading = true; $info.text('Loading...'); $loadMore.prop('disabled', true).text('Loading...');
        const reqData = { page: p, per_page: perPage, search: currentSearch };
        if (currentFilter.status) reqData.status = currentFilter.status;
        if (currentFilter.center_name) reqData.center_name = currentFilter.center_name;

        $.ajax({ url: BASE_STUDENTS_URL, method:'GET', dataType:'json', data: reqData })
          .done(function(res){
            if(!res || !res.success){ if(p===1) $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>'); $info.text((res && res.message) || 'Error'); noMore = true; return; }
            const total = res.total || 0; const students = res.students || [];
            const showed = (p-1)*perPage + students.length;
            renderStudents(students, opts.append);
            if(showed >= total) { noMore = true; $loadMore.hide(); $info.text(`${showed} of ${total}`); } else { noMore = false; $loadMore.show(); $info.text(`${showed} of ${total}`); }
            if(p===1 && students.length===0) $tbody.html('<tr><td colspan="7" class="loading-row">No students found</td></tr>');
          }).fail(function(){ $info.text('Request failed'); })
          .always(function(){ loading=false; $loadMore.prop('disabled', false).text('Load more'); });
      }

      function resetAndLoad(){ page=1; noMore=false; $tbody.empty(); fetchPage(page, {append:true}); }

      $loadMore.on('click', function(){ if(noMore||loading) return; page+=1; fetchPage(page,{append:true}); });

      $container.on('scroll', function(){
        const el = this;
        if(noMore || loading) return;
        if (el.scrollHeight - el.scrollTop - el.clientHeight < 200) { page += 1; fetchPage(page, {append:true}); }
      });

      let debounceTimer = null;
      function doSearch(q){ currentSearch = q||''; page=1; noMore=false; $tbody.empty(); fetchPage(page, {append:true}); }
      function debounceSearch(q){ clearTimeout(debounceTimer); debounceTimer = setTimeout(()=> doSearch(q), 300); }
      $searchInp.on('input', function(){ debounceSearch($(this).val()); });
      $searchBtn.on('click', function(){ doSearch($searchInp.val()); });
      $clearBtn.on('click', function(){ $searchInp.val(''); doSearch(''); });

      // initial fetches
      fetchLookups();           // <-- ensure lookups are loaded (so names are available)
      fetchCenterStats();
      resetAndLoad();
      initChart();
      fetchChart();
      fetchAttendance();

      setActiveCard('total');

      $(window).on('resize', function(){ if(chartInstance && typeof chartInstance.resize==='function') chartInstance.resize(); });

      // expose resetAndLoad for external calls
      window.resetAndLoad = resetAndLoad;
    })();
  </script>
</body>
</html>
