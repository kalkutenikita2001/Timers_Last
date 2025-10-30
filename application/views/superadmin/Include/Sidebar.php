<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sidebar with Smooth Submenu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    .sidebar {
      width: 250px;
      background: #fff;
      border-right: 1px solid #dee2e6;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 1000;
      height: 100vh;
      padding-top: 10px;
      transition: width .3s;
      overflow-y: auto;
    }

    .sidebar.minimized {
      width: 60px;
    }

    .logo {
      text-align: center;
      padding: 32px 0;
      transition: padding .3s;
    }

    .logo img {
      max-width: 80%;
      height: 155px;
      transition: all .3s;
    }

    .sidebar.minimized .logo img {
      max-width: 40px;
      height: 40px;
    }

    .sidebar .nav-link {
      color: #000;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      font-size: 14px;
      text-decoration: none;
      border-radius: 30px;
      margin: 5px 10px;
      transition: background-color .3s, color .3s;
    }

    .sidebar .nav-link:hover {
      background: #e9ecef;
      font-weight: 500;
    }

    .sidebar .nav-link.active {
      background: #e9ecef;
      font-weight: 700;
    }

    .sidebar .nav-link i {
      margin-right: 10px;
      font-size: 16px;
      min-width: 20px;
      text-align: center;
    }

    .sidebar.minimized .nav-link {
      justify-content: center;
      padding: 10px;
    }

    .sidebar.minimized .nav-link i {
      margin-right: 0;
    }

    .sidebar.minimized .nav-link span {
      display: none;
    }

    .nav-item .collapse {
      transition: height .35s;
    }

    .nav-item .nav-link[data-bs-toggle="collapse"] .bi-chevron-down {
      transition: transform .35s;
    }

    .nav-item .nav-link[data-bs-toggle="collapse"][aria-expanded="true"] .bi-chevron-down {
      transform: rotate(180deg);
    }

    .nav-item .collapse .nav-link {
      padding-left: 40px;
      font-size: 13px;
    }

    @media (max-width:768px) {
      .sidebar {
        transform: translateX(-250px);
        transition: transform .3s;
      }

      .sidebar.active {
        transform: translateX(0);
      }
    }

    .main-content {
      margin-left: 250px;
      padding: 20px;
      transition: margin-left .3s;
    }

    .main-content.expanded {
      margin-left: 60px;
    }

    .sidebar-badge {
      font-size: 0.65rem;
      padding: 0.18rem 0.38rem;
      border-radius: 999px;
      background: #dc3545;
      color: #fff;
      margin-left: 6px;
      display: none;
    }

    /* Rotate the chevron when submenu is expanded (button controls collapse now) */
    button[aria-expanded="true"] .bi-chevron-down {
      transform: rotate(180deg);
      transition: transform .35s;
    }

    /* Keep current hide-on-minimize behavior working for the inner label */
    .sidebar.minimized .nav-link a span {
      display: none;
    }

    .sidebar.minimized .nav-link a {
      justify-content: center;
      padding: 10px 0;
    }

    /* Keep sidebar links black in all states */
    .sidebar a {
      color: #000;
    }

    .sidebar a:hover,
    .sidebar a:focus,
    .sidebar a:active,
    .sidebar a:visited {
      color: #000;
    }

    /* Give the inner <a> the same selected look when it has .active */
    .sidebar .nav-item>.nav-link>a.active {
      background: #e9ecef;
      font-weight: 700;
      border-radius: 30px;
      padding: 10px 20px;
      display: flex;
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="sidebar" id="sidebar">
    <div class="logo">
      <img src="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
    </div>

    <nav class="nav flex-column">
      <a class="nav-link <?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/dashboard'); ?>">
        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
      </a>
      <a class="nav-link <?php echo ($this->uri->segment(2) == 'VenueForm') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/VenueForm'); ?>">
        <i class="bi bi-mortarboard"></i><span> Office Management </span>
      </a>


      <!---
      <a class="nav-link <?php echo ($this->uri->segment(2) == 'CenterManagement2') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/CenterManagement2'); ?>">
        <i class="bi bi-credit-card"></i><span>Center Management</span>
      </a>
  -->
      <!-- STAFF MANAGEMENT -->
      <div class="nav-item">
        <!-- Row wrapper styled like a nav-link -->
        <div class="nav-link d-flex justify-content-between align-items-center">
          <!-- Left side: click to open Staff_manage.php -->
          <a
            class="d-flex align-items-center flex-grow-1 text-decoration-none <?php echo ($this->uri->segment(2) == 'Staff_manage') ? 'active' : ''; ?>"
            href="<?php echo base_url('superadmin/Staff_manage'); ?>">
           <i class="bi bi-people-fill"></i>
            <span>Staff Management</span>
          </a>

          <!-- Right side: chevron only toggles the submenu -->
          <button
            class="btn btn-sm p-0 border-0 bg-transparent ms-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#staffMenu"
            aria-expanded="false"
            aria-controls="staffMenu"
            aria-label="Toggle Staff submenu">
            <i class="bi bi-chevron-down"></i>
          </button>
        </div>

        <div class="collapse" id="staffMenu">
          <nav class="nav flex-column ms-3">
            <a class="nav-link <?php echo ($this->uri->segment(2) == 'Add_NewStaff') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Add_NewStaff'); ?>">
              <i class="bi-person-plus"></i>

<span> Add New Staff</span>
            </a>
            <?php $isAttendance = ($this->uri->segment(1) == 'Attendance' || $this->uri->segment(2) == 'Attendance'); ?>
            <a class="nav-link <?php echo $isAttendance ? 'active' : ''; ?>" href="<?php echo base_url('Attendance'); ?>">
              <i class="fa-solid fa-book-open-reader"></i><span> Attendance</span>
            </a>
            <a class="nav-link <?php echo ($this->uri->segment(2) == 'Salary_Management') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Salary_Management'); ?>">
              <i class="bi bi-currency-dollar"></i>
<span> Salary Management</span>
            </a>
          </nav>
        </div>
      </div>



      <!-- ADMISSION MANAGEMENT -->
      <div class="nav-item">
        <!-- Row wrapper styled like a nav-link -->
        <div class="nav-link d-flex justify-content-between align-items-center">
          <!-- Left side: click to open Students -->
          <a
            class="d-flex align-items-center flex-grow-1 text-decoration-none <?php echo ($this->uri->segment(2) == 'Students') ? 'active' : ''; ?>"
            href="<?php echo base_url('superadmin/Students'); ?>">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Admission Management</span>
          </a>

          <!-- Right side: chevron only toggles the submenu -->
          <?php
          $isAdmissionActive = in_array($this->uri->segment(2), [
            'fNew_admission',
            'Re_admission',
            'FRenewNew_Admission'
          ]);
          ?>
          <button
            class="btn btn-sm p-0 border-0 bg-transparent ms-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#admissionMenu"
            aria-expanded="<?php echo $isAdmissionActive ? 'true' : 'false'; ?>"
            aria-controls="admissionMenu"
            aria-label="Toggle Admission submenu">
            <i class="bi bi-chevron-down"></i>
          </button>
        </div>

        <div class="collapse <?php echo $isAdmissionActive ? 'show' : ''; ?>" id="admissionMenu">
          <nav class="nav flex-column ms-3">
            <a class="nav-link <?php echo ($this->uri->segment(2) == 'ReAdd') ? 'active' : ''; ?>"
              href="<?php echo base_url('superadmin/ReAdd'); ?>">
              <i class="bi-clipboard-check"></i>
<span> New Admission</span>
            </a>
            <!-- <a class="nav-link <?php echo ($this->uri->segment(2) == 'Re_admission') ? 'active' : ''; ?>"
              href="<?php echo base_url('superadmin/Re_admission'); ?>">
              <i class="bi bi-arrow-counterclockwise"></i><span> Re-Admission</span>
            </a>-->
            <a class="nav-link <?php echo ($this->uri->segment(2) == 'FRenewNew_Admission') ? 'active' : ''; ?>"
              href="<?php echo base_url('superadmin/FRenewNew_Admission'); ?>">
              <i class="bi bi-arrow-repeat"></i><span> Renew Admission</span>
            </a>
          </nav>
        </div>
      </div>

      <!-- <a class="nav-link <?php echo ($this->uri->segment(2) == 'VenueManagement') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/VenueManagement'); ?>">
        <i class="bi bi-mortarboard"></i><span> Office Management 1</span>
      </a> -->

      
 <a class="nav-link <?php echo ($this->uri->segment(2) == 'FinanceManagement2') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/FinanceManagement2'); ?>">
                      <i class="fa-solid fa-file-invoice-dollar"></i>
<span>Finance Management</span>
      </a>

      <a class="nav-link <?php echo ($this->uri->segment(2) == 'EventAndNotice') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/EventAndNotice'); ?>">
        <i class="bi bi-calendar-event"></i><span>Event Management</span>
      </a>
     


      <!--
      <a class="nav-link <?php echo ($this->uri->segment(2) == 'Finance') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Finance'); ?>">
        <i class="bi bi-cash-stack"></i><span>Finance Management</span>
      </a>
  -->

      
      <?php $isExpenses = ($this->uri->segment(1) == 'Expense' || $this->uri->segment(2) == 'Expense' || $this->uri->segment(2) == 'Expenses'); ?>
      <a class="nav-link <?php echo $isExpenses ? 'active' : ''; ?>" href="<?php echo base_url('Expense'); ?>">
        <i class="fa-solid fa-arrow-trend-up"></i>
        <span> Expenses Management</span>
      </a>



      <?php $isLeave = ($this->uri->segment(1) == 'Leave' || $this->uri->segment(2) == 'Leave'); ?>
      <a class="nav-link <?php echo $isLeave ? 'active' : ''; ?>" href="<?php echo base_url('Leave'); ?>">
        <i class="bi bi-calendar-x"></i><span>Leave Management</span>
      </a>


      <a class="nav-link <?php echo ($this->uri->segment(2) == 'overall_report') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/overall_report'); ?>">
        <i class="bi bi-calendar-x"></i><span> Reports Management</span>
      </a>

      <a class="nav-link <?php echo ($this->uri->segment(2) == 'Permission') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Permission'); ?>">
        <i class="bi bi-person-circle"></i><span>Permission</span>
      </a>

      <a class="nav-link <?php echo ($this->uri->segment(2) == 'Superadmin_profile') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Superadmin_profile'); ?>">
        <i class="fa-solid fa-lock"></i><span>Forget Password</span>
      </a>

      <!-- Logout -->
      <a class="nav-link" href="<?php echo base_url('auth/logout'); ?>" id="logout-link">
        <i class="bi bi-box-arrow-right"></i><span>Logout</span>
      </a>

      <!-- Logout -->
      <a class="nav-link" href="<?php echo base_url('g'); ?>" id="logout-link">
        <i class=""></i><span></span>
      </a>
       <a class="nav-link" href="<?php echo base_url(''); ?>" id="logout-link">
        <i class=""></i><span></span>
      </a>
     
    </nav>
  </div>

  <!-- Optional: provide a main content wrapper to make the expand/collapse work -->
  <div id="mainContent" class="main-content">
    <!-- Your page content goes here -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const minimizeBtn = document.getElementById('minimizeSidebar');
      const mobileToggleBtn = document.getElementById('sidebarToggle');
      const navLinks = sidebar.querySelectorAll('.nav-link');
      const collapseElements = sidebar.querySelectorAll('.collapse');

      // safe-guard for missing elements
      if (minimizeBtn) {
        minimizeBtn.addEventListener('click', () => {
          sidebar.classList.toggle('minimized');
          if (mainContent) mainContent.classList.toggle('expanded');
        });
      }

      if (mobileToggleBtn) {
        mobileToggleBtn.addEventListener('click', () => {
          sidebar.classList.toggle('active');
        });
      }

      // remember sidebar scroll position across navigations
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (link.href && !link.getAttribute('data-bs-toggle')) {
            const scrollPosition = sidebar.scrollTop;
            sessionStorage.setItem('sidebarScrollPosition', scrollPosition);
          }
        });
      });

      const savedScrollPosition = sessionStorage.getItem('sidebarScrollPosition');
      if (savedScrollPosition !== null) sidebar.scrollTop = parseInt(savedScrollPosition, 10);

      // smooth collapse animations
      collapseElements.forEach(collapse => {
        collapse.addEventListener('show.bs.collapse', function() {
          this.style.height = '0';
          this.classList.add('show');
          this.style.height = this.scrollHeight + 'px';
        });
        collapse.addEventListener('shown.bs.collapse', function() {
          this.style.height = '';
        });
        collapse.addEventListener('hide.bs.collapse', function() {
          this.style.height = this.scrollHeight + 'px';
          setTimeout(() => {
            this.style.height = '0';
          }, 10);
        });
        collapse.addEventListener('hidden.bs.collapse', function() {
          this.style.height = '';
        });
      });

      // auto-close sidebar on mobile when clicking outside
      document.addEventListener('click', (e) => {
        if (window.innerWidth < 769 && !sidebar.contains(e.target) && e.target !== mobileToggleBtn && !(mobileToggleBtn && mobileToggleBtn.contains && mobileToggleBtn.contains(e.target))) {
          sidebar.classList.remove('active');
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const logoutEl = document.getElementById('logout-link');
    if (logoutEl) {
      logoutEl.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure?',
          text: "You will be logged out!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4040',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, logout!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) window.location.href = this.href;
        });
      });
    }
  </script>
</body>

</html>