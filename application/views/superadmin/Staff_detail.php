<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Staff Detail</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <style>
    :root{
      /* Project theme */
      --accent:#ff4040;
      --accent-dark:#470000;
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --card-bg:#ffffff;
      --text:#111;
      --subtle:#6c757d;
    }
    body{ background:var(--muted); color:var(--text); overflow-x:hidden; font-family: system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    /* Wrapper follows your attendance module behavior */
    .dashboard-wrapper{ margin-left:250px; padding:20px; min-height:100vh; transition:margin-left .25s ease, padding .25s ease; }
    .dashboard-wrapper.minimized{ margin-left:60px; }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; padding:12px; } }

    /* Hero */
    .hero{
      position:relative; border-radius:18px; overflow:hidden;
      background: radial-gradient(1200px 400px at -10% -20%, rgba(255,64,64,.25), transparent),
                  radial-gradient(900px 300px at 110% 0%, rgba(71,0,0,.20), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      border:1px solid #ffe1e1;
      box-shadow:0 18px 50px rgba(255,64,64,.10);
    }
    .hero::after{
      /* gentle parallax glow */
      content:""; position:absolute; inset:-40px; pointer-events:none;
      background: radial-gradient(700px 240px at 15% 0%, rgba(255,64,64,.18), transparent),
                  radial-gradient(600px 220px at 85% 0%, rgba(71,0,0,.16), transparent);
      filter: blur(10px);
      transform: translateY(-6px);
      animation: floatGlow 8s ease-in-out infinite alternate;
    }
    @keyframes floatGlow{ from{ transform:translateY(-6px) } to{ transform:translateY(6px) } }

    .avatar{
      width:72px; height:72px; border-radius:50%;
      background: var(--grad); color:#fff; display:flex; align-items:center; justify-content:center;
      box-shadow:0 14px 34px rgba(255,64,64,.35);
    }

    /* Cards */
    .card-lite{
      background:var(--card-bg); border-radius:16px; border:1px solid #ececec;
      box-shadow:0 10px 28px rgba(0,0,0,.06);
    }

    /* Buttons */
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:600; }
    .btn-primary:hover{ filter:brightness(.96); }

    /* Chips */
    .chip{
      border:1px solid #eee; background:#fff; border-radius:999px; padding:.38rem .72rem;
      display:inline-flex; align-items:center; gap:.45rem; box-shadow:0 6px 16px rgba(0,0,0,.05);
    }

    /* KPI tiles */
    .stat{ border:1px dashed #e7e7e7; border-radius:14px; padding:14px; background:#fff; height:100%; }
    .stat .label{ color:#666; font-size:.85rem; }
    .status-badge{
      border-radius:999px; padding:.25rem .6rem; font-size:.8rem; font-weight:700;
    }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-deactive{ background:#e2e3e5; color:#41464b; }

    /* Circular progress (attendance rate) */
    .ring{
      width:78px; height:78px; position:relative;
    }
    .ring svg{ transform:rotate(-90deg); }
    .ring .val{
      position:absolute; inset:0; display:grid; place-items:center; font-weight:700; font-size:.9rem;
    }

    /* Attendance calendar */
    .att-grid{ display:grid; grid-template-columns:repeat(7,1fr); gap:6px; }
    .att-day{
      border-radius:10px; border:1px solid #ececec; background:#fff; text-align:center;
      padding:8px 0; font-size:.85rem; user-select:none; transition:.2s;
    }
    .att-day.present{ background:#d1e7dd; border-color:#badbcc; }
    .att-day.absent{ background:#f8d7da; border-color:#f5c2c7; }
    .att-legend span{ display:inline-flex; align-items:center; gap:6px; margin-right:12px; font-size:.85rem; }

    /* Chart area fix to prevent height creep */
    .chart-box{ position:relative; height:260px; width:100%; }

    /* Payout list cap */
    #salaryList{ max-height:240px; overflow:auto; }

    /* Animations on scroll */
    .aos{ opacity:0; transform:translateY(10px); transition:opacity .5s ease, transform .5s ease; }
    .aos.in{ opacity:1; transform:none; }

    /* Utilities */
    .section-title{ font-weight:800; letter-spacing:.2px; }
    .text-subtle{ color:var(--subtle); }
  </style>
</head>
<body>

  <!-- Sidebar & Navbar -->
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div class="dashboard-wrapper" id="dashboardWrapper">
    <!-- HERO -->
    <div class="hero p-3 p-md-4 mb-3 aos">
      <div class="d-flex flex-wrap align-items-center gap-3">
        <div class="avatar"><i class="bi bi-person fs-3"></i></div>
        <div class="me-auto">
          <h3 class="mb-0" id="nameHd">Staff Name</h3>
          <div class="text-subtle small" id="emailHd">email@example.com</div>
        </div>

        <div class="d-flex flex-wrap gap-2">
          <a href="javascript:void(0)" class="btn btn-ghost" id="backBtn"><i class="bi bi-arrow-left me-1"></i>Back</a>
          <a href="<?php echo base_url('superadmin/Staff_manage'); ?>" class="btn btn-ghost"><i class="bi bi-list-ul me-1"></i>All Staff</a>
          <button class="btn btn-primary" id="editBtn"><i class="bi bi-pencil-square me-1"></i>Edit</button>
          <button class="btn btn-ghost" id="toggleStatusBtn"><i class="bi bi-toggle-on me-1"></i>Toggle Status</button>
        </div>
      </div>

      <div class="d-flex flex-wrap gap-2 mt-3" id="chipRow"></div>
    </div>

    <!-- KPI ROW -->
    <div class="row g-3">
      <div class="col-6 col-lg-3 aos">
        <div class="stat">
          <div class="label">Status</div>
          <div class="mt-1"><span id="statusBadge" class="status-badge">Active</span></div>
        </div>
      </div>
      <div class="col-6 col-lg-3 aos">
        <div class="stat">
          <div class="label">Current Salary</div>
          <div class="h5 mb-0" id="salaryVal">₹ 0</div>
          <small class="text-subtle">Next payout: <span id="nextPayout">—</span></small>
        </div>
      </div>
      <div class="col-6 col-lg-3 aos">
        <div class="stat d-flex align-items-center gap-3">
          <div class="ring">
            <svg width="78" height="78" viewBox="0 0 100 100">
              <circle cx="50" cy="50" r="44" stroke="#eee" stroke-width="10" fill="none"/>
              <circle id="ringProg" cx="50" cy="50" r="44" stroke="url(#grad)" stroke-width="10" fill="none"
                stroke-linecap="round" stroke-dasharray="276.46" stroke-dashoffset="276.46"/>
              <defs>
                <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0%" stop-color="#ff4040"/><stop offset="100%" stop-color="#470000"/>
                </linearGradient>
              </defs>
            </svg>
            <div class="val" id="ringVal">0%</div>
          </div>
          <div>
            <div class="label">This Month Presence</div>
            <div class="h5 mb-0"><span id="presentDays">0</span> days</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-3 aos">
        <div class="stat">
          <div class="label">Tenure</div>
          <div class="h5 mb-0" id="tenureVal">0 months</div>
          <small class="text-subtle">Joined <span id="joinDateSmall">—</span></small>
        </div>
      </div>
    </div>

    <!-- CONTENT GRID -->
    <div class="row g-3 mt-1">
      <!-- Attendance -->
      <div class="col-lg-7 aos">
        <div class="card-lite p-3">
          <div class="d-flex align-items-center gap-2">
            <h5 class="section-title mb-0"><i class="bi bi-calendar-check me-2" style="color:var(--accent)"></i>Attendance</h5>
            <div class="ms-auto d-flex gap-2">
              <select id="attMonth" class="form-select form-select-sm" style="width:auto"></select>
              <select id="attYear" class="form-select form-select-sm" style="width:auto"></select>
            </div>
          </div>
          <hr class="my-3">
          <div class="att-grid" id="attGrid"></div>
          <div class="att-legend mt-3">
            <span><span class="att-day present" style="width:14px;height:14px;padding:0;border-radius:4px;border:0"></span> Present</span>
            <span><span class="att-day absent" style="width:14px;height:14px;padding:0;border-radius:4px;border:0"></span> Absent</span>
          </div>
        </div>
      </div>

      <!-- Salary -->
      <div class="col-lg-5 aos">
        <div class="card-lite p-3">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="section-title mb-0"><i class="bi bi-cash-coin me-2" style="color:var(--accent)"></i>Salary History</h5>
          </div>
          <hr class="my-3">
          <div class="chart-box"><canvas id="salaryChart"></canvas></div>
          <ul id="salaryList" class="list-group list-group-flush mt-3"></ul>
        </div>
      </div>

      <!-- About -->
      <div class="col-lg-4 aos">
        <div class="card-lite p-3">
          <h5 class="section-title"><i class="bi bi-person-badge me-2" style="color:var(--accent)"></i>About</h5>
          <hr class="my-3">
          <div class="mb-2"><strong>Role:</strong> <span id="roleTxt">-</span></div>
          <div class="mb-2"><strong>Joined:</strong> <span id="joinTxt">-</span></div>
          <div class="mb-2"><strong>Contact:</strong> <span id="contactTxt">-</span></div>
          <div><strong>Email:</strong> <span id="emailTxt">-</span></div>
        </div>
      </div>

      <!-- Centers & Slots -->
      <div class="col-lg-8 aos">
        <div class="card-lite p-3">
          <h5 class="section-title"><i class="bi bi-geo-alt me-2" style="color:var(--accent)"></i>Centers & Slots</h5>
          <hr class="my-3">
          <div id="centersWrap" class="d-flex flex-wrap gap-2"></div>
          <div id="slotsWrap" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>
      </div>

      <!-- Activity -->
      <div class="col-12 aos">
        <div class="card-lite p-3">
          <h5 class="section-title"><i class="bi bi-clock-history me-2" style="color:var(--accent)"></i>Recent Activity</h5>
          <hr class="my-3">
          <div id="activityList" class="row row-cols-1 row-cols-md-3 g-3"></div>
        </div>
      </div>
    </div>
  </div> <!-- /dashboard-wrapper -->

  <!-- scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // ========= Animate-on-scroll =========
    const inView = new IntersectionObserver((entries)=>{
      entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); });
    }, {threshold: .08});
    document.querySelectorAll('.aos').forEach(el=> inView.observe(el));

    // ========= Helpers =========
    const qs = s => document.querySelector(s);
    const INR = n => new Intl.NumberFormat('en-IN').format(n);
    const urlId = (function(){ const p=location.pathname.split('/').filter(Boolean); const id=parseInt(p[p.length-1],10); return isNaN(id)?null:id; })();

    // Back button
qs('#backBtn').addEventListener('click', ()=>{
  location.href = "<?php echo base_url('superadmin/Staff_manage'); ?>";
});

    // Pull data from storage (front-end only)
    const all = JSON.parse(localStorage.getItem('staffDataAll') || '[]');
    const staff = all.find(s=>s.id===urlId) || all[0];
    if(!staff){ location.href = "<?php echo base_url('superadmin/Staff_manage'); ?>"; }

    // ---------- Fill hero ----------
    qs('#nameHd').textContent = staff.name;
    qs('#emailHd').textContent = staff.email;

    const chipRow = qs('#chipRow');
    function addChip(text, icon){ const el=document.createElement('span'); el.className='chip'; el.innerHTML=`<i class="${icon}"></i>${text}`; chipRow.appendChild(el); }
    addChip(staff.role, 'bi bi-person-badge');
    (staff.centers||[]).forEach(c=> addChip(c, 'bi bi-geo-alt'));
    if(staff.role==='Coach' && staff.slots?.length) staff.slots.forEach(s=> addChip(s,'bi bi-clock'));

    // ---------- KPI ----------
    const statusEl = qs('#statusBadge');
    statusEl.textContent = staff.status;
    statusEl.className = 'status-badge ' + (staff.status==='Active'?'status-active':'status-deactive');

    qs('#salaryVal').textContent = '₹ ' + INR(staff.salary);
    qs('#joinDateSmall').textContent = staff.joining_date;
    qs('#roleTxt').textContent = staff.role;
    qs('#joinTxt').textContent = staff.joining_date;
    qs('#contactTxt').textContent = staff.contact;
    qs('#emailTxt').textContent = staff.email;

    function nextPayout(){
      const now=new Date(); const end=new Date(now.getFullYear(), now.getMonth()+1, 0);
      return end.toISOString().slice(0,10);
    }
    qs('#nextPayout').textContent = nextPayout();

    // Tenure
    (function(){
      const j=new Date(staff.joining_date), n=new Date();
      const months=(n.getFullYear()-j.getFullYear())*12 + (n.getMonth()-j.getMonth());
      qs('#tenureVal').textContent = months + (months===1?' month':' months');
    })();

    // ---------- Attendance (grid + selectors + circular progress) ----------
    function fillMonthYearSelectors(){
      const mSel=qs('#attMonth'), ySel=qs('#attYear');
      const months=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
      months.forEach((m,i)=> mSel.append(new Option(m, i)));
      const n=new Date();
      for(let y=n.getFullYear()-1; y<=n.getFullYear()+1; y++) ySel.append(new Option(y, y));
      mSel.value=String(n.getMonth()); ySel.value=String(n.getFullYear());
      mSel.onchange=renderGrid; ySel.onchange=renderGrid;
    }
    function setRing(percent){
      const circ = 2*Math.PI*44; // r=44
      const off = circ * (1 - percent/100);
      const ring = document.getElementById('ringProg');
      ring.style.strokeDashoffset = off;
      document.getElementById('ringVal').textContent = Math.round(percent) + '%';
    }
    function renderGrid(){
      const m=Number(qs('#attMonth').value), y=Number(qs('#attYear').value);
      const key=`${y}-${String(m+1).padStart(2,'0')}`;
      const present = new Set((staff.attendance && staff.attendance[key]) || []);
      const grid=qs('#attGrid'); grid.innerHTML='';
      const last=new Date(y,m+1,0).getDate();
      const days=["S","M","T","W","T","F","S"];
      days.forEach(d=>{ const h=document.createElement('div'); h.className='text-center text-subtle small'; h.textContent=d; grid.appendChild(h); });
      for(let i=1;i<=last;i++){
        const cell=document.createElement('div');
        cell.className='att-day ' + (present.has(i)?'present':'absent');
        cell.textContent=i; grid.appendChild(cell);
      }
      qs('#presentDays').textContent = present.size;
      const pct = (present.size/last)*100;
      setRing(pct);
    }
    fillMonthYearSelectors(); renderGrid();

    // ---------- Salary chart + list (fixed height + destroy guard) ----------
    const salaryList = document.getElementById('salaryList'); salaryList.innerHTML='';
    (staff.payouts||[]).forEach(d=>{
      const li=document.createElement('li');
      li.className='list-group-item d-flex justify-content-between align-items-center';
      li.innerHTML=`<span><i class="bi bi-receipt me-2"></i>${d}</span><strong>₹ ${INR(staff.salary)}</strong>`;
      salaryList.appendChild(li);
    });

    const ctx = document.getElementById('salaryChart');
    const payoutMonths = (staff.payouts||[]).slice().reverse();
    const payoutValues = payoutMonths.map(()=> staff.salary);

    if (window.__salaryChart) window.__salaryChart.destroy();
    window.__salaryChart = new Chart(ctx, {
      type:'line',
      data:{ labels:payoutMonths, datasets:[{ label:'Payout (₹)', data:payoutValues, tension:.35, fill:false }] },
      options:{
        responsive:true,
        maintainAspectRatio:true,
        resizeDelay:120,
        plugins:{ legend:{ display:false } },
        scales:{ y:{ ticks:{ callback:v=>'₹ '+INR(v) } } }
      }
    });

    // ---------- Centers / Slots ----------
    const centersWrap = document.getElementById('centersWrap');
    (staff.centers||[]).forEach(c=>{
      const b=document.createElement('span');
      b.className='badge rounded-pill text-bg-light'; b.textContent=c;
      centersWrap.appendChild(b);
    });
    const slotsWrap = document.getElementById('slotsWrap');
    if(staff.role==='Coach' && staff.slots?.length){
      staff.slots.forEach(s=>{
        const b=document.createElement('span');
        b.className='badge rounded-pill text-bg-light'; b.textContent=s;
        slotsWrap.appendChild(b);
      });
    }else{ slotsWrap.innerHTML='<span class="text-subtle small">No slot assignment.</span>'; }

    // ---------- Activity (flavor) ----------
    const act=document.getElementById('activityList');
    [{ icon:'bi-calendar2-check', text:'Marked present', date:'Today' },
     { icon:'bi-cash-coin', text:'Salary processed', date:(staff.payouts?.[0]||'—') },
     { icon:'bi-geo-alt', text:`Center sync: ${staff.centers?.[0]||'-'}`, date:'This week' },
    ].forEach(a=>{
      const col=document.createElement('div'); col.className='col';
      col.innerHTML=`<div class="card-lite p-3 h-100">
        <div class="d-flex align-items-center gap-2">
          <i class="bi ${a.icon}" style="color:var(--accent)"></i>
          <div class="fw-semibold">${a.text}</div>
          <span class="ms-auto text-subtle small">${a.date}</span>
        </div>
      </div>`;
      act.appendChild(col);
    });

    // ---------- Quick actions ----------
    document.getElementById('editBtn').addEventListener('click', ()=>{
      localStorage.setItem('intentEditId', staff.id);
      location.href = "<?php echo base_url('superadmin/Staff_manage'); ?>";
    });
    document.getElementById('toggleStatusBtn').addEventListener('click', ()=>{
      staff.status = (staff.status==='Active'?'Deactive':'Active');
      statusEl.textContent = staff.status;
      statusEl.className = 'status-badge ' + (staff.status==='Active'?'status-active':'status-deactive');
      const idx = all.findIndex(x=>x.id===staff.id);
      if(idx>-1){ all[idx]=staff; localStorage.setItem('staffDataAll', JSON.stringify(all)); }
    });
  </script>

  <!-- === Sidebar toggle controller (same behavior as your attendance module) === -->
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
