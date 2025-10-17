<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add New Staff</title>
      <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --accent:#ff4040; 
      --accent-dark:#470000; 
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --sidebar-width:250px;
    }

    body{ 
      background:var(--muted); 
      color:#111; 
      overflow-x:hidden; 
      font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;
    }

    #main-content{
      margin-left: var(--sidebar-width);
      width: calc(100vw - var(--sidebar-width));
      padding: 20px;
      min-height: 100vh;
      transition: .25s;
      overflow-x: hidden;
    }
    #main-content.minimized{
      margin-left: 60px;
      width: calc(100vw - 60px);
    }

    @media (max-width: 991.98px){
      #main-content{
        margin-left: 0 !important;
        width: 100vw;
        padding: 12px;
      }
    }

    .page-hero{
      border-radius:16px; border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    .toolbar{
      position:sticky; top:12px; z-index:5;
      background:#fff; border:1px solid #e9ecef; border-radius:12px; padding:10px;
      box-shadow:0 8px 24px rgba(0,0,0,.05);
    }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    .global-search { max-width: 600px; margin: 0 auto; transition: all .25s ease; }
    .global-search .form-control { height: 42px; border-radius: 50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .form-control:focus { border-color: var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }
    .global-search .input-group-text { border-radius: 50px 0 0 50px; background:#fff; border-color:#e3e3e3; }

    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }
    .clickable-row { cursor:pointer; transition: background-color .2s ease; }
    .clickable-row:hover { background-color: rgba(255,64,64,.05); }

    .switch { position:relative; display:inline-block; width:46px; height:24px; }
    .switch input{ display:none; }
    .slider{ position:absolute; left:0; top:0; right:0; bottom:0; background:#dcdcdc; border-radius:24px; transition:.25s; }
    .slider:before{ content:""; position:absolute; left:3px; top:3px; width:18px; height:18px; background:#fff; border-radius:50%; transition:.25s; }
    .switch input:checked + .slider{ background:#28a745; }
    .switch input:checked + .slider:before{ transform:translateX(22px); }

    .modal-header.bg-danger { background: var(--grad) !important; color:#fff; }
  </style>
</head>
<body>
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">Add & Manage Staff</div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-primary" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
        </div>
      </div>
    </div>

    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search staff...">
          </div>
        </div>
        <div class="d-flex align-items-center gap-2">
          <span class="badge rounded-pill bg-light text-dark px-3 py-2">Total <b id="staffCount">0</b></span>
        </div>
      </div>
    </div>

    <div class="card-lite p-3 mt-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
        <div class="filter-options">
          <button class="btn btn-ghost btn-sm active" data-filter="all">All</button>
          <button class="btn btn-ghost btn-sm" data-filter="active">Active</button>
          <button class="btn btn-ghost btn-sm" data-filter="deactive">Deactive</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle" id="staffTable">
          <thead>
            <tr>
              <th style="width:60px">Sr No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Joining Date</th>
              <th>Role</th>
              <th>Centers</th>
              <th>Slots</th>
              <th class="text-end" style="width:110px">Salary (₹)</th>
              <th class="text-center" style="width:120px">Actions</th>
              <th class="text-center" style="width:90px">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="11" class="text-center text-muted py-4">Loading staff data...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

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
              <div class="col-md-6"><input type="text" class="form-control" name="name" placeholder="Enter Staff Name" required></div>
              <div class="col-md-6"><input type="email" class="form-control" name="email" placeholder="Staff Email" required></div>
            </div>
            <div class="row g-2 mb-3">
              <div class="col-md-6"><input type="text" class="form-control" name="contact" placeholder="Staff Contact" required></div>
              <div class="col-md-6"><input type="date" class="form-control" name="joining_date" required></div>
            </div>
            <div class="row g-2 mb-3">
              <div class="col-md-6"><input type="number" class="form-control" name="salary" placeholder="Enter Salary" required></div>
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
            <div class="text-end"><button type="submit" class="btn btn-primary">Save Staff</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- View Profile Modal -->
  <div class="modal fade" id="viewProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="text-center p-3" style="border-radius:10px;background:linear-gradient(145deg,#fff,#f6f6f6);box-shadow:0 6px 16px rgba(0,0,0,.04)">
          <h5 id="profileName" class="text-danger fw-bold mb-2">Staff Name</h5>
          <div class="text-start">
            <p><strong>Email:</strong> <span id="profileEmail"></span></p>
            <p><strong>Contact:</strong> <span id="profileContact"></span></p>
            <p><strong>Joining Date:</strong> <span id="profileDate"></span></p>
            <p><strong>Role:</strong> <span id="profileRole"></span></p>
            <p><strong>Centers:</strong> <span id="profileCenters"></span></p>
            <p><strong>Slots:</strong> <span id="profileSlots"></span></p>
            <p><strong>Salary:</strong> <span id="profileSalary"></span></p>
          </div>
          <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  (function($) {
    let editRow = null;
    let staffData = [];

    // Helper function to escape HTML
    function escapeHtml(unsafe) {
      if (unsafe === null || unsafe === undefined) return '';
      return String(unsafe)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    // Load staff data from localStorage
    function loadStaffData() {
      console.log('Loading staff data from localStorage...');
      const records = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      staffData = records.map(record => ({
        ...record,
        contact: record.contact || '',
        joiningDate: record.joiningDate || '',
        centers: record.centers ? record.centers.split(', ') : [],
        slots: record.slots ? record.slots.split(', ') : [],
        active: record.active !== false // Default to active if not specified
      }));
      
      console.log('Loaded staff data:', staffData);
      renderStaffTable();
      updateCount();
    }

    // Render staff table
    function renderStaffTable() {
      const tbody = $("#staffTable tbody");
      if (staffData.length === 0) {
        tbody.html(`
          <tr>
            <td colspan="11" class="text-center text-muted py-4">
              No staff found. 
              </button>
            </td>
          </tr>
        `);
        return;
      }

      tbody.empty();
      staffData.forEach((staff, index) => {
        const srNo = index + 1;
        const isActive = staff.active !== false; // Active by default
        const rowHtml = `
          <tr class="clickable-row" data-status="${isActive ? 'active' : 'deactive'}" 
              data-staff-id="${staff.staffId}" data-email="${staff.email}">
            <td>${srNo}</td>
            <td>${escapeHtml(staff.name)}</td>
            <td>${escapeHtml(staff.email)}</td>
            <td>${escapeHtml(staff.contact)}</td>
            <td>${escapeHtml(staff.joiningDate)}</td>
            <td>${escapeHtml(staff.role)}</td>
            <td>${escapeHtml(staff.centers.join(', ') || '-')}</td>
            <td>${escapeHtml(staff.role === 'Coach' && staff.slots.length ? staff.slots.join(', ') : '-')}</td>
            <td class="text-end">${staff.salary || '₹0'}</td>
            <td class="text-center">
              <div class="btn-group">
                <button class="btn btn-ghost btn-sm viewBtn" title="View"><i class="bi bi-eye"></i></button>
                <button class="btn btn-ghost btn-sm editBtn" title="Edit"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-ghost btn-sm deleteBtn" title="Delete"><i class="bi bi-trash text-danger"></i></button>
              </div>
            </td>
            <td class="text-center">
              <label class="switch">
                <input type="checkbox" class="statusToggle" ${isActive ? 'checked' : ''}>
                <span class="slider"></span>
              </label>
            </td>
          </tr>`;
        tbody.append(rowHtml);
      });
    }

    // Create salary record
    function createSalaryRecord(staffData) {
      const salaryRecord = {
        staffId: staffData.staffId,
        name: staffData.name,
        email: staffData.email,
        role: staffData.role,
        contact: staffData.contact,
        joiningDate: staffData.joiningDate,
        centers: staffData.centers.join(', '),
        slots: staffData.slots.join(', '),
        hours: '0',
        days: '0',
        sessions: '0',
        rate: staffData.salary ? `₹${parseInt(staffData.salary).toLocaleString()}` : '₹0',
        salary: staffData.salary ? `₹${parseInt(staffData.salary).toLocaleString()}` : '₹0',
        status: 'Pending',
        active: true, // Always active by default
        createdAt: new Date().toISOString()
      };

      let records = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      records.push(salaryRecord);
      localStorage.setItem('salaryRecords', JSON.stringify(records));
      
      // Trigger storage event
      window.localStorage.setItem('salaryRecords', JSON.stringify(records));
      console.log('Created salary record:', salaryRecord);
    }

    // Update salary record
    function updateSalaryRecord(oldEmail, newData) {
      let records = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      records = records.map(record => {
        if (record.email === oldEmail) {
          return {
            ...record,
            ...newData,
            name: newData.name,
            email: newData.email,
            role: newData.role,
            contact: newData.contact,
            joiningDate: newData.joiningDate,
            centers: newData.centers.join(', '),
            slots: newData.slots.join(', '),
            rate: newData.salary ? `₹${parseInt(newData.salary).toLocaleString()}` : '₹0',
            salary: newData.salary ? `₹${parseInt(newData.salary).toLocaleString()}` : '₹0',
            active: newData.active !== false, // Preserve active status
            updatedAt: new Date().toISOString()
          };
        }
        return record;
      });
      localStorage.setItem('salaryRecords', JSON.stringify(records));
      window.localStorage.setItem('salaryRecords', JSON.stringify(records));
    }

    // Delete salary record
    function deleteSalaryRecord(staffId, email) {
      let records = JSON.parse(localStorage.getItem('salaryRecords') || '[]');
      records = records.filter(record => record.staffId !== staffId && record.email !== email);
      localStorage.setItem('salaryRecords', JSON.stringify(records));
      window.localStorage.setItem('salaryRecords', JSON.stringify(records));
    }

    function updateCount() {
      $("#staffCount").text(staffData.length);
    }

    function init() {
      console.log('Initializing Staff Management...');
      loadStaffData();
      
      // Listen for storage changes from other tabs
      window.addEventListener('storage', function(e) {
        if (e.key === 'salaryRecords') {
          console.log('Storage changed, reloading staff data');
          loadStaffData();
        }
      });

      bindUI();
    }

    function bindUI() {
      // Add staff button
      $(document).off('click', '#addStaffBtn, #addStaffBtn3').on('click', '#addStaffBtn, #addStaffBtn3', function() {
        editRow = null;
        $("#staffForm")[0].reset();
        $("#slotSection").hide();
        $(".center-check, .slot-check").prop('checked', false);
        $("#staffModalLabel").text("Add Staff");
        new bootstrap.Modal(document.getElementById('staffModal')).show();
      });

      // Role change handler
      $("#roleSelect").off('change').on('change', function() {
        $(this).val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
      });

      // Form submission
      $("#staffForm").off('submit').on('submit', function(e) {
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
        
        if (!name || !email || !contact || !salary) {
          Swal.fire("Missing info", "Please fill all required fields.", "warning");
          return;
        }

        const staffId = Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        const staffDataToSave = {
          staffId,
          name,
          email,
          contact,
          joiningDate: date,
          role,
          salary,
          centers,
          slots,
          active: true // Always active when creating new staff
        };

        if (editRow) {
          // Update existing staff
          const oldEmail = editRow.data('email');
          updateSalaryRecord(oldEmail, staffDataToSave);
          loadStaffData(); // Reload to reflect changes
          Swal.fire("Updated!", "Staff details updated successfully.", "success");
        } else {
          // Add new staff
          createSalaryRecord(staffDataToSave);
          loadStaffData(); // Reload to show new staff
          Swal.fire("Added!", "New staff added successfully ", "success");
          
          // Dispatch custom event
          window.dispatchEvent(new CustomEvent('staffAdded', { 
            detail: { staffId, name, email, salary, role } 
          }));
        }

        // Close modal
        const modalEl = document.getElementById('staffModal');
        const bsModal = bootstrap.Modal.getInstance(modalEl);
        if (bsModal) bsModal.hide();
        $("#staffForm")[0].reset();
        $("#slotSection").hide();
        editRow = null;
      });

      // Edit button
      $(document).off('click', '.editBtn').on('click', '.editBtn', function() {
        editRow = $(this).closest('tr');
        const staff = staffData.find(s => s.staffId === editRow.data('staff-id'));
        if (!staff) return;

        $("#staffForm")[0].reset();
        $("#staffForm input[name='name']").val(staff.name);
        $("#staffForm input[name='email']").val(staff.email);
        $("#staffForm input[name='contact']").val(staff.contact);
        $("#staffForm input[name='joining_date']").val(staff.joiningDate);
        $("#roleSelect").val(staff.role);
        $("#staffForm input[name='salary']").val(staff.salary?.replace(/[₹,]/g, '') || '');
        
        // Restore checkboxes
        $(".center-check").prop('checked', false);
        staff.centers.forEach(center => $(`.center-check[value="${center}"]`).prop('checked', true));
        $(".slot-check").prop('checked', false);
        staff.slots.forEach(slot => $(`.slot-check[value="${slot}"]`).prop('checked', true));
        
        $("#roleSelect").val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
        $("#staffModalLabel").text("Edit Staff");
        new bootstrap.Modal(document.getElementById('staffModal')).show();
      });

      // View button
      $(document).off('click', '.viewBtn').on('click', '.viewBtn', function() {
        const row = $(this).closest('tr');
        const staff = staffData.find(s => s.staffId === row.data('staff-id'));
        if (!staff) return;

        $("#profileName").text(staff.name);
        $("#profileEmail").text(staff.email);
        $("#profileContact").text(staff.contact);
        $("#profileDate").text(staff.joiningDate);
        $("#profileRole").text(staff.role);
        $("#profileCenters").text(staff.centers.join(', ') || '-');
        $("#profileSlots").text(staff.slots.join(', ') || '-');
        $("#profileSalary").text(staff.salary || '₹0');
        new bootstrap.Modal(document.getElementById('viewProfileModal')).show();
      });

      // Delete button
      $(document).off('click', '.deleteBtn').on('click', '.deleteBtn', function() {
        const row = $(this).closest('tr');
        const staffId = row.data('staff-id');
        const email = row.data('email');
        const name = row.find("td:eq(1)").text();

        Swal.fire({
          title: "Are you sure?",
          text: `This will delete ${name} and their salary record.`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d00000",
          confirmButtonText: "Delete"
        }).then(result => {
          if (result.isConfirmed) {
            deleteSalaryRecord(staffId, email);
            loadStaffData();
            Swal.fire("Deleted!", "Staff and salary records deleted.", "success");
            
            window.dispatchEvent(new CustomEvent('staffDeleted', { 
              detail: { staffId, email } 
            }));
          }
        });
      });

      // Status toggle
      $(document).off('change', '.statusToggle').on('change', '.statusToggle', function() {
        const row = $(this).closest('tr');
        const staffId = row.data('staff-id');
        const isActive = $(this).is(':checked');
        const staff = staffData.find(s => s.staffId === staffId);
        
        if (staff) {
          staff.active = isActive;
          updateSalaryRecord(staff.email, { ...staff, active: isActive });
          row.attr('data-status', isActive ? 'active' : 'deactive');
          loadStaffData(); // Reload to update status display
          Swal.fire(isActive ? "Activated" : "Deactivated", 
                   `Status changed to ${isActive ? 'Active' : 'Inactive'}`, 
                   isActive ? "success" : "info");
        }
      });

      // Filters
      $(document).off('click', '.filter-options .btn').on('click', '.filter-options .btn', function() {
        $(".filter-options .btn").removeClass('active');
        $(this).addClass('active');
        const filter = $(this).data('filter');
        $("#staffTable tbody tr").each(function() {
          const status = $(this).attr('data-status') || 'active';
          if (filter === 'all' || status === filter) $(this).show(); else $(this).hide();
        });
      });

      // Search
      $("#searchInput").off('input').on('input', function() {
        const value = $(this).val().toLowerCase();
        $("#staffTable tbody tr").each(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });
    }

    // Initialize when DOM is ready
    $(function() {
      init();
    });

  })(jQuery);
  </script>

  <!-- Sidebar toggle script -->
  <script>
  (function () {
    const SIDEBAR_SELECTORS = '.sidebar, #sidebar, .main-sidebar';
    const TOGGLE_SELECTORS = '#sidebarToggle, .sidebar-toggle, [data-sidebar-toggle]';
    const WRAPPER_IDS = ['main-content'];
    const DESKTOP_WIDTH_CUTOFF = 991.98;
    const SIDEBAR_OPEN_CLASS = 'active';
    const SIDEBAR_MIN_CLASS = 'minimized';
    const BODY_OVERLAY_CLASS = 'sidebar-open';
    const CSS_VAR = '--sidebar-width';
    const SIDEBAR_WIDTH_OPEN = '250px';
    const SIDEBAR_WIDTH_MIN = '60px';

    const qs = s => document.querySelector(s);
    const qsa = s => Array.from(document.querySelectorAll(s));
    const sidebarEl = () => qs('#sidebar') || qs('.sidebar') || qs('.main-sidebar');
    const wrapperEl = () => WRAPPER_IDS.map(id => document.getElementById(id)).find(Boolean);
    const isMobile = () => window.innerWidth <= DESKTOP_WIDTH_CUTOFF;

    let backdrop = qs('.sidebar-backdrop');
    if (!backdrop) {
      backdrop = document.createElement('div');
      backdrop.className = 'sidebar-backdrop';
      Object.assign(backdrop.style, {
        position: 'fixed',
        inset: '0',
        background: 'rgba(0,0,0,0.42)',
        zIndex: '1070',
        display: 'none',
        opacity: '0',
        transition: 'opacity .18s ease'
      });
      document.body.appendChild(backdrop);
    }

    let lock = false;
    const lockFor = (ms = 320) => {
      lock = true;
      clearTimeout(lock._t);
      lock._t = setTimeout(() => lock = false, ms);
    };
    let lastInteractionAt = 0;
    const INTERACTION_GAP = 700;

    function openMobileSidebar() {
      const s = sidebarEl();
      if (!s) return;
      s.classList.add(SIDEBAR_OPEN_CLASS);
      document.body.classList.add(BODY_OVERLAY_CLASS);
      document.body.style.overflow = 'hidden';
      backdrop.style.display = 'block';
      requestAnimationFrame(() => backdrop.style.opacity = '1');
    }

    function closeMobileSidebar() {
      const s = sidebarEl();
      if (s) s.classList.remove(SIDEBAR_OPEN_CLASS);
      document.body.classList.remove(BODY_OVERLAY_CLASS);
      document.body.style.overflow = '';
      backdrop.style.opacity = '0';
      setTimeout(() => {
        if (!document.body.classList.contains(BODY_OVERLAY_CLASS)) 
          backdrop.style.display = 'none';
      }, 220);
    }

    function toggleDesktopSidebar() {
      const s = sidebarEl();
      if (!s) return;
      const isMin = s.classList.toggle(SIDEBAR_MIN_CLASS);
      const w = wrapperEl();
      if (w) w.classList.toggle('minimized', isMin);
      document.documentElement.style.setProperty(CSS_VAR, isMin ? SIDEBAR_WIDTH_MIN : SIDEBAR_WIDTH_OPEN);
      setTimeout(() => window.dispatchEvent(new Event('resize')), 220);
    }

    function handleToggleEvent(e) {
      if ((Date.now() - lastInteractionAt) < INTERACTION_GAP) return;
      if (lock) return;
      lastInteractionAt = Date.now();
      lockFor(260);
      isMobile() ? 
        document.body.classList.contains(BODY_OVERLAY_CLASS) ? 
          closeMobileSidebar() : openMobileSidebar() :
        toggleDesktopSidebar();
    }

    function wireToggleButtons() {
      qsa(TOGGLE_SELECTORS).forEach(el => {
        if (el.__sidebarToggleBound) return;
        el.__sidebarToggleBound = true;
        el.addEventListener('click', handleToggleEvent);
      });
    }

    // Event listeners
    document.addEventListener('click', e => {
      const target = e.target.closest(TOGGLE_SELECTORS);
      if (target) handleToggleEvent(e);
    });

    backdrop.addEventListener('click', () => {
      if (document.body.classList.contains(BODY_OVERLAY_CLASS)) closeMobileSidebar();
    });

    window.addEventListener('resize', () => {
      if (!isMobile()) closeMobileSidebar();
    });

    // Auto-create toggle button if navbar exists
    const navbar = qs('.navbar, header, .main-header');
    if (navbar && !qs(TOGGLE_SELECTORS)) {
      const btn = document.createElement('button');
      btn.id = 'sidebarToggle';
      btn.className = 'btn btn-sm btn-light me-2';
      btn.innerHTML = '<i class="bi bi-list"></i>';
      btn.setAttribute('aria-label', 'Toggle sidebar');
      navbar.prepend(btn);
      wireToggleButtons();
    }

    document.addEventListener('DOMContentLoaded', wireToggleButtons);
  })();
  </script>
</body>
</html>