<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Salary Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets/'); ?>Images/timeersbadmintonacademy_logo.jpg">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Your existing CSS styles remain the same -->
  <style>
    /* ... Keep all your existing CSS styles exactly as they are ... */
    :root{
      --accent:#ff4040; 
      --accent-dark:#470000;
      --muted:#f4f6f8;
      --grad:linear-gradient(135deg, var(--accent), var(--accent-dark));
      --success-light:#e8f5e8;
      --warning-light:#fff7e6;
      --sidebar-width:250px;
    }

    html, body { width:100%; max-width:100%; overflow-x:hidden; }
    body{ background:var(--muted); color:#111; font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial; }

    #main-content{ margin-left:var(--sidebar-width); width:calc(100vw - var(--sidebar-width)); padding:20px; min-height:100vh; transition:.25s; }
    #main-content.minimized{ margin-left:60px; width:calc(100vw - 60px); }
    @media (max-width:991.98px){ #main-content{ margin-left:0!important; width:100vw; padding:12px; } }

    .page-hero{ 
      border-radius:16px; 
      border:1px solid #ffe1e1;
      background: radial-gradient(1000px 320px at -10% -20%, rgba(255,64,64,.22), transparent),
                  radial-gradient(800px 260px at 110% 0%, rgba(71,0,0,.18), transparent),
                  linear-gradient(90deg, #fff, #fff6f6);
      box-shadow:0 16px 40px rgba(255,64,64,.08);
      padding:14px 16px;
      overflow:hidden;
    }
    .page-title{ font-weight:800; letter-spacing:.2px; }

    .toolbar{ 
      position:sticky; 
      top:12px; 
      z-index:5; 
      background:#fff; 
      border:1px solid #e9ecef; 
      border-radius:12px; 
      padding:10px; 
      box-shadow:0 8px 24px rgba(0,0,0,.05); 
      overflow:hidden; 
    }
    .btn-ghost{ border:1px solid #e9ecef; background:#fff; }
    .btn-ghost:hover{ background:#f8f8f8; }
    .btn-primary{ background:var(--grad); border:0; font-weight:700; }
    .btn-primary:hover{ filter:brightness(.96); }

    .global-search{ max-width:660px; margin:0 auto; transition:all .25s ease; }
    .global-search .form-control{ height:42px; border-radius:50px; font-size:.9rem; padding-left:.5rem; border-color:#e3e3e3; }
    .global-search .input-group-text{ border-radius:50px 0 0 50px; background:#fff; border-color:#e3e3e3; }
    .global-search .form-control:focus{ border-color:var(--accent); box-shadow:0 0 0 3px rgba(255,64,64,.2); }

    .card-lite{ background:#fff; border-radius:14px; border:1px solid #e9ecef; box-shadow:0 6px 20px rgba(0,0,0,.05); overflow:hidden; }
    .table{ width:100%; }
    .table thead th{ position:sticky; top:0; background:#fff; z-index:2; }
    .table-hover tbody tr:hover{ background:rgba(255,64,64,.035); }

    .action-icons .btn-icon{ 
      border:none; 
      background:transparent; 
      padding:6px; 
      margin:0 2px; 
      font-size:18px; 
      color:#dc3545; 
      transition: all 0.2s ease;
      border-radius: 4px;
    }
    .action-icons .btn-icon:hover{ 
      transform:scale(1.12); 
      color:#b71c1c; 
      background: rgba(255,64,64,0.1);
    }

    .mark-paid.disabled {
      opacity: 0.5;
      pointer-events: none;
      cursor: not-allowed;
    }
    .mark-paid.disabled i {
      color: #6c757d !important;
    }
    .mark-paid.disabled:hover {
      transform: none !important;
      color: #6c757d !important;
      background: transparent !important;
    }

    .badge-soft{ background:#fff; border:1px solid #e9ecef; padding:.35rem .6rem; border-radius:999px; }
    
    .badge.text-bg-success {
      animation: pulse-success 2s infinite;
    }
    @keyframes pulse-success {
      0%, 100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
      50% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    }

    .overview-card {
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.2s ease;
    }
    .overview-card:hover {
      transform: translateY(-2px);
    }
    .overview-card.bg-success {
      background: var(--success-light);
      color: #155724;
    }
    .overview-card.bg-success .card-body {
      background: var(--success-light);
    }
    .overview-card.bg-warning {
      background: var(--warning-light);
      color: #664d03;
    }
    .overview-card.bg-warning .card-body {
      background: var(--warning-light);
    }
    .overview-card .card-body {
      padding: 15px;
    }

    .swal2-confirm{ background:var(--accent)!important; border:0!important; }
    .swal2-cancel{ background:#6c757d!important; border:0!important; }
  </style>
</head>
<body>

  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div id="main-content" class="container-fluid">
    <!-- Hero with Overview Button -->
    <div class="page-hero mb-3">
      <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
        <div class="page-title h5 mb-0">
          <i class="fa-solid fa-sack-dollar me-2"></i>
          Salary Management
        </div>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-primary" id="salaryOverviewBtn">
            <i class="fa-solid fa-chart-line me-1"></i>Salary Overview
          </button>
          <button class="btn btn-ghost" id="assignSalaryBtn">
            <i class="fa-solid fa-sack-dollar me-1"></i>Assign Salary
          </button>
        </div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar mb-3">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="flex-grow-1">
          <div class="input-group global-search">
            <span class="input-group-text bg-white border-end-0">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input id="searchInput" type="text" class="form-control border-start-0" placeholder="Search by staff, status or amount...">
          </div>
        </div>
        <span class="badge-soft">
          Total <b id="rowCount">0</b>
        </span>
      </div>
    </div>

    <!-- Loading indicator -->
    <div id="loadingSpinner" class="text-center py-4" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2">Loading salary records...</p>
    </div>

    <!-- Table card -->
    <div class="card-lite p-2">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="salaryTable">
          <thead>
            <tr>
              <th style="width:72px">Sr No</th>
              <th>Staff Name</th>
              <th>Hours</th>
              <th>Days</th>
              <th>Sessions</th>
              <th>Rate</th>
              <th>Salary</th>
              <th>Status</th>
              <th class="text-center" style="width:200px">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic content loaded by JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- KEEP YOUR SIDEBAR CONTROLLER SCRIPT AS IS -->
  <script>
  // Your existing sidebar controller script stays exactly the same
  (function () {
    // ... Keep all your sidebar code unchanged ...
  })();
  </script>

  <!-- REPLACED: New Backend-Integrated Salary Management Script -->
  <script>
  $(function(){
    // Load salary records on page load
    loadSalaryRecords();

    // Backend API functions
    function loadSalaryRecords() {
      $('#loadingSpinner').show();
      $('#salaryTable tbody').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');
      
      $.ajax({
        url: '<?php echo base_url("staffsalary/get_salary_records"); ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          $('#loadingSpinner').hide();
          const tbody = $('#salaryTable tbody');
          tbody.empty();
          
          if (response.success && response.data.length === 0) {
            tbody.html(`
              <tr>
                <td colspan="9" class="text-center text-muted py-4">
                  <i class="fa-solid fa-users fa-2x mb-2 opacity-50"></i><br>
                  No staff salary records found.<br>
                  <small>Add staff from <strong>Staff Management</strong> page first.</small>
                </td>
              </tr>
            `);
          } else if (response.success) {
            response.data.forEach((record, index) => {
              const isPaid = (record.status || '').toLowerCase() === 'paid';
              const markPaidClass = isPaid ? 'mark-paid disabled' : 'mark-paid';
              const paidAt = record.paid_at_formatted || '';
              
              const rowHtml = `
                <tr data-staff-id="${record.staff_id}" data-sr-no="${record.sr_no || ''}" data-paid-at="${paidAt}">
                  <td>${index + 1}</td>
                  <td>
                    <strong>${escapeHtml(record.name || 'N/A')}</strong>
                    ${isPaid ? '<i class="fa-solid fa-check-circle text-success ms-1"></i>' : ''}
                  </td>
                  <td>${record.hours_worked || '0'}</td>
                  <td>${record.days_present || '0'}</td>
                  <td>${record.sessions || '0'}</td>
                  <td>${record.hourly_rate_formatted || '₹0'}</td>
                  <td class="fw-bold text-success">${record.total_salary_formatted || '₹0'}</td>
                  <td>
                    <span class="badge ${getStatusClass(record.status)}">
                      ${record.status || 'Pending'}
                    </span>
                    ${isPaid && paidAt ? `<br><small class="text-muted">${paidAt}</small>` : ''}
                  </td>
                  <td class="text-center action-icons">
                    <button class="btn-icon delete-salary" title="Delete Salary" data-staff-id="${record.staff_id}">
                      <i class="fa-solid fa-trash text-danger"></i>
                    </button>
                    <button class="btn-icon view-salary" title="View Details" data-staff-id="${record.staff_id}">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="btn-icon ${markPaidClass}" 
                            title="${isPaid ? 'Already Paid' : 'Mark as Paid'}" 
                            data-staff-id="${record.staff_id}" 
                            ${isPaid ? 'disabled' : ''}>
                      <i class="fa-solid fa-sack-dollar"></i>
                    </button>
                  </td>
                </tr>`;
              tbody.append(rowHtml);
            });
          } else {
            tbody.html(`
              <tr>
                <td colspan="9" class="text-center text-danger py-4">
                  <i class="fa-solid fa-exclamation-triangle fa-2x mb-2"></i><br>
                  Error loading salary records: ${response.message || 'Unknown error'}
                </td>
              </tr>
            `);
          }
          updateRowCount();
        },
        error: function(xhr, status, error) {
          $('#loadingSpinner').hide();
          $('#salaryTable tbody').html(`
            <tr>
              <td colspan="9" class="text-center text-danger py-4">
                <i class="fa-solid fa-exclamation-triangle fa-2x mb-2"></i><br>
                Failed to load data. Please check console for details.<br>
                <small>Error: ${error}</small>
              </td>
            </tr>
          `);
          console.error('AJAX Error:', xhr.responseText);
          updateRowCount();
        }
      });
    }

    function getStatusClass(status) {
      switch((status || '').toLowerCase()) {
        case 'paid': return 'text-bg-success';
        case 'pending': return 'text-bg-warning';
        default: return 'text-bg-secondary';
      }
    }

    function updateRowCount() {
      $('#rowCount').text($('#salaryTable tbody tr:visible').length || 0);
    }

    function escapeHtml(unsafe) {
      if (unsafe === null || unsafe === undefined) return '';
      return String(unsafe)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
    }

    // Search functionality
    $('#searchInput').on('input', function(){
      const q = $(this).val().toLowerCase();
      $('#salaryTable tbody tr').each(function(){
        const hit = $(this).text().toLowerCase().indexOf(q) > -1;
        $(this).toggle(hit);
      });
      updateRowCount();
    });

    // Delete salary record
    $(document).on('click', '.delete-salary', function(){
      const staffId = parseInt($(this).data('staff-id'));
      const staffName = $(this).closest('tr').find('td:eq(1)').text().trim();
      
      Swal.fire({ 
        title: 'Delete Salary Record?',
        html: `<strong>${escapeHtml(staffName)}</strong>'s salary record will be permanently deleted.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#dc3545',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if(result.isConfirmed){
          $.ajax({
            url: '<?php echo base_url("staffsalary/delete_salary_record"); ?>',
            type: 'POST',
            data: { staff_id: staffId },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                loadSalaryRecords();
                Swal.fire('Deleted!', 'Salary record deleted successfully.', 'success');
              } else {
                Swal.fire('Error', response.message || 'Failed to delete record', 'error');
              }
            },
            error: function() {
              Swal.fire('Error', 'Failed to delete record.', 'error');
            }
          });
        }
      });
    });

    // Mark as Paid - Backend Integration
    $(document).on('click', '.mark-paid:not(.disabled)', function(){
      const staffId = parseInt($(this).data('staff-id'));
      const staffName = $(this).closest('tr').find('td:eq(1)').text().trim();
      const row = $(this).closest('tr');
      
      const currentHours = parseInt(row.find('td:eq(2)').text()) || 0;
      const currentDays = parseInt(row.find('td:eq(3)').text()) || 0;
      const currentSessions = parseInt(row.find('td:eq(4)').text()) || 0;
      const currentRate = parseFloat(row.find('td:eq(5)').text().replace(/[₹,]/g,'')) || 0;
      const currentSalary = parseFloat(row.find('td:eq(6)').text().replace(/[₹,]/g,'')) || 0;
      
      Swal.fire({
        title: `<h4 class="text-success mb-3">
                  <i class="fa-solid fa-sack-dollar me-2"></i>
                  Finalize Payment - ${escapeHtml(staffName)}
                </h4>`,
        html: `
          <div class="text-start p-3 bg-light rounded">
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label fw-bold">Hours Worked</label>
                <input type="number" id="editHours" class="form-control" value="${currentHours}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">Days Present</label>
                <input type="number" id="editDays" class="form-control" value="${currentDays}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">Sessions</label>
                <input type="number" id="editSessions" class="form-control" value="${currentSessions}" min="0" />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold">Hourly Rate (₹)</label>
                <input type="number" id="editRate" class="form-control" step="0.01" value="${currentRate}" min="0" />
              </div>
              <div class="col-12">
                <label class="form-label fw-bold text-success">Total Salary (₹)</label>
                <input type="number" id="editSalary" class="form-control border-success" step="0.01" value="${currentSalary}" min="1" />
                <small class="text-muted">Final amount to be paid this month</small>
              </div>
            </div>
            <div class="alert alert-success mt-3">
              <i class="fa-solid fa-check-circle me-2"></i>
              This will mark the salary as <span class="badge text-bg-success">PAID</span>
            </div>
          </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Finalize & Mark Paid',
        confirmButtonColor: '#28a745',
        preConfirm: () => {
          const hours = parseInt($('#editHours').val()) || 0;
          const days = parseInt($('#editDays').val()) || 0;
          const sessions = parseInt($('#editSessions').val()) || 0;
          const rate = parseFloat($('#editRate').val()) || 0;
          const salary = parseFloat($('#editSalary').val()) || 0;
          
          if (salary <= 0) {
            Swal.showValidationMessage('Total salary must be greater than 0');
            return false;
          }
          
          return {
            staff_id: staffId,
            hours_worked: hours,
            days_present: days,
            sessions: sessions,
            hourly_rate: rate,
            total_salary: salary,
            status: 'Paid'
          };
        }
      }).then((result) => {
        if(result.isConfirmed){
          $.ajax({
            url: '<?php echo base_url("staffsalary/update_salary_record"); ?>',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(result.value),
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                loadSalaryRecords();
                Swal.fire({
                  title: 'Payment Finalized!',
                  html: `<div class="text-success text-center">
                    <div class="h4 mb-2">₹${result.value.total_salary.toLocaleString()}</div>
                    <p><strong>${escapeHtml(staffName)}</strong> salary marked as PAID!</p>
                  </div>`,
                  icon: 'success',
                  timer: 3000
                });
              } else {
                Swal.fire('Error', response.message || 'Failed to update record', 'error');
              }
            },
            error: function(xhr) {
              Swal.fire('Error', 'Failed to update record: ' + xhr.responseText, 'error');
            }
          });
        }
      });
    });

    // View salary details
    $(document).on('click', '.view-salary', function(){
      const row = $(this).closest('tr');
      const staffName = row.find('td:eq(1)').text().trim();
      const status = row.find('td:eq(7)').text().trim().split('\n')[0];
      const statusClass = getStatusClass(status);
      const paidAt = row.data('paid-at') || 'Not paid yet';
      
      Swal.fire({
        title: `<h4 class="text-primary mb-3">
                  <i class="fa-solid fa-eye me-2"></i>
                  Salary Details - ${escapeHtml(staffName)}
                </h4>`,
        html: `
          <div class="text-start">
            <div class="row g-3 mb-3">
              <div class="col-6"><strong>Staff:</strong> ${escapeHtml(staffName)}</div>
              <div class="col-6">
                <strong>Status:</strong> 
                <span class="badge ${statusClass}">${status}</span>
              </div>
              <div class="col-6"><strong>Hours:</strong> ${row.find('td:eq(2)').text()}</div>
              <div class="col-6"><strong>Days:</strong> ${row.find('td:eq(3)').text()}</div>
              <div class="col-6"><strong>Sessions:</strong> ${row.find('td:eq(4)').text()}</div>
              <div class="col-6"><strong>Rate:</strong> ${row.find('td:eq(5)').text()}</div>
              ${status.toLowerCase() === 'paid' ? 
                `<div class="col-6"><strong>Paid On:</strong> ${paidAt}</div>` : 
                `<div class="col-6"><strong>Action:</strong> <span class="text-warning">Pending Payment</span></div>`
              }
              <div class="col-12">
                <strong class="text-success h5">Total Salary: ${row.find('td:eq(6)').text()}</strong>
              </div>
            </div>
            ${status.toLowerCase() === 'paid' ? `
              <div class="alert alert-success">
                <i class="fa-solid fa-check-circle me-2"></i>
                <strong>✓ Payment Confirmed!</strong><br>
                This salary has been successfully processed.
              </div>
            ` : `
              <div class="alert alert-warning">
                <i class="fa-solid fa-exclamation-triangle me-2"></i>
                <strong>⚠️ Pending Payment</strong><br>
                Click "Mark as Paid" to finalize this payment.
              </div>
            `}
          </div>
        `,
        icon: 'info',
        confirmButtonColor: '#0d6efd',
        width: 550
      });
    });

    // Salary Overview - Backend Stats
    $('#salaryOverviewBtn').on('click', function(){
      loadSalaryRecords();
      setTimeout(() => {
        $.ajax({
          url: '<?php echo base_url("staffsalary/get_salary_records"); ?>',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              const records = response.data;
              const pendingRecords = records.filter(r => (r.status || '').toLowerCase() === 'pending');
              const paidRecords = records.filter(r => (r.status || '').toLowerCase() === 'paid');
              
              const pendingCount = pendingRecords.length;
              const paidCount = paidRecords.length;
              const totalRecords = records.length;
              const pendingAmount = pendingRecords.reduce((sum, r) => sum + parseFloat(r.total_salary || 0), 0);
              const paidAmount = paidRecords.reduce((sum, r) => sum + parseFloat(r.total_salary || 0), 0);
              const paidPercentage = totalRecords > 0 ? ((paidCount / totalRecords) * 100).toFixed(1) : 0;

              Swal.fire({
                title: 'Salary Management Dashboard',
                html: `
                  <div class="row text-center g-3 mb-3">
                    <div class="col-6">
                      <div class="card overview-card bg-success">
                        <div class="card-body">
                          <i class="fa-solid fa-check-circle fa-2x mb-2"></i>
                          <h5>Paid Salaries</h5>
                          <h3>${paidCount}</h3>
                          <small>₹${paidAmount.toLocaleString()}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="card overview-card bg-warning">
                        <div class="card-body">
                          <i class="fa-solid fa-clock fa-2x mb-2"></i>
                          <h5>Pending</h5>
                          <h3>${pendingCount}</h3>
                          <small>₹${pendingAmount.toLocaleString()}</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card overview-card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-6">
                              <h6>Total Records: ${totalRecords}</h6>
                              <h6>Total Amount: ₹${(paidAmount + pendingAmount).toLocaleString()}</h6>
                            </div>
                            <div class="col-6 text-end">
                              <h6>${paidPercentage}% Paid</h6>
                            </div>
                          </div>
                          <div class="progress mt-3" style="height: 12px;">
                            <div class="progress-bar bg-success" style="width: ${paidPercentage}%"></div>
                            <div class="progress-bar bg-warning" style="width: ${100 - paidPercentage}%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  ${pendingAmount > 0 ? `
                    <div class="alert alert-warning">
                      <i class="fa-solid fa-exclamation-triangle me-2"></i>
                      ₹${pendingAmount.toLocaleString()} in pending payments need attention.
                    </div>
                  ` : `
                    <div class="alert alert-success">
                      <i class="fa-solid fa-trophy me-2"></i>
                      All salaries paid! Great job!
                    </div>
                  `}
                `,
                width: '700px',
                confirmButtonText: 'Close',
                confirmButtonColor: '#0d6efd'
              });
            }
          }
        });
      }, 500);
    });

    // Assign salary button
    $('#assignSalaryBtn').on('click', function(){
      Swal.fire({
        title: 'Assign New Salary',
        html: `
          <div class="text-center">
            <i class="fa-solid fa-info-circle fa-2x text-primary mb-3"></i>
            <p class="mb-3">Salary records are automatically created when you add staff members from the Staff Management page.</p>
            <div class="alert alert-info">
              <i class="fa-solid fa-lightbulb me-2"></i>
              <strong>Tip:</strong> Add staff first, then manage their salaries here.
            </div>
          </div>
        `,
        icon: 'info',
        confirmButtonText: 'Go to Staff Management',
        confirmButtonColor: '#0d6efd'
      });
    });

    // Handle disabled mark-paid clicks
    $(document).on('click', '.mark-paid.disabled', function(e){
      e.preventDefault();
      e.stopPropagation();
      Swal.fire({
        title: 'Payment Already Processed!',
        text: 'This salary has already been marked as paid.',
        icon: 'info',
        timer: 2500,
        showConfirmButton: false
      });
    });
  });
  </script>
</body>
</html>