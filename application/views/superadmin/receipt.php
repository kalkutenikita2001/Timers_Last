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
        /* Base page */
        body {
            background-color: #f4f6f8 !important;
            margin: 0;
            font-family: 'Montserrat', serif !important;
            font-style: normal;
            overflow-x: hidden;
            color: #222;
        }

        /* Receipt card */
        .receipt-container {
            max-width: 820px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(16, 24, 40, 0.06);
            padding: 28px;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .receipt-header {
            text-align: center;
            padding-bottom: 18px;
            border-bottom: 2px solid rgba(179, 0, 0, 0.15);
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 22px;
            margin: -28px -28px 18px -28px;
        }

        .receipt-header h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.2px;
            font-weight: 700;
        }

        .receipt-header img {
            max-width: 110px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .academy-info {
            font-size: 13px;
            margin-top: 8px;
            opacity: 0.95;
            line-height: 1.2;
        }

        .receipt-details {
            margin-top: 6px;
        }

        .receipt-details h5 {
            color: #b30000;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .detail-label {
            color: #444;
            font-weight: 600;
            min-width: 120px;
            display: inline-block;
        }

        .detail-value {
            color: #111;
            display: inline-block;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 10px 12px;
        }

        .table thead th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff;
            font-weight: 700;
            border-color: rgba(0, 0, 0, 0.06);
        }

        .table-bordered {
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            border: none !important;
            box-shadow: 0 6px 20px rgba(255, 64, 64, 0.08);
        }

        .btn-primary:hover {
            opacity: 0.95;
        }

        .no-print { /* already used: hide on print */
            /* keep visible on screen */
        }

        /* Responsive on small screens (for screen view) */
        @media (max-width: 576px) {
            .receipt-container {
                margin: 18px;
                padding: 16px;
            }

            .receipt-header h2 {
                font-size: 18px;
            }

            .academy-info {
                font-size: 12px;
            }

            .detail-label { min-width: 90px; display: block; font-weight: 700; margin-bottom: 2px; }
            .detail-value { display: block; margin-bottom: 8px; }
        }

        /* PRINT STYLES: improved fidelity and centered, stacked details */
        @media print {
          * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
          }

          /* hide UI elements */
          .no-print,
          .btn,
          .btn-primary,
          .btn-secondary {
            display: none !important;
          }

          html,
          body {
            background: #fff !important;
            color: #000 !important;
            height: 100%;
          }

          /* center the receipt on page with fixed print width */
          .receipt-container {
            width: 700px !important;
            margin: 0 auto !important;
            padding: 20px !important;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: none !important;
            border-radius: 0 !important;
            border: none !important;
            page-break-inside: avoid;
          }

          /* header fallback for printers */
          .receipt-header {
            background: #b30000 !important;
            border-bottom: 2px solid #000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            padding: 14px !important;
            margin-bottom: 12px !important;
        }

          .receipt-header h2,
          .receipt-header .academy-info {
            color: #fff !important;
          }

          .receipt-header img {
            max-width: 120px !important;
            height: auto !important;
          }

          /* Tables: ensure borders visible on paper */
          .table,
          .table th,
          .table td {
            border: 1px solid #000 !important;
            color: #000 !important;
          }

          .table thead th {
            background-color: #b30000 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact !important;
          }

          .receipt-details p {
            margin-bottom: 6px !important;
            font-size: 12px !important;
          }

          /* --- Force details into a single stacked column on print --- */
          .receipt-details .row {
            display: block !important;
          }

          .receipt-details .col-md-6 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            box-sizing: border-box;
          }

          .receipt-details .col-md-6 p,
          .receipt-details .col-md-6 .detail-row {
            font-size: 12px !important;
            margin-bottom: 6px !important;
            color: #000 !important;
          }

          /* Make label/value compact and aligned */
          .detail-label {
            display: inline-block !important;
            min-width: 150px !important;
            font-weight: 700 !important;
            color: #000 !important;
          }

          .detail-value {
            display: inline-block !important;
            color: #000 !important;
          }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <!-- Replace with actual logo path -->
            <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
            <h2>Timeer's Badminton Academy</h2>
            <div class="academy-info">
                <p>123 Sports Complex, City Name, India</p>
                <p>Contact: +91 9876543210 | Email: info@timersacademy.com</p>
            </div>
        </div>

        <div class="receipt-details">
            <h5>Admission Receipt</h5>
            <div class="row">
                <div class="col-md-6">
                    <p class="detail-row"><span class="detail-label">Receipt No:</span> <span id="receiptNo"><?php echo htmlspecialchars($student_id); ?></span></p>
                    <p class="detail-row"><span class="detail-label">Date:</span> <span id="receiptDate"><?php echo date('Y-m-d'); ?></span></p>
                    <p class="detail-row"><span class="detail-label">Student Name:</span> <span id="studentName"></span></p>
                    <p class="detail-row"><span class="detail-label">Contact:</span> <span id="contact"></span></p>
                    <p class="detail-row"><span class="detail-label">Student Level:</span> <span id="studentLevel"></span></p>
                    <p class="detail-row"><span class="detail-label">Course Duration:</span> <span id="courseDuration"></span></p>
                    <p class="detail-row"><span class="detail-label">Parent Name:</span> <span id="parentName"></span></p>
                    <p class="detail-row"><span class="detail-label">Emergency Contact:</span> <span id="emergencyContact"></span></p>
                    <p class="detail-row"><span class="detail-label">Email:</span> <span id="email"></span></p>
                    <p class="detail-row"><span class="detail-label">Date of Birth:</span> <span id="dob"></span></p>
                    <p class="detail-row"><span class="detail-label">Address:</span> <span id="address"></span></p>
                </div>
                <div class="col-md-6">
                    <p class="detail-row"><span class="detail-label">Center:</span> <span id="center"></span></p>
                    <p class="detail-row"><span class="detail-label">Batch:</span> <span id="batch"></span></p>
                    <p class="detail-row"><span class="detail-label">Coach:</span> <span id="coach"></span></p>
                    <p class="detail-row"><span class="detail-label">Coordinator:</span> <span id="coordinator"></span></p>
                    <p class="detail-row"><span class="detail-label">Coordinator Phone:</span> <span id="coordinatorPhone"></span></p>
                    <p class="detail-row"><span class="detail-label">Batch Time:</span> <span id="batchTime"></span></p>
                    <!-- <p class="detail-row"><span class="detail-label">Duration:</span> <span id="duration"></span></p> -->
                    <p class="detail-row"><span class="detail-label">Date of Joining:</span> <span id="joiningDate"></span></p>
                    <!-- <p class="detail-row"><span class="detail-label">Attendance Link:</span> <span id="AttandanceLink"></span></p> -->
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
                <a href="<?= base_url('superadmin/Students') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Student Management</a>
            </div>
        </div>
    </div>

    <!-- Scripts (unchanged logic) -->
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
