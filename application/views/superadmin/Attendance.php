<!-- application/views/superadmin/attendance.php (improved) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Staff Attendance</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <!-- UI libs (front-end only) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --accent-1:#ff4040;
      --accent-2:#470000;
      --muted-bg:#f4f6f8;
      --primary-gradient: linear-gradient(135deg, var(--accent-1) 0%, var(--accent-2) 100%);
    }

    html, body { height:100%; }
    body{
      background:var(--muted-bg) !important;
      font-family:'Montserrat', serif;
      color:#1a1a1a;
      overflow-x:hidden;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Same outer wrapper as Dashboard */
    .dashboard-wrapper{
      margin-left:250px;
      padding:24px;
      min-height:100vh;
      background:var(--muted-bg);
      transition:all .25s ease-in-out;
    }
    .dashboard-wrapper.minimized{ margin-left:60px; }

    .card{
      border:none;
      border-radius:12px;
      box-shadow:0 6px 18px rgba(0,0,0,.06);
      overflow:hidden;
      background:#fff;
    }
    .card-header{
      background:var(--primary-gradient);
      color:#fff;
      padding:16px 20px;
    }

    .filters .form-select, .filters .form-control{ min-width:160px; }
    .search-container{ position:relative; }
    .search-container i{
      position:absolute; left:10px; top:50%; transform:translateY(-50%); color:#6c757d;
    }
    #tableSearch{
      padding-left:35px; border-radius:20px; border:1px solid #ced4da; width:260px;
    }

    .table thead{ background:var(--primary-gradient); color:#fff; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.05); }
    .staff-id{ font-weight:700; color:var(--accent-1); }
    .badge-status{ font-size:.8rem; }

    .btn-round{ border-radius:999px; }
    .btn-icon{ display:inline-flex; align-items:center; gap:.35rem; }

    .session-chip{ font-size:.75rem; border:1px dashed #dee2e6; padding:.2rem .45rem; border-radius:999px; }

    /* Mobile friendly table */
    @media (max-width:576px){
      .table thead{ display:none; }
      .table, .table tbody, .table tr, .table td{ display:block; width:100%; }
      .table tr{
        margin-bottom:12px; border:1px solid #e9ecef; border-radius:8px; padding:8px; background:#fff;
      }
      .table td{
        text-align:right; padding:8px 10px; position:relative; border:none; border-bottom:1px solid #f1f1f1;
      }
      .table td:before{
        content:attr(data-label); position:absolute; left:10px; width:55%; text-align:left; font-weight:600; color:#6c757d;
      }
    }

    /* Dashboard responsive parity */
    @media (max-width:991.98px){
      .dashboard-wrapper{ margin-left:0 !important; padding:16px; }
    }

    /* Mobile overlay sidebar (same behavior as Dashboard) */
    @media (max-width:575.98px){
      .sidebar, #sidebar, .main-sidebar{
        position:fixed !important; top:0; left:0; height:100vh; width:260px;
        transform:translateX(-100%); z-index:1080; background:#fff;
        box-shadow:0 14px 40px rgba(0,0,0,.18); transition:transform .28s ease;
      }
      .sidebar.active, #sidebar.active, .main-sidebar.active{ transform:translateX(0); }
      .sidebar-backdrop{ display:none; }
      body.sidebar-open .sidebar-backdrop{
        display:block; position:fixed; inset:0; background:rgba(0,0,0,.42); z-index:1070;
      }
      #tableSearch{ width:100% !important; margin-top:8px; }
    }
  </style>
</head>

<body>
  <!-- Include the same Sidebar & Navbar as Dashboard -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- Page Content -->
  <div class="dashboard-wrapper" id="dashboardWrapper">
    <div class="container-fluid px-2 px-md-3">
      <div class="card mb-3">
        <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
          <div class="mb-2 mb-md-0">
            <h5 class="mb-1"><i class="fa-solid fa-clipboard-check me-2"></i>Staff Attendance</h5>
            <small class="text-white-50">Admin panel to mark Present/Absent and Check-In/Check-Out</small>
          </div>

          <div class="d-flex flex-column gap-2">
            <div class="d-flex align-items-center gap-2 flex-wrap filters">
              <div class="search-container">
                <i class="fas fa-search"></i>
                <input id="tableSearch" class="form-control form-control-sm" type="text" placeholder="Search staff..."/>
              </div>

              <select id="roleFilter" class="form-select form-select-sm">
                <option value="">All Roles</option>
                <option value="Coach">Coach</option>
                <option value="Manager">Manager</option>
                <option value="Physio">Physio</option>
                <option value="Support">Support</option>
              </select>

              <select id="statusFilter" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
              </select>

              <input id="datePicker" type="date" class="form-control form-control-sm"/>
            </div>

            <div class="d-flex flex-wrap gap-2">
              <button id="markAllPresent" class="btn btn-success btn-sm btn-round btn-icon">
                <i class="fa-solid fa-user-check"></i> Mark All Present
              </button>
              <button id="markAllAbsent" class="btn btn-outline-secondary btn-sm btn-round btn-icon">
                <i class="fa-solid fa-user-xmark"></i> Mark All Absent
              </button>
              <button id="resetTimes" class="btn btn-outline-dark btn-sm btn-round btn-icon">
                <i class="fa-solid fa-rotate-left"></i> Reset Check-In/Out
              </button>
            </div>
          </div>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" id="staffTable">
              <thead>
                <tr>
                  <th style="width:60px;">ID</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Shift</th>
                  <th>Status</th>
                  <th>Check-In</th>
                  <th>Check-Out</th>
                  <th style="min-width:320px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- Sample static rows; replace with backend later -->
                <tr data-role="Coach" data-sessions='[{"label":"Batch 1 (AM)","start":"06:00 AM","end":"08:00 AM"},{"label":"Batch 2 (AM)","start":"08:00 AM","end":"10:00 AM"},{"label":"Batch 3 (PM)","start":"05:00 PM","end":"07:00 PM"}]'>
                  <td data-label="ID" class="staff-id"></td>
                  <td data-label="Name">Anita Sharma</td>
                  <td data-label="Role">Coach</td>
                  <td data-label="Shift">
                    <span class="session-chip">06:00–08:00 AM</span>
                    <span class="session-chip">08:00–10:00 AM</span>
                    <span class="session-chip">05:00–07:00 PM</span>
                  </td>
                  <td data-label="Status" class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                  <td data-label="Check-In" class="checkin-cell">—</td>
                  <td data-label="Check-Out" class="checkout-cell">—</td>
                  <td data-label="Action" class="action-cell">
                    <div class="d-flex flex-wrap gap-2">
                      <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary btn-present-toggle" data-target="Present"><i class="fa-solid fa-user-check"></i> Present</button>
                        <button class="btn btn-outline-secondary btn-present-toggle active" data-target="Absent"><i class="fa-solid fa-user-xmark"></i> Absent</button>
                      </div>
                      <button class="btn btn-primary btn-sm btn-icon btn-checkin" disabled><i class="fa-regular fa-circle-play"></i> Check-In</button>
                      <button class="btn btn-outline-primary btn-sm btn-icon btn-checkout" disabled><i class="fa-regular fa-circle-stop"></i> Check-Out</button>
                      <button class="btn btn-outline-dark btn-sm btn-icon btn-sessions"><i class="fa-solid fa-layer-group"></i> Sessions</button>
                    </div>
                  </td>
                </tr>

                <tr data-role="Manager">
                  <td class="staff-id"></td>
                  <td>Rohit Verma</td>
                  <td>Manager</td>
                  <td>09:00 AM – 05:00 PM</td>
                  <td class="status-cell"><span class="badge bg-success badge-status">Present</span></td>
                  <td class="checkin-cell">09:02 AM</td>
                  <td class="checkout-cell">—</td>
                  <td class="action-cell">
                    <div class="d-flex flex-wrap gap-2">
                      <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary btn-present-toggle active" data-target="Present"><i class="fa-solid fa-user-check"></i> Present</button>
                        <button class="btn btn-outline-secondary btn-present-toggle" data-target="Absent"><i class="fa-solid fa-user-xmark"></i> Absent</button>
                      </div>
                      <button class="btn btn-primary btn-sm btn-icon btn-checkin" disabled><i class="fa-regular fa-circle-play"></i> Check-In</button>
                      <button class="btn btn-outline-primary btn-sm btn-icon btn-checkout"><i class="fa-regular fa-circle-stop"></i> Check-Out</button>
                    </div>
                  </td>
                </tr>

                <tr data-role="Physio">
                  <td class="staff-id"></td>
                  <td>Kavya Iyer</td>
                  <td>Physio</td>
                  <td>12:00 PM – 08:00 PM</td>
                  <td class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                  <td class="checkin-cell">—</td>
                  <td class="checkout-cell">—</td>
                  <td class="action-cell">
                    <div class="d-flex flex-wrap gap-2">
                      <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary btn-present-toggle" data-target="Present"><i class="fa-solid fa-user-check"></i> Present</button>
                        <button class="btn btn-outline-secondary btn-present-toggle active" data-target="Absent"><i class="fa-solid fa-user-xmark"></i> Absent</button>
                      </div>
                      <button class="btn btn-primary btn-sm btn-icon btn-checkin" disabled><i class="fa-regular fa-circle-play"></i> Check-In</button>
                      <button class="btn btn-outline-primary btn-sm btn-icon btn-checkout" disabled><i class="fa-regular fa-circle-stop"></i> Check-Out</button>
                    </div>
                  </td>
                </tr>

                <tr data-role="Support">
                  <td class="staff-id"></td>
                  <td>Vikas Rao</td>
                  <td>Support</td>
                  <td>02:00 PM – 10:00 PM</td>
                  <td class="status-cell"><span class="badge bg-danger badge-status">Absent</span></td>
                  <td class="checkin-cell">—</td>
                  <td class="checkout-cell">—</td>
                  <td class="action-cell">
                    <div class="d-flex flex-wrap gap-2">
                      <div class="btn-group btn-group-sm" role="group">
                        <button class="btn btn-outline-secondary btn-present-toggle" data-target="Present"><i class="fa-solid fa-user-check"></i> Present</button>
                        <button class="btn btn-outline-secondary btn-present-toggle active" data-target="Absent"><i class="fa-solid fa-user-xmark"></i> Absent</button>
                      </div>
                      <button class="btn btn-primary btn-sm btn-icon btn-checkin" disabled><i class="fa-regular fa-circle-play"></i> Check-In</button>
                      <button class="btn btn-outline-primary btn-sm btn-icon btn-checkout" disabled><i class="fa-regular fa-circle-stop"></i> Check-Out</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-muted small d-flex flex-wrap justify-content-between gap-2">
          <div>* Front-end demo only. Hook to backend later.</div>
          <div class="text-end"><span id="recordsMeta">Showing 4 of 4 staff</span></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sessions Modal -->
  <div class="modal fade" id="sessionsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title"><i class="fa-solid fa-layer-group me-2"></i>Sessions for <span id="sessName"></span></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="sessionsList" class="vstack gap-2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Backdrop for mobile sidebar (same as Dashboard) -->
  <div class="sidebar-backdrop" aria-hidden="true" style="display:none;"></div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Attendance interactions (front-end only)
    $(function () {
      const pad2 = n => (n < 10 ? ("0"+n) : (""+n));
      const timeNow12 = () => { const d=new Date(); let h=d.getHours(); const m=pad2(d.getMinutes()); const ampm=h>=12?"PM":"AM"; h=h%12||12; return `${pad2(h)}:${m} ${ampm}`; };

      const renumber = () => {
        $("#staffTable tbody tr:visible").each(function(i){ $(this).find(".staff-id").text(i+1); });
        const total = $("#staffTable tbody tr").length;
        const shown = $("#staffTable tbody tr:visible").length;
        $("#recordsMeta").text(`Showing ${shown} of ${total} staff`);
      };

      const setStatus = ($row, status, {confirmIfClearing=true}={}) => {
        const $b = $row.find(".status-cell .badge-status");
        const hasTimes = ($row.find('.checkin-cell').text().trim() !== '—') || ($row.find('.checkout-cell').text().trim() !== '—');

        async function doSet(to){
          if(to==="Present"){
            $b.removeClass("bg-danger").addClass("bg-success").text("Present");
            $row.addClass("is-present");
            const hasCI = $row.find(".checkin-cell").text().trim() !== "—";
            $row.find(".btn-checkin").prop("disabled", false);
            $row.find(".btn-checkout").prop("disabled", !hasCI);
            Swal.fire({ icon:'success', title:'Marked Present', timer:1200, showConfirmButton:false });
          } else {
            // If already has times, confirm that we clear them
            if(confirmIfClearing && hasTimes){
              const res = await Swal.fire({
                icon:'warning', title:'Mark Absent?', text:'This will clear today\'s check-in/out times.', showCancelButton:true, confirmButtonText:'Yes, clear & mark absent'
              });
              if(!res.isConfirmed){ return; }
              resetTimes($row);
            }
            $b.removeClass("bg-success").addClass("bg-danger").text("Absent");
            $row.removeClass("is-present");
            $row.find(".btn-checkin, .btn-checkout").prop("disabled", true);
            Swal.fire({ icon:'info', title:'Marked Absent', timer:1200, showConfirmButton:false });
          }
          $row.find(".btn-present-toggle").removeClass("active");
          $row.find(`.btn-present-toggle[data-target='${to}']`).addClass("active");
        }
        return doSet(status);
      };

      const resetTimes = ($row) => {
        // Clear single-day times and any per-session times on the row
        $row.find(".checkin-cell").text("—");
        $row.find(".checkout-cell").text("—");
        const sessions = $row.data('sessions');
        if (Array.isArray(sessions)){
          sessions.forEach(s=>{ s.checkin=null; s.checkout=null; });
          $row.data('sessions', sessions);
        }
        if ($row.hasClass("is-present")){
          $row.find(".btn-checkin").prop("disabled", false);
          $row.find(".btn-checkout").prop("disabled", true);
        }
      };

      function parseSessions($row){
        if ($row.data('sessions')) return $row.data('sessions');
        const raw = $row.attr('data-sessions');
        if (!raw) return null;
        try{
          const arr = JSON.parse(raw).map(s=>({ ...s, checkin:null, checkout:null }));
          $row.data('sessions', arr);
          return arr;
        }catch(e){ return null; }
      }

      function renderSessionsModal($row){
        const name = $row.find('td').eq(1).text().trim();
        $("#sessName").text(name);
        const list = $("#sessionsList").empty();
        const sessions = parseSessions($row) || [];
        if (!sessions.length){ list.html('<div class="text-muted">No sessions configured.</div>'); return; }
        sessions.forEach((s, idx)=>{
          const id = `sess_${idx}`;
          const ci = s.checkin ? s.checkin : '—';
          const co = s.checkout ? s.checkout : '—';
          const row = $(
            `<div class="border rounded p-2 d-flex align-items-center justify-content-between">
               <div>
                 <div class="fw-semibold">${s.label}</div>
                 <div class="small text-muted">${s.start} – ${s.end}</div>
               </div>
               <div class="d-flex align-items-center gap-2">
                 <span class="badge text-bg-light">In: <span data-ci>${ci}</span></span>
                 <span class="badge text-bg-light">Out: <span data-co>${co}</span></span>
                 <button class="btn btn-sm btn-primary" data-action="sess-checkin" data-idx="${idx}"><i class="fa-regular fa-circle-play me-1"></i>Check-In</button>
                 <button class="btn btn-sm btn-outline-primary" data-action="sess-checkout" data-idx="${idx}"><i class="fa-regular fa-circle-stop me-1"></i>Check-Out</button>
               </div>
             </div>`);
          list.append(row);
        });
        const modal = new bootstrap.Modal(document.getElementById('sessionsModal'));
        modal.show();
        // Store current row for modal actions
        $('#sessionsModal').data('currentRow', $row);
      }

      // initial states
      renumber();
      document.getElementById("datePicker").value = new Date().toISOString().substring(0,10);

      // search
      $("#tableSearch").on("keyup", function(){
        const val = $(this).val().toLowerCase();
        $("#staffTable tbody tr").each(function(){
          $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
        });
        applyFilters();
      });

      // filters
      function applyFilters(){
        const role = $("#roleFilter").val();
        const status = $("#statusFilter").val();
        $("#staffTable tbody tr").each(function(){
          const $r = $(this);
          const roleOk = !role || ($r.attr("data-role") === role);
          const stText = $r.find(".status-cell .badge-status").text().trim();
          const stOk = !status || (stText === status);
          const visibleBySearch = $r.is(":visible");
          $r.toggle(roleOk && stOk && visibleBySearch);
        });
        renumber();
      }
      $("#roleFilter, #statusFilter").on("change", function(){
        const val = $("#tableSearch").val().toLowerCase();
        $("#staffTable tbody tr").each(function(){
          $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
        });
        applyFilters();
      });

      // mobile data-labels
      function setupLabels(){
        if($(window).width() < 576){
          $("#staffTable thead th").each(function(i){
            const label = $(this).text();
            $("#staffTable tbody tr").each(function(){
              $(this).find("td").eq(i).attr("data-label", label);
            });
          });
        } else {
          $("#staffTable tbody td").removeAttr("data-label");
        }
      }
      setupLabels();
      $(window).on("resize", setupLabels);

      // row actions (status)
      $("#staffTable").on("click", ".btn-present-toggle", function(){
        const $row = $(this).closest("tr");
        setStatus($row, $(this).data("target"));
        renumber();
      });

      // Single check-in/out logic (prevent multiple check-ins without checkout, ensure order)
      $("#staffTable").on("click", ".btn-checkin", async function(){
        const $row = $(this).closest("tr");
        if (!$row.hasClass("is-present")){
          return Swal.fire({icon:'warning', title:'Mark Present first'});
        }
        const alreadyIn = $row.find(".checkin-cell").text().trim() !== "—" && $row.find(".checkout-cell").text().trim() === "—";
        if (alreadyIn){
          return Swal.fire({icon:'info', title:'Already Checked-In', text:'Please check-out before checking in again.'});
        }
        $row.find(".checkin-cell").text(timeNow12());
        $row.find(".btn-checkin").prop("disabled", true);
        $row.find(".btn-checkout").prop("disabled", false);
        Swal.fire({ icon:'success', title:'Checked In', timer:1000, showConfirmButton:false });
      });

      $("#staffTable").on("click", ".btn-checkout", async function(){
        const $row = $(this).closest("tr");
        if (!$row.hasClass("is-present")) return;
        const ci = $row.find(".checkin-cell").text().trim();
        if (ci === "—"){
          return Swal.fire({icon:'info', title:'No Check-In found', text:'Check-in before checking out.'});
        }
        $row.find(".checkout-cell").text(timeNow12());
        $row.find(".btn-checkout").prop("disabled", true);
        Swal.fire({ icon:'success', title:'Checked Out', timer:1000, showConfirmButton:false });
      });

      // Sessions button (for Coach rows only)
      $("#staffTable").on("click", ".btn-sessions", function(){
        const $row = $(this).closest('tr');
        if (!$row.hasClass('is-present')){
          return Swal.fire({icon:'warning', title:'Mark Present first for sessions'});
        }
        renderSessionsModal($row);
      });

      // Handle session modal actions
      $(document).on('click', '#sessionsList [data-action] ', function(){
        const action = $(this).data('action');
        const idx = Number($(this).data('idx'));
        const $modal = $('#sessionsModal');
        const $row = $modal.data('currentRow');
        const sessions = parseSessions($row) || [];
        const s = sessions[idx];
        if (!s) return;
        if (action === 'sess-checkin'){
          if (s.checkin && !s.checkout){
            return Swal.fire({icon:'info', title:'Already checked-in', text:`${s.label} has an open session.`});
          }
          s.checkin = timeNow12();
          s.checkout = null;
          Swal.fire({ icon:'success', title:`Checked-In • ${s.label}`, timer:900, showConfirmButton:false });
        } else if (action === 'sess-checkout'){
          if (!s.checkin){
            return Swal.fire({icon:'info', title:'No check-in found', text:`Check-in to ${s.label} first.`});
          }
          if (s.checkout){
            return Swal.fire({icon:'info', title:'Already checked-out', text:`${s.label} already closed.`});
          }
          s.checkout = timeNow12();
          Swal.fire({ icon:'success', title:`Checked-Out • ${s.label}`, timer:900, showConfirmButton:false });
        }
        // Persist back and re-render modal list quickly (just update spans)
        $row.data('sessions', sessions);
        // Update visible badges in modal
        const container = $(this).closest('.border');
        container.find('[data-ci]').text(s.checkin ? s.checkin : '—');
        container.find('[data-co]').text(s.checkout ? s.checkout : '—');
        // Also reflect last action into main In/Out cells for quick glance
        const lastCI = sessions.map(x=>x.checkin).filter(Boolean).slice(-1)[0] || '—';
        const lastCO = sessions.map(x=>x.checkout).filter(Boolean).slice(-1)[0] || '—';
        $row.find('.checkin-cell').text(lastCI);
        $row.find('.checkout-cell').text(lastCO);
      });

      // bulk
      $("#markAllPresent").on("click", async function(){
        const res = await Swal.fire({icon:'question', title:'Mark all Present?', showCancelButton:true});
        if(!res.isConfirmed) return;
        $("#staffTable tbody tr").each(function(){ setStatus($(this), "Present", {confirmIfClearing:false}); });
        renumber();
      });
      $("#markAllAbsent").on("click", async function(){
        const res = await Swal.fire({icon:'warning', title:'Mark all Absent?', text:'This will clear all check-in/out times for today.', showCancelButton:true, confirmButtonText:'Yes, mark all Absent'});
        if(!res.isConfirmed) return;
        $("#staffTable tbody tr").each(function(){ setStatus($(this), "Absent", {confirmIfClearing:false}); resetTimes($(this)); });
        renumber();
      });
      $("#resetTimes").on("click", async function(){
        const res = await Swal.fire({icon:'warning', title:'Reset all times?', showCancelButton:true});
        if(!res.isConfirmed) return;
        $("#staffTable tbody tr").each(function(){ resetTimes($(this)); });
        Swal.fire({ icon:'success', title:'Times reset', timer:900, showConfirmButton:false });
      });

      // If a row is toggled to Present while times exist and then to Absent, we already confirm in setStatus()
    });
  </script>

  <!-- Robust sidebar controller (same as Dashboard) -->
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
