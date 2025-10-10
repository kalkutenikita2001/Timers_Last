<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Center Management </title>
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
  <style>
    :root {
      --primary-color: #007bff;
      --accent-color: #ff4d4f;
      --background-color: #f8fafc;
      --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      --card-hover-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      --button-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    body {
      background-color: var(--background-color) !important;
      margin: 0;
      font-family: 'Inter', sans-serif !important;
      overflow-x: hidden;
      min-height: 100vh;
    }
    .content-wrapper {
      margin-left: 250px;
      padding: 80px 20px 20px 20px;
      transition: var(--transition);
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .center-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px;
      border-left: 4px solid var(--accent-color);
      box-shadow: var(--card-shadow);
      margin-bottom: 20px;
      transition: var(--transition);
    }
    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--card-hover-shadow);
    }
    .card-details p {
      margin: 8px 0;
      font-size: 0.9rem;
      color: #2d3748;
      line-height: 1.6;
    }
    .card-details p:first-child {
      font-size: 1.1rem;
      font-weight: 600;
    }
    .card-details p span {
      font-weight: 500;
      color: #1a202c;
    }
    .btn-primary {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 500;
      transition: var(--transition);
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .filter-btn {
      background: #ffffff;
      color: #1a202c;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 15px;
      font-weight: 500;
      box-shadow: var(--button-shadow);
      transition: var(--transition);
    }
    .filter-btn:hover {
      background: linear-gradient(135deg, #f7fafc, #edf2f7);
      transform: translateY(-2px);
    }
    .modal-content {
      border-radius: 12px;
      padding: 30px;
      border: 2px solid var(--primary-color);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 20px;
      color: #1a202c;
    }
    .modal-close-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #4a5568;
      cursor: pointer;
      transition: var(--transition);
    }
    .modal-close-btn:hover {
      color: var(--accent-color);
      transform: scale(1.1);
    }
    .form-group {
      margin-bottom: 1.5rem;
    }
    .form-group label {
      font-weight: 500;
      font-size: 0.95rem;
      color: #2d3748;
      margin-bottom: 10px;
      display: block;
    }
    .form-control {
      height: 44px;
      border-radius: 8px;
      font-size: 0.95rem;
      border: 1px solid #e2e8f0;
      transition: var(--transition);
    }
    .form-control:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 8px rgba(255, 77, 79, 0.2);
    }
    .form-control::placeholder {
      color: #a0aec0;
    }
    .form-group select.form-control {
      appearance: none;
      background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path fill="%234a5568" d="M7 10l5 5 5-5z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 14px;
    }
    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 60px 12px 12px;
      }
      .center-card {
        padding: 15px;
        font-size: 0.85rem;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
        padding: 70px 18px 18px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
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
    <h4>Center Management</h4>

    <div class="filter-wrapper mb-4 d-flex justify-content-between align-items-center">
      <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal">
        <i class="fas fa-filter mr-2"></i> Filter
      </button>
      <a href="<?php echo base_url('superadmin/add_new_center'); ?>" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i> Add Center
      </a>
    </div>

    <div class="row" id="centerCards">
      <!-- Centers will be loaded here -->
    </div>
  </div>
</div>

<!-- New Center Modal (kept as-is) -->
<div class="modal fade" id="newCenterModal" tabindex="-1" aria-labelledby="newCenterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
      <h3 id="newCenterLabel">Add Center Details</h3>
      <form id="centerForm">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="center_name">Center Name <span class="text-danger">*</span></label>
            <input type="text" id="center_name" name="center_name" class="form-control" required placeholder="Enter Center Name" />
          </div>
          <div class="form-group col-md-6">
            <label for="center_timing">Timing From <span class="text-danger">*</span></label>
            <input type="time" id="center_timing" name="center_timing" class="form-control" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="center_rent">Center Rent <span class="text-danger">*</span></label>
            <input type="number" id="center_rent" name="center_rent" class="form-control" required placeholder="Enter Rent Amount" />
          </div>
          <div class="form-group col-md-6">
            <label for="center_rent_date">Rent Date <span class="text-danger">*</span></label>
            <input type="date" id="center_rent_date" name="center_rent_date" class="form-control" required />
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="centerSubmitBtn">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
      <h3 id="filterLabel">Filter Centers</h3>
      <form id="filterForm">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="filterCenterName">Center Name</label>
            <input type="text" id="filterCenterName" name="filterCenterName" class="form-control" placeholder="Enter center name" />
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary">Apply Filter</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Center Modal -->
<div class="modal fade" id="editCenterModal" tabindex="-1" aria-labelledby="editCenterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
      </button>
      <h3 id="editCenterLabel">Edit Center Details</h3>
      <form id="editCenterForm">
        <input type="hidden" id="edit_center_id" name="id" />
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="edit_center_name">Center Name <span class="text-danger">*</span></label>
            <input type="text" id="edit_center_name" name="name" class="form-control" required />
          </div>
          <div class="form-group col-md-6">
            <label for="edit_center_number">Center Number</label>
            <input type="text" id="edit_center_number" name="center_number" class="form-control" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="edit_center_address">Address</label>
            <input type="text" id="edit_center_address" name="address" class="form-control" />
          </div>
          <div class="form-group col-md-6">
            <label for="edit_center_rent">Center Rent</label>
            <input type="number" id="edit_center_rent" name="rent_amount" class="form-control" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="edit_center_rent_date">Rent Date</label>
            <input type="date" id="edit_center_rent_date" name="rent_paid_date" class="form-control" />
          </div>
          <div class="form-group col-md-6">
            <label for="edit_center_timing_from">Timing From</label>
            <input type="time" id="edit_center_timing_from" name="center_timing_from" class="form-control" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="edit_center_timing_to">Timing To</label>
            <input type="time" id="edit_center_timing_to" name="center_timing_to" class="form-control" />
          </div>
        </div>

        <div class="d-flex justify-content-center">
          <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>-->
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
<button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Close">
    <i class="fas fa-times"></i>
</button>
          <button type="button" class="btn btn-primary" id="editCenterSubmitBtn">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Cancel button click
    document.querySelectorAll('[data-dismiss="modal"], [data-bs-dismiss="modal"]').forEach(function(btn) {
        btn.addEventListener("click", function () {
            const modal = btn.closest(".modal");
            if (modal) {
                $(modal).modal('hide'); // for Bootstrap 4 (jQuery required)
                // For Bootstrap 5 without jQuery:
                // const modalInstance = bootstrap.Modal.getInstance(modal);
                // modalInstance.hide();
            }
        });
    });
});
</script>

