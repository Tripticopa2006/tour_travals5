<?php
session_start();
include "admin/db.php"; 

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// 2. Check if ID is provided
if (!isset($_GET['id'])) {
    die("Invalid Request! Booking ID is missing.");
}

$booking_id = mysqli_real_escape_string($conn, $_GET['id']);
$user_id = $_SESSION['user_id'];

// 3. Database query (Make sure table names 'bookings', 'packages', 'users' are correct)
$query = "SELECT bookings.*, packages.p_name, packages.p_price, packages.p_image, users.full_name, users.email
          FROM bookings 
          JOIN packages ON bookings.package_id = packages.id 
          JOIN users ON bookings.user_id = users.id
          WHERE bookings.id = '$booking_id' AND bookings.user_id = '$user_id'";

$result = mysqli_query($conn, $query);

// CHECK: Kya database ne data diya?
if ($result && mysqli_num_rows($result) > 0) {
    $booking = mysqli_fetch_assoc($result);
} else {
    // Agar data nahi mila toh error dikhayega, page blank nahi hoga
    die("<div style='text-align:center; padding:50px;'>
            <h2>Ticket Not Found!</h2>
            <p>Ya toh ID galat hai ya aap unauthorized hain.</p>
            <a href='user_dashboard.php'>Back to Dashboard</a>
         </div>");
}

// Package Image logic
$pkg_image = !empty($booking['p_image']) ? "admin/uploads/" . $booking['p_image'] : "https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=500&q=80";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket #BK-<?php echo $booking['id']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #eef2f3; font-family: 'Poppins', sans-serif; min-height: 100vh; display: flex; align-items: center; padding: 20px 0; }
        .ticket-wrapper { max-width: 850px; margin: auto; width: 95%; }
        .ticket-card { background: #fff; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); position: relative; overflow: hidden; border: 1px solid #ddd; }
        .ticket-header-main { display: flex; flex-wrap: wrap; background: #fff; border-bottom: 2px dashed #eee; }
        .pkg-photo-side { width: 250px; height: 180px; object-fit: cover; border-radius: 0 0 50px 0; }
        .header-text-side { flex: 1; padding: 20px; text-align: right; min-width: 250px; }
        .header-text-side h1 { color: #007bff; font-weight: 800; font-size: 1.8rem; margin: 0; }
        .ticket-body { padding: 25px; }
        .customer-box { background: #f8faff; padding: 15px; border-radius: 12px; margin-bottom: 20px; border-left: 5px solid #007bff; }
        .details-table th { color: #666; font-weight: 500; border: none !important; font-size: 14px; }
        .details-table td { font-weight: 700; color: #222; text-align: right; border: none !important; font-size: 14px; }
        .details-table tr { border-bottom: 1px solid #f1f1f1; }
        .total-price { font-size: 22px; color: #28a745; font-weight: 900; }

        @media (max-width: 576px) {
            .ticket-header-main { flex-direction: column; text-align: center; }
            .pkg-photo-side { width: 100%; height: 200px; border-radius: 0; }
            .header-text-side { text-align: center; padding: 15px; }
            .customer-box .col-sm-6 { text-align: left !important; margin-bottom: 10px; }
            .no-print .btn { width: 100%; margin-bottom: 10px; margin-left: 0 !important; }
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: white; }
            .ticket-card { box-shadow: none; border: 1px solid #000; border-radius: 0; }
        }
    </style>
</head>
<body>

<div class="ticket-wrapper">
    <div class="ticket-card">
        <div class="ticket-header-main">
            <img src="<?php echo $pkg_image; ?>" alt="Package" class="pkg-photo-side">
            <div class="header-text-side">
                <h1>TOUR & TRAVELS</h1>
                <p class="text-muted mb-0 small">E-Ticket & Confirmation</p>
                <div class="mt-2">
                    <span class="badge bg-primary">Ref: #BK-<?php echo $booking['id']; ?></span>
                </div>
            </div>
        </div>

        <div class="ticket-body">
            <div class="customer-box">
                <div class="row">
                    <div class="col-sm-6">
                        <small class="text-muted d-block">PASSENGER NAME</small>
                        <strong class="fs-6"><?php echo strtoupper($booking['full_name']); ?></strong>
                    </div>
                    <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
                        <small class="text-muted d-block">EMAIL ADDRESS</small>
                        <strong class="small"><?php echo $booking['email']; ?></strong>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table details-table mb-0">
                    <tr>
                        <th class="py-2">Destination</th>
                        <td class="py-2 text-primary"><?php echo $booking['p_name']; ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Check-in</th>
                        <td class="py-2"><?php echo date('d M, Y', strtotime($booking['checkin_date'])); ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Check-out</th>
                        <td class="py-2"><?php echo date('d M, Y', strtotime($booking['checkout_date'])); ?></td>
                    </tr>
                    <tr>
                        <th class="py-2">Status</th>
                        <td class="py-2">
                            <span class="badge <?php echo ($booking['status'] == 'Confirmed') ? 'bg-success' : 'bg-warning'; ?>">
                                <?php echo strtoupper($booking['status']); ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th class="pt-3 fs-6">Total Paid</th>
                        <td class="total-price pt-3">₹<?php echo number_format($booking['total_price']); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer text-center text-muted p-3">
            <p class="mb-1">Wish you a happy and safe journey! ✈️</p>
            <p class="small mb-0"><strong>Note:</strong> Carry a valid ID proof during travel.</p>
        </div>
    </div>
    
    <div class="text-center no-print mt-4 px-3">
        <button onclick="window.print()" class="btn btn-primary px-4 py-2 shadow">Download Ticket</button>
        <a href="user_dashboard.php" class="btn btn-outline-secondary px-4 py-2 ms-sm-2">Back</a>
    </div>
</div>

</body>
</html>