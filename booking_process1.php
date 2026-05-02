<?php 
session_start();
include('admin/db.php'); 

// Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Get Package ID from URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $package_id = intval($_GET['id']);
} else {
    die("Package ID missing!");
}

// Fetch package details
$stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();

if (!$package) {
    die("Package not found!");
}

// Base Price Logic
$base_price = isset($_GET['offer_price']) ? floatval($_GET['offer_price']) : $package['p_price'];

// Image Paths
$upload_dir = "admin/uploads/";
$p_image = (!empty($package['p_image'])) ? $upload_dir . $package['p_image'] : "images/default-package.jpg";
$t_image = (!empty($package['p_transport_image'])) ? $upload_dir . $package['p_transport_image'] : "images/default-car.jpg";
$h_image = (!empty($package['p_hotel_image'])) ? $upload_dir . $package['p_hotel_image'] : "images/default-hotel.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking - <?php echo htmlspecialchars($package['p_name']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), url('https://images.unsplash.com/photo-1503221043305-f7498f8b7888?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-attachment: fixed; color: #fff; min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .booking-card {
            background: rgba(20, 20, 20, 0.95); border-radius: 30px; overflow: hidden;
            border: 1px solid rgba(255, 193, 7, 0.3); backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .main-img { width: 100%; height: 320px; object-fit: cover; border-bottom: 5px solid #ffc107; }
        
        .sub-img-card {
            background: rgba(255, 255, 255, 0.05); border-radius: 15px; overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1); text-align: center; height: 100%;
        }
        .sub-img { width: 100%; height: 100px; object-fit: cover; }
        .sub-label { font-size: 0.7rem; color: #ffc107; font-weight: bold; text-transform: uppercase; padding: 5px; background: rgba(0,0,0,0.6); }

        .form-control { 
            background: rgba(0, 0, 0, 0.4); border: 1.5px solid #444; color: #fff; 
            border-radius: 12px; padding: 12px; transition: 0.3s;
        }
        .form-control:focus { 
            background: rgba(0, 0, 0, 0.6); border-color: #ffc107; color: #fff; 
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.2); 
        }
        
        .btn-payment { 
            background: linear-gradient(45deg, #ffc107, #ffb300); border: none; 
            font-weight: 800; border-radius: 15px; padding: 18px; color: #000;
            text-transform: uppercase; letter-spacing: 1px; transition: 0.4s;
        }
        .btn-payment:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3); color: #000; }
        
        .detail-box { background: rgba(255, 193, 7, 0.03); border: 1px dashed rgba(255, 193, 7, 0.3); border-radius: 15px; padding: 15px; }
        label { color: #ffc107; font-weight: 600; font-size: 0.8rem; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .price-display { background: rgba(255, 193, 7, 0.1); padding: 15px; border-radius: 12px; border: 1px solid rgba(255,193,7,0.2); }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="booking-card">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block" style="border-right: 1px solid rgba(255,193,7,0.2);">
                        <img src="<?php echo $p_image; ?>" class="main-img" style="height: 400px;">
                        <div class="p-4">
                            <h4 class="text-warning fw-bold mb-3">Service Inclusions</h4>
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="sub-img-card">
                                        <div class="sub-label">Transport</div>
                                        <img src="<?php echo $t_image; ?>" class="sub-img">
                                        <div class="p-2 small opacity-75"><?php echo htmlspecialchars($package['p_transport']); ?></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="sub-img-card">
                                        <div class="sub-label">Hotel</div>
                                        <img src="<?php echo $h_image; ?>" class="sub-img">
                                        <div class="p-2 small opacity-75"><?php echo ($package['p_hotel'] == 'Yes') ? 'Premium Stay' : 'No Hotel'; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-box">
                                <label class="d-block mb-1"><i class="fas fa-info-circle me-2"></i>Note</label>
                                <p class="small text-white-50 mb-0">Prices are calculated per person. Please ensure travel documents are ready.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7 p-4 p-md-5">
                        <div class="mb-4">
                            <span class="badge bg-warning text-dark mb-2">SECURE BOOKING</span>
                            <h2 class="fw-bold"><?php echo htmlspecialchars($package['p_name']); ?></h2>
                            <p class="text-white-50 small"><i class="fas fa-map-marker-alt text-warning me-1"></i> <?php echo htmlspecialchars($package['p_location']); ?></p>
                        </div>

                        <form action="payment.php" method="POST">
                            <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                            <input type="hidden" id="base_price" value="<?php echo $base_price; ?>">
                            <input type="hidden" name="total_amount" id="final_amount_input" value="<?php echo $base_price; ?>">

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label><i class="fas fa-phone-alt me-2"></i>Contact Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-secondary text-warning">+91</span>
                                        <input type="tel" name="phone" class="form-control" placeholder="Enter 10 digit number" pattern="[0-9]{10}" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label><i class="fas fa-users me-2"></i>Total Members (Including You)</label>
                                    <input type="number" name="members" id="members" class="form-control" value="1" min="1" max="20" required>
                                </div>

                                <div class="col-md-6">
                                    <label><i class="fas fa-calendar-check me-2"></i>Arrival Date</label>
                                    <input type="date" name="checkin" id="checkin" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label><i class="fas fa-calendar-times me-2"></i>Departure</label>
                                    <input type="date" name="checkout" id="checkout" class="form-control" required>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="price-display d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-white-50 small d-block">Final Payable Amount</span>
                                            <h3 class="text-warning fw-bold mb-0">₹<span id="display_price"><?php echo number_format($base_price); ?></span>/-</h3>
                                        </div>
                                        <div class="text-end text-white-50 small">
                                            ₹<?php echo number_format($base_price); ?> x <span id="member_count">1</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-payment w-100 shadow-lg">
                                        CONFIRM & PROCEED TO PAYMENT <i class="fas fa-chevron-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Date Logic
    const today = new Date().toISOString().split('T')[0];
    const checkin = document.getElementById('checkin');
    const checkout = document.getElementById('checkout');

    checkin.setAttribute('min', today);
    checkin.addEventListener('change', function() {
        checkout.setAttribute('min', this.value);
    });

    // Price Calculation Logic
    const membersInput = document.getElementById('members');
    const basePrice = parseFloat(document.getElementById('base_price').value);
    const displayPrice = document.getElementById('display_price');
    const memberCountLabel = document.getElementById('member_count');
    const finalAmountInput = document.getElementById('final_amount_input');

    membersInput.addEventListener('input', function() {
        let count = parseInt(this.value) || 1;
        if(count < 1) count = 1;
        
        let total = count * basePrice;
        
        // Update UI
        displayPrice.innerText = total.toLocaleString('en-IN');
        memberCountLabel.innerText = count;
        
        // Update hidden input for form submission
        finalAmountInput.value = total;
    });
</script>

<?php include "footer.php"; ?>
</body>
</html>