<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * application/views/superadmin/Finance.php
 * Centers the card responsively while keeping the sidebar offset in mind.
 * All existing PHP logic is preserved.
 */

function money($n) { return number_format((float)$n, 2); }

// If controller supplied rows, use them. Otherwise, try to fetch using CI DB (if available).
if (!isset($rows) || !is_array($rows)) {
    $rows = [];

    if (isset($this) && is_object($this) && property_exists($this, 'db')) {
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
                SUM(CASE WHEN YEARWEEK(COALESCE(s.created_at,s.admission_date,s.joining_date),1)=YEARWEEK(CURDATE(),1) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_weekly,
                SUM(CASE WHEN YEAR(COALESCE(s.created_at,s.admission_date,s.joining_date))=YEAR(CURDATE()) AND MONTH(COALESCE(s.created_at,s.admission_date,s.joining_date))=MONTH(CURDATE()) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_monthly,
                SUM(CASE WHEN YEAR(COALESCE(s.created_at,s.admission_date,s.joining_date))=YEAR(CURDATE()) THEN COALESCE(s.paid_amount,0) ELSE 0 END) AS stu_yearly,
                SUM(COALESCE(s.paid_amount,0)) AS stu_total
              FROM students s
              GROUP BY s.center_id
            ) s ON s.center_id = cd.id
            LEFT JOIN (
              SELECT
                st.center_id,
                SUM(CASE WHEN YEARWEEK(sf.created_at,1)=YEARWEEK(CURDATE(),1) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_weekly,
                SUM(CASE WHEN YEAR(sf.created_at)=YEAR(CURDATE()) AND MONTH(sf.created_at)=MONTH(CURDATE()) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_monthly,
                SUM(CASE WHEN YEAR(sf.created_at)=YEAR(CURDATE()) THEN COALESCE(sf.amount,0) ELSE 0 END) AS fac_yearly,
                SUM(COALESCE(sf.amount,0)) AS fac_total
              FROM student_facilities sf
              JOIN students st ON st.id = sf.student_id
              GROUP BY st.center_id
            ) f ON f.center_id = cd.id
            ORDER BY (COALESCE(s.stu_total,0) + COALESCE(f.fac_total,0)) DESC, cd.name ASC
        ";

        try {
            $q = $this->db->query($sql);
            $rows = $q->result_array();
        } catch (Exception $e) {
            $rows = [];
            $db_error_message = $e->getMessage();
        }
    }
}

// Ensure rows is array
if (!is_array($rows)) $rows = [];

// If controller didn't provide $grand, compute here from $rows
if (!isset($grand) || !is_array($grand)) {
    $grand = [
        'week' => 0.0,
        'month' => 0.0,
        'stu_alltime' => 0.0,
        'fac_alltime' => 0.0,
    ];

    foreach ($rows as &$r) {
        $r['stu_weekly']  = isset($r['stu_weekly']) ? (float)$r['stu_weekly'] : 0.0;
        $r['stu_monthly'] = isset($r['stu_monthly']) ? (float)$r['stu_monthly'] : 0.0;
        $r['stu_yearly']  = isset($r['stu_yearly']) ? (float)$r['stu_yearly'] : 0.0;
        $r['stu_total']   = isset($r['stu_total']) ? (float)$r['stu_total'] : 0.0;
        $r['fac_weekly']  = isset($r['fac_weekly']) ? (float)$r['fac_weekly'] : 0.0;
        $r['fac_monthly'] = isset($r['fac_monthly']) ? (float)$r['fac_monthly'] : 0.0;
        $r['fac_yearly']  = isset($r['fac_yearly']) ? (float)$r['fac_yearly'] : 0.0;
        $r['fac_total']   = isset($r['fac_total']) ? (float)$r['fac_total'] : 0.0;

        $r['week']  = $r['stu_weekly'] + $r['fac_weekly'];
        $r['month'] = $r['stu_monthly'] + $r['fac_monthly'];
        $r['year_window'] = $r['stu_yearly'] + $r['fac_yearly'];

        $r['alltime'] = $r['stu_total'] + $r['fac_total'];

        $grand['week'] += $r['week'];
        $grand['month'] += $r['month'];
        $grand['stu_alltime'] += $r['stu_total'];
        $grand['fac_alltime'] += $r['fac_total'];
    }
    unset($r);
}

if (!isset($grand_alltime)) {
    $grand_alltime = (float)$grand['stu_alltime'] + (float)$grand['fac_alltime'];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Finance — Center Revenue</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#f4f6f8;
      --card:#fff;
      --accent1:#ff5a5a;
      --accent2:#8b0000;
      --muted:#6b7280;
      --radius:12px;
      --sidebar-width:250px;       /* default; JS will overwrite with real value */
      --sidebar-minimized:60px;    /* minimized width */
      --card-shadow: 0 14px 40px rgba(12, 12, 14, 0.08);
      --card-shadow-hover: 0 28px 60px rgba(12,12,14,0.12);
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Arial;background:var(--bg);color:#111}
    /* outer wrap uses padding-left equal to sidebar width so content area = viewport - sidebar */
    .wrap{
      width:100%;
      padding:20px;
      padding-left: calc(var(--sidebar-width));
      transition: padding-left 0.23s ease;
      box-sizing:border-box;
    }
    /* when we detect minimized state we'll set --sidebar-width to minimized via JS; no CSS class required */
    /* content container centers the card within the available content width */
    .content {
      max-width:1100px;
      margin:0 auto;              /* centers content area horizontally */
      display:flex;
      justify-content:center;     /* centers the card in the content area */
      padding:8px;
    }

    .card{
      background:var(--card);
      border-radius:var(--radius);
      padding:22px;
      width:100%;
      max-width:1200px;
      box-shadow:var(--card-shadow);
      transition: transform .18s ease, box-shadow .18s ease;
      border: 1px solid rgba(0,0,0,0.04);
    }
    .card:hover{
      transform: translateY(-6px);
      box-shadow:var(--card-shadow-hover);
    }

    .meta{color:var(--muted);font-size:0.95rem;margin-bottom:8px}
    .table-wrap{overflow:auto;margin-top:12px}
    table{width:100%;border-collapse:collapse;min-width:720px}
    thead th{background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;padding:10px;text-align:left}
    tbody td{padding:10px;border-bottom:1px solid #eee;vertical-align:middle}
    .right{text-align:right;font-family:ui-monospace,monospace}
    tfoot td{padding:10px;background:#fafafa;border-top:2px solid #eee;font-weight:800}
    .small{color:var(--muted);font-size:0.92rem}
    .error{background:#fff6f6;border:1px solid #ffd6d6;padding:10px;border-radius:8px;margin-bottom:12px;color:#8b0000}

    @media (max-width:980px){
      .wrap{padding-left:12px} /* on small screens sidebar is likely hidden; fallback safe value */
      .content{padding:6px}
      .card{padding:16px}
      table{min-width:640px}
    }
    @media (max-width:640px){
      .card{padding:14px}
      thead th{font-size:13px}
      tbody td{font-size:13px; padding:8px}
    }
  </style>
</head>
<body>
   <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <div class="wrap" id="financeWrap" role="main">
    <div class="content">
      <div class="card" role="region" aria-label="Revenue summary">
        <h1 style="margin:0 0 8px 0;font-size:1.05rem">Revenue — Weekly / Monthly / Yearly</h1>
        <div class="meta">Weekly/Monthly are windowed (overlap). 'Yearly' column now shows student all-time (renamed); All-time column shows student+facility combined.</div>

        <?php if (!empty($db_error_message)): ?>
          <div class="error" role="alert">
            <strong>Warning:</strong> Database query failed inside view. Message: <?= htmlspecialchars($db_error_message) ?>
          </div>
        <?php endif; ?>

        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>Center</th>
                <th class="right">Weekly (₹)</th>
                <th class="right">Monthly (₹)</th>
                <th class="right">Yearly (₹)</th> <!-- renamed: shows student all-time -->
                <th class="right">Facility Total (All-time) (₹)</th>
                <th class="right">All-time Total (₹)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rows)): ?>
                <tr><td colspan="7" class="small">No centers found.</td></tr>
              <?php else: foreach ($rows as $r):
                  $cid = (int)($r['center_id'] ?? 0);
                  $cname = htmlspecialchars($r['center_name'] ?? "Center {$cid}");
                  $week = $r['week'] ?? 0;
                  $month = $r['month'] ?? 0;
                  $yearly_display = $r['stu_total'] ?? 0;
                  $ftot = $r['fac_total'] ?? 0;
                  $alltime = $r['alltime'] ?? (($r['stu_total'] ?? 0) + $ftot);
              ?>
                <tr data-center-id="<?= $cid ?>">
                  <td>
                    <div style="font-weight:700;"><?= $cname ?></div>
                    <div class="small">ID: <?= $cid ?></div>
                  </td>
                  <td class="right">₹ <?= money($week) ?></td>
                  <td class="right">₹ <?= money($month) ?></td>
                  <td class="right">₹ <?= money($yearly_display) ?></td>
                  <td class="right">₹ <?= money($ftot) ?></td>
                  <td class="right">₹ <?= money($alltime) ?></td>
                  <td><a href="<?= (function_exists('base_url') ? base_url("finance/details/{$cid}") : '#') ?>">Details</a></td>
                </tr>
              <?php endforeach; endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <td style="font-weight:800">Grand Totals</td>
                <td class="right">₹ <?= money($grand['week'] ?? 0) ?></td>
                <td class="right">₹ <?= money($grand['month'] ?? 0) ?></td>
                <td class="right">₹ <?= money($grand['stu_alltime'] ?? 0) ?></td>
                <td class="right">₹ <?= money($grand['fac_alltime'] ?? 0) ?></td>
                <td class="right">₹ <?= money($grand_alltime ?? 0) ?></td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div style="display:flex;justify-content:space-between;margin-top:12px">
          <div class="small">Source: students.paid_amount + student_facilities.amount. Dates: students.created_at/admission_date/joining_date &amp; student_facilities.created_at.</div>
          <div class="small">Rendered: <?= date('Y-m-d H:i:s') ?></div>
        </div>
      </div><!-- .card -->
    </div><!-- .content -->
  </div><!-- .wrap -->

  <script>
    (function () {
      const wrap = document.getElementById('financeWrap');

      // safe defaults
      const DEFAULT_SIDEBAR = 250;
      const MINIMIZED_SIDEBAR = 60;

      // finds likely sidebar element
      function findSidebar() {
        return document.querySelector('.sidebar, #sidebar, .main-sidebar, .sidebar-area, .left-sidebar');
      }

      // update CSS variable --sidebar-width based on current sidebar width or minimized state
      function updateSidebarWidth() {
        const sidebar = findSidebar();
        let width = DEFAULT_SIDEBAR;

        if (!sidebar) {
          // If sidebar is not found, but wrap has class minimized, use minimized width
          if (wrap && wrap.classList.contains('minimized')) width = MINIMIZED_SIDEBAR;
        } else {
          // If sidebar has minimized/collapsed class, pick minimized width
          const cls = sidebar.className || '';
          if (cls.includes('minimized') || cls.includes('collapsed') || cls.includes('sidebar-collapse')) {
            width = MINIMIZED_SIDEBAR;
          } else {
            // prefer offsetWidth (px)
            width = Math.max(sidebar.offsetWidth || DEFAULT_SIDEBAR, 48);
          }
        }

        // set CSS custom property on document root for usage in CSS
        document.documentElement.style.setProperty('--sidebar-width', width + 'px');
      }

      // run on load
      updateSidebarWidth();

      // re-run on resize (debounced)
      let resizeTimer = null;
      window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateSidebarWidth, 120);
      });

      // observe class changes on the sidebar (to detect minimized/collapsed toggles)
      const sidebar = findSidebar();
      if (sidebar) {
        const mo = new MutationObserver(function (mutations) {
          for (const m of mutations) {
            if (m.type === 'attributes' && m.attributeName === 'class') {
              updateSidebarWidth();
            }
          }
        });
        mo.observe(sidebar, { attributes: true, attributeFilter: ['class'] });
      }

      // listen for programmatic sidebarToggle events from your other pages/scripts
      document.addEventListener('sidebarToggle', function (e) {
        updateSidebarWidth();
        // reflect wrap.minimized if event carries it
        if (wrap && e.detail && typeof e.detail.minimized !== 'undefined') {
          wrap.classList.toggle('minimized', !!e.detail.minimized);
        }
      });

      // keyboard 'm' for quick testing (preserves your existing behavior)
      document.addEventListener('keydown', function (e) {
        if (e.key === 'm' && !e.ctrlKey && !e.metaKey && !e.altKey) {
          if (wrap) wrap.classList.toggle('minimized');
          updateSidebarWidth();
          document.dispatchEvent(new CustomEvent('sidebarToggle', { detail: { minimized: wrap && wrap.classList.contains('minimized') } }));
        }
      });
    })();
  </script>
</body>
</html>
