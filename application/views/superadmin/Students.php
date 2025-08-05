<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  <style>
    body {
         background-color: #f4f6f8 !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
      overflow-x: hidden;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s ease-in-out;
      position: relative;
      min-height: 100vh;
    }

    .content-wrapper.minimized {
      margin-left: 60px;
    }

    .content {
      margin-top: 60px;
    }

    /* Table Styles */
    .table-container {
      overflow-x: auto;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: #fff;
      border-radius: 0.5rem;
      overflow: hidden;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .table thead th {
      color: black;
      border-bottom: 2px solid #dee2e6;
      white-space: nowrap;
      padding: 1rem;
      text-align: center;
      font-weight: 600;
    }

    .table td, .table th {
      vertical-align: middle;
      text-align: center;
      padding: 0.75rem;
      white-space: nowrap;
      border-bottom: 1px solid #dee2e6;
      font-size: 0.9rem;
    }

    .table tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.05);
    }

    .table .horizontal-line td {
      border: none;
      background-color: #dee2e6;
      height: 1px;
      padding: 0;
    }

    .action-btn {
      background: none;
      border: none;
      font-size: 1rem;
      margin: 0 0.25rem;
      transition: transform 0.2s ease;
      color: #6c757d;
    }

    .action-btn:hover {
      transform: scale(1.2);
      color: #007bff;
    }

    /* Button Styles */
    .btn-custom {
      background: #007bff;
      color: white;
      border: none;
      border-radius: 0.375rem;
      padding: 0.6rem 1.25rem;
      font-size: 0.95rem;
      font-weight: 500;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background: #0056b3;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      transform: translateY(-2px);
    }

    /* Modal Styles */
    .modal-content {
      background-color: #fff;
      border-radius: 0.75rem;
      padding: 2rem;
      border: none;
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
      margin-top: 65px;
      max-width: 800px;
      max-height: 85vh;
      overflow-y: auto;
    }

    .modal-content h3 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 1.75rem;
      color: #343a40;
      letter-spacing: 0.5px;
    }

    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
      position: relative;
    }

    .modal-header .close {
      position: absolute;
      right: 1.5rem;
      top: 1.5rem;
      font-size: 1.5rem;
      color: #6c757d;
      opacity: 0.7;
      transition: opacity 0.3s ease;
    }

    .modal-header .close:hover {
      opacity: 1;
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    .form-group label {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
      color: #343a40;
      display: block;
    }

    .form-control, .form-check-input {
      height: calc(2.5rem + 2px);
      border-radius: 0.375rem;
      font-size: 0.9rem;
      border: 1px solid #ced4da;
      transition: all 0.3s ease;
      padding: 0.5rem 1rem;
      background-color: #f8f9fa;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.2);
      background-color: #fff;
    }

    .form-check-input {
      margin-top: 0.3rem;
      margin-right: 0.5rem;
    }

    .form-check-label {
      font-size: 0.9rem;
      color: #495057;
    }

    .invalid-feedback {
      font-size: 0.85rem;
      color: #dc3545;
      margin-top: 0.25rem;
    }

    .was-validated .form-control:invalid, .form-control.is-invalid {
      border-color: #dc3545;
      background-image: none;
    }

    .was-validated .form-control:valid, .form-control.is-valid {
      border-color: #28a745;
      background-image: none;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(8px);
      background-color: rgba(0, 0, 0, 0.5);
    }

    .add-btn-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
      gap: 12px;
      align-items: center;
    }

    /* Step Navigation Styles */
    .step-nav {
      display: flex;
      justify-content: space-between;
      background-color: #e9ecef;
      border-radius: 0.5rem 0.5rem 0 0;
      padding: 1rem;
      margin-bottom: 1.5rem;
      gap: 30px;
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

    /* Receipt Styles */
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

    /* Modal Footer */
    .modal-footer {
      border-top: none;
      padding-top: 1rem;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
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

    /* Responsive Design */
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0 !important;
        padding: 1rem !important;
      }

      .table {
        font-size: 0.8rem;
      }

      .action-btn {
        margin: 0.1rem;
        font-size: 0.8rem;
      }

      .modal-content {
        padding: 1.25rem;
        /* max-width: 95%; */
      }

      .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -5px;
        margin-left: -5px;
      }

      .form-group {
        padding-right: 5px;
        padding-left: 5px;
      }

      .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
      }

      .add-btn-container {
        justify-content: center;
        gap: 10px;
      }

      .btn-custom {
        width: 120px;
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
      }

      .step-nav {
        flex-direction: column;
        gap: 15px;
        padding: 0.75rem;
      }

      .step-nav span {
        font-size: 0.9rem;
        padding: 5px;
      }

      .step-nav span i {
        font-size: 1.2rem;
        margin-left: 8px;
      }
    }

    @media (min-width: 577px) and (max-width: 768px) {
      .content-wrapper {
        margin-left: 0 !important;
        padding: 1rem !important;
      }

      .content-wrapper.minimized {
        margin-left: 0;
      }

      .table {
        font-size: 0.85rem;
      }

      .modal-content {
        padding: 1.5rem;
        max-width: 90%;
      }

      .add-btn-container {
        justify-content: center;
        gap: 8px;
      }

      .btn-custom {
        font-size: 0.9rem;
      }

      .step-nav {
        gap: 20px;
        padding: 0.75rem;
      }

      .step-nav span {
        font-size: 0.9rem;
      }

      .step-nav span i {
        font-size: 1.3rem;
        margin-left: 8px;
      }
    }

    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
      }

      .content-wrapper.minimized {
        margin-left: 60px;
      }

      .table {
        font-size: 0.9rem;
      }

      .modal-content {
        max-width: 700px;
      }

      .step-nav {
        gap: 25px;
      }

      .step-nav span i {
        font-size: 1.4rem;
        margin-left: 10px;
      }
    }

    @media (min-width: 992px) {
      .modal-content {
        max-width: 800px;
      }

      .step-nav {
        gap: 30px;
      }

      .step-nav span i {
        font-size: 1.5rem;
        margin-left: 12px;
      }
    }

    /* Touch device hover fix */
    @media (hover: none) {
      .action-btn:hover,
      .btn-custom:hover,
      .modal-footer .btn-secondary:hover {
        background-color: inherit;
        transform: none;
        box-shadow: none;
      }
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
    <div class="container-fluid">
      <!-- Add Button and Filter -->
      <div class="add-btn-container">
        <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
          <i class="fas fa-filter mr-1"></i> Filter
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
              <td>897657689</td>
              <td>B1</td>
              <td>Corporate</td>
              <td>2025-07-31</td>
              <td>
                <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="Jane Doe" data-contact="897657689" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="Jane Doe" data-contact="897657689" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-eye"></i></button>
                <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="Jane Doe" data-contact="897657689" data-center="Center 1" data-batch="B1" data-category="Corporate"><i class="fas fa-sync"></i></button>
              </td>
            </tr>
            <tr class="horizontal-line"><td colspan="7"></td></tr>
            <tr>
              <td>Center 2</td>
              <td>John Smith</td>
              <td>987654321</td>
              <td>B2</td>
              <td>Individual</td>
              <td>2025-06-15</td>
              <td>
                <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="John Smith" data-contact="987654321" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="John Smith" data-contact="987654321" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-eye"></i></button>
                <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="John Smith" data-contact="987654321" data-center="Center 2" data-batch="B2" data-category="Individual"><i class="fas fa-sync"></i></button>
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
            <input type="tel" id="contact" name="contact" class="form-control" required pattern="[0-9]{10}" title="Contact must be exactly 10 digits"/>
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
            <input type="tel" id="emergencyContact" name="emergencyContact" class="form-control" required pattern="[0-9]{10}" title="Emergency contact must be exactly 10 digits"/>
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
            <input type="text" id="address" name="address" class="form-control" required minlength="5" maxlength="200"/>
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
            <input type="text" id="center" name="center" class="form-control" required pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces" minlength="2" maxlength="50"/>
            <div class="invalid-feedback">Please enter a valid center name (2-50 letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="batch">Batch <span class="text-danger">*</span></label>
            <input type="text" id="batch" name="batch" class="form-control" required pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only" minlength="1" maxlength="10"/>
            <div class="invalid-feedback">Please enter a valid batch (1-10 letters/numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="category">Category <span class="text-danger">*</span></label>
            <select id="category" name="category" class="form-control" required>
              <option value="">Select</option>
              <option>Coach</option>
              <option>Coordinator</option>
              <option>Corporate</option>
              <option>Individual</option>
            </select>
            <div class="invalid-feedback">Please select a category.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="coach">Coach <span class="text-danger">*</span></label>
            <select id="coach" name="coach" class="form-control" required>
              <option value="">Select</option>
              <option>GHJK</option>
              <option>DFGH</option>
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
              <option>1 month</option>
              <option>2 months</option>
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
            <input type="number" id="totalFees" name="totalFees" class="form-control" required min="1" title="Total fees must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid total fees amount greater than 0.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="amountPaid">Amount Paid <span class="text-danger">*</span></label>
            <input type="number" id="amountPaid" name="amountPaid" class="form-control" required min="0" title="Amount paid must be a positive number or zero"/>
            <div class="invalid-feedback">Please enter a valid amount paid.</div>
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
            <input type="text" id="filterName" name="filterName" class="form-control" pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="filterContact">Contact</label>
            <input type="tel" id="filterContact" name="filterContact" class="form-control" pattern="[0-9]{10}" title="Contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="filterCenter">Center</label>
            <input type="text" id="filterCenter" name="filterCenter" class="form-control" pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="filterBatch">Batch</label>
            <input type="text" id="filterBatch" name="filterBatch" class="form-control" pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only"/>
            <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="filterCategory">Category</label>
            <select id="filterCategory" name="filterCategory" class="form-control">
              <option value="">All</option>
              <option>Corporate</option>
              <option>Individual</option>
              <option>Coach</option>
              <option>Coordinator</option>
            </select>
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
            <input type="text" id="editName" name="editName" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="editContact">Contact <span class="text-danger">*</span></label>
            <input type="tel" id="editContact" name="editContact" class="form-control" required pattern="[0-9]{10}" title="Contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="editCenter">Center <span class="text-danger">*</span></label>
            <input type="text" id="editCenter" name="editCenter" class="form-control" required pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="editBatch">Batch <span class="text-danger">*</span></label>
            <input type="text" id="editBatch" name="editBatch" class="form-control" required pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only"/>
            <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="editCategory">Category <span class="text-danger">*</span></label>
            <select id="editCategory" name="editCategory" class="form-control" required>
              <option value="">Select</option>
              <option>Corporate</option>
              <option>Individual</option>
              <option>Coach</option>
              <option>Coordinator</option>
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
            <input type="number" id="renewTotalFees" name="renewTotalFees" class="form-control" required min="0" title="Total fees must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid total fees amount.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="renewAmountPaid">Amount Paid <span class="text-danger">*</span></label>
            <input type="number" id="renewAmountPaid" name="renewAmountPaid" class="form-control" required min="0" title="Amount paid must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid amount paid.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="renewRemainingAmount">Remaining Amount <span class="text-danger">*</span></label>
            <input type="number" id="renewRemainingAmount" name="renewRemainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly/>
            <div class="invalid-feedback">Please enter a valid remaining amount.</div>
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

<!-- Form Validation, Navigation, and Table Management -->
<script>
  $(document).ready(function () {
    const forms = ['admissionForm1', 'admissionForm2', 'admissionForm3', 'filterForm', 'editForm', 'renewForm'].map(id => document.getElementById(id));
    const tableBody = document.querySelector('#studentTableBody');
    let initialRows = Array.from(document.querySelectorAll('#studentTableBody tr:not(.horizontal-line)')).map(row => row.outerHTML);

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
        if (!isValid) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });

    // Navigation between steps
    $('#admissionForm1').on('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        $('#newAdmissionModal').modal('hide');
        $('#batchDetailsModal').modal('show');
      }
      this.classList.add('was-validated');
    });

    $('#admissionForm2').on('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        $('#batchDetailsModal').modal('hide');
        $('#feesDetailsModal').modal('show');
      }
      this.classList.add('was-validated');
    });

    // Calculate remaining amount
    ['amountPaid', 'renewAmountPaid'].forEach(id => {
      document.getElementById(id).addEventListener('input', function () {
        const totalFees = parseFloat(document.getElementById(id === 'amountPaid' ? 'totalFees' : 'renewTotalFees').value) || 0;
        const amountPaid = parseFloat(this.value) || 0;
        document.getElementById(id === 'amountPaid' ? 'remainingAmount' : 'renewRemainingAmount').value = Math.max(0, totalFees - amountPaid);
      });
    });

    // Add new student to table
    $('#admissionForm3').on('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        const name = $('#name').val();
        const contact = $('#contact').val();
        const center = $('#center').val();
        const batch = $('#batch').val();
        const category = $('#category').val();
        const duration = $('#duration').val();
        const expiryDate = new Date();
        if (duration === '1 month') expiryDate.setMonth(expiryDate.getMonth() + 1);
        else if (duration === '2 months') expiryDate.setMonth(expiryDate.getMonth() + 2);
        const expiry = expiryDate.toISOString().split('T')[0];

        const newRow = `
          <tr>
            <td>${center}</td>
            <td>${name}</td>
            <td>${contact}</td>
            <td>${batch}</td>
            <td>${category}</td>
            <td>${expiry}</td>
            <td>
              <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}"><i class="fas fa-edit"></i></button>
              <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
              <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}" data-totalfees="${$('#totalFees').val()}" data-amountpaid="${$('#amountPaid').val()}" data-remaining="${$('#remainingAmount').val()}" data-paymentmethod="${$('input[name="paymentMethod"]:checked').val() || ''}"><i class="fas fa-eye"></i></button>
              <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}"><i class="fas fa-sync"></i></button>
            </td>
          </tr>
          <tr class="horizontal-line"><td colspan="7"></td></tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', newRow);
        initialRows.push(newRow);

        // Update receipt modal with new data
        $('#receiptName').text(name);
        $('#receiptContact').text(contact);
        $('#receiptCenter').text(center);
        $('#receiptBatch').text(batch);
        $('#receiptCategory').text(category);
        $('#receiptTotalFees').text($('#totalFees').val());
        $('#receiptAmountPaid').text($('#amountPaid').val());
        $('#receiptRemainingAmount').text($('#remainingAmount').val());
        $('#receiptPaymentMethod').text($('input[name="paymentMethod"]:checked').val() || '');

        $('#feesDetailsModal').modal('hide');
        forms.forEach(f => f.reset());
        forms.forEach(f => f.classList.remove('was-validated'));
      }
      this.classList.add('was-validated');
    });

    // Edit functionality
    $(document).on('click', '.edit-btn', function () {
      const row = $(this).closest('tr');
      $('#editName').val($(this).data('name'));
      $('#editContact').val($(this).data('contact'));
      $('#editCenter').val($(this).data('center'));
      $('#editBatch').val($(this).data('batch'));
      $('#editCategory').val($(this).data('category'));

      $('#editForm').on('submit', function (event) {
        if (this.checkValidity()) {
          event.preventDefault();
          const name = $('#editName').val();
          const contact = $('#editContact').val();
          const center = $('#editCenter').val();
          const batch = $('#editBatch').val();
          const category = $('#editCategory').val();
          row.find('td').eq(0).text(center);
          row.find('td').eq(1).text(name);
          row.find('td').eq(2).text(contact);
          row.find('td').eq(3).text(batch);
          row.find('td').eq(4).text(category);
          row.find('.edit-btn').data('name', name);
          row.find('.edit-btn').data('contact', contact);
          row.find('.edit-btn').data('center', center);
          row.find('.edit-btn').data('batch', batch);
          row.find('.edit-btn').data('category', category);
          row.find('.view-btn').data('name', name);
          row.find('.view-btn').data('contact', contact);
          row.find('.view-btn').data('center', center);
          row.find('.view-btn').data('batch', batch);
          row.find('.view-btn').data('category', category);
          row.find('.renew-btn').data('name', name);
          row.find('.renew-btn').data('contact', contact);
          row.find('.renew-btn').data('center', center);
          row.find('.renew-btn').data('batch', batch);
          row.find('.renew-btn').data('category', category);
          $('#editModal').modal('hide');
          this.classList.remove('was-validated');
          initialRows = Array.from(document.querySelectorAll('#studentTableBody tr:not(.horizontal-line)')).map(row => row.outerHTML);
        }
        this.classList.add('was-validated');
      });
    });

    // Delete functionality
    $(document).on('click', '.delete-btn', function () {
      if (confirm('Are you sure you want to delete this record?')) {
        const row = $(this).closest('tr');
        const nextLine = row.next('tr.horizontal-line');
        if (nextLine.length) nextLine.remove();
        row.remove();
        initialRows = Array.from(document.querySelectorAll('#studentTableBody tr:not(.horizontal-line)')).map(row => row.outerHTML);
      }
    });

    // Handle receipt view
    $(document).on('click', '.view-btn', function () {
      $('#receiptName').text($(this).data('name'));
      $('#receiptContact').text($(this).data('contact'));
      $('#receiptCenter').text($(this).data('center'));
      $('#receiptBatch').text($(this).data('batch'));
      $('#receiptCategory').text($(this).data('category'));
      $('#receiptTotalFees').text($(this).data('totalfees') || '');
      $('#receiptAmountPaid').text($(this).data('amountpaid') || '');
      $('#receiptRemainingAmount').text($(this).data('remaining') || '');
      $('#receiptPaymentMethod').text($(this).data('paymentmethod') || '');
    });

    // Handle renew view
    $(document).on('click', '.renew-btn', function () {
      $('#renewName').val($(this).data('name'));
      $('#renewContact').val($(this).data('contact'));
      $('#renewCenter').val($(this).data('center'));
      $('#renewBatch').val($(this).data('batch'));
      $('#renewCategory').val($(this).data('category'));

      $('#renewForm').on('submit', function (event) {
        if (this.checkValidity()) {
          event.preventDefault();
          const duration = $('#duration').val() || '1 month';
          const expiryDate = new Date();
          if (duration === '1 month') expiryDate.setMonth(expiryDate.getMonth() + 1);
          else if (duration === '2 months') expiryDate.setMonth(expiryDate.getMonth() + 2);
          const newExpiry = expiryDate.toISOString().split('T')[0];
          $(this).closest('tr').find('td').eq(5).text(newExpiry);
          $('#renewModal').modal('hide');
          this.classList.remove('was-validated');
          alert('Admission renewed successfully!');
          initialRows = Array.from(document.querySelectorAll('#studentTableBody tr:not(.horizontal-line)')).map(row => row.outerHTML);
        }
        this.classList.add('was-validated');
      });
    });

    // Filter form submission
    $('#filterForm').on('submit', function (event) {
      event.preventDefault();
      if (!this.checkValidity()) return;

      const filterName = $('#filterName').val().trim().toLowerCase();
      const filterContact = $('#filterContact').val().trim();
      const filterCenter = $('#filterCenter').val().trim().toLowerCase();
      const filterBatch = $('#filterBatch').val().trim().toLowerCase();
      const filterCategory = $('#filterCategory').val().trim().toLowerCase();

      const filteredRows = initialRows.filter(row => {
        const rowElement = document.createElement('div');
        rowElement.innerHTML = row;
        const name = rowElement.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const contact = rowElement.querySelector('td:nth-child(3)').textContent;
        const center = rowElement.querySelector('td:nth-child(1)').textContent.toLowerCase();
        const batch = rowElement.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const category = rowElement.querySelector('td:nth-child(5)').textContent.toLowerCase();

        return (!filterName || name.includes(filterName)) &&
               (!filterContact || contact.includes(filterContact)) &&
               (!filterCenter || center.includes(filterCenter)) &&
               (!filterBatch || batch.includes(filterBatch)) &&
               (!filterCategory || category.includes(filterCategory));
      });

      tableBody.innerHTML = filteredRows.length ? filteredRows.join('<tr class="horizontal-line"><td colspan="7"></td></tr>') : '<tr><td colspan="7" class="text-center">No records match the filter criteria.</td></tr>';

      $('#filterModal').modal('hide');
      this.reset();
      this.classList.remove('was-validated');
      this.querySelectorAll('input').forEach(input => input.setCustomValidity(''));
    });

    // Clear filter form on modal close
    $('#filterModal').on('hidden.bs.modal', function () {
      const form = document.getElementById('filterForm');
      form.reset();
      form.classList.remove('was-validated');
      form.querySelectorAll('input').forEach(input => input.setCustomValidity(''));
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

    // Handle window resize
    $(window).on('resize', function () {
      if ($(window).width() <= 576) {
        $('#sidebar').removeClass('minimized');
        $('.navbar').removeClass('sidebar-minimized');
        $('#contentWrapper').removeClass('minimized');
      }
    });
  });
</script>
</body>
</html>