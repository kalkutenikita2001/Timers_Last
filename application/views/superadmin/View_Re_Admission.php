<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Re-Admission Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"/>
  <style>
    :root {
      --primary-color: #ff4040;
      --secondary-color: #f8f9fa;
      --accent-color: #007bff;
      --success-color: #28a745;
      --warning-color: #ffc107;
      --info-color: #17a2b8;
    }
    body {
      background-color: #f5f5f5;
      font-family: 'Montserrat', serif !important;
      overflow-x: hidden;
      min-height: 100vh;
    }
    .content-wrapper {
      margin-left: 250px;
      padding: 80px 20px 20px 20px;
      transition: margin-left 0.3s ease-in-out;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .inner-layout {
      display: flex;
      gap: 20px;
    }
    .inner-sidebar {
      width: 220px;
      padding: 15px 10px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
      position: sticky;
      top: 90px;
      height: fit-content;
    }
    .inner-sidebar .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      background: rgba(255,255,255,0.1);
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.25s ease;
    }
    .inner-sidebar .menu-item i {
      color: #ffecec;
      font-size: 16px;
      transition: color 0.25s ease;
    }
    .inner-sidebar .menu-item:hover {
      background: rgba(255,255,255,0.25);
      transform: translateX(5px);
    }
    .inner-sidebar .menu-item:hover i {
      color: #fff;
    }
    .inner-sidebar .menu-item.active {
      background: #fff;
      color: #470000;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }
    .inner-sidebar .menu-item.active i {
      color: #470000;
    }
    .details-area {
      flex: 1;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .section-content {
      display: none;
      margin-top: 15px;
    }
    .section-content.active {
      display: block;
    }
    h4 {
      font-weight: 700;
      font-size: 20px;
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 15px;
    }
    .section-title {
      font-weight: 600;
      font-size: 16px;
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      margin-bottom: 10px;
    }
    .progress-bar {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
    }
    .detail-row {
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }
    .detail-label {
      font-weight: 600;
      color: #666;
      margin-bottom: 5px;
    }
    .detail-value {
      font-size: 16px;
      color: #333;
      white-space: pre-wrap; /* Allow text wrapping for long content */
    }
    .re-admission-card {
      border: 1px solid #eee;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background: #f9f9f9;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .re-admission-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .re-admission-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .re-admission-name {
      font-weight: 600;
      color: #470000;
    }
    .re-admission-details-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 10px;
    }
    .re-admission-detail-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .re-admission-detail-item i {
      color: #ff4040;
      width: 16px;
    }
    .btn-renew {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border: none;
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 13px;
    }
    .btn-renew:hover {
      background: #300000;
      color: white;
    }
    .modal-content {
      border-radius: 10px;
      border: none;
      box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    }
    .modal-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border-radius: 10px 10px 0 0;
    }
    .modal-header .close {
      color: white;
      text-shadow: none;
      opacity: 0.8;
    }
    .modal-header .close:hover {
      opacity: 1;
    }
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(255, 64, 64, 0.25);
    }
    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 60px 12px 12px;
      }
      .inner-layout {
        flex-direction: column;
      }
      .inner-sidebar {
        width: 100%;
        position: static;
      }
      .re-admission-card {
        padding: 10px;
      }
      .re-admission-header {
        flex-direction: column;
        align-items: flex-start;
      }
      .re-admission-details-grid {
        grid-template-columns: 1fr;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
        padding: 70px 18px 18px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
      }
      .inner-sidebar {
        width: 200px;
      }
    }
  </style>
</head>
<body>
 <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>
