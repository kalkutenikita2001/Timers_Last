<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Center Management UI</title>
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
    .inner-layout {
      display: flex;
      gap: 20px;
    }
    .inner-sidebar {
      width: 220px;
      padding: 15px 10px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, #ff4d4f 0%, #470000 100%) !important;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      position: sticky;
      top: 90px;
      height: fit-content;
    }
    .inner-sidebar .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: var(--transition);
    }
    .inner-sidebar .menu-item i {
      color: #ffecec;
      font-size: 16px;
      transition: color 0.25s ease;
    }
    .inner-sidebar .menu-item:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateX(5px);
    }
    .inner-sidebar .menu-item:hover i {
      color: #fff;
    }
    .inner-sidebar .menu-item.active {
      background: #fff;
      color: #470000;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }
    .inner-sidebar .menu-item.active i {
      color: #470000;
    }
    .details-area {
      flex: 1;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: var(--card-shadow);
    }
    .section-content {
      display: none;
    }
    .section-content.active {
      display: block;
    }
    h4 {
      font-weight: 600;
      font-size: 20px;
      color: #1a202c;
      margin-bottom: 15px;
    }
    .section-title {
      font-weight: 600;
      font-size: 16px;
      color: #2d3748;
      margin-bottom: 10px;
    }
    .center-card, .batch-card, .facility-card, .staff-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px;
      border-left: 4px solid var(--accent-color);
      box-shadow: var(--card-shadow);
      margin-bottom: 20px;
      transition: var(--transition);
    }
    .center-card:hover, .batch-card:hover, .facility-card:hover, .staff-card:hover {
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
    .btn-secondary {
      background: #e2e8f0;
      color: #4a5568;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 500;
      transition: var(--transition);
    }
    .btn-secondary:hover {
      background: #cbd5e0;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-edit {
      background: linear-gradient(135deg, #ff4d4f, #470000);
      color: white;
      border: none;
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 13px;
    }
    .btn-edit:hover {
      background: #300000;
      color: white;
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
    .batch-entry, .facility-entry, .staff-entry {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
      background: #f7fafc;
      position: relative;
    }
    .remove-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 5px 10px;
      font-size: 0.85rem;
      background: #e2e8f0;
      color: #4a5568;
      border-radius: 8px;
      transition: var(--transition);
    }
    .remove-btn:hover {
      background: #cbd5e0;
      transform: translateY(-2px);
    }
    .progress-container {
      margin-bottom: 20px;
    }
    .progress-bar {
      background: linear-gradient(135deg, #ff4d4f, #470000);
    }
    .filter-wrapper {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
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
    @media (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 60px 12px 12px;
      }
      .inner-layout {
        flex-direction: column;
      }
      .inner-sidebar {
        width: 100%;
        position: static;
      }
      .center-card, .batch-card, .facility-card, .staff-card {
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
      .inner-sidebar {
        width: 200px;
      }
    }
  </style>
</head>
<body>
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <?php $this->load->view('superadmin/Include/Navbar') ?>
  <div class="content-wrapper" id="contentWrapper">
    <div class="container">
      <div class="inner-layout">
       
        <!-- Details Area -->
        <div class="details-area">
          <div class="progress-container">
            
          </div>
          <!-- Section: Center Details -->
          <div class="section-content active" id="centerDetails">
            <h4>Center Details</h4>
            <div class="filter-wrapper">
              <button class="filter-btn btn" data-toggle="modal" data-target="#filterModal">
                <i class="fas fa-filter mr-2"></i> Filter
              </button>
            </div>
            <div class="row" id="centerCards"></div>
            <div class="text-center mt-4">
              <button class="btn btn-primary" data-toggle="modal" data-target="#newCenterModal">
                <i class="fas fa-plus mr-2"></i> Add Center
              </button>
            </div>
          </div>
          <!-- Section: Batch Management -->
          <div class="section-content" id="batchManagement">
            <h4>Batch Management</h4>
            <div id="batchCards"></div>
            <div class="text-right mt-4">
              <button type="button" class="btn btn-secondary back-btn" onclick="navigateTo('batchManagement', 'centerDetails')">
                <i class="fas fa-arrow-left"></i> Back
              </button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#batchModal">
                <i class="fas fa-plus"></i> Add Batch
              </button>
              <button type="button" class="btn btn-primary next-btn" onclick="navigateTo('batchManagement', 'facilityManagement')">
                Next <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>
          <!-- Section: Facility Management -->
          <div class="section-content" id="facilityManagement">
            <h4>Facility Management</h4>
            <div id="facilityCards"></div>
            <div class="text-right mt-4">
              <button type="button" class="btn btn-secondary back-btn" onclick="navigateTo('facilityManagement', 'batchManagement')">
                <i class="fas fa-arrow-left"></i> Back
              </button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#facilityModal">
                <i class="fas fa-plus"></i> Add Facility
              </button>
              <button type="button" class="btn btn-primary next-btn" onclick="navigateTo('facilityManagement', 'staffManagement')">
                Next <i class="fas fa-arrow-right"></i>
              </button>
            </div>
          </div>
          <!-- Section: Staff Management -->
          <div class="section-content" id="staffManagement">
            <h4>Staff Management</h4>
            <div id="staffCards"></div>
            <div class="text-right mt-4">
              <button type="button" class="btn btn-secondary back-btn" onclick="navigateTo('staffManagement', 'facilityManagement')">
                <i class="fas fa-arrow-left"></i> Back
              </button>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staffModal">
                <i class="fas fa-plus"></i> Add Staff
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- New Center Modal -->
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
              <label for="center_timing">Timing <span class="text-danger">*</span></label>
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
            <button type="button" class="btn btn-primary" id="centerNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Batch Modal -->
  <div class="modal fade" id="batchModal" tabindex="-1" aria-labelledby="batchLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="batchLabel">Add Batch</h3>
        <form id="batchForm">
          <div id="batchEntries">
            <div class="batch-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_timing_0">Batch Timing <span class="text-danger">*</span></label>
                  <input type="time" id="batch_timing_0" name="batch_timing[]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="start_date_0">Start Date <span class="text-danger">*</span></label>
                  <input type="date" id="start_date_0" name="start_date[]" class="form-control" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_category_0">Category <span class="text-danger">*</span></label>
                  <select id="batch_category_0" name="batch_category[]" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                  </select>
                </div>
              </div>
              <button type="button" class="remove-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="btn btn-primary" id="addBatchBtn">Add Batch</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="batchNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Facility Modal -->
  <div class="modal fade" id="facilityModal" tabindex="-1" aria-labelledby="facilityLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="facilityLabel">Add Facility</h3>
        <form id="facilityForm">
          <div id="facilityEntries">
            <div class="facility-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="facility_0">Facility <span class="text-danger">*</span></label>
                  <select id="facility_0" name="facility[]" class="form-control" required>
                    <option value="">Select Facility</option>
                    <option value="Locker">Locker</option>
                    <option value="Shoe">Shoe</option>
                    <option value="Racket">Racket</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="locker_no_0">Locker No</label>
                  <input type="text" id="locker_no_0" name="locker_no[]" class="form-control" placeholder="Enter Locker No" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="facility_rent_0">Rent <span class="text-danger">*</span></label>
                  <input type="number" id="facility_rent_0" name="facility_rent[]" class="form-control" required placeholder="Enter Rent Amount" />
                </div>
                <div class="form-group col-md-6">
                  <label for="facility_rent_date_0">Rent Date <span class="text-danger">*</span></label>
                  <input type="date" id="facility_rent_date_0" name="facility_rent_date[]" class="form-control" required />
                </div>
              </div>
              <button type="button" class="remove-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="btn btn-primary" id="addFacilityBtn">Add Facility</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="facilityNextBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Staff Modal -->
  <div class="modal fade" id="staffModal" tabindex="-1" aria-labelledby="staffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="staffLabel">Add Staff</h3>
        <form id="staffForm">
          <div id="staffEntries">
            <div class="staff-entry">
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="staff_category_0">Category <span class="text-danger">*</span></label>
                  <select id="staff_category_0" name="staff_category[]" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="coach">Coach</option>
                    <option value="co-ordinator">Co-ordinator</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="staff_name_0">Staff Name <span class="text-danger">*</span></label>
                  <input type="text" id="staff_name_0" name="staff_name[]" class="form-control" required placeholder="Enter Staff Name" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="staff_timing_0">Timing <span class="text-danger">*</span></label>
                  <input type="time" id="staff_timing_0" name="staff_timing[]" class="form-control" required />
                </div>
                <div class="form-group col-md-6">
                  <label for="join_date_0">Join Date <span class="text-danger">*</span></label>
                  <input type="date" id="join_date_0" name="join_date[]" class="form-control" required />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="batch_selection_0">Batch Selection <span class="text-danger">*</span></label>
                  <select id="batch_selection_0" name="batch_selection[]" class="form-control" required>
                    <option value="">Select Batch Timing</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="contact_0">Contact <span class="text-danger">*</span></label>
                  <input type="text" id="contact_0" name="contact[]" class="form-control" required placeholder="Enter Contact" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="address_0">Address <span class="text-danger">*</span></label>
                  <input type="text" id="address_0" name="address[]" class="form-control" required placeholder="Enter Address" />
                </div>
              </div>
              <button type="button" class="remove-btn btn">Remove</button>
            </div>
          </div>
          <button type="button" class="btn btn-primary" id="addStaffBtn">Add Staff</button>
          <div class="d-flex justify-content-center mt-3">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="submitAllData">Submit</button>
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

  <!-- Edit Facility Modal -->
  <div class="modal fade" id="editFacilityModal" tabindex="-1" aria-labelledby="editFacilityLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="editFacilityLabel">Edit Facility</h3>
        <form id="editFacilityForm">
          <input type="hidden" id="editFacilityId">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_facility">Facility <span class="text-danger">*</span></label>
              <select id="edit_facility" name="facility" class="form-control" required>
                <option value="">Select Facility</option>
                <option value="Locker">Locker</option>
                <option value="Shoe">Shoe</option>
                <option value="Racket">Racket</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="edit_locker_no">Locker No</label>
              <input type="text" id="edit_locker_no" name="locker_no" class="form-control" placeholder="Enter Locker No" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_facility_rent">Rent <span class="text-danger">*</span></label>
              <input type="number" id="edit_facility_rent" name="facility_rent" class="form-control" required placeholder="Enter Rent Amount" />
            </div>
            <div class="form-group col-md-6">
              <label for="edit_facility_rent_date">Rent Date <span class="text-danger">*</span></label>
              <input type="date" id="edit_facility_rent_date" name="facility_rent_date" class="form-control" required />
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="confirmEditFacility">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Staff Modal -->
  <div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="editStaffLabel">Edit Staff</h3>
        <form id="editStaffForm">
          <input type="hidden" id="editStaffId">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_staff_category">Category <span class="text-danger">*</span></label>
              <select id="edit_staff_category" name="staff_category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="coach">Coach</option>
                <option value="co-ordinator">Co-ordinator</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="edit_staff_name">Staff Name <span class="text-danger">*</span></label>
              <input type="text" id="edit_staff_name" name="staff_name" class="form-control" required placeholder="Enter Staff Name" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_staff_timing">Timing <span class="text-danger">*</span></label>
              <input type="time" id="edit_staff_timing" name="staff_timing" class="form-control" required />
            </div>
            <div class="form-group col-md-6">
              <label for="edit_join_date">Join Date <span class="text-danger">*</span></label>
              <input type="date" id="edit_join_date" name="join_date" class="form-control" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="edit_batch_selection">Batch Selection <span class="text-danger">*</span></label>
              <select id="edit_batch_selection" name="batch_selection" class="form-control" required>
                <option value="">Select Batch Timing</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="edit_contact">Contact <span class="text-danger">*</span></label>
              <input type="text" id="edit_contact" name="contact" class="form-control" required placeholder="Enter Contact" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="edit_address">Address <span class="text-danger">*</span></label>
              <input type="text" id="edit_address" name="address" class="form-control" required placeholder="Enter Address" />
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" id="confirmEditStaff">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      let centerData = {};
      let batchData = [];
      let facilityData = [];
      let staffData = [];
      let selectedCenterId = null;

      // Navigation
      window.showSection = function(event, sectionId) {
        event.preventDefault();
        $('.menu-item').removeClass('active');
        $(event.currentTarget).addClass('active');
        $('.section-content').removeClass('active');
        $('#' + sectionId).addClass('active');
        updateProgressBar(sectionId);
        if (sectionId !== 'centerDetails' && selectedCenterId) {
          loadSectionData(sectionId, selectedCenterId);
        }
      };

      window.navigateTo = function(currentId, nextId) {
        $('.section-content').removeClass('active');
        $('#' + nextId).addClass('active');
        $('.menu-item').removeClass('active');
        $(`.menu-item[onclick*='${nextId}']`).addClass('active');
        updateProgressBar(nextId);
        if (nextId !== 'centerDetails' && selectedCenterId) {
          loadSectionData(nextId, selectedCenterId);
        }
      };

      function updateProgressBar(sectionId) {
        const progressBar = $('#progressBar');
        let step = 1;
        switch (sectionId) {
          case 'centerDetails': step = 1; break;
          case 'batchManagement': step = 2; break;
          case 'facilityManagement': step = 3; break;
          case 'staffManagement': step = 4; break;
        }
        const percentage = (step / 4) * 100;
        progressBar.css('width', percentage + '%').text(`Step ${step} of 4`);
      }

      // Load Centers
      function loadCenters() {
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/get_all',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            $('#centerCards').empty();
            response.forEach(center => {
              let card = `
                <div class="col-md-4">
                  <div class="center-card">
                    <div class="card-details">
                      <p>${center.name}</p>
                      <p><span>Timing:</span> ${center.timing}</p>
                      <p><span>Rent:</span> ${center.rent}</p>
                      <p><span>Rent Date:</span> ${center.rent_date}</p>
                      <button class="btn btn-primary view-btn" data-center-id="${center.id}">View Details</button>
                    </div>
                  </div>
                </div>`;
              $('#centerCards').append(card);
            });
          },
          error: function(xhr) {
            console.log('Load Centers Error:', xhr.responseText);
          }
        });
      }

      // Load Section Data
      function loadSectionData(sectionId, centerId) {
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/get/' + centerId,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (sectionId === 'batchManagement') {
              $('#batchCards').empty();
              response.batches.forEach(batch => {
                $('#batchCards').append(`
                  <div class="batch-card">
                    <div class="card-details">
                      <p>Batch ${batch.timing}</p>
                      <p><span>Start Date:</span> ${batch.start_date}</p>
                      <p><span>Category:</span> ${batch.category}</p>
                    </div>
                  </div>`);
              });
            } else if (sectionId === 'facilityManagement') {
              $('#facilityCards').empty();
              response.facilities.forEach(facility => {
                $('#facilityCards').append(`
                  <div class="facility-card">
                    <div class="card-details">
                      <p>${facility.type}</p>
                      <p><span>Locker No:</span> ${facility.locker_no || 'N/A'}</p>
                      <p><span>Rent:</span> ${facility.rent}</p>
                      <p><span>Rent Date:</span> ${facility.rent_date}</p>
                      <button class="btn btn-edit" data-toggle="modal" data-target="#editFacilityModal" 
                        data-id="${facility.id}" data-type="${facility.type}" 
                        data-locker-no="${facility.locker_no || ''}" data-rent="${facility.rent}" 
                        data-rent-date="${facility.rent_date}">Edit</button>
                    </div>
                  </div>`);
              });
            } else if (sectionId === 'staffManagement') {
              $('#staffCards').empty();
              response.staff.forEach(staff => {
                $('#staffCards').append(`
                  <div class="staff-card">
                    <div class="card-details">
                      <p>${staff.name}</p>
                      <p><span>Category:</span> ${staff.category}</p>
                      <p><span>Timing:</span> ${staff.timing}</p>
                      <p><span>Join Date:</span> ${staff.join_date}</p>
                      <p><span>Batch Timing:</span> ${staff.batch_timing}</p>
                      <p><span>Contact:</span> ${staff.contact}</p>
                      <p><span>Address:</span> ${staff.address}</p>
                      <button class="btn btn-edit" data-toggle="modal" data-target="#editStaffModal" 
                        data-id="${staff.id}" data-category="${staff.category}" data-name="${staff.name}"
                        data-timing="${staff.timing}" data-join-date="${staff.join_date}"
                        data-batch-timing="${staff.batch_timing}" data-contact="${staff.contact}"
                        data-address="${staff.address}">Edit</button>
                    </div>
                  </div>`);
              });
            }
          },
          error: function(xhr) {
            console.log('Load Section Error:', xhr.responseText);
          }
        });
      }

      // View Center Details
      $(document).on('click', '.view-btn', function() {
        selectedCenterId = $(this).data('center-id');
        loadSectionData('batchManagement', selectedCenterId);
        navigateTo('centerDetails', 'batchManagement');
      });

      // Add Batch Entry
      $('#addBatchBtn').click(function() {
        let index = $('#batchEntries .batch-entry').length;
        let newEntry = `
          <div class="batch-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_timing_${index}">Batch Timing <span class="text-danger">*</span></label>
                <input type="time" id="batch_timing_${index}" name="batch_timing[]" class="form-control" required />
              </div>
              <div class="form-group col-md-6">
                <label for="start_date_${index}">Start Date <span class="text-danger">*</span></label>
                <input type="date" id="start_date_${index}" name="start_date[]" class="form-control" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_category_${index}">Category <span class="text-danger">*</span></label>
                <select id="batch_category_${index}" name="batch_category[]" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="Beginner">Beginner</option>
                  <option value="Intermediate">Intermediate</option>
                  <option value="Advanced">Advanced</option>
                </select>
              </div>
            </div>
            <button type="button" class="remove-btn btn">Remove</button>
          </div>`;
        $('#batchEntries').append(newEntry);
      });

      // Remove Batch Entry
      $(document).on('click', '.remove-btn', function() {
        if ($(this).closest('.batch-entry, .facility-entry, .staff-entry').length > 1) {
          $(this).closest('.batch-entry, .facility-entry, .staff-entry').remove();
        }
      });

      // Add Facility Entry
      $('#addFacilityBtn').click(function() {
        let index = $('#facilityEntries .facility-entry').length;
        let newEntry = `
          <div class="facility-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="facility_${index}">Facility <span class="text-danger">*</span></label>
                <select id="facility_${index}" name="facility[]" class="form-control" required>
                  <option value="">Select Facility</option>
                  <option value="Locker">Locker</option>
                  <option value="Shoe">Shoe</option>
                  <option value="Racket">Racket</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="locker_no_${index}">Locker No</label>
                <input type="text" id="locker_no_${index}" name="locker_no[]" class="form-control" placeholder="Enter Locker No" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="facility_rent_${index}">Rent <span class="text-danger">*</span></label>
                <input type="number" id="facility_rent_${index}" name="facility_rent[]" class="form-control" required placeholder="Enter Rent Amount" />
              </div>
              <div class="form-group col-md-6">
                <label for="facility_rent_date_${index}">Rent Date <span class="text-danger">*</span></label>
                <input type="date" id="facility_rent_date_${index}" name="facility_rent_date[]" class="form-control" required />
              </div>
            </div>
            <button type="button" class="remove-btn btn">Remove</button>
          </div>`;
        $('#facilityEntries').append(newEntry);
      });

      // Add Staff Entry
      $('#addStaffBtn').click(function() {
        let index = $('#staffEntries .staff-entry').length;
        let newEntry = `
          <div class="staff-entry">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="staff_category_${index}">Category <span class="text-danger">*</span></label>
                <select id="staff_category_${index}" name="staff_category[]" class="form-control" required>
                  <option value="">Select Category</option>
                  <option value="coach">Coach</option>
                  <option value="co-ordinator">Co-ordinator</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="staff_name_${index}">Staff Name <span class="text-danger">*</span></label>
                <input type="text" id="staff_name_${index}" name="staff_name[]" class="form-control" required placeholder="Enter Staff Name" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="staff_timing_${index}">Timing <span class="text-danger">*</span></label>
                <input type="time" id="staff_timing_${index}" name="staff_timing[]" class="form-control" required />
              </div>
              <div class="form-group col-md-6">
                <label for="join_date_${index}">Join Date <span class="text-danger">*</span></label>
                <input type="date" id="join_date_${index}" name="join_date[]" class="form-control" required />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="batch_selection_${index}">Batch Selection <span class="text-danger">*</span></label>
                <select id="batch_selection_${index}" name="batch_selection[]" class="form-control" required>
                  <option value="">Select Batch Timing</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="contact_${index}">Contact <span class="text-danger">*</span></label>
                <input type="text" id="contact_${index}" name="contact[]" class="form-control" required placeholder="Enter Contact" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="address_${index}">Address <span class="text-danger">*</span></label>
                <input type="text" id="address_${index}" name="address[]" class="form-control" required placeholder="Enter Address" />
              </div>
            </div>
            <button type="button" class="remove-btn btn">Remove</button>
          </div>`;
        $('#staffEntries').append(newEntry);
        updateBatchSelections();
      });

      // Update Batch Selections
      function updateBatchSelections() {
        let batchTimings = batchData.map(batch => batch.timing);
        $('.staff-entry select[name="batch_selection[]"]').each(function() {
          let currentVal = $(this).val();
          $(this).empty().append('<option value="">Select Batch Timing</option>');
          batchTimings.forEach(timing => {
            $(this).append(`<option value="${timing}">${timing}</option>`);
          });
          if (currentVal && batchTimings.includes(currentVal)) {
            $(this).val(currentVal);
          }
        });
      }

      // Center Next
      $('#centerNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#centerForm')[0].checkValidity()) {
          centerData = {
            name: $('#center_name').val(),
            timing: $('#center_timing').val(),
            rent: $('#center_rent').val(),
            rent_date: $('#center_rent_date').val()
          };
          $('#newCenterModal').modal('hide');
          $('#batchModal').modal('show');
        } else {
          $('#centerForm')[0].reportValidity();
        }
      });

      // Batch Next
      $('#batchNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#batchForm')[0].checkValidity()) {
          batchData = [];
          $('#batchEntries .batch-entry').each(function() {
            batchData.push({
              timing: $(this).find('input[name="batch_timing[]"]').val(),
              start_date: $(this).find('input[name="start_date[]"]').val(),
              category: $(this).find('select[name="batch_category[]"]').val()
            });
          });
          $('#batchModal').modal('hide');
          $('#facilityModal').modal('show');
        } else {
          $('#batchForm')[0].reportValidity();
        }
      });

      // Facility Next
      $('#facilityNextBtn').click(function(e) {
        e.preventDefault();
        if ($('#facilityForm')[0].checkValidity()) {
          facilityData = [];
          $('#facilityEntries .facility-entry').each(function() {
            facilityData.push({
              type: $(this).find('select[name="facility[]"]').val(),
              locker_no: $(this).find('input[name="locker_no[]"]').val(),
              rent: $(this).find('input[name="facility_rent[]"]').val(),
              rent_date: $(this).find('input[name="facility_rent_date[]"]').val()
            });
          });
          $('#facilityModal').modal('hide');
          $('#staffModal').modal('inspireshow');
          updateBatchSelections();
        } else {
          $('#facilityForm')[0].reportValidity();
        }
      });

      // Submit All Data
      $('#staffForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#staffForm')[0].checkValidity()) {
          staffData = [];
          $('#staffEntries .staff-entry').each(function() {
            staffData.push({
              category: $(this).find('select[name="staff_category[]"]').val(),
              name: $(this).find('input[name="staff_name[]"]').val(),
              timing: $(this).find('input[name="staff_timing[]"]').val(),
              join_date: $(this).find('input[name="join_date[]"]').val(),
              batch_timing: $(this).find('select[name="batch_selection[]"]').val(),
              contact: $(this).find('input[name="contact[]"]').val(),
              address: $(this).find('input[name="address[]"]').val()
            });
          });

          let formData = {
            center: centerData,
            batches: batchData,
            facilities: facilityData,
            staff: staffData
          };

          $.ajax({
            url: 'http://localhost/timersacademy/index.php/center/save',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Center added successfully!',
                confirmButtonText: 'OK'
              }).then(() => {
                $('#staffModal').modal('hide');
                $('#centerForm, #batchForm, #facilityForm, #staffForm').trigger('reset');
                centerData = {};
                batchData = [];
                facilityData = [];
                staffData = [];
                loadCenters();
                navigateTo('staffManagement', 'centerDetails');
              });
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to add center: ' + (xhr.responseJSON?.message || 'Unknown error'),
                confirmButtonText: 'OK'
              });
            }
          });
        } else {
          $('#staffForm')[0].reportValidity();
        }
      });

      // Filter Centers
      $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        let filterName = $('#filterCenterName').val();
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/filter',
          type: 'POST',
          data: { filterCenterName: filterName },
          dataType: 'json',
          success: function(response) {
            $('#centerCards').empty();
            response.forEach(center => {
              let card = `
                <div class="col-md-4">
                  <div class="center-card">
                    <div class="card-details">
                      <p>${center.name}</p>
                      <p><span>Timing:</span> ${center.timing}</p>
                      <p><span>Rent:</span> ${center.rent}</p>
                      <p><span>Rent Date:</span> ${center.rent_date}</p>
                      <button class="btn btn-primary view-btn" data-center-id="${center.id}">View Details</button>
                    </div>
                  </div>
                </div>`;
              $('#centerCards').append(card);
            });
            $('#filterModal').modal('hide');
          },
          error: function(xhr) {
            console.log('Filter Centers Error:', xhr.responseText);
          }
        });
      });

      // Edit Facility
      $('#editFacilityModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        $('#editFacilityId').val(button.data('id'));
        $('#edit_facility').val(button.data('type'));
        $('#edit_locker_no').val(button.data('locker-no'));
        $('#edit_facility_rent').val(button.data('rent'));
        $('#edit_facility_rent_date').val(button.data('rent-date'));
      });

      $('#editFacilityForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#editFacilityForm')[0].checkValidity()) {
          let facilityData = {
            id: $('#editFacilityId').val(),
            type: $('#edit_facility').val(),
            locker_no: $('#edit_locker_no').val(),
            rent: $('#edit_facility_rent').val(),
            rent_date: $('#edit_facility_rent_date').val()
          };
          $.ajax({
            url: 'http://localhost/timersacademy/index.php/center/update_facility',
            type: 'POST',
            data: JSON.stringify(facilityData),
            contentType: 'application/json',
            success: function() {
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Facility updated successfully!',
                confirmButtonText: 'OK'
              }).then(() => {
                $('#editFacilityModal').modal('hide');
                loadSectionData('facilityManagement', selectedCenterId);
              });
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update facility: ' + (xhr.responseJSON?.message || 'Unknown error'),
                confirmButtonText: 'OK'
              });
            }
          });
        } else {
          $('#editFacilityForm')[0].reportValidity();
        }
      });

      // Edit Staff
      $('#editStaffModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        $('#editStaffId').val(button.data('id'));
        $('#edit_staff_category').val(button.data('category'));
        $('#edit_staff_name').val(button.data('name'));
        $('#edit_staff_timing').val(button.data('timing'));
        $('#edit_join_date').val(button.data('join-date'));
        $('#edit_contact').val(button.data('contact'));
        $('#edit_address').val(button.data('address'));
        let batchTiming = button.data('batch-timing');
        $('#edit_batch_selection').empty().append('<option value="">Select Batch Timing</option>');
        $.ajax({
          url: 'http://localhost/timersacademy/index.php/center/get/' + selectedCenterId,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            response.batches.forEach(batch => {
              $('#edit_batch_selection').append(`<option value="${batch.timing}">${batch.timing}</option>`);
            });
            if (batchTiming) {
              $('#edit_batch_selection').val(batchTiming);
            }
          }
        });
      });

      $('#editStaffForm').on('submit', function(e) {
        e.preventDefault();
        if ($('#editStaffForm')[0].checkValidity()) {
          let staffData = {
            id: $('#editStaffId').val(),
            category: $('#edit_staff_category').val(),
            name: $('#edit_staff_name').val(),
            timing: $('#edit_staff_timing').val(),
            join_date: $('#edit_join_date').val(),
            batch_timing: $('#edit_batch_selection').val(),
            contact: $('#edit_contact').val(),
            address: $('#edit_address').val()
          };
          $.ajax({
            url: 'http://localhost/timersacademy/index.php/center/update_staff',
            type: 'POST',
            data: JSON.stringify(staffData),
            contentType: 'application/json',
            success: function() {
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Staff updated successfully!',
                confirmButtonText: 'OK'
              }).then(() => {
                $('#editStaffModal').modal('hide');
                loadSectionData('staffManagement', selectedCenterId);
              });
            },
            error: function(xhr) {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update staff: ' + (xhr.responseJSON?.message || 'Unknown error'),
                confirmButtonText: 'OK'
              });
            }
          });
        } else {
          $('#editStaffForm')[0].reportValidity();
        }
      });

      // Sidebar Toggle
      function setupSidebarToggle() {
        const sidebarToggle = $('#sidebarToggle');
        const sidebar = $('#sidebar');
        const navbar = $('.navbar');
        const contentWrapper = $('#contentWrapper');

        sidebarToggle.on('click', function() {
          if (window.innerWidth <= 768) {
            sidebar.toggleClass('active');
            navbar.toggleClass('sidebar-hidden', sidebar.hasClass('active'));
          } else {
            const isMinimized = sidebar.toggleClass('minimized').hasClass('minimized');
            navbar.toggleClass('sidebar-minimized', isMinimized);
            contentWrapper.toggleClass('minimized', isMinimized);
          }
        });

        $(window).on('resize', function() {
          if (window.innerWidth <= 768) {
            sidebar.removeClass('minimized');
            contentWrapper.removeClass('minimized');
            navbar.removeClass('sidebar-minimized');
            if (!sidebar.hasClass('active')) {
              navbar.addClass('sidebar-hidden');
            }
          } else {
            sidebar.removeClass('active');
            navbar.removeClass('sidebar-hidden');
            if (sidebar.hasClass('minimized')) {
              contentWrapper.addClass('minimized');
              navbar.addClass('sidebar-minimized');
            } else {
              contentWrapper.removeClass('minimized');
              navbar.removeClass('sidebar-minimized');
            }
          }
        });

        sidebarToggle.on('click', function() {
          $(this).blur();
        });
      }

      // Initialize
      loadCenters();
      setupSidebarToggle();
    });
  </script>
</body>
</html>