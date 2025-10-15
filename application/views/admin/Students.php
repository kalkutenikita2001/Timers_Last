<?php
// application/views/admin/Students_manage.php

// Build unique batch list for the dropdown (safe even if $students empty)
$batchNames = [];
if (!empty($students)) {
  foreach ($students as $s) {
    $bn = trim($s['batch_name'] ?? '');
    if ($bn !== '' && !in_array($bn, $batchNames, true)) $batchNames[] = $bn;
  }
  sort($batchNames, SORT_NATURAL | SORT_FLAG_CASE);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Students Management</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <!-- UI libs -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>

  <style>
    :root{
      --accent:#ff4040; --accent-dark:#470000; --muted:#f5f7fb;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --ring:0 0 0 3px rgba(255,64,64,.18);
    }
    *{outline:0}
    body{ background:var(--muted); color:#111; overflow-x:hidden; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    /* layout (sidebar-aware) */
    .dashboard-wrapper{ margin-left:250px; padding:20px; min-height:100vh; transition:.25s; }
    .dashboard-wrapper.minimized{ margin-left:60px; }
    @media (max-width:991.98px){ .dashboard-wrapper{ margin-left:0 !important; padding:12px; } }

    /* header */
    .page-hero{
      border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.18), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.12), transparent),
                  linear-gradient(90deg, #fff, #fff8f8);
      box-shadow:0 12px 32px rgba(255,64,64,.06);
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }
    .avatar{
      width:40px;height:40px;border-radius:50%;display:grid;place-items:center;
      background:var(--grad); color:#fff; font-weight:700;
      box-shadow:0 8px 22px rgba(255,64,64,.28);
    }
    .stat-chip{
      background:#fff; border:1px dashed #f1c8c8; border-radius:14px; padding:10px 12px;
      min-width:150px; box-shadow:0 8px 24px rgba(0,0,0,.04);
    }
    .stat-chip .lbl{ color:#6c757d; font-size:.85rem; }

    /* toolbar */
    .toolbar{ position:sticky; top:12px; z-index:5; background:#fff; border:1px solid #f0d5d5; border-radius:12px; padding:10px; box-shadow:0 8px 24px rgba(0,0,0,.05); }
    .toolbar .form-select, .toolbar .form-control{ height:44px; border-radius:12px; border-color:#ecd1d1; }
    .toolbar .form-select:focus, .toolbar .form-control:focus{ border-color:var(--accent); box-shadow:var(--ring); }
    .btn-ghost{ border:1px solid #ecd1d1; background:#fff; }
    .btn-ghost:hover{ background:#fff5f5; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    /* unified search */
    .global-search{ max-width:640px; margin:0 auto; transition:all .25s ease; }
    .global-search .input-group-text{ border-radius:12px 0 0 12px; background:#fff; border-color:#ecd1d1; }
    .global-search .form-control{ border-radius:0 12px 12px 0; }

    /* table/cards */
    .card-lite{ background:#fff; border-radius:14px; border:1px solid #f0d5d5; box-shadow:0 6px 18px rgba(0,0,0,.05); }
    .table{ --bs-table-striped-bg: rgba(255,64,64,.018); }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; border-bottom-color:#f3d8d8; font-weight:700; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.04); }
    .table td, .table th{ vertical-align:middle; }
    .row-actions .btn{ padding:.3rem .45rem; }

    .status-badge{ border-radius:999px; padding:.25rem .6rem; font-size:.75rem; font-weight:700; }
    .status-active{ background:#d1e7dd; color:#0f5132; }
    .status-pending{ background:#fff3cd; color:#8c6d1f; }
    .status-deactive{ background:#f8d7da; color:#842029; }

    /* Replaced the blue fee pill with subtle accent-tinted styles */
    .fee-pill{ background:#fff0f0; color:#7a0f0f; border:1px solid #ffd1d1; border-radius:999px; font-weight:700; padding:.25rem .6rem; font-variant-numeric:tabular-nums; }
    .paid-pill{ background:#ffeaea; color:#7a0f0f; border:1px solid #ffd1d1; border-radius:999px; padding:.25rem .6rem; font-weight:700; }

    .clickable-row{ cursor:pointer; transition:background-color .2s ease; }
    .clickable-row:hover{ background:rgba(255,64,64,.05); }

    /* compact table spacing for density */
    #studentsTable tbody td{ padding-top:.65rem; padding-bottom:.65rem; }

    /* mobile cards */
    @media (max-width: 768px){ .table-wrap{ display:none; } .card-list{ display:grid; grid-template-columns:1fr; gap:12px; } }
    @media (min-width: 769px){ .card-list{ display:none; } }

    /* animations */
    .aos{ opacity:0; transform:translateY(10px); transition:opacity .5s ease, transform .5s ease; }
    .aos.in{ opacity:1; transform:none; }

    /* tiny helpers */
    .soft-sep{ height:1px; background:linear-gradient(90deg, transparent, #f0d5d5, transparent); }
  
  /* Force text rupee glyph (no emoji styling) */
.rupee{ font-family: system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif; font-weight:700; }
.fee-pill .rupee{ margin-right:.25rem; }

  
  </style>
</head>
<body>
  <?php $this->load->view('admin/Include/Sidebar'); ?>
  <?php $this->load->view('admin/Include/Navbar'); ?>

  <div class="dashboard-wrapper" id="dashboardWrapper">
    <!-- Page hero -->
    <div class="page-hero p-3 p-md-4 mb-3 aos">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="d-flex align-items-center gap-3">
          <div class="avatar">ST</div>
          <div>
            <div class="page-title h4 mb-0">Students Management</div>
            <small class="text-muted">Roster, fees & batch assignments at a glance</small>
          </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
          <a href="<?php echo base_url('admin/student_add'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add Student
          </a>
        </div>
      </div>

      <!-- stats -->
      <div class="d-flex flex-wrap gap-2 mt-3">
        <div class="stat-chip">
          <div class="lbl">Total Students</div>
          <div class="h5 mb-0" id="stCount">0</div>
        </div>
        <div class="stat-chip">
          <div class="lbl">Active</div>
          <div class="h5 mb-0" id="stActive">0</div>
        </div>
        <div class="stat-chip">
          <div class="lbl">Pending Dues</div>
          <div class="h5 mb-0" id="stDues">0</div>
        </div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar aos">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <!-- Batch dropdown + search -->
        <div class="d-flex align-items-center gap-2 flex-grow-1">
          <div class="global-search flex-grow-1">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
              <input id="searchBox" type="text" class="form-control border-start-0" placeholder="Search by name, level, category, status...">
            </div>
          </div>
          <div style="min-width:220px">
            <select id="batchFilter" class="form-select" aria-label="Filter by batch">
              <option value="">All Batches</option>
              <?php foreach ($batchNames as $bn): ?>
                <option value="<?php echo htmlspecialchars($bn); ?>"><?php echo htmlspecialchars($bn); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-ghost btn-sm" id="clearSearch"><i class="bi bi-x-circle me-1"></i>Clear</button>
          <span class="badge rounded-pill bg-light text-dark px-3 py-2">Showing <b id="rowCount">0</b></span>
        </div>
      </div>
    </div>

    <!-- Desktop table -->
    <div class="card-lite mt-3 aos">
      <div class="soft-sep"></div>
      <div class="table-wrap">
        <table class="table table-hover table-striped align-middle mb-0" id="studentsTable">
          <thead>
            <tr>
              <th style="width:56px">#</th>
              <th>Name</th>
              <th>Level</th>
              <th>Batch</th>
              <th>Category</th>
              <th class="text-end">Fees (₹)</th>
              <th class="text-end">Due (₹)</th>
              <th class="text-center">Status</th>
              <th class="text-center" style="width:140px">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php if(!empty($students)): $i=0; foreach($students as $stu): $i++; ?>
            <?php
              $total = (float)($stu['total_fees'] ?? 0);
              $paid  = (float)($stu['paid_amount'] ?? 0);
              $due   = max(0, $total - $paid);
              $status = $stu['status'] ?? 'Active';
              $batchNm = trim($stu['batch_name'] ?? '');
              $level = $stu['student_progress_category'];
              $category = $stu['category'] ?? '—';
            ?>
            <tr class="clickable-row"
                data-id="<?php echo $stu['id']; ?>"
                data-batch="<?php echo htmlspecialchars($batchNm); ?>">
              <td><?php echo $i; ?></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="avatar" style="width:32px;height:32px;font-size:.8rem">
                    <?php echo strtoupper(substr($stu['name'],0,1)); ?>
                  </div>
                  <div>
                    <div class="fw-semibold"><?php echo htmlspecialchars($stu['name']); ?></div>
                    <!-- Removed duplicate batch here; show a subtle secondary line (category) -->
                    <small class="text-muted"><?php echo htmlspecialchars($category); ?></small>
                  </div>
                </div>
              </td>
              <td><span class="badge text-bg-light"><?php echo htmlspecialchars($level); ?></span></td>
              <td><?php echo htmlspecialchars($batchNm !== '' ? $batchNm : '—'); ?></td>
              <td><?php echo htmlspecialchars($category); ?></td>
              <td class="text-end">
  <span class="fee-pill"><span class="rupee">&#8377;</span><?php echo number_format($total,2); ?></span>
</td>

              <td class="text-end">
  <?php if($due>0): ?>
    <span class="fee-pill"><span class="rupee">&#8377;</span><?php echo number_format($due,2); ?></span>
  <?php else: ?>
    <span class="paid-pill">Paid</span>
  <?php endif; ?>
</td>

              <td class="text-center">
                <?php if($status==='Active'): ?>
                  <span class="status-badge status-active">Active</span>
                <?php elseif($status==='Pending'): ?>
                  <span class="status-badge status-pending">Pending</span>
                <?php else: ?>
                  <span class="status-badge status-deactive">Deactive</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="row-actions btn-group">
                  <a href="<?php echo base_url('admin/student_details/'.$stu['id']); ?>" class="btn btn-ghost btn-sm" title="View"><i class="bi bi-eye"></i></a>
                  <a href="<?php echo base_url('admin/student_edit/'.$stu['id']); ?>" class="btn btn-ghost btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                  <button class="btn btn-ghost btn-sm text-danger" data-act="del" data-id="<?php echo $stu['id']; ?>" title="Delete"><i class="bi bi-trash"></i></button>
                </div>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="9" class="text-center py-4">No students found</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Mobile cards -->
    <div class="card-list mt-3 aos" id="studentCards">
      <?php if(!empty($students)): foreach($students as $stu):
        $total = (float)($stu['total_fees'] ?? 0);
        $paid  = (float)($stu['paid_amount'] ?? 0);
        $due   = max(0, $total - $paid);
        $status = $stu['status'] ?? 'Active';
        $batchNm = trim($stu['batch_name'] ?? '');
      ?>
      <div class="card-lite p-3" data-batch="<?php echo htmlspecialchars($batchNm); ?>">
        <div class="d-flex align-items-start justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <div class="avatar" style="width:36px;height:36px"><?php echo strtoupper(substr($stu['name'],0,1)); ?></div>
            <div>
              <div class="fw-bold"><?php echo htmlspecialchars($stu['name']); ?></div>
              <!-- Show level instead of repeating batch -->
              <div class="text-muted small"><?php echo htmlspecialchars($stu['student_progress_category']); ?></div>
            </div>
          </div>
          <span class="status-badge <?php echo $status==='Active'?'status-active':($status==='Pending'?'status-pending':'status-deactive'); ?>"><?php echo $status; ?></span>
        </div>
        <div class="mt-2 small">
          <div><i class="bi bi-collection me-1"></i><?php echo htmlspecialchars($stu['category'] ?? '—'); ?></div>
          <div><i class="bi bi-layers me-1"></i><?php echo htmlspecialchars($batchNm !== '' ? $batchNm : '—'); ?></div>
<div><i class="bi bi-cash me-1"></i>
  Total: <span class="fee-pill"><span class="rupee">&#8377;</span><?php echo number_format($total,2); ?></span>
  <?php echo $due>0
    ? ' • <span class="fee-pill"><span class="rupee">&#8377;</span>'.number_format($due,2).'</span>'
    : ' • <span class="paid-pill">Paid</span>'; ?>
</div>
        </div>
        <div class="d-flex gap-2 mt-3">
          <a class="btn btn-ghost w-100" href="<?php echo base_url('admin/student_details/'.$stu['id']); ?>"><i class="bi bi-eye me-1"></i>View</a>
          <a class="btn btn-ghost w-100" href="<?php echo base_url('admin/student_edit/'.$stu['id']); ?>"><i class="bi bi-pencil me-1"></i>Edit</a>
        </div>
      </div>
      <?php endforeach; endif; ?>
    </div>
  </div>

  <!-- libs -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // ===== Animate on scroll
    const io = new IntersectionObserver((es)=>es.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('in'); }),{threshold:.07});
    document.querySelectorAll('.aos').forEach(el=> io.observe(el));

    // ===== Row click -> detail
    document.addEventListener('DOMContentLoaded', function(){
      document.querySelectorAll('#studentsTable tbody tr.clickable-row').forEach(tr=>{
        tr.addEventListener('click', (e)=>{
          if (e.target.closest('.row-actions')) return;
          const id = tr.getAttribute('data-id');
          if (id) window.location.href = '<?php echo base_url('admin/student_details'); ?>/'+id;
        });
      });
    });

    // ===== Filters & Search
    const searchInput = document.getElementById('searchBox');
    const batchFilter = document.getElementById('batchFilter');

    function normalize(s){ return (s||'').toString().toLowerCase(); }

    function rowMatches(tr, q, batch){
      const text = normalize(tr.innerText);
      const rowBatch = (tr.getAttribute('data-batch') || '').toLowerCase();
      const qOk = text.includes(q);
      const bOk = !batch || rowBatch === batch.toLowerCase();
      return qOk && bOk;
    }

    function cardMatches(card, q, batch){
      const text = normalize(card.innerText);
      const rowBatch = (card.getAttribute('data-batch') || '').toLowerCase();
      const qOk = text.includes(q);
      const bOk = !batch || rowBatch === batch.toLowerCase();
      return qOk && bOk;
    }

    function filterList(){
      const q = normalize(searchInput.value);
      const batch = batchFilter.value;

      // table
      let n=0;
      document.querySelectorAll('#studentsTable tbody tr').forEach((tr)=>{
        const show = rowMatches(tr, q, batch);
        tr.style.display = show ? '' : 'none';
      });
      // re-number visible rows
      document.querySelectorAll('#studentsTable tbody tr').forEach((tr)=>{
        if (tr.style.display!=='none'){ n++; tr.querySelector('td:first-child').textContent = n; }
      });

      // cards
      document.querySelectorAll('#studentCards .card-lite').forEach(card=>{
        card.style.display = cardMatches(card, q, batch) ? '' : 'none';
      });

      // counts based on visible rows
      document.getElementById('rowCount').textContent = n;
      calcStats(true); // recalc from visible
    }

    searchInput.addEventListener('input', filterList);
    batchFilter.addEventListener('change', filterList);
    document.getElementById('clearSearch').addEventListener('click', ()=>{
      searchInput.value=''; batchFilter.value=''; filterList();
    });
    window.addEventListener('load', ()=>{ filterList(); });

    // ===== Stats from DOM (supports filtered state)
    function calcStats(useVisible=false){
      const rows = Array.from(document.querySelectorAll('#studentsTable tbody tr'))
        .filter(tr => !useVisible || tr.style.display !== 'none');

      const total = rows.length;
      let active=0, dues=0;
      rows.forEach(tr=>{
        const status = (tr.querySelector('.status-badge')||{}).textContent || '';
        if (status.includes('Active')) active++;
        const duePill = tr.querySelector('.fee-pill');
        const paidPill = tr.querySelector('.paid-pill');
        if (duePill && !paidPill) dues++; // has due
      });

      document.getElementById('stCount').textContent = total;
      document.getElementById('stActive').textContent = active;
      document.getElementById('stDues').textContent = dues;
    }

    // ===== Delete (hook to controller later)
    document.body.addEventListener('click', function(e){
      const btn = e.target.closest('[data-act="del"]'); if(!btn) return;
      if(!confirm('Delete this student?')) return;
      const id = btn.getAttribute('data-id');
      // TODO: replace with AJAX -> controller; for now remove row visually + corresponding card
      const tr = btn.closest('tr'); 
      if (tr) {
        const batch = tr.getAttribute('data-batch') || '';
        const name = tr.querySelector('td:nth-child(2) .fw-semibold')?.textContent || '';
        tr.remove();
        // remove matching mobile card by name + batch hint
        document.querySelectorAll('#studentCards .card-lite').forEach(card=>{
          if ((card.innerText||'').includes(name)) card.remove();
        });
      }
      filterList();
    });

    // ===== Sidebar toggle controller (shared with your Staff module)
    (function () {
      const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
      const WRAPPER_IDS = ['dashboardWrapper'];
      const DESKTOP_WIDTH_CUTOFF = 576;
      const SIDEBAR_MIN_CLASS = 'minimized';
      const CSS_VAR = '--sidebar-width';
      const SIDEBAR_WIDTH_OPEN = '250px';
      const SIDEBAR_WIDTH_MIN = '60px';

      const qs = s => document.querySelector(s);
      const qsa = s => Array.from(document.querySelectorAll(s));
      const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.dashboard-wrapper');
      const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

      let backdrop = qs('.sidebar-backdrop');
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'sidebar-backdrop';
        Object.assign(backdrop.style, {position:'fixed', inset:'0', background:'rgba(0,0,0,0.42)', zIndex:'1070', display:'none', opacity:'0', transition:'opacity .18s ease'});
        document.body.appendChild(backdrop);
      }

      let lock = false; const lockFor = (ms=320)=>{ lock=true; clearTimeout(lock._t); lock._t=setTimeout(()=>lock=false,ms); };

      function openMobileSidebar(){ const s = qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar'); if (!s) return; s.classList.add('active'); document.body.classList.add('sidebar-open'); document.body.style.overflow='hidden'; backdrop.style.display='block'; requestAnimationFrame(()=> backdrop.style.opacity='1'); }
      function closeMobileSidebar(){ const s = qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar'); if (s) s.classList.remove('active'); document.body.classList.remove('sidebar-open'); document.body.style.overflow=''; backdrop.style.opacity='0'; setTimeout(()=>{ if(!document.body.classList.contains('sidebar-open')) backdrop.style.display='none'; },220); }
      function toggleDesktopSidebar(){ const s=qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar'); if(!s) return; const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS); const w=wrapperEl(); if(w) w.classList.toggle('minimized', isMin); const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin); document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN); setTimeout(()=> window.dispatchEvent(new Event('resize')), 220); }
      function handleToggleEvent(){ if (isMobile()){ lockFor(260); document.body.classList.contains('sidebar-open') ? closeMobileSidebar() : openMobileSidebar(); } else { lockFor(260); toggleDesktopSidebar(); } }

      function wireToggleButtons(){ qsa(TOGGLE_SELECTORS).forEach(el=>{ if (el.__sidebarToggleBound) return; el.__sidebarToggleBound=true; el.addEventListener('click', handleToggleEvent); }); }

      document.addEventListener('keydown', function(ev){ if (ev.key==='Escape' && document.body.classList.contains('sidebar-open')) closeMobileSidebar(); });
      window.addEventListener('resize', wireToggleButtons);
      document.addEventListener('DOMContentLoaded', wireToggleButtons);
    })();
  </script>
</body>
</html>
