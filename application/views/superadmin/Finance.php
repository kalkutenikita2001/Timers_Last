<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * application/views/superadmin/Finance.php
 * Modified: removed windowed Yearly column and renamed Student All-time -> Yearly (₹)
 * Accepts $rows/$grand/$grand_alltime from controller, or will fetch from CI DB if missing.
 */

function money($n) { return number_format((float)$n, 2); }

// If controller supplied rows, use them. Otherwise, try to fetch using CI DB (if available).
if (!isset($rows) || !is_array($rows)) {
    $rows = [];

    // If running inside CI (view loaded by a controller with $this->db), fetch data here.
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
            // DB error — fall back to empty rows (view will show "No centers found")
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
        // we'll use stu_alltime in the 'Yearly' column (renamed)
        'stu_alltime' => 0.0,
        'fac_alltime' => 0.0,
    ];

    foreach ($rows as &$r) {
        // cast numeric fields (if SQL returned strings)
        $r['stu_weekly']  = isset($r['stu_weekly']) ? (float)$r['stu_weekly'] : 0.0;
        $r['stu_monthly'] = isset($r['stu_monthly']) ? (float)$r['stu_monthly'] : 0.0;
        $r['stu_yearly']  = isset($r['stu_yearly']) ? (float)$r['stu_yearly'] : 0.0;
        $r['stu_total']   = isset($r['stu_total']) ? (float)$r['stu_total'] : 0.0;
        $r['fac_weekly']  = isset($r['fac_weekly']) ? (float)$r['fac_weekly'] : 0.0;
        $r['fac_monthly'] = isset($r['fac_monthly']) ? (float)$r['fac_monthly'] : 0.0;
        $r['fac_yearly']  = isset($r['fac_yearly']) ? (float)$r['fac_yearly'] : 0.0;
        $r['fac_total']   = isset($r['fac_total']) ? (float)$r['fac_total'] : 0.0;

        // derived (overlapping) windows:
        $r['week']  = $r['stu_weekly'] + $r['fac_weekly'];
        $r['month'] = $r['stu_monthly'] + $r['fac_monthly'];
        // we removed the separate windowed 'year' column from the UI; keep it if needed in data
        $r['year_window'] = $r['stu_yearly'] + $r['fac_yearly'];

        // ALL-TIME must include both student + facility
        $r['alltime'] = $r['stu_total'] + $r['fac_total'];

        $grand['week'] += $r['week'];
        $grand['month'] += $r['month'];
        $grand['stu_alltime'] += $r['stu_total'];
        $grand['fac_alltime'] += $r['fac_total'];
    }
    unset($r);
}

// Ensure grand_alltime exists (student + facility all-time)
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
    :root{--bg:#f4f6f8;--card:#fff;--accent1:#ff5a5a;--accent2:#8b0000;--muted:#6b7280;--radius:12px}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,Segoe UI,Roboto,Arial;background:var(--bg);color:#111}
    .wrap{max-width:1100px;margin:18px auto;padding:12px}
    .card{background:var(--card);border-radius:var(--radius);padding:16px}
    .meta{color:var(--muted);font-size:0.95rem;margin-bottom:8px}
    .table-wrap{overflow:auto;margin-top:12px}
    table{width:100%;border-collapse:collapse;min-width:720px}
    thead th{background:linear-gradient(90deg,var(--accent1),var(--accent2));color:#fff;padding:10px;text-align:left}
    tbody td{padding:10px;border-bottom:1px solid #eee;vertical-align:middle}
    .right{text-align:right;font-family:ui-monospace,monospace}
    tfoot td{padding:10px;background:#fafafa;border-top:2px solid #eee;font-weight:800}
    .small{color:var(--muted);font-size:0.92rem}
    .error{background:#fff6f6;border:1px solid #ffd6d6;padding:10px;border-radius:8px;margin-bottom:12px;color:#8b0000}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="card" role="region" aria-label="Revenue summary">
      <h1>Revenue — Weekly / Monthly / Yearly</h1>
      <div class="meta">Weekly/Monthly are windowed (overlap). 'Yearly' column now shows student all-time (renamed); All-time column shows student+facility combined.</div>

      <?php if (!empty($db_error_message)): ?>
        <div class="error">
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
                // 'Yearly' column displays student ALL-TIME (renamed)
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

                <!-- Yearly now shows student all-time (as requested) -->
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

              <!-- Yearly footer shows grand student all-time -->
              <td class="right">₹ <?= money($grand['stu_alltime'] ?? 0) ?></td>

              <td class="right">₹ <?= money($grand['fac_alltime'] ?? 0) ?></td>
              <td class="right">₹ <?= money($grand_alltime ?? 0) ?></td>

              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div style="display:flex;justify-content:space-between;margin-top:12px">
        <div class="small">Source: students.paid_amount + student_facilities.amount. Dates: students.created_at/admission_date/joining_date & student_facilities.created_at.</div>
        <div class="small">Rendered: <?= date('Y-m-d H:i:s') ?></div>
      </div>
    </div>
  </div>
</body>
</html>
