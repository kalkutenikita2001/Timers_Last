<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .action-menu {
            position: relative;
            display: inline-block;
        }
        .menu-content {
            display: none;
            position: absolute;
            right: 0;
            background: #fff;
            min-width: 140px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            z-index: 1;
            border-radius: 6px;
        }
        .menu-content button {
            width: 100%;
            border: none;
            background: none;
            padding: 8px 16px;
            text-align: left;
        }
        .action-menu.show .menu-content {
            display: block;
        }
        .three-dot {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
</head>
<body>
      <!-- Sidebar and Navbar -->
    <?php $this->load->view('superadmin/Include/Sidebar'); ?>
    <?php $this->load->view('superadmin/Include/Navbar'); ?>

<div class="container mt-5">
    <h4 class="mb-4 text-center">Salary Management</h4>
    <table class="table table-bordered" id="salaryTable">
        <thead>
            <tr>
                <th>Sr No</th>
                <th>Staff Name</th>
                <th>Staff Salary</th>
                <th>Paid</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>25000</td>
                <td><input type="checkbox" class="paid-checkbox"></td>
                <td>
                    <div class="action-menu">
                        <button class="three-dot">&#x22EE;</button>
                        <div class="menu-content">
                            <button class="edit-salary">Edit Salary</button>
                            <button class="delete-salary">Delete Salary</button>
                            <button class="add-note">Add Note</button>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Add more rows dynamically as needed -->
</div>

<script>
$(document).ready(function() {
    // Three-dot menu toggle
    $(document).on('click', '.three-dot', function(e) {
        e.stopPropagation();
        $('.action-menu').removeClass('show');
        $(this).closest('.action-menu').toggleClass('show');
    });

    // Hide menu when clicking outside
    $(document).on('click', function() {
        $('.action-menu').removeClass('show');
    });

    // Edit Salary
    $(document).on('click', '.edit-salary', function() {
        let row = $(this).closest('tr');
        let currentSalary = row.find('td:eq(2)').text();
        Swal.fire({
            title: 'Edit Salary',
            input: 'number',
            inputLabel: 'Enter new salary',
            inputValue: currentSalary,
            showCancelButton: true,
            confirmButtonText: 'Save',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                row.find('td:eq(2)').text(result.value);
                Swal.fire('Updated!', 'Salary has been updated.', 'success');
            }
        });
    });

    // Delete Salary
    $(document).on('click', '.delete-salary', function() {
        let row = $(this).closest('tr');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the salary record.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
        }).then((result) => {
            if (result.isConfirmed) {
                row.remove();
                // Re-number Sr No
                $('#salaryTable tbody tr').each(function(i){
                    $(this).find('td:eq(0)').text(i+1);
                });
                Swal.fire('Deleted!', 'Salary record has been deleted.', 'success');
            }
        });
    });

    // Add Note
    $(document).on('click', '.add-note', function() {
        Swal.fire({
            title: 'Add Note',
            input: 'textarea',
            inputLabel: 'Enter note for this staff',
            showCancelButton: true,
            confirmButtonText: 'Save Note',
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                Swal.fire('Saved!', 'Note added: ' + result.value, 'success');
            }
        });
    });

    // Paid Checkbox
    $(document).on('change', '.paid-checkbox', function() {
        let checked = $(this).is(':checked');
        let staffName = $(this).closest('tr').find('td:eq(1)').text();
        if (checked) {
            Swal.fire('Marked as Paid', staffName + '\'s salary marked as paid.', 'success');
        } else {
            Swal.fire('Unmarked', staffName + '\'s salary marked as unpaid.', 'info');
        }
    });
});
</script>
</body>
</html>