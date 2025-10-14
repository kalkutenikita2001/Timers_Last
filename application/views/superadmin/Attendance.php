<!-- application/views/superadmin/attendance.php (themed + single search) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Staff Attendance</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <!-- UI libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --accent:#ff4040; --accent-dark:#470000; --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --sidebar-width:250px;
    }
    html,body{ width:100%; max-width:100%; overflow-x:hidden; }
    body{ background:var(--muted); font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial; color:#111; }

    /* layout (sidebar-aware) */
    .dashboard-wrapper{ margin-left:var(--sidebar-width); width:calc(100vw - var(--sidebar-width)); padding:20px; min-height:100vh; transition:.25s; }
    .dashboard-wrapper.minimized{ margin-left:60px; width:calc(100vw - 60px); }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; width:100vw; padding:12px; } }

    /* hero */
    .page-hero{ border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px; margin-bottom:12px; overflow:hidden;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    /* toolbar */
    .toolbar{ position:sticky; top:12px; z-index:5; background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,.05); overflow:hidden; }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    /* global search */
    .global-search{ max-width:680px; margin:0 auto; transition:all .25s ease; }
    .global-search .form-control{ height:42px; border-radius:50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .input-group-text{ border-radius:50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search .form-control:focus{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }

    /* cards & table */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); overflow:hidden; }
    .table thead{ background:#fff; }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background: rgba(255,64,64,.04); }
    .badge-status{ font-size:.8rem; }
    .staff-id{ color:var(--accent); font-weight:700; }

    .btn-compact{ padding:.32rem .6rem; font-size:.86rem; }
    .btn-reset{ border:1px solid #e9ecef; background:#fff; }
    .btn-reset:hover{ background:#f8f8f8; }

    /* Mobile-friendly table */
    @media (max-width:576px){
      .table thead{ display:none; }
      .table, .table tbody, .table tr, .table td{ display:block; width:100%; }
      .table tr{ margin-bottom:12px; border:1px solid #eaeaea; border-radius:8px; background:#fff; padding:8px; }
      .table td{ position:relative; text-align:right; padding:8px 10px; border:none; border-bottom:1px solid #f3f3f3; }
      .table td:before{ content:attr(data-label); position:absolute; left:10px; font-weight:600; color:#6c757d; }
      .table td:last-child{ border-bottom:none; }
    }
  </style>
</head>
<body>
  <!-- Sidebar & Navbar like Dashboard -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <div class="dashboard-wrapper" id="dashboardWrapper">
    <div class="container-fluid">

      <!-- Hero -->
      <div class="page-hero">
        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
          <div>
            <div class="page-title h5 mb-0"><i class="fa-solid fa-clipboard-check me-2"></i>Staff Attendance</div>
            <small class="text-muted">Simple check-in / check-out</small>
          </div>
          <input type="date" id="attDate" class="form-control form-control-sm" style="max-width: 200px;">
        </div>
      </div>

      <!-- Toolbar: SINGLE GLOBAL SEARCH -->
      <div class="toolbar mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 w-100">
          <div class="flex-grow-1">
            <div class="input-group global-search">
              <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass"></i></span>
              <input id="tableSearch" type="text" class="form-control border-start-0" placeholder="Search staff, role, shift, status, or times...">
            </div>
          </div>
          <span class="badge bg-light text-dark rounded-pill px-3 py-2">Showing <b id="shownCount">0</b></span>
        </div>
      </div>

      <!-- Table card -->
      <div class="card-lite">
        <div class="table-responsive">
          <table class="table table-bordered table-hover mb-0" id="staffTable">
            <thead>
              <tr>
                <th style="width:60px;">ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Shift</th>
                <th>Status</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th style="min-width:260px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr data-id="1" data-role="Coach">
                <td data-label="ID" class="staff-id">1</td>
                <td data-label="Name">Anita Sharma</td>
                <td data-label="Role">Coach</td>
                <td data-label="Shift">06:00–08:00 AM</td>
                <td data-label="Status" class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                <td data-label="Check-In" class="checkin-cell">—</td>
                <td data-label="Check-Out" class="checkout-cell">—</td>
                <td data-label="Actions">
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-switch m-0">
                      <input class="form-check-input present-switch" type="checkbox" id="present1">
                      <label class="form-check-label small" for="present1">Present</label>
                    </div>
                    <button class="btn btn-primary btn-compact btn-action" disabled>Check-In</button>
                    <button class="btn btn-compact btn-reset btn-clear" title="Clear times"><i class="fa-solid fa-rotate-left"></i></button>
                  </div>
                </td>
              </tr>
              <tr data-id="2" data-role="Manager">
                <td class="staff-id">2</td>
                <td>Rohit Verma</td>
                <td>Manager</td>
                <td>09:00 AM – 05:00 PM</td>
                <td class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                <td class="checkin-cell">—</td>
                <td class="checkout-cell">—</td>
                <td>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-switch m-0">
                      <input class="form-check-input present-switch" type="checkbox" id="present2">
                      <label class="form-check-label small" for="present2">Present</label>
                    </div>
                    <button class="btn btn-primary btn-compact btn-action" disabled>Check-In</button>
                    <button class="btn btn-compact btn-reset btn-clear" title="Clear times"><i class="fa-solid fa-rotate-left"></i></button>
                  </div>
                </td>
              </tr>
              <tr data-id="3" data-role="Physio">
                <td class="staff-id">3</td>
                <td>Kavya Iyer</td>
                <td>Student</td>
                <td>12:00 PM – 08:00 PM</td>
                <td class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                <td class="checkin-cell">—</td>
                <td class="checkout-cell">—</td>
                <td>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-switch m-0">
                      <input class="form-check-input present-switch" type="checkbox" id="present3">
                      <label class="form-check-label small" for="present3">Present</label>
                    </div>
                    <button class="btn btn-primary btn-compact btn-action" disabled>Check-In</button>
                    <button class="btn btn-compact btn-reset btn-clear" title="Clear times"><i class="fa-solid fa-rotate-left"></i></button>
                  </div>
                </td>
              </tr>
              <tr data-id="4" data-role="Support">
                <td class="staff-id">4</td>
                <td>Vikas Rao</td>
                <td>Support</td>
                <td>02:00 PM – 10:00 PM</td>
                <td class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                <td class="checkin-cell">—</td>
                <td class="checkout-cell">—</td>
                <td>
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-switch m-0">
                      <input class="form-check-input present-switch" type="checkbox" id="present4">
                      <label class="form-check-label small" for="present4">Present</label>
                    </div>
                    <button class="btn btn-primary btn-compact btn-action" disabled>Check-In</button>
                    <button class="btn btn-compact btn-reset btn-clear" title="Clear times"><i class="fa-solid fa-rotate-left"></i></button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="small text-muted d-flex justify-content-between flex-wrap p-2 border-top bg-white">
          <span>* Demo only. Saves to this browser (per date).</span>
          <span id="recordsMeta">Showing 4 of 4 staff</span>
        </div>
      </div>
    </div>
  </div>

  <div class="sidebar-backdrop" style="display:none;"></div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(function(){
      // -------- Helpers --------
      const pad2 = n => (n<10? "0"+n : ""+n);
      const now12 = () => { const d=new Date(); let h=d.getHours(); const m=pad2(d.getMinutes()); const am=h>=12?"PM":"AM"; h=h%12||12; return `${pad2(h)}:${m} ${am}`; };
      const dateKey = () => `attendanceSimple_v1_${$('#attDate').val() || new Date().toISOString().slice(0,10)}`;

      const shownCount = ()=> $('#shownCount').text($('#staffTable tbody tr:visible').length);

      function getState(){ try{ return JSON.parse(localStorage.getItem(dateKey())||'{}'); }catch(e){ return {}; } }
      function setState(st){ localStorage.setItem(dateKey(), JSON.stringify(st)); }
      function saveRow($row){
        const st = getState(); const id = String($row.data('id'));
        st[id] = {
          present: $row.find('.present-switch').is(':checked'),
          checkin: $row.find('.checkin-cell').text().trim(),
          checkout: $row.find('.checkout-cell').text().trim()
        };
        setState(st);
      }
      function loadAll(){
        const st = getState();
        $("#staffTable tbody tr").each(function(){
          const id = String($(this).data('id')); const r = st[id]; if(!r) return;
          $(this).find('.present-switch').prop('checked', !!r.present);
          setBadge($(this), r.present ? 'Present' : 'Absent');
          $(this).find('.checkin-cell').text(r.checkin || '—');
          $(this).find('.checkout-cell').text(r.checkout || '—');
          refreshAction($(this));
        });
      }

      function setBadge($row, status){
        const $b=$row.find('.badge-status');
        if(status==='Present'){ $b.removeClass('bg-danger').addClass('bg-success').text('Present'); }
        else{ $b.removeClass('bg-success').addClass('bg-danger').text('Absent'); }
      }
      function refreshAction($row){
        const present = $row.find('.present-switch').is(':checked');
        const ci = $row.find('.checkin-cell').text().trim();
        const co = $row.find('.checkout-cell').text().trim();
        const $btn = $row.find('.btn-action');
        if(!present){ $btn.prop('disabled', true).removeClass('btn-outline-primary').addClass('btn-primary').text('Check-In'); return; }
        if(ci==='—'){ $btn.prop('disabled', false).removeClass('btn-outline-primary').addClass('btn-primary').text('Check-In'); }
        else if(co==='—'){ $btn.prop('disabled', false).removeClass('btn-primary').addClass('btn-outline-primary').text('Check-Out'); }
        else { $btn.prop('disabled', true).removeClass('btn-primary').addClass('btn-outline-primary').text('Check-Out'); }
      }
      function renumber(){
        $("#staffTable tbody tr:visible").each((i,tr)=>$(tr).find(".staff-id").text(i+1));
        const total=$("#staffTable tbody tr").length, shown=$("#staffTable tbody tr:visible").length;
        $("#recordsMeta").text(`Showing ${shown} of ${total} staff`);
        shownCount();
      }
      function clearTimes($row){ $row.find('.checkin-cell').text('—'); $row.find('.checkout-cell').text('—'); }

      // -------- Init --------
      $('#attDate').val(new Date().toISOString().slice(0,10));
      loadAll(); renumber();

      // change date
      $('#attDate').on('change', function(){
        $("#staffTable tbody tr").each(function(){
          $(this).find('.present-switch').prop('checked', false);
          setBadge($(this), 'Absent'); clearTimes($(this)); refreshAction($(this));
        });
        loadAll(); renumber();
      });

      // -------- SINGLE GLOBAL SEARCH --------
      function applySearch(){
        const q = $('#tableSearch').val().toLowerCase();
        $("#staffTable tbody tr").each(function(){
          const text = $(this).text().toLowerCase();
          $(this).toggle(!q || text.includes(q));
        });
        renumber();
      }
      $('#tableSearch').on('input', applySearch);

      // -------- Present switch --------
      $(document).on('change', '.present-switch', function(){
        const $row=$(this).closest('tr');
        if(this.checked){
          setBadge($row,'Present'); refreshAction($row);
          Swal.fire({icon:'success',title:'Marked Present',timer:900,showConfirmButton:false});
        }else{
          const hasTimes = $row.find('.checkin-cell').text().trim()!=='—' || $row.find('.checkout-cell').text().trim()!=='—';
          if(hasTimes){
            Swal.fire({icon:'warning',title:'Mark Absent?',text:"This will clear today's Check-In/Out.",showCancelButton:true,confirmButtonText:'Yes, clear & mark absent'})
            .then(r=>{
              if(!r.isConfirmed){ $(this).prop('checked', true); return; }
              clearTimes($row); setBadge($row,'Absent'); refreshAction($row); saveRow($row);
              Swal.fire({icon:'info',title:'Marked Absent',timer:900,showConfirmButton:false});
            });
            return;
          }
          setBadge($row,'Absent'); refreshAction($row);
        }
        saveRow($row);
      });

      // -------- Unified action (Check-In / Check-Out) --------
      $(document).on('click', '.btn-action', function(){
        const $row=$(this).closest('tr');
        if(!$row.find('.present-switch').is(':checked')){ Swal.fire({icon:'info',title:'Mark Present first'}); return; }
        const ci=$row.find('.checkin-cell').text().trim(), co=$row.find('.checkout-cell').text().trim();
        if(ci==='—'){ const t=now12(); $row.find('.checkin-cell').text(t); Swal.fire({icon:'success',title:'Checked-In',text:t,timer:900,showConfirmButton:false}); }
        else if(co==='—'){ const t=now12(); $row.find('.checkout-cell').text(t); Swal.fire({icon:'success',title:'Checked-Out',text:t,timer:900,showConfirmButton:false}); }
        else{ Swal.fire({icon:'info',title:'Already Checked-Out'}); }
        refreshAction($row); saveRow($row);
      });

      // -------- Clear times --------
      $(document).on('click', '.btn-clear', function(){
        const $row=$(this).closest('tr');
        Swal.fire({icon:'warning',title:'Clear times?',showCancelButton:true,confirmButtonText:'Yes, clear'})
        .then(r=>{
          if(!r.isConfirmed) return;
          clearTimes($row); refreshAction($row); saveRow($row);
          Swal.fire({icon:'success',title:'Cleared',timer:800,showConfirmButton:false});
        });
      });

      // -------- Mobile labels --------
      function setupLabels(){
        if($(window).width()<576){
          $("#staffTable thead th").each(function(i){
            const label=$(this).text();
            $("#staffTable tbody tr").each(function(){
              $(this).find("td").eq(i).attr("data-label", label);
            });
          });
        }else{ $("#staffTable tbody td").removeAttr("data-label"); }
      }
      setupLabels(); $(window).on("resize", setupLabels);
    });
  </script>

  <!-- Sidebar controller (same as other pages) -->
  <script>
  (function () {
    const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['dashboardWrapper','financeWrap'];
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
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.wrap') || qs('.dashboard-wrapper');
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

    let backdrop = qs('.sidebar-backdrop');
    if (!backdrop) { backdrop = document.createElement('div'); backdrop.className = 'sidebar-backdrop'; Object.assign(backdrop.style,{position:'fixed',inset:'0',background:'rgba(0,0,0,0.42)',zIndex:'1070',display:'none',opacity:'0',transition:'opacity .18s ease'}); document.body.appendChild(backdrop); }

    let lock = false; const lockFor = (ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };
    let lastInteractionAt = 0; const INTERACTION_GAP = 700;

    function openMobileSidebar(){ const s = sidebarEl(); if (!s) return; s.classList.add(SIDEBAR_OPEN_CLASS); document.body.classList.add(BODY_OVERLAY_CLASS); document.body.style.overflow = 'hidden'; backdrop.style.display = 'block'; requestAnimationFrame(()=> backdrop.style.opacity = '1'); }
    function closeMobileSidebar(){ const s = sidebarEl(); if (s) s.classList.remove(SIDEBAR_OPEN_CLASS); document.body.classList.remove(BODY_OVERLAY_CLASS); document.body.style.overflow = ''; backdrop.style.opacity = '0'; setTimeout(()=>{ if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display='none'; },220); }
    function toggleDesktopSidebar(){ const s = sidebarEl(); if (!s) return; const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS); const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin); const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin); document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN); document.dispatchEvent(new CustomEvent('sidebarToggle', { detail:{ minimized:isMin }})); setTimeout(()=> window.dispatchEvent(new Event('resize')), 220); }
    function handleToggleEvent(e){ if (e && e.type==='click' && (Date.now()-lastInteractionAt) < INTERACTION_GAP) return; if (lock) return; if (isMobile()){ lockFor(260); document.body.classList.contains(BODY_OVERLAY_CLASS) ? closeMobileSidebar() : openMobileSidebar(); } else { lockFor(260); toggleDesktopSidebar(); } }
    function wireToggleButtons(){ const toggles = qsa(TOGGLE_SELECTORS); toggles.forEach(el=>{ if (el.__sidebarToggleBound) return; el.__sidebarToggleBound = true; el.addEventListener('pointerdown', ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); }, {passive:true}); el.addEventListener('click', ev=>{ lastInteractionAt=Date.now(); handleToggleEvent(ev); }); }); }

    document.addEventListener('pointerdown', function (ev) { if (ev.pointerType==='touch' || ev.pointerType==='pen') { const t = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS); if (t){ lastInteractionAt=Date.now(); handleToggleEvent(ev); } } }, {passive:true});
    document.addEventListener('click', function (ev) { const t = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS); if (t) handleToggleEvent(ev); });
    backdrop.addEventListener('click', function(){ if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });
    document.addEventListener('click', function(e){ if (!isMobile()) return; const inside = e.target.closest && e.target.closest(SIDEBAR_SELECTORS); if (!inside) return; const a = e.target.closest && e.target.closest('a'); if (a && a.getAttribute('href') && a.getAttribute('href') !== '#') { setTimeout(closeMobileSidebar,160); } });
    document.addEventListener('keydown', function(ev){ if (ev.key==='Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });

    let resizeTimer=null; window.addEventListener('resize', function(){ clearTimeout(resizeTimer); resizeTimer=setTimeout(function(){ if (!isMobile()){ closeMobileSidebar(); const s = sidebarEl(); const isMin = s && s.classList.contains(SIDEBAR_MIN_CLASS); document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN); } },120); });

    if (document.body.classList.contains(BODY_OVERLAY_CLASS)) { backdrop.style.display='block'; backdrop.style.opacity='1'; document.body.style.overflow='hidden'; }

    (function ensureFallbackToggle(){ const qsN = s=>document.querySelector(s); if (qsN(TOGGLE_SELECTORS)){ wireToggleButtons(); return; } const navbar = qsN('.navbar, header, .main-header, .topbar'); if (!navbar) return; const btn = document.createElement('button'); btn.type='button'; btn.id='sidebarToggle'; btn.className='btn btn-sm btn-light sidebar-toggle'; btn.setAttribute('aria-label','Toggle sidebar'); btn.style.marginRight='8px'; btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>'; navbar.prepend(btn); wireToggleButtons(); })();

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>
</body>
</html>
