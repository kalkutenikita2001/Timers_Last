<!-- Sidebar Component -->
<div class="sidebar" id="sidebar">
  <div class="logo">
    <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
  </div>
  <nav class="nav flex-column">
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/dashboard'); ?>">
      <i class="bi bi-speedometer2"></i><span>Dashboard</span>
    </a>
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'Center') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Center'); ?>">
      <i class="bi bi-building"></i><span>Center</span>
    </a>
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'Staff') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Staff'); ?>">
      <i class="bi bi-people"></i><span>Staff</span>
    </a>
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'Batch') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Batch'); ?>">
      <i class="bi bi-layers"></i><span>Batch</span>
    </a>
    
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'EventAndNotice') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/EventAndNotice'); ?>">
      <i class="bi bi-calendar-event"></i><span>EventAndNotice</span>
    </a>
   
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'Admission') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Finance'); ?>">
      <i class="bi bi-cash-stack"></i><span>Finance</span>
    </a>
    <a class="nav-link <?php echo ($this->uri->segment(2) == 'Admission') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Expenses'); ?>">
      <i class="bi bi-credit-card"></i><span>Expenses</span>
    </a>
     <a class="nav-link <?php echo ($this->uri->segment(2) == 'Admission') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Students'); ?>">
      <i class="bi bi-person-lines-fill"></i><span>Students</span>
    </a>
     <a class="nav-link <?php echo ($this->uri->segment(2) == 'Admission') ? 'active' : ''; ?>" href="<?php echo base_url('superadmin/Leave'); ?>">
      <i class="bi bi-receipt-cutoff"></i><span>Leave</span>
    </a>

    <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
  </nav>
</div>

<style>
  .sidebar {
    width: 250px;
    background-color: white;
    border-right: 1px solid #dee2e6;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 1000;
    height: 100vh;
    padding-top: 10px;
    transition: width 0.3s ease-in-out;
    overflow-y: scroll; /* Enable scrolling */
    scrollbar-width: none; /* Hide scrollbar for Firefox */
    -ms-overflow-style: none; /* Hide scrollbar for IE and Edge */
  }

  .sidebar::-webkit-scrollbar {
    display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
  }

  .sidebar.minimized {
    width: 60px;
  }

  .sidebar .logo {
    text-align: center;
    padding: 32px 0;
  }

  .sidebar .logo img {
    max-width: 80%;
    height: 155px;
    transition: all 0.3s ease;
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
    background-color: transparent;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .sidebar .nav-link:hover {
    background-color: #e9ecef;
    font-weight: 500;
  }

  .sidebar .nav-link.active {
    background-color: #e9ecef;
    font-weight: 700;
  }

  .sidebar .nav-link i {
    margin-right: 10px;
    font-size: 16px;
    transition: margin 0.3s ease;
  }

  .sidebar.minimized .nav-link {
    justify-content: center;
    padding: 10px;
    background-color: transparent !important;
  }

  .sidebar.minimized .nav-link i {
    margin-right: 0;
  }

  .sidebar.minimized .nav-link span {
    display: none;
  }

  /* Mobile Responsive */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-250px);
    }

    .sidebar.active {
      transform: translateX(0);
    }
  }

  @media (min-width: 769px) and (max-width: 1024px) {
    .sidebar {
      width: 200px;
    }

    .sidebar.minimized {
      width: 60px;
    }
  }
</style>

<script>
  // Save and restore scroll position
  document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const navLinks = sidebar.querySelectorAll('.nav-link');

    // Save scroll position before navigation
    navLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        if (link.href) { // Ensure it's not the logout link or an anchor
          const scrollPosition = sidebar.scrollTop;
          sessionStorage.setItem('sidebarScrollPosition', scrollPosition);
        }
      });
    });

    // Restore scroll position on page load
    const savedScrollPosition = sessionStorage.getItem('sidebarScrollPosition');
    if (savedScrollPosition !== null) {
      sidebar.scrollTop = parseInt(savedScrollPosition, 10);
    }

    // Sidebar toggle functionality (assuming it exists elsewhere)
    // This part is left unchanged as per your request
  });
</script>