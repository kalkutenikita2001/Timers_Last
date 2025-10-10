<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Navbar with Notification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { margin:0; padding-top:60px; font-family:'Montserrat', serif; }
    .navbar {
      box-shadow:0 2px 4px rgba(0,0,0,0.1);
      padding:10px 20px;
      position:fixed; top:0; z-index:1030; height:60px;
      width: calc(100% - 250px); left:250px;
      transition: width .3s, left .3s; background-color:#fff !important; border-bottom:1px solid #dee2e6;
    }
    .navbar.sidebar-minimized { width: calc(100% - 60px); left:60px; }
    .navbar.sidebar-hidden { width:100%; left:0; }
    .navbar-toggle { background:none; border:none; color:black !important; font-size:24px; cursor:pointer; padding:0; }
    .notification-icon { font-size:24px; cursor:pointer; position:relative; margin-left:15px; z-index:1101; display:flex; align-items:center; }
    /* small numeric badge on the bell */
    #navBellCount {
      position:absolute; top:-6px; right:-6px;
      font-size:0.65rem; padding:0.18rem 0.38rem; border-radius:999px;
      background:#dc3545; color:#fff; display:none; line-height:1;
      box-shadow:0 1px 4px rgba(0,0,0,0.15);
    }
    /* notification dropdown container (replaces your existing .notification-container) */
    .notification-container {
      display:none; position:fixed; top:60px; right:20px; background:#fff;
      width:320px; border-radius:10px; padding:8px; box-shadow:0 6px 18px rgba(0,0,0,0.12);
      z-index:1100; max-height:70vh; overflow:auto;
    }
    .notification-container .list { max-height:56vh; overflow:auto; }
    .notification-item { display:flex; gap:8px; padding:10px; align-items:flex-start; border-bottom:1px solid #eee; }
    .notification-item:last-child { border-bottom:none; }
    .notification-item strong { display:block; font-size:14px; }
    .notification-item p { margin:0; font-size:13px; color:#555; }
    .notification-item .time { font-size:11px; color:#888; white-space:nowrap; margin-left:auto; }
    /* Sidebar small badge (visible inside sidebar file too) */
    .sidebar-badge { font-size:0.65rem; padding:0.18rem 0.38rem; border-radius:999px; background:#dc3545; color:#fff; margin-left:6px; display:none; }
    /* small screens */
    @media (max-width:768px) {
      .navbar, .navbar.sidebar-minimized, .navbar.sidebar-hidden { width:100%; left:0; }
      .notification-container { right:10px; width:90%; max-width:360px; }
    }
    /* accessibility SR only */
    .sr-only { position: absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0; }
  </style>
</head>
<body>
  <nav class="navbar" id="navbar">
    <div class="container-fluid d-flex align-items-start">
      <div class="d-flex align-items-start">
        <button class="navbar-toggle me-2" id="sidebarToggle"><i class="bi bi-list"></i></button>
      </div>

      <div class="ms-auto d-flex align-items-center position-relative">
        <!-- Notification icon + badge -->
        <div class="notification-icon" id="notificationIcon" aria-haspopup="true" aria-expanded="false" role="button" tabindex="0">
          <i class="bi bi-bell-fill" aria-hidden="true"></i>
          <span id="navBellCount" aria-hidden="true">0</span>
          <span id="srNotifAnnounce" class="sr-only" aria-live="polite"></span>
        </div>

        <!-- Profile -->
        <div class="profile-icon ms-3">
          <a href="<?php echo base_url('superadmin/Superadmin_profile'); ?>">
            <img src="<?php echo base_url('assets/Images/timeersbadmintonacademy_logo.png'); ?>" class="rounded-circle" alt="Profile" width="32" height="32">
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Notification Dropdown -->
  <div class="notification-container" id="notificationDropdown" role="menu" aria-labelledby="notificationIcon">
    <div class="d-flex justify-content-between align-items-center px-2">
      <h6 class="mb-0">Notifications</h6>
      <div>
        <button class="btn btn-sm btn-light btn-outline-secondary me-1" id="markAllReadBtn">Mark all read</button>
        <button class="btn-close" id="closeNotification" aria-label="Close"></button>
      </div>
    </div>
    <hr class="my-2">
    <div class="list" id="notifList" aria-live="polite" aria-atomic="true">
      <!-- Items populated dynamically -->
      <div class="text-center text-muted small py-3" id="notifEmpty">No notifications</div>
    </div>
    <!--<div class="p-2 text-center small">-->
    <!--  <a href="<?php echo base_url('superadmin/notifications'); ?>">View all</a>-->
    <!--</div>-->
  </div>

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Pusher client (default real-time integration) -->
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <!-- OPTIONAL Socket.IO client (use if you run socket server instead of Pusher)
  <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>
  -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const closeNotification = document.getElementById('closeNotification');
    const navBellCount = document.getElementById('navBellCount');
    const sidebarBadge = document.querySelector('.sidebar-badge'); // sidebar file includes element with this class
    const notifList = document.getElementById('notifList');
    const notifEmpty = document.getElementById('notifEmpty');
    const srAnnounce = document.getElementById('srNotifAnnounce');
    const markAllReadBtn = document.getElementById('markAllReadBtn');

    // Expect these endpoints (implement on backend):
    const API_UNREAD_COUNT = '<?= base_url("notifications/unread_count") ?>';
    const API_LIST = '<?= base_url("notifications/list_unread") ?>';
    const API_MARK_READ = '<?= base_url("notifications/mark_read") ?>';

    // --- UI helpers ---
    function showBadge(count) {
      if (!navBellCount) return;
      if (count > 0) {
        navBellCount.style.display = 'inline-block';
        navBellCount.textContent = count;
      } else {
        navBellCount.style.display = 'none';
        navBellCount.textContent = '0';
      }
      if (sidebarBadge) {
        if (count > 0) { sidebarBadge.style.display = 'inline-block'; sidebarBadge.textContent = count; }
        else { sidebarBadge.style.display = 'none'; sidebarBadge.textContent = '0'; }
      }
    }

    function prependNotif(item) {
      // item: {id, type, message, item_id, created_at}
      const wrapper = document.createElement('div');
      wrapper.className = 'notification-item';
      wrapper.dataset.id = item.id;
      wrapper.innerHTML = `
        <div>
          <strong>${escapeHtml(item.title || item.type || 'Notification')}</strong>
          <p>${escapeHtml(item.message)}</p>
        </div>
        <div class="time">${timeAgo(new Date(item.created_at))}</div>
      `;
      // Insert at top
      if (notifEmpty) notifEmpty.style.display = 'none';
      notifList.insertBefore(wrapper, notifList.firstChild);
    }

    function escapeHtml(s) { return (s||'').replace(/[&<>"'`]/g, (m)=>({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;' }[m])); }

    function timeAgo(date) {
      const seconds = Math.floor((Date.now() - date)/1000);
      if (seconds < 60) return `${seconds}s`;
      const minutes = Math.floor(seconds/60);
      if (minutes < 60) return `${minutes}m`;
      const hours = Math.floor(minutes/60);
      if (hours < 24) return `${hours}h`;
      const days = Math.floor(hours/24);
      return `${days}d`;
    }

    // --- bootstrap of current unread count & list ---
    function fetchUnreadCountAndList() {
      fetch(API_UNREAD_COUNT, { credentials: 'same-origin' })
        .then(r => r.json()).then(data => {
          const c = Number(data.count || 0);
          showBadge(c);
        }).catch(()=>{ /* ignore errors */ });

      fetch(API_LIST, { credentials: 'same-origin' })
        .then(r => r.json()).then(data => {
          // expected: array of unread notifications
          notifList.innerHTML = '';
          if (!Array.isArray(data) || data.length === 0) {
            notifList.innerHTML = '<div class="text-center text-muted small py-3" id="notifEmpty">No notifications</div>';
            return;
          }
          data.forEach(item => {
            prependNotif(item);
          });
        }).catch(()=>{ /* ignore errors */ });
    }

    // initial load
    fetchUnreadCountAndList();

    // dropdown open/close
    notificationIcon.addEventListener('click', (ev) => {
      ev.stopPropagation();
      const visible = notificationDropdown.style.display === 'block';
      notificationDropdown.style.display = visible ? 'none' : 'block';
      if (!visible) {
        // when opened, optionally mark as read (or you can mark individually)
        // For UX we mark all unread as read when user explicitly opens
        fetch(API_MARK_READ, {
          method: 'POST',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({ mark_all: true }),
          credentials: 'same-origin'
        }).then(()=> {
          showBadge(0);
        }).catch(()=>{/*ignore*/});
      }
    });

    closeNotification.addEventListener('click', () => { notificationDropdown.style.display = 'none'; });
    window.addEventListener('click', (e) => {
      if (!notificationIcon.contains(e.target) && !notificationDropdown.contains(e.target)) {
        notificationDropdown.style.display = 'none';
      }
    });

    markAllReadBtn.addEventListener('click', (e) => {
      e.preventDefault();
      fetch(API_MARK_READ, {
        method:'POST', headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ mark_all: true }), credentials: 'same-origin'
      }).then(()=> {
        showBadge(0);
        notifList.innerHTML = '<div class="text-center text-muted small py-3" id="notifEmpty">No notifications</div>';
      });
    });

    // --- REALTIME: Pusher (default) ---
    // Replace PUSHER_KEY, PUSHER_CLUSTER with your values (or switch to Socket.IO)
    const PUSHER_KEY = 'YOUR_PUSHER_KEY';
    const PUSHER_CLUSTER = 'YOUR_PUSHER_CLUSTER';
    if (PUSHER_KEY && PUSHER_KEY !== 'YOUR_PUSHER_KEY') {
      Pusher.logToConsole = false;
      const pusher = new Pusher(PUSHER_KEY, { cluster: PUSHER_CLUSTER, forceTLS: true });
      const channel = pusher.subscribe('notifications-channel'); // channel name used on server
      channel.bind('new-notification', function(data) {
        // server pushes full notification data
        if (!data) return;
        prependNotif(data);
        // update badges
        const prev = Number(navBellCount.textContent || 0);
        const now = prev + 1;
        showBadge(now);
        // screen reader announcement
        if (srAnnounce) srAnnounce.textContent = data.message;
      });
    } else {
      // If Pusher key not set, fall back to periodic poll (fallback already below).
      console.info('Pusher not configured on client; using polling fallback.');
    }

    // --- POLLING fallback in case no real-time available ---
    const POLL_INTERVAL = 15000;
    setInterval(fetchUnreadCountAndList, POLL_INTERVAL);

    // --- optional: Socket.IO code (if you choose to use socket server instead)
    // Uncomment and adapt if you run a socket.io server:
    /*
    const socket = io('http://your-socket-server:3000');
    socket.on('new_leave', function(data){
      prependNotif(data);
      const prev = Number(navBellCount.textContent || 0);
      showBadge(prev + 1);
      if (srAnnounce) srAnnounce.textContent = data.message;
    });
    */

    // Sidebar toggle behavior kept (matches your previous code)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.querySelector('.navbar');
    const contentWrapper = document.getElementById('contentWrapper');

    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          if (sidebar) { sidebar.classList.toggle('active'); navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active')); }
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
  </script>
</body>
</html>
