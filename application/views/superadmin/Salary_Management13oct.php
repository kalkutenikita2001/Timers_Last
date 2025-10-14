<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Staff Profile - Overview & Salary</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background: #f8f9fa;
      font-family: "Poppins", sans-serif;
    }

    /* Tabs */
    .nav-tabs .nav-link.active {
      border-bottom: 3px solid #dc3545 !important;
      color: #dc3545 !important;
      font-weight: 600;
    }
    .nav-tabs .nav-link {
      color: #555;
    }

    /* Overview Card */
    .profile-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
      transition: all 0.3s ease;
    }
    .profile-card:hover {
      transform: translateY(-2px);
    }
    .profile-img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      background: #e3e3e3;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
      color: #888;
      margin-right: 20px;
    }

    .salary-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
      margin-top: 20px;
    }

    table th {
      background-color: #dc3545;
      color: white;
      text-align: center;
    }
    table td {
      text-align: center;
      vertical-align: middle;
    }

    .action-icons i {
      font-size: 20px;
      margin: 0 8px;
      cursor: pointer;
      color: #dc3545;
      transition: 0.3s;
    }
    .action-icons i:hover {
      color: #b71c1c;
      transform: scale(1.2);
    }

    .fade-section {
      display: none;
    }
    .fade-section.active {
      display: block;
      animation: fadeIn 0.4s ease-in-out;
    }
    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(10px);}
      to {opacity: 1; transform: translateY(0);}
    }

    
  </style>
</head>

<body>
    <!-- Sidebar and Navbar -->
  <?php $this->load->view('superadmin/Include/Sidebar'); ?>
  <?php $this->load->view('superadmin/Include/Navbar'); ?>

<div class="container mt-5">
  <ul class="nav nav-tabs mb-4" id="staffTabs">
    <li class="nav-item">
      <a class="nav-link active" href="#" data-target="#overviewSection">Overview</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" data-target="#salarySection">Salary</a>
    </li>
  </ul>

  <!-- Overview -->
  <div id="overviewSection" class="fade-section active">
    <div class="profile-card d-flex align-items-center">
      <div class="profile-img">
        <i class="fa-solid fa-user"></i>
      </div>
      <div>
        <h5 class="mb-1" id="staffName">Nikita Kalkute</h5>
        <small class="text-muted">Admin</small>
        <div class="mt-3">
          <p class="mb-1">
            <strong id="expenseDisplay">Expense ₹ 4,000.00</strong>
          </p>
          <p class="mb-0">₹ <span id="salaryDisplay">4,000.00</span> / month</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Salary -->
  <div id="salarySection" class="fade-section">
    <div class="salary-card">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>Staff Name</th>
            <th>Hours</th>
            <th>Days</th>
            <th>Sessions</th>
            <th>Rate</th>
            <th>Salary</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nikita Kalkute</td>
            <td>8</td>
            <td>26</td>
            <td>10</td>
            <td>₹1000</td>
            <td class="salary-amount">₹26,000</td>
            <td class="action-icons">
              <i class="fa-solid fa-paper-plane send-salary" title="Send Salary Details"></i>
              <i class="fa-solid fa-sack-dollar mark-paid" title="Mark as Paid"></i>
              <div class="dropdown d-inline">
                <i class="fa-solid fa-ellipsis-vertical" data-bs-toggle="dropdown"></i>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item edit-salary" href="#">Edit</a></li>
                  <li><a class="dropdown-item delete-salary" href="#">Delete</a></li>
                </ul>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
  // Tab switching
  $('#staffTabs .nav-link').click(function(e) {
    e.preventDefault();
    $('#staffTabs .nav-link').removeClass('active');
    $(this).addClass('active');
    $('.fade-section').removeClass('active');
    $($(this).data('target')).addClass('active');
  });

  // Send Salary Details
  $(document).on('click', '.send-salary', function() {
    let name = $(this).closest('tr').find('td:eq(0)').text();
    Swal.fire({
      icon: 'success',
      title: 'Sent!',
      text: `Salary details sent to ${name}.`,
      confirmButtonColor: '#dc3545'
    });
  });

  // Mark as Paid
  $(document).on('click', '.mark-paid', function() {
    let btn = $(this);
    let row = btn.closest('tr');
    let salaryText = row.find('.salary-amount').text().replace(/[₹,]/g, '');
    let salary = parseFloat(salaryText);

    Swal.fire({
      title: 'Confirm Payment',
      text: `Mark ₹${salary.toLocaleString()} as paid?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, Paid',
      confirmButtonColor: '#dc3545'
    }).then((result) => {
      if (result.isConfirmed) {
        btn.fadeOut();
        Swal.fire({
          icon: 'success',
          title: 'Payment Recorded!',
          text: 'Salary marked as paid successfully.',
          confirmButtonColor: '#dc3545'
        });

        // Update expense in Overview card
        let currentExpenseText = $('#expenseDisplay').text().replace(/[^\d.]/g, '');
        let currentExpense = parseFloat(currentExpenseText);
        let newExpense = currentExpense + salary;
        $('#expenseDisplay').text(`Expense ₹ ${newExpense.toLocaleString()}`);
      }
    });
  });

  // Edit Salary
  $(document).on('click', '.edit-salary', function() {
    let row = $(this).closest('tr');
    Swal.fire({
      title: 'Edit Salary Rate',
      input: 'number',
      inputLabel: 'Enter new rate per day:',
      inputPlaceholder: 'e.g. 1200',
      showCancelButton: true,
      confirmButtonText: 'Update',
      confirmButtonColor: '#dc3545'
    }).then(result => {
      if (result.isConfirmed && result.value) {
        let newRate = parseFloat(result.value);
        row.find('td:eq(4)').text(`₹${newRate}`);
        let days = parseFloat(row.find('td:eq(2)').text());
        let total = newRate * days;
        row.find('.salary-amount').text(`₹${total.toLocaleString()}`);
        Swal.fire('Updated!', 'Salary rate updated successfully.', 'success');
      }
    });
  });

  // Delete Salary
  $(document).on('click', '.delete-salary', function() {
    let row = $(this).closest('tr');
    Swal.fire({
      title: 'Delete Salary?',
      text: 'Are you sure you want to delete this record?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Delete',
      confirmButtonColor: '#dc3545'
    }).then((result) => {
      if (result.isConfirmed) {
        row.remove();
        Swal.fire('Deleted!', 'Salary record deleted.', 'success');
      }
    });
  });
});
</script>




<script>
$(document).ready(function () {
  // Sidebar collapse toggler
  $(".navbar-toggler, #sidebarToggle").on("click", function () {
    $("body").toggleClass("sidebar-collapsed");

    // Optional: if your sidebar has an ID or class, you can toggle it directly
    $(".sidebar").toggleClass("collapsed");
  });

  // Optional: close sidebar automatically on mobile when a link is clicked
  $(".sidebar a").on("click", function () {
    if ($(window).width() < 992) {
      $("body").removeClass("sidebar-collapsed");
      $(".sidebar").removeClass("collapsed");
    }
  });

  // Recheck screen size on window resize
  $(window).on("resize", function () {
    if ($(this).width() < 992) {
      $("body").addClass("sidebar-collapsed");
    } else {
      $("body").removeClass("sidebar-collapsed");
    }
  });
});
</script>

</body>
</html>
