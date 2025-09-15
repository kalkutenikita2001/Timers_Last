<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Permission Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --danger: #dc3545;
            --muted: #6c757d;
            --card-bg: #fff
        }

        body {
            background: #f5f7fb;
            font-family: Inter, system-ui, Segoe UI, Roboto, -apple-system
        }

        .hero {
            background: linear-gradient(135deg, var(--danger), #a71d2a);
            color: #fff;
            padding: 28px;
            border-radius: .6rem
        }

        .card {
            border: 0;
            border-radius: .6rem;
            box-shadow: 0 6px 20px rgba(25, 40, 60, .06)
        }

        .module {
            border-left: 4px solid var(--danger);
            padding: 12px;
            border-radius: .45rem;
            background: var(--card-bg)
        }

        .center-name {
            font-weight: 700
        }

        .admin-name {
            color: var(--danger);
            font-weight: 600
        }

        .form-check .form-check-input:checked {
            background-color: var(--danger);
            border-color: var(--danger)
        }

        #permissionWrapper {
            transition: margin-left .2s ease;
            margin-left: 250px
        }

        #permissionWrapper.min {
            margin-left: 60px
        }

        @media(max-width:768px) {
            #permissionWrapper {
                margin-left: 0 !important
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar placeholder (server include in original) -->
        <?php $this->load->view('superadmin/Include/Sidebar') ?>

        <main id="permissionWrapper" class="flex-fill">
            <div class="container-fluid p-4">
                <header class="hero text-center mb-4 shadow-sm">
                    <h1 class="h3 mb-1"><i class="fa fa-user-lock me-2"></i>Permission Management</h1>
                    <p class="mb-0 small">Manage access controls for your academy branches</p>
                </header>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between bg-white">
                                <div class="d-flex align-items-center gap-2"><i class="fa fa-lock text-danger"></i><strong>Manage Permissions</strong></div>
                                <div class="btn-group">
                                    <button id="toggleAllBtn" class="btn btn-sm btn-outline-secondary">Toggle All Off</button>
                                    <button id="saveBtn" class="btn btn-sm btn-danger"><i class="fa fa-save me-1"></i>Save</button>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="accordion" id="permissionAccordion">

                                    <!-- center template -->
                                    <div class="accordion-item" data-center="Center 1">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#c1">
                                                <span class="center-name"><i class="fa fa-building me-2"></i>Center 1</span>
                                            </button>
                                        </h2>
                                        <div id="c1" class="accordion-collapse collapse show" data-bs-parent="#permissionAccordion">
                                            <div class="accordion-body">
                                                <p class="admin-name"><i class="fa fa-user me-2"></i>Coach John Doe</p>
                                                <div class="module">
                                                    <h6 class="mb-2"><i class="fa fa-table me-2"></i>Dashboard</h6>
                                                    <div class="row gy-2">
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="center_mgmt">
                                                                <label class="form-check-label">Center Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" checked data-key="admission">
                                                                <label class="form-check-label">Admission Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" checked data-key="students">
                                                                <label class="form-check-label">Students Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="events">
                                                                <label class="form-check-label">Event Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="finance">
                                                                <label class="form-check-label">Finance Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="profile">
                                                                <label class="form-check-label">Super Admin Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item" data-center="Center 2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c2">
                                                <span class="center-name"><i class="fa fa-building me-2"></i>Center 2</span>
                                            </button>
                                        </h2>
                                        <div id="c2" class="accordion-collapse collapse" data-bs-parent="#permissionAccordion">
                                            <div class="accordion-body">
                                                <p class="admin-name"><i class="fa fa-user me-2"></i>Coach Jane Smith</p>
                                                <div class="module">
                                                    <h6 class="mb-2"><i class="fa fa-table me-2"></i>Dashboard</h6>
                                                    <div class="row gy-2">
                                                        <!-- reuse same keys for demo, in real app server provides defaults -->
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="center_mgmt">
                                                                <label class="form-check-label">Center Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" checked data-key="admission">
                                                                <label class="form-check-label">Admission Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" checked data-key="students">
                                                                <label class="form-check-label">Students Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="events">
                                                                <label class="form-check-label">Event Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="finance">
                                                                <label class="form-check-label">Finance Management</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input perm" type="checkbox" data-key="profile">
                                                                <label class="form-check-label">Super Admin Profile</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const toggleAllBtn = document.getElementById('toggleAllBtn');
            const saveBtn = document.getElementById('saveBtn');
            const perms = () => [...document.querySelectorAll('.perm')];
            const updateToggle = () => {
                const all = perms();
                toggleAllBtn.textContent = (all.length && all.every(i => i.checked)) ? 'Toggle All Off' : 'Toggle All On'
            }
            toggleAllBtn.onclick = () => {
                const all = perms();
                const on = all.length && all.every(i => i.checked);
                all.forEach(i => i.checked = !on);
                updateToggle()
            }
            document.addEventListener('change', e => {
                if (e.target.classList.contains('perm')) updateToggle()
            })
            saveBtn.onclick = () => {
                const payload = [];
                document.querySelectorAll('.accordion-item').forEach(item => {
                    const center = item.dataset.center || item.querySelector('.center-name')?.textContent?.trim();
                    if (!center) return;
                    const permsArr = [];
                    item.querySelectorAll('.perm').forEach(input => {
                        const label = input.closest('.form-check')?.querySelector('.form-check-label')?.textContent?.trim() || input.dataset.key;
                        permsArr.push({
                            key: input.dataset.key,
                            label,
                            enabled: !!input.checked
                        });
                    });
                    payload.push({
                        center,
                        perms: permsArr
                    });
                });
                console.log('permissions payload', payload);
                // TODO: send to server with fetch('/save', {method:'POST',body:JSON.stringify(payload)})
                bootstrap.Toast && new bootstrap.Toast(document.body).show();
                alert('Permissions ready — check console for payload.');
            }
            updateToggle();

            // sidebar auto-resize (minimal)
            const wrapper = document.getElementById('permissionWrapper');
            document.querySelectorAll('.sidebar-toggle').forEach(btn => btn.addEventListener('click', () => wrapper.classList.toggle('min')));
        })();
    </script>
</body>

</html>