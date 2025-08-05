<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admission Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
 <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa !important;
      margin: 0;
        font-family: 'Montserrat', sans-serif;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s ease-in-out;
    }

    .content-wrapper.minimized {
      margin-left: 60px;
    }

    .content {
      margin-left: 0;
    }

    .table-container {
      overflow-x: auto;
      margin-top: 20px;
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
      /* background-color: #343a40; */
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

    .btn-custom {
      /* background: linear-gradient(to right, #ff4040, #990000); */
      color: black;
      border: none;
      border-radius: 0.25rem;
      padding: 0.5rem 1rem;
      font-size: 1rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
          margin-top: 20px;
    }

    .btn-custom:hover {
      box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
      transform: translateY(-1px);
    }

    .modal-content {
      background-color: #fff;
      border-radius: 0.5rem;
      padding: 1.5rem;
      border: none;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .modal-content h3 {
      text-align: center;
      font-weight: 700;
      /* margin-bottom: 1.5rem; */
      font-size: 1.5rem;
      color: #343a40;
    }

    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
    }

    .form-group label {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
      color: #495057;
    }

    .form-control {
      height: calc(2.25rem + 2px);
      border-radius: 0.25rem;
      font-size: 0.9rem;
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
      border: 1px solid #ced4da;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
      border-color: #80bdff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .step-nav {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem;
      background-color: #e9ecef;
      border-radius: 0.25rem 0.25rem 0 0;
      margin-bottom: 1rem;
    }

    .step-nav span {
      font-weight: 600;
      color: #6c757d;
      position: relative;
      padding-bottom: 0.5rem;
    }

    .step-active {
      color: #007bff;
    }

    .step-active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 2px;
      background-color: #007bff;
    }

    .receipt-card {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      padding: 1rem;
      margin: 1rem 0;
    }

    .receipt-card p {
      margin: 0.25rem 0;
      font-size: 0.9rem;
    }

    .invalid-feedback {
      font-size: 0.875rem;
      color: #dc3545;
    }

    .was-validated .form-control:invalid, .form-control.is-invalid {
      border-color: #dc3545;
    }

    .was-validated .form-control:valid, .form-control.is-valid {
      border-color: #28a745;
    }

    @media (max-width: 768px) {
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
        padding: 1rem;
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
    }

    @media (min-width: 769px) and (max-width: 1024px) {
      .content-wrapper {
        margin-left: 200px;
      }

      .content-wrapper.minimized {
        margin-left: 60px;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('admin/Include/Navbar') ?>

  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12 d-flex justify-content-end">
        <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal">
          <i class="fas fa-filter mr-1"></i> Filter
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper" id="contentWrapper">
      <div class="content">
        <div class="container-fluid">
          <div class="table-responsive table-container">
            <table class="table table-bordered table-hover" id="admissionTable">
              <thead class="thead-dark1">
                <tr>
                  <th>Name</th>
                  <th>Contact</th>
                  <th>Center</th>
                  <th>Batch</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Jane Doe</td>
                  <td>897657689</td>
                  <td>ABC</td>
                  <td>B1</td>
                  <td>Corporate</td>
                  <td>
                    <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i></button>
                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-file-invoice"></i></button>
                    <button class="action-btn postpone-btn" data-toggle="modal" data-target="#postponeModal"><i class="fas fa-calendar-plus"></i></button>
                    <button class="action-btn prepone-btn" data-toggle="modal" data-target="#preponeModal"><i class="fas fa-calendar-minus"></i></button>
                    <button class="action-btn cancel-btn" data-toggle="modal" data-target="#cancelModal"><i class="fas fa-ban"></i></button>
                  </td>
                </tr>
                <tr class="horizontal-line"><td colspan="6"></td></tr>
                <tr>
                  <td>John Smith</td>
                  <td>987654321</td>
                  <td>XYZ</td>
                  <td>B2</td>
                  <td>Individual</td>
                  <td>
                    <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i></button>
                    <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                    <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-file-invoice"></i></button>
                    <button class="action-btn postpone-btn" data-toggle="modal" data-target="#postponeModal"><i class="fas fa-calendar-plus"></i></button>
                    <button class="action-btn prepone-btn" data-toggle="modal" data-target="#preponeModal"><i class="fas fa-calendar-minus"></i></button>
                    <button class="action-btn cancel-btn" data-toggle="modal" data-target="#cancelModal"><i class="fas fa-ban"></i></button>
                  </td>
                </tr>
                <tr class="horizontal-line"><td colspan="6"></td></tr>
              </tbody>
            </table>
          </div>

          <!-- New Admission Button -->
          <div class="row mt-3">
            <div class="col-12 text-right">
              <button class="btn btn-custom" data-toggle="modal" data-target="#newAdmissionModal">
                <i class="fas fa-plus mr-1"></i> New Admission
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- New Admission Modal (Step 1: Personal Details) -->
  <div class="modal fade" id="newAdmissionModal" tabindex="-1" aria-labelledby="newAdmissionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <div class="step-nav w-100">
            <span class="step-active">1. Personal Details</span>
            <span>2. Batch Details</span>
            <span>3. Fees Details</span>
          </div>
        </div>
        <h3 id="newAdmissionLabel" class="mb-4">Admission Form</h3>
        <form id="admissionForm1" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Full Name <span class="text-danger">*</span></label>
              <input type="text" id="name" name="name" class="form-control" required
                     pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="contact">Contact Number <span class="text-danger">*</span></label>
              <input type="tel" id="contact" name="contact" class="form-control" required
                     pattern="[0-9]{10}" title="Contact should be a 10-digit number">
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="parentName">Parent Name <span class="text-danger">*</span></label>
              <input type="text" id="parentName" name="parentName" class="form-control" required
                     pattern="[A-Za-z\s]+" title="Parent name should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid parent name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="emergencyContact">Emergency Contact <span class="text-danger">*</span></label>
              <input type="tel" id="emergencyContact" name="emergencyContact" class="form-control" required
                     pattern="[0-9]{10}" title="Emergency contact should be a 10-digit number">
              <div class="invalid-feedback">Please enter a valid 10-digit emergency contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email">Email Address <span class="text-danger">*</span></label>
              <input type="email" id="email" name="email" class="form-control" required
                     pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address">
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="address">Address <span class="text-danger">*</span></label>
              <textarea id="address" name="address" class="form-control" rows="1" required></textarea>
              <div class="invalid-feedback">Please enter an address.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
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
          <div class="step-nav w-100">
            <span>1. Personal Details</span>
            <span class="step-active">2. Batch Details</span>
            <span>3. Fees Details</span>
          </div>
        </div>
        <h3 id="batchDetailsLabel" class="mb-4">Admission Form</h3>
        <form id="admissionForm2" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="center">Center <span class="text-danger">*</span></label>
              <input type="text" id="center" name="center" class="form-control" required
                     pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="batch">Batch <span class="text-danger">*</span></label>
              <input type="text" id="batch" name="batch" class="form-control" required
                     pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only">
              <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="category">Category <span class="text-danger">*</span></label>
              <select id="category" name="category" class="form-control" required>
                <option value="" selected disabled>Select Category</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
                <option value="Student">Student</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="coach">Coach <span class="text-danger">*</span></label>
              <select id="coach" name="coach" class="form-control" required>
                <option value="" selected disabled>Select Coach</option>
                <option value="John Doe">John Doe</option>
                <option value="Jane Smith">Jane Smith</option>
                <option value="Mike Johnson">Mike Johnson</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="duration">Duration <span class="text-danger">*</span></label>
              <select id="duration" name="duration" class="form-control" required>
                <option value="" selected disabled>Select Duration</option>
                <option value="1 month">1 month</option>
                <option value="2 months">2 months</option>
                <option value="3 months">3 months</option>
                <option value="6 months">6 months</option>
                <option value="1 year">1 year</option>
              </select>
              <div class="invalid-feedback">Please select a duration.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
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
          <div class="step-nav w-100">
            <span>1. Personal Details</span>
            <span>2. Batch Details</span>
            <span class="step-active">3. Fees Details</span>
          </div>
        </div>
        <h3 id="feesDetailsLabel" class="mb-4">Admission Form</h3>
        <form id="admissionForm3" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="totalFees">Total Fees (₹) <span class="text-danger">*</span></label>
              <input type="number" id="totalFees" name="totalFees" class="form-control" required
                     min="0" step="0.01" title="Total fees must be a positive number">
              <div class="invalid-feedback">Please enter a valid total fees amount.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="amountPaid">Amount Paid (₹) <span class="text-danger">*</span></label>
              <input type="number" id="amountPaid" name="amountPaid" class="form-control" required
                     min="0" step="0.01" title="Amount paid must be a positive number">
              <div class="invalid-feedback">Please enter a valid amount paid.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="remainingAmount">Remaining Amount (₹) <span class="text-danger">*</span></label>
              <input type="number" id="remainingAmount" name="remainingAmount" class="form-control" required
                     min="0" step="0.01" title="Remaining amount must be a positive number">
              <div class="invalid-feedback">Please enter a valid remaining amount.</div>
            </div>
            <div class="form-group col-md-6">
              <label>Payment Method <span class="text-danger">*</span></label>
              <div class="d-flex">
                <div class="form-check mr-3">
                  <input type="radio" id="cash" name="paymentMethod" class="form-check-input" value="Cash" required>
                  <label class="form-check-label" for="cash">Cash</label>
                </div>
                <div class="form-check mr-3">
                  <input type="radio" id="online" name="paymentMethod" class="form-check-input" value="Online">
                  <label class="form-check-label" for="online">Online</label>
                </div>
                <div class="form-check">
                  <input type="radio" id="cheque" name="paymentMethod" class="form-check-input" value="Cheque">
                  <label class="form-check-label" for="cheque">Cheque</label>
                </div>
              </div>
              <div class="invalid-feedback">Please select a payment method.</div>
            </div>
          </div>
          <div class="modal-footer border-top-0 pt-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
            <button type="submit" class="btn btn-custom">Generate Receipt</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Postpone Modal -->
  <div class="modal fade" id="postponeModal" tabindex="-1" aria-labelledby="postponeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="postponeLabel" class="modal-title w-100 text-center">Postpone Admission</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="postponeForm" novalidate>
          <div class="form-group">
            <label for="postponeDate">New Date <span class="text-danger">*</span></label>
            <input type="date" id="postponeDate" name="postponeDate" class="form-control" required>
            <div class="invalid-feedback">Please select a new date.</div>
          </div>
          <div class="form-group">
            <label for="postponeReason">Reason <span class="text-danger">*</span></label>
            <textarea id="postponeReason" name="postponeReason" class="form-control" rows="3" required></textarea>
            <div class="invalid-feedback">Please provide a reason for postponement.</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Prepone Modal -->
  <div class="modal fade" id="preponeModal" tabindex="-1" aria-labelledby="preponeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="preponeLabel" class="modal-title w-100 text-center">Prepone Admission</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="preponeForm" novalidate>
          <div class="form-group">
            <label for="preponeDate">New Date <span class="text-danger">*</span></label>
            <input type="date" id="preponeDate" name="preponeDate" class="form-control" required>
            <div class="invalid-feedback">Please select a new date.</div>
          </div>
          <div class="form-group">
            <label for="preponeReason">Reason <span class="text-danger">*</span></label>
            <textarea id="preponeReason" name="preponeReason" class="form-control" rows="3" required></textarea>
            <div class="invalid-feedback">Please provide a reason for preponement.</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Cancel Modal -->
  <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="cancelLabel" class="modal-title w-100 text-center">Cancel Admission</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="cancelForm" novalidate>
          <div class="form-group">
            <label for="cancelReason">Reason for Cancellation <span class="text-danger">*</span></label>
            <textarea id="cancelReason" name="cancelReason" class="form-control" rows="4" required></textarea>
            <div class="invalid-feedback">Please provide a reason for cancellation.</div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Confirm Cancellation</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Filter Modal -->
  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="filterLabel" class="modal-title w-100 text-center">Filter Admissions</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="filterForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterName">Name</label>
              <input type="text" id="filterName" name="filterName" class="form-control"
                     pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="filterContact">Contact</label>
              <input type="tel" id="filterContact" name="filterContact" class="form-control"
                     pattern="[0-9]{10}" title="Contact should be a 10-digit number">
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterCenter">Center</label>
              <input type="text" id="filterCenter" name="filterCenter" class="form-control"
                     pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="filterBatch">Batch</label>
              <input type="text" id="filterBatch" name="filterBatch" class="form-control"
                     pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only">
              <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="filterCategory">Category</label>
              <select id="filterCategory" name="filterCategory" class="form-control">
                <option value="" selected>All Categories</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
                <option value="Student">Student</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="filterStatus">Status</label>
              <select id="filterStatus" name="filterStatus" class="form-control">
                <option value="" selected>All Statuses</option>
                <option value="Active">Active</option>
                <option value="Postponed">Postponed</option>
                <option value="Preponed">Preponed</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
            <button type="submit" class="btn btn-custom">Apply Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="editLabel" class="modal-title w-100 text-center">Edit Admission</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editName">Name <span class="text-danger">*</span></label>
              <input type="text" id="editName" name="editName" class="form-control" required
                     pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="editContact">Contact <span class="text-danger">*</span></label>
              <input type="tel" id="editContact" name="editContact" class="form-control" required
                     pattern="[0-9]{10}" title="Contact should be a 10-digit number">
              <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editCenter">Center <span class="text-danger">*</span></label>
              <input type="text" id="editCenter" name="editCenter" class="form-control" required
                     pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces">
              <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
            </div>
            <div class="form-group col-md-6">
              <label for="editBatch">Batch <span class="text-danger">*</span></label>
              <input type="text" id="editBatch" name="editBatch" class="form-control" required
                     pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only">
              <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="editCategory">Category <span class="text-danger">*</span></label>
              <select id="editCategory" name="editCategory" class="form-control" required>
                <option value="" selected disabled>Select Category</option>
                <option value="Corporate">Corporate</option>
                <option value="Individual">Individual</option>
                <option value="Student">Student</option>
              </select>
              <div class="invalid-feedback">Please select a category.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="editCoach">Coach <span class="text-danger">*</span></label>
              <select id="editCoach" name="editCoach" class="form-control" required>
                <option value="" selected disabled>Select Coach</option>
                <option value="John Doe">John Doe</option>
                <option value="Jane Smith">Jane Smith</option>
                <option value="Mike Johnson">Mike Johnson</option>
              </select>
              <div class="invalid-feedback">Please select a coach.</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-custom">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Receipt View Modal -->
  <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 id="receiptLabel" class="modal-title w-100 text-center">Admission Receipt</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="receipt-card">
            <div class="row">
              <div class="col-md-4">
                <h5 class="mb-3">1. Personal Details</h5>
                <p><strong>Name:</strong> <span id="receiptName"></span></p>
                <p><strong>Contact:</strong> <span id="receiptContact"></span></p>
                <p><strong>Parent Name:</strong> <span id="receiptParentName"></span></p>
                <p><strong>Emergency Contact:</strong> <span id="receiptEmergencyContact"></span></p>
                <p><strong>Email:</strong> <span id="receiptEmail"></span></p>
                <p><strong>Address:</strong> <span id="receiptAddress"></span></p>
              </div>
              <div class="col-md-4">
                <h5 class="mb-3">2. Batch Details</h5>
                <p><strong>Center:</strong> <span id="receiptCenter"></span></p>
                <p><strong>Batch:</strong> <span id="receiptBatch"></span></p>
                <p><strong>Category:</strong> <span id="receiptCategory"></span></p>
                <p><strong>Coach:</strong> <span id="receiptCoach"></span></p>
                <p><strong>Duration:</strong> <span id="receiptDuration"></span></p>
              </div>
              <div class="col-md-4">
                <h5 class="mb-3">3. Fees Details</h5>
                <p><strong>Total Fees:</strong> ₹<span id="receiptTotalFees"></span></p>
                <p><strong>Amount Paid:</strong> ₹<span id="receiptAmountPaid"></span></p>
                <p><strong>Remaining Amount:</strong> ₹<span id="receiptRemainingAmount"></span></p>
                <p><strong>Payment Mode:</strong> <span id="receiptPaymentMethod"></span></p>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-12 text-center">
                <p class="mb-0"><strong>Date:</strong> <span id="receiptDate"></span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-custom" onclick="window.print()">
            <i class="fas fa-print mr-1"></i> Print Receipt
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap + jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Validation, Navigation, and Table Management -->
  <script>
    $(document).ready(function() {
      // Set current date for receipt
      const now = new Date();
      const options = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZoneName: 'short',
        month: 'long',
        day: 'numeric',
        year: 'numeric'
      };
      $('#receiptDate').text(now.toLocaleString('en-US', options));

      // Form validation
      function validateForm(formId) {
        const form = document.getElementById(formId);
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      }

      // Validate all forms
      ['admissionForm1', 'admissionForm2', 'admissionForm3', 'filterForm',
       'editForm', 'postponeForm', 'preponeForm', 'cancelForm'].forEach(validateForm);

      // Navigation between steps
      $('#admissionForm1').on('submit', function(event) {
        if (this.checkValidity()) {
          event.preventDefault();
          $('#newAdmissionModal').modal('hide');
          $('#batchDetailsModal').modal('show');
        }
      });

      $('#admissionForm2').on('submit', function(event) {
        if (this.checkValidity()) {
          event.preventDefault();
          $('#batchDetailsModal').modal('hide');
          $('#feesDetailsModal').modal('show');
        }
      });

      // Calculate remaining amount
      $('#amountPaid').on('input', function() {
        const totalFees = parseFloat($('#totalFees').val()) || 0;
        const amountPaid = parseFloat($(this).val()) || 0;
        $('#remainingAmount').val((totalFees - amountPaid).toFixed(2));
      });

      // Add new admission to table
      $('#admissionForm3').on('submit', function(event) {
        if (this.checkValidity()) {
          event.preventDefault();

          // Get form values
          const name = $('#name').val();
          const contact = $('#contact').val();
          const center = $('#center').val();
          const batch = $('#batch').val();
          const category = $('#category').val();

          // Add new row to table
          const newRow = `
            <tr>
              <td>${name}</td>
              <td>${contact}</td>
              <td>${center}</td>
              <td>${batch}</td>
              <td>${category}</td>
              <td>
                <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal"><i class="fas fa-pen"></i></button>
                <button class="action-btn delete-btn"><i class="fas fa-trash-alt"></i></button>
                <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-file-invoice"></i></button>
                <button class="action-btn postpone-btn" data-toggle="modal" data-target="#postponeModal"><i class="fas fa-calendar-plus"></i></button>
                <button class="action-btn prepone-btn" data-toggle="modal" data-target="#preponeModal"><i class="fas fa-calendar-minus"></i></button>
                <button class="action-btn cancel-btn" data-toggle="modal" data-target="#cancelModal"><i class="fas fa-ban"></i></button>
              </td>
            </tr>
            <tr class="horizontal-line"><td colspan="6"></td></tr>
          `;

          $('#admissionTable tbody').append(newRow);

          // Update receipt modal with new data
          updateReceiptModal();

          // Close modal and reset forms
          $('#feesDetailsModal').modal('hide');
          $('form').each(function() {
            this.reset();
            this.classList.remove('was-validated');
          });
        }
      });

      // Update receipt modal with form data
      function updateReceiptModal() {
        $('#receiptName').text($('#name').val());
        $('#receiptContact').text($('#contact').val());
        $('#receiptParentName').text($('#parentName').val());
        $('#receiptEmergencyContact').text($('#emergencyContact').val());
        $('#receiptEmail').text($('#email').val());
        $('#receiptAddress').text($('#address').val());
        $('#receiptCenter').text($('#center').val());
        $('#receiptBatch').text($('#batch').val());
        $('#receiptCategory').text($('#category option:selected').text());
        $('#receiptCoach').text($('#coach option:selected').text());
        $('#receiptDuration').text($('#duration option:selected').text());
        $('#receiptTotalFees').text($('#totalFees').val());
        $('#receiptAmountPaid').text($('#amountPaid').val());
        $('#receiptRemainingAmount').text($('#remainingAmount').val());
        $('#receiptPaymentMethod').text($('input[name="paymentMethod"]:checked').val());
      }

      // Edit functionality
      $(document).on('click', '.edit-btn', function() {
        const row = $(this).closest('tr');
        $('#editName').val(row.find('td:eq(0)').text());
        $('#editContact').val(row.find('td:eq(1)').text());
        $('#editCenter').val(row.find('td:eq(2)').text());
        $('#editBatch').val(row.find('td:eq(3)').text());
        $('#editCategory').val(row.find('td:eq(4)').text());
      });

      // Handle edit form submission
      $('#editForm').on('submit', function(event) {
        if (this.checkValidity()) {
          event.preventDefault();
          const row = $('.edit-btn').closest('tr');
          row.find('td:eq(0)').text($('#editName').val());
          row.find('td:eq(1)').text($('#editContact').val());
          row.find('td:eq(2)').text($('#editCenter').val());
          row.find('td:eq(3)').text($('#editBatch').val());
          row.find('td:eq(4)').text($('#editCategory').val());
          $('#editModal').modal('hide');
        }
      });

      // Delete functionality
      $(document).on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this record?')) {
          $(this).closest('tr').next('.horizontal-line').remove();
          $(this).closest('tr').remove();
        }
      });

      // View receipt functionality
      $(document).on('click', '.view-btn', function() {
        const row = $(this).closest('tr');
        $('#receiptName').text(row.find('td:eq(0)').text());
        $('#receiptContact').text(row.find('td:eq(1)').text());
        $('#receiptCenter').text(row.find('td:eq(2)').text());
        $('#receiptBatch').text(row.find('td:eq(3)').text());
        $('#receiptCategory').text(row.find('td:eq(4)').text());
      });

      // Sidebar toggle functionality
      $('#sidebarToggle').on('click', function() {
        if ($(window).width() <= 768) {
          $('#sidebar').toggleClass('active');
          $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
        } else {
          const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
          $('.navbar').toggleClass('sidebar-minimized', isMinimized);
          $('#contentWrapper').toggleClass('minimized', isMinimized);
        }
      });

      // Handle window resize
      $(window).on('resize', function() {
        if ($(window).width() <= 768) {
          $('#sidebar').removeClass('minimized');
          $('.navbar').removeClass('sidebar-minimized');
          $('#contentWrapper').removeClass('minimized');
        }
      });
    });
  </script>
</body>
</html>
