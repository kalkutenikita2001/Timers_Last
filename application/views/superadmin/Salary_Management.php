<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Salary Management - Super Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      /* THEME — matches Staff pages */
      --accent:#ff4040; 
      --accent-dark:#470000;
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --sidebar-width:250px; /* controlled by sidebar script */
    }

    /* base */
    html, body { width:100%; max-width:100%; overflow-x:hidden; }
    body{ background:var(--muted); color:#111; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    /* layout (sidebar aware) */
    #main-content{ margin-left:var(--sidebar-width); width:calc(100vw - var(--sidebar-width)); padding:20px; min-height:100vh; transition:.25s; }
    #main-content.minimized{ margin-left:60px; width:calc(100vw - 60px); }
    @media (max-width:991.98px){ #main-content{ margin-left:0!important; width:100vw; padding:12px; } }

    /* hero/header */
    .page-hero{ border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px;
      overflow:hidden; /* avoid overflow shadow */
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    /* toolbar */
    .toolbar{ position:sticky; top:12px; z-index:5; background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,.05); overflow:hidden; }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    /* sleek search */
    .global-search{ max-width:660px; margin:0 auto; transition:all .25s ease; }
    .global-search .form-control{ height:42px; border-radius:50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .input-group-text{ border-radius:50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search .form-control:focus{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }

    /* cards & table */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); overflow:hidden; }
    .table{ width:100%; }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }

    .action-icons .btn-icon{ border:none; background:transparent; padding:6px; margin:0 2px; font-size:18px; color:#dc3545; }
    .action-icons .btn-icon:hover{ transform:scale(1.12); color:#b71c1c; }

    .badge-soft{ background:#fff; border:1px solid #e9ecef; padding:.35rem .6rem; border-radius:999px; }

    /* sweetalert buttons */
    .swal2-confirm{ background:var(--accent)!important; border:0!important; }
    .swal2-cancel{ background:#6c757d!important; border:0!important; }
  </style>
</head>
<body>

  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <!-- Hero -->
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">Salary Management</div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-ghost" id="assignSalaryBtn"><i class="fa-solid fa-sack-dollar me-1"></i>Assign Salary</button>
        </div>
      </div>
    </div>

    <!-- Toolbar with global search and count (hooked later if needed) -->
    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search by staff, status or amount...">
          </div>
        </div>
        <span class="badge-soft">Total <b id="rowCount">1</b></span>
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
              <th class="text-center" style="width:160px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nikita Kalkute</td>
              <td>8</td>
              <td>26</td>
              <td>10</td>
              <td>₹1000</td>
              <td>₹26,000</td>
              <td><span class="badge text-bg-warning">Pending</span></td>
              <td class="text-center action-icons">
                <button class="btn-icon delete-salary" title="Delete Salary"><i class="fa-solid fa-trash"></i></button>
                <button class="btn-icon send-salary" title="Send Details"><i class="fa-solid fa-paper-plane"></i></button>
                <button class="btn-icon mark-paid" title="Mark as Paid"><i class="fa-solid fa-sack-dollar"></i></button>
                <button class="btn-icon view-salary" title="View Details"><i class="fa-solid fa-eye"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Sidebar toggle controller (same as other screens; adds #main-content wrapper) -->
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
      Object.assign(backdrop.style,{position:'fixed',inset:'0',background:'rgba(0,0,0,.42)',zIndex:'1070',display:'none',opacity:'0',transition:'opacity .18s ease'});
      document.body.appendChild(backdrop);
    }

    let lock=false; const lockFor=(ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };
    let lastInteractionAt=0; const INTERACTION_GAP=700;

    function openMobileSidebar(){ const s=sidebarEl(); if(!s)return; s.classList.add(SIDEBAR_OPEN_CLASS); document.body.classList.add(BODY_OVERLAY_CLASS); document.body.style.overflow='hidden'; backdrop.style.display='block'; requestAnimationFrame(()=>backdrop.style.opacity='1'); }
    function closeMobileSidebar(){ const s=sidebarEl(); if(s) s.classList.remove(SIDEBAR_OPEN_CLASS); document.body.classList.remove(BODY_OVERLAY_CLASS); document.body.style.overflow=''; backdrop.style.opacity='0'; setTimeout(()=>{ if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display='none'; },220); }
    function toggleDesktopSidebar(){ const s=sidebarEl(); if(!s)return; const isMin=s.classList.toggle(SIDEBAR_MIN_CLASS); const w=wrapperEl(); if(w) w.classList.toggle('minimized',isMin); const nav=qs('.navbar'); if(nav) nav.classList.toggle('sidebar-minimized',isMin); document.documentElement.style.setProperty(CSS_VAR, isMin?SIDEBAR_WIDTH_MIN:SIDEBAR_WIDTH_OPEN); document.dispatchEvent(new CustomEvent('sidebarToggle',{detail:{minimized:isMin}})); setTimeout(()=>window.dispatchEvent(new Event('resize')),220); }
    function handleToggleEvent(e){ if(e&&e.type==='click'&&(Date.now()-lastInteractionAt)<INTERACTION_GAP) return; if(lock) return; if(isMobile()){ lockFor(260); document.body.classList.contains(BODY_OVERLAY_CLASS)?closeMobileSidebar():openMobileSidebar(); } else { lockFor(260); toggleDesktopSidebar(); } }
    function wireToggleButtons(){ qsa(TOGGLE_SELECTORS).forEach(el=>{ if(el.__sidebarToggleBound) return; el.__sidebarToggleBound=true; el.addEventListener('pointerdown',ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); },{passive:true}); el.addEventListener('click',ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); }); }); }

    document.addEventListener('pointerdown', function (ev) { if(ev.pointerType==='touch'||ev.pointerType==='pen'){ const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); if(t){ lastInteractionAt=Date.now(); handleToggleEvent(ev); } } }, {passive:true});
    document.addEventListener('click', function (ev) { const t=ev.target.closest&&ev.target.closest(TOGGLE_SELECTORS); if(t) handleToggleEvent(ev); });
    backdrop.addEventListener('click', function(){ if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });
    document.addEventListener('click', function(e){ if(!isMobile()) return; const inside=e.target.closest&&e.target.closest(SIDEBAR_SELECTORS); if(!inside) return; const a=e.target.closest&&e.target.closest('a'); if(a&&a.getAttribute('href')&&a.getAttribute('href')!=='#'){ setTimeout(closeMobileSidebar,160); } });
    document.addEventListener('keydown', function(ev){ if(ev.key==='Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });

    let resizeTimer=null; window.addEventListener('resize', function(){ clearTimeout(resizeTimer); resizeTimer=setTimeout(function(){ if(!isMobile()){ closeMobileSidebar(); const s=sidebarEl(); const isMin=s && s.classList.contains('minimized'); document.documentElement.style.setProperty(CSS_VAR, isMin?'60px':'250px'); } },120); });

    if(document.body.classList.contains(BODY_OVERLAY_CLASS)){ backdrop.style.display='block'; backdrop.style.opacity='1'; document.body.style.overflow='hidden'; }

    (function ensureFallbackToggle(){ const qsN=s=>document.querySelector(s); if(qsN(TOGGLE_SELECTORS)){ wireToggleButtons(); return; } const navbar=qsN('.navbar, header, .main-header, .topbar'); if(!navbar) return; const btn=document.createElement('button'); btn.type='button'; btn.id='sidebarToggle'; btn.className='btn btn-sm btn-light sidebar-toggle'; btn.setAttribute('aria-label','Toggle sidebar'); btn.style.marginRight='8px'; btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>'; navbar.prepend(btn); wireToggleButtons(); })();

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>

  <!-- PAGE LOGIC (unchanged core features, styled icons/buttons) -->
  <script>
    $(function(){
      const updateRowCount = ()=> $('#rowCount').text($('#salaryTable tbody tr:visible').length);
      updateRowCount();

      // Assign Salary (same logic as before, moved to hero button)
      $('#assignSalaryBtn').on('click', function(){
        Swal.fire({
          title: '<h4 class="text-danger mb-3">Assign Salary</h4>',
          html: `
          <div class="text-start">
            <label class="fw-bold mb-2">Select desired method of monthly salary computation</label><br>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Fixed salary" checked>
              <label class="form-check-label">Fixed salary</label>
              <input type="number" id="rate" class="form-control mt-2" placeholder="Enter rate (₹)" />
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Days present">
              <label class="form-check-label">Days present</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Session present">
              <label class="form-check-label">Session present</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Checked-in hours">
              <label class="form-check-label">Checked-in hours</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Revenue based">
              <label class="form-check-label">Revenue based</label>
            </div>
          </div>`,
          width: 500,
          showCancelButton: true,
          confirmButtonText: 'Assign',
          confirmButtonColor: '#dc3545',
          cancelButtonText: 'Cancel',
          preConfirm: () => {
            const type = $('input[name="salaryType"]:checked').val();
            const rate = $('#rate').val() || '0';
            return { type, rate };
          }
        }).then((result)=>{
          if(result.isConfirmed){
            Swal.fire({ title:'Assigned!', text:`Salary method "${result.value.type}" assigned successfully with rate ₹${result.value.rate}/month.`, icon:'success', confirmButtonColor:'#dc3545' });
            const newRow = `
              <tr>
                <td>${$('#salaryTable tbody tr').length + 1}</td>
                <td>New Staff</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>₹${result.value.rate}</td>
                <td>-</td>
                <td><span class="badge text-bg-warning">Pending</span></td>
                <td class="text-center action-icons">
                  <button class="btn-icon delete-salary" title="Delete Salary"><i class="fa-solid fa-trash"></i></button>
                  <button class="btn-icon send-salary" title="Send Details"><i class="fa-solid fa-paper-plane"></i></button>
                  <button class="btn-icon mark-paid" title="Mark as Paid"><i class="fa-solid fa-sack-dollar"></i></button>
                  <button class="btn-icon view-salary" title="View Details"><i class="fa-solid fa-eye"></i></button>
                </td>
              </tr>`;
            $('#salaryTable tbody').append(newRow);
            updateRowCount();
          }
        });
      });

      // quick search
      $('#searchInput').on('input', function(){
        const q = $(this).val().toLowerCase();
        $('#salaryTable tbody tr').each(function(){
          const hit = $(this).text().toLowerCase().indexOf(q) > -1;
          $(this).toggle(hit);
        });
        updateRowCount();
      });

      // Delete
      $(document).on('click', '.delete-salary', function(){
        const row = $(this).closest('tr');
        const staffName = row.find('td:eq(1)').text();
        Swal.fire({ title:'Delete Salary Record?', text:`Are you sure you want to delete ${staffName}'s record?`, icon:'warning', showCancelButton:true, confirmButtonText:'Delete', confirmButtonColor:'#dc3545' })
        .then((r)=>{ if(r.isConfirmed){ row.remove(); updateRowCount(); Swal.fire({ title:'Deleted!', text:`${staffName}'s record deleted successfully.`, icon:'success', confirmButtonColor:'#dc3545' }); } });
      });

      // View
      $(document).on('click', '.view-salary', function(){
        const row = $(this).closest('tr');
        Swal.fire({
          title: `<h4 class="text-danger mb-3">Salary Details</h4>`,
          html: `
            <p><b>Staff:</b> ${row.find('td:eq(1)').text()}</p>
            <p><b>Rate:</b> ${row.find('td:eq(5)').text()}</p>
            <p><b>Status:</b> ${row.find('td:eq(7)').text()}</p>
          `,
          icon: 'info',
          confirmButtonColor: '#dc3545'
        });
      });

      // Mark as Paid (editable)
      $(document).on('click', '.mark-paid', function(){
        const row = $(this).closest('tr');
        const staffName = row.find('td:eq(1)').text();
        const hours = row.find('td:eq(2)').text();
        const days = row.find('td:eq(3)').text();
        const sessions = row.find('td:eq(4)').text();
        const rate = row.find('td:eq(5)').text().replace('₹','').replace(/,/g,'').trim();
        const salary = row.find('td:eq(6)').text().replace('₹','').replace(/,/g,'').trim();
        Swal.fire({
          title: `<h4 class="text-danger mb-3">Edit Salary - ${staffName}</h4>`,
          html: `
            <div class="text-start">
              <label><b>Hours Worked:</b></label>
              <input type="number" id="editHours" class="form-control mb-2" value="${hours}" />
              <label><b>Days Present:</b></label>
              <input type="number" id="editDays" class="form-control mb-2" value="${days}" />
              <label><b>Sessions Attended:</b></label>
              <input type="number" id="editSessions" class="form-control mb-2" value="${sessions}" />
              <label><b>Rate (₹):</b></label>
              <input type="number" id="editRate" class="form-control mb-2" value="${rate}" />
              <label><b>Total Salary (₹):</b></label>
              <input type="number" id="editSalary" class="form-control mb-2" value="${salary}" />
            </div>
          `,
          width: 500,
          showCancelButton: true,
          confirmButtonText: 'Update & Mark as Paid',
          confirmButtonColor: '#dc3545',
          cancelButtonText: 'Cancel',
          preConfirm: ()=>({
            hours: $('#editHours').val(),
            days: $('#editDays').val(),
            sessions: $('#editSessions').val(),
            rate: $('#editRate').val(),
            salary: $('#editSalary').val()
          })
        }).then((res)=>{
          if(res.isConfirmed){
            row.find('td:eq(2)').text(res.value.hours);
            row.find('td:eq(3)').text(res.value.days);
            row.find('td:eq(4)').text(res.value.sessions);
            row.find('td:eq(5)').text(`₹${res.value.rate}`);
            row.find('td:eq(6)').text(`₹${res.value.salary}`);
            row.find('td:eq(7)').html('<span class="badge text-bg-success">Paid</span>');
            row.find('.mark-paid').closest('button').remove();
            Swal.fire({ title:'Updated & Marked as Paid!', text:`${staffName}'s salary has been updated and marked as paid.`, icon:'success', confirmButtonColor:'#dc3545' });
          }
        });
      });

      // Send to Overview (localStorage bridge)
      $(document).on('click', '.send-salary', function(){
        const row = $(this).closest('tr');
        const salaryData = {
          name: row.find('td:eq(1)').text(),
          hours: row.find('td:eq(2)').text(),
          days: row.find('td:eq(3)').text(),
          sessions: row.find('td:eq(4)').text(),
          rate: row.find('td:eq(5)').text(),
          salary: row.find('td:eq(6)').text(),
          status: row.find('td:eq(7)').text().trim()
        };
        localStorage.setItem('staffSalaryData', JSON.stringify(salaryData));
        Swal.fire({ title:'Details Sent!', text:`Salary details for ${salaryData.name} sent to Overview tab.`, icon:'success', confirmButtonColor:'#dc3545' });
      });
    });
  </script>
</body>
</html>
