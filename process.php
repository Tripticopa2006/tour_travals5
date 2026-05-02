<?php 
session_start();
include "header.php"; 

// 1. Database connection include karein
// Yakeen karein ki admin/db.php mein mysqli ka connection '$conn' variable mein hai
if(file_exists('admin/db.php')){
    include ('admin/db.php'); 
} else {
    die("Error: Database configuration file (admin/db.php) not found!");
}

// 2. Check karein ki mysqli connection variable ($conn) set hai ya nahi
if (!isset($conn)) {
    die("Error: Database connection variable (\$conn) is not defined in admin/db.php");
}

// 3. Database se packages fetch karein (mysqli use karte hue)
$query = "SELECT * FROM packages ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tour_travels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
        }

        .hero-title-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 40px;
            text-align: center;
        }

        .package-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s ease;
        }

        .package-card:hover {
            transform: translateY(-5px);
            border-color: #ffc107;
        }

        .card-img-container {
            height: 200px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .loc-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ffc107;
            color: #000;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            z-index: 5;
        }

        .card-content {
            padding: 20px;
            text-align: center;
            flex-grow: 1;
        }

        .card-content h5 {
            font-weight: 700;
            color: #ffc107;
            text-transform: uppercase;
            font-size: 1.1rem;
        }

        .price-display {
            font-size: 22px;
            font-weight: 800;
            margin: 10px 0;
        }

        .btn-book {
            background: #ffc107;
            color: #000 !important;
            font-weight: 800;
            padding: 12px;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: 0.3s;
            border: none;
            text-transform: uppercase;
        }

        .btn-book:hover {
            background: #fff;
        }
    </style>
</head>
<body>

<div class="container mb-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="hero-title-container">
                <h1 class="display-5 fw-bold text-white">🌍 OUR <span class="text-warning">PACKAGES</span></h1>
                <p class="opacity-75">Choose your perfect destination</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $name     = $row['p_name'] ?? 'Untitled Trip';
            $location = $row['p_location'] ?? 'Location';
            $price    = $row['p_price'] ?? '0';
            $image    = $row['p_image'] ?? '';
            $desc     = $row['p_description'] ?? '';

            // Redirection Logic
            if (!isset($_SESSION['user_id'])) {
                $target_url = "user_login.php?redirect_to=booking&id=" . $row['id'];
                $open_tab = ""; 
            } else {
                $target_url = "booking_process.php?id=" . $row['id'];
                $open_tab = ""; 
            }
    ?>
        <div class="col-lg-3 col-md-6"> 
            <div class="package-card shadow-lg">
                <div class="card-img-container">
                    <span class="loc-badge">📍 <?php echo strtoupper($location); ?></span>
                    <img src="admin/uploads/<?php echo $image; ?>" 
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'" 
                         alt="Tour Image">
                </div>
                
                <div class="card-content">
                    <h5><?php echo $name; ?></h5>
                    <p class="text-light opacity-50 small"><?php echo substr($desc, 0, 60); ?>...</p>
                    <div class="price-display text-white">₹<?php echo number_format((float)$price); ?>/-</div>
                </div>

                <a href="<?php echo $target_url; ?>" class="btn-book" <?php echo $open_tab; ?>>BOOK TRIP NOW</a>
            </div>
        </div>
    <?php 
        }
    } else {
        echo "<div class='text-center w-100 mt-5'><h3 class='text-warning'>No packages available at the moment.</h3></div>";
    }
    ?>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>