<!-- =------------------------------------------------------------------------------------------------------------------- -->

    <!-- Main Content Wrapper -->
    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
    <div class="container mt-5">
      <div class="inner-layout">
        <!-- Inner Sidebar -->
        <div class="inner-sidebar">
          <a href="#" class="menu-item active" onclick="showSection(event, 'reAdmissionList')">
            <i class="fas fa-list"></i> Re-Admission List
          </a>
          <a href="#" class="menu-item" onclick="showSection(event, 'basicData')">
            <i class="fas fa-user"></i> Personal Details
          </a>
          <a href="#" class="menu-item" onclick="showSection(event, 'batchDetails')">
            <i class="fas fa-file-alt"></i> Batch Details
          </a>
          <a href="#" class="menu-item" onclick="showSection(event, 'feesDetails')">
            <i class="fas fa-lock"></i> Fees Details
          </a>
          <a href="#" class="menu-item" onclick="showSection(event, 'facilities')">
            <i class="fas fa-building"></i> Facilities
          </a>
          <a href="#" class="menu-item" onclick="showSection(event, 'reAdmissionForm')">
            <i class="fas fa-wallet"></i> Re-Admission
          </a>
        </div>

        <!-- Details Area -->
        <div class="details-area">
          <div class="progress-container mb-4">
            <div class="progress">
              <div id="progressBar" class="progress-bar" role="progressbar" style="width: 16.67%;">
                Step 1 of 6
              </div>
            </div>
          </div>

          <!-- Section: Re-Admission List -->
          <div class="section-content active" id="reAdmissionList">
            <h4>Re-Admission List</h4>
            <p>List of students eligible for re-admission based on expiry date.</p>
            <div class="row" id="reAdmissionCards"></div>
          </div>

          <!-- Section: Personal Details -->
          <div class="section-content" id="basicData">
            <h4>Personal Details</h4>
            <p>Student's personal information and contact details.</p>
            <div class="detail-row" id="personalDetails"></div>
            <div class="text-right mt-4">
              <button type="button" class="btn btn-secondary" onclick="navigateTo('basicData', 'reAdmissionList')">
                <i class="fas fa-arrow-left"></i> Back
              </button>
              <button type="button" class="btn btn-success next1">Next <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>

          <!-- Section: Batch Details -->
          <div class="section-content" id="batchDetails">
            <h4>Batch Details</h4>
            <p>Information about the student's current and previous batches.</p>
            <div id="batchDetailsContent"></div>
            <div class="d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-secondary back1"><i class="fas fa-arrow-left"></i> Back</button>
              <button type="button" class="btn btn-success next2">Next <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>

          <!-- Section: Fees Details -->
          <div class="section-content" id="feesDetails">
            <h4>Fees Details</h4>
            <p>Information about the student's fees, payment status, and related details.</p>
            <div id="feesDetailsContent"></div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary back2"><i class="fas fa-arrow-left"></i> Back</button>
              <button type="button" class="btn btn-success next3">Next <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>

          <!-- Section: Facilities -->
          <div class="section-content" id="facilities">
            <h4>Facilities</h4>
            <p>Information about additional facilities availed by the student.</p>
            <div id="facilitiesContent"></div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary back3"><i class="fas fa-arrow-left"></i> Back</button>
              <button type="button" class="btn btn-success next4">Next <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>

          <!-- Section: Re-Admission Form -->
          <div class="section-content" id="reAdmissionForm">
            <h4>Re-Admission</h4>
            <p>Update details for re-admission and change the student's status.</p>
            <form id="reAdmissionForm">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><i class="fas fa-user"></i> Select Student *</label>
                  <select name="student_id" class="form-control" id="studentSelect" required>
                    <option value="">-- Select Student --</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label><i class="fas fa-toggle-on"></i> Status *</label>
                  <select name="status" class="form-control" id="statusSelect" required>
                    <option value="">-- Select Status --</option>
                    <option value="Active">Active</option>
                    <option value="Deactive">Deactive</option>
                  </select>
                </div>
              </div>
              <div class="section-title mb-2"><i class="fas fa-layer-group"></i> Batch Details</div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><i class="fas fa-users"></i> Select Batch *</label>
                  <select name="batch_id" class="form-control" id="batchSelect" required>
                    <option value="">-- Select Batch --</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label><i class="fas fa-clock"></i> Duration *</label>
                  <select name="duration" id="durationSelect" class="form-control" required>
                    <option value="">-- Select Duration --</option>
                    <option value="3">3 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">1 Year</option>
                  </select>
                </div>
              </div>
              <div class="section-title mb-2"><i class="fas fa-calendar-alt"></i> Date Information</div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><i class="fas fa-calendar-plus"></i> Join Date *</label>
                  <input type="date" name="join_date" id="joinDate" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                  <label><i class="fas fa-calendar-times"></i> Expiry Date *</label>
                  <input type="date" name="expiry_date" id="expiryDate" class="form-control" readonly>
                </div>
              </div>
              <div class="section-title mb-2"><i class="fas fa-money-bill-wave"></i> Payment Details</div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><i class="fas fa-rupee-sign"></i> Total Fees (₹) *</label>
                  <input type="number" name="total_fees" id="totalFees" class="form-control" placeholder="Enter total fees" required>
                </div>
                <div class="form-group col-md-6">
                  <label><i class="fas fa-credit-card"></i> Payment Method *</label>
                  <select name="payment_method" id="paymentMethod" class="form-control" required>
                    <option value="">-- Select Payment Method --</option>
                    <option>Cash</option>
                    <option>UPI</option>
                    <option>Bank Transfer</option>
                    <option>Card</option>
                  </select>
                </div>
              </div>
              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary back4"><i class="fas fa-arrow-left"></i> Back</button>
                <button type="submit" class="btn btn-success">Save Re-Admission <i class="fas fa-check"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      let selectedStudentId = null;

      // Navigation functions
      window.showSection = function(event, sectionId) {
        event.preventDefault();
        $('.menu-item').removeClass('active');
        $(event.currentTarget).addClass('active');
        $('.section-content').removeClass('active');
        $('#' + sectionId).addClass('active');
        updateProgressBar(sectionId);
        if (sectionId === 'reAdmissionForm') {
          loadStudentOptions();
          if (selectedStudentId) {
            loadReAdmissionForm(selectedStudentId);
          }
        }
      };

      window.navigateTo = function(currentId, nextId) {
        $('.section-content').removeClass('active');
        $('#' + nextId).addClass('active');
        $('.menu-item').removeClass('active');
        $(`.menu-item[onclick*='${nextId}']`).addClass('active');
        updateProgressBar(nextId);
        if (nextId === 'reAdmissionForm') {
          loadStudentOptions();
          if (selectedStudentId) {
            loadReAdmissionForm(selectedStudentId);
          }
        }
      };

      function updateProgressBar(sectionId) {
        const progressBar = $('#progressBar');
        let step = 1;
        switch (sectionId) {
          case 'reAdmissionList': step = 1; break;
          case 'basicData': step = 2; break;
          case 'batchDetails': step = 3; break;
          case 'feesDetails': step = 4; break;
          case 'facilities': step = 5; break;
          case 'reAdmissionForm': step = 6; break;
        }
        const percentage = (step / 6) * 100;
        progressBar.css('width', percentage + '%').text(`Step ${step} of 6`);
      }

      // Load re-admission list
      function loadReAdmissions() {
        $.ajax({
          url: '<?php echo base_url('index.php/admission/get_deactivated_students'); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#reAdmissionCards').empty();
            if (response && Array.isArray(response)) {
              response.forEach(student => {
                const expiryDate = new Date(student.joining_date);
                expiryDate.setMonth(expiryDate.getMonth() + parseInt(student.duration));
                const isExpired = expiryDate < new Date();
                if (isExpired) {
                  let card = `
                    <div class="col-md-4">
                      <div class="re-admission-card">
                        <div class="re-admission-header">
                          <div class="re-admission-name">${escapeHtml(student.name)}</div>
                          <button class="btn btn-renew view-btn" data-student-id="${student.id}">View</button>
                        </div>
                        <div class="re-admission-details-grid">
                          <div class="re-admission-detail-item"><i class="fas fa-phone"></i> ${escapeHtml(student.contact || 'N/A')}</div>
                          <div class="re-admission-detail-item"><i class="fas fa-building"></i> ${escapeHtml(student.center_name || 'N/A')}</div>
                          <div class="re-admission-detail-item"><i class="fas fa-calendar-alt"></i> Expiry: ${expiryDate.toLocaleDateString()}</div>
                        </div>
                      </div>
                    </div>`;
                  $('#reAdmissionCards').append(card);
                }
              });
            } else {
              console.log('Invalid response format for re-admissions:', response);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load re-admission list. Please try again.',
                confirmButtonText: 'OK'
              });
            }
          },
          error: function(xhr) {
            console.log('Error loading re-admissions:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load re-admission list. Please check your connection or try again later.',
              confirmButtonText: 'OK'
            });
          }
        });
      }

      // Load student options for dropdown
      function loadStudentOptions() {
        $.ajax({
          url: '<?php echo base_url('index.php/admission/get_deactivated_students'); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(students) {
            $('#studentSelect').empty().append('<option value="">-- Select Student --</option>');
            if (students && Array.isArray(students)) {
              students.forEach(student => {
                $('#studentSelect').append(`<option value="${student.id}">${escapeHtml(student.name)}</option>`);
              });
              if (selectedStudentId && $('#studentSelect option[value="' + selectedStudentId + '"]').length) {
                $('#studentSelect').val(selectedStudentId);
              }
            } else {
              console.log('Invalid students response for options:', students);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load student options. Please try again.',
                confirmButtonText: 'OK'
              });
            }
          },
          error: function(xhr) {
            console.log('Error loading student options:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load student options. Please check your connection or try again later.',
              confirmButtonText: 'OK'
            });
          }
        });
      }

      // Load re-admission form data
      function loadReAdmissionForm(studentId) {
        if (!studentId || isNaN(studentId)) {
          console.log('Invalid student ID:', studentId);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid student ID selected. Please select a valid student.',
            confirmButtonText: 'OK'
          });
          selectedStudentId = null;
          $('#studentSelect').val('');
          $('#reAdmissionForm')[0].reset();
          return;
        }
        $.ajax({
          url: '<?php echo base_url('index.php/admission/get_student'); ?>/' + studentId,
          type: 'GET',
          dataType: 'json',
          success: function(student) {
            if (student && student.id) {
              selectedStudentId = student.id; // Ensure ID is updated
              $('#statusSelect').val(student.status || 'Active');
              $('#batchSelect').empty().append('<option value="">-- Select Batch --</option>');
              $.ajax({
                url: '<?php echo base_url('index.php/admission/get_batches'); ?>/' + (student.center_id || ''),
                type: 'GET',
                dataType: 'json',
                success: function(batches) {
                  if (batches && Array.isArray(batches)) {
                    batches.forEach(batch => {
                      $('#batchSelect').append(`<option value="${batch.id}">${escapeHtml(batch.timing)} (${escapeHtml(batch.category)})</option>`);
                    });
                    $('#batchSelect').val(student.batch_id || '');
                  } else {
                    console.log('Invalid batches response:', batches);
                  }
                },
                error: function(xhr) {
                  console.log('Error loading batches:', xhr.responseText);
                }
              });
              $('#durationSelect').val(student.duration || '');
              $('#joinDate').val(student.joining_date || '');
              const expiryDate = new Date(student.joining_date || new Date());
              if (student.duration) expiryDate.setMonth(expiryDate.getMonth() + parseInt(student.duration));
              $('#expiryDate').val(student.duration ? expiryDate.toISOString().split('T')[0] : '');
              $('#totalFees').val(student.total_fees || '');
              $('#paymentMethod').val(student.payment_method || '');
            } else {
              console.log('Invalid student data:', student);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No student data found for the selected ID. Please select a different student or try again.',
                confirmButtonText: 'OK'
              });
              selectedStudentId = null;
              $('#studentSelect').val('');
              $('#reAdmissionForm')[0].reset();
              loadStudentOptions(); // Retry loading options
            }
          },
          error: function(xhr) {
            console.log('Error loading student for re-admission form:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load student details. Please try again or select a different student.',
              confirmButtonText: 'OK'
            });
            selectedStudentId = null;
            $('#studentSelect').val('');
            $('#reAdmissionForm')[0].reset();
            loadStudentOptions(); // Retry loading options
          }
        });
      }

      // View student details
      $(document).on('click', '.view-btn', function() {
        selectedStudentId = $(this).data('student-id');
        if (!selectedStudentId || isNaN(selectedStudentId)) {
          console.log('Invalid student ID from button:', selectedStudentId);
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid student ID selected. Please try again.',
            confirmButtonText: 'OK'
          });
          return;
        }
        $.ajax({
          url: '<?php echo base_url('index.php/admission/get_student'); ?>/' + selectedStudentId,
          type: 'GET',
          dataType: 'json',
          success: function(student) {
            if (student && student.id) {
              selectedStudentId = student.id; // Sync ID
              $('#personalDetails').html(`
                <div class="detail-label">Name</div><div class="detail-value">${escapeHtml(student.name || 'N/A')}</div>
                <div class="detail-label">Contact</div><div class="detail-value">${escapeHtml(student.contact || 'N/A')}</div>
                <div class="detail-label">Parent Name</div><div class="detail-value">${escapeHtml(student.parent_name || 'N/A')}</div>
                <div class="detail-label">Emergency Contact</div><div class="detail-value">${escapeHtml(student.emergency_contact || 'N/A')}</div>
                <div class="detail-label">Email</div><div class="detail-value">${escapeHtml(student.email || 'N/A')}</div>
                <div class="detail-label">DOB</div><div class="detail-value">${student.dob ? new Date(student.dob).toLocaleDateString() : 'N/A'}</div>
                <div class="detail-label">Address</div><div class="detail-value">${escapeHtml(student.address || 'N/A')}</div>
              `);

              $('#batchDetailsContent').html(`
                <div class="detail-row">
                  <div class="detail-label">Center</div><div class="detail-value">${escapeHtml(student.center_name || 'N/A')}</div>
                  <div class="detail-label">Batch Timing</div><div class="detail-value">${escapeHtml(student.batch_timing || 'N/A')}</div>
                  <div class="detail-label">Category</div><div class="detail-value">${escapeHtml(student.category || 'N/A')}</div>
                </div>`);

              $('#feesDetailsContent').html(`
                <div class="detail-row">
                  <div class="detail-label">Course Fees</div><div class="detail-value">${escapeHtml(student.course_fees || '0')} ₹</div>
                  <div class="detail-label">Additional Fees</div><div class="detail-value">${escapeHtml(student.additional_fees || '0')} ₹</div>
                  <div class="detail-label">Total Fees</div><div class="detail-value">${escapeHtml(student.total_fees || '0')} ₹</div>
                  <div class="detail-label">Paid Amount</div><div class="detail-value">${escapeHtml(student.paid_amount || '0')} ₹</div>
                  <div class="detail-label">Remaining Amount</div><div class="detail-value">${escapeHtml(student.remaining_amount || '0')} ₹</div>
                  <div class="detail-label">Payment Method</div><div class="detail-value">${escapeHtml(student.payment_method || 'N/A')}</div>
                </div>`);

              $('#facilitiesContent').html('<h5>Current Facilities</h5><div class="row">' + (student.facilities || []).map(fac => `
                <div class="col-md-4">
                  <div class="facility-card">
                    <div class="facility-header"><div class="facility-name">${escapeHtml(fac.name)}</div></div>
                    <div class="facility-details-grid">
                      <div class="facility-detail-item"><i class="fas fa-info-circle"></i> ${escapeHtml(fac.details || 'N/A')}</div>
                      <div class="facility-detail-item"><i class="fas fa-rupee-sign"></i> ${escapeHtml(fac.amount || '0')} ₹</div>
                    </div>
                  </div>
                </div>`).join('') + '</div>');

              navigateTo('reAdmissionList', 'basicData');
            } else {
              console.log('Invalid student data on view:', student);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid student data retrieved. Please try again.',
                confirmButtonText: 'OK'
              });
              selectedStudentId = null;
            }
          },
          error: function(xhr) {
            console.log('Error loading student details:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load student details. Please try again.',
              confirmButtonText: 'OK'
            });
            selectedStudentId = null;
          }
        });
      });

      // Update student selection and load form
      $('#studentSelect').on('change', function() {
        selectedStudentId = $(this).val();
        if (selectedStudentId) {
          loadReAdmissionForm(selectedStudentId);
        } else {
          $('#reAdmissionForm')[0].reset();
          selectedStudentId = null;
        }
      });

      // Update expiry date
      $('#joinDate, #durationSelect').on('change', function() {
        const joinDate = new Date($('#joinDate').val());
        const duration = parseInt($('#durationSelect').val());
        if (joinDate && duration) {
          const expiryDate = new Date(joinDate);
          expiryDate.setMonth(expiryDate.getMonth() + duration);
          $('#expiryDate').val(expiryDate.toISOString().split('T')[0]);
        } else {
          $('#expiryDate').val('');
        }
      });

      // Save re-admission
      $('#reAdmissionForm').on('submit', function(e) {
        e.preventDefault();
        if (!selectedStudentId || isNaN(selectedStudentId)) {
          console.log('No valid student ID selected for save');
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Please select a valid student for re-admission.',
            confirmButtonText: 'OK'
          });
          return;
        }
        const formData = {
          student_id: selectedStudentId,
          status: $('#statusSelect').val(),
          batch_id: $('#batchSelect').val(),
          duration: $('#durationSelect').val(),
          join_date: $('#joinDate').val(),
          expiry_date: $('#expiryDate').val(),
          total_fees: $('#totalFees').val(),
          payment_method: $('#paymentMethod').val()
        };
        $.ajax({
          url: '<?php echo base_url('index.php/admission/renew_student'); ?>',
          type: 'POST',
          data: JSON.stringify(formData),
          contentType: 'application/json',
          success: function(response) {
            if (response && response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Re-admission saved successfully!',
                confirmButtonText: 'OK'
              }).then(() => {
                loadReAdmissions();
                navigateTo('reAdmissionForm', 'reAdmissionList');
                $('#reAdmissionForm')[0].reset();
                selectedStudentId = null;
                $('#studentSelect').val('');
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message || 'Failed to save re-admission. Please check the data and try again.',
                confirmButtonText: 'OK'
              });
            }
          },
          error: function(xhr) {
            console.log('Error saving re-admission:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while saving: ' + (xhr.responseJSON ? xhr.responseJSON.message : xhr.statusText),
              confirmButtonText: 'OK'
            });
          }
        });
      });

      // Navigation buttons
      $('.next1').on('click', function() { navigateTo('basicData', 'batchDetails'); });
      $('.back1').on('click', function() { navigateTo('batchDetails', 'basicData'); });
      $('.next2').on('click', function() { navigateTo('batchDetails', 'feesDetails'); });
      $('.back2').on('click', function() { navigateTo('feesDetails', 'batchDetails'); });
      $('.next3').on('click', function() { navigateTo('feesDetails', 'facilities'); });
      $('.back3').on('click', function() { navigateTo('facilities', 'feesDetails'); });
      $('.next4').on('click', function() { navigateTo('facilities', 'reAdmissionForm'); });
      $('.back4').on('click', function() { navigateTo('reAdmissionForm', 'facilities'); });

      // Initialize
      loadReAdmissions();

      // HTML escaping function to prevent rendering issues
      function escapeHtml(unsafe) {
        return unsafe
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
      }
    });

    // --------------------------------------------------------------------------------------------------
  </script>
   <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const navbar = document.querySelector('.navbar');
            const contentWrapper = document.getElementById('contentWrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle('active');
                        navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                    } else {
                        const isMinimized = sidebar.classList.toggle('minimized');
                        navbar.classList.toggle('sidebar-minimized', isMinimized);
                        contentWrapper.classList.toggle('minimized', isMinimized);
                    }
                });
            }
        });
    </script>
    <!-- ------------------------------------------------------------------------------------------------------------------ -->
</body>
</html>