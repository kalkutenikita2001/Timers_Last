<?php
// application/views/superadmin/Staff_manage.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Staff Management</title>

  <!-- UI libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    :root{
      --accent:#ff4040; --accent-dark:#470000; --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
    }
    body{ background:var(--muted); color:#111; overflow-x:hidden; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    /* layout (sidebar-aware) */
    .dashboard-wrapper{ margin-left:250px; padding:20px; min-height:100vh; transition:.25s; }
    .dashboard-wrapper.minimized{ margin-left:60px; }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; padding:12px; } }

    /* header */
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

/* --- Sleek unified search bar --- */
.global-search {
  max-width: 600px;
  margin: 0 auto;
  transition: all 0.25s ease;
}
.global-search .form-control {
  height: 42px;
  border-radius: 50px;
  font-size: 0.9rem;
  padding-left: 0.5rem;
  border-color: #e3e3e3;
}
.global-search .form-control:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(255,64,64,0.2);
}
.global-search .input-group-text {
  border-radius: 50px 0 0 50px;
  background: white;
  border-color: #e3e3e3;
}
.global-search:hover {
  transform: scale(1.01);
}



    /* table */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }
    .row-actions .btn{ padding:.3rem .45rem; }
    .status-badge{ border-radius:999px; padding:.25rem .6rem; font-size:.75rem; font-weight:700; }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-deactive{ background:#e2e3e5; color:#41464b; }

    /* mobile cards */
    @media (max-width: 768px){
      .table-wrap{ display:none; }
      .card-list{ display:grid; grid-template-columns:1fr; gap:12px; }
    }
    @media (min-width: 769px){
      .card-list{ display:none; }
    }

    /* animations */
    .aos{ opacity:0; transform:translateY(10px); transition:opacity .5s ease, transform .5s ease; }
    .aos.in{ opacity:1; transform:none; }
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
          <button class="btn btn-ghost" id="openFilters"><i class="bi bi-funnel me-1"></i>Filters</button>
          <button class="btn btn-primary" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
        </div>
      </div>

      <!-- stats -->
      <div class="d-flex flex-wrap gap-2 mt-3">
        <div class="stat-chip">
          <div class="lbl">Total Staff</div>
          <div class="h5 mb-0" id="stTotal">0</div>
        </div>
        <div class="stat-chip">
          <div class="lbl">Active</div>
          <div class="h5 mb-0" id="stActive">0</div>
        </div>
        <div class="stat-chip">
          <div class="lbl">Coaches</div>
          <div class="h5 mb-0" id="stCoaches">0</div>
        </div>
      </div>
    </div>

    <!-- Toolbar -->
<div class="toolbar aos text-center">
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div class="flex-grow-1">
      <div class="input-group global-search">
        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
        <input id="searchBox" type="text" class="form-control border-start-0" 
               placeholder="Search staff by name, email, role, center or status...">
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
              <th>Email</th>
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

  <!-- Add/Edit Modal -->
  <div class="modal fade" id="staffModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-white" style="background:var(--grad)">
          <h5 class="modal-title" id="staffModalLabel">Add Staff</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="staffForm">
            <input type="hidden" name="id"/>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input class="form-control" name="name" required placeholder="Full name">
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required placeholder="name@example.com">
              </div>
              <div class="col-md-6">
                <label class="form-label">Contact</label>
                <input class="form-control" name="contact" required placeholder="10-digit number">
              </div>
              <div class="col-md-6">
                <label class="form-label">Joining Date</label>
                <input type="date" class="form-control" name="joining_date" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Role</label>
                <select class="form-select" name="role" id="roleSelect" required>
                  <option value="">Select role</option>
                  <option>Coach</option><option>Admin</option><option>Coordinator</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Centers</label>
                <select class="form-select" name="centers" multiple required>
                  <option>Center A</option><option>Center B</option><option>Center C</option>
                </select>
                <small class="text-muted">Hold CTRL to select multiple</small>
              </div>
              <div class="col-md-6" id="slotSection" style="display:none;">
                <label class="form-label">Slots (Coach only)</label>
                <select class="form-select" name="slots" multiple>
                  <option>6-8 AM</option><option>8-10 AM</option><option>5-7 PM</option>
                </select>
                <small class="text-muted">Hold CTRL to select multiple</small>
              </div>
              <div class="col-md-6">
                <label class="form-label">Salary (₹)</label>
                <input class="form-control" name="salary" required placeholder="e.g., 30000">
              </div>
            </div>
            <div class="text-end mt-3">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- libs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // ===== Animate on scroll
    const io = new IntersectionObserver((es)=>es.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); }),{threshold:.07});
    document.querySelectorAll('.aos').forEach(el=> io.observe(el));

    // ===== Demo storage
    const STORAGE_KEY = 'staffDataAll';
    const seed = [
      {id:1,name:"John Doe",email:"john@example.com",contact:"9876543210",joining_date:"2023-01-10",role:"Coach",centers:["Center A","Center B"],slots:["6-8 AM","5-7 PM"],salary:25000,status:"Active",attendance:{"2025-10":[1,2,3,4,7,8,9,10,11,14,15,16,17,18]},payouts:["2025-09-30","2025-08-31","2025-07-31"]},
      {id:2,name:"Priya Singh",email:"priya@academy.com",contact:"9123456789",joining_date:"2024-03-15",role:"Admin",centers:["Center C"],slots:[],salary:30000,status:"Active",attendance:{"2025-10":[1,2,3,6,7,8,10,13,14,15,16,17,20]},payouts:["2025-09-30","2025-08-31","2025-07-31"]},
      {id:3,name:"Aman Verma",email:"aman@academy.com",contact:"9000012345",joining_date:"2024-11-01",role:"Coordinator",centers:["Center B"],slots:[],salary:22000,status:"Deactive",attendance:{"2025-10":[1,2,5,6,7,9,10,11,12,14,16,17,18]},payouts:["2025-09-30","2025-08-31"]}
    ];
    function loadData(){ try{ return JSON.parse(localStorage.getItem(STORAGE_KEY)||'[]'); }catch(e){ return []; } }
    function saveData(arr){ localStorage.setItem(STORAGE_KEY, JSON.stringify(arr)); }
    let staffData = loadData(); if (!staffData.length){ staffData = seed; saveData(staffData); }

    // ===== Utilities
    const $ = (s)=>document.querySelector(s);
    const $$ = (s)=>Array.from(document.querySelectorAll(s));
    const fmt = n => new Intl.NumberFormat('en-IN').format(n);

    // ===== Filters
    function getFilters(){
  const q = $('#searchBox').value.trim().toLowerCase();
  return { q };
}
function matches(s, f){
  const hay = (s.name + ' ' + s.email + ' ' + s.role + ' ' + s.status + ' ' + (s.centers||[]).join(',')).toLowerCase();
  return !f.q || hay.includes(f.q);
}

    function filtered(){ const f=getFilters(); return staffData.filter(s=>matches(s,f)); }

    // ===== Stats
    function renderStats(){
      $('#stTotal').textContent = staffData.length;
      $('#stActive').textContent = staffData.filter(s=>s.status==='Active').length;
      $('#stCoaches').textContent = staffData.filter(s=>s.role==='Coach').length;
    }

    // ===== Table
    function initials(name){
      return (name||'').split(' ').slice(0,2).map(p=>p[0]||'').join('').toUpperCase();
    }
    function renderTable(){
      const tb = $('#staffTable tbody'); tb.innerHTML='';
      const rows = filtered();
      rows.forEach((s,i)=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${i+1}</td>
          <td class="text-nowrap">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar" style="width:32px;height:32px;font-size:.8rem">${initials(s.name)}</div>
              <div>
                <div class="fw-semibold">${s.name}</div>
                <small class="text-muted">${s.centers.join(', ') || '-'}</small>
              </div>
            </div>
          </td>
          <td>${s.email}</td>
          <td>${s.contact}</td>
          <td>${s.joining_date}</td>
          <td><span class="badge text-bg-light">${s.role}</span></td>
          <td>${s.centers.join(', ')}</td>
          <td>${s.role==='Coach' ? s.slots.join(', ') : '-'}</td>
          <td class="text-end">₹ ${fmt(s.salary)}</td>
          <td class="text-center">
            <span class="status-badge ${s.status==='Active'?'status-active':'status-deactive'}">${s.status}</span>
          </td>
          <td class="text-center">
            <div class="row-actions btn-group">
              <button class="btn btn-ghost btn-sm" data-act="view" data-id="${s.id}" title="View"><i class="bi bi-eye"></i></button>
              <button class="btn btn-ghost btn-sm" data-act="edit" data-id="${s.id}" title="Edit"><i class="bi bi-pencil"></i></button>
              <button class="btn btn-ghost btn-sm text-danger" data-act="del" data-id="${s.id}" title="Delete"><i class="bi bi-trash"></i></button>
            </div>
          </td>`;
        tb.appendChild(tr);
      });
      $('#rowCount').textContent = rows.length;
    }

    // ===== Cards
    function renderCards(){
      const list = $('#staffCards'); list.innerHTML='';
      filtered().forEach(s=>{
        const card = document.createElement('div');
        card.className='card-lite p-3';
        card.innerHTML = `
          <div class="d-flex align-items-start justify-content-between">
            <div class="d-flex align-items-center gap-2">
              <div class="avatar" style="width:36px;height:36px">${initials(s.name)}</div>
              <div>
                <div class="fw-bold">${s.name}</div>
                <div class="text-muted small">${s.email}</div>
              </div>
            </div>
            <span class="status-badge ${s.status==='Active'?'status-active':'status-deactive'}">${s.status}</span>
          </div>
          <div class="mt-2 small">
            <div><i class="bi bi-person-badge me-1"></i>${s.role}</div>
            <div><i class="bi bi-geo-alt me-1"></i>${s.centers.join(', ')||'-'}</div>
            <div><i class="bi bi-clock me-1"></i>${s.role==='Coach'?s.slots.join(', '):'-'}</div>
            <div><i class="bi bi-cash me-1"></i>₹ ${fmt(s.salary)}</div>
          </div>
          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-ghost w-100" data-act="view" data-id="${s.id}"><i class="bi bi-eye me-1"></i>View</button>
            <button class="btn btn-ghost w-100" data-act="edit" data-id="${s.id}"><i class="bi bi-pencil me-1"></i>Edit</button>
            <button class="btn btn-ghost w-100 text-danger" data-act="del" data-id="${s.id}"><i class="bi bi-trash me-1"></i>Delete</button>
          </div>`;
        list.appendChild(card);
      });
    }

    // ===== Modal handling
    let editingId = null;
    function openAdd(){
      editingId = null;
      $('#staffModalLabel').textContent='Add Staff';
      $('#staffForm').reset();
      $('#slotSection').style.display='none';
      new bootstrap.Modal('#staffModal').show();
    }
    function openEdit(id){
      const s = staffData.find(x=>x.id===id); if(!s) return;
      editingId = id;
      const f = $('#staffForm');
      $('#staffModalLabel').textContent='Edit Staff';
      f.name.value=s.name; f.email.value=s.email; f.contact.value=s.contact; f.joining_date.value=s.joining_date;
      f.role.value=s.role; f.salary.value=s.salary;
      [...f.centers.options].forEach(o=> o.selected = s.centers.includes(o.value));
      if(s.role==='Coach'){
        $('#slotSection').style.display='';
        [...f.slots.options].forEach(o=> o.selected = s.slots.includes(o.value));
      }else{
        $('#slotSection').style.display='none';
        [...f.slots.options].forEach(o=> o.selected=false);
      }
      new bootstrap.Modal('#staffModal').show();
    }
    function saveForm(e){
      e.preventDefault();
      const f = e.target;
      const payload = {
        id: editingId ?? (Math.max(0,...staffData.map(s=>s.id))+1),
        name: f.name.value.trim(),
        email: f.email.value.trim(),
        contact: f.contact.value.trim(),
        joining_date: f.joining_date.value,
        role: f.role.value,
        centers: [...f.centers.selectedOptions].map(o=>o.value),
        slots: f.role.value==='Coach' ? [...f.slots.selectedOptions].map(o=>o.value) : [],
        salary: Number(f.salary.value),
        status: editingId ? (staffData.find(s=>s.id===editingId)?.status ?? 'Active') : 'Active',
        attendance: editingId ? (staffData.find(s=>s.id===editingId)?.attendance ?? {}) : {},
        payouts: editingId ? (staffData.find(s=>s.id===editingId)?.payouts ?? []) : []
      };
      if(!payload.name || !payload.email){ return; }
      if (editingId){
        const idx = staffData.findIndex(s=>s.id===editingId); staffData[idx] = payload;
      }else{
        staffData.push(payload);
      }
      saveData(staffData);
      bootstrap.Modal.getInstance('#staffModal')?.hide();
      renderStats(); renderTable(); renderCards();
    }
    function deleteStaff(id){
      if(!confirm('Delete this staff?')) return;
      const idx = staffData.findIndex(s=>s.id===id);
      if(idx>-1){ staffData.splice(idx,1); saveData(staffData); renderStats(); renderTable(); renderCards(); }
    }
    function toggleSlotsVisibility(){
      $('#slotSection').style.display = ($('#roleSelect').value==='Coach') ? '' : 'none';
    }

    // ===== Navigation to detail (eye)
    function goDetail(id){
      localStorage.setItem('staffDataAll', JSON.stringify(staffData));
      window.location.href = '<?php echo base_url('superadmin/Staff_detail'); ?>/' + id;
    }

    // ===== Wire up
    document.addEventListener('DOMContentLoaded', ()=>{
      // inputs
      $('#roleSelect').addEventListener('change', toggleSlotsVisibility);
      $('#addStaffBtn').addEventListener('click', openAdd);
      $('#staffForm').addEventListener('submit', saveForm);
      $('#searchBox').addEventListener('input', ()=>{ renderTable(); renderCards(); });
      $('#clearFilters').addEventListener('click', ()=>{
        $('#searchBox').value=''; $('#filterRole').value=''; $('#filterStatus').value=''; $('#filterCenter').value='';
        renderTable(); renderCards();
      });
      // quick filters open focus
      $('#openFilters').addEventListener('click', ()=> $('#filterRole').focus());

      // delegate actions
      document.body.addEventListener('click', (e)=>{
        const btn = e.target.closest('[data-act]'); if(!btn) return;
        const id = Number(btn.dataset.id);
        const act = btn.dataset.act;
        if (act==='view') goDetail(id);
        else if (act==='edit') openEdit(id);
        else if (act==='del') deleteStaff(id);
      });

      renderStats(); renderTable(); renderCards();
    });
  </script>

  <!-- Sidebar toggle controller (matches attendance module) -->
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
</body>
</html>
