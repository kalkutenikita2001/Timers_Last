<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Forget Password</title>

  <!-- Bootstrap + fonts + icons (CDN) -->
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />


  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <style>
    :root {
      --accent: #d32f2f;
      --card-bg: #ffffff;
      --input-bg: #fff;

      /* make sure these match your real sidebar actual widths */
      --sidebar-full: 250px;
      /* full sidebar width (adjust to your sidebar) */
      --sidebar-collapsed: 60px;
      /* collapsed sidebar width (adjust to your sidebar) */
    }

    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      min-height: 100vh;
      background: #e9ecef;
      -webkit-font-smoothing: antialiased;
    }

    /* ---------- NOTE: Sidebar & Navbar are loaded by your PHP includes above.
       This file assumes the sidebar element will match one of these selectors:
       '.sidebar', '#sidebar', '.main-sidebar' or '#siteSidebar'.
       The toggle button should have class 'sidebar-toggle' (or update toggleSelectors below).
    ---------- */

    /* ---------- top navbar mock styling kept only to visually align margins if your real navbar expects it ---------- */
    .navbar-mock {
      margin-left: var(--sidebar-full);
      transition: margin-left .25s ease;
      background: #fff;
      border-bottom: 1px solid #eee;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      position: sticky;
      top: 0;
      z-index: 900;
    }

    .navbar-mock.minimized {
      margin-left: var(--sidebar-collapsed);
    }

    /* ---------- content wrapper responds to sidebar ---------- */
    .content-wrapper {
      margin-left: var(--sidebar-full);
      padding: 18px;
      transition: margin-left .28s ease, padding .28s ease;
      min-height: calc(100vh - 150px);
    }

    .content-wrapper.minimized {
      margin-left: var(--sidebar-collapsed);
    }

    /* ---------- header & card (your original styles) ---------- */
    .top-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      height: 150px;
      border-bottom-left-radius: 18px;
      border-bottom-right-radius: 18px;
      box-shadow: 0 8px 30px rgba(71, 0, 0, 0.25);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .top-header .content {
      position: relative;
      z-index: 2;
    }

    .top-header .title {
      font-size: 24px;
      font-weight: 700;
      letter-spacing: 0.3px
    }

    .top-header .subtitle {
      font-size: 14px;
      margin-top: 6px;
      opacity: .9
    }

    .header-decor {
      position: absolute;
      right: -80px;
      top: -40px;
      width: 260px;
      height: 260px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      filter: blur(20px);
    }

    .container {
      max-width: 600px;
      margin: -60px auto 30px;
    }

    .profile-card {
      background: var(--card-bg);
      padding: 22px;
      border-radius: 12px;
      box-shadow: 0 14px 40px rgba(2, 6, 23, 0.06);
      animation: fadeUp .45s ease both
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(8px)
      }

      to {
        opacity: 1;
        transform: translateY(0)
      }
    }

    h2 {
      font-size: 20px;
      margin-bottom: 8px;
      color: #222;
      font-weight: 700;
      text-align: center
    }

    .muted-panel {
      background: rgba(233, 236, 239, 0.9);
      padding: 10px;
      border-radius: 8px;
      color: #222;
      font-size: 13px;
      margin-bottom: 12px;
      text-align: center
    }

    .form-row {
      display: flex;
      gap: 14px;
      margin-bottom: 14px
    }

    .form-group {
      flex: 1;
      margin-bottom: 0;
      position: relative
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      font-size: 13px;
      color: #333
    }

    input {
      width: 100%;
      padding: 11px 12px;
      border-radius: 9px;
      border: 1px solid #e6e6e6;
      background: var(--input-bg);
      font-size: 14px
    }

    input::placeholder {
      color: #a5a5a5
    }

    input:focus {
      outline: none;
      border-color: var(--accent);
      box-shadow: 0 8px 22px rgba(211, 47, 47, 0.09)
    }

    .error {
      font-size: 12px;
      color: var(--accent);
      display: none;
      margin-top: 6px
    }

    .form-group.invalid input {
      border-color: var(--accent);
      background: #fff6f6
    }

    .form-group.invalid .error {
      display: block
    }

    .actions {
      text-align: center;
      margin-top: 18px
    }

    .btn-save {
      background: var(--accent);
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 10px;
      font-weight: 700;
      box-shadow: 0 10px 26px rgba(211, 47, 47, 0.14);
      transition: transform .15s
    }

    .btn-save:hover {
      transform: translateY(-3px)
    }

    .pw-toggle {
      position: absolute;
      right: 12px;
      top: 38px;
      background: transparent;
      border: none;
      color: #666;
      font-size: 14px;
      cursor: pointer
    }

    .strength {
      height: 7px;
      border-radius: 6px;
      background: #eee;
      margin-top: 8px;
      overflow: hidden
    }

    .strength>i {
      display: block;
      height: 100%;
      width: 0;
      transition: width .28s
    }

    .strength.weak>i {
      width: 33%;
      background: #ff6b6b
    }

    .strength.ok>i {
      width: 66%;
      background: #ffb86b
    }

    .strength.strong>i {
      width: 100%;
      background: #2ecc71
    }

    @media(max-width:768px) {

      /* on small screens we don't keep a big left margin */
      .content-wrapper {
        margin-left: 0 !important;
        padding: 12px
      }

      .form-row {
        flex-direction: column
      }

      .container {
        margin-top: 10px
      }
    }
  </style>
