<?php
session_start();
include('admin/db.php'); 
include "header.php"; 
require 'admin/mail_config.php'; // आपकी मेल कॉन्फ़िगरेशन फ़ाइल को यहाँ शामिल करें

$message = "";
$error = "";

if (isset($_POST['reset_request'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // 1. जाँचना कि ईमेल डेटाबेस में है या नहीं
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // 2. एक सुरक्षित टोकन बनाना
        $token = bin2hex(random_bytes(32)); 
        
        // 3. डेटाबेस में टोकन सेव करना
        $update_query = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        
        if(mysqli_query($conn, $update_query)) {
            
            // --- ईमेल का कंटेंट तैयार करना ---
            $subject = 'Password Reset Request - Tour & Travels';
            $reset_link = "https://cruisingly-unhelping-maire.ngrok-free.dev/tour_travals/reset_new_password.php?token=" . $token;
            
            $mail_body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px;'>
                    <h2 style='color: #ffc107; text-align: center;'>Reset Your Password</h2>
                    <p>नमस्ते,</p>
                    <p>हमें आपके अकाउंट के लिए पासवर्ड रिसेट का अनुरोध प्राप्त हुआ है। अपना पासवर्ड बदलने के लिए नीचे दिए गए बटन पर क्लिक करें:</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='$reset_link' style='background:#ffc107; color:#000; padding:12px 25px; text-decoration:none; border-radius:30px; font-weight:bold; display: inline-block;'>Reset Password</a>
                    </div>
                    <p>यह लिंक केवल कुछ समय के लिए मान्य है। यदि आपने यह अनुरोध नहीं किया है, तो कृपया इस ईमेल को अनदेखा करें।</p>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <p style='font-size: 12px; color: #888;'>Tour & Travels Team</p>
                </div>";

            // --- अपने function को कॉल करना ---
            $mailStatus = sendMail($email, $subject, $mail_body);

            if ($mailStatus === true) {
                $message = "सफलता! रिसेट लिंक आपके ईमेल पर भेज दिया गया है।";
            } else {
                $error = "ईमेल भेजने में विफल। एरर: " . $mailStatus;
            }
            
        } else {
            $error = "डेटाबेस अपडेट करने में त्रुटि आई।";
        }
    } else {
        $error = "यह ईमेल हमारे रिकॉर्ड में नहीं मिला।";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Tour & Travels</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body {
            margin: 0; padding: 0;
            background: linear-gradient(to bottom, #1a1a2e, #16213e); 
            font-family: 'Montserrat', sans-serif;
            color: #fff;
        }
        .reset-section {
            padding: 100px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
        }
        .reset-card {
            background: rgba(0, 0, 0, 0.85); 
            padding: 50px;
            border-radius: 30px;
            max-width: 450px;
            width: 100%;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }
        .reset-card h2 {
            color: #ffc107; 
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .reset-card p {
            color: #ffffff; 
            font-size: 1rem;
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .input-box {
            width: 100%;
            padding: 15px;
            margin: 10px 0 20px 0;
            background: transparent;
            border: 1px solid #444;
            border-radius: 30px;
            color: #fff;
            text-align: center;
            font-size: 1rem;
            box-sizing: border-box;
            outline: none;
        }
        .input-box:focus { border-color: #ffc107; }
        .reset-btn {
            background: #ffc107;
            color: #000;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        .reset-btn:hover { background: #fff; }
        .back-link {
            display: block;
            margin-top: 25px;
            color: #ffc107;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .alert { padding: 12px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: rgba(0,255,0,0.15); border: 1px solid #28a745; color: #28a745; }
        .alert-error { background: rgba(255,0,0,0.15); border: 1px solid #dc3545; color: #dc3545; }
    </style>
</head>
<body>

<div class="reset-section">
    <div class="reset-card animate__animated animate__zoomIn">
        <h2>Reset Password</h2>
        <p>Enter your email to receive a reset link.</p>

        <?php if($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" class="input-box" placeholder="Your Registered Email" required>
            <button type="submit" name="reset_request" class="reset-btn">Send Reset Link</button>
        </form>

        <a href="user_login.php" class="back-link">← Back to Login</a>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>