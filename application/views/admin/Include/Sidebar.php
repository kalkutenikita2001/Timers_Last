<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
    </div>
    <nav class="nav flex-column">
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Dashboard') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Dashboard'; ?>">
            <i class="bi bi-house-door"></i><span>Dashboard</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Batch') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Batch'; ?>">
            <i class="bi bi-stack"></i><span>Batch</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'EventAndNotice') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/EventAndNotice'; ?>">
            <i class="bi bi-calendar-event"></i><span>EventAndNotice</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Admission') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Admission'; ?>">
            <i class="bi bi-person-plus"></i><span>Admission</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'IncomeAndExpenses') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/IncomeAndExpenses'; ?>">
            <i class="bi bi-cash"></i><span>IncomeAndExpenses</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Attendance') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Attendance'; ?>">
            <i class="bi bi-check-circle"></i><span>Attendance</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Leave') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Leave'; ?>">
            <i class="bi bi-calendar-x"></i><span>Leave</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'locker_fees') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/locker_fees'; ?>">
            <i class="bi bi-geo-alt"></i><span>Venue</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Profile') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Profile'; ?>">
            <i class="bi bi-person-circle"></i><span>Profile</span>
        </a>
        <a class="nav-link <?php echo ($this->uri->segment(2) == 'Report') ? 'active' : ''; ?>" href="<?php echo base_url() . 'admin/Report'; ?>">
            <i class="bi bi-clipboard-data"></i><span>Report</span>
        </a>
        <a class="nav-link" href="<?php echo base_url('base/adminlogin'); ?>"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>
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
        overflow-y: auto;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE and Edge */
        transition: width 0.3s ease-in-out;
        height: 100vh;
        padding-top: 28px;
        font-family: 'Montserrat', serif;
    }

    .sidebar::-webkit-scrollbar {
        display: none; /* Chrome, Safari, and other Webkit browsers */
    }

    .sidebar.minimized {
        width: 60px;
    }

    .sidebar .nav-link {
        color: #000;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 5px 10px;
        border-radius: 30px;
    }

    .sidebar.minimized .nav-link {
        justify-content: center;
        padding: 10px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #e9ecef;
        color: #000;
        border-radius: 30px;
        font-weight: bold;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
        font-size: 16px;
        transition: margin 0.3s ease;
    }

    .sidebar.minimized .nav-link i {
        margin-right: 0;
    }

    .sidebar .logo {
        text-align: center;
        padding: 37px 0 0 0;
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

    @media (min-width: 769px) {
        .sidebar {
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
                if (link.href && link.href !== '#') {
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
    });
</script>