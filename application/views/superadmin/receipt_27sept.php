<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admission Receipt - Timers Academy</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f4f6f8 !important;
            margin: 0;
            font-family: 'Montserrat', serif !important;
            font-style: normal;
            overflow-x: hidden;
        }

        .receipt-container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .receipt-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #b30000;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            margin: -30px -30px 20px -30px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .receipt-header img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .academy-info {
            font-size: 14px;
            margin-top: 10px;
        }

        .receipt-details {
            margin-top: 20px;
        }

        .receipt-details h5 {
            color: #b30000;
            font-weight: bold;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            border: none !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        @media print {
            .no-print {
                display: none;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .receipt-container {
                margin: 20px;
                padding: 15px;
            }
            .receipt-header h2 {
                font-size: 20px;
            }
            .academy-info {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <!-- Replace with actual logo path -->
           <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
            <h2>Timeer's badminton academy</h2>
            <div class="academy-info">
                <p>123 Sports Complex, City Name, India</p>
                <p>Contact: +91 9876543210 | Email: info@timersacademy.com</p>
            </div>
        </div>

        <div class="receipt-details">
            <h5>Admission Receipt</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Receipt No:</strong> <span id="receiptNo"><?php echo htmlspecialchars($student_id); ?></span></p>
                    <p><strong>Date:</strong> <span id="receiptDate"><?php echo date('Y-m-d'); ?></span></p>
                    <p><strong>Student Name:</strong> <span id="studentName"></span></p>
                    <p><strong>Contact:</strong> <span id="contact"></span></p>
                                        <p><strong>Student Level:</strong> <span id="studentLevel"></span></p>
                                        <p><strong>Course Duration (in months):</strong> <span id="courseDuration"></span></p>

                    <p><strong>Parent Name:</strong> <span id="parentName"></span></p>
                    <p><strong>Emergency Contact:</strong> <span id="emergencyContact"></span></p>
                    <p><strong>Email:</strong> <span id="email"></span></p>
                    <p><strong>Date of Birth:</strong> <span id="dob"></span></p>
                    <p><strong>Address:</strong> <span id="address"></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Center:</strong> <span id="center"></span></p>
                    <p><strong>Batch:</strong> <span id="batch"></span></p>
                    <p><strong>Coach:</strong> <span id="coach"></span></p>
                    <p><strong>Coordinator:</strong> <span id="coordinator"></span></p>
                    <p><strong>Coordinator Phone:</strong> <span id="coordinatorPhone"></span></p>
                    <p><strong>Batch Time:</strong> <span id="batchTime"></span></p>
                    <p><strong>Duration:</strong> <span id="duration"></span></p>
                    <p><strong>Date of Joining:</strong> <span id="joiningDate"></span></p>
                    <p><strong>Attendance Link:</strong> <span id="AttandanceLink"></span></p>

                </div>
            </div>

            <h5 class="mt-4">Fee Details</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-right">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody id="feeDetails">
                    <tr>
                        <td>Course Fees</td>
                        <td class="text-right" id="courseFees"></td>
                      
                    </tr>
                  
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total Fees</th>
                        <th class="text-right" id="totalFees"></th>
                    </tr>
                    <tr>
                        <th>Amount Paid</th>
                        <th class="text-right" id="paidAmount"></th>
                    </tr>
                    <tr>
                        <th>Remaining Amount</th>
                        <th class="text-right" id="remainingAmount"></th>
                    </tr>
                    <tr>
                        <th>Payment Method</th>
                        <th class="text-right" id="paymentMethod"></th>
                    </tr>
                </tfoot>
            </table>

            <div class="text-center mt-4 no-print">
                <button class="btn btn-primary" onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
                <a href="<?= base_url('superadmin/Students') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left" onclick="redirectToPage()"></i> Back to Student Management</a>
            </div>
        </div>
    </div>
    
    <script>
function redirectToPage() {
    window.location.href = "<?= base_url('superadmin/Students'); ?>";
}
</script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const studentId = '<?php echo htmlspecialchars($student_id); ?>';
            if (studentId) {
                $.ajax({
                    url: '<?= base_url('Admission/get_student/') ?>' + studentId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data); // Debug: Log the response
                        $('#receiptNo').text(data.id || 'N/A');
                        $('#studentName').text(data.name || 'N/A');
                        $('#contact').text(data.contact || 'N/A');
                        $('#parentName').text(data.parent_name || 'N/A');
$('#courseDuration').text(data.course_duration ? data.course_duration + ' months' : 'N/A');
                                                $('#studentLevel').text(data.student_progress_category || 'N/A');

                        $('#emergencyContact').text(data.emergency_contact || 'N/A');
                        $('#email').text(data.email || 'N/A');
                        $('#dob').text(data.dob || 'N/A');
                        $('#address').text(data.address || 'N/A');
                        $('#center').text(data.center_name || 'N/A');
                        $('#batch').text(data.batch_name || 'N/A');
                        $('#category').text(data.category || 'N/A');
                        $('#coach').text(data.coach || 'N/A');
                        $('#coordinator').text(data.coordinator_name || 'N/A');
                        $('#coordinatorPhone').text(data.coordinator_phone || 'N/A');
$('#batchTime').text(
    (data.batch_start_time && data.batch_end_time) 
        ? `${data.batch_start_time} - ${data.batch_end_time}` 
        : 'N/A'
);
$('#AttandanceLink').text(data.attendace_link || 'N/A');
                        $('#duration').text(data.duration ? `${data.duration} hours` : 'N/A');
                        $('#joiningDate').text(data.joining_date || 'N/A');
                        $('#courseFees').text(data.course_fees ? `₹${parseFloat(data.course_fees).toLocaleString()}` : '₹0');
                        $('#totalFees').text(data.total_fees ? `₹${parseFloat(data.total_fees).toLocaleString()}` : '₹0');
                        $('#paidAmount').text(data.paid_amount ? `₹${parseFloat(data.paid_amount).toLocaleString()}` : '₹0');
                        $('#remainingAmount').text(data.remaining_amount ? `₹${parseFloat(data.remaining_amount).toLocaleString()}` : '₹0');
                        $('#paymentMethod').text(data.payment_method || 'N/A');
                        $('#courseDuration').text(data.course_duration || 'N/A');   
                      if (data.additional_fees && parseFloat(data.additional_fees) > 0) {
    $('#feeDetails').append(`
        <tr>
            <td>Facility Charges</td>
            <td class="text-right">₹${parseFloat(data.additional_fees).toLocaleString()}</td>
        </tr>
    `);
}
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error); // Debug: Log the error
                        alert('Failed to fetch receipt details: ' + error);
                    }
                });
            } else {
                alert('Invalid student ID');
            }
        });
    </script>
</body>

</html>