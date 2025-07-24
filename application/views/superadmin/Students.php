<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
       background-color: #e9ecef !important;
      margin: 0;
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
      margin-top: 60px;
    }

    .table thead th {
      background-color: #f8f9fa;
      color: #000;
      border-bottom: 2px solid #dee2e6;
      white-space: nowrap;
      padding: 10px;
    }

    .table td, .table th {
      vertical-align: middle;
      text-align: center;
      padding: 10px;
      white-space: nowrap;
    }

    .action-btn {
      background: none;
      border: none;
      font-size: 16px;
      margin: 0 5px;
      color: #007bff;
    }

    .action-btn:hover {
      color: #0056b3;
    }

    .new-admission-btn, .renew-btn {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 14px;
      margin-top: 10px;
      padding: 6px 12px;
    }

    .new-admission-btn:hover, .renew-btn:hover {
      background: linear-gradient(to right, #ff3030, #360000);
    }

    .filter-btn {
      background: linear-gradient(to right, #ff4040, #470000);
      color: white;
      border: none;
      border-radius: 5px;
      padding: 8px 15px;
      font-size: 14px;
      float: right;
      margin-bottom: 10px;
      margin-right: 40px;
    }

    .filter-btn:hover {
      background: linear-gradient(to right, #ff3030, #360000);
    }

    .modal-content {
      background-color: #f0ebeb;
      border-radius: 10px;
      padding: 15px;
      margin: auto;
      border: 2px solid #007bff;
      margin-top: 71px !important;
      max-width: 600px;
      max-height: 80vh;
      overflow-y: auto;
    }

    .modal-content h3 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }

    .modal-backdrop.show {
      backdrop-filter: blur(6px);
    }

    .form-group label {
      font-weight: bold;
      font-size: 14px;
    }

    .form-control {
      height: 38px;
      border-radius: 6px;
      font-size: 14px;
    }

    .submit-btn, .next-btn {
      background: linear-gradient(to top, #990000, #ff0000);
      border: none;
      color: white;
      border-radius: 8px;
      padding: 8px;
      width: 120px;
      font-weight: bold;
      display: block;
      margin: 15px auto 0;
    }

    .step-nav {
      display: flex;
      justify-content: space-between;
      padding: 8px;
      background-color: #d3d3d3;
      border-radius: 5px 5px 0 0;
      margin-bottom: 10px;
    }

    .step-nav span {
      font-weight: bold;
      display: flex;
      align-items: center;
    }

    .step-nav span i {
      margin-left: 5px;
      color: #007bff;
    }

    .step-active {
      border-bottom: 2px solid blue;
    }

    .receipt-header {
      text-align: center;
      margin-bottom: 15px;
    }

    .receipt-header img {
      max-width: 150px;
      margin-bottom: 10px;
    }

    .receipt-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 15px;
    }

    .receipt-table th, .receipt-table td {
      border: 1px solid #dee2e6;
      padding: 8px;
      text-align: left;
    }

    .receipt-table th {
      background-color: #f8f9fa;
      font-weight: bold;
    }

    .receipt-footer {
      text-align: right;
      font-weight: bold;
    }

    @media (max-width: 768px) {
      body {
        padding: 10px;
      }
      .content-wrapper {
        margin-left: 0 !important;
        padding: 10px !important;
      }
      .table {
        font-size: 12px;
      }
      .new-admission-btn, .filter-btn, .renew-btn {
        /* width: 100%; */
        margin-bottom: 10px;
        position: static;
      }
      .modal-content {
        max-width: 90%;
        padding: 10px;
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
<?php $this->load->view('superadmin/Include/Sidebar') ?>
<!-- Navbar -->
<?php $this->load->view('superadmin/Include/Navbar') ?>

<!-- Main Content -->
<div class="content-wrapper" id="contentWrapper">
  <div class="content">
    <div class="container-fluid">

      <div class="table-container">
        <table class="table table-bordered table-hover" id="studentTable">
          <thead>
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
          <tbody>
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
          </tbody>
        </table>
      </div>

      <!-- New Admission Button -->
      <div class="text-right">
        <button class="new-admission-btn" data-toggle="modal" data-target="#newAdmissionModal">Add Student</button>
      </div>
    </div>
  </div>
</div>

<!-- New Admission Modal (Step 1: Personal Details) -->
<div class="modal fade" id="newAdmissionModal" tabindex="-1" aria-labelledby="newAdmissionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="step-nav">
        <span class="step-active">1. Personal Details <i class="fas fa-arrow-right"></i></span>
        <span>2. Batch Details <i class="fas fa-arrow-right"></i></span>
        <span>3. Fees Details <i class="fas fa-arrow-right"></i></span>
      </div>
      <h3 id="newAdmissionLabel">Student Admission Form</h3>
      <form id="admissionForm1" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">Name :</label>
            <input type="text" id="name" name="name" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="contact">Contact :</label>
            <input type="tel" id="contact" name="contact" class="form-control" required pattern="[0-9]{10}" title="Contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="parentName">Parent Name :</label>
            <input type="text" id="parentName" name="parentName" class="form-control" required pattern="[A-Za-z\s]+" title="Parent name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid parent name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="emergencyContact">Emergency Contact :</label>
            <input type="tel" id="emergencyContact" name="emergencyContact" class="form-control" required pattern="[0-9]{10}" title="Emergency contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit emergency contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address"/>
            <div class="invalid-feedback">Please enter a valid email address.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="address">Address :</label>
            <input type="text" id="address" name="address" class="form-control" required/>
            <div class="invalid-feedback">Please enter an address.</div>
          </div>
        </div>
        <button type="submit" class="next-btn">Next</button>
      </form>
    </div>
  </div>
</div>

<!-- New Admission Modal (Step 2: Batch Details) -->
<div class="modal fade" id="batchDetailsModal" tabindex="-1" aria-labelledby="batchDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="step-nav">
        <span>1. Personal Details <i class="fas fa-arrow-right"></i></span>
        <span class="step-active">2. Batch Details <i class="fas fa-arrow-right"></i></span>
        <span>3. Fees Details <i class="fas fa-arrow-right"></i></span>
      </div>
      <h3 id="batchDetailsLabel">Student Admission Form</h3>
      <form id="admissionForm2" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="center">Center :</label>
            <input type="text" id="center" name="center" class="form-control" required pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="batch">Batch :</label>
            <input type="text" id="batch" name="batch" class="form-control" required pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only"/>
            <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="category">Category :</label>
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
            <label for="coach">Coach :</label>
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
            <label for="coordinator">Coordinator :</label>
            <input type="text" id="coordinator" name="coordinator" class="form-control" required pattern="[A-Za-z\s]+" title="Coordinator should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid coordinator name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="duration">Duration :</label>
            <select id="duration" name="duration" class="form-control" required>
              <option value="">Select</option>
              <option>1 month</option>
              <option>2 months</option>
            </select>
            <div class="invalid-feedback">Please select a duration.</div>
          </div>
        </div>
        <button type="submit" class="next-btn">Next</button>
      </form>
    </div>
  </div>
</div>

<!-- New Admission Modal (Step 3: Fees Details) -->
<div class="modal fade" id="feesDetailsModal" tabindex="-1" aria-labelledby="feesDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="step-nav">
        <span>1. Personal Details <i class="fas fa-arrow-right"></i></span>
        <span>2. Batch Details <i class="fas fa-arrow-right"></i></span>
        <span class="step-active">3. Fees Details <i class="fas fa-arrow-right"></i></span>
      </div>
      <h3 id="feesDetailsLabel">Student Admission Form</h3>
      <form id="admissionForm3" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="totalFees">Total Fees :</label>
            <input type="number" id="totalFees" name="totalFees" class="form-control" required min="0" title="Total fees must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid total fees amount.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="amountPaid">Amount Paid :</label>
            <input type="number" id="amountPaid" name="amountPaid" class="form-control" required min="0" title="Amount paid must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid amount paid.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="remainingAmount">Remaining Amount :</label>
            <input type="number" id="remainingAmount" name="remainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly/>
            <div class="invalid-feedback">Please enter a valid remaining amount.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="paymentMethod">Payment Method :</label>
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
        <button type="submit" class="submit-btn">Generate Receipt</button>
      </form>
    </div>
  </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <h3 id="filterLabel">Filter</h3>
      <form id="filterForm" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="filterName">Name :</label>
            <input type="text" id="filterName" name="filterName" class="form-control" pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="filterContact">Contact :</label>
            <input type="tel" id="filterContact" name="filterContact" class="form-control" pattern="[0-9]{10}" title="Contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="filterCenter">Center :</label>
            <input type="text" id="filterCenter" name="filterCenter" class="form-control" pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="filterBatch">Batch :</label>
            <input type="text" id="filterBatch" name="filterBatch" class="form-control" pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only"/>
            <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="filterCategory">Category :</label>
            <select id="filterCategory" name="filterCategory" class="form-control">
              <option value="">All</option>
              <option>Corporate</option>
              <option>Individual</option>
              <option>Coach</option>
              <option>Coordinator</option>
            </select>
          </div>
        </div>
        <button type="submit" class="submit-btn">Apply Filter</button>
      </form>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <h3 id="editLabel">Edit Student</h3>
      <form id="editForm" novalidate>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="editName">Name :</label>
            <input type="text" id="editName" name="editName" class="form-control" required pattern="[A-Za-z\s]+" title="Name should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="editContact">Contact :</label>
            <input type="tel" id="editContact" name="editContact" class="form-control" required pattern="[0-9]{10}" title="Contact should be a 10-digit number"/>
            <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="editCenter">Center :</label>
            <input type="text" id="editCenter" name="editCenter" class="form-control" required pattern="[A-Za-z\s]+" title="Center should contain only letters and spaces"/>
            <div class="invalid-feedback">Please enter a valid center name (letters and spaces only).</div>
          </div>
          <div class="form-group col-md-6">
            <label for="editBatch">Batch :</label>
            <input type="text" id="editBatch" name="editBatch" class="form-control" required pattern="[A-Za-z0-9]+" title="Batch should contain letters and numbers only"/>
            <div class="invalid-feedback">Please enter a valid batch (letters and numbers only).</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="editCategory">Category :</label>
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
        <button type="submit" class="submit-btn">Save Changes</button>
      </form>
    </div>
  </div>
</div>

<!-- Receipt View Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="receipt-header">
        <img src="https://via.placeholder.com/150" alt="Company Logo" />
        <h3>Admission Receipt</h3>
        <p>Date: 21-07-2025 03:28 PM IST</p> <!-- Updated to current time -->
      </div>
      <table class="receipt-table">
        <thead>
          <tr>
            <th>Section</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Student Name</td>
            <td><span id="receiptName"></span></td>
          </tr>
          <tr>
            <td>Contact</td>
            <td><span id="receiptContact"></span></td>
          </tr>
          <tr>
            <td>Center</td>
            <td><span id="receiptCenter"></span></td>
          </tr>
          <tr>
            <td>Batch</td>
            <td><span id="receiptBatch"></span></td>
          </tr>
          <tr>
            <td>Category</td>
            <td><span id="receiptCategory"></span></td>
          </tr>
          <tr>
            <td>Total Fees</td>
            <td>Rs. <span id="receiptTotalFees"></span></td>
          </tr>
          <tr>
            <td>Amount Paid</td>
            <td>Rs. <span id="receiptAmountPaid"></span></td>
          </tr>
          <tr>
            <td>Remaining Amount</td>
            <td>Rs. <span id="receiptRemainingAmount"></span></td>
          </tr>
          <tr>
            <td>Payment Method</td>
            <td><span id="receiptPaymentMethod"></span></td>
          </tr>
        </tbody>
      </table>
      <div class="receipt-footer">
        <p>Thank you for your payment!</p>
      </div>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>

<!-- Renew Admission Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" aria-labelledby="renewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="step-nav">
        <span class="step-active">1. Renew Fees <i class="fas fa-arrow-right"></i></span>
      </div>
      <h3 id="renewLabel">Renew Admission</h3>
      <form id="renewForm" novalidate>
        <input type="hidden" id="renewName" name="renewName">
        <input type="hidden" id="renewContact" name="renewContact">
        <input type="hidden" id="renewCenter" name="renewCenter">
        <input type="hidden" id="renewBatch" name="renewBatch">
        <input type="hidden" id="renewCategory" name="renewCategory">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="renewTotalFees">Total Fees :</label>
            <input type="number" id="renewTotalFees" name="renewTotalFees" class="form-control" required min="0" title="Total fees must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid total fees amount.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="renewAmountPaid">Amount Paid :</label>
            <input type="number" id="renewAmountPaid" name="renewAmountPaid" class="form-control" required min="0" title="Amount paid must be a positive number"/>
            <div class="invalid-feedback">Please enter a valid amount paid.</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="renewRemainingAmount">Remaining Amount :</label>
            <input type="number" id="renewRemainingAmount" name="renewRemainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number" readonly/>
            <div class="invalid-feedback">Please enter a valid remaining amount.</div>
          </div>
          <div class="form-group col-md-6">
            <label for="renewPaymentMethod">Payment Method :</label>
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
        <button type="submit" class="submit-btn">Renew Admission</button>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap + jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Form Validation, Navigation, and Table Management -->
<script>
  (function () {
    'use strict';
    const forms = ['admissionForm1', 'admissionForm2', 'admissionForm3', 'filterForm', 'editForm', 'renewForm'].map(id => document.getElementById(id));
    const tableBody = document.querySelector('#studentTable tbody');

    forms.forEach(form => {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });

    // Navigation between steps
    document.getElementById('admissionForm1').addEventListener('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        $('#newAdmissionModal').modal('hide');
        $('#batchDetailsModal').modal('show');
      }
      this.classList.add('was-validated');
    });

    document.getElementById('admissionForm2').addEventListener('submit', function (event) {
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
    document.getElementById('admissionForm3').addEventListener('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const contact = document.getElementById('contact').value;
        const center = document.getElementById('center').value;
        const batch = document.getElementById('batch').value;
        const category = document.getElementById('category').value;
        const duration = document.getElementById('duration').value;
        const expiryDate = new Date();
        if (duration === '1 month') expiryDate.setMonth(expiryDate.getMonth() + 1);
        else if (duration === '2 months') expiryDate.setMonth(expiryDate.getMonth() + 2);
        const expiry = expiryDate.toISOString().split('T')[0];

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td>${center}</td>
          <td>${name}</td>
          <td>${contact}</td>
          <td>${batch}</td>
          <td>${category}</td>
          <td>${expiry}</td>
          <td>
            <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
            <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}" data-totalfees="${document.getElementById('totalFees').value}" data-amountpaid="${document.getElementById('amountPaid').value}" data-remaining="${document.getElementById('remainingAmount').value}" data-paymentmethod="${document.querySelector('input[name="paymentMethod"]:checked') ? document.querySelector('input[name="paymentMethod"]:checked').value : ''}"><i class="fas fa-eye"></i></button>
            <button class="action-btn renew-btn" data-toggle="modal" data-target="#renewModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}"><i class="fas fa-sync"></i></button>
          </td>
        `;
        tableBody.appendChild(newRow);

        // Update receipt modal with new data
        document.getElementById('receiptName').textContent = name;
        document.getElementById('receiptContact').textContent = contact;
        document.getElementById('receiptCenter').textContent = center;
        document.getElementById('receiptBatch').textContent = batch;
        document.getElementById('receiptCategory').textContent = category;
        document.getElementById('receiptTotalFees').textContent = document.getElementById('totalFees').value;
        document.getElementById('receiptAmountPaid').textContent = document.getElementById('amountPaid').value;
        document.getElementById('receiptRemainingAmount').textContent = document.getElementById('remainingAmount').value;
        document.getElementById('receiptPaymentMethod').textContent = document.querySelector('input[name="paymentMethod"]:checked') ? document.querySelector('input[name="paymentMethod"]:checked').value : '';

        $('#feesDetailsModal').modal('hide');
        forms.forEach(f => f.reset());
        forms.forEach(f => f.classList.remove('was-validated'));
      }
      this.classList.add('was-validated');
    });

    // Edit functionality
    document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function () {
        const row = this.closest('tr');
        document.getElementById('editName').value = this.getAttribute('data-name');
        document.getElementById('editContact').value = this.getAttribute('data-contact');
        document.getElementById('editCenter').value = row.cells[0].textContent;
        document.getElementById('editBatch').value = this.getAttribute('data-batch');
        document.getElementById('editCategory').value = this.getAttribute('data-category');

        document.getElementById('editForm').onsubmit = function (event) {
          if (this.checkValidity()) {
            event.preventDefault();
            row.cells[1].textContent = document.getElementById('editName').value;
            row.cells[2].textContent = document.getElementById('editContact').value;
            row.cells[0].textContent = document.getElementById('editCenter').value;
            row.cells[3].textContent = document.getElementById('editBatch').value;
            row.cells[4].textContent = document.getElementById('editCategory').value;
            button.setAttribute('data-name', document.getElementById('editName').value);
            button.setAttribute('data-contact', document.getElementById('editContact').value);
            button.setAttribute('data-center', document.getElementById('editCenter').value);
            button.setAttribute('data-batch', document.getElementById('editBatch').value);
            button.setAttribute('data-category', document.getElementById('editCategory').value);
            $('#editModal').modal('hide');
            this.classList.remove('was-validated');
          }
          this.classList.add('was-validated');
        };
      });
    });

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
        if (confirm('Are you sure you want to delete this record?')) {
          this.closest('tr').remove();
        }
      });
    });

    // Handle receipt view
    document.querySelectorAll('.view-btn').forEach(button => {
      button.addEventListener('click', function () {
        const row = this.closest('tr');
        document.getElementById('receiptName').textContent = this.getAttribute('data-name');
        document.getElementById('receiptContact').textContent = this.getAttribute('data-contact');
        document.getElementById('receiptCenter').textContent = this.getAttribute('data-center');
        document.getElementById('receiptBatch').textContent = this.getAttribute('data-batch');
        document.getElementById('receiptCategory').textContent = this.getAttribute('data-category');
        document.getElementById('receiptTotalFees').textContent = this.getAttribute('data-totalfees');
        document.getElementById('receiptAmountPaid').textContent = this.getAttribute('data-amountpaid');
        document.getElementById('receiptRemainingAmount').textContent = this.getAttribute('data-remaining');
        document.getElementById('receiptPaymentMethod').textContent = this.getAttribute('data-paymentmethod');
      });
    });

    // Handle renew view
    document.querySelectorAll('.renew-btn').forEach(button => {
      button.addEventListener('click', function () {
        document.getElementById('renewName').value = this.getAttribute('data-name');
        document.getElementById('renewContact').value = this.getAttribute('data-contact');
        document.getElementById('renewCenter').value = this.getAttribute('data-center');
        document.getElementById('renewBatch').value = this.getAttribute('data-batch');
        document.getElementById('renewCategory').value = this.getAttribute('data-category');

        document.getElementById('renewForm').onsubmit = function (event) {
          if (this.checkValidity()) {
            event.preventDefault();
            const row = button.closest('tr');
            const expiryDate = new Date();
            const duration = document.getElementById('duration').value || '1 month';
            if (duration === '1 month') expiryDate.setMonth(expiryDate.getMonth() + 1);
            else if (duration === '2 months') expiryDate.setMonth(expiryDate.getMonth() + 2);
            const newExpiry = expiryDate.toISOString().split('T')[0];
            row.cells[5].textContent = newExpiry;

            $('#renewModal').modal('hide');
            this.classList.remove('was-validated');
            alert('Admission renewed successfully!');
          }
          this.classList.add('was-validated');
        };
      });
    });

    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', () => {
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');
      const contentWrapper = document.getElementById('contentWrapper');

      if (sidebarToggle && sidebar && navbar && contentWrapper) {
        sidebarToggle.addEventListener('click', () => {
          if (window.innerWidth <= 768) {
            sidebar.classList.toggle('active');
            navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
          } else {
            const isMinimized = sidebar.classList.toggle('minimized');
            navbar.classList.toggle('sidebar-minimized', isMinimized);
            contentWrapper.classList.toggle('minimized', isMinimized);
          }
        });
      }
    });
  })();
</script>
</body>
</html>