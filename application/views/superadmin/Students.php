<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
  <title>Student Management</title>
  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Montserrat', serif !important;
      background-color: #f4f6f8 !important;
      color: #333;
      min-height: 100vh;
      margin: 0;
      padding: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
      overflow-x: hidden;
    }
    .content-wrapper {
      margin-left: 15rem;
      padding: 1.5rem;
      transition: all 0.3s ease-in-out;
      position: relative;
      min-height: 100vh;
    }
    .content-wrapper.minimized {
      margin-left: 4rem;
    }
    .container {
      max-width: 100%;
      margin: 4rem auto 0;
      width: 100%;
      padding: 0 1rem;
    }
    .content {
      margin-top: 4rem;
    }
    .add-btn-container {
      justify-content: space-between;
      margin-bottom: 1.5rem;
      gap: 0.75rem;
      align-items: center;
      flex-wrap: wrap;
    }
    .btn-custom {
      background: #6c757d;
      color: white;
      border: none;
      border-radius: 0.25rem;
      padding: 0.5rem 1rem;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
      touch-action: manipulation;
      min-width: 120px;
    }
    .btn-custom:hover {
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
      transform: translateY(-1px);
    }
    .table-container {
      margin-top: 1.5rem;
      margin-bottom: 1.5rem;
      background: #fff;
      border-radius: 0.5rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      overflow-x: auto;
    }
    .table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: #fff;
      border-radius: 0.5rem;
      overflow: hidden;
      min-width: 600px;
    }
    .table thead th {
      background-color: #343a40;
      color: white;
      border-bottom: 2px solid #dee2e6;
      white-space: nowrap;
      text-align: center;
      font-weight: 600;
      font-size: 0.875rem;
      padding: 1rem;
    }
    .table td, .table th {
      vertical-align: middle;
      text-align: center;
      padding: 0.75rem;
      white-space: nowrap;
      border-bottom: 1px solid #dee2e6;
      font-size: 0.85rem;
      color: #000;
    }
    .table tbody tr:hover {
      background-color: rgba(0, 123, 255, 0.1);
    }
    .table .horizontal-line td {
      border: none;
      background-color: #dee2e6;
      height: 1px;
      padding: 0;
    }
    .action-btn {
      font-size: 0.85rem;
      margin: 0 0.3rem;
      padding: 0.3rem 0.6rem;
      border-radius: 0.25rem;
      cursor: pointer;
      transition: all 0.2s ease;
      border: none;
    }
    .action-btn.edit-btn {
      background-color: #ffc107;
      color: #000;
    }
    .action-btn.delete-btn {
      background-color: #dc3545;
      color: white;
    }
    .action-btn.view-btn {
      background-color: #28a745;
      color: white;
    }
    .action-btn.renew-btn {
      background-color: #17a2b8;
      color: white;
    }
    .action-btn:hover:not(:disabled) {
      filter: brightness(90%);
    }
    .action-btn:disabled {
      background-color: #ccc !important;
      cursor: not-allowed;
      opacity: 0.6;
    }
    .modal-content {
      background-color: #fff;
      border-radius: 0.5rem;
      padding: 1rem;
      border: none;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2);
      margin-top: 65px;
    }
    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
      position: relative;
    }
    .modal-title {
      text-align: center;
      font-weight: 700;
      margin-bottom: 1rem;
      font-size: 1.25rem;
      color: #343a40;
      width: 100%;
    }
    .close {
      position: absolute;
      right: 1rem;
      top: 1rem;
      font-size: 1.25rem;
      color: #343a40;
      opacity: 0.7;
      width: 2rem;
      height: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      transition: all 0.3s ease;
    }
    .close:hover {
      opacity: 1;
      background: #e0e0e0;
    }
    .form-group label {
      font-weight: 600;
      font-size: 0.85rem;
      margin-bottom: 0.3rem;
      color: #495057;
    }
    .form-control, .form-control select {
      height: calc(1.8rem + 2px);
      border-radius: 0.3rem;
      font-size: 0.85rem;
      padding: 0.3rem 0.5rem;
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
      border: 1px solid #ced4da;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus, .form-control select:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.25);
    }
    .form-group textarea {
      resize: vertical;
      min-height: 3rem;
    }
    .invalid-feedback {
      font-size: 0.75rem;
      color: #dc3545;
    }
    .was-validated .form-control:invalid, .form-control.is-invalid {
      border-color: #dc3545;
      background: #ffeaea;
    }
    .was-validated .form-control:valid, .form-control.is-valid {
      border-color: #28a745;
    }
    .modal-backdrop.show {
      backdrop-filter: blur(6px);
    }
    .form-note {
      font-size: 0.8rem;
      color: #6c757d;
      margin-bottom: 0.8rem;
      text-align: center;
    }
    .form-row {
      display: flex;
      flex-wrap: wrap;
      margin-right: -5px;
      margin-left: -5px;
      align-items: center;
    }
    .form-group {
      padding-right: 5px;
      padding-left: 5px;
      margin-bottom: 0.8rem;
      flex: 0 0 50%;
      max-width: 50%;
    }
    .step-nav {
      display: flex;
      justify-content: space-between;
      background-color: #e9ecef;
      border-radius: 0.5rem 0.5rem 0 0;
      padding: 1rem;
      margin-bottom: 1.5rem;
      gap: 30px;
      flex-wrap: wrap;
    }
    .step-nav span {
      font-weight: 600;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      color: #6c757d;
      position: relative;
      transition: color 0.3s ease;
    }
    .step-nav span i {
      margin-left: 10px;
      font-size: 1.5rem;
      color: #007bff;
      transition: color 0.3s ease;
    }
    .step-nav span.step-active {
      color: #007bff;
      font-weight: 700;
    }
    .step-nav span.step-active i {
      color: #0056b3;
    }
    .receipt-card {
      background: #f8f9fa;
      padding: 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .receipt-card p {
      margin: 0.5rem 0;
      font-size: 0.9rem;
      color: #343a40;
    }
    .receipt-card p strong {
      color: #1a1a1a;
      font-weight: 600;
    }
    .modal-footer {
      border-top: none;
      padding-top: 1rem;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      flex-wrap: wrap;
    }
    .modal-footer .btn-secondary {
      background-color: #6c757d;
      border: none;
      border-radius: 0.375rem;
      padding: 0.6rem 1.25rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }
    .modal-footer .btn-secondary:hover {
      background-color: #5a6268;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
    }
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0 !important;
        padding: 0.5rem !important;
      }
      .container {
        margin-top: 3rem;
        padding: 0 0.5rem;
      }
      .table {
        font-size: 0.7rem;
        min-width: 100%;
      }
      .table th:nth-child(3), .table td:nth-child(3),
      .table th:nth-child(4), .table td:nth-child(4) {
        display: none;
      }
      .action-btn {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
      }
      .modal-content {
        padding: 0.8rem;
        margin-top: 30px;
      }
      .form-row {
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
      }
      .form-group {
        padding: 0;
        margin-bottom: 0.6rem;
        flex: 0 0 100%;
        max-width: 100%;
      }
      .add-btn-container {
        justify-content: center;
        flex-direction: column;
        gap: 0.5rem;
      }
      .btn-custom {
        font-size: 0.75rem;
        padding: 0.3rem 0.6rem;
        
      }
      .step-nav {
        flex-direction: column;
        gap: 0.5rem;
        padding: 0.75rem;
      }
      .step-nav span {
        font-size: 0.7rem;
        padding: 5px;
      }
      .step-nav span i {
        font-size: 1rem;
        margin-left: 8px;
      }
    }
    @media (min-width: 577px) and (max-width: 768px) {
      .content-wrapper {
        margin-left: 0 !important;
        padding: 1rem !important;
      }
      .container {
        margin-top: 3.5rem;
        padding: 0 0.75rem;
      }
      .table {
        font-size: 0.8rem;
      }
      .table th:nth-child(4), .table td:nth-child(4) {
        display: none;
      }
      .action-btn {
        font-size: 0.8rem;
        padding: 0.3rem 0.5rem;
      }
      .modal-content {
        padding: 0.9rem;
        margin-top: 40px;
      }
      .form-row {
        flex-direction: row;
        flex-wrap: wrap;
      }
      .form-group {
        flex: 0 0 50%;
        max-width: 50%;
      }
      .add-btn-container {
        justify-content: space-between;
        flex-wrap: wrap;
      }
      .btn-custom {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
      }
      .step-nav {
        gap: 0.75rem;
      }
      .step-nav span {
        font-size: 0.8rem;
      }
      .step-nav span i {
        font-size: 1.2rem;
        margin-left: 8px;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 12rem;
      }
      .content-wrapper.minimized {
        margin-left: 4rem;
      }
      .container {
        margin-top: 4rem;
        padding: 0 1rem;
      }
      .table {
        font-size: 0.9rem;
      }
      .modal-content {
        max-width: calc(450px + 2vw);
        margin-top: 60px;
      }
      .step-nav {
        gap: 25px;
      }
      .step-nav span i {
        font-size: 1.4rem;
        margin-left: 10px;
      }
    }
    @media (min-width: 992px) and (max-width: 1200px) {
      .content-wrapper {
        margin-left: 14rem;
      }
      .container {
        margin-top: 4rem;
        padding: 0 1rem;
      }
      .modal-content {
        max-width: calc(480px + 2vw);
        margin-top: 65px;
      }
    }
    @media (min-width: 1201px) {
      .content-wrapper {
        margin-left: 15rem;
      }
      .container {
        margin-top: 4rem;
        padding: 0 1rem;
      }
      .modal-content {
        max-width: 800px;
        margin-top: 65px;
      }
    }
    @media (min-width: 1600px) {
      .content-wrapper {
        margin-left: 16rem;
      }
      .container {
        margin-top: 4rem;
        padding: 0 1rem;
      }
      .modal-content {
        max-width: calc(520px + 2vw);
        margin-top: 65px;
      }
      .table {
        font-size: 1rem;
      }
      .btn-custom {
        font-size: 1.1rem;
        padding: 0.6rem 1.2rem;
      }
    }
    @media (hover: none) {
      .action-btn:hover,
      .btn-custom:hover,
      .close:hover {
        transform: none;
        background-color: inherit;
        box-shadow: none;
      }
    }
    .form-control{
          padding: 1.375rem .75rem;
    }
  </style> 
