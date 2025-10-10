<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title> Event Management</title>

  <!-- Bootstrap & Font Awesome -->
  <link rel="icon" type="image/jpg" sizes="32x32" href="<?php echo base_url('assets\Images\timeersbadmintonacademy_logo.jpg'); ?>">

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Custom Styles -->
  <style>
    body {
      background-color: #f4f6f8 !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
      font-style: normal;
      overflow-x: hidden;
    }

    /* Sidebar */
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

    /* Navbar */
    .navbar {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      color: white;
      padding: 10px;
      transition: left 0.3s ease-in-out, width 0.3s ease-in-out;
    }

    .navbar.sidebar-minimized {
      left: 60px;
    }

    /* Content */
    .content-wrapper {
      margin-left: 250px;
      padding: 40px 20px 20px 20px;
      transition: margin-left 0.3s ease-in-out;
    }

    .content-wrapper.minimized {
      margin-left: 60px;
    }

    /* Card Header */
    .card-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      color: #fff !important;
    }

    /* Buttons Primary */
    .btn-primary {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      border: none !important;
    }

    .btn-primary:hover {
      opacity: 0.9;
    }

    /* Event Card Styles */
    .event-card {
      transition: transform 0.3s, box-shadow 0.3s;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 25px;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .event-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      color: white;
      padding: 15px;
    }

    .event-icon {
      margin-right: 8px;
      width: 20px;
      text-align: center;
    }

    .event-detail {
      margin-bottom: 12px;
      display: flex;
      align-items: flex-start;
    }

    .event-title {
      font-size: 1.4rem;
      margin-bottom: 0;
      font-weight: 600;
    }

    .event-description {
      color: #555;
      line-height: 1.5;
      flex-grow: 1;
    }

    .participate-btn {
      padding: 8px 15px;
      font-weight: 600;
      margin-left: 5px;
    }

    .page-title {
      font-weight: 700;
      color: #333;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 2px solid #ff4040;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .filter-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    /* Modal Styles */
    .modal-content {
      border-radius: 12px;
      overflow: hidden;
    }

    .modal-header {
      background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
      color: white;
      border-bottom: none;
    }

    .modal-title {
      font-weight: 600;
    }

    .close {
      color: white;
      opacity: 0.8;
    }

    .close:hover {
      color: white;
      opacity: 1;
    }

    /* Add Event Button */
    .add-event-btn {
      padding: 10px 20px;
      font-weight: 600;
    }

    .card-footer button {
      width: 80% !important;
    }

    /* Mobile Responsive */
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
        padding: 80px 20px 20px 20px;
      }

      .page-title {
        flex-direction: column;
        align-items: flex-start;
      }

      .add-event-btn {
        margin-top: 15px;
      }
    }

    /* Fix for equal height cards */
    .events-container {
      display: flex;
      flex-wrap: wrap;
    }

    .events-container .col-lg-4,
    .events-container .col-md-6 {
      display: flex;
      margin-bottom: 25px;
    }

    .event-card .card-body {
      flex-grow: 1;
    }

    .card-footer {
      background: white;
      border-top: 1px solid rgba(0, 0, 0, 0.1);

    }


    .event .card-footer button {
      font-size: 10px;
      padding: 5px !important;
      width: 80px;
      height: 40px;
    }

    /* Ensure columns stretch evenly */
    .events-container {
      display: flex;
      flex-wrap: wrap;
    }

    .events-container .col-lg-4,
    .events-container .col-md-6 {
      display: flex;
      align-items: stretch;
      /* makes all cards equal height */
    }

    /* Make cards fill their column */
    .event-card {
      display: flex;
      flex-direction: column;
      flex: 1 1 auto;
      /* <-- important */
    }

    /* Grow body so footer sticks to bottom */
    .event-card .card-body {
      flex-grow: 1;
    }

    .fixed-title {
      min-height: 50px;
      /* ensures space */
      max-height: 60px;
      /* avoids making box too tall */
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 0 8px;
      overflow: hidden;
    }

    .event-title {
      font-size: clamp(1rem, 1.2vw, 1.2rem);
      /* responsive font size */
      line-height: 1.2em;
      font-weight: 600;
      margin: 0;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
    }


    .fixed-description {
      height: 80px;
      /* Description box height */
      overflow: hidden;
    }

    .fixed-field {
      height: 30px;
      /* Each detail row height */
      display: flex;
      align-items: center;
      overflow: hidden;
    }

    .event-card {
      display: flex;
      flex-direction: column;
    }
  </style>
