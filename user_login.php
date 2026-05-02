<?php
session_start();
include('admin/db.php'); // Database connection

// --- REDIRECTION LOGIC (Header se pehle hona chahiye) ---

// CASE 1: Agar URL mein 'id' milta hai (Direct Ticket view)
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $booking_id = $_GET['id'];
    header("Location: ticket.php?id=" . $booking_id);
    exit();
}

// CASE 2: Agar user pehle se login hai
if (isset($_SESSION['user_id'])) {
    if (isset($_GET['package_id']) && !empty($_GET['package_id'])) {
        header("Location: booking_process.php?id=" . $_GET['package_id']);
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

// --- LOGIN LOGIC ---
$error = ""; 
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; 
    
    // Password hashing (MD5 as per your setup)
    $hashed_password = md5($password); 

    $query = "SELECT * FROM users WHERE email='$email' AND password='$hashed_password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Session Variables Set Karna
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];

        // Redirect after successful login
        if (isset($_GET['package_id']) && !empty($_GET['package_id'])) {
            header("Location: booking_process.php?id=" . $_GET['package_id']);
        } else {
            header("Location: user_dashboard.php");
        }
        exit();
        
    } else {
        $error = "Invalid Email or Password. Please try again.";
    }
}

include "header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌍 Tour & Travals - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-box {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 25px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .login-box h2 {
            font-weight: 800;
            letter-spacing: 2px;
            margin-bottom: 5px;
            color: #ffc107;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            width: 100%;
            padding: 12px 20px;
            border-radius: 30px;
            margin-bottom: 20px;
            outline: none;
            transition: 0.3s;
            text-align: center;
            box-sizing: border-box;
        }

        .input-field:focus {
            border-color: #ffc107;
            background: rgba(255, 255, 255, 0.1);
        }

        .login-btn {
            background: #ffc107;
            color: #000;
            width: 100%;
            padding: 12px;
            border-radius: 30px;
            border: none;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.4s;
            margin-bottom: 15px;
        }

        .login-btn:hover {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 193, 7, 0.4);
        }

        .forgot-pass {
            display: block;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .forgot-pass:hover {
            color: #ffc107;
        }

        .error-alert {
            background: rgba(248, 113, 113, 0.2);
            border: 1px solid #f87171;
            color: #f87171;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .footer-links {
            margin-top: 25px;
            font-size: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .footer-links a {
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box animate__animated animate__zoomIn">
        <h2>LOGIN</h2>
        <p style="font-size: 13px; color: rgba(255,255,255,0.6); margin-bottom: 30px;">
            <?php echo (isset($_GET['package_id']) && !empty($_GET['package_id'])) ? "Login to complete your booking" : "Explore the world with us"; ?>
        </p>

        <?php if(!empty($error)): ?>
            <div class="error-alert animate__animated animate__shakeX">
                ⚠️ <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . (isset($_GET['package_id']) ? '?package_id='.$_GET['package_id'] : '')); ?>">
            <input type="email" name="email" class="input-field" placeholder="Email Address" required>
            <input type="password" name="password" class="input-field" placeholder="Password" required>
            
            <button name="login" class="login-btn" type="submit">Sign In</button>
            
            <a href="forgot_password.php" class="forgot-pass">Forgot Password?</a>
        </form>

        <div class="footer-links">
            Don't have an account? 
            <a href="user_register.php<?php echo (isset($_GET['package_id']) && !empty($_GET['package_id'])) ? '?package_id='.$_GET['package_id'] : ''; ?>">
                Register Now
            </a>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>