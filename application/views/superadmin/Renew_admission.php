<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student List</title>

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
      min-height: 100vh;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .navbar {
      transition: margin-left 0.3s ease-in-out;
    }
    .navbar.sidebar-hidden {
      margin-left: 0;
    }
    .table thead th {
      white-space: nowrap;
      font-size: 0.9rem;
    }
    .form-inline .form-control {
      width: 100%;
      max-width: 240px;
    }
    .card-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
    }
    .table-responsive {
      overflow-x: auto;
    }
    .table {
      width: 100%;
      table-layout: auto;
    }
    .modal-dialog {
      max-width: 90%;
      margin: 1.75rem auto;
    }
    .modal-content {
      border-radius: 0.5rem;
    }
    .btn-sm {
      font-size: 0.8rem;
      padding: 0.4rem 0.8rem;
    }
    .badge {
      font-size: 0.85rem;
    }
    .btn-block-xs {
      display: inline-block;
      margin-right: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .content-wrapper {
        margin-left: 0;
        padding: 70px 15px 15px 15px;
      }
      .content-wrapper.minimized {
        margin-left: 0;
      }
      .form-inline .form-control {
        max-width: 200px;
      }
      .table thead th {
        font-size: 0.85rem;
      }
      .modal-dialog {
        max-width: 95%;
      }
    }

    @media (max-width: 768px) {
      .content-wrapper {
        padding: 60px 10px 10px 10px;
      }
      .form-inline {
        width: 100%;
        justify-content: center;
      }
      .form-inline .form-control {
        width: 100%;
        max-width: none;
        margin-bottom: 10px;
      }
      .card-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .card-header h4 {
        margin-bottom: 10px;
      }
      .table {
        display: block;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
      }
      .table thead {
        display: none;
      }
      .table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border-bottom: 1px solid #dee2e6;
      }
      .table tbody td {
        display: block;
        text-align: left;
        padding: 0.5rem;
        border: none;
        position: relative;
        font-size: 0.9rem;
      }
      .table tbody td:before {
        content: attr(data-label);
        font-weight: bold;
        display: inline-block;
        width: 40%;
        padding-right: 10px;
      }
      .table tbody td.text-nowrap {
        text-align: center;
      }
      .modal-body .row {
        flex-direction: column;
      }
      .modal-body .col-md-6,
      .modal-body .col-md-4,
      .modal-body .col-md-12 {
        width: 100%;
        margin-bottom: 1rem;
      }
      .btn-sm {
        width: 100%;
        margin-bottom: 0.5rem;
      }
      .btn-block-xs {
        display: block;
        margin-right: 0;
      }
    }

    @media (max-width: 576px) {
      .content-wrapper {
        padding: 50px 8px 8px 8px;
      }
      .card-header h4 {
        font-size: 1.2rem;
      }
      .table tbody td {
        font-size: 0.85rem;
      }
      .modal-title {
        font-size: 1.1rem;
      }
      .modal-footer .btn {
        width: 100%;
        margin-bottom: 0.5rem;
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
        <div class="card-header text-white d-flex align-items-center justify-content-between">
          <h4 class="mb-0"><i class="fas fa-users"></i> Student List</h4>
          <form class="form-inline" onsubmit="return false;">
            <input id="tableSearch" class="form-control form-control-sm" type="text" placeholder="Search name / batch / level"/>
          </form>
        </div>

        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0" id="studentsTable">
              <thead style="background: linear-gradient(135deg, #ff4040 0%, #470000 100%); color: #fff;">
                <tr>
                  <th style="width: 60px;">ID</th>
                  <th>Name</th>
                  <th>Level</th>
                  <th>Batch</th>
                  <th>Facility</th>
                  <th>Fees</th>
                  <th>Status</th>
                  <th style="min-width: 260px;">Action</th>
                </tr>
              </thead>
              <tbody>
                <!-- Populated dynamically via JavaScript -->
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer text-muted small">
          * Students with expired admissions or absent for 5+ days are marked Deactive.
        </div>
      </div>
    </div>
  </div>

  <!-- Renew Admission Modal -->
  <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form id="renewForm" method="POST">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="renewModalLabel"><i class="fas fa-redo"></i> Renew Admission</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="renewStudentId" name="student_id">
            <input type="hidden" id="renewNameHidden" name="name">
            <input type="hidden" id="renewContact" name="contact">
            <input type="hidden" id="renewCenter" name="center_id">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>Student</label>
                  <input type="text" id="renewStudentName" class="form-control" readonly>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>Current Level</label>
                  <input type="text" id="renewCurrentLevel" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-2">
                  <label>Current Facilities</label>
                  <input type="text" id="renewCurrentFacilities" class="form-control" readonly>
                </div>
              </div>
            </div>

            <hr/>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>New Level</label>
                  <select name="level" id="renewLevel" class="form-control" required>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>Batch</label>
                  <select name="batch_id" id="renewBatch" class="form-control" required>
                    <!-- Populated via AJAX -->
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>Duration</label>
                  <select name="duration" id="renewDuration" class="form-control" required>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">1 Year</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-2">
                  <label>Facility</label>
                  <select name="facility_type" id="renewFacility" class="form-control" required>
                    <option value="continue">Continue Existing Facility</option>
                    <option value="new">New Facility</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row" id="newFacilities" style="display: none;">
              <div class="col-md-12">
                <div class="form-group mb-2">
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
              <div class="col-md-4">
                <div class="form-group mb-2">
                  <label>Fees Amount (₹)</label>
                  <input type="number" id="renewFeesAmount" name="fees_amount" class="form-control" min="0" step="0.01" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group mb-2">
                  <label>Paid Amount (₹)</label>
                  <input type="number" name="paid_amount" class="form-control" min="0" step="0.01" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group mb-2">
                  <label>Payment Mode</label>
                  <select name="payment_mode" id="renewPaymentMode" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="UPI">UPI</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                    <option value="Card">Card</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group mb-2">
                  <label>Receipt No.</label>
                  <input type="text" id="renewReceipt" name="receipt_no" class="form-control" readonly value="RCPT<?= time(); ?>">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-save"></i> Generate Receipt
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
              <i class="fas fa-times"></i> Cancel
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- View Student Modal -->
  <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="viewModalLabel"><i class="fas fa-user"></i> Student Details</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Name</strong></label>
                <p id="viewName"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Contact</strong></label>
                <p id="viewContact"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Level</strong></label>
                <p id="viewLevel"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Batch</strong></label>
                <p id="viewBatch"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Facility</strong></label>
                <p id="viewFacility"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Fees</strong></label>
                <p id="viewFees"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Status</strong></label>
                <p id="viewStatus"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Joining Date</strong></label>
                <p id="viewJoiningDate"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Parent Name</strong></label>
                <p id="viewParentName"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Emergency Contact</strong></label>
                <p id="viewEmergencyContact"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Email</strong></label>
                <p id="viewEmail"></p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><strong>Date of Birth</strong></label>
                <p id="viewDob"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><strong>Address</strong></label>
                <p id="viewAddress"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fas fa-times"></i> Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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

    // Load students dynamically
    $(document).ready(function() {
      $.ajax({
        url: base_url + 'admission/get_students',
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
                    data-batch-timing="${student.batch_timing}" 
                    data-facility="${student.facilities || 'None'}" 
                    data-fees="${student.total_fees}" 
                    data-status="${student.status}"
                    data-center_id="${student.center_id}"
                    data-contact="${student.contact}"
                    data-parent_name="${student.parent_name || ''}"
                    data-emergency_contact="${student.emergency_contact || ''}"
                    data-email="${student.email || ''}"
                    data-dob="${student.dob || ''}"
                    data-address="${student.address || ''}"
                    data-joining_date="${student.joining_date}">
                  <td data-label="ID">${student.id}</td>
                  <td data-label="Name">${student.name}</td>
                  <td data-label="Level">${student.category}</td>
                  <td data-label="Batch">${student.batch_timing}</td>
                  <td data-label="Facility">${student.facilities || 'None'}</td>
                  <td data-label="Fees">₹${student.total_fees}</td>
                  <td data-label="Status" class="status-cell">
                    <span class="badge ${student.status === 'Active' ? 'badge-success' : 'badge-danger'}">${student.status}</span>
                  </td>
                  <td data-label="Action" class="text-nowrap">
                    <button type="button" class="btn btn-sm btn-info btn-view-student">
                      <i class="fas fa-eye"></i> View
                    </button>
                    <button type="button" class="btn btn-sm btn-success btn-open-renew btn-block-xs">
                      <i class="fas fa-redo"></i> Renew
                    </button>
                    <button type="button" class="btn btn-sm ${student.status === 'Active' ? 'btn-secondary' : 'btn-success'} btn-toggle-status btn-block-xs">
                      <i class="fas ${student.status === 'Active' ? 'fa-toggle-on' : 'fa-toggle-off'}"></i> ${student.status === 'Active' ? 'Deactivate' : 'Activate'}
                    </button>
                  </td>
                </tr>
              `;
              tbody.append(row);
            });
          } else {
            tbody.append('<tr><td colspan="8" class="text-center">No students found.</td></tr>');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error loading students:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error loading students. Status: ' + xhr.status
          });
          $('#studentsTable tbody').append('<tr><td colspan="8" class="text-center">Error loading students.</td></tr>');
        }
      });
    });

    // View student details
    $(document).on('click', '.btn-view-student', function() {
      const $row = $(this).closest('tr');
      const student_id = $row.data('id');

      $.ajax({
        url: base_url + 'admission/get_student/' + student_id,
        type: 'GET',
        dataType: 'json',
        success: function(student) {
          $('#viewName').text(student.name || '-');
          $('#viewContact').text(student.contact || '-');
          $('#viewLevel').text(student.category || '-');
          $('#viewBatch').text(student.batch_timing || '-');
          $('#viewFacility').text(student.facilities ? student.facilities.map(f => f.name).join(', ') : 'None');
          $('#viewFees').text('₹' + student.total_fees || '-');
          $('#viewStatus').text(student.status || '-');
          $('#viewJoiningDate').text(student.joining_date || '-');
          $('#viewParentName').text(student.parent_name || '-');
          $('#viewEmergencyContact').text(student.emergency_contact || '-');
          $('#viewEmail').text(student.email || '-');
          $('#viewDob').text(student.dob || '-');
          $('#viewAddress').text(student.address || '-');
          $('#viewModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error('Error fetching student details:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load student details. Please try again.'
          });
        }
      });
    });

    // Open Renew Modal with row data
    $(document).on('click', '.btn-open-renew', function() {
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

    // Toggle facility visibility
    $('#renewFacility').on('change', function() {
      $('#newFacilities').toggle(this.value === 'new');
    });

    // Toggle status
    $(document).on('click', '.btn-toggle-status', function() {
      const $row = $(this).closest('tr');
      const student_id = $row.data('id');
      const $badge = $row.find('.status-cell .badge');
      const isActive = $badge.hasClass('badge-success');

      $.ajax({
        url: base_url + 'admission/toggle_status/' + student_id,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            $badge.removeClass('badge-success badge-danger')
                  .addClass(response.status === 'Active' ? 'badge-success' : 'badge-danger')
                  .text(response.status);
            $row.data('status', response.status);
            $(this).removeClass('btn-success btn-secondary')
                   .addClass(response.status === 'Active' ? 'btn-secondary' : 'btn-success')
                   .html(`<i class="fas ${response.status === 'Active' ? 'fa-toggle-on' : 'fa-toggle-off'}"></i> ${response.status === 'Active' ? 'Deactivate' : 'Activate'}`);
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message,
              showConfirmButton: false,
              timer: 1500
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: response.message
            });
          }
        }.bind(this),
        error: function(xhr, status, error) {
          console.error('Error toggling status:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to toggle status. Please try again.'
          });
        }
      });
    });

    // Renew form submission
    $('#renewForm').on('submit', function(e) {
      e.preventDefault();

      const totalFees = parseFloat($('#renewFeesAmount').val());
      const paidAmount = parseFloat($('input[name="paid_amount"]').val());
      const batch = $('#renewBatch').val();
      const level = $('#renewLevel').val();
      const duration = $('#renewDuration').val();
      const facilityType = $('#renewFacility').val();
      const facilities = facilityType === 'new' ? $('select[name="facilities[]"]').val() : [];
      const studentId = $('#renewStudentId').val(); // Ensure student ID is captured

      // Validate student ID
      if (!studentId) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Student ID is missing. Please try again.'
        });
        return;
      }

      if (!level) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select a valid level.'
        });
        return;
      }
      if (!batch) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select a valid batch.'
        });
        return;
      }
      if (!duration) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select a valid duration.'
        });
        return;
      }
      if (!facilityType) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select a valid facility type.'
        });
        return;
      }
      if (facilityType === 'new' && facilities.length === 0) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please select at least one facility for new facility type.'
        });
        return;
      }
      if (isNaN(totalFees) || totalFees <= 0) {
        Swal.fire({
          icon: 'error',
          title: 'Invalid Input',
          text: 'Please enter a valid Fees Amount greater than 0.'
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
          text: 'Paid Amount cannot exceed Fees Amount.'
        });
        return;
      }

      let formData = $(this).serializeArray();
      if (facilityType === 'new') {
        const facilitiesData = facilities.map(facility => ({
          name: facility,
          details: facility,
          amount: 0
        }));
        formData.push({name: 'facilities', value: JSON.stringify(facilitiesData)});
      } else {
        formData.push({name: 'facilities', value: JSON.stringify([])});
      }

      // Ensure student_id is included in form data
      formData.push({name: 'student_id', value: studentId});

      $.ajax({
        url: base_url + 'admission/renew_student',
        type: 'POST',
        data: $.param(formData),
        dataType: 'json',
        success: function(response) {
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
              text: response.message || 'Failed to renew admission.'
            });
          }
        },
        error: function(xhr, status, error) {
          console.error('Submission error:', error, xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while renewing admission.'
          });
        }
      });
    });

    // Sidebar toggle
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