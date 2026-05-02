<?php
session_start();
include('admin/db.php'); // Database connection enable karein

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. Fetch User Data from Database
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Variables mein data set karein
$user_name    = $user['name'] ?? "User Name";
$user_email   = $user['email'] ?? "email@example.com";
$user_phone   = $user['phone'] ?? "";
$user_city    = $user['city'] ?? "";
$user_state   = $user['state'] ?? "";
$user_address = $user['address'] ?? "";
// Profile image logic: agar DB mein image hai to wo dikhao, nahi to default placeholder
$user_image   = (!empty($user['image'])) ? "uploads/profiles/" . $user['image'] : "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";

// Stats (Inhe bhi aap query se fetch kar sakte hain)
$trips_count = 12; 
$reviews_count = 5;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Tour & Travels</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root { --primary-yellow: #ffc107; }
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif; color: #fff; min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .glass-container {
            background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 40px;
            overflow: hidden; width: 100%; max-width: 1000px; display: flex; flex-wrap: wrap;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
        }
        .sidebar {
            background: rgba(0, 0, 0, 0.3); flex: 1; min-width: 320px; padding: 40px;
            text-align: center; border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .profile-img-container { position: relative; width: 160px; margin: 0 auto 20px; }
        .profile-img {
            width: 160px; height: 160px; border-radius: 35px; object-fit: cover;
            border: 3px solid var(--primary-yellow); box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }
        .camera-btn {
            position: absolute; bottom: -5px; right: -5px; background: var(--primary-yellow);
            width: 40px; height: 40px; border-radius: 12px; color: #000; cursor: pointer;
            display: flex; align-items: center; justify-content: center; transition: 0.3s;
        }
        .camera-btn:hover { transform: scale(1.1); }
        .sidebar h3 { font-weight: 800; color: var(--primary-yellow); margin-top: 15px; }
        .stats-box { display: flex; gap: 15px; margin-top: 30px; }
        .stat-item {
            flex: 1; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px; border-radius: 15px;
        }
        .form-section { flex: 2; min-width: 320px; padding: 40px; }
        .form-title { border-left: 5px solid var(--primary-yellow); padding-left: 15px; font-weight: 800; margin-bottom: 30px; }
        .label-custom { color: var(--primary-yellow); font-weight: 600; font-size: 0.85rem; margin-bottom: 7px; display: block; }
        .input-group-custom {
            background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px; padding: 12px 15px; display: flex; align-items: center; margin-bottom: 20px;
        }
        .input-group-custom i { color: var(--primary-yellow); margin-right: 15px; width: 20px; text-align: center; }
        .input-group-custom input, .input-group-custom textarea {
            background: transparent; border: none; color: #fff; width: 100%; outline: none;
        }
        .btn-save {
            background: var(--primary-yellow); color: #000; font-weight: 800;
            border-radius: 12px; padding: 12px 35px; border: none; float: right; transition: 0.3s;
        }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3); }
        @media (max-width: 768px) { .glass-container { flex-direction: column; } .sidebar { border-right: none; border-bottom: 1px solid rgba(255, 255, 255, 0.1); } }
    </style>
</head>
<body>

<form action="update_logic.php" method="POST" enctype="multipart/form-data" class="w-100 d-flex justify-content-center">
    <div class="glass-container">
        
        <div class="sidebar">
            <div class="profile-img-container">
                <img src="<?php echo $user_image; ?>" class="profile-img" id="preview" alt="User Profile">
                
                <label for="profile_upload" class="camera-btn">
                    <i class="fas fa-camera"></i>
                    <input type="file" id="profile_upload" name="profile_image" hidden onchange="previewImage(event)">
                </label>
            </div>
            <h3><?php echo htmlspecialchars($user_name); ?></h3>
            <p class="text-white-50">Nature Lover & Traveler</p>

            <div class="stats-box">
                <div class="stat-item">
                    <h4><?php echo $trips_count; ?></h4>
                    <span>Trips</span>
                </div>
                <div class="stat-item">
                    <h4><?php echo $reviews_count; ?></h4>
                    <span>Reviews</span>
                </div>
            </div>
        </div>

        <div class="form-section">
       

            <div class="row">
                <div class="col-md-6">
                    <label class="label-custom">Full Name</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user-circle"></i>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user_name); ?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="label-custom">Email (Locked)</label>
                    <div class="input-group-custom" style="opacity: 0.6;">
                        <i class="fas fa-envelope"></i>
                        <input type="email" value="<?php echo htmlspecialchars($user_email); ?>" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="label-custom">Phone Number</label>
                    <div class="input-group-custom">
                        <i class="fas fa-mobile-alt"></i>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user_phone); ?>">
                    </div>
                </div>
          
        </div>

    </div>
</form>

<script>
    // Frontend par image select karte hi turant preview dikhane ke liye script
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('preview');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

</body>
</html>