</head>
<body>
  <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>
  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="content">
      <div class="container">
        <!-- Add Button and Filter -->
        <div class="add-btn-container">
          <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
            <i class="bi bi-funnel me-2"></i> Filter
          </button>
          <button class="btn btn-custom" data-toggle="modal" data-target="#newAdmissionModal">
            <i class="fas fa-plus mr-1"></i> Add Student
          </button>
        </div>
        <div class="table-container">
          <table class="table table-bordered table-hover" id="studentTable">
            <thead class="thead-dark1">
              <tr>
                <th>Center</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Batch</th>
                <th>Category</th>
                <th>Plan Expiry</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="studentTableBody">
              <tr>
                <td>Center 1</td>
                <td>Jane Doe</td>
                <td>8976576890</td>
                <td>B1</td>
                <td>Corporate</td>
                <td>2025-07-31</td>
                <td>
                  <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="Jane Doe" data-contact="8976576890" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-edit"></i></button>
                  <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                  <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="Jane Doe" data-contact="8976576890" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-eye"></i></button>
                  <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="Jane Doe" data-contact="8976576890" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-sync"></i></button>
                </td>
              </tr>
              <tr class="horizontal-line"><td colspan="7"></td></tr>
              <tr>
                <td>Center 2</td>
                <td>John Smith</td>
                <td>9876543210</td>
                <td>B2</td>
                <td>Individual</td>
                <td>2025-06-15</td>
                <td>
                  <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="John Smith" data-contact="9876543210" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-edit"></i></button>
                  <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                  <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="John Smith" data-contact="9876543210" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-eye"></i></button>
                  <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="John Smith" data-contact="9876543210" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-sync"></i></button>
                </td>
              </tr>
              <tr class="horizontal-line"><td colspan="7"></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- New Admission Modal (Step 1: Personal Details) -->
  <div class="modal fade" id="newAdmissionModal" tabindex="-1" aria-labelledby="newAdmissionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="newAdmissionLabel" class="modal-title w-100 text-center">Student Admission Form</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="step-nav">
          <span class="step-active">1. Personal Details <i class="fas fa-arrow-right"></i></span>
          <span>2. Batch Details <i class="fas fa-arrow-right"></i></span>
          <span>3. Fees Details <i class="fas fa-arrow-right"></i></span>
        </div>
        <form id="admissionForm1" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Name <span class="text-danger">*</span></label>
              <input type="text" id="name" name="name" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="contact">Contact <span class="text-danger">*</span></label>
              <input type="tel" id="contact" name="contact" class="form-control" required pattern="[0-9]{10}" title="Contact must be exactly 10 digits" maxlength="10"/>
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="parentName">Parent Name <span class="text-danger">*</span></label>
              <input type="text" id="parentName" name="parentName" class="form-control" required pattern="[A-Za-z\s]+" title="Parent name should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid parent name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="emergencyContact">Emergency Contact <span class="text-danger">*</span></label>
              <input type="tel" id="emergencyContact" name="emergencyContact" class="form-control" required pattern="[0-9]{10}" title="Emergency contact must be exactly 10 digits" maxlength="10"/>
              <div class="invalid-feedback">Please enter a valid 10-digit emergency contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email">Email <span class="text-danger">*</span></label>
              <input type="email" id="email" name="email" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address" maxlength="100"/>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="address">Address <span class="text-danger">*</span></label>
              <textarea id="address" name="address" class="form-control" required minlength="5" maxlength="200"></textarea>
              <div class="invalid-feedback">Please enter a valid address (5-200 characters).</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- New Admission Modal (Step 2: Batch Details) -->
  <div class="modal fade" id="batchDetailsModal" tabindex="-1" aria-labelledby="batchDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="batchDetailsLabel" class="modal-title w-100 text-center">Student Admission Form</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="step-nav">
          <span>1. Personal Details <i class="fas fa-arrow-right"></i></span>
          <span class="step-active">2. Batch Details <i class="fas fa-arrow-right"></i></span>
          <span>3. Fees Details <i class="fas fa-arrow-right"></i></span>
        </div>
        <form id="admissionForm2" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="center">Center <span class="text-danger">*</span></label>
              <select id="center" name="center" class="form-control" required>
                <option value="">-- Select Center --</option>
                <!-- Centers will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a center.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="batch">Batch <span class="text-danger">*</span></label>
              <select id="batch" name="batch" class="form-control" required>
                <option value="">-- Select Batch --</option>
                <!-- Batches will be populated dynamically -->
              </select>
              <div class="invalid-feedback">Please select a batch.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="category">Category <span class="text-danger">*</span></label>
              <select id="category" name="category" class="form-control" required>
                <option value="">Select</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coach">Coach <span class="text-danger">*</span></label>
              <select id="coach" name="coach" class="form-control" required>
                <option value="">Select</option>
                <option value="GHJK">GHJK</option>
                <option value="DFGH">DFGH</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="coordinator">Coordinator <span class="text-danger">*</span></label>
              <input type="text" id="coordinator" name="coordinator" class="form-control" required pattern="[A-Za-z\s]+" title="Coordinator should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid coordinator name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="duration">Duration <span class="text-danger">*</span></label>
              <select id="duration" name="duration" class="form-control" required>
                <option value="">Select</option>
                <option value="1 month">1 month</option>
                <option value="2 months">2 months</option>
              </select>
              <div class="invalid-feedback">Please select a duration.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- New Admission Modal (Step 3: Fees Details) -->
  <div class="modal fade" id="feesDetailsModal" tabindex="-1" aria-labelledby="feesDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="feesDetailsLabel" class="modal-title w-100 text-center">Student Admission Form</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="step-nav">
          <span>1. Personal Details <i class="fas fa-arrow-right"></i></span>
          <span>2. Batch Details <i class="fas fa-arrow-right"></i></span>
          <span class="step-active">3. Fees Details <i class="fas fa-arrow-right"></i></span>
        </div>
        <form id="admissionForm3" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="totalFees">Total Fees <span class="text-danger">*</span></label>
              <input type="number" id="totalFees" name="totalFees" class="form-control" required min="1" max="100000" title="Total fees must be between 1 and 100,000"/>
              <div class="invalid-feedback">Please enter a valid total fees amount (1-100,000).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="amountPaid">Amount Paid <span class="text-danger">*</span></label>
              <input type="number" id="amountPaid" name="amountPaid" class="form-control" required min="0" title="Amount paid must be a positive number or zero"/>
              <div class="invalid-feedback">Please enter a valid amount paid (0 or more, not exceeding total fees).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="remainingAmount">Remaining Amount <span class="text-danger">*</span></label>
              <input type="number" id="remainingAmount" name="remainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly/>
              <div class="invalid-feedback">Please ensure remaining amount is valid.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="paymentMethod">Payment Method <span class="text-danger">*</span></label>
              <div>
                <div class="form-check">
                  <input type="radio" id="cash" name="paymentMethod" class="form-check-input" value="Cash" required>
                  <label class="form-check-label" for="cash">Cash</label>
                </div>
                <div class="form-check">
                  <input type="radio" id="online" name="paymentMethod" class="form-check-input" value="Online">
                  <label class="form-check-label" for="online">Online</label>
                </div>
              </div>
              <div class="invalid-feedback">Please select a payment method.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Generate Receipt</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="filterLabel" class="modal-title w-100 text-center">Filter Students</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterName">Name</label>
              <input type="text" id="filterName" name="filterName" class="form-control" pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="filterContact">Contact</label>
              <input type="tel" id="filterContact" name="filterContact" class="form-control" pattern="[0-9]{10}" title="Contact should be a 10-digit number" maxlength="10"/>
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterCenter">Center</label>
              <input type="text" id="filterCenter" name="filterCenter" class="form-control" pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid center name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="filterBatch">Batch</label>
              <input type="text" id="filterBatch" name="filterBatch" class="form-control" pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only" minlength="1" maxlength="20"/>
              <div class="invalid-feedback">Please enter a valid batch (1-20 letters and numbers only).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="filterCategory">Category</label>
              <select id="filterCategory" name="filterCategory" class="form-control">
                <option value="">All</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a valid category.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
            <button type="submit" class="btn btn-custom">Apply Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="editLabel" class="modal-title w-100 text-center">Edit Student</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editName">Name <span class="text-danger">*</span></label>
              <input type="text" id="editName" name="editName" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="editContact">Contact <span class="text-danger">*</span></label>
              <input type="tel" id="editContact" name="editContact" class="form-control" required pattern="[0-9]{10}" title="Contact should be a 10-digit number" maxlength="10"/>
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editCenter">Center <span class="text-danger">*</span></label>
              <input type="text" id="editCenter" name="editCenter" class="form-control" required pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces" minlength="2" maxlength="50"/>
              <div class="invalid-feedback">Please enter a valid center name (2-50 letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="editBatch">Batch <span class="text-danger">*</span></label>
              <input type="text" id="editBatch" name="editBatch" class="form-control" required pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only" minlength="1" maxlength="20"/>
              <div class="invalid-feedback">Please enter a valid batch (1-20 letters and numbers only).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="editCategory">Category <span class="text-danger">*</span></label>
              <select id="editCategory" name="editCategory" class="form-control" required>
                <option value="">Select</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
                <option value="Coach">Coach</option>
                <option value="Coordinator">Coordinator</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Receipt View Modal -->
  <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="receiptLabel" class="modal-title w-100 text-center">Admission Receipt</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="receipt-card">
            <p><strong>Student Name:</strong> <span id="receiptName"></span></p>
            <p><strong>Contact:</strong> <span id="receiptContact"></span></p>
            <p><strong>Center:</strong> <span id="receiptCenter"></span></p>
            <p><strong>Batch:</strong> <span id="receiptBatch"></span></p>
            <p><strong>Category:</strong> <span id="receiptCategory"></span></p>
            <p><strong>Total Fees:</strong> Rs. <span id="receiptTotalFees"></span></p>
            <p><strong>Amount Paid:</strong> Rs. <span id="receiptAmountPaid"></span></p>
            <p><strong>Remaining Amount:</strong> Rs. <span id="receiptRemainingAmount"></span></p>
            <p><strong>Payment Method:</strong> <span id="receiptPaymentMethod"></span></p>
            <p><strong>Attendance Link:</strong>  <a id="attendancelink" href="#" target="_blank" style="word-break: break-all; display: inline-block; max-width: 100%;"></a></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Renew Admission Modal -->
  <div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="renewLabel" class="modal-title w-100 text-center">Renew Admission</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="step-nav">
          <span class="step-active">1. Renew Fees <i class="fas fa-arrow-right"></i></span>
        </div>
        <form id="renewForm" novalidate>
          <input type="hidden" id="renewName" name="renewName">
          <input type="hidden" id="renewContact" name="renewContact">
          <input type="hidden" id="renewCenter" name="renewCenter">
          <input type="hidden" id="renewBatch" name="renewBatch">
          <input type="hidden" id="renewCategory" name="renewCategory">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="renewTotalFees">Total Fees <span class="text-danger">*</span></label>
              <input type="number" id="renewTotalFees" name="renewTotalFees" class="form-control" required min="1" max="100000" title="Total fees must be between 1 and 100,000"/>
              <div class="invalid-feedback">Please enter a valid total fees amount (1-100,000).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="renewAmountPaid">Amount Paid <span class="text-danger">*</span></label>
              <input type="number" id="renewAmountPaid" name="renewAmountPaid" class="form-control" required min="0" title="Amount paid must be a positive number or zero"/>
              <div class="invalid-feedback">Please enter a valid amount paid (0 or more, not exceeding total fees).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="renewRemainingAmount">Remaining Amount <span class="text-danger">*</span></label>
              <input type="number" id="renewRemainingAmount" name="renewRemainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly/>
              <div class="invalid-feedback">Please ensure remaining amount is valid.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="renewPaymentMethod">Payment Method <span class="text-danger">*</span></label>
              <div>
                <div class="form-check">
                  <input type="radio" id="renewCash" name="renewPaymentMethod" class="form-check-input" value="Cash" required>
                  <label class="form-check-label" for="renewCash">Cash</label>
                </div>
                <div class="form-check">
                  <input type="radio" id="renewOnline" name="renewPaymentMethod" class="form-check-input" value="Online">
                  <label class="form-check-label" for="renewOnline">Online</label>
                </div>
              </div>
              <div class="invalid-feedback">Please select a payment method.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Renew Admission</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Bootstrap + jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function () {
      const forms = ['admissionForm1', 'admissionForm2', 'admissionForm3', 'filterForm', 'editForm', 'renewForm'].map(id => document.getElementById(id));
      const tableBody = document.querySelector('#studentTableBody');
      const filterButton = document.querySelector('#filterModal .btn-custom[type="submit"]');
      const baseUrl = '<?php echo base_url(); ?>';

      // Function to load centers dynamically
      function loadCenters(selectElement) {
        $.ajax({
          url: baseUrl + 'center/get_centers',
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            console.log('loadCenters response:', response);
            selectElement.innerHTML = '<option value="">-- Select Center --</option>';
            if (response.status === 'success' && response.data.length > 0) {
              response.data.forEach(center => {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${center.center_name}">${center.center_name}</option>`);
              });
            } else {
              selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>No centers available</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error('loadCenters error:', xhr.responseText, status, error);
            selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>Error loading centers</option>');
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load centers: ' + (xhr.responseJSON?.message || error),
              timer: 3000
            });
          }
        });
      }

      // Function to load batches dynamically
      function loadBatches(selectElement) {
        $.ajax({
          url: baseUrl + 'batch/get_batches',
          method: 'POST',
          data: { '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>' },
          dataType: 'json',
          success: function (response) {
            console.log('loadBatches response:', response);
            selectElement.innerHTML = '<option value="">-- Select Batch --</option>';
            if (response.status === 'success' && response.data.length > 0) {
              response.data.forEach(batch => {
                selectElement.insertAdjacentHTML('beforeend', `<option value="${batch.batch}">${batch.batch}</option>`);
              });
            } else {
              selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>No batches available</option>');
            }
          },
          error: function (xhr, status, error) {
            console.error('loadBatches error:', xhr.responseText, status, error);
            selectElement.insertAdjacentHTML('beforeend', '<option value="" disabled>Error loading batches</option>');
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load batches: ' + (xhr.responseJSON?.message || error),
              timer: 3000
            });
          }
        });
      }

      // Load centers and batches when batchDetailsModal is shown
      $('#batchDetailsModal').on('show.bs.modal', function () {
        loadCenters(document.getElementById('center'));
        loadBatches(document.getElementById('batch'));
      });

      // Load initial students
      function loadStudents() {
        $.ajax({
          url: '<?= base_url('Student_controller/index') ?>',
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log('loadStudents response:', response);
            tableBody.innerHTML = '';
            if (response.status === 'success' && Array.isArray(response.students) && response.students.length > 0) {
              response.students.forEach(student => {
                const row = `
                  <tr>
                    <td>${student.center || 'N/A'}</td>
                    <td>${student.name || 'N/A'}</td>
                    <td>${student.contact || 'N/A'}</td>
                    <td>${student.batch || 'N/A'}</td>
                    <td>${student.category || 'N/A'}</td>
                    <td>${student.plan_expiry || 'N/A'}</td>
                    <td>
                      <button class="action-btn edit-btn" data-id="${student.id}" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                      <button class="action-btn delete-btn" data-id="${student.id}"><i class="fas fa-trash"></i></button>
                      <button class="action-btn view-btn" data-id="${student.id}" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i></button>
                      <button class="action-btn renew-btn" data-id="${student.id}" data-toggle="modal" data-target="#renewModal"><i class="fas fa-sync"></i></button>
                    </td>
                  </tr>
                  <tr class="horizontal-line"><td colspan="7"></td></tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
              });
            } else {
              tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No students found.</td></tr>';
            }
          },
          error: function(xhr, status, error) {
            console.error('loadStudents error:', xhr.responseText, status, error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load students: ' + (xhr.responseJSON?.message || error),
              timer: 3000
            });
            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No students found.</td></tr>';
          }
        });
      }

      // Initial load
      loadStudents();

      // Form validation
      forms.forEach(form => {
        form.addEventListener('submit', function (event) {
          let isValid = form.checkValidity();
          if (form.id === 'filterForm') {
            let atLeastOneFilled = false;
            form.querySelectorAll('input, select').forEach(input => {
              if (input.value.trim() !== '') atLeastOneFilled = true;
            });
            if (!atLeastOneFilled) {
              form.querySelector('#filterName').setCustomValidity('At least one filter field must be filled.');
              isValid = false;
            } else {
              form.querySelector('#filterName').setCustomValidity('');
            }
          }
          if (form.id === 'admissionForm3' || form.id === 'renewForm') {
            const totalFeesInput = form.querySelector(form.id === 'admissionForm3' ? '#totalFees' : '#renewTotalFees');
            const amountPaidInput = form.querySelector(form.id === 'admissionForm3' ? '#amountPaid' : '#renewAmountPaid');
            const totalFees = parseFloat(totalFeesInput.value) || 0;
            const amountPaid = parseFloat(amountPaidInput.value) || 0;
            if (amountPaid > totalFees) {
              amountPaidInput.setCustomValidity('Amount paid cannot exceed total fees.');
              isValid = false;
            } else {
              amountPaidInput.setCustomValidity('');
            }
          }
          if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });

      // Real-time validation for amount paid
      ['amountPaid', 'renewAmountPaid'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
          const totalFeesInput = document.getElementById(id === 'amountPaid' ? 'totalFees' : 'renewTotalFees');
          const remainingAmountInput = document.getElementById(id === 'amountPaid' ? 'remainingAmount' : 'renewRemainingAmount');
          const totalFees = parseFloat(totalFeesInput.value) || 0;
          const amountPaid = parseFloat(this.value) || 0;
          if (amountPaid > totalFees) {
            this.setCustomValidity('Amount paid cannot exceed total fees.');
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
          } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            remainingAmountInput.value = Math.max(0, totalFees - amountPaid);
          }
        });
      });

      // Real-time validation for total fees
      ['totalFees', 'renewTotalFees'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
          const amountPaidInput = document.getElementById(id === 'totalFees' ? 'amountPaid' : 'renewAmountPaid');
          const remainingAmountInput = document.getElementById(id === 'totalFees' ? 'remainingAmount' : 'renewRemainingAmount');
          const totalFees = parseFloat(this.value) || 0;
          const amountPaid = parseFloat(amountPaidInput.value) || 0;
          if (totalFees < 1 || totalFees > 100000) {
            this.setCustomValidity('Total fees must be between 1 and 100,000.');
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
          } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            if (amountPaid > totalFees) {
              amountPaidInput.setCustomValidity('Amount paid cannot exceed total fees.');
              amountPaidInput.classList.add('is-invalid');
              amountPaidInput.classList.remove('is-valid');
            } else {
              amountPaidInput.setCustomValidity('');
              amountPaidInput.classList.remove('is-invalid');
              amountPaidInput.classList.add('is-valid');
              remainingAmountInput.value = Math.max(0, totalFees - amountPaid);
            }
          }
        });
      });

      // Navigation between steps
      let admissionData = {};
      $('#admissionForm1').on('submit', function (event) {
        if (this.checkValidity()) {
          event.preventDefault();
          admissionData = {
            name: $('#name').val().trim(),
            contact: $('#contact').val().trim(),
            parentName: $('#parentName').val().trim(),
            emergencyContact: $('#emergencyContact').val().trim(),
            email: $('#email').val().trim(),
            address: $('#address').val().trim()
          };
          $('#newAdmissionModal').modal('hide');
          $('#batchDetailsModal').modal('show');
        }
        this.classList.add('was-validated');
      });

      $('#admissionForm2').on('submit', function (event) {
        if (this.checkValidity()) {
          event.preventDefault();
          admissionData = {
            ...admissionData,
            center: $('#center').val(),
            batch: $('#batch').val(),
            category: $('#category').val(),
            coach: $('#coach').val(),
            coordinator: $('#coordinator').val().trim(),
            duration: $('#duration').val()
          };
          $('#batchDetailsModal').modal('hide');
          $('#feesDetailsModal').modal('show');
        }
        this.classList.add('was-validated');
      });

      // Add new student and generate receipt
      $('#admissionForm3').on('submit', function (event) {
        if (this.checkValidity()) {
          event.preventDefault();
          admissionData = {
            ...admissionData,
            totalFees: $('#totalFees').val(),
            amountPaid: $('#amountPaid').val(),
            paymentMethod: $('input[name="paymentMethod"]:checked').val()
          };
          $.ajax({
            url: '<?= base_url('Student_controller/add_student') ?>',
            method: 'POST',
            data: admissionData,
            dataType: 'json',
            success: function(response) {
              console.log('add_student response:', response);
              if (response.status === 'success') {
                $('#receiptName').text(response.data.name);
                $('#receiptContact').text(response.data.contact);
                $('#receiptCenter').text(response.data.center);
                $('#receiptBatch').text(response.data.batch);
                $('#receiptCategory').text(response.data.category);
                $('#receiptTotalFees').text(response.data.total_fees);
                $('#receiptAmountPaid').text(response.data.amount_paid);
                $('#receiptRemainingAmount').text(response.data.remaining_amount);
                $('#receiptPaymentMethod').text(response.data.payment_method);
                 $('#attendancelink').attr('href', response.data.attendace_link || '#').text(response.data.attendace_link || 'N/A');
                $('#receiptModal').modal('show');
                $('#feesDetailsModal').modal('hide');
                forms.forEach(f => f.reset());
                forms.forEach(f => f.classList.remove('was-validated'));
                setTimeout(loadStudents, 500);
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: response.message,
                  timer: 3000
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: response.message || response.errors || 'Failed to add student',
                  timer: 3000
                });
              }
            },
            error: function(xhr, status, error) {
              console.error('add_student error:', xhr.responseText, status, error);
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to add student: ' + (xhr.responseJSON?.message || error),
                timer: 3000
              });
            }
          });
        }
        this.classList.add('was-validated');
      });

      // Edit functionality
      $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        $.ajax({
          url: '<?= base_url('Student_controller/get_student/') ?>' + id,
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log('get_student response:', response);
            if (response.status === 'success' && response.data) {
              $('#editName').val(response.data.name || '');
              $('#editContact').val(response.data.contact || '');
              $('#editCenter').val(response.data.center || '');
              $('#editBatch').val(response.data.batch || '');
              $('#editCategory').val(response.data.category || '');
              $('#editForm').off('submit').on('submit', function (event) {
                if (this.checkValidity()) {
                  event.preventDefault();
                  $.ajax({
                    url: '<?= base_url('Student_controller/edit_student/') ?>' + id,
                    method: 'POST',
                    data: {
                      editName: $('#editName').val().trim(),
                      editContact: $('#editContact').val().trim(),
                      editCenter: $('#editCenter').val().trim(),
                      editBatch: $('#editBatch').val().trim(),
                      editCategory: $('#editCategory').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                      console.log('edit_student response:', response);
                      if (response.status === 'success') {
                        loadStudents();
                        $('#editModal').modal('hide');
                        this.classList.remove('was-validated');
                        Swal.fire({
                          icon: 'success',
                          title: 'Success',
                          text: response.message,
                          timer: 3000
                        });
                      } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Error',
                          text: response.message || response.errors || 'Failed to update student',
                          timer: 3000
                        });
                      }
                    },
                    error: function(xhr, status, error) {
                      console.error('edit_student error:', xhr.responseText, status, error);
                      Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update student: ' + (xhr.responseJSON?.message || error),
                        timer: 3000
                      });
                    }
                  });
                }
                this.classList.add('was-validated');
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message || 'Student not found',
                timer: 3000
              });
            }
          },
          error: function(xhr, status, error) {
            console.error('get_student error:', xhr.responseText, status, error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to fetch student: ' + (xhr.responseJSON?.message || error),
              timer: 3000
            });
          }
        });
      });

      // Delete functionality
      $(document).on('click', '.delete-btn', function () {
        const id = $(this).data('id');
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
            $.ajax({
              url: '<?= base_url('Student_controller/delete_student/') ?>' + id,
              method: 'POST',
              dataType: 'json',
              success: function(response) {
                console.log('delete_student response:', response);
                if (response.status === 'success') {
                  loadStudents();
                  Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message,
                    timer: 3000
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to delete student',
                    timer: 3000
                  });
                }
              },
              error: function(xhr, status, error) {
                console.error('delete_student error:', xhr.responseText, status, error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to delete student: ' + (xhr.responseJSON?.message || error),
                  timer: 3000
                });
              }
            });
          }
        });
      });

      // View receipt
      $(document).on('click', '.view-btn', function () {
        const id = $(this).data('id');
        $.ajax({
          url: '<?= base_url('Student_controller/get_student/') ?>' + id,
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            console.log('get_student (view receipt) response:', response);
            if (response.status === 'success' && response.data) {
              $('#receiptName').text(response.data.name || 'N/A');
              $('#receiptContact').text(response.data.contact || 'N/A');
              $('#receiptCenter').text(response.data.center || 'N/A');
              $('#receiptBatch').text(response.data.batch || 'N/A');
              $('#receiptCategory').text(response.data.category || 'N/A');
              $('#receiptTotalFees').text(response.data.total_fees || '0');
              $('#receiptAmountPaid').text(response.data.amount_paid || '0');
              $('#receiptRemainingAmount').text(response.data.remaining_amount || '0');
              $('#receiptPaymentMethod').text(response.data.payment_method || 'N/A');
              $('#attendancelink').attr('href', response.data.attendace_link || '#').text(response.data.attendace_link || 'N/A');
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message || 'Student not found',
                timer: 3000
              });
            }
          },
          error: function(xhr, status, error) {
            console.error('get_student (view receipt) error:', xhr.responseText, status, error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to fetch receipt: ' + (xhr.responseJSON?.message || error),
              timer: 3000
            });
          }
        });
      });

      // Renew functionality
      $(document).on('click', '.renew-btn', function () {
        const id = $(this).data('id');
        $.ajax({
          url: '<?= base_url('Student_controller/get_student/') ?>' + id,
          method: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success' && response.data) {
              $('#renewName').val(response.data.name || '');
              $('#renewContact').val(response.data.contact || '');
              $('#renewCenter').val(response.data.center || '');
              $('#renewBatch').val(response.data.batch || '');
              $('#renewCategory').val(response.data.category || '');
            }
          }
        });
        $('#renewForm').off('submit').on('submit', function (event) {
          if (this.checkValidity()) {
            event.preventDefault();
            $.ajax({
              url: '<?= base_url('Student_controller/renew_student/') ?>' + id,
              method: 'POST',
              data: {
                renewName: $('#renewName').val(),
                renewContact: $('#renewContact').val(),
                renewCenter: $('#renewCenter').val(),
                renewBatch: $('#renewBatch').val(),
                renewCategory: $('#renewCategory').val(),
                renewTotalFees: $('#renewTotalFees').val(),
                renewAmountPaid: $('#renewAmountPaid').val(),
                renewPaymentMethod: $('input[name="renewPaymentMethod"]:checked').val(),
                duration: $('#duration').val() || '1 month'
              },
              dataType: 'json',
              success: function(response) {
                console.log('renew_student response:', response);
                if (response.status === 'success') {
                  loadStudents();
                  $('#renewModal').modal('hide');
                  this.classList.remove('was-validated');
                  Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 3000
                  });
                  $('#receiptName').text(response.data.name || admissionData.name || 'N/A');
                  $('#receiptContact').text(response.data.contact || admissionData.contact || 'N/A');
                  $('#receiptCenter').text(response.data.center || admissionData.center || 'N/A');
                  $('#receiptBatch').text(response.data.batch || admissionData.batch || 'N/A');
                  $('#receiptCategory').text(response.data.category || admissionData.category || 'N/A');
                  $('#receiptTotalFees').text(response.data.total_fees || '0');
                  $('#receiptAmountPaid').text(response.data.amount_paid || '0');
                  $('#receiptRemainingAmount').text(response.data.remaining_amount || '0');
                  $('#receiptPaymentMethod').text(response.data.payment_method || 'N/A');
                  $('#receiptModal').modal('show');
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || response.errors || 'Failed to renew student',
                    timer: 3000
                  });
                }
              },
              error: function(xhr, status, error) {
                console.error('renew_student error:', xhr.responseText, status, error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Failed to renew student: ' + (xhr.responseJSON?.message || error),
                  timer: 3000
                });
              }
            });
          }
          this.classList.add('was-validated');
        });
      });

      // Filter students
      $('#filterForm').on('submit', function (event) {
        event.preventDefault();
        if (!this.checkValidity()) {
          console.log('Filter form validation failed');
          return;
        }
        // Collect filter data
        const filterData = {
          filterName: $('#filterName').val().trim(),
          filterContact: $('#filterContact').val().trim(),
          filterCenter: $('#filterCenter').val().trim(),
          filterBatch: $('#filterBatch').val().trim(),
          filterCategory: $('#filterCategory').val().trim()
        };
        console.log('filterForm data sent:', filterData);
        // Disable filter button to prevent multiple submissions
        filterButton.disabled = true;
        filterButton.textContent = 'Filtering...';
        $.ajax({
          url: '<?= base_url('Student_controller/filter_students') ?>',
          method: 'POST',
          data: filterData,
          dataType: 'json',
          success: function(response) {
            console.log('filter_students response:', response);
            tableBody.innerHTML = '';
            if (response.status === 'success' && Array.isArray(response.students) && response.students.length > 0) {
              response.students.forEach(student => {
                const row = `
                  <tr>
                    <td>${student.center || 'N/A'}</td>
                    <td>${student.name || 'N/A'}</td>
                    <td>${student.contact || 'N/A'}</td>
                    <td>${student.batch || 'N/A'}</td>
                    <td>${student.category || 'N/A'}</td>
                    <td>${student.plan_expiry || 'N/A'}</td>
                    <td>
                      <button class="action-btn edit-btn" data-id="${student.id}" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                      <button class="action-btn delete-btn" data-id="${student.id}"><i class="fas fa-trash"></i></button>
                      <button class="action-btn view-btn" data-id="${student.id}" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i></button>
                      <button class="action-btn renew-btn" data-id="${student.id}" data-toggle="modal" data-target="#renewModal"><i class="fas fa-sync"></i></button>
                    </td>
                  </tr>
                  <tr class="horizontal-line"><td colspan="7"></td></tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
              });
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: `Found ${response.students.length} matching student(s)`,
                timer: 2000
              });
            } else {
              console.warn('No students found or invalid response:', response);
              tableBody.innerHTML = '<tr><td colspan="7" class="text-center">No records match the filter criteria.</td></tr>';
              Swal.fire({
                icon: 'info',
                title: 'No Results',
                text: response.message || 'No students match the filter criteria.',
                timer: 2000
              });
            }
            $('#filterModal').modal('hide');
            this.reset();
            this.classList.remove('was-validated');
            this.querySelectorAll('input, select').forEach(input => input.setCustomValidity(''));
          },
          error: function(xhr, status, error) {
            console.error('filter_students error:', {
              responseText: xhr.responseText,
              status: status,
              error: error,
              statusCode: xhr.status
            });
            tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Failed to load filtered records.</td></tr>';
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to filter students: ' + (xhr.responseJSON?.message || error || 'Server error'),
              timer: 3000
            });
            $('#filterModal').modal('hide');
          },
          complete: function() {
            // Re-enable filter button
            filterButton.disabled = false;
            filterButton.textContent = 'Apply Filter';
          }
        });
      });

      // Clear filter form on modal close
      $('#filterModal').on('hidden.bs.modal', function () {
        const form = document.getElementById('filterForm');
        form.reset();
        form.classList.remove('was-validated');
        form.querySelectorAll('input, select').forEach(input => input.setCustomValidity(''));
        loadStudents();
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

            // Handle window resize for responsive sidebar behavior
      $(window).on('resize', function () {
        const windowWidth = $(window).width();
        const sidebar = $('#sidebar');
        const contentWrapper = $('#contentWrapper');
        const navbar = $('.navbar');

        if (windowWidth <= 576) {
          // For mobile view, ensure sidebar is not minimized but can be toggled active
          sidebar.removeClass('minimized');
          if (!sidebar.hasClass('active')) {
            contentWrapper.removeClass('minimized');
            navbar.removeClass('sidebar-minimized');
          }
        } else {
          // For larger screens, restore minimized state if applicable
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

      // Trigger resize on page load to ensure correct initial state
      $(window).trigger('resize');
    });
  </script>
</body>
</html>