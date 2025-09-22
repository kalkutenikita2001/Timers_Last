<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * application/views/superadmin/Finance.php
 * Responsive + improved sidebar behaviour. All server logic preserved.
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f4f6f8;
            --card: #fff;
            --accent1: #ff5a5a;
            --accent2: #8b0000;
            --muted: #6b7280;
            --radius: 12px;
            --sidebar-width: 250px;
            --sidebar-minimized: 60px;
            --card-shadow: 0 14px 40px rgba(12, 12, 14, 0.08);
            --card-shadow-hover: 0 28px 60px rgba(12, 12, 14, 0.12);
            --btn-gradient: linear-gradient(90deg, var(--accent1), var(--accent2));
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: Inter, system-ui, Segoe UI, Roboto, Arial;
            background: var(--bg);
            color: #111
        }

        /* Sidebar fallback styling hooks - actual sidebar markup is in your included view */
        .sidebar,
        #sidebar,
        .main-sidebar {
            transition: transform .22s ease, left .22s ease, right .22s ease;
            will-change: transform;
        }

        /* Desktop push behaviour controlled by --sidebar-width */
        .wrap {
            width: 100%;
            padding: 20px;
            padding-left: calc(var(--sidebar-width));
            transition: padding-left 0.23s ease;
            box-sizing: border-box;
        }

        /* When the sidebar is minimized on desktop we also apply a class on the wrap if necessary */
        .wrap.minimized {
            padding-left: var(--sidebar-minimized);
        }

        .content {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            padding: 8px;
            width: 100%;
        }

        .card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 22px;
            width: 100%;
            max-width: 1200px;
            box-shadow: var(--card-shadow);
            transition: transform .18s ease, box-shadow .18s ease;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow-hover);
        }

        .meta {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 8px
        }

        .table-wrap {
            overflow: auto;
            margin-top: 12px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px
        }

        thead th {
            background: linear-gradient(90deg, var(--accent1), var(--accent2));
            color: #fff;
            padding: 10px;
            text-align: left
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: middle
        }

        .right {
            text-align: right;
            font-family: ui-monospace, monospace
        }

        tfoot td {
            padding: 10px;
            background: #fafafa;
            border-top: 2px solid #eee;
            font-weight: 800
        }

        .small {
            color: var(--muted);
            font-size: 0.92rem
        }

        .error {
            background: #fff6f6;
            border: 1px solid #ffd6d6;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px;
            color: #8b0000
        }

        /* Details button (attractive) */
        .btn-details {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            color: white;
            background: var(--btn-gradient);
            box-shadow: 0 6px 18px rgba(139,0,0,0.12);
            transition: transform .14s ease, box-shadow .14s ease, opacity .12s ease;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .btn-details svg {
            height: 16px;
            width: 16px;
            opacity: 0.98;
            transform: translateY(-0.5px);
        }

        .btn-details:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(139,0,0,0.14);
        }

        .btn-details:active {
            transform: translateY(0);
            opacity: 0.95;
        }

        /* Modal improvements to match color scheme */
        .modal .modal-content {
            border-radius: 16px;
            overflow: hidden;
            border: none;
            background: linear-gradient(180deg, #ffffff, #fff);
            box-shadow: 0 30px 80px rgba(12,12,14,0.16);
        }

        .modal .modal-header {
            background: var(--btn-gradient);
            color: #fff;
            padding: 18px 20px;
            align-items: center;
            border-bottom: none;
        }

        .modal .modal-header h5 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 800;
            letter-spacing: 0.2px;
        }

        .modal .btn-close {
            filter: brightness(1.4);
            opacity: 0.95;
        }

        .modal .modal-body {
            padding: 18px;
            background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(250,250,250,0.98));
        }

        .modal .modal-footer {
            padding: 12px 18px;
            border-top: none;
            background: transparent;
        }

        /* Metric boxes inside modal */
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
        }

        .metric.accent {
            background: linear-gradient(90deg, rgba(255,90,90,0.06), rgba(139,0,0,0.03));
            border: 1px solid rgba(255,90,90,0.12);
        }

        .small.text-muted {
            color: #68707a;
        }

        /* Sidebar overlay/backdrop for smaller screens */
        .sidebar-backdrop {
            display: none;
        }

        body.sidebar-open .sidebar-backdrop {
            display: block;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 1070;
            -webkit-tap-highlight-color: transparent;
        }

        /* Mobile: make sidebar an overlay drawer */
        @media (max-width: 991.98px) {
            .wrap {
                padding-left: 12px;
            }

            .sidebar,
            #sidebar,
            .main-sidebar {
                position: fixed !important;
                top: 0;
                left: 0;
                height: 100vh;
                width: 270px;
                transform: translateX(-100%);
                z-index: 1080;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
                background: #fff;
            }

            body.sidebar-open .sidebar,
            body.sidebar-open #sidebar,
            body.sidebar-open .main-sidebar {
                transform: translateX(0);
            }
        }

        @media (max-width:980px) {
            .wrap {
                padding-left: 12px
            }

            .content {
                padding: 6px
            }

            .card {
                padding: 16px
            }

            table {
                min-width: 640px
            }
        }

        @media (max-width:640px) {
            .card {
                padding: 14px
            }

            thead th {
                font-size: 13px
            }

            tbody td {
                font-size: 13px;
                padding: 8px
            }
        }

        /* Minor niceties for smaller tables to avoid overlap */
        @media (max-width:480px) {
            table {
                min-width: 540px;
            }
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
                                            <div style="font-weight:700;"><?= $cname ?></div>
                                            <div class="small">ID: <?= $cid ?></div>
                                        </td>
                                        <td class="right">₹ <?= money($week) ?></td>
                                        <td class="right">₹ <?= money($month) ?></td>
                                        <td class="right">₹ <?= money($yearly_display) ?></td>
                                        <td class="right">₹ <?= money($ftot) ?></td>
                                        <td class="right">₹ <?= money($alltime) ?></td>
                                        <td>
                                            <a href="<?= (function_exists('base_url') ? base_url("finance/details/{$cid}") : '#') ?>"
                                               class="center-details-link btn-details"
                                               data-center-id="<?= $cid ?>"
                                               title="View center details">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
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

                <div style="display:flex;justify-content:space-between;margin-top:12px;flex-wrap:wrap;gap:8px">
                </div>
            </div><!-- .card -->
        </div><!-- .content -->
    </div><!-- .wrap -->

    <!-- Center Details Modal -->
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

    <!-- Details modal + helper logic (kept; unchanged) -->
    <script>
        (function() {
            // Helper: format INR
            function inr(n) {
                if (n === null || n === undefined) return '0.00';
                return Number(n).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function escapeHtml(unsafe) {
                if (unsafe === null || unsafe === undefined) return '';
                return String(unsafe)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
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

            // Delegate click for details links
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

                fetch(url, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(resp) {
                        if (!resp.ok) {
                            return resp.text().then(t => { throw new Error('Server error: ' + (t || resp.status)); });
                        }
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

    <!-- Robust single sidebar controller (drop-in): replaces other sidebar scripts -->
    <script>
    (function () {
      const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
      const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
      const WRAPPERS = ['financeWrap','dashboardWrapper','contentWrapper','wrap'];
      const DESKTOP_BREAK = 576; // px cutoff for mobile overlay mode
      const OPEN_CLASS = 'active';      // applied to sidebar in mobile overlay mode
      const BODY_OVERLAY = 'sidebar-open';
      const MIN_CLASS = 'minimized';
      const CSS_VAR = '--sidebar-width';
      const OPEN_WIDTH = '250px';
      const MIN_WIDTH = '60px';
      const IGNORE_MS = 600; // time window after pointerdown to ignore the following click

      const qs = s => document.querySelector(s);
      function sidebarEl() { return qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar'); }
      function wrapperEl() {
        for (const id of WRAPPERS) {
          const el = document.getElementById(id);
          if (el) return el;
        }
        return qs('.wrap') || qs('.dashboard-wrapper') || null;
      }
      function isMobile() { return window.innerWidth <= DESKTOP_BREAK; }

      // single backdrop instance
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

      let ignoreToggleUntil = 0;
      function openMobile() {
        const s = sidebarEl(); if (!s) return;
        s.classList.add(OPEN_CLASS);
        document.body.classList.add(BODY_OVERLAY);
        document.body.style.overflow = 'hidden';
        backdrop.style.display = 'block';
        requestAnimationFrame(()=> backdrop.style.opacity = '1');
      }
      function closeMobile() {
        const s = sidebarEl(); if (s) s.classList.remove(OPEN_CLASS);
        document.body.classList.remove(BODY_OVERLAY);
        document.body.style.overflow = '';
        backdrop.style.opacity = '0';
        setTimeout(()=> {
          if (!document.body.classList.contains(BODY_OVERLAY)) backdrop.style.display = 'none';
        }, 220);
      }
      function toggleDesktop() {
        const s = sidebarEl(); if (!s) return;
        const isMin = s.classList.toggle(MIN_CLASS);
        const w = wrapperEl(); if (w) w.classList.toggle('minimized', isMin);
        const nav = qs('.navbar'); if (nav) nav.classList.toggle('sidebar-minimized', isMin);
        document.documentElement.style.setProperty(CSS_VAR, isMin ? MIN_WIDTH : OPEN_WIDTH);
        document.dispatchEvent(new CustomEvent('sidebarToggle', { detail: { minimized: isMin } }));
        setTimeout(()=> window.dispatchEvent(new Event('resize')), 220);
      }

      function handleActivation() {
        if (isMobile()) {
          if (document.body.classList.contains(BODY_OVERLAY)) closeMobile(); else openMobile();
        } else {
          toggleDesktop();
        }
      }

      // pointerdown — fast on touch; set ignore window to dedupe click
      document.addEventListener('pointerdown', function (ev) {
        try {
          const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
          if (!toggle) return;
          ignoreToggleUntil = Date.now() + IGNORE_MS;
          handleActivation();
        } catch (err) { /* silent */ }
      }, { passive: true });

      // click — handle mouse/keyboard; ignore if pointerdown handled it recently
      document.addEventListener('click', function (ev) {
        const toggle = ev.target.closest && ev.target.closest(TOGGLE_SELECTORS);
        if (!toggle) return;
        if (Date.now() < ignoreToggleUntil) return;
        handleActivation();
      });

      // backdrop closes overlay
      backdrop.addEventListener('click', function () {
        if (!document.body.classList.contains(BODY_OVERLAY)) return;
        closeMobile();
      });

      // close when clicking a real link inside sidebar (mobile)
      document.addEventListener('click', function (e) {
        if (!isMobile()) return;
        const inside = e.target.closest && e.target.closest(SIDEBAR_SELECTORS);
        if (!inside) return;
        const anchor = e.target.closest && e.target.closest('a[href]');
        if (anchor && anchor.getAttribute('href') && anchor.getAttribute('href') !== '#') {
          setTimeout(closeMobile, 140);
        }
      });

      // ESC closes overlay
      document.addEventListener('keydown', function (ev) {
        if (ev.key === 'Escape' && document.body.classList.contains(BODY_OVERLAY)) {
          closeMobile();
        }
      });

      // on resize, ensure overlay closed on desktop and sync CSS var
      let rt = null;
      window.addEventListener('resize', function () {
        clearTimeout(rt);
        rt = setTimeout(function () {
          if (!isMobile()) {
            closeMobile();
            const s = sidebarEl();
            const isMin = s && s.classList.contains(MIN_CLASS);
            document.documentElement.style.setProperty(CSS_VAR, isMin ? MIN_WIDTH : OPEN_WIDTH);
          }
        }, 120);
      });

      // inject a fallback toggle if none present (non-destructive)
      (function ensureToggle() {
        if (qs(TOGGLE_SELECTORS)) return;
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
      })();

      // if overlay class already present, show backdrop
      if (document.body.classList.contains(BODY_OVERLAY)) {
        backdrop.style.display = 'block';
        backdrop.style.opacity = '1';
        document.body.style.overflow = 'hidden';
      }
    })();
    </script>

    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
