<?php
session_start();
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tour_travals"; 

$conn = mysqli_connect($host, $user, $pass, $db);

include "header.php";

// User login check
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Payment details handle karna
if (isset($_POST['package_id'])) {
    $package_id = mysqli_real_escape_string($conn, $_POST['package_id']);
    
    // ERROR FIX: Check if price/total_amount exists
    $price = isset($_POST['price']) ? $_POST['price'] : (isset($_POST['total_amount']) ? $_POST['total_amount'] : 0);
    
    $checkin = mysqli_real_escape_string($conn, $_POST['checkin']);
    $checkout = mysqli_real_escape_string($conn, $_POST['checkout']);
    
    // Nayi fields handle karna taaki NULL na aaye
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '';
    $members = isset($_POST['members']) ? mysqli_real_escape_string($conn, $_POST['members']) : '1';
    
    $today = date('Y-m-d');

    if ($checkin < $today) {
        echo "<script>alert('Check-in date purani nahi ho sakti!'); window.history.back();</script>";
        exit();
    }
    
    $query = "SELECT * FROM packages WHERE id = '$package_id'";
    $res = mysqli_query($conn, $query);

    if ($res && mysqli_num_rows($res) > 0) {
        $pkg = mysqli_fetch_assoc($res);
        $p_name = $pkg['p_name'] ?? $pkg['p_title'] ?? "Tour Package";
    } else {
        $p_name = "Tour Package";
    }
} else {
    echo "<div style='background:#0f1013; color:white; height:100vh; display:flex; align-items:center; justify-content:center; flex-direction:column;'>
            <h3 style='margin-bottom:20px;'>Booking details missing!</h3>
            <a href='index.php' style='background:#ffc107; color:#000; padding:10px 25px; border-radius:50px; text-decoration:none; font-weight:600;'>Back to Packages</a>
          </div>";
    include "footer.php";
    exit();
}
?>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body { background: #0f1013 !important; color: #fff; font-family: 'Outfit', sans-serif; margin: 0; padding: 0; }
    .payment-wrapper {
        position: relative; padding: 80px 0; display: flex; align-items: center; justify-content: center; min-height: 100vh;
        background: linear-gradient(rgba(15, 16, 19, 0.7), rgba(15, 16, 19, 0.8)), 
                    url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover; background-position: center; background-attachment: fixed;
    }
    .payment-card {
        background: rgba(22, 23, 27, 0.85); border-radius: 24px; padding: 40px; border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5); max-width: 450px; width: 100%; backdrop-filter: blur(15px);
    }
    .summary-box { background: rgba(255, 193, 7, 0.1); border-radius: 15px; padding: 20px; margin-bottom: 30px; border: 1px dashed rgba(255, 193, 7, 0.3); }
    .price-tag { font-size: 32px; font-weight: 700; color: #ffc107; margin-top: 5px; }
    .payment-option {
        background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px; padding: 18px; cursor: pointer; transition: 0.3s; margin-bottom: 15px; display: flex; align-items: center; color: #ddd;
    }
    .payment-option:hover { background: rgba(255, 193, 7, 0.15); border-color: #ffc107; transform: translateX(5px); }
    .form-control-custom {
        background: rgba(0, 0, 0, 0.4) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #fff !important; padding: 15px !important; border-radius: 12px !important; margin-top: 10px;
    }
    .btn-pay-modern {
        background: #ffc107; color: #000; font-weight: 700; padding: 18px; border-radius: 12px;
        width: 100%; border: none; margin-top: 25px; text-transform: uppercase; letter-spacing: 1.5px; cursor: pointer;
    }
</style>

<div class="payment-wrapper">
    <div class="payment-card">
        <div class="text-center mb-4">
            <div style="background: rgba(255, 193, 7, 0.2); width: 60px; height: 60px; line-height: 60px; border-radius: 50%; margin: 0 auto 15px;">
                <i class="fas fa-shield-alt text-warning" style="font-size: 28px;"></i>
            </div>
            <h3 class="fw-bold m-0">Secure Checkout</h3>
            <p class="text-white-50 mt-1"><?php echo htmlspecialchars($p_name); ?></p>
        </div>

        <div class="summary-box text-center">
            <span class="text-white-50 small text-uppercase">Total Payable Amount</span>
            <div class="price-tag">₹<?php echo number_format($price); ?></div>
            <div class="small text-warning mt-1"><?php echo $members; ?> Members | ID: #<?php echo $package_id; ?></div>
        </div>

        <form action="booking_success.php" method="POST">
            <input type="hidden" name="package_id" value="<?php echo $package_id; ?>">
            <input type="hidden" name="amount" value="<?php echo $price; ?>">
            <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
            <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
            
            <input type="hidden" name="phone" value="<?php echo $phone; ?>">
            <input type="hidden" name="members" value="<?php echo $members; ?>">

            <div class="payment-methods">
                <label class="payment-option" for="upi">
                    <input type="radio" name="pay_method" value="UPI" id="upi" checked>
                    <span class="ms-3">UPI (PhonePe / GPay)</span>
                    <i class="fab fa-google-pay ms-auto fs-3"></i>
                </label>
                <label class="payment-option" for="card">
                    <input type="radio" name="pay_method" value="Card" id="card">
                    <span class="ms-3">Debit / Credit Card</span>
                    <i class="far fa-credit-card ms-auto fs-4"></i>
                </label>
            </div>

            <input type="text" class="form-control-custom w-100" placeholder="Enter UPI ID / Card Details" name="pay_details" required>

            <button type="submit" class="btn-pay-modern">
                Confirm & Pay Now
            </button>
        </form>

        <div class="text-center secure-badge">
            <i class="fas fa-lock me-1"></i> SSL Secure Encryption
        </div>
    </div>
</div>

<?php include "footer.php"; ?>