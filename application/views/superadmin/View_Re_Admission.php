<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Student</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>

  <style>

     :root {
            --primary-color: #ff4040;
            --secondary-color: #f8f9fa;
            --accent-color: #007bff;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .section-content {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        h5 {
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .facility-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .facility-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .facility-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .facility-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .facility-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .status-active {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .status-expired {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        
        .status-completed {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }
        
        .facility-actions {
            margin-bottom: 15px;
        }
        
        .btn-renew {
            background-color: rgba(255, 64, 64, 0.1);
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            padding: 5px 15px;
            transition: all 0.3s;
        }
        
        .btn-renew:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .facility-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .facility-detail-item {
            display: flex;
            align-items: center;
        }
        
        .facility-detail-item i {
            margin-right: 10px;
            color: var(--primary-color);
            width: 20px;
        }
        
        .facility-duration {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
        }
        
        .duration-bar {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin: 10px 0;
            overflow: hidden;
        }
        
        .duration-progress {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 4px;
        }
        
        .duration-info {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #6c757d;
        }
        
        .required-field::after {
            content: " *";
            color: var(--primary-color);
        }
        
        .sub-type-info {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }
        
        .sub-type-options {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .sub-type-option {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .sub-type-option:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .sub-type-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(255, 64, 64, 0.05);
        }
        
        .sub-type-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        
        .sub-type-details {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 8px;
        }
        
        .amount {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .duration-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .duration-option {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .duration-option:hover {
            border-color: var(--primary-color);
        }
        
        .duration-option.selected {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 64, 64, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #e03a3a;
            border-color: #e03a3a;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }
        
        .modal-header .close {
            color: white;
        }

    /* Facility Section Styles */
    .facility-section {
      padding: 20px;
    }
    
    .facility-card {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      border-left: 4px solid #ff4040;
      position: relative;
    }
    
    .facility-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
      flex-wrap: wrap;
    }
    
    .facility-name {
      font-weight: 600;
      font-size: 18px;
      color: #470000;
    }
    
    .facility-status {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
    }
    
    .status-active {
      background-color: #e6f7ee;
      color: #28a745;
    }
    
    .status-expired {
      background-color: #fef3eb;
      color: #fd7e14;
    }
    
    .status-completed {
      background-color: #e6f0ff;
      color: #007bff;
    }
    
    .facility-actions {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      gap: 8px;
    }
    
    .btn-renew {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      font-size: 13px;
      transition: all 0.3s;
    }
    
    .btn-renew:hover {
      background: #300000;
      color: white;
      transform: translateY(-2px);
    }
    
    .facility-details-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
      margin-bottom: 15px;
    }
    
    .facility-detail-item {
      display: flex;
      align-items: center;
    }
    
    .facility-detail-item i {
      margin-right: 10px;
      color: #ff4040;
      width: 20px;
    }
    
    .facility-duration {
      background: #f8f9fa;
      padding: 12px 15px;
      border-radius: 6px;
      margin-top: 10px;
    }
    
    .duration-bar {
      height: 8px;
      background: #e9ecef;
      border-radius: 4px;
      overflow: hidden;
      margin-top: 8px;
    }
    
    .duration-progress {
      height: 100%;
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      border-radius: 4px;
    }
    
    .duration-info {
      display: flex;
      justify-content: space-between;
      margin-top: 5px;
      font-size: 13px;
      color: #6c757d;
    }
    
    /* New Facility Form */
    .sub-type-info {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
      margin-top: 10px;
      display: none;
    }
    
    .hostel-option {
      padding: 12px;
      border: 1px solid #dee2e6;
      border-radius: 5px;
      margin-bottom: 10px;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .hostel-option:hover {
      background-color: #e9ecef;
      border-color: #ff4040;
    }
    
    .hostel-option.selected-hostel {
      background-color: #e6f7ff;
      border-left: 3px solid #007bff;
    }
    
    .hostel-name {
      font-weight: 600;
      color: #470000;
    }
    
    .hostel-details {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 5px;
    }
    
    .rent-amount {
      color: #28a745;
      font-weight: 600;
    }
    
    .required-field::after {
      content: " *";
      color: #ff4040;
    }
    
    .duration-options {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 10px;
    }
    
    .duration-option {
      padding: 8px 15px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.2s;
    }
    
    .duration-option:hover {
      background-color: #f8f9fa;
    }
    
    .duration-option.selected {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border-color: #470000;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .facility-header {
        flex-direction: column;
        align-items: flex-start;
      }
      
      .facility-actions {
        position: static;
        margin-top: 10px;
        align-self: flex-end;
      }
      
      .facility-details-grid {
        grid-template-columns: 1fr;
      }
      
      .duration-options {
        flex-direction: column;
      }
    }
    body {
      font-family: 'Montserrat', serif !important;
      overflow-x: hidden;
      min-height: 100vh;
      background: #f9f9f9;
    }

    .content-wrapper {
      margin-left: 250px;
      padding: 80px 20px 20px 20px;
      transition: margin-left 0.3s ease-in-out;
    }
    .content-wrapper.minimized {
      margin-left: 60px;
    }

    .inner-layout {
      display: flex;
      gap: 20px;
    }

    /* Inner Sidebar */
    .inner-sidebar {
      width: 220px;
      padding: 15px 10px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      border-radius: 8px;
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      box-shadow: 0 4px 12px rgba(0,0,0,0.25);
      position: sticky;
      top: 90px;
      height: fit-content;
    }

    .inner-sidebar .menu-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px;
      background: rgba(255,255,255,0.1);
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: all 0.25s ease;
    }
    .inner-sidebar .menu-item i {
      color: #ffecec;
      font-size: 16px;
      transition: color 0.25s ease;
    }
    .inner-sidebar .menu-item:hover {
      background: rgba(255,255,255,0.25);
      transform: translateX(5px);
    }
    .inner-sidebar .menu-item:hover i {
      color: #fff;
    }
    .inner-sidebar .menu-item.active {
      background: #fff;
      color: #470000;
      font-weight: 600;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }
    .inner-sidebar .menu-item.active i {
      color: #470000;
    }

    /* Details Area */
    .details-area {
      flex: 1;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .section-content {
      display: none;
      margin-top: 15px;
    }
    .section-content.active {
      display: block;
    }

    h4 {
      font-weight: 600;
      color: #470000;
      margin-bottom: 15px;
    }

    .section-title {
      font-weight: 500;
      font-size: 16px;
      color: #ff4040;
    }

    .btn-primary {
      background: #ff4040;
      border: none;
    }
    .btn-primary:hover {
      background: #cc0000;
    }
    .btn-success {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      border: none;
    }
    .btn-success:hover {
      background: #300000;
    }
    .btn-secondary {
      background: #666;
      border: none;
    }
    
    .btn-renew {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
      color: white;
      border: none;
      padding: 5px 12px;
      border-radius: 4px;
      font-size: 13px;
    }
    .btn-renew:hover {
      background: #300000;
      color: white;
    }

    h4 {
  font-weight: 700;
  font-size: 20px;
  background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 15px;
} 
.section-title {
  font-weight: 600;
  font-size: 16px;
  background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 10px;
}

.progress-bar {
  background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
}

.detail-row {
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid #eee;
}
.detail-label {
  font-weight: 600;
  color: #666;
  margin-bottom: 5px;
}
.detail-value {
  font-size: 16px;
  color: #333;
}

/* Batch Card Styles */
.batch-card {
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  background: #f9f9f9;
}
.batch-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.batch-name {
  font-weight: 600;
  color: #470000;
}
.batch-status {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.status-active {
  background: #d4edda;
  color: #155724;
}
.status-completed {
  background: #e2e3e5;
  color: #383d41;
}
.status-expired {
  background: #f8d7da;
  color: #721c24;
}
.batch-details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 10px;
}
.batch-detail-item {
  display: flex;
  align-items: center;
  gap: 8px;
}
.batch-detail-item i {
  color: #ff4040;
  width: 16px;
}

/* Facility Cards */
.facility-card {
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  background: #f9f9f9;
  position: relative;
}
.facility-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.facility-name {
  font-weight: 600;
  color: #470000;
}
.facility-status {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}
.facility-details-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 10px;
}
.facility-detail-item {
  display: flex;
  align-items: center;
  gap: 8px;
}
.facility-detail-item i {
  color: #ff4040;
  width: 16px;
}
.facility-actions {
  position: absolute;
  top: 15px;
  right: 15px;
  display: flex;
  gap: 8px;
}

/* Modal Styles */
.modal-content {
  border-radius: 10px;
  border: none;
  box-shadow: 0 5px 25px rgba(0,0,0,0.2);
}
.modal-header {
  background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
  color: white;
  border-radius: 10px 10px 0 0;
}
.modal-header .close {
  color: white;
  text-shadow: none;
  opacity: 0.8;
}
.modal-header .close:hover {
  opacity: 1;
}

  </style>
</head>
<body>

<!-- Sidebar -->
<?php $this->load->view('superadmin/Include/Sidebar') ?>
<!-- Navbar -->
<?php $this->load->view('superadmin/Include/Navbar') ?>

<div class="content-wrapper" id="contentWrapper">
  <div class="container mt-5">

    <div class="inner-layout">
      
      <!-- Inner Sidebar -->
      <div class="inner-sidebar">
        <a href="#" class="menu-item active" onclick="showSection(event,'basicData')">
          <i class="fas fa-user"></i> Personal Details 
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'batchDetails')">
          <i class="fas fa-file-alt"></i> Batch Details
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'feesDetails')">
          <i class="fas fa-lock"></i> Fees Details 
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'facilities')">
          <i class="fas fa-building"></i> Facilities 
        </a>
        <a href="#" class="menu-item" onclick="showSection(event,'Re_admission')">
          <i class="fas fa-wallet"></i> Re-Admission
        </a>
      </div>

      <!-- Details Area -->
      <!-- ================= Details Area ================= -->
<div class="details-area">

<div class="progress-container mb-4">
  <div class="progress">
    <div id="progressBar" class="progress-bar " role="progressbar" style="width: 20%;">
      Step 1 of 5
    </div>
  </div>
</div>

  <!-- Section: Basic Data -->
  <div class="section-content active" id="basicData">
    <h4>Personal Details</h4>
    <p>Student's personal information and contact details.</p>

    <div class="row">
      <div class="col-md-6">
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-user"></i> Name</div>
          <div class="detail-value">Rahul Sharma</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-user-friends"></i> Parent Name</div>
          <div class="detail-value">Rajesh Sharma</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-envelope"></i> Email</div>
          <div class="detail-value">rahul.sharma@example.com</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-home"></i> Address</div>
          <div class="detail-value">123, Main Street, Mumbai, Maharashtra - 400001</div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-phone-alt"></i> Contact</div>
          <div class="detail-value">+91 9876543210</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-phone-alt"></i> Emergency Contact</div>
          <div class="detail-value">+91 9123456780</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-calendar-alt"></i> Date of Birth</div>
          <div class="detail-value">15 June 2005</div>
        </div>
        
        <div class="detail-row">
          <div class="detail-label"><i class="fas fa-venus-mars"></i> Gender</div>
          <div class="detail-value">Male</div>
        </div>
      </div>
    </div>

    <div class="text-right mt-4">
      <button type="button" class="btn btn-success next1">Next <i class="fas fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- Section: Batch Details -->
  <div class="section-content" id="batchDetails">
    <h4>Batch Details</h4>
    <p>Information about the student's current and previous batches.</p>
    
    <!-- Current Batch -->
    <h5 class="mt-4 mb-3" style="color: #ff4040;">Current Batch</h5>
    
    <div class="batch-card">
      <div class="batch-header">
        <div class="batch-name">Advanced Swimming - Group A</div>
        <div class="batch-status status-active">Active</div>
      </div>
      <div class="batch-details-grid">
        <div class="batch-detail-item">
          <i class="fas fa-university"></i>
          <span><strong>Center:</strong> Mumbai Central Branch</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-chalkboard-teacher"></i>
          <span><strong>Coach:</strong> Mr. Vikram Singh</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-plus"></i>
          <span><strong>Join Date:</strong> 01 Jan 2023</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-check"></i>
          <span><strong>Expiry Date:</strong> 31 Dec 2023</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-clock"></i>
          <span><strong>Timing:</strong> Mon, Wed, Fri - 6:00 PM to 7:30 PM</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-user-tie"></i>
          <span><strong>Coordinator:</strong> Mrs. Sunita Patel</span>
        </div>
      </div>
    </div>
    
    <!-- Previous Batches -->
    <h5 class="mt-5 mb-3" style="color: #ff4040;">Previous Batches</h5>
    
    <div class="batch-card">
      <div class="batch-header">
        <div class="batch-name">Intermediate Swimming - Group B</div>
        <div class="batch-status status-completed">Completed</div>
      </div>
      <div class="batch-details-grid">
        <div class="batch-detail-item">
          <i class="fas fa-university"></i>
          <span><strong>Center:</strong> Mumbai Central Branch</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-chalkboard-teacher"></i>
          <span><strong>Coach:</strong> Mrs. Priya Desai</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-plus"></i>
          <span><strong>Join Date:</strong> 01 Jun 2022</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-check"></i>
          <span><strong>Expiry Date:</strong> 31 Dec 2022</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-clock"></i>
          <span><strong>Timing:</strong> Tue, Thu, Sat - 5:00 PM to 6:30 PM</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-award"></i>
          <span><strong>Grade:</strong> A (Excellent Performance)</span>
        </div>
      </div>
    </div>
    
    <div class="batch-card">
      <div class="batch-header">
        <div class="batch-name">Beginner Swimming - Group C</div>
        <div class="batch-status status-completed">Completed</div>
      </div>
      <div class="batch-details-grid">
        <div class="batch-detail-item">
          <i class="fas fa-university"></i>
          <span><strong>Center:</strong> Andheri West Branch</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-chalkboard-teacher"></i>
          <span><strong>Coach:</strong> Mr. Ramesh Kumar</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-plus"></i>
          <span><strong>Join Date:</strong> 10 Jan 2022</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-calendar-check"></i>
          <span><strong>Expiry Date:</strong> 10 May 2022</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-clock"></i>
          <span><strong>Timing:</strong> Mon, Wed, Fri - 4:00 PM to 5:30 PM</span>
        </div>
        <div class="batch-detail-item">
          <i class="fas fa-award"></i>
          <span><strong>Grade:</strong> B+ (Good Performance)</span>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button type="button" class="btn btn-secondary back1"><i class="fas fa-arrow-left"></i> Back</button>
      <button type="button" class="btn btn-success next2">Next <i class="fas fa-arrow-right"></i></button>
    </div>
  </div>

  <!-- Section: Fees Details -->
  <div class="section-content" id="feesDetails">
    <h4>Fees Details</h4>
    <p>Information about the student's fees, payment status, and related details.</p>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label><i class="fas fa-wallet"></i> Total Fees *</label>
        <input type="number" id="totalFees" class="form-control" required>
      </div>
      <div class="form-group col-md-6">
        <label><i class="fas fa-money-check-alt"></i> Amount Paid *</label>
        <input type="number" id="paidAmount" class="form-control" required>
      </div>
      <div class="form-group col-md-6">
        <label><i class="fas fa-balance-scale"></i> Remaining Amount *</label>
        <input type="number" id="remainingAmount" class="form-control" readonly>
      </div>
      <div class="form-group col-md-6">
        <label><i class="fas fa-credit-card"></i> Payment Method *</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment" value="Cash">
          <label class="form-check-label">Cash</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment" value="Online">
          <label class="form-check-label">Online</label>
        </div>
      </div>
    </div>

   <div class="d-flex justify-content-between">
  <button type="button" class="btn btn-secondary back2"><i class="fas fa-arrow-left"></i> Back</button>
  <button type="button" class="btn btn-success next3">Next <i class="fas fa-arrow-right"></i></button>
</div>
</div>

   <!-- Section: Facilities -->
        <div class="section-content" id="facilities">
            <!-- Content for the facility section only -->
            
                <h4>Facilities</h4>
                <p>Information about additional facilities availed by the student.</p>
                
                <!-- Current Facilities -->
                <h5 class="mt-4 mb-3" style="color: #ff4040;">Current Facilities</h5>
                
                <div class="facility-card">
                    <div class="facility-header">
                        <div class="facility-name">Hostel Accommodation</div>
                        <div class="facility-status status-active">Active</div>
                    </div>
                    
                    <div class="facility-details-grid">
                        <div class="facility-detail-item">
                            <i class="fas fa-home"></i>
                            <span><strong>Room No:</strong> H-102</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-building"></i>
                            <span><strong>Hostel Type:</strong> Single AC Room</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-plus"></i>
                            <span><strong>Start Date:</strong> 01 Jan 2023</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <span><strong>Expiry Date:</strong> 31 Dec 2023</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span><strong>Amount:</strong> ₹15,000/month</span>
                        </div>
                    </div>
                    
                    <!-- Duration Information -->
                    <div class="facility-duration">
                        <div class="d-flex justify-content-between">
                            <span><strong>Duration:</strong> 12 months</span>
                            <span><strong>Remaining:</strong> 3 months</span>
                        </div>
                        <div class="duration-bar">
                            <div class="duration-progress" style="width: 75%"></div>
                        </div>
                        <div class="duration-info">
                            <span>Started: Jan 2023</span>
                            <span>Ends: Dec 2023</span>
                        </div>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-header">
                        <div class="facility-name">Mess Facility</div>
                        <div class="facility-status status-active">Active</div>
                    </div>
                    
                    <div class="facility-details-grid">
                        <div class="facility-detail-item">
                            <i class="fas fa-utensils"></i>
                            <span><strong>Meal Plan:</strong> Breakfast & Dinner</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-plus"></i>
                            <span><strong>Start Date:</strong> 01 Jan 2023</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <span><strong>Expiry Date:</strong> 31 Dec 2023</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span><strong>Amount:</strong> ₹8,000/month</span>
                        </div>
                    </div>
                    
                    <!-- Duration Information -->
                    <div class="facility-duration">
                        <div class="d-flex justify-content-between">
                            <span><strong>Duration:</strong> 12 months</span>
                            <span><strong>Remaining:</strong> 3 months</span>
                        </div>
                        <div class="duration-bar">
                            <div class="duration-progress" style="width: 75%"></div>
                        </div>
                        <div class="duration-info">
                            <span>Started: Jan 2023</span>
                            <span>Ends: Dec 2023</span>
                        </div>
                    </div>
                </div>
                
                <!-- Previous Facilities -->
                <h5 class="mt-5 mb-3" style="color: #ff4040;">Previous Facilities</h5>
                
                <div class="facility-card">
                    <div class="facility-header">
                        <div class="facility-name">Locker</div>
                        <div class="facility-status status-expired">Expired</div>
                    </div>
                    <div class="facility-actions">
                        <button class="btn btn-renew" data-toggle="modal" data-target="#renewModal" data-facility="Locker">
                            <i class="fas fa-sync-alt"></i> Renew
                        </button>
                    </div>
                    <div class="facility-details-grid">
                        <div class="facility-detail-item">
                            <i class="fas fa-lock"></i>
                            <span><strong>Locker No:</strong> L-205</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-plus"></i>
                            <span><strong>Start Date:</strong> 01 Jun 2022</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <span><strong>Expiry Date:</strong> 31 Dec 2022</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span><strong>Amount:</strong> ₹2,000/month</span>
                        </div>
                    </div>
                    
                    <!-- Duration Information -->
                    <div class="facility-duration">
                        <div class="d-flex justify-content-between">
                            <span><strong>Duration:</strong> 7 months</span>
                            <span><strong>Status:</strong> Expired</span>
                        </div>
                        <div class="duration-bar">
                            <div class="duration-progress" style="width: 100%"></div>
                        </div>
                        <div class="duration-info">
                            <span>Started: Jun 2022</span>
                            <span>Ended: Dec 2022</span>
                        </div>
                    </div>
                </div>
                
                <div class="facility-card">
                    <div class="facility-header">
                        <div class="facility-name">Transport Service</div>
                        <div class="facility-status status-completed">Completed</div>
                    </div>
                    <div class="facility-actions">
                        <button class="btn btn-renew" data-toggle="modal" data-target="#renewModal" data-facility="Transport Service">
                            <i class="fas fa-sync-alt"></i> Renew
                        </button>
                    </div>
                    <div class="facility-details-grid">
                        <div class="facility-detail-item">
                            <i class="fas fa-bus"></i>
                            <span><strong>Route:</strong> Andheri to Campus</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-plus"></i>
                            <span><strong>Start Date:</strong> 01 Mar 2022</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-calendar-check"></i>
                            <span><strong>Expiry Date:</strong> 31 May 2022</span>
                        </div>
                        <div class="facility-detail-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span><strong>Amount:</strong> ₹3,500/month</span>
                        </div>
                    </div>
                    
                    <!-- Duration Information -->
                    <div class="facility-duration">
                        <div class="d-flex justify-content-between">
                            <span><strong>Duration:</strong> 3 months</span>
                            <span><strong>Status:</strong> Completed</span>
                        </div>
                        <div class="duration-bar">
                            <div class="duration-progress" style="width: 100%"></div>
                        </div>
                        <div class="duration-info">
                            <span>Started: Mar 2022</span>
                            <span>Ended: May 2022</span>
                        </div>
                    </div>
                </div>
                
                <!-- Add New Facility -->
                <h5 class="mt-5 mb-3" style="color: #ff4040;">Add New Facility</h5>
                
                <form id="facilityForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="required-field"><i class="fas fa-building"></i> Select Facility</label>
                            <select id="facilityType" class="form-control" required onchange="showSubTypes()">
                                <option value="">-- Select Facility --</option>
                                <option value="hostel">Hostel Accommodation</option>
                                <option value="mess">Mess Facility</option>
                                <option value="locker">Locker</option>
                                <option value="transport">Transport Service</option>
                                <option value="gym">Gym Membership</option>
                                <option value="library">Library Access</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="required-field"><i class="fas fa-money-bill-wave"></i> Amount (₹)</label>
                            <input type="number" id="facilityAmount" class="form-control" placeholder="Enter amount" required>
                        </div>
                    </div>
                    
                    <!-- Sub-type selection (initially hidden) -->
                    <div id="subTypeContainer" class="sub-type-info">
                        <h6 id="subTypeTitle">Select Facility Type</h6>
                        <div id="subTypeOptions" class="sub-type-options">
                            <!-- Options will be populated by JavaScript -->
                        </div>
                    </div>
                    
                    <!-- Duration Selection -->
                    <div class="form-group">
                        <label class="required-field"><i class="fas fa-clock"></i> Select Duration</label>
                        <div class="duration-options">
                            <div class="duration-option" onclick="selectDuration(1)">1 Month</div>
                            <div class="duration-option" onclick="selectDuration(3)">3 Months</div>
                            <div class="duration-option selected" onclick="selectDuration(6)">6 Months</div>
                            <div class="duration-option" onclick="selectDuration(12)">1 Year</div>
                            <div class="duration-option" onclick="selectDuration(0)">Custom</div>
                        </div>
                        <input type="hidden" id="selectedDuration" value="6">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="required-field"><i class="fas fa-calendar-plus"></i> Start Date</label>
                            <input type="date" id="facilityStartDate" class="form-control" required onchange="updateExpiryDate()">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="required-field"><i class="fas fa-calendar-check"></i> Expiry Date</label>
                            <input type="date" id="facilityExpiryDate" class="form-control" required readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><i class="fas fa-sticky-note"></i> Additional Notes</label>
                        <textarea id="facilityNotes" class="form-control" rows="3" placeholder="Any additional information about the facility"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-secondary back3"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="submit" class="btn btn-primary " id="addFacilityBtn"><i class="fas fa-plus"></i> Add Facility</button>
                        <button type="button" class="btn btn-success next4">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
            </div>

            <!-- Renew Facility Modal -->
            <div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="renewModalLabel">Renew Facility</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="renewForm">
                                <input type="hidden" id="renewFacilityName">
                                
                                <div class="form-group">
                                    <label for="renewAmount">Amount (₹)</label>
                                    <input type="number" class="form-control" id="renewAmount" required>
                                </div>
                                
                                <div class="form-group">
                                    <label><i class="fas fa-clock"></i> Select Duration</label>
                                    <div class="duration-options">
                                        <div class="duration-option" onclick="selectRenewDuration(1)">1 Month</div>
                                        <div class="duration-option" onclick="selectRenewDuration(3)">3 Months</div>
                                        <div class="duration-option selected" onclick="selectRenewDuration(6)">6 Months</div>
                                        <div class="duration-option" onclick="selectRenewDuration(12)">1 Year</div>
                                        <div class="duration-option" onclick="selectRenewDuration(0)">Custom</div>
                                    </div>
                                    <input type="hidden" id="renewDuration" value="6">
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="renewStartDate">Start Date</label>
                                        <input type="date" class="form-control" id="renewStartDate" required onchange="updateRenewExpiryDate()">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="renewExpiryDate">Expiry Date</label>
                                        <input type="date" class="form-control" id="renewExpiryDate" required readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="renewNotes">Additional Notes</label>
                                    <textarea class="form-control" id="renewNotes" rows="3"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" id="confirmRenew">Confirm Renewal</button>
                        </div>
</div>
</div>
</div
                
            


 <!-- Section: Re-Admission -->

<div class="section-content" id="Re_admission">
  <h4>Re-Admission</h4>
  <p>Update details for re-admission and change the student's status.</p>

  <!-- Student Details -->
  <div class="form-row">
    <div class="form-group col-md-6">
      <label><i class="fas fa-user"></i> Select Student *</label>
      <select name="student_id" class="form-control" required>
        <option value="">-- Select Student --</option>
        <option value="1">Rahul Sharma</option>
        <option value="2">Priya Patil</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label><i class="fas fa-toggle-on"></i> Status *</label>
      <select name="status" class="form-control" required>
        <option value="">-- Select Status --</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>
  </div>

  <!-- Batch Details -->
  <div class="section-title mb-2"><i class="fas fa-layer-group"></i> Batch Details</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label><i class="fas fa-users"></i> Select Batch *</label>
      <select name="batch_id" class="form-control" required>
        <option value="">-- Select Batch --</option>
        <option value="morning">Morning Batch</option>
        <option value="evening">Evening Batch</option>
        <option value="weekend">Weekend Batch</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label><i class="fas fa-clock"></i> Duration *</label>
      <select name="duration" id="durationSelect" class="form-control" required>
        <option value="">-- Select Duration --</option>
        <option value="3">3 Months</option>
        <option value="6">6 Months</option>
        <option value="12">1 Year</option>
      </select>
    </div>
  </div>

  <!-- Date Information -->
  <div class="section-title mb-2"><i class="fas fa-calendar-alt"></i> Date Information</div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label><i class="fas fa-calendar-plus"></i> Join Date *</label>
      <input type="date" name="join_date" id="joinDate" class="form-control" required>
    </div>
    <div class="form-group col-md-6">
      <label><i class="fas fa-calendar-times"></i> Expiry Date *</label>
      <input type="date" name="expiry_date" id="expiryDate" class="form-control" readonly>
    </div>
  </div>

  <!-- Payment Details -->
  <div class="section-title mb-2"><i class="fas fa-money-bill-wave"></i> Payment Details</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label><i class="fas fa-rupee-sign"></i> Fees Amount (₹) *</label>
      <input type="number" name="fees_amount" class="form-control" placeholder="Enter amount" required>
    </div>
    <div class="form-group col-md-4">
      <label><i class="fas fa-credit-card"></i> Payment Mode *</label>
      <select name="payment_mode" class="form-control" required>
        <option value="">-- Select Payment Mode --</option>
        <option>Cash</option>
        <option>UPI</option>
        <option>Bank Transfer</option>
        <option>Card</option>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label><i class="fas fa-receipt"></i> Receipt No.</label>
      <input type="text" name="receipt_no" class="form-control" readonly value="RCPT<?php echo time(); ?>">
    </div>
  </div>
  

  <!-- Navigation -->
  <div class="d-flex justify-content-between mt-3">
    <button type="button" class="btn btn-secondary back4"><i class="fas fa-arrow-left"></i> Back</button>
    <button type="submit" class="btn btn-success">Save Re-Admission <i class="fas fa-check"></i></button>
  </div>
</div>

</div>
<!-- ================= End Details Area ================= -->

  </div>
</div>

<!-- Renew Facility Modal -->
<div class="modal fade" id="renewModal" tabindex="-1" role="dialog" aria-labelledby="renewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renewModalLabel">Renew Facility</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="renewForm">
          <input type="hidden" id="renewFacilityName">
          <div class="form-group">
            <label for="renewAmount">Amount (₹)</label>
            <input type="number" class="form-control" id="renewAmount" required>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="renewStartDate">Start Date</label>
              <input type="date" class="form-control" id="renewStartDate" required>
            </div>
            <div class="form-group col-md-6">
              <label for="renewExpiryDate">Expiry Date</label>
              <input type="date" class="form-control" id="renewExpiryDate" required>
            </div>
          </div>
          <div class="form-group">
            <label for="renewNotes">Additional Notes</label>
            <textarea class="form-control" id="renewNotes" rows="3"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="confirmRenew">Confirm Renewal</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showSection(event, sectionId) {
    event.preventDefault();

    document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');

    document.querySelectorAll('.section-content').forEach(sec => sec.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    
    // Update progress bar based on active section
    updateProgressBar(sectionId);
  }

  function updateProgressBar(sectionId) {
    const progressBar = document.getElementById("progressBar");
    let step = 1;
    
    switch(sectionId) {
      case "basicData":
        step = 1;
        break;
      case "batchDetails":
        step = 2;
        break;
      case "feesDetails":
        step = 3;
        break;
      case "facilities":
        step = 4;
        break;
      case "Re_admission":
        step = 5;
        break;
    }
    
    const percentage = (step / 5) * 100;
    progressBar.style.width = percentage + "%";
    progressBar.innerText = `Step ${step} of 5`;
  }

  // Function to calculate expiry date based on join date and duration
  function calculateExpiryDate() {
    const joinDateInput = document.getElementById('joinDate');
    const durationSelect = document.getElementById('durationSelect');
    const expiryDateInput = document.getElementById('expiryDate');
    
    if (joinDateInput.value && durationSelect.value) {
      const joinDate = new Date(joinDateInput.value);
      const duration = parseInt(durationSelect.value);
      
      // Calculate expiry date by adding months to join date
      const expiryDate = new Date(joinDate);
      expiryDate.setMonth(expiryDate.getMonth() + duration);
      
      // Format the date as YYYY-MM-DD for the input field
      const formattedExpiryDate = expiryDate.toISOString().split('T')[0];
      expiryDateInput.value = formattedExpiryDate;
    } else {
      expiryDateInput.value = '';
    }
  }

   document.addEventListener('DOMContentLoaded', () => {
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const navbar = document.querySelector('.navbar');
      const contentWrapper = document.getElementById('contentWrapper');

      if (sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
          if (window.innerWidth <= 768) {
            if (sidebar) {
              sidebar.classList.toggle('active');
              if (navbar) navbar.classList.toggle('sidebar-hidden', !sidebar.classList.contains('active'));
            }
          } else {
            if (sidebar && contentWrapper) {
              const isMinimized = sidebar.classList.toggle('minimized');
              if (navbar) navbar.classList.toggle('sidebar-minimized', isMinimized);
              contentWrapper.classList.toggle('minimized', isMinimized);
            }
          }
        });
      }
      
      // Calculate remaining amount when fees or paid amount changes
      const totalFeesInput = document.getElementById('totalFees');
      const paidAmountInput = document.getElementById('paidAmount');
      const remainingAmountInput = document.getElementById('remainingAmount');
      
      function calculateRemainingAmount() {
        if (totalFeesInput && paidAmountInput && remainingAmountInput) {
          const total = parseFloat(totalFeesInput.value) || 0;
          const paid = parseFloat(paidAmountInput.value) || 0;
          remainingAmountInput.value = (total - paid).toFixed(2);
        }
      }
      
      if (totalFeesInput && paidAmountInput) {
        totalFeesInput.addEventListener('input', calculateRemainingAmount);
        paidAmountInput.addEventListener('input', calculateRemainingAmount);
      }
      
      // Set up event listeners for date calculation
      const joinDateInput = document.getElementById('joinDate');
      const durationSelect = document.getElementById('durationSelect');
      
      if (joinDateInput && durationSelect) {
        joinDateInput.addEventListener('change', calculateExpiryDate);
        durationSelect.addEventListener('change', calculateExpiryDate);
        
        // Set default join date to today
        const today = new Date().toISOString().split('T')[0];
        joinDateInput.value = today;
      }
      
      // Set default dates for facility form
      const facilityStartDate = document.getElementById('facilityStartDate');
      const facilityExpiryDate = document.getElementById('facilityExpiryDate');
      
      if (facilityStartDate) {
        const today = new Date().toISOString().split('T')[0];
        facilityStartDate.value = today;
        
        // Set default expiry date to 30 days from today
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + 30);
        facilityExpiryDate.value = expiryDate.toISOString().split('T')[0];
      }
      
      // Add facility button functionality
      const addFacilityBtn = document.getElementById('addFacilityBtn');
      if (addFacilityBtn) {
        addFacilityBtn.addEventListener('click', function() {
          const facilityType = document.getElementById('facilityType').value;
          const facilityAmount = document.getElementById('facilityAmount').value;
          const facilityStartDate = document.getElementById('facilityStartDate').value;
          const facilityExpiryDate = document.getElementById('facilityExpiryDate').value;
          
          if (!facilityType || !facilityAmount || !facilityStartDate || !facilityExpiryDate) {
            alert('Please fill all required fields');
            return;
          }
          
          // In a real application, you would send this data to the server
          // For this demo, we'll just show a success message
          alert('Facility added successfully!');
          
          // Reset the form
          document.getElementById('facilityType').value = '';
          document.getElementById('facilityAmount').value = '';
          document.getElementById('facilityNotes').value = '';
          
          // Set default dates again
          const today = new Date().toISOString().split('T')[0];
          document.getElementById('facilityStartDate').value = today;
          
          const expiryDate = new Date();
          expiryDate.setDate(expiryDate.getDate() + 30);
          document.getElementById('facilityExpiryDate').value = expiryDate.toISOString().split('T')[0];
        });
      }
      
      // Renew modal functionality
      $('#renewModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const facilityName = button.data('facility');
        const modal = $(this);
        modal.find('#renewFacilityName').val(facilityName);
        modal.find('.modal-title').text('Renew ' + facilityName);
        
        // Set default dates for renewal
        const today = new Date().toISOString().split('T')[0];
        modal.find('#renewStartDate').val(today);
        
        const expiryDate = new Date();
        expiryDate.setMonth(expiryDate.getMonth() + 3); // Default to 3 months
        modal.find('#renewExpiryDate').val(expiryDate.toISOString().split('T')[0]);
      });
      
      // Confirm renewal button
      const confirmRenewBtn = document.getElementById('confirmRenew');
      if (confirmRenewBtn) {
        confirmRenewBtn.addEventListener('click', function() {
          const facilityName = document.getElementById('renewFacilityName').value;
          const amount = document.getElementById('renewAmount').value;
          const startDate = document.getElementById('renewStartDate').value;
          const expiryDate = document.getElementById('renewExpiryDate').value;
          
          if (!amount || !startDate || !expiryDate) {
            alert('Please fill all required fields');
            return;
          }
          
          // In a real application, you would send this data to the server
          // For this demo, we'll just show a success message
          alert(facilityName + ' renewed successfully!');
          
          // Close the modal
          $('#renewModal').modal('hide');
        });
      }
    });

  // Navigation functions
  function navigateTo(currentId, nextId) {
    document.querySelectorAll(".section-content").forEach(sec => sec.classList.remove("active"));
    document.getElementById(nextId).classList.add("active");

    // Update sidebar active state too
    document.querySelectorAll(".menu-item").forEach(item => item.classList.remove("active"));
    document.querySelector(`.menu-item[onclick*='${nextId}']`).classList.add("active");
    
    // Update progress bar
    updateProgressBar(nextId);
  }

  // Set up event listeners for navigation
  document.addEventListener("DOMContentLoaded", () => {
    // Next1 → from Basic Data to Batch Details
    document.querySelector(".next1")?.addEventListener("click", () => {
      navigateTo("basicData", "batchDetails");
    });

    // Next2 → from Batch Details to Fees Details
    document.querySelector(".next2")?.addEventListener("click", () => {
      navigateTo("batchDetails", "feesDetails");
    });
    
    // Next3 → from Fees Details to Facilities
    document.querySelector(".next3")?.addEventListener("click", () => {
      navigateTo("feesDetails", "facilities");
    });
    
    // Next4 → from Facilities to Re-Admission
    document.querySelector(".next4")?.addEventListener("click", () => {
      navigateTo("facilities", "Re_admission");
    });

    // Next5→ from Facilities to Re-Admission → from Facilities to Re-Admission
    document.querySelector(".next4")?.addEventListener("click", () => {
      navigateTo("facilities", "Re_admission");
    });
    // Back1 → from Batch Details to Basic Data
    document.querySelector(".back1")?.addEventListener("click", () => {
      navigateTo("batchDetails", "basicData");
    });

    // Back2 → from Fees Details to Batch Details
    document.querySelector(".back2")?.addEventListener("click", () => {
      navigateTo("feesDetails", "batchDetails");
    });
    
    // Back3 → from Facilities to Fees Details
    document.querySelector(".back3")?.addEventListener("click", () => {
      navigateTo("facilities", "feesDetails");
    });
    
    // Back4 → from Re-Admission to Facilities
    document.querySelector(".back4")?.addEventListener("click", () => {
      navigateTo("Re_admission", "facilities");
    });
  });
