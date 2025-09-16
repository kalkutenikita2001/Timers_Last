<?php
// Finance.php
// Clean UI: Weekly/Monthly/Yearly windows + Facility Total + All-time Total (Student+Facility).
// Student Total column hidden (keeps logic intact).
// Responsive + animated, integrates with existing sidebar/navbar includes.
// Update DB credentials if needed.

$host = '127.0.0.1';
$port = 3306;
$db   = 'mybadmintondb';
$user = 'root';     // <-- change if needed
$pass = '';         // <-- change if needed
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Friendly error for debugging in dev; in production show a simple message.
    die("DB connection failed: " . htmlspecialchars($e->getMessage()));
}

/*
 SQL: get per-center student & facility aggregates.
 - Students: use COALESCE(created_at, admission_date, joining_date) for date
 - Facilities: student_facilities.amount joined to students for center_id
 - Left join center_details so every center shows (even with zero revenue)
*/
$sql = "
SELECT
  cd.id AS center_id,
  cd.name AS center_name,

  COALESCE(s.stu_weekly,0)  AS stu_weekly,
  COALESCE(s.stu_monthly,0) AS stu_monthly,
  COALESCE(s.stu_yearly,0)  AS stu_yearly,
  COALESCE(s.stu_total,0)   AS stu_total,

  COALESCE(f.fac_weekly,0)  AS fac_weekly,
  COALESCE(f.fac_monthly,0) AS fac_monthly,
  COALESCE(f.fac_yearly,0)  AS fac_yearly,
  COALESCE(f.fac_total,0)   AS fac_total

FROM center_details cd

