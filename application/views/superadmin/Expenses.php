<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f6f8;
            padding-top: 60px;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            border: none;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .option-buttons button {
            border-radius: 20px;
            padding: 8px 25px;
            margin: 0 5px;
        }

        .option-buttons button.active {
            background: #000;
            color: #fff;
        }

        .table th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
        }

        .action-btn {
            padding: 5px 10px;
            margin: 0 3px;
            border-radius: 4px;
        }

        .thumbs-up {
            background-color: #28a745;
            color: white;
        }

        .cross {
            background-color: #dc3545;
            color: white;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 15px;
            }
        }

        .card-header h4 {
            color: #fff !important;
        }

        .table thead th {
            color: #fff !important;
        }

        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .card-header h4 {
            color: #fff !important;
        }

        .table th,
        .table thead th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: #fff !important;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php $this->load->view('superadmin/Include/Sidebar') ?>
    <!-- Navbar -->
    <?php $this->load->view('superadmin/Include/Navbar') ?>

    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Expense Management</h4>
                </div>
                <div class="card-body">


                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mb-4">
                        <div class="center-select-container" id="centerSelectContainer">
                            <select class="form-control form-control-sm" style="width: 200px;">
                                <option>-- Select Center --</option>
                                <option>Center 1</option>
                                <option>Center 2</option>
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#filterModal">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#expenseModal">
                                <i class="fas fa-plus mr-1"></i> Add Expense
                            </button>
                        </div>
                    </div>

                    <!-- Expenses Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Equipment Purchase</td>
                                    <td>15/10/2023</td>
                                    <td>Rs. 15,000</td>
                                    <td>Bought new cricket bats</td>
                                    <td>
                                        <button class="action-btn thumbs-up"><i class="fas fa-check"></i></button>
                                        <button class="action-btn cross"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Coach Payment</td>
                                    <td>10/10/2023</td>
                                    <td>Rs. 25,000</td>
                                    <td>Monthly salary</td>
                                    <td>
                                        <button class="action-btn thumbs-up"><i class="fas fa-check"></i></button>
                                        <button class="action-btn cross"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Utility Bills</td>
                                    <td>05/10/2023</td>
                                    <td>Rs. 8,500</td>
                                    <td>Electricity and water</td>
                                    <td>
                                        <button class="action-btn thumbs-up"><i class="fas fa-check"></i></button>
                                        <button class="action-btn cross"><i class="fas fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <!-- Add Expense Modal -->
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Add Expense</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-building mr-1 text-danger"></i> Select Center</label>
                                <select class="form-control" required>
                                    <option value="" disabled selected>Select Center</option>
                                    <option>Center 1</option>
                                    <option>Center 2</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-heading mr-1 text-danger"></i> Title</label>
                                <input type="text" class="form-control" placeholder="Enter expense title" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-calendar-alt mr-1 text-danger"></i> Date</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-rupee-sign mr-1 text-danger"></i> Amount (₹)</label>
                                <input type="number" class="form-control" placeholder="Enter amount" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label><i class="fas fa-align-left mr-1 text-danger"></i> Description</label>
                                <textarea class="form-control" rows="3" placeholder="Enter description..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal"><i class="fas fa-times mr-1"></i> Cancel</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="fas fa-save mr-1"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg border-0 rounded-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-filter mr-2"></i>Filter Expenses</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-calendar-alt mr-1 text-danger"></i> From Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-calendar-check mr-1 text-danger"></i> To Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-coins mr-1 text-danger"></i> Min Amount</label>
                                <input type="number" class="form-control" placeholder="Enter min amount">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-wallet mr-1 text-danger"></i> Max Amount</label>
                                <input type="number" class="form-control" placeholder="Enter max amount">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label><i class="fas fa-tags mr-1 text-danger"></i> Category</label>
                                <select class="form-control">
                                    <option>All</option>
                                    <option>Equipment</option>
                                    <option>Salaries</option>
                                    <option>Utilities</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary px-4"><i class="fas fa-undo mr-1"></i> Clear</button>
                        <button type="submit" class="btn btn-danger px-4"><i class="fas fa-check mr-1"></i> Apply Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function switchOption(option) {
            $('.option-buttons button').removeClass('active');
            $(`.option-buttons button:contains(${option === 'centerwise' ? 'Centerwise Expenses' : 'Own Expenses'})`).addClass('active');

            if (option === 'own') {
                $('#centerSelectContainer').hide();
            } else {
                $('#centerSelectContainer').show();
            }
        }

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const contentWrapper = document.getElementById('contentWrapper');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        document.getElementById('sidebar').classList.toggle('active');
                    } else {
                        contentWrapper.classList.toggle('minimized');
                    }
                });
            }
        });
    </script>
</body>

</html>