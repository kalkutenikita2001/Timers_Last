<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Salary Management - Super Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    /* Header */
    .salary-heading {
      background-color: #dc3545;
      color: white;
      padding: 12px;
      border-radius: 8px;
      text-align: center;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      position: relative;
    }

    /* Add Salary Floating Button */
    .add-salary-btn {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      background-color: white;
      color: #dc3545;
      border: 2px solid #dc3545;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .add-salary-btn:hover {
      background-color: #dc3545;
      color: white;
      transform: scale(1.1) translateY(-50%);
    }

    /* Table */
    table th {
      background-color: #dc3545;
      color: white;
      text-align: center;
    }
    table td {
      text-align: center;
      vertical-align: middle;
    }

    /* Action Icons */
    .action-icons i {
      font-size: 20px;
      margin: 0 8px;
      cursor: pointer;
      color: #dc3545;
      transition: transform 0.2s, color 0.2s;
    }
    .action-icons i:hover {
      color: #b71c1c;
      transform: scale(1.2);
    }

    /* Tooltip */
    .tooltip-label {
      display: none;
      position: absolute;
      background: #333;
      color: #fff;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      white-space: nowrap;
      top: -28px;
      left: 50%;
      transform: translateX(-50%);
    }
    .action-icon-wrapper {
      position: relative;
      display: inline-block;
    }
    .action-icon-wrapper:hover .tooltip-label {
      display: block;
    }

    /* SweetAlert Buttons */
    .swal2-confirm {
      background-color: #dc3545 !important;
      border: none !important;
    }
    .swal2-cancel {
      background-color: #6c757d !important;
      border: none !important;
    }
  </style>
</head>

<body>
  <!-- Sidebar and Navbar -->
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

  <div class="container mt-5">
    <div class="salary-heading mb-4">
      Salary Management
      <div class="add-salary-btn" id="addSalaryBtn">
        <i class="fa-solid fa-plus"></i>
      </div>
    </div>

    <table class="table table-bordered table-hover align-middle" id="salaryTable">
      <thead>
        <tr>
          <th>Sr No</th>
          <th>Staff Name</th>
          <th>Hours</th>
          <th>Days</th>
          <th>Sessions</th>
          <th>Rate</th>
          <th>Salary</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Nikita Kalkute</td>
          <td>8</td>
          <td>26</td>
          <td>10</td>
          <td>₹1000</td>
          <td>₹26,000</td>
          <td><span class="badge bg-warning">Pending</span></td>
          <td class="action-icons">
            <div class="action-icon-wrapper">
              <i class="fa-solid fa-trash delete-salary"></i>
              <span class="tooltip-label">Delete Salary</span>
            </div>
            <div class="action-icon-wrapper">
              <i class="fa-solid fa-paper-plane send-salary"></i>
              <span class="tooltip-label">Send Details</span>
            </div>
            <div class="action-icon-wrapper">
              <i class="fa-solid fa-sack-dollar mark-paid"></i>
              <span class="tooltip-label">Mark as Paid</span>
            </div>
            <div class="action-icon-wrapper">
              <i class="fa-solid fa-eye view-salary"></i>
              <span class="tooltip-label">View Details</span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function() {

      // ➕ Add Salary Assign Card
      $("#addSalaryBtn").click(function() {
        Swal.fire({
          title: '<h4 class="text-danger mb-3">Assign Salary</h4>',
          html: `
          <div class="text-start">
            <label class="fw-bold mb-2">Select desired method of monthly salary computation</label><br>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Fixed salary" checked>
              <label class="form-check-label">Fixed salary</label>
              <input type="number" id="rate" class="form-control mt-2" placeholder="Enter rate (₹)" />
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Days present">
              <label class="form-check-label">Days present</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Session present">
              <label class="form-check-label">Session present</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Checked-in hours">
              <label class="form-check-label">Checked-in hours</label>
            </div>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="salaryType" value="Revenue based">
              <label class="form-check-label">Revenue based</label>
            </div>
          </div>`,
          width: 500,
          showCancelButton: true,
          confirmButtonText: 'Assign',
          confirmButtonColor: '#dc3545',
          cancelButtonText: 'Cancel',
          preConfirm: () => {
            const type = $('input[name="salaryType"]:checked').val();
            const rate = $('#rate').val() || '0';
            return { type, rate };
          }
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'Assigned!',
              text: `Salary method "${result.value.type}" assigned successfully with rate ₹${result.value.rate}/month.`,
              icon: 'success',
              confirmButtonColor: '#dc3545'
            });

            // 💾 Reflect salary assignment in table (simulation)
            let newRow = `
              <tr>
                <td>2</td>
                <td>New Staff</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>₹${result.value.rate}</td>
                <td>-</td>
                <td><span class="badge bg-warning">Pending</span></td>
                <td class="action-icons">
                  <div class="action-icon-wrapper">
                    <i class="fa-solid fa-trash delete-salary"></i>
                    <span class="tooltip-label">Delete Salary</span>
                  </div>
                  <div class="action-icon-wrapper">
                    <i class="fa-solid fa-paper-plane send-salary"></i>
                    <span class="tooltip-label">Send Details</span>
                  </div>
                  <div class="action-icon-wrapper">
                    <i class="fa-solid fa-sack-dollar mark-paid"></i>
                    <span class="tooltip-label">Mark as Paid</span>
                  </div>
                  <div class="action-icon-wrapper">
                    <i class="fa-solid fa-eye view-salary"></i>
                    <span class="tooltip-label">View Details</span>
                  </div>
                </td>
              </tr>`;
            $("#salaryTable tbody").append(newRow);
          }
        });
      });

      // 🗑️ Delete Salary
      $(document).on('click', '.delete-salary', function() {
        let row = $(this).closest('tr');
        let staffName = row.find('td:eq(1)').text();

        Swal.fire({
          title: 'Delete Salary Record?',
          text: `Are you sure you want to delete ${staffName}'s record?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Delete',
          confirmButtonColor: '#dc3545'
        }).then((result) => {
          if (result.isConfirmed) {
            row.remove();
            Swal.fire({
              title: 'Deleted!',
              text: `${staffName}'s record deleted successfully.`,
              icon: 'success',
              confirmButtonColor: '#dc3545'
            });
          }
        });
      });

      // 👁️ View Salary
      $(document).on('click', '.view-salary', function() {
        let row = $(this).closest('tr');
        Swal.fire({
          title: `<h4 class="text-danger mb-3">Salary Details</h4>`,
          html: `
            <p><b>Staff:</b> ${row.find('td:eq(1)').text()}</p>
            <p><b>Rate:</b> ${row.find('td:eq(5)').text()}</p>
            <p><b>Status:</b> ${row.find('td:eq(7)').text()}</p>
          `,
          icon: 'info',
          confirmButtonColor: '#dc3545'
        });
      });

    });



    // 💰 Mark as Paid - View & Edit Salary Details
