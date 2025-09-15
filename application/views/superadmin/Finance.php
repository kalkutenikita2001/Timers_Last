<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

        .option-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .option-buttons button {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .option-buttons button.active {
            background: #000;
            color: #fff;
            border: 1px solid #fff;
        }

        .option-buttons button:hover {
            background: #333;
            color: #fff;
        }

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
            background-color: #343a40;
            color: white;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
            padding: 1rem;
            text-align: center;
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
            text-align: center;
            padding: 0.75rem;
            white-space: nowrap;
            border-bottom: 1px solid #dee2e6;
            font-size: 0.9rem;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
        }

        .action-icon {
            font-size: 1.2rem;
            margin: 0 0.5rem;
            cursor: pointer;
            transition: transform 0.2s ease;
            color: #17a2b8;
        }

        .action-btn {
            font-size: 0.85rem;
            margin: 0 0.3rem;
            padding: 0.3rem 0.6rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .action-btn.approve-btn {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .action-btn.reject-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-custom {
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1rem;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-top: 65px;
        }

        .add-btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
            align-items: center;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 10px;
        }

        @media (max-width: 576px) {
            .content-wrapper {
                margin-left: 0 !important;
                padding: 1rem !important;
            }

            .option-buttons {
                flex-direction: column;
            }

            .add-btn-container {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>
    <div class="modal fade" id="confirmActionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="confirmActionLabel" class="modal-title w-100 text-center"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <p id="confirmMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper" id="contentWrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="option-buttons">
                    <button class="active" data-option="centerwise">Centerwise Revenue</button>
                    <button data-option="totalrevenue">Total Revenue</button>
                </div>
                <div class="add-btn-container">
                    <button class="btn btn-custom" data-toggle="modal" data-target="#filterModal"><i class="fas fa-filter me-2"></i> Filter</button>
                </div>
                <div class="table-container">
                    <div class="table-title">Revenue Records</div>
                    <table class="table table-bordered table-hover" id="revenueTable">
                        <thead>
                            <tr>
                                <th>Center Name</th>
                                <th>Daily Revenue(₹)</th>
                                <th>Weekly Revenue(₹)</th>
                                <th>Monthly Revenue(₹)</th>
                                <th>Yearly Revenue(₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="revenueTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100 text-center">Revenue Details</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="receipt-card">
                        <p><strong>Center Name:</strong> <span id="viewCenterName"></span></p>
                        <p><strong>Date:</strong> <span id="viewDate"></span></p>
                        <p><strong>Daily Revenue:</strong> <span id="viewDailyRevenue"></span></p>
                        <p><strong>Weekly Revenue:</strong> <span id="viewWeeklyRevenue"></span></p>
                        <p><strong>Monthly Revenue:</strong> <span id="viewMonthlyRevenue"></span></p>
                        <p><strong>Yearly Revenue:</strong> <span id="viewYearlyRevenue"></span></p>
                        <p><strong>Status:</strong> <span id="viewStatus"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title w-100 text-center">Filter Revenue</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <form id="filterForm">
                    <div class="form-note">Fill at least one field to apply a filter.</div>
                    <div class="form-group">
                        <label for="filterCenterName">Center Name</label>
                        <select id="filterCenterName" name="filterCenterName" class="form-control">
                            <option value="">All Centers</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="startDate">Start Date</label>
                            <input type="date" id="startDate" name="startDate" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="endDate">End Date</label>
                            <input type="date" id="endDate" name="endDate" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function loadRevenues(option = 'centerwise', filters = {}) {
            $('#revenueTableBody').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

            $.ajax({
                url: "<?php echo base_url('Finance/getRevenue'); ?>",
                type: "POST",
                data: filters,
                dataType: "json",
                success: function(response) {
                    if (response.status && response.data.length > 0) {
                        let rows = "";
                        response.data.forEach(r => {
                            rows += `
                        <tr>
                            <td>${r.center_name}</td>
                            <td>₹${r.student_income}</td>
                            <td>₹${r.facility_income}</td>
                            <td>₹${r.total_income}</td>
                            <td>
                                <i class="fas fa-info-circle action-icon" title="View Details" data-toggle="modal" data-target="#viewModal"></i>
                            </td>
                        </tr>
                    `;
                        });
                        $('#revenueTableBody').html(rows);
                    } else {
                        $('#revenueTableBody').html('<tr><td colspan="6" class="text-center">No data found</td></tr>');
                    }
                }
            });
        }
    </script>
</body>

</html>