<script>
  $(document).ready(function() {

    // Load Centers from API
    function loadCenters() {
      $.ajax({
        url: "<?php echo base_url('Center/getAllcenters'); ?>",
        method: "GET",
        dataType: "json",
        success: function(response) {
          $('#centerCards').empty();

          if (response.status && response.data.length > 0) {
            response.data.forEach(center => {
              let card = `
                <div class="col-md-4" id="centerCard_${center.id}">
                  <div class="center-card">
                    <div class="card-details">
                      <p><b>${escapeHtml(center.name)}</b></p>
                      <p><span>Timing:</span> ${center.center_timing_from || ''} - ${center.center_timing_to || ''}</p>
                      <p><span>Rent:</span> ₹${center.rent_amount || '0'}</p>
                      <p><span>Rent Date:</span> ${center.rent_paid_date || ''}</p>

                      <div class="mt-3 d-flex" style="gap:8px;">
                        <button class="btn btn-primary view-btn" data-center-id="${center.id}">View Details</button>

                        <button class="btn btn-outline-secondary edit-center-btn" data-center-id="${center.id}">
                          <i class="fas fa-edit"></i> Edit
                        </button>

                        <button class="btn btn-danger delete-center-btn" data-center-id="${center.id}">
                          <i class="fas fa-trash-alt"></i> Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>`;
              $('#centerCards').append(card);
            });
          } else {
            $('#centerCards').html('<p class="text-center w-100">No centers found</p>');
          }
        },
        error: function() {
          $('#centerCards').html('<p class="text-center w-100 text-danger">Error loading centers</p>');
        }
      });
    }

    // Escape helper to avoid HTML injection
    function escapeHtml(text) {
      if (text === null || text === undefined) return '';
      return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    // Redirect to Center Details
    $(document).on('click', '.view-btn', function() {
      const centerId = $(this).data('center-id');
      window.location.href = '<?php echo base_url("superadmin/view_center_details"); ?>?center_id=' + centerId;
    });

    // Submit new center (demo only — kept original behavior)
    $('#centerSubmitBtn').click(function(e) {
      e.preventDefault();
      const form = $('#centerForm')[0];
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Center added successfully!',
        confirmButtonText: 'OK'
      }).then(() => {
        $('#newCenterModal').modal('hide');
        $('#centerForm').trigger('reset');
        loadCenters();
      });
    });

    // Filter Centers (client-side)
    $('#filterForm').on('submit', function(e) {
      e.preventDefault();
      let filterName = $('#filterCenterName').val().toLowerCase();

      $('.center-card').each(function() {
        const centerName = $(this).find('p:first').text().toLowerCase();
        if (centerName.includes(filterName)) {
          $(this).parent().show();
        } else {
          $(this).parent().hide();
        }
      });

      $('#filterModal').modal('hide');
    });

    // DELETE center
    $(document).on('click', '.delete-center-btn', function() {
      const centerId = $(this).data('center-id');

      Swal.fire({
        title: 'Are you sure?',
        html: 'Deleting this center will <b>also delete all related student records</b>. This action is irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        focusCancel: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?php echo base_url('Center/deleteCenterbyId/'); ?>" + centerId,
            method: "POST",
            dataType: "json",
            success: function(res) {
              if (res.status) {
                // remove card from UI
                $('#centerCard_' + centerId).fadeOut(300, function() { $(this).remove(); });

                Swal.fire({
                  icon: 'success',
                  title: 'Deleted!',
                  text: res.message || 'Center and related students deleted successfully.'
                });
              } else {
                Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Could not delete center.' });
              }
            },
            error: function() {
              Swal.fire({ icon: 'error', title: 'Error', text: 'Server error while deleting center.' });
            }
          });
        }
      });
    });

    // EDIT center - open modal and populate via GET to /Center/getCenterById/{id}
    $(document).on('click', '.edit-center-btn', function() {
      const centerId = $(this).data('center-id');
      $.ajax({
        url: "<?php echo base_url('Center/getCenterById/'); ?>" + centerId,
        method: "GET",
        dataType: "json",
        success: function(res) {
          if (res.status === 'success' || res.status === true) {
            // your controller sometimes returns {status: "success", center: {...}} or {status:true, data:...}
            // Normalize:
            const c = res.center || res.data || res;
            // if res contains the center object nested as 'center' or 'data'
            const centerObj = c.center || c.data || c;
            // but your controller returns {status:true, data: centerArray} in some endpoints
            // handle common shapes:
            let centerData = null;
            if (res.center) centerData = res.center;
            else if (res.data && typeof res.data === 'object' && !Array.isArray(res.data)) centerData = res.data;
            else if (res.data && Array.isArray(res.data) && res.data.length > 0) centerData = res.data[0];
            else if (res.name || res.id) centerData = res;
            else if (c && c.name) centerData = c;

            if (!centerData) {
              // try fallback: if response itself has center keys
              centerData = res;
            }

            // Populate fields (guard undefined)
            $('#edit_center_id').val(centerData.id || '');
            $('#edit_center_name').val(centerData.name || '');
            $('#edit_center_number').val(centerData.center_number || '');
            $('#edit_center_address').val(centerData.address || '');
            $('#edit_center_rent').val(centerData.rent_amount || '');
            let rentDate = centerData.rent_paid_date && centerData.rent_paid_date !== '0000-00-00' ? centerData.rent_paid_date : '';
            $('#edit_center_rent_date').val(rentDate);
            $('#edit_center_timing_from').val(centerData.center_timing_from || '');
            $('#edit_center_timing_to').val(centerData.center_timing_to || '');
            $('#editCenterModal').modal('show');
          } else {
            // handle other shapes where status:false
            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Could not fetch center details.' });
          }
        },
        error: function() {
          Swal.fire({ icon: 'error', title: 'Error', text: 'Server error while fetching center details.' });
        }
      });
    });

    // Save edit (sends JSON to updateCenter)
    $('#editCenterSubmitBtn').click(function(e) {
      e.preventDefault();
      const form = $('#editCenterForm')[0];
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }

      const payload = {
        id: $('#edit_center_id').val(),
        name: $('#edit_center_name').val(),
        center_number: $('#edit_center_number').val(),
        address: $('#edit_center_address').val(),
        rent_amount: $('#edit_center_rent').val(),
        rent_paid_date: $('#edit_center_rent_date').val(),
        center_timing_from: $('#edit_center_timing_from').val(),
        center_timing_to: $('#edit_center_timing_to').val()
      };

      $.ajax({
        url: "<?php echo base_url('Center/updateCenter'); ?>",
        method: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: JSON.stringify(payload),
        success: function(res) {
          // your updateCenter returns {status:'success', message:...} or similar
          if (res.status === 'success' || res.status === true) {
            $('#editCenterModal').modal('hide');
            Swal.fire({ icon: 'success', title: 'Saved', text: res.message || 'Center updated.' }).then(()=>{
              loadCenters(); // refresh list
            });
          } else {
            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Could not update center.' });
          }
        },
        error: function() {
          Swal.fire({ icon: 'error', title: 'Error', text: 'Server error while updating center.' });
        }
      });
    });

    // Initialize
    loadCenters();
  });

  // Sidebar toggle functionality (kept as-is)
  $('#sidebarToggle').on('click', function () {
    if ($(window).width() <= 576) {
      $('#sidebar').toggleClass('active');
      $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
    } else {
      const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
      $('.navbar').toggleClass('sidebar-minimized', isMinimized);
      $('#contentWrapper').toggleClass('minimized', isMinimized);
    }
  });
  
  // Sidebar toggle functionality
      $('#sidebarToggle').on('click', function () {
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
