<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body style="font-family: Arial, sans-serif; text-align: center; padding: 40px;">
    <h2>
        Marking Attendance for 
        <span style="color: #4CAF50;"><?= $student_name ?></span>
    </h2>
    <p id="status" style="font-size: 18px; color: #555;">Fetching your location...</p>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                document.getElementById("status").innerHTML = 
                    `Your Location: <strong>${lat.toFixed(6)}, ${lng.toFixed(6)}</strong><br>Checking distance...`;

                fetch("<?= base_url('Student_controller/mark_with_location') ?>", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        token: "<?= $token ?>",
                        latitude: lat,
                        longitude: lng
                    })
                })
                .then(res => res.json())
                .then(data => {
                    let locationInfo = `
                        <p><strong>Your Location:</strong> ${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
                      
                    `;

                    if (data.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Attendance Marked",
                            html: `<p><strong>${data.message}</strong></p>${locationInfo}`,
                            confirmButtonText: "OK",
                            confirmButtonColor: "#4CAF50"
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops!",
                            html: `<p>${data.message}</p>${locationInfo}`,
                            confirmButtonText: "Try Again",
                            confirmButtonColor: "#f44336"
                        });
                    }

                    // Update status text with distance
                    document.getElementById("status").innerHTML = 
                        `Your Location: <strong>${lat.toFixed(6)}, ${lng.toFixed(6)}</strong><br>
                          <strong>${data.message} meters</strong>`;
                });
            }, function(error) {
                document.getElementById("status").textContent = `Error: ${error.message}`;
                Swal.fire({
                    icon: "error",
                    title: "Location Error",
                    text: error.message,
                    confirmButtonColor: "#f44336"
                });
            });
        } else {
            document.getElementById("status").textContent = "Geolocation not supported.";
            Swal.fire({
                icon: "error",
                title: "Geolocation Not Supported",
                text: "Please use a device with GPS enabled."
            });
        }
    </script>
</body>
</html>
