<?php
session_start();
include "admin/db.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$total_users = 0;

// --- 1. Update Logic ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);

    $image_query = "";
    if (!empty($_FILES['profile_pic']['name'])) {
        $img_name = time() . '_' . $_FILES['profile_pic']['name'];
        $target = "uploads/profiles/" . $img_name;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target)) {
            $image_query = ", profile_pic = '$img_name'";
        }
    }

    $sql = "UPDATE users SET full_name='$full_name', phone='$phone' $image_query WHERE id='$user_id'";
    
    if (mysqli_query($conn, $sql)) { 
        $message = "success"; 
        
        // --- 2. Count Total Users (Kitne logo ne profile banayi hai) ---
        $count_query = "SELECT COUNT(*) as total FROM users";
        $count_result = mysqli_query($conn, $count_query);
        $count_data = mysqli_fetch_assoc($count_result);
        $total_users = $count_data['total'];
    }
}

// --- 3. Fetch User Details for View ---
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$user_img = !empty($user['profile_pic']) ? "uploads/profiles/" . $user['profile_pic'] : "https://cdn-icons-png.flaticon.com/512/3135/3135715.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Profile | Tour & Travels</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    
    <style>
        :root { --accent-yellow: #ffc107; --input-bg: rgba(0, 0, 0, 0.6); --glass-border: rgba(255, 193, 7, 0.3); }

        body { 
            background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1470770841072-f978cf4d019e?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-position: center; background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif; color: #ffffff; min-height: 100vh;
        }

        .main-profile-card { background: rgba(255, 255, 255, 0.07); backdrop-filter: blur(25px); border: 1px solid var(--glass-border); border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6); margin-top: 20px; }
        .profile-sidebar { background: rgba(0, 0, 0, 0.4); padding: 50px 20px; border-right: 1px solid var(--glass-border); text-align: center; }
        .profile-pic-preview { width: 140px; height: 140px; border-radius: 25px; object-fit: cover; border: 3px solid var(--accent-yellow); }
        .camera-icon { background: var(--accent-yellow); color: #000; width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; position: absolute; bottom: -5px; right: -5px; }

        .form-section { padding: 45px; }
        .input-group { background: var(--input-bg); border: 1.5px solid var(--glass-border); border-radius: 14px; }
        .input-group-text i { color: var(--accent-yellow) !important; }
        .form-control { background: transparent !important; border: none !important; color: #ffffff !important; padding: 14px 12px; }
        .form-label { color: var(--accent-yellow) !important; font-weight: 700; }

        .btn-save { background: var(--accent-yellow); color: #000 !important; border: none; padding: 16px 50px; border-radius: 14px; font-weight: 800; text-transform: uppercase; transition: 0.4s; width: 100%; }
        .btn-save:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4); }

        /* Footer */
        .custom-footer { background: linear-gradient(90deg, #4b2c61 0%, #a13670 100%); padding: 40px 0 20px; margin-top: 60px; }
        .footer-link { color: rgba(255,255,255,0.8); text-decoration: none; display: block; margin-bottom: 8px; }
        .social-icon { width: 35px; height: 35px; background: rgba(255,255,255,0.2); display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: white; margin-right: 8px; }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="container py-5 mt-5">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="user_dashboard.php" class="text-white text-decoration-none bg-dark bg-opacity-50 p-2 rounded px-3 border border-secondary">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
        <span class="badge bg-warning text-dark p-2">Logged in as: <?php echo htmlspecialchars($user['full_name']); ?></span>
    </div>

    <div class="main-profile-card">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-0">
                <div class="col-lg-4 profile-sidebar">
                    <div class="position-relative d-inline-block mb-4">
                        <img src="<?php echo $user_img; ?>" id="preview" class="profile-pic-preview">
                        <label for="profile_pic" class="camera-icon"><i class="bi bi-camera-fill"></i></label>
                        <input type="file" name="profile_pic" id="profile_pic" hidden onchange="previewImage(this)" accept="image/*">
                    </div>
                    <h3 class="mb-1 text-warning"><?php echo htmlspecialchars($user['full_name']); ?></h3>
                    <p class="mb-4 text-white-50">Member Since: <?php echo date('M Y', strtotime($user['created_at'] ?? 'now')); ?></p>

                    <div class="row g-2 px-3">
                        <div class="col-6"><div class="bg-dark p-3 rounded-4 border border-secondary"><h4>12</h4><small>Trips</small></div></div>
                        <div class="col-6"><div class="bg-dark p-3 rounded-4 border border-secondary"><h4>5</h4><small>Reviews</small></div></div>
                    </div>
                </div>

                <div class="col-lg-8 form-section">
                    <h2 class="fw-bold mb-4"><i class="bi bi-pencil-square text-warning me-2"></i>Edit Profile</h2>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-person"></i></span>
                                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email (Not Editable)</label>
                            <div class="input-group opacity-75">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-phone"></i></span>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Enter Phone">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-save">
                            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Save & View Community Stats
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<footer class="custom-footer">
    <div class="container text-white">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5>🌍 Tour & Travels</h5>
                <p class="small opacity-75">Your journey, our priority. Experience the world with us.</p>
            </div>
            <div class="col-lg-4 mb-4">
                <h5>Quick Links</h5>
                <a href="#" class="footer-link">Home</a>
                <a href="#" class="footer-link">Packages</a>
            </div>
            <div class="col-lg-4 mb-4">
                <h5>Follow Us</h5>
                <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
        <div class="text-center mt-4 border-top pt-3 opacity-50">
            &copy; 2026 Tour & Travels
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById('preview').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // --- Success Popup with User Count ---
    <?php if($message == "success") { ?>
        Swal.fire({
            title: 'Profile Updated Successfully!',
            html: `
                <div style="margin-top:15px;">
                    <p>Aapki profile update ho gayi hai.</p>
                    <hr style="border-color: #444">
                    <h3 style="color: #ffc107;">Community Stats</h3>
                    <p style="font-size: 1.2rem;">Ab tak <strong><?php echo $total_users; ?></strong> logo ne hamare saath profile banayi hai!</p>
                </div>
            `,
            icon: 'success',
            background: '#1a1a1a',
            color: '#fff',
            confirmButtonColor: '#ffc107',
            confirmButtonText: '<span style="color:#000">Great!</span>'
        });
    <?php } ?>
</script>

</body>
</html>