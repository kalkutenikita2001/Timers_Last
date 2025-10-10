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
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
  <?php $this->load->view('superadmin/Include/Sidebar') ?>

  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

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
          <!-- Success message -->
          <div id="successMsg" class="alert alert-success text-center" style="display:none; margin:10px;">Date updated successfully.</div>
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
                <!-- Table rows will be loaded by JS -->
              </tbody>
            </table>
          </div>
          <!-- Pagination controls -->
          <div class="d-flex justify-content-between align-items-center p-2">
            <small id="paginationInfo" class="text-muted"></small>
            <nav>
              <ul class="pagination pagination-sm mb-0" id="paginationControls"></ul>
            </nav>
          </div>

        </div>

        <div class="modal fade" id="updateDateModal" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <form id="updateDateForm" action="<?= site_url('Admission/update_joining_date') ?>" method="POST">
                <div class="modal-header">
                  <h5 class="modal-title"><i class="fas fa-calendar-alt"></i> Update Joining Date</h5>
                  <button type="button" class="close text-white" id="closeModalBtn"><span>&times;</span></button>
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
                  <button type="button" class="btn btn-secondary" id="cancelModalBtn"><i class="fas fa-times"></i> Cancel</button>
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
      let studentsData = [];
      let currentPage = 1;
      const pageSize = 5;

      // Fetch center name by ID
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

      // Render table rows for current page
      function renderTable(page, filter = "") {
        let filtered = studentsData;
        if (filter) {
          filtered = studentsData.filter(student => {
            return (
              student.name.toLowerCase().includes(filter) ||
              (student.center_name && student.center_name.toLowerCase().includes(filter)) ||
              String(student.id).includes(filter)
            );
          });
        }
        const start = (page - 1) * pageSize;
        const end = start + pageSize;
        const pageData = filtered.slice(start, end);
        $("#studentsTable tbody").html("");
        if (pageData.length === 0) {
          $("#studentsTable tbody").html(`<tr><td colspan="7" class="text-center text-muted">No deactive students found</td></tr>`);
          return;
        }
        pageData.forEach(student => {
          let rowHtml = `
        <tr data-id="${student.id}" data-name="${student.name}" data-center="${student.center_name || ''}"
            data-total="${student.total_fees}" data-paid="${student.paid_amount}" data-remaining="${student.remaining_amount}"
            data-status="${student.status}" data-joining="${student.joining_date}">
          <td>${student.id}</td>
          <td>${student.name}</td>
          <td class="center-cell">${student.center_name || 'Loading...'}</td>
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
        });
        // Fetch center names for rows that need it
        pageData.forEach(student => {
          if (!student.center_name && student.center_id) {
            fetchCenterName(student.center_id, function(centerName) {
              student.center_name = centerName;
              let $tr = $(`#studentsTable tbody tr[data-id='${student.id}']`);
              $tr.find('.center-cell').text(centerName);
              $tr.attr('data-center', centerName);
            });
          }
        });
      }

      // Render pagination controls
      function renderPagination(page, filter = "") {
        let filtered = studentsData;
        if (filter) {
          filtered = studentsData.filter(student => {
            return (
              student.name.toLowerCase().includes(filter) ||
              (student.center_name && student.center_name.toLowerCase().includes(filter)) ||
              String(student.id).includes(filter)
            );
          });
        }
        const totalPages = Math.ceil(filtered.length / pageSize);
        let html = "";
        if (totalPages <= 1) {
          $("#pagination").html("");
          return;
        }
        html += `<li class="page-item${page === 1 ? ' disabled' : ''}"><a class="page-link" href="#" data-page="${page-1}">Previous</a></li>`;
        for (let i = 1; i <= totalPages; i++) {
          html += `<li class="page-item${page === i ? ' active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
        }
        html += `<li class="page-item${page === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" data-page="${page+1}">Next</a></li>`;
        $("#pagination").html(html);
      }

      // Load students data
      function loadDeactiveStudents() {
        $.ajax({
          url: "<?= base_url('Admission/get_deactive_students') ?>",
          method: "GET",
          dataType: "json",
          success: function(res) {
            if (res.status === 'success') {
              studentsData = res.data.map(student => ({
                ...student,
                center_name: null
              }));
              currentPage = 1;
              renderTable(currentPage);
              renderPagination(currentPage);
            } else {
              studentsData = [];
              renderTable(currentPage);
              renderPagination(currentPage);
            }
          },
          error: function() {
            alert("Error fetching students data.");
          }
        });
      }

      // Pagination click
      $(document).on('click', '#pagination .page-link', function(e) {
        e.preventDefault();
        const page = parseInt($(this).data('page'));
        if (!isNaN(page) && page > 0) {
          currentPage = page;
          const filter = $('#tableSearch').val().toLowerCase();
          renderTable(currentPage, filter);
          renderPagination(currentPage, filter);
        }
      });

      // Toggle Fees View
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

      // Open Modal with selected student
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

      // Validate Date Before Submit & AJAX submit
      $('#updateDateForm').on('submit', function(e) {
        e.preventDefault();
        const newDate = $('#updateJoiningDate').val();
        const currentDate = $(this).data('current-date');
        const studentId = $('#updateStudentId').val();
        if (new Date(newDate) <= new Date(currentDate)) {
          $('#updateJoiningDate').addClass('is-invalid');
          return false;
        } else {
          $('#updateJoiningDate').removeClass('is-invalid');
        }
        // AJAX submit
        $.ajax({
          url: $(this).attr('action'),
          method: 'POST',
          data: {
            student_id: studentId,
            joining_date: newDate
          },
          dataType: 'json',
          success: function(res) {
            if (res.status === 'success') {
              $('#updateDateModal').modal('hide');
              Swal.fire({
                icon: 'success',
                title: 'Date updated successfully',
                showConfirmButton: false,
                timer: 1800
              });
              loadDeactiveStudents();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Failed to update date',
                text: res.message || '',
                timer: 2000
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error updating date',
              timer: 2000
            });
          }
        });
      });

      // Cancel & Close modal buttons
      $('#cancelModalBtn, #closeModalBtn').on('click', function() {
        $('#updateDateModal').modal('hide');
      });

      // Search Filter
      $('#tableSearch').on('input', function() {
        const q = $(this).val().toLowerCase();
        currentPage = 1;
        renderTable(currentPage, q);
        renderPagination(currentPage, q);
      });

      // Initial load
      loadDeactiveStudents();

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
    });
  </script>

</body>

</html>