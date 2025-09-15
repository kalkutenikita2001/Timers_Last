<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Permission Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --danger: #dc3545;
            --muted: #6c757d;
            --sidebar-full: 250px;
            /* full sidebar width (adjust if needed) */
            --sidebar-collapsed: 60px;
            /* collapsed sidebar width (adjust if needed) */
        }

        /* ===== general page styling (unchanged) ===== */
        body {
            background: #f8f9fa;
            font-family: "Segoe UI", Tahoma, sans-serif;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, var(--danger), #a71d2a);
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0 0 10px 10px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .06);
            border: 0;
        }

        .card-header {
            background: linear-gradient(45deg, var(--danger), #a71d2a);
            color: #fff;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
        }

        .module-section {
            background: #fff;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid var(--danger);
        }

        .module-title {
            font-weight: 600;
            color: var(--danger);
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }

        .form-check-input:checked {
            background-color: var(--danger);
            border-color: var(--danger);
        }

        .toggle-all-btn {
            font-size: .85rem;
            padding: .35rem .6rem;
        }

        .admin-name {
            font-weight: 600;
            color: var(--danger);
            margin: 10px 0;
        }

        .center-name {
            font-weight: 700;
            font-size: 1.05rem;
        }

        .accordion-button:not(.collapsed) {
            background: rgba(220, 53, 69, .06);
            color: var(--danger);
            font-weight: 600;
        }

        /* ===== auto-resize wrapper styles =====
           The script toggles the `minimized` class on the wrapper.
           Make sure the values match your actual sidebar widths.
        */
        /* default (sidebar expanded) */
        #permissionWrapper {
            transition: margin-left 0.25s ease, padding 0.25s ease;
            margin-left: var(--sidebar-full);
            padding: 0;
            /* existing padding inside container-fluid remains */
        }

        /* when sidebar minimized */
        #permissionWrapper.minimized {
            margin-left: var(--sidebar-collapsed);
        }

        /* Small-screen: override (mobile layout will not keep large margin) */
        @media (max-width: 768px) {
            #permissionWrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <?php $this->load->view('superadmin/Include/Sidebar') ?>


        <!-- Main Content Area -->
        <!-- NOTE: I added id="permissionWrapper" so the auto-resize script can target this element -->
        <div id="permissionWrapper" class="main w-100">
            <!-- Navbar -->
            <?php $this->load->view('superadmin/Include/Navbar') ?>

            <!-- Page Content -->
            <div class="container-fluid p-4">

                <header class="header text-center">
                    <h1 class="mb-1"><i class="fas fa-user-lock me-2"></i>Permission Management</h1>
                    <p class="mb-0">Manage access controls for your academy branches</p>
                </header>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-lock me-2"></i>Manage Permissions</span>
                                <button id="toggleAllBtn" class="btn btn-sm btn-secondary toggle-all-btn" type="button">Toggle All Off</button>
                            </div>

                            <div class="card-body">
                                <div class="accordion" id="permissionAccordion">

                                    <!-- Example: Center 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#center1">
                                                <span class="center-name"><i class="fas fa-building me-2"></i>Center 1</span>
                                            </button>
                                        </h2>
                                        <div id="center1" class="accordion-collapse collapse show" data-bs-parent="#permissionAccordion">
                                            <div class="accordion-body">
                                                <p class="admin-name"><i class="fas fa-user me-2"></i>Coach John Doe</p>

                                                <div class="module-section">
                                                    <h6 class="module-title"><i class="fas fa-database me-2"></i>Database</h6>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="db1" checked>
                                                        <label class="form-check-label" for="db1">Isha Hai Official</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="db2">
                                                        <label class="form-check-label" for="db2">ChatGPT</label>
                                                    </div>
                                                </div>

                                                <div class="module-section">
                                                    <h6 class="module-title"><i class="fas fa-table me-2"></i>Databoard</h6>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="databoard1">
                                                        <label class="form-check-label" for="databoard1">Center Management</label>
                                                    </div>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="databoard2" checked>
                                                        <label class="form-check-label" for="databoard2">Admission Management</label>
                                                    </div>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="databoard3" checked>
                                                        <label class="form-check-label" for="databoard3">Students Management</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="databoard4">
                                                        <label class="form-check-label" for="databoard4">Event Management</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Example: Center 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading2">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#center2">
                                                <span class="center-name"><i class="fas fa-building me-2"></i>Center 2</span>
                                            </button>
                                        </h2>
                                        <div id="center2" class="accordion-collapse collapse" data-bs-parent="#permissionAccordion">
                                            <div class="accordion-body">
                                                <p class="admin-name"><i class="fas fa-user me-2"></i>Coach Jane Smith</p>
                                                <div class="module-section">
                                                    <h6 class="module-title"><i class="fas fa-database me-2"></i>Database</h6>
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="center2-db1">
                                                        <label class="form-check-label" for="center2-db1">Isha Hai Official</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" id="center2-db2" checked>
                                                        <label class="form-check-label" for="center2-db2">ChatGPT</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- /accordion -->

                                <div class="d-grid gap-2 mt-3">
                                    <button id="saveBtn" class="btn btn-danger" type="button"><i class="fas fa-save me-2"></i>Save All Permissions</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /container-fluid -->
        </div>
    </div>

    <!-- ===== scripts (your original permission logic unchanged) ===== -->
    <script>
        (() => {
            const toggleAllBtn = document.getElementById('toggleAllBtn');
            const saveBtn = document.getElementById('saveBtn');

            function updateToggleButton() {
                const inputs = [...document.querySelectorAll('.form-check-input')];
                const allChecked = inputs.length && inputs.every(i => i.checked);
                toggleAllBtn.textContent = allChecked ? 'Toggle All Off' : 'Toggle All On';
            }

            toggleAllBtn.addEventListener('click', () => {
                const inputs = [...document.querySelectorAll('.form-check-input')];
                const allChecked = inputs.length && inputs.every(i => i.checked);
                inputs.forEach(i => i.checked = !allChecked);
                updateToggleButton();
            });

            document.addEventListener('change', e => {
                if (!e.target.classList.contains('form-check-input')) return;
                updateToggleButton();
            });

            saveBtn.addEventListener('click', () => {
                const payload = [];
                document.querySelectorAll('.accordion-item').forEach(item => {
                    const center = item.querySelector('.center-name')?.textContent?.trim();
                    if (!center) return;
                    const perms = [];
                    item.querySelectorAll('.form-check-input').forEach(input => {
                        const label = input.closest('.form-check')?.querySelector('.form-check-label')?.textContent?.trim();
                        perms.push({
                            id: input.id,
                            label,
                            enabled: !!input.checked
                        });
                    });
                    payload.push({
                        center,
                        perms
                    });
                });
                console.log('permissions payload', payload);
                alert('Permissions ready. Hook this to backend.');
            });

            updateToggleButton();
        })();
    </script>

    <!-- ===== Sidebar auto-resize script (drop-in) ===== -->
    <script>
        /*
          SidebarAutoResize: toggles the wrapper class when sidebar changes,
          and observes sidebar 'class' attribute changes.
          It also listens for .sidebar-toggle clicks (if present).
        */
        (function() {
            const options = {
                wrapperSelector: '#permissionWrapper',
                sidebarSelector: '.sidebar, #sidebar, .main-sidebar',
                toggleSelector: '.sidebar-toggle', // keep in sync with your toggle button
                minimizedClassOnWrapper: 'minimized',
                sidebarMinimizedClasses: ['minimized', 'collapsed', 'sidebar-collapse']
            };

            function queryFirst(selector) {
                try {
                    return document.querySelector(selector);
                } catch (e) {
                    return null;
                }
            }

            function checkSidebarClasses(sidebarEl) {
                if (!sidebarEl) return false;
                return options.sidebarMinimizedClasses.some(cls => sidebarEl.classList.contains(cls));
            }

            function setWrapperState(wrapperEl, minimized) {
                if (!wrapperEl) return;
                if (minimized) wrapperEl.classList.add(options.minimizedClassOnWrapper);
                else wrapperEl.classList.remove(options.minimizedClassOnWrapper);
                // dispatch event for other modules
                const ev = new CustomEvent('sidebarToggle', {
                    detail: {
                        minimized
                    }
                });
                document.dispatchEvent(ev);
            }

            function observeSidebar(sidebarEl, wrapperEl) {
                if (!sidebarEl || !wrapperEl || typeof MutationObserver === 'undefined') return null;
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            const minimized = checkSidebarClasses(sidebarEl);
                            setWrapperState(wrapperEl, minimized);
                        }
                    });
                });
                observer.observe(sidebarEl, {
                    attributes: true,
                    attributeFilter: ['class']
                });
                return observer;
            }

            function init() {
                document.addEventListener('DOMContentLoaded', () => {
                    const wrapperEl = queryFirst(options.wrapperSelector);
                    const sidebarEl = queryFirst(options.sidebarSelector);
                    const toggleEl = queryFirst(options.toggleSelector);

                    if (!wrapperEl) {
                        console.warn('SidebarAutoResize: wrapper element not found for selector', options.wrapperSelector);
                        return;
                    }

                    // initial sync: if sidebar already has minimized classes, set wrapper accordingly
                    if (checkSidebarClasses(sidebarEl)) setWrapperState(wrapperEl, true);
                    else setWrapperState(wrapperEl, false);

                    // attach toggle handler if button exists
                    if (toggleEl) {
                        toggleEl.addEventListener('click', function() {
                            // toggle wrapper class
                            const isMin = wrapperEl.classList.contains(options.minimizedClassOnWrapper);
                            setWrapperState(wrapperEl, !isMin);
                        });
                    }

                    // observe sidebar class changes (keeps things robust)
                    observeSidebar(sidebarEl, wrapperEl);

                    // optional: respond to programmatic events from other code
                    document.addEventListener('sidebarToggle', (e) => {
                        // nothing required here, but other modules can listen to this event
                        // console.log('sidebarToggle event', e.detail);
                    });
                });
            }

            init();
        })();
    </script>

    <!-- make sure Bootstrap JS + icons are included (if not already loaded) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>