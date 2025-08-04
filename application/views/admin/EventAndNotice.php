<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Event & Notice Management</title>
  <!-- Bootstrap & Font Awesome -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #e9ecef !important;
      margin: 0;
      font-family: 'Montserrat', serif !important;
      font-style: normal;
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
    .filter-wrapper {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 10px;
    }
    .participate-btn {
      background: #ffffff;
      color: #000000;
      border: 1px solid #ced4da;
      border-radius: 8px;
      padding: 8px 15px;
      font-size: 15px;
      font-style: normal;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .participate-btn:hover {
      background: #f0f0f0;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .center-card {
      background-color: #ffffff;
      border-radius: 1rem;
      padding: 1rem;
      width: 100%;
      max-width: 22rem;
      border-left: 2px solid #ff4040;
      position: relative;
      /* margin: 0.5rem; */
      color: #333;
      font-size: 0.875rem;
      font-style: normal;
      text-align: left;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: auto;
      min-height: 10rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .center-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .card-icon {
      position: absolute;
      top: 0.75rem;
      right: 0.75rem;
      font-size: 1.125rem;
      color: #333;
    }
    .card-details {
      padding-top: 0.25rem;
    }
    .card-details p {
      margin: 0.3rem 0;
      line-height: 1.4;
      color: #333;
      font-style: normal;
    }
    .card-details p:first-child {
      font-size: 1rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    .card-details p span {
      font-weight: 500;
      color: #444;
    }
    .view-btn {
      margin-top: 0.5rem;
      padding: 0.4rem 1rem;
      border: none;
      background-color: #eee;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      font-weight: bold;
      font-style: normal;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .view-btn:hover {
      background-color: #ddd;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .add-center-btn {
      color: black;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      width: 180px;
      font-size: 15px;
      font-style: normal;
      margin: 25px auto;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }
    .add-center-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .button-container {
      display: flex;
      justify-content: center;
    }
    .modal-content {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 20px;
      max-width: 500px;
      margin: auto;
      border: 2px solid #007bff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      position: relative;
    }
    .modal-content h3 {
      text-align: center;
      font-weight: 600;
      margin-bottom: 15px;
      color: #333;
      font-style: normal;
    }
    .modal-close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #333;
      cursor: pointer;
      transition: color 0.3s ease, transform 0.2s ease;
    }
    .modal-close-btn:hover {
      color: #ff4040;
      transform: scale(1.2);
    }
    .modal-backdrop.show {
      backdrop-filter: blur(6px);
    }
    .form-group {
      margin-bottom: 0.75rem;
    }
    .form-group label {
      font-weight: 500;
      font-size: 14px;
      color: #444;
      margin-bottom: 4px;
      display: block;
      font-style: normal;
    }
    .form-control, .form-control textarea {
      height: 38px;
      border-radius: 8px;
      font-size: 13px;
      border: 1px solid #ced4da;
      font-style: normal;
      transition: border-color 0.3s ease;
    }
    .form-control:focus, .form-control textarea:focus {
      border-color: #ff4040;
      box-shadow: 0 0 5px rgba(255, 64, 64, 0.3);
    }
    .form-control::placeholder {
      color: #999;
    }
    .submit-btn, .close-btn, .update-btn, .delete-btn {
      border-radius: 8px;
      padding: 8px;
      font-weight: 600;
      width: 120px;
      margin: 6px 5px;
      border: none;
      color: #000000;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
      transition: background 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
      font-style: normal;
    }
    .submit-btn {
      background: #ffffff;
    }
    .submit-btn:hover {
      background: #f0f0f0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .close-btn {
      background: #e0e0e0;
      color: #333;
    }
    .close-btn:hover {
      background: #d0d0d0;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .update-btn {
      color: white;
    }
    .update-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .delete-btn {
      color: white;
    }
    .delete-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .invalid-feedback {
      color: #dc3545;
      font-size: 12px;
      margin-top: 4px;
    }
    .blur {
      filter: blur(5px);
      transition: filter 0.3s ease;
    }
    /* Responsive Design */
    @media (max-width: 576px) {
      .content-wrapper {
        margin-left: 0;
        padding: 10px;
      }
      .center-card {
        padding: 0.75rem;
        max-width: 100%;
        margin: 0.3125rem;
        font-size: 0.8125rem;
      }
      .card-details p:first-child {
        font-size: 0.9375rem;
      }
      .view-btn {
        font-size: 0.8125rem;
        padding: 0.3rem 0.75rem;
      }
      .add-center-btn, .participate-btn {
        width: 120px;
        font-size: 12px;
        padding: 6px 10px;
      }
      .modal-content {
        max-width: 90%;
        padding: 12px;
      }
      .form-row {
        flex-direction: column;
        gap: 8px;
      }
      .form-control, .form-control textarea {
        height: 34px;
        font-size: 12px;
      }
      .form-group label {
        font-size: 13px;
      }
      .submit-btn, .close-btn, .update-btn, .delete-btn {
        width: 100px;
        padding: 6px;
        font-size: 12px;
      }
      .modal-content h3 {
        font-size: 1rem;
      }
    }
    @media (min-width: 577px) and (max-width: 768px) {
      .content-wrapper {
        margin-left: 0;
        padding: 15px;
      }
      .content-wrapper.minimized {
        margin-left: 0;
      }
      .center-card {
        max-width: 18rem;
        margin: 0.5rem;
        font-size: 0.875rem;
      }
      .add-center-btn, .participate-btn {
        width: 140px;
        font-size: 13px;
      }
      .modal-content {
        max-width: 90%;
        padding: 15px;
      }
      .form-row {
        gap: 10px;
      }
      .submit-btn, .close-btn, .update-btn, .delete-btn {
        width: 100px;
        font-size: 12px;
      }
    }
    @media (min-width: 769px) and (max-width: 991px) {
      .content-wrapper {
        margin-left: 200px;
        padding: 15px;
      }
      .content-wrapper.minimized {
        margin-left: 60px;
      }
      .center-card {
        max-width: 18rem;
        margin: 0.5rem;
        font-size: 0.875rem;
      }
      .add-center-btn, .participate-btn {
        width: 150px;
        font-size: 14px;
      }
      .modal-content {
        max-width: 450px;
        padding: 15px;
      }
    }
    @media (min-width: 992px) {
      .center-card {
        max-width: 22rem;
      }
      .add-center-btn, .participate-btn {
        width: 180px;
        font-size: 15px;
      }
      .modal-content {
        max-width: 500px;
      }
    }
    @media (hover: none) {
      .view-btn:hover,
      .add-center-btn:hover,
      .participate-btn:hover,
      .submit-btn:hover,
      .update-btn:hover,
      .delete-btn:hover,
      .close-btn:hover,
      .modal-close-btn:hover {
        background-color: inherit;
        transform: none;
        box-shadow: none;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <?php $this->load->view('admin/Include/Sidebar') ?>
  <!-- Navbar -->
  <?php $this->load->view('admin/Include/Navbar') ?>

  <!-- Main Content -->
  <div class="content-wrapper" id="contentWrapper">
    <div class="content" id="mainContent">
      <div class="container-fluid">
        <!-- Participate Button -->
        <div class="filter-wrapper">
          <button type="button" class="participate-btn" data-toggle="modal" data-target="#participateModal">
            <i class="fas fa-user-plus me-2"></i> Participate
          </button>
        </div>
        <div class="row justify-content-start">
          <div class="col-12">
            <div class="row justify-content-start" id="eventRow">
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                <div class="center-card" id="card-1">
                  <i class="fas fa-calendar-alt card-icon"></i>
                  <div class="card-details">
                    <p><span>Title:</span> Independence day</p>
                    <p><span>Center:</span> ABC</p>
                    <p><span>Date:</span> 15/08/2025</p>
                    <p><span>Time:</span> 6 to 7 AM</p>
                    <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                  </div>
                  <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-event-id="card-1" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                <div class="center-card" id="card-2">
                  <i class="fas fa-calendar-alt card-icon"></i>
                  <div class="card-details">
                    <p><span>Title:</span> Independence day</p>
                    <p><span>Center:</span> ABC</p>
                    <p><span>Date:</span> 15/08/2025</p>
                    <p><span>Time:</span> 6 to 7 AM</p>
                    <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                  </div>
                  <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-event-id="card-2" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
                </div>
              </div>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
                <div class="center-card" id="card-3">
                  <i class="fas fa-calendar-alt card-icon"></i>
                  <div class="card-details">
                    <p><span>Title:</span> Independence day</p>
                    <p><span>Center:</span> ABC</p>
                    <p><span>Date:</span> 15/08/2025</p>
                    <p><span>Time:</span> 6 to 7 AM</p>
                    <p><span>Description:</span> Shantinagar, Nashik, Maharashtra - 456789</p>
                  </div>
                  <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-event-id="card-3" data-title="Independence day" data-center="ABC" data-date="15/08/2025" data-time="6 to 7 AM" data-description="Shantinagar, Nashik, Maharashtra - 456789">View</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Add Button -->
        <div class="button-container">
          <button class="add-center-btn" data-toggle="modal" data-target="#addEventModal">Add Event/Notice</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Event Modal -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="addEventLabel">Add Event/Notice</h3>
        <form id="eventForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="title">Title <span class="text-danger">*</span></label>
              <input type="text" id="title" name="title" class="form-control" placeholder="Enter title" required />
              <div class="invalid-feedback">Please enter a title.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="center">Center <span class="text-danger">*</span></label>
              <input type="text" id="center" name="center" class="form-control" placeholder="Enter center" required />
              <div class="invalid-feedback">Please enter a center.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="date">Date <span class="text-danger">*</span></label>
              <input type="date" id="date" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="time">Time <span class="text-danger">*</span></label>
              <input type="time" id="time" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select a time.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="description">Description <span class="text-danger">*</span></label>
              <textarea id="description" name="description" class="form-control" placeholder="Enter description" required></textarea>
              <div class="invalid-feedback">Please enter a description.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="submit-btn btn">Submit</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- View Event Modal -->
  <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="viewEventLabel">Event/Notice Details</h3>
        <form id="viewEventForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="viewTitle">Title <span class="text-danger">*</span></label>
              <input type="text" id="viewTitle" name="title" class="form-control" placeholder="Enter title" required />
              <div class="invalid-feedback">Please enter a title.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewCenter">Center <span class="text-danger">*</span></label>
              <input type="text" id="viewCenter" name="center" class="form-control" placeholder="Enter center" required />
              <div class="invalid-feedback">Please enter a center.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewDate">Date <span class="text-danger">*</span></label>
              <input type="date" id="viewDate" name="date" class="form-control" required />
              <div class="invalid-feedback">Please select a date.</div>
            </div>
            <div class="form-group col-md-6">
              <label for="viewTime">Time <span class="text-danger">*</span></label>
              <input type="time" id="viewTime" name="time" class="form-control" required />
              <div class="invalid-feedback">Please select a time.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="viewDescription">Description <span class="text-danger">*</span></label>
              <textarea id="viewDescription" name="description" class="form-control" placeholder="Enter description" required></textarea>
              <div class="invalid-feedback">Please enter a description.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="update-btn btn">Update</button>
            <button type="button" class="delete-btn btn">Delete</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Participate Modal -->
  <div class="modal fade" id="participateModal" tabindex="-1" aria-labelledby="participateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button type="button" class="modal-close-btn" data-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        <h3 id="participateLabel">Participate in Event</h3>
        <form id="participateForm" novalidate>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="studentName">Student Name <span class="text-danger">*</span></label>
              <select id="studentName" name="studentName" class="form-control" placeholder="Select student" required>
                <option value="">Select Student</option>
                <option>Jane Doe</option>
                <option>John Smith</option>
              </select>
              <div class="invalid-feedback">Please select a student.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="eventTitle">Event Title <span class="text-danger">*</span></label>
              <select id="eventTitle" name="eventTitle" class="form-control" placeholder="Select event" required>
                <option value="">Select Event</option>
                <option>Independence day</option>
              </select>
              <div class="invalid-feedback">Please select an event.</div>
            </div>
            <div class="form-group col-md-12">
              <label for="paymentMode">Payment Mode <span class="text-danger">*</span></label>
              <div>
                <div class="form-check">
                  <input type="radio" id="cash" name="paymentMode" class="form-check-input" value="Cash" required>
                  <label class="form-check-label" for="cash">Cash</label>
                </div>
                <div class="form-check">
                  <input type="radio" id="online" name="paymentMode" class="form-check-input" value="Online">
                  <label class="form-check-label" for="online">Online</label>
                </div>
              </div>
              <div class="invalid-feedback">Please select a payment mode.</div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="submit-btn btn">Confirm</button>
            <button type="button" class="close-btn btn" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap + jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Form Submission, View Modal, Update, Delete, and Participate Handling -->
  <script>
    (function () {
      'use strict';
      let cardCounter = 4;
      const eventForm = document.getElementById('eventForm');
      const participateForm = document.getElementById('participateForm');
      const viewForm = document.getElementById('viewEventForm');
      if (!eventForm) {
        console.error('Event form not found!');
        return;
      }
      if (!participateForm) {
        console.error('Participate form not found!');
        return;
      }
      if (!viewForm) {
        console.error('View form not found!');
        return;
      }

      // Store initial cards for future filtering compatibility
      let initialCards = Array.from(document.querySelectorAll('#eventRow .col-12')).map(card => card.outerHTML);

      // Event form submission
      eventForm.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (!eventForm.checkValidity()) {
          eventForm.classList.add('was-validated');
          return;
        }

        // Get form values
        const title = document.getElementById('title').value.trim();
        const center = document.getElementById('center').value.trim();
        const dateRaw = document.getElementById('date').value;
        const timeRaw = document.getElementById('time').value;
        const description = document.getElementById('description').value.trim();

        // Format date to DD/MM/YYYY
        const dateObj = new Date(dateRaw);
        const date = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        // Create new card
        const newCard = `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="center-card" id="card-${cardCounter}">
              <i class="fas fa-calendar-alt card-icon"></i>
              <div class="card-details">
                <p><span>Title:</span> ${title}</p>
                <p><span>Center:</span> ${center}</p>
                <p><span>Date:</span> ${date}</p>
                <p><span>Time:</span> ${time}</p>
                <p><span>Description:</span> ${description}</p>
              </div>
              <button class="view-btn" data-toggle="modal" data-target="#viewEventModal" data-event-id="card-${cardCounter}" data-title="${title}" data-center="${center}" data-date="${date}" data-time="${time}" data-description="${description}">View</button>
            </div>
          </div>
        `;

        // Append new card to the row
        const eventRow = document.getElementById('eventRow');
        if (eventRow) {
          eventRow.insertAdjacentHTML('beforeend', newCard);
          initialCards.push(newCard);
          cardCounter++;
          // Update event dropdown in participate modal
          const eventSelect = document.getElementById('eventTitle');
          const newOption = document.createElement('option');
          newOption.value = title;
          newOption.textContent = title;
          eventSelect.appendChild(newOption);
        } else {
          console.error('eventRow element not found!');
        }

        // Reset form and close modal
        eventForm.reset();
        eventForm.classList.remove('was-validated');
        $('#addEventModal').modal('hide');
      });

      // Ensure validation feedback on input for event form
      eventForm.addEventListener('input', function () {
        if (eventForm.checkValidity()) {
          eventForm.classList.remove('was-validated');
        }
      });

      // Participate form submission
      participateForm.addEventListener('submit', function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (!participateForm.checkValidity()) {
          participateForm.classList.add('was-validated');
          return;
        }

        const studentName = document.getElementById('studentName').value;
        const eventTitle = document.getElementById('eventTitle').value;
        const paymentMode = document.querySelector('input[name="paymentMode"]:checked').value;

        // Perform action: Display confirmation and log participation
        alert(`Participation confirmed for ${studentName} in the ${eventTitle} event with payment mode: ${paymentMode}`);
        console.log(`Student ${studentName} registered for ${eventTitle} event with payment mode: ${paymentMode} on ${new Date().toLocaleString('en-IN', { timeZone: 'Asia/Kolkata' })}`);

        // Reset form and close modal
        participateForm.reset();
        participateForm.classList.remove('was-validated');
        $('#participateModal').modal('hide');
      });

      // Ensure validation feedback on input for participate form
      participateForm.addEventListener('input', function () {
        if (participateForm.checkValidity()) {
          participateForm.classList.remove('was-validated');
        }
      });

      // Handle view button clicks
      $('#viewEventModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const eventId = button.data('event-id');
        const title = button.data('title');
        const center = button.data('center');
        const date = button.data('date');
        const time = button.data('time');
        const description = button.data('description');

        const modal = $(this);
        modal.find('#viewEventLabel').text(`Event/Notice Details - ${title}`);
        modal.find('#viewTitle').val(title);
        modal.find('#viewCenter').val(center);
        modal.find('#viewDate').val(new Date(date.split('/').reverse().join('-')).toISOString().split('T')[0]);
        modal.find('#viewTime').val(time.split(' to ')[0].trim());
        modal.find('#viewDescription').val(description);
        modal.find('.update-btn').data('event-id', eventId);
        modal.find('.delete-btn').data('event-id', eventId);
      });

      // Handle update form submission
      viewForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();

        if (!viewForm.checkValidity()) {
          viewForm.classList.add('was-validated');
          return;
        }

        const eventId = $(viewForm).find('.update-btn').data('event-id');
        const title = document.getElementById('viewTitle').value.trim();
        const center = document.getElementById('viewCenter').value.trim();
        const dateRaw = document.getElementById('viewDate').value;
        const timeRaw = document.getElementById('viewTime').value;
        const description = document.getElementById('viewDescription').value.trim();

        // Format date to DD/MM/YYYY
        const dateObj = new Date(dateRaw);
        const date = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;

        // Format time to "H to H+1 AM/PM"
        const [hours, minutes] = timeRaw.split(':');
        const hourNum = parseInt(hours, 10);
        const period = hourNum >= 12 ? 'PM' : 'AM';
        const displayHour = hourNum % 12 || 12;
        const nextHour = (hourNum + 1) % 12 || 12;
        const time = `${displayHour} to ${nextHour} ${period}`;

        // Update the card
        const card = document.getElementById(eventId);
        if (card) {
          card.querySelector('p:nth-child(1) span').nextSibling.textContent = ` ${title}`;
          card.querySelector('p:nth-child(2) span').nextSibling.textContent = ` ${center}`;
          card.querySelector('p:nth-child(3) span').nextSibling.textContent = ` ${date}`;
          card.querySelector('p:nth-child(4) span').nextSibling.textContent = ` ${time}`;
          card.querySelector('p:nth-child(5) span').nextSibling.textContent = ` ${description}`;
          card.querySelector('.view-btn').setAttribute('data-title', title);
          card.querySelector('.view-btn').setAttribute('data-center', center);
          card.querySelector('.view-btn').setAttribute('data-date', date);
          card.querySelector('.view-btn').setAttribute('data-time', time);
          card.querySelector('.view-btn').setAttribute('data-description', description);

          // Update initialCards
          const cardIndex = initialCards.findIndex(c => c.includes(`id="${eventId}"`));
          if (cardIndex !== -1) {
            initialCards[cardIndex] = card.parentElement.outerHTML;
          }

          // Update event dropdown in participate modal
          const eventSelect = document.getElementById('eventTitle');
          const options = Array.from(eventSelect.options);
          const optionIndex = options.findIndex(opt => opt.value === title);
          if (optionIndex !== -1) {
            eventSelect.options[optionIndex].textContent = title;
          } else {
            const newOption = document.createElement('option');
            newOption.value = title;
            newOption.textContent = title;
            eventSelect.appendChild(newOption);
          }
        }

        // Reset form and close modal
        viewForm.classList.remove('was-validated');
        $('#viewEventModal').modal('hide');
      });

      // Ensure validation feedback on input for view form
      viewForm.addEventListener('input', function () {
        if (viewForm.checkValidity()) {
          viewForm.classList.remove('was-validated');
        }
      });

      // Handle delete button click
      viewForm.querySelector('.delete-btn').addEventListener('click', function () {
        const eventId = $(this).data('event-id');
        const card = document.getElementById(eventId);
        if (card) {
          const cardContainer = card.parentElement;
          cardContainer.remove();
          // Update initialCards
          initialCards = initialCards.filter(c => !c.includes(`id="${eventId}"`));
          $('#viewEventModal').modal('hide');
        }
      });

      // Sidebar toggle functionality
      document.addEventListener('DOMContentLoaded', () => {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const contentWrapper = document.getElementById('contentWrapper');

        if (sidebarToggle) {
          sidebarToggle.addEventListener('click', () => {
            if (window.innerWidth <= 576) {
              // Mobile behavior
              if (sidebar) {
                sidebar.classList.toggle('active');
              }
            } else {
              // Desktop behavior - minimize/maximize
              if (sidebar && contentWrapper) {
                const isMinimized = sidebar.classList.toggle('minimized');
                contentWrapper.classList.toggle('minimized', isMinimized);
              }
            }
          });
        }
      });

      // Modal blur effect
      $('#addEventModal, #viewEventModal, #participateModal').on('show.bs.modal', function () {
        document.getElementById('mainContent').classList.add('blur');
      });

      $('#addEventModal, #viewEventModal, #participateModal').on('hidden.bs.modal', function () {
        document.getElementById('mainContent').classList.remove('blur');
      });
    })();
  </script>
</body>
</html>