</head>

<body>


  <!-- Sidebar -->
  <?php $this->load->view('superadmin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('superadmin/Include/Navbar') ?>

  <!-- Main Content Wrapper -->
  <div class="event content-wrapper" id="contentWrapper">
    <div class="content">
      <div class="container-fluid">
        <div class="container">
          <div class="page-title">
            <h1><i class="fas fa-calendar-alt mr-2"></i>All Events</h1>
            <button type="button" class="btn btn-primary add-event-btn" data-toggle="modal" data-target="#addEventModal">
              <i class="fas fa-plus-circle mr-2"></i>Add Event
            </button>
          </div>

          <!-- Filter Section -->
          <div class="filter-container">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="searchEvents"><i class="fas fa-search"></i> Search Events</label>
                  <input type="text" class="form-control" id="searchEvents" placeholder="Search by event name, description...">
                </div>
              </div>
              <!-- <div class="col-md-3">
                <div class="form-group">
                  <label for="filterDate"><i class="fas fa-filter"></i> Filter by Date</label>
                  <select class="form-control" id="filterDate">
                    <option value="all">All Dates</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="past">Past Events</option>
                  </select>
                </div>
              </div> -->
              <div class="col-md-3">
                <div class="form-group">
                  <label for="sortEvents"><i class="fas fa-sort"></i> Sort By</label>
                  <select class="form-control" id="sortEvents">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <!-- Events Grid - FIXED: Removed duplicate row class -->
          <div class="row events-container">
            <?php foreach ($events as $event): ?>
              <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                <div class="card event-card w-100">
                  <div class="event-header fixed-title">
                    <h3 class="event-title text-truncate" data-id="<?= $event->id ?>"><?= $event->name ?></h3>
                  </div>
                  <div class="card-body d-flex flex-column">
                    <div class="event-description fixed-description">
                      <?= $event->description ?>
                    </div>
                    <div class="event-detail fixed-field"><i class="fas fa-calendar-day event-icon"></i> <span>Date: <?= $event->date ?></span></div>
                    <div class="event-detail fixed-field"><i class="fas fa-clock event-icon"></i> <span>Time: <?= $event->time ?></span></div>
                    <div class="event-detail fixed-field"><i class="fas fa-money-bill-wave event-icon"></i> <span>Fee: Rs <?= $event->fee ?></span></div>
                    <div class="event-detail fixed-field"><i class="fas fa-users event-icon"></i> <span>Max Participants: <?= $event->max_participants ?></span></div>
                    <div class="event-detail fixed-field">
                      <i class="fas fa-map-marker-alt event-icon"></i>
                      <span>Venue: <?= $event->venue ?></span>
                    </div>
                  </div>


                  <div class="card-footer d-flex justify-content-center">
                    <button class="btn btn-primary participate-btn mx-2">Send Form</button>
                    <button class="btn btn-primary participate-btn view-participants-btn mx-2" data-id="<?= $event->id ?>">
                      View Participant
                    </button>
                    <button class="btn btn-danger delete-btn mx-2" data-id="<?= $event->id ?>">
                      Delete
                    </button>
                  </div>

                </div>
              </div>
            <?php endforeach; ?>
          </div>


          <!-- Pagination -->
          <nav aria-label="Event pagination" class="mt-4">
            <ul class="pagination justify-content-center" id="pagination"></ul>
          </nav>
        </div>
      </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addEventModalLabel">
              <i class="fas fa-plus-circle mr-2"></i>Add New Event
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form id="eventForm" class="needs-validation" novalidate>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="eventName"><i class="fas fa-tag"></i> Event Name *</label>
                  <input type="text" class="form-control" id="eventName" placeholder="Enter event name" required>
                  <div class="invalid-feedback">Please enter event name</div>
                </div>

                <div class="form-group col-md-12">
                  <label for="eventDescription"><i class="fas fa-align-left"></i> Description *</label>
                  <textarea class="form-control" id="eventDescription" rows="3" placeholder="Enter event description" required></textarea>
                  <div class="invalid-feedback">Please enter description</div>
                </div>

                <div class="form-group col-md-6">
                  <label for="eventDate"><i class="fas fa-calendar-day"></i> Date *</label>
                  <input type="date" class="form-control" id="eventDate" required>
                  <div class="invalid-feedback">Please select a date</div>
                </div>

                <div class="form-group col-md-6">
                  <label for="eventTime"><i class="fas fa-clock"></i> Time *</label>
                  <input type="time" class="form-control" id="eventTime" required>
                  <div class="invalid-feedback">Please select time</div>
                </div>

                <div class="form-group col-md-6">
                  <label for="eventFee"><i class="fas fa-money-bill-wave"></i> Participation Fee *</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rs</span>
                    </div>
                    <input type="number" class="form-control" id="eventFee" placeholder="0.00" min="0" step="0.01" required>
                    <div class="invalid-feedback">Please enter participation fee</div>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <label for="maxParticipants"><i class="fas fa-users"></i> Maximum Participants *</label>
                  <input type="number" class="form-control" id="maxParticipants" placeholder="Enter maximum participants" min="1" required>
                  <div class="invalid-feedback">Please enter max participants</div>
                </div>

                <div class="form-group col-md-6">
                  <label for="eventVenue"><i class="fas fa-map-marker-alt"></i> Venue *</label>
                  <input type="text" class="form-control" id="eventVenue" placeholder="Enter venue" required>
                  <div class="invalid-feedback">Please enter venue</div>
                </div>

              </div>
            </form>
          </div>



          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="saveEventBtn" disabled>
              <i class="fas fa-save mr-2"></i>Save Event
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap + jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        // Search functionality
        $('#searchEvents').on('keyup', function() {
          const value = $(this).val().toLowerCase();
          $('.event-card').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });

        // Save event button handler
        $('#saveEventBtn').click(function() {
          const eventData = {
            name: $('#eventName').val(),
            description: $('#eventDescription').val(),
            date: $('#eventDate').val(),
            time: $('#eventTime').val(),
            fee: $('#eventFee').val(),
            maxParticipants: $('#maxParticipants').val(),
            venue: $('#eventVenue').val() // <-- new

          };

          $.ajax({
            url: "<?= base_url('superadmin/saveEvent') ?>",
            type: "POST",
            data: eventData,
            dataType: "json",
            success: function(response) {
              if (response.status === "success") {
                Swal.fire({
                  icon: 'success',
                  title: 'Event Registered!',
                  text: 'Your event has been successfully saved.',
                  confirmButtonColor: '#ff4040'
                }).then(() => {
                  location.reload(); // refresh to see event
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Failed',
                  text: 'Event could not be saved. Try again.',
                  confirmButtonColor: '#ff4040'
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error saving event. Please check console.',
                confirmButtonColor: '#ff4040'
              });
            }
          });
        });

        // Reset form
        $('#eventForm')[0].reset();
      });

      // Button click handlers


      // JS Validation
      document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("eventForm");
        const saveBtn = document.getElementById("saveEventBtn");

        function validateForm() {
          saveBtn.disabled = !form.checkValidity();
        }

        form.querySelectorAll("input, textarea").forEach((el) => {
          el.addEventListener("input", validateForm);
          el.addEventListener("change", validateForm);
        });

        saveBtn.addEventListener("click", function() {
          if (!form.checkValidity()) {
            form.classList.add("was-validated");
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Event Saved!',
              text: 'Your event has been created successfully.',
              confirmButtonColor: '#ff4040'
            }).then(() => {
              $("#addEventModal").modal("hide");
              form.reset();
              saveBtn.disabled = true;
              form.classList.remove("was-validated");
            });
          }
        });
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const cardsPerPage = 6;
        const cards = document.querySelectorAll(".event-card");
        const totalCards = cards.length;
        const totalPages = Math.ceil(totalCards / cardsPerPage);
        const pagination = document.getElementById("pagination");

        function showPage(page) {
          // hide all cards first
          cards.forEach((card, index) => {
            card.style.display =
              index >= (page - 1) * cardsPerPage && index < page * cardsPerPage ?
              "block" :
              "none";
          });

          // update pagination
          pagination.innerHTML = "";

          // Previous button
          const prevItem = document.createElement("li");
          prevItem.className = "page-item " + (page === 1 ? "disabled" : "");
          prevItem.innerHTML = `<a class="page-link" href="#">Previous</a>`;
          prevItem.onclick = (e) => {
            e.preventDefault();
            if (page > 1) showPage(page - 1);
          };
          pagination.appendChild(prevItem);

          // Page numbers
          for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = "page-item " + (i === page ? "active" : "");
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.onclick = (e) => {
              e.preventDefault();
              showPage(i);
            };
            pagination.appendChild(li);
          }

          // Next button
          const nextItem = document.createElement("li");
          nextItem.className =
            "page-item " + (page === totalPages ? "disabled" : "");
          nextItem.innerHTML = `<a class="page-link" href="#">Next</a>`;
          nextItem.onclick = (e) => {
            e.preventDefault();
            if (page < totalPages) showPage(page + 1);
          };
          pagination.appendChild(nextItem);
        }

        // initialize first page
        if (totalCards > 0) {
          showPage(1);
        }
      });
    </script>
    <script>
      $(document).on('click', '.delete-btn', function() {
        let eventId = $(this).data('id');
        let card = $(this).closest('.card'); // remove card on success

        Swal.fire({
          title: 'Are you sure?',
          text: "This event will be permanently deleted!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ff4040',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "<?= base_url('EventController/deleteEvent/') ?>" + eventId,
              type: "POST",
              dataType: "json",
              success: function(response) {
                if (response.status === 'success') {
                  card.remove();
                  Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The event has been deleted.',
                    confirmButtonColor: '#ff4040'
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: 'Error deleting event.',
                    confirmButtonColor: '#ff4040'
                  });
                }
              },
              error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Something went wrong with the request.',
                  confirmButtonColor: '#ff4040'
                });
              }
            });
          }
        });
      });
    </script>
    <script>
      $(document).on('click', '.participate-btn', function() {
        const buttonText = $(this).text().trim();

        if (buttonText === 'Send Form') {
          // Get event ID from data-id attribute
          const eventId = $(this).closest('.event-card').find('.event-title').data('id');
          const shareLink = "<?= base_url('ParticipantController/form') ?>?event=" + eventId;


          Swal.fire({
            title: 'Share Form',
            html: `<input type="text" id="shareLinkInput" class="swal2-input" value="${shareLink}" readonly>`,
            icon: 'info',
            confirmButtonColor: '#ff4040',
            showCancelButton: true,
            cancelButtonText: 'Copy Link',
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.cancel) {
              const copyText = document.getElementById("shareLinkInput");
              copyText.select();
              copyText.setSelectionRange(0, 99999);
              document.execCommand("copy");
              Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Link copied to clipboard.',
                confirmButtonColor: '#ff4040'
              });
            }
          });
        }
      });
    </script>
    <script>
      $(document).on('click', '.view-participants-btn', function() {
        let eventId = $(this).data('id');
        window.location.href = "<?= base_url('superadmin/EventAndNotice/view_participants/') ?>" + eventId;
      });


      // Sidebar toggle functionality
      $('#sidebarToggle').on('click', function() {
        if ($(window).width() <= 576) {
          $('#sidebar').toggleClass('active');
          $('.navbar').toggleClass('sidebar-hidden', !$('#sidebar').hasClass('active'));
        } else {
          const isMinimized = $('#sidebar').toggleClass('minimized').hasClass('minimized');
          $('.navbar').toggleClass('sidebar-minimized', isMinimized);
          $('#contentWrapper').toggleClass('minimized', isMinimized);
        }
      });
    </script>
</body>

</html>