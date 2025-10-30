<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f5f7fb; 
            padding-top: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .office-stats {
            background: linear-gradient(45deg, #4158d0, #c850c0);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>

    <div class="container-fluid">
        <!-- Header Stats -->
        <div class="row">
            <div class="col-md-12">
                <div class="office-stats">
                    <div class="row">
                        <div class="col-md-3">
                            <h4>Total Offices</h4>
                            <h2><?= count($offices) ?></h2>
                        </div>
                        <div class="col-md-3">
                            <h4>Total Staff</h4>
                            <h2>-</h2>
                        </div>
                        <div class="col-md-3">
                            <h4>Active Facilities</h4>
                            <h2>-</h2>
                        </div>
                        <div class="col-md-3">
                            <h4>Locations</h4>
                            <h2>-</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Office Management</h4>
                        <a href="<?= base_url('office/add') ?>" class="btn btn-light">
                            <i class="fas fa-plus"></i> Add New Office
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="<?= base_url('office/search') ?>" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" 
                                       name="term" 
                                       class="form-control" 
                                       placeholder="Search offices..."
                                       value="<?= isset($search_term) ? $search_term : '' ?>">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>

                        <!-- Flash Messages -->
                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Offices Grid -->
                        <div class="row g-4">
                            <?php foreach($offices as $office): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <i class="fas fa-building text-primary"></i>
                                                <?= htmlspecialchars($office['office_name']) ?>
                                            </h5>
                                            <p class="card-text">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <?= htmlspecialchars($office['location']) ?>
                                            </p>
                                            <p class="card-text">
                                                <i class="fas fa-phone text-success"></i>
                                                <?= htmlspecialchars($office['contact_number']) ?>
                                            </p>
                                            <p class="card-text">
                                                <i class="fas fa-user text-info"></i>
                                                Head: <?= htmlspecialchars($office['office_head']) ?>
                                            </p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    <?= htmlspecialchars($office['working_hours']) ?>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0">
                                            <div class="btn-group w-100">
                                                <a href="<?= base_url('office/view/'.$office['id']) ?>" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="<?= base_url('office/edit/'.$office['id']) ?>" 
                                                   class="btn btn-outline-secondary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger"
                                                        onclick="confirmDelete(<?= $office['id'] ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if(isset($links)): ?>
                            <div class="mt-4">
                                <?= $links ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(officeId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('office/delete/') ?>' + officeId;
                }
            });
        }
    </script>
</body>
</html>