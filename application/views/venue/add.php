<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Venue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fb; }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add New Venue</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('venue/save') ?>" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="venue_name" class="form-label">Venue Name</label>
                                <input type="text" class="form-control" id="venue_name" name="venue_name" required>
                                <div class="invalid-feedback">
                                    Please enter a venue name.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                                <div class="invalid-feedback">
                                    Please enter a location.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="num_courts" class="form-label">Number of Courts</label>
                                <input type="number" class="form-control" id="num_courts" name="num_courts" min="1" required>
                                <div class="invalid-feedback">
                                    Please enter the number of courts.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Venue Password (Optional)</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-text">Set a password if you want to restrict access to this venue.</div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= base_url('venue') ?>" class="btn btn-light me-md-2">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Venue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>