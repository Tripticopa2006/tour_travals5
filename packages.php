<?php 
session_start();
include "header.php"; 

// 1. Database connection include karein
if(file_exists('admin/db.php')){
    include ('admin/db.php'); 
} else {
    die("Database configuration file (admin/db.php) not found!");
}

// 2. Check karein ki connection variable set hai ya nahi
if (!isset($conn)) {
    die("Error: Database connection variable (\$conn) is not defined in admin/db.php");
}

// Database se packages fetch karein
$query = "SELECT * FROM packages ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🌍 Our Packages - Tour & Travels</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.85), rgba(0,0,0,0.85)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
            min-height: 100vh;
        }

        /* --- Dashboard Button Style --- */
        .btn-back-dashboard {
            background: rgba(255, 255, 255, 0.1);
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 10px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-back-dashboard:hover {
            background: #fff;
            color: #000 !important;
            transform: translateX(-5px);
        }

        .hero-title-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .package-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
        }

        .package-card:hover {
            transform: translateY(-10px);
            border-color: #ffc107;
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }

        .card-img-container {
            height: 220px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .package-card:hover .card-img-container img {
            transform: scale(1.1);
        }

        .loc-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ffc107;
            color: #000;
            padding: 4px 15px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 800;
            z-index: 5;
            box-shadow: 0 5px 10px rgba(0,0,0,0.3);
        }

        .card-content {
            padding: 25px;
            text-align: center;
            flex-grow: 1;
        }

        .card-content h5 {
            font-weight: 700;
            color: #ffc107;
            text-transform: uppercase;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .price-display {
            font-size: 24px;
            font-weight: 800;
            margin: 15px 0;
            color: #fff;
        }

        .btn-book {
            background: #ffc107;
            color: #000 !important;
            font-weight: 800;
            padding: 15px;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: 0.3s;
            border: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-book:hover {
            background: #ffffff;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

<div class="container mt-5 pb-5">
    
    <div class="row">
        <div class="col-12">
            <a href="user_dashboard.php" class="btn-back-dashboard">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="hero-title-container">
                <h1 class="display-5 fw-bold text-white">🌍 OUR <span class="text-warning">PACKAGES</span></h1>
                <p class="text-white-50">Duniya ghoomne ka moka mat chhodiye. Choose your deal!</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
    <?php 
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $name     = $row['p_name'] ?? 'Untitled Trip';
            $location = $row['p_location'] ?? 'Location';
            $price    = $row['p_price'] ?? '0';
            $image    = $row['p_image'] ?? '';
            $desc     = $row['p_description'] ?? '';

            // --- REDIRECTION LOGIC ---
            if (!isset($_SESSION['user_id'])) {
                $target_url = "user_login.php?package_id=" . $row['id'];
            } else {
                $target_url = "booking_process.php?id=" . $row['id'];
            }
    ?>
        <div class="col-lg-3 col-md-6"> 
            <div class="package-card shadow-lg">
                <div class="card-img-container">
                    <span class="loc-badge"><i class="fas fa-map-marker-alt"></i> <?php echo strtoupper($location); ?></span>
                    <img src="admin/uploads/<?php echo $image; ?>" 
                         onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'" 
                         alt="Tour Image">
                </div>
                
                <div class="card-content">
                    <h5><?php echo htmlspecialchars($name); ?></h5>
                    <p class="text-light opacity-50 small"><?php echo htmlspecialchars(substr($desc, 0, 65)); ?>...</p>
                    <div class="price-display">₹<?php echo number_format((float)$price); ?>/-</div>
                </div>

                <a href="<?php echo $target_url; ?>" class="btn-book">BOOK NOW</a>
            </div>
        </div>
    <?php 
        }
    } else {
        echo "<div class='text-center w-100 mt-5'><h3 class='text-warning'>Filhaal koi packages available nahi hain.</h3></div>";
    }
    ?>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>