<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
    /* Keep consistent layout with your other pages */
    #main-content {
        margin-left: 260px;
        /* same as your sidebar width */
        padding: 20px;
        background-color: #f8f9fc;
        min-height: 100vh;
        transition: all 0.3s;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h4 {
        font-weight: 600;
    }

    .table-container {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    #staffTable th,
    #staffTable td {
        text-align: center;
        vertical-align: middle;
        min-width: 100px;
    }

    @media (max-width: 992px) {
        #main-content {
            margin-left: 0;
            padding: 10px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .table-container {
            padding: 10px;
        }
    }

    /* Make table scrollable on mobile */
    @media (max-width: 768px) {
        .table-container {
            overflow-x: auto;
        }

        #staffTable {
            min-width: 700px;
        }

        .modal-dialog {
            max-width: 95vw;
            margin: 10px auto;
        }

        .row.mb-3> .col-md-6,
        .row.mb-3> .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .row.mb-3 {
            flex-direction: column;
        }

        .text-end {
            text-align: left !important;
            margin-top: 10px;
        }
    }

    /* Responsive buttons */
    @media (max-width: 576px) {
        .btn {
            width: 100%;
            margin-bottom: 8px;
        }

        .page-header h4 {
            font-size: 1.2rem;
        }

        #staffTable th,
        #staffTable td {
            font-size: 13px;
            min-width: 80px;
            padding: 6px;
        }

        .table-container {
            padding: 5px;
        }
    }

    /* Red Gradient Theme Button */
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
    </style>
</head>

<body>

    <!-- Sidebar and Navbar -->
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>

    <!-- Main Content -->
    <div id="main-content">
        <div class="page-header">
            <h4>Add New Staff</h4>
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-primary me-2" id="addStaffBtn">Add Staff</button>
                <button class="btn btn-primary" id="addStudentBtn" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
            </div>
        </div>

        <!-- Staff Table -->
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
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>9876543210</td>
                            <td>2023-01-10</td>
                            <td>Coach</td>
                            <td>Center A, Center B</td>
                            <td>6-8 AM, 5-7 PM</td>
                            <td>25000</td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn">Edit</button>
                                <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success statusBtn">Active</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Priya Singh</td>
                            <td>priya@academy.com</td>
                            <td>9123456789</td>
                            <td>2024-03-15</td>
                            <td>Admin</td>
                            <td>Center C</td>
                            <td>-</td>
                            <td>30000</td>
                            <td>
                                <button class="btn btn-sm btn-warning editBtn">Edit</button>
                                <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success statusBtn">Active</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Staff Modal -->
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
                            <div class="col-md-6 col-12"><input type="text" class="form-control" name="name" placeholder="Name" required></div>
                            <div class="col-md-6 col-12 mt-2 mt-md-0"><input type="email" class="form-control" name="email" placeholder="Email" required></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-12"><input type="text" class="form-control" name="contact" placeholder="Contact" required></div>
                            <div class="col-md-6 col-12 mt-2 mt-md-0"><input type="date" class="form-control" name="joining_date" required></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-12">
                                <select class="form-select" name="role" id="roleSelect" required>
                                    <option value="">Select Role</option>
                                    <option value="Coach">Coach</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Coordinator">Coordinator</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-12 mt-2 mt-md-0">
                                <select class="form-select" name="centers[]" multiple required>
                                    <option value="Center A">Center A</option>
                                    <option value="Center B">Center B</option>
                                    <option value="Center C">Center C</option>
                                </select>
                                <small class="text-muted">Hold CTRL to select multiple</small>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-12"><input type="text" class="form-control" name="salary" placeholder="Salary" required></div>
                        </div>
                        <div class="row mb-3" id="slotSection" style="display:none;">
                            <div class="col-md-12 col-12">
                                <select class="form-select" name="slots[]" multiple>
                                    <option value="6-8 AM">6-8 AM</option>
                                    <option value="8-10 AM">8-10 AM</option>
                                    <option value="5-7 PM">5-7 PM</option>
                                </select>
                                <small class="text-muted">Hold CTRL to select multiple</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger w-md-auto">Save Staff</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




<!-- Add Student Modal-->
 */