$(document).on('click', '.mark-paid', function() {
  let row = $(this).closest('tr');

  // Get staff data from table
  let staffName = row.find('td:eq(1)').text();
  let hours = row.find('td:eq(2)').text();
  let days = row.find('td:eq(3)').text();
  let sessions = row.find('td:eq(4)').text();
  let rate = row.find('td:eq(5)').text().replace('₹', '').trim();
  let salary = row.find('td:eq(6)').text().replace('₹', '').trim();

  // Show editable SweetAlert popup
  Swal.fire({
    title: `<h4 class="text-danger mb-3">Edit Salary - ${staffName}</h4>`,
    html: `
      <div class="text-start">
        <label><b>Hours Worked:</b></label>
        <input type="number" id="editHours" class="form-control mb-2" value="${hours}" />
        
        <label><b>Days Present:</b></label>
        <input type="number" id="editDays" class="form-control mb-2" value="${days}" />
        
        <label><b>Sessions Attended:</b></label>
        <input type="number" id="editSessions" class="form-control mb-2" value="${sessions}" />
        
        <label><b>Rate (₹):</b></label>
        <input type="number" id="editRate" class="form-control mb-2" value="${rate}" />
        
        <label><b>Total Salary (₹):</b></label>
        <input type="number" id="editSalary" class="form-control mb-2" value="${salary}" />
      </div>
    `,
    width: 500,
    showCancelButton: true,
    confirmButtonText: 'Update & Mark as Paid',
    confirmButtonColor: '#dc3545',
    cancelButtonText: 'Cancel',
    preConfirm: () => {
      return {
        hours: $('#editHours').val(),
        days: $('#editDays').val(),
        sessions: $('#editSessions').val(),
        rate: $('#editRate').val(),
        salary: $('#editSalary').val()
      };
    }
  }).then((result) => {
    if (result.isConfirmed) {
      // Update table data with new values
      row.find('td:eq(2)').text(result.value.hours);
      row.find('td:eq(3)').text(result.value.days);
      row.find('td:eq(4)').text(result.value.sessions);
      row.find('td:eq(5)').text(`₹${result.value.rate}`);
      row.find('td:eq(6)').text(`₹${result.value.salary}`);
      row.find('td:eq(7)').html('<span class="badge bg-success">Paid</span>');

      // Hide Mark as Paid icon
      row.find('.mark-paid').closest('.action-icon-wrapper').remove();

      Swal.fire({
        title: 'Updated & Marked as Paid!',
        text: `${staffName}'s salary has been updated and marked as paid.`,
        icon: 'success',
        confirmButtonColor: '#dc3545'
      });
    }
  });
});




// ✉️ Send Salary Details to Overview tab
$(document).on('click', '.send-salary', function () {
  let row = $(this).closest('tr');

  // Collect staff data from row
  const salaryData = {
    name: row.find('td:eq(1)').text(),
    hours: row.find('td:eq(2)').text(),
    days: row.find('td:eq(3)').text(),
    sessions: row.find('td:eq(4)').text(),
    rate: row.find('td:eq(5)').text(),
    salary: row.find('td:eq(6)').text(),
    status: row.find('td:eq(7)').text().trim()
  };

  // Save to localStorage
  localStorage.setItem('staffSalaryData', JSON.stringify(salaryData));

  Swal.fire({
    title: 'Details Sent!',
    text: `Salary details for ${salaryData.name} sent to Overview tab.`,
    icon: 'success',
    confirmButtonColor: '#dc3545'
  });
});

  </script>
</body>
</html>
