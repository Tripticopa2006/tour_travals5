<?php
session_start();
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Traveler'; 

// Fetch user profile pic
$query = "SELECT profile_pic FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user_data = mysqli_fetch_assoc($result);
$user_img = !empty($user_data['profile_pic']) ? "uploads/profiles/" . $user_data['profile_pic'] : "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✨ High-End Dashboard | Tour & Travels</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-deep: #030708;
            --accent-blue: #00e5ff;
            --accent-green: #00ff88;
            --accent-pink: #ff0077;
            --btn-grad: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
        }

        body { 
            background: var(--bg-deep);
            background-image: 
                radial-gradient(at 0% 0%, rgba(0, 229, 255, 0.1) 0, transparent 45%),
                radial-gradient(at 100% 100%, rgba(255, 0, 119, 0.1) 0, transparent 45%),
                url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #ffffff;
            min-height: 100vh;
        }

        .dashboard-header { padding: 60px 0 20px; }

        /* --- Welcome Area --- */
        .welcome-section {
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 40px;
            margin-bottom: 50px;
            box-shadow: 0 30px 60px rgba(0,0,0,0.4);
        }

        .user-avatar {
            width: 110px;
            height: 110px;
            border-radius: 30px;
            border: 3px solid rgba(255,255,255,0.2);
            object-fit: cover;
            margin-bottom: 20px;
        }

        /* --- Stylish Boxes --- */
        .box-container {
            background: rgba(10, 15, 20, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 32px;
            padding: 35px 25px;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            z-index: 1;
            overflow: hidden;
            text-align: center;
        }

        .box-blue:hover { border-color: var(--accent-blue); box-shadow: 0 0 40px rgba(0, 229, 255, 0.2); }
        .box-green:hover { border-color: var(--accent-green); box-shadow: 0 0 40px rgba(0, 255, 136, 0.2); }
        .box-pink:hover { border-color: var(--accent-pink); box-shadow: 0 0 40px rgba(255, 0, 119, 0.2); }

        .box-container:hover {
            transform: translateY(-15px);
            background: rgba(20, 25, 30, 0.95);
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 25px;
            background: rgba(255, 255, 255, 0.03);
            transition: 0.3s;
        }

        .box-blue .icon-circle { color: var(--accent-blue); }
        .box-green .icon-circle { color: var(--accent-green); }
        .box-pink .icon-circle { color: var(--accent-pink); }

        h4 { font-weight: 800; letter-spacing: 1px; color: #ffffff !important; margin-bottom: 12px; }
        p { color: rgba(255, 255, 255, 0.7) !important; font-size: 0.95rem; }

        /* --- High Highlight Buttons --- */
        .btn-box {
            background: var(--btn-grad);
            color: #000 !important;
            border-radius: 18px;
            padding: 15px 25px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            border: none;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);
        }

        .btn-box:hover {
            background: #ffffff;
            transform: scale(1.02);
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.4);
            letter-spacing: 1.5px;
        }

        /* Luxury text white color */
        .luxury-text {
            color: #ffffff !important;
            opacity: 0.9;
            font-weight: 400;
        }

    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="dashboard-header text-center">
    <div class="container">
        <h1 class="display-4 fw-800">Travel <span style="color: var(--accent-blue);">Hub</span></h1>
        <p class="luxury-text">Luxury is in each detail.</p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="welcome-section text-center">
                <img src="<?php echo $user_img; ?>" class="user-avatar shadow" alt="User">
                <h2 class="fw-800">Namaste, <?php echo htmlspecialchars($user_name); ?>! 👋</h2>
                <p>Aapke agle safar ki taiyari yahan se shuru hoti hai. Explore karein aur enjoy karein!</p>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-4">
            <div class="box-container box-blue">
                <div class="icon-circle shadow-sm">
                    <i class="bi bi-calendar2-check-fill"></i>
                </div>
                <h4>MY TRIPS</h4>
                <p>Apni sari bookings aur tickets ka status yahan check karein.</p>
                <a href="my_bookings.php" class="btn btn-box">View Tickets</a>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="box-container box-green">
                <div class="icon-circle shadow-sm">
                    <i class="bi bi-compass-fill"></i>
                </div>
                <h4>EXPLORE</h4>
                <p>Naye exotic locations aur best deals ko browse karein.</p>
                <a href="packages.php" class="btn btn-box">Browse Tours</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="box-container box-pink">
                <div class="icon-circle shadow-sm">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h4>ACCOUNT</h4>
                <p>Profile update karein aur account settings manage karein.</p>
                <a href="profile.php" class="btn btn-box">Edit Details</a>
            </div>
        </div>
        
    </div>
</div>

<?php include "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>