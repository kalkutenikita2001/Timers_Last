<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * application/views/superadmin/Finance.php
 *
 * Visual change only:
 * - Montserrat font everywhere (including numbers).
 * - Tabular numbers for aligned numeric columns.
 * - Details popup design restored to the original Finance.php styles (metric cards, spacing).
 * - Sidebar controller replaced with robust controller copied from your dashboard example (desktop minimize + mobile overlay + dedupe).
 * - No functional/SQL/JS changes to business logic.
 */

function money($n)
{
    return number_format((float)$n, 2);
}

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

if (!is_array($rows)) $rows = [];

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
    <!-- Use same font as Expenses module -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
    <style>
        :root {
            --bg: #f4f6f8;
            --card: #fff;
            --accent1: #ff4040; /* matched to expense */
            --accent2: #470000; /* matched to expense */
            --muted: #6b7280;
            --radius: 10px;
            --sidebar-width: 250px;
            --sidebar-minimized: 60px;
            --card-shadow: 0 14px 40px rgba(12, 12, 14, 0.06);
            --card-shadow-hover: 0 28px 60px rgba(12, 12, 14, 0.10);
            --btn-gradient: linear-gradient(135deg, var(--accent1), var(--accent2));
        }

        * { box-sizing: border-box }

        /* Base page font: Montserrat everywhere */
        body {
            margin: 0;
            font-family: 'Montserrat', Inter, system-ui, -apple-system, 'Segoe UI', Roboto, Arial;
            background: var(--bg);
            color: #111;
            padding-top: 0; /* controlled by your navbar include */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Keep the same sidebar hooks used by your app */
        .wrap { width: 100%; padding: 20px; padding-left: calc(var(--sidebar-width)); transition: padding-left 0.23s ease; }
        .wrap.minimized { padding-left: var(--sidebar-minimized); }

        .content { max-width: 1100px; margin: 0 auto; display:flex; justify-content:center; padding:8px; width:100%; }

        /* Card visually aligned with Expenses module */
        .card {
            background: var(--card);
            border-radius: var(--radius);
            width: 100%;
            max-width: 1200px;
            box-shadow: var(--card-shadow);
            transition: transform .18s ease, box-shadow .18s ease;
            border: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
        }

        /* .card:hover { transform: translateY(-6px); box-shadow: var(--card-shadow-hover); } */

        /* Header style — match Expenses' red gradient bar */
        .card .card-header-like {
            background: linear-gradient(135deg, var(--accent1) 0%, var(--accent2) 100%);
            color: #fff;
            padding: 14px 18px;
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .card .card-header-like h1 { margin:0; font-size:1.05rem; font-weight:600; color:#fff }

        .meta { color: var(--muted); font-size:0.95rem; margin-bottom:8px }

        .table-wrap { overflow:auto; margin-top: 12px; }

        table { width:100%; border-collapse:collapse; min-width:720px }

        thead th {
            background: linear-gradient(135deg, var(--accent1) 0%, var(--accent2) 100%);
            color:#fff; padding:10px; text-align:left; font-weight:600; font-size:0.95rem;
        }

        tbody td { padding:10px; border-bottom:1px solid #eee; vertical-align:middle; font-size:0.95rem }

        /* Ensure numeric columns also use Montserrat and tabular numbers for perfect alignment */
        .right {
            text-align:right;
            font-family: 'Montserrat', ui-monospace, SFMono-Regular, Menlo, Monaco, 'Roboto Mono', monospace;
            font-variant-numeric: tabular-nums;
            -moz-font-feature-settings: "tnum" 1;
            -webkit-font-feature-settings: "tnum" 1;
            font-feature-settings: "tnum" 1;
            font-weight: 500;
        }

        /* Make footer totals consistent */
        tfoot td { padding:10px; background:#fafafa; border-top:2px solid #eee; font-weight:800 }

        .small { color:var(--muted); font-size:0.92rem }

        /* Buttons styled like Expenses */
        .btn-like {
            display:inline-flex; align-items:center; gap:8px; padding:8px 12px; border-radius:8px; font-weight:600; font-size:0.92rem;
            text-decoration:none; color:white; background:var(--btn-gradient); border:none; cursor:pointer;
            box-shadow: 0 6px 18px rgba(71,0,0,0.08);
        }

        .btn-like:active { transform: translateY(0); opacity:0.95 }

        /* Modal kept visually similar but markup/functionality unchanged */
        .modal .modal-content { border-radius:12px; overflow:hidden; border:none; box-shadow:0 30px 80px rgba(12,12,14,0.12); }
        .modal .modal-header { background: var(--btn-gradient); color:#fff; padding:14px 16px; border-bottom:none }
        .modal .modal-body { padding:16px; background:linear-gradient(180deg,#fff,#fff) }
        .modal .modal-footer { padding:12px 16px; border-top:none; background:transparent }

        /*
         * === Restored popup metric styles from original Finance.php ===
         * These styles make the details modal show neat metric cards (label + value),
         * with an accented metric for pending fees as in the original file.
         */
        .modal-metrics {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .metric {
            background: #fff;
            border-radius: 10px;
            padding: 12px;
            min-width: 160px;
            flex: 1;
            box-shadow: 0 8px 28px rgba(12,12,14,0.06);
            border: 1px solid rgba(0,0,0,0.04);
        }

        .metric .label {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .metric .value {
            margin-top: 8px;
            font-weight: 800;
            font-size: 1.05rem;
            /* ensure numbers here use tabular-nums too */
            font-variant-numeric: tabular-nums;
            -moz-font-feature-settings: "tnum" 1;
            -webkit-font-feature-settings: "tnum" 1;
            font-feature-settings: "tnum" 1;
        }

        .metric.accent {
            background: linear-gradient(90deg, rgba(255,90,90,0.06), rgba(139,0,0,0.03));
            border: 1px solid rgba(255,90,90,0.12);
        }

        .small.text-muted {
            color: #68707a;
        }

        /* Responsive tweaks (kept similar to Expenses view) */
        @media (max-width:980px) {
            .wrap { padding-left:12px }
            .content { padding:6px }
            .card { padding:16px }
            table { min-width:640px }
        }

        @media (max-width:640px) {
            .card { padding:14px }
            thead th { font-size:13px }
            tbody td { font-size:13px; padding:8px }
        }

        @media (max-width:480px) { table { min-width:540px } }
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

                <div class="card-header-like">
                    <h1>Revenue — Weekly / Monthly / Yearly</h1>
                    <div style="display:flex;gap:8px;align-items:center">
                        <div style="max-width:250px">
                            <!-- Updated placeholder to indicate ID search also works -->
                            <input type="text" id="globalSearch" class="form-control" placeholder="🔍 Search Centers or enter Center ID..." style="width:100%; padding:8px; border-radius:6px; border:1px solid #e6e6e6; font-family:inherit">
                        </div>
                    </div>
                </div>

                <?php if (!empty($db_error_message)): ?>
                    <div class="error" role="alert" style="margin:16px">
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
                                <th class="right">Yearly (₹)</th>
                                <th class="right">Facility Total (All-time) (₹)</th>
                                <th class="right">All-time Total (₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rows)): ?>
                                <tr>
                                    <td colspan="7" class="small">No centers found.</td>
                                </tr>
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
                                            <div style="font-weight:700; font-size:0.98rem"><?= $cname ?></div>
                                            <div class="small">ID: <?= $cid ?></div>
                                        </td>
                                        <td class="right">₹ <?= money($week) ?></td>
                                        <td class="right">₹ <?= money($month) ?></td>
                                        <td class="right">₹ <?= money($yearly_display) ?></td>
                                        <td class="right">₹ <?= money($ftot) ?></td>
                                        <td class="right">₹ <?= money($alltime) ?></td>
                                        <td>
                                            <a href="<?= (function_exists('base_url') ? base_url("finance/details/{$cid}") : '#') ?>"
                                               class="center-details-link btn-like"
                                               data-center-id="<?= $cid ?>"
                                               title="View center details">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="height:16px;width:16px;">
                                                    <path d="M12 2a10 10 0 100 20 10 10 0 000-20zM11 10h2v6h-2v-6zm0-4h2v2h-2V6z" fill="#fff"/>
                                                </svg>
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
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

                <div style="display:flex;justify-content:space-between;margin-top:12px;flex-wrap:wrap;gap:8px"></div>
            </div><!-- .card -->
        </div><!-- .content -->
    </div><!-- .wrap -->

    <!-- Center Details Modal (unchanged behaviour & markup; design restored via CSS above) -->
    <div class="modal fade" id="centerDetailsModal" tabindex="-1" aria-labelledby="centerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content" style="border-radius:12px;">
                <div class="modal-header" style="border-bottom: none;">
                    <h5 class="modal-title" id="centerDetailsModalLabel">Center Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="centerDetailsModalBody">
                    <div style="min-height:80px; display:flex; align-items:center; justify-content:center;">
                        <div class="small text-muted">Loading...</div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Details modal + helper logic (kept unchanged) -->
    <script>
        (function() {
            function inr(n) {
                if (n === null || n === undefined) return '0.00';
                return Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function escapeHtml(unsafe) {
                if (unsafe === null || unsafe === undefined) return '';
                return String(unsafe).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\"/g, "&quot;").replace(/'/g, "&#039;");
            }

            function buildDetailsHtml(data) {
                return `
          <div>
            <div style="margin-bottom:10px;">
              <strong style="font-size:1.05rem;">${escapeHtml(data.center_name)}</strong>
              <div class="small text-muted">Center ID: ${data.center_id}</div>
            </div>

            <div class="modal-metrics" role="list">
              <div class="metric">
                <div class="label">Total Students</div>
                <div class="value">${escapeHtml(String(data.total_students || 0))}</div>
              </div>

              <div class="metric">
                <div class="label">Active Students</div>
                <div class="value">${escapeHtml(String(data.active_students || 0))}</div>
              </div>

              <div class="metric accent">
                <div class="label">Students with Pending Fees</div>
                <div class="value">${escapeHtml(String(data.students_with_due || 0))}</div>
                <div class="small text-muted" style="margin-top:6px">Total Pending: ₹ ${inr(data.total_due)}</div>
              </div>

              <div class="metric">
                <div class="label">Total Paid (Students)</div>
                <div class="value">₹ ${inr(data.total_paid)}</div>
              </div>
            </div>

            ${data.last_attendance ? `<div style="margin-top:12px;" class="small text-muted">Last attendance recorded: ${escapeHtml(data.last_attendance)}</div>` : ''}
          </div>
        `;
            }

            document.addEventListener('click', function(ev) {
                const a = ev.target.closest && ev.target.closest('a.center-details-link');
                if (!a) return;
                ev.preventDefault();

                const centerId = a.getAttribute('data-center-id') || a.dataset.centerId || a.href.split('/').pop();
                if (!centerId) return;

                const modalEl = document.getElementById('centerDetailsModal');
                const modalBody = document.getElementById('centerDetailsModalBody');
                modalBody.innerHTML = '<div style="min-height:80px; display:flex; align-items:center; justify-content:center;"><div class="small text-muted">Loading...</div></div>';
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                const url = '<?= base_url("finance/get_center_summary/") ?>' + encodeURIComponent(centerId);

                fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
                    .then(function(resp) {
                        if (!resp.ok) { return resp.text().then(t => { throw new Error('Server error: ' + (t || resp.status)); }); }
                        return resp.json();
                    })
                    .then(function(json) {
                        if (!json || json.status !== 'success' || !json.data) {
                            modalBody.innerHTML = '<div class="small text-muted">No data available</div>';
                            return;
                        }
                        modalBody.innerHTML = buildDetailsHtml(json.data);
                    })
                    .catch(function(err) {
                        console.error('Failed to fetch center summary', err);
                        modalBody.innerHTML = '<div class="small text-muted text-danger">Failed to load data. Please try again later.</div>';
                    });
            });
        })();
    </script>

   <!-- Sidebar controller (fixed: single-click on desktop by adding direct pointerdown on toggles) -->
<script>
(function () {
  // --- Configuration ---
  const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
  const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
  const WRAPPER_IDS = ['dashboardWrapper', 'financeWrap', 'contentWrapper', 'wrap'];
  const DESKTOP_WIDTH_CUTOFF = 576;
  const SIDEBAR_OPEN_CLASS = 'active';
  const SIDEBAR_MIN_CLASS = 'minimized';
  const BODY_OVERLAY_CLASS = 'sidebar-open';
  const CSS_VAR = '--sidebar-width';
  const SIDEBAR_WIDTH_OPEN = '250px';
  const SIDEBAR_WIDTH_MIN = '60px';

  // --- Helpers ---
  const qs = s => document.querySelector(s);
  const qsa = s => Array.from(document.querySelectorAll(s));
  const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
  const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean) || qs('.wrap') || qs('.dashboard-wrapper');

  function isMobile() { return window.innerWidth <= DESKTOP_WIDTH_CUTOFF; }

  // Ensure single backdrop exists
  let backdrop = qs('.sidebar-backdrop');
  if (!backdrop) {
    backdrop = document.createElement('div');
    backdrop.className = 'sidebar-backdrop';
    backdrop.style.position = 'fixed';
    backdrop.style.inset = '0';
    backdrop.style.background = 'rgba(0,0,0,0.42)';
    backdrop.style.display = 'none';
    backdrop.style.opacity = '0';
    backdrop.style.transition = 'opacity .18s ease';
    document.body.appendChild(backdrop);
  }

  // Prevent double-toggles
  let lock = false;
  function lockFor(ms=320) { lock = true; clearTimeout(lock._t); lock._t = setTimeout(()=> lock=false, ms); }

  // Track last interactive event to suppress follow-up synthetic clicks
  let lastInteractionAt = 0;
  const INTERACTION_GAP = 700; // ms

  function openMobileSidebar() {
    const s = sidebarEl(); if (!s) return;
    s.classList.add(SIDEBAR_OPEN_CLASS);
    document.body.classList.add(BODY_OVERLAY_CLASS);
    document.body.style.overflow = 'hidden';
    backdrop.style.display = 'block';
    requestAnimationFrame(()=> backdrop.style.opacity = '1');
  }

  function closeMobileSidebar() {
    const s = sidebarEl(); if (s) s.classList.remove(SIDEBAR_OPEN_CLASS);
    document.body.classList.remove(BODY_OVERLAY_CLASS);
    document.body.style.overflow = '';
    backdrop.style.opacity = '0';
    setTimeout(()=> { if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) backdrop.style.display = 'none'; }, 220);
  }

  function toggleDesktopSidebar() {
    const s = sidebarEl(); if (!s) return;
    const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
    const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin);
    const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
    document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
    document.dispatchEvent(new CustomEvent('sidebarToggle', { detail: { minimized: isMin } }));
    setTimeout(()=> window.dispatchEvent(new Event('resize')), 220);
  }

  function handleToggleEvent(e) {
    // suppress clicks immediately after a pointerdown/touch (we set lastInteractionAt)
    if (e && e.type === 'click' && (Date.now() - lastInteractionAt) < INTERACTION_GAP) {
      return;
    }

    if (lock) return;
    if (isMobile()) {
      lockFor(260);
      if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar(); else openMobileSidebar();
    } else {
      lockFor(260);
      toggleDesktopSidebar();
    }
  }

  // --- Wire direct handlers to toggle elements (click + pointerdown) ---
  function wireToggleButtons() {
    const toggles = qsa(TOGGLE_SELECTORS);
    toggles.forEach(el => {
      if (el.__sidebarToggleBound) return;
      el.__sidebarToggleBound = true;

      // pointerdown catches mouse/pen/touch early — immediate reaction on press
      el.addEventListener('pointerdown', function (ev) {
        // mark the interaction time so the following click is ignored by handleToggleEvent
        lastInteractionAt = Date.now();
        // Call handler directly for instantaneous response on desktop/mouse
        try { handleToggleEvent(ev); } catch (err) { console.warn('sidebar pointerdown handler error', err); }
      }, { passive: true });

      // Keep click handler as backup (keyboard activation or other environments)
      el.addEventListener('click', function (ev) {
        // mark interaction time (for safety)
        lastInteractionAt = Date.now();
        // Let delegated handlers decide; still call handler to be sure
        try { handleToggleEvent(ev); } catch (err) { console.warn('sidebar click handler error', err); }
      });
    });
  }

  // Global pointerdown: only use for touch/pen if a toggle was pressed outside wireToggleButtons
  document.addEventListener('pointerdown', function (ev) {
    if (ev.pointerType === 'touch' || ev.pointerType === 'pen') {
      const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
      if (toggle) {
        lastInteractionAt = Date.now();
        handleToggleEvent(ev);
      }
    }
  }, { passive: true });

  // Delegated click: covers dynamic toggles, keyboard, and acts as backup
  document.addEventListener('click', function (ev) {
    const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
    if (toggle) {
      // If a recent pointerdown already handled this, handleToggleEvent will ignore the click
      handleToggleEvent(ev);
    }
  });

  // Backdrop click closes mobile sidebar
  backdrop.addEventListener('click', function () {
    if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) return;
    closeMobileSidebar();
  });

  // Close overlay when clicking a link inside sidebar on mobile (common UX)
  document.addEventListener('click', function (e) {
    if (!isMobile()) return;
    const inside = e.target.closest && e.target.closest(SIDEBAR_SELECTORS);
    if (!inside) return;
    const anchor = e.target.closest && e.target.closest('a');
    if (anchor && anchor.getAttribute('href') && anchor.getAttribute('href') !== '#') {
      setTimeout(closeMobileSidebar, 160);
    }
  });

  // ESC closes overlay
  document.addEventListener('keydown', function (ev) {
    if (ev.key === 'Escape' && document.body.classList.contains(BODY_OVERLAY_CLASS)) {
      closeMobileSidebar();
    }
  });

  // Resize handling
  let resizeTimer = null;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
      if (!isMobile()) {
        closeMobileSidebar();
        const s = sidebarEl();
        const isMin = s && s.classList.contains(SIDEBAR_MIN_CLASS);
        document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
      }
    }, 120);
  });

  // If page initially had sidebar-open, ensure backdrop visible
  if (document.body.classList.contains(BODY_OVERLAY_CLASS)) {
    backdrop.style.display = 'block';
    backdrop.style.opacity = '1';
    document.body.style.overflow = 'hidden';
  }

  // Provide fallback toggle button if none exists, and wire toggles
  (function ensureFallbackToggle() {
    if (qs(TOGGLE_SELECTORS)) {
      wireToggleButtons();
      return;
    }
    const navbar = qs('.navbar, header, .main-header, .topbar');
    if (!navbar) return;
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.id = 'sidebarToggle';
    btn.className = 'btn btn-sm btn-light sidebar-toggle';
    btn.setAttribute('aria-label', 'Toggle sidebar');
    btn.style.marginRight = '8px';
    btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6H20M4 12H20M4 18H20" stroke="#111" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    navbar.prepend(btn);

    wireToggleButtons();
  })();

  // Also wire buttons on DOMContentLoaded (in case toggles are added later)
  document.addEventListener('DOMContentLoaded', () => {
    wireToggleButtons();
  });

})();
</script>


    <script>
    // Enhanced Global search for table:
    // - If value is pure digits, match center ID exactly.
    // - Otherwise, text search.
    (function () {
        const input = document.getElementById('globalSearch');
        if (!input) return;
        input.addEventListener('keyup', function () {
            let raw = this.value.trim();
            if (raw === "") {
                document.querySelectorAll("table tbody tr").forEach(tr => tr.style.display = '');
                return;
            }

            if (/^\d+$/.test(raw)) {
                const id = raw.replace(/^0+/, '') || '0';
                document.querySelectorAll("table tbody tr").forEach(tr => {
                    const rowId = String(tr.getAttribute('data-center-id') || '');
                    tr.style.display = (rowId === id) ? '' : 'none';
                });
                return;
            }

            let value = raw.toLowerCase();
            document.querySelectorAll("table tbody tr").forEach(tr => {
                tr.style.display = (tr.innerText.toLowerCase().indexOf(value) > -1) ? '' : 'none';
            });
        });
    })();
    </script>

    <!-- bootstrap (kept same as original) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
