<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admission Management</title>

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
    min-width: 700px; /* Ensure table is scrollable on small screens */
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

  .new-admission-btn {
    background: linear-gradient(to right, #ff4040, #470000);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 15px;
    font-size: 14px;
    margin-top: 10px;
  }

  .new-admission-btn:hover {
    background: linear-gradient(to right, #ff3030, #360000);
  }

  .filter-btn {
    background: linear-gradient(to right, #ff4040, #470000);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 15px;
    font-size: 14px;
    margin: 20px 40px 10px 0; /* Added margin-top */
    float: right;
  }

  .filter-btn:hover {
    background: linear-gradient(to right, #ff3030, #360000);
  }

  .modal-content {
    background-color: #f0ebeb;
    border-radius: 10px;
    padding: 20px;
    margin: auto;
    border: 2px solid #007bff;
    margin-top: 71px !important;
  }

  .modal-content h3 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .modal-backdrop.show {
    backdrop-filter: blur(6px);
  }

  .form-group label {
    font-weight: bold;
    font-size: 14px;
  }

  .form-control {
    height: 40px;
    border-radius: 6px;
    font-size: 14px;
  }

  .submit-btn, .next-btn {
    background: linear-gradient(to top, #990000, #ff0000);
    border: none;
    color: white;
    border-radius: 8px;
    padding: 10px;
    width: 140px;
    font-weight: bold;
    display: block;
    margin: 20px auto 0;
  }

  .step-nav {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    background-color: #d3d3d3;
    border-radius: 5px 5px 0 0;
    margin-bottom: 10px;
  }

  .step-nav span {
    font-weight: bold;
  }

  .step-active {
    border-bottom: 2px solid blue;
  }

  .receipt-card {
    background-color: #f0ebeb;
    border: 2px solid #007bff;
    border-radius: 5px;
    padding: 10px;
    margin: 10px 0;
  }

  @media (max-width: 576px) {
    body {
      padding: 5px;
    }
    .content-wrapper {
      margin-left: 0 !important;
      padding: 5px !important;
    }
    .table-container {
      margin-top: 80px; /* Adjusted for filter button */
    }
    .table {
      font-size: 10px;
    }
    .table td, .table th {
      padding: 6px;
    }
    .new-admission-btn, .filter-btn {
      width: auto;
      margin: 20px 10px 10px 10px;
      font-size: 12px;
      padding: 6px 12px;
    }
    .modal-content {
      max-width: 90%;
      padding: 10px;
    }
    .form-control {
      font-size: 12px;
      height: 36px;
    }
    .step-nav {
      font-size: 12px;
      padding: 8px;
    }
  }

  @media (min-width: 577px) and (max-width: 768px) {
    body {
      padding: 10px;
    }
    .content-wrapper {
      margin-left: 0 !important;
      padding: 10px !important;
    }
    .table-container {
      margin-top: 80px;
    }
    .table {
      font-size: 11px;
    }
    .table td, .table th {
      padding: 8px;
    }
    .new-admission-btn, .filter-btn {
      width: auto;
      margin: 20px 15px 10px 15px;
      font-size: 13px;
    }
    .modal-content {
      max-width: 90%;
      padding: 15px;
    }
    .form-control {
      font-size: 13px;
    }
  }

  @media (min-width: 769px) and (max-width: 991px) {
    .content-wrapper {
      margin-left: 180px;
      padding: 15px;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }
    .table-container {
      margin-top: 80px;
    }
    .new-admission-btn, .filter-btn {
      font-size: 13px;
    }
    .modal-content {
      max-width: 80%;
    }
  }

  @media (min-width: 992px) {
    .new-admission-btn, .filter-btn {
      font-size: 14px;
    }
    .modal-content {
      max-width: 700px;
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
      <button class="filter-btn" data-toggle="modal" data-target="#filterModal">
  <i class="bi bi-funnel me-1"></i> Filter
</button>
      <div class="table-container">
        <table class="table table-bordered table-hover" id="admissionTable">
          <thead>
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
                <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i></button>
              </td>
            </tr>
            <tr>
              <td>John Smith</td>
              <td>987654321</td>
              <td>XYZ</td>
              <td>B2</td>
              <td>Individual</td>
              <td>
                <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button>
                <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- New Admission Button -->
      <div class="text-right">
        <button class="new-admission-btn" data-toggle="modal" data-target="#newAdmissionModal">New Admission</button>
      </div>
    </div>
  </div>
</div>

<!-- New Admission Modal (Step 1: Personal Details) -->
<div class="modal fade" id="newAdmissionModal" tabindex="-1" aria-labelledby="newAdmissionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="step-nav">
        <span class="step-active">1. Personal Details</span>
        <span>2. Batch Details</span>
        <span>3. Fees Details</span>
      </div>
      <h3 id="newAdmissionLabel">Admission Form</h3>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="step-nav">
        <span>1. Personal Details</span>
        <span class="step-active">2. Batch Details</span>
        <span>3. Fees Details</span>
      </div>
      <h3 id="batchDetailsLabel">Admission Form</h3>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="step-nav">
        <span>1. Personal Details</span>
        <span>2. Batch Details</span>
        <span class="step-active">3. Fees Details</span>
      </div>
      <h3 id="feesDetailsLabel">Admission Form</h3>
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
            <input type="number" id="remainingAmount" name="remainingAmount" class="form-control" required min="0" title="Remaining amount must be a positive number"/>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="editLabel">Edit Admission</h3>
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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <h3 id="receiptLabel">Receipt</h3>
      <div class="receipt-card">
        <div class="row">
          <div class="col-md-4">
            <p><strong>1. Personal Details :</strong></p>
            <p>Name : <span id="receiptName"></span></p>
            <p>Contact : <span id="receiptContact"></span></p>
            <p>Parent Name : <span id="receiptParentName"></span></p>
            <p>Emergency Contact : <span id="receiptEmergencyContact"></span></p>
            <p>Email : <span id="receiptEmail"></span></p>
            <p>Address : <span id="receiptAddress"></span></p>
          </div>
          <div class="col-md-4">
            <p><strong>2. Batch Details :</strong></p>
            <p>Center : <span id="receiptCenter"></span></p>
            <p>Batch : <span id="receiptBatch"></span></p>
            <p>Category : <span id="receiptCategory"></span></p>
            <p>Coach : <span id="receiptCoach"></span></p>
            <p>Duration : <span id="receiptDuration"></span></p>
          </div>
          <div class="col-md-4">
            <p><strong>3. Fees Details :</strong></p>
            <p>Total Fees : Rs.<span id="receiptTotalFees"></span></p>
            <p>Amount Paid : Rs.<span id="receiptAmountPaid"></span></p>
            <p>Remaining Amount : Rs.<span id="receiptRemainingAmount"></span></p>
            <p>Payment Mode : <span id="receiptPaymentMethod"></span></p>
          </div>
        </div>
        <p><strong>Date :</strong> 17-07-2025 09:48 PM IST</p>
      </div>
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    const forms = ['admissionForm1', 'admissionForm2', 'admissionForm3', 'filterForm', 'editForm'].map(id => document.getElementById(id));
    const tableBody = document.querySelector('#admissionTable tbody');

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

    // Add new admission to table
    document.getElementById('admissionForm3').addEventListener('submit', function (event) {
      if (this.checkValidity()) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const contact = document.getElementById('contact').value;
        const center = document.getElementById('center').value;
        const batch = document.getElementById('batch').value;
        const category = document.getElementById('category').value;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
          <td>${name}</td>
          <td>${contact}</td>
          <td>${center}</td>
          <td>${batch}</td>
          <td>${category}</td>
          <td>
            <button class="action-btn edit-btn" data-toggle="modal" data-target="#editModal" data-name="${name}" data-contact="${contact}" data-center="${center}" data-batch="${batch}" data-category="${category}"><i class="fas fa-edit"></i></button>
            <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
            <button class="action-btn view-btn" data-toggle="modal" data-target="#receiptModal"><i class="fas fa-eye"></i></button>
          </td>
        `;
        tableBody.appendChild(newRow);

        // Update receipt modal with new data
        document.getElementById('receiptName').textContent = name;
        document.getElementById('receiptContact').textContent = contact;
        document.getElementById('receiptParentName').textContent = document.getElementById('parentName').value;
        document.getElementById('receiptEmergencyContact').textContent = document.getElementById('emergencyContact').value;
        document.getElementById('receiptEmail').textContent = document.getElementById('email').value;
        document.getElementById('receiptAddress').textContent = document.getElementById('address').value;
        document.getElementById('receiptCenter').textContent = center;
        document.getElementById('receiptBatch').textContent = batch;
        document.getElementById('receiptCategory').textContent = category;
        document.getElementById('receiptCoach').textContent = document.getElementById('coach').value;
        document.getElementById('receiptDuration').textContent = document.getElementById('duration').value;
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
        document.getElementById('editCenter').value = this.getAttribute('data-center');
        document.getElementById('editBatch').value = this.getAttribute('data-batch');
        document.getElementById('editCategory').value = this.getAttribute('data-category');

        document.getElementById('editForm').onsubmit = function (event) {
          if (this.checkValidity()) {
            event.preventDefault();
            row.cells[0].textContent = document.getElementById('editName').value;
            row.cells[1].textContent = document.getElementById('editContact').value;
            row.cells[2].textContent = document.getElementById('editCenter').value;
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
        document.getElementById('receiptName').textContent = row.cells[0].textContent;
        document.getElementById('receiptContact').textContent = row.cells[1].textContent;
        document.getElementById('receiptCenter').textContent = row.cells[2].textContent;
        document.getElementById('receiptBatch').textContent = row.cells[3].textContent;
        document.getElementById('receiptCategory').textContent = row.cells[4].textContent;
        // Additional receipt data would need to be stored or fetched; using defaults for now
      });
    });

    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', () => {
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');
      const contentWrapper = document.getElementById('contentWrapper');

      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
          if (window.innerWidth <= 768) {
            // Mobile behavior
            if (sidebar) {
              sidebar.classList.toggle('active');
              navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
            }
          } else {
            // Desktop behavior - minimize/maximize
            if (sidebar && contentWrapper) {
              const isMinimized = sidebar.classList.toggle('minimized');
              navbar.classList.toggle('sidebar-minimized', isMinimized);
              contentWrapper.classList.toggle('minimized', isMinimized);
            }
          }
        });
      }
    });
  })();
</script>
</body>
</html>