<?php
// application/views/superadmin/Student_detail.php
// Controller should pass $student with keys:
// id,name,email,contact,alt_contact,gender,address,blood_group,join_date,end_date,
// batch_name,student_progress_category,category,status,total_fees,paid_amount,
// attendance => ["YYYY-MM"=>[1,2,3,...]],
// fee_history => [{date:"2025-09-30", amount: 3500}, ...],
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Student Detail</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <style>
    :root{
      --accent:#ff4040; --accent-dark:#470000; --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --card-bg:#fff; --text:#111; --subtle:#6c757d;
    }
    body{ background:var(--muted); color:var(--text); overflow-x:hidden; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    .dashboard-wrapper{ margin-left:250px; padding:20px; min-height:100vh; transition:margin-left .25s ease, padding .25s ease; }
    .dashboard-wrapper.minimized{ margin-left:60px; }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; padding:12px; } }

    /* HERO */
    .hero{ position:relative; border-radius:18px; overflow:hidden;
      background: radial-gradient(1200px 400px at -10% -20%, rgba(255,64,64,.25), transparent),
                  radial-gradient(900px 300px at 110% 0%, rgba(71,0,0,.20), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      border:1px solid #ffe1e1; box-shadow:0 18px 50px rgba(255,64,64,.10);
    }
    .hero::after{ content:""; position:absolute; inset:-40px; pointer-events:none;
      background: radial-gradient(700px 240px at 15% 0%, rgba(255,64,64,.18), transparent),
                  radial-gradient(600px 220px at 85% 0%, rgba(71,0,0,.16), transparent);
      filter: blur(10px); transform: translateY(-6px); animation: floatGlow 8s ease-in-out infinite alternate;
    }
    @keyframes floatGlow{ from{ transform:translateY(-6px) } to{ transform:translateY(6px) } }

    .avatar{ width:72px; height:72px; border-radius:50%; background: var(--grad); color:#fff;
      display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.2rem;
      box-shadow:0 14px 34px rgba(255,64,64,.35);
    }

    /* buttons */
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:600; }
    .btn-primary:hover{ filter:brightness(.96); }
    #renewBtn{
      background: var(--grad); color:#fff; border:none; font-weight:600; transition:all .2s ease;
    }
    #renewBtn:hover{ filter:brightness(.96); transform:translateY(-1px); box-shadow:0 6px 14px rgba(255,64,64,.2); }
    #renewBtn.renewed{ background:#198754; box-shadow:0 6px 14px rgba(25,135,84,.25); }

    /* chips */
    .chip{ border:1px solid #eee; background:#fff; border-radius:999px; padding:.38rem .72rem;
      display:inline-flex; align-items:center; gap:.45rem; box-shadow:0 6px 16px rgba(0,0,0,.05); white-space:nowrap; }
    .chips-row{ display:flex; gap:.5rem; overflow:auto; flex-wrap:nowrap; scrollbar-width:none; }
    .chips-row::-webkit-scrollbar{ display:none; }

    /* stats */
    .stat{ border:1px dashed #e7e7e7; border-radius:14px; padding:14px; background:#fff; height:100%; }
    .stat .label{ color:#666; font-size:.85rem; }
    .status-badge{ border-radius:999px; padding:.25rem .6rem; font-size:.8rem; font-weight:700; }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-pending{ background:#fff3cd; color:#8c6d1f; }
    .status-deactive{ background:#f8d7da; color:#842029; }

    .ring{ width:78px; height:78px; position:relative; }
    .ring svg{ transform:rotate(-90deg); }
    .ring .val{ position:absolute; inset:0; display:grid; place-items:center; font-weight:700; font-size:.9rem; }

    /* info cards */
    .h-cards{ display:grid; grid-auto-flow:column; grid-auto-columns:minmax(260px, 1fr); gap:12px; overflow:auto; padding-bottom:2px; }
    .h-card{ background:#fff; border:1px solid #ececec; border-radius:14px; padding:14px; min-height:140px; box-shadow:0 8px 18px rgba(0,0,0,.05); }
    .h-card h6{ font-weight:800; margin:0 0 .6rem 0; display:flex; align-items:center; gap:.5rem; }
    .h-card .rowline{ display:flex; justify-content:space-between; gap:10px; padding:.32rem 0; border-bottom:1px dashed #f0f0f0; }
    .h-card .rowline:last-child{ border-bottom:0; }
    .label-min{ color:#6b7280; font-size:.85rem; }
    .value-min{ font-weight:600; }
    /* Prevent overflow for long text like Gmail or Address */
.h-card .value-min {
  word-break: break-word;
  overflow-wrap: anywhere;
  max-width: 60%;
  text-align: right;
}


    @media (max-width:768px){
      .hero .head-actions{ width:100%; justify-content:flex-end; flex-wrap:wrap; }
    }
  </style>
</head>
<body>

<?php $this->load->view('superadmin/Include/Sidebar'); ?>
<?php $this->load->view('superadmin/Include/Navbar'); ?>

<?php
  $s = $student ?? [];
  $s += [
    'id'=>0,'name'=>'Unknown','email'=>'','contact'=>'','alt_contact'=>'','gender'=>'','address'=>'','blood_group'=>'',
    'join_date'=>'','end_date'=>'','batch_name'=>'','student_progress_category'=>'','category'=>'','status'=>'Active',
    'total_fees'=>0,'paid_amount'=>0,'attendance'=>[], 'fee_history'=>[]
  ];
  $total = (float)$s['total_fees'];
  $paid  = (float)$s['paid_amount'];
  $due   = max(0, $total - $paid);
  $join  = !empty($s['join_date']) ? date('Y-m-d', strtotime($s['join_date'])) : '';
  $end   = !empty($s['end_date']) ? date('Y-m-d', strtotime($s['end_date'])) : '';
?>

<div class="dashboard-wrapper" id="dashboardWrapper">
  <!-- HERO -->
  <div class="hero p-3 p-md-4 mb-3 aos">
    <div class="d-flex flex-wrap align-items-center gap-3">
      <div class="avatar"><?php echo strtoupper(substr($s['name'],0,2)); ?></div>

      <div class="me-auto">
        <h3 class="mb-0" id="nameHd"><?php echo htmlspecialchars($s['name']); ?></h3>
        <div class="text-subtle small" id="emailHd"><?php echo htmlspecialchars($s['email'] ?: '—'); ?></div>

        <div class="mt-2 chips-row" id="chipRow">
          <span class="chip"><i class="bi bi-people"></i>Batch: <?php echo htmlspecialchars($s['batch_name'] ?: '—'); ?></span>
          <span class="chip"><i class="bi bi-rocket-takeoff"></i><?php echo htmlspecialchars($s['student_progress_category'] ?: 'Beginner'); ?></span>
          <span class="chip"><i class="bi bi-collection"></i><?php echo htmlspecialchars($s['category'] ?: 'Category —'); ?></span>
          <?php if(!empty($s['contact'])): ?><span class="chip"><i class="bi bi-telephone"></i><?php echo htmlspecialchars($s['contact']); ?></span><?php endif; ?>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2 head-actions">
        <a id="renewBtn"
   class="btn d-flex align-items-center gap-1"
   href="<?php echo base_url('superadmin/fRenewNew_Admission/'.$s['id']); ?>">
  <i class="bi bi-arrow-repeat"></i> Renew Admission
</a>
        <a href="<?php echo base_url('superadmin/Students'); ?>" class="btn btn-ghost">
          <i class="bi bi-arrow-left me-1"></i>Back
        </a>
        <a href="<?php echo base_url('superadmin/student_edit/'.$s['id']); ?>" class="btn btn-primary">
          <i class="bi bi-pencil-square me-1"></i>Edit
        </a>
      </div>
    </div>
  </div>

  <!-- KPI ROW -->
  <div class="row g-3">
    <div class="col-6 col-lg-3 aos">
      <div class="stat">
        <div class="label">Status</div>
        <?php $st=$s['status']; $cls = $st==='Active'?'status-active':($st==='Pending'?'status-pending':'status-deactive'); ?>
        <span id="statusBadge" class="status-badge <?php echo $cls; ?>"><?php echo htmlspecialchars($st); ?></span>
      </div>
    </div>
    <div class="col-6 col-lg-3 aos">
      <div class="stat">
        <div class="label">Total Fees</div>
        <div class="h5 mb-0">₹ <?php echo number_format($total,2); ?></div>
        <small class="text-subtle">Paid: ₹ <?php echo number_format($paid,2); ?> • Due:
          <b class="<?php echo $due>0?'text-danger':'text-success'; ?>">₹ <?php echo number_format($due,2); ?></b></small>
      </div>
    </div>
    <div class="col-6 col-lg-3 aos">
      <div class="stat d-flex align-items-center gap-3">
        <div class="ring">
          <svg width="78" height="78" viewBox="0 0 100 100">
            <circle cx="50" cy="50" r="44" stroke="#eee" stroke-width="10" fill="none"/>
            <circle id="ringProg" cx="50" cy="50" r="44" stroke="url(#grad)" stroke-width="10" fill="none" stroke-linecap="round"
              stroke-dasharray="276.46" stroke-dashoffset="276.46"/>
            <defs><linearGradient id="grad" x1="0" y1="0" x2="1" y2="1"><stop offset="0%" stop-color="#ff4040"/><stop offset="100%" stop-color="#470000"/></linearGradient></defs>
          </svg>
          <div class="val" id="ringVal">0%</div>
        </div>
        <div>
          <div class="label">Presence (This Month)</div>
          <div class="h5 mb-0"><span id="presentDays">0</span> days</div>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3 aos">
      <div class="stat">
        <div class="label">Tenure</div>
        <div class="h5 mb-0" id="tenureVal">—</div>
        <small class="text-subtle d-block">Start: <?php echo $join ?: '—'; ?></small>
        <small class="text-subtle">End: <?php echo $end ?: '—'; ?></small>
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
        <div id="attGrid" style="display:grid; grid-template-columns:repeat(7,1fr); gap:6px;"></div>
        <div class="mt-2 small text-subtle">Tap a date to toggle present/absent (front-end demo).</div>
      </div>
    </div>

    <!-- Fee History -->
    <div class="col-lg-5 aos">
      <div class="card-lite p-3">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="section-title mb-0"><i class="bi bi-cash-coin me-2" style="color:var(--accent)"></i>Fee History</h5>
          <a href="<?php echo base_url('superadmin/student_fee_history/'.$s['id']); ?>" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <hr class="my-3">
        <div class="chart-box"><canvas id="feeChart"></canvas></div>
        <ul id="txnList" class="list-group list-group-flush mt-3"></ul>
      </div>
    </div>

    <!-- Admission Details (horizontal) -->
    <div class="col-12 aos">
      <div class="h-cards">
        <div class="h-card">
          <h6><i class="bi bi-person-heart" style="color:var(--accent)"></i> Personal</h6>
          <div class="rowline"><span class="label-min">Name</span><span class="value-min"><?php echo htmlspecialchars($s['name'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Gender</span><span class="value-min"><?php echo htmlspecialchars($s['gender'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Blood</span><span class="value-min"><?php echo htmlspecialchars($s['blood_group'] ?: '—'); ?></span></div>
        </div>
        <div class="h-card">
          <h6><i class="bi bi-telephone-forward" style="color:var(--accent)"></i> Contact</h6>
          <div class="rowline"><span class="label-min">Phone</span><span class="value-min"><?php echo htmlspecialchars($s['contact'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Alt</span><span class="value-min"><?php echo htmlspecialchars($s['alt_contact'] ?: '—'); ?></span></div>
         <div class="rowline flex-column align-items-start">
  <span class="label-min">Email</span>
  <span class="value-min w-100 text-break text-end"><?php echo htmlspecialchars($s['email'] ?: '—'); ?></span>
</div>
<div class="rowline flex-column align-items-start">
  <span class="label-min">Address</span>
  <span class="value-min w-100 text-break text-end"><?php echo htmlspecialchars($s['address'] ?: '—'); ?></span>
</div>

        </div>
        <div class="h-card">
          <h6><i class="bi bi-mortarboard" style="color:var(--accent)"></i> Academics</h6>
          <div class="rowline"><span class="label-min">Level</span><span class="value-min"><?php echo htmlspecialchars($s['student_progress_category'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Category</span><span class="value-min"><?php echo htmlspecialchars($s['category'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Batch</span><span class="value-min"><?php echo htmlspecialchars($s['batch_name'] ?: '—'); ?></span></div>
        </div>
        <div class="h-card">
          <h6><i class="bi bi-journal-check" style="color:var(--accent)"></i> Admission</h6>
          <div class="rowline"><span class="label-min">Status</span><span class="value-min"><?php echo htmlspecialchars($s['status'] ?: '—'); ?></span></div>
          <div class="rowline"><span class="label-min">Start</span><span class="value-min"><?php echo $join ?: '—'; ?></span></div>
          <div class="rowline"><span class="label-min">End</span><span class="value-min"><?php echo $end ?: '—'; ?></span></div>
          <div class="rowline"><span class="label-min">Fees</span><span class="value-min">₹ <?php echo number_format($total,2); ?></span></div>
        </div>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Animate-on-scroll
  const inView = new IntersectionObserver((entries)=>{ entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); }); }, {threshold:.08});
  document.querySelectorAll('.aos').forEach(el=> inView.observe(el));

  // Data from PHP
  const PHP_STUDENT = <?php echo json_encode($s, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES); ?>;
  let student = PHP_STUDENT || {};

  // Renew button: optimistic UI + toast + redirect
  (function(){
    const btn = document.getElementById('renewBtn');
    if(!btn) return;

    // Lightweight toast using Bootstrap
    function ensureToast(){
      let holder = document.getElementById('toastInner');
      if(holder) return holder;
      const wrap = document.createElement('div');
      wrap.id = 'toast';
      wrap.className = 'position-fixed bottom-0 end-0 p-3';
      wrap.style.zIndex = '1080';
      wrap.innerHTML = `
        <div id="toastInner" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>`;
      document.body.appendChild(wrap);
      return document.getElementById('toastInner');
    }
    function showToast(msg, success=true){
      const wrap = ensureToast();
      const body = wrap.querySelector('.toast-body');
      body.textContent = msg;
      wrap.classList.remove('bg-danger','text-white','bg-success');
      wrap.classList.add(success ? 'bg-success' : 'bg-danger','text-white');
      new bootstrap.Toast(wrap, { delay: 1400 }).show();
    }

    // btn.addEventListener('click', function(){
    //   btn.disabled = true;
    //   btn.classList.add('renewed');
    //   btn.innerHTML = '<i class="bi bi-check2-circle"></i> Renewed';
    //   showToast('Renewal started…', true);

    //   setTimeout(function(){
    //     location.href = "<?php echo base_url('superadmin/subscription_renew/'.$s['id']); ?>";
    //   }, 900);
    // });
  })();

  // Tenure calc (uses end date if present)
  (function(){
    try{
      const start = student.join_date ? new Date(student.join_date) : null;
      const end   = student.end_date ? new Date(student.end_date) : new Date();
      if(!start) return;
      let months = (end.getFullYear()-start.getFullYear())*12 + (end.getMonth()-start.getMonth());
      if(end.getDate() < start.getDate()) months -= 1;
      if(months < 0) months = 0;
      document.getElementById('tenureVal').textContent = months + (months===1?' month':' months');
    }catch(_){}
  })();

  // Attendance grid
  const dow=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
  const mSel=document.getElementById('attMonth'); const ySel=document.getElementById('attYear');
  (function fillMY(){
    const n=new Date();
    ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'].forEach((m,i)=>mSel.append(new Option(m, i)));
    for(let y=n.getFullYear()-1;y<=n.getFullYear()+1;y++) ySel.append(new Option(y,y));
    mSel.value=n.getMonth(); ySel.value=n.getFullYear();
  })();

  function setRing(pct){
    const circ=2*Math.PI*44; const off=circ*(1-pct/100);
    const ring=document.getElementById('ringProg'); ring.style.strokeDashoffset=off;
    document.getElementById('ringVal').textContent=Math.round(pct)+'%';
  }

  function renderGrid(){
    const m=Number(mSel.value), y=Number(ySel.value); const key=`${y}-${String(m+1).padStart(2,'0')}`;
    const present = new Set((student.attendance && student.attendance[key]) || []);
    const grid=document.getElementById('attGrid'); grid.innerHTML='';
    dow.forEach(d=>{ const h=document.createElement('div'); h.className='text-center text-subtle small'; h.textContent=d; grid.appendChild(h); });
    const last=new Date(y,m+1,0).getDate();
    for(let i=1;i<=last;i++){
      const cell=document.createElement('div'); const isP=present.has(i);
      cell.className='text-center p-2 border rounded '+(isP?'bg-success-subtle':'bg-light');
      cell.textContent=i; cell.style.userSelect='none';
      cell.addEventListener('click',()=>{ if(present.has(i)) present.delete(i); else present.add(i); renderGrid(); });
      grid.appendChild(cell);
    }
    document.getElementById('presentDays').textContent = present.size;
    setRing((present.size/last)*100);
  }
  mSel.onchange=renderGrid; ySel.onchange=renderGrid; renderGrid();

  // Fee history chart & list
  const feeData = Array.isArray(student.fee_history) ? student.fee_history.slice().sort((a,b)=> new Date(a.date)-new Date(b.date)) : [];
  const labels = feeData.map(x=>x.date); const values = feeData.map(x=>Number(x.amount||0));
  if (window.__feeChart) window.__feeChart.destroy();
  window.__feeChart = new Chart(document.getElementById('feeChart'), {
    type:'bar',
    data:{ labels, datasets:[{ label:'Amount (₹)', data: values }] },
    options:{ responsive:true, maintainAspectRatio:true, plugins:{ legend:{ display:false } },
      scales:{ y:{ ticks:{ callback:v=>'₹ '+ new Intl.NumberFormat('en-IN').format(v) } } } }
  });
  const txnList=document.getElementById('txnList'); txnList.innerHTML='';
  feeData.slice().reverse().forEach(t=>{
    const li=document.createElement('li'); li.className='list-group-item d-flex justify-content-between align-items-center';
    li.innerHTML=`<span><i class="bi bi-receipt me-2"></i>${t.date}</span><strong>₹ ${new Intl.NumberFormat('en-IN').format(t.amount||0)}</strong>`;
    txnList.appendChild(li);
  });

  // Activity
  const act=document.getElementById('activityList');
  const lastPaid = feeData.at(-1)?.date || '—';
  [
    { icon:'bi-wallet2', text:'Payment recorded', date:lastPaid },
    { icon:'bi-calendar2-check', text:'Attendance updated', date:'This week' },
    { icon:'bi-people', text:`Batch: ${student.batch_name||'—'}`, date:'Today' },
  ].forEach(a=>{
    const col=document.createElement('div'); col.className='col';
    col.innerHTML=`<div class="card-lite p-3 h-100"><div class="d-flex align-items-center gap-2">
      <i class="bi ${a.icon}" style="color:var(--accent)"></i><div class="fw-semibold">${a.text}</div>
      <span class="ms-auto text-subtle small">${a.date}</span></div></div>`;
    act.appendChild(col);
  });

  // Basic sidebar toggle wiring (if your layout uses it)
  (function () {
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['dashboardWrapper'];
    const DESKTOP_WIDTH_CUTOFF = 576; const SIDEBAR_MIN_CLASS = 'minimized'; const BODY_OVERLAY_CLASS = 'sidebar-open';
    const CSS_VAR = '--sidebar-width'; const SIDEBAR_WIDTH_OPEN = '250px'; const SIDEBAR_WIDTH_MIN = '60px';

    const qs = s => document.querySelector(s); const qsa = s => Array.from(document.querySelectorAll(s));
    const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.dashboard-wrapper');
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

    let backdrop = qs('.sidebar-backdrop'); if (!backdrop) { backdrop = document.createElement('div'); backdrop.className = 'sidebar-backdrop';
      backdrop.style.position='fixed'; backdrop.style.inset='0'; backdrop.style.background='rgba(0,0,0,0.42)'; backdrop.style.zIndex='10';
      backdrop.style.display='none'; backdrop.style.opacity='0'; backdrop.style.transition='opacity .18s ease'; document.body.appendChild(backdrop); }

    function openMobileSidebar(){ const s = sidebarEl(); if (!s) return; s.classList.add('active'); document.body.classList.add(BODY_OVERLAY_CLASS);
      document.body.style.overflow='hidden'; backdrop.style.display='block'; requestAnimationFrame(()=> backdrop.style.opacity='1'); }
    function closeMobileSidebar(){ const s = sidebarEl(); if (s) s.classList.remove('active'); document.body.classList.remove(BODY_OVERLAY_CLASS);
      document.body.style.overflow=''; backdrop.style.opacity='0'; setTimeout(()=>{ if(!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display='none'; },220); }
    function toggleDesktopSidebar(){ const s=sidebarEl(); if(!s) return; const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
      const w=wrapperEl(); if(w) w.classList.toggle('minimized', isMin); const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
      document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN); setTimeout(()=> window.dispatchEvent(new Event('resize')), 220); }
    function handleToggleEvent(){ if (isMobile()){ document.body.classList.contains(BODY_OVERLAY_CLASS) ? closeMobileSidebar() : openMobileSidebar(); } else { toggleDesktopSidebar(); } }
    function wire(){ qsa(TOGGLE_SELECTORS).forEach(el=>{ if (el.__st) return; el.__st=true; el.addEventListener('click', handleToggleEvent); }); }
    window.addEventListener('resize', wire); document.addEventListener('DOMContentLoaded', wire);
  })();
</script>

</body>
</html>
