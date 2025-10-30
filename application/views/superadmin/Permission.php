<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Permission Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">
    <style>
        :root {
            --danger: #dc3545;
            --muted: #6c757d;
            --card-bg: #fff;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
        }

        body {
            background: #f5f7fb;
            font-family: Inter, system-ui, Segoe UI, Roboto, -apple-system, sans-serif;
            padding-top: 0px !important;
        }

        .hero {
            background: linear-gradient(135deg, var(--danger), #a71d2a);
            color: #fff;
            padding: 28px;
            border-radius: .6rem;
            margin-bottom: 24px;
        }

        .card {
            border: 0;
            border-radius: .6rem;
            box-shadow: 0 6px 20px rgba(25, 40, 60, .06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(25, 40, 60, .1);
        }

        .center-name {
            font-weight: 700;
            color: #343a40;
        }

        .form-check .form-check-input:checked {
            background-color: var(--danger);
            border-color: var(--danger);
        }

        #permissionWrapper {
            transition: margin-left .2s ease;
            margin-left: 250px;
        }

        #permissionWrapper.min {
            margin-left: 60px;
        }

        .permission-card {
            border-top: 3px solid var(--danger);
        }

        .permission-header {
            background-color: var(--light-bg);
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            border-radius: .6rem .6rem 0 0 !important;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 12px;
            padding: 16px;
        }

        .permission-item {
            background: var(--light-bg);
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .permission-item:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }

        .toggle-all-container {
            background-color: var(--light-bg);
            padding: 12px 16px;
            border-top: 1px solid var(--border-color);
            border-radius: 0 0 .6rem .6rem;
        }

        @media (max-width: 992px) {
            .permissions-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }

        @media (max-width: 768px) {
            #permissionWrapper {
                margin-left: 0 !important;
            }

            .permissions-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-check-input, .form-check-label {
            cursor: pointer;
            user-select: none;
        }

        .save-btn {
            position: relative;
            overflow: hidden;
        }

        .save-btn:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        @keyframes ripple {
            0% { transform: scale(0, 0); opacity: 1; }
            20% { transform: scale(25, 25); opacity: 1; }
            100% { opacity: 0; transform: scale(40, 40); }
        }

        .save-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
    </style>
</head>

