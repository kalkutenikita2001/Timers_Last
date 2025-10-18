<?php
// application/views/superadmin/Staff_manage.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Staff Management</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <!-- UI libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    :root{ --accent:#ff4040; --accent-dark:#470000; --muted:#f4f6f8; --grad:linear-gradient(135deg, var(--accent), var(--accent-dark)); }
    body{ background:var(--muted); color:#111; overflow-x:hidden; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    .dashboard-wrapper{ margin-left:250px; padding:20px; min-height:100vh; transition:.25s; }
    .dashboard-wrapper.minimized{ margin-left:60px; }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; padding:12px; } }

    .page-hero{
      border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }
    .avatar{
      width:40px;height:40px;border-radius:50%;display:grid;place-items:center;
      background:var(--grad); color:#fff; font-weight:700;
      box-shadow:0 8px 22px rgba(255,64,64,.35);
    }
    .stat-chip{
      background:#fff; border:1px dashed #e7e7e7; border-radius:14px; padding:10px 12px;
      min-width:140px; box-shadow:0 8px 24px rgba(0,0,0,.05);
    }
    .stat-chip .lbl{ color:#6c757d; font-size:.85rem; }

    .toolbar{
      position:sticky; top:12px; z-index:5;
      background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px;
      box-shadow:0 8px 24px rgba(0,0,0,.05);
    }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    .global-search { max-width: 600px; margin: 0 auto; transition: all .25s ease; }
    .global-search .form-control { height: 42px; border-radius: 50px; font-size: .9rem; padding-left: .5rem; border-color: #e3e3e3; }
    .global-search .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,64,64,.2); }
    .global-search .input-group-text { border-radius: 50px 0 0 50px; background: #fff; border-color:#e3e3e3; }
    .global-search:hover { transform: scale(1.01); }

    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }
    .row-actions .btn{ padding:.3rem .45rem; }
    .status-badge{ border-radius:999px; padding:.25rem .6rem; font-size:.75rem; font-weight:700; }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-deactive{ background:#e2e3e5; color:#41464b; }

    @media (max-width: 768px){ .table-wrap{ display:none; } .card-list{ display:grid; grid-template-columns:1fr; gap:12px; } }
    @media (min-width: 769px){ .card-list{ display:none; } }

    .aos{ opacity:0; transform:translateY(10px); transition:opacity .5s ease, transform .5s ease; }
    .aos.in{ opacity:1; transform:none; }

    .clickable-row{ cursor:pointer; transition: background-color .2s ease; }
    .clickable-row:hover{ background-color: rgba(255,64,64,.05); }
  </style>
</head>
<body>

  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div class="dashboard-wrapper" id="dashboardWrapper">
    <!-- Page hero -->
    <div class="page-hero p-3 p-md-4 mb-3 aos">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">SM</div>
          <div>
            <div class="page-title h4 mb-0">Staff Management</div>
            <small class="text-muted">Manage profiles, attendance & salary at a glance</small>
          </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-primary" id="addStaffBtn"
   href="<?php echo base_url('superadmin/Add_NewStaff'); ?>?autopopup=1">
  <i class="bi bi-plus-circle me-1"></i>Add Staff
</a>

        </div>
      </div>

      <div class="d-flex flex-wrap gap-2 mt-3">
        <div class="stat-chip"><div class="lbl">Total Staff</div><div class="h5 mb-0" id="stTotal">0</div></div>
        <div class="stat-chip"><div class="lbl">Active</div><div class="h5 mb-0" id="stActive">0</div></div>
        <div class="stat-chip"><div class="lbl">Coaches</div><div class="h5 mb-0" id="stCoaches">0</div></div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar aos text-center">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input id="searchBox" type="text" class="form-control border-start-0" placeholder="Search staff by name, role, center or status...">
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-ghost btn-sm" id="clearFilters"><i class="bi bi-x-circle me-1"></i>Clear</button>
          <span class="badge rounded-pill bg-light text-dark px-3 py-2">Showing <b id="rowCount">0</b></span>
        </div>
      </div>
    </div>

    <!-- Desktop table -->
    <div class="card-lite mt-3 aos">
      <div class="table-wrap">
        <table class="table table-hover align-middle mb-0" id="staffTable">
          <thead>
            <tr>
              <th style="width:56px">#</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Join Date</th>
              <th>Role</th>
              <th>Centers</th>
              <th>Slots</th>
              <th class="text-end">Salary (₹)</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width:120px">Actions</th>
            </tr>
          </thead>
          <tbody><!-- JS inject --></tbody>
        </table>
      </div>
    </div>

    <!-- Mobile cards -->
    <div class="card-list mt-3 aos" id="staffCards"><!-- JS inject --></div>
  </div>

  <!-- libs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // Animate-on-scroll
    const inObs = new IntersectionObserver((es)=>es.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); }),{threshold:.07});
    document.querySelectorAll('.aos').forEach(el=> inObs.observe(el));

    // Helpers
    const qs  = s => document.querySelector(s);
    const INR = n => new Intl.NumberFormat('en-IN').format(n);
    let staffData = [];

    // Fetch strictly from DB (no fallback)
    async function fetchFromDb(){
      const url = "<?php echo base_url('api/staff'); ?>?t=" + Date.now();
      const res = await fetch(url, {
        headers:{ 'Accept':'application/json', 'Cache-Control':'no-cache' },
        cache: 'no-store'
      });
      if (!res.ok) throw new Error('HTTP '+res.status);
      const data = await res.json();
      return Array.isArray(data) ? data : [];
    }

    // Filters
    function getFilters(){
      return { q: (qs('#searchBox').value || '').trim().toLowerCase() };
    }
    function matches(row, f){
      const centersStr = Array.isArray(row.centers) ? row.centers.join(',') : (row.centers || '');
      const hay = `${row.name||''} ${row.email||''} ${row.role||''} ${(row.status||'') } ${centersStr}`.toLowerCase();
      return !f.q || hay.includes(f.q);
    }
    function filtered(){ const f=getFilters(); return staffData.filter(s=>matches(s,f)); }

    // Stats
    function renderStats(){
      qs('#stTotal').textContent   = staffData.length;
      qs('#stActive').textContent  = staffData.filter(s => (s.status||'Active') === 'Active').length;
      qs('#stCoaches').textContent = staffData.filter(s => s.role === 'Coach').length;
    }

    // UI helpers
    function initials(name){ return (name||'').split(' ').slice(0,2).map(p=>p[0]||'').join('').toUpperCase(); }

    function renderTable(){
      const tb = qs('#staffTable tbody');
      tb.innerHTML = '';
      const rows = filtered();

      if (!rows.length){
        tb.innerHTML = `<tr><td colspan="11" class="text-center text-muted py-4">No staff found.</td></tr>`;
        qs('#rowCount').textContent = 0;
        return;
      }

      rows.forEach((s,i)=>{
        const centers = Array.isArray(s.centers) ? s.centers : (s.centers ? String(s.centers).split(',').map(x=>x.trim()).filter(Boolean) : []);
        const slots   = Array.isArray(s.slots)   ? s.slots   : (s.slots   ? String(s.slots).split(',').map(x=>x.trim()).filter(Boolean)   : []);
        const status  = s.status || 'Active';

        const tr = document.createElement('tr');
        tr.classList.add('clickable-row');
        tr.innerHTML = `
          <td>${i+1}</td>
          <td class="text-nowrap">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar" style="width:32px;height:32px;font-size:.8rem">${initials(s.name)}</div>
              <div>
                <div class="fw-semibold">${s.name||'-'}</div>
                <small class="text-muted">${s.role||'-'}</small>
              </div>
            </div>
          </td>
          <td>${s.contact||'-'}</td>
          <td>${s.joining_date||'-'}</td>
          <td><span class="badge text-bg-light">${s.role||'-'}</span></td>
          <td>${centers.join(', ')||'-'}</td>
          <td>${(s.role==='Coach' && slots.length) ? slots.join(', ') : '-'}</td>
<td class="text-end"><span style="font-family: inherit;">₹</span>&nbsp;${INR(Number(s.salary||0))}</td>
          <td class="text-center">
            <span class="status-badge ${status==='Active'?'status-active':'status-deactive'}">${status}</span>
          </td>
          <td class="text-center">
            <div class="row-actions btn-group">
              <button class="btn btn-ghost btn-sm" data-act="view" data-id="${s.id}" title="View"><i class="bi bi-eye"></i></button>
              <button class="btn btn-ghost btn-sm" data-act="edit" data-id="${s.id}" title="Edit"><i class="bi bi-pencil"></i></button>
            </div>
          </td>`;
        tr.addEventListener('click', (e)=>{ if (!e.target.closest('.row-actions') && !e.target.closest('button')) goDetail(s.id); });
        tb.appendChild(tr);
      });

      qs('#rowCount').textContent = rows.length;
    }

    function renderCards(){
      const list = qs('#staffCards'); list.innerHTML='';
      const rows = filtered();
      if (!rows.length) return;

      rows.forEach(s=>{
        const centers = Array.isArray(s.centers) ? s.centers : (s.centers ? String(s.centers).split(',').map(x=>x.trim()).filter(Boolean) : []);
        const slots   = Array.isArray(s.slots)   ? s.slots   : (s.slots   ? String(s.slots).split(',').map(x=>x.trim()).filter(Boolean)   : []);
        const status  = s.status || 'Active';

        const card = document.createElement('div');
        card.className='card-lite p-3';
        card.innerHTML = `
          <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar" style="width:36px;height:36px">${initials(s.name)}</div>
              <div>
                <div class="fw-bold">${s.name||'-'}</div>
                <div class="text-muted small">${s.email||'-'}</div>
              </div>
            </div>
            <span class="status-badge ${status==='Active'?'status-active':'status-deactive'}">${status}</span>
          </div>
          <div class="mt-2 small">
            <div><i class="bi bi-person-badge me-1"></i>${s.role||'-'}</div>
            <div><i class="bi bi-geo-alt me-1"></i>${centers.join(', ')||'-'}</div>
            <div><i class="bi bi-clock me-1"></i>${s.role==='Coach' && slots.length ? slots.join(', ') : '-'}</div>
            <div><i class="bi bi-cash me-1"></i>₹ ${INR(Number(s.salary||0))}</div>
          </div>
          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-ghost w-100" data-act="view" data-id="${s.id}"><i class="bi bi-eye me-1"></i>View</button>
            <button class="btn btn-ghost w-100" data-act="edit" data-id="${s.id}"><i class="bi bi-pencil me-1"></i>Edit</button>
          </div>`;
        list.appendChild(card);
      });
    }

    // Navigation
    function goDetail(id){
      try { localStorage.setItem('staffDataAll', JSON.stringify(staffData)); } catch(e){}
      window.location.href = "<?php echo base_url('superadmin/Staff_detail'); ?>/" + id;
    }

    // Wire up
    document.addEventListener('DOMContentLoaded', async ()=>{
      // search + clear
      qs('#searchBox').addEventListener('input', ()=>{ renderTable(); renderCards(); });
      qs('#clearFilters').addEventListener('click', ()=>{ qs('#searchBox').value=''; renderTable(); renderCards(); });

      // actions
      document.body.addEventListener('click', (e)=>{
        const btn = e.target.closest('[data-act]'); if(!btn) return;
        const id = Number(btn.dataset.id);
        const act = btn.dataset.act;
        if (act==='view') goDetail(id);
        else if (act==='edit') window.location.href = "<?php echo base_url('superadmin/Add_NewStaff'); ?>?id="+id;
      });

      // load strictly from DB
      try{
        staffData = await fetchFromDb();
      }catch(err){
        console.error(err);
        staffData = [];
      }

      renderStats(); renderTable(); renderCards();
    });

    // keep layout script below
  </script>

  <!-- Sidebar toggle controller (same behavior as attendance module) -->
  <script>
  (function () {
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
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      backdrop.style.position = 'fixed';
      backdrop.style.inset = '0';
      backdrop.style.background = 'rgba(0,0,0,0.42)';
      backdrop.style.zIndex = '10';
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
    function handleToggleEvent(){
      if (lock) return;
      if (isMobile()){ lockFor(260); document.body.classList.contains(BODY_OVERLAY_CLASS) ? closeMobileSidebar() : openMobileSidebar(); }
      else { lockFor(260); toggleDesktopSidebar(); }
    }
    function wireToggleButtons(){
      const toggles = qsa(TOGGLE_SELECTORS);
      toggles.forEach(el=>{
        if (el.__sidebarToggleBound) return;
        el.__sidebarToggleBound = true;
        el.addEventListener('click', handleToggleEvent);
      });
    }

    backdrop.addEventListener('click', function(){ if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); });

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

    (function ensureFallbackToggle(){
      const navbar = qs('.navbar, header, .main-header, .topbar');
      if (!qs(TOGGLE_SELECTORS) && navbar){
        const btn = document.createElement('button');
        btn.type='button'; btn.id='sidebarToggle'; btn.className='btn btn-sm btn-light sidebar-toggle'; btn.setAttribute('aria-label','Toggle sidebar'); btn.style.marginRight='8px';
        btn.innerHTML='<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        navbar.prepend(btn);
      }
      wireToggleButtons();
    })();
  })();
  </script>
  <script>
  // after your existing code that defines fetchFromDb() and renders:
  window.addEventListener('storage', async (e)=>{
    if (e.key === 'staff:changed') {
      try{
        const rows = await fetchFromDb();
        staffData = rows;
        renderStats(); renderTable(); renderCards();
      }catch(err){ console.error(err); }
    }
  });
</script>

</body>
</html>