<!-- Container to display student cards -->
<div class="row" id="studentCardsContainer"></div>
 <!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="addStudentModalLabel">Add Students</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addStudentForm">
          <!-- Student Name -->
          <div class="mb-3">
            <label for="studentName" class="form-label">Student Name</label>
            <input type="text" class="form-control" id="studentName" placeholder="Enter student name">
          </div>

          <!-- Category -->
          <div class="mb-3">
            <label for="studentCategory" class="form-label">Category</label>
            <select class="form-select" id="studentCategory">
              <option value="">Select Category</option>
              <option value="group">Group</option>
              <option value="individual">Individual</option>
            </select>
          </div>

          <!-- Level -->
          <div class="mb-3">
            <label for="studentLevel" class="form-label">Level</label>
            <select class="form-select" id="studentLevel">
              <option value="">Select Level</option>
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
          </div>

          <!-- Assign Staff (Coach) -->
          <div class="mb-3">
            <label for="assignStaff" class="form-label">Assign Staff (Coach)</label>
            <select class="form-select" id="assignStaff">
              <option value="">Select Staff</option>
              <option value="staff1">Staff 1</option>
              <option value="staff2">Staff 2</option>
              <option value="staff3">Staff 3</option>
            </select>
          </div>

          <!-- Related Center -->
          <div class="mb-3">
            <label for="relatedCenter" class="form-label">Related Center</label>
            <select class="form-select" id="relatedCenter">
              <option value="">Select Center</option>
              <option value="center1">Center 1</option>
              <option value="center2">Center 2</option>
              <option value="center3">Center 3</option>
            </select>
          </div>

          <!-- Slots -->
          <div class="mb-3">
            <label for="slot" class="form-label">Slots</label>
            <select class="form-select" id="slot">
              <option value="">Select Slot</option>
              <option value="slot1">Slot 1</option>
              <option value="slot2">Slot 2</option>
              <option value="slot3">Slot 3</option>
            </select>
          </div>

          <!-- Court Assignment -->
          <div class="mb-3">
            <label for="court" class="form-label">Assign Court</label>
            <select class="form-select" id="court">
              <option value="">Select Court</option>
              <option value="court1">Court 1</option>
              <option value="court2">Court 2</option>
              <option value="court3">Court 3</option>
            </select>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="saveStudentBtn">Save Student</button>
      </div>
    </div>
  </div>
</div> 

<!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const saveBtn = document.querySelector("#saveStudentBtn");
    const studentForm = document.getElementById("addStudentForm");
    const container = document.getElementById("studentCardsContainer");

    saveBtn.addEventListener("click", function() {
      // Get form values
      const name = document.getElementById("studentName").value;
      const category = document.getElementById("studentCategory").value;
      const level = document.getElementById("studentLevel").value;
      const staff = document.getElementById("assignStaff").value;
      const center = document.getElementById("relatedCenter").value;
      const slot = document.getElementById("slot").value;
      const court = document.getElementById("court").value;

      // Basic validation
      if(!name) { alert("Please enter student name"); return; }

      // Create card
      const card = document.createElement("div");
      card.className = "col-md-4 mb-3";
      card.innerHTML = `
        <div class="card border-danger h-100">
          <div class="card-header bg-danger text-white">${name}</div>
          <div class="card-body">
            <p><strong>Category:</strong> ${category || "-"}</p>
            <p><strong>Level:</strong> ${level || "-"}</p>
            <p><strong>Coach:</strong> ${staff || "-"}</p>
            <p><strong>Center:</strong> ${center || "-"}</p>
            <p><strong>Slot:</strong> ${slot || "-"}</p>
            <p><strong>Court:</strong> ${court || "-"}</p>
          </div>
        </div>
      `;

      // Append card to container
      container.appendChild(card);

      // Reset form & close modal
      studentForm.reset();
      const modalEl = document.getElementById("addStudentModal");
      const modal = bootstrap.Modal.getInstance(modalEl);
      modal.hide();
    });
  });
</script>

