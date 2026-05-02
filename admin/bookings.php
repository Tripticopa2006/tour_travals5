<?php
session_start();
include('db.php'); 
include('mail_config.php');

// --- ACTION LOGIC: CONFIRM/CANCEL ---
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    if ($status == 'Confirmed' || $status == 'Cancelled') {
        $updateQuery = "UPDATE bookings SET status = '$status' WHERE id = '$id'";
        
        if (mysqli_query($conn, $updateQuery)) {
            $userQuery = "SELECT users.email, users.full_name, packages.p_name FROM bookings 
                          JOIN users ON bookings.user_id = users.id 
                          JOIN packages ON bookings.package_id = packages.id 
                          WHERE bookings.id = '$id'";
            $userResult = mysqli_query($conn, $userQuery);
            $userData = mysqli_fetch_assoc($userResult);

            if ($userData) {
                $emailBody = "<div style='font-family: Arial; padding: 20px;'>
                                <h2>Booking Update</h2>
                                <p>Dear <b>{$userData['full_name']}</b>, your booking for <b>{$userData['p_name']}</b> is <b>$status</b>.</p>
                              </div>";
                sendMail($userData['email'], "Booking $status", $emailBody);
            }
        }
    }
    header("Location: bookings.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 flex min-h-screen">

    <?php include('sidebar.php'); ?>

    <main class="ml-0 md:ml-64 p-4 md:p-8 w-full transition-all duration-300">
        
        <div class="mt-12 md:mt-0 mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800">Manage Bookings</h2>
                <p class="text-sm text-gray-500">Auto-refreshing every 5 seconds...</p>
            </div>
            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hidden sm:block">
                <i class="fas fa-sync-alt fa-spin mr-2"></i> Real-time Active
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-900 text-white">
                        <tr class="text-xs md:text-sm uppercase tracking-wider">
                            <th class="p-4">ID & Customer</th>
                            <th class="p-4 hidden md:table-cell">Package</th>
                            <th class="p-4 hidden sm:table-cell">Dates</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="booking-table-body" class="divide-y divide-gray-100 text-sm">
                        <tr><td colspan="5" class="p-10 text-center text-gray-400 animate-pulse">Loading bookings...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Function to load data using AJAX
        function fetchBookings() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("booking-table-body").innerHTML = this.responseText;
            }
            xhttp.open("GET", "fetch_bookings_ajax.php", true);
            xhttp.send();
        }

        // Auto Refresh every 5 seconds
        setInterval(fetchBookings, 5000);

        // Initial Load
        window.onload = fetchBookings;

        // Cancel Confirmation
        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Confirm Cancellation?',
                text: "The customer will receive an email notification.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'bookings.php?id=' + bookingId + '&status=Cancelled';
                }
            })
        }
    </script>
</body>
</html>