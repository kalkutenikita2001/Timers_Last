<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Participants</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content-wrapper {
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .page-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .participants-table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table-responsive {
            border-radius: 8px;
        }

        .table thead th {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px 12px;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 64, 64, 0.05);
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }

        .badge-participant {
            background-color: #6c757d;
            color: white;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .back-button {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .table-responsive {
                border: 1px solid #dee2e6;
                border-radius: 8px;
            }

            .page-header {
                padding: 15px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 8px;
            }

            .table tbody td {
                display: block;
                text-align: right;
                padding: 10px 15px;
                position: relative;
                border-top: none;
                border-bottom: 1px solid #dee2e6;
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .table tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                font-weight: 600;
                color: #495057;
            }
        }

        .participant-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .participant-name-cell {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>


    <div class="content-wrapper" id="contentWrapper">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2><i class="fas fa-users mr-2"></i>Event Participants</h2>
                        <p class="mb-0">
                            Viewing participants for Event:
                            <strong><?= $event_name ? $event_name : 'Unknown Event' ?></strong>
                        </p>

                    </div>
                    <div class="col-md-6 text-md-right">
                        <button class="back-button" onclick="history.back()">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Events
                        </button>
                    </div>
                </div>
            </div>

            <!-- Participants Table -->
            <div class="participants-table-container">
                <?php if (!empty($participants)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Registered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($participants as $i => $p): ?>
                                    <tr>
                                        <td data-label="#">
                                            <span class="badge badge-participant"><?= $i + 1 ?></span>
                                        </td>
                                        <td data-label="Name" class="participant-name-cell">
                                            <div class="participant-avatar">
                                                <?= strtoupper(substr($p->name, 0, 1)) ?>
                                            </div>
                                            <?= $p->name ?>
                                        </td>
                                        <td data-label="Email">
                                            <a href="mailto:<?= $p->email ?>"><?= $p->email ?></a>
                                        </td>
                                        <td data-label="Phone">
                                            <a href="tel:<?= $p->phone ?>"><?= $p->phone ?></a>
                                        </td>
                                        <td data-label="Address"><?= $p->address ?></td>
                                        <td data-label="Registered At"><?= date('M j, Y g:i A', strtotime($p->created_at)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <h3>No Participants Found</h3>
                        <p class="text-muted"> <?= $event->description ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Summary Card -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-white text-danger text-center mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Total Participants</h5>
                            <h2 class="card-text"><?= count($participants) ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="d-flex justify-content-end mb-4">
                        <button id="exportBtn" class="btn btn-lg btn-outline-primary">
                            <i class="fas fa-download mr-1"></i> Export List
                        </button>
                    </div>
                </div>


            </div>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add responsiveness to table on small screens
        document.addEventListener("DOMContentLoaded", function() {
            function adjustTableForMobile() {
                if (window.innerWidth < 768) {
                    document.querySelectorAll('tbody td').forEach(td => {
                        const headerText = document.querySelectorAll('th')[td.cellIndex].textContent;
                        td.setAttribute('data-label', headerText);
                    });
                }
            }

            adjustTableForMobile();
            window.addEventListener('resize', adjustTableForMobile);
        });
    </script>
    <script>
        document.getElementById("exportBtn").addEventListener("click", function() {
            let table = document.querySelector(".participants-table-container table");
            if (!table) {
                alert("No participants to export!");
                return;
            }

            let rows = table.querySelectorAll("tr");
            let csv = [];

            rows.forEach(row => {
                let cols = row.querySelectorAll("th, td");
                let rowData = [];
                cols.forEach(col => {
                    // Clean text (remove extra spaces/new lines)
                    let text = col.innerText.replace(/(\r\n|\n|\r)/gm, "").trim();
                    // Escape double quotes
                    text = `"${text.replace(/"/g, '""')}"`;
                    rowData.push(text);
                });
                csv.push(rowData.join(","));
            });

            // Create downloadable CSV
            let csvContent = "data:text/csv;charset=utf-8," + csv.join("\n");
            let link = document.createElement("a");
            link.setAttribute("href", encodeURI(csvContent));
            link.setAttribute("download", "participants_list.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</body>

</html>