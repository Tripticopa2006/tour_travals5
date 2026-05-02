<?php
session_start();
include "header.php"; // Navbar
include "admin/db.php"; // Database connection

// URL se package ID get karna
if (isset($_GET['id'])) {
    $package_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Package details fetch karne ki query
    $query = "SELECT * FROM packages WHERE id = '$package_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='container mt-5'><h3>Package not found!</h3></div>";
        include "footer.php";
        exit();
    }
} else {
    header("Location: explore_tours.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['p_name']; ?> - Tour_travaaaaaaaaaaals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .details-container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .package-img { width: 100%; height: 400px; object-fit: cover; border-radius: 10px; }
        .price-tag { font-size: 1.5rem; color: #8b5cf6; font-weight: bold; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="details-container">
        <div class="row">
            <div class="col-md-6">
                <img src="admin/uploads/<?php echo $row['p_image']; ?>" class="package-img" alt="<?php echo $row['p_name']; ?>">
            </div>
            <div class="col-md-6">
                <h2 class="text-dark font-weight-bold"><?php echo $row['p_name']; ?></h2>
                
                <p class="text-muted">
                    <?php 
                        // Safety check for description column
                        if(isset($row['p_desc'])){
                            echo $row['p_desc'];
                        } else {
                            echo "No description available.";
                        }
                    ?>
                </p>
                
                <p class="price-tag">Price: ₹<?php echo number_format($row['p_price']); ?></p>
                <hr>
                <a href="booking_form.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-lg">Book This Package</a>
                <a href="explore_tours.php" class="btn btn-outline-secondary btn-lg">Back to Tours</a>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>