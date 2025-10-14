<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add New Staff</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --brand-dark:#7b0000;
      --brand:#d00000;
    }

    body {
      background-color: #f8f9fc;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    #main-content {
      margin-left: 260px;
      padding: 20px;
      min-height: 100vh;
      transition: all 0.3s;
    }

    /* Tabs */
    .nav-tabs {
      margin-bottom: 0;
      border-bottom: 0;
    }
    .nav-tabs .nav-link {
      color: var(--brand-dark);
      font-weight: 500;
      border-radius: 6px 6px 0 0;
    }
    .nav-tabs .nav-link.active {
      background-color: var(--brand);
      color: #fff;
    }

    /* Overview: centered card with maximum width */
    .overview-wrap {
      max-width: 820px;
      margin: 24px auto;
      padding: 28px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      transition: transform .18s ease;
    }
    .overview-wrap:hover { transform: translateY(-3px); }
    .overview-title { color: var(--brand); font-weight:600; margin-bottom:10px; }
    .overview-row { display:flex; gap:12px; flex-wrap:wrap; }

    .overview-item {
      flex:1 1 200px;
      min-width:160px;
      background:#fbfbfb;
      border-radius:8px;
      padding:12px;
      border:1px solid rgba(0,0,0,0.04);
    }
    .overview-item h6 { margin:0; font-size:14px; color:var(--brand-dark); }
    .overview-item p { margin:6px 0 0 0; font-size:14px; color:#333; }

    /* Staff tab container */
    .staff-wrap {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
      margin: 20px auto 40px;
      padding: 18px;
      max-width: 1200px;
    }

    .filter-bar {
      display:flex;
      gap:12px;
      align-items:center;
      justify-content:space-between;
      flex-wrap:wrap;
      margin-bottom:12px;
    }
    .filter-options button {
      border:none;
      background:none;
      color:var(--brand-dark);
      font-weight:500;
      margin-right:12px;
    }
    .filter-options button.active,
    .filter-options button:hover { color:var(--brand); text-decoration:underline; }

    .btn-primary {
      background: linear-gradient(90deg, var(--brand-dark), var(--brand));
      border: none;
      font-weight: 500;
      padding: 8px 16px;
      border-radius: 6px;
    }

    .table-container { overflow-x:auto; }

    .action-icons button {
      border:none;
      background:none;
      padding:6px;
      margin:0 2px;
    }
    .view-icon { color:#0d6efd; }
    .edit-icon { color:#ffc107; }
    .delete-icon { color:#dc3545; }

    /* modal tweaks */
    .modal-header.bg-danger { background: linear-gradient(90deg,var(--brand-dark),var(--brand)); color:#fff; }
    .profile-card {
      padding:18px;
      text-align:center;
      border-radius:10px;
      background:linear-gradient(145deg,#fff,#f6f6f6);
      box-shadow:0 6px 16px rgba(0,0,0,0.04);
    }

    /* switches */
    .switch { position:relative; display:inline-block; width:46px; height:24px; }
    .switch input{ display:none; }
    .slider{ position:absolute; left:0; top:0; right:0; bottom:0; background:#dcdcdc; border-radius:24px; transition:.25s; }
    .slider:before{ content:""; position:absolute; left:3px; top:3px; width:18px; height:18px; background:#fff; border-radius:50%; transition:.25s; }
    .switch input:checked + .slider{ background:#28a745; }
    .switch input:checked + .slider:before{ transform:translateX(22px); }

    /* Responsive */
    @media (max-width: 992px) {
      #main-content { margin-left:0; padding:16px; }
      .overview-wrap, .staff-wrap { margin-left:0; margin-right:0; }
      .overview-item { flex-basis: 45%; }
    }
    @media (max-width: 576px) {
      .overview-item { flex-basis: 100%; }
      .filter-bar { gap:10px; align-items:flex-start; }
    }
  </style>
</head>
<body>
  
  <?php  $this->load->view('superadmin/Include/Sidebar');  ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <ul class="nav nav-tabs" id="staffTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overviewTab" type="button" role="tab">Overview</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="staff-tab" data-bs-toggle="tab" data-bs-target="#staffTab" type="button" role="tab">Staff</button>
      </li>
    </ul>

    <div class="tab-content">
      <!-- Overview tab -->
      <div class="tab-pane fade show active" id="overviewTab" role="tabpanel" aria-labelledby="overview-tab">
        <div class="overview-wrap" id="overviewWrap">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="overview-title mb-0">Staff Overview</h5>
            <small class="text-muted" id="overviewLastUpdated"></small>
          </div>

          <div id="overviewContent">
            <p class="text-center text-muted mb-0">No staff details available. Click "Send Details" from Salary Management (or add a staff record).</p>
          </div>
        </div>
      </div>

      <!-- Staff tab -->
      <div class="tab-pane fade" id="staffTab" role="tabpanel" aria-labelledby="staff-tab">
        <div class="staff-wrap">
          <div class="filter-bar">
            <div class="filter-options">
              <button class="active" data-filter="all">All</button>
              <button data-filter="active">Active</button>
              <button data-filter="deactive">Deactive</button>
            </div>

            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="me-2 staff-count">Total Staff: <span id="staffCount">1</span></div>
              <input type="text" id="searchInput" class="form-control form-control-sm me-2" style="width:220px" placeholder="Search staff...">
              <button class="btn btn-primary btn-sm" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
            </div>
          </div>

          <div class="table-container">
            <table class="table table-bordered table-striped align-middle" id="staffTable">
              <thead class="table-light">
                <tr>
                  <th style="width:60px">Sr No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Joining Date</th>
                  <th>Role</th>
                  <th>Centers</th>
                  <th>Slots</th>
                  <th style="width:110px">Salary</th>
                  <th style="width:120px">Actions</th>
                  <th style="width:90px">Status</th>
                </tr>
              </thead>
              <tbody>
                <!-- initial single row -->
                <tr data-status="active">
                  <td>1</td>
                  <td>John Doe</td>
                  <td>john@example.com</td>
                  <td>9876543210</td>
                  <td>2023-01-10</td>
                  <td>Coach</td>
                  <td>Center A</td>
                  <td>6-8 AM</td>
                  <td>25000</td>
                  <td class="action-icons">
                    <button class="btn btn-sm viewBtn" title="View"><i class="bi bi-eye-fill view-icon"></i></button>
                    <button class="btn btn-sm editBtn" title="Edit"><i class="bi bi-pencil-square edit-icon"></i></button>
                    <button class="btn btn-sm deleteBtn" title="Delete"><i class="bi bi-trash delete-icon"></i></button>
                  </td>
                  <td>
                    <label class="switch">
                      <input type="checkbox" class="statusToggle" checked>
                      <span class="slider"></span>
                    </label>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div> <!-- /staffTab -->
    </div> <!-- /tab-content -->
  </div> <!-- /main-content -->

  <!-- Staff Modal -->
  <div class="modal fade" id="staffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="staffModalLabel">Add Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="staffForm" autocomplete="off">
            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" placeholder="Enter Staff Name" required>
              </div>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" placeholder="Staff Email" required>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" name="contact" placeholder="Staff Contact" required>
              </div>
              <div class="col-md-6">
                <input type="date" class="form-control" name="joining_date" required>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="number" class="form-control" name="salary" placeholder="Enter Salary" required>
              </div>
              <div class="col-md-6">
                <select class="form-select" name="role" id="roleSelect" required>
                  <option value="">Select Role</option>
                  <option value="Coach">Coach</option>
                  <option value="Admin">Admin</option>
                  <option value="Coordinator">Coordinator</option>
                  <option value="Manager">Manager</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="fw-bold mb-2">Select Centers:</label>
              <div class="d-flex flex-wrap gap-3">
                <div><input type="checkbox" class="center-check" value="Center A"> Center A</div>
                <div><input type="checkbox" class="center-check" value="Center B"> Center B</div>
                <div><input type="checkbox" class="center-check" value="Center C"> Center C</div>
                <div><input type="checkbox" class="center-check" value="Center D"> Center D</div>
              </div>
            </div>

            <div class="mb-3" id="slotSection" style="display:none;">
              <label class="fw-bold mb-2">Select Slots:</label>
              <div class="d-flex flex-wrap gap-3">
                <div><input type="checkbox" class="slot-check" value="6-8 AM"> 6-8 AM</div>
                <div><input type="checkbox" class="slot-check" value="8-10 AM"> 8-10 AM</div>
                <div><input type="checkbox" class="slot-check" value="5-7 PM"> 5-7 PM</div>
                <div><input type="checkbox" class="slot-check" value="7-9 PM"> 7-9 PM</div>
              </div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Save Staff</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- View Profile Modal -->
  <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="profile-card">
          <h5 id="profileName" class="text-danger fw-bold mb-2">Staff Name</h5>
          <div class="profile-info text-start">
            <p><strong>Email:</strong> <span id="profileEmail"></span></p>
            <p><strong>Contact:</strong> <span id="profileContact"></span></p>
            <p><strong>Joining Date:</strong> <span id="profileDate"></span></p>
            <p><strong>Role:</strong> <span id="profileRole"></span></p>
            <p><strong>Centers:</strong> <span id="profileCenters"></span></p>
            <p><strong>Slots:</strong> <span id="profileSlots"></span></p>
          </div>
          <div class="salary-box" id="profileSalary"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    (function($){
      // single source of truth for edit row
      let editRow = null;

      // Ensure no duplicate handlers — attach only once
      function init() {
        updateCount();
        bindUI();
        loadOverviewFromStorage();
      }

      function updateCount(){
        const count = $("#staffTable tbody tr").length;
        $("#staffCount").text(count);
      }

      function bindUI(){
        // Open Add modal
        $("#addStaffBtn").off('click').on("click", function(){
          editRow = null;
          $("#staffForm")[0].reset();
          $("#slotSection").hide();
          $("#staffModalLabel").text("Add Staff");
          // uncheck all checkboxes explicitly
          $(".center-check, .slot-check").prop('checked', false);
          const staffModal = new bootstrap.Modal(document.getElementById('staffModal'));
          staffModal.show();
        });

        // Role -> toggle slots
        $("#roleSelect").off('change').on("change", function(){
          $(this).val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
        });

        // Submit form: add or update
        $("#staffForm").off('submit').on("submit", function(e){
          e.preventDefault();
          const form = $(this);
          const name = form.find("input[name='name']").val().trim();
          const email = form.find("input[name='email']").val().trim();
          const contact = form.find("input[name='contact']").val().trim();
          const date = form.find("input[name='joining_date']").val();
          const role = form.find("#roleSelect").val();
          const salary = form.find("input[name='salary']").val().trim();
          const centers = $(".center-check:checked").map(function(){ return $(this).val(); }).get();
          const slots = $(".slot-check:checked").map(function(){ return $(this).val(); }).get();

          // Basic validation (already required, but double-check)
          if (!name || !email || !contact) {
            Swal.fire("Missing info", "Please fill required fields.", "warning");
            return;
          }

          const tbody = $("#staffTable tbody");

          if (editRow) {
            // update existing row (editRow is a jQuery tr)
            editRow.find("td:eq(1)").text(name);
            editRow.find("td:eq(2)").text(email);
            editRow.find("td:eq(3)").text(contact);
            editRow.find("td:eq(4)").text(date);
            editRow.find("td:eq(5)").text(role);
            editRow.find("td:eq(6)").text(centers.length ? centers.join(", ") : '-');
            editRow.find("td:eq(7)").text(role === "Coach" && slots.length ? slots.join(", ") : '-');
            editRow.find("td:eq(8)").text(salary || '-');

            Swal.fire("Updated!", "Staff details updated successfully.", "success");
          } else {
            // add new row (ensure single append)
            const srNo = tbody.children("tr").length + 1;
            const newRow = $(`
              <tr data-status="active">
                <td>${srNo}</td>
                <td>${escapeHtml(name)}</td>
                <td>${escapeHtml(email)}</td>
                <td>${escapeHtml(contact)}</td>
                <td>${escapeHtml(date)}</td>
                <td>${escapeHtml(role)}</td>
                <td>${escapeHtml(centers.length ? centers.join(", ") : '-')}</td>
                <td>${escapeHtml(role === "Coach" && slots.length ? slots.join(", ") : '-')}</td>
                <td>${escapeHtml(salary || '-')}</td>
                <td class="action-icons">
                  <button class="btn btn-sm viewBtn" title="View"><i class="bi bi-eye-fill view-icon"></i></button>
                  <button class="btn btn-sm editBtn" title="Edit"><i class="bi bi-pencil-square edit-icon"></i></button>
                  <button class="btn btn-sm deleteBtn" title="Delete"><i class="bi bi-trash delete-icon"></i></button>
                </td>
                <td>
                  <label class="switch">
                    <input type="checkbox" class="statusToggle" checked>
                    <span class="slider"></span>
                  </label>
                </td>
              </tr>
            `);
            tbody.append(newRow);
            Swal.fire("Added!", "New staff added successfully.", "success");
            updateCount();
          }

          // close modal (Bootstrap API)
          const modalEl = document.getElementById('staffModal');
          const bsModal = bootstrap.Modal.getInstance(modalEl);
          if (bsModal) bsModal.hide();

          // reset form & editRow
          $("#staffForm")[0].reset();
          $("#slotSection").hide();
          editRow = null;
        });

        // Delegated: edit button
        $(document).off('click', '.editBtn').on('click', '.editBtn', function(){
          const row = $(this).closest('tr');
          editRow = row;

          // Populate modal fields
          $("#staffForm")[0].reset();
          $("#staffForm input[name='name']").val(row.find("td:eq(1)").text());
          $("#staffForm input[name='email']").val(row.find("td:eq(2)").text());
          $("#staffForm input[name='contact']").val(row.find("td:eq(3)").text());
          $("#staffForm input[name='joining_date']").val(row.find("td:eq(4)").text());
          $("#roleSelect").val(row.find("td:eq(5)").text());
          $("#staffForm input[name='salary']").val(row.find("td:eq(8)").text());

          // centers -> check checkboxes matching values
          const centersText = row.find("td:eq(6)").text();
          $(".center-check").prop('checked', false);
          if (centersText && centersText !== '-') {
            centersText.split(',').map(s => s.trim()).forEach(val => {
              $(`.center-check[value="${val}"]`).prop('checked', true);
            });
          }

          // slots
          const slotsText = row.find("td:eq(7)").text();
          $(".slot-check").prop('checked', false);
          if (slotsText && slotsText !== '-') {
            slotsText.split(',').map(s => s.trim()).forEach(val => {
              $(`.slot-check[value="${val}"]`).prop('checked', true);
            });
          }

          // show/hide slot section depending on role
          $("#roleSelect").val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();

          $("#staffModalLabel").text("Edit Staff");
          const staffModal = new bootstrap.Modal(document.getElementById('staffModal'));
          staffModal.show();
        });

        // Delegated: view button
        $(document).off('click', '.viewBtn').on('click', '.viewBtn', function(){
          const row = $(this).closest('tr');
          $("#profileName").text(row.find("td:eq(1)").text());
          $("#profileEmail").text(row.find("td:eq(2)").text());
          $("#profileContact").text(row.find("td:eq(3)").text());
          $("#profileDate").text(row.find("td:eq(4)").text());
          $("#profileRole").text(row.find("td:eq(5)").text());
          $("#profileCenters").text(row.find("td:eq(6)").text());
          $("#profileSlots").text(row.find("td:eq(7)").text());

          const salary = row.find("td:eq(8)").text().trim();
          if (!salary || salary === '-' || salary === '0') {
            $("#profileSalary").text("No salary assigned").addClass("no-salary");
          } else {
            $("#profileSalary").text("Income: ₹" + salary).removeClass("no-salary");
          }

          const viewModal = new bootstrap.Modal(document.getElementById('viewProfileModal'));
          viewModal.show();
        });

        // Delegated: delete
        $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', function(){
          const row = $(this).closest('tr');
          Swal.fire({
            title: "Are you sure?",
            text: "This staff record will be deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d00000",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Delete"
          }).then(result => {
            if (result.isConfirmed) {
              row.remove();
              // re-number sr no
              $("#staffTable tbody tr").each(function(i){
                $(this).find("td:eq(0)").text(i+1);
              });
              updateCount();
              Swal.fire("Deleted!", "Staff record deleted successfully.", "success");
            }
          });
        });

        // Delegated: status toggle
        $(document).off('change', '.statusToggle').on('change', '.statusToggle', function(){
          const row = $(this).closest('tr');
          if ($(this).is(':checked')) {
            row.attr('data-status','active');
            Swal.fire("Activated", "Status changed to Active", "success");
          } else {
            row.attr('data-status','deactive');
            Swal.fire("Deactivated", "Status changed to Inactive", "info");
          }
        });

        // Filter buttons
        $(".filter-options button").off('click').on('click', function(){
          $(".filter-options button").removeClass('active');
          $(this).addClass('active');
          const filter = $(this).data('filter');
          $("#staffTable tbody tr").each(function(){
            const status = $(this).attr('data-status') || 'active';
            if (filter === 'all' || status === filter) $(this).show(); else $(this).hide();
          });
        });

        // Search box
        $("#searchInput").off('keyup').on('keyup', function(){
          const value = $(this).val().toLowerCase();
          $("#staffTable tbody tr").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
          });
        });
      } // bindUI

      // load overview card content from localStorage (if any)
      function loadOverviewFromStorage(){
        const data = localStorage.getItem('staffSalaryData');
        if (!data) return;
        try {
          const staff = JSON.parse(data);
          const html = buildOverviewHtml(staff);
          $("#overviewContent").html(html);
          $("#overviewLastUpdated").text("Updated: " + new Date().toLocaleString());
        } catch(e){
          console.warn("Invalid staff data in storage");
        }
      }

      // helper to build overview html (responsive)
      function buildOverviewHtml(staff){
        // sanitize display
        const name = escapeHtml(staff.name || '-');
        const hours = escapeHtml(staff.hours || '-');
        const days = escapeHtml(staff.days || '-');
        const sessions = escapeHtml(staff.sessions || '-');
        const rate = escapeHtml(staff.rate || '-');
        const salary = escapeHtml(staff.salary || '-');
        const status = escapeHtml(staff.status || '-');

        return `
          <div class="overview-row">
            <div style="flex-basis:100%">
              <h6 class="mb-1">${name}</h6>
              <p class="text-muted mb-3">Latest salary snapshot from Salary Management</p>
            </div>

            <div class="overview-item">
              <h6>Hours</h6>
              <p>${hours}</p>
            </div>
            <div class="overview-item">
              <h6>Days</h6>
              <p>${days}</p>
            </div>
            <div class="overview-item">
              <h6>Sessions</h6>
              <p>${sessions}</p>
            </div>
            <div class="overview-item">
              <h6>Rate</h6>
              <p>${rate}</p>
            </div>
            <div class="overview-item">
              <h6>Salary</h6>
              <p>${salary}</p>
            </div>
            <div class="overview-item">
              <h6>Status</h6>
              <p>${status}</p>
            </div>
          </div>
        `;
      }

      // simple escape to avoid injection when building rows
      function escapeHtml(unsafe) {
        if (unsafe === null || unsafe === undefined) return '';
        return String(unsafe)
          .replaceAll('&', '&amp;')
          .replaceAll('<', '&lt;')
          .replaceAll('>', '&gt;')
          .replaceAll('"', '&quot;')
          .replaceAll("'", '&#039;');
      }

      // initialize once DOM is ready
      $(function(){ init(); });
    })(jQuery);
  </script>
</body>
</html>