</script>
<script>
  // Define sub-types for each facility type
        const facilitySubTypes = {
            hostel: [
                { id: 'singleNonAC', name: 'Single Seater (Non-AC)', details: 'Private room with attached bathroom', amount: 8000 },
                { id: 'singleAC', name: 'Single Seater (AC)', details: 'Private AC room with attached bathroom', amount: 12000 },
                { id: 'doubleNonAC', name: 'Double Seater (Non-AC)', details: 'Shared room with attached bathroom', amount: 6000 },
                { id: 'doubleAC', name: 'Double Seater (AC)', details: 'Shared AC room with attached bathroom', amount: 9000 },
                { id: 'tripleNonAC', name: 'Triple Seater (Non-AC)', details: 'Shared room for three students', amount: 5000 }
            ],
            mess: [
                { id: 'breakfastOnly', name: 'Breakfast Only', details: 'Morning meals only', amount: 3000 },
                { id: 'lunchOnly', name: 'Lunch Only', details: 'Afternoon meals only', amount: 4000 },
                { id: 'dinnerOnly', name: 'Dinner Only', details: 'Evening meals only', amount: 3500 },
                { id: 'breakfastDinner', name: 'Breakfast & Dinner', details: 'Morning and evening meals', amount: 6000 },
                { id: 'fullMeal', name: 'Full Meal Plan', details: 'All three meals included', amount: 9000 }
            ],
            locker: [
                { id: 'small', name: 'Small Locker', details: 'Ideal for books and small items', amount: 1000 },
                { id: 'medium', name: 'Medium Locker', details: 'Fits a backpack and books', amount: 1500 },
                { id: 'large', name: 'Large Locker', details: 'Spacious for multiple items', amount: 2000 },
                { id: 'premium', name: 'Premium Locker', details: 'Extra secure with digital lock', amount: 2500 }
            ],
            transport: [
                { id: 'oneWay', name: 'One Way Service', details: 'Transport to or from campus', amount: 2500 },
                { id: 'twoWay', name: 'Two Way Service', details: 'Transport to and from campus', amount: 4000 },
                { id: 'weekend', name: 'Weekend Service', details: 'Weekend transport only', amount: 2000 },
                { id: 'premiumBus', name: 'Premium Bus Service', details: 'AC bus with guaranteed seating', amount: 5000 }
            ],
            gym: [
                { id: 'basic', name: 'Basic Membership', details: 'Access to cardio and weight areas', amount: 1500 },
                { id: 'premium', name: 'Premium Membership', details: 'Includes classes and trainer consultation', amount: 3000 },
                { id: 'pool', name: 'Gym + Pool Access', details: 'Full gym access plus swimming pool', amount: 4000 }
            ],
            library: [
                { id: 'basic', name: 'Basic Access', details: 'Book borrowing and reading area access', amount: 500 },
                { id: 'research', name: 'Research Access', details: 'Includes journal and database access', amount: 1500 },
                { id: 'premium', name: 'Premium Access', details: '24/7 access with study rooms', amount: 2500 }
            ],
            other: [
                { id: 'custom', name: 'Custom Facility', details: 'Specify details in notes', amount: 0 }
            ]
        };
        
        // Facility type labels for display
        const facilityTypeLabels = {
            hostel: 'Hostel Type',
            mess: 'Meal Plan',
            locker: 'Locker Size',
            transport: 'Transport Plan',
            gym: 'Membership Type',
            library: 'Access Level',
            other: 'Facility Type'
        };
        
        // Show sub-types based on selected facility type
        function showSubTypes() {
            const facilityType = document.getElementById('facilityType').value;
            const subTypeContainer = document.getElementById('subTypeContainer');
            const subTypeOptions = document.getElementById('subTypeOptions');
            const subTypeTitle = document.getElementById('subTypeTitle');
            
            // Clear previous options
            subTypeOptions.innerHTML = '';
            
            if (facilityType && facilitySubTypes[facilityType]) {
                // Show the container
                subTypeContainer.style.display = 'block';
                
                // Set the title
                subTypeTitle.textContent = `Select ${facilityTypeLabels[facilityType]}`;
                
                // Add options for the selected facility type
                facilitySubTypes[facilityType].forEach(subType => {
                    const optionDiv = document.createElement('div');
                    optionDiv.className = 'sub-type-option';
                    optionDiv.setAttribute('data-id', subType.id);
                    optionDiv.setAttribute('data-amount', subType.amount);
                    optionDiv.innerHTML = `
                        <div class="sub-type-name">${subType.name}</div>
                        <div class="sub-type-details">${subType.details}</div>
                        <div class="amount">₹${subType.amount.toLocaleString()}/month</div>
                    `;
                    
                    optionDiv.addEventListener('click', function() {
                        // Remove selected class from all options
                        document.querySelectorAll('.sub-type-option').forEach(opt => {
                            opt.classList.remove('selected');
                        });
                        
                        // Add selected class to clicked option
                        this.classList.add('selected');
                        
                        // Set the amount in the amount field
                        document.getElementById('facilityAmount').value = subType.amount;
                    });
                    
                    subTypeOptions.appendChild(optionDiv);
                });
            } else {
                // Hide the container if no facility type selected or no sub-types
                subTypeContainer.style.display = 'none';
            }
        }
        
        // Set default start date to today and calculate expiry
        window.onload = function() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('facilityStartDate').value = formattedDate;
            updateExpiryDate();
            
            // Set renew modal start date to today as well
            document.getElementById('renewStartDate').value = formattedDate;
            updateRenewExpiryDate();
        };
        
        // Duration selection for new facility
        function selectDuration(months) {
            document.querySelectorAll('#facilityForm .duration-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            event.target.classList.add('selected');
            document.getElementById('selectedDuration').value = months;
            updateExpiryDate();
        }
        
        // Duration selection for renew modal
        function selectRenewDuration(months) {
            document.querySelectorAll('#renewForm .duration-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            event.target.classList.add('selected');
            document.getElementById('renewDuration').value = months;
            updateRenewExpiryDate();
        }
        
        // Update expiry date based on start date and duration
        function updateExpiryDate() {
            const startDate = new Date(document.getElementById('facilityStartDate').value);
            const duration = parseInt(document.getElementById('selectedDuration').value);
            
            if (!isNaN(startDate.getTime()) && duration > 0) {
                const expiryDate = new Date(startDate);
                expiryDate.setMonth(expiryDate.getMonth() + duration);
                
                document.getElementById('facilityExpiryDate').value = expiryDate.toISOString().split('T')[0];
            }
        }
        
        // Update renew expiry date
        function updateRenewExpiryDate() {
            const startDate = new Date(document.getElementById('renewStartDate').value);
            const duration = parseInt(document.getElementById('renewDuration').value);
            
            if (!isNaN(startDate.getTime()) && duration > 0) {
                const expiryDate = new Date(startDate);
                expiryDate.setMonth(expiryDate.getMonth() + duration);
                
                document.getElementById('renewExpiryDate').value = expiryDate.toISOString().split('T')[0];
            }
        }
        
        // Set up renew modal with facility data
        $('#renewModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const facilityName = button.data('facility');
            const modal = $(this);
            
            modal.find('.modal-title').text('Renew ' + facilityName);
            modal.find('#renewFacilityName').val(facilityName);
        });
        
        // Form submission handling
        document.getElementById('facilityForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Facility added successfully!');
            // Here you would typically send the data to a server
        });
        
        document.getElementById('confirmRenew').addEventListener('click', function() {
            alert('Facility renewed successfully!');
            $('#renewModal').modal('hide');
            // Here you would typically send the renewal data to a server
        });
</script>
</body>
</html>