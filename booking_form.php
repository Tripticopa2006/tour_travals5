<?php
session_start();
include "header.php"; 
include "admin/db.php";

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Fetch package details
if (isset($_GET['id'])) {
    $package_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM packages WHERE id = '$package_id'";
    $result = mysqli_query($conn, $query);
    $package = mysqli_fetch_assoc($result);
} else {
    header("Location: explore_tours.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book <?php echo $package['p_name']; ?> - Tour_travels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .booking-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            background: white;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .card-body-custom {
            padding: 30px;
        }
        .package-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #4b5563;
        }
        .form-label {
            font-weight: 600;
            color: #6b7280;
        }
        .btn-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .btn-confirm:hover {
            transform: translateY(-2px);
            color: white;
        }
        .img-preview {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card booking-card">
                <div class="card-header-custom">
                    <h2 class="mb-0">Secure Your Booking</h2>
                    <p class="mb-0 opacity-75">Complete the form below to confirm your trip</p>
                </div>
                
                <div class="card-body-custom">
                    <div class="row mb-4 align-items-center">
                        <div class="col-md-4">
                            <img src="admin/uploads/<?php echo $package['p_image']; ?>" class="img-preview" alt="Package Image">
                        </div>
                        <div class="col-md-8">
                            <h4 class="package-title"><?php echo $package['p_name']; ?></h4>
                            <p class="text-muted mb-1">📍 <?php echo $package['p_location']; ?></p>
                            <span class="badge bg-primary fs-6">₹<?php echo number_format($package['p_price']); ?></span>
                        </div>
                    </div>

                    <form action="booking_process.php" method="POST">
                        <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Select Travel Date</label>
                            <input type="date" name="travel_date" class="form-control form-control-lg" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Number of Persons</label>
                            <input type="number" name="persons" class="form-control form-control-lg" min="1" value="1" required>
                        </div>

                        <button type="submit" class="btn btn-confirm w-100 btn-lg">
                            Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>