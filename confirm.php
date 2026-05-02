<?php 
session_start();
include "header.php"; 

include "admin/db.php";
// mysqli connection bana rahe hain
$conn = mysqli_connect($host, $user, $pass, $db);

// Connection check karein
if (!$conn) {
    die("Database Connection failed: " . mysqli_connect_error());
}

// 2. Check if a booking ID was passed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['booking_id'])) {
    $booking_id = mysqli_real_escape_string($conn, $_POST['booking_id']);

    // 3. Update the booking status in Database
    $update_query = "UPDATE bookings SET status = 'Confirmed' WHERE id = '$booking_id'";
    mysqli_query($conn, $update_query);

    // Fetch customer details to show a personalized message
    $user_query = "SELECT customer_name, customer_email FROM bookings WHERE id = '$booking_id'";
    $result = mysqli_query($conn, $user_query);
    $customer = mysqli_fetch_assoc($result);

} else {
    // If someone tries to access this page directly without POST
    die("Invalid access.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .check-icon { font-size: 5rem; color: #28a745; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-5 shadow text-center" style="max-width: 600px; margin: auto;">
            <div class="check-icon">✓</div>
            <h1 class="text-success">Booking Confirmed!</h1>
            
            <?php if ($customer): ?>
                <p class="lead">Thank you, <?php echo htmlspecialchars($customer['customer_name']); ?>!</p>
                <hr>
                <p>Your booking ID is: <strong>#<?php echo htmlspecialchars($booking_id); ?></strong></p>
                <p>A confirmation email has been sent to <strong><?php echo htmlspecialchars($customer['customer_email']); ?></strong>.</p>
            <?php else: ?>
                <p class="lead">Thank you for your booking!</p>
            <?php endif; ?>
            
            <br>
            <a href="index.php" class="btn btn-outline-primary btn-lg">Back to Home</a>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>