</head>

<body>
  <!-- ========== ORIGINAL SIDEBAR (kept exactly as you had it) ========== -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>

  <!-- ========== ORIGINAL NAVBAR (kept exactly as you had it) ========== -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- ===== Content wrapper: THIS element will get .minimized toggled ===== -->
  <div class="content-wrapper" id="contentWrapper">
    <header class="top-header">
      <div class="header-decor" aria-hidden="true"></div>
      <div class="content">
        <div class="title">Super Admin — Account</div>
        <div class="subtitle">Secure settings — change password for superadmin or admin</div>
      </div>
    </header>

    <div class="container">
      <!-- Change Password -->
      <section class="profile-card" id="changePasswordSection">
        <div class="muted-panel">Use a strong, unique password. Minimum 8 characters recommended.</div>
        <form id="changePasswordForm" novalidate>
          <h2>Change Password</h2>

          <div class="form-row">
            <div class="form-group" id="g-userType">
              <label for="userType">User Type</label>
              <select id="userType" class="form-control" required>
                <option value="">Select User Type</option>
                <option value="superadmin">Super Admin</option>
                <option value="admin">Admin</option>
              </select>
              <div class="error">Please select a user type</div>
            </div>

            <div class="form-group" id="g-username">
              <label for="username">Username</label>
              <input id="username" placeholder="e.g. Superadmin/Admin" required autocomplete="username" />
              <div class="error">Username is required</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group" id="g-currentPassword">
              <label for="currentPassword">Current Password</label>
              <input id="currentPassword" type="password" placeholder=" Current password" required autocomplete="current-password" />
              <button type="button" class="pw-toggle" data-target="currentPassword" aria-label="Toggle current password"><i class="fas fa-eye"></i></button>
              <div class="error">Current password is required</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group" id="g-newPassword">
              <label for="newPassword">New Password</label>
              <input id="newPassword" type="password" placeholder="New password(8 char)" required autocomplete="new-password" />
              <button type="button" class="pw-toggle" data-target="newPassword" aria-label="Toggle new password"><i class="fas fa-eye"></i></button>
              <div class="strength" id="pwStrength" aria-hidden="true"><i></i></div>
              <div class="error">New password must be at least 8 chars and different</div>
            </div>

            <div class="form-group" id="g-confirmPassword">
              <label for="confirmPassword">Confirm New Password</label>
              <input id="confirmPassword" type="password" placeholder="Re-type password" required autocomplete="new-password" />
              <button type="button" class="pw-toggle" data-target="confirmPassword" aria-label="Toggle confirm password"><i class="fas fa-eye"></i></button>
              <div class="error">Passwords do not match</div>
            </div>
          </div>

          <div class="actions">
            <button type="submit" class="btn-save">Change Password</button>
          </div>
        </form>
      </section>
    </div>
  </div>

  <!-- JS libs (keep or replace with your own versions) -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Password & form logic -->
  <script>
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.pw-toggle');
      if (!btn) return;
      const targetId = btn.getAttribute('data-target');
      if (!targetId) return;
      const input = document.getElementById(targetId);
      if (!input) return;
      const icon = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        if (icon) icon.className = 'fas fa-eye-slash';
      } else {
        input.type = 'password';
        if (icon) icon.className = 'fas fa-eye';
      }
      input.focus();
    });

    (function() {
      const newPwd = document.getElementById('newPassword');
      const pwStrength = document.getElementById('pwStrength');
      if (!newPwd || !pwStrength) return;
      newPwd.addEventListener('input', () => {
        const v = newPwd.value || '';
        const score = (v.length >= 8 ? 1 : 0) + ((/[A-Z]/.test(v) && /[a-z]/.test(v)) ? 1 : 0) + ((/[0-9]/.test(v) || /[\W_]/.test(v)) ? 1 : 0);
        pwStrength.className = 'strength ' + (score <= 1 ? 'weak' : score === 2 ? 'ok' : 'strong');
      });
    })();

    function markInvalid(el, msg) {
      if (!el) return;
      el.classList.add('invalid');
      if (msg) el.querySelector('.error').textContent = msg;
    }

    function clearInvalid(el) {
      if (!el) return;
      el.classList.remove('invalid');
    }

    function validateForm() {
      let ok = true;
      const userType = document.getElementById('userType');
      const u = document.getElementById('username'),
        c = document.getElementById('currentPassword'),
        n = document.getElementById('newPassword'),
        cf = document.getElementById('confirmPassword');

      [userType, u, c, n, cf].forEach(i => {
        const g = i.closest('.form-group');
        if (g) clearInvalid(g);
      });

      if (!userType.value) {
        markInvalid(userType.closest('.form-group'), 'Please select a user type');
        ok = false;
      }

      if (!u.value.trim()) {
        markInvalid(u.closest('.form-group'), 'Username is required');
        ok = false;
      }

      if (!c.value.trim()) {
        markInvalid(c.closest('.form-group'), 'Current password is required');
        ok = false;
      }

      if (!n.value.trim()) {
        markInvalid(n.closest('.form-group'), 'New password required');
        ok = false;
      } else if (n.value.length < 8) {
        markInvalid(n.closest('.form-group'), 'Must be at least 8 characters');
        ok = false;
      } else if (n.value === c.value) {
        markInvalid(n.closest('.form-group'), 'Cannot be same as current');
        ok = false;
      }

      if (!cf.value.trim() || cf.value !== n.value) {
        markInvalid(cf.closest('.form-group'), 'Passwords do not match');
        ok = false;
      }

      return ok;
    }

    document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
      e.preventDefault();

      if (validateForm()) {
        const userType = document.getElementById('userType').value;
        const username = document.getElementById('username').value;
        const currentPassword = document.getElementById('currentPassword').value;
        const newPassword = document.getElementById('newPassword').value;

        // Prepare data for AJAX request
        const formData = new FormData();
        formData.append('userType', userType);
        formData.append('username', username);
        formData.append('currentPassword', currentPassword);
        formData.append('newPassword', newPassword);

        // Show loading alert
        Swal.fire({
          title: 'Changing Password',
          text: 'Please wait...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        // Send AJAX request to server
        fetch('<?php echo base_url("superadmin/change_password"); ?>', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            Swal.close();

            if (data.success) {
              // Success message
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Password changed successfully!',
                confirmButtonColor: '#d32f2f'
              }).then(() => {
                // Reset form
                document.getElementById('changePasswordForm').reset();
                const pw = document.getElementById('pwStrength');
                if (pw) pw.className = 'strength';
              });
            } else {
              // Error message
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.message || 'Failed to change password. Please try again.',
                confirmButtonColor: '#d32f2f'
              });
            }
          })
          .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred. Please try again.',
              confirmButtonColor: '#d32f2f'
            });
          });
      } else {
        Swal.fire({
          icon: 'warning',
          title: 'Validation Error',
          text: 'Please fix the errors in the form',
          confirmButtonColor: '#d32f2f'
        });
      }
    });

    document.querySelectorAll('#changePasswordForm input, #changePasswordForm select').forEach(inp => {
      inp.addEventListener('input', () => {
        const group = inp.closest('.form-group');
        if (group) clearInvalid(group);
      });
    });

    // Sidebar auto-resize script (keeps original sidebar/nav includes intact)
    (function() {
      const cfg = {
        // element that should shift
        wrapperSelector: '#contentWrapper',
        // list of selectors to try for the sidebar element (your include must match one)
        sidebarSelectors: ['.sidebar', '#sidebar', '.main-sidebar', '#siteSidebar'],
        // list of selectors to try for the toggle button (keep your toggle's class)
        toggleSelectors: ['.sidebar-toggle', '#sidebarToggle', '[data-sidebar-toggle]'],
        // class we toggle on wrapper to reduce left margin
        minimizedClassOnWrapper: 'minimized',
        // a class toggled on sidebar for visual collapsed state by button
        sidebarToggleClass: 'minimized',
        // classes your server might set on the sidebar when collapsed
        sidebarMinimizedClasses: ['minimized', 'collapsed', 'sidebar-collapse', 'mini', 'closed']
      };

      function q(sel) {
        try {
          return document.querySelector(sel);
        } catch (e) {
          return null;
        }
      }

      function findFirst(selectors) {
        for (let s of selectors) {
          if (!s) continue;
          s = s.trim();
          const el = q(s);
          if (el) return el;
        }
        return null;
      }

      function sidebarHasMinimized(sidebarEl) {
        if (!sidebarEl) return false;
        return cfg.sidebarMinimizedClasses.some(c => sidebarEl.classList.contains(c));
      }

      function setWrapper(wrapperEl, minimized) {
        if (!wrapperEl) return;
        wrapperEl.classList.toggle(cfg.minimizedClassOnWrapper, !!minimized);
        // if your navbar needs margin adjusted, add a selector for it (example uses .navbar-mock)
        const navbar = q('.navbar-mock');
        if (navbar) navbar.classList.toggle('minimized', !!minimized);
        document.dispatchEvent(new CustomEvent('sidebarToggle', {
          detail: {
            minimized: !!minimized
          }
        }));
      }

      function observeSidebar(sidebarEl, wrapperEl) {
        if (!sidebarEl || !wrapperEl || typeof MutationObserver === 'undefined') return null;
        const obs = new MutationObserver(muts => {
          muts.forEach(m => {
            if (m.type === 'attributes' && m.attributeName === 'class') {
              const min = sidebarHasMinimized(sidebarEl) || sidebarEl.classList.contains(cfg.sidebarToggleClass);
              setWrapper(wrapperEl, min);
            }
          });
        });
        obs.observe(sidebarEl, {
          attributes: true,
          attributeFilter: ['class']
        });
        return obs;
      }

      function attachToggle(toggleEl, sidebarEl, wrapperEl) {
        if (!toggleEl) return;
        toggleEl.addEventListener('click', function() {
          if (sidebarEl) sidebarEl.classList.toggle(cfg.sidebarToggleClass);
          const minimized = sidebarHasMinimized(sidebarEl) || (sidebarEl && sidebarEl.classList.contains(cfg.sidebarToggleClass));
          setWrapper(wrapperEl, minimized);
          toggleEl.setAttribute('aria-pressed', String(!!minimized));
        });
      }

      function initOnce() {
        const wrapper = q(cfg.wrapperSelector);
        if (!wrapper) {
          console.warn('SidebarAutoResize: wrapper element not found:', cfg.wrapperSelector);
          return;
        }

        let sidebar = findFirst(cfg.sidebarSelectors);
        let toggle = findFirst(cfg.toggleSelectors);

        // short retry if includes load later
        if (!sidebar || !toggle) {
          let attempts = 0;
          const maxAttempts = 40;
          const retry = setInterval(() => {
            attempts++;
            sidebar = sidebar || findFirst(cfg.sidebarSelectors);
            toggle = toggle || findFirst(cfg.toggleSelectors);
            if (sidebar && toggle) {
              clearInterval(retry);
              _setup(wrapper, sidebar, toggle);
            } else if (attempts >= maxAttempts) {
              clearInterval(retry);
              if (sidebar) _setup(wrapper, sidebar, toggle);
              else console.warn('SidebarAutoResize: could not find sidebar or toggle within timeout.');
            }
          }, 100);
        } else {
          _setup(wrapper, sidebar, toggle);
        }
      }

      function _setup(wrapper, sidebar, toggle) {
        const initialMin = sidebar ? (sidebarHasMinimized(sidebar) || sidebar.classList.contains(cfg.sidebarToggleClass)) : wrapper.classList.contains(cfg.minimizedClassOnWrapper);
        setWrapper(wrapper, initialMin);
        attachToggle(toggle, sidebar, wrapper);
        observeSidebar(sidebar, wrapper);

        // watch for late changes (defensive)
        const bodyObs = new MutationObserver((muts, obs) => {
          const s = findFirst(cfg.sidebarSelectors);
          const t = findFirst(cfg.toggleSelectors);
          if (s && t) {
            obs.disconnect();
            if (s !== sidebar || t !== toggle) {
              sidebar = s;
              toggle = t;
              attachToggle(toggle, sidebar, wrapper);
              observeSidebar(sidebar, wrapper);
              setWrapper(wrapper, sidebarHasMinimized(sidebar) || sidebar.classList.contains(cfg.sidebarToggleClass));
            }
          }
        });
        bodyObs.observe(document.body, {
          childList: true,
          subtree: true
        });
        setTimeout(() => bodyObs.disconnect(), 5000);
      }

      if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initOnce);
      else initOnce();
    })();


    // Sidebar toggle functionality
    $('#sidebarToggle').on('click', function() {
      if ($(window).width() <= 576) {
        $('#sidebar').toggleClass('active');
        $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
      } else {
        const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
        $('.navbar').toggleClass('sidebar-minimized', isMinimized);
        $('#contentWrapper').toggleClass('minimized', isMinimized);
      }
    });
  </script>
</body>

</html>