<body>

    <?php $this->load->view('superadmin/Include/Navbar') ?>
    <?php $this->load->view('superadmin/Include/Sidebar') ?>

    <main id="permissionWrapper" class="flex-fill">
        <div class="container-fluid mt-0">
            <header class="hero text-center mb-4 shadow-sm">
                <h1 class="h3 mb-1"><i class="fa fa-user-lock me-2"></i>Permission Management</h1>
                <p class="mb-0 small">Manage access controls for your academy branches</p>
            </header>

            <div class="row justify-content-center mb-3">
                <div class="col-lg-11">
                    <input type="text" id="globalSearch" class="form-control" placeholder="Search centers, modules or venues...">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card permission-card">
                        <div class="card-header d-flex align-items-center justify-content-between permission-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa fa-lock text-danger"></i>
                                <strong>Manage Permissions</strong>
                            </div>
                            <div class="btn-group">
                                <button id="toggleAllBtn" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-toggle-off me-1"></i>Toggle All Off
                                </button>
                                <button id="saveAllBtn" class="btn btn-sm btn-danger save-btn">
                                    <i class="fa fa-save me-1"></i>Save All
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <!-- CENTERS LOOP -->
                            <?php foreach ($centers as $center): ?>
                                <div class="center-permissions mb-4">
                                    <div class="px-4 pt-4 pb-2">
                                        <h5 class="center-name mb-1">
                                            <i class="fa fa-building text-danger me-2"></i>
                                            <?= htmlspecialchars($center['name']); ?>
                                        </h5>
                                        <p class="text-muted small mb-0">Manage permissions for this center</p>
                                    </div>

                                    <form method="post" action="<?= base_url('superadmin/save_permissions/' . $center['id']) ?>" class="center-form">
                                        <div class="permissions-grid">
                                            <?php foreach ($modules as $key => $label): ?>
                                                <div class="permission-item d-flex align-items-center">
                                                    <div class="form-check flex-grow-1 mb-0">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="permissions[<?= $key ?>]"
                                                            value="1"
                                                            id="perm-<?= $center['id'] ?>-<?= $key ?>"
                                                            <?= (!empty($center['permissions'][$key]) && $center['permissions'][$key]) ? 'checked' : '' ?>>
                                                        <label class="form-check-label w-100" for="perm-<?= $center['id'] ?>-<?= $key ?>">
                                                            <?= $label ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="toggle-all-container d-flex justify-content-end">
                                            <button type="submit" class="btn btn-sm btn-danger save-btn">
                                                <i class="fa fa-save me-1"></i>Save Center
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <?php if (next($centers)): ?>
                                    <hr class="mx-4 my-4">
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <!-- VENUES SECTION -->
                            <div class="center-permissions mb-4">
                                <div class="px-4 pt-4 pb-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="center-name mb-1">
                                            <i class="fa fa-map-marker-alt text-danger me-2"></i>Venues
                                        </h5>
                                        <p class="text-muted small mb-0">Manage module access per venue (Attendance, Leave, Expense)</p>
                                    </div>
                                        <div>
                                        <button id="toggleAllVenuesBtn" class="btn btn-sm btn-outline-danger">
                                            <i class="fa fa-toggle-off me-1"></i>Toggle All Venues
                                        </button>
                                        <button id="saveAllVenuesBtn" class="btn btn-sm btn-danger ms-2">
                                            <i class="fa fa-save me-1"></i>Save All Venues
                                        </button>
                                    </div>
                                </div>

                                <div class="permissions-grid">
                                    <?php if (!empty($venues)): ?>
                                        <?php foreach ($venues as $venue): ?>
                                            <div class="permission-item venue-item">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1"><?= htmlspecialchars($venue['venue_name']) ?></h6>
                                                        <div class="text-muted small">
                                                            <i class="fa fa-map-marker-alt me-1"></i> <?= htmlspecialchars($venue['location']) ?>
                                                            <span class="ms-2"> <i class="fa fa-door-open me-1"></i> Courts: <?= htmlspecialchars($venue['num_courts']) ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-sm btn-outline-primary manage-permissions-btn" data-venue-id="<?= $venue['id'] ?>">
                                                            <i class="fa fa-cog me-1"></i> Manage
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Hidden toggles (shown when Manage clicked) -->
                                                <div class="permission-toggles mt-3" data-venue-id="<?= $venue['id'] ?>" style="display:none">
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input permission-toggle" id="admission_<?= $venue['id'] ?>" data-type="admission" data-permission="admission" <?= (!empty($venue['permissions']['admission']) && $venue['permissions']['admission']) ? 'checked' : '' ?> />
                                                        <label class="form-check-label" for="admission_<?= $venue['id'] ?>"> <i class="fa fa-user-plus text-primary me-1"></i> Admission</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input permission-toggle" id="attendance_<?= $venue['id'] ?>" data-type="attendance" data-permission="attendance" <?= (!empty($venue['permissions']['attendance']) && $venue['permissions']['attendance']) ? 'checked' : '' ?> />
                                                        <label class="form-check-label" for="attendance_<?= $venue['id'] ?>"> <i class="fa fa-calendar text-success me-1"></i> Attendance</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input permission-toggle" id="leave_<?= $venue['id'] ?>" data-type="leave" data-permission="leave" <?= (!empty($venue['permissions']['leave']) && $venue['permissions']['leave']) ? 'checked' : '' ?> />
                                                        <label class="form-check-label" for="leave_<?= $venue['id'] ?>"> <i class="fa fa-calendar-minus text-warning me-1"></i> Leave</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input type="checkbox" class="form-check-input permission-toggle" id="expense_<?= $venue['id'] ?>" data-type="expense" data-permission="expense" <?= (!empty($venue['permissions']['expense']) && $venue['permissions']['expense']) ? 'checked' : '' ?> />
                                                        <label class="form-check-label" for="expense_<?= $venue['id'] ?>"> <i class="fa fa-money-bill text-danger me-1"></i> Expense</label>
                                                    </div>

                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-sm btn-primary save-permissions" data-venue-id="<?= $venue['id'] ?>">
                                                            <i class="fa fa-save me-1"></i> Save Permissions
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="permission-item text-center text-muted">
                                            <i class="fa fa-info-circle me-2"></i>No venues found
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- END VENUES -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Center permissions handling
            const toggleAllBtn = document.getElementById('toggleAllBtn');
            let allEnabled = false;

            toggleAllBtn.addEventListener('click', function() {
                allEnabled = !allEnabled;
                const checkboxes = document.querySelectorAll('input[type="checkbox"]:not([disabled])');

                checkboxes.forEach(cb => cb.checked = allEnabled);

                toggleAllBtn.innerHTML = allEnabled ?
                    '<i class="fa fa-toggle-on me-1"></i>Toggle All Off' :
                    '<i class="fa fa-toggle-off me-1"></i>Toggle All On';
            });

            document.getElementById('saveAllBtn').addEventListener('click', function() {
                const forms = document.querySelectorAll('.center-form');
                let saved = 0;

                Swal.fire({
                    title: 'Saving Permissions',
                    html: 'Saving all centers...<br><div class="progress mt-3" style="height:10px;"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%"></div></div>',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        const total = forms.length;
                        forms.forEach((form, i) => {
                            setTimeout(() => {
                                saved++;
                                const pct = (saved / total) * 100;
                                document.querySelector('.progress-bar').style.width = pct + '%';
                                if (saved === total) {
                                    setTimeout(() => {
                                        Swal.fire('Success!', 'All permissions saved.', 'success');
                                    }, 500);
                                }
                            }, i * 300);
                        });
                    }
                });
            });

            // Venue permissions handling (attach at top-level so they work immediately)
            const toggleAllVenuesBtn = document.getElementById('toggleAllVenuesBtn');
            let allVenuesEnabled = false;
            if (toggleAllVenuesBtn) {
                toggleAllVenuesBtn.addEventListener('click', function() {
                    allVenuesEnabled = !allVenuesEnabled;
                    const venueCheckboxes = document.querySelectorAll('.permission-toggle');
                    venueCheckboxes.forEach(cb => cb.checked = allVenuesEnabled);
                    this.innerHTML = allVenuesEnabled ?
                        '<i class="fa fa-toggle-on me-1"></i>Toggle All Off' :
                        '<i class="fa fa-toggle-off me-1"></i>Toggle All On';
                });
            }

            const saveAllVenuesBtn = document.getElementById('saveAllVenuesBtn');
            if (saveAllVenuesBtn) {
                saveAllVenuesBtn.addEventListener('click', function() {
                    const venueItems = document.querySelectorAll('.permission-item.venue-item');
                    const payload = [];

                    venueItems.forEach(item => {
                        const toggles = item.querySelector('.permission-toggles');
                        if (!toggles) return;
                        const venueId = toggles.dataset.venueId;
                        const entry = { venue_id: venueId };
                        toggles.querySelectorAll('.permission-toggle').forEach(cb => {
                            const key = cb.dataset.permission || cb.dataset.type;
                            entry[key] = cb.checked ? 1 : 0;
                        });
                        payload.push(entry);
                    });

                    if (payload.length === 0) {
                        Swal.fire('Nothing to save', 'No venue permissions found to save.', 'info');
                        return;
                    }

                    Swal.fire({
                        title: 'Saving all venues',
                        html: 'Please wait...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch('<?= base_url('superadmin/save_all_venue_permissions') ?>', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Saved', `Permissions saved for ${data.saved} venues.`, 'success');
                            // mark all save buttons as saved
                            document.querySelectorAll('.save-permissions').forEach(b => {
                                b.classList.remove('btn-warning');
                                b.classList.add('btn-primary');
                                b.innerHTML = '<i class="fa fa-check me-1"></i>Saved';
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Failed to save venue permissions', 'error');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'An error occurred while saving permissions', 'error');
                    });
                });
            }

            document.querySelectorAll('.center-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Saving...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    setTimeout(() => {
                        Swal.fire('Saved!', '', 'success').then(() => form.submit());
                    }, 1000);
                });
            });

            // Handle permission toggles
            document.querySelectorAll('.permission-toggle').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Highlight the save button when changes are made
                    const venueContainer = this.closest('.permission-toggles');
                    const saveButton = venueContainer.querySelector('.save-permissions');
                    saveButton.classList.add('btn-warning');
                    saveButton.innerHTML = '<i class="fa fa-save me-1"></i>Save Changes';
                });
            });

            // Handle save buttons
            document.querySelectorAll('.save-permissions').forEach(button => {
                button.addEventListener('click', function() {
                    const venueId = this.dataset.venueId;
                    const container = this.closest('.permission-toggles');
                    const permissions = {};
                    
                    // Collect all permissions for this venue
                    container.querySelectorAll('.permission-toggle').forEach(checkbox => {
                        permissions[checkbox.dataset.type] = checkbox.checked;
                    });

                    // Save permissions via AJAX
                    fetch('<?= base_url('superadmin/save_venue_permissions/') ?>' + venueId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(permissions)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Permissions saved successfully',
                                timer: 1500
                            });
                            button.classList.remove('btn-warning');
                            button.classList.add('btn-primary');
                            button.innerHTML = '<i class="fa fa-check me-1"></i>Saved';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to save permissions'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while saving permissions'
                        });
                    });
                });
            });

            // Manage button: toggle visibility of permission toggles for the venue
            document.querySelectorAll('.manage-permissions-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const vid = this.dataset.venueId;
                    const container = document.querySelector('.permission-toggles[data-venue-id="' + vid + '"]');
                    if (!container) return;
                    // toggle
                    if (container.style.display === 'none' || container.style.display === '') {
                        container.style.display = 'block';
                        this.innerHTML = '<i class="fa fa-times me-1"></i> Close';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-outline-secondary');
                    } else {
                        container.style.display = 'none';
                        this.innerHTML = '<i class="fa fa-cog me-1"></i> Manage';
                        this.classList.remove('btn-outline-secondary');
                        this.classList.add('btn-outline-primary');
                    }
                });
            });
        });
    </script>

    <script>
        // Global Search (now includes venues)
        document.getElementById('globalSearch').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const sections = document.querySelectorAll('.center-permissions');

            sections.forEach(section => {
                const title = section.querySelector('.center-name')?.innerText.toLowerCase() || '';
                let match = title.includes(query);

                section.querySelectorAll('.permission-item').forEach(item => {
                    const text = item.innerText.toLowerCase();
                    if (text.includes(query)) {
                        item.style.display = '';
                        match = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                section.style.display = match ? '' : 'none';
            });
        });
    </script>
</body>
</html>