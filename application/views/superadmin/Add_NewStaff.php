<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Staff</title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.jpg'); ?>">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- jQuery & SweetAlert -->
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
    }

    #main-content.minimized {
      margin-left: 60px;
      width: calc(100vw - 60px);
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

    .btn-primary {
      background: var(--grad);
      border: 0;
      font-weight: 700;
    }

    .btn-primary:hover {
      filter: brightness(.96);
    }

    .table thead th {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 2;
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

    #slotSection {
      display: none;
    }
  </style>
</head>

<body>
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <!-- Page Hero -->
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">Add & Manage Staff</div>
        <button class="btn btn-primary" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search staff...">
          </div>
        </div>
        <span class="badge rounded-pill bg-light text-dark px-3 py-2">Total <b id="staffCount">0</b></span>
      </div>
    </div>

    <!-- Staff Table -->
    <div class="card-lite p-3 mt-3">
      <div class="filter-options mb-2">
        <button class="btn btn-ghost btn-sm active" data-filter="all">All</button>
        <button class="btn btn-ghost btn-sm" data-filter="active">Active</button>
        <button class="btn btn-ghost btn-sm" data-filter="deactive">Deactive</button>
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
              <!-- <th class="text-center" style="width:90px">Status</th> -->
            </tr>
          </thead>
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
                    <?php
                    if (!empty($staffMember['centers'])) {
                      foreach (explode(',', $staffMember['centers']) as $center) {
                        echo '<span class="badge bg-light text-dark mb-1">' . htmlspecialchars(trim($center)) . '</span><br>';
                      }
                    } else {
                      echo '<span class="text-muted">No centers</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    if (!empty($staffMember['slots'])) {
                      foreach (explode(',', $staffMember['slots']) as $slot) {
                        echo '<span class="badge bg-light text-dark mb-1">' . htmlspecialchars(trim($slot)) . '</span><br>';
                      }
                    } else {
                      echo '<span class="text-muted">No slots</span>';
                    }
                    ?>
                  </td>
                  <td class="text-end">₹<?= number_format($staffMember['salary'], 2) ?></td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary viewBtn" data-id="<?= $staffMember['id'] ?>"><i class="bi bi-eye"></i></button>
                      <button class="btn btn-outline-secondary editBtn" data-id="<?= $staffMember['id'] ?>"><i class="bi bi-pencil"></i></button>
                      <button class="btn btn-outline-danger deleteBtn" data-id="<?= $staffMember['id'] ?>"><i class="bi bi-trash"></i></button>
                    </div>
                  </td>
                  <!-- <td class="text-center">
                    <label class="switch">
                      <input type="checkbox" class="statusToggle" <?= $staffMember['active'] == 1 ? 'checked' : '' ?> data-id="<?= $staffMember['id'] ?>">
                      <span class="slider"></span>
                    </label>
                  </td> -->
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

  <!-- Add/Edit Staff Modal -->
  <div class="modal fade" id="staffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="staffModalLabel">Add Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

            <div class="mb-3">
              <label class="fw-bold mb-2">Select Centers:</label>
              <div class="d-flex flex-wrap gap-3">
                <?php if (!empty($venues)): foreach ($venues as $venue): ?>
                    <div>
                      <input type="checkbox" name="centers[]" value="<?= $venue['venue_name']; ?>" class="center-check">
                      <?= $venue['venue_name']; ?>
                    </div>
                  <?php endforeach;
                else: ?>
                  <p>No centers available.</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3" id="slotSection">
              <label class="fw-bold mb-2">Select Slots:</label>
              <div class="d-flex flex-wrap gap-3">
                <?php if (!empty($slots)): foreach ($slots as $slot): ?>
                    <div>
                      <input type="checkbox" name="slots[]" value="<?= $slot['slot_name']; ?>"
                        class="slot-check" data-center="<?= $slot['venue_name']; ?>">
                      <?= $slot['slot_name']; ?>
                    </div>
                  <?php endforeach;
                else: ?>
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
  <!-- Edit Staff Modal -->
  <div class="modal fade" id="editStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="editStaffForm" method="post" action="<?php echo base_url('superadmin/updateStaff'); ?>">
            <input type="hidden" name="id" id="editStaffId">

            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" name="name" id="editStaffName" placeholder="Enter Staff Name" required>
              </div>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" id="editStaffEmail" placeholder="Staff Email" required>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" class="form-control" name="contact" id="editStaffContact" placeholder="Staff Contact" required>
              </div>
              <div class="col-md-6">
                <input type="date" class="form-control" name="joining_date" id="editStaffJoining" required>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="number" class="form-control" name="salary" id="editStaffSalary" placeholder="Enter Salary" required>
              </div>
              <div class="col-md-6">
                <select class="form-select" name="role" id="editRoleSelect" required>
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
              <div class="d-flex flex-wrap gap-3" id="editCenterList">
                <?php if (!empty($venues)): foreach ($venues as $venue): ?>
                    <div>
                      <input type="checkbox" name="centers[]" value="<?= $venue['venue_name']; ?>" class="center-check">
                      <?= $venue['venue_name']; ?>
                    </div>
                  <?php endforeach;
                else: ?>
                  <p>No centers available.</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3" id="editSlotSection">
              <label class="fw-bold mb-2">Select Slots:</label>
              <div class="d-flex flex-wrap gap-3" id="editSlotList">
                <?php if (!empty($slots)): foreach ($slots as $slot): ?>
                    <div>
                      <input type="checkbox" name="slots[]" value="<?= $slot['slot_name']; ?>"
                        class="slot-check" data-center="<?= $slot['venue_name']; ?>">
                      <?= $slot['slot_name']; ?>
                    </div>
                  <?php endforeach;
                else: ?>
                  <p>No slots available.</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Update Staff</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize staff count
      $("#staffCount").text(<?= !empty($staff) ? count($staff) : 0 ?>);

      // Add Staff Button
      $('#addStaffBtn').on('click', function() {
        $('#staffForm')[0].reset();
        $(".center-check, .slot-check").prop('checked', false);
        $("#slotSection").hide();
        $("#staffModalLabel").text("Add Staff");
        new bootstrap.Modal(document.getElementById('staffModal')).show();
      });

      // Role selection
      $("#roleSelect").on('change', function() {
        if ($(this).val() === "Coach") {
          $("#slotSection").show();
        } else {
          $("#slotSection").hide();
          $(".slot-check").prop('checked', false);
        }
      });

      // Form submission via AJAX
      document.getElementById('staffForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Saving...';

        const formData = new FormData(form);

        try {
          const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
          });

          // Parse JSON response
          const result = await response.json();

          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Save Staff';

          if (result.success) {
            Swal.fire("Success", result.message, "success").then(() => {
              const staffModal = bootstrap.Modal.getInstance(document.getElementById('staffModal'));
              staffModal.hide();
              location.reload();
            });
          } else {
            Swal.fire("Error", result.message || "Failed to save staff", "error");
          }
        } catch (error) {
          console.error('Error:', error);
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Save Staff';
          Swal.fire("Error", "An error occurred while saving staff", "error");
        }
      });


      // View profile modal
      $(document).on('click', '.viewBtn', function(e) {
        e.stopPropagation();
        const $row = $(this).closest('tr');
        $('#profileName').text($row.find('td:eq(1)').text());
        $('#profileEmail').text($row.find('td:eq(2)').text());
        $('#profileContact').text($row.find('td:eq(3)').text());
        $('#profileDate').text($row.find('td:eq(4)').text());
        $('#profileRole').text($row.find('td:eq(5)').text());
        $('#profileCenters').html($row.find('td:eq(6)').html());
        $('#profileSlots').html($row.find('td:eq(7)').html());
        $('#profileSalary').text($row.find('td:eq(8)').text());
        new bootstrap.Modal(document.getElementById('viewProfileModal')).show();
      });

      // Search functionality
      $('#searchInput').on('keyup', function() {
        const text = $(this).val().toLowerCase();
        $('#staffTable tbody tr').filter(function() {
          $(this).toggle($(this).text().toLowerCase().includes(text));
        });
      });

      // Filter functionality
      $('[data-filter]').on('click', function() {
        const filter = $(this).data('filter');
        $('[data-filter]').removeClass('active');
        $(this).addClass('active');
        $('#staffTable tbody tr').each(function() {
          const isActive = $(this).find('.statusToggle').is(':checked');
          $(this).toggle(filter === 'all' || (filter === 'active' && isActive) || (filter === 'deactive' && !isActive));
        });
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.stopPropagation();
          const row = this.closest('tr');

          // Basic fields
          document.getElementById('editStaffId').value = this.dataset.id;
          document.getElementById('editStaffName').value = row.cells[1].textContent.trim();
          document.getElementById('editStaffEmail').value = row.cells[2].textContent.trim();
          document.getElementById('editStaffContact').value = row.cells[3].textContent.trim();

          // Convert "d M Y" to Y-m-d
          const joining = row.cells[4].textContent.trim();
          if (joining !== 'N/A') {
            const d = new Date(joining);
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            document.getElementById('editStaffJoining').value = `${yyyy}-${mm}-${dd}`;
          } else {
            document.getElementById('editStaffJoining').value = '';
          }

          document.getElementById('editStaffSalary').value = row.cells[8].textContent.replace('₹', '').replace(',', '').trim();
          document.getElementById('editRoleSelect').value = row.cells[5].textContent.trim();

          // Reset all checkboxes
          document.querySelectorAll('#editCenterList input').forEach(chk => chk.checked = false);
          document.querySelectorAll('#editSlotList input').forEach(chk => chk.checked = false);

          // Preselect centers
          const centers = [];
          row.cells[6].querySelectorAll('span').forEach(span => centers.push(span.textContent.trim()));
          centers.forEach(c => {
            const input = document.querySelector(`#editCenterList input[value="${c}"]`);
            if (input) input.checked = true;
          });

          // Preselect slots
          const slots = [];
          row.cells[7].querySelectorAll('span').forEach(span => slots.push(span.textContent.trim()));
          slots.forEach(s => {
            const input = document.querySelector(`#editSlotList input[value="${s}"]`);
            if (input) input.checked = true;
          });

          // Show/hide slot section
          const slotSection = document.getElementById('editSlotSection');
          slotSection.style.display = (row.cells[5].textContent.trim() === 'Coach') ? 'block' : 'none';

          // Show modal
          new bootstrap.Modal(document.getElementById('editStaffModal')).show();
        });
      });

      // Show/hide slots on role change
      document.getElementById('editRoleSelect').addEventListener('change', function() {
        const slotSection = document.getElementById('editSlotSection');
        if (this.value === 'Coach') {
          slotSection.style.display = 'block';
        } else {
          slotSection.style.display = 'none';
          document.querySelectorAll('#editSlotList input').forEach(chk => chk.checked = false);
        }
      });
    });
  </script>
  <script>
    // Function to update available slots based on selected centers
    function updateAvailableSlots() {
      const selectedCenters = Array.from(document.querySelectorAll('.center-check:checked'))
        .map(cb => cb.value);

      // Reset all slots first
      document.querySelectorAll('.slot-check').forEach(slot => {
        slot.style.display = 'block';
        slot.parentElement.style.display = 'block';
      });

      // If no centers selected or role is not Coach, show all slots
      if (selectedCenters.length === 0 || document.getElementById('roleSelect').value !== 'Coach') {
        return;
      }

      // Hide slots that don't belong to selected centers
      // You'll need to add data-center attribute to your slot checkboxes
      document.querySelectorAll('.slot-check').forEach(slot => {
        const slotCenter = slot.getAttribute('data-center');
        if (slotCenter && !selectedCenters.includes(slotCenter)) {
          slot.style.display = 'none';
          slot.parentElement.style.display = 'none';
        }
      });
    }

    // Update your existing slot checkboxes to include data-center attribute
    // Modify your PHP slot generation to look like this:
    /*
    <?php if (!empty($slots)): foreach ($slots as $slot): ?>
        <div>
            <input type="checkbox" name="slots[]" value="<?= $slot['slot_name']; ?>" 
                   class="slot-check" data-center="<?= $slot['venue_name']; ?>">
            <?= $slot['slot_name']; ?>
        </div>
    <?php endforeach;
    endif; ?>
    */

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      // Update slots when centers are selected/deselected
      document.querySelectorAll('.center-check').forEach(checkbox => {
        checkbox.addEventListener('change', updateAvailableSlots);
      });

      // Update slots when role changes
      document.getElementById('roleSelect').addEventListener('change', function() {
        if (this.value === 'Coach') {
          $("#slotSection").show();
          updateAvailableSlots();
        } else {
          $("#slotSection").hide();
        }
      });

      // For edit modal
      document.querySelectorAll('.center-check').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          if (document.getElementById('editRoleSelect').value === 'Coach') {
            updateAvailableSlots();
          }
        });
      });

      document.getElementById('editRoleSelect').addEventListener('change', function() {
        if (this.value === 'Coach') {
          document.getElementById('editSlotSection').style.display = 'block';
          updateAvailableSlots();
        } else {
          document.getElementById('editSlotSection').style.display = 'none';
        }
      });
    });
    // Delete Staff Functionality
    $(document).on('click', '.deleteBtn', function(e) {
      e.stopPropagation();
      const staffId = $(this).data('id');
      const staffName = $(this).closest('tr').find('td:eq(1)').text().trim();

      Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete staff member: ${staffName}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4040',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Show loading
          Swal.fire({
            title: 'Deleting...',
            text: 'Please wait',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

          // AJAX call to delete staff
          $.ajax({
            url: '<?php echo base_url('superadmin/deleteStaff'); ?>',
            type: 'POST',
            data: {
              id: staffId
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  title: 'Deleted!',
                  text: response.message,
                  icon: 'success',
                  confirmButtonColor: '#ff4040'
                }).then(() => {
                  location.reload();
                });
              } else {
                Swal.fire({
                  title: 'Error!',
                  text: response.message || 'Failed to delete staff',
                  icon: 'error',
                  confirmButtonColor: '#ff4040'
                });
              }
            },
            error: function() {
              Swal.fire({
                title: 'Error!',
                text: 'An error occurred while deleting staff',
                icon: 'error',
                confirmButtonColor: '#ff4040'
              });
            }
          });
        }
      });
    });

    // Edit Form Submission with SweetAlert
    document.getElementById('editStaffForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const form = this;
      const submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Updating...';

      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData,
        });

        const result = await response.json();

        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Update Staff';

        if (result.success) {
          Swal.fire({
            title: 'Success!',
            text: result.message,
            icon: 'success',
            confirmButtonColor: '#ff4040'
          }).then(() => {
            const editModal = bootstrap.Modal.getInstance(document.getElementById('editStaffModal'));
            editModal.hide();
            location.reload();
          });
        } else {
          Swal.fire({
            title: 'Error!',
            text: result.message || 'Failed to update staff',
            icon: 'error',
            confirmButtonColor: '#ff4040'
          });
        }
      } catch (error) {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Update Staff';
        Swal.fire({
          title: 'Error!',
          text: 'An error occurred while updating staff',
          icon: 'error',
          confirmButtonColor: '#ff4040'
        });
      }
    });
  </script>

  <script>
document.addEventListener('DOMContentLoaded', function () {
  const p = new URLSearchParams(location.search);
  if (p.get('autopopup') === '1') {
    // same prep as your existing click handler
    $('#staffForm')[0].reset();
    $(".center-check, .slot-check").prop('checked', false);
    $("#slotSection").hide();
    $("#staffModalLabel").text("Add Staff");
    new bootstrap.Modal(document.getElementById('staffModal')).show();
  }
});
</script>

</body>

</html>