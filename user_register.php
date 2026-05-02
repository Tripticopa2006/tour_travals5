<?php
include('admin/db.php');

$error = ""; 

if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $hashed_password = md5($password); 

    // Final security check (Server-side)
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    
    if(mysqli_num_rows($check_email) > 0){
        $error = "Email already exists!";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO users (full_name, email, password, phone) VALUES ('$name', '$email', '$hashed_password', '$phone')");
        
        if($insert){
            header("Location: user_login.php?msg=registered");
            exit();
        } else {
            $error = "Registration failed, try again.";
        }
    }
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌍 Tour & Travals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&display=swap" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                        url('https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-box {
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 40px;
            border-radius: 30px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        /* H2 Heading White Style */
        .register-box h2 {
            color: #ffffff !important; /* Forcefully white */
            font-weight: 800; 
            letter-spacing: 3px;
            margin-bottom: 5px;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            width: 100%;
            padding: 12px 20px;
            border-radius: 50px;
            outline: none;
            font-size: 15px;
            margin-bottom: 20px;
            transition: 0.3s;
        }

        .input-field:focus { border-color: #ffc107; background: rgba(255, 255, 255, 0.15); }

        #email_status {
            display: block;
            font-size: 13px;
            margin-top: -15px;
            margin-bottom: 15px;
            text-align: left;
            padding-left: 15px;
        }
         
        .register-btn {
            background: #ffc107;
            color: #000;
            width: 100%;
            padding: 12px;
            border-radius: 50px;
            border: none;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .register-btn:hover:not(:disabled) {
            background: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
        }

        .register-btn:disabled {
            background: #555;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .links { margin-top: 25px; font-size: 14px; color: rgba(255,255,255,0.7); }
        .links a { color: #ffc107; text-decoration: none; font-weight: 700; }
        .home-link { display: inline-block; margin-top: 20px; color: #fff; opacity: 0.5; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="register-box animate__animated animate__zoomIn">
        
        <div class="mb-4">
            <h2>REGISTER</h2>
            <div style="height: 3px; width: 50px; background: #ffc107; margin: 10px auto;"></div>
            <p style="color: #ffc107; font-size: 14px; margin-top: 10px;">Start your journey with us</p>
        </div>

        <?php if(!empty($error)): ?>
            <p class="animate__animated animate__shakeX" style="color: #f87171; font-size: 13px; background: rgba(248,113,113,0.1); padding: 10px; border-radius: 10px;">
                ⚠️ <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <form method="POST" id="regForm">
            <input type="text" name="name" class="input-field" placeholder="Full Name" required>
            
            <input type="email" name="email" id="email" class="input-field" placeholder="Email Address" required>
            <div id="email_status"></div>

            <input type="text" name="phone" class="input-field" placeholder="Phone Number" required>
            <input type="password" name="password" class="input-field" placeholder="Create Password" required>
            
            <button name="register" id="submit_btn" class="register-btn" type="submit">Create Account</button>
        </form>
        
        <div class="links">
            Already a member? <a href="user_login.php">Login Now</a>
        </div>
        <a href="index.php" class="home-link">← Back to Home</a>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#email').on('blur', function() {
        var email = $(this).val();
        var email_status = $('#email_status');
        var btn = $('#submit_btn');

        if(email == '') {
            email_status.html('');
            return;
        }

        // Loading message
        email_status.html('<span style="color: #bbb;">Checking...</span>');

        $.ajax({
            url: 'check_email.php',
            type: 'POST',
            data: { email: email },
            success: function(response) {
                if(response == 'exists') {
                    email_status.html('<span style="color: #f87171;">⚠️ This email is already registered!</span>');
                    btn.prop('disabled', true); 
                } else {
                    email_status.html('<span style="color: #4ade80;">✅ Email is available.</span>');
                    btn.prop('disabled', false); 
                }
            }
        });
    });
});
</script>

<?php include "footer.php"; ?>
</body>
</html>