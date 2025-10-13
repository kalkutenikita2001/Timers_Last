<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Venue Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f4f6f8 !important;
            font-family: 'Montserrat', sans-serif !important;
            overflow-x: hidden;
        }

        .sidebar {
            position: relative;
            left: 0;
            top: 0;
            bottom: 0;
            width: 250px;
            background-color: #333;
            color: white;
            padding-top: 20px;
        }

        .sidebar.minimized {
            width: 60px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            color: white;
            padding: 10px;
            transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
            /* background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important; */
        }

        .navbar.sidebar-minimized {
            left: 60px;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content-wrapper.minimized {
            margin-left: 60px;
        }

        .card {
            border: none;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            color: #fff !important;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .form-control.is-invalid {
            border-color: #ff4040;
        }

        .invalid-feedback {
            color: #ff4040;
        }

        label {
            font-weight: 500;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            border: none !important;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        /* Make all Font Awesome icons red */
        i.fas,
        i.far,
        i.fab {
            color: #ff4040 !important;
        }

        /* Keep trash icons their default color */
        .btn .fa-trash {
            color: inherit !important;
            /* keeps the button default color */
        }



        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .navbar {
                left: 0;
            }

            .content-wrapper {
                margin-left: 0;
            }
        }





        .court-slot-block {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background: #fff;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .court-slot-block h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .slot-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .slot-box {
            background-color: #e6ffe6;
            /* greenish for available */
            color: #333;
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid green;
            text-align: center;
            min-width: 80px;
            cursor: pointer;
            transition: 0.2s;
        }

        .slot-box:hover {
            background-color: #ccffcc;
            transform: scale(1.05);
        }


        /* --- Court / Slot / Facility / Plan Boxes --- */
        /* --- Enhanced Court / Slot / Facility / Plan Boxes --- */
        .court-slot-block {
            border: 2px solid #ff4040;
            /* Red border */
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            background: #fff;
            /* solid white background */
            box-shadow: 0 4px 12px rgba(255, 64, 64, 0.15);
            /* subtle red shadow */
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            flex: 1 1 22%;
            /* Desktop: approx 4 per row */
            box-sizing: border-box;
        }

        .court-slot-block:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(255, 64, 64, 0.25);
            border-color: #ff0000;
            /* darker red on hover */
        }

        .court-slot-block h5 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ff4040;
            /* Red heading */
        }

        .court-slot-block h5 small {
            color: #555;
            font-weight: 400;
        }

        .court-slot-block p {
            font-size: 0.9rem;
            color: #333;
        }


        /* Container Flexbox */
        #courtSlotsView,
        #facilityPreview,
        #slotPreview,
        #planPreview {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Slot boxes */
        .slot-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .slot-box {
            min-width: 80px;
            padding: 6px 12px;
            border-radius: 8px;
            background: linear-gradient(135deg, #e6ffe6, #ccffcc);
            border: 1px solid #28a745;
            font-size: 0.85rem;
            color: #2c3e50;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .slot-box:hover {
            background: linear-gradient(135deg, #ccffcc, #b2f2b2);
            transform: scale(1.05);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive: mobile single box per row */
        @media (max-width: 768px) {
            .court-slot-block {
                flex: 1 1 100%;
                /* full width */
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
        <div class="container-fluid mt-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-building mr-2"></i> Add New Center</h4>
                </div>
                <div class="card-body">
                    <!-- Venue Details -->
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2 text-primary"></i>Venue Details</h5>
                    <form id="venueForm">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Venue Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Venue Name">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Location">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Number of Courts <span class="text-danger">*</span></label>
                                <input type="number" id="numCourts" class="form-control" placeholder="e.g. 3" min="1">
                            </div>
                        </div>

                        <!-- Court Details Container -->
                        <div id="courtDetailsContainer"></div>

                        <div id="courtSlotsView" class="mt-4">
                            <!-- Dynamically generated court slot views will appear here -->
                        </div>

                        <hr>

                        <!-- Facilities / Amenities -->
                        <h5 class="mb-3"><i class="fas fa-dumbbell mr-2 text-primary"></i>Facilities / Amenities</h5>
                        <div id="facilityContainer">
                            <div class="form-row facility-item mb-2">
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" placeholder="Facility Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" placeholder="Type">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="number" class="form-control" placeholder="Rent">
                                </div>
                                <div class="form-group col-md-1 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-facility"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addFacility" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Facility</button>

                        <div id="facilityPreview" class="mt-3"></div>

                        <hr>

                        <!-- Slot Management -->
                        <h5 class="mb-3"><i class="fas fa-clock mr-2 text-primary"></i>Add Slots</h5>
                        <div id="slotContainer">
                            <div class="form-row slot-item mb-2">
                                <div class="form-group col-md-4">
                                    <label>From</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>To</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Category/Name</label>
                                    <input type="text" class="form-control" placeholder="e.g. Morning Slot">
                                </div>
                                <div class="form-group col-md-1 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-slot mt-4"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="addSlot" class="btn btn-outline-primary btn-sm mb-3"><i class="fas fa-plus"></i> Add Slot</button>

                        <div id="slotPreview" class="mt-3"></div>
                        <hr>

                        <h5 class="mb-3"><i class="fas fa-tags mr-2 text-primary"></i>Pricing / Membership Plans</h5>
                        <div id="planContainer">
                            <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
                                <!-- Row 1: Name, Duration, Period, Slot -->
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" class="form-control" placeholder="Membership Name">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="number" class="form-control" placeholder="Duration">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select class="form-control">
                                            <option selected disabled>Select Period</option>
                                            <option>Week</option>
                                            <option>Month</option>
                                            <option>Year</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select class="form-control">
                                            <option selected disabled>Select Slot</option>
                                            <option>Morning Slot</option>
                                            <option>Evening Slot</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2 text-center align-self-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-plan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- Row 2: Registration Fees, Coaching Fees -->
                                <div class="form-row mt-2">
                                    <div class="form-group col-md-3">
                                        <input type="number" class="form-control" placeholder="Registration Fees">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <input type="number" class="form-control" placeholder="Coaching Fees">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="addPlan" class="btn btn-outline-primary btn-sm mb-3">
                            <i class="fas fa-plus"></i> Add Plan
                        </button>

                        <div id="planPreview" class="mt-3"></div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-secondary mr-2">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                        <!-- View Center Section -->
                        <div class="card shadow mt-4">
                            <div class="card-header bg-dark text-white">
                                <h4 class="mb-0"><i class="fas fa-eye mr-2"></i> View Centers</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Venue Name</th>
                                                <th>Location</th>
                                                <th>Courts</th>
                                                <th>Facilities</th>
                                                <th>Slots</th>
                                                <th>Plans</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dynamic rows here -->
                                            <tr>
                                                <td>ABC Sports Arena</td>
                                                <td>Pune</td>
                                                <td>4</td>
                                                <td>Badminton, Gym</td>
                                                <td>6:00 AM - 9:00 AM</td>
                                                <td>Monthly, Yearly</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </div>

                <!-- Scripts -->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script>
                    // Add Facility
                    $('#addFacility').on('click', function() {
                        $('#facilityContainer').append(`
      <div class="form-row facility-item mb-2">
        <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Facility Name"></div>
        <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Type"></div>
        <div class="form-group col-md-3"><input type="number" class="form-control" placeholder="Rent"></div>
        <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-facility"><i class="fas fa-trash"></i></button></div>
      </div>
    `);
                    });

                    // Remove Facility
                    $(document).on('click', '.remove-facility', function() {
                        $(this).closest('.facility-item').remove();
                    });

                    // Add Slot
                    $('#addSlot').on('click', function() {
                        $('#slotContainer').append(`
      <div class="form-row slot-item mb-2">
        <div class="form-group col-md-4"><label>From</label><input type="time" class="form-control"></div>
        <div class="form-group col-md-4"><label>To</label><input type="time" class="form-control"></div>
        <div class="form-group col-md-3"><label>Category/Name</label><input type="text" class="form-control"></div>
        <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-slot mt-4"><i class="fas fa-trash"></i></button></div>
      </div>
    `);
                    });

                    // Remove Slot
                    $(document).on('click', '.remove-slot', function() {
                        $(this).closest('.slot-item').remove();
                    });

                    // Add Plan
                    // Add Plan
                    // Add Plan - Updated for 2-row design
                    $('#addPlan').on('click', function() {
                        $('#planContainer').append(`
        <div class="plan-item mb-3 p-3 border rounded bg-white shadow-sm">
            <!-- Row 1: Name, Duration, Period, Slot, Remove -->
            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" placeholder="Membership Name">
                </div>
                <div class="form-group col-md-2">
                    <input type="number" class="form-control" placeholder="Duration">
                </div>
                <div class="form-group col-md-2">
                    <select class="form-control">
                        <option selected disabled>Select Period</option>
                        <option>Week</option>
                        <option>Month</option>
                        <option>Year</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <select class="form-control">
                        <option selected disabled>Select Slot</option>
                        <option>Morning Slot</option>
                        <option>Evening Slot</option>
                    </select>
                </div>
                <div class="form-group col-md-2 text-center align-self-end">
                    <button type="button" class="btn btn-danger btn-sm remove-plan">
                        <i class="fas fa-trash"></i> 
                    </button>
                </div>
            </div>
            <!-- Row 2: Registration Fees, Coaching Fees -->
            <div class="form-row mt-2">
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" placeholder="Registration Fees">
                </div>
                <div class="form-group col-md-3">
                    <input type="number" class="form-control" placeholder="Coaching Fees">
                </div>
            </div>
        </div>
    `);

                        renderPlanPreview(); // Update preview
                    });



                    // Remove Plan
                    $(document).on('click', '.remove-plan', function() {
                        $(this).closest('.plan-item').remove();
                    });

                    // Generate court details based on number of courts
                    $('#numCourts').on('input', function() {
                        let num = parseInt($(this).val()) || 0;
                        let container = $('#courtDetailsContainer');
                        container.empty(); // Clear previous inputs

                        for (let i = 1; i <= num; i++) {
                            container.append(`
            <div class="form-row mb-2 court-item">
                <div class="form-group col-md-6">
                    <label>Court ${i} Name</label>
                    <input type="text" class="form-control" placeholder="Enter Court ${i} Name">
                </div>
                <div class="form-group col-md-6">
                    <label>Court ${i} Category</label>
                    <input type="text" class="form-control" placeholder="Enter Court ${i} Category">
                </div>
            </div>
        `);
                        }
                    });


                    function renderCourtSlots() {
                        const courts = [];
                        $('#courtDetailsContainer .court-item').each(function() {
                            const courtName = $(this).find('input').eq(0).val();
                            const courtCategory = $(this).find('input').eq(1).val();
                            if (courtName) {
                                courts.push({
                                    name: courtName,
                                    category: courtCategory
                                });
                            }
                        });

                        const slots = [];
                        $('#slotContainer .slot-item').each(function() {
                            const fromTime = $(this).find('input[type="time"]').eq(0).val();
                            const toTime = $(this).find('input[type="time"]').eq(1).val();
                            const slotName = $(this).find('input[type="text"]').val();
                            if (fromTime && toTime) {
                                slots.push({
                                    from: fromTime,
                                    to: toTime,
                                    name: slotName
                                });
                            }
                        });

                        const container = $('#courtSlotsView');
                        container.empty();

                        courts.forEach(court => {
                            const courtDiv = $(`
            <div class="court-slot-block mb-3">
                <h5>${court.name} - <small>${court.category}</small></h5>
                <div class="slot-grid"></div>
            </div>
        `);

                            slots.forEach(slot => {
                                const slotBox = $(`
                <div class="slot-box">
                    ${formatTime(slot.from)} - ${formatTime(slot.to)}<br><small>${slot.name}</small>
                </div>
            `);
                                courtDiv.find('.slot-grid').append(slotBox);
                            });

                            container.append(courtDiv);
                        });
                    }


                    // Optional: Convert 24h time to 12h AM/PM
                    function formatTime(time) {
                        if (!time) return '';
                        let [h, m] = time.split(':');
                        h = parseInt(h);
                        const ampm = h >= 12 ? 'PM' : 'AM';
                        h = h % 12 || 12;
                        return `${("0"+h).slice(-2)}:${m} ${ampm}`;
                    }

                    // Call this function on form submit or a button click
                    $('#venueForm').on('submit', function(e) {
                        e.preventDefault();
                        renderCourtSlots();
                    });

                    function renderFacilityPreview() {
                        const container = $('#facilityPreview');
                        container.empty();

                        $('#facilityContainer .facility-item').each(function() {
                            const name = $(this).find('input').eq(0).val();
                            const type = $(this).find('input').eq(1).val();
                            const rent = $(this).find('input').eq(2).val();

                            if (name) {
                                const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${name} - <small>${type}</small></h5>
                    <p>Rent: ₹${rent || 0}</p>
                </div>
            `);
                                container.append(div);
                            }
                        });
                    }

                    function renderSlotPreview() {
                        const container = $('#slotPreview');
                        container.empty();

                        $('#slotContainer .slot-item').each(function() {
                            const from = $(this).find('input[type="time"]').eq(0).val();
                            const to = $(this).find('input[type="time"]').eq(1).val();
                            const name = $(this).find('input[type="text"]').val();

                            if (from && to) {
                                const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${name || 'Slot'}</h5>
                    <p>${formatTime(from)} - ${formatTime(to)}</p>
                </div>
            `);
                                container.append(div);
                            }
                        });
                    }

                    function renderPlanPreview() {
                        const container = $('#planPreview');
                        container.empty();

                        $('#planContainer .plan-item').each(function() {
                            const membershipName = $(this).find('input').eq(0).val();
                            const duration = $(this).find('input').eq(1).val();
                            const period = $(this).find('select').eq(0).val();
                            const slot = $(this).find('select').eq(1).val();
                            const regFee = $(this).find('input').eq(2).val();
                            const coachingFee = $(this).find('input').eq(3).val();

                            if (membershipName && duration && period) {
                                const div = $(`
                <div class="court-slot-block mb-2">
                    <h5>${membershipName} - ${duration} ${period} <small>${slot || ''}</small></h5>
                    <p>Registration: ₹${regFee || 0}, Coaching: ₹${coachingFee || 0}</p>
                </div>
            `);
                                container.append(div);
                            }
                        });
                    }

                    // On form submit, update all previews
                    $('#venueForm').on('submit', function(e) {
                        e.preventDefault();
                        renderCourtSlots();
                        renderFacilityPreview();
                        renderSlotPreview();
                        renderPlanPreview();
                    });

                    // Also update previews when user types in inputs
                    $(document).on('input change', '#facilityContainer input', renderFacilityPreview);
                    $(document).on('input change', '#slotContainer input', renderSlotPreview);
                    $(document).on('change', '#planContainer input, #planContainer select', renderPlanPreview);

                    // Update previews when adding/removing items
                    $('#addFacility, #addSlot, #addPlan').on('click', function() {
                        renderFacilityPreview();
                        renderSlotPreview();
                        renderPlanPreview();
                    });

                    $(document).on('click', '.remove-facility, .remove-slot, .remove-plan', function() {
                        renderFacilityPreview();
                        renderSlotPreview();
                        renderPlanPreview();
                    });
                </script>


                <script>
                    // Add Facility
                    $('#addFacility').on('click', function() {
                        $('#facilityContainer').append(`
      <div class="form-row facility-item mb-2">
        <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Facility Name"></div>
        <div class="form-group col-md-4"><input type="text" class="form-control" placeholder="Type"></div>
        <div class="form-group col-md-3"><input type="number" class="form-control" placeholder="Rent"></div>
        <div class="form-group col-md-1 text-center"><button type="button" class="btn btn-danger btn-sm remove-facility"><i class="fas fa-trash"></i></button></div>
      </div>
    `);
                        renderFacilityPreview();
                    });

                    // Remove Facility with SweetAlert confirmation
                    $(document).on('click', '.remove-facility', function() {
                        let row = $(this).closest('.facility-item');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This facility will be deleted!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                                renderFacilityPreview();
                                Swal.fire('Deleted!', 'Facility has been removed.', 'success');
                            }
                        });
                    });

                    // Remove Slot with SweetAlert confirmation
                    $(document).on('click', '.remove-slot', function() {
                        let row = $(this).closest('.slot-item');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This slot will be deleted!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                                renderSlotPreview();
                                Swal.fire('Deleted!', 'Slot has been removed.', 'success');
                            }
                        });
                    });

                    // Remove Plan with SweetAlert confirmation
                    $(document).on('click', '.remove-plan', function() {
                        let row = $(this).closest('.plan-item');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This plan will be deleted!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove();
                                renderPlanPreview();
                                Swal.fire('Deleted!', 'Plan has been removed.', 'success');
                            }
                        });
                    });

                    // Form submission with SweetAlert success
                    $('#venueForm').on('submit', function(e) {
                        e.preventDefault();
                        renderCourtSlots();
                        renderFacilityPreview();
                        renderSlotPreview();
                        renderPlanPreview();

                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Venue details have been saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                </script>


</body>

</html>