LEFT JOIN (
  SELECT
    s.center_id,
    SUM(CASE WHEN YEARWEEK(COALESCE(s.created_at, s.admission_date, s.joining_date),1) = YEARWEEK(CURDATE(),1) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_weekly,
    SUM(CASE WHEN YEAR(COALESCE(s.created_at, s.admission_date, s.joining_date)) = YEAR(CURDATE()) AND MONTH(COALESCE(s.created_at, s.admission_date, s.joining_date)) = MONTH(CURDATE()) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_monthly,
    SUM(CASE WHEN YEAR(COALESCE(s.created_at, s.admission_date, s.joining_date)) = YEAR(CURDATE()) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_yearly,
    SUM(COALESCE(s.paid_amount,0)) AS stu_total
  FROM students s
  GROUP BY s.center_id
) s ON s.center_id = cd.id

LEFT JOIN (
  SELECT
    st.center_id,
    SUM(CASE WHEN YEARWEEK(sf.created_at,1) = YEARWEEK(CURDATE(),1) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_weekly,
    SUM(CASE WHEN YEAR(sf.created_at) = YEAR(CURDATE()) AND MONTH(sf.created_at) = MONTH(CURDATE()) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_monthly,
    SUM(CASE WHEN YEAR(sf.created_at) = YEAR(CURDATE()) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_yearly,
    SUM(COALESCE(sf.amount,0)) AS fac_total
  FROM student_facilities sf
  JOIN students st ON st.id = sf.student_id
  GROUP BY st.center_id
) f ON f.center_id = cd.id

ORDER BY (COALESCE(s.stu_total,0) + COALESCE(f.fac_total,0)) DESC, cd.name ASC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

// Compute grand totals separately for student and facility, then combine.
$grand = [
    'week' => 0.0,
    'month' => 0.0,
    'year' => 0.0,
    'stu_alltime' => 0.0,
    'fac_alltime' => 0.0,
];

foreach ($rows as $r) {
    $sw = (float)$r['stu_weekly']; $fw = (float)$r['fac_weekly']; $week = $sw + $fw;
    $sm = (float)$r['stu_monthly']; $fm = (float)$r['fac_monthly']; $month = $sm + $fm;
    $sy = (float)$r['stu_yearly']; $fy = (float)$r['fac_yearly']; $year = $sy + $fy;
    $stot = (float)$r['stu_total']; $ftot = (float)$r['fac_total'];

    $grand['week'] += $week;
    $grand['month'] += $month;
    $grand['year'] += $year;

    $grand['stu_alltime'] += $stot;
    $grand['fac_alltime'] += $ftot;
}

$grand_alltime = $grand['stu_alltime'] + $grand['fac_alltime'];

function money($n) { return number_format((float)$n, 2); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Finance Management</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
      <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <style>
    :root{
      --bg: #f4f6f8;
      --card: #ffffff;
      --accent1: #ff5a5a;
      --accent2: #8b0000;
      --muted: #6b7280;
      --radius: 12px;
      --shadow: 0 12px 30px rgba(12, 12, 14, 0.06);
      --glass: rgba(255,255,255,0.6);
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,'Helvetica Neue',Arial;padding-top: 0px !important;color:#111;background:var(--bg);-webkit-font-smoothing:antialiased}
    .page{display:grid;grid-template-columns:250px 1fr;gap:18px;padding: 18px;;align-items:start;min-height:100vh}
    /* adapt to your app sidebar - toggle via .sidebar-collapsed on .page */
    .page.sidebar-collapsed{grid-template-columns:72px 1fr}
    @media (max-width:980px){ .page{grid-template-columns:1fr;padding:12px} .sidebar-area{display:none} }

    /* Sidebar area: included from your template if present */
    .sidebar-area{padding:6px}

    .main{display:flex;flex-direction:column;gap:14px;min-width:0}

    .topbar{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:20px;height: 45px;border-radius:10px;background:var(--card);box-shadow:var(--shadow)}
    .brand{display:flex;gap:12px;align-items:center}
    .logo{width: 249px;height: 219px;border-radius:10px;display:grid;place-items:center;color:#fff;font-weight:800}
    .page-title{font-weight:700;font-size:1.05rem}
    .subtitle{color:var(--muted);font-size:0.9rem}

    /* card */
    .card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);padding:16px}
    .controls{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap}
    .left-controls{display:flex;gap:8px;align-items:center}
    .select{padding:8px 10px;border-radius:10px;border:1px solid #e6e6e6;background:#fff;font-weight:600}
    .btn{padding:8px 12px;border-radius:10px;border:none;background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;font-weight:700;cursor:pointer;box-shadow:0 8px 18px rgba(139,0,0,0.12)}
    .meta{color:var(--muted);font-size:0.92rem;margin-top:6px}

    /* table */
    .table-wrap{overflow:auto;margin-top:12px;border-radius:10px}
    table{width:100%;border-collapse:collapse;min-width:880px}
    thead th{position:sticky;top:0;background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;padding:12px;text-align:left;font-weight:700;z-index:2}
    tbody td{padding:12px;border-bottom:1px solid #f0f0f0;vertical-align:middle;background:linear-gradient(180deg, rgba(255,255,255,0), rgba(255,255,255,0));}
    tbody tr{transition:transform .18s ease, box-shadow .18s ease, background .18s ease;transform:translateY(0);opacity:0;animation:rowEnter .32s ease forwards}
    tbody tr:hover{transform:translateY(-6px);box-shadow:0 18px 34px rgba(12,12,14,0.06)}
    @keyframes rowEnter { from { transform: translateY(6px); opacity:0 } to { transform: translateY(0); opacity:1 } }

    .right{ text-align:right; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, 'Roboto Mono', monospace; }
    tfoot td{padding:12px;background:#fafafa;border-top:2px solid #eee;font-weight:800}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;background:rgba(255,90,90,0.12);color:var(--accent2);font-weight:700}

    /* responsive tweaks */
    @media (max-width:1100px){ table{min-width:760px} }
    @media (max-width:820px){ table{min-width:700px} .page{grid-template-columns:1fr} .sidebar-area{display:none} }

    /* small helper */
    .small{color:var(--muted);font-size:0.92rem}
    a.btn-sm{display:inline-block;padding:6px 10px;border-radius:8px;background:transparent;color:var(--accent2);border:1px solid rgba(0,0,0,0.06);text-decoration:none;font-weight:700}

  </style>
</head>
<body>

<!-- Sidebar -->
<?php $this->load->view('superadmin/Include/Sidebar') ?>
<!-- Navbar -->
<?php $this->load->view('superadmin/Include/Navbar') ?>


  <div class="page" id="pageRoot">
    <div class="sidebar-area" id="sidebarArea">
      <?php
      // Try to load your CI view if it exists; otherwise render a small fallback sidebar
      if (defined('APPPATH') && is_file(APPPATH . 'views/superadmin/Include/Sidebar.php')) {
          $this->load->view('superadmin/Include/Sidebar');
      } else {
          // Fallback sidebar so page remains usable in standalone contexts
          ?>
          <aside class="sidebar" id="fallbackSidebar" style="width:250px;background:linear-gradient(180deg,#470000,#ff4040);color:#fff;padding:14px;border-radius:10px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
              <div style="width:42px;height:42px;border-radius:8px;background:#fff2f2;display:grid;place-items:center;color:#8b0000;font-weight:800;">FM</div>
              <div>
                <div style="font-weight:800;">My Academy</div>
                <div style="font-size:12px;opacity:0.9;">Finance</div>
              </div>
            </div>
            <nav style="display:flex;flex-direction:column;gap:8px;">
              <a href="#" style="color:#fff;text-decoration:none;padding:8px;border-radius:6px;">Dashboard</a>
              <a href="#" style="color:#fff;text-decoration:none;padding:8px;border-radius:6px;">Centers</a>
              <a href="#" style="color:#fff;text-decoration:none;padding:8px;border-radius:6px;">Students</a>
              <a href="#" style="color:#fff;text-decoration:none;padding:8px;border-radius:6px;">Settings</a>
            </nav>
          </aside>
      <?php } ?>
    </div>

    <div class="main">
      <div class="topbar" role="navigation" aria-label="Page topbar">
        <div class="brand">
          <div class="logo">FM</div>
          <div>
            <div class="page-title">Finance — Center Revenue</div>
            <div class="subtitle">Weekly · Monthly · Yearly · Facility totals · All-time</div>
          </div>
        </div>

        <div style="display:flex;gap:10px;align-items:center">
          <?php if(function_exists('view')): ?>
            <?php $this->load->view('superadmin/Include/Navbar') ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="card" role="region" aria-label="Revenue summary card">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
          <div>
            <div style="font-weight:800;font-size:1.02rem">Revenue overview</div>
            <div class="meta">Shows weekly/monthly/yearly (windowed) and all-time facility & total amounts.</div>
          </div>

          <div class="controls" style="flex:0 0 auto;">
            <div class="left-controls">
              <select id="centerFilter" class="select" aria-label="Filter by center">
                <option value="">— All centers —</option>
<?php
// Build dropdown from centers result set (unique)
$seen = [];
foreach ($rows as $r) {
    $cid = (int)$r['center_id'];
    if (isset($seen[$cid])) continue;
    $seen[$cid] = true;
    $cname = htmlspecialchars($r['center_name'] ?: "Center {$cid}");
    echo "                  <option value=\"{$cid}\">{$cname}</option>\n";
}
?>
              </select>

              <button id="filterBtn" class="btn" title="Filter">Filter</button>
            </div>

            <div style="display:flex;gap:8px;align-items:center">
              <div class="small">Showing <strong><?= count($rows) ?></strong> centers</div>
              <a class="btn-sm" href="#" id="exportCsv">Export CSV</a>
            </div>
          </div>
        </div>

        <div class="table-wrap" style="margin-top:14px;">
          <table role="table" aria-label="Center revenue table">
            <thead>
              <tr>
                <th>Center</th>
                <th class="right">Weekly (₹)</th>
                <th class="right">Monthly (₹)</th>
                <th class="right">Yearly (₹)</th>

                <!-- Student Total column intentionally removed for simplified UI -->
                <!-- Facility Total -->
                <th class="right">Facility Total (All-time) (₹)</th>

                <!-- All-time includes both student + facility -->
                <th class="right">All-time Total (₹)</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody id="table-body">
<?php if (count($rows) === 0): ?>
              <tr><td colspan="7" class="small">No centers found.</td></tr>
<?php else:
  foreach ($rows as $r):
    $cid = (int)$r['center_id'];
    $cname = htmlspecialchars($r['center_name'] ?: "Center {$cid}");
    $sw = (float)$r['stu_weekly']; $fw = (float)$r['fac_weekly']; $week = $sw + $fw;
    $sm = (float)$r['stu_monthly']; $fm = (float)$r['fac_monthly']; $month = $sm + $fm;
    $sy = (float)$r['stu_yearly']; $fy = (float)$r['fac_yearly']; $year = $sy + $fy;
    $stot = (float)$r['stu_total']; $ftot = (float)$r['fac_total']; $alltime = $stot + $ftot;
?>
              <tr data-center-id="<?= $cid ?>">
                <td>
                  <div style="font-weight:700;"><?= $cname ?></div>
                  <div class="small">ID: <?= $cid ?></div>
                </td>

                <td class="right">₹ <?= money($week) ?></td>
                <td class="right">₹ <?= money($month) ?></td>
                <td class="right">₹ <?= money($year) ?></td>

                <td class="right">₹ <?= money($ftot) ?></td>
                <td class="right">₹ <?= money($alltime) ?></td>

                <td><a class="btn-sm" href="finance_details.php?center_id=<?= urlencode($cid) ?>">Details</a></td>
              </tr>
<?php endforeach; endif; ?>
            </tbody>

            <tfoot>
              <tr>
                <td style="font-weight:800">Grand Totals</td>
                <td class="right">₹ <?= money($grand['week']) ?></td>
                <td class="right">₹ <?= money($grand['month']) ?></td>
                <td class="right">₹ <?= money($grand['year']) ?></td>

                <td class="right">₹ <?= money($grand['fac_alltime']) ?></td>
                <td class="right">₹ <?= money($grand_alltime) ?></td>

                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;margin-top:12px;">
          <div class="small">Data: <span style="color:#333">students.paid_amount</span> + <span style="color:#333">student_facilities.amount</span>. Windows: weekly/monthly/yearly use student/facility dates as discussed.</div>
          <div class="small">Last updated: <?= date('Y-m-d H:i:s') ?></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Client filtering, CSV export and small UI behaviors
    (function(){
      const tableBody = document.getElementById('table-body');
      const centerSelect = document.getElementById('centerFilter');
      const filterBtn = document.getElementById('filterBtn');
      const exportCsvBtn = document.getElementById('exportCsv');
      const pageRoot = document.getElementById('pageRoot');

      function filterByCenter(id){
        const rows = Array.from(tableBody.querySelectorAll('tr'));
        if (!id) {
          rows.forEach(r => r.style.display = '');
          return;
        }
        rows.forEach(r => {
          if (r.dataset.centerId === id) r.style.display = '';
          else r.style.display = 'none';
        });
      }

      if (filterBtn) filterBtn.addEventListener('click', () => filterByCenter(centerSelect.value));
      if (centerSelect) centerSelect.addEventListener('change', (e) => filterByCenter(e.target.value));

      // Export visible rows to CSV
      function tableToCSV(){
        const headers = ['Center','Weekly (₹)','Monthly (₹)','Yearly (₹)','Facility Total (All-time) (₹)','All-time Total (₹)'];
        const rows = Array.from(tableBody.querySelectorAll('tr')).filter(r => r.style.display !== 'none');
        const data = [headers];
        rows.forEach(r => {
          const cols = Array.from(r.querySelectorAll('td'));
          if(cols.length === 0) return;
          const row = [
            cols[0].innerText.trim().replace(/\s+ID:.*/,'').trim(),
            cols[1].innerText.replace(/₹/g,'').trim(),
            cols[2].innerText.replace(/₹/g,'').trim(),
            cols[3].innerText.replace(/₹/g,'').trim(),
            cols[4].innerText.replace(/₹/g,'').trim(),
            cols[5].innerText.replace(/₹/g,'').trim()
          ];
          data.push(row);
        });
        return data.map(r => r.map(c => `"${(c+'').replace(/"/g,'""')}"`).join(',')).join('\n');
      }

      if (exportCsvBtn) exportCsvBtn.addEventListener('click', function(e){
        e.preventDefault();
        const csv = tableToCSV();
        const blob = new Blob([csv], {type: 'text/csv;charset=utf-8;'});
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'finance_centers_<?= date('Ymd_His') ?>.csv';
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
      });

      // Sidebar keyboard toggle for accessibility (press 'm' to toggle collapsed)
      document.addEventListener('keydown', function(e){
        if (e.key === 'm' && !e.metaKey && !e.ctrlKey && !e.altKey){
          pageRoot.classList.toggle('sidebar-collapsed');
        }
      });

      // Subtle staggered entrance for rows: add slight delay
      Array.from(tableBody.querySelectorAll('tr')).forEach((tr, i) => {
        tr.style.animationDelay = (i * 0.03) + 's';
      });

    })();

      // Sidebar toggle functionality
      $('#sidebarToggle').on('click', function () {
        if ($(window).width() <= 576) {
          $('#sidebar').toggleClass('active');
          $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
        } else {
          const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
          $('.navbar').toggleClass('sidebar-minimized', isMinimized);
          $('#contentWrapper').toggleClass('minimized', isMinimized);
        }
      });

    
  </script>

  <!-- Optional: If you have an auto-resize script that measures .sidebar width, it will now find .sidebar (or the fallback). -->
</body>
</html>
