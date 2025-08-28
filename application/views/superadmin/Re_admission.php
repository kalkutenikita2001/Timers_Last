


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Re-Admission</title>

  <!-- Bootstrap & Icons -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
    .content-wrapper.minimized { margin-left: 60px; }
    @media (max-width: 768px) {
      .content-wrapper { margin-left: 0; padding: 80px 12px 20px 12px; }
    }

    .table thead th { white-space: nowrap; }
    .form-inline .form-control { width: 240px; }

    .card-header {
       background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
    }

    @media (max-width: 576px) {
      .form-inline,
      .d-flex.flex-sm-row {
        flex-direction: column !important;
      }

      .form-control,
      .btn {
        width: 100% !important;
      }
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
        <div class="card-header text-white d-flex flex-column flex-sm-row align-items-sm-center justify-content-between">
          <h4 class="mb-2 mb-sm-0"><i class="fas fa-user-slash"></i> Re-Admission (Deactivated Students)</h4>

          <!-- Quick search -->
          <form class="d-flex flex-column flex-sm-row gap-2" onsubmit="return false;">
            <input id="tableSearch" class="form-control form-control-sm" type="text" placeholder="Search name / batch / level"/>
          </form>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" id="studentsTable">
              <thead style="background: linear-gradient(135deg, #007bff 0%, #001f54 100%); color: #fff;">
                <tr>
                  <th style="width: 60px;">ID</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Batch</th>
                  <th>Facility</th>
                  <th>Fees</th>
                  <th>Status</th>
                  <th style="min-width: 200px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($students)): ?>
                  <?php foreach ($students as $student): ?>
                    <tr data-id="<?= htmlspecialchars($student['id']) ?>" 
                        data-name="<?= htmlspecialchars($student['name']) ?>" 
                        data-level="<?= htmlspecialchars($student['category']) ?>" 
                        data-batch="<?= htmlspecialchars($student['batch_id']) ?>" 
                        data-facility="<?= htmlspecialchars($student['facilities'] ?: 'None') ?>" 
                        data-fees="<?= htmlspecialchars($student['total_fees']) ?>" 
                        data-status="Deactive"
                        data-center_id="<?= htmlspecialchars($student['center_id']) ?>"
                        data-contact="<?= htmlspecialchars($student['contact']) ?>">
                      <td><?= htmlspecialchars($student['id']) ?></td>
                      <td><?= htmlspecialchars($student['name']) ?></td>
                      <td><?= htmlspecialchars($student['category']) ?></td>
                      <td><?= htmlspecialchars($student['batch_timing']) ?></td>
                      <td><?= htmlspecialchars($student['facilities'] ?: 'None') ?></td>
                      <td>₹<?= htmlspecialchars($student['total_fees']) ?></td>
                      <td class="status-cell">
                        <span class="badge badge-danger">Deactive</span>
                      </td>
                      <td class="text-nowrap">
                        <button type="button" class="btn btn-sm btn-success btn-open-renew">
                          <i class="fas fa-redo"></i> Re-Admit
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center">No deactivated students found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-muted small">
          * Only deactivated students are shown here. Use Re-Admit to renew admission.
        </div>
      </div>
    </div>
  </div>

  <!-- Re-Admission Modal -->
  <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="<?= site_url('admission/renew_student') ?>" method="POST" id="renewForm">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"><i class="fas fa-redo"></i> Re-Admission</h5>
            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="renewStudentId" name="id">
            <input type="hidden" id="renewNameHidden" name="name">
            <input type="hidden" id="renewContact" name="contact">
            <input type="hidden" id="renewCenter" name="center_id">

            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>Student</label>
                  <input type="text" id="renewStudentName" class="form-control" readonly>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>Previous Level</label>
                  <input type="text" id="renewCurrentLevel" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label>Previous Facilities</label>
                  <input type="text" id="renewCurrentFacilities" class="form-control" readonly>
                </div>
              </div>
            </div>

            <hr/>

            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>New Level</label>
                  <select name="category" id="renewLevel" class="form-control" required>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>Batch</label>
                  <select name="batch_id" id="renewBatch" class="form-control" required>
                    <!-- Populated via AJAX -->
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>Duration</label>
                  <select name="duration" class="form-control" required>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">1 Year</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <div class="form-group">
                  <label>Facility</label>
                  <select name="facility_type" id="renewFacility" class="form-control" required>
                    <option value="continue">Continue Existing</option>
                    <option value="new">New Facility</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row" id="newFacilities" style="display: none;">
              <div class="col-12">
                <div class="form-group">
                  <label>New Facilities</label>
                  <select multiple name="facilities[]" class="form-control">
                    <option value="Locker">Locker</option>
                    <option value="Shoe">Shoe</option>
                    <option value="Racket">Racket</option>
                  </select>
                </div>
              </div>
            </div>

            <hr/>

            <div class="row">
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label>Total Fees (₹)</label>
                  <input type="number" name="total_fees" id="renewFeesAmount" class="form-control" required min="0">
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label>Paid Amount (₹)</label>
                  <input type="number" name="paid_amount" class="form-control" required min="0">
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="form-group">
                  <label>Payment Mode</label>
                  <select name="payment_method" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Card">Card</option>
                  </select>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Confirm Re-Admission</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script>
    const base_url = '<?= base_url() ?>';

    // Client-side search
    $('#tableSearch').on('input', function () {
      const q = $(this).val().toLowerCase();
      $('#studentsTable tbody tr').each(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
      });
    });

    // Show/hide new facilities based on facility type
    $('#renewFacility').on('change', function() {
      $('#newFacilities').toggle(this.value === 'new');
    });

    // Delegate event for dynamically added buttons
    $(document).on('click', '.btn-open-renew', function () {
      const $row = $(this).closest('tr');
      $('#renewStudentId').val($row.data('id'));
      $('#renewStudentName').val($row.data('name'));
      $('#renewNameHidden').val($row.data('name'));
      $('#renewContact').val($row.data('contact'));
      $('#renewCenter').val($row.data('center_id'));
      $('#renewCurrentLevel').val($row.data('level'));
      $('#renewLevel').val($row.data('level'));
      $('#renewFeesAmount').val($row.data('fees'));
      $('#renewCurrentFacilities').val($row.data('facility'));

      const facility = $row.data('facility') === 'None' ? 'new' : 'continue';
      $('#renewFacility').val(facility);
      $('#newFacilities').toggle(facility === 'new');

      // Fetch batches for the center
      const center_id = $row.data('center_id');
      $.ajax({
        url: base_url + 'admission/get_batches/' + center_id,
        type: 'GET',
        dataType: 'json',
        success: function(batches) {
          $('#renewBatch').empty();
          if (batches.length > 0) {
            $.each(batches, function(index, batch) {
              $('#renewBatch').append('<option value="' + batch.id + '">' + batch.timing + '</option>');
            });
            $('#renewBatch').val($row.data('batch'));
          } else {
            $('#renewBatch').append('<option value="">No batches available</option>');
          }
          $('#renewModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error('Error fetching batches:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load batches. Please try again.'
          });
        }
      });
    });

    // Form submission with facilities
    $('#renewForm').on('submit', function(e) {
      e.preventDefault();

      // Validate form inputs
      const totalFees = parseFloat($('#renewFeesAmount').val());
      const paidAmount = parseFloat($('input[name="paid_amount"]').val());
      if (isNaN(totalFees) || totalFees < 0) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please enter a valid Total Fees amount.'
        });
        return;
      }
      if (isNaN(paidAmount) || paidAmount < 0) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please enter a valid Paid Amount.'
        });
        return;
      }
      if (paidAmount > totalFees) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Paid Amount cannot exceed Total Fees.'
        });
        return;
      }
      if (!$('#renewBatch').val()) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select a valid batch.'
        });
        return;
      }

      // Serialize form data
      let formData = $(this).serializeArray();
      const facilities = [];
      if ($('#renewFacility').val() === 'new') {
        $('#newFacilities select option:selected').each(function() {
          facilities.push({
            name: $(this).val(),
            details: $(this).val(),
            amount: 0
          });
        });
        // Always send facilities (empty array if none selected)
        formData.push({name: 'facilities', value: JSON.stringify(facilities.length > 0 ? facilities : [])});
      }

      console.log('Submitting form data:', formData); // Debug log

      // Submit form via AJAX
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $.param(formData),
        dataType: 'json',
        success: function(response) {
          console.log('Server response:', response); // Debug log
          if (response.success) {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Admission renewed successfully!',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              $('#renewModal').modal('hide');
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message || 'Failed to renew admission. Please check the console for details.'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('Submission error:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while renewing admission. Status: ' + xhr.status + '. Check console for details.'
          });
        }
      });
    });

    // Load deactivated students
    $(document).ready(function() {
      $.ajax({
        url: base_url + 'admission/get_deactivated_students',
        type: 'GET',
        dataType: 'json',
        success: function(students) {
          const tbody = $('#studentsTable tbody');
          tbody.empty();
          if (students.length > 0) {
            students.forEach(student => {
              const row = `
                <tr data-id="${student.id}" 
                    data-name="${student.name}" 
                    data-level="${student.category}" 
                    data-batch="${student.batch_id}" 
                    data-facility="${student.facilities || 'None'}" 
                    data-fees="${student.total_fees}" 
                    data-status="Deactive"
                    data-center_id="${student.center_id}"
                    data-contact="${student.contact}">
                  <td>${student.id}</td>
                  <td>${student.name}</td>
                  <td>${student.category}</td>
                  <td>${student.batch_timing}</td>
                  <td>${student.facilities || 'None'}</td>
                  <td>₹${student.total_fees}</td>
                  <td class="status-cell"><span class="badge badge-danger">Deactive</span></td>
                  <td class="text-nowrap">
                    <button type="button" class="btn btn-sm btn-success btn-open-renew">
                      <i class="fas fa-redo"></i> Re-Admit
                    </button>
                  </td>
                </tr>
              `;
              tbody.append(row);
            });
          } else {
            tbody.append('<tr><td colspan="8" class="text-center">No deactivated students found.</td></tr>');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error loading deactivated students:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error loading deactivated students. Status: ' + xhr.status
          });
          $('#studentsTable tbody').append('<tr><td colspan="8" class="text-center">Error loading deactivated students.</td></tr>');
        }
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');
      const contentWrapper = document.getElementById('contentWrapper');

      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
          if (window.innerWidth <= 768) {
            if (sidebar) {
              sidebar.classList.toggle('active');
              if (navbar) navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
            }
          } else {
            if (sidebar && contentWrapper) {
              const isMinimized = sidebar.classList.toggle('minimized');
              if (navbar) navbar.classList.toggle('sidebar-minimized', isMinimized);
              contentWrapper.classList.toggle('minimized', isMinimized);
            }
          }
        });
      }
    });
  </script>
</body>
</html>
