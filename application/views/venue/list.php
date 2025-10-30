<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fb; }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .venue-card {
            transition: transform 0.2s;
        }
        .venue-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Venue Management</h4>
                        <a href="<?= base_url('venue/add') ?>" class="btn btn-light">
                            <i class="fas fa-plus"></i> Add New Venue
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="<?= base_url('venue/search') ?>" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="term" class="form-control" placeholder="Search venues...">
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

                        <!-- Venues Grid -->
                        <div class="row g-4">
                            <?php foreach($venues as $venue): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card venue-card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($venue['venue_name']) ?></h5>
                                            <p class="card-text">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <?= htmlspecialchars($venue['location']) ?>
                                            </p>
                                            <p class="card-text">
                                                <i class="fas fa-volleyball-ball text-primary"></i>
                                                <?= htmlspecialchars($venue['num_courts']) ?> Courts
                                            </p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    Created: <?= date('M d, Y', strtotime($venue['created_at'])) ?>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0">
                                            <div class="btn-group w-100">
                                                <a href="<?= base_url('venue/edit/'.$venue['id']) ?>" 
                                                   class="btn btn-outline-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger"
                                                        onclick="confirmDelete(<?= $venue['id'] ?>)">
                                                    <i class="fas fa-trash"></i> Delete
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
        function confirmDelete(venueId) {
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
                    window.location.href = '<?= base_url('venue/delete/') ?>' + venueId;
                }
            });
        }
    </script>
</body>
</html>