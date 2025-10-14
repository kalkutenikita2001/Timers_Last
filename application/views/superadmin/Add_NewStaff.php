<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add New Staff</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      /* match Staff Management */
      --accent:#ff4040; 
      --accent-dark:#470000; 
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --sidebar-width:250px; /* toggled by controller */
    }

    body{ 
      background:var(--muted); 
      color:#111; 
      overflow-x:hidden; 
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;
    }

    /* layout (sidebar-aware) */
   /* Fit content to screen, sidebar-aware */
*,
*::before,
*::after { box-sizing: border-box; }

html, body { width:100%; max-width:100%; overflow-x:hidden; }

#main-content{
  margin-left: var(--sidebar-width);          /* 250px when open */
  width: calc(100vw - var(--sidebar-width));  /* keep inside the viewport */
  padding: 20px;
  min-height: 100vh;
  transition: .25s;
  overflow-x: hidden;                          /* safety belt */
}
#main-content.minimized{
  margin-left: 60px;
  width: calc(100vw - 60px);
}

/* Mobile: sidebar overlays, content goes full width */
@media (max-width: 991.98px){
  #main-content{
    margin-left: 0 !important;
    width: 100vw;
    padding: 12px;
  }
}

    /* header-ish hero (lightweight) */
    .page-hero{
      border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    /* toolbar */
    .toolbar{
      position:sticky; top:12px; z-index:5;
      background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px;
      box-shadow:0 8px 24px rgba(0,0,0,.05);
    }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    /* unified global search */
    .global-search { max-width: 600px; margin: 0 auto; transition: all .25s ease; }
    .global-search .form-control { height: 42px; border-radius: 50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .form-control:focus { border-color: var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }
    .global-search .input-group-text { border-radius: 50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search:hover { transform: scale(1.01); }

    /* card + table styling */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }
    .clickable-row { cursor:pointer; transition: background-color .2s ease; }
    .clickable-row:hover { background-color: rgba(255,64,64,.05); }

    /* badges (reuse) */
    .status-badge{ border-radius:999px; padding:.25rem .6rem; font-size:.75rem; font-weight:700; }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-deactive{ background:#e2e3e5; color:#41464b; }

    /* switches (kept) */
    .switch { position:relative; display:inline-block; width:46px; height:24px; }
    .switch input{ display:none; }
    .slider{ position:absolute; left:0; top:0; right:0; bottom:0; background:#dcdcdc; border-radius:24px; transition:.25s; }
    .slider:before{ content:""; position:absolute; left:3px; top:3px; width:18px; height:18px; background:#fff; border-radius:50%; transition:.25s; }
    .switch input:checked + .slider{ background:#28a745; }
    .switch input:checked + .slider:before{ transform:translateX(22px); }

    /* modal header gradient */
    .modal-header.bg-danger { background: var(--grad) !important; color:#fff; }
  </style>
</head>
<body>
  <?php  $this->load->view('superadmin/Include/Sidebar');  ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <!-- lightweight hero to align visuals with list page -->
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">Add & Manage Staff</div>
        <div class="d-flex flex-wrap gap-2">
          <!-- <button class="btn btn-ghost" id="openFilters"><i class="bi bi-funnel me-1"></i>Filters</button>
          <button class="btn btn-primary" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button> -->
        </div>
      </div>
    </div>

    <!-- toolbar with global search + count -->
    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search staff by name, email, role, center or status...">
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="badge rounded-pill bg-light text-dark px-3 py-2">Total <b id="staffCount">1</b></span>
        </div>
      </div>
    </div>

    <ul class="nav nav-tabs" id="staffTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overviewTab" type="button" role="tab">Overview</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staffTab" type="button" role="tab">Staff</button>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Overview tab -->
      <div class="tab-pane fade show active" id="overviewTab" role="tabpanel" aria-labelledby="overview-tab">
        <div class="card-lite p-3 mt-3" id="overviewWrap">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="mb-0">Staff Overview</h5>
            <small class="text-muted" id="overviewLastUpdated"></small>
          </div>
          <div id="overviewContent">
            <p class="text-center text-muted mb-0">No staff details available. Click "Send Details" from Salary Management (or add a staff record).</p>
          </div>
        </div>
      </div>

      <!-- Staff tab -->
      <div class="tab-pane fade" id="staffTab" role="tabpanel" aria-labelledby="staff-tab">
        <div class="card-lite p-3 mt-3">
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
            <div class="filter-options">
              <button class="btn btn-ghost btn-sm active" data-filter="all">All</button>
              <button class="btn btn-ghost btn-sm" data-filter="active">Active</button>
              <button class="btn btn-ghost btn-sm" data-filter="deactive">Deactive</button>
            </div>
            <button class="btn btn-primary btn-sm" id="addStaffBtn2"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle" id="staffTable">
              <thead>
                <tr>
                  <th style="width:60px">Sr No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Joining Date</th>
                  <th>Role</th>
                  <th>Centers</th>
                  <th>Slots</th>
                  <th class="text-end" style="width:110px">Salary (₹)</th>
                  <th class="text-center" style="width:120px">Actions</th>
                  <th class="text-center" style="width:90px">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr class="clickable-row" data-status="active">
                  <td>1</td>
                  <td>John Doe</td>
                  <td>john@example.com</td>
                  <td>9876543210</td>
                  <td>2023-01-10</td>
                  <td>Coach</td>
                  <td>Center A</td>
                  <td>6-8 AM</td>
                  <td class="text-end">25000</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button class="btn btn-ghost btn-sm viewBtn" title="View"><i class="bi bi-eye"></i></button>
                      <button class="btn btn-ghost btn-sm editBtn" title="Edit"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-ghost btn-sm deleteBtn" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                    </div>
                  </td>
                  <td class="text-center">
                    <label class="switch">
                      <input type="checkbox" class="statusToggle" checked>
                      <span class="slider"></span>
                    </label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Staff Modal -->
  <div class="modal fade" id="staffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="staffModalLabel">Add Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="staffForm" autocomplete="off">
            <div class="row g-2 mb-3">
              <div class="col-md-6"><input type="text" class="form-control" name="name" placeholder="Enter Staff Name" required></div>
              <div class="col-md-6"><input type="email" class="form-control" name="email" placeholder="Staff Email" required></div>
            </div>
            <div class="row g-2 mb-3">
              <div class="col-md-6"><input type="text" class="form-control" name="contact" placeholder="Staff Contact" required></div>
              <div class="col-md-6"><input type="date" class="form-control" name="joining_date" required></div>
            </div>
            <div class="row g-2 mb-3">
              <div class="col-md-6"><input type="number" class="form-control" name="salary" placeholder="Enter Salary" required></div>
              <div class="col-md-6">
                <select class="form-select" name="role" id="roleSelect" required>
                  <option value="">Select Role</option>
                  <option value="Coach">Coach</option>
                  <option value="Admin">Admin</option>
                  <option value="Coordinator">Coordinator</option>
                  <option value="Manager">Manager</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label class="fw-bold mb-2">Select Centers:</label>
              <div class="d-flex flex-wrap gap-3">
                <div><input type="checkbox" class="center-check" value="Center A"> Center A</div>
                <div><input type="checkbox" class="center-check" value="Center B"> Center B</div>
                <div><input type="checkbox" class="center-check" value="Center C"> Center C</div>
                <div><input type="checkbox" class="center-check" value="Center D"> Center D</div>
              </div>
            </div>
            <div class="mb-3" id="slotSection" style="display:none;">
              <label class="fw-bold mb-2">Select Slots:</label>
              <div class="d-flex flex-wrap gap-3">
                <div><input type="checkbox" class="slot-check" value="6-8 AM"> 6-8 AM</div>
                <div><input type="checkbox" class="slot-check" value="8-10 AM"> 8-10 AM</div>
                <div><input type="checkbox" class="slot-check" value="5-7 PM"> 5-7 PM</div>
                <div><input type="checkbox" class="slot-check" value="7-9 PM"> 7-9 PM</div>
              </div>
            </div>
            <div class="text-end"><button type="submit" class="btn btn-primary">Save Staff</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- View Profile Modal -->
  <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="text-center p-3" style="border-radius:10px;background:linear-gradient(145deg,#fff,#f6f6f6);box-shadow:0 6px 16px rgba(0,0,0,.04)">
          <h5 id="profileName" class="text-danger fw-bold mb-2">Staff Name</h5>
          <div class="text-start">
            <p><strong>Email:</strong> <span id="profileEmail"></span></p>
            <p><strong>Contact:</strong> <span id="profileContact"></span></p>
            <p><strong>Joining Date:</strong> <span id="profileDate"></span></p>
            <p><strong>Role:</strong> <span id="profileRole"></span></p>
            <p><strong>Centers:</strong> <span id="profileCenters"></span></p>
            <p><strong>Slots:</strong> <span id="profileSlots"></span></p>
          </div>
          <div id="profileSalary"></div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar toggle controller (reused, with wrapper id added) -->
  <script>
  (function () {
    const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['main-content','dashboardWrapper','financeWrap']; // added main-content
    const DESKTOP_WIDTH_CUTOFF = 576;
    const SIDEBAR_OPEN_CLASS = 'active';
    const SIDEBAR_MIN_CLASS = 'minimized';
    const BODY_OVERLAY_CLASS = 'sidebar-open';
    const CSS_VAR = '--sidebar-width';
    const SIDEBAR_WIDTH_OPEN = '250px';
    const SIDEBAR_WIDTH_MIN = '60px';

    const qs = s => document.querySelector(s);
    const qsa = s => Array.from(document.querySelectorAll(s));
    const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.wrap') || qs('#main-content');
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

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

    let lock = false; const lockFor = (ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };
    let lastInteractionAt = 0; const INTERACTION_GAP = 700;

    function openMobileSidebar(){
      const s = sidebarEl(); if (!s) return;
      s.classList.add(SIDEBAR_OPEN_CLASS);
      document.body.classList.add(BODY_OVERLAY_CLASS);
      document.body.style.overflow = 'hidden';
      backdrop.style.display = 'block';
      requestAnimationFrame(()=> backdrop.style.opacity = '1');
    }
    function closeMobileSidebar(){
      const s = sidebarEl(); if (s) s.classList.remove(SIDEBAR_OPEN_CLASS);
      document.body.classList.remove(BODY_OVERLAY_CLASS);
      document.body.style.overflow = '';
      backdrop.style.opacity = '0';
      setTimeout(()=>{ if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display='none'; },220);
    }
    function toggleDesktopSidebar(){
      const s = sidebarEl(); if (!s) return;
      const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
      const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin);
      const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
      document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
      document.dispatchEvent(new CustomEvent('sidebarToggle', { detail:{ minimized:isMin }}));
      setTimeout(()=> window.dispatchEvent(new Event('resize')), 220);
    }
    function handleToggleEvent(e){
      if (e && e.type==='click' && (Date.now()-lastInteractionAt) < INTERACTION_GAP) return;
      if (lock) return;
      if (isMobile()){ lockFor(260); document.body.classList.contains(BODY_OVERLAY_CLASS) ? closeMobileSidebar() : openMobileSidebar(); }
      else { lockFor(260); toggleDesktopSidebar(); }
    }
    function wireToggleButtons(){
      const toggles = qsa(TOGGLE_SELECTORS);
      toggles.forEach(el=>{
        if (el.__sidebarToggleBound) return;
        el.__sidebarToggleBound = true;
        el.addEventListener('pointerdown', ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); }, {passive:true});
        el.addEventListener('click', ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); });
      });
    }

    document.addEventListener('pointerdown', function (ev) {
      if (ev.pointerType==='touch' || ev.pointerType==='pen') {
        const t = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
        if (t){ lastInteractionAt=Date.now(); handleToggleEvent(ev); }
      }
    }, {passive:true});
    document.addEventListener('click', function (ev) {
      const t = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
      if (t) handleToggleEvent(ev);
    });
    backdrop.addEventListener('click', function(){ if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });
    document.addEventListener('click', function(e){
      if (!isMobile()) return;
      const inside = e.target.closest && e.target.closest(SIDEBAR_SELECTORS);
      if (!inside) return;
      const a = e.target.closest && e.target.closest('a');
      if (a && a.getAttribute('href') && a.getAttribute('href') !== '#') { setTimeout(closeMobileSidebar,160); }
    });
    document.addEventListener('keydown', function(ev){ if (ev.key==='Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });

    let resizeTimer=null;
    window.addEventListener('resize', function(){
      clearTimeout(resizeTimer);
      resizeTimer=setTimeout(function(){
        if (!isMobile()){
          closeMobileSidebar();
          const s = sidebarEl();
          const isMin = s && s.classList.contains(SIDEBAR_MIN_CLASS);
          document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
        }
      },120);
    });

    if (document.body.classList.contains(BODY_OVERLAY_CLASS)) {
      backdrop.style.display='block'; backdrop.style.opacity='1'; document.body.style.overflow='hidden';
    }

    (function ensureFallbackToggle(){
      const qsN = s=>document.querySelector(s);
      if (qsN(TOGGLE_SELECTORS)){ wireToggleButtons(); return; }
      const navbar = qsN('.navbar, header, .main-header, .topbar');
      if (!navbar) return;
      const btn = document.createElement('button');
      btn.type='button'; btn.id='sidebarToggle'; btn.className='btn btn-sm btn-light sidebar-toggle'; btn.setAttribute('aria-label','Toggle sidebar'); btn.style.marginRight='8px';
      btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
      navbar.prepend(btn);
      wireToggleButtons();
    })();

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>

  <!-- Page logic (kept functionality, wired to new UI) -->
  <script>
    (function($){
      let editRow = null;

      function init() {
        updateCount();
        bindUI();
        loadOverviewFromStorage();
      }

      function updateCount(){
        const count = $("#staffTable tbody tr").length;
        $("#staffCount").text(count);
      }

      function bindUI(){
        const openAdd = () => {
          editRow = null;
          $("#staffForm")[0].reset();
          $("#slotSection").hide();
          $(".center-check, .slot-check").prop('checked', false);
          $("#staffModalLabel").text("Add Staff");
          new bootstrap.Modal(document.getElementById('staffModal')).show();
        };
        $("#addStaffBtn, #addStaffBtn2").off('click').on('click', openAdd);

        $("#roleSelect").off('change').on("change", function(){
          $(this).val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
        });

        $("#staffForm").off('submit').on("submit", function(e){
          e.preventDefault();
          const form = $(this);
          const name = form.find("input[name='name']").val().trim();
          const email = form.find("input[name='email']").val().trim();
          const contact = form.find("input[name='contact']").val().trim();
          const date = form.find("input[name='joining_date']").val();
          const role = form.find("#roleSelect").val();
          const salary = form.find("input[name='salary']").val().trim();
          const centers = $(".center-check:checked").map(function(){ return $(this).val(); }).get();
          const slots = $(".slot-check:checked").map(function(){ return $(this).val(); }).get();
          if (!name || !email || !contact){ Swal.fire("Missing info","Please fill required fields.","warning"); return; }

          const tbody = $("#staffTable tbody");
          if (editRow) {
            editRow.find("td:eq(1)").text(name);
            editRow.find("td:eq(2)").text(email);
            editRow.find("td:eq(3)").text(contact);
            editRow.find("td:eq(4)").text(date);
            editRow.find("td:eq(5)").text(role);
            editRow.find("td:eq(6)").text(centers.length?centers.join(", "):'-');
            editRow.find("td:eq(7)").text(role==="Coach" && slots.length?slots.join(", "):'-');
            editRow.find("td:eq(8)").text(salary||'-');
            Swal.fire("Updated!","Staff details updated successfully.","success");
          } else {
            const srNo = tbody.children("tr").length + 1;
            const rowHtml = `
              <tr class="clickable-row" data-status="active">
                <td>${srNo}</td>
                <td>${escapeHtml(name)}</td>
                <td>${escapeHtml(email)}</td>
                <td>${escapeHtml(contact)}</td>
                <td>${escapeHtml(date)}</td>
                <td>${escapeHtml(role)}</td>
                <td>${escapeHtml(centers.length?centers.join(", "):'-')}</td>
                <td>${escapeHtml(role==="Coach" && slots.length?slots.join(", "):'-')}</td>
                <td class="text-end">${escapeHtml(salary||'-')}</td>
                <td class="text-center">
                  <div class="btn-group">
                    <button class="btn btn-ghost btn-sm viewBtn" title="View"><i class="bi bi-eye"></i></button>
                    <button class="btn btn-ghost btn-sm editBtn" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-ghost btn-sm deleteBtn" title="Delete"><i class="bi bi-trash text-danger"></i></button>
                  </div>
                </td>
                <td class="text-center">
                  <label class="switch">
                    <input type="checkbox" class="statusToggle" checked>
                    <span class="slider"></span>
                  </label>
                </td>
              </tr>`;
            tbody.append($(rowHtml));
            Swal.fire("Added!","New staff added successfully.","success");
            updateCount();
          }
          const modalEl = document.getElementById('staffModal');
          const bsModal = bootstrap.Modal.getInstance(modalEl); if (bsModal) bsModal.hide();
          $("#staffForm")[0].reset(); $("#slotSection").hide(); editRow = null;
        });

        $(document).off('click', '.editBtn').on('click', '.editBtn', function(){
          const row = $(this).closest('tr'); editRow = row;
          $("#staffForm")[0].reset();
          $("#staffForm input[name='name']").val(row.find("td:eq(1)").text());
          $("#staffForm input[name='email']").val(row.find("td:eq(2)").text());
          $("#staffForm input[name='contact']").val(row.find("td:eq(3)").text());
          $("#staffForm input[name='joining_date']").val(row.find("td:eq(4)").text());
          $("#roleSelect").val(row.find("td:eq(5)").text());
          $("#staffForm input[name='salary']").val(row.find("td:eq(8)").text());
          const centersText = row.find("td:eq(6)").text();
          $(".center-check").prop('checked', false);
          if (centersText && centersText !== '-') centersText.split(',').map(s=>s.trim()).forEach(v=>{$(`.center-check[value="${v}"]`).prop('checked', true);});
          const slotsText = row.find("td:eq(7)").text();
          $(".slot-check").prop('checked', false);
          if (slotsText && slotsText !== '-') slotsText.split(',').map(s=>s.trim()).forEach(v=>{$(`.slot-check[value="${v}"]`).prop('checked', true);});
          $("#roleSelect").val()==="Coach" ? $("#slotSection").show() : $("#slotSection").hide();
          $("#staffModalLabel").text("Edit Staff");
          new bootstrap.Modal(document.getElementById('staffModal')).show();
        });

        $(document).off('click', '.viewBtn').on('click', '.viewBtn', function(){
          const row = $(this).closest('tr');
          $("#profileName").text(row.find("td:eq(1)").text());
          $("#profileEmail").text(row.find("td:eq(2)").text());
          $("#profileContact").text(row.find("td:eq(3)").text());
          $("#profileDate").text(row.find("td:eq(4)").text());
          $("#profileRole").text(row.find("td:eq(5)").text());
          $("#profileCenters").text(row.find("td:eq(6)").text());
          $("#profileSlots").text(row.find("td:eq(7)").text());
          const salary = row.find("td:eq(8)").text().trim();
          if (!salary || salary==='-' || salary==='0') $("#profileSalary").text("No salary assigned").addClass("no-salary");
          else $("#profileSalary").text("Income: ₹"+salary).removeClass("no-salary");
          new bootstrap.Modal(document.getElementById('viewProfileModal')).show();
        });

        $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', function(){
          const row = $(this).closest('tr');
          Swal.fire({ title:"Are you sure?", text:"This staff record will be deleted.", icon:"warning", showCancelButton:true, confirmButtonColor:"#d00000", cancelButtonColor:"#6c757d", confirmButtonText:"Delete" })
          .then(r=>{ if(r.isConfirmed){ row.remove(); $("#staffTable tbody tr").each(function(i){ $(this).find("td:eq(0)").text(i+1); }); updateCount(); Swal.fire("Deleted!","Staff record deleted successfully.","success"); }});
        });

        $(document).off('change', '.statusToggle').on('change', '.statusToggle', function(){
          const row = $(this).closest('tr');
          if ($(this).is(':checked')){ row.attr('data-status','active'); Swal.fire("Activated","Status changed to Active","success"); }
          else { row.attr('data-status','deactive'); Swal.fire("Deactivated","Status changed to Inactive","info"); }
        });

        $(document).off('click', '.filter-options .btn').on('click', '.filter-options .btn', function(){
          $(".filter-options .btn").removeClass('active');
          $(this).addClass('active');
          const filter = $(this).data('filter');
          $("#staffTable tbody tr").each(function(){
            const status = $(this).attr('data-status')||'active';
            if (filter==='all' || status===filter) $(this).show(); else $(this).hide();
          });
        });

        $("#searchInput").off('input').on('input', function(){
          const value = $(this).val().toLowerCase();
          $("#staffTable tbody tr").each(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
          });
        });
      }

      function loadOverviewFromStorage(){
        const data = localStorage.getItem('staffSalaryData');
        if (!data) return;
        try{ const staff = JSON.parse(data); const html = buildOverviewHtml(staff); $("#overviewContent").html(html); $("#overviewLastUpdated").text("Updated: "+ new Date().toLocaleString()); }catch(e){ console.warn('Invalid staff data'); }
      }

      function buildOverviewHtml(staff){
        const esc = s=>escapeHtml(s??'-');
        return `
          <div class="row g-2">
            <div class="col-12"><h6 class="mb-1">${esc(staff.name)}</h6><p class="text-muted mb-3">Latest salary snapshot from Salary Management</p></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Hours</div><div>${esc(staff.hours)}</div></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Days</div><div>${esc(staff.days)}</div></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Sessions</div><div>${esc(staff.sessions)}</div></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Rate</div><div>${esc(staff.rate)}</div></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Salary</div><div>${esc(staff.salary)}</div></div></div>
            <div class="col-sm-6 col-md-4 col-lg-3"><div class="card-lite p-2"><div class="small text-muted">Status</div><div>${esc(staff.status)}</div></div></div>
          </div>`;
      }

      function escapeHtml(unsafe){
        if (unsafe===null || unsafe===undefined) return '';
        return String(unsafe).replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'","&#039;");
      }

      $(function(){ init(); });
    })(jQuery);
  </script>
</body>
</html>