<script>
$(function() {
    let editRow = null;

    // Open modal for ADD STAFF
    $("#addStaffBtn").on("click", function() {
        editRow = null;
        $("#staffForm")[0].reset();
        $("#slotSection").hide();
        $("#staffModalLabel").text("Add Staff");
        $("#staffModal").modal("show");
    });

    // Handle ADD or EDIT
    $("#staffForm").on("submit", function(e) {
        e.preventDefault();

        let name = $("input[name='name']").val();
        let email = $("input[name='email']").val();
        let contact = $("input[name='contact']").val();
        let date = $("input[name='joining_date']").val();
        let role = $("#roleSelect").val();
        let centers = $("select[name='centers[]']").val() || [];
        let slots = $("select[name='slots[]']").val() || [];
        let salary = $("input[name='salary']").val();

        let tbody = $("#staffTable tbody");
        let srNo = tbody.children("tr").length + (editRow ? 0 : 1);

        if (editRow) {
            editRow.find("td:eq(1)").text(name);
            editRow.find("td:eq(2)").text(email);
            editRow.find("td:eq(3)").text(contact);
            editRow.find("td:eq(4)").text(date);
            editRow.find("td:eq(5)").text(role);
            editRow.find("td:eq(6)").text(centers.join(", "));
            editRow.find("td:eq(7)").text(role === "Coach" ? slots.join(", ") : '-');
            editRow.find("td:eq(8)").text(salary);
            editRow = null;
        } else {
            let row = `<tr>
  <td>${srNo}</td>
  <td>${name}</td>
  <td>${email}</td>
  <td>${contact}</td>
  <td>${date}</td>
  <td>${role}</td>
  <td>${centers.join(", ")}</td>
  <td>${role === "Coach" ? slots.join(", ") : '-'}</td>
  <td>${salary}</td>
  <td>
    <button class="btn btn-sm btn-warning editBtn">Edit</button>
    <button class="btn btn-sm btn-danger deleteBtn">Delete</button>
  </td>
  <td>
    <button class="btn btn-sm btn-success statusBtn">Active</button>
  </td>
</tr>`;
            tbody.append(row);

            // SweetAlert for staff added
            Swal.fire({
                icon: 'success',
                title: 'Staff Added',
                text: 'Staff member has been added successfully!',
                timer: 1500,
                showConfirmButton: false
            });
        }

        // Re-number Sr No after add/edit/delete
        tbody.children("tr").each(function(i) {
            $(this).find("td:eq(0)").text(i + 1);
        });

        $("#staffModal").modal("hide");
        $("#staffForm")[0].reset();
        $("#slotSection").hide();
    });

    // DELETE
    $(document).on("click", ".deleteBtn", function() {
        if (confirm("Are you sure you want to delete this staff member?")) {
            $(this).closest("tr").remove();
            // Re-number Sr No after delete
            $("#staffTable tbody tr").each(function(i) {
                $(this).find("td:eq(0)").text(i + 1);
            });
        }
    });

    // EDIT
    $(document).on("click", ".editBtn", function() {
        editRow = $(this).closest("tr");
        $("#staffModalLabel").text("Edit Staff");

        $("input[name='name']").val(editRow.find("td:eq(1)").text());
        $("input[name='email']").val(editRow.find("td:eq(2)").text());
        $("input[name='contact']").val(editRow.find("td:eq(3)").text());
        $("input[name='joining_date']").val(editRow.find("td:eq(4)").text());
        $("#roleSelect").val(editRow.find("td:eq(5)").text()).trigger("change");
        $("input[name='salary']").val(editRow.find("td:eq(8)").text());

        $("#staffModal").modal("show");
    });

    // STATUS TOGGLE
    $(document).on("click", ".statusBtn", function() {
        let btn = $(this);
        if (btn.text() === "Active") {
            btn.text("Deactive").removeClass("btn-success").addClass("btn-secondary");
        } else {
            btn.text("Active").removeClass("btn-secondary").addClass("btn-success");
        }
    });

    // Role change logic
    $("#roleSelect").on("change", function() {
        if ($(this).val() === "Coach") {
            $("#slotSection").show();
        } else {
            $("#slotSection").hide();
        }
    });
});
</script>

    <!-- Sidebar Toggle -->
    <script>
    $(document).ready(function() {
        $("#sidebarToggle").on("click", function() {
            $("#sidebar").toggleClass("collapsed");
            $("#main-content").toggleClass("expanded");
        });
    });
    </script>

</body>

</html>