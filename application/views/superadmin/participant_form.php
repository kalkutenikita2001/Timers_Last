<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            font-family: 'Arial', sans-serif;
        }

        .registration-card {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            transition: transform 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-5px);
        }

        .registration-card h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ff4040;
            font-weight: bold;
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff4040 0%, #470000 100%) !important;
            border: none;
            width: 100%;
        }

        .form-control:focus {
            border-color: #ff4040;
            box-shadow: 0 0 5px rgba(255, 64, 64, 0.5);
        }
    </style>
</head>

<body>
    <div class="registration-card">
        <h2>Register for Event</h2>
        <form id="participantForm">
            <div class="form-group">
                <label for="participantName">Name *</label>
                <input type="text" class="form-control" id="participantName" name="name" required>
            </div>

            <div class="form-group">
                <label for="eventSelect">Event *</label>
                <select class="form-control" id="eventSelect" name="event" required>
                    <option value="">Select Event</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event->id ?>" <?= ($event_id == $event->id) ? 'selected' : '' ?>>
                            <?= $event->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="participantEmail">Email *</label>
                <input type="email" class="form-control" id="participantEmail" name="email" required>
            </div>

            <div class="form-group">
                <label for="participantPhone">Phone *</label>
                <input type="text" class="form-control" id="participantPhone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="participantAddress">Address *</label>
                <textarea class="form-control" id="participantAddress" name="address" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function validateForm() {
            const name = $('#participantName').val().trim();
            const email = $('#participantEmail').val().trim();
            const phone = $('#participantPhone').val().trim();
            const address = $('#participantAddress').val().trim();
            const event = $('#eventSelect').val();

            const nameRegex = /^[A-Za-z\s]{3,}$/;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^[0-9]{10}$/;

            if (!nameRegex.test(name)) {
                Swal.fire("Invalid Name", "Name must be at least 3 characters and contain only letters.", "warning");
                return false;
            }

            if (!emailRegex.test(email)) {
                Swal.fire("Invalid Email", "Please enter a valid email address.", "warning");
                return false;
            }

            if (!phoneRegex.test(phone)) {
                Swal.fire("Invalid Phone", "Phone number must be 10 digits.", "warning");
                return false;
            }

            if (address.length < 10) {
                Swal.fire("Invalid Address", "Address must be at least 10 characters long.", "warning");
                return false;
            }

            if (!event) {
                Swal.fire("Event Required", "Please select an event.", "warning");
                return false;
            }

            return true;
        }

        $('#participantForm').submit(function(e) {
            e.preventDefault();
            if (!validateForm()) return;

            const formData = $(this).serialize();

            $.ajax({
                url: '<?= base_url("ParticipantController/save") ?>',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registered!',
                            text: 'You have successfully registered for the event.',
                            confirmButtonColor: '#ff4040'
                        });
                        $('#participantForm')[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Registration failed. Try again.',
                            confirmButtonColor: '#ff4040'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Something went wrong.',
                        confirmButtonColor: '#ff4040'
                    });
                }
            });
        });

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const eventId = urlParams.get('event');
            if (eventId) {
                $('#eventSelect').val(eventId);
            }
        });
    </script>
</body>

</html>