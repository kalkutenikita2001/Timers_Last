<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Re-Admission</title>

  <!-- Bootstrap & Icons -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">


  <style>
    body {
      background-color: #f4f6f8 !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
      overflow-x: hidden;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 80px 20px 20px 20px;
      transition: margin-left 0.3s ease-in-out;
    }

    .content-wrapper.minimized {
      margin-left: 60px;
    }

    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 80px 12px 20px 12px;
      }
    }

    .table thead th {
      white-space: nowrap;
    }

    .form-inline .form-control {
      width: 240px;
    }

    .card-header,
    .modal-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      color: #fff !important;
    }

    /* Fees cell styling */
    .fees-cell div {
      margin-bottom: 5px;
    }

    .fees-label {
      font-weight: bold;
      color: #555;
    }

    /* Validation error styling */
    .is-invalid {
      border-color: #dc3545 !important;
    }

    .invalid-feedback {
      display: none;
      color: #dc3545;
      font-size: 12px;
    }

    .is-invalid~.invalid-feedback {
      display: block;
    }
  </style>
</head>

<body class="bg-light">

  <!-- Sidebar -->
  <?php $this->load->view('admin/Include/Sidebar') ?>

  <!-- Navbar -->
  <?php $this->load->view('admin/Include/Navbar') ?>

  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="container-fluid mt-4">
      <div class="card shadow">
        <div class="card-header text-white d-flex align-items-center justify-content-between">
          <h4 class="mb-0"><i class="fas fa-user-slash"></i> Re-Admission (Deactivated Students)</h4>

          <!-- Quick search -->
          <form class="form-inline" onsubmit="return false;">
            <input id="tableSearch" class="form-control form-control-sm" type="text" placeholder="Search by name" />
          </form>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" id="studentsTable">
              <thead style="background: linear-gradient(135deg, #007bff 0%, #001f54 100%); color: #fff;">
                <tr>
                  <th style="width: 60px;">Student ID</th>
                  <th>Name</th>
                  <th>Center</th>
                  <th>Fees
                    <button class="btn btn-sm btn-light ml-2" id="toggleFees">
                      <i class="fas fa-sync"></i>
                    </button>
                  </th>
                  <th>Status</th>
                  <th>Joining Date</th>
                  <th style="min-width: 120px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr data-id="2" data-name="Priya Patil" data-center="Main Center"
                  data-total="8000" data-paid="4000" data-remaining="4000"
                  data-status="Deactive" data-joining="2025-08-20">
                  <td>2</td>
                  <td>Priya Patil</td>
                  <td>Main Center</td>
                  <td class="fees-cell">
                    <div><span class="fees-label">Total:</span> ₹8000</div>
                    <div><span class="fees-label">Paid:</span> ₹4000</div>
                    <div><span class="fees-label">Remaining:</span> ₹4000</div>
                  </td>
                  <td class="status-cell">
                    <span class="badge badge-danger">Deactive</span>
                  </td>
                  <td class="joining-cell">2025-08-20</td>
                  <td class="text-nowrap">
                    <button class="btn btn-sm btn-primary btn-update-date"
                      data-id="2" data-name="Priya Patil" data-date="2025-08-20">
                      <i class="fas fa-calendar-alt"></i> Update Date
                    </button>
                  </td>
                </tr>

                <tr data-id="3" data-name="Amit Kumar" data-center="Branch Center"
                  data-total="6000" data-paid="3000" data-remaining="3000"
                  data-status="Deactive" data-joining="2025-08-22">
                  <td>3</td>
                  <td>Amit Kumar</td>
                  <td>Branch Center</td>
                  <td class="fees-cell">
                    <div><span class="fees-label">Total:</span> ₹6000</div>
                    <div><span class="fees-label">Paid:</span> ₹3000</div>
                    <div><span class="fees-label">Remaining:</span> ₹3000</div>
                  </td>
                  <td class="status-cell">
                    <span class="badge badge-danger">Deactive</span>
                  </td>
                  <td class="joining-cell">2025-08-22</td>
                  <td class="text-nowrap">
                    <button class="btn btn-sm btn-primary btn-update-date"
                      data-id="3" data-name="Amit Kumar" data-date="2025-08-22">
                      <i class="fas fa-calendar-alt"></i> Update Date
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal fade" id="updateDateModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <form id="updateDateForm" action="<?= site_url('Admission/update_joining_date') ?>" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title"><i class="fas fa-calendar-alt"></i> Update Joining Date</h5>
                  <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="updateStudentId" name="student_id">
                  <div class="form-group">
                    <label>Student</label>
                    <input type="text" id="updateStudentName" class="form-control" readonly>
                  </div>
                  <div class="form-group">
                    <label>New Joining Date</label>
                    <input type="date" name="joining_date" id="updateJoiningDate" class="form-control" required>
                    <div class="invalid-feedback">New joining date must be after the current joining date.</div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer text-muted small">
          * Only deactivated students are shown here. Use Update Date to modify joining dates.
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const baseUrl = '<?= base_url() ?>';
  </script>

  <script>
    $(document).ready(function() {
      let feeMode = 'total';
      // 🔹 Fetch center name by ID
      function fetchCenterName(centerId, callback) {
        $.ajax({
          url: baseUrl + "Center/getCenterById/" + centerId,
          method: "GET",
          dataType: "json",
          success: function(res) {
            if (res.status === "success" && res.center) {
              callback(res.center.name);
            } else {
              callback("Unknown Center");
            }
          },
          error: function() {
            callback("Error");
          }
        });
      }

      function loadDeactiveStudents() {
        $.ajax({
          url: "<?= base_url('Admission/get_deactive_students_by_center') ?>",
          method: "GET",
          dataType: "json",
          success: function(res) {
            if (res.status === 'success') {
              $("#studentsTable tbody").html(''); // Clear table first

              res.data.forEach(student => {
                // Temporary row with center placeholder
                let rowHtml = `
            <tr data-id="${student.id}" data-name="${student.name}" data-center="" 
                data-total="${student.total_fees}" data-paid="${student.paid_amount}" data-remaining="${student.remaining_amount}"
                data-status="${student.status}" data-joining="${student.joining_date}">
              <td>${student.id}</td>
              <td>${student.name}</td>
              <td class="center-cell">Loading...</td>
              <td class="fees-cell">
                <div><span class="fees-label">Total:</span> ₹${student.total_fees}</div>
                <div><span class="fees-label">Paid:</span> ₹${student.paid_amount}</div>
                <div><span class="fees-label">Remaining:</span> ₹${student.remaining_amount}</div>
              </td>
              <td class="status-cell">
                <span class="badge badge-danger">${student.status}</span>
              </td>
              <td class="joining-cell">${student.joining_date}</td>
              <td class="text-nowrap">
                <button class="btn btn-sm btn-primary btn-update-date" 
                        data-id="${student.id}" data-name="${student.name}" data-date="${student.joining_date}">
                  <i class="fas fa-calendar-alt"></i> Update Date
                </button>
              </td>
            </tr>
          `;

                $("#studentsTable tbody").append(rowHtml);

                // 🔹 Fetch center name asynchronously
                fetchCenterName(student.center_id, function(centerName) {
                  let $tr = $(`#studentsTable tbody tr[data-id='${student.id}']`);
                  $tr.find('.center-cell').text(centerName);
                  $tr.attr('data-center', centerName);
                });
              });
            } else {
              $("#studentsTable tbody").html(`<tr><td colspan="7" class="text-center text-muted">No deactive students found</td></tr>`);
            }
          },
          error: function() {
            alert("Error fetching students data.");
          }
        });
      }

      // 🔹 Toggle Fees View
      $('#toggleFees').on('click', function() {
        feeMode = (feeMode === 'total') ? 'paid' : (feeMode === 'paid') ? 'remaining' : 'total';

        $('#studentsTable tbody tr').each(function() {
          const $row = $(this);
          $row.find('.fees-cell').html(`
        <div><span class="fees-label ${feeMode === 'total' ? 'text-primary' : ''}">Total:</span> ₹${$row.data('total')}</div>
        <div><span class="fees-label ${feeMode === 'paid' ? 'text-primary' : ''}">Paid:</span> ₹${$row.data('paid')}</div>
        <div><span class="fees-label ${feeMode === 'remaining' ? 'text-primary' : ''}">Remaining:</span> ₹${$row.data('remaining')}</div>
      `);
        });
      });

      // 🔹 Open Modal with selected student
      $(document).on('click', '.btn-update-date', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const date = $(this).data('date');

        $('#updateStudentId').val(id);
        $('#updateStudentName').val(name);
        $('#updateJoiningDate').val(date);
        $('#updateDateForm').data('current-date', date);

        $('#updateJoiningDate').removeClass('is-invalid');
        $('#updateDateModal').modal('show');
      });

      // 🔹 Validate Date Before Submit
      $('#updateDateForm').on('submit', function(e) {
        const newDate = $('#updateJoiningDate').val();
        const currentDate = $(this).data('current-date');
        if (new Date(newDate) <= new Date(currentDate)) {
          e.preventDefault();
          $('#updateJoiningDate').addClass('is-invalid');
          return false;
        } else {
          $('#updateJoiningDate').removeClass('is-invalid');
        }
      });

      // 🔹 Search Filter
      $('#tableSearch').on('input', function() {
        const q = $(this).val().toLowerCase();
        $('#studentsTable tbody tr').each(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
        });
      });

      // 🔹 Initial load
      loadDeactiveStudents();
    });



    // Sidebar toggle functionality
    $('#sidebarToggle').on('click', function() {
      if ($(window).width() <= 576) {
        $('#sidebar').toggleClass('active');
        $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
      } else {
        const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
        $('.navbar').toggleClass('sidebar-minimized', isMinimized);
        $('#contentWrapper').toggleClass('minimized', isMinimized);
      }
    });
  </script>

</body>

</html>