<?php
session_start();
include('admin/db.php'); // सुनिश्चित करें कि डेटाबेस पाथ सही है
include "header.php"; 

$message = "";
$error = "";
$show_form = true;

// 1. URL से टोकन (Token) प्राप्त करना और उसकी जांच करना
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    
    // डेटाबेस में चेक करें कि यह टोकन मौजूद है या नहीं
    $query = "SELECT * FROM users WHERE reset_token='$token' AND reset_token IS NOT NULL AND reset_token != ''";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        $error = "अमान्य या पुराना टोकन। कृपया फिर से 'Forgot Password' लिंक जनरेट करें।";
        $show_form = false;
    }
} else {
    // अगर बिना टोकन के पेज खोला जाए तो लॉगिन पर भेज दें
    header("Location: user_login.php");
    exit();
}

// 2. जब यूजर "Update Password" बटन पर क्लिक करे
if (isset($_POST['update_password'])) {
    $new_pass = mysqli_real_escape_string($conn, $_POST['password']);
    $conf_pass = mysqli_real_escape_string($conn, $_POST['conf_password']);

    if (empty($new_pass) || empty($conf_pass)) {
        $error = "कृपया दोनों फ़ील्ड भरें।";
    } elseif ($new_pass !== $conf_pass) {
        $error = "पासवर्ड मैच नहीं हो रहे हैं! कृपया दोबारा जाँचें।";
    } elseif (strlen($new_pass) < 6) {
        $error = "सुरक्षा के लिए पासवर्ड कम से कम 6 अंकों का होना चाहिए।";
    } else {
        // --- MD5 एन्क्रिप्शन का उपयोग ---
        $md5_password = md5($new_pass);
        
        // पासवर्ड अपडेट करें और टोकन को NULL कर दें ताकि दोबारा इस्तेमाल न हो सके
        $update_query = "UPDATE users SET password='$md5_password', reset_token=NULL WHERE reset_token='$token'";
        
        if (mysqli_query($conn, $update_query)) {
            $message = "सफलता! आपका पासवर्ड अपडेट कर दिया गया है।";
            $show_form = false; // सफलता के बाद फॉर्म छुपा दें
        } else {
            $error = "डेटाबेस अपडेट करने में तकनीकी समस्या आई।";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Password | Tour & Travels</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { 
            margin: 0; 
            padding: 0;
            background: linear-gradient(to bottom, #1a1a2e, #16213e); 
            font-family: 'Montserrat', sans-serif; 
            color: #fff; 
        }
        .reset-section { 
            padding: 100px 20px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 70vh; 
        }
        .reset-card { 
            background: rgba(0, 0, 0, 0.85); 
            padding: 40px; 
            border-radius: 30px; 
            max-width: 450px; 
            width: 100%; 
            text-align: center; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.5); 
            border: 1px solid rgba(255, 193, 7, 0.1);
        }
        .reset-card h2 { 
            color: #ffc107; 
            font-size: 2.2rem; 
            margin-bottom: 10px; 
        }
        .reset-card p {
            font-size: 0.9rem;
            margin-bottom: 25px;
            color: #ccc;
        }
        .input-box { 
            width: 100%; 
            padding: 15px; 
            margin: 10px 0; 
            background: rgba(255,255,255,0.05); 
            border: 1px solid #444; 
            border-radius: 30px; 
            color: #fff; 
            text-align: center; 
            outline: none; 
            box-sizing: border-box; 
            font-size: 1rem;
        }
        .input-box:focus { 
            border-color: #ffc107; 
            background: rgba(255,255,255,0.1);
        }
        .reset-btn { 
            background: #ffc107; 
            color: #000; 
            border: none; 
            padding: 15px; 
            border-radius: 30px; 
            font-weight: bold; 
            cursor: pointer; 
            width: 100%; 
            margin-top: 15px; 
            transition: 0.3s; 
            font-size: 1rem;
            text-transform: uppercase;
        }
        .reset-btn:hover { 
            background: #fff; 
            transform: translateY(-2px);
        }
        .alert { 
            padding: 15px; 
            border-radius: 15px; 
            margin-bottom: 20px; 
            font-size: 14px; 
            line-height: 1.5;
        }
        .alert-success { 
            background: rgba(40, 167, 69, 0.2); 
            border: 1px solid #28a745; 
            color: #2fb344; 
        }
        .alert-error { 
            background: rgba(220, 53, 69, 0.2); 
            border: 1px solid #dc3545; 
            color: #ff5c6c; 
        }
        .login-link {
            display: inline-block;
            margin-top: 20px;
            color: #ffc107;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="reset-section">
    <div class="reset-card animate__animated animate__fadeInUp">
        <h2>New Password</h2>
        
        <?php if($message): ?>
            <div class="alert alert-success">
                <strong>सफलता!</strong><br><?php echo $message; ?>
            </div>
            <a href="user_login.php" class="reset-btn" style="text-decoration:none; display:block;">लॉगिन करें</a>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="alert alert-error">
                <strong>त्रुटि!</strong><br><?php echo $error; ?>
            </div>
            <?php if(!$show_form): ?>
                <a href="forgot_password.php" class="login-link">नया लिंक प्राप्त करें</a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($show_form): ?>
        <p>कृपया अपना नया पासवर्ड दर्ज करें और उसे कन्फर्म करें।</p>
        <form method="POST" action="">
            <input type="password" name="password" class="input-box" placeholder="New Password" required minlength="6">
            <input type="password" name="conf_password" class="input-box" placeholder="Confirm New Password" required minlength="6">
            <button type="submit" name="update_password" class="reset-btn">Update Password</button>
        </form>
        <?php endif; ?>

        <br>
        <a href="user_login.php" class="login-link">← Back to Login</a>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>