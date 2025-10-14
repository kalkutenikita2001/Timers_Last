<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Staff</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      background-color: #f8f9fc;
    }

    #main-content {
      margin-left: 260px;
      padding: 20px;
      min-height: 100vh;
      transition: all 0.3s;
    }

    .nav-tabs .nav-link.active {
      background-color: #d00000;
      color: #fff;
      font-weight: 500;
    }

    .nav-tabs .nav-link {
      color: #7b0000;
      border-radius: 6px 6px 0 0;
      font-weight: 500;
    }

    .filter-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 15px 0;
      flex-wrap: wrap;
    }

    .filter-options button {
      border: none;
      background: none;
      color: #7b0000;
      font-weight: 500;
      margin-right: 15px;
      transition: color 0.3s;
    }

    .filter-options button.active,
    .filter-options button:hover {
      color: #d00000;
      text-decoration: underline;
    }

    .staff-count {
      font-weight: 600;
      color: #7b0000;
    }

    .btn-primary {
      background: linear-gradient(90deg, #7b0000, #d00000);
      color: #fff;
      border: none;
      font-weight: 500;
      padding: 8px 18px;
      border-radius: 6px;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background: linear-gradient(90deg, #600000, #a50000);
      color: #fff;
    }

    .table-container {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      background-color: #ccc;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      transition: .4s;
      border-radius: 24px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 3px;
      bottom: 3px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #28a745;
    }

    input:checked + .slider:before {
      transform: translateX(26px);
    }

    .action-icons button {
      border: none;
      background: none;
      padding: 5px;
      margin: 0 2px;
      cursor: pointer;
      transition: transform 0.2s ease;
    }

    .action-icons i {
      font-size: 18px;
    }

    .view-icon { color: #0d6efd; }
    .edit-icon { color: #ffc107; }
    .delete-icon { color: #dc3545; }

    .action-icons button:hover {
      transform: scale(1.15);
    }

    .profile-card {
      background: linear-gradient(145deg, #ffffff, #f1f1f1);
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 25px;
      text-align: center;
      transition: transform 0.3s ease;
    }

    .profile-card:hover { transform: translateY(-5px); }

    .profile-card h5 {
      color: #7b0000;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .profile-info p { margin: 4px 0; font-size: 15px; }

    .salary-box { margin-top: 15px; font-weight: 600; color: #198754; }
    .salary-box.no-salary { color: #dc3545; }


    /* ===========================
   📱 Mobile Responsive Styles
   =========================== */
@media (max-width: 992px) {
  #main-content {
    margin-left: 0 !important;
    padding: 15px;
  }

  .filter-bar {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
  }

  .filter-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 8px;
  }

  .filter-options button {
    font-size: 14px;
    padding: 4px 8px;
  }

  .staff-count {
    font-size: 14px;
  }

  .btn-primary {
    padding: 6px 12px;
    font-size: 14px;
  }

  #searchInput {
    width: 100% !important;
  }

  .table-container {
    padding: 10px;
    overflow-x: auto;
  }

  table {
    font-size: 14px;
    white-space: nowrap;
  }

  th, td {
    padding: 8px 10px;
  }

  .action-icons i {
    font-size: 16px;
  }

  .switch {
    transform: scale(0.9);
  }
}

@media (max-width: 576px) {
  .filter-bar {
    flex-direction: column;
    gap: 12px;
  }

  .filter-options button {
    font-size: 13px;
  }

  .staff-count {
    font-size: 13px;
  }

  .btn-primary {
    font-size: 13px;
    padding: 5px 10px;
  }

  table {
    font-size: 13px;
  }

  #main-content {
    padding: 10px;
  }
}





  </style>
</head>

<body>
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content">
    <ul class="nav nav-tabs" id="staffTabs">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#overviewTab">Overview</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#staffTab">Staff</a>
      </li>
    </ul>

    <div class="tab-pane fade show active" id="overviewTab">
  <div class="p-4 bg-white rounded shadow-sm">
    <!-- <h5 class="text-danger mb-3">Staff Overview</h5> -->
    <div id="overviewContent" class="text-start">
      <p class="text-muted mb-0">No staff details available. Click "Send Details" from Salary Management.</p>
    </div>
  </div>
</div>


      <!-- Staff Tab -->
      <div class="tab-pane fade" id="staffTab">
        <div class="filter-bar">
          <div class="filter-options">
            <button class="active" data-filter="all">All</button>
            <button data-filter="active">Active</button>
            <button data-filter="deactive">Deactive</button>
          </div>

          <div class="d-flex align-items-center gap-3">
            <span class="staff-count">Total Staff: <span id="staffCount">1</span></span>
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search staff...">
            <button class="btn btn-primary btn-sm" id="addStaffBtn"><i class="bi bi-plus-circle me-1"></i>Add Staff</button>
          </div>
        </div>
        <div class="table-container">
          <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle" id="staffTable">
              <thead class="table-light">
                <tr>
                  <th>Sr No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Joining Date</th>
                  <th>Role</th>
                  <th>Centers</th>
                  <th>Slots</th>
                  <th>Salary</th>
                  <th>Actions</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
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
                    <button class="viewBtn"><i class="bi bi-eye-fill view-icon"></i></button>
                    <button class="editBtn"><i class="bi bi-pencil-square edit-icon"></i></button>
                    <button class="deleteBtn"><i class="bi bi-trash delete-icon"></i></button>
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
      </div>
    </div>
  </div>

  <!-- Reuse your modals from old code (Add/Edit and View) -->
  <!-- Staff Modal -->
  <!-- 🧩 Staff Modal (Updated Layout with Checkboxes) -->
<div class="modal fade" id="staffModal" data-backdrop="static" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="staffModalLabel">Add Staff</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="staffForm">
          <div class="row mb-3">
            <div class="col-md-6">
              <input type="text" class="form-control" name="name" placeholder="Enter Staff Name" required>
            </div>
            <div class="col-md-6 mt-2 mt-md-0">
              <input type="email" class="form-control" name="email" placeholder="Staff Email" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <input type="text" class="form-control" name="contact" placeholder="Staff Contact" required>
            </div>
            <div class="col-md-6 mt-2 mt-md-0">
              <input type="date" class="form-control" name="joining_date" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <input type="number" class="form-control" name="salary" placeholder="Enter Salary" required>
            </div>
            <div class="col-md-6 mt-2 mt-md-0">
              <select class="form-select" name="role" id="roleSelect" required>
                <option value="">Select Role</option>
                <option value="Coach">Coach</option>
                <option value="Admin">Admin</option>
                <option value="Coordinator">Coordinator</option>
                <option value="Manager">Manager</option>
              </select>
            </div>
          </div>

          <!-- ✅ Centers Selection as Checkboxes -->
          <div class="mb-3">
            <label class="fw-bold mb-2">Select Centers:</label>
            <div class="d-flex flex-wrap gap-3">
              <div><input type="checkbox" class="center-check" value="Center A"> Center A</div>
              <div><input type="checkbox" class="center-check" value="Center B"> Center B</div>
              <div><input type="checkbox" class="center-check" value="Center C"> Center C</div>
              <div><input type="checkbox" class="center-check" value="Center D"> Center D</div>
            </div>
          </div>

          <!-- ✅ Slots Selection as Checkboxes -->
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

<!-- ✅ Updated JavaScript logic for new checkboxes -->
<script>
  $(function () {
    let editRow = null;

    const updateCount = () => {
      const count = $("#staffTable tbody tr").length;
      $("#staffCount").text(count);
    };
    updateCount();

    $("#addStaffBtn").on("click", function () {
      editRow = null;
      $("#staffForm")[0].reset();
      $("#slotSection").hide();
      $("#staffModalLabel").text("Add Staff");
      $("#staffModal").modal("show");
    });

    $("#staffForm").on("submit", function (e) {
      e.preventDefault();
      const name = $("input[name='name']").val();
      const email = $("input[name='email']").val();
      const contact = $("input[name='contact']").val();
      const date = $("input[name='joining_date']").val();
      const role = $("#roleSelect").val();
      const salary = $("input[name='salary']").val();

      // ✅ Collect checked centers and slots
      const centers = $(".center-check:checked").map(function(){ return $(this).val(); }).get();
      const slots = $(".slot-check:checked").map(function(){ return $(this).val(); }).get();

      const tbody = $("#staffTable tbody");

      if (editRow) {
        editRow.find("td:eq(1)").text(name);
        editRow.find("td:eq(2)").text(email);
        editRow.find("td:eq(3)").text(contact);
        editRow.find("td:eq(4)").text(date);
        editRow.find("td:eq(5)").text(role);
        editRow.find("td:eq(6)").text(centers.join(", "));
        editRow.find("td:eq(7)").text(role === "Coach" ? slots.join(", ") : '-');
        editRow.find("td:eq(8)").text(salary);
        Swal.fire("Updated!", "Staff details updated successfully.", "success");
      } else {
        const srNo = tbody.children("tr").length + 1;
        const newRow = `
          <tr data-status="active">
            <td>${srNo}</td>
            <td>${name}</td>
            <td>${email}</td>
            <td>${contact}</td>
            <td>${date}</td>
            <td>${role}</td>
            <td>${centers.join(", ")}</td>
            <td>${role === "Coach" ? slots.join(", ") : '-'}</td>
            <td>${salary}</td>
            <td class="action-icons">
              <button class="viewBtn"><i class="bi bi-eye-fill view-icon"></i></button>
              <button class="editBtn"><i class="bi bi-pencil-square edit-icon"></i></button>
              <button class="deleteBtn"><i class="bi bi-trash delete-icon"></i></button>
            </td>
            <td>
              <label class="switch">
                <input type="checkbox" class="statusToggle" checked>
                <span class="slider"></span>
              </label>
            </td>
          </tr>`;
        tbody.append(newRow);
        Swal.fire("Added!", "New staff added successfully.", "success");
        updateCount();
      }
      $("#staffModal").modal("hide");
    });

    $(document).on("click", ".viewBtn", function () {
      const row = $(this).closest("tr");
      $("#profileName").text(row.find("td:eq(1)").text());
      $("#profileEmail").text(row.find("td:eq(2)").text());
      $("#profileContact").text(row.find("td:eq(3)").text());
      $("#profileDate").text(row.find("td:eq(4)").text());
      $("#profileRole").text(row.find("td:eq(5)").text());
      $("#profileCenters").text(row.find("td:eq(6)").text());
      $("#profileSlots").text(row.find("td:eq(7)").text());
      const salary = row.find("td:eq(8)").text().trim();
      if (!salary || salary === "0") {
        $("#profileSalary").text("No salary assigned").addClass("no-salary");
      } else {
        $("#profileSalary").text("Income: ₹" + salary).removeClass("no-salary");
      }
      $("#viewProfileModal").modal("show");
    });

    $(document).on("click", ".deleteBtn", function () {
      const row = $(this).closest("tr");
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
          updateCount();
          Swal.fire("Deleted!", "Staff record deleted successfully.", "success");
        }
      });
    });

    $(document).on("change", ".statusToggle", function () {
      const row = $(this).closest("tr");
      if ($(this).is(":checked")) {
        row.attr("data-status", "active");
        Swal.fire("Activated", "Status changed to Active", "success");
      } else {
        row.attr("data-status", "deactive");
        Swal.fire("Deactivated", "Status changed to Inactive", "info");
      }
    });

    $(".filter-options button").on("click", function () {
      $(".filter-options button").removeClass("active");
      $(this).addClass("active");
      const filter = $(this).data("filter");
      $("#staffTable tbody tr").each(function () {
        const status = $(this).attr("data-status");
        if (filter === "all" || status === filter) $(this).show();
        else $(this).hide();
      });
    });

    $("#searchInput").on("keyup", function () {
      const value = $(this).val().toLowerCase();
      $("#staffTable tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });

    $("#roleSelect").on("change", function () {
      $(this).val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
    });
  });
</script>


  <!-- View Profile Modal -->
  <div class="modal fade" id="viewProfileModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="profile-card">
          <h5 id="profileName">Staff Name</h5>
          <div class="profile-info">
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    $(function() {
      let editRow = null;

      const updateCount = () => {
        const count = $("#staffTable tbody tr").length;
        $("#staffCount").text(count);
      };

      updateCount();

      $("#addStaffBtn").on("click", function () {
        editRow = null;
        $("#staffForm")[0].reset();
        $("#slotSection").hide();
        $("#staffModalLabel").text("Add Staff");
        $("#staffModal").modal("show");
      });

      $("#staffForm").on("submit", function (e) {
        e.preventDefault();
        const name = $("input[name='name']").val();
        const email = $("input[name='email']").val();
        const contact = $("input[name='contact']").val();
        const date = $("input[name='joining_date']").val();
        const role = $("#roleSelect").val();
        const centers = $("select[name='centers[]']").val() || [];
        const slots = $("select[name='slots[]']").val() || [];
        const salary = $("input[name='salary']").val();
        const tbody = $("#staffTable tbody");

        if (editRow) {
          editRow.find("td:eq(1)").text(name);
          editRow.find("td:eq(2)").text(email);
          editRow.find("td:eq(3)").text(contact);
          editRow.find("td:eq(4)").text(date);
          editRow.find("td:eq(5)").text(role);
          editRow.find("td:eq(6)").text(centers.join(", "));
          editRow.find("td:eq(7)").text(role === "Coach" ? slots.join(", ") : '-');
          editRow.find("td:eq(8)").text(salary);
          Swal.fire("Updated!", "Staff details updated successfully.", "success");
        } else {
          const srNo = tbody.children("tr").length + 1;
          const newRow = `
            <tr data-status="active">
              <td>${srNo}</td>
              <td>${name}</td>
              <td>${email}</td>
              <td>${contact}</td>
              <td>${date}</td>
              <td>${role}</td>
              <td>${centers.join(", ")}</td>
              <td>${role === "Coach" ? slots.join(", ") : '-'}</td>
              <td>${salary}</td>
              <td class="action-icons">
                <button class="viewBtn"><i class="bi bi-eye-fill view-icon"></i></button>
                <button class="editBtn"><i class="bi bi-pencil-square edit-icon"></i></button>
                <button class="deleteBtn"><i class="bi bi-trash delete-icon"></i></button>
              </td>
              <td>
                <label class="switch">
                  <input type="checkbox" class="statusToggle" checked>
                  <span class="slider"></span>
                </label>
              </td>
            </tr>`;
          tbody.append(newRow);
          Swal.fire("Added!", "New staff added successfully.", "success");
          updateCount();
        }

        $("#staffModal").modal("hide");
      });

      $(document).on("click", ".deleteBtn", function () {
        const row = $(this).closest("tr");
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
            updateCount();
            Swal.fire("Deleted!", "Staff record deleted successfully.", "success");
          }
        });
      });

      $(document).on("click", ".viewBtn", function () {
        const row = $(this).closest("tr");
        $("#profileName").text(row.find("td:eq(1)").text());
        $("#profileEmail").text(row.find("td:eq(2)").text());
        $("#profileContact").text(row.find("td:eq(3)").text());
        $("#profileDate").text(row.find("td:eq(4)").text());
        $("#profileRole").text(row.find("td:eq(5)").text());
        $("#profileCenters").text(row.find("td:eq(6)").text());
        $("#profileSlots").text(row.find("td:eq(7)").text());
        const salary = row.find("td:eq(8)").text().trim();
        if (!salary || salary === "0") {
          $("#profileSalary").text("No salary assigned").addClass("no-salary");
        } else {
          $("#profileSalary").text("Income: ₹" + salary).removeClass("no-salary");
        }
        $("#viewProfileModal").modal("show");
      });

      $(document).on("change", ".statusToggle", function () {
        const row = $(this).closest("tr");
        if ($(this).is(":checked")) {
          row.attr("data-status", "active");
          Swal.fire("Activated", "Status changed to Active", "success");
        } else {
          row.attr("data-status", "deactive");
          Swal.fire("Deactivated", "Status changed to Inactive", "info");
        }
      });

      $(".filter-options button").on("click", function() {
        $(".filter-options button").removeClass("active");
        $(this).addClass("active");
        const filter = $(this).data("filter");
        $("#staffTable tbody tr").each(function() {
          const status = $(this).attr("data-status");
          if (filter === "all" || status === filter) $(this).show();
          else $(this).hide();
        });
      });

      $("#searchInput").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $("#staffTable tbody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });

      $("#roleSelect").on("change", function () {
        $(this).val() === "Coach" ? $("#slotSection").show() : $("#slotSection").hide();
      });
    });

// 🧾 Load Salary Details into Overview Tab
$(document).ready(function() {
  const data = localStorage.getItem('staffSalaryData');
  if (data) {
    const staff = JSON.parse(data);
    const html = `
      <div class="border rounded p-3 bg-light">
        <h6 class="text-danger fw-bold mb-3">${staff.name}</h6>
        <p><b>Hours Worked:</b> ${staff.hours}</p>
        <p><b>Days Present:</b> ${staff.days}</p>
        <p><b>Sessions:</b> ${staff.sessions}</p>
        <p><b>Rate:</b> ${staff.rate}</p>
        <p><b>Total Salary:</b> ${staff.salary}</p>
        <p><b>Status:</b> ${staff.status}</p>
      </div>
    `;
    $("#overviewContent").html(html);
  }
});







  </script>




</body>
</html>
