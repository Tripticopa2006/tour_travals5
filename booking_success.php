<?php
session_start();
include('admin/db.php');
include "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$success = false;
$error_msg = "";

if (isset($_POST['package_id'])) {
    $user_id    = $_SESSION['user_id'];
    $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
    $total_price= mysqli_real_escape_string($conn, $_POST['amount']);
    $checkin    = mysqli_real_escape_string($conn, $_POST['checkin']);
    $checkout   = mysqli_real_escape_string($conn, $_POST['checkout']);
    $status     = "pending"; // Spelling corrected from 'panding'
    $b_date     = date('Y-m-d H:i:s');

    // Database columns: checkin_date, checkout_date, total_price
    $sql = "INSERT INTO bookings (user_id, package_id, booking_date, checkin_date, checkout_date, total_price, status) 
            VALUES ('$user_id', '$package_id', '$b_date', '$checkin', '$checkout', '$total_price', '$status')";

    if (mysqli_query($conn, $sql)) {
        $success = true;
        $booking_id = mysqli_insert_id($conn);
    } else {
        $error_msg = mysqli_error($conn);
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<style>
    body { 
        background: #0f0c29; 
        background: linear-gradient(to bottom, #24243e, #302b63, #0f0c29); 
        color: #fff; 
        font-family: 'Poppins', sans-serif;
    }
    
    .main-wrapper { min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 15px; }
    
    .compact-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 30px;
        padding: 30px;
        width: 100%;
        max-width: 420px;
        text-align: center;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }

    .success-text { color: #00ffcc; font-weight: 700; font-size: 1.8rem; margin-top: -10px; text-transform: capitalize; }
    
    .ticket-lite {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 20px;
        margin: 20px 0;
        border-left: 4px solid #ffc107;
    }

    /* Gradient Button Style */
    .btn-gradient {
        background: linear-gradient(45deg, #00d2ff, #3a7bd5);
        color: white !important; 
        font-weight: 600; 
        padding: 12px 35px;
        border-radius: 50px; 
        border: none; 
        transition: 0.3s;
        text-decoration: none; 
        display: inline-block;
        width: 100%; /* Full width button for better mobile look */
    }
    .btn-gradient:hover { 
        transform: translateY(-3px); 
        box-shadow: 0 10px 20px rgba(58, 123, 213, 0.4); 
    }
    
    .price-tag { font-size: 1.5rem; color: #ffc107; font-weight: bold; }
</style>

<div class="main-wrapper">
    <?php if ($success): ?>
        <div class="compact-card">
            <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_kz9pjcjt.json" 
                background="transparent" speed="1.5" style="width: 120px; height: 120px; margin: 0 auto;" autoplay></lottie-player>

            <h2 class="success-text">Pending!</h2>
            <p class="text-light opacity-75 small">Pack your bags, the adventure awaits.</p>

            <div class="ticket-lite text-start">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-white-50">Booking ID</small>
                    <span class="small fw-bold">#BK-<?php echo $booking_id; ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-white-50">Dates</small>
                    <span class="small"><?php echo date('d M', strtotime($checkin)); ?> - <?php echo date('d M', strtotime($checkout)); ?></span>
                </div>
                <hr class="my-2 border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-white-50">Amount Paid</small>
                    <span class="price-tag">₹<?php echo number_format($total_price); ?></span>
                </div>
            </div>

            <div class="mt-4">
                <a href="my_bookings.php" class="btn-gradient">View My Bookings</a>
            </div>
        </div>

        <script>
            // Blue & Gold Confetti effect on load
            confetti({ 
                particleCount: 150, 
                spread: 70, 
                origin: { y: 0.6 }, 
                colors: ['#00d2ff', '#ffc107', '#ffffff'] 
            });
        </script>

    <?php else: ?>
        <div class="compact-card" style="border-color: rgba(255, 0, 0, 0.3);">
            <div class="mb-3">
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-danger">Booking Failed!</h3>
            <p class="small text-white-50"><?php echo htmlspecialchars($error_msg); ?></p>
            <div class="mt-3">
                <a href="javascript:history.back()" class="btn btn-outline-light rounded-pill px-4">Try Again</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "footer.php"; ?>