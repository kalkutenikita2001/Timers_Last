<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Salary Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --accent:#ff4040; 
      --accent-dark:#470000;
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --success-light:#e8f5e8;
      --warning-light:#fff7e6;
      --sidebar-width:250px;
    }

    html, body { width:100%; max-width:100%; overflow-x:hidden; }
    body{ background:var(--muted); color:#111; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    #main-content{ margin-left:var(--sidebar-width); width:calc(100vw - var(--sidebar-width)); padding:20px; min-height:100vh; transition:.25s; }
    #main-content.minimized{ margin-left:60px; width:calc(100vw - 60px); }
    @media (max-width:991.98px){ #main-content{ margin-left:0!important; width:100vw; padding:12px; } }

    .page-hero{ 
      border-radius:16px; 
      border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px;
      overflow:hidden;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    .toolbar{ 
      position:sticky; 
      top:12px; 
      z-index:5; 
      background:#fff; 
      border:1px solid #e9ecef; 
      border-radius:12px; 
      padding:10px; 
      box-shadow:0 8px 24px rgba(0,0,0,.05); 
      overflow:hidden; 
    }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    .global-search{ max-width:660px; margin:0 auto; transition:all .25s ease; }
    .global-search .form-control{ height:42px; border-radius:50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .input-group-text{ border-radius:50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search .form-control:focus{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }

    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); overflow:hidden; }
    .table{ width:100%; }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }

    .action-icons .btn-icon{ 
      border:none; 
      background:transparent; 
      padding:6px; 
      margin:0 2px; 
      font-size:18px; 
      color:#dc3545; 
      transition: all 0.2s ease;
      border-radius: 4px;
    }
    .action-icons .btn-icon:hover{ 
      transform:scale(1.12); 
      color:#b71c1c; 
      background: rgba(255,64,64,0.1);
    }

    /* Disabled button styles */
    .mark-paid.disabled {
      opacity: 0.5;
      pointer-events: none;
      cursor: not-allowed;
    }
    .mark-paid.disabled i {
      color: #6c757d !important;
    }
    .mark-paid.disabled:hover {
      transform: none !important;
      color: #6c757d !important;
      background: transparent !important;
    }

    .badge-soft{ background:#fff; border:1px solid #e9ecef; padding:.35rem .6rem; border-radius:999px; }
    
    /* Status badge animations */
    .badge.text-bg-success {
      animation: pulse-success 2s infinite;
    }
    @keyframes pulse-success {
      0%, 100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
      50% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    }

    /* Overview cards with faint colors */
    .overview-card {
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }
    .overview-card:hover {
      transform: translateY(-2px);
    }
    .overview-card.bg-success {
      background: var(--success-light);
      color: #155724;
    }
    .overview-card.bg-success .card-body {
      background: var(--success-light);
    }
    .overview-card.bg-warning {
      background: var(--warning-light);
      color: #664d03;
    }
    .overview-card.bg-warning .card-body {
      background: var(--warning-light);
    }
    .overview-card .card-body {
      padding: 15px;
    }

    .swal2-confirm{ background:var(--accent)!important; border:0!important; }
    .swal2-cancel{ background:#6c757d!important; border:0!important; }
  </style>
</head>
<body>

  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <!-- Hero with Overview Button -->
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">
          <i class="fa-solid fa-sack-dollar me-2"></i>
          Salary Management
        </div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-primary" id="salaryOverviewBtn">
            <i class="fa-solid fa-chart-line me-1"></i>Salary Overview
          </button>
          <button class="btn btn-ghost" id="assignSalaryBtn">
            <i class="fa-solid fa-sack-dollar me-1"></i>Assign Salary
          </button>
        </div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search by staff, status or amount...">
          </div>
        </div>
        <span class="badge-soft">
          Total <b id="rowCount">0</b>
        </span>
      </div>
    </div>

    <!-- Table card -->
    <div class="card-lite p-2">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="salaryTable">
          <thead>
            <tr>
              <th style="width:72px">Sr No</th>
              <th>Staff Name</th>
              <th>Hours</th>
              <th>Days</th>
              <th>Sessions</th>
              <th>Rate</th>
              <th>Salary</th>
              <th>Status</th>
              <th class="text-center" style="width:200px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic content loaded by JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar Controller -->
  <script>
  (function () {
    const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['main-content','dashboardWrapper','financeWrap'];
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
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('#main-content');
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

    let backdrop = qs('.sidebar-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      Object.assign(backdrop.style,{
        position:'fixed', 
        inset:'0', 
        background:'rgba(0,0,0,.42)', 
        zIndex:'1070', 
        display:'none', 
        opacity:'0', 
        transition:'opacity .18s ease'
      });
      document.body.appendChild(backdrop);
    }

    let lock=false; 
    const lockFor=(ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };
    let lastInteractionAt=0; 
    const INTERACTION_GAP=700;

    function openMobileSidebar(){
      const s=sidebarEl(); 
      if(!s)return; 
      s.classList.add(SIDEBAR_OPEN_CLASS); 
      document.body.classList.add(BODY_OVERLAY_CLASS); 
      document.body.style.overflow='hidden'; 
      backdrop.style.display='block'; 
      requestAnimationFrame(()=>backdrop.style.opacity='1'); 
    }
    
    function closeMobileSidebar(){
      const s=sidebarEl(); 
      if(s) s.classList.remove(SIDEBAR_OPEN_CLASS); 
      document.body.classList.remove(BODY_OVERLAY_CLASS); 
      document.body.style.overflow=''; 
      backdrop.style.opacity='0'; 
      setTimeout(()=>{ 
        if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) 
          backdrop.style.display='none'; 
      },220); 
    }
    
    function toggleDesktopSidebar(){
      const s=sidebarEl(); 
      if(!s)return; 
      const isMin=s.classList.toggle(SIDEBAR_MIN_CLASS); 
      const w=wrapperEl(); 
      if(w) w.classList.toggle('minimized',isMin); 
      const nav=qs('.navbar'); 
      if(nav) nav.classList.toggle('sidebar-minimized',isMin); 
      document.documentElement.style.setProperty(CSS_VAR, isMin?SIDEBAR_WIDTH_MIN:SIDEBAR_WIDTH_OPEN); 
      document.dispatchEvent(new CustomEvent('sidebarToggle',{detail:{minimized:isMin}})); 
      setTimeout(()=>window.dispatchEvent(new Event('resize')),220); 
    }
    
    function handleToggleEvent(e){
      if(e&&e.type==='click'&&(Date.now()-lastInteractionAt)<INTERACTION_GAP) return; 
      if(lock) return; 
      if(isMobile()){ 
        lockFor(260); 
        document.body.classList.contains(BODY_OVERLAY_CLASS)?closeMobileSidebar():openMobileSidebar(); 
      } else { 
        lockFor(260); 
        toggleDesktopSidebar(); 
      } 
    }
    
    function wireToggleButtons(){
      qsa(TOGGLE_SELECTORS).forEach(el=>{
        if(el.__sidebarToggleBound) return; 
        el.__sidebarToggleBound=true; 
        el.addEventListener('pointerdown',ev=>{ 
          lastInteractionAt=Date.now(); 
          handleToggleEvent(ev); 
        },{passive:true}); 
        el.addEventListener('click',ev=>{ 
          lastInteractionAt=Date.now(); 
          handleToggleEvent(ev); 
        }); 
      }); 
    }

    document.addEventListener('pointerdown', function (ev) { 
      if(ev.pointerType==='touch'||ev.pointerType==='pen'){
        const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); 
        if(t){ 
          lastInteractionAt=Date.now(); 
          handleToggleEvent(ev); 
        } 
      } 
    }, {passive:true});
    
    document.addEventListener('click', function (ev) { 
      const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); 
      if(t) handleToggleEvent(ev); 
    });
    
    backdrop.addEventListener('click', function(){
      if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); 
    });
    
    document.addEventListener('click', function(e){
      if(!isMobile()) return; 
      const inside=e.target.closest&&e.target.closest(SIDEBAR_SELECTORS); 
      if(!inside) return; 
      const a=e.target.closest&&e.target.closest('a'); 
      if(a&&a.getAttribute('href')&&a.getAttribute('href')!=='#'){
        setTimeout(closeMobileSidebar,160); 
      } 
    });
    
    document.addEventListener('keydown', function(ev){
      if(ev.key==='Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) 
        closeMobileSidebar(); 
    });

    let resizeTimer=null; 
    window.addEventListener('resize', function(){
      clearTimeout(resizeTimer); 
      resizeTimer=setTimeout(function(){
        if(!isMobile()){
          closeMobileSidebar(); 
          const s=sidebarEl(); 
          const isMin=s && s.classList.contains('minimized'); 
          document.documentElement.style.setProperty(CSS_VAR, isMin?'60px':'250px'); 
        } 
      },120); 
    });

    if(document.body.classList.contains(BODY_OVERLAY_CLASS)){
      backdrop.style.display='block'; 
      backdrop.style.opacity='1'; 
      document.body.style.overflow='hidden'; 
    }

    (function ensureFallbackToggle(){
      const qsN=s=>document.querySelector(s); 
      if(qsN(TOGGLE_SELECTORS)){ 
        wireToggleButtons(); 
        return; 
      } 
      const navbar=qsN('.navbar, header, .main-header, .topbar'); 
      if(!navbar) return; 
      const btn=document.createElement('button'); 
      btn.type='button'; 
      btn.id='sidebarToggle'; 
      btn.className='btn btn-sm btn-light sidebar-toggle'; 
      btn.setAttribute('aria-label','Toggle sidebar'); 
      btn.style.marginRight='8px'; 
      btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>'; 
      navbar.prepend(btn); 
      wireToggleButtons(); 
    })();

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>

  <!-- Complete Salary Management Script -->
  <script>
  $(function(){
    // Global variables
    let editRow = null;

    // Load salary records on page load
    loadSalaryRecords();
    
    // Listen for changes from other tabs/windows
    window.addEventListener('storage', function(e) {
      if (e.key === 'salaryRecords') {
        loadSalaryRecords();
      }
    });
    
    window.addEventListener('staffAdded', function(e) {
      loadSalaryRecords();
      Swal.fire('New Staff Added!', `${e.detail.name} has been added to salary management.`, 'success');
    });
    
    window.addEventListener('staffDeleted', function(e) {
      loadSalaryRecords();
    });

    // Load and display salary records
    function loadSalaryRecords() {
      const salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      const tbody = $('#salaryTable tbody');
      tbody.empty();
      
      if (salaryRecords.length === 0) {
        tbody.html(`
          <tr>
            <td colspan="9" class="text-center text-muted py-4">
              <i class="fa-solid fa-users fa-2x mb-2 opacity-50"></i><br>
              No staff salary records found.<br>
              <small>Add staff from <strong>Staff Management</strong> page first.</small>
            </td>
          </tr>
        `);
      } else {
        salaryRecords.forEach((record, index) => {
          const isPaid = record.status?.toLowerCase() === 'paid';
          const markPaidClass = isPaid ? 'mark-paid disabled' : 'mark-paid';
          const paidAt = record.paidAt ? new Date(record.paidAt).toLocaleDateString() : '';
          
          const rowHtml = `
            <tr data-staff-id="${record.staffId}" data-email="${record.email}" data-paid-at="${paidAt}">
              <td>${index + 1}</td>
              <td>
                <strong>${escapeHtml(record.name)}</strong>
                ${isPaid ? '<i class="fa-solid fa-check-circle text-success ms-1"></i>' : ''}
              </td>
              <td>${record.hours || '0'}</td>
              <td>${record.days || '0'}</td>
              <td>${record.sessions || '0'}</td>
              <td>${record.rate || '₹0'}</td>
              <td class="fw-bold text-success">${record.salary || '₹0'}</td>
              <td>
                <span class="badge ${getStatusClass(record.status)}">
                  ${record.status || 'Pending'}
                </span>
                ${isPaid && paidAt ? `<br><small class="text-muted">${paidAt}</small>` : ''}
              </td>
              <td class="text-center action-icons">
                <button class="btn-icon delete-salary" title="Delete Salary" data-staff-id="${record.staffId}" data-email="${record.email}">
                  <i class="fa-solid fa-trash text-danger"></i>
                </button>
                <button class="btn-icon send-salary" title="Send Details" data-staff-id="${record.staffId}">
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
                <button class="btn-icon ${markPaidClass}" 
                        title="${isPaid ? 'Already Paid' : 'Mark as Paid'}" 
                        data-staff-id="${record.staffId}" 
                        ${isPaid ? 'disabled' : ''}>
                  <i class="fa-solid fa-sack-dollar"></i>
                </button>
                <button class="btn-icon view-salary" title="View Details" data-staff-id="${record.staffId}">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </td>
            </tr>`;
          tbody.append(rowHtml);
        });
      }
      
      updateRowCount();
    }

    function getStatusClass(status) {
      switch(status?.toLowerCase()) {
        case 'paid': return 'text-bg-success';
        case 'pending': return 'text-bg-warning';
        default: return 'text-bg-secondary';
      }
    }

    function updateRowCount() {
      $('#rowCount').text($('#salaryTable tbody tr:visible').length || 0);
    }

    function escapeHtml(unsafe) {
      if (unsafe === null || unsafe === undefined) return '';
      return String(unsafe)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    // Search functionality
    $('#searchInput').on('input', function(){
      const q = $(this).val().toLowerCase();
      $('#salaryTable tbody tr').each(function(){
        const hit = $(this).text().toLowerCase().indexOf(q) > -1;
        $(this).toggle(hit);
      });
      updateRowCount();
    });

    // Delete salary record
    $(document).on('click', '.delete-salary', function(){
      const row = $(this).closest('tr');
      const staffName = row.find('td:eq(1)').text().trim();
      const staffId = $(this).data('staff-id');
      
      Swal.fire({ 
        title: 'Delete Salary Record?',
        html: `<strong>${escapeHtml(staffName)}</strong>'s salary record will be permanently deleted.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if(result.isConfirmed){
          let salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
          salaryRecords = salaryRecords.filter(record => record.staffId !== staffId);
          localStorage.setItem('salaryRecords', JSON.stringify(salaryRecords));
          
          loadSalaryRecords();
          Swal.fire({ 
            title: 'Deleted!',
            text: `${staffName}'s salary record deleted successfully.`,
            icon: 'success',
            confirmButtonColor: '#28a745'
          });
        }
      });
    });

    // Send details to overview
    $(document).on('click', '.send-salary', function(){
      const row = $(this).closest('tr');
      const salaryData = {
        name: row.find('td:eq(1)').text().trim(),
        hours: row.find('td:eq(2)').text(),
        days: row.find('td:eq(3)').text(),
        sessions: row.find('td:eq(4)').text(),
        rate: row.find('td:eq(5)').text(),
        salary: row.find('td:eq(6)').text(),
        status: row.find('td:eq(7)').text().trim(),
        timestamp: new Date().toLocaleString()
      };
      
      localStorage.setItem('selectedSalaryData', JSON.stringify(salaryData));
      sessionStorage.setItem('salaryAction', 'view-details');
      
      Swal.fire({ 
        title: 'Details Sent!',
        text: `Salary details for ${salaryData.name} sent to Dashboard Overview.`,
        icon: 'success',
        confirmButtonColor: '#28a745',
        footer: '<button class="btn btn-primary btn-sm" onclick="$(\'#salaryOverviewBtn\').click(); Swal.close();">View in Dashboard</button>'
      });
    });

    // Enhanced Mark as Paid with disabled handling
    $(document).on('click', '.mark-paid:not(.disabled)', function(){
      const row = $(this).closest('tr');
      const staffId = $(this).data('staff-id');
      const staffName = row.find('td:eq(1)').text().trim();
      const currentHours = row.find('td:eq(2)').text() || 0;
      const currentDays = row.find('td:eq(3)').text() || 0;
      const currentSessions = row.find('td:eq(4)').text() || 0;
      const currentRate = parseInt(row.find('td:eq(5)').text().replace(/[₹,]/g,'')) || 0;
      const currentSalary = parseInt(row.find('td:eq(6)').text().replace(/[₹,]/g,'')) || 0;
      
      Swal.fire({
        title: `<h4 class="text-success mb-3">
                  <i class="fa-solid fa-sack-dollar me-2"></i>
                  Finalize Payment - ${escapeHtml(staffName)}
                </h4>`,
        html: `
          <div class="text-start p-3 bg-light rounded">
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label fw-bold">
                  Hours Worked
                </label>
                <input type="number" id="editHours" class="form-control" value="${currentHours}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">
                 Days Present
                </label>
                <input type="number" id="editDays" class="form-control" value="${currentDays}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">
                 Sessions
                </label>
                <input type="number" id="editSessions" class="form-control" value="${currentSessions}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">
                 Hourly Rate (₹)
                </label>
                <input type="number" id="editRate" class="form-control" value="${currentRate}" min="0" />
              </div>
              <div class="col-12">
                <label class="form-label fw-bold text-success">
                 Total Salary (₹)
                </label>
                <input type="number" id="editSalary" class="form-control border-success" value="${currentSalary}" min="1" />
                <small class="text-muted">Final amount to be paid this month</small>
              </div>
            </div>
            <hr class="my-3">
            <div class="alert alert-success">
              <i class="fa-solid fa-check-circle me-2"></i>
              <strong>Payment Confirmation:</strong> This will mark the salary as <span class="badge text-bg-success">PAID</span> and disable further edits.
            </div>
          </div>
        `,
        width: 600,
        showCancelButton: true,
        confirmButtonText: '<i class="fa-solid fa-check me-1"></i>Finalize & Mark Paid',
        confirmButtonColor: '#28a745',
        cancelButtonText: '<i class="fa-solid fa-times me-1"></i>Cancel',
        cancelButtonColor: '#6c757d',
        preConfirm: () => {
          const hours = $('#editHours').val() || '0';
          const days = $('#editDays').val() || '0';
          const sessions = $('#editSessions').val() || '0';
          const rate = $('#editRate').val() || '0';
          const salary = $('#editSalary').val() || '0';
          
          if (parseInt(salary) <= 0) {
            Swal.showValidationMessage('Total salary must be greater than 0');
            return false;
          }
          
          return { hours, days, sessions, rate, salary };
        }
      }).then((result) => {
        if(result.isConfirmed){
          let salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
          salaryRecords = salaryRecords.map(record => {
            if (record.staffId === staffId) {
              const updatedRecord = {
                ...record,
                hours: result.value.hours,
                days: result.value.days,
                sessions: result.value.sessions,
                rate: `₹${parseInt(result.value.rate).toLocaleString()}`,
                salary: `₹${parseInt(result.value.salary).toLocaleString()}`,
                status: 'Paid',
                paidAt: new Date().toISOString(),
                updatedAt: new Date().toISOString()
              };
              
              window.dispatchEvent(new CustomEvent('salaryPaid', { 
                detail: { staffId, staffName, amount: result.value.salary } 
              }));
              
              return updatedRecord;
            }
            return record;
          });
          
          localStorage.setItem('salaryRecords', JSON.stringify(salaryRecords));
          loadSalaryRecords();
          
          Swal.fire({ 
            title: '<i class="fa-solid fa-check-circle text-success me-2"></i>Payment Finalized!',
            html: `
              <div class="text-success text-center">
                <div class="h4 mb-2">₹${parseInt(result.value.salary).toLocaleString()}</div>
                <p><strong>${escapeHtml(staffName)}</strong> salary marked as PAID!</p>
                <div class="mt-2">
                  <small class="text-success-emphasis">
                    <i class="fa-solid fa-clock me-1"></i>
                    Processed on: ${new Date().toLocaleString()}
                  </small>
                </div>
              </div>
            `,
            icon: 'success',
            confirmButtonColor: '#28a745',
            timer: 5000,
            timerProgressBar: true
          });
        }
      });
    });

    // Prevent clicks on disabled buttons
    $(document).on('click', '.mark-paid.disabled', function(e){
      e.preventDefault();
      e.stopPropagation();
      Swal.fire({
        title: 'Payment Already Processed!',
        text: 'This salary has already been marked as paid.',
        icon: 'info',
        confirmButtonColor: '#28a745',
        timer: 2500,
        showConfirmButton: false
      });
    });

    // View salary details
    $(document).on('click', '.view-salary', function(){
      const row = $(this).closest('tr');
      const staffName = row.find('td:eq(1)').text().trim();
      const status = row.find('td:eq(7)').text().trim().split('\n')[0];
      const statusClass = getStatusClass(status);
      const paidAt = row.data('paid-at') || 'Not paid yet';
      
      Swal.fire({
        title: `<h4 class="text-primary mb-3">
                  <i class="fa-solid fa-eye me-2"></i>
                  Salary Details - ${escapeHtml(staffName)}
                </h4>`,
        html: `
          <div class="text-start">
            <div class="row g-3 mb-3">
              <div class="col-6"><strong>Staff:</strong> ${escapeHtml(staffName)}</div>
              <div class="col-6">
                <strong>Status:</strong> 
                <span class="badge ${statusClass}">${status}</span>
              </div>
              <div class="col-6"><strong>Hours:</strong> ${row.find('td:eq(2)').text()}</div>
              <div class="col-6"><strong>Days:</strong> ${row.find('td:eq(3)').text()}</div>
              <div class="col-6"><strong>Sessions:</strong> ${row.find('td:eq(4)').text()}</div>
              <div class="col-6"><strong>Rate:</strong> ${row.find('td:eq(5)').text()}</div>
              ${status.toLowerCase() === 'paid' ? 
                `<div class="col-6"><strong>Paid On:</strong> ${paidAt}</div>` : 
                `<div class="col-6"><strong>Action:</strong> <span class="text-warning">Pending Payment</span></div>`
              }
              <div class="col-12">
                <strong class="text-success h5">Total Salary: ${row.find('td:eq(6)').text()}</strong>
              </div>
            </div>
            ${status.toLowerCase() === 'paid' ? `
              <div class="alert alert-success">
                <i class="fa-solid fa-check-circle me-2"></i>
                <strong>✓ Payment Confirmed!</strong><br>
                This salary has been successfully processed and cannot be modified.
              </div>
            ` : `
              <div class="alert alert-warning">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                <strong>⚠️ Pending Payment</strong><br>
                Click "Mark as Paid" button to finalize this payment.
              </div>
            `}
          </div>
        `,
        icon: 'info',
        confirmButtonColor: '#0d6efd',
        width: 550,
        footer: status.toLowerCase() === 'pending' ? 
          '<button class="btn btn-success btn-sm" onclick="event.stopPropagation(); $(\'.mark-paid[data-staff-id=\\\'${$(this).closest(\\\'tr\\\').data(\\\'staff-id\\\')}\\\']\\\').trigger(\\\'click\\\'); Swal.close();">Finalize Payment Now</button>' : 
          'Payment completed successfully'
      });
    });

    // Salary Dashboard Overview
    $('#salaryOverviewBtn').on('click', function(){
      const salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      const pendingRecords = salaryRecords.filter(r => r.status?.toLowerCase() === 'pending');
      const paidRecords = salaryRecords.filter(r => r.status?.toLowerCase() === 'paid');
      
      const pendingCount = pendingRecords.length;
      const paidCount = paidRecords.length;
      const totalStaff = salaryRecords.length;
      const totalPendingAmount = pendingRecords.reduce((sum, r) => 
        sum + parseInt(r.salary?.replace(/[₹,]/g, '') || 0), 0);
      const totalPaidAmount = paidRecords.reduce((sum, r) => 
        sum + parseInt(r.salary?.replace(/[₹,]/g, '') || 0), 0);
      const totalAmount = totalPendingAmount + totalPaidAmount;
      
      const paidPercentage = totalStaff > 0 ? ((paidCount / totalStaff) * 100).toFixed(1) : 0;

      Swal.fire({
        title: `<h4 class="text-primary mb-0">
                  Salary Management Dashboard
                </h4>`,
        html: `
          <div class="row text-center g-3 mb-3">
            <div class="col-6">
              <div class="card overview-card bg-success">
                <div class="card-body">
                  <i class="fa-solid fa-check-circle fa-2x mb-2"></i>
                  <h5>Paid Salaries</h5>
                  <h3>${paidCount}</h3>
                  <small>₹${totalPaidAmount.toLocaleString()}</small>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="card overview-card bg-warning">
                <div class="card-body">
                  <i class="fa-solid fa-clock fa-2x mb-2"></i>
                  <h5>Pending</h5>
                  <h3>${pendingCount}</h3>
                  <small>₹${totalPendingAmount.toLocaleString()}</small>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card overview-card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <h6>Total Staff: ${totalStaff}</h6>
                      <h6>Total Amount: ₹${totalAmount.toLocaleString()}</h6>
                    </div>
                    <div class="col-6 text-end">
                      <h6>${paidPercentage}% Paid</h6>
                    </div>
                  </div>
                  <div class="progress mt-3" style="height: 12px;">
                    <div class="progress-bar bg-success" style="width: ${paidPercentage}%"></div>
                    <div class="progress-bar bg-warning" style="width: ${100 - paidPercentage}%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          ${totalPendingAmount > 0 ? `
            <div class="alert alert-warning">
              <i class="fa-solid fa-exclamation-triangle me-2"></i>
              <strong>₹${totalPendingAmount.toLocaleString()} in pending payments</strong> 
              need your attention this month.
            </div>
          ` : `
            <div class="alert alert-success">
              <i class="fa-solid fa-trophy me-2"></i>
              <strong>🎉 All salaries paid!</strong> Great job on time management.
            </div>
          `}
        `,
        width: '900px',
        confirmButtonText: 'Detailed Report',
        confirmButtonColor: '#0d6efd',
        showCancelButton: true,
        cancelButtonText: 'Close Dashboard',
        footer: `
          <div class="text-center">
            <button class="btn btn-outline-primary btn-sm me-2" onclick="exportSalaryReport()">
              <i class="fa-solid fa-download me-1"></i>Export CSV
            </button>
            <button class="btn btn-success btn-sm" onclick="printSalarySummary()">
              <i class="fa-solid fa-print me-1"></i>Print Summary
            </button>
          </div>
        `,
        didOpen: () => {
          $('.swal2-footer .btn').addClass('swal2-styled');
        }
      });
    });

    // Export function
    window.exportSalaryReport = function() {
      const salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      if (salaryRecords.length === 0) {
        Swal.fire('No Data', 'No salary records to export.', 'warning');
        return;
      }
      
      let csv = 'Staff Name,Hours,Days,Sessions,Rate,Total Salary,Status,Paid Date\n';
      salaryRecords.forEach(record => {
        csv += `"${record.name}","${record.hours || 0}","${record.days || 0}","${record.sessions || 0}","${record.rate || '₹0'}","${record.salary || '₹0'}","${record.status || 'Pending'}","${record.paidAt ? new Date(record.paidAt).toLocaleDateString() : ''}"\n`;
      });
      
      const blob = new Blob([csv], { type: 'text/csv' });
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `salary-report-${new Date().toISOString().split('T')[0]}.csv`;
      a.click();
      window.URL.revokeObjectURL(url);
      
      Swal.fire('Exported!', 'Salary report downloaded successfully.', 'success');
      Swal.close();
    };

    // Print function
    window.printSalarySummary = function() {
      window.print();
      Swal.fire({
        toast: true,
        position: 'top-end',
        title: 'Printing...',
        text: 'Salary summary printing in progress.',
        icon: 'info',
        showConfirmButton: false,
        timer: 3000
      });
      Swal.close();
    };

    // Assign salary button - info only
    $('#assignSalaryBtn').on('click', function(){
      const salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      if (salaryRecords.length === 0) {
        Swal.fire({
          title: 'Get Started with Salary Management',
          html: `
            <div class="text-center">
              <i class="fa-solid fa-users fa-3x text-primary mb-3 opacity-75"></i>
              <h5>No staff records found</h5>
              <p class="mb-3">Salary records are automatically created when you add staff members.</p>
              <div class="alert alert-info">
                <i class="fa-solid fa-info-circle me-2"></i>
                <strong>Next Steps:</strong> Add staff from <strong>Staff Management</strong> page
              </div>
            </div>
          `,
          icon: 'info',
          confirmButtonText: 'Go to Staff Management',
          confirmButtonColor: '#0d6efd'
        });
      } else {
        Swal.fire({
          title: 'Salary Management Active',
          html: `
            <div class="text-center">
              <i class="fa-solid fa-check-circle fa-2x text-success mb-2"></i>
              <p><strong>${salaryRecords.length}</strong> staff salary records active</p>
              <p class="mb-0">Use table actions to manage payments and view details</p>
            </div>
          `,
          icon: 'success',
          confirmButtonColor: '#28a745',
          footer: '<small>💡 Salary records sync automatically across all tabs</small>'
        });
      }
    });

    // Staff form integration (if coming from staff management)
    $("#staffForm").off('submit').on("submit", function(e){
      e.preventDefault();
      const form = $(this);
      const name = form.find("input[name='name']").val().trim();
      const email = form.find("input[name='email']").val().trim();
      const salary = form.find("input[name='salary']").val().trim();
      const role = form.find("#roleSelect").val();
      
      if (!name || !email) { 
        Swal.fire("Missing info","Please fill required fields.","warning"); 
        return; 
      }

      // Create salary record
      createSalaryRecord(name, email, salary, role);
      
      Swal.fire("Success!","Staff added with salary record.","success");
      const modalEl = document.getElementById('staffModal');
      const bsModal = bootstrap.Modal.getInstance(modalEl); 
      if (bsModal) bsModal.hide();
      $("#staffForm")[0].reset(); 
      editRow = null;
    });

    function createSalaryRecord(name, email, salary, role) {
      const salaryData = {
        staffId: Date.now(),
        name: name,
        email: email,
        role: role,
        hours: '0',
        days: '0',
        sessions: '0',
        rate: salary ? `₹${parseInt(salary).toLocaleString()}` : '₹0',
        salary: salary ? `₹${parseInt(salary).toLocaleString()}` : '₹0',
        status: 'Pending'
      };
      
      let salaryRecords = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      salaryRecords.push(salaryData);
      localStorage.setItem('salaryRecords', JSON.stringify(salaryRecords));
      
      window.dispatchEvent(new CustomEvent('staffAdded', { detail: salaryData }));
      loadSalaryRecords();
    }
  });
  </script>
</body>
</html>