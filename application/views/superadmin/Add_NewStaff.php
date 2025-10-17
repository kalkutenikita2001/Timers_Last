<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Staff</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --accent: #ff4040;
      --accent-dark: #470000;
      --muted: #f4f6f8;
      --grad: linear-gradient(135deg, var(--accent), var(--accent-dark));
      --sidebar-width: 250px;
    }

    body {
      background: var(--muted);
      color: #111;
      overflow-x: hidden;
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
    }

    #main-content {
      margin-left: var(--sidebar-width);
      width: calc(100vw - var(--sidebar-width));
      padding: 20px;
      min-height: 100vh;
      transition: .25s;
      overflow-x: hidden;
    }

    #main-content.minimized {
      margin-left: 60px;
      width: calc(100vw - 60px);
    }

    @media (max-width: 991.98px) {
      #main-content {
        margin-left: 0 !important;
        width: 100vw;
        padding: 12px;
      }
    }

    .page-hero {
      border-radius: 16px;
      border: 1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255, 64, 64, .22), transparent),
        radial-gradient(800px 260px at 110% 0%, rgba(71, 0, 0, .18), transparent),
        linear-gradient(90deg, #fff, #fff6f6);
      box-shadow: 0 16px 40px rgba(255, 64, 64, .08);
      padding: 14px 16px;
    }

    .page-title {
      font-weight: 800;
      letter-spacing: .2px;
    }

    .toolbar {
      position: sticky;
      top: 12px;
      z-index: 5;
      background: #fff;
      border: 1px solid #e9ecef;
      border-radius: 12px;
      padding: 10px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, .05);
    }

    .btn-ghost {
      border: 1px solid #e9ecef;
      background: #fff;
    }

    .btn-ghost:hover {
      background: #f8f8f8;
    }

    .btn-primary {
      background: var(--grad);
      border: 0;
      font-weight: 700;
    }

    .btn-primary:hover {
      filter: brightness(.96);
    }

    .global-search {
      max-width: 600px;
      margin: 0 auto;
      transition: all .25s ease;
    }

    .global-search .form-control {
      height: 42px;
      border-radius: 50px;
      font-size: .9rem;
      padding-left: .5rem;
      border-color: #e3e3e3;
    }

    .global-search .form-control:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(255, 64, 64, .2);
    }

    .global-search .input-group-text {
      border-radius: 50px 0 0 50px;
      background: #fff;
      border-color: #e3e3e3;
    }

    .card-lite {
      background: #fff;
      border-radius: 14px;
      border: 1px solid #e9ecef;
      box-shadow: 0 6px 20px rgba(0, 0, 0, .05);
    }

    .table thead th {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 2;
    }

    .table-hover tbody tr:hover {
      background: rgba(255, 64, 64, .035);
    }

    .clickable-row {
      cursor: pointer;
      transition: background-color .2s ease;
    }

    .clickable-row:hover {
      background-color: rgba(255, 64, 64, .05);
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 46px;
      height: 24px;
    }

    .switch input {
      display: none;
    }

    .slider {
      position: absolute;
      left: 0;
      top: 0;
      right: 0;
      bottom: 0;
      background: #dcdcdc;
      border-radius: 24px;
      transition: .25s;
    }

    .slider:before {
      content: "";
      position: absolute;
      left: 3px;
      top: 3px;
      width: 18px;
      height: 18px;
      background: #fff;
      border-radius: 50%;
      transition: .25s;
    }

    .switch input:checked+.slider {
      background: #28a745;
    }

    .switch input:checked+.slider:before {
      transform: translateX(22px);
    }

    .modal-header.bg-danger {
      background: var(--grad) !important;
      color: #fff;
    }
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
          <!-- <tbody>
            <tr>
              <td colspan="11" class="text-center text-muted py-4">Loading staff data...</td>
            </tr>
          </tbody> -->
          <tbody>
            <?php if (!empty($staff)): ?>
              <?php foreach ($staff as $index => $staffMember): ?>
                <tr class="clickable-row" data-id="<?= $staffMember['id'] ?>">
                  <td><?= $index + 1 ?></td>
                  <td><?= htmlspecialchars($staffMember['name']) ?></td>
                  <td><?= htmlspecialchars($staffMember['email']) ?></td>
                  <td><?= htmlspecialchars($staffMember['contact']) ?></td>
                  <td><?= !empty($staffMember['joining_date']) && $staffMember['joining_date'] != '0000-00-00' ? date('d M Y', strtotime($staffMember['joining_date'])) : 'N/A' ?></td>
                  <td><?= htmlspecialchars($staffMember['role']) ?></td>
                  <td>
                    <?php if (!empty($staffMember['centers'])): ?>
                      <?php
                      $centers = explode(',', $staffMember['centers']);
                      foreach ($centers as $center):
                      ?>
                        <span class="badge bg-light text-dark mb-1"><?= htmlspecialchars(trim($center)) ?></span><br>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">No centers</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($staffMember['slots'])): ?>
                      <?php
                      $slots = explode(',', $staffMember['slots']);
                      foreach ($slots as $slot):
                      ?>
                        <span class="badge bg-light text-dark mb-1"><?= htmlspecialchars(trim($slot)) ?></span><br>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <span class="text-muted">No slots</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-end">₹<?= number_format($staffMember['salary'], 2) ?></td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary viewBtn" data-id="<?= $staffMember['id'] ?>">
                        <i class="bi bi-eye"></i>
                      </button>
                      <button class="btn btn-outline-secondary editBtn" data-id="<?= $staffMember['id'] ?>">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <button class="btn btn-outline-danger deleteBtn" data-id="<?= $staffMember['id'] ?>">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </td>
                  <td class="text-center">
                    <label class="switch">
                      <input type="checkbox" class="statusToggle" <?= $staffMember['active'] == 1 ? 'checked' : '' ?> data-id="<?= $staffMember['id'] ?>">
                      <span class="slider"></span>
                    </label>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="11" class="text-center text-muted py-4">No staff members found.</td>
              </tr>
            <?php endif; ?>
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
          <form id="staffForm" action="<?php echo base_url('superadmin/saveStaff'); ?>" method="post">



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
            <!-- In Centers section -->
            <div class="mb-3">
              <label class="fw-bold mb-2">Select Centers:</label>
              <div class="d-flex flex-wrap gap-3">
                <?php if (!empty($venues)) : ?>
                  <?php foreach ($venues as $venue) : ?>
                    <div>
                      <input type="checkbox" name="centers[]" value="<?= $venue['venue_name']; ?>" class="center-check">
                      <?= $venue['venue_name']; ?>
                    </div>
                  <?php endforeach; ?>
                <?php else : ?>
                  <p>No centers available.</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3" id="slotSection">
              <label class="fw-bold mb-2">Select Slots:</label>
              <div class="d-flex flex-wrap gap-3">
                <?php if (!empty($slots)) : ?>
                  <?php foreach ($slots as $slot) : ?>
                    <div>
                      <input type="checkbox" name="slots[]" value="<?= $slot['slot_name']; ?>" class="slot-check">
                      <?= $slot['slot_name']; ?>
                    </div>
                  <?php endforeach; ?>
                <?php else : ?>
                  <p>No slots available.</p>
                <?php endif; ?>
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
    // Initialize when DOM is ready
    $(function() {
      console.log('Initializing Staff Management...');
      bindUI();

      // Update staff count from server data
      const staffCount = <?= !empty($staff) ? count($staff) : 0 ?>;
      $("#staffCount").text(staffCount);
    });
    (function($) {
      let editRow = null;

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

        // Form submission - ONLY ONE VERSION
        $("#staffForm").off('submit').on('submit', function(e) {
          const form = $(this);
          const name = form.find("input[name='name']").val().trim();
          const email = form.find("input[name='email']").val().trim();
          const contact = form.find("input[name='contact']").val().trim();
          const salary = form.find("input[name='salary']").val().trim();
          const role = form.find("#roleSelect").val();
          const joiningDate = form.find("input[name='joining_date']").val();

          // Basic validation
          if (!name || !email || !contact || !salary || !role || !joiningDate) {
            e.preventDefault();
            Swal.fire("Missing info", "Please fill all required fields.", "warning");
            return false;
          }

          // Show loading state
          const submitBtn = form.find('button[type="submit"]');
          submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Saving...');

          // Form will now submit normally to your PHP controller
          return true;
        });

        // Remove all these event handlers since they depend on localStorage functions that are commented out:
        // - Edit button (.editBtn)
        // - View button (.viewBtn) 
        // - Delete button (.deleteBtn)
        // - Status toggle (.statusToggle)
        // - Filters
        // - Search

        // For now, just keep the table showing the loading message
        $("#staffTable tbody").html(`
        <tr>
          <td colspan="11" class="text-center text-muted py-4">
            Staff data will load here after being saved to database.
          </td>
        </tr>
      `);
      }

      // Initialize when DOM is ready - SIMPLIFIED VERSION
      $(function() {
        console.log('Initializing Staff Management...');
        bindUI();

        // Update count to 0 since we're not loading from localStorage
        $("#staffCount").text("0");
      });

    })(jQuery);
  </script>
</body>

</html>