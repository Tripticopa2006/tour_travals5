<?php
session_start();
include "header.php"; // Navbar
include "admin/db.php"; // Database connection

// Database se active packages laane ki query
$query = "SELECT * FROM packages"; // Agar koi 'status' column hai toh: WHERE status = 'active'
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Explore Tours - Tour_travels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .package-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .package-img {
            height: 200px;
            object-fit: cover;
        }
        .price-tag {
            font-size: 1.25rem;
            color: #8b5cf6; /* Match your dashboard color */
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2 class="text-center mb-5 font-weight-bold">Explore Our Packages</h2>

    <div class="row g-4">
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Database columns ke naam verify karein (p_image, p_name, p_price, p_desc, etc.)
                $image = "admin/uploads/" . $row['p_image']; // Image path
        ?>
        <div class="col-md-4">
            <div class="card package-card h-100 shadow-sm">
                <img src="<?php echo $image; ?>" class="card-img-top package-img" alt="<?php echo $row['p_name']; ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-dark"><?php echo $row['p_name']; ?></h5>
                    <p class="card-text text-muted small">
                        <?php 
                            // Description ke liye safety check
                            if(isset($row['p_desc'])){
                                echo substr($row['p_desc'], 0, 100); 
                            } else {
                                echo "No description available";
                            }
                        ?>...
                    </p>
                    <div class="mt-auto">
                        <p class="price-tag mb-2">₹<?php echo number_format($row['p_price']); ?></p>
                        <a href="package_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col-12 text-center'><p>No packages available right now.</p></div>";
        }
        ?>
    </div>
</div>

<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>