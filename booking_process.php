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

// Offer Price Check
if (isset($_GET['offer_price'])) {
    $display_price = floatval($_GET['offer_price']);
} else {
    $display_price = $package['p_price'];
}

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
            background: rgba(25, 25, 25, 0.98); border-radius: 30px; overflow: hidden;
            border: 1px solid rgba(255, 193, 7, 0.2); backdrop-filter: blur(20px);
        }
        .main-img { width: 100%; height: 320px; object-fit: cover; border-bottom: 5px solid #ffc107; }
        
        /* Secondary Images Styling */
        .sub-img-card {
            background: rgba(255, 255, 255, 0.05); border-radius: 15px; overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1); text-align: center;
        }
        .sub-img { width: 100%; height: 120px; object-fit: cover; }
        .sub-label { font-size: 0.75rem; color: #ffc107; font-weight: bold; text-transform: uppercase; padding: 5px; background: rgba(0,0,0,0.5); }

        .form-control { background: rgba(255, 255, 255, 0.05); border: 2px solid #333; color: #fff; border-radius: 12px; }
        .form-control:focus { background: rgba(255, 255, 255, 0.1); border-color: #ffc107; color: #fff; box-shadow: none; }
        
        .btn-payment { background: linear-gradient(45deg, #ffc107, #ff9800); border: none; font-weight: 800; border-radius: 15px; padding: 15px; }
        .detail-box { background: rgba(255, 193, 7, 0.05); border: 1px dashed rgba(255, 193, 7, 0.4); border-radius: 15px; padding: 20px; }
        label { color: #ffc107; font-weight: 600; font-size: 0.85rem; margin-bottom: 5px; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8"> <div class="booking-card shadow-2xl">
                
                <div class="position-relative">
                    <img src="<?php echo $p_image; ?>" class="main-img">
                    <div class="position-absolute bottom-0 start-0 p-4 w-100" style="background: linear-gradient(transparent, rgba(0,0,0,0.9));">
                        <h2 class="fw-bold mb-0"><?php echo htmlspecialchars($package['p_name']); ?></h2>
                        <span class="badge bg-warning text-dark"><i class="fas fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($package['p_location']); ?></span>
                    </div>
                </div>

                <div class="p-4 p-md-5">
                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <h6 class="text-warning text-uppercase small fw-bold mb-3">Service Details</h6>
                            
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="sub-img-card">
                                        <div class="sub-label"><i class="fas fa-car me-1"></i> Transport</div>
                                        <img src="<?php echo $t_image; ?>" class="sub-img" title="Transport: <?php echo $package['p_transport']; ?>">
                                        <div class="p-2 small"><?php echo htmlspecialchars($package['p_transport']); ?></div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="sub-img-card">
                                        <div class="sub-label"><i class="fas fa-hotel me-1"></i> Hotel</div>
                                        <img src="<?php echo $h_image; ?>" class="sub-img">
                                        <div class="p-2 small">Stay: <?php echo ($package['p_hotel'] == 'Yes') ? 'Included' : 'Not Included'; ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-box">
                                <p class="small text-light mb-0" style="white-space: pre-wrap;"><?php echo htmlspecialchars($package['p_description']); ?></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bg-dark p-4 rounded-4 border border-secondary">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-secondary uppercase small">Total Payable</span>
                                    <h3 class="text-warning fw-bold m-0">₹<?php echo number_format($display_price); ?>/-</h3>
                                </div>

                                <form action="payment.php" method="POST">
                                    <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $display_price; ?>">

                                    <div class="mb-3">
                                        <label><i class="fas fa-calendar-plus me-2"></i>Arrival Date</label>
                                        <input type="date" name="checkin" class="form-control" id="checkin" required>
                                    </div>

                                    <div class="mb-4">
                                        <label><i class="fas fa-calendar-minus me-2"></i>Departure Date</label>
                                        <input type="date" name="checkout" class="form-control" id="checkout" required>
                                    </div>

                                    <button type="submit" class="btn btn-payment w-100 shadow-lg text-white">
                                        PROCEED TO PAYMENT <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div> </div>
            </div>
        </div>
    </div>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('checkin').setAttribute('min', today);
    document.getElementById('checkin').addEventListener('change', function() {
        document.getElementById('checkout').setAttribute('min', this.value);
    });
</script>

<?php include "footer.php"; ?>
</body>
</html>