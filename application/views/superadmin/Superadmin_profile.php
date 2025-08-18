<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #e9ecef !important;
            color: #fff;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 10px;
            transition: all 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .container {
            max-width: 1200px;
            margin: 70px auto 0;
            width: 100%;
        }

        .tab-buttons-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .tab-button {
            flex: 1;
            padding: 12px;
            background: #e0e0e0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: #000;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .tab-button.active {
            background: #fff;
            color: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .tab-button:hover {
            background: #d3d3d3;
            transform: translateY(-1px);
        }

        .profile-form {
            background: #f5f5f5;
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-form h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background: white;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #d32f2f;
            box-shadow: 0 0 5px rgba(211, 47, 47, 0.2);
        }

        .save-btn {
            color: black;
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            width: 140px;
            font-size: 15px;
            margin: 25px auto;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .save-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .error {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.invalid input,
        .form-group.invalid select {
            border-color: #d32f2f;
            background: #ffeaea;
        }

        .form-group.invalid .error {
            display: block;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 5px !important;
            }

            .container {
                margin-top: 60px;
            }

            .tab-buttons-container {
                flex-direction: column;
            }

            .tab-button {
                width: 100%;
            }

            .profile-form {
                padding: 15px;
                max-width: 100%;
            }

            .form-row {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .profile-form {
                padding: 10px;
            }

            .form-group label {
                font-size: 12px;
            }

            .form-group input,
            .form-group select {
                padding: 8px;
                font-size: 12px;
            }

            .save-btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .content-wrapper {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container">
            <!-- Tab Buttons -->
            <div class="tab-buttons-container">
                <button class="tab-button active" onclick="showTab('changePassword')">Change Password</button>
                <button class="tab-button" onclick="showTab('superAdminDetails')">Super Admin Details</button>
                <button class="tab-button" onclick="showTab('systemSettings')">System Settings</button>
            </div>

            <!-- Change Password Form -->
            <div id="changePasswordTab" class="profile-form">
                <h2>Super Admin Profile</h2>
                <form id="changePasswordForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="username">Username :</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                            <div class="error">Username is required</div>
                        </div>
                        <div class="form-group">
                            <label for="currentPassword">Current Password :</label>
                            <input type="password" id="currentPassword" name="currentPassword" class="form-control" required>
                            <div class="error">Current Password is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="newPassword">New Password :</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control" required>
                            <div class="error">New Password is required</div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="save-btn mt-3">Change</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Super Admin Details Form -->
            <div id="superAdminDetailsTab" class="profile-form" style="display: none;">
                <h2>Super Admin Details</h2>
                <form id="superAdminDetailsForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullName">Full Name :</label>
                            <input type="text" id="fullName" name="fullName" class="form-control" required>
                            <div class="error">Full Name is required</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                            <div class="error">Valid email is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number :</label>
                            <input type="tel" id="phone" name="phone" class="form-control" pattern="[0-9]{10}" required>
                            <div class="error">Valid 10-digit phone number is required</div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="save-btn mt-3">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- System Settings Form -->
            <div id="systemSettingsTab" class="profile-form" style="display: none;">
                <h2>System Settings</h2>
                <form id="systemSettingsForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="systemName">System Name :</label>
                            <input type="text" id="systemName" name="systemName" class="form-control" required>
                            <div class="error">System Name is required</div>
                        </div>
                        <div class="form-group">
                            <label for="adminRole">Admin Role :</label>
                            <select id="adminRole" name="adminRole" class="form-control custom-select" required>
                                <option value="">Select Role</option>
                                <option value="superAdmin">Super Admin</option>
                                <option value="admin">Admin</option>
                            </select>
                            <div class="error">Admin Role is required</div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="systemAccess">System Access Level :</label>
                            <select id="systemAccess" name="systemAccess" class="form-control custom-select" required>
                                <option value="">Select Access Level</option>
                                <option value="full">Full Access</option>
                                <option value="restricted">Restricted Access</option>
                            </select>
                            <div class="error">System Access Level is required</div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="save-btn mt-3">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap + Font Awesome + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

    <script>
        // Tab functionality
        function showTab(tabName) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.profile-form').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabName + 'Tab').style.display = 'block';
            document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add('active');
        }

        // Form validation and submission
        const changePasswordForm = document.getElementById('changePasswordForm');
        const superAdminDetailsForm = document.getElementById('superAdminDetailsForm');
        const systemSettingsForm = document.getElementById('systemSettingsForm');

        function clearValidationErrors(form) {
            const formGroups = form.querySelectorAll('.form-group');
            formGroups.forEach(group => {
                group.classList.remove('invalid');
            });
        }

        function validateChangePassword() {
            const username = document.getElementById('username');
            const currentPassword = document.getElementById('currentPassword');
            const newPassword = document.getElementById('newPassword');
            let isValid = true;

            clearValidationErrors(changePasswordForm);

            if (!username.value.trim()) {
                username.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!currentPassword.value.trim()) {
                currentPassword.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!newPassword.value.trim()) {
                newPassword.closest('.form-group').classList.add('invalid');
                isValid = false;
            } else if (newPassword.value.length < 8) {
                newPassword.closest('.form-group').classList.add('invalid');
                newPassword.nextElementSibling.textContent = 'New Password must be at least 8 characters';
                isValid = false;
            } else if (newPassword.value === currentPassword.value) {
                newPassword.closest('.form-group').classList.add('invalid');
                newPassword.nextElementSibling.textContent = 'New Password cannot be the same as Current Password';
                isValid = false;
            }

            return isValid;
        }

        function validateSuperAdminDetails() {
            const fullName = document.getElementById('fullName');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            let isValid = true;

            clearValidationErrors(superAdminDetailsForm);

            if (!fullName.value.trim()) {
                fullName.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!phone.value.trim() || !/^[0-9]{10}$/.test(phone.value)) {
                phone.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        function validateSystemSettings() {
            const systemName = document.getElementById('systemName');
            const adminRole = document.getElementById('adminRole');
            const systemAccess = document.getElementById('systemAccess');
            let isValid = true;

            clearValidationErrors(systemSettingsForm);

            if (!systemName.value.trim()) {
                systemName.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!adminRole.value) {
                adminRole.closest('.form-group').classList.add('invalid');
                isValid = false;
            }
            if (!systemAccess.value) {
                systemAccess.closest('.form-group').classList.add('invalid');
                isValid = false;
            }

            return isValid;
        }

        changePasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateChangePassword()) {
                alert('Password changed successfully!');
                changePasswordForm.reset();
            }
        });

        superAdminDetailsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateSuperAdminDetails()) {
                alert('Super Admin details saved successfully!');
                superAdminDetailsForm.reset();
            }
        });

        systemSettingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateSystemSettings()) {
                alert('System settings saved successfully!');
                systemSettingsForm.reset();
            }
        });

        // Real-time validation
        ['username', 'currentPassword', 'newPassword'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                if (this.value.trim()) {
                    this.closest('.form-group').classList.remove('invalid');
                } else {
                    this.closest('.form-group').classList.add('invalid');
                }
                if (id === 'newPassword' && this.value.trim()) {
                    if (this.value.length < 8) {
                        this.closest('.form-group').classList.add('invalid');
                        this.nextElementSibling.textContent = 'New Password must be at least 8 characters';
                    } else if (this.value === document.getElementById('currentPassword').value) {
                        this.closest('.form-group').classList.add('invalid');
                        this.nextElementSibling.textContent = 'New Password cannot be the same as Current Password';
                    }
                }
            });
        });

        ['fullName', 'email', 'phone'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                if (this.value.trim()) {
                    this.closest('.form-group').classList.remove('invalid');
                } else {
                    this.closest('.form-group').classList.add('invalid');
                }
                if (id === 'email' && this.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value)) {
                    this.closest('.form-group').classList.add('invalid');
                }
                if (id === 'phone' && this.value.trim() && !/^[0-9]{10}$/.test(this.value)) {
                    this.closest('.form-group').classList.add('invalid');
                }
            });
        });

        ['systemName'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                if (this.value.trim()) {
                    this.closest('.form-group').classList.remove('invalid');
                } else {
                    this.closest('.form-group').classList.add('invalid');
                }
            });
        });

        ['adminRole', 'systemAccess'].forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                if (this.value) {
                    this.closest('.form-group').classList.remove('invalid');
                } else {
                    this.closest('.form-group').classList.add('invalid');
                }
            });
        });

        // Sidebar toggle functionality
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
                            navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
                        }
                    } else {
                        if (sidebar && contentWrapper) {
                            const isMinimized = sidebar.classList.toggle('minimized');
                            navbar.classList.toggle('sidebar-minimized', isMinimized);
                            contentWrapper.classList.toggle('minimized', isMinimized);
                        }
                    }
                });
            }
        });

        // Initialize with change password tab active
        showTab('changePassword');
    </script>
</body>
</html>